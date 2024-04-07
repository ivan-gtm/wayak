function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
    try {
        var info = gen[key](arg)
          , value = info.value
    } catch (error) {
        return void reject(error)
    }
    info.done ? resolve(value) : Promise.resolve(value).then(_next, _throw)
}
function _asyncToGenerator(fn) {
    return function() {
        var self = this
          , args = arguments;
        return new Promise(function(resolve, reject) {
            var gen = fn.apply(self, args);
            function _next(value) {
                asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value)
            }
            function _throw(err) {
                asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err)
            }
            _next(void 0)
        }
        )
    }
}
function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread()
}
function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
}
function _unsupportedIterableToArray(o, minLen) {
    if (o) {
        if ("string" == typeof o)
            return _arrayLikeToArray(o, minLen);
        var n = Object.prototype.toString.call(o).slice(8, -1);
        return "Object" === n && o.constructor && (n = o.constructor.name),
        "Map" === n || "Set" === n ? Array.from(o) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? _arrayLikeToArray(o, minLen) : void 0
    }
}
function _iterableToArray(iter) {
    if ("undefined" != typeof Symbol && Symbol.iterator in Object(iter))
        return Array.from(iter)
}
function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr))
        return _arrayLikeToArray(arr)
}
function _arrayLikeToArray(arr, len) {
    (null == len || len > arr.length) && (len = arr.length);
    for (var i = 0, arr2 = new Array(len); i < len; i++)
        arr2[i] = arr[i];
    return arr2
}
function _typeof(obj) {
    return (_typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(obj) {
        return typeof obj
    }
    : function(obj) {
        return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj
    }
    )(obj)
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
var canvasScale = 1, currentcanvasid = 0, canvasindex = 0, pageindex = 0, canvasarray = [], isdownloadpdf = !1, isupdatetemplate = !1, issaveastemplate = !1, totalsvgs = 0, convertedsvgs = 0, loadedtemplateid = 0, activeObjectCopy, keystring = "", remstring = "", savestatecount = 0, stopProcess = !1, templatesloading = !1, backgroundsLoading = !1, elementsLoading = !1, textsLoading = !1, rotationStep = 1, properties_to_save = Array("format", "patternSourceCanvas", "bgImg", "src", "svg_custom_paths", "hidden", "cwidth", "cheight", "locked", "selectable", "editable", "bg", "logoid", "evented", "id", "bgsrc", "bgScale", "lockMovementX", "lockMovementY"), isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0, isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor), isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor), s_history = !1, previewSvg, offsetTemplates = 0, offsetRelatedProducts = 0, offsetTexts = 0, offsetElements = 0, offsetBackgrounds = 0, template_type, geofilterBackground, instructionsId, svg_custom_data = [], localStorageKey = "templett.design", templateOptions, backgroundPromise, duplicatedTemplateId, lastShadowBlur, lastShadowHorizontalOffset, lastShadowVerticalOffset, lastShadowColor, historyTable, $fontUTF8Symbols = {}, $useKeepSvgGroups = !1, dontLoadFonts = [], DEBUG = 1, $copyOnePageAcrossSheet = !1;
fabric.Object.NUM_FRACTION_DIGITS = 10,
InfiniteScroll.prototype.loadNextPage = function() {
    if (!this.isLoading && this.canLoad) {
        var path = this.getAbsolutePath();
        this.isLoading = !0;
        var onLoad = function(response) {
            this.onPageLoad(response, path)
        }
        .bind(this)
          , onError = function(error) {
            this.onPageError(error, path)
        }
        .bind(this)
          , onLast = function(response) {
            this.lastPageReached(response, path)
        }
        .bind(this);
        request(path, this.options.responseType, onLoad, onError, onLast),
        this.dispatchEvent("request", null, [path])
    }
}
;
var request = function(url, responseType, onLoad, onError, onLast) {
    var req = new XMLHttpRequest;
    req.open("GET", url, !0),
    req.responseType = responseType || "",
    req.setRequestHeader("X-Requested-With", "XMLHttpRequest"),
    demo_as_id && "" != demoJwt && req.setRequestHeader("x-demo-templett-jwt", demoJwt),
    req.onload = function() {
        if (200 == req.status)
            onLoad(req.response);
        else if (204 == req.status)
            onLast(req.response);
        else {
            var error = new Error(req.statusText);
            onError(error)
        }
    }
    ,
    req.onerror = function() {
        var error = new Error("Network error requesting " + url);
        onError(error)
    }
    ,
    req.send()
};
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
var $spectrum_options = {
    containerClassName: "color-fill",
    togglePaletteOnly: !0,
    showPalette: !0,
    preferredFormat: "hex",
    hideAfterPaletteSelect: !0,
    showSelectionPalette: !0,
    localStorageKey: localStorageKey,
    showInput: !0,
    showInitial: !0,
    allowEmpty: !0,
    showButtons: !1,
    maxSelectionSize: 24,
    togglePaletteMoreText: "Show advanced",
    togglePaletteLessText: "Hide advanced",
    beforeShow: function(color) {
        $(this).spectrum("set", $(this).css("backgroundColor"))
    },
    show: function(color) {
        $(this).data("previous-color", color.toRgbString().replace(/\s/g, ""))
    }
};
function keepSvgGroups(objects, svgElements, allSvgElements, options) {
    if (void 0 !== $useKeepSvgGroups && !$useKeepSvgGroups)
        return fabric.util.groupSVGElements(objects, options);
    var $svgGroups = {}
      , loadedObjects = [];
    for (var i in allSvgElements)
        allSvgElements.hasOwnProperty(i) && ("g" !== allSvgElements[i].nodeName || allSvgElements[i].id || (allSvgElements[i].id = "tg" + Math.floor(1e4 * Math.random()) + 1));
    for (var j in $.each(svgElements, function(i, o) {
        o.parentNode && "g" === o.parentNode.tagName && ($svgGroups[o.parentNode.id] || ($svgGroups[o.parentNode.id] = []),
        $svgGroups[o.parentNode.id].push(objects[i]))
    }),
    $svgGroups) {
        var $svgGroup = fabric.util.groupSVGElements($svgGroups[j]);
        $svgGroup.set("fill", ""),
        $svgGroup.svg_custom_paths = [],
        loadedObjects.push($svgGroup)
    }
    return fabric.util.groupSVGElements(loadedObjects, options)
}
function getGradientTypeofObject($object) {
    if (!$object)
        return !1;
    if ($object.fill && "object" !== _typeof($object.fill))
        return !1;
    var $gradientDirection = !1;
    return $object.fill instanceof fabric.Gradient && (0 !== $object.fill.coords.y2 && ($gradientDirection = "linear-gradient-v-fill"),
    0 !== $object.fill.coords.x2 && ($gradientDirection = "linear-gradient-h-fill"),
    0 !== $object.fill.coords.x2 && 0 !== $object.fill.coords.y2 && ($gradientDirection = "linear-gradient-d-fill"),
    void 0 !== $object.fill.coords.r1 && ($gradientDirection = "radial-gradient-fill"),
    $gradientDirection)
}
function applyGradient($color1, $color2, $direction, $object) {
    if ($object || ($object = canvas.getActiveObject()),
    !$object)
        return !1;
    if (!$color1)
        return !1;
    if ("string" != typeof $color1)
        return !1;
    var $objH = $object.get("height")
      , $objW = $object.get("width")
      , $type = "linear"
      , x = 0
      , x1 = 0
      , y = 0
      , y1 = 0
      , r2 = 0;
    if ("object" === _typeof($object.fill) && $object.fill instanceof fabric.Gradient && "radial-gradient-fill" === $direction && $object.fill.colorStops.length > 1)
        $object.fill.colorStops[0].color = $color1,
        $color2 && ($object.fill.colorStops[1].color = $color2);
    else {
        switch ($color2 || ($color2 = "#" + ("000000" + ("0xffffff" ^ $color1.replace("#", "0x")).toString(16)).slice(-6)),
        $direction || ($direction = "linear-gradient-v-fill"),
        $direction) {
        default:
        case "linear-gradient-v-fill":
            y1 = $objH;
            break;
        case "linear-gradient-h-fill":
            x1 = $objW;
            break;
        case "linear-gradient-d-fill":
            x = -$objW,
            x1 = $objW,
            y = -$objH,
            y1 = $objH;
            break;
        case "radial-gradient-fill":
            r2 = $objW > $objH ? $objW / 2 : $objH / 2,
            x = $objW / 2,
            x1 = $objW / 2,
            y = $objH / 2,
            y1 = $objH / 2,
            $type = "radial"
        }
        $object.setGradient("fill", {
            x1: x,
            y1: y,
            x2: x1,
            y2: y1,
            r1: 0,
            r2: r2,
            type: $type,
            colorStops: {
                0: $color1,
                1: $color2
            }
        })
    }
    return $object.dirty = !0,
    canvas.renderAll(),
    DEBUG && console.log("applyGradient() ", $direction, $color1, $color2),
    !0
}
function applyGradient2(element, object) {
    if ("object" === _typeof(element.fill) && "linear" == element.fill.type) {
        var gradientParams = getGlobalGradient(element.fill.colorStops, element.fill.coords, "linear");
        object.setGradient("fill", gradientParams),
        object.set("dirty", !0),
        canvas.renderAll()
    }
    if ("object" === _typeof(element.fill) && "radial" == element.fill.type) {
        var _gradientParams = getGlobalGradient(element.fill.colorStops, element.fill.coords, "radial");
        object.setGradient("fill", _gradientParams),
        object.set("dirty", !0),
        canvas.renderAll()
    }
}
function getGlobalGradient(colorStops, coords, direction) {
    if (!colorStops)
        return !1;
    var type = "linear";
    "radial-gradient-fill" != direction && "radial" != direction || (type = "radial");
    var colorValues = {};
    return colorStops.forEach(function(color, index) {
        var key = null != color.offset ? color.offset : getOffsetKey(index, colorStops.length)
          , value = color;
        if (color.color && (value = color.color),
        null != color.opacity)
            if (-1 != value.indexOf("#")) {
                var hex = value.replace("#", "");
                value = "rgba(" + parseInt(hex.substring(0, 2), 16) + "," + parseInt(hex.substring(2, 4), 16) + "," + parseInt(hex.substring(4, 6), 16) + "," + color.opacity + ")"
            } else
                value = (value = value.replace("rgb", "rgba")).replace(")", "," + color.opacity + ")");
        colorValues[key] = value
    }),
    Object.assign({
        type: type,
        colorStops: colorValues
    }, coords)
}
function getOffsetKey(index, length) {
    return 0 == index ? 0 : index == length - 1 ? 1 : 1 / (length - 1) * index
}
function switchFillType($filltype, $color1, $color2, $target) {
    var $colorSelectorBox;
    DEBUG && console.log("switchFillType() $target: ", $target),
    DEBUG && console.log("switchFillType() $filltype: ", $filltype),
    $colorSelectorBox = $target ? $($target).parents(".colorSelectorBox") : $(".colorSelectorBox"),
    $filltype || ($filltype = $(".toolbar-top").find(".fill-type.active").attr("id")),
    $($colorSelectorBox).find(".fill-type").removeClass("active"),
    $($colorSelectorBox).find("#" + $filltype).addClass("active"),
    "pattern-fill" === $filltype ? ($(".patternFillGroup").show(),
    $("#colorSelector").hide()) : ($(".patternFillGroup").hide(),
    $("#colorSelector").show()),
    $color1 && "string" == typeof $color1 && !$color2 && ($color2 = ("000000" + ("0xffffff" ^ $color1.replace("#", "0x")).toString(16)).slice(-6)),
    "color-fill" === $filltype && ($($colorSelectorBox).find("#colorSelector2").hide(),
    $($colorSelectorBox).find("#colorSelector").css({
        "background-color": $color1,
        padding: "17px 19px"
    }),
    $colorSelectorBox.hasClass("group") && ($colorSelectorBox.find(".sp-preview").css({
        "background-color": $color1,
        padding: "17px 19px"
    }),
    $colorSelectorBox.find(".sp-light").css({
        width: "40px"
    }),
    $colorSelectorBox.find(".dynamiccolorpicker2").spectrum("destroy").hide())),
    ["linear-gradient-h-fill", "linear-gradient-v-fill", "linear-gradient-d-fill", "radial-gradient-fill"].indexOf($filltype) > -1 && ($($colorSelectorBox).find("#colorSelector2").show(),
    $color1 && "string" == typeof $color1 && $color2 && ($($colorSelectorBox).find("#colorSelector,#colorSelector2").css({
        "background-color": "transparent",
        padding: "17px 10px"
    }),
    $colorSelectorBox.hasClass("group") && ($colorSelectorBox.find(".sp-light,.sp-preview").css({
        "background-color": "transparent"
    }),
    $colorSelectorBox.find(".sp-light").css({
        padding: "17px 10px",
        width: "20px"
    })),
    $($colorSelectorBox).css({
        "background-image": "-webkit-linear-gradient(to right, " + $color1 + ", " + $color2 + ")"
    }),
    $($colorSelectorBox).css({
        "background-image": "-moz-linear-gradient(to right, " + $color1 + ", " + $color2 + ")"
    }),
    $($colorSelectorBox).css({
        "background-image": "-ms-linear-gradient(to right, " + $color1 + ", " + $color2 + ")"
    }),
    $($colorSelectorBox).css({
        "background-image": "-o-linear-gradient(to right, " + $color1 + ", " + $color2 + ")"
    }),
    $($colorSelectorBox).css({
        "background-image": "linear-gradient(to right, " + $color1 + ", " + $color2 + ")"
    }),
    $($colorSelectorBox).css({
        height: "36px"
    })))
}
function isSvg($object) {
    return DEBUG && console.log("isSvg()"),
    $object || ($object = canvas.getActiveObject()),
    !!$object && (!!$object.src && !!/\.sv?g/i.test($object.src))
}
function isElement($object) {
    var $return = !1;
    if (!$object)
        return !1;
    if (void 0 !== $object.svg_custom_paths)
        return !0;
    var $objects = $object.objects || $object._objects;
    return $objects && $.each($objects, function($i, $o) {
        if ("path" === $o.type || "path-group" === $o.type)
            return $return = !0,
            !1;
        "group" === $o.type && $.each($o.getObjects(), function($chi, $ch) {
            if ("path" === $ch.type || "path-group" === $ch.type)
                return $return = !0,
                !1
        })
    }),
    $return
}
function isTextsGroup() {
    if (!canvas.getActiveObject())
        return !1;
    var $return = !0;
    return canvas.getActiveObject()._objects || ($return = !1),
    canvas.getActiveObject()._objects && $.each(canvas.getActiveObject()._objects, function($i, $o) {
        /text/.test($o.type) || ($return = !1)
    }),
    $return
}
function isImagesGroup($object) {
    if ($object || ($object = canvas.getActiveObject()),
    !$object)
        return !1;
    var $return = !0;
    return $object._objects || ($return = !1),
    $object._objects && $.each($object._objects, function($i, $o) {
        /image/.test($o.type) || ("group" === $o.type ? $.each($o._objects, function($i, $c) {
            /image/.test($c.type) || ($return = !1)
        }) : $return = !1)
    }),
    $return
}
function save_history($force) {
    canvas.$history || (canvas.$history = [],
    canvas.$h_pos = -1);
    s_history && setTimeout(function() {
        canvas.cwidth = 96 * $("#loadCanvasWid").val(),
        canvas.cheight = 96 * $("#loadCanvasHei").val();
        var $data = canvas.toDatalessJSON(["locked"])
          , $c_state = JSON.stringify($data);
        (canvas.$history[canvas.$h_pos] != $c_state || $force) && (canvas.$history[++canvas.$h_pos] = $c_state,
        canvas.$history.length - 1 > canvas.$h_pos && (canvas.$history = canvas.$history.slice(0, canvas.$h_pos + 1))),
        canvas.$history.length > 100 && (canvas.$history = canvas.$history.slice(-100),
        canvas.$h_pos = canvas.$history.length - 1),
        DEBUG && console.log("saved. history length: " + canvas.$history.length + " history position: " + canvas.$h_pos),
        $("#redo").hide(),
        $("#undo").show(),
        $("#autosave").data("saved", "no"),
        document.getElementById("autosave").checked && canvas.$history.length % 9 == 0 && loadedtemplateid && ($.toast({
            text: "Auto saving template...",
            icon: "success",
            position: "top-right",
            hideAfter: 2e3
        }),
        isupdatetemplate = !0,
        s_history = !1,
        canvas.discardActiveObject().renderAll(),
        processSVGs(!0),
        $("#autosave").data("saved", "yes"))
    }, 10)
}
function history_redo() {
    canvas.$history.length > 0 && canvas.$history[canvas.$h_pos + 1] ? (s_history = !1,
    canvas.loadFromJSON(canvas.$history[--canvas.$h_pos], function() {
        setCanvasWidthHeight(canvas.cwidth * canvas.getZoom(), canvas.cheight * canvas.getZoom()),
        $("#loadCanvasWid").val(canvas.cwidth / 96),
        $("#loadCanvasHei").val(canvas.cheight / 96),
        canvas.bgsrc && setCanvasBg(canvas, canvas.bgsrc, "", canvas.bgScale),
        canvas.renderAll.bind(canvas)
    }),
    DEBUG && console.log("redo. history length: " + canvas.$history.length + " history position: " + canvas.$h_pos),
    s_history = !0,
    $("#undo").show()) : $("#redo").hide()
}
function history_undo() {
    canvas.$history[canvas.$h_pos - 1] && (s_history = !1,
    canvas.loadFromJSON(canvas.$history[--canvas.$h_pos], function() {
        setCanvasWidthHeight(canvas.cwidth * canvas.getZoom(), canvas.cheight * canvas.getZoom()),
        $("#loadCanvasWid").val(canvas.cwidth / 96),
        $("#loadCanvasHei").val(canvas.cheight / 96),
        canvas.bgsrc && setCanvasBg(canvas, canvas.bgsrc, "", canvas.bgScale),
        canvas.renderAll.bind(canvas),
        s_history = !0
    }),
    DEBUG && console.log("undo. history length: " + canvas.$history.length + " history position: " + canvas.$h_pos),
    $("#redo").show()),
    canvas.$h_pos < 1 && ($("#undo").hide(),
    $("#autosave").data("saved", "yes"))
}
function dataURItoBlob(dataURI) {
    for (var byteString = atob(dataURI.split(",")[1]), mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0], ab = new ArrayBuffer(byteString.length), ia = new Uint8Array(ab), i = 0; i < byteString.length; i++)
        ia[i] = byteString.charCodeAt(i);
    return new Blob([ab],{
        type: mimeString
    })
}
function setJpegDPI(dataURI) {
    var raw = atob(dataURI.split(",")[1])
      , mimeString = dataURI.split(",")[0]
      , HEX = "";
    for (i = 0; i < raw.length; i++) {
        var _hex = raw.charCodeAt(i).toString(16);
        HEX += 2 == _hex.length ? _hex : "0" + _hex
    }
    return HEX = (HEX = HEX.toUpperCase()).slice(0, 26) + "01012C012C" + HEX.slice(36),
    base64 = btoa(HEX.match(/\w{2}/g).map(function(a) {
        return String.fromCharCode(parseInt(a, 16))
    }).join("")),
    mimeString + "," + base64
}
function setPngDPI(dataURI) {
    var raw = atob(dataURI.split(",")[1])
      , mimeString = dataURI.split(",")[0]
      , HEX = "";
    for (i = 0; i < raw.length; i++) {
        var _hex = raw.charCodeAt(i).toString(16);
        HEX += 2 == _hex.length ? _hex : "0" + _hex
    }
    return HEX = (HEX = HEX.toUpperCase()).slice(0, 70) + "00097048597300000EC400000EC401952B0E1B0000" + HEX.slice(70),
    base64 = btoa(HEX.match(/\w{2}/g).map(function(a) {
        return String.fromCharCode(parseInt(a, 16))
    }).join("")),
    mimeString + "," + base64
}
function addFontToFabric(fontid) {
    if (fontid) {
        var path = window.location.origin;
        path || (path = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "")),
        getFontFilename(fontid).then(function(fontFilename) {
            fabric.fontPaths[fontid] = fontFilename
        })
    }
}
function getFontFilename(fontid) {
    return new Promise(function(resolve, reject) {
        var url = appUrl + "editor/get-woff-font-url?font_id=" + fontid;
        $.getJSON(url).done(function(data) {
            data.success ? resolve(data.url) : console.log("An error occurred while receiving the font filename: " + answer.msg)
        })
    }
    )
}
function IsJsonString(str) {
    try {
        JSON.parse(str)
    } catch (e) {
        return console.log(e),
        !1
    }
    return !0
}
function autoSave($element) {
    var $key = $($element).attr("id")
      , $val = $($element).is(":checked")
      , url = appUrl + "design/actions/saveSettings.php";
    $.getJSON(url, {
        key: $key,
        value: $val
    })
}
function loadSettings() {
    var url = appUrl + "editor/load-settings";
    $.getJSON(url).done(function($answer) {
        0 == $answer.err && $answer.data.forEach(function($setting, i) {
            $("#" + $setting.set_key).length && $("#" + $setting.set_key).prop("checked", eval($setting.set_value))
        })
    })
}
function addGrid(lcanvas) {
    if (void 0 === lcanvas && (lcanvas = canvasarray[currentcanvasid]),
    $("#gridbtn").hasClass("active")) {
        for (var n = lcanvas._objects.length; lcanvas._objects[--n]; )
            "grid" === lcanvas._objects[n].id && lcanvas.remove(lcanvas._objects[n]);
        return lcanvas.renderAll(),
        void $("#gridbtn").html("Show Grid").removeClass("active")
    }
    var i, line, gridWidth = lcanvas.get("width"), gridHeight = lcanvas.get("height"), lineOption = {
        stroke: "rgba(0,0,0,.2)",
        strokeWidth: 1,
        selectable: !1,
        strokeDashArray: [3, 3],
        id: "grid",
        hoverCursor: "null"
    }, lineOption2 = {
        stroke: "rgba(0,0,0,.2)",
        strokeWidth: 1,
        selectable: !1,
        id: "grid",
        hoverCursor: "null"
    };
    for (i = Math.ceil(gridWidth / 24); i--; )
        line = new fabric.Line([24 * i, 0, 24 * i, gridHeight],lineOption),
        lcanvas.add(line),
        lcanvas.sendToBack(line);
    for (i = Math.ceil(gridHeight / 24); i--; )
        line = new fabric.Line([0, 24 * i, gridWidth, 24 * i],lineOption),
        lcanvas.add(line),
        lcanvas.sendToBack(line);
    for (i = Math.ceil(gridWidth / 96); i--; )
        line = new fabric.Line([96 * i, 0, 96 * i, gridHeight],lineOption2),
        lcanvas.add(line),
        lcanvas.sendToBack(line);
    for (i = Math.ceil(gridHeight / 96); i--; )
        line = new fabric.Line([0, 96 * i, gridWidth, 96 * i],lineOption2),
        lcanvas.add(line),
        lcanvas.sendToBack(line);
    lcanvas.renderAll(),
    $("#gridbtn").html("Hide Grid").addClass("active")
}
function getFonts2($o, $fontFamily) {
    return DEBUG && console.log("getFonts2() fontFamily: " + $fontFamily),
    new Promise(function(resolve, reject) {
        $fontFamily ? dontLoadFonts.indexOf($fontFamily) > -1 ? (resolve({
            object: $o,
            font: $fontFamily
        }),
        setupSymbolsPanel($fontFamily)) : (WebFontConfig = {
            custom: {
                families: [$fontFamily],
                urls: [appUrl + "editor/get-css-fonts?templates=" + JSON.stringify($fontFamily)]
            },
            testStrings: {
                fontFamily: "AB"
            },
            active: function(a) {},
            loading: function() {
                DEBUG && console.log("loading")
            },
            inactive: function(f) {
                DEBUG && console.log("inactive")
            },
            fontloading: function(f) {
                DEBUG && console.log("fontloading " + f)
            },
            fontactive: function(f) {
                DEBUG && console.log("fontactive " + f),
                resolve({
                    object: $o,
                    font: f
                }),
                addFontToFabric(f),
                dontLoadFonts.push(f),
                setupSymbolsPanel(f)
            },
            fontinactive: function(f) {
                DEBUG && console.log("fontinactive" + f),
                reject({
                    object: $o,
                    font: f
                })
            }
        },
        WebFont.load(WebFontConfig)) : resolve({
            object: $o,
            font: ""
        })
    }
    )
}
function getFonts(e, fontFamily) {
    void 0 === fontFamily && (fontFamily = e.fontFamily);
    var families = [];
    "group" == e.type && e.forEachObject(function(child, i) {
        child.fontFamily && dontLoadFonts.indexOf(child.fontFamily) < 0 && families.push(child.fontFamily),
        $.isEmptyObject(child.styles) || $.each(child.styles, function($i, $line) {
            $.each($line, function($i, $style) {
                void 0 !== $style.fontFamily && dontLoadFonts.indexOf($style.fontFamily) < 0 && families.push($style.fontFamily)
            })
        })
    }),
    e.fontFamily && (dontLoadFonts.indexOf(e.fontFamily) < 0 && (DEBUG && console.log(e.fontFamily),
    families.push(e.fontFamily)),
    $.isEmptyObject(e.styles) || $.each(e.styles, function($i, $line) {
        $.each($line, function($i, $style) {
            void 0 !== $style.fontFamily && dontLoadFonts.indexOf($style.fontFamily) < 0 && families.push($style.fontFamily)
        })
    })),
    families.length ? (families = families.filter(function(value, index, self) {
        return self.indexOf(value) === index
    }),
    WebFontConfig = {
        custom: {
            families: families,
            urls: [appUrl + "editor/get-css-fonts?templates=" + JSON.stringify(families)]
        },
        testStrings: {
            fontFamily: "AB"
        },
        active: function(a) {},
        loading: function() {
            DEBUG && console.log("loading")
        },
        inactive: function() {
            DEBUG && console.log("inactive")
        },
        fontloading: function(f) {
            DEBUG && console.log("fontloading " + f)
        },
        fontactive: function(f) {
            DEBUG && console.log(a),
            "group" == e.type ? (e.forEachObject(function(ch) {
                -1 != ["textbox", "text", "i-text"].indexOf(ch.type) && f === ch.fontFamily && (fabric.charWidthsCache[f] = {},
                ch.__lineWidths = [],
                e.dirty = !0,
                ch.initDimensions())
            }),
            e._restoreObjectsState(),
            fabric.util.resetObjectTransform(e),
            e._calcBounds(),
            e._updateObjectsCoords(),
            e.setCoords()) : (e.__lineWidths = [],
            e.initDimensions()),
            DEBUG && console.log("font: " + f + " loaded"),
            fabric.charWidthsCache[f] = {},
            addFontToFabric(f),
            canvasarray[currentcanvasid].renderAll(),
            dontLoadFonts.push(f),
            e.dirty = !0,
            canvas.renderAll()
        },
        fontinactive: function() {
            DEBUG && console.log("fontinactive")
        }
    },
    WebFont.load(WebFontConfig)) : ("group" == e.type && (e._restoreObjectsState(),
    fabric.util.resetObjectTransform(e),
    e._calcBounds(),
    e._updateObjectsCoords(),
    e.setCoords()),
    canvasarray[currentcanvasid].renderAll())
}
function scale_canvas_to(width, height, $canvas) {
    s_history = !1;
    var canvas = $canvas || canvasarray[currentcanvasid]
      , width_scalefactor = width / canvas.get("width")
      , height_scalefactor = height / canvas.get("height");
    width_scalefactor == height_scalefactor && zoomIt(width_scalefactor, canvas),
    width_scalefactor < height_scalefactor && zoomIt(width_scalefactor, canvas),
    width_scalefactor > height_scalefactor && zoomIt(height_scalefactor, canvas),
    setCanvasWidthHeight(width, height);
    for (var i = 0; i <= pageindex; i++)
        adjustIconPos(i);
    initCenteringGuidelines(canvas),
    s_history = !0,
    save_history()
}
function set_canvas_size(width, height) {
    var canvas = canvasarray[currentcanvasid];
    width = parseInt(width),
    height = parseInt(height),
    width > 0 && height > 0 && (canvas.setWidth(width),
    canvas.setHeight(height),
    canvas.renderAll(),
    canvas.backgroundImage && set_canvas_bg(canvas.backgroundImage._element.src)),
    canvas.setDimensions()
}
function set_canvas_bg(img_url) {
    var canvas = canvasarray[currentcanvasid];
    fabric.Image.fromURL(img_url, function(img) {
        img.set({
            originX: "left",
            originY: "top"
        });
        var scalefactor = parseInt(canvas.width) / parseInt(img.get("width"));
        img.scale(scalefactor),
        canvas.get("height") > img.get("height") && img.scaleToHeight(canvas.get("height")),
        img.viewportCenter(),
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
            crossOrigin: "Anonymous"
        })
    })
}
function trim_canvas() {
    var canvas = canvasarray[currentcanvasid]
      , x = canvas.get("width")
      , y = canvas.get("height")
      , width = 0
      , height = 0;
    canvas._objects.forEach(function(obj, i) {
        var bound = obj.getBoundingRect();
        bound.left < x && (x = bound.left),
        bound.top < y && (y = bound.top),
        bound.left + bound.width > width && (width = bound.left + bound.width),
        bound.top + bound.height > height && (height = bound.top + bound.height)
    }),
    canvas._objects.forEach(function(obj, i) {
        obj.left = obj.left - x,
        obj.top = obj.top - y,
        obj.setCoords()
    }),
    canvas.width = width,
    canvas.height = height,
    setCanvasWidthHeight(width - x, height - y)
}
function zoomIt(factor, $canvas, $forceScale) {
    ($canvas = $canvas || canvasarray[currentcanvasid]).setHeight($canvas.get("height") * factor),
    $canvas.setWidth($canvas.get("width") * factor);
    var objects = $canvas.getObjects();
    for (var i in objects) {
        var tempScaleX = objects[i].scaleX * factor
          , tempScaleY = objects[i].scaleY * factor
          , tempLeft = objects[i].left * factor
          , tempTop = objects[i].top * factor;
        ($("#scale_with_size").is(":checked") || $forceScale) && (objects[i].scaleX = tempScaleX,
        objects[i].scaleY = tempScaleY,
        objects[i].left = tempLeft,
        objects[i].top = tempTop),
        objects[i].setCoords()
    }
    $canvas.bgsrc && setCanvasBg($canvas, $canvas.bgsrc, "", $canvas.bgScale),
    $canvas.renderAll()
}
function addheadingText() {
    if (hasCanvas()) {
        s_history = !1;
        var headingTxt = new fabric.Textbox("Heading",{
            fontFamily: selectedFont,
            fontSize: 36 * 1.3,
            textAlign: "center",
            fill: fillColor,
            scaleX: canvasScale,
            scaleY: canvasScale,
            lineHeight: 1,
            originX: "center",
            originY: "top"
        });
        "geofilter" != template_type && "geofilter2" != template_type || headingTxt.set({
            fontSize: 96 * 1.3
        }),
        canvas.discardActiveObject().renderAll(),
        canvas.add(headingTxt),
        headingTxt.viewportCenter(),
        headingTxt.setCoords(),
        setControlsVisibility(headingTxt),
        canvas.calcOffset(),
        canvas.renderAll(),
        canvas.setActiveObject(headingTxt),
        s_history = !0,
        save_history()
    }
}
function addText() {
    if (hasCanvas()) {
        s_history = !1;
        var txtBox = new fabric.Textbox("This is a text box",{
            fontFamily: selectedFont,
            fontSize: 12 * 1.3,
            textAlign: "center",
            fill: fillColor,
            scaleX: canvasScale,
            scaleY: canvasScale,
            lineHeight: 1.2,
            width: 200,
            fontWeight: "normal",
            originX: "center",
            originY: "top"
        });
        "geofilter" != template_type && "geofilter2" != template_type || txtBox.set({
            fontSize: 36 * 1.3
        }),
        canvas.discardActiveObject().renderAll(),
        canvas.add(txtBox),
        txtBox.viewportCenter(),
        txtBox.setCoords(),
        setControlsVisibility(txtBox),
        canvas.calcOffset(),
        canvas.renderAll(),
        canvas.setActiveObject(txtBox),
        s_history = !0,
        save_history()
    }
}
function addvLine() {
    s_history = !1;
    var line = new fabric.Line([50, 50, 50, 200],{
        scaleX: canvasScale,
        scaleY: canvasScale,
        stroke: fillColor,
        padding: 5,
        originX: "center",
        originY: "center"
    });
    line.on({
        scaling: function(e) {
            var w = this.width * this.scaleX
              , h = this.height * this.scaleY;
            this.strokeWidth;
            this.set({
                height: h,
                width: w,
                scaleX: 1,
                scaleY: 1
            })
        }
    }),
    canvas.discardActiveObject().renderAll(),
    canvas.add(line),
    setControlsVisibility(line),
    line.viewportCenter(),
    line.setCoords(),
    canvas.calcOffset(),
    canvas.renderAll(),
    canvas.setActiveObject(line),
    s_history = !0,
    save_history()
}
function addhLine() {
    s_history = !1;
    var line = new fabric.Line([50, 50, 50, 200],{
        scaleX: canvasScale,
        scaleY: canvasScale,
        stroke: fillColor,
        angle: 90,
        padding: 5,
        originX: "center",
        originY: "center"
    });
    line.on({
        scaling: function(e) {
            var w = this.width * this.scaleX
              , h = this.height * this.scaleY;
            this.strokeWidth;
            this.set({
                height: h,
                width: w,
                scaleX: 1,
                scaleY: 1
            })
        }
    }),
    canvas.discardActiveObject().renderAll(),
    canvas.add(line),
    setControlsVisibility(line),
    line.viewportCenter(),
    line.setCoords(),
    canvas.calcOffset(),
    canvas.renderAll(),
    canvas.setActiveObject(line),
    s_history = !0,
    save_history()
}
function addBorder() {
    s_history = !1;
    var border = new fabric.Rect({
        stroke: "rgb(0,0,0)",
        strokeWidth: 1,
        fill: "",
        opacity: 1,
        width: canvas.get("width") / canvas.getZoom() - 48,
        height: canvas.get("height") / canvas.getZoom() - 48
    });
    border.on({
        scaling: function(e) {
            var w = this.width * this.scaleX
              , h = this.height * this.scaleY;
            this.strokeWidth;
            this.set({
                height: h,
                width: w,
                scaleX: 1,
                scaleY: 1
            })
        }
    }),
    canvas.discardActiveObject().renderAll(),
    canvas.add(border),
    setControlsVisibility(border),
    border.viewportCenter(),
    border.setCoords(),
    canvas.calcOffset(),
    canvas.renderAll(),
    canvas.setActiveObject(border),
    s_history = !0,
    save_history()
}
function addPNGToCanvas(imagepath) {
    s_history = !1,
    fabric.Image.fromURL(imagepath, function(image) {
        var $imageSizes = image.getOriginalSize();
        "geofilter" != template_type && "geofilter2" != template_type && image.scaleToWidth($imageSizes.width / 3.125),
        canvas.discardActiveObject(),
        canvas.add(image),
        image.set({
            originX: "center",
            originY: "center"
        }),
        image.viewportCenter(),
        image.setCoords(),
        canvas.renderAll(),
        canvas.setActiveObject(image),
        appSpinner.hide(),
        s_history = !0,
        save_history()
    }, {
        crossOrigin: "Anonymous"
    })
}
function addJsonToCanvas(url) {
    s_history = !1,
    $.get(url, function(json) {
        for (var objects = json.objects, i = 0; i < objects.length; i++) {
            "activeSelection" == objects[i].type && (objects[i].type = "group"),
            fabric.util.getKlass(objects[i].type).fromObject(objects[i], function(img) {
                canvas.add(img),
                img.set({
                    originX: "center",
                    originY: "center"
                }),
                img.viewportCenter(),
                img.setCoords(),
                canvas.setActiveObject(img)
            })
        }
    }),
    appSpinner.hide(),
    s_history = !0,
    save_history()
}
function addSVGToCanvas(logosvgimg, svgoptions) {
    DEBUG && console.log("addSVGToCanvas"),
    s_history = !1,
    fabric.loadSVGFromURL(logosvgimg, function(objects, options, svgElements, allSvgElements) {
        var loadedObject = keepSvgGroups(objects, svgElements, allSvgElements, options);
        DEBUG && console.log("loadedObject: ", loadedObject),
        canvas.discardActiveObject().renderAll(),
        loadedObject.set({
            scaleX: canvasScale,
            scaleY: canvasScale,
            svg_custom_paths: [],
            width: options.width,
            height: options.height
        }),
        loadedObject.src = logosvgimg,
        loadedObject.clone(function(clone) {
            canvas.add(clone),
            clone.setCoords(),
            clone.get("width") > clone.get("height") && clone.get("width") > canvas.get("width") / canvas.getZoom() ? clone.scaleToWidth(canvas.get("width") / canvas.getZoom()) : clone.get("height") > canvas.get("height") / canvas.getZoom() && clone.scaleToHeight(canvas.get("height") / canvas.getZoom()),
            svgoptions && (clone.left = svgoptions.left,
            clone.top = svgoptions.top,
            clone.scaleX = svgoptions.scaleX,
            clone.scaleY = svgoptions.scaleY,
            clone.angle = svgoptions.angle,
            clone.flipX = svgoptions.flipX,
            clone.flipY = svgoptions.flipY),
            clone.set({
                originX: "center",
                originY: "center",
                src: logosvgimg,
                svg_custom_paths: []
            }),
            function removeClipPath($o) {
                delete $o.clipPath,
                $o._objects && $.each($o._objects, function($i, $child) {
                    return removeClipPath($child)
                })
            }(clone),
            clone.viewportCenter(),
            clone.setCoords(),
            clone.hasRotatingPoint = !0,
            canvas.renderAll(),
            canvas.setActiveObject(clone),
            appSpinner.hide(),
            s_history = !0,
            save_history()
        })
    })
}
function addUploadedSVGToCanvas(svgimg) {
    s_history = !1;
    var svgImgPath = "./uploads/" + svgimg;
    fabric.loadSVGFromURL(svgImgPath, function(objects, options, svgElements, allSvgElements) {
        var loadedObject = keepSvgGroups(objects, svgElements, allSvgElements, options);
        canvas.discardActiveObject().renderAll(),
        loadedObject.set({
            left: 200,
            top: 200,
            scaleX: canvasScale,
            scaleY: canvasScale
        }),
        loadedObject.src = svgImgPath,
        canvas.add(loadedObject),
        loadedObject.viewportCenter(),
        loadedObject.setCoords(),
        loadedObject.hasRotatingPoint = !0,
        canvas.renderAll(),
        canvas.setActiveObject(loadedObject),
        s_history = !0,
        save_history()
    })
}
function setControlsVisibility(object) {
    object.locked && !0 === object.locked || (object.setControlsVisibility({
        tl: !0,
        tr: !0,
        bl: !0,
        br: !0,
        mt: !0,
        mb: !0,
        ml: !0,
        mr: !0
    }),
    object.hasControls = !0)
}
function addCanvasToPage(dupflag, pageid, jsonarray) {
    s_history = !1;
    var rows = document.getElementById("numOfcanvasrows").value
      , cols = document.getElementById("numOfcanvascols").value;
    $(".deletecanvas").css("display", "block");
    var rc = parseInt(rows) * parseInt(cols) * parseInt(pageid)
      , dupcount = 0;
    $("#page" + pageindex).append("<table></table>");
    for (var i = 1; i <= rows; i++) {
        $("#page" + pageindex).find("table").last().append('<tr id="row' + i + '"></tr>');
        for (var j = 1; j <= cols; j++)
            if (addNewCanvas(i),
            dupflag) {
                var currentcanvasjson = canvasarray[rc + dupcount].toDatalessJSON(properties_to_save);
                canvas.loadFromJSON(currentcanvasjson, function($srcCanvasId, $desCanvasId) {
                    setTimeout(function() {
                        canvasarray[$srcCanvasId].forEachObject(function($o, $i) {
                            "group" === $o.type && normalizeSvgScale($o, canvasarray[$desCanvasId]._objects[$i])
                        })
                    }, 10)
                }(rc + dupcount, currentcanvasid)),
                dupcount++
            }
    }
    for (i = 0; canvasarray[i]; )
        canvasarray[i].setDimensions(),
        canvasarray[i++].renderAll();
    var pagenumbericon = $("#pagenumber").clone(!0).prop("id", "pagenumber" + pageindex)
      , dupcanvicon = $("#duplicatecanvas").clone(!0).prop("id", "duplicatecanvas" + pageindex)
      , delcanvicon = $("#deletecanvas").clone(!0).prop("id", "deletecanvas" + pageindex);
    if (pagenumbericon.appendTo("#page" + pageindex),
    dupcanvicon.appendTo("#page" + pageindex),
    delcanvicon.appendTo("#page" + pageindex),
    "geofilter" == template_type || "geofilter2" == template_type) {
        var arrowleft = $(".background-arrow-right").clone(!0)
          , arrowright = $(".background-arrow-left").clone(!0);
        arrowleft.appendTo("#page" + pageindex),
        arrowright.appendTo("#page" + pageindex)
    }
    var pages = $(".page:visible");
    $.each(pages, function(key, page) {
        adjustIconPos($(page).prop("id").replace("page", ""))
    }),
    $("#addnewpagebutton").show(),
    $("#saveimage").show(),
    $("#savetemplate").show(),
    $(".download-menu").show(),
    $(".download-dropdown").show(),
    $(".zoom-control").show(),
    $("#options").show(),
    $("#choose-img").hide(),
    $(".sidebar-elements li:not(#relatedProductsPane) a").removeClass("invisible"),
    canvasindex > 10 ? $(".download-jpeg-menu-item").hide() : $(".download-jpeg-menu-item").show(),
    s_history = !0,
    updatePageNumbers(),
    demo_as_id && "geofilter" != template_type && "geofilter2" != template_type && setDemoOverlay(),
    "geofilter2" == template_type && setGeofilterOverlay()
}
function setCanvasSize() {
    var width = document.getElementById("loadCanvasWid").value
      , height = document.getElementById("loadCanvasHei").value;
    setCanvasWidthHeight(width *= 96, height *= 96),
    adjustIconPos(pageindex),
    $("#canvaswh_modal").modal("hide"),
    $(".deletecanvas").css("display", "none")
}
function addFileToCanvas(imagefile) {
    fabric.util.loadImage("./uploads/" + imagefile, function(img) {
        var object = new fabric.Cropzoomimage(img,{
            scaleX: canvasScale / 2,
            scaleY: canvasScale / 2
        });
        object.src = "uploads/" + imagefile,
        canvas.add(object),
        canvas.setActiveObject(object),
        object.viewportCenter(),
        object.setCoords(),
        setControlsVisibility(object),
        appSpinner.hide(),
        canvas.renderAll()
    }, {
        crossOrigin: ""
    })
}
function setCanvasBg(lcanvas, bgsrc, bgcolor, scalex, id, setZoom) {
    backgroundPromise = new Promise(function(resolve, reject) {
        if (setZoom = setZoom || 0,
        scalex || ($("#bgscale").val(100),
        scalex = .32 / fabric.devicePixelRatio),
        bgcolor)
            $("#bgcolorselect").spectrum("set", bgcolor),
            lcanvas.backgroundImage = "",
            lcanvas.setBackgroundColor(bgcolor, function() {
                lcanvas.renderAll(),
                lcanvas.bgsrc = ""
            }),
            resolve();
        else if (bgsrc) {
            $("#bgcolorselect").spectrum("set", ""),
            lcanvas.bgsrc = bgsrc,
            lcanvas.bgScale = scalex;
            $("#loadCanvasWid").val(),
            $("#loadCanvasHei").val();
            var scale = parseFloat($("#zoomperc").data("scaleValue"));
            getBg(lcanvas, scalex * scale).then(function($bg) {
                lcanvas.setBackgroundColor($bg, function() {
                    if (lcanvas.bgImg) {
                        var $sc = scalex * scale / 3.125 / fabric.devicePixelRatio;
                        lcanvas.bgImg.scale($sc),
                        setZoom && autoZoom()
                    }
                    lcanvas.renderAll(),
                    resolve()
                })
            }).catch(function($res) {
                reject($res),
                console.log($res)
            }),
            save_history()
        } else
            resolve()
    }
    )
}
function deleteCanvasBg(lcanvas) {
    lcanvas.backgroundImage = "",
    lcanvas.backgroundColor = "",
    lcanvas.bgsrc = "",
    lcanvas.bgImg = "",
    lcanvas.renderAll(),
    save_history()
}
function setStyle(object, styleName, value) {
    if (object && object.setSelectionStyles && object.isEditing) {
        var style = {};
        style[styleName] = value,
        object.selectionStart === object.selectionEnd || 0 === object.selectionStart && object.selectionEnd === object.text.length ? (object.removeStyle(styleName),
        object[styleName] = value,
        "fontFamily" == styleName && $("#font-dropdown").on("shown.bs.dropdown", function() {
            $("#fontSearch").focus(),
            $("#fonts-dropdown").scrollTop($('#fonts-dropdown li a[data-ff="' + value + '"]').position().top - $("#fonts-dropdown li:first").position().top),
            $("#fonts-dropdown li a").removeClass("font-selected"),
            $('#fonts-dropdown li a[data-ff="' + value + '"]').addClass("font-selected")
        })) : ($.isEmptyObject(object.getSelectionStyles()) ? ($.isEmptyObject(object.getStyleAtPosition()) || object.getStyleAtPosition()[styleName] !== value || "fill" === styleName || (style[styleName] = ""),
        object.setSelectionStyles(style, object.selectionStart, object.selectionEnd)) : $.each(object.getSelectionStyles(), function($i, $s) {
            void 0 !== $s[styleName] && $s[styleName] === value && "fill" !== styleName ? $s[styleName] = "" : $s[styleName] = value,
            object.setSelectionStyles($s, object.selectionStart + $i, object.selectionStart + 1 + $i)
        }),
        "fontFamily" === styleName && object.setSelectionStyles(style, object.selectionStart, object.selectionEnd))
    } else
        object && (object.setSelectionStyles && object.removeStyle(styleName),
        object[styleName] = value,
        "fontFamily" == styleName && $("#font-dropdown").on("shown.bs.dropdown", function() {
            $("#fontSearch").focus(),
            $("#fonts-dropdown").scrollTop($('#fonts-dropdown li a[data-ff="' + value + '"]').position().top - $("#fonts-dropdown li:first").position().top),
            $("#fonts-dropdown li a").removeClass("font-selected"),
            $('#fonts-dropdown li a[data-ff="' + value + '"]').addClass("font-selected")
        }));
    object.dirty = !0,
    canvas.renderAll(),
    save_history()
}
$("body").on("click", ".fill-type", function(e) {
    e.preventDefault();
    var $color1, $color2, $activeObject = canvas.getActiveObject(), $colorSelectorBox = $(this).parents(".colorSelectorBox"), $filltype = $(this).attr("id"), $cpicker = $colorSelectorBox.find(".dynamiccolorpicker"), $cpicker2 = $colorSelectorBox.find(".dynamiccolorpicker2.showElement"), $oldFilltype = $colorSelectorBox.data("gradient-type");
    if ($color1 = $cpicker.length ? $cpicker.spectrum("get").toRgbString().replace(/\s/g, "") : "#000000",
    DEBUG && console.log($cpicker2),
    $cpicker2.length && ($color2 = $cpicker2.spectrum("get").toRgbString().replace(/\s/g, "")),
    $activeObject) {
        if ("group" === $activeObject.type && $activeObject._objects)
            $.each($activeObject._objects, function($i, $o) {
                "color-fill" === $filltype ? "color-fill" !== $oldFilltype && (!$o.fill || "object" !== _typeof($o.fill) || "linear" !== $o.fill.type && "radial" !== $o.fill.type || (DEBUG && console.log(".fill-type: oldFilltype!==color-fill :", $color1, $color2, $o.fill),
                DEBUG && console.log(".fill-type: oldFilltype!==color-fill :", $o.fill.colorStops[0].color === $color1),
                DEBUG && console.log(".fill-type: oldFilltype!==color-fill :", $o.fill.colorStops[1].color === $color2),
                $o.fill.colorStops[0].color === $color1 && $o.fill.colorStops[1].color === $color2 && (DEBUG && console.log("match!"),
                $o.set("fill", "#" + new fabric.Color($color1).toHex().toLowerCase()),
                $o.dirty = !0))) : "color-fill" === $oldFilltype ? ($color1 = "#" + new fabric.Color($color1).toHex().toLowerCase(),
                $color2 = "#" + ("000000" + ("0xffffff" ^ $color1.replace("#", "0x")).toString(16)).slice(-6),
                DEBUG && console.log(".fill-type: oldFilltype===color-fill :", $color1, $color2, $o.fill),
                "string" == typeof $o.fill && $o.fill.toLowerCase() === $color1.toLowerCase() && (DEBUG && console.log("match!"),
                ["linear-gradient-h-fill", "linear-gradient-v-fill", "linear-gradient-d-fill", "radial-gradient-fill"].indexOf($filltype) > -1 && applyGradient($color1, $color2, $filltype, $o),
                "pattern-fill" === $filltype && setDynamicPattern($o, $(".tiles_block").find(".pattern_tile").first().data("imgsrc")))) : !$o.fill || "object" !== _typeof($o.fill) || "linear" !== $o.fill.type && "radial" !== $o.fill.type || $o.fill.colorStops[0].color === $color1 && $o.fill.colorStops[1].color === $color2 && applyGradient($color1, $color2, $filltype, $o)
            });
        else if ("string" == typeof $activeObject.fill && ("Black" === ($color1 = $activeObject.fill) && ($color1 = "#000000"),
        $color2 = "#" + ("000000" + ("0xffffff" ^ $color1.replace("#", "0x")).toString(16)).slice(-6),
        $("#colorSelector2").spectrum("set", $color2)),
        "object" === _typeof($activeObject.fill) && ($activeObject.fill instanceof fabric.Gradient && $activeObject.fill.colorStops && ($color1 = "#" + new fabric.Color($activeObject.fill.colorStops[0].color).toHex(),
        $color2 = "#" + new fabric.Color($activeObject.fill.colorStops[1].color).toHex()),
        DEBUG && console.log(".fill-type click: color1,color2:", $color1, $color2)),
        DEBUG && console.log(".fill-type click: filltype,color1,color2:", $filltype, $color1, $color2),
        "color-fill" === $filltype && $activeObject.set("fill", $color1),
        ["linear-gradient-h-fill", "linear-gradient-v-fill", "linear-gradient-d-fill", "radial-gradient-fill"].indexOf($filltype) > -1 && applyGradient($color1, $color2, $filltype),
        "pattern-fill" === $filltype)
            setDynamicPattern($activeObject, $(".tiles_block").find(".pattern_tile").first().data("imgsrc"));
        switchFillType($filltype, $color1, $color2, e.target),
        canvas.discardActiveObject(),
        canvas.setActiveObject($activeObject),
        canvas.renderAll()
    }
}),
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
fabric.Image.prototype.getSvgSrc = fabric.Image.prototype.getSrc,
$("#deleterow,#deletecolumn").click(function(e) {
    e.preventDefault();
    var jsonCanvasArray = []
      , width = document.getElementById("loadCanvasWid").value
      , height = document.getElementById("loadCanvasHei").value
      , rows = document.getElementById("numOfcanvasrows").value
      , cols = document.getElementById("numOfcanvascols").value
      , $new_rows = rows
      , $new_cols = cols;
    if (1 !== rows && 1 !== cols) {
        $(e.currentTarget).hasClass("deleterow") && ($new_rows = parseInt(rows) - 1,
        $("#canvaspages .page:visible table tr:last-child").hide()),
        $(e.currentTarget).hasClass("deletecolumn") && ($new_cols = parseInt(cols) - 1,
        $("#canvaspages .page:visible table tr td:last-child").hide());
        var wh = '{"width": ' + (width *= 96) + ', "height": ' + (height *= 96) + ', "rows": ' + $new_rows + ', "cols": ' + $new_cols + "}";
        jsonCanvasArray.push(wh);
        for (var i = 0; i < canvasindex; i++)
            canvasarray[i] && "object" === _typeof(canvasarray[i]) && (canvasarray[i].discardActiveObject().renderAll(),
            $("#divcanvas" + i).is(":visible") && jsonCanvasArray.push(canvasarray[i].toDatalessJSON(properties_to_save)));
        openTemplate(JSON.stringify(jsonCanvasArray))
    }
}),
$("#addrow,#addcolumn").click(function(e) {
    e.preventDefault();
    var $ids, jsonCanvasArray = [], width = document.getElementById("loadCanvasWid").value, height = document.getElementById("loadCanvasHei").value, rows = document.getElementById("numOfcanvasrows").value, cols = document.getElementById("numOfcanvascols").value, $new_rows = rows, $new_cols = cols;
    $(e.currentTarget).hasClass("addrow") && ($new_rows = parseInt(rows) + 1,
    $ids = [],
    $("#canvaspages .page:visible table tr:last-child td:last-child").each(function(o, i) {
        var $id = this.id.replace("divcanvas", "");
        $ids.push($id)
    }),
    $ids.reverse().forEach(function($v, $i) {
        for ($c = 1; $c <= cols; $c++) {
            var $pos = parseInt($v) + $c;
            canvasarray.splice($pos, 0, "{}"),
            canvasindex++
        }
    })),
    $(e.currentTarget).hasClass("addcolumn") && ($new_cols = parseInt(cols) + 1,
    $ids = [],
    $("#canvaspages .page:visible table tr td:last-child").each(function(o, i) {
        var $id = this.id.replace("divcanvas", "");
        $ids.push($id)
    }),
    $ids.reverse().forEach(function($v, $i) {
        var $pos = parseInt($v) + 1;
        canvasarray.splice($pos, 0, '{"background":"#ffffff"}'),
        canvasindex++
    }));
    var wh = '{"width": ' + (width *= 96) + ', "height": ' + (height *= 96) + ', "rows": ' + $new_rows + ', "cols": ' + $new_cols + "}";
    jsonCanvasArray.push(wh);
    for (var i = 0; i < canvasindex; i++)
        canvasarray[i] && ("object" === _typeof(canvasarray[i]) ? !$("#divcanvas" + i).is(":visible") && $("#divcanvas" + i) || jsonCanvasArray.push(canvasarray[i].toDatalessJSON(properties_to_save)) : jsonCanvasArray.push(canvasarray[i]));
    openTemplate(JSON.stringify(jsonCanvasArray))
}),
$("#templatesearch").on("keypress", function(e) {
    if (13 === e.which) {
        $(this).val().match(/\w+/g).toString();
        $("#a").scrollTop(0),
        initMasonry_template(),
        loadTemplates_template()
    }
}),
$("#textsearch").on("keypress", function(e) {
    if (13 === e.which) {
        $(this).val().match(/\w+/g).toString();
        $("#b").scrollTop(0),
        initMasonry_text(),
        loadTemplates_text()
    }
}),
$("#elementssearch").on("keypress", function(e) {
    if (13 === e.which) {
        $(this).val().match(/\w+/g).toString();
        initMasonry_element(),
        loadTemplates_element()
    }
}),
$("#bgsearch").on("keypress", function(e) {
    if (13 === e.which) {
        $(this).val().match(/\w+/g).toString();
        initMasonry_bg(),
        loadTemplates_bg()
    }
}),
$("#template_container").on("click", ".thumbnail", function() {
    jQuery(this).data("target") && loadTemplate(jQuery(this).data("target"))
}),
$("#catimage_container").on("click", ".thumbnail", function() {
    jQuery(this).data("target") && loadElement(jQuery(this).data("target"))
}),
$("#text_container").on("click", ".thumbnail", function() {
    jQuery(this).data("target") && loadText(jQuery(this).data("target"))
}),
$(window).bind("beforeunload", function() {
    if ("yes" !== $("#autosave").data("saved") && 0 === demo_as_id)
        return "You have unsaved changes!"
}),
$("input[name=metric_units1]").change(function() {
    $("input[name=metric_units]").val([this.value]);
    var $canvas_width_inches = parseFloat($("#loadCanvasWid").val())
      , $canvas_height_inches = parseFloat($("#loadCanvasHei").val());
    switch (this.value) {
    case "in":
        $(".canvas_size_inches").addClass("active"),
        $(".canvas_size_pixels").removeClass("active"),
        $(".canvas_size_mm").removeClass("active");
        break;
    case "px":
        $("#loadCanvasWidthPx").val(Math.round(96 * $canvas_width_inches * 3.125)),
        $("#loadCanvasHeightPx").val(Math.round(96 * $canvas_height_inches * 3.125)),
        $(".canvas_size_pixels").addClass("active"),
        $(".canvas_size_inches").removeClass("active"),
        $(".canvas_size_mm").removeClass("active");
        break;
    case "mm":
        $("#loadCanvasWidthMm").val(Number((25.4 * $canvas_width_inches).toFixed(2))),
        $("#loadCanvasHeightMm").val(Number((25.4 * $canvas_height_inches).toFixed(2))),
        $(".canvas_size_pixels").removeClass("active"),
        $(".canvas_size_inches").removeClass("active"),
        $(".canvas_size_mm").addClass("active")
    }
}),
$("#loadCanvasWidthPx").change(function() {
    $("#loadCanvasWid").val(Number(Number(parseFloat($(this).val()) / 96 / 3.125).toFixed(3)))
}),
$("#loadCanvasHeightPx").change(function() {
    $("#loadCanvasHei").val(Number(Number(parseFloat($(this).val()) / 96 / 3.125).toFixed(3)))
}),
$("#loadCanvasWidthMm").change(function() {
    $("#loadCanvasWid").val(Number(Number(parseFloat($(this).val()) / 25.4).toFixed(3)))
}),
$("#loadCanvasHeightMm").change(function() {
    $("#loadCanvasHei").val(Number(Number(parseFloat($(this).val()) / 25.4).toFixed(3)))
}),
$("input[name=metric_units]").change(function() {
    $("input[name=metric_units1]").val([this.value]);
    var $canvas_width_inches = parseFloat($("#new_canvas_width").val())
      , $canvas_height_inches = parseFloat($("#new_canvas_height").val());
    switch (this.value) {
    case "in":
        $(".canvas_size_inches").addClass("active"),
        $(".canvas_size_pixels").removeClass("active"),
        $(".canvas_size_mm").removeClass("active");
        break;
    case "px":
        $("#new_canvas_width_pixels").val(Math.round(96 * $canvas_width_inches * 3.125)),
        $("#new_canvas_height_pixels").val(Math.round(96 * $canvas_height_inches * 3.125)),
        $(".canvas_size_pixels").addClass("active"),
        $(".canvas_size_inches").removeClass("active"),
        $(".canvas_size_mm").removeClass("active");
        break;
    case "mm":
        $("#new_canvas_width_mm").val(Number((25.4 * $canvas_width_inches).toFixed(2))),
        $("#new_canvas_height_mm").val(Number((25.4 * $canvas_height_inches).toFixed(2))),
        $(".canvas_size_pixels").removeClass("active"),
        $(".canvas_size_inches").removeClass("active"),
        $(".canvas_size_mm").addClass("active")
    }
}),
$("#new_canvas_width_pixels").change(function() {
    $("#new_canvas_width").val(Number(Number(parseFloat($(this).val()) / 96 / 3.125).toFixed(3)))
}),
$("#new_canvas_height_pixels").change(function() {
    $("#new_canvas_height").val(Number(Number(parseFloat($(this).val()) / 96 / 3.125).toFixed(3)))
}),
$("#new_canvas_width_mm").change(function() {
    $("#new_canvas_width").val(Number(Number(parseFloat($(this).val()) / 25.4).toFixed(3)))
}),
$("#new_canvas_height_mm").change(function() {
    $("#new_canvas_height").val(Number(Number(parseFloat($(this).val()) / 25.4).toFixed(3)))
}),
$(".textPane").click(function(e) {
    e.preventDefault(),
    !$("#text_container .thumb").last().attr("id") && $("body").hasClass("admin") && (initMasonry_text(),
    loadTemplates_text())
}),
$(".elementsPane").click(function(e) {
    e.preventDefault(),
    $("#catimage_container .thumb").last().attr("id") || (initMasonry_element(!0),
    loadTemplates_element())
}),
$(".bgPane").click(function(e) {
    e.preventDefault();
    $("#background_container .thumb").last().attr("id");
    initMasonry_bg(),
    loadTemplates_bg()
}),
$("#gridbtn").on("click", function() {
    addGrid()
}),
$("#bgscale").on("slide", function(slideEvt) {
    var $csv = $("#bgscale").data("cachedVal")
      , $zoom = canvas.getZoom() || 1
      , $sv = slideEvt.value / 100 / 3.125 / fabric.devicePixelRatio * $zoom;
    $csv !== $sv && ($("#bgscale").data("cachedVal", $sv),
    canvas.bgImg && canvas.bgImg.scale($sv),
    canvas.renderAll())
}),
$("#bgscale").on("slideStop", function(slideEvt) {
    canvas.bgScale = slideEvt.value / 100
}),
$("#fontbold").click(function(e) {
    e.preventDefault();
    var activeObject = canvas.getActiveObject()
      , fontBoldValue = "";
    if (activeObject)
        fontBoldValue = "normal" === activeObject.fontWeight ? "bold" : "normal",
        activeObject && /text/.test(activeObject.type) && (setStyle(activeObject, "fontWeight", fontBoldValue),
        $("#fontbold").toggleClass("active"));
    else {
        var groupObjects = canvas.getActiveObject()._objects;
        fontBoldValue = "normal" === groupObjects[0].fontWeight ? "bold" : "normal",
        $.each(groupObjects, function(object_i, object) {
            object && /text/.test(object.type) && setStyle(object, "fontWeight", fontBoldValue)
        })
    }
    canvas.renderAll()
}),
$("#fontitalic").click(function(e) {
    e.preventDefault();
    var activeObject = canvas.getActiveObject()
      , fontItalicValue = "";
    if (activeObject)
        fontItalicValue = "italic" === activeObject.fontStyle ? "" : "italic",
        activeObject && /text/.test(activeObject.type) && (setStyle(activeObject, "fontStyle", fontItalicValue),
        $("#fontitalic").toggleClass("active"));
    else {
        var groupObjects = canvas.getActiveObject()._objects;
        fontItalicValue = "italic" === groupObjects[0].fontStyle ? "" : "italic",
        $.each(groupObjects, function(object_i, object) {
            object && /text/.test(object.type) && setStyle(object, "fontStyle", fontItalicValue)
        })
    }
    canvas.renderAll()
}),
$("#fontunderline").click(function(e) {
    e.preventDefault();
    var activeObject = canvas.getActiveObject()
      , fontUnderlineValue = "";
    if (activeObject)
        fontUnderlineValue = "underline" === activeObject.underline ? "" : "underline",
        activeObject && /text/.test(activeObject.type) && (setStyle(activeObject, "underline", fontUnderlineValue),
        $("#fontunderline").toggleClass("active"));
    else {
        var groupObjects = canvas.getActiveObject()._objects;
        fontUnderlineValue = "underline" === groupObjects[0].underline ? "" : "underline",
        $.each(groupObjects, function(object_i, object) {
            object && /text/.test(object.type) && setStyle(object, "underline", fontUnderlineValue)
        })
    }
    canvas.renderAll()
});
var fontSizeSwitch = document.getElementById("fontsize");
fontSizeSwitch && (fontSizeSwitch.onchange = function() {
    this.value > 500 && (this.value = 500),
    this.value < 6 && (this.value = 6);
    var fontsize = Math.round(1.3 * this.value.toLowerCase())
      , activeObject = canvas.getActiveObject();
    activeObject && ("text" != activeObject.type && "i-text" != activeObject.type || (activeObject.set("fontSize", fontsize),
    activeObject.scaleX = 1,
    activeObject.scaleY = 1,
    activeObject.setCoords()),
    "textbox" == activeObject.type && (activeObject.set("fontSize", fontsize / activeObject.scaleX),
    activeObject.setCoords()),
    activeObject.setSelectionStyles && activeObject.removeStyle("fontSize"),
    isTextsGroup() && activeObject._objects && (activeObject.forEachObject(function(ch) {
        ch.setSelectionStyles && ch.removeStyle("fontSize"),
        ch.set("fontSize", fontsize),
        ch.scaleX = 1,
        ch.scaleY = 1
    }),
    activeObject._restoreObjectsState(),
    fabric.util.resetObjectTransform(activeObject),
    activeObject._calcBounds(),
    activeObject._updateObjectsCoords(),
    activeObject.setCoords()),
    canvas.renderAll())
}
);
var ChangeLineHeight = function() {
    s_history = !1,
    setStyle(canvas.getActiveObject(), "lineHeight", clh.getValue()),
    canvas.renderAll()
}
  , clh = $("#changelineheight").slider().on("slide", ChangeLineHeight).data("slider");
$("#changelineheight").slider().on("slideStop", function(e) {
    s_history = !0,
    save_history()
});
var ChangeCharSpacing = function() {
    s_history = !1;
    var activeObject = canvas.getActiveObject();
    setStyle(activeObject, "charSpacing", 100 * ccs.getValue()),
    activeObject.setCoords(),
    canvas.renderAll()
}
  , ccs = $("#changecharspacing").slider().on("slide", ChangeCharSpacing).data("slider");
$("#changecharspacing").slider().on("slide", function(e) {
    s_history = !0,
    save_history()
});
var deleteitembtn = document.getElementById("deleteitem");
function deleteItem() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if ("activeSelection" === activeObject.type && activeObject._objects) {
            var objectsInGroup = activeObject.getObjects();
            canvas.discardActiveObject(),
            objectsInGroup.forEach(function(object) {
                !0 !== object.locked && canvas.remove(object)
            })
        } else
            !0 !== activeObject.locked && canvas.remove(activeObject);
        canvas.discardActiveObject().renderAll(),
        save_history()
    }
}
deleteitembtn && (deleteitembtn.onclick = function() {
    deleteItem()
}
);
var objectalignleftSwitch = document.getElementById("objectalignleft");
objectalignleftSwitch && (objectalignleftSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject._objects ? activeObject.forEachObject(function(object) {
        var objWidth = object.getBoundingRect().width;
        DEBUG && console.log(object.left),
        object && /text/.test(object.type) && setStyle(object, "textAlign", "left"),
        object.originX = "center",
        object.left = -activeObject.width / 2 + objWidth / 2,
        object.setCoords()
    }) : activeObject && /text/.test(activeObject.type) && (setStyle(activeObject, "textAlign", "left"),
    $("#objectalignleft").addClass("active"),
    $("#objectalignright").removeClass("active"),
    $("#objectaligncenter").removeClass("active")),
    canvas.renderAll()
}
);
var objectaligncenterSwitch = document.getElementById("objectaligncenter");
objectaligncenterSwitch && (objectaligncenterSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject._objects ? activeObject.forEachObject(function(object) {
        object && /text/.test(object.type) && setStyle(object, "textAlign", "center"),
        object.originX = "center",
        object.left = 0
    }) : activeObject && /text/.test(activeObject.type) && (setStyle(activeObject, "textAlign", "center"),
    $("#objectaligncenter").addClass("active"),
    $("#objectalignleft").removeClass("active"),
    $("#objectalignright").removeClass("active")),
    canvas.renderAll()
}
);
var objectalignrightSwitch = document.getElementById("objectalignright");
objectalignrightSwitch && (objectalignrightSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject._objects ? activeObject.forEachObject(function(object) {
        var objWidth = object.getBoundingRect().width;
        object && /text/.test(object.type) && setStyle(object, "textAlign", "right"),
        object.originX = "center",
        object.left = activeObject.width / 2 - objWidth / 2,
        object.setCoords()
    }) : activeObject && /text/.test(activeObject.type) && (setStyle(activeObject, "textAlign", "right"),
    $("#objectalignright").addClass("active"),
    $("#objectalignleft").removeClass("active"),
    $("#objectaligncenter").removeClass("active")),
    canvas.renderAll()
}
);
var horizcenterIndentSwitch = document.getElementById("horizcenterindent");
horizcenterIndentSwitch && (horizcenterIndentSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject()
      , activeGroup = canvas.getActiveObject();
    if (activeGroup._objects) {
        var objs = activeGroup.getObjects()
          , group = new fabric.Group(objs,{
            originX: "center",
            originY: "center",
            top: activeGroup.top
        });
        canvas._activeObject = null,
        canvas.setActiveObject(group.setCoords()).renderAll(),
        activeGroup = canvas.getActiveObject(),
        canvas.viewportCenterH(activeGroup),
        activeGroup.setCoords(),
        canvas.renderAll()
    } else
        activeObject && (activeObject.viewportCenterH(),
        activeObject.setCoords(),
        canvas.renderAll());
    save_history()
}
);
var verticenterIndentSwitch = document.getElementById("verticenterindent");
verticenterIndentSwitch && (verticenterIndentSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject()
      , activeGroup = canvas.getActiveObject();
    if (activeGroup._objects) {
        var objs = activeGroup.getObjects()
          , group = new fabric.Group(objs,{
            originX: "center",
            originY: "center",
            left: activeGroup.left
        });
        canvas._activeObject = null,
        canvas.setActiveObject(group.setCoords()).renderAll(),
        activeGroup = canvas.getActiveObject(),
        canvas.viewportCenterObjectV(activeGroup),
        activeGroup.setCoords(),
        canvas.renderAll()
    } else
        activeObject && (activeObject.viewportCenterV()(),
        activeObject.setCoords(),
        canvas.renderAll());
    save_history()
}
);
var leftIndentSwitch = document.getElementById("leftindent");
leftIndentSwitch && (leftIndentSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject()
      , activeGroup = canvas.getActiveObject();
    if (activeGroup._objects) {
        var objs = activeGroup.getObjects()
          , group = new fabric.Group(objs,{
            originX: "center",
            originY: "center",
            top: activeGroup.top
        });
        canvas._activeObject = null,
        canvas.setActiveObject(group.setCoords()).renderAll(),
        activeGroup = canvas.getActiveObject(),
        canvas.viewportCenterObjectH(activeGroup),
        activeGroup.left = activeGroup.width / 2 * activeGroup.scaleX + 12 * canvasScale,
        activeGroup.setCoords(),
        canvas.renderAll()
    } else
        activeObject && (activeObject.viewportCenterH(),
        activeObject.setCoords(),
        activeObject.originX = "left",
        activeObject.left = 12 * canvasScale,
        activeObject.setCoords(),
        canvas.renderAll());
    save_history()
}
);
var rightIndentSwitch = document.getElementById("rightindent");
function changeObjectColor(hex) {
    DEBUG && console.log("changeObjectColor");
    var obj = canvas.getActiveObject();
    if (obj)
        if (obj.paths)
            for (var i = 0; i < obj.paths.length; i++)
                obj.paths[i].set("fill", hex);
        else
            setStyle(obj, "fill", hex);
    obj && obj._objects && obj.forEachObject(function(object) {
        if (object.paths)
            for (var i = 0; i < object.paths.length; i++)
                object.paths[i].set("fill", hex);
        else
            setStyle(object, "fill", hex)
    }),
    canvas.renderAll(),
    save_history(1)
}
function changeStrokeColor(hex) {
    DEBUG && console.log(changeStrokeColor);
    var obj = canvas.getActiveObject();
    if (obj) {
        if (obj.paths)
            for (var i = 0; i < obj.paths.length; i++)
                obj.paths[i].set("stroke", hex);
        if (obj._objects)
            for (i = 0; i < obj._objects.length; i++)
                obj._objects[i].set("stroke", hex);
        obj.set("stroke", hex)
    }
    var grpobjs = canvas.getActiveObject();
    grpobjs && grpobjs._objects && grpobjs.forEachObject(function(object) {
        if (object._objects)
            for (var i = 0; i < object._objects.length; i++)
                object._objects[i].set("stroke", hex);
        if (object.paths)
            for (i = 0; i < object.paths.length; i++)
                object.paths[i].set("stroke", hex);
        else
            object.set("stroke", hex)
    }),
    canvas.renderAll(),
    save_history()
}
function setCanvasWidthHeight(width, height) {
    if (width)
        for (var i = 0; i <= canvasindex; i++) {
            if (canvasarray[i])
                canvasarray[i].width = width,
                (canvasDOM = document.getElementById("canvas" + i)).style.width = width / 1 + "px",
                canvasDOM.width = width,
                (elem = document.getElementsByClassName("upper-canvas")[i]).style.width = width / 1 + "px",
                elem.width = width,
                (elem = document.getElementsByClassName("canvas-container")[i]).style.width = width / 1 + "px",
                elem.width = width,
                (elem = document.getElementsByClassName("canvascontent")[i]).style.width = width / 1 + "px",
                elem.width = width,
                (elem = document.getElementById("divcanvas" + i)).style.width = width / 1 + "px",
                elem.width = width,
                0,
                canvasarray[i].calcOffset(),
                canvasarray[i].renderAll(),
                canvasarray[i].setDimensions()
        }
    if (height)
        for (i = 0; i <= canvasindex; i++) {
            var canvasDOM, elem;
            if (canvasarray[i])
                canvasarray[i].height = height,
                (canvasDOM = document.getElementById("canvas" + i)).style.height = height / 1 + "px",
                canvasDOM.height = height,
                (elem = document.getElementsByClassName("upper-canvas")[i]).style.height = height / 1 + "px",
                elem.height = height,
                (elem = document.getElementsByClassName("canvas-container")[i]).style.height = height / 1 + "px",
                elem.height = height,
                (elem = document.getElementsByClassName("canvascontent")[i]).style.height = height / 1 + "px",
                elem.height = height,
                (elem = document.getElementById("divcanvas" + i)).style.height = height / 1 + "px",
                elem.height = height,
                0,
                canvasarray[i].calcOffset(),
                canvasarray[i].renderAll(),
                canvasarray[i].setDimensions()
        }
    $("#canvaswidth").val(""),
    $("#canvaswidth").val(Math.round(width)),
    $("#canvasheight").val(""),
    $("#canvasheight").val(Math.round(height))
}
function setZoom(newZoomLevel) {
    if (void 0 === newZoomLevel && (newZoomLevel = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1),
    newZoomLevel < .2 && (newZoomLevel = .1),
    "geofilter" == template_type || "geofilter2" == template_type) {
        newZoomLevel = newZoomLevel > 1 ? 1 : newZoomLevel;
        var marginLeft = $("#phone").width() / 2 * newZoomLevel - 1.5
          , top = ("geofilter2" == template_type ? -63 : -260) * newZoomLevel + 63;
        $("#phone").css({
            transform: "scale(" + newZoomLevel + ")",
            marginLeft: "-" + marginLeft + "px",
            top: top + "px"
        });
        var borderRadius = "geofilter2" == template_type ? 100 * newZoomLevel : 5;
        setTimeout(function() {
            $(".canvas-background").css("border-radius", borderRadius + "px")
        }, 0)
    }
    var $n = 0
      , $new_width = 96 * document.getElementById("loadCanvasWid").value * newZoomLevel
      , $new_height = 96 * document.getElementById("loadCanvasHei").value * newZoomLevel;
    for (setCanvasWidthHeight($new_width, $new_height); canvasarray[$n]; )
        $("#divcanvas" + $n).is(":visible") && (canvasarray[$n].setZoom(newZoomLevel),
        canvasarray[$n].setDimensions({
            width: $new_width,
            height: $new_height
        }),
        canvasarray[$n].bgImg && canvasarray[$n].bgImg.scale(canvasarray[$n].bgScale * newZoomLevel / 3.125 / fabric.devicePixelRatio),
        canvasarray[$n].renderAll(),
        adjustIconPos($n)),
        $n++;
    $("#zoomperc").html(Math.round(100 * newZoomLevel) + "%").data("scaleValue", newZoomLevel),
    demo_as_id && "geofilter" != template_type && "geofilter2" != template_type && setDemoOverlay()
}
function updateDpatternsScale() {
    arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : canvas
}
function setDemoOverlay() {
    scale = $("#zoomperc").data("scaleValue");
	var uri = appUrl + "assets/img/demo_overlay.svg";
    fabric.Image.fromURL(uri, function(img) {
        img.scaleToWidth(50 * scale),
        img.angle = 315,
        img.top = 50 * scale,
        img.left = 20 * scale,
        patternSourceCanvas = new fabric.StaticCanvas,
        patternSourceCanvas.add(img);
        for (var pattern = new fabric.Pattern({
            source: function() {
                return patternSourceCanvas.setDimensions({
                    width: 80 * scale,
                    height: 80 * scale
                }),
                patternSourceCanvas.renderAll(),
                patternSourceCanvas.getElement()
            },
            repeat: "repeat"
        }), n = 0; canvasarray[n]; )
            $("#divcanvas" + n).is(":visible") && canvasarray[n].setOverlayColor(pattern, function() {
                canvasarray[n].renderAll()
            }),
            n++
    })
}
function setGeofilterOverlay() {
    canvas.setOverlayImage("/design/assets/img/geofilter_overlay.svg", canvas.renderAll.bind(canvas))
}
function removeGeofilterOverlay() {
    canvas.setOverlayImage(null, canvas.renderAll.bind(canvas))
}
function setCanvasZoom(canvasId) {
    var newZoomLevel = parseFloat($("#zoomperc").data("scaleValue")) || 1;
    if (newZoomLevel < .2 && (newZoomLevel = .1),
    "geofilter" == template_type || "geofilter2" == template_type) {
        newZoomLevel = newZoomLevel > 1 ? 1 : newZoomLevel;
        var marginLeft = $("#phone").width() / 2 * newZoomLevel - 1.5
          , top = ("geofilter2" == template_type ? -63 : -260) * newZoomLevel + 63;
        $("#phone").css({
            transform: "scale(" + newZoomLevel + ")",
            marginLeft: "-" + marginLeft + "px",
            top: top + "px"
        });
        var borderRadius = "geofilter2" == template_type ? 100 * newZoomLevel : 5;
        setTimeout(function() {
            $(".canvas-background").css("border-radius", borderRadius + "px")
        }, 0)
    }
    var canvasDOM, elem, width = 96 * document.getElementById("loadCanvasWid").value * newZoomLevel, height = 96 * document.getElementById("loadCanvasHei").value * newZoomLevel;
    canvasarray[canvasId].width = width,
    (canvasDOM = document.getElementById("canvas" + canvasId)).style.width = width / 1 + "px",
    canvasDOM.width = width,
    (elem = document.getElementsByClassName("upper-canvas")[canvasId]).style.width = width / 1 + "px",
    elem.width = width,
    (elem = document.getElementsByClassName("canvas-container")[canvasId]).style.width = width / 1 + "px",
    elem.width = width,
    (elem = document.getElementsByClassName("canvascontent")[canvasId]).style.width = width / 1 + "px",
    elem.width = width,
    (elem = document.getElementById("divcanvas" + canvasId)).style.width = width / 1 + "px",
    elem.width = width,
    canvasarray[canvasId].calcOffset(),
    canvasarray[canvasId].renderAll(),
    canvasarray[canvasId].setDimensions(),
    canvasarray[canvasId].height = height,
    (canvasDOM = document.getElementById("canvas" + canvasId)).style.height = height / 1 + "px",
    canvasDOM.height = height,
    (elem = document.getElementsByClassName("upper-canvas")[canvasId]).style.height = height / 1 + "px",
    elem.height = height,
    (elem = document.getElementsByClassName("canvas-container")[canvasId]).style.height = height / 1 + "px",
    elem.height = height,
    (elem = document.getElementsByClassName("canvascontent")[canvasId]).style.height = height / 1 + "px",
    elem.height = height,
    (elem = document.getElementById("divcanvas" + canvasId)).style.height = height / 1 + "px",
    elem.height = height,
    canvasarray[canvasId].calcOffset(),
    canvasarray[canvasId].renderAll(),
    canvasarray[canvasId].setDimensions(),
    $("#canvaswidth").val(""),
    $("#canvaswidth").val(Math.round(width)),
    $("#canvasheight").val(""),
    $("#canvasheight").val(Math.round(height)),
    canvasarray[canvasId].setZoom(newZoomLevel),
    canvasarray[canvasId].setDimensions({
        width: width,
        height: height
    }),
    adjustIconPos(canvasId),
    $("#zoomperc").html(Math.round(100 * newZoomLevel) + "%").data("scaleValue", newZoomLevel)
}
function zoomTo($scale_value) {
    $scale_value < .2 && ($scale_value = .1);
    var $container = jQuery("#canvasbox-tab");
    $container.css({
        transform: "scale(" + $scale_value + ") translatez(0)"
    }),
    $("#zoomperc").html(Math.round(100 * $scale_value) + "%").data("scaleValue", $scale_value),
    $(".duplicatecanvas, .deletecanvas, #addnewpagebutton").css("transform", "perspective(1px) scale(" + eval(1 / $scale_value) + ") translatez(0)"),
    $(".am-content").css("height", $("#canvaspages").outerHeight() * $scale_value + $("#addnewpagebutton").outerHeight() + 150);
    var $w = $("#canvaspages").outerWidth() * $scale_value + $(".duplicatecanvas").outerWidth();
    $w > $(window).width() ? $(".am-content").css("width", $w + 105) : $(".am-content").css("width", "auto")
}
rightIndentSwitch && (rightIndentSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject()
      , activeGroup = canvas.getActiveObject();
    if (activeGroup._objects) {
        var objs = activeGroup.getObjects()
          , group = new fabric.Group(objs,{
            originX: "center",
            originY: "center",
            top: activeGroup.top
        });
        canvas._activeObject = null,
        canvas.setActiveObject(group.setCoords()).renderAll(),
        activeGroup = canvas.getActiveObject(),
        canvas.viewportCenterObjectH(activeGroup),
        activeGroup.left = canvas.width - activeGroup.width / 2 * activeGroup.scaleX - 12 * canvasScale,
        activeGroup.setCoords(),
        canvas.renderAll()
    } else
        activeObject && (activeObject.viewportCenterH(),
        activeObject.setCoords(),
        activeObject.originX = "left",
        activeObject.left = canvas.width - activeObject.width * activeObject.scaleX - 12 * canvasScale,
        activeObject.setCoords(),
        canvas.renderAll());
    save_history()
}
),
$("#undo").click(function(e) {
    e.preventDefault(),
    history_undo()
}),
$("#redo").click(function(e) {
    e.preventDefault(),
    history_redo()
}),
$("#addremovestroke").click(function(e) {
    DEBUG && console.log(addremovestroke),
    e.preventDefault(),
    e.stopPropagation();
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.get("stroke")) {
            if (activeObject.paths)
                for (var i = 0; i < activeObject.paths.length; i++)
                    activeObject.paths[i].set("stroke", ""),
                    activeObject.paths[i].set("strokeWidth", 1);
            if (activeObject._objects)
                for (i = 0; i < activeObject._objects.length; i++)
                    activeObject._objects[i].set("stroke", ""),
                    activeObject._objects[i].set("strokeWidth", 1);
            activeObject.set("stroke", ""),
            activeObject.set("strokeWidth", 1),
            $("#strokegroup").hide()
        } else {
            if (activeObject.paths)
                for (i = 0; i < activeObject.paths.length; i++)
                    activeObject.paths[i].set("stroke", "#000000");
            if (activeObject._objects)
                for (i = 0; i < activeObject._objects.length; i++)
                    activeObject._objects[i].set("stroke", "#000000");
            activeObject.set("paintFirst", "stroke"),
            activeObject.set("strokeLineJoin", "round"),
            activeObject.set("stroke", "#000000"),
            activeObject.set("strokeWidth", 1),
            $("#strokegroup").show(),
            $("#colorStrokeSelector").css("background-color", "#000000")
        }
        canvas.renderAll(),
        save_history()
    }
}),
$("#btnZoomIn").click(function() {
    var $scale_value = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1;
    setZoom($scale_value += .1)
}),
$("#btnZoomOut").click(function() {
    var $scale_value = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1;
    setZoom($scale_value -= .1)
}),
$("#zoomperc").click(function() {
    setZoom(1)
}),
$("#btnFitToScreen").click(function() {
    setZoom(1),
    autoZoom()
});
var newTemplateTagsEdit = $("#newTemplateTags").tagsField({
    label: "Tags",
    id: "template_tags",
    labelColumnClass: "control-label",
    divColumnClass: ""
});
function resetNewTemplateForm() {
    $(".metric_block").show(),
    $("input[name=metric_units1]").val(["in"]),
    $("#canvaswh_modal").find(".canvas_size_inches").attr("class", "canvas_size_inches active"),
    $("#canvaswh_modal").find(".canvas_size_pixels").attr("class", "canvas_size_pixels"),
    $("#canvaswh_modal").find(".canvas_size_mm").attr("class", "canvas_size_mm"),
    $("#loadCanvasWid").val(5),
    $("#loadCanvasHei").val(7),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("1")
}
function setWorkspace() {
    $("#addnewpagebutton").show(),
    $("#productImageDownload").hide(),
    $("#downloadPDF").parent().show(),
    $("#downloadJPEG").parent().show(),
    $("#downloadAsPNG").parent().show(),
    $(".bgPane").parent().show(),
    $(".duplicatecanvas").css("visibility", "visible"),
    $("#options").show(),
    $("#background").hide(),
    $("#phone").hide(),
    $(".background-arrow").hide(),
    $("#addnewpagebutton").text(" + Add a Blank Page"),
    $("#convertToDoublesided").hide(),
    $("#convertToSingle").hide(),
    $("#convertGeofilterToNewSize").hide(),
    $("#addrow").hide(),
    $("#deleterow").hide(),
    $("#addcolumn").hide(),
    $("#deletecolumn").hide(),
    "custom" == template_type ? ($("#addrow").show(),
    $("#deleterow").show(),
    $("#addcolumn").show(),
    $("#deletecolumn").show()) : "doublesided" == template_type ? ($("#addnewpagebutton").text(" + Add a Back Side"),
    2 == $(".divcanvas:visible").length && ($("#addnewpagebutton").hide(),
    $(".duplicatecanvas").css("visibility", "hidden"))) : "geofilter" == template_type ? ($("#addnewpagebutton").hide(),
    $("#downloadPDF").parent().hide(),
    $("#downloadJPEG").parent().hide(),
    $(".bgPane").parent().hide(),
    $(".duplicatecanvas").css("visibility", "hidden"),
    $("#canvasSize").hide(),
    $("#gridbtn").hide(),
    $("#convertGeofilterToNewSize").show(),
    $("#background").show(),
    $("#phone").show(),
    $("#canvas0").addClass("canvas-background"),
    $(".background-arrow").show(),
    setGeofilterBackground(geofilterBackground)) : "geofilter2" == template_type ? ($("#addnewpagebutton").hide(),
    $("#downloadPDF").parent().hide(),
    $("#downloadJPEG").parent().hide(),
    $(".bgPane").parent().hide(),
    $(".duplicatecanvas").css("visibility", "hidden"),
    $("#options").hide(),
    $("#background").show(),
    $("#phone").show(),
    $("#canvas0").addClass("canvas-background"),
    $(".background-arrow").show(),
    setGeofilterBackground(geofilterBackground)) : "product_image" == template_type && ($("#addnewpagebutton").hide(),
    $(".download-menu").hide(),
    $("#productImageDownload").show(),
    $(".duplicatecanvas").css("visibility", "hidden")),
    "single" == template_type && $(".divcanvas:visible").length <= 2 || "custom" == template_type && $(".divcanvas:visible").length <= 2 && 1 == $("#numOfcanvasrows").val() && 1 == $("#numOfcanvascols").val() ? $("#convertToDoublesided").show() : "doublesided" == template_type && $("#convertToSingle").show(),
    ["doublesided", "geofilter", "geofilter2", "product_image"].includes(template_type) || ($(".pagenumber:visible").length >= 36 ? ($(".duplicatecanvas").addClass("disabled"),
    $("#addnewpagebutton").hide(),
    $("#pageLimitMessage").show()) : ($(".duplicatecanvas").removeClass("disabled"),
    $("#addnewpagebutton").show(),
    $("#pageLimitMessage").hide())),
    canvasarray[0].cwidth / 96 * (canvasarray[0].cheight / 96) > 100 && ($("#addnewpagebutton").hide(),
    $(".duplicatecanvas").css("visibility", "hidden")),
    setTimeout(checkDpatterns, 100)
}
$("#savetemplate").click(function() {
    loadedtemplateid <= 0 ? (issaveastemplate = !0,
    isupdatetemplate = !1,
    $("#savetemplate_modal").find(".modal-title").text("Save Template"),
    $("#savetemplate_modal").find(".btn").text("Submit"),
    $("#savetemplate_modal").modal("show")) : (issaveastemplate = !1,
    isupdatetemplate = !0,
    proceed_savetemplate())
}),
$("#savetemplate_modal").on("hidden.bs.modal", function(e) {}),
$("#newtemplate").click(function(e) {
    if (e.preventDefault(),
    "yes" !== $("#autosave").data("saved"))
        return $("#unsavedChanges").data("newtemplate", 1),
        $("#unsavedChanges").data("templateid", 0),
        void $("#unsavedChanges").modal("show");
    $("#template_type_modal").modal("show")
}),
$("#btn_type_single").click(function(e) {
    template_type = "single",
    resetNewTemplateForm(),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("1"),
    $("#numOfcanvasrows").closest("span").hide(),
    $("#numOfcanvascols").closest("span").hide(),
    $("#multiCanvText").hide(),
    $("#template_type_modal").modal("hide"),
    $("#canvaswh_modal").modal("show")
}),
$("#btn_type_doublesided").click(function(e) {
    template_type = "doublesided",
    resetNewTemplateForm(),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("1"),
    $("#numOfcanvasrows").closest("span").hide(),
    $("#numOfcanvascols").closest("span").hide(),
    $("#multiCanvText").hide(),
    $("#template_type_modal").modal("hide"),
    $("#canvaswh_modal").modal("show")
}),
$("#btn_type_bookfold").click(function(e) {
    template_type = "book_fold",
    resetNewTemplateForm(),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("2"),
    $("#numOfcanvasrows").closest("span").hide(),
    $("#numOfcanvascols").closest("span").hide(),
    $("#multiCanvText").show(),
    $("#template_type_modal").modal("hide"),
    $("#canvaswh_modal").modal("show")
}),
$("#btn_type_tentfold").click(function(e) {
    template_type = "tent_fold",
    resetNewTemplateForm(),
    $("#numOfcanvasrows").val("2"),
    $("#numOfcanvascols").val("1"),
    $("#numOfcanvasrows").closest("span").hide(),
    $("#numOfcanvascols").closest("span").hide(),
    $("#multiCanvText").show(),
    $("#template_type_modal").modal("hide"),
    $("#canvaswh_modal").modal("show")
}),
$("#btn_type_custom").click(function(e) {
    template_type = "custom",
    resetNewTemplateForm(),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("1"),
    $("#numOfcanvasrows").closest("span").show(),
    $("#numOfcanvascols").closest("span").show(),
    $("#multiCanvText").show(),
    $("#template_type_modal").modal("hide"),
    $("#canvaswh_modal").modal("show")
}),
$("#btn_type_product_image").click(function(e) {
    template_type = "product_image",
    resetNewTemplateForm(),
    $("input[name=metric_units1]").val(["px"]),
    $("#canvaswh_modal").find(".canvas_size_pixels").attr("class", "canvas_size_pixels active"),
    $("#canvaswh_modal").find(".canvas_size_inches").attr("class", "canvas_size_inches"),
    $("#canvaswh_modal").find(".canvas_size_mm").attr("class", "canvas_size_mm"),
    $(".metric_block").hide(),
    $("#loadCanvasWidthPx").val(2e3),
    $("#loadCanvasHeightPx").val(1600),
    $("#loadCanvasWid").val(2e3 / 96 / 3.125),
    $("#loadCanvasHei").val(1600 / 96 / 3.125),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("1"),
    $("#numOfcanvasrows").closest("span").hide(),
    $("#numOfcanvascols").closest("span").hide(),
    $("#multiCanvText").hide(),
    $("#template_type_modal").modal("hide"),
    $("#canvaswh_modal").modal("show")
}),
$("#btn_type_geofilter").click(function(e) {
    template_type = "geofilter2",
    resetNewTemplateForm(),
    $("input[name=metric_units1]").val(["px"]),
    $("#loadCanvasWidthPx").val(1080),
    $("#loadCanvasHeightPx").val(2340),
    $("#loadCanvasWid").val(11.25),
    $("#loadCanvasHei").val(24.375),
    $("#numOfcanvasrows").val("1"),
    $("#numOfcanvascols").val("1"),
    canvasindex = 0,
    canvasarray = [],
    pageindex = 0,
    loadedtemplateid = 0,
    $("#canvaspages > div").not("#page0").remove(),
    $("#page0").empty(),
    addCanvasToPage(),
    setCanvasSize(),
    autoZoom();
    var i = 0;
    for (s_history = !0; canvasarray[i]; )
        canvas = canvasarray[i],
        save_history(1),
        canvas.renderAll(),
        i++;
    $("#template_type_modal").modal("hide"),
    geofilterBackground = 0,
    setWorkspace()
}),
$("#saveastemplate").click(function() {
    issaveastemplate = !0,
    $("#savetemplate_modal").find(".modal-title").text("Save as New Template"),
    $("#savetemplate_modal").find(".btn").text("Save As New"),
    $("#savetemplate_modal").modal("show")
}),
$("#downloadPDF").click(function() {
    checkSavePaper().length > 0 ? $(".savePaperRow").show() : ($("#savePaper").prop("checked", !1),
    $("#selectSize").attr("aria-expanded", !1),
    $("#selectSize").removeClass("in"),
    $(".savePaperRow").hide()),
    $("#downloadpdfmodal").modal("show"),
    getPreview()
}),
$("#downloadJPEG").click(function() {
    $("#downloadjpegmodal").modal("show")
}),
$("#downloadtemplate").click(function() {
    $("#downloadtemplate_modal").modal("show")
}),
$("#downloadPNG").click(function() {
    "geofilter2" == template_type ? downloadAsPng() : $("#downloadPngModal").modal("show")
}),
$("#showHistory").click(function() {
    historyTable.ajax.reload(),
    $("#showHistoryModal").modal("show")
}),
// $("#downloadAsPNG").click(function() {
//     downloadAsPng()
// });
// var downloadAsPng = function() {
//     if (ajaxRequestRef && ajaxRequestRef.abort(),
//     demo_as_id > 0)
//         $.toast({
//             text: "Not allowed in demo mode",
//             icon: "error",
//             loader: !1,
//             position: "top-right"
//         });
//     else {
//         downloadPdfTimer(120),
//         canvas.discardActiveObject().renderAll();
//         var canvases = canvasarray;
//         globalRow = parseInt($("#numOfcanvasrows").val()),
//         globalCol = parseInt($("#numOfcanvascols").val());
//         var pages = $(".divcanvas:visible").length / document.getElementById("numOfcanvasrows").value / document.getElementById("numOfcanvascols").value
//           , canvasWidth = canvases[0].get("width") / canvases[0].getZoom()
//           , canvasHeight = canvases[0].get("height") / canvases[0].getZoom()
//           , density = $('[name="pngRadioDensity"]:checked').val();
//         "geofilter2" == template_type && (density = 96);
//         var templateJson = getTemplateJson()
//           , urlDocument = appUrl + "admin/Documents/download-png-file";
//         $.toast({
//             heading: "Creating PNG...",
//             text: "Please wait",
//             icon: "info",
//             loader: !1,
//             allowToastClose: !1,
//             position: "top-right",
//             hideAfter: !1,
//             stack: 1,
//             beforeShow: function() {
//                 var tag = $(".jq-toast-single.jq-has-icon.jq-icon-info").first();
//                 $(tag).removeClass("jq-icon-info"),
//                 $(tag).addClass("toast-loader-icon")
//             }
//         }),
//         $.ajax({
//             url: urlDocument,
//             method: "POST",
//             data: {
//                 webSocketConn: webSocketConn,
//                 demoAsId: demo_as_id,
//                 docUserId: docUserId,
//                 templateId: loadedtemplateid,
//                 templateJson: templateJson,
//                 pages: pages,
//                 canvasWidth: canvasWidth,
//                 canvasHeight: canvasHeight,
//                 rows: globalRow,
//                 cols: globalCol,
//                 bleed: !1,
//                 trimsMarks: !1,
//                 savePaper: !1,
//                 pageSize: "us-letter",
//                 pageType: template_type,
//                 density: density,
//                 metrics: $("input[name=metric_units1]:checked").val()
//             },
//             dataType: "json"
//         }).done(function(data) {
//             pdfRequestId = data.requestId,
//             pullingType = "png",
//             webSocketConn || (clearTimeout(referenceUpdates),
//             checkDocsUpdates(pdfRequestId))
//         })
//     }
// };
$("#downloadAsPNG").click(function() {
    registerDownload("PNG", void 0, function(func) {
        demo_as_id > 0 ? $.toast({
            text: "Not allowed in demo mode",
            icon: "error",
            loader: !1,
            position: "top-right"
        }) : (canvas.discardActiveObject().renderAll(),
        appSpinner.show(),
        $("#zoomperc").data("oldScaleValue", $("#zoomperc").data("scaleValue")),
        setZoom(1),
        removeDeletedCanvases(canvasarray, function($options) {
            1 === $options.canvases.length ? "geofilter" == template_type || "geofilter2" == template_type ? (downloadImage2({
                canvases: $options.canvases,
                format: "png"
            }),
            func()) : downloadImageProxy({
                canvases: $options.canvases,
                callback: function($options) {
                    downloadImage2({
                        canvases: $options.canvases,
                        format: "png"
                    }),
                    func()
                }
            }) : downloadImageProxy({
                canvases: $options.canvases,
                callback: function($options) {
                    downloadImage3({
                        canvases: $options.canvases,
                        format: "png"
                    }),
                    func()
                }
            })
        }))
    })
});
// $("#downloadAsJPEG, #downloadProductImage").click(function() {
//     if (ajaxRequestRef && ajaxRequestRef.abort(),
//     demo_as_id > 0)
//         $.toast({
//             text: "Not allowed in demo mode",
//             icon: "error",
//             loader: !1,
//             position: "top-right"
//         });
//     else {
//         downloadPdfTimer(120),
//         canvas.discardActiveObject().renderAll();
//         var canvases = canvasarray;
//         globalRow = parseInt($("#numOfcanvasrows").val()),
//         globalCol = parseInt($("#numOfcanvascols").val());
//         var pages = $(".divcanvas:visible").length / document.getElementById("numOfcanvasrows").value / document.getElementById("numOfcanvascols").value
//           , canvasWidth = canvases[0].get("width") / canvases[0].getZoom()
//           , canvasHeight = canvases[0].get("height") / canvases[0].getZoom()
//           , bleed = $("#savebleed").is(":checked")
//           , density = $('[name="jpegRadioDensity"]:checked').val();
//         300 != density && (bleed = !1);
//         var templateJson = getTemplateJson()
//           , urlDocument = appUrl + "admin/Documents/download-jpeg-file";
//         $.toast({
//             heading: "Creating JPEG...",
//             text: "Please wait",
//             icon: "info",
//             loader: !1,
//             allowToastClose: !1,
//             position: "top-right",
//             hideAfter: !1,
//             stack: 1,
//             beforeShow: function() {
//                 var tag = $(".jq-toast-single.jq-has-icon.jq-icon-info").first();
//                 $(tag).removeClass("jq-icon-info"),
//                 $(tag).addClass("toast-loader-icon")
//             }
//         }),
//         $.ajax({
//             url: urlDocument,
//             method: "POST",
//             data: {
//                 // webSocketConn: webSocketConn,
//                 demoAsId: demo_as_id,
//                 // docUserId: docUserId,
//                 templateId: loadedtemplateid,
//                 templateJson: templateJson,
//                 pages: pages,
//                 canvasWidth: canvasWidth,
//                 canvasHeight: canvasHeight,
//                 rows: globalRow,
//                 cols: globalCol,
//                 bleed: bleed,
//                 trimsMarks: !1,
//                 savePaper: !1,
//                 pageSize: "us-letter",
//                 pageType: template_type,
//                 density: density,
//                 metrics: $("input[name=metric_units1]:checked").val()
//             },
//             dataType: "json"
//         }).done(function(data) {
//             pdfRequestId = data.requestId,
//             pullingType = "jpeg",
//             webSocketConn || (clearTimeout(referenceUpdates),
//             checkDocsUpdates(pdfRequestId))
//         })
//     }
// });

$("#downloadAsJPEG").click(function() {
    registerDownload("JPEG", {
        saveBleed: $("input#savebleed").is(":checked")
    }, function(func) {
        toggleHiddenStatusOfObjects(),
        demo_as_id > 0 ? $.toast({
            text: "Not allowed in demo mode",
            icon: "error",
            loader: !1,
            position: "top-right"
        }) : (canvas.discardActiveObject().renderAll(),
        appSpinner.show(),
        $("#zoomperc").data("oldScaleValue", $("#zoomperc").data("scaleValue")),
        setZoom(1),
        removeDeletedCanvases(canvasarray, function($options) {
            $("#savebleed").is(":checked") ? createBleed({
                canvases: $options.canvases,
                callback: function($options) {
                    downloadImageProxy({
                        canvases: $options.canvases
                    })
                }
            }) : 1 === $options.canvases.length ? downloadImageProxy({
                canvases: $options.canvases,
                callback: function($options) {
                    downloadImage2({
                        canvases: $options.canvases,
                        format: "jpeg"
                    })
                }
            }) : downloadImageProxy({
                canvases: $options.canvases,
                callback: function($options) {
                    downloadImage3({
                        canvases: $options.canvases,
                        format: "jpeg"
                    })
                }
            }),
            func()
        }))
    })
});

$('[name="jpegRadioDensity"]').click(function() {
    300 == $('[name="jpegRadioDensity"]:checked').val() ? $("#div-jpeg-bleed").show() : $("#div-jpeg-bleed").hide()
});

var registerDownload = function(type) {
    var obj = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : void 0;
    (arguments.length > 2 ? arguments[2] : void 0)(function() {
        registerCallBack(type, obj)
    })
}
  , registerCallBack = function(type) {
    var obj = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : void 0
      , url = appUrl + "editor/register-template-download";
    $.ajax({
        url: url,
        type: "POST",
        data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
            templateId: loadedtemplateid,
            fileType: type,
            purchase_code: design_as_id,
            customerId: customerId,
            option: void 0 !== obj ? JSON.stringify(obj) : ""
        },
        dataType: "json"
    }).done(function(data) {
        data.success ? 0 != data.limit && showDownloadsRemaining(data.remaining) : $.toast({
            text: data.msg,
            icon: "error",
            loader: !1,
            position: "top-right",
            hideAfter: 3e3
        })
    }).fail(function() {})
};
function downloadImageProxy($options) {
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , $readyCanvases = $options.readyCanvases || []
      , $callback = $options.callback || (1 === $canvases.length ? downloadImage2 : downloadImage3)
      , $i = $options.i || 0
      , tcanvas = new fabric.StaticCanvas;
    tcanvas.setDimensions({
        width: $canvases[$i].get("width"),
        height: $canvases[$i].get("height")
    }),
    "string" != typeof $canvases[$i].backgroundColor && ($canvases[$i].backgroundColor = ""),
    tcanvas.loadFromJSON(JSON.stringify($canvases[$i].toDatalessJSON(properties_to_save)), function() {
        setCanvasBg($canvases[$i], $canvases[$i].bgsrc, "", $canvases[$i].bgScale),
        addBackgroundLayer($canvases[$i], tcanvas).then(function(tcanvas) {
            DEBUG && console.log("$i; " + $i),
            DEBUG && console.log($canvases.length),
            $readyCanvases[$i] = tcanvas,
            $i++,
            $readyCanvases.length >= $canvases.length || $i > $canvases.length ? $callback({
                canvases: $readyCanvases
            }) : downloadImageProxy({
                canvases: $canvases,
                readyCanvases: $readyCanvases,
                i: $i,
                callback: $callback
            })
        }).catch(function($res) {
            DEBUG && console.log($res)
        })
    })
}
function toggleHiddenStatusOfObjects() {
    for (var $i = 0; canvasarray[$i]; )
        canvasarray[$i].forEachObject(function($o) {
            $o.hidden && ($o.visible ? $o.visible = !1 : $o.visible = !0)
        }),
        canvasarray[$i].renderAll(),
        $i++
}
var globalRow = 0
  , globalCol = 0
  , toastMsg = null
  , pdfRequestId = "";

// Bind click event to the download PDF button
$("#downloadAsPDF").click(function() {
    // Abort any ongoing AJAX request to prevent conflicts
    if (ajaxRequestRef && ajaxRequestRef.abort(),
    demo_as_id > 0) {
        // Show a toast message if the action is not allowed in demo mode
        $.toast({
            text: "Not allowed in demo mode",
            icon: "error",
            loader: false, // Use boolean for clarity
            position: "top-right"
        });
    } else {
        // Start the download PDF countdown timer
        downloadPdfTimer(120);
        // Deselect any selected objects on the canvas and re-render
        canvas.discardActiveObject().renderAll();

        // Initialize variables for canvas dimensions and page settings
        var canvases = canvasarray;
        globalRow = parseInt($("#numOfcanvasrows").val()),
        globalCol = parseInt($("#numOfcanvascols").val());

        // Calculate the number of pages based on visible divs and input values
        var pages = $(".divcanvas:visible").length / document.getElementById("numOfcanvasrows").value / document.getElementById("numOfcanvascols").value,
            canvasWidth = canvases[0].get("width") / canvases[0].getZoom(),
            canvasHeight = canvases[0].get("height") / canvases[0].getZoom(),
            bleed = $("#savebleedPdf").is(":checked"),
            trimsMarks = $("#savecrop").is(":checked"),
            savePaper = $("#savePaper").is(":checked"),
            pageSize = "us-letter", // Default page size
            metrics = $("input[name=metric_units1]:checked").val();

        // Update page size if A4 is selected
        if ($(".paper-size.active").find('input[name="paperSize"]').val() === "a4") {
            pageSize = "a4";
        }

        // Retrieve the template JSON for the document
        // var templateJson = getTemplateJson()
        
        // Construct the URL for the document download endpoint
        var urlDocument = appUrl + "editor/download-pdf";

        // Show a toast message indicating the PDF creation is in progress
        $.toast({
            heading: "Creating PDF...",
            text: "Please wait",
            icon: "info",
            loader: false,
            allowToastClose: false,
            position: "top-right",
            hideAfter: false,
            stack: 1,
            beforeShow: function() {
                // Change the icon of the toast message to a loader
                var tag = $(".jq-toast-single.jq-has-icon.jq-icon-info").first();
                $(tag).removeClass("jq-icon-info"),
                $(tag).addClass("toast-loader-icon")
            }
        });

        // Perform the AJAX request to generate the PDF
        $.ajax({
            url: urlDocument,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                // Removed commented out code for cleanliness
                demoAsId: demo_as_id,
                docUserId: docUserId,
                templateId: loadedtemplateid,
                jpgImageData: getTemplateImage(canvasWidth),
                // asdasd canvasWidth
                pages: pages,
                canvasWidth: canvasWidth,
                canvasHeight: canvasHeight,
                rows: globalRow,
                cols: globalCol,
                bleed: bleed,
                trimsMarks: trimsMarks,
                savePaper: savePaper,
                pageSize: pageSize,
                pageType: template_type,
                metrics: metrics
            },
            dataType: "json"
        }).done(function(data) {
            // Update global variables with the response for further processing
            pdfRequestId = data.requestId;
            pullingType = "pdf";
            type = "pdf";
            
            // data.success = true;
            // data.file = 'url to download';
            // data.msg = "Please try again" / "Your PDF is Ready";
            // data.requestId = 'sdasdasd';
            
            if(data.success) {
                var msg = "Your PDF is Ready";
                var linkText = '<a class="file-button-download" data-linktype="' + type + '" target="_blank" href="' + data.file + '">Download Now</a>';
                $.toast({
                    heading: msg,
                    text: linkText,
                    icon: "success",
                    loader: !0,
                    position: "top-right",
                    hideAfter: !1,
                    stack: 1
                });
            } else {
                $.toast({
                    heading: "Error",
                    text: data.msg,
                    icon: "error",
                    loader: !1,
                    position: "top-right",
                    hideAfter: 4e3,
                    stack: 1
                });
            }
        });
    }
});

/**
 * Generates a data URL for the current canvas image at a specified width.
 * @param {number} desiredWidth - The desired width of the image.
 * @returns {string} The data URL of the canvas image in JPEG format.
 */
function getTemplateImage(desiredWidth) {
    // Retrieve the current canvas based on the global currentcanvasid
    var firstCanvas = canvasarray[currentcanvasid],
        // Store the initial zoom level of the canvas to restore it later
        initialZoom = firstCanvas.getZoom(),
        // Flag to track if the canvas background is initially empty
        isEmptyBackground = false;

    // Set the canvas zoom based on the desired width and the original canvas width
    setZoom(desiredWidth / (96 * parseFloat(document.getElementById("loadCanvasWid").value)));

    // Check and set the background color to white if it's not set
    if (!firstCanvas.backgroundColor) {
        isEmptyBackground = true;
        firstCanvas.set({ backgroundColor: "#ffffff" });
    }

    // Specific action for a template type, remove geofilter overlay if applicable
    if (template_type === "geofilter2") {
        removeGeofilterOverlay();
    }

    // Generate the canvas data URL in JPEG format with high quality
    var dataURL = firstCanvas.toDataURL({
        format: "jpeg",
        quality: 0.9
    });

    // Restore specific template modifications after generating the data URL
    if (template_type === "geofilter2") {
        setGeofilterOverlay();
    }

    // Restore the canvas background color if it was initially empty
    if (isEmptyBackground) {
        firstCanvas.set({ backgroundColor: "" });
    }

    // Reset the zoom level to its original value
    setZoom(initialZoom);

    // Return the generated data URL
    return dataURL;
}


var processDownloadButton = function(data, type) {
    if (clearTimeout(timerPdfRef),
    data.requestId == pdfRequestId) {
        var msg = "Your PDF is Ready";
        if ("jpeg" == type ? msg = "Your JPEG is Ready" : "png" == type && (msg = "Your PNG is Ready"),
        1 == data.success) {
            var linkText = '<a class="file-button-download" data-linktype="' + type + '" target="_blank" href="' + data.file + '">Download Now</a>';
            toastMsg = $.toast({
                heading: msg,
                text: linkText,
                icon: "success",
                loader: !0,
                position: "top-right",
                hideAfter: !1,
                stack: 1
            })
        } else
            $.toast({
                heading: "Error",
                text: data.msg,
                icon: "error",
                loader: !1,
                position: "top-right",
                hideAfter: 4e3,
                stack: 1
            })
    }
};
$(document).on("click", ".file-button-download", function() {
    setTimeout(function() {
        toastMsg && toastMsg.reset()
    }, 3e3);
    var type = $(this).data("linktype");
    if ("jpeg" == type) {
        var density = $('[name="jpegRadioDensity"]:checked').val();
        registerCallBack("JPEG", {
            dpi: density,
            saveBleed: $("input#savebleed").is(":checked")
        })
    } else if ("png" == type) {
        density = $('[name="pngRadioDensity"]:checked').val();
        registerCallBack("PNG", {
            dpi: density
        })
    } else
        registerCallBack("PDF", {
            saveCrop: $("input#savecrop").is(":checked"),
            savePaper: $("input#savePaper").is(":checked")
        })
});
var pageSizes = [{
    size: "us-legal",
    width: 8.5,
    height: 14,
    active: !1,
    id: "#btn_type_legal"
}, {
    size: "us-letter",
    width: 8.5,
    height: 11,
    active: !0,
    id: "#btn_type_us"
}, {
    size: "a4",
    width: 8.3,
    height: 11.7,
    active: !0,
    id: "#btn_type_a4"
}, {
    size: "a3",
    width: 11.7,
    height: 16.5,
    active: !1,
    id: "#btn_type_a3"
}, {
    size: "a2",
    width: 16.5,
    height: 23.4,
    active: !1,
    id: "#btn_type_a2"
}];
$("#savecrop, #savebleedPdf, #savePaper").on("change", function() {
    checkSavePaper().length > 0 ? $(".savePaperRow").show() : ($("#selectSize").attr("aria-expanded", !1),
    $("#selectSize").removeClass("in"),
    $("#savePaper").prop("checked", !1),
    $(".savePaperRow").hide()),
    getPreview()
}),
$("#btn_type_a4, #btn_type_us").on("click", function() {
    checkSavePaper(),
    getPreview()
});
var checkSavePaper = function(fn) {
    globalRow = parseInt($("#numOfcanvasrows").val()),
    globalCol = parseInt($("#numOfcanvascols").val());
    var canvases = canvasarray
      , canvasWidth = canvases[0].get("width") / canvases[0].getZoom()
      , canvasHeight = canvases[0].get("height") / canvases[0].getZoom()
      , multi = 0
      , bleed = $("#savebleedPdf").is(":checked")
      , trimsMarks = $("#savecrop").is(":checked");
    (bleed || trimsMarks) && (multi = 2),
    bleed && trimsMarks && (multi = 4),
    canvasWidth = canvasWidth * globalCol + 12 * multi,
    canvasHeight = canvasHeight * globalRow + 12 * multi;
    for (var validPageSizes = [], activeFormats = pageSizes.filter(function(pageSize) {
        return pageSize.active
    }), i = 0; i < activeFormats.length; i++)
        isValidForPage(activeFormats[i], canvasWidth, canvasHeight) && validPageSizes.push(activeFormats[i]);
    $(".paper-size").parent().addClass("editor-disabled"),
    $(".paper-size").removeClass("active");
    for (i = 0; i < validPageSizes.length; i++)
        0 == i && $(validPageSizes[i].id).addClass("active"),
        $(validPageSizes[i].id).parent().removeClass("editor-disabled");
    return null != fn && fn(),
    validPageSizes
}
  , isValidForPage = function(pageSize, canvasWidth, canvasHeight) {
    var pageWidthPx = 96 * pageSize.width
      , pageHeightPx = 96 * pageSize.height;
    return pageWidthPx * pageHeightPx >= 2 * canvasWidth * canvasHeight && (2 * canvasWidth <= pageWidthPx && canvasHeight <= pageHeightPx || 2 * canvasHeight <= pageHeightPx && canvasWidth <= pageWidthPx || 2 * canvasWidth <= pageHeightPx && canvasHeight <= pageWidthPx || 2 * canvasHeight <= pageWidthPx && canvasWidth <= pageHeightPx)
}
  , ajaxRequestRef = null
  , previewRequestId = ""
  , getPreview = function() {}
  , showPreviewPdf = function(data) {
    if (data.requestId == previewRequestId)
        if (hideLoadingSpin(),
        1 == data.success) {
            var newImg = $("<img/>");
            $(newImg).attr("src", data.svg),
            $("#preview-div").append(newImg),
            $("img").one("load", function() {
                var imgWidth = $(newImg).get(0).naturalWidth
                  , originalWidth = imgWidth
                  , imgHeight = $(newImg).get(0).naturalHeight
                  , ratioY = 300 / imgHeight;
                ratioY < 1 && (imgWidth *= ratioY,
                imgHeight *= ratioY),
                $("#preview-div img").css("width", imgWidth),
                $("#preview-div img").css("height", imgHeight),
                $("#preview-div img").css("margin-top", (360 - imgHeight) / 2),
                $("#preview-div img").css("background", "#FFF"),
                $("#preview-div img").css("box-shadow", "1px 1px 6px 2px rgba(0,0,0,0.2)"),
                $("#preview-div img").css("transform-origin", "top left"),
                $("#preview-div img").css("transform", "scale(1)"),
                $("#preview-div img").css("transition", "transform 1s ease");
                var bleed = $("#savebleedPdf").is(":checked");
                ($("#savecrop").is(":checked") || bleed) && (stopLoop = !1,
                toggleLoop = !1,
                clearTimeout(timeOutRef),
                previewLoopZoom(5 * originalWidth, imgWidth))
            })
        } else {
            var divTitle = $("<div/>");
            $(divTitle).html(data.msgTitle),
            $(divTitle).css("margin-top", 150);
            var divText = $("<div/>");
            $(divText).html(data.msgText),
            $("#preview-div").html(""),
            $("#preview-div").append(divTitle),
            $("#preview-div").append(divText)
        }
}
  , stopLoop = !1
  , toggleLoop = !1
  , timeOutRef = 0
  , previewLoopZoom = function previewLoopZoom(originalWidth, svgWidth) {
    var scaleValue = 1;
    (toggleLoop = !toggleLoop) && (scaleValue = originalWidth / svgWidth * 2),
    timeOutRef = setTimeout(function() {
        $("#preview-div svg").css("transform", "scale(" + scaleValue + ")"),
        stopLoop || previewLoopZoom(originalWidth, svgWidth)
    }, 5e3)
}
  , showLoadingSpin = function() {
    $("#pdf-preview-div .loading-spin").show()
}
  , hideLoadingSpin = function() {
    $("#pdf-preview-div .loading-spin").hide()
};
function getTemplateThumbnail() {
    var firstcanvas = canvasarray[currentcanvasid]
      , initialZoom = firstcanvas.getZoom()
      , isEmptyBackground = !1;
    setZoom(1200 / (96 * document.getElementById("loadCanvasWid").value)),
    firstcanvas.backgroundColor || (isEmptyBackground = !0,
    firstcanvas.set({
        backgroundColor: "#ffffff"
    })),
    "geofilter2" == template_type && removeGeofilterOverlay();
    var dataURL = firstcanvas.toDataURL({
        format: "jpeg",
        quality: .9
    });
    return "geofilter2" == template_type && setGeofilterOverlay(),
    isEmptyBackground && firstcanvas.set({
        backgroundColor: ""
    }),
    setZoom(initialZoom),
    dataURL
}
function saveAsTemplateFile() {
    issaveastemplate = !1,
    s_history = !1;
    var $metrics = $("input[name=metric_units1]:checked").val()
      , filename = $("#templatename").val()
      , $tags = JSON.parse(newTemplateTagsEdit.getTags()).join(",")
      , jsonData = getTemplateJson()
      , pngdataURL = getTemplateThumbnail()
      , saveToAdminAccount = $("input[name=saveToAdminAccount]:checked").val()
      , url = appUrl + "editor/template/save-as";
    $.post(url, {
        pngimageData: pngdataURL,
        filename: filename,
        jsonData: jsonData,
        tags: $tags,
        metrics: $metrics,
        design_as_id: design_as_id,
        type: template_type,
        geofilterBackground: geofilterBackground,
        instructionsId: instructionsId,
        saveToAdminAccount: saveToAdminAccount
    }).done(function(msg) {
        if (IsJsonString(msg)) {
            var $msg = JSON.parse(msg);
            void 0 !== $msg && 0 === $msg.err ? (loadedtemplateid = $msg.id,
            $("#savetemplate").show(),
            $(".download-menu").show(),
            newTemplateTagsEdit.clean(),
            $.toast({
                text: "Saved as new template",
                icon: "success",
                loader: !1,
                position: "top-right"
            })) : $.toast({
                text: "Error while saving. " + $msg.msg,
                icon: "error",
                loader: !1,
                position: "top-right"
            })
        } else
            $.toast({
                text: "An error occurred while saving the template",
                icon: "error",
                loader: !1,
                position: "top-right"
            })
    }).always(function() {
        appSpinner.hide(),
        s_history = !0
    })
}
function normalizeSvgScale($src, $dest) {
    if (!$src || !$dest)
        return !1;
    if (!$src._objects || !$dest._objects)
        return !1;
    var $src_options = fabric.util.qrDecompose($src.calcOwnMatrix());
    $src.forEachObject(function($o, $i) {
        var matrix = $o.calcOwnMatrix()
          , options = fabric.util.qrDecompose(matrix)
          , center = new fabric.Point(options.translateX,options.translateY)
          , object = $dest._objects[$i];
        object.flipX = !1,
        object.flipY = !1,
        object.set("scaleX", options.scaleX),
        object.set("scaleY", options.scaleY),
        object.skewX = options.skewX,
        object.skewY = options.skewY,
        object.angle = options.angle,
        object.setPositionByOrigin(center, "center", "center")
    }),
    $dest._calcBounds(),
    $dest.setCoords();
    var $center = new fabric.Point($src_options.translateX,$src_options.translateY);
    return $dest.set({
        angle: $src.angle,
        scaleX: $src_options.scaleX,
        scaleY: $src_options.scaleY,
        skewX: $src_options.skewX,
        skewY: $src_options.skewY,
        flipX: $src.flipX,
        flipY: $src.flipY
    }),
    $dest.setPositionByOrigin($center, "center", "center"),
    $dest.setCoords(),
    !0
}
function getTemplateJson() {
    var jsonCanvasArray = []
      , width = document.getElementById("loadCanvasWid").value
      , height = document.getElementById("loadCanvasHei").value
      , rows = document.getElementById("numOfcanvasrows").value
      , cols = document.getElementById("numOfcanvascols").value
      , wh = '{"width": ' + (width = (96 * width).toFixed(2)) + ', "height": ' + (height = (96 * height).toFixed(2)) + ', "rows": ' + rows + ', "cols": ' + cols + "}";
    jsonCanvasArray.push(wh),
    DEBUG && console.log(canvasindex),
    DEBUG && console.log(jsonCanvasArray);
    for (var i = 0; i < canvasindex; i++)
        if (canvasarray[i]) {
            var tempData = JSON.parse(JSON.stringify(canvasarray[i].toDatalessJSON(properties_to_save)));
            $.each(tempData.objects, function(object_i, object) {
                DEBUG && console.log("getTemplateJson() object", object),
                isSvg(object) && (object.objects && $useKeepSvgGroups && $.each(object.objects, function($i, $child) {
                    $child.svg_custom_paths && $child.svg_custom_paths.length && (object.svg_custom_paths || (object.svg_custom_paths = []),
                    object.svg_custom_paths = {
                        svg_custom_paths: $child.svg_custom_paths
                    })
                }),
                object.path = [],
                object.objects = []),
                void 0 !== object._objects && (object._objects = []),
                "path" == object.type && object.fill && object.svg_custom_paths && 1 == object.svg_custom_paths.length && delete object.svg_custom_paths,
                function removeDpatternSource($o) {
                    "object" === _typeof($o.fill) && "Dpattern" == $o.fill.type && delete $o.fill.source,
                    $o.objects && $.each($o.objects, function($i, $child) {
                        return removeDpatternSource($child)
                    })
                }(object)
            }),
            canvasarray[i].discardActiveObject().renderAll(),
            $("#divcanvas" + i).is(":visible") && jsonCanvasArray.push(tempData)
        }
    return JSON.stringify(jsonCanvasArray).replace(/"backgroundImage":{.*?}/gi, '"backgroundImage":""')
}
function updateTemplate(updateOriginal) {
    return DEBUG && console.log("updateTemplate"),
    new Promise(function(resolve, reject) {
        if (stopProcess)
            reject();
        else {
            var updateOriginal = updateOriginal || 0;
            if (s_history = !1,
            totalsvgs == convertedsvgs && 0 != loadedtemplateid) {
                isupdatetemplate = !1;
                var jsonData = getTemplateJson();
                if (!IsJsonString(jsonData))
                    return $.toast({
                        text: "An error occurred while saving the template",
                        icon: "error",
                        loader: !1,
                        position: "top-right"
                    }),
                    void reject();
                var metrics = $("input[name=metric_units1]:checked").val()
                  , pngdataURL = getTemplateThumbnail()
                  , crc = crc32(jsonData)
                  , url = appUrl + "editor/template/update";
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        language_code: language_code,
                        templateid: loadedtemplateid,
                        pngimageData: pngdataURL,
                        jsonData: jsonData,
                        metrics: metrics,
                        crc: crc,
                        design_as_id: design_as_id,
                        type: template_type,
                        geofilterBackground: geofilterBackground,
                        instructionsId: instructionsId,
                        updateOriginal: updateOriginal
                    },
                    dataType: "json"
                }).done(function(answer) {
                    appSpinner.hide();
                    var icon = answer.err ? "error" : "success"
                      , text = answer.err ? answer.msg : "Template saved";
                    $.toast({
                        text: text,
                        icon: icon,
                        loader: !1,
                        position: "top-right"
                    }),
                    answer.err || ("customer" == currentUserRole && getTemplates2(0, ""),
                    $("#autosave").data("saved", "yes")),
                    s_history = !0,
                    resolve()
                }).fail(function() {
                    appSpinner.hide(),
                    $.toast({
                        heading: "Error saving template",
                        text: "Please try again",
                        icon: "error",
                        loader: !1,
                        position: "top-right",
                        hideAfter: 5e3
                    })
                })
            }
        }
    }
    )
}
$("#progressModal").on("shown.bs.modal", function(e) {
    $("#savePaper").is(":checked") ? $("input#savecrop").is(":checked") && 1 === globalCol && 1 === globalRow ? createBleedForPDF({
        callback: removeDeletedCanvasesProxy
    }) : removeDeletedCanvasesProxy() : $("input#savecrop").is(":checked") && 1 === globalCol && 1 === globalRow ? createBleedForPDF({
        callback: rasterizeObjectsProxy
    }) : removeDeletedCanvases(canvasarray, rasterizeObjectsProxy)
});
var newTextTagsEdit = $("#newTextTags").tagsField({
    label: "Tags",
    id: "text_tags",
    labelColumnClass: "control-label",
    divColumnClass: ""
});
function saveFromSelection(callback) {
    if (newTextTagsEdit.validate())
        if ("undefined" != typeof canvas) {
            var actobj = canvas.getActiveObject()
              , actgroupobjs = canvas.getActiveObject();
            if (tempcanvas.clear(),
            actobj)
                actobj.clone(function(clone) {
                    tempcanvas.setWidth(clone.width * clone.scaleX),
                    tempcanvas.setHeight(clone.height * clone.scaleY),
                    clone.originX = "center",
                    clone.originY = "center",
                    tempcanvas.add(clone),
                    clone.viewportCenter();
                    var jsonData = JSON.stringify({
                        objects: [clone.toJSON(properties_to_save)]
                    })
                      , pngdataURL = clone.toDataURL("image/png");
                    callback(pngdataURL, jsonData)
                });
            else if (actgroupobjs) {
                console.log(actgroupobjs + "--" + _typeof(actgroupobjs)),
                tempcanvas.setWidth(actgroupobjs.width * actgroupobjs.scaleX),
                tempcanvas.setHeight(actgroupobjs.height * actgroupobjs.scaleY);
                var totalobjs = actgroupobjs.getObjects().length
                  , loadedobjs = 0
                  , jsonData = "";
                actgroupobjs.forEachObject(function(object) {
                    object.clone(function(clone) {
                        if (tempcanvas.add(clone),
                        clone.set("left", clone.left + tempcanvas.width / 2),
                        clone.set("top", clone.top + tempcanvas.height / 2),
                        ++loadedobjs >= totalobjs) {
                            jsonData += JSON.stringify({
                                objects: [actgroupobjs.toJSON(properties_to_save)]
                            });
                            var pngdataURL = tempcanvas.toDataURL("image/png");
                            callback(pngdataURL, jsonData)
                        }
                    })
                })
            } else
                $("#alertModal").modal("show"),
                $("#responceMessage").html("Please select the object you wish to save.")
        } else
            $("#alertModal").modal("show"),
            $("#responceMessage").html("Please select the object you wish to save.")
}
function saveAsText(pngdataURL, jsonData) {
    var $tags = JSON.parse(newTextTagsEdit.getTags()).join(",")
      , filename = $("#textname").val()
      , url = appUrl + "design/savetext.php";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            pngimageData: pngdataURL,
            filename: filename,
            jsonData: jsonData,
            tags: $tags
        },
        success: function(data) {
            $answer = JSON.parse(data),
            $answer.err ? $.toast({
                text: $answer.msg,
                loader: !1,
                hideafter: !1,
                icon: "error",
                position: "top-right"
            }) : (getTexts2(0, ""),
            $.toast({
                text: $answer.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            }))
        }
    })
}
function saveAsElement(pngdataURL, jsonData) {
    var filename = $("#elmtname").val()
      , $tags = JSON.parse(newElementTagsEdit.getTags()).join(",");
    appSpinner.show();
    var url = appUrl + "design/saveasjson.php";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            filename: filename,
            pngdataURL: pngdataURL,
            jsonData: jsonData,
            tags: $tags
        },
        success: function(data) {
            appSpinner.hide(),
            $answer = JSON.parse(data),
            $answer.err ? $.toast({
                text: $answer.msg,
                loader: !1,
                hideafter: !1,
                icon: "error",
                position: "top-right"
            }) : $.toast({
                text: $answer.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            })
        }
    })
}
function proceed_savetemplate() {
    $("#savetemplate_modal").is(":visible") && !newTemplateTagsEdit.validate() || ($("#savetemplate_modal").modal("hide"),
    appSpinner.show(),
    $("#saveastemplate").show(),
    canvas.discardActiveObject().renderAll(),
    processSVGs())
}
function downloadImage() {
    $("#publishModal").modal("hide"),
    appSpinner.show();
    var cwidth = document.getElementById("loadCanvasWid").value
      , cheight = document.getElementById("loadCanvasHei").value
      , cols = document.getElementById("numOfcanvascols").value
      , rows = document.getElementById("numOfcanvasrows").value;
    setZoom(1),
    cwidth *= 96,
    cheight *= 96;
    var buffer = document.getElementById("outputcanvas")
      , buffer_context = buffer.getContext("2d");
    buffer.width = parseInt(cwidth) * parseInt(cols);
    var hiddencanvascount = parseInt(cols) * parseInt(rows) * (pageindex + 1) - $(".divcanvas:visible").length;
    buffer.height = parseInt(cheight) * (parseInt(rows) * (pageindex + 1) - hiddencanvascount / parseInt(cols));
    for (var writtenpages = 0, processpages = 0, rowcount = 0, colcount = 0, i = 0; i < canvasindex; i++)
        canvasarray[i] && (canvasarray[i].discardActiveObject().renderAll(),
        $("#divcanvas" + i).is(":visible") && (processpages++,
        colcount >= cols && (colcount = 0,
        rowcount++),
        w = cwidth * colcount,
        colcount++,
        function(li, c, r) {
            var img = new Image;
            img.onload = function() {
                if (buffer_context.drawImage(this, c, r),
                ++writtenpages == processpages) {
                    var canvasele = document.getElementById("outputcanvas")
                      , id = loadedtemplateid;
                    0 === loadedtemplateid && (id = "new");
                    var filename = "wayak_" + id + ".png"
                      , img = canvasele.toDataURL({
                        format: "png",
                        quality: 1
                    })
                      , url = appUrl + "design/saveimage.php";
                    $.post(url, {
                        file: filename,
                        data: img
                    }).done(function($answer) {
                        $answer.length > 1 && ($("#autosave").data("saved", "yes"),
                        window.location.href = appUrl + "design/downloadfile.php?file=" + $answer + "&filename=" + filename)
                    }).always(function() {
                        appSpinner.hide(),
                        setZoom($("#zoomperc").data("oldScaleValue"))
                    })
                }
            }
            ,
            img.src = canvasarray[li].toDataURL({
                format: "png",
                multiplier: 1 / fabric.devicePixelRatio
            })
        }(i, w, cheight * rowcount)))
}
function makeObjectNotSelectable($object) {
    return $object || ($object = canvas.getActiveObject()),
    !!$object && ($object.set("locked", !0),
    /text/.test($object.type) && $object.set("editable", !1),
    canvas.discardActiveObject(),
    canvas.setActiveObject($object),
    !0)
}
function makeObjectSelectable($object) {
    return $object || ($object = canvas.getActiveObject()),
    !!$object && ($object.set("locked", !1),
    /text/.test($object.type) && $object.set("editable", !0),
    $object.setControlsVisibility({
        bl: !0,
        br: !0,
        tl: !0,
        tr: !0,
        ml: !0,
        mr: !0,
        mt: !0,
        mtr: !0,
        mb: !0
    }),
    $object.set({
        lockMovementY: !1,
        lockMovementX: !1
    }),
    canvas.discardActiveObject(),
    canvas.setActiveObject($object),
    !0)
}
function savesvg(svgobj) {
    var lsvgobj;
    tempcanvas.clear(),
    (lsvgobj = svgobj).clone(function(clone) {
        tempcanvas.width = clone.width * clone.scaleX,
        tempcanvas.height = clone.height * clone.scaleY,
        clone.originX = "center",
        clone.originY = "center",
        clone.angle = 0,
        tempcanvas.add(clone),
        clone.viewportCenter(),
        svgData = tempcanvas.toSVG();
        var $thumb = tempcanvas.tempcanvas.toDataURL({
            format: "jpeg",
            quality: .7
        });
        DEBUG && console.log(svgData);
        var filename = $("#elmtname").val();
        lsvgobj.visible = path + filename + ".svg";
        var url = appUrl + "design/savesvg.php";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                filename: filename,
                svgData: svgData,
                thumb: $thumb
            },
            success: function(msg) {
                convertedsvgs++,
                isdownloadpdf && downloadDocument(),
                isupdatetemplate && updateTemplate()
            }
        })
    }),
    isdownloadpdf && downloadDocument(),
    isupdatetemplate && updateTemplate()
}
var savecrop = !1
  , $svgs = 0
  , $additionalHeight = 0;
function getBg($obj, scalex) {
    return DEBUG && console.log("getBg()"),
    DEBUG && console.log("scaleX", scalex),
    new Promise(function(resolve, reject) {
        if (void 0 !== $obj) {
            window.$obj = $obj;
            var bgsrc = $obj.bgsrc
              , $zoom = $obj.getZoom() || 1;
            bgsrc && fabric.Image.fromURL(bgsrc, function(img3) {
                img3.get("width") > img3.get("height") ? img3.scaleToHeight($obj.get("height") / $zoom) : img3.scaleToWidth($obj.get("width") / $zoom);
                var patternSourceCanvas = new fabric.StaticCanvas;
                patternSourceCanvas.add(img3),
                patternSourceCanvas.renderAll(),
                $obj.bgImg = img3,
                $obj.patternSourceCanvas = patternSourceCanvas;
                var pattern = new fabric.Pattern({
                    source: function() {
                        return $obj.patternSourceCanvas.setDimensions({
                            width: $obj.bgImg.get("width") * $obj.bgImg.get("scaleX"),
                            height: $obj.bgImg.get("height") * $obj.bgImg.get("scaleY")
                        }),
                        $obj.patternSourceCanvas.renderAll(),
                        $obj.patternSourceCanvas.getElement()
                    },
                    repeat: "repeat"
                });
                resolve(pattern)
            }, {
                crossOrigin: "anonymous"
            }),
            !bgsrc && $obj.backgroundColor && resolve($obj.backgroundColor),
            bgsrc || $obj.backgroundColor || resolve("")
        } else
            reject("canvas or object is not exist")
    }
    )
}
function createBgPatternWithBleed($obj) {
    return DEBUG && console.log("createBgPatternWithBleed()"),
    new Promise(function(resolve, reject) {
        if (void 0 !== $obj) {
            var $bgsrc = $obj.bgsrc;
            $bgsrc && fabric.Image.fromURL($obj.bgsrc, function($img) {
                var $tc = new fabric.StaticCanvas
                  , $scale = 3.125 * $obj.bgImg.scaleX;
                $img.scale($scale),
                $tc.setDimensions({
                    width: 3.125 * $obj.get("width") + 2 * $img.get("width"),
                    height: 3.125 * $obj.get("height") + 2 * $img.get("height")
                });
                for (var $x = -$img.get("width") * $scale + 37.5 / fabric.devicePixelRatio, $y = -$img.get("height") * $scale + 37.5 / fabric.devicePixelRatio; $y < $tc.get("height"); ) {
                    for (; $x < $tc.get("width"); ) {
                        var $timg = fabric.util.object.clone($img);
                        $tc.add($timg),
                        $timg.set({
                            left: $x,
                            top: $y
                        }),
                        $x += $timg.get("width") * $scale
                    }
                    $y += $timg.get("height") * $scale,
                    $x = -$img.get("width") * $scale + 37.5 / fabric.devicePixelRatio
                }
                $tc.renderAll(),
                resolve($tc.toDataURL({
                    multiplier: 1,
                    format: "jpeg",
                    quality: .5,
                    left: 0,
                    top: 0,
                    width: 3.125 * $obj.get("width") / fabric.devicePixelRatio,
                    height: 3.125 * $obj.get("height") / fabric.devicePixelRatio
                }))
            }, {
                crossOrigin: "anonymous"
            }),
            !$bgsrc && $obj.backgroundColor && resolve($tc.backgroundColor),
            $bgsrc || $obj.backgroundColor || resolve("")
        } else
            reject("canvas or object is not exist")
    }
    )
}
function getBg2($obj, scalex) {
    return new Promise(function(resolve, reject) {
        if (void 0 !== $obj) {
            var $bgsrc = $obj.bgsrc
              , $zoom = $obj.getZoom() || 1
              , $tc = new fabric.StaticCanvas
              , $w = $obj.get("width") / $zoom * 3.125
              , $h = $obj.get("height") / $zoom * 3.125
              , rows = parseInt($("#numOfcanvasrows").val())
              , cols = parseInt($("#numOfcanvascols").val());
            DEBUG && console.log("getBg2()"),
            DEBUG && console.log("width: " + $w + " height: " + $h),
            $tc.setDimensions({
                width: $w,
                height: $h
            }),
            $bgsrc && fabric.Image.fromURL($bgsrc, function($img) {
                var $scale = 3.125 * $obj.bgImg.scaleX;
                $img.scale($scale);
                for (var $x = 0, $y = 0; $y < $tc.get("height"); ) {
                    for (; $x < $tc.get("width"); ) {
                        var $timg = fabric.util.object.clone($img);
                        $tc.add($timg),
                        $timg.set({
                            left: $x,
                            top: $y
                        }),
                        $x += $timg.get("width") * $scale
                    }
                    $y += $timg.get("height") * $scale,
                    $x = 0
                }
                if ($tc.renderAll(),
                $("input#savecrop").is(":checked") && rows + cols < 3)
                    var width = ($w - 75) / fabric.devicePixelRatio
                      , height = ($h - 75) / fabric.devicePixelRatio;
                else
                    width = $w / fabric.devicePixelRatio,
                    height = $h / fabric.devicePixelRatio;
                resolve($tc.toDataURL({
                    multiplier: fabric.devicePixelRatio,
                    format: "jpeg",
                    quality: .3,
                    left: 0,
                    top: 0,
                    width: width,
                    height: height
                }))
            }, {
                crossOrigin: "anonymous"
            }),
            !$bgsrc && $obj.backgroundColor && resolve($tc.backgroundColor),
            $bgsrc || $obj.backgroundColor || resolve("")
        } else
            reject("canvas or object is not exist")
    }
    )
}
function createBleed($options) {
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , $canvasesWithBleed = $options.canvasesWithBleed || []
      , $callback = $options.callback || downloadImage2
      , $i = $options.i || 0;
    DEBUG && console.log("createBleed");
    var $cwidth = parseInt($canvases[$i].get("width") + 24)
      , $cheight = parseInt($canvases[$i].get("height") + 24)
      , _el = fabric.util.createCanvasElement();
    _el.width = $cwidth,
    _el.height = $cheight,
    $canvasesWithBleed[$i] = new fabric.StaticCanvas(_el),
    $canvasesWithBleed[$i].setDimensions({
        width: $cwidth,
        height: $cheight
    }),
    $canvasesWithBleed[$i].loadFromJSON(JSON.stringify($canvases[$i].toDatalessJSON(properties_to_save)), function() {
        $canvases[++$i] ? createBleed({
            canvases: $canvases,
            i: $i,
            callback: $callback,
            canvasesWithBleed: $canvasesWithBleed
        }) : setTimeout(function() {
            $callback({
                canvases: $canvasesWithBleed
            })
        }, 100)
    }, function(o, object) {
        DEBUG && console.log("object's left: " + object.left + " object's top: " + object.top),
        object.set({
            left: object.left + 12,
            top: object.top + 12
        }),
        object.setCoords()
    })
}
function removeDeletedCanvasesProxy($options) {
    DEBUG && console.log("removeDeletedCanvasesProxy $canvases:"),
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray;
    DEBUG && console.log($canvases),
    rasterizeObjectsProxy({
        canvases: $canvases,
        callback: removeDeletedCanvases
    })
}
function createBleedForPDF($options) {
    DEBUG && console.log("createBleedForPDF"),
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , $i = $options.i || 0
      , $canvasesWithBleed = $options.canvasesWithBleed || []
      , $callback = $options.callback || downloadDocument;
    DEBUG && console.log("createBleedForPDF i: " + $i);
    var $cwidth = parseInt($canvases[$i].get("width") + 24)
      , $cheight = parseInt($canvases[$i].get("height") + 24)
      , _el = fabric.util.createCanvasElement();
    _el.width = $cwidth,
    _el.height = $cheight,
    $canvasesWithBleed[$i] = new fabric.StaticCanvas(_el),
    $canvasesWithBleed[$i].setDimensions({
        width: $cwidth,
        height: $cheight
    }),
    $canvasesWithBleed[$i].loadFromJSON(JSON.stringify($canvases[$i].toDatalessJSON(properties_to_save)), function() {
        $canvases[++$i] ? createBleedForPDF({
            canvases: $canvases,
            i: $i,
            canvasesWithBleed: $canvasesWithBleed,
            callback: $callback
        }) : setTimeout(function() {
            $callback({
                canvases: $canvasesWithBleed
            })
        }, 100)
    }, function(o, object) {
        DEBUG && console.log("object's left: " + object.left + " object's top: " + object.top),
        object.set({
            left: object.left + 12,
            top: object.top + 12
        }),
        object.setCoords()
    })
}
function downloadImage3($options) {
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , i = $options.i || 0
      , $format = $options.format || "jpeg"
      , $zip = $options.zip || new JSZip;
    "jpg" === $format && ($format = "jpeg");
    var filename = "wayak_" + (i + 1) + "." + $format
      , id = loadedtemplateid;
    "jpeg" === $format && ($canvases[i].backgroundColor || $canvases[i].set({
        backgroundColor: "#ffffff"
    })),
    $canvases[i].setDimensions();
    var metrics = $("input[name=metric_units1]:checked").val()
      , multiplier = 1;
    ("jpeg" == $format || "png" == $format && "px" == metrics && !/geofilter/.test(template_type)) && (multiplier = 3.125);
    var dataURL = $canvases[i].toDataURL({
        format: $format,
        quality: 1,
        multiplier: multiplier / fabric.devicePixelRatio,
        enableRetinaScaling: 1
    });
    if (dataURL = $canvases[i].toDataURL({
        format: $format,
        quality: 1,
        multiplier: multiplier / fabric.devicePixelRatio,
        enableRetinaScaling: 1
    }),
    "jpeg" == $format ? dataURL = setJpegDPI(dataURL) : "png" == $format && "geofilter" != template_type && "geofilter2" != template_type && (dataURL = setPngDPI(dataURL)),
    dataURL = dataURL.split("base64,")[1],
    $zip.file(filename, dataURL, {
        base64: !0
    }),
    $canvases[++i])
        downloadImage3({
            canvases: $canvases,
            i: i,
            format: $format,
            zip: $zip
        });
    else {
        0 === loadedtemplateid && (id = "new");
        filename = "wayak_" + id + ".zip";
        isMac && isSafari ? $zip.generateAsync({
            type: "base64"
        }).then(function(content) {
            var url = appUrl + "design/savezip.php";
            $.post(url, {
                file: filename,
                data: content
            }).done(function($answer) {
                var $parsedAnswer = JSON.parse($answer);
                $parsedAnswer.err ? saveAs(content, filename) : window.location.href = appUrl + "design/downloadfile.php?file=" + $parsedAnswer.msg + "&filename=" + filename
            }).fail(function() {
                saveAs(content, filename)
            }).always(function() {
                appSpinner.hide(),
                setZoom($("#zoomperc").data("oldScaleValue"))
            })
        }) : $zip.generateAsync({
            type: "blob"
        }).then(function(blob) {
            appSpinner.hide(),
            setZoom($("#zoomperc").data("oldScaleValue")),
            saveAs(blob, filename)
        }),
        toggleHiddenStatusOfObjects()
    }
}
function downloadImage2($options) {
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , $format = $options.format || "jpeg";
    "jpg" === $format && ($format = "jpeg");
    var id = loadedtemplateid;
    0 === loadedtemplateid && (id = "new");
    var filename = "wayak_" + id + "." + $format
      , metrics = $("input[name=metric_units1]:checked").val()
      , multiplier = 1;
    ("jpeg" == $format || "png" == $format && "px" == metrics && !/geofilter/.test(template_type)) && (multiplier = 3.125);
    for (var $i = 0; $i < $canvases.length; ) {
        if ($canvases[$i]) {
            "jpeg" == $format && ($canvases[$i].backgroundColor || $canvases[$i].set({
                backgroundColor: "#ffffff"
            })),
            $canvases[$i].setDimensions(),
            "geofilter2" == template_type && removeGeofilterOverlay();
            var dataURL = $canvases[$i].toDataURL({
                format: $format,
                quality: 1,
                multiplier: multiplier / fabric.devicePixelRatio,
                enableRetinaScaling: 1
            });
            if (dataURL = $canvases[$i].toDataURL({
                format: $format,
                quality: 1,
                multiplier: multiplier / fabric.devicePixelRatio,
                enableRetinaScaling: 1
            }),
            "geofilter2" == template_type && setGeofilterOverlay(),
            "jpeg" == $format ? dataURL = setJpegDPI(dataURL) : "png" == $format && "geofilter" != template_type && "geofilter2" != template_type && (dataURL = setPngDPI(dataURL)),
            isMac && isSafari || "png" == $format && "geofilter" == template_type || "png" == $format && "geofilter2" == template_type) {
                var url = appUrl + "design/saveimage.php";
                $.post(url, {
                    file: filename,
                    data: dataURL,
                    template_type: template_type
                }).done(function($answer) {
                    $answer.length > 1 && ($("#autosave").data("saved", "yes"),
                    window.location.href = appUrl + "design/downloadfile.php?file=" + $answer + "&filename=" + filename)
                }).fail(function() {
                    var blob = dataURItoBlob(dataURL);
                    saveAs(blob, filename)
                }).always(function() {
                    appSpinner.hide(),
                    setZoom($("#zoomperc").data("oldScaleValue"))
                })
            } else {
                appSpinner.hide();
                var blob = dataURItoBlob(dataURL);
                saveAs(blob, filename)
            }
        }
        $i++
    }
    setZoom($("#zoomperc").data("oldScaleValue")),
    toggleHiddenStatusOfObjects()
}
function removeDeletedCanvases($canvases, $callback) {
    $canvases = $canvases || canvasarray;
    for (var $i = 0, $newArray = []; $i < $canvases.length; )
        $("#divcanvas" + $i).is(":visible") && $canvases[$i] && $newArray.push($canvases[$i]),
        $i++;
    $callback || ($callback = groupCanvasesOfOnePage),
    DEBUG && console.log("removeDeletedCanvases canvases: " + $newArray),
    $callback({
        canvases: $newArray
    })
}
function groupCanvasesOfOnePage($options) {
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , i = $options.i || 0
      , $localI = $options.localI || 0;
    DEBUG && console.log("i: " + i);
    var $cmp = 0;
    $("input#savecrop").is(":checked") && ($cmp = 12);
    var $groupedCanvases = $options.groupedCanvases || []
      , rows = parseInt($("#numOfcanvasrows").val())
      , cols = parseInt($("#numOfcanvascols").val())
      , $canvasWidth = $canvases[0].get("width") / $canvases[0].getZoom()
      , $canvasHeight = $canvases[0].get("height") / $canvases[0].getZoom()
      , $width = cols * $canvasWidth
      , $height = rows * $canvasHeight;
    DEBUG && console.log("height: " + $height),
    DEBUG && console.log("groupCanvasesOfOnePage $canvasWidth :" + $canvasWidth);
    var visibleCanvases = $canvases.length
      , tempcanvas3 = $options.tempcanvas || new fabric.StaticCanvas;
    tempcanvas3.width = $width,
    tempcanvas3.height = $height,
    i > 0 && i % (cols * rows) == 0 && ($groupedCanvases.push(tempcanvas3),
    tempcanvas3 = new fabric.StaticCanvas,
    $localI = 0),
    DEBUG && console.log("$localI: " + $localI),
    DEBUG && console.log("visibleCanvases: " + visibleCanvases);
    var obj = new fabric.Group($canvases[i]._objects);
    tempcanvas3.add(obj),
    tempcanvas3.moveTo(obj, $localI);
    var $posInRow = Math.floor($localI / cols)
      , $left = $canvasWidth * ($localI - $posInRow * cols)
      , $top = $canvasHeight * $posInRow;
    if (DEBUG && console.log("left: " + $left),
    DEBUG && console.log("top: " + $top),
    obj.set({
        left: obj.left + $left,
        top: obj.top + $top
    }),
    obj.calcCoords(),
    DEBUG && console.log("groupCanvasesOfOnePage: object id: " + i),
    DEBUG && console.log("groupCanvasesOfOnePage: transform matrix: "),
    DEBUG && console.log(obj.calcTransformMatrix()),
    obj.setCoords(),
    $cmp > 0)
        if (1 === cols && 1 === rows) {
            var $color = "#000000"
              , $gap = 0
              , $zIndex = 9999
              , $strokeWidth = .5
              , $correction = .25
              , $tl_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left - $strokeWidth + $gap - $cmp,
                top: $top + $cmp - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tl_h),
            tempcanvas3.moveTo($tl_h, $zIndex);
            var $tl_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left + $cmp - $correction,
                top: $top - $strokeWidth + $gap - $cmp,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tl_v),
            tempcanvas3.moveTo($tl_v, $zIndex);
            var $tr_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left + $canvasWidth - 0 - $gap,
                top: $top + $cmp - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tr_h),
            tempcanvas3.moveTo($tr_h, $zIndex);
            var $tr_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left - $cmp + $canvasWidth - $correction,
                top: $top - $strokeWidth + $gap - $cmp,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tr_v),
            tempcanvas3.moveTo($tr_v, $zIndex);
            var $br_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left + $canvasWidth - 0 - $gap,
                top: $top - $cmp + $canvasHeight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($br_h),
            tempcanvas3.moveTo($br_h, $zIndex);
            var $br_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left - $cmp + $canvasWidth - $correction,
                top: $top + $canvasHeight - 0 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($br_v),
            tempcanvas3.moveTo($br_v, $zIndex);
            var $bl_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left - $strokeWidth + $gap - $cmp,
                top: $top - $cmp + $canvasHeight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($bl_h),
            tempcanvas3.moveTo($bl_h, $zIndex);
            var $bl_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left + $cmp - $correction,
                top: $top - $cmp + $canvasHeight + $cmp - 0 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($bl_v),
            tempcanvas3.moveTo($bl_v, $zIndex)
        } else {
            $color = "#000000",
            $gap = 0,
            $zIndex = 9999,
            $strokeWidth = .5,
            $correction = .25,
            $tl_h = new fabric.Line([0, 0, 4, 0],{
                left: $left - $cmp - $strokeWidth + $gap,
                top: $top - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tl_h),
            tempcanvas3.moveTo($tl_h, $zIndex);
            $tl_v = new fabric.Line([0, 0, 0, 4],{
                left: $left - $correction,
                top: $top - $cmp - $strokeWidth + $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tl_v),
            tempcanvas3.moveTo($tl_v, $zIndex);
            $tr_h = new fabric.Line([0, 0, 4, 0],{
                left: $left + $canvasWidth + $cmp - 4 - $gap,
                top: $top - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tr_h),
            tempcanvas3.moveTo($tr_h, $zIndex);
            $tr_v = new fabric.Line([0, 0, 0, 4],{
                left: $left + $canvasWidth - $correction,
                top: $top - $cmp - $strokeWidth + $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($tr_v),
            tempcanvas3.moveTo($tr_v, $zIndex);
            $br_h = new fabric.Line([0, 0, 4, 0],{
                left: $left + $canvasWidth + $cmp - 4 - $gap,
                top: $top + $canvasHeight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($br_h),
            tempcanvas3.moveTo($br_h, $zIndex);
            $br_v = new fabric.Line([0, 0, 0, 4],{
                left: $left + $canvasWidth - $correction,
                top: $top + $canvasHeight + $cmp - 4 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($br_v),
            tempcanvas3.moveTo($br_v, $zIndex);
            $bl_h = new fabric.Line([0, 0, 4, 0],{
                left: $left - $cmp - $strokeWidth + $gap,
                top: $top + $canvasHeight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($bl_h),
            tempcanvas3.moveTo($bl_h, $zIndex);
            $bl_v = new fabric.Line([0, 0, 0, 4],{
                left: $left - $correction,
                top: $top + $canvasHeight + $cmp - 4 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas3.add($bl_v),
            tempcanvas3.moveTo($bl_v, $zIndex)
        }
    if (tempcanvas3.renderAll(),
    $localI++,
    ++i >= visibleCanvases)
        return $groupedCanvases.push(tempcanvas3),
        DEBUG && console.log($groupedCanvases),
        void optimizeCanvasesOnPage($groupedCanvases);
    groupCanvasesOfOnePage({
        canvases: $canvases,
        i: i,
        groupedCanvases: $groupedCanvases,
        tempcanvas: tempcanvas3,
        localI: $localI
    })
}
function optimizeCanvasesOnPage($canvases, $paperWidthIn, $paperHeightIn) {
    $canvases = $canvases || canvasarray;
    var $cmp = 0;
    $("input#savecrop").is(":checked") && ($cmp = 12),
    "a4" === $(".paper-size.active").find('input[name="paperSize"]').val() && ($paperWidthIn = 8.267,
    $paperHeightIn = 11.692),
    void 0 === $paperWidthIn && ($paperWidthIn = 8.5),
    void 0 === $paperHeightIn && ($paperHeightIn = 11);
    var $paperWidthPx = 96 * $paperWidthIn
      , $paperHeightPx = 96 * $paperHeightIn
      , $canvasWidth = $canvases[0].get("width") / $canvases[0].getZoom()
      , $canvasHeight = $canvases[0].get("height") / $canvases[0].getZoom();
    DEBUG && console.log("$canvasWidth: " + $canvasWidth),
    DEBUG && console.log("$canvasHeight: " + $canvasHeight),
    DEBUG && console.log("$paperWidthPx: " + $paperWidthPx),
    DEBUG && console.log("$paperHeightPx: " + $paperHeightPx);
    var $verticallyAmount = Math.floor(($paperWidthPx - $cmp) / ($canvasWidth + $cmp)) * Math.floor(($paperHeightPx - $cmp) / ($canvasHeight + $cmp));
    DEBUG && console.log("portrait amount: " + $verticallyAmount);
    var $horizontallyAmount = Math.floor(($paperHeightPx - $cmp) / ($canvasWidth + $cmp)) * Math.floor(($paperWidthPx - $cmp) / ($canvasHeight + $cmp));
    if (DEBUG && console.log("landscape: " + $horizontallyAmount),
    0 !== $verticallyAmount || 0 !== $horizontallyAmount) {
        if ($verticallyAmount > $horizontallyAmount) {
            var $amountOfColumnsOnPage = Math.floor(($paperWidthPx - $cmp) / ($canvasWidth + $cmp))
              , $amountOfRowsOnPage = Math.floor(($paperHeightPx - $cmp) / ($canvasHeight + $cmp));
            return DEBUG && console.log("portrait selected"),
            void downloadOptimized($canvases, 0, $paperWidthPx, $paperHeightPx, $amountOfColumnsOnPage, $amountOfRowsOnPage)
        }
        $amountOfColumnsOnPage = Math.floor(($paperHeightPx - $cmp) / ($canvasWidth + $cmp)),
        $amountOfRowsOnPage = Math.floor(($paperWidthPx - $cmp) / ($canvasHeight + $cmp));
        return DEBUG && console.log("landscape selected"),
        void downloadOptimized($canvases, 0, $paperHeightPx, $paperWidthPx, $amountOfColumnsOnPage, $amountOfRowsOnPage)
    }
    downloadDocument($canvases)
}
function copyOnePageAcrossSheet() {
    $copyOnePageAcrossSheet = !0,
    $("input#savecrop").is(":checked") ? createBleedForPDF({
        callback: removeDeletedCanvasesProxy
    }) : removeDeletedCanvases(canvasarray)
}
function downloadOptimized($canvases, i, $paperWidthPx, $paperHeightPx, $amountOfColumnsOnPage, $amountOfRowsOnPage) {
    if (i > 1e3)
        DEBUG && console.log("too deep recursion. exiting");
    else {
        void 0 === $canvases && ($canvases = canvasarray),
        void 0 === i && (i = 0);
        var rows = $amountOfRowsOnPage
          , cols = $amountOfColumnsOnPage
          , $canvasesOnPage = $amountOfRowsOnPage * $amountOfColumnsOnPage
          , $currentPage = Math.ceil((i + 1) / $canvasesOnPage)
          , $emptyPlacesOnPage = $currentPage * $canvasesOnPage - i - 1
          , $nextI = i
          , visibleCanvases = $canvases.length
          , $cmp = 0;
        $("input#savecrop").is(":checked") && ($cmp = 12),
        i + 1 > visibleCanvases && $emptyPlacesOnPage >= 0 && ($nextI = i + 1 - visibleCanvases * Math.floor((i + 1) / visibleCanvases),
        $canvases[$nextI] || ($nextI = 0),
        DEBUG && console.log("new canvas height: " + optimizedPosition.height)),
        DEBUG && console.log("i: " + i),
        DEBUG && console.log("$nextI: " + $nextI),
        DEBUG && console.log("visibleCanvases:" + visibleCanvases),
        DEBUG && console.log("$currentPage: " + $currentPage),
        DEBUG && console.log("$emptyPlacesOnPage: " + $emptyPlacesOnPage),
        DEBUG && console.log("$canvasesOnPage: " + $canvasesOnPage),
        DEBUG && console.log("$amountOfRowsOnPage: " + $amountOfRowsOnPage),
        DEBUG && console.log("$amountOfColumnsOnPage: " + $amountOfColumnsOnPage);
        var cwidth = $canvases[0].get("width")
          , cheight = $canvases[0].get("height")
          , $pdfPageHeight = $paperHeightPx
          , $height = cheight * visibleCanvases / cols + $cmp * (rows + 1)
          , $width = $paperWidthPx
          , $valueToCenterByWidth = ($paperWidthPx - cols * cwidth - $cmp * (cols + 1)) / 2
          , $valueToCenterByHeight = ($paperHeightPx - rows * cheight - $cmp * (rows + 1)) / 2;
        DEBUG && console.log("$valueToCenterByWidth: " + $valueToCenterByWidth),
        DEBUG && console.log("$valueToCenterByHeight: " + $valueToCenterByHeight),
        DEBUG && console.log("$pdfPageHeight: " + $pdfPageHeight),
        DEBUG && console.log("$height: " + $height),
        isdownloadpdf = !1,
        0 == i && (window.optimizedPosition = new fabric.StaticCanvas,
        optimizedPosition.width = $width,
        optimizedPosition.calcOffset(),
        optimizedPosition.clear(),
        $svgs = 0,
        $additionalHeight = 0),
        optimizedPosition.height = $currentPage * $paperHeightPx,
        $copyOnePageAcrossSheet && ($nextI = $currentPage - 1,
        visibleCanvases *= $canvasesOnPage);
        var tempcanvas = new fabric.StaticCanvas;
        tempcanvas.loadFromJSON(JSON.stringify($canvases[$nextI].toDatalessJSON(properties_to_save)), function() {
            var obj = new fabric.Group(tempcanvas._objects);
            parseInt($("#numOfcanvasrows").val()),
            parseInt($("#numOfcanvascols").val());
            DEBUG && console.log("objects:"),
            optimizedPosition.add(obj),
            optimizedPosition.moveTo(obj, i);
            var $posInRow = Math.floor(i / cols)
              , $posInCol = i - $posInRow * cols
              , $left = cwidth * $posInCol + $cmp + $valueToCenterByWidth
              , $top = cheight * $posInRow + $cmp + $valueToCenterByHeight;
            $posInRow % rows == 0 && i >= cols && 0 === $posInCol && ($additionalHeight += $cmp + 2 * $valueToCenterByHeight),
            DEBUG && console.log("$posInRow: " + $posInRow),
            DEBUG && console.log("$posInCol: " + $posInCol),
            $posInRow > 0 && ($top += $cmp * $posInRow),
            $posInCol > 0 && ($left += $cmp * $posInCol),
            $top += $additionalHeight,
            obj.set({
                left: obj.left + $left,
                top: obj.top + $top
            }),
            DEBUG && console.log("$top: " + $top),
            DEBUG && console.log("downloadOptimized: transform matrix: "),
            DEBUG && console.log(obj.calcTransformMatrix()),
            obj.setCoords(),
            optimizedPosition.renderAll(),
            $svgs++,
            i++,
            setTimeout(function() {
                var progress = Math.round($svgs / visibleCanvases * 100);
                if ($(".bar").width(progress + "%"),
                $svgs >= visibleCanvases && 0 === $emptyPlacesOnPage)
                    return DEBUG && console.log("last call"),
                    proceedPDF2(optimizedPosition.toSVG({}, function(data) {
                        return data
                    }), $width, $pdfPageHeight),
                    void setZoom($("#zoomperc").data("oldScaleValue"));
                downloadOptimized($canvases, i, $paperWidthPx, $paperHeightPx, $amountOfColumnsOnPage, $amountOfRowsOnPage)
            }, 0)
        })
    }
}
function addBackgroundLayer(canvas, tcanvas) {
    return DEBUG && console.log("addBackgroundLayer()"),
    new Promise(function(resolve, reject) {
        var rows = parseInt($("#numOfcanvasrows").val())
          , cols = parseInt($("#numOfcanvascols").val());
        if (canvas.backgroundImage && "image" === canvas.backgroundImage.type)
            fabric.Image.fromURL(canvas.backgroundImage.toDataURL({
                format: "jpeg",
                quality: .5,
                multiplier: 3.125,
                left: 0,
                top: 0,
                width: canvas.get("width"),
                height: canvas.get("height")
            }), function(img) {
                if ($("input#savecrop").is(":checked") && rows + cols < 3)
                    var width = img.get("width") + 75
                      , height = img.get("height") + 75;
                else
                    width = img.get("width"),
                    height = img.get("height");
                img.set({
                    top: 0,
                    left: 0,
                    width: width,
                    height: height,
                    id: "bgl"
                }),
                tcanvas.add(img),
                img.moveTo(0),
                resolve(tcanvas)
            });
        else if (canvas.backgroundColor && "string" == typeof canvas.backgroundColor) {
            var rect = new fabric.Rect({
                top: -.5,
                left: -.5,
                width: canvas.get("width"),
                height: canvas.get("height"),
                id: "bgl",
                fill: canvas.backgroundColor
            });
            tcanvas.add(rect),
            rect.moveTo(0),
            resolve(tcanvas)
        } else if (canvas.bgsrc)
            getBg2(canvas, 1).then(function($bg) {
                fabric.Image.fromURL($bg, function(img) {
                    if ($("input#savecrop").is(":checked") && cols + rows < 3)
                        var width = img.get("width") + 75
                          , height = img.get("height") + 75;
                    else
                        width = img.get("width"),
                        height = img.get("height");
                    DEBUG && console.log("addBackgroundLayer() img width, img.height", width, height),
                    tcanvas.add(img);
                    img.set({
                        scaleX: width / img.get("width") / 3.125,
                        scaleY: height / img.get("height") / 3.125,
                        top: 0,
                        left: 0,
                        originX: "left",
                        originY: "top",
                        id: "bgl",
                        preserveAspectRatio: !0
                    }),
                    img.moveTo(0),
                    DEBUG && console.log("img", img),
                    DEBUG && console.log("addBackgroundLayer() tcanvas", tcanvas),
                    resolve(tcanvas)
                })
            }).catch(function($res) {
                console.log($res)
            });
        else {
            rect = new fabric.Rect({
                top: -.5,
                left: -.5,
                width: canvas.get("width") / canvas.getZoom(),
                height: canvas.get("height") / canvas.getZoom(),
                fill: "",
                id: "bgl"
            });
            tcanvas.add(rect),
            rect.moveTo(0),
            resolve(tcanvas)
        }
    }
    )
}
function rasterizeObjectsProxy($options) {
    $options || ($options = {});
    var $canvases = $options.canvases || canvasarray
      , $readyCanvases = $options.readyCanvases || []
      , $callback = $options.callback || downloadDocument
      , $i = $options.i || 0;
    rasterizeObjects($canvases[$i]).then(function(tcanvas) {
        DEBUG && console.log("$i; " + $i),
        DEBUG && console.log($canvases.length),
        $readyCanvases[$i] = tcanvas,
        $i++,
        $readyCanvases.length >= $canvases.length || $i > $canvases.length ? $callback($readyCanvases) : rasterizeObjectsProxy({
            canvases: $canvases,
            readyCanvases: $readyCanvases,
            i: $i,
            callback: $callback
        })
    }).catch(function($res) {
        DEBUG && console.log($res)
    })
}
function rasterizeObjects(canvas) {
    return DEBUG && console.log("rasterizeObjects()"),
    new Promise(function(resolve, reject) {
        var objcanvas = new fabric.StaticCanvas;
        objcanvas.width = canvas.get("width"),
        objcanvas.height = canvas.get("height");
        var tcanvas = new fabric.StaticCanvas;
        tcanvas.set("width", canvas.get("width")),
        tcanvas.set("height", canvas.get("height")),
        "string" != typeof canvas.backgroundColor && (canvas.backgroundColor = ""),
        tcanvas.loadFromJSON(JSON.stringify(canvas.toDatalessJSON(properties_to_save)), function() {
            s_history = !1,
            setCanvasBg(canvas, canvas.bgsrc, "", canvas.bgScale),
            s_history = !0,
            addBackgroundLayer(canvas, tcanvas).then(function(tcanvas) {
                return resolve(tcanvas)
            })
        })
    }
    )
}
function downloadDocument($canvases, i) {
    void 0 === $canvases && ($canvases = canvasarray),
    void 0 === i && (i = 0);
    var cwidth = $canvases[i].get("width")
      , cheight = $canvases[i].get("height")
      , visibleCanvases = $(".divcanvas:visible").length
      , rows = parseInt($("#numOfcanvasrows").val())
      , cols = parseInt($("#numOfcanvascols").val())
      , $onecanvasperpage = $("#onecanvasperpage").is(":checked")
      , $cmp = 0;
    if ($("input#savecrop").is(":checked") && ($cmp = 10),
    $onecanvasperpage) {
        rows *= cols,
        cols = 1;
        var $pdfPageHeight = cheight + 2 * $cmp
          , $height = (cheight + 2 * $cmp) * rows
    } else {
        $pdfPageHeight = cheight * rows + 2 * $cmp;
        var roundedHeight = 96 * Math.ceil($pdfPageHeight / 96)
          , cropBottom = (roundedHeight = $pdfPageHeight) - $pdfPageHeight
          , cropBottomPt = .75 * cropBottom;
        $height = (cheight + cropBottom) * visibleCanvases / cols + 2 * $cmp
    }
    var $width = cwidth * cols + 2 * $cmp
      , roundedWidth = Math.ceil($width / 96);
    roundedWidth = $width;
    var cropWidthPt = .75 * $width;
    isdownloadpdf = !1,
    0 == i && (window.tempcanvas2 = new fabric.StaticCanvas,
    tempcanvas2.width = $width,
    tempcanvas2.height = $height,
    tempcanvas2.calcOffset(),
    tempcanvas2.clear(),
    $svgs = 0,
    $additionalHeight = 0);
    var obj = new fabric.Group($canvases[i]._objects);
    tempcanvas2.add(obj),
    tempcanvas2.moveTo(obj, i);
    var $posInRow = Math.floor(i / cols)
      , $posInCol = i - $posInRow * cols
      , $left = cwidth * $posInCol + $cmp;
    if ($onecanvasperpage)
        var $top = (cheight + 2 * $cmp) * $posInRow + $cmp;
    else {
        $top = cheight * $posInRow + $cmp;
        $posInRow % rows == 0 && i >= cols && 0 === $posInCol && ($additionalHeight += 2 * $cmp + cropBottom,
        tempcanvas2.height += 2 * $cmp)
    }
    if ($top += $additionalHeight,
    obj.set({
        left: obj.left + $left,
        top: obj.top + $top
    }),
    obj.setCoords(),
    $cmp > 0)
        if (1 === cols && 1 === rows) {
            var $color = "#000000"
              , $gap = 0
              , $zIndex = 9999
              , $strokeWidth = .5
              , $correction = .25
              , $tl_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left - $strokeWidth + $gap - $cmp,
                top: $top + $cmp + $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tl_h),
            tempcanvas2.moveTo($tl_h, $zIndex);
            var $tl_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left + $cmp + $correction,
                top: $top - $strokeWidth + $gap - $cmp,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tl_v),
            tempcanvas2.moveTo($tl_v, $zIndex);
            var $tr_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left + cwidth - 0 - $gap,
                top: $top + $cmp + $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tr_h),
            tempcanvas2.moveTo($tr_h, $zIndex);
            var $tr_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left - $cmp + cwidth - $correction,
                top: $top - $strokeWidth + $gap - $cmp,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tr_v),
            tempcanvas2.moveTo($tr_v, $zIndex);
            var $br_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left + cwidth - 0 - $gap,
                top: $top - $cmp + cheight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($br_h),
            tempcanvas2.moveTo($br_h, $zIndex);
            var $br_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left - $cmp + cwidth - $correction,
                top: $top + cheight - 0 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($br_v),
            tempcanvas2.moveTo($br_v, $zIndex);
            var $bl_h = new fabric.Line([0, 0, 0 + $cmp, 0],{
                left: $left - $strokeWidth + $gap - $cmp,
                top: $top - $cmp + cheight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($bl_h),
            tempcanvas2.moveTo($bl_h, $zIndex);
            var $bl_v = new fabric.Line([0, 0, 0, 0 + $cmp],{
                left: $left + $cmp + $correction,
                top: $top - $cmp + cheight + $cmp - 0 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($bl_v),
            tempcanvas2.moveTo($bl_v, $zIndex)
        } else {
            $color = "#000000",
            $gap = 0,
            $zIndex = 9999,
            $strokeWidth = .5,
            $correction = .25,
            $tl_h = new fabric.Line([0, 0, 5, 0],{
                left: $left - $cmp - $strokeWidth + $gap,
                top: $top - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tl_h),
            tempcanvas2.moveTo($tl_h, $zIndex);
            $tl_v = new fabric.Line([0, 0, 0, 5],{
                left: $left - $correction,
                top: $top - $cmp - $strokeWidth + $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tl_v),
            tempcanvas2.moveTo($tl_v, $zIndex);
            $tr_h = new fabric.Line([0, 0, 5, 0],{
                left: $left + cwidth + $cmp - 5 - $gap,
                top: $top - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tr_h),
            tempcanvas2.moveTo($tr_h, $zIndex);
            $tr_v = new fabric.Line([0, 0, 0, 5],{
                left: $left + cwidth - $correction,
                top: $top - $cmp - $strokeWidth + $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($tr_v),
            tempcanvas2.moveTo($tr_v, $zIndex);
            $br_h = new fabric.Line([0, 0, 5, 0],{
                left: $left + cwidth + $cmp - 5 - $gap,
                top: $top + cheight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($br_h),
            tempcanvas2.moveTo($br_h, $zIndex);
            $br_v = new fabric.Line([0, 0, 0, 5],{
                left: $left + cwidth - $correction,
                top: $top + cheight + $cmp - 5 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($br_v),
            tempcanvas2.moveTo($br_v, $zIndex);
            $bl_h = new fabric.Line([0, 0, 5, 0],{
                left: $left - $cmp - $strokeWidth + $gap,
                top: $top + cheight - $correction,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($bl_h),
            tempcanvas2.moveTo($bl_h, $zIndex);
            $bl_v = new fabric.Line([0, 0, 0, 5],{
                left: $left - $correction,
                top: $top + cheight + $cmp - 5 - $gap,
                stroke: $color,
                strokeWidth: $strokeWidth
            });
            tempcanvas2.add($bl_v),
            tempcanvas2.moveTo($bl_v, $zIndex)
        }
    tempcanvas2.renderAll(),
    $svgs++,
    i++,
    setTimeout(function() {
        var progress = Math.round($svgs / visibleCanvases * 100);
        ($(".bar").width(progress + "%"),
        $svgs >= visibleCanvases) ? (proceedPDF2(tempcanvas2.toSVG({}, function(data) {
            return data
        }), roundedWidth, roundedHeight, cropWidthPt, cropBottomPt),
        setZoom($("#zoomperc").data("oldScaleValue"))) : downloadDocument($canvases, i)
    }, 0)
}
function fixSVGText(str) {
    for (var svg = (new DOMParser).parseFromString(str, "image/svg+xml").documentElement, tspans = svg.querySelectorAll("tspan"), i = 0; i < tspans.length; i++) {
        var ts = tspans[i]
          , parent = ts.parentNode
          , gParent = parent.parentNode
          , j = 0
          , replace = document.createElementNS("http://www.w3.org/2000/svg", "text")
          , tsAttr = ts.attributes;
        for (j = 0; j < tsAttr.length; j++)
            replace.setAttributeNS(null, tsAttr[j].name, tsAttr[j].value);
        var childNodes = ts.childNodes;
        for (j = 0; j < childNodes.length; j++)
            replace.appendChild(ts.childNodes[j]);
        var tAttr = parent.attributes;
        for (j = 0; j < tAttr.length; j++)
            replace.setAttributeNS(null, tAttr[j].name, tAttr[j].value);
        gParent.appendChild(replace),
        ts === parent.lastElementChild && gParent.removeChild(parent)
    }
    var result = (new XMLSerializer).serializeToString(svg);
    return result = (result = (result = result.replace(new RegExp("FONT-FAMILY","g"), "font-family")).replace(new RegExp("FONT-SIZE","g"), "font-size")).replace(new RegExp("FONT-WEIGHT","g"), "font-weight")
}
var pdfProccess = !1;
function proceedPDF2(svg, $width, $height) {
    var cropWidth = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 0
      , cropBottom = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : 0;
    registerDownload("PDF", {
        saveCrop: $("input#savecrop").is(":checked"),
        savePaper: $("input#savePaper").is(":checked")
    }, function(func) {
        toggleHiddenStatusOfObjects();
        var id = loadedtemplateid;
        0 === loadedtemplateid && (id = "new");
        var filename = "wayak_" + id + ".pdf"
          , $fonts = "";
        for (var $family in fabric.fontPaths)
            fabric.fontPaths.hasOwnProperty($family) && ($fonts += "@font-face {font-family: '" + $family + "';src: url('" + fabric.fontPaths[$family] + "');font-style: normal;font-weight: normal;}");
        $fonts = '<style type="text/css"><![CDATA[' + $fonts + "]]></style>";
        var $svg_with_fonts = (svg = svg.replace(/\<desc\>.*?\<\/desc\>/, "<desc>Created with templett.com</desc>")).replace(/<\/defs>/, $fonts + "</defs>")
          , jsonData = JSON.stringify($svg_with_fonts);
        DEBUG && console.log("svg size(mb): ", jsonData.length / 1024 / 1024);
        var pages = $(".divcanvas:visible").length / document.getElementById("numOfcanvasrows").value / document.getElementById("numOfcanvascols").value
          , url = appUrl;
        url = appUrl + "editor/pdf",
        pdfProccess ? $.toast({
            text: "Please wait for the current PDF process to finish",
            icon: "error",
            hideAfter: 4e3,
            loader: !1,
            position: "top-right"
        }) : (pdfProccess = !0,
        $.ajax({
            type: "POST",
            url: url,
            data: {
                filename: filename,
                jsonData: jsonData,
                cwidth: $width,
                cheight: $height,
                cropWidth: cropWidth,
                cropBottom: cropBottom,
                pages: pages
            },
            success: function($answer) {
                if (pdfProccess = !1,
                $answer) {
                    if (!IsJsonString($answer))
                        return $("#progressModal").modal("hide"),
                        $.toast({
                            text: "Something went wrong",
                            icon: "error",
                            hideAfter: 3e3,
                            loader: !1,
                            position: "top-right"
                        }),
                        !1;
                    if (($answer = JSON.parse($answer)).success) {
                        func();
                        var $pdf = $answer.data;
                        $("#autosave").data("saved", "yes"),
                        setTimeout(function() {
                            window.location.href = processServerUrl + "design/downloadfile.php?file=" + $pdf + "&filename=" + filename
                        }, 200)
                    } else
                        $.toast({
                            text: $answer.msg,
                            icon: "error",
                            hideAfter: 3e3,
                            loader: !1,
                            position: "top-right"
                        });
                    savecrop = !1,
                    $("#progressModal").modal("hide")
                } else
                    $("#progressModal").modal("hide")
            }
        }))
    })
}
function downloadPdf() {
    isdownloadpdf = !1;
    for (var jsonCanvasArray = [], i = 0; i < canvasindex; i++)
        $("#divcanvas" + i).is(":visible") && jsonCanvasArray.push(canvasarray[i].toSVG());
    proceedPDF(jsonCanvasArray)
}
function proceedPDF(jsonCanvasArray) {
    $("input#savecrop").is(":checked") && (savecrop = !0);
    var id = loadedtemplateid;
    0 === loadedtemplateid && (id = "new");
    var filename = "wayak_" + id + ".pdf"
      , $onecanvasperpage = $("#onecanvasperpage").is(":checked")
      , jsonData = JSON.stringify(jsonCanvasArray)
      , cwidth = document.getElementById("loadCanvasWid").value
      , cheight = document.getElementById("loadCanvasHei").value
      , rows = document.getElementById("numOfcanvasrows").value
      , cols = document.getElementById("numOfcanvascols").value;
    cwidth *= 96,
    cheight *= 96;
    var url = appUrl + "design/pdf.php";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            filename: filename,
            jsonData: jsonData,
            cwidth: cwidth,
            cheight: cheight,
            rows: rows,
            cols: cols,
            savecrop: savecrop,
            ocpp: $onecanvasperpage
        },
        success: function($answer) {
            if ($answer) {
                if (0 == ($answer = JSON.parse($answer)).err) {
                    var $pdf = $answer.data;
                    DEBUG && console.log($pdf),
                    $("#autosave").data("saved", "yes"),
                    window.location.href = appUrl + "design/downloadfile.php?file=" + $pdf + "&filename=" + filename
                }
                savecrop = !1,
                appSpinner.hide()
            } else
                appSpinner.hide()
        }
    })
}
function processSVGs(disablespinner) {
    DEBUG && console.log("processSVGs"),
    totalsvgs = 0,
    convertedsvgs = 0,
    $("#publishModal").modal("hide"),
    $("#pdfdownloadModal").modal("hide"),
    disablespinner || appSpinner.show(),
    isdownloadpdf && downloadDocument(),
    issaveastemplate && saveAsTemplateFile(),
    isupdatetemplate && updateTemplate()
}
$("#addCategory").click(function() {
    $("#Addcategoryodal").modal("show")
}),
$("#addTemplateCategory").click(function() {
    $("#AddTemplatecategoryModal").modal("show")
}),
$("#addBGCategory").click(function() {
    $("#AddBGcategoryodal").modal("show")
}),
$("#addTextCategory").click(function() {
    $("#AddTextcategoryModal").modal("show")
}),
$("#saveText").click(function() {
    demo_as_id > 0 ? $.toast({
        text: "Not allowed in demo mode",
        icon: "error",
        loader: !1,
        position: "top-right"
    }) : $("#savetext_modal").modal("show")
}),
$("#saveElement").click(function() {
    demo_as_id > 0 ? $.toast({
        text: "Not allowed in demo mode",
        icon: "error",
        loader: !1,
        position: "top-right"
    }) : $("#saveelement_modal").modal("show")
}),
$("#cancel-design-as").on("click", function() {
    var url = appUrl + "admin/Users/close-design-as-user-scope";
    $.ajax({
        method: "post",
        url: url,
        dataType: "json"
    }).done(function(data) {
        data.success && (window.location.href = appUrl + "design")
    })
}),
$("#redirect-admin-design-as").on("click", function(e) {
    e.preventDefault(),
    e.stopPropagation();
    var redirectUrl = $(this).prop("href")
      , url = appUrl + "admin/Users/close-design-as-user-scope";
    $.ajax({
        method: "post",
        url: url,
        dataType: "json"
    }).done(function(data) {
        data.success && (window.location.href = redirectUrl)
    })
}),
Dropzone.autoDiscover = !1;
var wrapperDz = null, files, bgfiles;
function deleteTemplate(id) {
    if (appSpinner.show(),
    "" != id) {
        var url = appUrl + "design/actions/deleteTemplate.php";
        $.getJSON(url, {
            templateid: id
        }, function(data) {
            appSpinner.hide(),
            $.toast({
                text: data.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            }),
            data.err || $("#template_container .thumb#" + id).hide()
        })
    } else
        $("#alertModal").modal("show"),
        $("#responceMessage").html("Please select the Template(s), you wish to delete.")
}
function deleteText($id) {
    if (appSpinner.show(),
    $id) {
        var url = appUrl + "design/actions/deleteText.php";
        $.getJSON(url, {
            id: $id
        }).done(function($answer) {
            $answer.err ? $.toast({
                text: $answer.msg,
                loader: !1,
                hideafter: !1,
                icon: "error",
                position: "top-right"
            }) : ($.toast({
                text: $answer.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            }),
            $("#text_container .thumb#" + $id).hide())
        }).always(function() {
            appSpinner.hide()
        })
    }
}
function deleteElement($id) {
    if (appSpinner.show(),
    $id) {
        var url = appUrl + "admin/Elements/delete-element";
        $.post(url, {
            id: $id
        }, function() {}, "json").done(function($answer) {
            $answer.success ? ($.toast({
                text: $answer.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            }),
            $("#catimage_container .thumb#" + $id).hide()) : $.toast({
                text: $answer.msg,
                loader: !1,
                hideafter: !1,
                icon: "error",
                position: "top-right"
            })
        }).always(function() {
            appSpinner.hide()
        })
    }
}
function deleteBg($id) {
    if (appSpinner.show(),
    $id) {
        var url = appUrl + "design/actions/deleteBg.php";
        $.getJSON(url, {
            id: $id
        }).done(function($answer) {
            $answer.err ? $.toast({
                text: $answer.msg,
                loader: !1,
                hideafter: !1,
                icon: "error",
                position: "top-right"
            }) : ($.toast({
                text: $answer.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            }),
            $("#background_container .thumb#" + $id).hide())
        }).always(function() {
            appSpinner.hide()
        })
    }
}
function deleteImage(id) {
    if (appSpinner.show(),
    id) {
        var url = appUrl + "admin/Elements/delete-images";
        $.post(url, {
            id: id
        }, null, "json").done(function(data) {
            data.success ? ($.toast({
                text: data.msg,
                icon: "success",
                loader: !1,
                position: "top-right"
            }),
            $('.deleteImage[data-target="' + id + '"]').parent().hide()) : $.toast({
                text: data.msg,
                loader: !1,
                hideafter: !1,
                icon: "error",
                position: "top-right"
            })
        }).always(function() {
            appSpinner.hide()
        })
    }
}
function readIMG(input) {
    if (DEBUG && console.log(input.files[0]),
    input.files && input.files[0]) {
        var reader = new FileReader;
        reader.onload = function(e) {
            var src = e.target.result;
            if ($("#previewImage").show(),
            $("#previewImage").attr("src", src),
            "image/svg+xml" == input.files[0].type) {
                var svg = window.atob(src.replace("data:image/svg+xml;base64,", ""));
                canvg("previewSvg", svg, {
                    ignoreMouse: !0,
                    ignoreAnimation: !0
                }),
                previewSvg = document.getElementById("previewSvg").toDataURL("image/png")
            }
        }
        ,
        reader.readAsDataURL(input.files[0])
    }
}
function prepareUpload(event) {
    files = event.target.files
}
function uploadimage() {
    var data = new FormData;
    $.each(files, function(key, value) {
        data.append("element_img", value)
    });
    var url = appUrl + "design/upload.php?files";
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        cache: !1,
        dataType: "json",
        processData: !1,
        contentType: !1,
        success: function(data) {
            alert(data)
        }
    })
}
function readBGIMG(input) {
    if ($this = this,
    input.files && input.files[0]) {
        var reader = new FileReader;
        reader.onload = function(e) {
            $("#previewBGImage").show(),
            $("#previewBGImage").attr("src", e.target.result).width(150)
        }
        ,
        reader.readAsDataURL(input.files[0])
    }
}
function prepareBGUpload(event) {
    bgfiles = event.target.files
}
function uploadBgimage() {
    var data = new FormData;
    $.each(bgfiles, function(key, value) {
        data.append("bg_img", value)
    });
    var url = appUrl + "design/upload.php?files";
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        cache: !1,
        dataType: "json",
        processData: !1,
        contentType: !1,
        success: function(data) {
            alert(data)
        }
    })
}
function addNewCanvasPage(dupflag, pageid) {
    pageindex++,
    $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>"),
    addCanvasToPage(dupflag, pageid),
    setWorkspace()
}
function addNewCanvas($rowid) {
    savestatecount = 0,
    $("#page" + pageindex).find("tr#row" + $rowid).append("<td align='center' id='divcanvas" + canvasindex + "' onmousedown='javascript:selectCanvas(this.id);' onClick='javascript:selectCanvas(this.id);' oncontextmenu='javascript:selectCanvas(this.id);' class='divcanvas'><div class='canvascontent' ><canvas id='canvas" + canvasindex + "' class='canvas'></canvas></div></td>"),
    canvas = new fabric.Canvas("canvas" + canvasindex,{
        enableRetinaScaling: !0
    }),
    canvas.index = 0,
    canvas.state = [],
    canvas.rotationCursor = 'url("assets/img/rotatecursor2.png") 10 10, crosshair',
    canvas.backgroundColor = "",
    canvas.selectionColor = "rgba(255,255,255,0.3)",
    canvas.selectionBorderColor = "rgba(0,0,0,0.1)",
    canvas.hoverCursor = "pointer",
    canvas.perPixelTargetFind = !0,
    canvas.preserveObjectStacking = !0,
    canvas.targetFindTolerance = 10,
    canvasarray.push(canvas);
    document.getElementById("loadCanvasWid").value,
    document.getElementById("loadCanvasHei").value;
    setCanvasZoom(canvasarray.length - 1),
    initCanvasEvents(canvas),
    initAligningGuidelines(canvas),
    initCenteringGuidelines(canvas),
    initKeyboardEvents(),
    canvas.calcOffset(),
    canvas.renderAll(),
    currentcanvasid = canvasindex,
    canvasindex++,
    save_history(),
    $("#bgcolorselect").spectrum("set", "")
}
function selectCanvas(id) {
    if (id = id.replace("divcanvas", ""),
    currentcanvasid != parseInt(id)) {
        canvas.discardActiveObject().renderAll();
        for (var i = 0; i < canvasindex; i++)
            $("#canvas" + i).css("box-shadow", "");
        if ("geofilter" != template_type && "geofilter2" != template_type && $("#canvas" + id).css("box-shadow", "0px 0px 10px #888888"),
        currentcanvasid != parseInt(id)) {
            currentcanvasid = parseInt(id);
            var tempcanvas = canvasarray[parseInt(id)];
            tempcanvas && (canvas = tempcanvas);
            var obj = canvas.getActiveObject();
            obj && canvas.setActiveObject(obj);
            for (var n = canvas._objects.length; canvas._objects[--n]; )
                "text" === canvas._objects[n].type && !1 === canvas._objects[n].selectable && canvas.remove(canvas._objects[n]);
            $("#bgscale").slider("setValue", 100 * canvas.bgScale),
            canvas.renderAll(),
            canvas.backgroundColor ? $("#bgcolorselect").spectrum("set", canvas.backgroundColor) : $("#bgcolorselect").spectrum("set", "")
        }
    }
}
function autoZoom() {
    var $canvas_box_height = $("#page0").height()
      , $canvas_box_width = $("#page0").width()
      , $window_height = $(window).height()
      , $window_width = $(window).width()
      , $sidebar_width = $(".am-left-sidebar").width();
    $canvas_box_width < $window_width - $sidebar_width && $canvas_box_height < $window_height - 60 ? setZoom(1) : $canvas_box_width > $window_width - $sidebar_width ? setZoom(1 / ($canvas_box_width / ($window_width - $sidebar_width - 300))) : ($canvas_box_height > $window_height - 60 || 1 / ($canvas_box_height / ($window_height - 60)) <= 1) && setZoom(1 / ($canvas_box_height / ($window_height - 60)))
}
function adjustIconPos(id) {
    var p = $("#page" + id).find("table");
    if (p.length) {
        parseFloat(jQuery("#zoomperc").data("scaleValue"));
        var position = p.position()
          , width = p.outerWidth()
          , $top = (p.outerHeight() / 2 || 0) - 20;
        "geofilter" != template_type && "geofilter2" != template_type || ($(".background-arrow-right").css({
            position: "absolute",
            top: $top - 15 + "px",
            left: position.left + width + 60 + "px"
        }).show(),
        $(".background-arrow-left").css({
            position: "absolute",
            top: $top - 15 + "px",
            left: position.left - 127 + "px"
        }).show()),
        $("#pagenumber" + id).css({
            position: "absolute",
            top: $top + "px",
            left: position.left + width + 30 + "px"
        }).show(),
        $top += 25,
        "doublesided" == template_type && 2 == $(".divcanvas:visible").length || ($("#duplicatecanvas" + id).css({
            position: "absolute",
            top: $top + "px",
            left: position.left + width + 10 + "px"
        }).show(),
        $top += 25),
        $("#deletecanvas" + id).css({
            position: "absolute",
            top: $top + "px",
            left: position.left + width + 10 + "px"
        }).show(),
        1 == $(".page:visible").length && $(".deletecanvas").css("display", "none"),
        $(".duplicatecanvas, .deletecanvas").css("left", position.left + (width + 30))
    }
}
function openTemplate(jsons) {
    if (DEBUG && console.log("openTemplate()"),
    savestatecount = 0,
    s_history = !1,
    !IsJsonString(jsons))
        return appSpinner.hide(),
        $.toast({
            text: "Something went wrong",
            icon: "error",
            hideAfter: 2e3,
            loader: !1,
            position: "top-right"
        }),
        !1;
    var jsonCanvasArray = JSON.parse(jsons);
    if (jsonCanvasArray && !(jsonCanvasArray.length <= 0)) {
        var wh = jsonCanvasArray[0];
        wh = JSON.parse(wh),
        document.getElementById("loadCanvasWid").value = parseFloat(wh.width / 96),
        document.getElementById("loadCanvasHei").value = parseFloat(wh.height / 96),
        document.getElementById("numOfcanvasrows").value = parseInt(wh.rows),
        document.getElementById("numOfcanvascols").value = parseInt(wh.cols);
        var rc = parseInt(wh.rows) * parseInt(wh.cols);
        $("#canvaspages").html(""),
        pageindex = 0,
        canvasindex = 0,
        canvasarray = [];
        for (var i = 0; i < (jsonCanvasArray.length - 1) / rc; i++)
            pageindex = i,
            $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>"),
            addCanvasToPage(!1, i, jsonCanvasArray);
        setCanvasSize(),
        i = 1;
        for (var families = []; jsonCanvasArray[i]; )
            jsonCanvasArray[i].objects && jsonCanvasArray[i].objects.forEach(function(o, i) {
                o.fontFamily && (dontLoadFonts.indexOf(o.fontFamily) < 0 && (families.push(o.fontFamily),
                $("body").append('<div class="font-test" style="font-family: ' + o.fontFamily + '"></div>'),
                dontLoadFonts.push(o.fontFamily)),
                addFontToFabric(o.fontFamily)),
                $.isEmptyObject(o.styles) || $.each(o.styles, function($i, $line) {
                    $.each($line, function($i, $style) {
                        void 0 !== $style.fontFamily && dontLoadFonts.indexOf($style.fontFamily) < 0 && families.push($style.fontFamily)
                    })
                })
            }),
            i++;
        return 0 == families.length ? proceedOpenTemplate(jsonCanvasArray) : (families = _toConsumableArray(new Set(families)),
        WebFontConfig = {
            custom: {
                families: families,
                urls: [appUrl + "editor/get-css-fonts?templates=" + JSON.stringify(families)]
            },
            active: function() {
                DEBUG && console.log("all fonts are loaded"),
                proceedOpenTemplate(jsonCanvasArray)
            },
            fontinactive: function(f) {
                DEBUG && console.log("Font failed to load: " + f)
            },
            inactive: function() {
                $.toast({
                    text: "Fonts have failed to load. Please refresh the browser.",
                    icon: "error",
                    hideAfter: !1,
                    loader: !1,
                    position: "top-right"
                }),
                proceedOpenTemplate(jsonCanvasArray)
            }
        },
        WebFont.load(WebFontConfig)),
        !0
    }
}
function proceedOpenTemplate(jsonCanvasArray) {
    s_history = !1;
    for (var i = 0; i < canvasindex; i++)
        !function(lcanvas, json) {
            if (json) {
                svg_custom_data = [],
                DEBUG && console.log("proceedOpenTemplate() json: ", json),
                DEBUG && console.log("svg_custom_data: ", svg_custom_data);
                var json_without_svg = {
                    backgroundImage: json.backgroundImage,
                    bgColor: json.background,
                    cheight: json.cheight,
                    cwidth: json.cwidth,
                    objects: []
                };
                lcanvas.clear(),
                json.backgroundImage = "";
                var $bgsrc = ""
                  , $scale = 1
                  , $bgcolor = json.background;
                if (json.bgScale && ($scale = json.bgScale),
                json.bgsrc && ($bgsrc = json.bgsrc),
                $bgcolor && "string" == typeof $bgcolor && !$bgsrc && (setCanvasBg(lcanvas, "", $bgcolor, 1, i),
                $("#bgcolorselect").spectrum("set", canvas.backgroundColor)),
                $bgsrc && (lcanvas.bgsrc = $bgsrc,
                lcanvas.bgScale = $scale,
                $("#bgscale").slider("setValue", 100 * $scale),
                setCanvasBg(lcanvas, $bgsrc, "", $scale, i, !0),
                $("#bgcolorselect").spectrum("set", "")),
                json.objects) {
                    var json_objects = json.objects
                      , counter = 0;
                    0 == json_objects.length && i + 1 >= canvasindex && afterLoadTemplate(),
                    $.each(json_objects, function(object_i, object) {
                        DEBUG && console.log("obj: ", object),
                        object.selectable = !0,
                        object.backgroundColor = "",
                        "image" === object.type && object.bg ? (json_without_svg.objects[json_without_svg.objects.length] = object,
                        json.bgsrc || ($bgsrc = object.src,
                        object.visible = !1),
                        $scale = 1) : void 0 !== object.svg_custom_paths && isSvg(object) ? (DEBUG && console.log("object.svg_custom_paths: ", object.svg_custom_paths),
                        svg_custom_data[object_i] = object) : json_without_svg.objects[json_without_svg.objects.length] = object,
                        counter++,
                        json_objects.length == counter && (DEBUG && console.log("counter: ", counter),
                        json = JSON.stringify(json),
                        DEBUG && console.log("svg_custom_data: ", svg_custom_data),
                        loadObjectOnCanvasFromJSON(lcanvas, json_without_svg, svg_custom_data, i))
                    })
                }
            } else
                afterLoadJSON(lcanvas, i);
            savestatecount = 0
        }(canvasarray[i], jsonCanvasArray[i + 1]);
    return initKeyboardEvents(),
    $("#canvaspages .page").length > 1 && $(".deletecanvas").show(),
    $("#savetemplate").show(),
    $("#saveastemplate").show(),
    $(".download-menu").show(),
    $("#undo").hide(),
    $("#bgscale").slider("setValue", 100 * canvas.bgScale),
    $(".sidebar-elements li:not(#relatedProductsPane) a").removeClass("invisible"),
    canvasindex > 10 ? $(".download-jpeg-menu-item").hide() : $(".download-jpeg-menu-item").show(),
    setWorkspace(),
    updatePageNumbers(),
    getBgimages2(0, ""),
    demo_as_id,
    !0
}
function loadObjectOnCanvasFromJSON(lcanvas, json, svg_custom_data12, i) {
    DEBUG && console.log("loadObjectOnCanvasFromJSON() json", json),
    lcanvas.renderOnAddRemove = !1,
    lcanvas.loadFromJSON(json, function() {
        lcanvas.bgsrc && setCanvasBg(lcanvas, lcanvas.bgsrc, "", lcanvas.bgScale, i, !0),
        lcanvas.bgColor && "string" == typeof lcanvas.bgColor && !lcanvas.bgsrc && setCanvasBg(lcanvas, "", lcanvas.bgColor, 1, i),
        DEBUG && console.log("svg_custom_data12: ", svg_custom_data12),
        svg_custom_data12.length > 0 ? $.each(svg_custom_data12, function(svg_i, svg_data) {
            if (svg_data && void 0 !== svg_data) {
                if (isSvg(svg_data)) {
                    DEBUG && console.log("svg_data: ", svg_data);
                    var svg_src = svg_data.src;
                    fabric.loadSVGFromURL(svg_src, function(objects, options, svgElements, allSvgElements) {
                        var loadedObject = keepSvgGroups(objects, svgElements, allSvgElements, options);
                        if (DEBUG && console.log("loadedObject", loadedObject),
                        lcanvas.discardActiveObject().renderAll(),
                        loadedObject.set({
                            top: svg_data.top,
                            left: svg_data.left,
                            shadow: svg_data.shadow,
                            stroke: svg_data.stroke,
                            strokeWidth: svg_data.strokeWidth,
                            opacity: svg_data.opacity,
                            index: svg_i,
                            locked: svg_data.locked,
                            src: svg_src,
                            svg_custom_paths: svg_data.svg_custom_paths,
                            originX: svg_data.originX ? svg_data.originX : "center",
                            originY: svg_data.originY ? svg_data.originY : "center",
                            width: svg_data.width,
                            height: svg_data.height
                        }),
                        svg_data.fill && ("string" == typeof svg_data.fill && (loadedObject.fill = svg_data.fill),
                        "object" === _typeof(svg_data.fill) && ("Dpattern" == svg_data.fill.type || "pattern" == svg_data.fill.type)))
                            try {
                                var $p = svg_data.fill;
                                fabric.Dpattern.fromObject($p, function(fill) {
                                    return loadedObject.set({
                                        fill: fill,
                                        dirty: !0
                                    })
                                })
                            } catch (e) {
                                console.log("Error", e, svg_data.fill),
                                loadedObject.fill = svg_data.fill
                            }
                        var $gradientType = getGradientTypeofObject(svg_data);
                        if (!1 !== $gradientType ? applyGradient(svg_data.fill.colorStops[0].color, svg_data.fill.colorStops[1].color, $gradientType, loadedObject) : applyGradient2(svg_data, loadedObject),
                        lcanvas.add(loadedObject),
                        loadedObject.setCoords(),
                        loadedObject.scale(1),
                        loadedObject.set({
                            scaleX: svg_data.scaleX,
                            scaleY: svg_data.scaleY,
                            flipX: svg_data.flipX,
                            flipY: svg_data.flipY,
                            angle: svg_data.angle,
                            top: svg_data.top,
                            left: svg_data.left
                        }),
                        "center" !== loadedObject.originX || "center" !== loadedObject.originY) {
                            var $point = loadedObject.getPointByOrigin("center", "center");
                            loadedObject.set({
                                originX: "center",
                                originY: "center",
                                left: $point.x,
                                top: $point.y
                            })
                        }
                        loadedObject.setCoords(),
                        loadedObject.hasRotatingPoint = !0,
                        "object" === _typeof(svg_data.svg_custom_paths) && $.each(svg_data.svg_custom_paths, function(path_i, path_data) {
                            if (path_data && void 0 !== path_data) {
                                DEBUG && console.log("loadObjectOnCanvasFromJSON() path_i, path_data ", path_i, path_data);
                                var $index = path_data.index ? path_data.index : path_i;
                                if ("fill" == path_data.action)
                                    if (!path_data.color_value || "object" !== _typeof(path_data.color_value) || "linear" !== path_data.color_value.type && "radial" !== path_data.color_value.type)
                                        loadedObject._objects && loadedObject._objects[$index] ? "group" === loadedObject._objects[$index].type && loadedObject._objects[$index]._objects ? $.each(loadedObject._objects[$index]._objects, function($i, $child) {
                                            $child.set("fill", path_data.color_value)
                                        }) : loadedObject._objects[$index] && loadedObject._objects[$index].set("fill", path_data.color_value) : loadedObject && loadedObject.set("fill", path_data.color_value);
                                    else {
                                        var $gradientType = "color-fill";
                                        0 !== path_data.color_value.coords.x2 && ($gradientType = "linear-gradient-h-fill"),
                                        0 !== path_data.color_value.coords.y2 && ($gradientType = "linear-gradient-v-fill"),
                                        0 !== path_data.color_value.coords.x2 && 0 !== path_data.color_value.coords.y2 && ($gradientType = "linear-gradient-d-fill"),
                                        void 0 !== path_data.color_value.coords.r1 && ($gradientType = "radial-gradient-fill"),
                                        applyGradient(path_data.color_value.colorStops[0].color, path_data.color_value.colorStops[1].color, $gradientType, loadedObject._objects[$index])
                                    }
                                else
                                    "stroke" == path_data.action && (loadedObject._objects[$index].stroke = path_data.color_value)
                            } else
                                path_data && path_data.color_value && (loadedObject.fill = path_data.color_value,
                                loadedObject.dirty = !0)
                        }),
                        svg_data.stroke && loadedObject.paths && $.each(loadedObject.paths, function(path_i, path_data) {
                            path_data.set("strokeWidth", svg_data.strokeWidth),
                            path_data.set("stroke", svg_data.stroke)
                        }),
                        svg_data.stroke && loadedObject._objects && $.each(loadedObject._objects, function(path_i, path_data) {
                            path_data.set("strokeWidth", svg_data.strokeWidth),
                            path_data.set("stroke", svg_data.stroke)
                        }),
                        loadedObject.moveTo(svg_i),
                        lcanvas.renderAll()
                    })
                }
                svg_data.svg_custom_data && ($.each(svg_data.svg_custom_data, function($index, $svg_data) {
                    "object" === _typeof($svg_data) && isSvg($svg_data) && fabric.loadSVGFromURL($svg_data.src, function(objects, options, svgElements, allSvgElements) {
                        var $object = fabric.util.groupSVGElements(objects, options);
                        $object.set({
                            top: $svg_data.top,
                            left: $svg_data.left,
                            shadow: $svg_data.shadow,
                            stroke: $svg_data.stroke,
                            strokeWidth: $svg_data.strokeWidth,
                            opacity: $svg_data.opacity,
                            index: $index,
                            locked: $svg_data.locked,
                            src: $svg_data.src,
                            svg_custom_paths: $svg_data.svg_custom_paths,
                            originX: $svg_data.originX ? $svg_data.originX : "center",
                            originY: $svg_data.originY ? $svg_data.originY : "center",
                            width: $svg_data.width,
                            height: $svg_data.height
                        }),
                        $svg_data.fill && ($object.fill = $svg_data.fill);
                        var $gradientType = getGradientTypeofObject($svg_data);
                        !1 !== $gradientType && applyGradient($svg_data.fill.colorStops[0].color, $svg_data.fill.colorStops[1].color, $gradientType, $object),
                        $object.set({
                            scaleX: $svg_data.scaleX,
                            scaleY: $svg_data.scaleY,
                            flipX: $svg_data.flipX,
                            flipY: $svg_data.flipY,
                            angle: $svg_data.angle,
                            top: $svg_data.top,
                            left: $svg_data.left
                        }),
                        $object.setCoords(),
                        $object.hasRotatingPoint = !0,
                        "object" === _typeof($svg_data.svg_custom_paths) && $.each($svg_data.svg_custom_paths, function($path_i, $path_data) {
                            if ($path_data && void 0 !== $path_data) {
                                DEBUG && console.log("loadObjectOnCanvasFromJSON() path_i, path_data ", $path_i, $path_data);
                                var $index2 = $path_data.index ? $path_data.index : path_i;
                                if ("fill" == $path_data.action)
                                    if (!$path_data.color_value || "object" !== _typeof($path_data.color_value) || "linear" !== $path_data.color_value.type && "radial" !== $path_data.color_value.type)
                                        $object._objects && $object._objects[$index2] ? "group" === $object._objects[$index2].type && $object._objects[$index2]._objects ? $.each($object._objects[$index2]._objects, function($i, $child) {
                                            $child.set("fill", $path_data.color_value)
                                        }) : $object._objects[$index2] && $object._objects[$index2].set("fill", $path_data.color_value) : $object && $object.set("fill", $path_data.color_value);
                                    else {
                                        var $gradientType = "color-fill";
                                        0 !== $path_data.color_value.coords.x2 && ($gradientType = "linear-gradient-h-fill"),
                                        0 !== $path_data.color_value.coords.y2 && ($gradientType = "linear-gradient-v-fill"),
                                        0 !== $path_data.color_value.coords.x2 && 0 !== $path_data.color_value.coords.y2 && ($gradientType = "linear-gradient-d-fill"),
                                        void 0 !== $path_data.color_value.coords.r1 && ($gradientType = "radial-gradient-fill"),
                                        applyGradient($path_data.color_value.colorStops[0].color, $path_data.color_value.colorStops[1].color, $gradientType, $object._objects[$index2])
                                    }
                                else
                                    "stroke" == $path_data.action && ($object._objects[$index].stroke = $path_data.color_value)
                            } else
                                $path_data && $path_data.color_value && ($object.fill = $path_data.color_value,
                                $object.dirty = !0)
                        }),
                        $svg_data.stroke && $object.paths && $.each($object.paths, function($path_i, $path_data) {
                            $path_data.set("strokeWidth", $svg_data.strokeWidth),
                            $path_data.set("stroke", $svg_data.stroke)
                        }),
                        $svg_data.stroke && $object._objects && $.each($object._objects, function($path_i, $path_data) {
                            $path_data.set("strokeWidth", $svg_data.strokeWidth),
                            $path_data.set("stroke", $svg_data.stroke)
                        }),
                        lcanvas._objects[svg_i].insertAt($object, svg_i),
                        lcanvas.renderAll(),
                        DEBUG && console.log("svg_i, $index", svg_i, $index)
                    })
                }),
                DEBUG && console.log("svg_data.svg_custom_data", svg_data.svg_custom_data)),
                svg_custom_data12.length == svg_i + 1 && checkIfGroupsNeedsSVGLoading(lcanvas, i)
            } else
                svg_custom_data12.length == svg_i + 1 && checkIfGroupsNeedsSVGLoading(lcanvas, i)
        }) : checkIfGroupsNeedsSVGLoading(lcanvas, i)
    }),
    demo_as_id && setDemoOverlay()
}
function checkIfGroupsNeedsSVGLoading(lcanvas, i) {
    DEBUG && console.log("checkIfGroupsNeedsSVGLoading()"),
    $.each(lcanvas._objects, function(index, object) {
        if ("group" === object.type) {
            var $need_svg_loading = !1;
            $.each(object._objects, function(i, child) {
                "group" === child.type && void 0 !== child.svg_custom_paths && ($need_svg_loading = !0)
            }),
            $need_svg_loading && (DEBUG && console.log("checkIfGroupsNeedsSVGLoading(): $need_svg_loading", $need_svg_loading),
            loadSVGForGroupMembers({
                canvas: lcanvas,
                index: index
            }))
        }
    }),
    afterLoadJSON(lcanvas, i)
}
function loadSVGForGroupMembers($options) {
    $options || ($options = {});
    var $canvas = $options.canvas || canvas
      , $index = $options.index || 0;
    $.each($canvas._objects[$index]._objects, function(i, child) {
        "group" === child.type && void 0 !== child.svg_custom_paths && void 0 !== child.src && function($index, i) {
            fabric.loadSVGFromURL($canvas._objects[$index]._objects[i].src, function(objects, options) {
                var loadedObject = fabric.util.groupSVGElements(objects, options);
                fabric.util.populateWithProperties($canvas._objects[$index]._objects[i], loadedObject, ["locked", "originX", "originY", "scaleX", "scaleY", "top", "left", "angle", "flipX", "flipY", "shadow", "stroke", "strokeWidth", "opacity", "index", "src", "svg_custom_paths"]),
                $.each($canvas._objects[$index]._objects[i].svg_custom_paths, function(path_i, path_data) {
                    if (path_data && void 0 !== path_data) {
                        var $index = path_data.index ? path_data.index : path_i;
                        if (loadedObject.paths && loadedObject.paths[$index])
                            if ("fill" == path_data.action)
                                if (!path_data.color_value || "object" !== _typeof(path_data.color_value) || "linear" !== path_data.color_value.type && "radial" !== path_data.color_value.type)
                                    loadedObject.paths[$index].set("fill", path_data.color_value);
                                else {
                                    var $gradientType = "color-fill";
                                    0 !== path_data.color_value.coords.x2 && ($gradientType = "linear-gradient-h-fill"),
                                    0 !== path_data.color_value.coords.y2 && ($gradientType = "linear-gradient-v-fill"),
                                    0 !== path_data.color_value.coords.x2 && 0 !== path_data.color_value.coords.y2 && ($gradientType = "linear-gradient-d-fill"),
                                    void 0 !== path_data.color_value.coords.r1 && ($gradientType = "radial-gradient-fill"),
                                    applyGradient(path_data.color_value.colorStops[0].color, path_data.color_value.colorStops[1].color, $gradientType, loadedObject.paths[$index])
                                }
                            else
                                loadedObject.paths[$index].stroke = path_data.color_value
                    }
                }),
                $canvas._objects[$index]._objects[i].paths = loadedObject.paths,
                $canvas._objects[$index].dirty = !0,
                $canvas.renderAll()
            })
        }($index, i)
    })
}
function afterLoadJSON(lcanvas, i) {
    lcanvas.renderOnAddRemove = !0;
    for (var n = lcanvas._objects.length; lcanvas._objects[--n]; ) {
        if (lcanvas._objects[n].bg && lcanvas.remove(lcanvas._objects[n]),
        /text/.test(lcanvas._objects[n].type) && ("top" !== lcanvas._objects[n].originY || "center" !== lcanvas._objects[n].originX)) {
            var $point = lcanvas._objects[n].getPointByOrigin("center", "top");
            lcanvas._objects[n].set({
                originX: "center",
                originY: "top",
                left: $point.x,
                top: $point.y
            }),
            lcanvas._objects[n].setCoords()
        }
        "image" !== lcanvas._objects[n].type || lcanvas._objects[n].width && lcanvas._objects[n].height && lcanvas._objects[n].src || lcanvas.remove(lcanvas._objects[n])
    }
    lcanvas.setDimensions(),
    lcanvas.renderAll(),
    canvasarray.length == i + 1 && afterLoadTemplate()
    $('#template-status').val('Template Loaded');
}
function saveHistoryForAllCanvases() {
    s_history = !0,
    autoZoom();
    for (var $c = 0; canvasarray[$c]; )
        canvas = canvasarray[$c],
        save_history(1),
        $c++;
    $("#undo").hide(),
    $("#autosave").data("saved", "yes")
}
function initKeyboardEvents() {
    $("#canvaspages").keyup(function(e) {
        switch (DEBUG && console.log("keyup"),
        DEBUG && console.log(e.key, e.keyCode),
        e.keyCode) {
        case 17:
            remstring = "ctrl ";
            break;
        case 67:
            remstring = " c";
            break;
        case 88:
            remstring = " x";
            break;
        case 86:
            remstring = " v";
            break;
        case 90:
            remstring = " z"
        }
        DEBUG && console.log("keystring: ", keystring),
        -1 != keystring.indexOf(remstring) && (keystring = keystring.replace(remstring, ""))
    }),
    $("#canvaspages").keydown(function(e) {
        if (DEBUG && console.log("keydown"),
        DEBUG && console.log("keystring: ", keystring),
        90 !== e.keyCode && 17 !== e.keyCode && 91 !== e.keyCode) {
            if (e.target && "INPUT" == e.target.nodeName)
                return !1;
            var activeobject = canvas.getActiveObject();
            if (!activeobject && !activeObjectCopy)
                return;
            if (activeobject && activeobject.isEditing)
                return;
            if (activeobject && activeobject.locked && !0 === activeobject.locked)
                return
        }
        switch (DEBUG && console.log("switch"),
        e.keyCode) {
        case 8:
            e.preventDefault(),
            deleteItem();
            break;
        case 17:
            e.preventDefault(),
            keystring = "ctrl";
            break;
        case 91:
            e.preventDefault(),
            keystring = "cmd";
            break;
        case 173:
        case 109:
            return e.preventDefault(),
            !e.ctrlKey && !e.metaKey || objManip("zoomBy-z", -10);
        case 61:
        case 107:
            return !e.ctrlKey && !e.metaKey || demo.objManip("zoomBy-z", 10);
        case 37:
            if (activeobject.lockMovementX) {
                e.preventDefault();
                break
            }
            return e.shiftKey ? objManip("zoomBy-x", -1) : e.ctrlKey || e.metaKey ? objManip("angle", -1) : objManip("left", -1);
        case 39:
            if (activeobject.lockMovementX) {
                e.preventDefault();
                break
            }
            return e.shiftKey ? objManip("zoomBy-x", 1) : e.ctrlKey || e.metaKey ? objManip("angle", 1) : objManip("left", 1);
        case 38:
            if (activeobject.lockMovementY) {
                e.preventDefault();
                break
            }
            return e.shiftKey ? objManip("zoomBy-y", -1) : !(!e.ctrlKey && !e.metaKey) || objManip("top", -1);
        case 40:
            if (activeobject.lockMovementY) {
                e.preventDefault();
                break
            }
            return e.shiftKey ? objManip("zoomBy-y", 1) : !(!e.ctrlKey && !e.metaKey) || objManip("top", 1);
        case 67:
            e.preventDefault(),
            "ctrl c" != (keystring += " c") && "cmd c" != keystring || copyobjs();
            break;
        case 88:
            e.preventDefault(),
            "ctrl x" != (keystring += " x") && "cmd x" != keystring || cutobjs();
            break;
        case 86:
            e.preventDefault(),
            "ctrl v" != (keystring += " v") && "cmd v" != keystring || pasteobjs();
            break;
        case 90:
            e.preventDefault(),
            keystring += " z",
            DEBUG && console.log("keystring: ", keystring),
            "ctrl z" != keystring && "cmd z" != keystring || (DEBUG && console.log("history_undo"),
            history_undo());
            break;
        case 46:
            e.preventDefault(),
            deleteItem()
        }
        return canvas.renderAll(),
        !0
    })
}
$(function() {
    $("#addElement").click(function() {
        newElementTagsEdit.clean(),
        null !== wrapperDz && wrapperDz.removeAllFiles(),
        $("#AddelementModal").modal("show")
    });
    var newElementTagsEdit = $("#newElementTags").tagsField({
        label: "Tags (Will apply to all elements)",
        id: "new-element-tags-id",
        labelColumnClass: "control-label",
        divColumnClass: ""
    });
    $("#AddelementModal").on("shown.bs.modal", function(e) {
        var parent = $("#addElement").parent()[0];
        if ($(parent).removeClass("active"),
        null !== wrapperDz)
            return !1;
        $("#div-new-element-dropzone").dropzone({
            url: appUrl + "admin/Elements/add-elements",
            autoProcessQueue: !1,
            uploadMultiple: !0,
            parallelUploads: 10,
            maxFiles: 10,
            timeout: 24e4,
            maxFilesize: 20,
            acceptedFiles: ".jpeg,.jpg,.png,.svg",
            init: function() {
                wrapperDz = this;
                var wrapperThis = this;
                this.on("addedfile", function(file) {
                    var i, len;
                    if (this.files.length)
                        for (i = 0,
                        len = this.files.length; i < len - 1; i++)
                            if ($iFile = this.files[i].name.replace(/\.[^/.]+$/, ""),
                            $newFile = file.name.replace(/\.[^/.]+$/, ""),
                            $iFile === $newFile)
                                return void this.removeFile(file);
                    var removeButton = Dropzone.createElement("<button class='btn btn-lg dark'>Remove File</button>");
                    removeButton.addEventListener("click", function(e) {
                        e.preventDefault(),
                        e.stopPropagation(),
                        wrapperThis.removeFile(file)
                    }),
                    file.previewElement.appendChild(removeButton)
                })
            }
        })
    }),
    $(document).on("click", "#uploadButton", function() {
        if (newElementTagsEdit.validate()) {
            var tags = JSON.parse(newElementTagsEdit.getTags()).join(",")
              , formData = new FormData;
            formData.append("tags", tags),
            wrapperDz.getQueuedFiles().forEach(function(fileElement) {
                formData.append("file[]", fileElement)
            }),
            formData.append("wsRefId", docUserId),
            $("#AddelementModal").modal("hide"),
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest;
                    return xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var progress = Math.floor(100 * evt.loaded / evt.total);
                            updateToastMsg({
                                text: "Uploading elements: " + progress + "%",
                                icon: "info",
                                loader: !1,
                                position: "top-right",
                                hideAfter: !1
                            })
                        }
                    }, !1),
                    xhr
                },
                method: "post",
                cache: !1,
                contentType: !1,
                processData: !1,
                url: appUrl + "admin/Elements/add-elements",
                data: formData,
                dataType: "json",
                timeout: 6e5
            }).done(function(data) {
                data.success ? 0 == webSocketConn && checkUploadedImages(data.ids) : (setTimeout(function() {
                    $("#AddelementModal").modal("show")
                }, 400),
                $.toast({
                    text: data.msg,
                    icon: "error",
                    loader: !1,
                    position: "top-right",
                    hideAfter: 3e3
                }))
            }).fail(function() {
                setTimeout(function() {
                    $("#AddelementModal").modal("show")
                }, 400),
                $("#uploadButton").prop("disabled", !1),
                $.toast({
                    text: "Request Error",
                    icon: "error",
                    loader: !1,
                    position: "top-right",
                    hideAfter: 3e3
                })
            })
        }
    });
    var checkUploadedImages = function checkUploadedImages(ids) {
        var ref = setTimeout(function() {
            $.ajax({
                method: "post",
                url: appUrl + "admin/Elements/check-if-elements-are-processed",
                data: {
                    ids: ids
                },
                dataType: "json"
            }).done(function(data) {
                data.success && data.finish ? (toastInstance && (toastInstance.reset(),
                toastInstance = null),
                $.toast({
                    text: "Elements added",
                    icon: "success",
                    loader: !1,
                    position: "top-right",
                    hideAfter: 3e3
                }),
                $("#uploadButton").prop("disabled", !1),
                $("#uploadCancelButton").click(),
                initMasonry_element(),
                loadTemplates_element(),
                clearTimeout(ref)) : (updateToastMsg({
                    text: data.msg,
                    icon: "info",
                    loader: !1,
                    position: "top-right",
                    hideAfter: !1
                }),
                checkUploadedImages(ids))
            }).fail(function() {
                toastInstance && (toastInstance.reset(),
                toastInstance = null),
                setTimeout(function() {
                    $("#AddelementModal").modal("show")
                }, 400),
                $("#uploadButton").prop("disabled", !1),
                $.toast({
                    text: "Request Error",
                    icon: "error",
                    loader: !1,
                    position: "top-right",
                    hideAfter: 3e3
                })
            })
        }, 3e3)
    }
}),
$("#addBackground").click(function() {
    newBgTagsEdit.clean(),
    $("#AddbackgroundModal").modal("show")
}),
$("#deletetempcat").click(function() {
    "" != $("#tempcat-select").val() ? $("#Del_templatecatmodal").modal("show") : ($("#alertModal").modal("show"),
    $("#responceMessage").html("Please select the Category, you wish to delete."))
}),
$("#deleteCategory").click(function() {
    "" != $("#cat-select").val() ? $("#Del_catmodal").modal("show") : ($("#alertModal").modal("show"),
    $("#responceMessage").html("Please select the Category, you wish to delete."))
}),
$("#deleteBGCategory").click(function() {
    "" != $("#bgcat-select").val() ? $("#Del_bgcatmodal").modal("show") : ($("#alertModal").modal("show"),
    $("#responceMessage").html("Please select the Category, you wish to delete."))
}),
$("#deletetextcat").click(function() {
    "" != $("#textcat-select").val() ? $("#Del_textcatmodal").modal("show") : ($("#alertModal").modal("show"),
    $("#responceMessage").html("Please select the Category, you wish to delete."))
}),
$("#deleteText").click(function() {
    appSpinner.hide();
    var selectedTxt = [];
    if ($(".textimg-checkbox:checked").each(function() {
        selectedTxt.push($(this).val())
    }),
    "" != selectedTxt) {
        selectedTxt = selectedTxt.join(",");
        var url = appUrl + "design/actions/deleteText.php";
        $.post(url, {
            textid: selectedTxt
        }, function(data) {
            appSpinner.hide(),
            $("#text_container").empty(),
            getTexts2(0, ""),
            document.getElementById("successMessage").innerHTML = data,
            $("#successModal").modal("show")
        })
    } else
        $("#alertModal").modal("show"),
        $("#responceMessage").html("Please select the Text(s), you wish to delete.")
}),
$("#element_img").on("change", prepareUpload),
$("#bg_img").on("change", prepareBGUpload),
$(".deletecanvas").click(function() {
    var id = this.id.replace("deletecanvas", "");
    $("#page" + id).hide();
    var pages = $(".page:visible");
    $.each(pages, function(key, page) {
        adjustIconPos($(page).prop("id").replace("page", ""))
    }),
    1 == $(".page:visible").length && $(".deletecanvas").css("display", "none"),
    $(".page:visible").find(".canvascontent").length > 10 ? $(".download-jpeg-menu-item").hide() : $(".download-jpeg-menu-item").show(),
    setWorkspace(),
    updatePageNumbers()
}),
$(".duplicatecanvas").click(function() {
    if (!$(this).hasClass("disabled")) {
        var id = this.id;
        id = id.replace("duplicatecanvas", ""),
        canvas.discardActiveObject(),
        addNewCanvasPage(!0, id),
        setWorkspace()
    }
}),
$("#font-size-dropdown").on("click", "li a", function() {
    var selSize = $(this).text()
      , activeObject = canvas.getActiveObject();
    if (activeObject) {
        var selectedFontSize = selSize;
        activeObject.fontSize;
        "text" != activeObject.type && "i-text" != activeObject.type || (activeObject.set("fontSize", 1.3 * selectedFontSize),
        activeObject.scaleX = 1,
        activeObject.scaleY = 1,
        activeObject.setCoords()),
        "textbox" == activeObject.type && activeObject.set("fontSize", 1.3 * selectedFontSize / activeObject.scaleX),
        activeObject.setSelectionStyles && activeObject.removeStyle("fontSize"),
        isTextsGroup() && activeObject._objects && (activeObject.forEachObject(function(ch) {
            ch.setSelectionStyles && ch.removeStyle("fontSize"),
            ch.set("fontSize", 1.3 * selectedFontSize),
            ch.scaleX = 1,
            ch.scaleY = 1
        }),
        activeObject._restoreObjectsState(),
        fabric.util.resetObjectTransform(activeObject),
        activeObject._calcBounds(),
        activeObject._updateObjectsCoords(),
        activeObject.setCoords()),
        canvas.renderAll(),
        $(this).parents(".input-group").find(".fontinput").val(selectedFontSize)
    }
}),
$(document).ready(function() {
    sortUnorderedList("fonts-dropdown"),
    $("#fonts-dropdown li a").click(function(e) {
        e.preventDefault();
        var selText = $(this).data("ff")
          , fDisplayName = $(this).parent().find("span").html()
          , activeObject = canvas.getActiveObject();
        $(this).parents(".btn-group").find(".dropdown-toggle").html('<span style="overflow:hidden"><a  style="font-family: ' + selText + '" href="#" data-ff="' + selText + '" size="3">' + fDisplayName + '</a>&nbsp;&nbsp;<span class="caret"></span></span>'),
        activeObject && getFonts2(activeObject, selText).then(function($result) {
            DEBUG && console.log("getFonts2() success", $result),
            fabric.charWidthsCache[$result.font] = {},
            $result.object.__lineWidths = [],
            $result.object._charWidthsCache = {},
            setStyle($result.object, "fontFamily", $result.font),
            activeObject.charSpacing = 0,
            $result.object.setCoords()
        }).catch(function($result) {
            console.log("font " + $result.font + " failed to load")
        }),
        activeObject && activeObject._objects && isTextsGroup() && activeObject.forEachObject(function($o, $i) {
            getFonts2($o, selText).then(function($result) {
                fabric.charWidthsCache[$result.font] = {},
                $result.object.__lineWidths = [],
                $result.object._charWidthsCache = {},
                $result.object.set("fontFamily", $result.font),
                $result.object.initDimensions(),
                $result.object.charSpacing = 0,
                $result.object.setCoords()
            }).then(function() {
                activeObject._restoreObjectsState(),
                fabric.util.resetObjectTransform(activeObject),
                activeObject._calcBounds(),
                activeObject._updateObjectsCoords(),
                activeObject.setCoords(),
                canvas.renderAll()
            }).catch(function($result) {
                console.log("font " + $result.font + " failed to load for object")
            })
        }),
        save_history()
    })
});
var newBgTagsEdit = $("#newBgTags").tagsField({
    label: "Tags",
    id: "new-bg-tags-id",
    labelColumnClass: "control-label col-sm-12",
    divColumnClass: "form-group col-sm-12"
});
// $("#add-background-form").parsley().on("form:submit", function(event) {
//     if (!newBgTagsEdit.validate())
//         return !1;
//     $("#uploadBgButton").html("Uploading..."),
//     $("#uploadBgButton").prop("disabled", !0);
//     var formData = new FormData
//       , tags = JSON.parse(newBgTagsEdit.getTags()).join(",");
//     return formData.append("tags", tags),
//     formData.append("file", $("#bg-img-file")[0].files[0]),
//     formData.append("bgName", $("#bg-name").val()),
//     formData.append("wsRefId", docUserId),
//     $("#AddbackgroundModal").modal("hide"),
//     $("#bg-name").val(""),
//     $("#previewBGImage").hide(),
//     $.ajax({
//         xhr: function() {
//             var xhr = new window.XMLHttpRequest;
//             return xhr.upload.addEventListener("progress", function(evt) {
//                 if (evt.lengthComputable) {
//                     var progress = Math.floor(100 * evt.loaded / evt.total);
//                     updateToastMsg({
//                         text: "Uploading background: " + progress + "%",
//                         icon: "info",
//                         loader: !1,
//                         position: "top-right",
//                         hideAfter: !1
//                     })
//                 }
//             }, !1),
//             xhr
//         },
//         method: "post",
//         cache: !1,
//         contentType: !1,
//         processData: !1,
//         url: appUrl + "admin/Backgrounds/add-background",
//         data: formData,
//         dataType: "json",
//         timeout: 6e5
//     }).done(function(data) {
//         $("#uploadBgButton").prop("disabled", !1),
//         $("#uploadBgButton").html("Add"),
//         data.success ? 0 == webSocketConn && checkUploadedBg(data.ids) : (setTimeout(function() {
//             $("#AddbackgroundModal").modal("show")
//         }, 400),
//         $.toast({
//             text: data.msg,
//             icon: "error",
//             loader: !1,
//             position: "top-right",
//             hideAfter: 3e3
//         }))
//     }).fail(function() {
//         setTimeout(function() {
//             $("#AddbackgroundModal").modal("show")
//         }, 400),
//         $("#uploadBgButton").prop("disabled", !1),
//         $("#uploadBgButton").html("Add"),
//         $.toast({
//             text: "Request Error",
//             icon: "error",
//             loader: !1,
//             position: "top-right",
//             hideAfter: 3e3
//         }),
//         toastInstance.reset(),
//         toastInstance = null
//     }),
//     !1
// });
var checkUploadedBg = function checkUploadedBg(ids) {
    var ref = setTimeout(function() {
        $.ajax({
            method: "post",
            url: appUrl + "admin/Backgrounds/check-if-background-are-processed",
            data: {
                ids: ids
            },
            dataType: "json"
        }).done(function(data) {
            data.success && data.finish ? (toastInstance.reset(),
            toastInstance = null,
            $.toast({
                text: "Backgrounds added",
                icon: "success",
                loader: !1,
                position: "top-right",
                hideAfter: 3e3
            }),
            $("#AddbackgroundModal").modal("hide"),
            clearTimeout(ref)) : (updateToastMsg({
                text: data.msg,
                icon: "info",
                loader: !1,
                position: "top-right",
                hideAfter: !1
            }),
            checkUploadedBg(ids))
        }).fail(function() {
            toastInstance.reset(),
            toastInstance = null,
            setTimeout(function() {
                $("#AddbackgroundModal").modal("show")
            }, 400),
            $("#uploadBgButton").prop("disabled", !1),
            $.toast({
                text: "Request Error",
                icon: "error",
                loader: !1,
                position: "top-right",
                hideAfter: 3e3
            })
        })
    }, 3e3)
};
function sortUnorderedList(ul, sortDescending) {
    if ("string" == typeof ul && (ul = document.getElementById(ul)),
    ul) {
        for (var lis = ul.getElementsByTagName("LI"), vals = [], i = 0, l = lis.length; i < l; i++)
            vals.push(lis[i].innerHTML);
        vals.sort(function(a, b) {
            return a.toLowerCase().localeCompare(b.toLowerCase())
        }),
        sortDescending && vals.reverse();
        for (i = 0,
        l = lis.length; i < l; i++)
            lis[i].innerHTML = vals[i]
    } else
        alert("The UL object is null!")
}
function loadTemplate(templateid) {
    var checkUnsaved = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1];
    if (stopProcess = !0,
    s_history = !1,
    "yes" !== $("#autosave").data("saved") && 0 === demo_as_id && checkUnsaved)
        return $("#unsavedChanges").data("newtemplate", 0),
        $("#unsavedChanges").data("templateid", templateid),
        void $("#unsavedChanges").modal("show");
    setZoom(1),
    appSpinner.show(),
    loadedtemplateid = templateid;
    var url = appUrl + "editor/load-template";
    $.ajax({
        url: url,
        type: "get",
        data: {
            language_code: language_code,
            id: templateid,
            customerId: customerId,
            design_as_id: design_as_id,
            demo_as_id: demo_as_id,
            demo_templates: demo_templates
        },
        dataType: "json",
        success: function(data) {
            if (0 == data.err) {
                if (geofilterBackground = 0,
                template_type = "custom",
                data.options.length) {
                    var options = JSON.parse(data.options);
                    template_type = options.type,
                    instructionsId = options.instructionsId,
                    "geofilter" != template_type && "geofilter2" != template_type || !options.geofilterBackground || (geofilterBackground = options.geofilterBackground),
                    templateOptions = options
                }
                if (savestatecount = 0,
                !openTemplate(data.data))
                    return;
                $("input[name=metric_units]").val([data.metrics]),
                $("input[name=metric_units1]").val([data.metrics]),
                "px" == data.metrics ? ($(".canvas_size_pixels").addClass("active"),
                $(".canvas_size_inches").removeClass("active"),
                $(".canvas_size_mm").removeClass("active")) : "in" == data.metrics ? ($(".canvas_size_inches").addClass("active"),
                $(".canvas_size_pixels").removeClass("active"),
                $(".canvas_size_mm").removeClass("active")) : "mm" == data.metrics && ($(".canvas_size_pixels").removeClass("active"),
                $(".canvas_size_inches").removeClass("active"),
                $(".canvas_size_mm").addClass("active")),
                canvas.calcOffset(),
                canvas.renderAll(),
                $("#autosave").data("saved", "yes"),
                stopProcess = !1,
                data.instructions ? ($("#instructions").html(data.instructions),
                $("#instructions-button").show()) : $("#instructions-button").hide(),
                0 == demo_as_id || setDemoOverlay(),
                initMasonry_related(loadedtemplateid),
                loadTemplates_related(),
                initMasonry_bg()
            } else
                appSpinner.hide(),
                $.toast({
                    text: data.msg,
                    icon: "error",
                    loader: !1,
                    position: "top-right"
                })
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (appSpinner.hide(),
            jqXHR.status) {
            case 400:
                var excp = $.parseJSON(jqXHR.responseText).error;
                DEBUG && console.log("UnableToComplyException:" + excp.message, "warning");
                break;
            case 500:
                excp = $.parseJSON(jqXHR.responseText).error;
                DEBUG && console.log("PanicException:" + excp.message, "panic");
                break;
            default:
                DEBUG && console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText)
            }
            $.toast({
                text: "Something went wrong",
                icon: "error",
                hideAfter: 2e3,
                loader: !1,
                position: "top-right"
            })
        }
    }),
    $("#downloads-remaining-text").hide();
    var urlDownloadsRemaining = appUrl + "editor/get-remaining-downloads/" + templateid+"?customerId="+customerId;
    $.ajax({
        url: urlDownloadsRemaining,
        type: "GET",
        dataType: "json"
    }).done(function(data) {
        data.success && data.remaining && data.remaining > 0 && showDownloadsRemaining(data.remaining)
    }).fail(function() {})
}
$("#unsaved_changes_commit").click(function(e) {
    e.preventDefault();
    var $templateid = $("#unsavedChanges").data("templateid")
      , $newTemplate = $("#unsavedChanges").data("newtemplate");
    $("#unsavedChanges").data("newtemplate", 0),
    $("#unsavedChanges").data("templateid", 0),
    $("#unsavedChanges").modal("hide"),
    $("#autosave").data("saved", "yes"),
    $templateid && loadTemplate($templateid),
    $newTemplate && $("#template_type_modal").modal("show")
}),
$("#unsaved_changes_cancel").click(function(e) {
    e.preventDefault(),
    $("#unsavedChanges").data("newtemplate", 0),
    $("#unsavedChanges").data("templateid", 0),
    $("#unsavedChanges").modal("hide")
});
var showDownloadsRemaining = function(remaining) {
    var text = remaining;
    text += 1 != remaining ? " downloads remaining" : " download remaining",
    $("#downloads-remaining-text").html(text),
    remaining <= 2 ? ($("#downloads-remaining-text").addClass("text-danger"),
    $("#downloads-remaining-text").removeClass("title")) : ($("#downloads-remaining-text").addClass("title"),
    $("#downloads-remaining-text").removeClass("text-danger")),
    $("#downloads-remaining-text").show(),
    0 == remaining && $("#downloads-remaining-text").siblings().hide()
}
  , templateIdToRevert = 0;
function checkAllowRevertTemplate(templateId) {
    var url = appUrl + "editor/check-allow-revert-template?templateId=" + templateId;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json"
    }).done(function(data) {
        templateIdToRevert = templateId,
        data.access ? $("#options-customer").show() : $("#options-customer").hide()
    }).fail(function() {
        $.toast({
            text: "Request Error",
            icon: "error",
            loader: !1,
            position: "top-right",
            hideAfter: 3e3
        })
    })
}
function showRevertTemplate() {
    $("#revertTemplateModal").modal("show")
}
function revertTemplate() {
    appSpinner.show(),
    templateIdToRevert = loadedtemplateid;
    var url = appUrl + "design/app/revert-template";
    $.ajax({
        url: url,
        method: "POST",
        data: {
            templateId: templateIdToRevert
        },
        dataType: "json"
    }).done(function(data) {
        appSpinner.hide(),
        data.success && loadTemplate(templateIdToRevert, !1),
        $.toast({
            text: data.msg,
            icon: data.success ? "success" : "error",
            loader: !1,
            position: "top-right",
            hideAfter: 4e3
        })
    }).fail(function() {
        appSpinner.hide(),
        $.toast({
            text: "Request Error",
            icon: "error",
            loader: !1,
            position: "top-right",
            hideAfter: 3e3
        })
    })
}
function loadText(textid) {
    if (hasCanvas()) {
        appSpinner.show();
        var url = appUrl + "design/loadtext.php";
        $.getJSON(url, {
            id: parseInt(textid)
        }).done(function(json) {
            if (IsJsonString(JSON.stringify(json)) && void 0 !== json.objects)
                for (var objects = json.objects, i = 0; i < objects.length; i++) {
                    "activeSelection" == objects[i].type && (objects[i].type = "group"),
                    fabric.util.getKlass(objects[i].type).fromObject(objects[i], function(element) {
                        canvas.add(element),
                        element.set({
                            originX: "center",
                            originY: "center"
                        }),
                        element.viewportCenter(),
                        element.setCoords(),
                        canvas.setActiveObject(element)
                    })
                }
            else
                $.toast({
                    text: "Text object is corrupted or not exist",
                    icon: "error",
                    loader: !1,
                    position: "top-right",
                    hideAfter: 3e3
                });
            appSpinner.hide(),
            s_history = !0,
            save_history()
        })
    }
}
function loadElement(elementid) {
    DEBUG && console.log("loadElement"),
    DEBUG && console.log(elementid),
    appSpinner.show();
    appUrl;
    $.ajax({
        url: "/design/loadelement.php",
        type: "get",
        data: {
            id: parseInt(elementid)
        },
        success: function(data) {
            var json = JSON.parse(data);
            fabric.util.enlivenObjects([json], function(objects) {
                var origRenderOnAddRemove = canvas.renderOnAddRemove;
                canvas.renderOnAddRemove = !1,
                objects.forEach(function(o) {
                    canvas.add(o),
                    o.viewportCenter(),
                    o.setCoords(),
                    o.viewportCenter();
                    var items = o._objects;
                    o._restoreObjectsState(),
                    canvas.remove(o);
                    for (var i = 0; i < items.length; i++)
                        canvas.add(items[i])
                }),
                canvas.renderOnAddRemove = origRenderOnAddRemove,
                canvas.renderAll()
            }),
            appSpinner.hide()
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
            case 400:
                var excp = $.parseJSON(jqXHR.responseText).error;
                DEBUG && console.log("UnableToComplyException:" + excp.message, "warning");
                break;
            case 500:
                excp = $.parseJSON(jqXHR.responseText).error;
                DEBUG && console.log("PanicException:" + excp.message, "panic");
                break;
            default:
                DEBUG && console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText)
            }
        }
    })
}
var objectFlipHorizontalSwitch = document.getElementById("objectfliphorizontal");
objectFlipHorizontalSwitch && (objectFlipHorizontalSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject.flipX ? activeObject.flipX = !1 : activeObject.flipX = !0,
    canvas.renderAll(),
    save_history())
}
);
var objectFlipVerticalSwitch = document.getElementById("objectflipvertical");
objectFlipVerticalSwitch && (objectFlipVerticalSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject.flipY ? activeObject.flipY = !1 : activeObject.flipY = !0,
    canvas.renderAll(),
    save_history())
}
);
var objectLock = document.getElementById("objectlock");
objectLock && (objectLock.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject._objects && "activeSelection" === activeObject.type ? activeObject.forEachObject(function($c) {
        $c.lockMovementY ? ($c.lockMovementY = $c.lockMovementX = !1,
        $c.hasControls = !0,
        $c.set({
            borderColor: "#4dd7fa"
        })) : ($c.lockMovementY = $c.lockMovementX = !0,
        $c.hasControls = !1,
        $c.set({
            borderColor: "#ff0000"
        }))
    }) : activeObject.lockMovementY ? (activeObject.lockMovementY = activeObject.lockMovementX = !1,
    activeObject.hasControls = !0,
    activeObject.set({
        borderColor: "#4dd7fa"
    })) : (activeObject.lockMovementY = activeObject.lockMovementX = !0,
    activeObject.hasControls = !1,
    activeObject.set({
        borderColor: "#ff0000"
    })),
    canvas.renderAll(),
    save_history()
}
),
$("#group").on("click", function() {
    var activeSelection = canvas.getActiveObject();
    activeSelection && "activeSelection" === activeSelection.type && activeSelection._objects && (activeSelection.toGroup().svg_custom_paths = [],
    $("#group").hide(),
    $("#ungroup").show())
}),
$("#ungroup").click(function() {
    var activeObject = canvas.getActiveObject();
    if ("group" === activeObject.type) {
        var $objects = activeObject.getObjects();
        $.each($objects, function($i, $o) {
            if ($o.isUngrouping = !0,
            !/text/.test($o.type)) {
                var $p = $o.translateToOriginPoint($o.getCenterPoint(), "center", "center");
                $o.set({
                    originX: "center",
                    originY: "center",
                    dirty: !0,
                    left: $p.x,
                    top: $p.y
                })
            }
        }),
        activeObject.toActiveSelection(),
        canvas.getActiveObject().set({
            transparentCorners: !1,
            borderColor: "#f9a24c",
            cornerColor: "#f9a24c",
            cornerSize: 8,
            minScaleLimit: 0,
            padding: 5,
            borderDashArray: [4, 2]
        }),
        $("#ungroup").hide(),
        $("#group").show()
    }
});
var ChangeOpacity = function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        var $opacity = co.getValue();
        activeObject._objects && "activeSelection" === activeObject.type ? activeObject.forEachObject(function($c) {
            $c.set("opacity", $opacity)
        }) : activeObject.set("opacity", $opacity),
        canvas.renderAll()
    }
}
  , co = $("#changeopacity").slider().on("change", ChangeOpacity).data("slider");
function ChangeStrokeWidth(e) {
    DEBUG && console.log("ChangeStrokeWidth"),
    s_history = !1;
    var activeObject = canvas.getActiveObject();
    if ("path-group" === activeObject.type)
        for (var i = 0; i < activeObject.paths.length; i++)
            activeObject.paths[i].set("strokeWidth", e.value);
    if ("group" === activeObject.type && activeObject._objects)
        for (i = 0; i < activeObject._objects.length; i++)
            activeObject._objects[i].set("strokeWidth", e.value);
    "rect" === activeObject.type && (activeObject.viewportCenter(),
    activeObject.set({
        left: (canvas.get("width") / canvas.getZoom() - activeObject.get("width")) / 2,
        top: (canvas.get("height") / canvas.getZoom() - activeObject.get("height")) / 2
    })),
    activeObject.set("strokeWidth", e.value),
    activeObject.setCoords(),
    canvas.renderAll()
}
$("#changestrokewidth").slider().on("slide", ChangeStrokeWidth).data("slider"),
$("#changestrokewidth").slider().on("slideStop", function(e) {
    s_history = !0,
    save_history()
});
var ChangeBorderWH = function() {
    s_history = !1;
    var activeObject = canvas.getActiveObject();
    activeObject.set({
        width: canvas.get("width") / canvas.getZoom() - 96 * cbwh.getValue() * 2,
        height: canvas.get("height") / canvas.getZoom() - 96 * cbwh.getValue() * 2
    }),
    "rect" == activeObject.type && (activeObject.viewportCenter(),
    activeObject.set({
        left: (canvas.get("width") / canvas.getZoom() - activeObject.get("width")) / 2,
        top: (canvas.get("height") / canvas.getZoom() - activeObject.get("height")) / 2
    })),
    activeObject.setCoords(),
    canvas.renderAll()
}
  , cbwh = $("#changeborderwh").slider().on("slide", ChangeBorderWH).data("slider");
function ChangeShadowColor(color) {
    var activeObject = canvas.getActiveObject();
    activeObject && activeObject.shadow && (activeObject.shadow.color = color.toString()),
    lastShadowColor = color.toString(),
    canvas.renderAll()
}
$("#changeborderwh").slider().on("slideStop", function(e) {
    s_history = !0,
    save_history()
}),
$("input#shadowSwitch").click(function() {
    var activeObject = canvas.getActiveObject();
    if ($("input#shadowSwitch").is(":checked")) {
        if (activeObject.shadow)
            activeObject.shadow.color = "rgba(0, 0, 0, 1)";
        else {
            var shadowColor = lastShadowColor || "rgba(0, 0, 0, 1)"
              , shadowBlur = lastShadowBlur || 5
              , shadowOffsetX = lastShadowHorizontalOffset || 5
              , shadowOffsetY = lastShadowVerticalOffset || 5;
            activeObject.setShadow({
                blur: shadowBlur,
                offsetX: shadowOffsetX,
                offsetY: shadowOffsetY,
                color: shadowColor
            })
        }
        $("#shadowGroup .tab-content").removeClass("editor-disabled"),
        $("#shadowColor").spectrum("enable")
    } else
        activeObject.shadow = null,
        $("#shadowGroup .tab-content").addClass("editor-disabled"),
        $("#shadowColor").spectrum("disable");
    canvas.renderAll()
}),
$("#changeBlur").slider();
var ChangeShadowBlur = function() {
    canvas.getActiveObject().shadow.blur = csb.getValue(),
    lastShadowBlur = csb.getValue(),
    canvas.renderAll()
}
  , csb = $("#changeBlur").slider().on("slide", ChangeShadowBlur).data("slider")
  , ChangeShadowHOffset = function() {
    canvas.getActiveObject().shadow.offsetX = csho.getValue(),
    lastShadowHorizontalOffset = csho.getValue(),
    canvas.renderAll()
}
  , csho = $("#changeHOffset").slider().on("slide", ChangeShadowHOffset).data("slider")
  , ChangeShadowVOffset = function() {
    canvas.getActiveObject().shadow.offsetY = csvo.getValue(),
    lastShadowVerticalOffset = csvo.getValue(),
    canvas.renderAll()
}
  , csvo = $("#changeVOffset").slider().on("slide", ChangeShadowVOffset).data("slider");
$("#clone").on("click", function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject.clone(function(clone) {
        if ("activeSelection" === clone.type)
            clone.canvas = canvas,
            clone.forEachObject(function(obj, i) {
                if (obj.scale(1),
                canvas.add(obj),
                obj.set({
                    scaleX: activeObject._objects[i].get("scaleX"),
                    scaleY: activeObject._objects[i].get("scaleY"),
                    left: activeObject._objects[i].get("left"),
                    top: activeObject._objects[i].get("top")
                }),
                "object" === _typeof(activeObject._objects[i].fill) && ("Dpattern" === activeObject._objects[i].fill.type || "pattern" === activeObject._objects[i].fill.type)) {
                    var $p = activeObject._objects[i].fill.toObject();
                    fabric.Dpattern.fromObject($p, function(fill) {
                        return obj.set({
                            fill: fill,
                            dirty: !0
                        })
                    })
                }
                "#ff0000" == activeObject._objects[i].borderColor && (obj.lockMovementY = obj.lockMovementX = !1,
                obj.hasControls = !0,
                obj.set({
                    borderColor: "#4dd7fa"
                })),
                obj.setCoords()
            });
        else {
            if (clone.scale(1),
            canvas.add(clone),
            clone.set({
                scaleX: activeObject.get("scaleX"),
                scaleY: activeObject.get("scaleY")
            }),
            "object" === _typeof(activeObject.fill) && ("Dpattern" === activeObject.fill.type || "pattern" === activeObject.fill.type)) {
                var $p = activeObject.fill.toObject();
                fabric.Dpattern.fromObject($p, function(fill) {
                    return clone.set({
                        fill: fill,
                        dirty: !0
                    })
                })
            }
            "#ff0000" == activeObject.borderColor && (clone.lockMovementY = clone.lockMovementX = !1,
            clone.hasControls = !0,
            clone.set({
                borderColor: "#4dd7fa"
            }))
        }
        clone.set({
            left: activeObject.get("left") + 50,
            top: activeObject.get("top") + 50
        }),
        clone.setCoords(),
        canvas.renderAll(),
        canvas.discardActiveObject(),
        canvas.setActiveObject(clone)
    }, properties_to_save),
    canvas.renderAll())
});
var sendLayerBackSwitch = document.getElementById("sendbackward");
sendLayerBackSwitch && (sendLayerBackSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (canvas.sendBackwards(activeObject),
    canvas.renderAll())
}
);
var bringLayerFrontSwitch = document.getElementById("bringforward");
bringLayerFrontSwitch && (bringLayerFrontSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (canvas.bringForward(activeObject),
    canvas.renderAll())
}
);
var sendLayerToBackSwitch = document.getElementById("sendtoback");
sendLayerToBackSwitch && (sendLayerToBackSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (canvas.sendToBack(activeObject),
    canvas.renderAll())
}
);
var bringLayerToFrontSwitch = document.getElementById("bringtofront");
function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)
}
function onlyUnique(value, index, self) {
    return self.indexOf(value) === index
}
function selectallobjs() {
    canvas.discardActiveObject();
    var objs = canvas.getObjects().map(function(o) {
        return o.set("active", !0)
    });
    objs = objs.filter(function(o) {
        return !o.locked
    });
    var group = new fabric.ActiveSelection(objs,{
        canvas: canvas
    });
    canvas.setActiveObject(group),
    canvas.requestRenderAll()
}
function cutobjs() {
    var $activeObject = canvas.getActiveObject();
    $activeObject && $activeObject.clone(function(cloned) {
        activeObjectCopy = cloned,
        cloned.canvas = canvas,
        "activeSelection" === $activeObject.type ? ($activeObject.forEachObject(function(obj, i) {
            canvas.remove(obj)
        }),
        $activeObject._objects = $activeObject._objects.filter(function(o) {
            return !o.locked
        })) : canvas.remove($activeObject),
        canvas.discardActiveObject(),
        canvas.requestRenderAll()
    }, properties_to_save)
}
function copyobjs() {
    var $activeObject = canvas.getActiveObject();
    $activeObject && $activeObject.clone(function(cloned) {
        activeObjectCopy = cloned,
        "activeSelection" === cloned.type && (cloned.canvas = canvas,
        cloned._objects = cloned._objects.filter(function(o) {
            return !o.locked
        }))
    }, properties_to_save)
}
function pasteobjs($inPlace) {
    activeObjectCopy && activeObjectCopy.clone(function(clonedObj) {
        canvas.discardActiveObject(),
        clonedObj.set({
            evented: !0
        }),
        $inPlace || canvas.viewportCenterObject(clonedObj),
        clonedObj.setCoords(),
        "activeSelection" === clonedObj.type ? (clonedObj.canvas = canvas,
        clonedObj.forEachObject(function(obj, i) {
            obj.scale(1),
            canvas.add(obj),
            obj.set({
                scaleX: activeObjectCopy._objects[i].get("scaleX"),
                scaleY: activeObjectCopy._objects[i].get("scaleY"),
                left: activeObjectCopy._objects[i].get("left"),
                top: activeObjectCopy._objects[i].get("top")
            }),
            obj.setCoords()
        })) : (clonedObj.scale(1),
        canvas.add(clonedObj),
        clonedObj.set({
            scaleX: activeObjectCopy.get("scaleX"),
            scaleY: activeObjectCopy.get("scaleY")
        })),
        clonedObj.setCoords(),
        canvas.setActiveObject(clonedObj),
        canvas.requestRenderAll()
    }, properties_to_save)
}
function toSVG() {
    window.open("data:image/svg+xml;utf8," + encodeURIComponent(canvas.toSVG()))
}
function resizeDownCanvas() {
    canvasScale = Math.round(10 * canvasScale) / 10,
    Math.round(canvas.width) - 20 >= $(".am-content").width() && resizeDownCanvas()
}
function hasCanvas() {
    return !!canvasarray.length || ($.toast({
        text: "Please load a template first",
        icon: "warning",
        loader: !1,
        position: "top-right",
        hideAfter: 2e3
    }),
    !1)
}
bringLayerToFrontSwitch && (bringLayerToFrontSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (canvas.bringToFront(activeObject),
    canvas.renderAll())
}
),
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
,
zoomBy = function(x, y, z) {
    var activeObject = canvas.getActiveObject();
    activeObject && activeObject.zoomBy(x, y, z, function() {
        canvas.renderAll()
    })
}
,
objManip = function(prop, value) {
    var obj = canvas.getActiveObject()
      , grpobjs = obj;
    if (!obj)
        return !0;
    switch (prop) {
    case "zoomBy-x":
        obj.zoomBy(value, 0, 0, function() {
            canvas.renderAll()
        });
        break;
    case "zoomBy-y":
        obj.zoomBy(0, value, 0, function() {
            canvas.renderAll()
        });
        break;
    case "zoomBy-z":
        obj.zoomBy(0, 0, value, function() {
            canvas.renderAll()
        });
        break;
    default:
        obj && 0 == obj.lockMovementX && obj.set(prop, obj.get(prop) + value),
        grpobjs && grpobjs._objects && (grpobjs.set(prop, grpobjs.get(prop) + value),
        grpobjs.setCoords())
    }
    return !obj || "left" !== prop && "top" !== prop || obj.setCoords(),
    canvas.renderAll(),
    !1
}
,
$(document).ready(function() {
    var imageDz = null;
    null === imageDz && $("#myAwesomeDropzone").dropzone({
        url: appUrl + "editor/template/upload-image",
        paramName: "file[]",
        maxFilesize: 20,
        thumbnailWidth: 140,
        previewsContainer: ".uploaded_images",
        acceptedFiles: ".png,.jpg,.jpeg,.svg",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            imageDz = this,
            this.on("success", function(file, $answer) {
                var data = JSON.parse($answer);
                if (data.success) {
                    $(file.previewElement).data("id", data.id);
                    var deleteBtn = "";
                    demo_as_id || (deleteBtn = '<i class="fa fa-trash-o deleteImage" data-target="' + data.id + '"></i>'),
                    $(".uploaded_images .dz-preview").each(function(index, element) {
                        var img = $(element).find(".dz-image img").attr("src")
                          , name = $(element).find(".dz-filename span").html()
                          , items = '<div data-id="' + data.id + '" class="dz-preview dz-processing dz-image-preview dz-success dz-complete thumb"><div class="dz-image"><img data-dz-thumbnail="" alt="' + name + '" src="' + img + '"></div> \x3c!-- <div class="dz-details"> <div class="dz-filename"><span data-dz-name="">' + name + "</span></div>  </div> --\x3e" + deleteBtn + "</div>";
                        items = $(items),
                        infinites.image.infiniteScroll("appendItems", items).masonry("appended", items)
                    }),
                    $(".uploaded_images").html("")
                } else
                    $.toast({
                        text: data.msg,
                        icon: "error",
                        loader: !1,
                        position: "top-right",
                        hideAfter: 3e3
                    })
            })
        }
    }),
    $("#template_tags,#element_tags, #bg_tags,#new_element_tags").select2({
        tags: !0,
        width: "100%",
        tokenSeparators: [","]
    }),
    $("input[name=metric_units1]").val(["in"]),
    $("input[name=metric_units]").val(["in"]),
    $("#undo").hide(),
    $("#productImageDownload").hide(),
    $(".page *").length || ($("#addnewpagebutton").hide(),
    $("#saveimage").hide(),
    $("#saveastemplate").hide(),
    $(".download-menu").hide(),
    $(".zoom-control").hide(),
    $("#options").hide()),
    $("#savetemplate").hide(),
    initMasonry_template(),
    loadTemplates_template(),
    initMasonry_image(),
    loadTemplates_image(),
    getUploadedImages(0)
}),
$(window).load(function() {
    if ("administrator" == currentUserRole && !hideVideoModal) {
        $("#modal-video").modal(),
        $(document).on("click", "#hide-video", function() {
            var url = appUrl + "design/actions/hideVideo.php";
            $.get(url)
        });
        var youtubeFunc = ""
          , youtubeIframe = document.getElementById("modal-video").getElementsByTagName("iframe")[0].contentWindow;
        $("#modal-video").on("hidden.bs.modal", function(e) {
            youtubeFunc = "pauseVideo",
            youtubeIframe.postMessage('{"event":"command","func":"' + youtubeFunc + '","args":""}', "*")
        })
    }
}),
$(".noclose").on("click", function(e) {
    e.stopPropagation()
}),
$(document).on("click", ".catImage", function() {
    if (hasCanvas()) {
        appSpinner.show();
        var imagepath = $(this).data("imgsrc")
          , $svgsrc = $(this).data("svgsrc");
        $(this).parents(".thumb").attr("id");
        imagepath || (imagepath = $(this).attr("src")),
        (/\.png$/i.test(imagepath) || /\.jpg$/i.test(imagepath)) && addPNGToCanvas(imagepath),
        /\.svg$/i.test(imagepath) && addSVGToCanvas(imagepath),
        /\.json$/i.test(imagepath) && addJsonToCanvas(imagepath),
        $svgsrc && addSVGToCanvas($svgsrc)
    }
    return !1
}),
$(document).on("click", ".bgImage", function() {
    if (hasCanvas()) {
        var bgimagepath = $(this).data("imgsrc");
        $("#bgscale").slider("setValue", 100),
        setCanvasBg(canvas, bgimagepath, "", 1, currentcanvasid)
    }
    return !1
}),
$(document).on("click", "#bgImageRemove", function() {
    return deleteCanvasBg(canvas),
    $("#bgcolorselect").spectrum("set", ""),
    !1
});
var tempIdToDel = "";
$(document).on("click", ".deleteTemp", function() {
    showDeleteModal("Delete Template", "Are you sure you want to delete this template?", "Be sure this template id is not associated with any listings!", "deleteTemplate", $(this).attr("id"))
}),
$(document).on("click", ".deleteText", function() {
    deleteText($(this).attr("id"))
}),
$(document).on("click", ".deleteElement", function() {
    showDeleteModal("Delete Element", "Are you sure you want to delete this element?", "Be sure this element id is not associated with any templates!", "deleteElement", $(this).attr("id"))
}),
$(document).on("click", ".deleteBg", function() {
    showDeleteModal("Delete Background", "Are you sure you want to delete this background?", "Be sure this background id is not associated with any templates!", "deleteBg", $(this).attr("id"))
}),
$(document).on("click", ".deleteImage", function() {
    deleteImage($(this).data("target"))
}),
$("#publishTemplate").click(function() {
    $("#publishModal").modal("show")
}),
$("#canvasSize").click(function() {
    void 0 !== canvasarray[currentcanvasid] && ($("#new_canvas_width").val(Number(Number($("#loadCanvasWid").val()).toFixed(3))),
    $("#new_canvas_height").val(Number(Number($("#loadCanvasHei").val()).toFixed(3))),
    $("#new_canvas_width_pixels").val(Math.round(96 * $("#loadCanvasWid").val() * 3.125)),
    $("#new_canvas_height_pixels").val(Math.round(96 * $("#loadCanvasHei").val() * 3.125)),
    $("#new_canvas_width_mm").val(Number(Number(25.4 * $("#loadCanvasWid").val()).toFixed(2))),
    $("#new_canvas_height_mm").val(Number(Number(25.4 * $("#loadCanvasHei").val()).toFixed(2))),
    $("#canvasSizeModal").modal("show"))
}),
$("#changeCanvasSize").click(function(e) {
    $("#canvasSizeModal").modal("hide");
    var $canvas_width = parseFloat($("#new_canvas_width").val())
      , $canvas_height = parseFloat($("#new_canvas_height").val())
      , $new_canvas_width = 96 * $canvas_width
      , $new_canvas_height = 96 * $canvas_height;
    $("#loadCanvasWid").val($canvas_width),
    $("#loadCanvasHei").val($canvas_height),
    $new_canvas_width > 0 && $new_canvas_height > 0 && (setZoom(1),
    scale_canvas_to($new_canvas_width, $new_canvas_height)),
    setWorkspace()
});
var $color_selector_options = $spectrum_options;
$color_selector_options.change = function(color) {
    DEBUG && console.log("color: ", color),
    null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
    var local_store = window.localStorage[localStorageKey];
    if (-1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
    color)
        colorVal = color.toHexString();
    else
        var colorVal = "";
    var $activeObject = canvas.getActiveObject()
      , $gradientType = getGradientTypeofObject($activeObject);
    if ($activeObject && !1 !== $gradientType) {
        var $color2 = $("#colorSelector2").spectrum("get");
        $color2 = $color2 ? $color2.toHexString() : "#" + ("000000" + ("0xffffff" ^ colorVal.replace("#", "0x")).toString(16)).slice(-6),
        DEBUG && console.log("#colorSelector: ", $gradientType, colorVal, $color2),
        switchFillType($gradientType, colorVal, $color2),
        applyGradient(colorVal, $color2, $gradientType)
    } else
        changeObjectColor(colorVal),
        $("#colorSelector").css("background", colorVal)
}
,
$color_selector_options.move = function(color) {
    var colorVal = "";
    color && (colorVal = color.toHexString());
    var $activeObject = canvas.getActiveObject()
      , $gradientType = getGradientTypeofObject($activeObject);
    if ($activeObject && !1 !== $gradientType) {
        var $color2 = $("#colorSelector2").spectrum("get");
        $color2 = $color2 ? $color2.toHexString() : "#" + ("000000" + ("0xffffff" ^ colorVal.replace("#", "0x")).toString(16)).slice(-6),
        DEBUG && console.log("#colorSelector: ", $gradientType, colorVal, $color2),
        switchFillType($gradientType, colorVal, $color2),
        applyGradient(colorVal, $color2, $gradientType)
    } else
        changeObjectColor(colorVal),
        $("#colorSelector").css("background", colorVal)
}
,
$("#colorSelector").spectrum($color_selector_options);
var $color_selector2_options = $spectrum_options;
function getCatimages2($offset, $tags) {}
function getUploadedImages($offset) {
    $(".uploaded_images_list");
    var url = appUrl + "editor/get-additional-assets/?offset=" + $offset;
    $.getJSON(url).done(function(data) {
        data.success,
        "administrator" != currentUserRole && "designer" != currentUserRole || ($("#tab-upload").hide(),
        !isNaN(design_as_id) && design_as_id > 0 ? $("#tab-upload").show() : data.images.length > 0 && ($("#tab-upload").show(),
        $("#tab-upload .dz-message").hide(),
        $("#myAwesomeDropzone").css({
            border: "none"
        }),
        $("#myAwesomeDropzone").removeClass("dz-clickable")))
    })
}
function getBgimages2($offset, $tags) {}
function getTemplates2($offset, $tags) {}
$color_selector2_options.change = function(color) {
    DEBUG && console.log("color: ", color),
    null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
    var local_store = window.localStorage[localStorageKey];
    if (-1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
    color)
        colorVal = color.toHexString();
    else
        var colorVal = "#000000";
    var $activeObject = canvas.getActiveObject()
      , $color1 = $("#colorSelector").spectrum("get")
      , $gradientType = getGradientTypeofObject($activeObject);
    $activeObject && !1 !== $gradientType && ($color1 = $color1 ? $color1.toHexString() : $activeObject.fill.colorStops[0].color,
    DEBUG && console.log("#colorSelector2: ", $gradientType, $color1, colorVal),
    switchFillType($gradientType, $color1, colorVal),
    applyGradient($color1, colorVal, $gradientType))
}
,
$color_selector2_options.move = function(color) {
    var colorVal = "";
    color && (colorVal = color.toHexString());
    var $activeObject = canvas.getActiveObject()
      , $gradientType = getGradientTypeofObject($activeObject);
    if ($activeObject && !1 !== $gradientType) {
        var $color1 = $("#colorSelector").spectrum("get");
        $color1 = $color1 ? $color1.toHexString() : "#" + ("000000" + ("0xffffff" ^ colorVal.replace("#", "0x")).toString(16)).slice(-6),
        DEBUG && console.log("#colorSelector: ", $gradientType, $color1, colorVal),
        switchFillType($gradientType, $color1, colorVal),
        applyGradient($color1, colorVal, $gradientType)
    } else
        changeObjectColor(colorVal),
        $("#colorSelector2").css("background", colorVal)
}
,
$("#colorSelector2").spectrum($color_selector2_options),
$("#bgcolorselect").spectrum({
    flat: !0,
    showPalette: !0,
    showPaletteOnly: !0,
    togglePaletteOnly: !0,
    preferredFormat: "hex",
    allowEmpty: !0,
    hideAfterPaletteSelect: !0,
    showSelectionPalette: !0,
    localStorageKey: localStorageKey,
    showInput: !0,
    showInitial: !1,
    showButtons: !1,
    maxSelectionSize: 24,
    togglePaletteMoreText: "Show advanced",
    togglePaletteLessText: "Hide advanced",
    move: function(color) {
        if (color) {
            colorVal = color.toHexString();
            0 != canvasindex && (deleteCanvasBg(canvas),
            setCanvasBg(canvas, !1, colorVal))
        } else
            var colorVal = ""
    }
}),
$("#bgcolorselect").on("dragstop.spectrum", function(e, color) {
    setTimeout(function() {
        null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
        var local_store = window.localStorage[localStorageKey];
        -1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
        $("#bgcolorselect").spectrum("set", color)
    }, 0)
}),
$("#bgcolorcontainer input").keypress(function(e) {
    if (13 == e.which) {
        var color = $(this).val();
        null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
        var local_store = window.localStorage[localStorageKey];
        -1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
        $("#bgcolorselect").spectrum("set", color),
        0 != canvasindex && (deleteCanvasBg(canvas),
        setCanvasBg(canvas, !1, color))
    }
}),
$("#colorStrokeSelector").spectrum({
    containerClassName: "color-stroke",
    showPaletteOnly: !0,
    togglePaletteOnly: !0,
    showPalette: !0,
    preferredFormat: "hex",
    hideAfterPaletteSelect: !0,
    showSelectionPalette: !0,
    localStorageKey: localStorageKey,
    showInput: !0,
    showInitial: !0,
    allowEmpty: !0,
    showButtons: !1,
    maxSelectionSize: 24,
    togglePaletteMoreText: "Show advanced",
    togglePaletteLessText: "Hide advanced",
    change: function(color) {
        DEBUG && console.log("color: ", color),
        null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
        var local_store = window.localStorage[localStorageKey];
        if (-1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
        color)
            colorVal = color.toHexString();
        else
            var colorVal = "";
        changeStrokeColor(colorVal),
        $("#colorStrokeSelector").css("backgroundColor", colorVal)
    },
    beforeShow: function(color) {
        $(this).spectrum("set", canvas.getActiveObject().stroke)
    },
    move: function(color) {
        if (DEBUG && console.log("colorStrokeSelector"),
        color)
            colorVal = color.toHexString();
        else
            var colorVal = "";
        changeStrokeColor(colorVal),
        $("#colorStrokeSelector").css("backgroundColor", colorVal)
    }
}),
$("#shadowColor").spectrum({
    containerClassName: "color-shadow",
    showPaletteOnly: !0,
    togglePaletteOnly: !0,
    showPalette: !0,
    hideAfterPaletteSelect: !1,
    showSelectionPalette: !0,
    localStorageKey: localStorageKey,
    showInput: !0,
    showInitial: !0,
    preferredFormat: "hex",
    flat: !0,
    showButtons: !1,
    maxSelectionSize: 24,
    togglePaletteMoreText: "Show advanced",
    togglePaletteLessText: "Hide advanced",
    showAlpha: !0,
    move: function(color) {
        if (DEBUG && console.log("color: ", color),
        color)
            colorVal = color;
        else
            var colorVal = "";
        ChangeShadowColor(colorVal)
    }
}),
$("#shadowColor").on("dragstop.spectrum", function(e, color) {
    setTimeout(function() {
        null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
        var local_store = window.localStorage[localStorageKey];
        -1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
        $("#shadowColor").spectrum("set", color)
    }, 0)
}),
$("#shadowTabs .sp-input").keypress(function(e) {
    if (13 == e.which) {
        var color = $(this).val();
        null == window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";");
        var local_store = window.localStorage[localStorageKey];
        -1 == local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color),
        $("#shadowColor").spectrum("set", color),
        ChangeShadowColor(color)
    }
}),
$(".toolbar-top .sp-palette-toggle, .color-fill .sp-palette-toggle, .color-stroke .sp-palette-toggle").addClass("btn btn-default"),
$("#bgcolorcontainer .sp-palette-toggle").addClass("btn btn-alt4"),
$("#bgcolorcontainer input").attr("placeholder", "Type a # hex color code and hit enter"),
jQuery(function($) {
    $("#a").on("scroll", function() {
        flag_scroll_templates_template || 100 * ($(this).scrollTop() + $(this).innerHeight()) / $(this)[0].scrollHeight > 95 && ($(aContainer_template).next().find(".loader-ellips").show(),
        $(aContainer_template).next().find(".iscroll-button").hide(),
        flag_scroll_templates_template = !0,
        loadTemplates_template())
    }),
    $("#b").on("scroll", function() {
        flag_scroll_templates_text || 100 * ($(this).scrollTop() + $(this).innerHeight()) / $(this)[0].scrollHeight > 95 && ($(aContainer_text).next().find(".loader-ellips").show(),
        $(aContainer_text).next().find(".iscroll-button").hide(),
        flag_scroll_templates_text = !0,
        loadTemplates_text())
    }),
    $("#c").on("scroll", function() {
        flag_scroll_templates_element || 100 * ($(this).scrollTop() + $(this).innerHeight()) / $(this)[0].scrollHeight > 95 && ($(aContainer_element).next().find(".loader-ellips").show(),
        $(aContainer_element).next().find(".iscroll-button").hide(),
        flag_scroll_templates_element = !0,
        loadTemplates_element())
    }),
    $("#d").on("scroll", function() {
        flag_scroll_templates_bg || 100 * ($(this).scrollTop() + $(this).innerHeight()) / $(this)[0].scrollHeight > 95 && ($(aContainer_bg).next().find(".loader-ellips").show(),
        $(aContainer_bg).next().find(".iscroll-button").hide(),
        flag_scroll_templates_bg = !0,
        loadTemplates_bg())
    }),
    $("#e").on("scroll", function() {
        flag_scroll_templates_related || 100 * ($(this).scrollTop() + $(this).innerHeight()) / $(this)[0].scrollHeight > 95 && ($(aContainer_related).next().find(".loader-ellips").show(),
        $(aContainer_related).next().find(".iscroll-button").hide(),
        flag_scroll_templates_related = !0,
        loadTemplates_related())
    }),
    $("#f").on("scroll", function() {
        flag_scroll_templates_image || 100 * ($(this).scrollTop() + $(this).innerHeight()) / $(this)[0].scrollHeight > 95 && ($(aContainer_image).next().find(".loader-ellips").show(),
        $(aContainer_image).next().find(".iscroll-button").hide(),
        flag_scroll_templates_image = !0,
        loadTemplates_image())
    })
}),
$(".uploaded_images_list").on("click", ".dz-preview:not(.dz-error)", function(e) {
    if (!$(e.target).hasClass("deleteImage")) {
        var id = $(this).data("id");
        if (id && hasCanvas()) {
            appSpinner.show();
            var url = appUrl + "editor/template/get-uploaded-image/" + id;
            $.getJSON(url).done(function(data) {
                if (data.success) {
                    var image_link = encodeURI(data.img);
                    if (data.img && /\.sv?g$/i.test(data.img))
                        return void addSVGToCanvas(image_link);
                    fabric.Image.fromURL(image_link, function($image) {
                        $image.scaleToWidth($image.get("width") / 3.125),
                        $image.width > $image.height ? $image.width > canvas.width && $image.scaleToWidth(canvas.width - 40) : $image.height > canvas.height && $image.scaleToHeight(canvas.height - 40),
                        canvas.discardActiveObject(),
                        $image.set({
                            originX: "center",
                            originY: "center"
                        }),
                        canvas.viewportCenterObject($image),
                        $image.setCoords(),
                        canvas.add($image),
                        canvas.renderAll(),
                        canvas.setActiveObject($image),
                        appSpinner.hide()
                    }, {
                        crossOrigin: "Anonymous"
                    })
                } else
                    $.toast({
                        text: data.msg,
                        icon: "error",
                        loader: !1,
                        position: "top-right",
                        hideAfter: 2e3
                    }),
                    appSpinner.hide()
            })
        }
    }
}),
$("#cancel_templates_search").click(function(e) {
    e.preventDefault(),
    $("#templatesearch").val(""),
    $("#a").scrollTop(0),
    initMasonry_template(),
    loadTemplates_template()
}),
$("#cancel_text_search").click(function(e) {
    e.preventDefault(),
    $("#textsearch").val(""),
    initMasonry_text(),
    loadTemplates_text()
}),
$("#cancel_elements_search").click(function(e) {
    e.preventDefault(),
    $("#elementssearch").val(""),
    initMasonry_element(),
    loadTemplates_element()
}),
$("#cancel_bg_search").click(function(e) {
    e.preventDefault(),
    $("#bgsearch").val(""),
    initMasonry_bg(),
    loadTemplates_bg()
});
var relatedProductPage = 0
  , relatedProductCount = 2;
function getRelatedProducts(templateId, page) {}
function getTexts2($offset, $tags) {}
function handleFileSelect(evt) {
    $("ul.navbar-nav>li.dropdown").removeClass("open");
    for (var f, files = evt.target.files, i = 0; f = files[i]; i++)
        if (-1 != f.name.indexOf(".ype")) {
            var reader = new FileReader;
            reader.onload = function(e) {
                openTemplate(e.target.result)
            }
            ,
            reader.readAsText(f)
        }
}
function handleContextmenu(e) {
    e.preventDefault(),
    $(".custom-menu").find(".flatten").hide(),
    $(".custom-menu").find(".unflatten").hide(),
    canvas.getActiveObject() && canvas.getActiveObject().locked && !0 === canvas.getActiveObject().locked && $(".custom-menu").find(".unflatten").show(),
    canvas.getActiveObject() && !canvas.getActiveObject().locked && $(".custom-menu").find(".flatten").show(),
    canvas.getActiveObject() && canvas.getActiveObject().locked && !0 === canvas.getActiveObject().locked && !$("body").hasClass("admin") ? ($(".custom-menu").find(".copy").hide(),
    $(".custom-menu").find(".cut").hide(),
    $(".custom-menu").find(".unflatten").hide(),
    $(".custom-menu").find(".flatten").hide()) : ($(".custom-menu").find(".copy").show(),
    $(".custom-menu").find(".cut").show()),
    $(".custom-menu").finish().toggle(100).css({
        top: e.pageY + "px",
        left: e.pageX + "px"
    })
}
function flatten() {
    var $objects = canvas.getActiveObjects();
    $objects && ($.each($objects, function($i, $o) {
        makeObjectNotSelectable($o)
    }),
    canvas.renderAll())
}
function unflatten() {
    var $objects = canvas.getActiveObjects();
    $objects && $.each($objects, function($i, $o) {
        makeObjectSelectable($o)
    })
}
$("#relatedProductsPane .col-lg-12.scroll-container").on("click", function() {
    getRelatedProducts(loadedtemplateid)
}),
$(document).ready(function() {
    $("#canvaswhForm").validate({
        rules: {
            loadCanvasWid: {
                required: !0,
                number: !0
            },
            loadCanvasHei: {
                required: !0,
                number: !0
            },
            numOfcanvasrows: {
                required: !0,
                number: !0
            },
            numOfcanvascols: {
                required: !0,
                number: !0
            }
        },
        highlight: function(element) {
            $(element).closest(".form-group").removeClass("has-success").addClass("has-error")
        },
        success: function(element) {
            element.text("").addClass("valid").closest(".form-group").removeClass("has-error").addClass("has-success"),
            element.remove("label")
        },
        submitHandler: function(form) {
            canvasindex = 0,
            canvasarray = [],
            pageindex = 0,
            loadedtemplateid = 0,
            $("#canvaspages > div").not("#page0").remove(),
            $("#page0").empty(),
            addCanvasToPage(),
            setCanvasSize(),
            autoZoom();
            var i = 0;
            for (s_history = !0; canvasarray[i]; )
                canvas = canvasarray[i],
                save_history(1),
                canvas.renderAll(),
                canvas.setDimensions(),
                i++;
            setWorkspace()
        }
    })
}),
$("#opentemplate").click(function(e) {
    e.preventDefault(),
    $("#opentemplate_input").click()
}),
$("#opentemplate_input").change(function(evt) {
    handleFileSelect(evt)
}),
$("#showmoreoptions").click(function() {
    $("#showmoreoptions ul li").find("a.temphide").removeClass("temphide").css("display", "block"),
    $("#opacitySlider").hide(),
    $("#lineheightSlider").hide(),
    $("#charspacingSlider").hide(),
    $("#borderwhSlider").hide(),
    $("#textuppercase").hide(),
    $("#textlowercase").hide(),
    $("#textcapitalize").hide();
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        activeObject._objects && "activeSelection" === activeObject.type ? $("#objectlock").html("<i class='fa fa-lock'></i>&nbsp;&nbsp; Toggle Lock") : 1 == activeObject.lockMovementY ? $("#objectlock").html("<i class='fa fa-unlock'></i>&nbsp;&nbsp; Unlock Object") : $("#objectlock").html("<i class='fa fa-lock' style='font-size:16px;'></i>&nbsp;&nbsp; Lock Position"),
        activeObject.get("stroke") ? $("#addremovestroke").html("<i class='fa' style='font-size: 18px;'>▣</i>&nbsp; Remove Stroke") : ($("#strokegroup").hide(),
        $("#addremovestroke").html("<i class='fa' style='font-size: 18px;'>▣</i>&nbsp; Add Stroke"));
        var objectopacity = activeObject.get("opacity");
        $("#changeopacity").slider("setValue", objectopacity);
        var objectborderwh = (canvas.get("width") - activeObject.get("width")) / 96 / 2;
        if ($("#changeborderwh").slider("setValue", objectborderwh),
        "textbox" == activeObject.type || "text" == activeObject.type || "i-text" == activeObject.type) {
            var textlineheight = activeObject.get("lineHeight");
            $("#changelineheight").slider("setValue", textlineheight);
            var textcharspacing = activeObject.charSpacing / 100;
            $("#changecharspacing").slider("setValue", textcharspacing)
        }
    }
}),
$("#shadowGroup").click(function() {
    $("#shadowColor").spectrum("set", "rgba(0, 0, 0, 1)");
    var activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.get("shadow")) {
        var objectShadow = activeObject.get("shadow");
        objectShadow.color && ($("#shadowSwitch").prop("checked", !0),
        $("#shadowColor").spectrum("enable"),
        $("#shadowColor").spectrum("set", objectShadow.color)),
        $("#changeBlur").slider("setValue", objectShadow.blur),
        $("#changeHOffset").slider("setValue", objectShadow.offsetX),
        $("#changeVOffset").slider("setValue", objectShadow.offsetY)
    } else
        $("#shadowSwitch").prop("checked", !1),
        $("#shadowGroup .tab-content").addClass("editor-disabled"),
        $("#shadowColor").spectrum("disable")
}),
$("#shadowGroup a.dropdown-toggle").on("click", function(event) {
    $(this).parent().toggleClass("open")
}),
$("body").on("click", function(e) {
    $("#shadowGroup").is(e.target) || 0 !== $("#shadowGroup").has(e.target).length || 0 !== $(".open").has(e.target).length || ($("#shadowGroup").removeClass("open"),
    $("#shadowTabs .nav-tabs li").first().tab("show"),
    $("#color").removeClass("active"),
    $("#appearance").addClass("active"))
}),
$("#strokedropdown").click(function() {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        var objectstrokewidth = activeObject.get("strokeWidth");
        $("#changestrokewidth").slider("setValue", objectstrokewidth)
    }
}),
$("#objectopacity").click(function() {
    $("#opacitySlider").toggle(),
    $("#showmoreoptions ul li a").each(function() {
        "block" == $(this).css("display") && $(this).not("#objectopacity").addClass("temphide")
    })
}),
$("#lineheight").click(function() {
    $("#lineheightSlider").toggle(),
    $("#showmoreoptions ul li a").each(function() {
        "block" == $(this).css("display") && $(this).not("#lineheight").addClass("temphide")
    })
}),
$("#charspacing").click(function() {
    $("#charspacingSlider").toggle(),
    $("#showmoreoptions ul li a").each(function() {
        "block" == $(this).css("display") && $(this).not("#charspacing").addClass("temphide")
    })
}),
$("#objectborderwh").click(function() {
    $("#borderwhSlider").toggle(),
    $("#showmoreoptions ul li a").each(function() {
        "block" == $(this).css("display") && $(this).not("#objectborderwh").addClass("temphide")
    })
}),
$("#textcase").click(function() {
    $("#textuppercase, #textlowercase, #textcapitalize").toggle(),
    $("#showmoreoptions ul li a").each(function() {
        "block" == $(this).css("display") && $(this).not("#textuppercase, #textlowercase, #textcapitalize").addClass("temphide")
    })
}),
$("#hideobject").click(function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject.hidden ? (activeObject.hidden = !1,
    $("#hideobject").html("<i class='fa fa-eye'></i>&nbsp; Hide object in pdf/png")) : (activeObject.hidden = !0,
    $("#hideobject").html("<i class='fa fa-eye'></i>&nbsp; Unhide object in pdf/png")))
}),
$("#changeopacity").slider({
    formatter: function(value) {
        return 100 * value + "%"
    }
}),
$("#bgscale").slider({
    formatter: function(value) {
        return value + "%"
    }
}),
$("#canvasbox-tab").bind("contextmenu", function(e) {
    return handleContextmenu(e),
    !1
}),
$(".custom-menu li").click(function(e) {
    var selectedObject = canvas.getActiveObject();
    if (selectedObject && -1 != ["i-text", "textbox"].indexOf(selectedObject.type) && selectedObject.isEditing) {
        switch ($(this).attr("data-action")) {
        case "selectall":
            selectedObject.selectAll();
            break;
        case "copy":
            selectedObject.copy();
            break;
        case "cut":
            selectedObject.selectionStart != selectedObject.selectionEnd && (selectedObject.copy(),
            selectedObject.removeChars(selectedObject.selectionStart, selectedObject.selectionEnd));
            break;
        case "paste":
            selectedObject.paste()
        }
        canvas.renderAll()
    } else
        switch ($(this).attr("data-action")) {
        case "selectall":
            selectallobjs();
            break;
        case "copy":
            copyobjs();
            break;
        case "cut":
            cutobjs();
            break;
        case "paste":
            pasteobjs();
            break;
        case "pasteInPlace":
            pasteobjs("inPlace");
            break;
        case "flatten":
            flatten();
            break;
        case "unflatten":
            unflatten()
        }
    $(".custom-menu").hide(100)
}),
$(document).unbind("keydown").bind("keydown", function(event) {
    var doPrevent = !1;
    if (8 === event.keyCode) {
        var d = event.srcElement || event.target;
        doPrevent = ("INPUT" !== d.tagName.toUpperCase() || "TEXT" !== d.type.toUpperCase() && "PASSWORD" !== d.type.toUpperCase() && "FILE" !== d.type.toUpperCase() && "SEARCH" !== d.type.toUpperCase() && "EMAIL" !== d.type.toUpperCase() && "NUMBER" !== d.type.toUpperCase() && "DATE" !== d.type.toUpperCase()) && "TEXTAREA" !== d.tagName.toUpperCase() || (d.readOnly || d.disabled)
    }
    doPrevent && event.preventDefault()
});
var textuppercaseSwitch = document.getElementById("textuppercase");
textuppercaseSwitch && (textuppercaseSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject._objects && "activeSelection" === activeObject.type ? activeObject.forEachObject(function(e) {
        /text/.test(e.type) && (e.text = e.text.toUpperCase())
    }) : /text/.test(activeObject.type) && (activeObject.text = activeObject.text.toUpperCase()),
    canvas.renderAll())
}
);
var textlowercaseSwitch = document.getElementById("textlowercase");
textlowercaseSwitch && (textlowercaseSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject._objects && "activeSelection" === activeObject.type ? activeObject.forEachObject(function(e) {
        /text/.test(e.type) && (e.text = e.text.toLowerCase())
    }) : /text/.test(activeObject.type) && (activeObject.text = activeObject.text.toLowerCase()),
    canvas.renderAll())
}
);
var textcapitalizeSwitch = document.getElementById("textcapitalize");
function capitalizeFirstAllWords(str) {
    for (var pieces = str.split(" "), i = 0; i < pieces.length; i++) {
        var j = pieces[i].charAt(0).toUpperCase();
        pieces[i] = j + pieces[i].substr(1)
    }
    return pieces.join(" ")
}
function updatePageNumbers() {
    "doublesided" == template_type ? ($(".pagenumber").css("visibility", "visible"),
    $(".pagenumber:visible").each(function(i, obj) {
        $(this).text(["Front", "Back"][i])
    })) : $(".pagenumber:visible").length > 1 ? ($(".pagenumber:visible").each(function(i, obj) {
        $(this).text(i + 1)
    }),
    $(".pagenumber").css("visibility", "visible")) : $(".pagenumber").css("visibility", "hidden")
}
function setGeofilterBackground(index) {
    background = 0 == index ? "none" : "url(/design/assets/img/" + geofilterBackgrounds[index].filename + ")",
    $("#canvas0").fadeTo("fast", .3, function() {
        $("#canvas0").css("background-image", background)
    }).fadeTo("fast", 1)
}
function nextBackground() {
    ++geofilterBackground == geofilterBackgrounds.length && (geofilterBackground = 0),
    setGeofilterBackground(geofilterBackground)
}
function prevBackground() {
    --geofilterBackground < 0 && (geofilterBackground = geofilterBackgrounds.length - 1),
    setGeofilterBackground(geofilterBackground)
}
function showDeleteModal(title, message, message2, callback, id) {
    $("#deleteModalTitle").html(title),
    $("#deleteModalMessage").html(message),
    $("#deleteModalMessage2").html(message2),
    $("#deleteModal").modal("show"),
    $("#proceedDelete").attr("onclick", callback + "(" + id + ")")
}
function convertToDoublesided() {
    template_type = "doublesided",
    setWorkspace(),
    updatePageNumbers();
    for (var $n = 0; canvasarray[$n]; )
        $("#divcanvas" + $n).is(":visible") && adjustIconPos($n),
        $n++;
    $.toast({
        text: "Template converted",
        icon: "success",
        loader: !1,
        position: "top-right",
        hideAfter: 2e3
    })
}
function convertToSingle() {
    template_type = "single",
    setWorkspace(),
    updatePageNumbers();
    for (var $n = 0; canvasarray[$n]; )
        $("#divcanvas" + $n).is(":visible") && adjustIconPos($n),
        $n++;
    $.toast({
        text: "Template converted",
        icon: "success",
        loader: !1,
        position: "top-right",
        hideAfter: 2e3
    })
}
function convertGeofilterToNewSize() {
    template_type = "geofilter2",
    $("#loadCanvasHeightPx").val(2340),
    $("#loadCanvasHei").val(24.375),
    setCanvasSize(),
    setWorkspace(),
    setZoom(),
    $.toast({
        text: "Template converted",
        icon: "success",
        loader: !1,
        position: "top-right",
        hideAfter: 2e3
    })
}
function trackRelatedProducts(listing_id) {
    appUrl;
    $.get("/trackRelatedProducts.php", {
        listing_id: listing_id
    })
}
textcapitalizeSwitch && (textcapitalizeSwitch.onclick = function() {
    var activeObject = canvas.getActiveObject();
    activeObject && (activeObject._objects && "activeSelection" === activeObject.type ? activeObject.forEachObject(function(e) {
        /text/.test(e.type) && (e.text = e.text.toLowerCase(),
        e.text = capitalizeFirstAllWords(e.text))
    }) : /text/.test(activeObject.type) && (activeObject.text = activeObject.text.toLowerCase(),
    activeObject.text = capitalizeFirstAllWords(activeObject.text)),
    canvas.renderAll())
}
),
$("body").tooltip({
    selector: "[data-toggle=tooltip]"
}),
$("#canvaspages").mouseup(function() {
    $(".rotation_info_block").hide()
}),
$("#printInstructions").click(function() {
    var oDoc = document.getElementById("printIframe").contentDocument
      , text = document.getElementById("instructions").innerHTML;
    oDoc.write('<head><title>Instructions From The Seller</title></head><body onload="this.focus(); this.print();"><div style="white-space: pre-wrap;">' + text + "</div></body>"),
    oDoc.close()
}),
$(".paper-input").hide(),
$(".sidebar-elements li a").not(".sidebar-elements.zoom-control li a").click(function() {
    $(".sidebar-elements .sub-menu").parent().removeClass("active"),
    $(this).parent().addClass("active")
}),
$("body").on("click", function(e) {
    $(".submenu.visible").is(e.target) || 0 !== $(".submenu.visible").has(e.target).length || 0 !== $(".parent").parent().has(e.target).length || $(".sidebar-elements .sub-menu").parent().removeClass("active")
}),
$(document).ajaxError(function(event, jqxhr, settings, thrownError) {
    "Unauthorized" != thrownError && 401 != jqxhr.status || 0 !== demo_as_id || ($("#loginModal").modal("show"),
    appSpinner.hide()),
    500 == jqxhr.status && (appSpinner.hide(),
    $.toast({
        text: "Something went wrong on server. Please try again later",
        icon: "error",
        hideAfter: 3e3,
        loader: !1,
        position: "top-right"
    }))
}),
$("#loginForm").submit(function(e) {
    e.preventDefault(),
    0 != $("#loginForm").parsley().isValid() && ($button = $("#loginButton"),
    $button.html("Logging..."),
    $.ajax({
        method: "POST",
        url: appUrl + "security/login-check",
        data: {
            username: $("#username").val(),
            password: $("#password").val(),
            platform: platform.description,
            remember: $("#remember").is(":checked")
        },
        dataType: "json"
    }).done(function(data) {
        data.success ? ($("#loginModal").modal("hide"),
        $("#password").val(""),
        $button.html("Log in")) : $button.html("Error. Please check your information")
    }).fail(function() {
        button.html("Error. Please Try again")
    }))
}),
$(document).ready(function() {
    $.each(geofilterBackgrounds, function(key, value) {
        key > 0 && ($("<img/>")[0].src = "/design/assets/img/" + value.filename) && ($("<img/>")[0].loading = "lazy")
    })
});
var makeCRCTable = function() {
    for (var c, crcTable = [], n = 0; n < 256; n++) {
        c = n;
        for (var k = 0; k < 8; k++)
            c = 1 & c ? 3988292384 ^ c >>> 1 : c >>> 1;
        crcTable[n] = c
    }
    return crcTable
}
  , crc32 = function(str) {
    for (var crcTable = window.crcTable || (window.crcTable = makeCRCTable()), crc = -1, i = 0; i < str.length; i++)
        crc = crc >>> 8 ^ crcTable[255 & (crc ^ str.charCodeAt(i))];
    return (-1 ^ crc) >>> 0
};
function optimizeCanvasesOnPage2($paperWidthIn, $paperHeightIn, $canvasWidth, $canvasHeight, $isCropNeeded) {
    var $cmp = 0;
    $isCropNeeded && ($cmp = 12),
    "a4" === $(".paper-size.active").find('input[name="paperSize"]').val() && ($paperWidthIn = 8.267,
    $paperHeightIn = 11.692),
    void 0 === $paperWidthIn && ($paperWidthIn = 8.5),
    void 0 === $paperHeightIn && ($paperHeightIn = 11);
    var $paperWidthPx = 96 * $paperWidthIn
      , $paperHeightPx = 96 * $paperHeightIn
      , $pWidth = $canvasWidth = $canvasWidth || canvasarray[0].get("width") / canvasarray[0].getZoom()
      , $pHeight = $canvasHeight = $canvasHeight || canvasarray[0].get("height") / canvasarray[0].getZoom();
    DEBUG && console.log("$canvasWidth: " + $canvasWidth),
    DEBUG && console.log("$canvasHeight: " + $canvasHeight),
    DEBUG && console.log("$paperWidthPx: " + $paperWidthPx),
    DEBUG && console.log("$paperHeightPx: " + $paperHeightPx);
    var $verticallyAmount = Math.floor(($paperWidthPx - $cmp) / ($canvasWidth + $cmp)) * Math.floor(($paperHeightPx - $cmp) / ($canvasHeight + $cmp));
    DEBUG && console.log("portrait amount: " + $verticallyAmount);
    var $horizontallyAmount = Math.floor(($paperHeightPx - $cmp) / ($canvasWidth + $cmp)) * Math.floor(($paperWidthPx - $cmp) / ($canvasHeight + $cmp));
    if (DEBUG && console.log("landscape: " + $horizontallyAmount),
    0 === $verticallyAmount && 0 === $horizontallyAmount)
        return {
            paperWidthPx: $pWidth,
            paperHeightPx: $pHeight,
            amountOfColumnsOnPage: 1,
            amountOfRowsOnPage: 1,
            offsetX: 0,
            offsetY: 0
        };
    if ($verticallyAmount > $horizontallyAmount) {
        var $amountOfColumnsOnPage = Math.floor(($paperWidthPx - $cmp) / ($canvasWidth + $cmp))
          , $amountOfRowsOnPage = Math.floor(($paperHeightPx - $cmp) / ($canvasHeight + $cmp));
        DEBUG && console.log("portrait selected"),
        $pWidth = $paperWidthPx,
        $pHeight = $paperHeightPx
    } else {
        $amountOfColumnsOnPage = Math.floor(($paperHeightPx - $cmp) / ($canvasWidth + $cmp)),
        $amountOfRowsOnPage = Math.floor(($paperWidthPx - $cmp) / ($canvasHeight + $cmp));
        DEBUG && console.log("landscape selected"),
        $pWidth = $paperHeightPx,
        $pHeight = $paperWidthPx
    }
    return {
        paperWidthPx: $pWidth,
        paperHeightPx: $pHeight,
        amountOfColumnsOnPage: $amountOfColumnsOnPage,
        amountOfRowsOnPage: $amountOfRowsOnPage,
        offsetX: ($pWidth - $amountOfColumnsOnPage * $canvasWidth - $cmp * ($amountOfColumnsOnPage + 1)) / 2,
        offsetY: ($pHeight - $amountOfRowsOnPage * $canvasHeight - $cmp * ($amountOfRowsOnPage + 1)) / 2
    }
}
function loadInstructions(templateId) {
    $("#instructions").html("<p>Loading...</p>");
    var url = appUrl + "design/actions/getInstructions.php";
    $.getJSON(url, {
        templateId: templateId
    }).done(function(answer) {
        answer.err ? $.toast({
            text: answer.msg,
            icon: "error",
            loader: !1,
            position: "top-right",
            hideAfter: 3e3
        }) : $("#instructions").html(answer.instructions)
    })
}
function convertToNewPxFormat() {
    canvasarray.forEach(function(canv) {
        canv.cwidth = (.32 * templateOptions.width).toFixed(2),
        canv.cheight = (.32 * templateOptions.height).toFixed(2),
        setCanvasWidthHeight(canv.cwidth, canv.cheight),
        $("#loadCanvasWid").val((canv.cwidth / 96).toFixed(2)),
        $("#loadCanvasHei").val((canv.cheight / 96).toFixed(2)),
        canv.bgsrc && (canv.bgScale *= .32),
        canv.getObjects().forEach(function(obj) {
            obj.scaleX *= .32,
            obj.scaleY *= .32,
            obj.left *= .32,
            obj.top *= .32,
            obj.setCoords()
        }),
        canv.renderAll()
    }),
    stopProcess = !1,
    updateTemplate(1),
    setZoom(3.125 * parseFloat($("#zoomperc").data("scaleValue")))
}
function afterLoadTemplate() {
    Promise.all([backgroundPromise]).then(function() {
        saveHistoryForAllCanvases(),
        selectCanvas("divcanvas0"),
        "geofilter" != template_type && "geofilter2" != template_type && ("px" == templateOptions.metrics && setZoom(1),
        autoZoom(),
        demo_as_id && setDemoOverlay()),
        "geofilter2" == template_type && setGeofilterOverlay(),
        "geofilter" == template_type || "geofilter2" == template_type || templateOptions.scriptVersion && !(templateOptions.scriptVersion < 4) || "px" != templateOptions.metrics || demo_as_id ? appSpinner.hide() : convertToNewPxFormat(),
        setWorkspace()
    })
}
function showDuplicateTemplateModal() {
    $("#duplicateTemplateModal").modal("show"),
    $("#duplicateTemplateModal p").html("In order to add another template to your account,         we'll need to first save the one you're working on. Then we'll create another template         based on this one and add it to your account. Ready?"),
    $(".proceedDuplicateTemplateFooter").addClass("active"),
    $(".loadDuplicatedTemplateFooter").removeClass("active")
}
function duplicateTemplate(el) {
    loadedtemplateid && ($(el).html("Duplicating..."),
    $(el).attr("disabled", "disabled"),
    updateTemplate().then(function() {
        var url = appUrl + "design/actions/duplicateTemplate.php";
        $.getJSON(url, {
            id: loadedtemplateid,
            design_as_id: design_as_id
        }).done(function(answer) {
            answer.success ? (duplicatedTemplateId = answer.id,
            $("#duplicateTemplateModal p").html("Do you want to switch over to the new template?                         Your changes have already been saved on the current template."),
            $(".proceedDuplicateTemplateFooter").removeClass("active"),
            $(".loadDuplicatedTemplateFooter").addClass("active"),
            getTemplates2(0, "")) : $.toast({
                text: answer.msg,
                icon: "error",
                loader: !1,
                position: "top-right"
            }),
            $(el).html("Continue"),
            $(el).removeAttr("disabled")
        })
    }))
}
!function(console) {
    console.image = function(url, scale) {
        scale = scale || 1;
        var img = new Image;
        img.onload = function() {
            var width, height, dim = (width = this.width * scale,
            height = this.height * scale,
            {
                string: "+",
                style: "font-size: 1px; padding: " + Math.floor(height / 2) + "px " + Math.floor(width / 2) + "px; line-height: " + height + "px;"
            });
            console.log("%c" + dim.string, dim.style + "background: url(" + url + "); background-size: " + this.width * scale + "px " + this.height * scale + "px; color: transparent; background-repeat: no-repeat"),
            console.log("image dimensions", this.width, this.height)
        }
        ,
        img.src = url
    }
}(console),
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
}),
$("#object-grayscale").checkboxradio({
    icon: !1,
    classes: {
        "ui-checkboxradio-label": "btn btn-default"
    }
}),
$("#object-scale,#object-hue,#object-brightness,#object-contrast,#object-saturation,#object-blur").slider();
var $filter_multiplier_hue = 50
  , $filter_multiplier = 100;
function getPropertiesOfObject(event, ui) {
    s_history = !1;
    var $obj = canvas.getActiveObject();
    if ($("#object-properties").find(".may-be-disabled").addClass("editor-disabled"),
    $obj) {
        var $scale = 3.125 * $obj.get("scaleX") * 100;
        $("#object-scale").slider("setValue", parseFloat($scale) || 100),
        $("#object-scale").slider("setAttribute", "ticks_snap_bounds", 1),
        $obj.get("width") < fabric.textureSize && $("#object-properties").find(".may-be-disabled").removeClass("editor-disabled"),
        $("#object-hue").slider("setValue", parseFloat(getFilterValue("HueRotation")) * $filter_multiplier_hue || 0),
        $("#object-hue").slider("setAttribute", "ticks_snap_bounds", 1),
        $("#object-brightness").slider("setValue", parseFloat(getFilterValue("Brightness")) * $filter_multiplier || 0),
        $("#object-brightness").slider("setAttribute", "ticks_snap_bounds", 1),
        $("#object-contrast").slider("setValue", parseFloat(getFilterValue("Contrast")) * $filter_multiplier || 0),
        $("#object-contrast").slider("setAttribute", "ticks_snap_bounds", 1),
        $("#object-saturation").slider("setValue", parseFloat(getFilterValue("Saturation")) * $filter_multiplier || 0),
        $("#object-saturation").slider("setAttribute", "ticks_snap_bounds", 1),
        $("#object-blur").slider("setValue", parseFloat(getFilterValue("Blur")) * $filter_multiplier || 0),
        $("#object-blur").slider("setAttribute", "ticks_snap_bounds", 1),
        $("#object-grayscale").prop("checked", !!getFilterValue("Grayscale")).checkboxradio("refresh")
    }
    $(".slider").blur()
}
$("#showObjectProperties").click(function(e) {
    e.preventDefault(),
    $("#object-properties").dialog("open")
}),
$("#object-scale").slider().on("slide", function(e) {
    var $obj = canvas.getActiveObject();
    if ($obj) {
        var $sc = this.value / 3.125 / 100;
        $obj.set({
            scaleX: $sc,
            scaleY: $sc
        }),
        canvas.renderAll()
    }
}),
$("#object-hue").slider().on("slide", function(e) {
    var $f = new fabric.Image.filters.HueRotation;
    applyFilter($f, $f.mainParameter, parseFloat(this.value) / $filter_multiplier_hue)
}),
$("#object-brightness").slider().on("slide", function(e) {
    var $f = new fabric.Image.filters.Brightness;
    applyFilter($f, $f.mainParameter, parseFloat(this.value) / $filter_multiplier)
}),
$("#object-contrast").slider().on("slide", function(e) {
    var $f = new fabric.Image.filters.Contrast;
    applyFilter($f, $f.mainParameter, parseFloat(this.value) / $filter_multiplier)
}),
$("#object-saturation").slider().on("slide", function(e) {
    var $f = new fabric.Image.filters.Saturation;
    applyFilter($f, $f.mainParameter, parseFloat(this.value) / $filter_multiplier)
}),
$("#object-blur").slider().on("slide", function(e) {
    var $f = new fabric.Image.filters.Blur;
    applyFilter($f, $f.mainParameter, parseFloat(this.value) / $filter_multiplier)
}),
$("#object-grayscale").on("change", function(e) {
    var $f = new fabric.Image.filters.Grayscale
      , $parameter = $f.mainParameter;
    this.checked ? applyFilter($f, $parameter, "average") : resetFilter("Grayscale")
});
try {
    var webglBackend = new fabric.WebglFilterBackend;
    fabric.filterBackend = webglBackend,
    fabric.filterBackend = fabric.initFilterBackend()
} catch (e) {
    var canvas2dBackend = new fabric.Canvas2dFilterBackend;
    fabric.filterBackend = canvas2dBackend,
    fabric.filterBackend = fabric.initFilterBackend()
}
var $filters = ["Grayscale", "Invert", "Remove-color", "Sepia", "Brownie", "Brightness", "Contrast", "HueSaturation", "Noise", "Vintage", "Pixelate", "Blur", "Sharpen", "Emboss", "Technicolor", "Polaroid", "Blend-color", "Gamma", "Kodachrome", "Blackwhite", "Blend-image", "Hue", "Resize"];
function applyFilter($filter, $property, $value, $obj) {
    if ($obj || ($obj = canvas.getActiveObject()),
    $obj && void 0 !== $obj.filters) {
        var $index = -1;
        $filter[$property] = $value,
        $.each($obj.filters, function($i, $f) {
            this.type == $filter.type && ($index = $i)
        }),
        $index > -1 ? $obj.filters[$index][$property] = $value : $obj.filters.push($filter),
        $obj.applyFilters(),
        canvas.renderAll()
    }
}
function getFilterValue($filter, $obj) {
    if ($obj || ($obj = canvas.getActiveObject()),
    $obj) {
        var $return = !1;
        if (void 0 !== _typeof($filter))
            return $.each($obj.filters, function($f) {
                var $type = this.type
                  , $value = this[this.mainParameter];
                $type == $filter && ($return = $value)
            }),
            $return
    }
}
function resetFilter($filter, $obj) {
    $obj || ($obj = canvas.getActiveObject()),
    $obj && void 0 !== _typeof($filter) && ($.each($obj.filters, function($i, $f) {
        this.type == $filter && $obj.filters.splice($i, 1)
    }),
    $obj.applyFilters(),
    canvas.renderAll())
}
function showFontUploadModal() {
    $("#fontUpload").click()
}
function uploadFont() {
    appSpinner.show();
    var data = new FormData;
    data.append("file", $("#fontUpload").prop("files")[0]);
    var url = appUrl + "admin/Fonts/add-font";
    $.ajax({
        url: url,
        type: "POST",
        processData: !1,
        contentType: !1,
        dataType: "json",
        data: data,
        timeout: 12e4,
        success: function(data) {
            data.success ? ($("#fontDetailsModal").modal("show"),
            $("#fontId").val(data.id),
            $("#fontOriginalName").val(data.originalName),
            $("#fontDisplayName").val(data.originalName)) : $.toast({
                text: data.msg,
                icon: "error",
                hideAfter: 3e3,
                loader: !1,
                position: "top-right"
            })
        },
        error: function() {
            $.toast({
                text: "Something went wrong",
                icon: "error",
                hideAfter: 3e3,
                loader: !1,
                position: "top-right"
            })
        },
        complete: function() {
            appSpinner.hide()
        }
    })
}
function saveFontDetails() {
    if ($("#fontDetailsModal").modal("hide"),
    $("#fontOriginalName").val() != $("#fontDisplayName").val()) {
        appSpinner.show();
        var url = appUrl + "admin/Fonts/editFont";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                id: $("#fontId").val(),
                originalName: $("#fontOriginalName").val(),
                displayName: $("#fontDisplayName").val()
            },
            success: function(data) {
                data.success ? $.toast({
                    text: "Font saved",
                    icon: "success",
                    hideAfter: 2e3,
                    loader: !1,
                    position: "top-right"
                }) : $.toast({
                    text: "Something went wrong",
                    icon: "error",
                    hideAfter: 2e3,
                    loader: !1,
                    position: "top-right"
                })
            },
            error: function() {
                $.toast({
                    text: "Something went wrong",
                    icon: "error",
                    hideAfter: 2e3,
                    loader: !1,
                    position: "top-right"
                })
            },
            complete: function() {
                appSpinner.hide()
            }
        })
    } else
        $.toast({
            text: "Font saved",
            icon: "success",
            hideAfter: 2e3,
            loader: !1,
            position: "top-right"
        })
}
$("body").on("click", ".filter-reset-all", function(e) {
    e.preventDefault();
    var $obj = canvas.getActiveObject();
    $(".filter-wrapper").map(function() {
        var $filter_input = $(this).find("input[data-filter-index]")
          , $filter_index = $filter_input.data("filter-index")
          , $default_value = $filter_input.data("slider-value");
        void 0 !== _typeof($filter_index) && $obj && $obj.filters && ("Scale" === $filter_index ? ($obj.set({
            scaleX: .32,
            scaleY: .32
        }),
        canvas.renderAll()) : resetFilter($filter_index),
        $filter_input.slider("setValue", $default_value))
    }),
    resetFilter("Grayscale"),
    $("#object-grayscale").prop("checked", !1),
    $('label[for="object-grayscale"]').removeClass("ui-state-active")
}),
$("#fontUpload").change(function() {
    $("#fontConfirmationModal").modal("show"),
    $("#fontConfirmationCheckbox").prop("checked", !1),
    $("#proceedFontUploadBtn").attr("disabled", "disabled")
}),
$("#fontConfirmationCheckbox").change(function() {
    $(this).is(":checked") ? $("#proceedFontUploadBtn").removeAttr("disabled") : $("#proceedFontUploadBtn").attr("disabled", "disabled")
}),
$("#showColors").click(function(e) {
    e.preventDefault(),
    $("#dynamiccolorpickers").fadeToggle(),
    $(this).toggleClass("expanded")
});
var AppSpinner = function() {
    this.show = function() {
        $("#appSpinner").is(":visible") || $("#appSpinner").show()
    }
    ,
    this.hide = function() {
        $("#appSpinner").is(":visible") && $("#appSpinner").hide()
    }
}
  , appSpinner = new AppSpinner;
function updatePatternFill($s) {
    var $ao = canvas.getActiveObject();
    $ao && ($ao.fill.update({
        scale: $s.value / 100 * .32 / fabric.devicePixelRatio
    }),
    $ao.dirty = !0,
    canvas.renderAll())
}
function generatePatterns() {
    var $offset = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0
      , $amount = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 16
      , $keys = Object.keys(fabric.Color.colorNameMap)
      , $patterns = [];
    if ($offset + $amount > $keys.length)
        return $patterns;
    for (var $i = $offset; $i < $amount + $offset; $i++)
        $patterns.push(GeoPattern.generate($keys[$i]));
    return $patterns
}
function getPatterns() {
    var $offset = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0
      , $tags = arguments.length > 1 ? arguments[1] : void 0;
    if ("undefined" == typeof patternsLoading || !patternsLoading) {
        patternsLoading = !0;
        var $grid = $("#patternsList")
          , $patterns = "";
        0 == $offset && ($grid.empty(),
        offsetPatterns = 0),
        $(".loading-icon").css({
            left: $grid.offset().left + $grid.outerWidth() / 2 - 32,
            top: $grid.offset().top + $grid.height() / 2 - 16
        }).show();
        var url = appUrl + "editor/get-bg-images";
        return $.getJSON(url, {
            offset: $offset,
            limit: 24,
            tags: $tags,
            demo_as_id: demo_as_id,
            design_as_id: design_as_id,
            template_id: loadedtemplateid
        }).done(function($answer) {
            if ("0" == $answer.err && $answer.data) {
                demo_as_id;
                jQuery.each($answer.data, function($i, $val) {
                    $patterns += '<a class="pattern_tile ' + this.isownitem + '" id="' + this.id + '" href="#" data-imgsrc="' + this.url + '"><img class="img-responsive" src="' + this.thumb + '" alt=""></a>'
                }),
                $grid.append($patterns),
                offsetPatterns += 24
            }
            $answer.data || 0 != $offset || $grid.html("<h3>No Results</h3>")
        }).always(function() {
            patternsLoading = !1,
            $(".loading-icon").hide()
        }),
        !0
    }
}
function changeDynamicPattern($object, $newSrc, $oldSrc) {
    $object._objects && !$object.isEmpty() ? $object._objects.map(function($c) {
        $c._objects && !$c.isEmpty() ? changeDynamicPattern($c, $newSrc, $oldSrc) : $c.fill && $c.fill instanceof fabric.Dpattern && $c.fill.src === $oldSrc && setDynamicPattern($c, $newSrc)
    }) : setDynamicPattern($object, $newSrc)
}
function setDynamicPattern($o, $src) {
    $o.set("fill", new fabric.Dpattern({
        scale: .32 / fabric.devicePixelRatio,
        src: $src
    },function($p) {
        $(".patternScale").slider("setValue", 100),
        $(".pattern_tile").removeClass("loading"),
        $(".patternFillPreview.open").data("currentsrc", $src).css("background-image", "url(" + $p.toDataURL({
            multiplier: fabric.devicePixelRatio,
            width: $p.width * $p.scale,
            height: $p.height * $p.scale,
            quality: .6
        }) + ")")
    }
    )),
    $o.dirty = !0,
    canvas.renderAll()
}
function checkDpatterns() {
    for (var $i = 0; canvasarray[$i]; )
        $.each(canvasarray[$i]._objects, function(i, o) {
            !function restoreDpatternSource($o) {
                if ($o._objects && $.each($o._objects, function($a, $child) {
                    return restoreDpatternSource($child)
                }),
                "object" === _typeof($o.fill) && /pattern/.test($o.fill.type) && !($o.fill instanceof fabric.Dpattern)) {
                    var $p = {
                        repeat: $o.fill.repeat,
                        crossOrigin: $o.fill.crossOrigin,
                        offsetX: $o.fill.offsetX,
                        offsetY: $o.fill.offsetY,
                        patternTransform: $o.fill.patternTransform ? $o.fill.patternTransform.concat() : null,
                        padding: $o.fill.padding,
                        scale: $o.fill.scale,
                        src: $o.fill.src,
                        width: $o.fill.width,
                        height: $o.fill.height
                    };
                    $o.fill.source && "string" == typeof $o.fill.source.src && ($p.source = $o.fill.source),
                    fabric.Dpattern.fromObject($p, function(fill) {
                        $o.set({
                            fill: fill,
                            dirty: !0
                        }),
                        $o.canvas.renderAll()
                    })
                }
            }(o)
        }),
        $i++
}
function checkUTF8Symbols() {
    var $font = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : ""
      , callback = arguments.length > 1 ? arguments[1] : void 0;
    if (!$font)
        return !1;
    var url = appUrl + "editor/get-woff-font-url?font_id=" + $font;
    $.ajax({
        url: url,
        method: "get",
        dataType: "json"
    }).done(function(data) {
        data.success && opentype.load(data.url, function(err, font) {
            if (err)
                $.toast({
                    text: "Could not load font.",
                    icon: "error",
                    loader: !1,
                    position: "top-right"
                });
            else {
                for (var keys = [], glyphs = font.glyphs.glyphs, glyphsKeys = Object.keys(glyphs), i = 0; i < glyphsKeys.length; i++)
                    void 0 !== glyphs[glyphsKeys[i]].unicode && keys.push(glyphs[glyphsKeys[i]].unicode);
                callback(keys)
            }
        })
    }).fail(function() {
        return $.toast({
            text: "Glyph font request error",
            icon: "error",
            loader: !1,
            position: "top-right"
        }),
        !1
    })
}
function setupSymbolsPanel() {
    var $font = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : ""
      , $text = canvas.getActiveObject();
    if ($text)
        if ($font || ($font = $text.fontFamily),
        $fontUTF8Symbols[$font] && "object" === _typeof($fontUTF8Symbols[$font])) {
            var $markup = "";
            $.each($fontUTF8Symbols[$font], function($i, $s) {
                $markup += '<span data-code="' + $s + '" class="utf8-symbol">&#' + $s + "</span>"
            }),
            $(".utf8-symbols").html($markup).css("font-family", $font)
        } else
            checkUTF8Symbols($font, function(keys) {
                if ($fontUTF8Symbols[$font] = keys,
                $fontUTF8Symbols[$font].length) {
                    var $markup = "";
                    $.each($fontUTF8Symbols[$font], function($i, $s) {
                        $markup += '<span data-code="' + $s + '" class="utf8-symbol">&#' + $s + "</span>"
                    }),
                    $(".utf8-symbols").html($markup).css("font-family", $font)
                }
            })
}
$("body").on("pattern_image_loaded", function(e) {
    DEBUG && console.log("pattern_image_loaded"),
    $(".pattern_tile").removeClass("loading"),
    setTimeout(function() {
        canvas._objects.map(function(o) {
            "object" === _typeof(o.fill) && /pattern/.test(o.fill.type) && o.set("dirty", !0),
            canvas.renderAll()
        })
    }, 100)
}),
$(".patternScale").slider().on("slide", updatePatternFill).data("slider"),
$(".patternScale").slider().on("slideStart", function(e) {
    $(".patternFillTab").addClass("fade")
}),
$(".patternScale").slider().on("slideStop", function(e) {
    $(".patternFillTab").removeClass("fade")
}),
$("body").on("click", ".patternFillLabel", function(e) {
    e.preventDefault();
    var $btn = $(e.target);
    $(".patternFillPreview").removeClass("open"),
    $btn.toggleClass("open");
    var $modal = $(".patternFillTab");
    $modal.toggle(),
    $modal.css({
        left: $btn.offset().left,
        top: $btn.offset().top + 34
    });
    var $ao = canvas.getActiveObject();
    $ao && $ao.fill instanceof fabric.Dpattern && $(".patternScale").slider("setValue", 100 * $ao.fill.scale * 3.125 * fabric.devicePixelRatio)
}),
$(".patternFillTab").on("click", ".pattern_tile", function(e) {
    var $ao = canvas.getActiveObject()
      , $pattern_tile = $(e.target).parent(".pattern_tile");
    $pattern_tile.addClass("loading"),
    changeDynamicPattern($ao, $pattern_tile.data("imgsrc"), $(".patternFillPreview.open").data("currentsrc"))
}),
$(document).ready(function() {
    // Get background patterns
    // getPatterns(0),
    // $("#patternsList").on("scroll", function(e) {
    //     var element = $(e.target).get(0);
    //     element.scrollTop > element.scrollHeight - element.offsetHeight - 10 && (patternsLoading || getPatterns(offsetPatterns))
    // })
}),
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
}),
$("body").on("click", ".utf8-symbol", function(e) {
    e.preventDefault();
    var $textObject = canvas.getActiveObject();
    if ($textObject && /text/.test($textObject.type)) {
        var $symbol = $(this).text()
          , $selectionStart = $textObject.text.length
          , $selectionEnd = $textObject.text.length;
        $textObject.isEditing && ($selectionStart = $textObject.selectionStart,
        $selectionEnd = $textObject.selectionEnd),
        $textObject.insertChars($symbol, "", $selectionStart, $selectionEnd),
        $selectionEnd === $selectionStart && ($textObject.selectionStart = $textObject.selectionEnd = ++$selectionEnd),
        $textObject.isEditing && ($textObject.hiddenTextarea.value = $textObject.text),
        $textObject.dirty = !0,
        canvas.renderAll()
    }
}),
$("#showObSymbolsPanel").click(function() {
    return $("#font-symbols").dialog("open")
}),
$("#fontSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    })
}),
$("#font-dropdown").on("hide.bs.dropdown", function(e) {
    $("#fontSearch").val(""),
    $(".dropdown-menu li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf("") > -1)
    }),
    $("#fontSearch").blur()
}),
$(".left-sidebar-dropdown-menu").on("hide.bs.dropdown", function(e) {
    $(".left-sidebar-dropdown-menu .dropdown-menu li").removeClass("active")
});
// var webSocketConn = !1
//   , countConnection = 0;
// function wsConection() {
//     var conn = new WebSocket(wsDir);
//     conn.onopen = function(e) {
//         console.log("connected to WS"),
//         webSocketConn = !0,
//         countConnection++,
//         conn.send(JSON.stringify({
//             type: "id",
//             userId: docUserId
//         })),
//         keepConnection()
//     }
//     ,
//     conn.onclose = function(event) {
//         conn.close(),
//         webSocketConn = !1,
//         reConnectWS()
//     }
//     ;
//     var reConnectWS = function() {
//         !webSocketConn && countConnection > 0 && setTimeout(function() {
//             wsConection()
//         }, 1e3)
//     }
//       , keepConnection = function keepConnection() {
//         setTimeout(function() {
//             keepConnection(),
//             webSocketConn && conn && conn.send(JSON.stringify({
//                 type: "id",
//                 userId: docUserId
//             }))
//         }, 2e4)
//     };
//     conn.onmessage = function(msg) {
//         var msgObj = JSON.parse(msg.data);
//         msgObj.userId == docUserId && processWsMsg(msgObj)
//     }
//     ;
//     var processWsMsg = function(msgObj) {
//         switch (msgObj.type) {
//         case "preview-svg":
//             showPreviewPdf(msgObj);
//             break;
//         case "download-pdf":
//             processDownloadButton(msgObj, "pdf");
//             break;
//         case "download-png":
//             processDownloadButton(msgObj, "png");
//             break;
//         case "download-jpeg":
//             processDownloadButton(msgObj, "jpeg");
//             break;
//         case "user-notification":
//             var text = msgObj.msg;
//             text.type && "background" == text.type ? "Finished" == text.text ? (toastInstance && (toastInstance.reset(),
//             toastInstance = null),
//             $.toast({
//                 text: "Background added",
//                 icon: "success",
//                 loader: !1,
//                 position: "top-right",
//                 hideAfter: 4e3
//             }),
//             $("#uploadBgButton").prop("disabled", !1),
//             initMasonry_element(),
//             loadTemplates_element()) : updateToastMsg({
//                 text: text.text,
//                 icon: "info",
//                 loader: !1,
//                 position: "top-right",
//                 hideAfter: !1
//             }) : text.type && "element" == text.type && "Finished" == text.text ? (toastInstance && (toastInstance.reset(),
//             toastInstance = null),
//             $.toast({
//                 text: "Elements added",
//                 icon: "success",
//                 loader: !1,
//                 position: "top-right",
//                 hideAfter: 4e3
//             }),
//             $("#uploadButton").prop("disabled", !1),
//             $("#uploadCancelButton").click(),
//             initMasonry_element(),
//             loadTemplates_element()) : -1 != text.text.indexOf("Finished") ? (toastInstance && (toastInstance.reset(),
//             toastInstance = null),
//             $.toast({
//                 text: text.text,
//                 icon: "warning",
//                 loader: !1,
//                 position: "top-right",
//                 hideAfter: 4e3
//             }),
//             $("#uploadButton").prop("disabled", !1),
//             $("#uploadCancelButton").click(),
//             initMasonry_element(),
//             loadTemplates_element()) : updateToastMsg({
//                 text: text.text,
//                 icon: "info",
//                 loader: !1,
//                 position: "top-right",
//                 hideAfter: !1
//             })
//         }
//     }
// }
// wsConection();
var toastInstance = null
  , updateToastMsg = function(objectParameters) {
    null == toastInstance ? (objectParameters.afterHidden = function() {
        toastInstance = null
    }
    ,
    objectParameters.beforeShow = function() {
        var tag = $(".jq-toast-single.jq-has-icon.jq-icon-info").first();
        $(tag).removeClass("jq-icon-info"),
        $(tag).addClass("toast-loader-icon")
    }
    ,
    toastInstance = $.toast(objectParameters)) : toastInstance.update(objectParameters)
}
  , referenceUpdates = 0
  , pullingType = "pdf"
  , pullingCount = 0
  , pullingRequestId = ""
  , checkDocsUpdates = function(requestId) {
    referenceUpdates = setTimeout(function() {
        var urlUpdate = appUrl + "admin/Documents/get-user-docs-updates/" + requestId + "/" + docUserId;
        $.ajax({
            url: urlUpdate,
            method: "GET",
            dataType: "json",
            timeout: 9e4
        }).done(function(data) {
            if (data.response) {
                if ("svg" == data.type && "svg" == pullingType)
                    return void showPreviewPdf(data.data);
                if ("pdf" == data.type && "pdf" == pullingType)
                    return void processDownloadButton(data.data, "pdf");
                if ("jpeg" == data.type && "jpeg" == pullingType)
                    return void processDownloadButton(data.data, "jpeg");
                if ("png" == data.type && "png" == pullingType)
                    return void processDownloadButton(data.data, "png")
            } else
                $.toast({
                    heading: getMessageErroByType(pullingType),
                    text: "Please try again later.",
                    icon: "error",
                    position: "top-right",
                    hideAfter: 4e3
                })
        })
    }, 2e3),
    pullingRequestId != requestId ? (pullingCount = 1,
    pullingRequestId = requestId) : ++pullingCount > 2 && (clearTimeout(referenceUpdates),
    $.toast({
        heading: getMessageErroByType(pullingType),
        text: "Please try again later.",
        icon: "error",
        position: "top-right",
        hideAfter: 4e3
    }))
}
  , timerPdfValue = 120
  , timerPdfRef = 0
  , downloadPdfTimer = function downloadPdfTimer() {
    var initValue = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : void 0;
    initValue && (timerPdfValue = initValue),
    timerPdfRef = setTimeout(function() {
        --timerPdfValue > 0 ? downloadPdfTimer() : (clearTimeout(timerPdfRef),
        $.toast({
            heading: getMessageErroByType(pullingType),
            text: "Please try again later.",
            icon: "error",
            position: "top-right",
            hideAfter: !1,
            stack: 1
        }))
    }, 1e3)
}
  , getMessageErroByType = function(pullingType) {
    var errorMsg = "";
    switch (pullingType) {
    case "svg":
        errorMsg = "Error creating Preview";
        break;
    case "pdf":
        errorMsg = "Error creating PDF";
        break;
    case "jpeg":
        errorMsg = "Error creating JPG";
        break;
    case "png":
        errorMsg = "Error creating PNG"
    }
    return errorMsg
}
  , infinites = []
  , masonrys = []
  , flag_scroll_templates_element = !1
  , limit_element = 24
  , aContainer_element = "#catimage_container"
  , aSearch_element = "#elementssearch"
  , aMethod_element = "get-elements"
  , type_element = "element";
function initMasonry_element() {
    null != $(aContainer_element).data("infiniteScroll") && ($(aContainer_element).html(""),
    $(aContainer_element).infiniteScroll().infiniteScroll("destroy"),
    $(aContainer_element).masonry().masonry("destroy")),
    infinites[type_element] = $(aContainer_element).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: !0,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    }),
    masonrys[type_element] = infinites[type_element].data("masonry"),
    infinites[type_element].infiniteScroll({
        path: function() {
            var tags = $(aSearch_element).val() ? $(aSearch_element).val().toString() : "";
            return appUrl + "design/app/" + aMethod_element + "/" + this.loadCount + "/" + limit_element + "/" + tags + "/" + design_as_id
        },
        responseType: "text",
        outlayer: masonrys[type_element],
        history: !1,
        scrollThreshold: !1
    }),
    loadReadMore(aContainer_element, "loadTemplates_element"),
    $(aContainer_element).next().find(".iscroll-button").show()
}
function getItemHTML_element(item) {
    var img = item.img
      , thumb = item.thumb;
    return '<div class="col-xs-4 thumb ' + item.isownitem + '" id="' + item.id + '"><a class="thumbnail" href="#"><img crossorigin="' + item.crossorigin + '" class="catImage img-responsive" data-imgsrc="' + img + '" src="' + thumb + '" alt=""></a>' + ("designer" != currentUserRole ? '<i class="fa fa-trash-o deleteElement" id="' + item.id + '"></i>' : "") + "</div>"
}
function loadTemplates_element() {
    infinites[type_element].infiniteScroll("loadNextPage"),
    setTimeout(function() {
        masonrys[type_element].layout(),
        $(".infinite-scroll-request_catimage").hide()
    }, 200),
    setTimeout(function() {
        $(aContainer_element).next().find(".loader-ellips").hide()
    }, 1500)
}

// $(aContainer_element).on("load.infiniteScroll", function() {
//     var _ref = _asyncToGenerator(regeneratorRuntime.mark(function _callee(event, response) {
//         var data, itemsHTML, items;
//         return regeneratorRuntime.wrap(function(_context) {
//             for (; ; )
//                 switch (_context.prev = _context.next) {
//                 case 0:
//                     data = (data = JSON.parse(response)).data,
//                     itemsHTML = data.map(getItemHTML_element).join(""),
//                     (items = $(itemsHTML)).imagesLoaded(function() {
//                         infinites[type_element].infiniteScroll("appendItems", items).masonry("appended", items)
//                     }),
//                     0 != data.length && setTimeout(function() {
//                         flag_scroll_templates_element = !1,
//                         $(aContainer_element).next().find(".iscroll-last").hide()
//                     }, 500),
//                     data.length < limit_element && ($(aContainer_element).next().find(".loader-ellips").hide(),
//                     $(aContainer_element).next().find(".iscroll-button").hide(),
//                     $(aContainer_element).next().find(".iscroll-last").show());
//                 case 7:
//                 case "end":
//                     return _context.stop()
//                 }
//         }, _callee)
//     }));
//     return function(_x, _x2) {
//         return _ref.apply(this, arguments)
//     }
// }());

var flag_scroll_templates_bg = !1
  , limit_bg = 24
  , aContainer_bg = "#background_container"
  , aSearch_bg = "#bgsearch"
  , aMethod_bg = "get-backgrounds"
  , type_bg = "bg";
function initMasonry_bg() {
    null != $(aContainer_bg).data("infiniteScroll") && ($(aContainer_bg).html(""),
    $(aContainer_bg).infiniteScroll().infiniteScroll("destroy"),
    $(aContainer_bg).masonry().masonry("destroy")),
    infinites[type_bg] = $(aContainer_bg).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: !0,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    }),
    masonrys[type_bg] = infinites[type_bg].data("masonry"),
    infinites[type_bg].infiniteScroll({
        path: function() {
            var tags = $(aSearch_bg).val() ? $(aSearch_bg).val().toString() : "";
            return appUrl + "editor/" + aMethod_bg + "?loadCount=" + this.loadCount + "&limit_bg=" + limit_bg + "&tags=" + tags + "&design_as_id=" + design_as_id + "&demo_as_id=" + demo_as_id + "&loadedtemplateid=" + loadedtemplateid
        },
        responseType: "text",
        outlayer: masonrys[type_bg],
        history: !1,
        scrollThreshold: !1
    }),
    loadReadMore(aContainer_bg, "loadTemplates_bg"),
    $(aContainer_bg).next().find(".iscroll-button").show()
}
function getItemHTML_bg(item) {
    demo_as_id;
    return "superadmin" == currentUserRole || "administrator" == currentUserRole ? '<div class="col-xs-4 thumb ' + item.is_own_item + '" id="' + item.id + '"><a class="thumbnail bgImage" href="#" data-imgsrc="' + item.url + '"><img class="img-responsive" src="' + item.thumb + '" alt=""><span class="thumb-overlay"><h3>' + item.name + '</h3></span></a> <i class="fa fa-trash-o deleteBg" id="' + item.id + '"></i></div>' : '<div class="col-xs-4 thumb ' + item.is_own_item + '" id="' + item.id + '"><a class="thumbnail bgImage" href="#" data-imgsrc="' + item.url + '"><img class="img-responsive" src="' + item.thumb + '" alt=""><span class="thumb-overlay"><h3>' + item.name + "</h3></span></a></div>"
}
function loadTemplates_bg() {
    infinites[type_bg].infiniteScroll("loadNextPage"),
    setTimeout(function() {
        masonrys[type_bg].layout(),
        $(".infinite-scroll-request_background").hide()
    }, 200),
    setTimeout(function() {
        $(aContainer_bg).next().find(".loader-ellips").hide()
    }, 1500)
}
$(aContainer_bg).on("load.infiniteScroll", function(event, response) {
    var data = JSON.parse(response)
      , itemsHTML = (data = data.data).map(getItemHTML_bg).join("")
      , $items = $(itemsHTML);
    $items.imagesLoaded(function() {
        infinites[type_bg].infiniteScroll("appendItems", $items).masonry("appended", $items)
    }),
    0 != data.length && setTimeout(function() {
        flag_scroll_templates_bg = !1,
        $(aContainer_bg).next().find(".iscroll-last").hide()
    }, 500),
    data.length < limit_bg && ($(aContainer_bg).next().find(".loader-ellips").hide(),
    $(aContainer_bg).next().find(".iscroll-button").hide(),
    $(aContainer_bg).next().find(".iscroll-last").show());
});
var flag_scroll_templates_text = !1
  , limit_text = 24
  , aContainer_text = "#text_container"
  , aSearch_text = "#textsearch"
  , aMethod_text = "get-texts"
  , type_text = "text";
function initMasonry_text() {
    null != $(aContainer_text).data("infiniteScroll") && ($(aContainer_text).html(""),
    $(aContainer_text).infiniteScroll().infiniteScroll("destroy"),
    $(aContainer_text).masonry().masonry("destroy")),
    infinites[type_text] = $(aContainer_text).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: !0,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    }),
    masonrys[type_text] = infinites[type_text].data("masonry"),
    infinites[type_text].infiniteScroll({
        path: function() {
            var tags = $(aSearch_text).val() ? $(aSearch_text).val().toString() : "";
            return appUrl + "design/app/" + aMethod_text + "/" + this.loadCount + "/" + limit_text + "/" + tags + "/" + design_as_id
        },
        responseType: "text",
        outlayer: masonrys[type_text],
        history: !1,
        scrollThreshold: !1
    }),
    loadReadMore(aContainer_text, "loadTemplates_text"),
    $(aContainer_text).next().find(".iscroll-button").show()
}
function getItemHTML_text(item) {
    return '<div class="col-xs-6 thumb ' + item.isownitem + '" id="' + item.text_id + '"><a class="thumbnail" title="' + item.text_name + '" href="#" data-target="' + item.text_id + '"><img class="textImage img-responsive" src="' + item.text_thumbnail + '" alt=""></a><i class="fa fa-trash-o deleteText" id="' + item.text_id + '"></i></div>'
}
function loadTemplates_text() {
    infinites[type_text].infiniteScroll("loadNextPage"),
    setTimeout(function() {
        masonrys[type_text].layout(),
        $(".infinite-scroll-request_text").hide()
    }, 200),
    setTimeout(function() {
        $(aContainer_text).next().find(".loader-ellips").hide()
    }, 1500)
}
$(aContainer_text).on("load.infiniteScroll", function(event, response) {
    var data = JSON.parse(response)
      , itemsHTML = (data = data.data).map(getItemHTML_text).join("")
      , $items = $(itemsHTML);
    $items.imagesLoaded(function() {
        infinites[type_text].infiniteScroll("appendItems", $items).masonry("appended", $items)
    }),
    0 != data.length && setTimeout(function() {
        flag_scroll_templates_text = !1,
        $(aContainer_text).next().find(".iscroll-last").hide()
    }, 500),
    data.length < limit_text && ($(aContainer_text).next().find(".loader-ellips").hide(),
    $(aContainer_text).next().find(".iscroll-button").hide(),
    $(aContainer_text).next().find(".iscroll-last").show())
});
var flag_scroll_templates_template = !1
  , limit_template = 20
  , aContainer_template = "#template_container"
  , aSearch_template = "#templatesearch"
  , aMethod_template = "get-thumbnails"
  , type_template = "template";
function initMasonry_template() {
    null != $(aContainer_template).data("infiniteScroll") && ($(aContainer_template).html(""),
    $(aContainer_template).infiniteScroll().infiniteScroll("destroy"),
    $(aContainer_template).masonry().masonry("destroy")),
    infinites[type_template] = $(aContainer_template).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: !0,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    }),
    masonrys[type_template] = infinites[type_template].data("masonry"),
    infinites[type_template].infiniteScroll({
        path: function() {
            var tags = $(aSearch_template).val() ? $(aSearch_template).val().toString() : "";
            return appUrl + "editor/" + aMethod_template + "/?load_count=" + this.loadCount + "&limit_template=" + limit_template + "&tags=" + tags + "&design_as_id=" + design_as_id + "&demo_as_id=" + demo_as_id + "&demo_templates=" + demo_templates + "&id=" + demo_templates + "&language_code=" + language_code + "&customerId=" + customerId
        },
        responseType: "text",
        outlayer: masonrys[type_template],
        history: !1,
        scrollThreshold: !1
    }),
    loadReadMore(aContainer_template, "loadTemplates_template"),
    $(aContainer_template).next().find(".iscroll-button").show(),
    $('#template-status').val("Thumbs Loaded")
}
function getItemHTML_template($row) {
    return $templates = '<div class="col-xs-6 thumb" id="' + $row.template_id + '">',
    $row.instructionsId && ($templates += '<a class="instructions-overlay" onclick="loadInstructions(' + $row.template_id + ')" data-toggle="modal" data-target="#sellerInstructions"><h3>Seller Instructions</h3></a>'),
    $templates += '<a class="thumbnail" data-target="' + $row.template_id + '">',
    $templates += '<span class="thumb-overlay"><h3>' + $row.template_name + "</h3></span>",
    $templates += '<div class="expired-notice" style="display:none;">EXPIRED</div>',
    $templates += '<img class="tempImage img-responsive" src="' + $row.temp_source + '" alt="" style="">',
    $templates += "</a>",
    $templates += '<div class="badge-container">',
    $templates += '<span class="badge dims">' + $row.width + " x " + $row.height + " " + $row.metrics + "</span>",
    $templates += '<span class="badge tempId">ID: ' + $row.template_id + "</span>",
    "designer" != currentUserRole && ($templates += '<i class="fa fa-trash-o deleteTemp" id="' + $row.template_id + '"></i>'),
    $templates += "</div>",
    $templates += "</div>",
    $templates
}
function loadTemplates_template() {
    infinites[type_template].infiniteScroll("loadNextPage"),
    setTimeout(function() {
        masonrys[type_template].layout()
    }, 200),
    setTimeout(function() {
        $(aContainer_template).next().find(".loader-ellips").hide()
    }, 1500)
}
$(aContainer_template).on("load.infiniteScroll", function(event, response) {
    var data = JSON.parse(response)
      , itemsHTML = (data = data.data).map(getItemHTML_template).join("")
      , $items = $(itemsHTML);
    $items.imagesLoaded(function() {
        infinites[type_template].infiniteScroll("appendItems", $items).masonry("appended", $items)
    }),
    0 != data.length && setTimeout(function() {
        flag_scroll_templates_template = !1,
        $(aContainer_template).next().find(".iscroll-last").hide()
    }, 500),
    data.length < limit_template && ($(aContainer_template).next().find(".loader-ellips").hide(),
    $(aContainer_template).next().find(".iscroll-button").hide(),
    $(aContainer_template).next().find(".iscroll-last").show())
});
var flag_scroll_templates_related = !1, limit_related = 24, aContainer_related = "#related_products_container", aSearch_related = "", aMethod_related = "get-related-products", type_related = "related", templateId_related;
function initMasonry_related(templateId) {
    templateId_related = templateId,
    null != $(aContainer_related).data("infiniteScroll") && ($(aContainer_related).html(""),
    $(aContainer_related).infiniteScroll().infiniteScroll("destroy"),
    $(aContainer_related).masonry().masonry("destroy")),
    infinites[type_related] = $(aContainer_related).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: !0,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    }),
    masonrys[type_related] = infinites[type_related].data("masonry"),
    infinites[type_related].infiniteScroll({
        path: function() {
            return appUrl + "editor/" + aMethod_related + "/" + templateId_related + "?demo_as_id=" + demo_as_id + "&loadCount=" + this.loadCount + "&limit_related=" + limit_related
        },
        responseType: "text",
        outlayer: masonrys[type_related],
        history: !1,
        scrollThreshold: !1
    }),
    loadReadMore(aContainer_related, "loadTemplates_related"),
    $(aContainer_related).next().find(".iscroll-button").show()
}
function getItemHTML_related(product) {
    var newElement = $("<div/>");
    $(newElement).addClass("grid-item"),
    $(newElement).css("width", 140),
    $(newElement).css("float", "left"),
    $(newElement).css("margin", "0 0 10px 10px");
    var productLink = $("<a/>");
    $(productLink).attr("href", product.url),
    $(productLink).attr("target", "_blank");
    var productImage = $("<img/>");
    return $(productImage).attr("src", product.image),
    $(productImage).css("width", "100%"),
    $(productLink).append(productImage),
    $(newElement).append(productLink),
    $("<div/>").append(newElement).html()
}
function loadTemplates_related() {
    infinites[type_related].infiniteScroll("loadNextPage"),
    setTimeout(function() {
        masonrys[type_related] && (masonrys[type_related].layout(),
        $(".infinite-scroll-request_related_products").show())
    }, 500),
    setTimeout(function() {
        $(aContainer_related).next().find(".loader-ellips").hide()
    }, 1500)
}
$(aContainer_related).on("load.infiniteScroll", function(event, response) {
    var data = JSON.parse(response);
    if (data.total > 0) {
        $("#relatedProductsPane a:hidden").removeClass("invisible");
        var itemsHTML = (data = data.products).map(getItemHTML_related).join("")
          , $items = $(itemsHTML);
        $items.imagesLoaded(function() {
            infinites[type_related].infiniteScroll("appendItems", $items).masonry("appended", $items)
        }),
        0 != data.length && setTimeout(function() {
            flag_scroll_relateds_related = !1,
            $(aContainer_related).next().find(".iscroll-last").hide()
        }, 500),
        data.length < limit_related && ($(aContainer_related).next().find(".loader-ellips").hide(),
        $(aContainer_related).next().find(".iscroll-button").hide(),
        $(aContainer_related).next().find(".iscroll-last").show())
    } else
        $("#relatedProductsPane a:visible").addClass("invisible")
});
var flag_scroll_templates_image = !1, limit_image = 24, aContainer_image = ".uploaded_images_list", aSearch_image = "", aMethod_image = "get-uploaded-images", type_image = "image", templateId_image;
function initMasonry_image(templateId) {
    templateId_image = templateId,
    null != $(aContainer_image).data("infiniteScroll") && ($(aContainer_image).html(""),
    $(aContainer_image).infiniteScroll().infiniteScroll("destroy"),
    $(aContainer_image).masonry().masonry("destroy")),
    infinites[type_image] = $(aContainer_image).masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: !0,
        stagger: 30,
        visibleStyle: {
            transform: "translateY(0)",
            opacity: 1
        },
        hiddenStyle: {
            transform: "translateY(100px)",
            opacity: 0
        }
    }),
    masonrys[type_image] = infinites[type_image].data("masonry"),
    infinites[type_image].infiniteScroll({
        path: function() {
            return appUrl + "editor/" + aMethod_image + "/" + limit_image + "/" + this.loadCount
        },
        responseType: "text",
        outlayer: masonrys[type_image],
        history: !1,
        scrollThreshold: !1
    }),
    loadReadMore(aContainer_image, "loadTemplates_image"),
    $(aContainer_image).next().find(".iscroll-button").show()
}
function getItemHTML_image(product) {
    var deleteBtn = demo_as_id ? "" : '<i data-target="' + product.id + '" class="fa fa-trash-o deleteImage"></i>';
    return '<div data-id="' + product.id + '" class="dz-preview dz-processing dz-image-preview dz-success dz-complete thumb"><div class="dz-image"><img data-dz-thumbnail="" alt="' + product.filename + '" src="' + product.img + '"></div> \x3c!-- <div class="dz-details"> <div class="dz-filename"><span data-dz-name="">' + product.filename + "</span></div>  </div> --\x3e" + deleteBtn + "</div>"
}
function loadTemplates_image() {
    infinites[type_image].infiniteScroll("loadNextPage"),
    setTimeout(function() {
        masonrys[type_image] && (masonrys[type_image].layout(),
        $(".infinite-scroll-request_image_products").show())
    }, 500),
    setTimeout(function() {
        $(aContainer_image).next().find(".loader-ellips").hide()
    }, 1500)
}
function loadReadMore(container, loadFunctionName) {
    "page-load" == $(container).next().attr("class") && $(container).next().remove();
    var html_load = '<div class="page-load">';
    html_load += '<div class="loader-ellips"><img class="loading-spin" src="' + appUrl + 'design/assets/img/loader.svg"></div>',
    html_load += '<p class="iscroll-last">End of Results</p>',
    html_load += "</div>",
    $(container).after(html_load)
}
function initCanvasEvents(lcanvas) {
    var selectedObject;
    lcanvas && (canvas = lcanvas);
    var localStorageKey = "templett.design";
    function objectSelected(e, $action) {
        if (s_history = !1,
        (selectedObject = e.target ? e.target : canvas.getActiveObject()) && ("created" !== $action || "activeSelection" === selectedObject.type)) {
            for (var i = 0; i <= canvasindex; i++)
                $("#canvas" + i).css("box-shadow", "");
            if ("geofilter" !== template_type && "geofilter2" !== template_type && $("#canvas" + currentcanvasid).css("box-shadow", "0px 0px 10px #888888"),
            e.target.hidden ? $("#hideobject").html("<i class='fa fa-eye'></i>&nbsp; Unhide object in pdf/png") : $("#hideobject").html("<i class='fa fa-eye'></i>&nbsp; Hide object in pdf/png"),
            $(".tools-top").addClass("toolbar-show"),
            console.log("Show Toolbar"),
            !e.target || "false" !== e.target.selectable) {
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
                if ($toolbar_top.find("#shadowGroup").show(),
                $toolbar_top.find("#deleteitem").show(),
                $toolbar_top.find("#showmoreoptions").show(),
                $toolbar_top.find("#clone").show(),
                $toolbar_top.find(".bringforward").show(),
                $toolbar_top.find(".sendbackward").show(),
                $toolbar_top.find("#showObjectProperties").hide(),
                $toolbar_top.find("#showColors").hide().removeClass("expanded"),
                $(".patternFillTab").hide(),
                $("#group").hide(),
                $("#ungroup").hide(),
                $("#strokegroup").hide(),
                $("#alignbtns").hide(),
                $("#alignbtns a").removeClass("active"),
                selectedObject.selectionBackgroundColor = "rgba(255,255,255,0.25)",
                setControlsVisibility(selectedObject),
                selectedObject.locked && !0 === selectedObject.locked || (selectedObject.lockMovementY ? (selectedObject.hasControls = !1,
                selectedObject.set({
                    borderColor: "#ff0000"
                })) : (selectedObject.hasControls = !0,
                selectedObject.set({
                    borderColor: "#4dd7fa"
                })),
                "activeSelection" === selectedObject.type || "group" === selectedObject.type ? ($("#addremovestroke").hide(),
                selectedObject.set({
                    transparentCorners: !1,
                    borderColor: "#f9a24c",
                    cornerColor: "#f9a24c",
                    cornerSize: 8,
                    minScaleLimit: 0,
                    padding: 5,
                    borderDashArray: [4, 2]
                })) : $("#addremovestroke").show()),
                "image" === selectedObject.type && $toolbar_top.find("#showObjectProperties").show(),
                "textbox" === selectedObject.type || "text" === selectedObject.type || "i-text" === selectedObject.type || isTextsGroup()) {
                    var fontFamily, fontSize;
                    if ($(".textelebtns").show(),
                    "bold" === selectedObject.fontWeight ? $("#fontbold").addClass("active") : $("#fontbold").removeClass("active"),
                    "italic" === selectedObject.fontStyle ? $("#fontitalic").addClass("active") : $("#fontitalic").removeClass("active"),
                    "underline" === selectedObject.underline ? $("#fontunderline").addClass("active") : $("#fontunderline").removeClass("active"),
                    $("#alignbtns").show(),
                    "left" === selectedObject.textAlign ? $("#objectalignleft").addClass("active") : $("#objectalignleft").removeClass("active"),
                    "center" === selectedObject.textAlign ? $("#objectaligncenter").addClass("active") : $("#objectaligncenter").removeClass("active"),
                    "right" === selectedObject.textAlign ? $("#objectalignright").addClass("active") : $("#objectalignright").removeClass("active"),
                    "i-text" === selectedObject.type && (multiline = selectedObject._textLines.length,
                    multiline > 1 ? $("#lineheight").show() : 1 === multiline && $("#lineheight").hide()),
                    $("#objectflipvertical").hide(),
                    $("#objectfliphorizontal").hide(),
                    $("#objectalignleft").html("<i class='fa fa-align-left'></i>"),
                    $("#objectaligncenter").html("<i class='fa fa-align-center'></i>"),
                    $("#objectalignright").html("<i class='fa fa-align-right'></i>"),
                    selectedObject.selectionColor = "rgba(0, 123, 240, 0.3)",
                    selectedObject.editingBorderColor = "#4dd7fa",
                    isTextsGroup()) {
                        $("#showObSymbolsPanel").hide(),
                        $("#textstylebtns").hide(),
                        $("#font-symbols").dialog("close");
                        var fonts = []
                          , sizes = [];
                        selectedObject.forEachObject(function(object) {
                            fonts.push(object.fontFamily),
                            sizes.push(object.fontSize / 1.3)
                        }),
                        fonts = _toConsumableArray(new Set(fonts)),
                        sizes = _toConsumableArray(new Set(sizes)),
                        fontFamily = 1 === fonts.length ? fonts[0] : "",
                        fontSize = 1 === sizes.length ? sizes[0].toFixed(0) : "-"
                    } else
                        $("#showObSymbolsPanel").show(),
                        fontFamily = selectedObject.fontFamily || "font7",
                        fontSize = "textbox" === selectedObject.type ? (selectedObject.fontSize * selectedObject.scaleX / 1.3).toFixed(0) : Math.round(selectedObject.fontSize / 1.3) || 36;
                    var fontDisplayName = $("#fonts-dropdown").find('a[data-ff="' + fontFamily + '"]').parent().find("span").text();
                    fontDisplayName || (fontDisplayName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"),
                    $("#font-selected").html('<span style="overflow:hidden"><a href="#" style="font-family: ' + fontFamily + '" >' + fontDisplayName + '</a>&nbsp;&nbsp;<span class="caret"></span></span>'),
                    $("#fontsize").val(fontSize),
                    setupSymbolsPanel(fontFamily),
                    $("#font-dropdown").on("shown.bs.dropdown", function() {
                        $("#fontSearch").focus(),
                        $("#fonts-dropdown").scrollTop($('#fonts-dropdown li a[data-ff="' + fontFamily + '"]').position().top - $("#fonts-dropdown li:first").position().top),
                        $("#fonts-dropdown li a").removeClass("font-selected"),
                        $('#fonts-dropdown li a[data-ff="' + fontFamily + '"]').addClass("font-selected")
                    })
                } else
                    $(".textelebtns").hide(),
                    $("#objectflipvertical").show(),
                    $("#objectfliphorizontal").show(),
                    $("#objectalignleft").html("<span class='glyphicon glyphicon-object-align-left'></span>"),
                    $("#objectaligncenter").html("<span class='glyphicon glyphicon-object-align-vertical'></span>"),
                    $("#objectalignright").html("<span class='glyphicon glyphicon-object-align-right'></span>");
                "activeSelection" === selectedObject.type && selectedObject._objects && ($("#group").show(),
                $("#alignbtns").show()),
                "group" === selectedObject.type && ($("#ungroup").show(),
                $("#strokegroup").show()),
                selectedObject.get("stroke") ? ($("#colorStrokeSelector").css("backgroundColor", selectedObject.stroke),
                $("#strokegroup").show()) : $("#strokegroup").hide();
                var ar = [37, 38, 39, 40];
                $(document).keydown(function(e) {
                    var key = e.which;
                    return !($.inArray(key, ar) > -1) || (e.preventDefault(),
                    !1)
                }),
                $("#dynamiccolorpickers").html("");
                var $gradientType = getGradientTypeofObject(selectedObject);
                if (!1 !== $gradientType) {
                    DEBUG && console.log("getGradientTypeofObject: ", $gradientType);
                    var $color1 = selectedObject.fill.colorStops[0].color
                      , $color2 = selectedObject.fill.colorStops[1].color;
                    switchFillType($gradientType, $color1, $color2)
                } else
                    "string" == typeof selectedObject.fill && switchFillType("color-fill", selectedObject.fill),
                    selectedObject.fill instanceof fabric.Dpattern && ($(".patternFillGroup").show(),
                    $(".patternFillGroup").find(".patternFillPreview").attr("data-currentsrc", selectedObject.fill.src).css("background-image", "url(" + selectedObject.fill.toDataURL({
                        width: selectedObject.fill.width * selectedObject.fill.scale,
                        height: selectedObject.fill.height * selectedObject.fill.scale,
                        mulitplier: fabric.devicePixelRatio,
                        quality: .6
                    }) + ")"),
                    $(".colorSelectorBox.single").find("#colorSelector,#colorSelector2").hide(),
                    $(".colorSelectorBox.single").find(".dropdown-menu.fill-type-dropdown").find(".fill-type").removeClass("active").parent().find(".fill-type.pattern-fill").addClass("active"));
                var $validTagsRegExp = /^(path|circle|polygon|polyline|ellipse|rect|line)\b/i;
                if ("activeSelection" === selectedObject.type || "group" === selectedObject.type || isElement(selectedObject)) {
                    var colorarray = []
                      , allObjects = []
                      , groupObjects = [];
                    void 0 === selectedObject.svg_custom_paths && (selectedObject.svg_custom_paths = []),
                    selectedObject._objects && (groupObjects = selectedObject._objects),
                    selectedObject._objects || groupObjects.push(selectedObject);
                    for (i = 0; i < groupObjects.length; i++)
                        if (DEBUG && console.log("selectedObject groupObjects[i]", groupObjects[i], groupObjects[i].type),
                        "group" === groupObjects[i].type)
                            for (var objects = groupObjects[i].getObjects(), n = 0; n < objects.length; n++) {
                                if ("group" === objects[n].type)
                                    objects[n].forEachObject(function($child, $i) {
                                        var colorString = $child.fill;
                                        if (void 0 !== colorString) {
                                            var $o = {};
                                            $o[n] = $i,
                                            $child.group_index = $o,
                                            allObjects.push($child),
                                            "string" == typeof colorString && colorString && ($child.fill = "#" + new fabric.Color(colorString).toHex()),
                                            isImagesGroup(objects[n]) || colorarray.push($child.fill)
                                        }
                                    });
                                else
                                    void 0 !== (colorString = objects[n].fill) && (objects[n].group_index = n,
                                    allObjects.push(objects[n]),
                                    "string" == typeof colorString && colorString && (objects[n].fill = "#" + new fabric.Color(colorString).toHex()),
                                    colorarray.push(objects[n].fill))
                            }
                        else if ("textbox" === groupObjects[i].type || "text" === groupObjects[i].type || "i-text" === groupObjects[i].type || isTextsGroup()) {
                            var colorString;
                            void 0 !== (colorString = groupObjects[i].fill) && ("string" == typeof colorString ? (groupObjects[i].fill = "#" + new fabric.Color(colorString).toHex(),
                            allObjects.push(groupObjects[i])) : allObjects.push(groupObjects[i]),
                            colorarray.push(groupObjects[i].fill))
                        } else
                            $validTagsRegExp.test(groupObjects[i].type) && (DEBUG && console.log("groupObjects[i].fill: ", groupObjects[i].fill),
                            void 0 !== groupObjects[i].fill && (colorarray.push(groupObjects[i].fill),
                            allObjects.push(groupObjects[i])));
                    $validTagsRegExp.test(selectedObject.type) && (colorarray.push(selectedObject.fill),
                    allObjects.push(selectedObject));
                    var flags = []
                      , output = []
                      , l = (colorarray = colorarray.filter(onlyUnique)).length;
                    for (i = 0; i < l; i++)
                        if (DEBUG && console.log("colorarray[" + i + "]", colorarray[i]),
                        "object" === _typeof(colorarray[i]) && colorarray[i].colorStops) {
                            if (flags[colorarray[i].colorStops[0].color + colorarray[i].colorStops[1].color])
                                continue;
                            flags[colorarray[i].colorStops[0].color + colorarray[i].colorStops[1].color] = !0,
                            output.push(colorarray[i])
                        } else
                            output.push(colorarray[i]);
                    colorarray = output,
                    DEBUG && console.log("output", output),
                    colorarray.length && $(".colorSelectorBox.single").hide(),
                    $(".colorSelectorBox.single").find("#colorSelector2").hide();
                    var colorpickerhtml = "";
                    for (i = 0; i < colorarray.length; i++) {
                        if ("string" == typeof colorarray[i]) {
                            var $color = colorarray[i];
                            "Black" === $color && ($color = "#000000"),
                            colorpickerhtml += '<div class="btn-group colorSelectorBox group" data-gradient-type="color-fill">',
                            colorpickerhtml += '<input type="text" class="btn btn-default dynamiccolorpicker" title="Color Picker" value="' + $color + '" />',
                            colorpickerhtml += '<button type="button" class="filltype btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>',
                            colorpickerhtml += "</div>"
                        }
                        if ("object" === _typeof(colorarray[i])) {
                            if (colorarray[i]instanceof fabric.Gradient) {
                                var $gradientDirection;
                                $color1 = "#" + new fabric.Color(colorarray[i].colorStops[0].color).toHex(),
                                $color2 = "#" + new fabric.Color(colorarray[i].colorStops[1].color).toHex();
                                0 !== colorarray[i].coords.y2 && ($gradientDirection = "linear-gradient-v-fill"),
                                0 !== colorarray[i].coords.x2 && ($gradientDirection = "linear-gradient-h-fill"),
                                0 !== colorarray[i].coords.x2 && 0 !== colorarray[i].coords.x2 && ($gradientDirection = "linear-gradient-d-fill"),
                                void 0 === colorarray[i].coords.r1 && void 0 === colorarray[i].coords.r2 || ($gradientDirection = "radial-gradient-fill"),
                                $color1 && (colorpickerhtml += '<div class="btn-group colorSelectorBox group" data-gradient-type="' + $gradientDirection + '">',
                                colorpickerhtml += '<input type="text" class="btn btn-default dynamiccolorpicker" title="Color Picker" value="' + $color1 + '" />',
                                colorpickerhtml += '<input type="text" class="btn btn-default dynamiccolorpicker2 showElement" title="Color Picker" value="' + $color2 + '"/>',
                                colorpickerhtml += '<button type="button" class="filltype btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>',
                                colorpickerhtml += "</div>")
                            }
                            if (colorarray[i]instanceof fabric.Dpattern) {
                                var $template = $(".patternFillLabel").first().clone()
                                  , $dropdown = $(".colorSelectorBox.single").find(".dropdown-menu.fill-type-dropdown").clone();
                                $dropdown.find(".fill-type").removeClass("active").parent().find(".fill-type.pattern-fill").addClass("active"),
                                $template.find(".patternFillPreview").attr("data-currentsrc", colorarray[i].src).css("background-image", "url(" + colorarray[i].toDataURL({
                                    mulitplier: fabric.devicePixelRatio,
                                    width: colorarray[i].width * colorarray[i].scale,
                                    height: colorarray[i].height * colorarray[i].scale,
                                    quality: .6
                                }) + ")"),
                                colorpickerhtml += '<div class="dpattern-holder btn btn-default">',
                                colorpickerhtml += '<div class="wrapper">',
                                colorpickerhtml += $template.get(0).outerHTML,
                                colorpickerhtml += "</div>",
                                colorpickerhtml += '<div class="wrapper">',
                                colorpickerhtml += '<button type="button" class="filltype btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>',
                                colorpickerhtml += $dropdown.get(0).outerHTML,
                                colorpickerhtml += "</div>",
                                colorpickerhtml += "</div>"
                            }
                        }
                    }
                    DEBUG && console.log("selectedObject allObjects: ", allObjects),
                    $("#dynamiccolorpickers").html(colorpickerhtml);
                    var objinitcolor = "";
                    if ($(".dynamiccolorpicker").spectrum({
                        containerClassName: "dynamic-fill",
                        showAlpha: !1,
                        showPalette: !0,
                        preferredFormat: "hex",
                        hideAfterPaletteSelect: !0,
                        showSelectionPalette: !0,
                        localStorageKey: localStorageKey,
                        showInput: !0,
                        showInitial: !0,
                        allowEmpty: !0,
                        showButtons: !0,
                        maxSelectionSize: 24,
                        togglePaletteMoreText: "Show advanced",
                        togglePaletteLessText: "Hide advanced",
                        change: function(color) {
                            DEBUG && console.log("color: ", color);
                            var local_store = window.localStorage[localStorageKey];
                            -1 === local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color);
                            var newcolorVal = color.toRgbString()
                              , $oldcolorval = $(this).data("previous-color")
                              , $cb = $(this).parents(".colorSelectorBox")
                              , $cpicker2 = $cb.find(".dynamiccolorpicker2")
                              , $filltype = $cb.data("gradient-type")
                              , $color2 = "";
                            $cpicker2.length && "color-fill" !== $filltype ? ($color2 = $cpicker2.spectrum("get").toRgbString().replace(/\s/g, ""),
                            newcolorVal = color.toRgbString().replace(/\s/g, "")) : $oldcolorval = "#" + new fabric.Color($oldcolorval).toHex(),
                            DEBUG && console.log(".dynamiccolorpicker: ", newcolorVal, $oldcolorval, $color1);
                            for (var i = 0; i < allObjects.length; i++) {
                                if (DEBUG && console.log(".dynamiccolorpicker i: ", i),
                                void 0 !== allObjects[i].group_index && void 0 !== allObjects[i].group.svg_custom_paths && allObjects[i].fill && objinitcolor.toLowerCase() === allObjects[i].fill.toString().toLowerCase()) {
                                    var path_data = {
                                        index: allObjects[i].group_index,
                                        action: "fill",
                                        color_value: newcolorVal
                                    };
                                    allObjects[i].group.svg_custom_paths[allObjects[i].group_index] = path_data
                                }
                                "color-fill" === $filltype ? allObjects[i].fill && $oldcolorval.toLowerCase() === tinycolor(allObjects[i].fill).toHexString() && (allObjects[i].fill = newcolorVal,
                                allObjects[i].dirty = !0,
                                switchFillType($filltype, newcolorVal, $color2, $(this)),
                                allObjects[i].group && void 0 !== allObjects[i].group.svg_custom_paths && (allObjects[i].group.svg_custom_paths[i] = {
                                    index: i,
                                    action: "fill",
                                    color_value: newcolorVal
                                })) : !allObjects[i].fill || "object" !== _typeof(allObjects[i].fill) || "linear" !== allObjects[i].fill.type && "radial" !== allObjects[i].fill.type || allObjects[i].fill.colorStops[0].color === $oldcolorval && allObjects[i].fill.colorStops[1].color === $color2 && (allObjects[i].fill.colorStops[0].color = newcolorVal,
                                allObjects[i].dirty = !0,
                                switchFillType($filltype, newcolorVal, $color2, $(this)),
                                allObjects[i].group && void 0 !== allObjects[i].group.svg_custom_paths && (allObjects[i].group.svg_custom_paths[i] = {
                                    index: i,
                                    action: "fill",
                                    color_value: allObjects[i].fill
                                }))
                            }
                            canvas.getActiveObject() && (canvas.getActiveObject().dirty = !0),
                            canvas.getActiveObject()._objects && !canvas.getActiveObject().isEmptyObject && canvas.getActiveObject().forEachObject(function(o) {
                                o.dirty = !0
                            }),
                            selectedObject.set("dirty", !0),
                            canvas.renderAll(),
                            save_history()
                        },
                        beforeShow: function(color) {
                            $(".dynamic-fill .sp-palette-toggle").addClass("btn btn-default"),
                            $(this).spectrum("set", color)
                        },
                        show: function(color) {
                            objinitcolor = color.toRgbString().replace(/\s/g, ""),
                            $(this).data("previous-color", objinitcolor)
                        }
                    }),
                    colorarray && colorarray.length > 6) {
                        for (var $previewColors = Array(), $c = 0; $c < colorarray.length; $c++) {
                            var $curColor = "#ffffff";
                            "object" === _typeof(colorarray[$c]) ? colorarray[$c]instanceof fabric.Gradient && ($curColor = "#" + new fabric.Color(colorarray[$c].colorStops[0].color).toHex()) : $curColor = colorarray[$c],
                            $curColor && $previewColors.push($curColor)
                        }
                        $previewColors.map(function($curColor, $i) {
                            return $("#showColors").find(".color-" + $i++).css("background", $curColor)
                        }),
                        $("#dynamiccolorpickers").hide(),
                        $("#showColors").show()
                    } else
                        $("#dynamiccolorpickers").show();
                    $(".colorSelectorBox.group").each(function($i, $cb) {
                        var $dropdown = $(".colorSelectorBox.single").find(".dropdown-menu.fill-type-dropdown").clone();
                        $($cb).append($dropdown);
                        var $cPicker2 = $($cb).find(".dynamiccolorpicker2");
                        if ($($cPicker2).hasClass("showElement")) {
                            $($cPicker2).spectrum({
                                containerClassName: "dynamic-fill",
                                showAlpha: !1,
                                showPalette: !0,
                                preferredFormat: "hex",
                                hideAfterPaletteSelect: !0,
                                showSelectionPalette: !0,
                                localStorageKey: localStorageKey,
                                showInput: !0,
                                showInitial: !0,
                                allowEmpty: !0,
                                showButtons: !0,
                                maxSelectionSize: 24,
                                togglePaletteMoreText: "Show advanced",
                                togglePaletteLessText: "Hide advanced",
                                change: function(color) {
                                    DEBUG && console.log("color: ", color);
                                    var local_store = window.localStorage[localStorageKey];
                                    -1 === local_store.search(color) && (window.localStorage[localStorageKey] = local_store + ";" + color);
                                    var newcolorVal = color.toRgbString().replace(/\s/g, "")
                                      , $oldcolorval = $(this).data("previous-color")
                                      , $cb = $(this).parents(".colorSelectorBox")
                                      , $color1 = $cb.find(".dynamiccolorpicker").spectrum("get").toRgbString().replace(/\s/g, "");
                                    DEBUG && console.log(".dynamiccolorpicker2: ", newcolorVal, $oldcolorval, $color1);
                                    for (var i = 0; i < allObjects.length; i++) {
                                        if (void 0 !== allObjects[i].group_index && void 0 !== allObjects[i].group.svg_custom_paths && allObjects[i].fill && objinitcolor.toLowerCase() === allObjects[i].fill.toString().toLowerCase()) {
                                            var path_data = {
                                                index: allObjects[i].group_index,
                                                action: "fill",
                                                color_value: newcolorVal
                                            };
                                            allObjects[i].group.svg_custom_paths[allObjects[i].group_index] = path_data
                                        }
                                        if (allObjects[i].fill && "object" === _typeof(allObjects[i].fill) && ("linear" === allObjects[i].fill.type || "radial" === allObjects[i].fill.type))
                                            if (allObjects[i].fill.colorStops[0].color === $color1 && allObjects[i].fill.colorStops[1].color === $oldcolorval)
                                                DEBUG && console.log("yep, our boy"),
                                                allObjects[i].fill.colorStops[1].color = newcolorVal,
                                                allObjects[i].dirty = !0,
                                                switchFillType($cb.data("gradient-type"), $color1, newcolorVal, $(this))
                                    }
                                    canvas.getActiveObject() && (canvas.getActiveObject().dirty = !0),
                                    selectedObject.set("dirty", !0),
                                    objinitcolor = newcolorVal,
                                    canvas.renderAll(),
                                    save_history()
                                },
                                beforeShow: function(color) {
                                    $(".dynamic-fill .sp-palette-toggle").addClass("btn btn-default"),
                                    $(this).spectrum("set", color)
                                },
                                show: function(color) {
                                    objinitcolor = color.toRgbString().replace(/\s/g, ""),
                                    $(this).data("previous-color", objinitcolor)
                                }
                            });
                            var $color1 = $($cb).find(".dynamiccolorpicker").spectrum("get").toHexString() || "#000000"
                              , $color2 = $($cb).find(".dynamiccolorpicker2").spectrum("get").toHexString() || "#ffffff";
                            switchFillType($($cb).data("gradient-type"), $color1, $color2, $($cb).find(".dynamiccolorpicker2"))
                        } else
                            $($cb).find(".fill-type").removeClass("active"),
                            $($cb).find("#color-fill").addClass("active")
                    })
                } else
                    $(".colorSelectorBox.single").show();
                "line" === selectedObject.type && selectedObject.setControlsVisibility({
                    bl: !1,
                    br: !1,
                    tl: !1,
                    tr: !1,
                    ml: !1,
                    mr: !1
                }),
                "line" !== selectedObject.type && "image" !== selectedObject.type || $(".colorSelectorBox.single").hide(),
                "rect" === selectedObject.type ? $("#objectborderwh").show() : $("#objectborderwh").hide(),
                "" === selectedObject.fill || "rgba(0,0,0,0)" === selectedObject.fill ? ($("#colorSelector, #dynamiccolorpickers .sp-preview").css("background-image", 'url("assets/img/transbg.png")'),
                $("#colorSelector, #dynamiccolorpickers .sp-preview").css("background-color", "#ffffff")) : ($("#colorSelector").css("background-color", selectedObject.fill),
                $("#colorSelector").css("background-image", "none")),
                $(".color-fill .sp-clear, .dynamic-fill .sp-clear").click(function() {
                    console.log("here"),
                    $(".sp-container.color-fill, .sp-container.dynamic-fill").addClass("sp-hidden"),
                    selectedObject.set("fill", "rgba(0,0,0,0)"),
                    canvas.renderAll(),
                    save_history()
                }),
                $(".color-stroke .sp-clear").click(function() {
                    $(".sp-container.color-stroke").addClass("sp-hidden"),
                    selectedObject.set("stroke", ""),
                    canvas.renderAll(),
                    save_history()
                }),
                !0 === selectedObject.locked && (selectedObject.setControlsVisibility({
                    bl: !1,
                    br: !1,
                    tl: !1,
                    tr: !1,
                    ml: !1,
                    mr: !1,
                    mt: !1,
                    mtr: !1,
                    mb: !1
                }),
                selectedObject.set({
                    lockMovementY: !0,
                    lockMovementX: !0,
                    borderColor: "#cccccc"
                }),
                $toolbar_top.find(".textelebtns").hide(),
                $toolbar_top.find("#alignbtns").hide(),
                $toolbar_top.find("#clone").hide(),
                $toolbar_top.find(".bringforward").hide(),
                $toolbar_top.find(".sendbackward").hide(),
                $toolbar_top.find("#ungroup").hide(),
                $toolbar_top.find("#shadowGroup").hide(),
                $toolbar_top.find("#deleteitem").hide(),
                $toolbar_top.find("#showmoreoptions").hide(),
                $toolbar_top.find("#showObjectProperties").hide(),
                $toolbar_top.find(".patternFillGroup").hide()),
                selectedObject.dirty = !0,
                canvas.renderAll(),
                s_history = !0
            }
        }
    }
    function deselectLockedObject(e) {
        (selectedObject = canvas.getActiveObject()) && selectedObject._objects && $.each(selectedObject.getObjects(), function(i, o) {
            o && o.locked && !0 === o.locked && selectedObject.removeWithUpdate(o)
        })
    }
    void 0 === window.localStorage[localStorageKey] && (window.localStorage[localStorageKey] = ";"),
    canvas.observe("object:selected", function(e) {
        objectSelected(e, "selected")
    }),
    canvas.observe("selection:updated", function(e) {
        objectSelected(e, "updated")
    }),
    canvas.observe("selection:created", function(e) {
        objectSelected(e, "created")
    }),
    canvas.observe("selection:cleared", function(e) {
        $(".sp-container.color-fill, .sp-container.dynamic-fill").addClass("sp-hidden")
    }),
    canvas.observe("selection:updated", deselectLockedObject),
    canvas.observe("selection:created", deselectLockedObject),
    canvas.observe("object:moving", function(e) {
        $(".tools-top").removeClass("toolbar-show"),
        e.target.setCoords()
    }),
    canvas.observe("object:rotating", function(e) {
        e.e.shiftKey ? e.target.snapAngle = 0 : e.target.snapAngle = 5;
        var $angle = parseInt(e.target.angle % 360);
        $(".rotation_info_block").html($angle + "°").show()
    }),
    canvas.observe("object:scaling", function(e) {
        e.target && /text/.test(e.target.type) && e.target && e.target.scaleX === e.target.scaleY && $("#fontsize").val((e.target.fontSize * e.target.scaleX / 1.3).toFixed(0)),
        e.target.setCoords();
        document.getElementById("loadCanvasHei").value
    }),
    canvas.observe("object:modified", function(e) {
        if (DEBUG && console.log("object is modified"),
        $(".tools-top").addClass("toolbar-show"),
        s_history = !0,
        save_history(),
        e.target && /text/.test(e.target.type)) {
            var scaleX = e.target.scaleX
              , scaleY = e.target.scaleY;
            if (e.target && scaleX === scaleY) {
                if (e.target.fontSize *= scaleX,
                e.target.fontSize = e.target.fontSize.toFixed(0),
                e.target.width *= scaleX,
                e.target.height *= scaleY,
                e.target.fill instanceof fabric.Dpattern) {
                    var $newscale = e.target.fill.scale * scaleX;
                    e.target.fill.update({
                        scale: $newscale
                    })
                }
                e.target.scaleX = 1,
                e.target.scaleY = 1,
                e.target.setCoords(),
                $("#fontsize").val((e.target.fontSize / 1.3).toFixed(0))
            }
            !isTextsGroup() && e.target.fill && "object" === _typeof(e.target.fill) && ("linear" === e.target.fill.type ? e.target.fill.coords.x1 < 0 ? (e.target.fill.coords.x1 = -e.target.width,
            e.target.fill.coords.x2 = e.target.width,
            e.target.fill.coords.y1 = -e.target.height,
            e.target.fill.coords.y2 = e.target.height) : (0 !== e.target.fill.coords.x1 && (e.target.fill.coords.x1 = e.target.width),
            0 !== e.target.fill.coords.x2 && (e.target.fill.coords.x2 = e.target.width),
            0 !== e.target.fill.coords.y1 && (e.target.fill.coords.y1 = e.target.height),
            0 !== e.target.fill.coords.y2 && (e.target.fill.coords.y2 = e.target.height)) : "radial" === e.target.fill.type && void 0 !== e.target.fill.coords.r1 && (e.target.fill.coords.r2 = e.target.width > e.target.height ? e.target.width / 2 : e.target.height / 2,
            e.target.fill.coords.x1 = e.target.width / 2,
            e.target.fill.coords.x2 = e.target.width / 2,
            e.target.fill.coords.y1 = e.target.height / 2,
            e.target.fill.coords.y2 = e.target.height / 2))
        }
    }),
    canvas.observe("object:added", function(e) {
        if (e.target.isUngrouping)
            delete e.target.isUngrouping;
        else {
            var add_object = e.target
              , color = "group" === add_object.type ? "#f9a24c" : "#4dd7fa";
            add_object.set({
                transparentCorners: !1,
                borderDashArray: [4, 2],
                cornerStrokeColor: "#ffffff",
                borderColor: color,
                cornerColor: color,
                cornerSize: 8,
                minScaleLimit: 0,
                padding: 5,
                lockScalingFlip: !0
            }),
            getFonts(e.target),
            save_history(),
            canvas.renderAll()
        }
    }),
    canvas.observe("mouse:up", function(e) {
        canvas.renderAll()
    }),
    canvas.observe("mouse:up", function(e) {
        if (e.target && /text/.test(e.target.type) && e.target.isEditing) {
            DEBUG && console.log("style at positon", e.target.getStyleAtPosition());
            var styleAtPosition = e.target.getStyleAtPosition();
            if ($("#fontsize").val((e.target.fontSize / 1.3).toFixed(0)),
            void 0 !== styleAtPosition.fill ? $("#colorSelector").css("backgroundColor", styleAtPosition.fill) : $("#colorSelector").css("backgroundColor", e.target.fill),
            void 0 !== styleAtPosition.fontWeight ? "bold" === styleAtPosition.fontWeight ? $("#fontbold").addClass("active") : $("#fontbold").removeClass("active") : "bold" === e.target.fontWeight ? $("#fontbold").addClass("active") : $("#fontbold").removeClass("active"),
            void 0 !== styleAtPosition.fontStyle ? "italic" === styleAtPosition.fontStyle ? $("#fontitalic").addClass("active") : $("#fontitalic").removeClass("active") : "italic" === e.target.fontStyle ? $("#fontitalic").addClass("active") : $("#fontitalic").removeClass("active"),
            void 0 !== styleAtPosition.underline ? "underline" === styleAtPosition.underline ? $("#fontunderline").addClass("active") : $("#fontunderline").removeClass("active") : "italic" === e.target.underline ? $("#fontunderline").addClass("active") : $("#fontunderline").removeClass("active"),
            void 0 !== styleAtPosition.fontFamily) {
                var fontDisplayName = $("#fonts-dropdown").find('a[data-ff="' + styleAtPosition.fontFamily + '"]').parent().find("span").text();
                DEBUG && console.log("fontDisplayName", fontDisplayName),
                $("#font-selected").html('<span style="overflow:hidden"><a href="#" style="font-family: ' + styleAtPosition.fontFamily + '" >' + fontDisplayName + '</a>&nbsp;&nbsp;<span class="caret"></span></span>'),
                $("#font-dropdown").on("shown.bs.dropdown", function() {
                    $("#fontSearch").focus(),
                    $("#fonts-dropdown").scrollTop($('#fonts-dropdown li a[data-ff="' + styleAtPosition.fontFamily + '"]').position().top - $("#fonts-dropdown li:first").position().top),
                    $("#fonts-dropdown li a").removeClass("font-selected"),
                    $('#fonts-dropdown li a[data-ff="' + styleAtPosition.fontFamily + '"]').addClass("font-selected")
                })
            } else {
                var fontid = e.target.fontFamily || "font7";
                fontDisplayName = $("#fonts-dropdown").find('a[data-ff="' + fontid + '"]').parent().find("span").text();
                $("#font-selected").html('<span style="overflow:hidden"><a href="#" style="font-family: ' + e.target.fontFamily + '" >' + fontDisplayName + '</a>&nbsp;&nbsp;<span class="caret"></span></span>'),
                $("#font-dropdown").on("shown.bs.dropdown", function() {
                    $("#fontSearch").focus(),
                    $("#fonts-dropdown").scrollTop($('#fonts-dropdown li a[data-ff="' + e.target.fontFamily + '"]').position().top - $("#fonts-dropdown li:first").position().top),
                    $("#fonts-dropdown li a").removeClass("font-selected"),
                    $('#fonts-dropdown li a[data-ff="' + e.target.fontFamily + '"]').addClass("font-selected")
                })
            }
        }
    }),
    canvas.observe("text:editing:entered", function(e) {
        DEBUG && console.log("text:editing:entered first"),
        selectedObject.hasControls = !0,
        $("#group").hide(),
        $("#ungroup").hide(),
        $("#strokegroup").hide(),
        $("#clone").hide(),
        $("#showmoreoptions").hide(),
        $("#shadowGroup").hide(),
        e.target.set({
            cursorColor: e.target.fill
        });
        var $scale_value = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1
          , bodyRect = document.body.getBoundingClientRect()
          , offsetRect = (e.target.canvas.upperCanvasEl.getBoundingClientRect().top - bodyRect.top) / $scale_value;
        e.target.hiddenTextarea.style.cssText = "position: fixed !important; top: " + offsetRect + "px !important; left: 0px; opacity: 0; width: 0px; height: 0px; z-index: -999;"
    }),
    canvas.on("mouse:over", function(e) {
        e.target && "line" === e.target.type && (e.target.padding = 5,
        e.target.setCoords(),
        canvas.renderAll())
    }),
    canvas.observe("text:editing:exited", function(e) {
        DEBUG && console.log("text:editing:exited"),
        "" == e.target.text && setTimeout(function() {
            return canvas.remove(e.target)
        }, 0),
        $("#group").show(),
        $("#ungroup").show(),
        $("#strokegroup").show(),
        $("#clone").show(),
        $("#showmoreoptions").show(),
        $("#shadowGroup").show()
    }),
    $("body").mousedown(function(e) {
        var actobj = canvas.getActiveObject();
        actobj || ($(".tools-top").removeClass("toolbar-show"),
        $(".patternFillTab").hide(),
        $(".patternFillPreview").removeClass("open"),
        "LI" !== e.target.nodeName && $(".custom-menu").hide()),
        $("#filltype, .filltype, #strokedropdown").click(function() {
            $(".sp-container.color-fill, .sp-container.dynamic-fill, .sp-container.color-stroke").addClass("sp-hidden")
        }),
        actobj && "image" === actobj.type && 0 !== $(e.target).closest(".ui-dialog").length || $("#object-properties").dialog("close"),
        actobj && (/text/.test(actobj.type) || 0 !== $(e.target).closest(".ui-dialog").length) || $("#font-symbols").dialog("close"),
        "CANVAS" !== e.target.nodeName && "DIV" === e.target.nodeName && "sp-preview" !== e.target.className && !$(e.target).hasClass("sp-clear") && e.target.className.indexOf("sp-light") < 0 && "sp-container" !== e.target.className && e.target.className.indexOf("ui-dialog") < 0 && $(".dpattern-holder").has(e.target).length < 1 && $(".patternFillTab").has(e.target).length < 1 && $("#font-symbols").has(e.target).length < 1 && (canvas.discardActiveObject().renderAll(),
        $(".tools-top").removeClass("toolbar-show"),
        $(".patternFillTab").hide(),
        $(".patternFillPreview").removeClass("open"),
        $("#font-symbols").dialog("close"))
    })
}
$(aContainer_image).on("load.infiniteScroll", function(event, response) {
    var data = JSON.parse(response)
      , itemsHTML = (data = data.images).map(getItemHTML_image).join("")
      , $items = $(itemsHTML);
    $items.imagesLoaded(function() {
        infinites[type_image].infiniteScroll("appendItems", $items).masonry("appended", $items)
    }),
    0 != data.length && setTimeout(function() {
        flag_scroll_images_image = !1,
        $(aContainer_image).next().find(".iscroll-last").hide()
    }, 500),
    data.length < limit_image && ($(aContainer_image).next().find(".loader-ellips").hide(),
    $(aContainer_image).next().find(".iscroll-button").hide(),
    $(aContainer_image).next().find(".iscroll-last").show())
}),
$(document).ready(function() {
    var columns = [{
        data: "date",
        title: "Date"
    }, {
        data: "type",
        title: "Type"
    }, {
        data: "template_id",
        title: "Template ID"
    }, {
        data: "template_name",
        title: "Template name"
    }, {
        data: "s3url",
        title: "Download",
        render: function(link) {
            return '<a target="_blank" href="' + getS3Url(link) + '">Download</a>'
        }
    }];
    // historyTable = $("#historyTable").DataTable({
    //     ajax: appUrl + "design/app/get-download-history-server-process",
    //     columns: columns,
    //     bLengthChange: !1,
    //     aaSorting: [[0, "desc"]]
    // })
});
