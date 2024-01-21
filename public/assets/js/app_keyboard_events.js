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

function processKeyCodeActions(e) {
    if (DEBUG) {
        console.log("MIGRATED:: keydown", "keystring: ", keystring);
    }

    if (isNonControlKeyCode(e.keyCode) && isTargetInput(e.target)) {
        return false;
    }

    var activeobject = canvas.getActiveObject();
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
        case 48: //CMD+0 // Command with "0" / reset zoom to default
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                setZoom(1);
            }
            break;
        case 91: // Command
            e.preventDefault();
            keystring = "cmd";
            break;
        case 173: // Minus (Firefox)
        case 189: // Numpad Substract (-) on laptop
        case 109: // Numpad Substract
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                objManip("zoomOut", calculateZoomLevel()-0.1);
            }
            break;
        case 61: // Equal (Firefox)
        case 187: // Numpad Substract (+) on laptop
        case 107: // Numpad Add
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                objManip("zoomIn", calculateZoomLevel()+0.1);
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
            if (e.ctrlKey || e.metaKey) {
                copyobjs();
            }
            break;
        case 88: // X key
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                cutobjs();
            }
            break;
        case 86: // V key
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                pasteobjs();
            }
            break;
        case 90: // Z key
            e.preventDefault();
            keystring += " z";
            if (e.ctrlKey || e.metaKey) {
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

function handleArrowKey(activeObject, e) {
    if ((e.keyCode === 37 || e.keyCode === 39) && activeObject.lockMovementX) {
        e.preventDefault();
        return;
    }
    if ((e.keyCode === 38 || e.keyCode === 40) && activeObject.lockMovementY) {
        e.preventDefault();
        return;
    }

    var direction = getArrowKeyDirection(e.keyCode);
    // var manipulationType = e.shiftKey ? 'zoomBy' : (e.ctrlKey || e.metaKey) ? 'angle' : 'move';
    var manipulationValue = getArrowKeyValue(e.keyCode, e.shiftKey);
    
    console.log("objManip(`${manipulationType}-${direction}`, manipulationValue)");
    // console.log("manipulationType"+manipulationType);
    console.log("direction"+direction);
    console.log("manipulationValue"+manipulationValue);

    objManip(direction, manipulationValue);
    e.preventDefault();
}

// Helper functions for direction and value calculation
function getArrowKeyDirection(keyCode) {
    switch (keyCode) {
        case 37: return 'left';
        case 39: return 'left';
        case 38: return 'top';
        case 40: return 'top';
    }
}

function getArrowKeyValue(keyCode, isShift) {
    if (keyCode === 37 || keyCode === 38) { // Left or Up
        return isShift ? -10 : -1;
    } else { // Right or Down
        return isShift ? 10 : 1;
    }
}
