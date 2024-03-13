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
});

function updateFontSizeForActiveObject(object, fontSize) {
    if (isObjectTextType(object)) {
        setFontSizeAndResetScale(object, fontSize);
    } else if (object.type === "textbox") {
        adjustFontSizeForTextbox(object, fontSize);
    } else if (isTextsGroup(object)) {
        adjustFontSizeForTextsGroup(object, fontSize);
    }
}

function isObjectTextType(object) {
    return object.type === "text" || object.type === "i-text";
}

function setFontSizeAndResetScale(object, fontSize) {
    object.set("fontSize", fontSize);
    object.scaleX = object.scaleY = 1;
    object.setCoords();
}

function adjustFontSizeForTextbox(textbox, fontSize) {
    textbox.set("fontSize", fontSize / textbox.scaleX);
    textbox.setCoords();
}

function isTextsGroup(object) {
    // Assuming isTextsGroup checks if the object is a group of text objects
    return object.type === "group" && object._objects && object._objects.every(obj => isObjectTextType(obj));
}

function adjustFontSizeForTextsGroup(group, fontSize) {
    group.forEachObject(child => {
        if (child.setSelectionStyles) child.removeStyle("fontSize");
        setFontSizeAndResetScale(child, fontSize);
    });

    group._restoreObjectsState();
    fabric.util.resetObjectTransform(group);
    group._calcBounds();
    group._updateObjectsCoords();
    group.setCoords();
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
            updateFontSizeForActiveObject(activeObject, fontSize);
            canvas.renderAll(); // Update the canvas only once after font size changes
        }
    };
}

function updateFontSizeForActiveObject(object, fontSize) {
    if (isTextTypeObject(object)) {
        adjustFontSizeForTextObject(object, fontSize);
    } else if (object.type === "textbox") {
        adjustFontSizeForTextbox(object, fontSize);
    } else if (isTextsGroup()) {
        adjustFontSizeForTextsGroup(object, fontSize);
    }
}

function isTextTypeObject(object) {
    return object.type === "text" || object.type === "i-text";
}

function adjustFontSizeForTextObject(object, fontSize) {
    object.set("fontSize", fontSize);
    resetObjectScale(object);
}

function adjustFontSizeForTextbox(object, fontSize) {
    object.set("fontSize", fontSize / object.scaleX); // Adjust for the object's scale
    object.setCoords();
}

function resetObjectScale(object) {
    object.scaleX = 1;
    object.scaleY = 1;
    object.setCoords();
}

function isTextsGroup() {
    // Placeholder for the actual implementation of isTextsGroup
    // Assuming it checks if the active object is a group of text objects
}

function adjustFontSizeForTextsGroup(group, fontSize) {
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
    if ($(container).data("infiniteScroll")) {
        $(container).empty(); // Clear the container's HTML
        $(container).infiniteScroll('destroy');
        $(container).masonry('destroy');
    }
}

function initializeMasonry(container) {
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

function initializeInfiniteScroll(container, masonryInstance, templateId) {
    $(container).infiniteScroll({
        path: () => `${appUrl}editor/${aMethod_related}/${templateId}?demo_as_id=${demo_as_id}&loadCount=${this.loadCount}&limit_related=${limit_related}`,
        responseType: "text",
        outlayer: masonryInstance,
        history: false, // Use false instead of !1 for clarity
        scrollThreshold: false // Use false instead of !1 for clarity
    });
}

function initMasonry_related(templateId) {
    logDebug("initMasonry_related()");
    templateId_related = templateId; // Assuming templateId_related is globally accessible

    destroyExistingInfiniteScrollAndMasonry(aContainer_related);

    // Initialize Masonry and store the instance
    infinites[type_related] = initializeMasonry(aContainer_related);
    masonrys[type_related] = infinites[type_related].data("masonry");

    // Initialize Infinite Scroll with the newly created Masonry instance
    initializeInfiniteScroll(aContainer_related, masonrys[type_related], templateId_related);

    // Assuming loadReadMore is a function defined elsewhere
    loadReadMore(aContainer_related, "loadTemplates_related");

    // Show the "read more" or equivalent button
    $(aContainer_related).next().find(".iscroll-button").show();
}


function logDebug(message) {
    if (DEBUG) { // Assuming DEBUG is a global flag
        console.log(message);
    }
}

function updateCanvasSize(canvas) {
    setCanvasWidthHeight(canvas.cwidth * canvas.getZoom(), canvas.cheight * canvas.getZoom());
    $("#loadCanvasWid").val(canvas.cwidth / 96);
    $("#loadCanvasHei").val(canvas.cheight / 96);
}

function applyCanvasBackgroundIfNeeded(canvas) {
    if (canvas.bgsrc) {
        setCanvasBg(canvas, canvas.bgsrc, "", canvas.bgScale);
    }
}

function updateHistoryControls(canvas) {
    if (canvas.$h_pos < 1) {
        $("#undo").hide();
        $("#autosave").data("saved", "yes");
    } else {
        $("#redo").show();
    }
}

function history_undo() {
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
    logDebugInfo("isImagesGroup()"); // Assuming logDebugInfo is a globally defined function for logging

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

function logDebugInfo(message) {
    if (DEBUG) { // Assuming DEBUG is a globally defined flag
        console.log(message);
    }
}

function logDebug(message) {
    if (DEBUG) {
        console.log(message);
    }
}

function destroyExistingMasonryAndInfiniteScroll(container) {
    if ($(container).data("infiniteScroll")) {
        $(container).html("");
        $(container).infiniteScroll('destroy');
        $(container).masonry('destroy');
    }
}

function initializeMasonry(container) {
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
    var tags = $(aSearch_bg).val() ? $(aSearch_bg).val().toString() : "";
    return `${appUrl}editor/${aMethod_bg}?loadCount=${this.loadCount}&limit_bg=${limit_bg}&tags=${tags}&design_as_id=${design_as_id}&demo_as_id=${demo_as_id}&loadedtemplateid=${loadedtemplateid}`;
}

function initializeInfiniteScroll(masonryInstance) {
    masonryInstance.infiniteScroll({
        path: generateInfiniteScrollPath,
        responseType: "text",
        outlayer: masonrys[type_bg],
        history: false,
        scrollThreshold: false
    });
}

function showScrollButton(container) {
    $(container).next().find(".iscroll-button").show();
}

function initMasonry_bg() {
    logDebug("MIGRATED:: initMasonry_bg()");

    destroyExistingMasonryAndInfiniteScroll(aContainer_bg);

    infinites[type_bg] = initializeMasonry(aContainer_bg);
    masonrys[type_bg] = infinites[type_bg].data("masonry");

    initializeInfiniteScroll(infinites[type_bg]);

    loadReadMore(aContainer_bg, "loadTemplates_bg");
    showScrollButton(aContainer_bg);
}

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
        DEBUG && console.log("Dpattern toObject", this);
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
        DEBUG && console.log("toDatalessJSON", this);
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
    return DEBUG && console.log("Dpattern fromObject", object),
    new fabric.Dpattern(object,callback)
}
;

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

