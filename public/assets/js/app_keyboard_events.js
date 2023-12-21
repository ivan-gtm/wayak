function initKeyboardEvents() {
    if (DEBUG) {
        console.log("MIGRATED:: initKeyboardEvents()");
    }

    $("#canvaspages").keyup(function (e) {
        if (handleInputNode(e)) {
            return;
        }
        processKeyStringUpdate(e, 'keyup');
        handleKeyUpEvents(e);
    });

    $("#canvaspages").keydown(function (e) {
        if (handleInputNode(e)) {
            return true; // Allow standard input behavior
        }
        if (!handleActiveObject(e)) {
            return; // Skip further processing for certain active object conditions
        }
        processKeyStringUpdate(e, 'keydown');
        handleKeyDownEvents(e);
        processKeyCodeActions(e);
    });
}


function handleKeyUpEvents() {
    $("#canvaspages").keyup(function (e) {
        if (DEBUG) {
            console.log("MIGRATED:: keyup", e.key, e.keyCode);
        }

        const remstring = getRemovalStringFromKeyCode(e.keyCode);
        if (remstring) {
            updateKeyString(remstring);
        }
    });
}

function getRemovalStringFromKeyCode(keyCode) {
    switch (keyCode) {
        case 17: return "ctrl ";
        case 67: return " c";
        case 88: return " x";
        case 86: return " v";
        case 90: return " z";
        default: return null;
    }
}

function updateKeyString(remstring) {
    if (DEBUG) {
        console.log("MIGRATED:: keystring before removal: ", keystring);
    }

    if (keystring.includes(remstring)) {
        keystring = keystring.replace(remstring, "");
    }

    if (DEBUG) {
        console.log("MIGRATED:: keystring after removal: ", keystring);
    }
}

function handleKeyDownEvents() {
    $("#canvaspages").keydown(function (e) {
        if (DEBUG) {
            console.log("MIGRATED:: keydown", "keystring: ", keystring);
        }

        if (isNonControlKeyCode(e.keyCode) && isTargetInput(e.target)) {
            return false;
        }

        const activeobject = canvas.getActiveObject();
        if (isInvalidActiveObject(activeobject)) {
            return;
        }

        switch (e.keyCode) {
            case 8: // Backspace
                e.preventDefault();
                deleteItem();
                break;
            case 17: // Ctrl
                e.preventDefault();
                keystring = "ctrl";
                break;
            case 91: // Command
                e.preventDefault();
                keystring = "cmd";
                break;
            case 173: // Minus (Firefox)
            case 109: // Numpad Substract
                e.preventDefault();
                if (e.ctrlKey || e.metaKey) {
                    objManip("zoomBy-z", -10);
                }
                break;
            case 61: // Equal (Firefox)
            case 107: // Numpad Add
                e.preventDefault();
                if (e.ctrlKey || e.metaKey) {
                    objManip("zoomBy-z", 10);
                }
                break;
            case 37: // Left Arrow
                e.preventDefault();
                handleArrowKey(activeobject, e, "left");
                break;
            case 39: // Right Arrow
                e.preventDefault();
                handleArrowKey(activeobject, e, "right");
                break;
            case 38: // Up Arrow
                e.preventDefault();
                handleArrowKey(activeobject, e, "up");
                break;
            case 40: // Down Arrow
                e.preventDefault();
                handleArrowKey(activeobject, e, "down");
                break;
            case 67: // C key
                e.preventDefault();
                if (keystring === "ctrl c" || keystring === "cmd c") {
                    copyobjs();
                }
                break;
            case 88: // X key
                e.preventDefault();
                if (keystring === "ctrl x" || keystring === "cmd x") {
                    cutobjs();
                }
                break;
            case 86: // V key
                e.preventDefault();
                if (keystring === "ctrl v" || keystring === "cmd v") {
                    pasteobjs();
                }
                break;
            case 90: // Z key
                e.preventDefault();
                keystring += " z";
                if (keystring === "ctrl z" || keystring === "cmd z") {
                    history_undo();
                }
                break;
            case 46: // Delete key
                e.preventDefault();
                deleteItem();
                break;
        }

        canvas.renderAll();
        return true;
    });
}

function isNonControlKeyCode(keyCode) {
    return keyCode !== 90 && keyCode !== 17 && keyCode !== 91;
}

function isTargetInput(target) {
    return target && target.nodeName === "INPUT";
}

function isInvalidActiveObject(activeobject) {
    if (!activeobject && !activeObjectCopy) {
        return true;
    }

    if (activeobject && (activeobject.isEditing || (activeobject.locked && activeobject.locked === true))) {
        return true;
    }

    return false;
}

function processKeyStringUpdate(e, eventType) {
    if (DEBUG) {
        console.log(eventType, e.key, e.keyCode);
    }

    const keyAction = getKeyActionFromKeyCode(e.keyCode);
    if (eventType === 'keydown') {
        updateKeyStringForKeyDown(keyAction);
    } else if (eventType === 'keyup') {
        updateKeyStringForKeyUp(keyAction);
    }
}

function getKeyActionFromKeyCode(keyCode) {
    switch (keyCode) {
        case 17: return "ctrl";
        case 67: return "c";
        case 88: return "x";
        case 86: return "v";
        case 90: return "z";
        default: return "";
    }
}

function updateKeyStringForKeyDown(keyAction) {
    if (keyAction) {
        keystring += (keystring ? " " : "") + keyAction;
    }
}

function updateKeyStringForKeyUp(keyAction) {
    const remString = keyAction ? " " + keyAction : "";
    if (keystring.includes(remString)) {
        keystring = keystring.replace(remString, "");
    }
}

function handleInputNode(event) {
    if (event.target && event.target.nodeName === "INPUT") {
        // Return true to allow standard input behavior
        return true;
    }

    // Return false if the target is not an input, indicating that custom handling is needed
    return false;
}

function handleActiveObject(event) {
    const activeObject = canvas.getActiveObject();

    // Check if there's no active object and no copied object
    if (!activeObject && !activeObjectCopy) {
        return false;
    }

    // Return false if the active object is in editing mode
    if (activeObject && activeObject.isEditing) {
        return false;
    }

    // Return false if the active object is locked
    if (activeObject && activeObject.locked) {
        return false;
    }

    // Proceed with custom handling for the active object
    return true;
}

function processKeyCodeActions(e) {
    const activeObject = canvas.getActiveObject();

    switch (e.keyCode) {
        case 8: // Backspace
            e.preventDefault();
            deleteItem();
            break;
        case 17: // Ctrl
            e.preventDefault();
            keystring = "ctrl";
            break;
        case 91: // Command
            e.preventDefault();
            keystring = "cmd";
            break;
        case 173: // Minus (Firefox)
        case 109: // Numpad Subtract
            e.preventDefault();
            if (!e.ctrlKey && !e.metaKey) {
                objManip("zoomBy-z", -10);
            }
            break;
        case 61: // Equal (Firefox)
        case 107: // Numpad Add
            e.preventDefault();
            if (!e.ctrlKey && !e.metaKey) {
                objManip("zoomBy-z", 10);
            }
            break;
        case 37: // Left Arrow
        case 39: // Right Arrow
        case 38: // Up Arrow
        case 40: // Down Arrow
            handleArrowKey(e, activeObject);
            break;
        case 67: // C key
        case 88: // X key
        case 86: // V key
            handleClipboardAction(e, activeObject);
            break;
        case 90: // Z key
            handleUndoAction(e);
            break;
        case 46: // Delete key
            e.preventDefault();
            deleteItem();
            break;
    }
}

function handleArrowKey(e, activeObject) {
    if ((e.keyCode === 37 || e.keyCode === 39) && activeObject.lockMovementX) {
        e.preventDefault();
        return;
    }
    if ((e.keyCode === 38 || e.keyCode === 40) && activeObject.lockMovementY) {
        e.preventDefault();
        return;
    }

    const direction = getArrowKeyDirection(e.keyCode);
    const manipulationType = e.shiftKey ? 'zoomBy' : (e.ctrlKey || e.metaKey) ? 'angle' : 'move';
    const manipulationValue = getArrowKeyValue(e.keyCode, e.shiftKey);

    objManip(`${manipulationType}-${direction}`, manipulationValue);
    e.preventDefault();
}

function handleClipboardAction(e, activeObject) {
    if (!activeObject) {
        return;
    }

    switch (e.keyCode) {
        case 67: // C key
            if (keystring === "ctrl c" || keystring === "cmd c") {
                copyobjs();
            }
            break;
        case 88: // X key
            if (keystring === "ctrl x" || keystring === "cmd x") {
                cutobjs();
            }
            break;
        case 86: // V key
            if (keystring === "ctrl v" || keystring === "cmd v") {
                pasteobjs();
            }
            break;
    }
    e.preventDefault();
}

function handleUndoAction(e) {
    if (keystring === "ctrl z" || keystring === "cmd z") {
        history_undo();
    }
    e.preventDefault();
}

// Helper functions for direction and value calculation
function getArrowKeyDirection(keyCode) {
    switch (keyCode) {
        case 37: return 'x';
        case 39: return 'x';
        case 38: return 'y';
        case 40: return 'y';
    }
}

function getArrowKeyValue(keyCode, isShift) {
    if (keyCode === 37 || keyCode === 38) { // Left or Up
        return isShift ? -10 : -1;
    } else { // Right or Down
        return isShift ? 10 : 1;
    }
}
