function initCanvasEvents(lcanvas) {
    if (DEBUG) {
        console.log(`initCanvasEvents(): Canvas ID - ${lcanvas ? lcanvas.id : 'undefined'}`);
    }

    let selectedObject;
    const canvas = lcanvas || canvas;
    const LOCAL_STORAGE_KEY = "wayak.design";
    
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
    });
    canvas.observe("selection:updated", function(e) {
        objectSelected(e, "updated")
    });
    canvas.observe("selection:created", function(e) {
        objectSelected(e, "created")
    });
    canvas.observe("selection:cleared", function(e) {
        $(".sp-container.color-fill, .sp-container.dynamic-fill").addClass("sp-hidden")
    });
    canvas.observe("selection:updated", deselectLockedObject),
    canvas.observe("selection:created", deselectLockedObject),
    canvas.observe("object:moving", function(e) {
        $(".tools-top").removeClass("toolbar-show"),
        e.target.setCoords()
    });
    canvas.observe("object:rotating", function(e) {
        e.e.shiftKey ? e.target.snapAngle = 0 : e.target.snapAngle = 5;
        var $angle = parseInt(e.target.angle % 360);
        $(".rotation_info_block").html($angle + "°").show()
    });
    canvas.observe("object:scaling", function(e) {
        e.target && /text/.test(e.target.type) && e.target && e.target.scaleX === e.target.scaleY && $("#fontsize").val((e.target.fontSize * e.target.scaleX / 1.3).toFixed(0)),
        e.target.setCoords();
        document.getElementById("loadCanvasHei").value
    });
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
    });
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
    });
    canvas.observe("mouse:up", function(e) {
        canvas.renderAll()
    });
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
    });
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
    });
    canvas.on("mouse:over", function(e) {
        e.target && "line" === e.target.type && (e.target.padding = 5,
        e.target.setCoords(),
        canvas.renderAll())
    });
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
    });
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
    });
}