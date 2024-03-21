$(document).ready(function() {
    $("#font-size-dropdown").on("click", "li a", function() {
        var selectedFontSize = parseInt($(this).text(), 10) * 1.3;
        var activeObject = canvas.getActiveObject();
        
        if (!activeObject) return;
        
        updateFontSizeForActiveObject(activeObject, selectedFontSize);
        canvas.renderAll();
        
        // Update the font size display in the input field
        $(this).closest(".input-group").find(".fontinput").val(selectedFontSize);
    });
    
    setupShowMoreOptions();
    setupTextCaseToggle();
    initializeLineHeightToggle();
    initializeLineHeightSlider();
    initializeCharSpacingSlider();
    setupTextTransformationSwitches();
    setupFlipHorizontalSwitch();
    setupFlipVerticalSwitch();
    setupObjectLockToggle();
    initializeShadowGroupClick();
    initializeShadowDropdownToggle();
    initializeBodyClick();
    initializeShadowBlurSlider();
    initializeShadowOffsetSliders();
    initializeShadowColorPicker();
    setupShadowColorChangeEvents();
    $("#addremovestroke").click(handleStrokeToggle);
    initializeColorStrokeSelector();
    setupStrokeWidthDropdown();
    initializeStrokeWidthSlider();
    // initializeOpacitySlider();
    attachNoCloseClickHandler();
    attachCharSpacingClickHandler();
    attachObjectOpacityClickHandler();
    setupDuplicateCanvasClickHandler();
    attachDeleteCanvasHandler();
});

function attachDeleteCanvasHandler() {
    $(".deletecanvas").on("click", function() {
        var id = extractIdFromElementId($(this).attr("id"), "deletecanvas");
        hidePageById(id);
        adjustVisiblePageIcons();
        toggleDeleteButtonBasedOnVisiblePages();
        toggleDownloadJpegMenuItemBasedOnCanvasCount();
        setWorkspace();
        updatePageNumbers();
    });
}

function extractIdFromElementId(elementId, prefix) {
    return elementId.replace(prefix, "");
}

function hidePageById(pageId) {
    $("#page" + pageId).hide();
}

function adjustVisiblePageIcons() {
    $(".page:visible").each(function() {
        adjustIconPos(extractIdFromElementId($(this).attr("id"), "page"));
    });
}

function toggleDeleteButtonBasedOnVisiblePages() {
    if ($(".page:visible").length === 1) {
        $(".deletecanvas").hide();
    } else {
        $(".deletecanvas").show();
    }
}

function toggleDownloadJpegMenuItemBasedOnCanvasCount() {
    if ($(".page:visible").find(".canvascontent").length > 10) {
        $(".download-jpeg-menu-item").hide();
    } else {
        $(".download-jpeg-menu-item").show();
    }
}


function setupDuplicateCanvasClickHandler() {
    $(".duplicatecanvas").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var canvasId = extractCanvasIdFromDuplicateButtonId(this.id);
            canvas.discardActiveObject();
            addNewCanvasPage(true, canvasId);
            setWorkspace();
        }
    });
}

function extractCanvasIdFromDuplicateButtonId(buttonId) {
    // Replace "duplicatecanvas" with an empty string to extract the numeric ID
    return buttonId.replace("duplicatecanvas", "");
}

function addNewCanvasPage(duplicateFlag, pageId) {
    logDebug("addNewCanvasPage");

    // Increment the page index and add a new page div to the canvas pages container
    pageindex++;
    var newPageId = 'page' + pageindex;
    $("#canvaspages").append(`<div class='page' id='${newPageId}'></div>`);

    // Add a canvas to the newly created page
    addCanvasToPage(duplicateFlag, pageId);

    // Adjust the workspace layout or settings
    setWorkspace();
}

function logDebug(message) {
    if (DEBUG) { // Ensure DEBUG is a global boolean flag
        console.log(message);
    }
}

function attachObjectOpacityClickHandler() {
    $("#objectopacity").on("click", function() {
        toggleOpacitySlider();
        hideOtherOptionsExceptThis('#objectopacity');
    });
}

function toggleOpacitySlider() {
    // Toggle the visibility of the opacity slider
    $("#opacitySlider").toggle();
}

function hideOtherOptionsExceptThis(exceptionSelector) {
    // Hide all other options that are currently visible except for the one specified
    $("#showmoreoptions ul li a").each(function() {
        if ($(this).css("display") === "block" && !$(this).is(exceptionSelector)) {
            $(this).addClass("temphide");
        }
    });
}

function attachCharSpacingClickHandler() {
    $("#charspacing").on("click", function() {
        toggleCharSpacingSlider();
        hideOtherOptionsExceptThis("#charspacing");
    });
}

function toggleCharSpacingSlider() {
    // Toggle visibility of the character spacing slider
    $("#charspacingSlider").toggle();
}

function attachNoCloseClickHandler() {
    $(".noclose").on("click", preventEventPropagation);
}

function preventEventPropagation(e) {
    if (DEBUG) {
        console.log('Click event on ".noclose" prevented from propagating.');
    }
    e.stopPropagation();
}

var co = $("#changeopacity").slider().on("change", changeOpacity).data("slider");

function changeOpacity() {
    logDebug("ChangeOpacity");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;
    
    var opacityValue = co.getValue();
    applyOpacityToActiveObject(activeObject, opacityValue);
    canvas.renderAll();
}

function applyOpacityToActiveObject(object, opacityValue) {
    if (object.type === "activeSelection" && object._objects) {
        object.forEachObject(function(obj) {
            obj.set("opacity", opacityValue);
        });
    } else {
        object.set("opacity", opacityValue);
    }
}

function initializeStrokeWidthSlider() {
    logDebug("initializeStrokeWidthSlider");
    $("#changestrokewidth").slider({
        slide: changeStrokeWidth,
        stop: finalizeStrokeWidthChange
    });
}

function changeStrokeWidth(event, ui) {
    logDebug("ChangeStrokeWidth");

    s_history = false; // Temporarily disable history tracking
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    updateStrokeWidthForActiveObject(activeObject, ui.value);
    activeObject.setCoords();
    canvas.renderAll();
}

function updateStrokeWidthForActiveObject(object, strokeWidth) {
    if (["path-group", "group"].includes(object.type) && object._objects) {
        object._objects.forEach(function(child) {
            child.set("strokeWidth", strokeWidth);
        });
    } else {
        object.set("strokeWidth", strokeWidth);
    }

    // Center the rectangle if it's the active object type being modified
    if (object.type === "rect") {
        centerRectangle(object);
    }
}

function centerRectangle(rectangle) {
    rectangle.viewportCenter();
    rectangle.set({
        left: (canvas.get("width") / canvas.getZoom() - rectangle.get("width")) / 2,
        top: (canvas.get("height") / canvas.getZoom() - rectangle.get("height")) / 2
    });
}

function finalizeStrokeWidthChange() {
    logDebug('Stroke width adjustment finalized');
    s_history = true; // Re-enable history tracking and save the state
    save_history();
}

function logDebug(message) {
    if (DEBUG) { // Check if debug mode is enabled and log the message
        console.log(message);
    }
}


function setupStrokeWidthDropdown() {
    $("#strokedropdown").on("click", updateStrokeWidthSlider);
}

function updateStrokeWidthSlider() {
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    var objectStrokeWidth = activeObject.get("strokeWidth") || 0; // Default to 0 if undefined
    $("#changestrokewidth").slider("setValue", objectStrokeWidth);
}


function initializeColorStrokeSelector() {
    $("#colorStrokeSelector").spectrum({
        containerClassName: "color-stroke",
        showPaletteOnly: true,
        togglePaletteOnly: true,
        showPalette: true,
        preferredFormat: "hex",
        hideAfterPaletteSelect: true,
        showSelectionPalette: true,
        localStorageKey: localStorageKey, // Assuming this is defined elsewhere
        showInput: true,
        showInitial: true,
        allowEmpty: true,
        showButtons: false,
        maxSelectionSize: 24,
        togglePaletteMoreText: "Show advanced",
        togglePaletteLessText: "Hide advanced",
        change: handleColorChange,
        beforeShow: function() {
            var strokeColor = canvas.getActiveObject() ? canvas.getActiveObject().stroke : "#000";
            $(this).spectrum("set", strokeColor);
        },
        move: updateStrokeColor
    });
}

function handleColorChange(color) {
    logDebug("Stroke color changed: ", color);

    var colorVal = color ? color.toHexString() : "";
    updateLocalStorageForColor(color, colorVal);
    changeStrokeColor(colorVal);
    $("#colorStrokeSelector").css("backgroundColor", colorVal);
}

function updateStrokeColor(color) {
    logDebug("Moving stroke color selector");

    var colorVal = color ? color.toHexString() : "";
    changeStrokeColor(colorVal);
    $("#colorStrokeSelector").css("backgroundColor", colorVal);
}

function updateLocalStorageForColor(color, colorVal) {
    if (!window.localStorage[localStorageKey]) {
        window.localStorage[localStorageKey] = ";";
    }

    var localStore = window.localStorage[localStorageKey];
    if (localStore.indexOf(color) === -1) {
        window.localStorage[localStorageKey] += ";" + colorVal;
    }
}

function logDebug(message, color = '') {
    if (DEBUG) { // Assuming DEBUG is a global flag
        console.log(message, color);
    }
}

function changeStrokeColor(colorVal) {
    // Assuming there's a function to update the stroke color of the active object
    // If it doesn't exist, it should be implemented according to your application's logic
    var activeObject = canvas.getActiveObject();
    if (activeObject && colorVal) {
        activeObject.set({ stroke: colorVal });
        canvas.renderAll();
    }
}

function handleStrokeToggle(e) {
    if (DEBUG) console.log("Toggle Stroke");

    e.preventDefault();
    e.stopPropagation();

    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    if (activeObject.get("stroke")) {
        removeStroke(activeObject);
        $("#strokegroup").hide();
    } else {
        addStroke(activeObject);
        $("#strokegroup").show();
        $("#colorStrokeSelector").css("background-color", "#000000");
    }

    canvas.renderAll();
    save_history();
}

function removeStroke(object) {
    setStrokeProperties(object, "", 1);
}

function addStroke(object) {
    setStrokeProperties(object, "#000000", 1, {
        paintFirst: "stroke",
        strokeLineJoin: "round"
    });
}

function setStrokeProperties(object, color, width, additionalProps = {}) {
    const applyProps = (obj) => {
        obj.set("stroke", color);
        obj.set("strokeWidth", width);
        for (let prop in additionalProps) {
            obj.set(prop, additionalProps[prop]);
        }
    };

    if (object.paths) {
        object.paths.forEach(applyProps);
    }

    if (object._objects) {
        object._objects.forEach(applyProps);
    }

    applyProps(object);
}

function ChangeShadowColor(color) {
    if (DEBUG) {
        console.log("ChangeShadowColor()");
    }

    var activeObject = canvas.getActiveObject();
    if (!activeObject || !activeObject.shadow) return;

    // Convert color to string only once and reuse
    var colorStr = color.toString();
    activeObject.shadow.color = colorStr;
    lastShadowColor = colorStr; // Assuming lastShadowColor is used elsewhere to track state

    canvas.renderAll();
}


function initializeShadowColorPicker() {
    $("#shadowColor").spectrum({
        containerClassName: "color-shadow",
        showPaletteOnly: true,
        togglePaletteOnly: true,
        showPalette: true,
        hideAfterPaletteSelect: false,
        showSelectionPalette: true,
        localStorageKey: localStorageKey, // Assuming localStorageKey is defined elsewhere
        showInput: true,
        showInitial: true,
        preferredFormat: "hex",
        flat: true,
        showButtons: false,
        maxSelectionSize: 24,
        togglePaletteMoreText: "Show advanced",
        togglePaletteLessText: "Hide advanced",
        showAlpha: true,
        move: handleColorMove
    });
}

function handleColorMove(color) {
    logDebugColor(color);
    var colorVal = color ? color : "";
    ChangeShadowColor(colorVal); // Assuming ChangeShadowColor is defined elsewhere
}

function logDebugColor(color) {
    if (DEBUG) {
        console.log("color: ", color);
    }
}

function setupShadowColorChangeEvents() {
    $("#shadowColor").on("dragstop.spectrum", handleDragStop);

    $("#shadowTabs .sp-input").keypress(function(e) {
        if (e.which == 13) { // Enter key pressed
            handleEnterKeyPress($(this).val());
        }
    });
}

function handleDragStop(e, color) {
    if (DEBUG) console.log('Color drag stop event');
    setTimeout(function() {
        updateLocalStorageColor(color);
        $("#shadowColor").spectrum("set", color);
    }, 0);
}

function handleEnterKeyPress(color) {
    updateLocalStorageColor(color);
    $("#shadowColor").spectrum("set", color);
    ChangeShadowColor(color);
}

function updateLocalStorageColor(color) {
    if (!window.localStorage[localStorageKey]) {
        window.localStorage[localStorageKey] = ";";
    }
    var localStore = window.localStorage[localStorageKey];
    if (localStore.search(color) == -1) {
        window.localStorage[localStorageKey] = localStore + ";" + color;
    }
}

$("body").on("click", function(e) {
    if (DEBUG) console.log('$("body").on("click", function(e) {');
    $(".submenu.visible").is(e.target) || 0 !== $(".submenu.visible").has(e.target).length || 0 !== $(".parent").parent().has(e.target).length || $(".sidebar-elements .sub-menu").parent().removeClass("active")
});

// Define a more readable and maintainable configuration object
const spectrumOptions = {
    containerClassName: "color-fill",
    togglePaletteOnly: true,
    showPalette: true,
    preferredFormat: "hex",
    hideAfterPaletteSelect: true,
    showSelectionPalette: true,
    localStorageKey: localStorageKey, // Assuming localStorageKey is defined elsewhere
    showInput: true,
    showInitial: true,
    allowEmpty: true,
    showButtons: false,
    maxSelectionSize: 24,
    togglePaletteMoreText: "Show advanced",
    togglePaletteLessText: "Hide advanced",
    beforeShow: function() {
        $(this).spectrum("set", $(this).css("backgroundColor"));
    },
    show: function(color) {
        $(this).data("previous-color", color.toRgbString().replace(/\s/g, ""));
    }
};

// Utility function to handle repetitive tasks
function updateLocalStorage(color) {
    if (DEBUG) console.log("color: ", color);
    const keyExists = window.localStorage[localStorageKey] !== undefined;
    if (!keyExists) window.localStorage[localStorageKey] = ";";

    let storedColors = window.localStorage[localStorageKey];
    if (!storedColors.includes(color)) {
        window.localStorage[localStorageKey] = `${storedColors};${color}`;
    }
}

function setColorAndGradient(selector, color, isSecondSelector = false) {
    const colorVal = color ? color.toHexString() : (isSecondSelector ? "#000000" : "");
    const activeObject = canvas.getActiveObject();
    const gradientType = getGradientTypeOfObject(activeObject);

    if (activeObject && gradientType !== false) {
        let otherSelector = isSecondSelector ? "#colorSelector" : "#colorSelector2";
        let otherColor = $(otherSelector).spectrum("get");
        otherColor = otherColor ? otherColor.toHexString() : getContrastingColor(colorVal);

        if (DEBUG) console.log(selector, gradientType, colorVal, otherColor);
        switchFillType(gradientType, colorVal, otherColor);
        applyGradient(colorVal, otherColor, gradientType);
    } else {
        changeObjectColor(colorVal);
        $(selector).css("background", colorVal);
    }
}

function getContrastingColor(colorVal) {
    return "#" + ("000000" + ("0xffffff" ^ colorVal.replace("#", "0x")).toString(16)).slice(-6);
}

// Configure spectrumOptions for specific selectors
const colorSelectorOptions = {
    ...spectrumOptions,
    change: function(color) {
        updateLocalStorage(color);
        setColorAndGradient("#colorSelector", color);
    },
    move: function(color) {
        setColorAndGradient("#colorSelector", color);
    }
};

const colorSelector2Options = {
    ...spectrumOptions,
    change: function(color) {
        updateLocalStorage(color);
        setColorAndGradient("#colorSelector2", color, true);
    },
    move: function(color) {
        setColorAndGradient("#colorSelector2", color, true);
    }
};

// Initialize spectrum with the configured options
$("#colorSelector").spectrum(colorSelectorOptions);
$("#colorSelector2").spectrum(colorSelector2Options);



function initializeShadowOffsetSliders() {
    logDebug("initializeShadowOffsetSliders()");
    // Initialize horizontal offset slider and attach slide event handler
    var shadowHOffsetSlider = $("#changeHOffset").slider({
        slide: function(event, ui) {
            updateShadowOffset('horizontal', ui.value);
        }
    }).data("slider");

    // Initialize vertical offset slider and attach slide event handler
    var shadowVOffsetSlider = $("#changeVOffset").slider({
        slide: function(event, ui) {
            updateShadowOffset('vertical', ui.value);
        }
    }).data("slider");
}

function updateShadowOffset(direction, offsetValue) {
    logDebug("updateShadowOffset(d");
    var activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.shadow) {
        // Update the appropriate shadow offset based on direction
        if (direction === 'horizontal') {
            activeObject.shadow.offsetX = offsetValue;
            lastShadowHorizontalOffset = offsetValue; // Remember the last horizontal offset value
        } else if (direction === 'vertical') {
            activeObject.shadow.offsetY = offsetValue;
            lastShadowVerticalOffset = offsetValue; // Remember the last vertical offset value
        }

        // Re-render the canvas to apply the offset change
        canvas.renderAll();
    }
}

function initializeShadowBlurSlider() {
    logDebug("initializeShadowBlurSlider()");
    // Initialize the slider and store a reference for later use
    var shadowBlurSlider = $("#changeBlur").slider({
        slide: function(event, ui) {
            updateShadowBlur(ui.value);
        }
    }).data("slider");

    function updateShadowBlur(blurValue) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.shadow) {
            // Update the shadow blur value of the active object
            activeObject.shadow.blur = blurValue;
            // Remember the last shadow blur value for potential future use
            lastShadowBlur = blurValue;
            // Re-render the canvas to apply the blur change
            canvas.renderAll();
        }
    }
}


function initializeShadowGroupClick() {
    logDebug("initializeShadowGroupClick()");
    $("#shadowGroup").click(function() {
        setDefaultShadowColor();
        updateShadowControlsBasedOnActiveObject();
    });
}

function setDefaultShadowColor() {
    logDebug("setDefaultShadowColor()");
    $("#shadowColor").spectrum("set", "rgba(0, 0, 0, 1)");
}

function updateShadowControlsBasedOnActiveObject() {
    logDebug("updateShadowControlsBasedOnActiveObject()");
    var activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.get("shadow")) {
        const objectShadow = activeObject.get("shadow");
        updateShadowControls(objectShadow);
    } else {
        disableShadowControls();
    }
}

function updateShadowControls(objectShadow) {
    logDebug("updateShadowControls(o");
    if (objectShadow.color) {
        $("#shadowSwitch").prop("checked", true);
        $("#shadowColor").spectrum("enable").spectrum("set", objectShadow.color);
    }
    $("#changeBlur").slider("setValue", objectShadow.blur);
    $("#changeHOffset").slider("setValue", objectShadow.offsetX);
    $("#changeVOffset").slider("setValue", objectShadow.offsetY);
}

function disableShadowControls() {
    logDebug("disableShadowControls()");
    $("#shadowSwitch").prop("checked", false);
    $("#shadowGroup .tab-content").addClass("editor-disabled");
    $("#shadowColor").spectrum("disable");
}

function initializeShadowDropdownToggle() {
    logDebug("initializeShadowDropdownToggle()");
    $("#shadowGroup a.dropdown-toggle").on("click", function() {
        $(this).parent().toggleClass("open");
    });
}

function initializeBodyClick() {
    logDebug("initializeBodyClick()");
    $("body").on("click", function(e) {
        if (!$("#shadowGroup").is(e.target) && $("#shadowGroup").has(e.target).length === 0 && $(".open").has(e.target).length === 0) {
            closeShadowGroup();
        }
    });
}

function closeShadowGroup() {
    logDebug("closeShadowGroup()");
    $("#shadowGroup").removeClass("open");
    $("#shadowTabs .nav-tabs li").first().tab("show");
    $("#color").removeClass("active");
    $("#appearance").addClass("active");
}


function setupObjectLockToggle() {
    logDebug("setupObjectLockToggle()");
    var objectLock = document.getElementById("objectlock");
    if (objectLock) {
        objectLock.addEventListener("click", toggleObjectLock);
    }
}

function toggleObjectLock() {
    logDebug("toggleObjectLock()");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    if (activeObject.type === "activeSelection") {
        // Toggle lock state for each object in the active selection
        activeObject.forEachObject(toggleLockState);
    } else {
        // Toggle lock state for a single active object
        toggleLockState(activeObject);
    }

    canvas.renderAll();
    save_history();
}

function toggleLockState(object) {
    logDebug("toggleLockState(o");
    const isLocked = object.lockMovementY && object.lockMovementX;
    object.set({
        lockMovementY: !isLocked,
        lockMovementX: !isLocked,
        hasControls: !isLocked,
        borderColor: isLocked ? "#4dd7fa" : "#ff0000"
    });
}


function setupFlipVerticalSwitch() {
    logDebug("setupFlipVerticalSwitch()");
    var flipVerticalSwitch = document.getElementById("objectflipvertical");
    if (flipVerticalSwitch) {
        flipVerticalSwitch.addEventListener("click", toggleFlipVertical);
    }
}

function toggleFlipVertical() {
    logDebug("toggleFlipVertical()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        // Simplify the toggle by using a direct assignment
        activeObject.flipY = !activeObject.flipY;
        
        // Render the canvas to reflect changes and save the current state
        canvas.renderAll();
        save_history();
    }
}


function setupFlipHorizontalSwitch() {
    logDebug("setupFlipHorizontalSwitch()");
    var flipHorizontalSwitch = document.getElementById("objectfliphorizontal");
    if (flipHorizontalSwitch) {
        flipHorizontalSwitch.addEventListener("click", toggleFlipHorizontal);
    }
}

function toggleFlipHorizontal() {
    logDebug("toggleFlipHorizontal()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        // Directly toggle the flipX property
        activeObject.flipX = !activeObject.flipX;
        
        // Render the canvas to reflect changes and save the state
        canvas.renderAll();
        save_history();
    }
}


function setupTextTransformationSwitches() {
    logDebug("setupTextTransformationSwitches()");
    setupSwitch("textuppercase", transformTextToUpper);
    setupSwitch("textlowercase", transformTextToLower);
    setupSwitch("textcapitalize", transformTextToCapital);
}

function setupSwitch(switchId, transformFunction) {
    logDebug("setupSwitch(s");
    var switchElement = document.getElementById(switchId);
    if (switchElement) {
        switchElement.onclick = function() {
            applyTextTransformation(transformFunction);
        };
    }
}

function applyTextTransformation(transformFunction) {
    logDebug("applyTextTransformation(t");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    if (activeObject.type === "activeSelection") {
        activeObject.forEachObject(function(obj) {
            if (/text/.test(obj.type)) {
                obj.text = transformFunction(obj.text);
                obj.setCoords(); // Ensure the object's coordinates are updated
            }
        });
    } else if (/text/.test(activeObject.type)) {
        activeObject.text = transformFunction(activeObject.text);
        activeObject.setCoords();
    }
    canvas.renderAll();
}

// Transformation functions
function transformTextToUpper(text) {
    logDebug("transformTextToUpper(t");
    return text.toUpperCase();
}

function transformTextToLower(text) {
    logDebug("transformTextToLower(t");
    return text.toLowerCase();
}

function transformTextToCapital(text) {
    logDebug("transformTextToCapital(t");
    return text.split(" ").map(function(word) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }).join(" ");
}


function initializeCharSpacingSlider() {
    logDebug("initializeCharSpacingSlider()");
    // Set up the slider and its event handlers in a structured manner
    var charSpacingSlider = $("#changecharspacing").slider({
        onSlide: adjustCharSpacing,
        onSlideStop: finalizeCharSpacingAdjustment
    }).data("slider");
}

function adjustCharSpacing() {
    logDebug("adjustCharSpacing()");
    // Temporarily disable history tracking
    s_history = false;
    
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        var charSpacingValue = 100 * charSpacingSlider.getValue(); // Assuming charSpacingSlider is accessible
        setStyle(activeObject, "charSpacing", charSpacingValue);
        activeObject.setCoords();
        canvas.renderAll();
    }
}

function finalizeCharSpacingAdjustment() {
    logDebug("finalizeCharSpacingAdjustment()");
    // Re-enable history tracking and save the state
    s_history = true;
    save_history();
}


function initializeLineHeightSlider() {
    logDebug("initializeLineHeightSlider()");
    $("#changelineheight").slider({
        onSlide: adjustActiveObjectLineHeight,
        onSlideStop: finalizeLineHeightAdjustment
    });
}

function adjustActiveObjectLineHeight() {
    logDebug("adjustActiveObjectLineHeight()");
    // Temporarily disable history tracking to avoid intermediate states
    s_history = false;
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        setStyle(activeObject, "lineHeight", lineHeightSlider.getValue());
        canvas.renderAll();
    }
}

function finalizeLineHeightAdjustment() {
    logDebug("finalizeLineHeightAdjustment()");
    // Re-enable history tracking and save the state
    s_history = true;
    save_history();
}

function setupShowMoreOptions() {
    logDebug("setupShowMoreOptions()");
    $("#showmoreoptions").click(function() {
        resetUIElements();
        updateLockButton();
        updateStrokeButton();
        updateSlidersBasedOnActiveObject();
    });
}

function resetUIElements() {
    logDebug("resetUIElements()");
    // Hide sliders and reset buttons
    $("#showmoreoptions ul li a.temphide").removeClass("temphide").css("display", "block");
    $("#opacitySlider, #lineheightSlider, #charspacingSlider, #borderwhSlider, #textuppercase, #textlowercase, #textcapitalize").hide();
}

function updateLockButton() {
    logDebug("updateLockButton()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        var lockHtml = activeObject._objects && activeObject.type === "activeSelection" ?
            "<i class='fa fa-lock'></i>&nbsp;&nbsp; Toggle Lock" :
            activeObject.lockMovementY ?
            "<i class='fa fa-unlock'></i>&nbsp;&nbsp; Unlock Object" :
            "<i class='fa fa-lock' style='font-size:16px;'></i>&nbsp;&nbsp; Lock Position";
        $("#objectlock").html(lockHtml);
    }
}

function updateStrokeButton() {
    logDebug("updateStrokeButton()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        var strokeHtml = activeObject.get("stroke") ?
            "<i class='fa' style='font-size: 18px;'>▣</i>&nbsp; Remove Stroke" :
            "<i class='fa' style='font-size: 18px;'>▣</i>&nbsp; Add Stroke";
        $("#addremovestroke").html(strokeHtml);
        if (!activeObject.get("stroke")) {
            $("#strokegroup").hide();
        }
    }
}

function updateSlidersBasedOnActiveObject() {
    logDebug("updateSlidersBasedOnActiveObject()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        $("#changeopacity").slider("setValue", activeObject.get("opacity"));
        var objectborderwh = (canvas.get("width") - activeObject.get("width")) / 96 / 2;
        $("#changeborderwh").slider("setValue", objectborderwh);

        if (["textbox", "text", "i-text"].includes(activeObject.type)) {
            $("#changelineheight").slider("setValue", activeObject.get("lineHeight"));
            $("#changecharspacing").slider("setValue", activeObject.charSpacing / 100);
        }
    }
}

// Initialize the border width and height slider and set up event handlers
$("#changeborderwh").slider({
    onSlide: function(e) {
        adjustActiveObjectBorder(e.value);
    },
    onSlideStop: function() {
        s_history = true;
        save_history();
    }
}).data("slider");

function adjustActiveObjectBorder(borderValue) {
    logDebug("adjustActiveObjectBorder(b");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    // Disable history tracking for this change
    s_history = false;

    // Calculate new width and height based on border value
    var newWidth = canvas.get("width") / canvas.getZoom() - 96 * borderValue * 2;
    var newHeight = canvas.get("height") / canvas.getZoom() - 96 * borderValue * 2;
    
    // Apply new width and height to the active object
    activeObject.set({ width: newWidth, height: newHeight }).setCoords();

    // If the object is a rectangle, center it on the viewport and adjust its position
    if (activeObject.type === "rect") {
        centerRectangleObject(activeObject);
    }

    canvas.renderAll();
}

function centerRectangleObject(rectObject) {
    logDebug("centerRectangleObject(r");
    rectObject.viewportCenter();
    var newLeft = (canvas.get("width") / canvas.getZoom() - rectObject.get("width")) / 2;
    var newTop = (canvas.get("height") / canvas.getZoom() - rectObject.get("height")) / 2;
    rectObject.set({ left: newLeft, top: newTop }).setCoords();
}

function loadTemplates_related() {
    logDebug("loadTemplates_related()");
    logDebug("loadTemplates_related()");

    // Trigger loading the next page of templates.
    infinites[type_related].infiniteScroll("loadNextPage");

    // Schedule layout refresh and display of related products request indicator after a short delay.
    scheduleLayoutRefreshAndShowRequestIndicator();

    // Hide the loader animation after a longer delay, indicating completion.
    hideLoaderAnimationAfterDelay();
}

function scheduleLayoutRefreshAndShowRequestIndicator() {
    logDebug("scheduleLayoutRefreshAndShowRequestIndicator()");
    setTimeout(function() {
        if (masonrys[type_related]) {
            masonrys[type_related].layout();
            $(".infinite-scroll-request_related_products").show();
        }
    }, 500); // Wait 500ms to refresh the layout and show the request indicator.
}

function hideLoaderAnimationAfterDelay() {
    logDebug("hideLoaderAnimationAfterDelay()");
    setTimeout(function() {
        $(aContainer_related).next().find(".loader-ellips").hide();
    }, 1500); // Wait 1500ms before hiding the loader animation.
}


function initializeLineHeightToggle() {
    logDebug("initializeLineHeightToggle()");
    $("#lineheight").on("click", function() {
        toggleLineHeightSlider();
        hideOtherOptionsExceptThis("#lineheight")
    });
}

function toggleLineHeightSlider() {
    logDebug("toggleLineHeightSlider()");
    // Toggles visibility of the line height slider.
    $("#lineheightSlider").toggle();
}

function setupTextCaseToggle() {
    logDebug("setupTextCaseToggle()");
    $("#textcase").on("click", function() {
        console.log("#textcase");
        toggleTextCaseOptions();
        hideOtherOptionsExceptThis("#textuppercase, #textlowercase, #textcapitalize");
    });
}

function toggleTextCaseOptions() {
    logDebug("toggleTextCaseOptions()");
    // Toggles visibility of the text case options.
    $("#textuppercase, #textlowercase, #textcapitalize").toggle();
}

// function hideNonVisibleOptions() {
//     logDebug("hideNonVisibleOptions()");
//     // Adds 'temphide' class to non-visible options, excluding specific text case options.
//     $("#showmoreoptions ul li a").each(function() {
//         if ($(this).css("display") === "block" && !$(this).is("#textuppercase, #textlowercase, #textcapitalize")) {
//             $(this).addClass("temphide");
//         }
//     });
// }

function updateFontSizeForActiveObject(object, fontSize) {
    logDebug("updateFontSizeForActiveObject(o");
    if (isObjectTextType(object)) {
        setFontSizeAndResetScale(object, fontSize);
    } else if (object.type === "textbox") {
        adjustFontSizeForTextbox(object, fontSize);
    } else if (isTextsGroup2(object)) {
        adjustFontSizeForTextsGroup(object, fontSize);
    }
}

function isObjectTextType(object) {
    logDebug("isObjectTextType(o");
    return object.type === "text" || object.type === "i-text";
}

function setFontSizeAndResetScale(object, fontSize) {
    logDebug("setFontSizeAndResetScale(o");
    object.set("fontSize", fontSize);
    object.scaleX = object.scaleY = 1;
    object.setCoords();
}

function adjustFontSizeForTextbox(textbox, fontSize) {
    logDebug("adjustFontSizeForTextbox(t");
    textbox.set("fontSize", fontSize / textbox.scaleX);
    textbox.setCoords();
}

function isTextsGroup2(object) {
    logDebug("isTextsGroup2(o");
    // Assuming isTextsGroup checks if the object is a group of text objects
    return object.type === "group" && object._objects && object._objects.every(obj => isObjectTextType(obj));
}

// Ensure the fontSizeSwitch element exists before attaching the event listener
var fontSizeSwitch = document.getElementById("fontsize");
if (fontSizeSwitch) {
    fontSizeSwitch.onchange = function() {
        // Clamp the font size value between 6 and 500
        var clampedValue = Math.min(500, Math.max(6, this.value));
        this.value = clampedValue;

        var fontSize = Math.round(1.3 * clampedValue); // Apply scaling factor to font size
        var activeObject = canvas.getActiveObject();

        if (activeObject) {
            updateFontSizeForActiveObjectAlt(activeObject, fontSize);
            canvas.renderAll(); // Update the canvas only once after font size changes
        }
    };
}

function updateFontSizeForActiveObjectAlt(object, fontSize) {
    logDebug("updateFontSizeForActiveObjectAlt(o");
    if (isTextTypeObject(object)) {
        adjustFontSizeForTextObject(object, fontSize);
    } else if (object.type === "textbox") {
        adjustFontSizeForTextbox(object, fontSize);
    } else if (isTextsGroup2(object)) {
        adjustFontSizeForTextsGroup(object, fontSize);
    }
}

function isTextTypeObject(object) {
    logDebug("isTextTypeObject(o");
    return object.type === "text" || object.type === "i-text";
}

function adjustFontSizeForTextObject(object, fontSize) {
    logDebug("adjustFontSizeForTextObject(o");
    object.set("fontSize", fontSize);
    resetObjectScale(object);
}

function resetObjectScale(object) {
    logDebug("resetObjectScale(o");
    object.scaleX = 1;
    object.scaleY = 1;
    object.setCoords();
}

function adjustFontSizeForTextsGroup(group, fontSize) {
    logDebug("adjustFontSizeForTextsGroup(g");
    group.forEachObject(function(child) {
        if (child.setSelectionStyles) {
            child.removeStyle("fontSize");
        }
        child.set("fontSize", fontSize);
        resetObjectScale(child);
    });

    // Restore the group state and update coordinates
    group._restoreObjectsState();
    fabric.util.resetObjectTransform(group);
    group._calcBounds();
    group._updateObjectsCoords();
    group.setCoords();
}

function logDebug(message) {
    if (DEBUG) { // Assumes DEBUG is a global flag
        console.log(message);
    }
}

function destroyExistingInfiniteScrollAndMasonry(container) {
    logDebug("destroyExistingInfiniteScrollAndMasonry(c");
    if ($(container).data("infiniteScroll")) {
        $(container).empty(); // Clear the container's HTML
        $(container).infiniteScroll('destroy');
        $(container).masonry('destroy');
    }
}

function initializeMasonrySidebar(container) {
    logDebug("initializeMasonrySidebar(c");
    return $(container).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: true, // Use true instead of !0 for clarity
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    });
}

function initializeInfiniteScrollSidebar(container, masonryInstance, templateId) {
    logDebug("initializeInfiniteScrollSidebar(c");
    $(container).infiniteScroll({
        path: () => `${appUrl}editor/${aMethod_related}/${templateId}?demo_as_id=${demo_as_id}&loadCount=${this.loadCount}&limit_related=${limit_related}`,
        responseType: "text",
        outlayer: masonryInstance,
        history: false, // Use false instead of !1 for clarity
        scrollThreshold: false // Use false instead of !1 for clarity
    });
}

function initMasonry_related(templateId) {
    logDebug("initMasonry_related(t");
    logDebug("initMasonry_related()");
    templateId_related = templateId; // Assuming templateId_related is globally accessible

    destroyExistingInfiniteScrollAndMasonry(aContainer_related);

    // Initialize Masonry and store the instance
    infinites[type_related] = initializeMasonrySidebar(aContainer_related);
    masonrys[type_related] = infinites[type_related].data("masonry");

    // Initialize Infinite Scroll with the newly created Masonry instance
    initializeInfiniteScrollSidebar(aContainer_related, masonrys[type_related], templateId_related);

    // Assuming loadReadMore is a function defined elsewhere
    loadReadMore(aContainer_related, "loadTemplates_related");

    // Show the "read more" or equivalent button
    $(aContainer_related).next().find(".iscroll-button").show();
}

function updateCanvasSize(canvas) {
    logDebug("updateCanvasSize(c");
    setCanvasWidthHeight(canvas.cwidth * canvas.getZoom(), canvas.cheight * canvas.getZoom());
    $("#loadCanvasWid").val(canvas.cwidth / 96);
    $("#loadCanvasHei").val(canvas.cheight / 96);
}

function applyCanvasBackgroundIfNeeded(canvas) {
    logDebug("applyCanvasBackgroundIfNeeded(c");
    if (canvas.bgsrc) {
        setCanvasBg(canvas, canvas.bgsrc, "", canvas.bgScale);
    }
}

function updateHistoryControls(canvas) {
    logDebug("updateHistoryControls(c");
    if (canvas.$h_pos < 1) {
        $("#undo").hide();
        $("#autosave").data("saved", "yes");
    } else {
        $("#redo").show();
    }
}

function history_undo() {
    logDebug("history_undo()");
    logDebug("history_undo()");

    if (!canvas.$history[canvas.$h_pos - 1]) {
        return;
    }

    s_history = false; // Assuming s_history is a global flag indicating whether history actions should be recorded

    // Decrement the history position and load the corresponding state
    canvas.loadFromJSON(canvas.$history[--canvas.$h_pos], function() {
        // Actions to perform after the canvas state has been loaded
        updateCanvasSize(canvas);
        applyCanvasBackgroundIfNeeded(canvas);
        canvas.renderAll(); // Use direct call instead of bind
        s_history = true; // Re-enable history recording

        logDebug(`undo. history length: ${canvas.$history.length} history position: ${canvas.$h_pos}`);
    });

    updateHistoryControls(canvas);
}


function isImagesGroup($object) {
    logDebug("isImagesGroup()"); // Assuming logDebugInfo is a globally defined function for logging

    // Retrieve the active object if $object is not provided
    $object = $object || canvas.getActiveObject();

    // Return false if no object is found
    if (!$object) return false;

    // Check if the object is a group
    if (!$object._objects) return false;

    // Function to recursively check if all objects are images or groups of images
    function areAllImages(objects) {
        return objects.every(($o) => {
            if (/image/.test($o.type)) {
                return true; // Object is an image
            } else if ($o.type === "group") {
                return areAllImages($o._objects); // Recursively check groups
            }
            return false; // Object is not an image or group of images
        });
    }

    // Use the recursive function to check all objects in the group
    return areAllImages($object._objects);
}

function destroyExistingMasonryAndInfiniteScroll(container) {
    logDebug("destroyExistingMasonryAndInfiniteScroll(c");
    if ($(container).data("infiniteScroll")) {
        $(container).html("");
        $(container).infiniteScroll('destroy');
        $(container).masonry('destroy');
    }
}

function initializeMasonry(container) {
    logDebug("initializeMasonry(c");
    return $(container).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: true,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    });
}

function generateInfiniteScrollPath() {
    logDebug("generateInfiniteScrollPath()");
    var tags = $(aSearch_bg).val() ? $(aSearch_bg).val().toString() : "";
    return `${appUrl}editor/${aMethod_bg}?loadCount=${this.loadCount}&limit_bg=${limit_bg}&tags=${tags}&design_as_id=${design_as_id}&demo_as_id=${demo_as_id}&loadedtemplateid=${loadedtemplateid}`;
}

function initializeInfiniteScroll(masonryInstance) {
    logDebug("initializeInfiniteScroll(m");
    masonryInstance.infiniteScroll({
        path: generateInfiniteScrollPath,
        responseType: "text",
        outlayer: masonrys[type_bg],
        history: false,
        scrollThreshold: false
    });
}

function showScrollButton(container) {
    logDebug("showScrollButton(c");
    $(container).next().find(".iscroll-button").show();
}

function initMasonry_bg() {
    logDebug("initMasonry_bg()");
    logDebug("MIGRATED:: initMasonry_bg()");

    destroyExistingMasonryAndInfiniteScroll(aContainer_bg);

    infinites[type_bg] = initializeMasonry(aContainer_bg);
    masonrys[type_bg] = infinites[type_bg].data("masonry");

    initializeInfiniteScroll(infinites[type_bg]);

    loadReadMore(aContainer_bg, "loadTemplates_bg");
    showScrollButton(aContainer_bg);
}

$(document).ready(function() {

    $("#object-properties").dialog({
        resizable: !1,
        height: "auto",
        width: "auto",
        modal: !1,
        autoOpen: !1,
        dialogClass: "no-close",
        position: {
            my: "left center",
            at: "left+20px center",
            of: ".main-content"
        },
        open: function() {
            $("#object-properties").dialog("option", "position", {
                my: "left center",
                at: "left+20px center",
                of: ".main-content"
            }),
            getPropertiesOfObject()
        },
        close: function() {
            s_history = !0,
            save_history()
        }
    });
    
    $("#showObSymbolsPanel").click(function() {
        return $("#font-symbols").dialog("open")
    });
    
    $("#font-symbols").dialog({
        resizable: !1,
        height: "auto",
        width: "auto",
        modal: !1,
        autoOpen: !1,
        dialogClass: "no-close",
        position: {
            my: "left center",
            at: "left+20px center",
            of: ".main-content"
        },
        open: function() {
            $("#font-symbols").dialog("option", "position", {
                my: "left center",
                at: "left+20px center",
                of: ".main-content"
            }),
            setupSymbolsPanel()
        },
        close: function() {}
    });
    
    $("#btnZoomIn").click(function() {
        var $scale_value = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1;
        setZoom($scale_value += .1)
    });
    $("#btnZoomOut").click(function() {
        var $scale_value = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1;
        setZoom($scale_value -= .1)
    });
    $("#zoomperc").click(function() {
        setZoom(1)
    });

    $("#btnFitToScreen").click(function() {
        setZoom(1),
        autoZoom()
    });
    
    $("#fontbold").click(function(e) {
        e.preventDefault();
        toggleTextStyle("fontWeight", "fontbold", "normal", "bold");
    });

    $("#fontitalic").click(function(e) {
        e.preventDefault();
        toggleTextStyle("fontStyle", "fontitalic", "", "italic");
    });

    $("#fontunderline").click(function(e) {
        e.preventDefault();
        // For 'underline', assuming it's a boolean since Fabric.js usually uses boolean for such styles.
        // You might need to adjust the implementation if it's handled differently in your project.
        toggleTextDecoration("underline", "fontunderline");
    });

    $("#changeopacity").slider({
        formatter: function(value) {
            return 100 * value + "%"
        }
    });
});


function toggleTextStyle(styleType, activeClassId, defaultValue, alternateValue) {
    logDebug("toggleTextStyle(s");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    var isGroup = activeObject._objects;
    var objectsToStyle = isGroup ? activeObject._objects : [activeObject];

    objectsToStyle.forEach(function(obj) {
        if (/text/.test(obj.type)) {
            var currentValue = obj[styleType];
            var newValue = currentValue === defaultValue ? alternateValue : defaultValue;
            setStyle(obj, styleType, newValue);
        }
    });

    // Toggle the button's active state if applicable
    $("#" + activeClassId).toggleClass("active", objectsToStyle.some(obj => obj[styleType] === alternateValue));

    canvas.renderAll();
}

function toggleTextDecoration(decorationType, activeClassId) {
    logDebug("toggleTextDecoration(d");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    var isGroup = activeObject._objects;
    var objectsToStyle = isGroup ? activeObject._objects : [activeObject];

    objectsToStyle.forEach(function(obj) {
        if (/text/.test(obj.type)) {
            var newValue = !obj[decorationType];
            setStyle(obj, decorationType, newValue);
        }
    });

    $("#" + activeClassId).toggleClass("active", objectsToStyle.some(obj => obj[decorationType]));

    canvas.renderAll();
}



$(document).ready(function() {
    $("body").on("click", ".utf8-symbol", function(event) {
        event.preventDefault(); // Prevent the default action of the click event

        // Retrieve the active text object from the canvas
        var activeTextObject = canvas.getActiveObject();

        // Proceed only if the active object is a text object
        if (activeTextObject && /text/.test(activeTextObject.type)) {
            insertSymbolIntoText(activeTextObject, $(this).text());
        }
    });

    function insertSymbolIntoText(textObject, symbol) {
        // Determine the insertion point or selection range in the text object
        var insertionStart = textObject.isEditing ? textObject.selectionStart : textObject.text.length;
        var insertionEnd = textObject.isEditing ? textObject.selectionEnd : textObject.text.length;

        // Insert the symbol into the text object at the determined position
        textObject.insertChars(symbol, "", insertionStart, insertionEnd);

        // Adjust the selection range if no selection was made (insertion point)
        if (insertionEnd === insertionStart) {
            textObject.selectionStart = textObject.selectionEnd = insertionStart + symbol.length;
        }

        // Update the hidden textarea if the text object is in editing mode
        if (textObject.isEditing) {
            textObject.hiddenTextarea.value = textObject.text;
        }

        // Mark the text object as needing a re-render and update the canvas
        textObject.dirty = true;
        canvas.renderAll();
    }
});


$(document).ready(function() {
    $("#clone").on("click", function() {
        cloneActiveObject();
    });
});

function cloneActiveObject() {
    logDebug("cloneActiveObject()");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    activeObject.clone(function(clone) {
        processClone(clone, activeObject);
        adjustCloneProperties(clone, activeObject);
        finalizeClone(clone, activeObject);
    }, properties_to_save); // Assuming properties_to_save is defined elsewhere
}

function adjustCloneProperties(clone, original) {
    logDebug("adjustCloneProperties(c");
    // Adjust the clone's properties based on the original object or active selection
    if (original.type === 'activeSelection') {
        // If cloning an active selection, individually adjust properties of each object within
        clone.forEachObject(function(obj, index) {
            const originalObj = original._objects[index];
            adjustObjectProperties(obj, originalObj);
        });
    } else {
        // If cloning a single object, directly adjust the clone's properties
        adjustObjectProperties(clone, original);
    }

    // Set additional properties and position the clone relative to the original
    clone.set({
        left: original.get('left') + 10,
        top: original.get('top') + 10,
        angle: original.angle,
        scaleX: original.scaleX,
        scaleY: original.scaleY,
        skewX: original.skewX,
        skewY: original.skewY,
        flipX: original.flipX,
        flipY: original.flipY
    }).setCoords();
}

function adjustObjectProperties(obj, originalObj) {
    logDebug("adjustObjectProperties(o");
    // Apply patterns if the original object has a pattern fill
    if (typeof originalObj.fill === 'object' && (originalObj.fill.type === 'Dpattern' || originalObj.fill.type === 'pattern')) {
        const patternProps = originalObj.fill.toObject();
        fabric.Dpattern.fromObject(patternProps, function(fill) {
            obj.set({ fill: fill, dirty: true });
        });
    }

    // Adjust borderColor for the cloned object if necessary
    if (originalObj.borderColor === '#ff0000') {
        obj.set({
            borderColor: '#4dd7fa',
            lockMovementY: false,
            lockMovementX: false,
            hasControls: true
        });
    }

    obj.setCoords();
}


function processClone(clone, activeObject) {
    logDebug("processClone(c");
    if (clone.type === "activeSelection") {
        clone.canvas = canvas;
        clone.forEachObject(function(obj, i) {
            obj.scale(1);
            canvas.add(obj);
            copyPropertiesFromActiveObject(obj, activeObject._objects[i]);
        });
    } else {
        clone.scale(1);
        canvas.add(clone);
        copyPropertiesFromActiveObject(clone, activeObject);
    }
}

function copyPropertiesFromActiveObject(clone, original) {
    logDebug("copyPropertiesFromActiveObject(c");
    setCloneScaleAndPosition(clone, original);
    applyPatternFillIfNeeded(clone, original);
    adjustBorderColor(clone, original);
    clone.setCoords();
}

function setCloneScaleAndPosition(clone, original) {
    logDebug("setCloneScaleAndPosition(c");
    clone.set({
        scaleX: original.get("scaleX"),
        scaleY: original.get("scaleY"),
        left: original.get("left") + 50,
        top: original.get("top") + 50
    });
}

function applyPatternFillIfNeeded(clone, original) {
    logDebug("applyPatternFillIfNeeded(c");
    if (typeof original.fill === "object" && (original.fill.type === "Dpattern" || original.fill.type === "pattern")) {
        var pattern = original.fill.toObject();
        fabric.Dpattern.fromObject(pattern, function(fill) {
            clone.set({ fill: fill, dirty: true });
        });
    }
}

function adjustBorderColor(clone, original) {
    logDebug("adjustBorderColor(c");
    if (original.borderColor === "#ff0000") {
        clone.set({
            borderColor: "#4dd7fa",
            lockMovementY: false,
            lockMovementX: false,
            hasControls: true
        });
    }
}

function finalizeClone(clone, activeObject) {
    logDebug("finalizeClone(c");
    canvas.renderAll();
    canvas.discardActiveObject();
    canvas.setActiveObject(clone);
}

// Function to check if source and destination objects are valid for normalization.
function isValidObjectPair(src, dest) {
    logDebug("isValidObjectPair(s");
    // Returns true only if both src and dest objects and their _objects property exist.
    return src && dest && src._objects && dest._objects;
}

// Function to apply transformations from a source object to a destination object.
function applyObjectTransformations(srcObject, destObject) {
    logDebug("applyObjectTransformations(s");
    // Decompose the matrix of the source object to get its properties.
    const matrix = srcObject.calcOwnMatrix();
    const options = fabric.util.qrDecompose(matrix);
    // Create a center point based on the decomposed options.
    const center = new fabric.Point(options.translateX, options.translateY);

    // Set transformation properties on the destination object and position it by the calculated center.
    destObject.set({
        flipX: false,
        flipY: false,
        scaleX: options.scaleX,
        scaleY: options.scaleY,
        skewX: options.skewX,
        skewY: options.skewY,
        angle: options.angle
    }).setPositionByOrigin(center, "center", "center");
}

// Main function to normalize the scale of SVG objects.
function normalizeSvgScale(src, dest) {
    logDebug("normalizeSvgScale(s");
    logDebug("normalizeSvgScale()"); // Log the function call for debugging.

    // Early return if src or dest objects do not meet validity criteria.
    if (!isValidObjectPair(src, dest)) return false;

    // Decompose the matrix of the source object to use its properties for the destination.
    const srcOptions = fabric.util.qrDecompose(src.calcOwnMatrix());

    // Iterate over each object in the source, applying transformations to corresponding objects in the destination.
    src.forEachObject(function(obj, index) {
        if (dest._objects[index]) {
            applyObjectTransformations(obj, dest._objects[index]);
        }
    });

    // Recalculate bounds and set coordinates for the destination object.
    dest._calcBounds();
    dest.setCoords();

    // Create a center point based on the source object's options and set the destination object's properties accordingly.
    const center = new fabric.Point(srcOptions.translateX, srcOptions.translateY);
    dest.set({
        angle: src.angle,
        scaleX: srcOptions.scaleX,
        scaleY: srcOptions.scaleY,
        skewX: srcOptions.skewX,
        skewY: srcOptions.skewY,
        flipX: src.flipX,
        flipY: src.flipY
    }).setPositionByOrigin(center, "center", "center");

    dest.setCoords(); // Ensure the destination object's coordinates are updated.
    return true; // Return true to indicate successful normalization.
}

// var activeObjectCopy = null; // Ensure activeObjectCopy is declared at a broader scope

function copyobjs() {
    logDebug("copyobjs()");
    logDebug("copyobjs()");
    var activeObject = canvas.getActiveObject();

    if (activeObject) {
        activeObject.clone(function(cloned) {
            if (cloned.type === "activeSelection") {
                cloned._objects = cloned._objects.filter(o => !o.locked);
            }
            activeObjectCopy = cloned;
        }, properties_to_save); // Assuming properties_to_save is defined and relevant
    }
}

function pasteobjs(inPlace = false) {
    logDebug("pasteobjs(i");
    logDebug("pasteobjs()");
    if (!activeObjectCopy) return;

    activeObjectCopy.clone(function(clonedObj) {
        canvas.discardActiveObject();
        clonedObj.set({ evented: true });

        if (!inPlace) {
            // Position the cloned object at the center of the viewport if not pasting in place
            canvas.viewportCenterObject(clonedObj);
        }

        if (clonedObj.type === "activeSelection") {
            pasteActiveSelection(clonedObj);
        } else {
            pasteSingleObject(clonedObj);
        }

        canvas.setActiveObject(clonedObj);
        canvas.requestRenderAll();
    }, properties_to_save); // Assuming properties_to_save is defined and relevant
}

function pasteActiveSelection(clonedSelection) {
    logDebug("pasteActiveSelection(c");
    clonedSelection.canvas = canvas;
    clonedSelection.forEachObject((obj, i) => {
        applyObjectProperties(obj, activeObjectCopy._objects[i]);
        canvas.add(obj);
    });
}

function pasteSingleObject(clonedObj) {
    logDebug("pasteSingleObject(c");
    applyObjectProperties(clonedObj, activeObjectCopy);
    canvas.add(clonedObj);
}

function applyObjectProperties(object, referenceObject) {
    logDebug("applyObjectProperties(o");
    object.set({
        scaleX: referenceObject.get("scaleX"),
        scaleY: referenceObject.get("scaleY"),
        left: referenceObject.get("left") + 10, // Offset to visualize the paste action
        top: referenceObject.get("top") + 10,
    }).setCoords();
}

// Ensures the script runs after the DOM is fully loaded.
document.addEventListener("DOMContentLoaded", function() {
    setupSendLayerBackward();
    setupBringLayerForward();
    setupSendLayerToBack();
    setupBringLayerToFront();
    setupShadowSwitch();
});

function setupShadowSwitch() {
    logDebug("setupShadowSwitch()");
    $("input#shadowSwitch").on("click", toggleShadow);
}

function toggleShadow() {
    logDebug("toggleShadow()");
    var activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    if ($("input#shadowSwitch").is(":checked")) {
        applyShadowToActiveObject(activeObject);
        enableShadowControls();
    } else {
        removeShadowFromActiveObject(activeObject);
        disableShadowControls();
    }

    canvas.renderAll();
}

function applyShadowToActiveObject(object) {
    logDebug("applyShadowToActiveObject(o");
    if (object.shadow) {
        object.shadow.color = "rgba(0, 0, 0, 1)";
    } else {
        var shadow = {
            color: lastShadowColor || "rgba(0, 0, 0, 1)",
            blur: lastShadowBlur || 5,
            offsetX: lastShadowHorizontalOffset || 5,
            offsetY: lastShadowVerticalOffset || 5
        };
        object.setShadow(shadow);
    }
}

function enableShadowControls() {
    logDebug("enableShadowControls()");
    $("#shadowGroup .tab-content").removeClass("editor-disabled");
    $("#shadowColor").spectrum("enable");
}

function removeShadowFromActiveObject(object) {
    logDebug("removeShadowFromActiveObject(o");
    object.shadow = null;
}

// Function to set up the "bring to front" action for the active object on the canvas.
function setupBringLayerToFront() {
    logDebug("setupBringLayerToFront()");
    var bringLayerToFrontSwitch = document.getElementById("bringtofront");
    if (bringLayerToFrontSwitch) {
        bringLayerToFrontSwitch.addEventListener("click", bringActiveObjectToFront);
    }
}

// Function to bring the active object to the front of the canvas, if it exists.
function bringActiveObjectToFront() {
    logDebug("bringActiveObjectToFront()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.bringToFront(activeObject);
        canvas.renderAll();
    }
}


// Function to set up the "send to back" action for the active object.
function setupSendLayerToBack() {
    logDebug("setupSendLayerToBack()");
    var sendLayerToBackSwitch = document.getElementById("sendtoback");
    if (sendLayerToBackSwitch) {
        sendLayerToBackSwitch.addEventListener("click", sendActiveObjectToBack);
    }
}

// Function to send the active object to the back on the canvas, if it exists.
function sendActiveObjectToBack() {
    logDebug("sendActiveObjectToBack()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.sendToBack(activeObject);
        canvas.renderAll();
    }
}

// Function to set up the "bring forward" action for the active object.
function setupBringLayerForward() {
    logDebug("setupBringLayerForward()");
    var bringLayerFrontSwitch = document.getElementById("bringforward");
    if (bringLayerFrontSwitch) {
        bringLayerFrontSwitch.addEventListener("click", sendActiveObjectForward);
    }
}

// Function to bring the active object forward on the canvas, if it exists.
function sendActiveObjectForward() {
    logDebug("sendActiveObjectForward()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.bringForward(activeObject, true); // true to move it one layer forward only if it's not already at the front
        canvas.renderAll();
    }
}


// Function to set up the "send backward" action for the active object.
function setupSendLayerBackward() {
    logDebug("setupSendLayerBackward()");
    var sendLayerBackSwitch = document.getElementById("sendbackward");
    if (sendLayerBackSwitch) {
        sendLayerBackSwitch.addEventListener("click", function() {
            sendActiveObjectBackward();
        });
    }
}

// Function to send the active object backward on the canvas, if it exists.
function sendActiveObjectBackward() {
    logDebug("sendActiveObjectBackward()");
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.sendBackwards(activeObject, true); // true to send it one layer back only if it's not already at the bottom
        canvas.renderAll();
    }
}

fabric.Cropzoomimage = fabric.util.createClass(fabric.Image, {
    type: "cropzoomimage",
    zoomedXY: !1,
    initialize: function(element, options) {
        options || (options = {}),
        this.callSuper("initialize", element, options),
        this.set({
            orgSrc: element.src,
            cx: 0,
            cy: 0,
            cw: element.width,
            ch: element.height
        })
    },
    zoomBy: function(x, y, z, callback) {
        (x || y) && (this.zoomedXY = !0),
        this.cx += x,
        this.cy += y,
        z && (this.cw -= z,
        this.ch -= z / (this.width / this.height)),
        z && !this.zoomedXY && (this.cx = this.width / 2 - this.cw / 2,
        this.cy = this.height / 2 - this.ch / 2),
        this.cw > this.width && (this.cw = this.width),
        this.ch > this.height && (this.ch = this.height),
        this.cw < 1 && (this.cw = 1),
        this.ch < 1 && (this.ch = 1),
        this.cx < 0 && (this.cx = 0),
        this.cy < 0 && (this.cy = 0),
        this.cx > this.width - this.cw && (this.cx = this.width - this.cw),
        this.cy > this.height - this.ch && (this.cy = this.height - this.ch),
        this.rerender(callback)
    },
    rerender: function(callback) {
        var img = new Image
          , obj = this;
        img.onload = function() {
            var canvas = fabric.util.createCanvasElement();
            canvas.width = obj.width,
            canvas.height = obj.height,
            canvas.getContext("2d").drawImage(this, obj.cx, obj.cy, obj.cw, obj.ch, 0, 0, obj.width, obj.height),
            img.onload = function() {
                obj.setElement(this),
                obj.applyFilters(canvas.renderAll),
                obj.set({
                    left: obj.left,
                    top: obj.top,
                    angle: obj.angle
                }),
                obj.setCoords(),
                callback && callback(obj)
            }
            ,
            img.src = canvas.toDataURL("image/png")
        }
        ,
        img.src = this.orgSrc
    },
    toObject: function() {
        return fabric.util.object.extend(this.callSuper("toObject"), {
            orgSrc: this.orgSrc,
            cx: this.cx,
            cy: this.cy,
            cw: this.cw,
            ch: this.ch
        })
    }
}),
fabric.Cropzoomimage.async = !0,
fabric.Cropzoomimage.fromObject = function(object, callback) {
    fabric.util.loadImage(object.src, function(img) {
        fabric.Image.prototype._initFilters.call(object, object, function(filters) {
            object.filters = filters || [];
            var instance = new fabric.Cropzoomimage(img,object);
            callback && callback(instance)
        })
    }, null, object.crossOrigin)
}
fabric.Dpattern = fabric.util.createClass(fabric.Pattern, {
    padding: 0,
    scale: 1,
    patternImage: null,
    patternSourceCanvas: null,
    type: "Dpattern",
    src: null,
    width: 0,
    height: 0,
    crossOrigin: "anonymous",
    initialize: function(options, cb) {
        var _this = this;
        this.setOptions(options),
        this.source && "object" === _typeof(this.source) && "string" == typeof this.source.src && !this.src && (this.src = this.source.src),
        this.src || (this.src = "//d1p42ymg3s8emo.cloudfront.net/thumbs/1_1510855424.png"),
        fabric.Image.fromURL(this.src, function($img) {
            return _this.id = fabric.Object.__uid++,
            $("body").trigger("pattern_image_loaded"),
            canvas && canvas.fire("custom:pattern_image_loaded", {
                target: _this
            }),
            _this.patternImage = $img,
            _this.width = _this.width || _this.patternImage.width,
            _this.height = _this.height || _this.patternImage.height,
            _this.scale || (_this.scale = 1),
            _this.padding || (_this.padding = 0),
            _this.patternImage.scaleToWidth(_this.width * _this.scale),
            _this.patternSourceCanvas = new fabric.StaticCanvas,
            _this.patternSourceCanvas.add(_this.patternImage),
            _this.patternSourceCanvas.renderAll(),
            _this.source = function() {
                return this.patternSourceCanvas.setDimensions({
                    width: this.patternImage.getScaledWidth() + this.padding,
                    height: this.patternImage.getScaledHeight() + this.padding
                }),
                this.patternSourceCanvas.renderAll(),
                this.patternSourceCanvas.getElement()
            }
            ,
            cb && cb(_this),
            _this
        }, {
            crossOrigin: this.crossOrigin
        })
    },
    toDataURL: function($params) {
        return this.src && this.patternSourceCanvas && void 0 !== this.patternSourceCanvas.toDataURL ? this.patternSourceCanvas.toDataURL($params) : this.src
    },
    update: function($params) {
        this.setOptions($params),
        this.patternImage.scale(this.scale),
        this.patternSourceCanvas.setDimensions({
            width: this.patternImage.getScaledWidth() + this.padding,
            height: this.patternImage.getScaledHeight() + this.padding
        })
    },
    toObject: function() {
        // DEBUG && console.log("Dpattern toObject", this);
        var object, NUM_FRACTION_DIGITS = fabric.Object.NUM_FRACTION_DIGITS, source = this.patternSourceCanvas;
        this.patternSourceCanvas && this.patternSourceCanvas.toDataURL && (source = this.patternSourceCanvas.toDataURL({
            multiplier: fabric.devicePixelRatio
        })),
        object = {
            type: "Dpattern",
            repeat: this.repeat,
            crossOrigin: this.crossOrigin,
            offsetX: fabric.util.toFixed(this.offsetX, NUM_FRACTION_DIGITS),
            offsetY: fabric.util.toFixed(this.offsetY, NUM_FRACTION_DIGITS),
            patternTransform: this.patternTransform ? this.patternTransform.concat() : null,
            padding: this.padding,
            scale: this.scale,
            src: this.src,
            source: source
        };
        for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++)
            args[_key] = arguments[_key];
        return fabric.util.populateWithProperties(this, object, args),
        object
    },
    toDatalessJSON: function() {
        // DEBUG && console.log("toDatalessJSON", this);
        for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++)
            args[_key2] = arguments[_key2];
        var object = this.toObject(args);
        return delete object.patternImage,
        delete object.patternSourceCanvas,
        delete object.source,
        fabric.util.populateWithProperties(this, object, args),
        object
    }
}),
fabric.Dpattern.async = !0,
fabric.Dpattern.fromObject = function(object, callback) {
    // DEBUG && console.log("Dpattern fromObject", object),
    return new fabric.Dpattern(object,callback);
};

// var DEBUG = !1;
fabric.Object.NUM_FRACTION_DIGITS = 10,
fabric.textureSize = 4096,
fabric.util.object.extend(fabric.Group.prototype, {
    clone: function(callback, properties) {
        var _this2 = this;
        this.callSuper("clone", function(cloned) {
            normalizeSvgScale(_this2, cloned),
            callback && callback(cloned)
        }, properties)
    }
}),
fabric.PathGroup = {},
fabric.PathGroup.fromObject = function(object, callback) {
    var originalPaths = object.paths;
    delete object.paths,
    "string" == typeof originalPaths ? fabric.loadSVGFromURL(originalPaths, function(elements) {
        var pathUrl = originalPaths
          , group = fabric.util.groupSVGElements(elements, object, pathUrl);
        group.type = "group",
        object.paths = originalPaths,
        void 0 !== callback && callback(group)
    }) : fabric.util.enlivenObjects(originalPaths, function(enlivenedObjects) {
        enlivenedObjects.forEach(function(obj) {
            obj._removeTransformMatrix()
        });
        var group = new fabric.Group(enlivenedObjects,object);
        group.type = "group",
        object.paths = originalPaths,
        void 0 !== callback && callback(group)
    })
}
;

fabric.Object.prototype.rotatingPointOffset = 20,
fabric.Group.prototype.toSVG = function(t) {
    for (var transform, cwidth = canvasarray[0].get("width") / canvasarray[0].getZoom(), cheight = canvasarray[0].get("height") / canvasarray[0].getZoom(), e = [], i = 0, len = this._objects.length; i < len; i++)
        if ("group" == this._objects[i].type) {
            var opacityValue = this._objects[i].opacity
              , groupSvg = this._objects[i].toSVG(t)
              , groupElement = $(groupSvg);
            $(groupElement).css("opacity", opacityValue),
            groupSvg = groupSvg.replace('style="', 'style="opacity: ' + opacityValue + ";"),
            e.push("\t", groupSvg)
        } else
            e.push("\t", this._objects[i].toSVG(t));
    var center, options = {
        translateX: 0,
        translateY: 0,
        scaleX: 1,
        scaleY: 1
    };
    this.getObjects().forEach(function(o) {
        "bgl" === o.id && (transform = o.calcOwnMatrix(),
        options = fabric.util.qrDecompose(transform),
        center = new fabric.Point(options.translateX,options.translateY),
        cwidth = o.get("width"),
        cheight = o.get("height"))
    });
    var x = -cwidth / 2 - .1
      , y = -cheight / 2 - .1;
    if (transform) {
        var $clipPath = new fabric.Rect({
            left: x,
            top: y,
            width: cwidth,
            height: cheight,
            scaleX: options.scaleX,
            scaleY: options.scaleY
        });
        this.clipPath = $clipPath,
        $clipPath.setPositionByOrigin(center, "center", "center")
    }
    return this._createBaseSVGMarkup(e, {
        reviver: t,
        noStyle: !0,
        withShadow: !0
    })
}
,
fabric.Image.prototype.getSrc = function(filtered) {
    var element = filtered ? this._element : this._originalElement;
    if (element) {
        if (element.toDataURL) {
            var format = /jp?g/.test(this.src) ? "jpeg" : "png";
            return element.toDataURL("image/" + format, .8)
        }
        return element.src
    }
    return this.src || ""
}
,
fabric.Image.prototype.getSvgSrc = fabric.Image.prototype.getSrc;

