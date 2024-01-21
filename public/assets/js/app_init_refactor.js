function initCanvasEvents(lcanvas) {
    if (DEBUG) {
        console.log(`initCanvasEvents(): Canvas ID - ${lcanvas ? lcanvas.id : 'undefined'}`);
    }

    let selectedObject;
    const canvas = lcanvas || canvas;
    const LOCAL_STORAGE_KEY = "wayak.design";

    function objectSelected(e, $action) {
        // Resetting the s_history flag to false
        s_history = false;

        // Determine the selected object: Use the event's target if available, otherwise get the active object from the canvas
        selectedObject = e.target ? e.target : canvas.getActiveObject();

        // Proceed if there's a selected object and the action is not 'created' or if the selected object is an 'activeSelection'
        if (selectedObject && ("created" !== $action || "activeSelection" === selectedObject.type)) {
            // Clear box-shadow style from all canvas elements up to the current index
            for (var i = 0; i <= canvasindex; i++) {
                $("#canvas" + i).css("box-shadow", "");
            }

            // Apply box-shadow style to the current canvas if template type is not 'geofilter' or 'geofilter2'
            if ("geofilter" !== template_type && "geofilter2" !== template_type) {
                $("#canvas" + currentcanvasid).css("box-shadow", "0px 0px 10px #888888");
            }

            // Toggle visibility text based on the hidden status of the target element
            if (e.target.hidden) {
                $("#hideobject").html("<i class='fa fa-eye'></i>&nbsp; Unhide object in pdf/png");
            } else {
                $("#hideobject").html("<i class='fa fa-eye'></i>&nbsp; Hide object in pdf/png");
            }

            // Add a class to display the toolbar
            $(".tools-top").addClass("toolbar-show");
            console.log("Show Toolbar");

            // Additional condition check for the target's selectable property
            if (!e.target || "false" !== e.target.selectable) {
                selectedObject.set({
                    transparentCorners: !1,
                    borderDashArray: [4, 2],
                    cornerStrokeColor: "#ffffff",
                    borderColor: "#4dd7fa",
                    cornerColor: "#4dd7fa",
                    cornerSize: 8,
                    minScaleLimit: 0,
                    padding: 5,
                    lockScalingFlip: !0
                });
                var $toolbar_top = $(".toolbar-top");
                if (!e.target || e.target.selectable !== "false") {
                    // Set properties for the selected object
                    selectedObject.set({
                        transparentCorners: false,
                        borderDashArray: [4, 2],
                        cornerStrokeColor: "#ffffff",
                        borderColor: "#4dd7fa",
                        cornerColor: "#4dd7fa",
                        cornerSize: 8,
                        minScaleLimit: 0,
                        padding: 5,
                        lockScalingFlip: true
                    });
                
                    // Toolbar top element and actions
                    var $toolbar_top = $(".toolbar-top");
                    $toolbar_top.find("#shadowGroup").show();
                    $toolbar_top.find("#deleteitem").show();
                    $toolbar_top.find("#showmoreoptions").show();
                    $toolbar_top.find("#clone").show();
                    $toolbar_top.find(".bringforward").show();
                    $toolbar_top.find(".sendbackward").show();
                    $toolbar_top.find("#showObjectProperties").hide();
                    $toolbar_top.find("#showColors").hide().removeClass("expanded");
                    $(".patternFillTab").hide();
                    $("#group").hide();
                    $("#ungroup").hide();
                    $("#strokegroup").hide();
                    $("#alignbtns").hide();
                    $("#alignbtns a").removeClass("active");
                
                    // Set selection background color
                    selectedObject.selectionBackgroundColor = "rgba(255,255,255,0.25)";
                
                    // Apply control visibility settings
                    setControlsVisibility(selectedObject);
                
                    // Handle locked objects and their properties
                    if (selectedObject.locked && selectedObject.locked === true) {
                        selectedObject.lockMovementY = true;
                        selectedObject.hasControls = false;
                        selectedObject.set({ borderColor: "#ff0000" });
                    } else {
                        if (selectedObject.lockMovementY) {
                            selectedObject.hasControls = false;
                            selectedObject.set({ borderColor: "#ff0000" });
                        } else {
                            selectedObject.hasControls = true;
                            selectedObject.set({ borderColor: "#4dd7fa" });
                        }
                    }
                
                    // Additional conditions for specific object types
                    if (selectedObject.type === "activeSelection" || selectedObject.type === "group") {
                        $("#addremovestroke").hide();
                        selectedObject.set({
                            transparentCorners: false,
                            borderColor: "#f9a24c",
                            cornerColor: "#f9a24c",
                            cornerSize: 8,
                            minScaleLimit: 0,
                            padding: 5,
                            borderDashArray: [4, 2]
                        });
                    } else {
                        $("#addremovestroke").show();
                    }
                
                    // Show object properties for images
                    if (selectedObject.type === "image") {
                        $toolbar_top.find("#showObjectProperties").show();
                    }
                
                    // Text object specific conditions
                    handleTextObject(selectedObject);
                } else {
                    // Hide text element buttons and show flip controls
                    $(".textelebtns").hide();
                    $("#objectflipvertical").show();
                    $("#objectfliphorizontal").show();
                
                    // Update HTML content of alignment buttons
                    $("#objectalignleft").html("<span class='glyphicon glyphicon-object-align-left'></span>");
                    $("#objectaligncenter").html("<span class='glyphicon glyphicon-object-align-vertical'></span>");
                    $("#objectalignright").html("<span class='glyphicon glyphicon-object-align-right'></span>");
                }
                
                // Handle UI changes for active selection objects
                if (selectedObject.type === "activeSelection" && selectedObject._objects) {
                    $("#group").show();
                    $("#alignbtns").show();
                }
                
                // Handle UI changes for group objects
                if (selectedObject.type === "group") {
                    $("#ungroup").show();
                    $("#strokegroup").show();
                }
                
                // Update stroke color selector and stroke group visibility based on selected object
                if (selectedObject.get("stroke")) {
                    $("#colorStrokeSelector").css("backgroundColor", selectedObject.stroke);
                    $("#strokegroup").show();
                } else {
                    $("#strokegroup").hide();
                }
                
                // Array of key codes to prevent default action
                var arrowKeys = [37, 38, 39, 40];

                // Attach keydown event to document
                $(document).keydown(function (e) {
                    var key = e.which;
                    // Prevent default action if key is in arrowKeys array
                    if ($.inArray(key, arrowKeys) > -1) {
                        e.preventDefault();
                        return false;
                    }
                    return true;
                });

                // Clear the HTML content of dynamic color pickers
                $("#dynamiccolorpickers").html("");

                // Get the gradient type of the selected object
                var gradientType = getGradientTypeofObject(selectedObject);

                // Check if the selected object has a gradient fill
                if (gradientType !== false) {
                    if (DEBUG) {
                        console.log("getGradientTypeofObject: ", gradientType);
                    }
                    var color1 = selectedObject.fill.colorStops[0].color;
                    var color2 = selectedObject.fill.colorStops[1].color;
                    // Apply the gradient fill
                    switchFillType(gradientType, color1, color2);
                } else {
                    // Check and apply color fill or pattern fill
                    if (typeof selectedObject.fill === "string") {
                        switchFillType("color-fill", selectedObject.fill);
                    } else if (selectedObject.fill instanceof fabric.Dpattern) {
                        // Show pattern fill UI and set attributes
                        $(".patternFillGroup").show();
                        var patternFillPreview = $(".patternFillGroup").find(".patternFillPreview");
                        patternFillPreview.attr("data-currentsrc", selectedObject.fill.src)
                            .css("background-image", "url(" + selectedObject.fill.toDataURL({
                                width: selectedObject.fill.width * selectedObject.fill.scale,
                                height: selectedObject.fill.height * selectedObject.fill.scale,
                                mulitplier: fabric.devicePixelRatio,
                                quality: 0.6
                            }) + ")");

                        // Update UI for pattern fill
                        $(".colorSelectorBox.single").find("#colorSelector,#colorSelector2").hide();
                        $(".colorSelectorBox.single").find(".dropdown-menu.fill-type-dropdown")
                            .find(".fill-type").removeClass("active")
                            .parent().find(".fill-type.pattern-fill").addClass("active");
                    }
                }

                var $validTagsRegExp = /^(path|circle|polygon|polyline|ellipse|rect|line)\b/i;
                if ("activeSelection" === selectedObject.type || "group" === selectedObject.type || isElement(selectedObject)) {
                    // Initialize arrays for storing color, all objects, and group objects
                    var colorarray = [];
                    var allObjects = [];
                    var groupObjects = [];

                    // Ensure selectedObject.svg_custom_paths is initialized as an array if undefined
                    selectedObject.svg_custom_paths = selectedObject.svg_custom_paths || [];

                    // Populate groupObjects with the objects from selectedObject, if they exist
                    if (selectedObject._objects) {
                        groupObjects = selectedObject._objects;
                    } else {
                        // If no _objects, treat selectedObject as a single group object
                        groupObjects.push(selectedObject);
                    }

                    // Iterate over each groupObject
                    groupObjects.forEach((groupObject, i) => {
                        if (DEBUG) {
                            console.log("selectedObject groupObjects[i]", groupObject, groupObject.type);
                        }

                        if (groupObject.type === "group") {
                            // Process each object in a group
                            processGroupObjects(groupObject, i);
                        } else if (isTextType(groupObject.type)) {
                            // Process text-type objects
                            processTextObject(groupObject);
                        } else if ($validTagsRegExp.test(groupObject.type)) {
                            // Process valid tag objects
                            processValidTagObject(groupObject);
                        }
                    });

                    // Check and process the selected object if it matches valid tag types
                    if ($validTagsRegExp.test(selectedObject.type)) {
                        addColorAndObject(selectedObject.fill, selectedObject);
                    }

                    function processGroupObjects(groupObject, groupIndex) {
                        var objects = groupObject.getObjects();
                        objects.forEach((object, n) => {
                            if (object.type === "group") {
                                object.forEachObject(($child, $i) => {
                                    processChildObject($child, $i, n);
                                });
                            } else {
                                addColorAndObject(object.fill, object, n);
                            }
                        });
                    }

                    function processChildObject($child, $i, n) {
                        if ($child.fill !== undefined) {
                            var $o = {};
                            $o[n] = $i;
                            $child.group_index = $o;
                            allObjects.push($child);
                            processColorString($child.fill, $child);
                        }
                    }

                    function processTextObject(textObject) {
                        if (textObject.fill !== undefined) {
                            processColorString(textObject.fill, textObject);
                            allObjects.push(textObject);
                        }
                    }

                    function processValidTagObject(tagObject) {
                        if (DEBUG) {
                            console.log("groupObjects[i].fill: ", tagObject.fill);
                        }
                        if (tagObject.fill !== undefined) {
                            addColorAndObject(tagObject.fill, tagObject);
                        }
                    }

                    function processColorString(colorString, object) {
                        if (typeof colorString === "string" && colorString) {
                            object.fill = "#" + new fabric.Color(colorString).toHex();
                        }
                        if (!isImagesGroup(object)) {
                            colorarray.push(object.fill);
                        }
                    }

                    function addColorAndObject(fill, object, index = null) {
                        if (fill !== undefined) {
                            if (index !== null) {
                                object.group_index = index;
                            }
                            allObjects.push(object);
                            processColorString(fill, object);
                        }
                    }

                    function isTextType(type) {
                        return type === "textbox" || type === "text" || type === "i-text" || isTextsGroup();
                    }

                    // Remove duplicate colors from colorarray
                    colorarray = colorarray.filter(onlyUnique);

                    // Initialize arrays for processing
                    var flags = [];
                    var output = [];
                    var colorArrayLength = colorarray.length;

                    // Process each color in the color array
                    for (var i = 0; i < colorArrayLength; i++) {
                        if (DEBUG) {
                            console.log("colorarray[" + i + "]", colorarray[i]);
                        }

                        if (isObjectWithColorStops(colorarray[i])) {
                            // Check for unique gradient color stops
                            var colorStopsKey = getColorStopsKey(colorarray[i]);
                            if (!flags[colorStopsKey]) {
                                flags[colorStopsKey] = true;
                                output.push(colorarray[i]);
                            }
                        } else {
                            // Add non-gradient colors to the output
                            output.push(colorarray[i]);
                        }
                    }

                    // Update colorarray with processed colors
                    colorarray = output;

                    if (DEBUG) {
                        console.log("output", output);
                    }

                    // Update UI based on the color array length
                    if (colorarray.length) {
                        $(".colorSelectorBox.single").hide();
                        $(".colorSelectorBox.single").find("#colorSelector2").hide();
                    }

                    // Initialize color picker HTML
                    var colorpickerhtml = "";

                    // Helper function to determine if an object has color stops (gradient)
                    function isObjectWithColorStops(color) {
                        return typeof color === "object" && color.colorStops;
                    }

                    // Helper function to create a unique key from color stops
                    function getColorStopsKey(color) {
                        return color.colorStops[0].color + color.colorStops[1].color;
                    }

                    // Iterate through each color in the color array
                    colorarray.forEach(color => {
                        if (typeof color === "string") {
                            // Process string type color
                            processStringColor(color);
                        } else if (color instanceof fabric.Gradient) {
                            // Process fabric gradient
                            processFabricGradient(color);
                        } else if (color instanceof fabric.Dpattern) {
                            // Process fabric pattern
                            processFabricPattern(color);
                        }
                    });

                    function processStringColor(color) {
                        color = color === "Black" ? "#000000" : color;
                        colorpickerhtml += `
                            <div class="btn-group colorSelectorBox group" data-gradient-type="color-fill">
                                <input type="text" class="btn btn-default dynamiccolorpicker" title="Color Picker" value="${color}" />
                                <button type="button" class="filltype btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                            </div>`;
                    }

                    function processFabricGradient(gradient) {
                        let $color1 = "#" + new fabric.Color(gradient.colorStops[0].color).toHex();
                        let $color2 = "#" + new fabric.Color(gradient.colorStops[1].color).toHex();
                        let $gradientDirection = determineGradientDirection(gradient);

                        if ($color1) {
                            colorpickerhtml += `
                                <div class="btn-group colorSelectorBox group" data-gradient-type="${$gradientDirection}">
                                    <input type="text" class="btn btn-default dynamiccolorpicker" title="Color Picker" value="${$color1}" />
                                    <input type="text" class="btn btn-default dynamiccolorpicker2 showElement" title="Color Picker" value="${$color2}" />
                                    <button type="button" class="filltype btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                </div>`;
                        }
                    }

                    function processFabricPattern(pattern) {
                        let $template = $(".patternFillLabel").first().clone();
                        let $dropdown = $(".colorSelectorBox.single").find(".dropdown-menu.fill-type-dropdown").clone();
                        $dropdown.find(".fill-type").removeClass("active").parent().find(".fill-type.pattern-fill").addClass("active");
                        $template.find(".patternFillPreview").attr("data-currentsrc", pattern.src).css("background-image", `url(${pattern.toDataURL({
                            mulitplier: fabric.devicePixelRatio,
                            width: pattern.width * pattern.scale,
                            height: pattern.height * pattern.scale,
                            quality: 0.6
                        })})`);

                        colorpickerhtml += `
                            <div class="dpattern-holder btn btn-default">
                                <div class="wrapper">${$template.get(0).outerHTML}</div>
                                <div class="wrapper">
                                    <button type="button" class="filltype btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    ${$dropdown.get(0).outerHTML}
                                </div>
                            </div>`;
                    }

                    function determineGradientDirection(gradient) {
                        if (gradient.coords.x2 !== 0 && gradient.coords.y2 !== 0) {
                            return "linear-gradient-d-fill";
                        } else if (gradient.coords.x2 !== 0) {
                            return "linear-gradient-h-fill";
                        } else if (gradient.coords.y2 !== 0) {
                            return "linear-gradient-v-fill";
                        } else if (gradient.coords.r1 !== undefined || gradient.coords.r2 !== undefined) {
                            return "radial-gradient-fill";
                        }
                        return "";
                    }

                    // Log selected objects if in DEBUG mode
                    if (DEBUG) {
                        console.log("selectedObject allObjects: ", allObjects);
                    }

                    // Update dynamic color pickers HTML
                    $("#dynamiccolorpickers").html(colorpickerhtml);

                    // Initialize the color picker with spectrum
                    initializeColorPicker();

                    function initializeColorPicker() {
                        $(".dynamiccolorpicker").spectrum({
                            containerClassName: "dynamic-fill",
                            showAlpha: false,
                            showPalette: true,
                            preferredFormat: "hex",
                            hideAfterPaletteSelect: true,
                            showSelectionPalette: true,
                            localStorageKey: localStorageKey,
                            showInput: true,
                            showInitial: true,
                            allowEmpty: true,
                            showButtons: true,
                            maxSelectionSize: 24,
                            togglePaletteMoreText: "Show advanced",
                            togglePaletteLessText: "Hide advanced",
                            change: onColorChange,
                            beforeShow: onBeforeShowColor,
                            show: onShowColor
                        });
                    }

                    function onBeforeShowColor(color) {
                        // Custom logic before showing the color picker
                        $(".dynamic-fill .sp-palette-toggle").addClass("btn btn-default");
                        $(this).spectrum("set", color);
                    }

                    function onShowColor(color) {
                        // Custom logic when showing the color picker
                        var initialColor = color.toRgbString().replace(/\s/g, "");
                        $(this).data("previous-color", initialColor);
                    }

                    function onColorChange(color) {
                        if (DEBUG) {
                            console.log("color: ", color);
                        }
                    
                        // Update local storage with new color
                        var local_store = window.localStorage[localStorageKey];
                        var newColorVal = color.toRgbString().replace(/\s/g, "");
                        if (local_store.indexOf(newColorVal) === -1) {
                            window.localStorage[localStorageKey] = local_store + ";" + newColorVal;
                        }
                    
                        // Process each object in allObjects
                        allObjects.forEach((obj, i) => {
                            updateObjectColor(obj, newColorVal, i);
                        });
                    
                        // Flag the active object as dirty to trigger a canvas redraw
                        if (canvas.getActiveObject()) {
                            canvas.getActiveObject().dirty = true;
                            if (canvas.getActiveObject()._objects && !canvas.getActiveObject().isEmptyObject) {
                                canvas.getActiveObject().forEachObject((o) => {
                                    o.dirty = true;
                                });
                            }
                        }
                    
                        // Mark the selectedObject as dirty and render the canvas
                        selectedObject.set("dirty", true);
                        canvas.renderAll();
                    
                        // Save the current state to history
                        save_history();
                    }
                    
                    function updateObjectColor(obj, newColorVal, index) {
                        var $cb = $(this).parents(".colorSelectorBox");
                        var $filltype = $cb.data("gradient-type");
                        var $cpicker2 = $cb.find(".dynamiccolorpicker2");
                        var $oldColorVal = $(this).data("previous-color");
                        var $color2 = "";
                    
                        if ($cpicker2.length && $filltype !== "color-fill") {
                            $color2 = $cpicker2.spectrum("get").toRgbString().replace(/\s/g, "");
                        } else {
                            $oldColorVal = "#" + new fabric.Color($oldColorVal).toHex();
                        }
                    
                        if (DEBUG) {
                            console.log(".dynamiccolorpicker: ", newColorVal, $oldColorVal, $color1);
                        }
                    
                        // Update color for the object
                        if ($filltype === "color-fill") {
                            updateColorFill(obj, newColorVal, $oldColorVal, $color2, index);
                        } else {
                            updateGradientFill(obj, newColorVal, $oldColorVal, $color2, index);
                        }
                    }
                    
                    function updateColorFill(obj, newColorVal, oldColorVal, color2, index) {
                        if (obj.fill && oldColorVal.toLowerCase() === tinycolor(obj.fill).toHexString()) {
                            obj.fill = newColorVal;
                            obj.dirty = true;
                            switchFillType("color-fill", newColorVal, color2, $(this));
                    
                            if (obj.group && obj.group.svg_custom_paths !== undefined) {
                                obj.group.svg_custom_paths[index] = {
                                    index: index,
                                    action: "fill",
                                    color_value: newColorVal
                                };
                            }
                        }
                    }
                    
                    function updateGradientFill(obj, newColorVal, oldColorVal, color2, index) {
                        if (obj.fill && typeof obj.fill === "object" && (obj.fill.type === "linear" || obj.fill.type === "radial")) {
                            var isFirstColorStopMatch = obj.fill.colorStops[0].color === oldColorVal;
                            var isSecondColorStopMatch = obj.fill.colorStops[1].color === color2;
                            if (isFirstColorStopMatch && isSecondColorStopMatch) {
                                obj.fill.colorStops[0].color = newColorVal;
                                obj.dirty = true;
                                switchFillType(obj.fill.type, newColorVal, color2, $(this));
                    
                                if (obj.group && obj.group.svg_custom_paths !== undefined) {
                                    obj.group.svg_custom_paths[index] = {
                                        index: index,
                                        action: "fill",
                                        color_value: obj.fill
                                    };
                                }
                            }
                        }
                    }
                
                    // Check if colorarray has more than 6 elements
                    if (colorarray && colorarray.length > 6) {
                        // Initialize an array to store preview colors
                        var previewColors = [];

                        // Iterate through each color in colorarray and process it
                        colorarray.forEach(color => {
                            var currentColor = "#ffffff"; // Default color

                            if (typeof color === "object" && color instanceof fabric.Gradient) {
                                // If color is a fabric.Gradient, get its first color stop
                                currentColor = "#" + new fabric.Color(color.colorStops[0].color).toHex();
                            } else {
                                // Otherwise, use the color as is
                                currentColor = color;
                            }

                            // Add the processed color to previewColors array
                            if (currentColor) {
                                previewColors.push(currentColor);
                            }
                        });

                        // Apply the preview colors to the UI
                        previewColors.forEach((color, index) => {
                            $("#showColors").find(".color-" + (index + 1)).css("background", color);
                        });

                        // Update UI elements' visibility
                        $("#dynamiccolorpickers").hide();
                        $("#showColors").show();

                    } else {
                        $("#dynamiccolorpickers").show();
                    }
                    
                    // Iterate over each color selector box group
                    $(".colorSelectorBox.group").each(function (index, colorBox) {
                        var $dropdown = $(".colorSelectorBox.single").find(".dropdown-menu.fill-type-dropdown").clone();
                        $(colorBox).append($dropdown);
                    
                        var $colorPicker2 = $(colorBox).find(".dynamiccolorpicker2");
                        if ($colorPicker2.hasClass("showElement")) {
                            initializeColorPicker($colorPicker2, $(colorBox));
                        } else {
                            $(colorBox).find(".fill-type").removeClass("active");
                            $(colorBox).find("#color-fill").addClass("active");
                        }
                    });
                    
                    function initializeColorPicker($colorPicker, $colorBox) {
                        $colorPicker.spectrum({
                            // Spectrum settings
                            containerClassName: "dynamic-fill",
                            showAlpha: false,
                            showPalette: true,
                            preferredFormat: "hex",
                            hideAfterPaletteSelect: true,
                            showSelectionPalette: true,
                            localStorageKey: localStorageKey,
                            showInput: true,
                            showInitial: true,
                            allowEmpty: true,
                            showButtons: true,
                            maxSelectionSize: 24,
                            togglePaletteMoreText: "Show advanced",
                            togglePaletteLessText: "Hide advanced",
                            change: colorChangeHandler,
                            beforeShow: beforeShowHandler,
                            show: showHandler
                        });
                    
                        // Initialize colors for switchFillType
                        var color1 = $colorBox.find(".dynamiccolorpicker").spectrum("get").toHexString() || "#000000";
                        var color2 = $colorPicker.spectrum("get").toHexString() || "#ffffff";
                        switchFillType($colorBox.data("gradient-type"), color1, color2, $colorPicker);
                    }
                    
                    function colorChangeHandler(color) {
                        if (DEBUG) {
                            console.log("color: ", color);
                        }
                    
                        // Update local storage with the new color
                        var localStore = window.localStorage[localStorageKey];
                        var newColorVal = color.toRgbString().replace(/\s/g, "");
                        if (localStore.indexOf(newColorVal) === -1) {
                            window.localStorage[localStorageKey] = localStore + ";" + newColorVal;
                        }
                    
                        // Data from the color picker
                        var $oldColorVal = $(this).data("previous-color");
                        var $colorBox = $(this).parents(".colorSelectorBox");
                        var $color1 = $colorBox.find(".dynamiccolorpicker").spectrum("get").toRgbString().replace(/\s/g, "");
                    
                        if (DEBUG) {
                            console.log(".dynamiccolorpicker2: ", newColorVal, $oldColorVal, $color1);
                        }
                    
                        // Update colors of all objects
                        allObjects.forEach((obj, i) => {
                            updateObjectColor(obj, newColorVal, $oldColorVal, $color1, i, $colorBox);
                        });
                    
                        // Update the canvas and save history
                        updateCanvasAndHistory();
                    }
                    
                    function updateObjectColor(obj, newColor, oldColor, firstColor, index, $colorBox) {
                        if (obj.group_index !== undefined && obj.group.svg_custom_paths !== undefined && obj.fill) {
                            if (obj.fill.toString().toLowerCase() === objinitcolor.toLowerCase()) {
                                var pathData = {
                                    index: obj.group_index,
                                    action: "fill",
                                    color_value: newColor
                                };
                                obj.group.svg_custom_paths[obj.group_index] = pathData;
                            }
                        }
                    
                        // Update fill type and object color
                        var fillType = $colorBox.data("gradient-type");
                        if (fillType === "color-fill" && obj.fill) {
                            if (tinycolor(obj.fill).toHexString().toLowerCase() === oldColor.toLowerCase()) {
                                obj.fill = newColor;
                                obj.dirty = true;
                                switchFillType(fillType, firstColor, newColor, $(this));
                            }
                        } else if (obj.fill && typeof obj.fill === "object" && (obj.fill.type === "linear" || obj.fill.type === "radial")) {
                            if (obj.fill.colorStops[0].color === firstColor && obj.fill.colorStops[1].color === oldColor) {
                                obj.fill.colorStops[1].color = newColor;
                                obj.dirty = true;
                                switchFillType(fillType, firstColor, newColor, $(this));
                            }
                        }
                    }
                    
                    function updateCanvasAndHistory() {
                        var activeObject = canvas.getActiveObject();
                        if (activeObject) {
                            activeObject.dirty = true;
                            if (activeObject._objects && !activeObject.isEmptyObject) {
                                activeObject.forEachObject((o) => {
                                    o.dirty = true;
                                });
                            }
                        }
                    
                        selectedObject.set("dirty", true);
                        canvas.renderAll();
                        save_history();
                    }
                    
                    function beforeShowHandler(color) {
                        $(".dynamic-fill .sp-palette-toggle").addClass("btn btn-default");
                        $(this).spectrum("set", color);
                    }
                    
                    function showHandler(color) {
                        var initialColor = color.toRgbString().replace(/\s/g, "");
                        $(this).data("previous-color", initialColor);
                    }
                } else {
                    $(".colorSelectorBox.single").show();
                }

                if (selectedObject.type === "line") {
                    setSelectedObjectControlVisibility(false);
                } else if (selectedObject.type === "line" || selectedObject.type === "image") {
                    $(".colorSelectorBox.single").hide();
                }
            
                if (selectedObject.type === "rect") {
                    $("#objectborderwh").show();
                } else {
                    $("#objectborderwh").hide();
                }
            
                updateColorSelectorBackground();
            
                if (selectedObject.locked === true) {
                    lockSelectedObject();
                }
            
                selectedObject.dirty = true;

                function setSelectedObjectControlVisibility(isVisible) {
                    selectedObject.setControlsVisibility({
                        bl: isVisible,
                        br: isVisible,
                        tl: isVisible,
                        tr: isVisible,
                        ml: isVisible,
                        mr: isVisible,
                        mt: isVisible,
                        mtr: isVisible,
                        mb: isVisible
                    });
                }
                
                function updateColorSelectorBackground() {
                    if (selectedObject.fill === "" || selectedObject.fill === "rgba(0,0,0,0)") {
                        $("#colorSelector, #dynamiccolorpickers .sp-preview").css({
                            "background-image": 'url("assets/img/transbg.png")',
                            "background-color": "#ffffff"
                        });
                    } else {
                        $("#colorSelector").css({
                            "background-color": selectedObject.fill,
                            "background-image": "none"
                        });
                    }
                }
                
                function initializeClickHandlers() {
                    $(".color-fill .sp-clear, .dynamic-fill .sp-clear").click(clearColorFillHandler);
                    $(".color-stroke .sp-clear").click(clearColorStrokeHandler);
                }
                
                function clearColorFillHandler() {
                    console.log("here");
                    $(".sp-container.color-fill, .sp-container.dynamic-fill").addClass("sp-hidden");
                    selectedObject.set("fill", "rgba(0,0,0,0)");
                    canvas.renderAll();
                    save_history();
                }
                
                function clearColorStrokeHandler() {
                    $(".sp-container.color-stroke").addClass("sp-hidden");
                    selectedObject.set("stroke", "");
                    canvas.renderAll();
                    save_history();
                }
                
                function lockSelectedObject() {
                    setSelectedObjectControlVisibility(false);
                    selectedObject.set({
                        lockMovementY: true,
                        lockMovementX: true,
                        borderColor: "#cccccc"
                    });
                    hideToolbarOptions();
                }
                
                function hideToolbarOptions() {
                    var toolbarOptions = [".textelebtns", "#alignbtns", "#clone", ".bringforward", ".sendbackward", "#ungroup", "#shadowGroup", "#deleteitem", "#showmoreoptions", "#showObjectProperties", ".patternFillGroup"];
                    toolbarOptions.forEach(option => $toolbar_top.find(option).hide());
                }
                
                function updateCanvasAndHistoryIfNeeded() {
                    canvas.renderAll();
                    s_history = true;
                }

                // Click handlers for clear buttons
                initializeClickHandlers();

                // Update canvas and history if necessary
                updateCanvasAndHistoryIfNeeded();
            }
        }
    }

    function deselectLockedObject(event) {
        var activeObject = canvas.getActiveObject();

        if (activeObject && activeObject._objects) {
            activeObject.getObjects().forEach(function (object) {
                if (object && object.locked === true) {
                    activeObject.removeWithUpdate(object);
                }
            });
        }
    }

    // Initialize local storage for the specified key if it doesn't exist
    if (typeof window.localStorage[localStorageKey] === 'undefined') {
        window.localStorage[localStorageKey] = ";";
    }

    // Add an event listener for when an object is selected on the canvas
    canvas.observe("object:selected", function (event) {
        objectSelected(event, "selected");
    });

    canvas.observe("selection:updated", function (e) {
        objectSelected(e, "updated")
    });
    canvas.observe("selection:created", function (e) {
        objectSelected(e, "created")
    });

    canvas.observe("selection:cleared", function (e) {
        $(".sp-container.color-fill, .sp-container.dynamic-fill").addClass("sp-hidden")
    });

    canvas.observe("selection:updated", deselectLockedObject);
    canvas.observe("selection:created", deselectLockedObject);

    canvas.observe("object:moving", function (event) {
        // Hide the top toolbar
        $(".tools-top").removeClass("toolbar-show");

        // Update the coordinates of the moving object
        event.target.setCoords();
    });

    canvas.observe("object:rotating", function (event) {
        // Apply snapping logic
        event.target.snapAngle = event.e.shiftKey ? 0 : 5;

        // Calculate and format the angle
        var rotationAngle = parseInt(event.target.angle % 360);
        var formattedAngle = rotationAngle + "°";

        // Update the rotation info on the UI
        $(".rotation_info_block").html(formattedAngle).show();
    });

    function handleObjectScaling(event) {
        if (isTextObject(event.target)) {
            updateTextObjectFontSize(event.target);
        }
        setObjectCoordinates(event.target);
        updateCanvasHeightInput();
    }

    function isTextObject(target) {
        return target && /text/.test(target.type) && target.scaleX === target.scaleY;
    }

    function updateTextObjectFontSize(target) {
        var newFontSize = (target.fontSize * target.scaleX / 1.3).toFixed(0);
        $("#fontsize").val(newFontSize);
    }

    function setObjectCoordinates(target) {
        if (target) {
            target.setCoords();
        }
    }

    function updateCanvasHeightInput() {
        var canvasHeight = document.getElementById("loadCanvasHei").value;
        // Perform any additional operations with canvasHeight if needed
    }

    canvas.observe("object:scaling", function (e) {
        handleObjectScaling(e);
    });

    function logModificationEvent() {
        if (DEBUG) {
            console.log("object is modified >> object:modified");
        }
    }

    function showToolbar() {
        $(".tools-top").addClass("toolbar-show");
    }

    function setHistoryFlagAndSave() {
        s_history = true;
        save_history(); // Assuming save_history is a global function
    }

    function processObjectModification(target) {
        if (isTextObject(target)) {
            scaleTextObject(target);
            updateTextObjectUI(target);
            updateFillPatternScale(target);
            resetObjectScaleAndCoords(target);
        } else if (target.fill && typeof target.fill === "object") {
            updateGradientFill(target);
        }
    }

    function isTextObject(target) {
        return target && /text/.test(target.type);
    }

    function scaleTextObject(target) {
        var scaleX = target.scaleX, scaleY = target.scaleY;
        if (scaleX === scaleY) {
            target.fontSize *= scaleX;
            target.fontSize = parseFloat(target.fontSize.toFixed(0));
            target.width *= scaleX;
            target.height *= scaleY;
        }
    }

    function updateTextObjectUI(target) {
        if (target.scaleX === target.scaleY) {
            $("#fontsize").val((target.fontSize / 1.3).toFixed(0));
        }
    }

    function updateFillPatternScale(target) {
        if (target.fill instanceof fabric.Dpattern && target.scaleX === target.scaleY) {
            var newScale = target.fill.scale * target.scaleX;
            target.fill.update({ scale: newScale });
        }
    }

    function resetObjectScaleAndCoords(target) {
        target.scaleX = 1;
        target.scaleY = 1;
        target.setCoords();
    }

    function updateGradientFill(target) {
        if (!isTextsGroup()) {
            if (target.fill.type === "linear") {
                updateLinearGradientCoords(target);
            } else if (target.fill.type === "radial") {
                updateRadialGradientCoords(target);
            }
        }
    }

    function updateLinearGradientCoords(target) {
        // Example implementation, adjust as needed
        target.fill.coords.x1 = -target.width;
        target.fill.coords.x2 = target.width;
        target.fill.coords.y1 = -target.height;
        target.fill.coords.y2 = target.height;
    }

    function updateRadialGradientCoords(target) {
        // Example implementation, adjust as needed
        var maxDimension = Math.max(target.width, target.height);
        target.fill.coords.r2 = maxDimension / 2;
        target.fill.coords.x1 = target.width / 2;
        target.fill.coords.x2 = target.width / 2;
        target.fill.coords.y1 = target.height / 2;
        target.fill.coords.y2 = target.height / 2;
    }

    function isTextsGroup() {
        // Implement according to your specific logic
        // Example:
        var activeObject = canvas.getActiveObject();
        return activeObject && activeObject.type === 'group' &&
            activeObject._objects.every(obj => obj.type === 'text');
    }

    canvas.observe("object:modified", function (e) {
        logModificationEvent();
        showToolbar();
        setHistoryFlagAndSave();
        processObjectModification(e.target);
    });

    canvas.observe("object:added", handleObjectAdded);

    function handleObjectAdded(event) {
        if (event.target.isUngrouping) {
            removeUngroupingFlag(event.target);
        } else {
            processNewObject(event.target);
        }
    }

    function removeUngroupingFlag(target) {
        delete target.isUngrouping;
    }

    function processNewObject(target) {
        setTargetStyles(target);
        getFonts(target); // Assuming getFonts is a function defined elsewhere in the script
        save_history(); // Assuming save_history is a function defined elsewhere in the script
        canvas.renderAll();
    }

    function setTargetStyles(target) {
        var color = determineColor(target);
        target.set({
            transparentCorners: false,
            borderDashArray: [4, 2],
            cornerStrokeColor: "#ffffff",
            borderColor: color,
            cornerColor: color,
            cornerSize: 8,
            minScaleLimit: 0,
            padding: 5,
            lockScalingFlip: true
        });
    }

    function determineColor(target) {
        return target.type === "group" ? "#f9a24c" : "#4dd7fa";
    }


    canvas.observe("mouse:up", function (e) {
        canvas.renderAll()
    });

    canvas.observe("mouse:up", handleMouseUpEvent);

    function handleMouseUpEvent(event) {
        if (isTextObjectBeingEdited(event.target)) {
            logDebugStyle(event.target);
            var styleAtPosition = event.target.getStyleAtPosition();

            setFontSize(event.target);
            setColorSelector(styleAtPosition, event.target);
            toggleStyleButtons(styleAtPosition, event.target);
            updateFontFamily(styleAtPosition, event.target);
        }
    }

    function isTextObjectBeingEdited(target) {
        return target && /text/.test(target.type) && target.isEditing;
    }

    function logDebugStyle(target) {
        if (DEBUG) {
            console.log("style at position", target.getStyleAtPosition());
        }
    }

    function setFontSize(target) {
        $("#fontsize").val((target.fontSize / 1.3).toFixed(0));
    }

    function setColorSelector(style, target) {
        var color = style.fill !== undefined ? style.fill : target.fill;
        $("#colorSelector").css("backgroundColor", color);
    }

    function toggleStyleButtons(style, target) {
        toggleButton("#fontbold", style.fontWeight, target.fontWeight, "bold");
        toggleButton("#fontitalic", style.fontStyle, target.fontStyle, "italic");
        toggleButton("#fontunderline", style.underline, target.underline, "underline");
    }

    function toggleButton(selector, styleProperty, targetProperty, expectedValue) {
        if (styleProperty !== undefined) {
            $(selector).toggleClass("active", styleProperty === expectedValue);
        } else {
            $(selector).toggleClass("active", targetProperty === expectedValue);
        }
    }

    function updateFontFamily(style, target) {
        var fontFamily = style.fontFamily !== undefined ? style.fontFamily : (target.fontFamily || "font7");
        var fontDisplayName = getFontDisplayName(fontFamily);
        updateFontDropdown(fontFamily, fontDisplayName);
    }

    function getFontDisplayName(fontFamily) {
        return $("#fonts-dropdown").find('a[data-ff="' + fontFamily + '"]').parent().find("span").text();
    }

    function updateFontDropdown(fontFamily, displayName) {
        var dropdownHtml = '<span style="overflow:hidden"><a href="#" style="font-family: ' + fontFamily + '" >' + displayName + '</a>&nbsp;&nbsp;<span class="caret"></span></span>';
        $("#font-selected").html(dropdownHtml);
        $("#font-dropdown").on("shown.bs.dropdown", function () {
            handleFontDropdownShown(fontFamily);
        });
    }

    function handleFontDropdownShown(fontFamily) {
        $("#fontSearch").focus();
        var positionTop = $('#fonts-dropdown li a[data-ff="' + fontFamily + '"]').position().top;
        var firstItemTop = $("#fonts-dropdown li:first").position().top;
        $("#fonts-dropdown").scrollTop(positionTop - firstItemTop);
        $("#fonts-dropdown li a").removeClass("font-selected");
        $('#fonts-dropdown li a[data-ff="' + fontFamily + '"]').addClass("font-selected");
    }


    canvas.observe("text:editing:entered", handleTextEditingEntered);

    function handleTextEditingEntered(event) {
        logDebugInfo("text:editing:entered first");

        enableControlsForSelectedObject();

        toggleUIElementsForEditing();

        setCursorColorToFill(event.target);

        adjustHiddenTextareaPosition(event.target);
    }

    function logDebugInfo(message) {
        if (DEBUG) {
            console.log(message);
        }
    }

    function enableControlsForSelectedObject() {
        selectedObject.hasControls = true;
    }

    function toggleUIElementsForEditing() {
        $("#group, #ungroup, #strokegroup, #clone, #showmoreoptions, #shadowGroup").hide();
    }

    function setCursorColorToFill(target) {
        target.set({ cursorColor: target.fill });
    }

    function adjustHiddenTextareaPosition(target) {
        var scaleValue = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1;
        var bodyRect = document.body.getBoundingClientRect();
        var offsetRect = (target.canvas.upperCanvasEl.getBoundingClientRect().top - bodyRect.top) / scaleValue;

        target.hiddenTextarea.style.cssText = "position: fixed !important; top: " + offsetRect + "px !important; left: 0px; opacity: 0; width: 0px; height: 0px; z-index: -999;";
    }


    canvas.on("mouse:over", handleMouseOver);

    function handleMouseOver(event) {
        if (isLineObject(event.target)) {
            enhanceTargetPadding(event.target);
        }
    }

    function isLineObject(target) {
        return target && target.type === "line";
    }

    function enhanceTargetPadding(target) {
        target.padding = 5;
        target.setCoords();
        canvas.renderAll();
    }


    // Assuming DEBUG is a global variable that controls debugging logs
    canvas.observe("text:editing:exited", handleTextEditingExited);

    function handleTextEditingExited(event) {
        logDebugInfo("MIGRATED>> text:editing:exited");

        removeEmptyText(event.target);

        showTextEditingOptions();
    }

    function logDebugInfo(message) {
        if (DEBUG) {
            console.log(message);
        }
    }

    function removeEmptyText(target) {
        if (target.text === "") {
            setTimeout(function () {
                canvas.remove(target);
            }, 0);
        }
    }

    function showTextEditingOptions() {
        $("#group, #ungroup, #strokegroup, #clone, #showmoreoptions, #shadowGroup").show();
    }

    $(document).ready(function () {
        $("body").mousedown(handleMouseDown);
    });

    function handleMouseDown(e) {
        var activeObject = canvas.getActiveObject();

        if (!activeObject) {
            handleNoActiveObject(e);
        }

        bindClickEventsForFillAndStroke();

        handleCloseDialogs(activeObject, e);

        handleCanvasClicks(e);
    }

    function handleNoActiveObject(e) {
        $(".tools-top").removeClass("toolbar-show");
        $(".patternFillTab").hide();
        $(".patternFillPreview").removeClass("open");
        if (e.target.nodeName !== "LI") {
            $(".custom-menu").hide();
        }
    }

    function bindClickEventsForFillAndStroke() {
        $("#filltype, .filltype, #strokedropdown").click(function () {
            $(".sp-container.color-fill, .sp-container.dynamic-fill, .sp-container.color-stroke").addClass("sp-hidden");
        });
    }

    function handleCloseDialogs(activeObject, e) {
        if (activeObject && activeObject.type === "image" && $(e.target).closest(".ui-dialog").length === 0) {
            $("#object-properties").dialog("close");
        }

        if (!activeObject || (!/text/.test(activeObject.type) && $(e.target).closest(".ui-dialog").length === 0)) {
            $("#font-symbols").dialog("close");
        }
    }

    function handleCanvasClicks(e) {
        if (e.target.nodeName !== "CANVAS" && e.target.nodeName === "DIV" && e.target.className !== "sp-preview" && !$(e.target).hasClass("sp-clear") && e.target.className.indexOf("sp-light") < 0 && e.target.className !== "sp-container" && e.target.className.indexOf("ui-dialog") < 0 && $(".dpattern-holder").has(e.target).length < 1 && $(".patternFillTab").has(e.target).length < 1 && $("#font-symbols").has(e.target).length < 1) {
            canvas.discardActiveObject().renderAll();
            $(".tools-top").removeClass("toolbar-show");
            $(".patternFillTab").hide();
            $(".patternFillPreview").removeClass("open");
            $("#font-symbols").dialog("close");
        }
    }

}

function handleTextObject(selectedObject) {
    // Check if the selected object is a text
    if (selectedObject.type === "textbox" || selectedObject.type === "text" || selectedObject.type === "i-text" || isTextsGroup()) {
        var fontFamily, fontSize;
        $(".textelebtns").show();
        toggleTextStyles(selectedObject);

        // Set text alignment
        setTextAlignment(selectedObject);

        // Additional conditions for multiline text
        handleMultilineText(selectedObject);

        // Set selection color and editing border color
        selectedObject.selectionColor = "rgba(0, 123, 240, 0.3)";
        selectedObject.editingBorderColor = "#4dd7fa";

        // Handle group text
        if (isTextsGroup()) {
            handleGroupText(selectedObject);
        } else {
            // Non-group text handling
            handleNonGroupText(selectedObject);
        }

        // Text styling UI
        setTextStylingUI(fontFamily, selectedObject);
    }
}

function toggleTextStyles(selectedObject) {
    // Toggle bold style
    if (selectedObject.fontWeight === "bold") {
        $("#fontbold").addClass("active");
    } else {
        $("#fontbold").removeClass("active");
    }

    // Toggle italic style
    if (selectedObject.fontStyle === "italic") {
        $("#fontitalic").addClass("active");
    } else {
        $("#fontitalic").removeClass("active");
    }

    // Toggle underline
    if (selectedObject.underline) {
        $("#fontunderline").addClass("active");
    } else {
        $("#fontunderline").removeClass("active");
    }
}

function setTextAlignment(selectedObject) {
    // Set text alignment buttons based on the selectedObject's textAlign property
    ["left", "center", "right"].forEach(alignment => {
        if (selectedObject.textAlign === alignment) {
            $(`#objectalign${alignment}`).addClass("active");
        } else {
            $(`#objectalign${alignment}`).removeClass("active");
        }
    });
}

function handleMultilineText(selectedObject) {
    // Handle the visibility of line height adjustment for multiline text
    if (selectedObject.type === "i-text") {
        const multiline = selectedObject._textLines.length;
        if (multiline > 1) {
            $("#lineheight").show();
        } else if (multiline === 1) {
            $("#lineheight").hide();
        }
    }
}

function handleGroupText(selectedObject) {
    // Handle text properties when the selectedObject is a group of texts
    $("#showObSymbolsPanel").hide();
    $("#textstylebtns").hide();
    $("#font-symbols").dialog("close");

    let fonts = [];
    let sizes = [];

    selectedObject.forEachObject(object => {
        fonts.push(object.fontFamily);
        sizes.push(object.fontSize / 1.3);
    });

    fonts = [...new Set(fonts)]; // Unique font families
    sizes = [...new Set(sizes)]; // Unique sizes

    return {
        fontFamily: fonts.length === 1 ? fonts[0] : "",
        fontSize: sizes.length === 1 ? sizes[0].toFixed(0) : "-"
    };
}

function handleNonGroupText(selectedObject) {
    // Handle text properties when the selectedObject is a single text element
    $("#showObSymbolsPanel").show();

    const fontFamily = selectedObject.fontFamily || "font7";
    const fontSize = selectedObject.type === "textbox" ? 
        (selectedObject.fontSize * selectedObject.scaleX / 1.3).toFixed(0) :
        Math.round(selectedObject.fontSize / 1.3) || 36;

    return { fontFamily, fontSize };
}

function setTextStylingUI(fontFamily, selectedObject) {
    // Update UI elements to reflect current text styles and properties
    const fontDisplayName = $("#fonts-dropdown").find(`a[data-ff="${fontFamily}"]`).parent().find("span").text() || "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $("#font-selected").html(`<span style="overflow:hidden"><a href="#" style="font-family: ${fontFamily}" >${fontDisplayName}</a>&nbsp;&nbsp;<span class="caret"></span></span>`);
    $("#fontsize").val(selectedObject.fontSize);

    setupSymbolsPanel(fontFamily);

    $("#font-dropdown").on("shown.bs.dropdown", function () {
        $("#fontSearch").focus();
        $("#fonts-dropdown").scrollTop($('#fonts-dropdown li a[data-ff="${fontFamily}"]').position().top - $("#fonts-dropdown li:first").position().top);
        $("#fonts-dropdown li a").removeClass("font-selected");
        $('#fonts-dropdown li a[data-ff="${fontFamily}"]').addClass("font-selected");
    });
}