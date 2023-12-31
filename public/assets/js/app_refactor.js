function downloadImage3(options = {}) {
    const canvases = options.canvases || canvasarray;
    let index = options.i || 0;
    let format = options.format || "jpeg";
    const zip = options.zip || new JSZip();

    format = format === "jpg" ? "jpeg" : format;

    const filename = `wayak_${index + 1}.${format}`;
    let id = loadedtemplateid;

    if (format === "jpeg" && !canvases[index].backgroundColor) {
        canvases[index].set({ backgroundColor: "#ffffff" });
    }

    canvases[index].setDimensions();

    const metrics = $("input[name=metric_units1]:checked").val();
    let multiplier = 1;
    if (format === "jpeg" || (format === "png" && metrics === "px" && !/geofilter/.test(template_type))) {
        multiplier = 3.125;
    }


    const getCanvasDataURL = () => canvases[index].toDataURL({
        format: format,
        quality: 1,
        multiplier: multiplier / fabric.devicePixelRatio,
        enableRetinaScaling: true
    });

    let dataURL = getCanvasDataURL();
    if (format === "jpeg") {
        dataURL = setJpegDPI(dataURL);
    } else if (format === "png" && template_type !== "geofilter" && template_type !== "geofilter2") {
        dataURL = setPngDPI(dataURL);
    }

    const base64Data = dataURL.split("base64,")[1];
    zip.file(filename, base64Data, { base64: true });

    if (canvases[++index]) {
        downloadImage3({ canvases, i: index, format, zip });
    } else {
        id = loadedtemplateid === 0 ? "new" : id;
        const finalFilename = `wayak_${id}.zip`;
        processZipAndSave(zip, finalFilename);
    }
}

function processZipAndSave(zip, filename) {
    const generateZipOptions = isMac && isSafari ? { type: "base64" } : { type: "blob" };
    const zipGeneration = zip.generateAsync(generateZipOptions);

    zipGeneration.then(blobOrBase64 => {
        if (isMac && isSafari) {
            saveZipBase64(blobOrBase64, filename);
        } else {
            appSpinner.hide();
            setZoom($("#zoomperc").data("oldScaleValue"));
            saveAs(blobOrBase64, filename);
        }
    });

    toggleHiddenStatusOfObjects();
}

function toggleHiddenStatusOfObjects() {
    if (DEBUG) { // Assumes 'DEBUG' is globally accessible
        console.log("MIGRATED:: toggleHiddenStatusOfObjects");
    }

    canvasarray.forEach(toggleObjectsVisibility); // Assumes 'canvasarray' is globally accessible
}

function toggleObjectsVisibility(canvas) {
    canvas.forEachObject(object => {
        if (object.hidden) {
            object.visible = !object.visible;
        }
    });
    canvas.renderAll();
}


function saveZipBase64(content, filename) {
    const url = `${appUrl}design/savezip.php`;
    $.post(url, { file: filename, data: content })
        .done(response => {
            const parsedResponse = JSON.parse(response);
            if (parsedResponse.err) {
                saveAs(content, filename);
            } else {
                window.location.href = `${appUrl}design/downloadfile.php?file=${parsedResponse.msg}&filename=${filename}`;
            }
        })
        .fail(() => saveAs(content, filename))
        .always(() => {
            appSpinner.hide();
            setZoom($("#zoomperc").data("oldScaleValue"));
        });
}


function downloadImage() {
    $("#publishModal").modal("hide");
    appSpinner.show();

    const canvasWidth = parseInt(document.getElementById("loadCanvasWid").value) * 96;
    const canvasHeight = parseInt(document.getElementById("loadCanvasHei").value) * 96;
    const columns = parseInt(document.getElementById("numOfcanvascols").value);
    const rows = parseInt(document.getElementById("numOfcanvasrows").value);

    setZoom(1);

    const buffer = document.getElementById("outputcanvas");
    const bufferContext = buffer.getContext("2d");

    buffer.width = canvasWidth * columns;
    const hiddenCanvasCount = columns * rows * (pageindex + 1) - $(".divcanvas:visible").length;
    buffer.height = canvasHeight * (rows * (pageindex + 1) - hiddenCanvasCount / columns);

    let writtenPages = 0;
    let processPages = 0;
    let rowCount = 0;
    let colCount = 0;

    for (let i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;

        canvasarray[i].discardActiveObject().renderAll();

        if ($("#divcanvas" + i).is(":visible")) {
            processPages++;
            if (colCount >= columns) {
                colCount = 0;
                rowCount++;
            }

            const posX = canvasWidth * colCount++;
            const posY = canvasHeight * rowCount;

            processTmpDownloadCanvas(i, posX, posY, () => {
                if (++writtenPages === processPages) {
                    saveCanvasImage();
                }
            });
        }
    }
}

function processTmpDownloadCanvas(canvasIndex, posX, posY, callback) {
    const img = new Image();
    img.onload = function () {
        const bufferContext = document.getElementById("outputcanvas").getContext("2d");
        bufferContext.drawImage(this, posX, posY);
        callback();
    };
    img.src = canvasarray[canvasIndex].toDataURL({ format: "png", multiplier: 1 / fabric.devicePixelRatio });
}

function saveCanvasImage() {
    if(DEBUG) {
        console.log("MIGRATED:: saveCanvasImage()");
    }
    const canvasElement = document.getElementById("outputcanvas");
    const id = loadedtemplateid === 0 ? "new" : loadedtemplateid;
    const filename = `wayak_${id}.png`;
    const imageData = canvasElement.toDataURL({ format: "png", quality: 1 });
    const url = `${appUrl}design/saveimage.php`;

    $.post(url, { file: filename, data: imageData }).done(response => {
        if (response.length > 1) {
            $("#autosave").data("saved", "yes");
            window.location.href = `${appUrl}design/downloadfile.php?file=${response}&filename=${filename}`;
        }
    }).always(() => {
        appSpinner.hide();
        setZoom($("#zoomperc").data("oldScaleValue"));
    });
}

function getFonts2(object, fontFamily) {
    if (DEBUG) {
        console.log("MIGRATED:: getFonts2() fontFamily: " + fontFamily);
    }

    return new Promise((resolve, reject) => {
        if (!fontFamily) {
            resolve({ object, font: "" });
            return;
        }

        if (dontLoadFonts.includes(fontFamily)) {
            resolve({ object, font: fontFamily });
            setupSymbolsPanel(fontFamily);
            return;
        }

        const WebFontConfig = {
            custom: {
                families: [fontFamily],
                urls: [`${appUrl}editor/get-css-fonts?templates=${JSON.stringify(fontFamily)}`]
            },
            testStrings: { fontFamily: "AB" },
            loading: () => { if (DEBUG) console.log("loading"); },
            inactive: (f) => { if (DEBUG) console.log("inactive"); },
            fontloading: (f) => { if (DEBUG) console.log("fontloading " + f); },
            fontactive: (f) => {
                if (DEBUG) console.log("fontactive " + f);
                resolve({ object, font: f });
                addFontToFabric(f);
                dontLoadFonts.push(f);
                setupSymbolsPanel(f);
            },
            fontinactive: (f) => {
                if (DEBUG) console.log("fontinactive" + f);
                reject({ object, font: f });
            }
        };

        WebFont.load(WebFontConfig);
    });
}

function switchFillType(fillType, color1, color2, target) {
    if (DEBUG) {
        console.log("MIGRATED:: switchFillType() target: ", target);
        console.log("MIGRATED:: switchFillType() fillType: ", fillType);
    }

    const colorSelectorBox = target ? $(target).parents(".colorSelectorBox") : $(".colorSelectorBox");
    fillType = fillType || $(".toolbar-top").find(".fill-type.active").attr("id");

    colorSelectorBox.find(".fill-type").removeClass("active");
    colorSelectorBox.find("#" + fillType).addClass("active");

    if (fillType === "pattern-fill") {
        $(".patternFillGroup").show();
        $("#colorSelector").hide();
    } else {
        $(".patternFillGroup").hide();
        $("#colorSelector").show();
    }

    if (color1 && typeof color1 === "string" && !color2) {
        color2 = ("000000" + ("0xffffff" ^ color1.replace("#", "0x")).toString(16)).slice(-6);
    }

    if (fillType === "color-fill") {
        handleColorFill(colorSelectorBox, color1);
    }

    if (["linear-gradient-h-fill", "linear-gradient-v-fill", "linear-gradient-d-fill", "radial-gradient-fill"].includes(fillType)) {
        handleGradientFill(colorSelectorBox, color1, color2);
    }
}

function handleColorFill(colorSelectorBox, color) {
    colorSelectorBox.find("#colorSelector2").hide();
    colorSelectorBox.find("#colorSelector").css({
        "background-color": color,
        padding: "17px 19px"
    });

    if (colorSelectorBox.hasClass("group")) {
        applyGroupStyles(colorSelectorBox, color);
    }
}

function handleGradientFill(colorSelectorBox, color1, color2) {
    colorSelectorBox.find("#colorSelector2").show();
    if (color1 && typeof color1 === "string" && color2) {
        colorSelectorBox.find("#colorSelector,#colorSelector2").css({
            "background-color": "transparent",
            padding: "17px 10px"
        });

        if (colorSelectorBox.hasClass("group")) {
            colorSelectorBox.find(".sp-light,.sp-preview").css({
                "background-color": "transparent"
            });
            colorSelectorBox.find(".sp-light").css({
                padding: "17px 10px",
                width: "20px"
            });
        }

        const linearGradient = `linear-gradient(to right, ${color1}, ${color2})`;
        colorSelectorBox.css({
            "background-image": linearGradient,
            height: "36px"
        });
    }
}

function applyGroupStyles(colorSelectorBox, color) {
    colorSelectorBox.find(".sp-preview").css({
        "background-color": color,
        padding: "17px 19px"
    });
    colorSelectorBox.find(".sp-light").css({
        width: "40px"
    });
    colorSelectorBox.find(".dynamiccolorpicker2").spectrum("destroy").hide();
}

function configureImage(img, scale) {
    img.scaleToWidth(50 * scale);
    img.angle = 315;
    img.top = 50 * scale;
    img.left = 20 * scale;
}

function createPatternSourceCanvas(img, scale) {
    const canvas = new fabric.StaticCanvas();
    canvas.add(img);
    return canvas;
}

function getPatternSource(canvas, scale) {
    canvas.setDimensions({
        width: 80 * scale,
        height: 80 * scale
    });
    canvas.renderAll();
    return canvas.getElement();
}

function applyPatternToVisibleCanvases(pattern) {
    for (let i = 0; i < canvasarray.length; i++) {
        if ($("#divcanvas" + i).is(":visible")) {
            canvasarray[i].setOverlayColor(pattern, () => canvasarray[i].renderAll());
        }
    }
}

function openTemplate(jsons) {
    if (DEBUG) {
        console.log("MIGRATED:: openTemplate()");
    }

    resetState();

    if (!IsJsonString(jsons)) {
        showErrorToast("Something went wrong");
        return false;
    }

    const jsonCanvasArray = JSON.parse(jsons);
    if (!jsonCanvasArray || jsonCanvasArray.length <= 0) {
        showErrorToast("Invalid Template Data");
        return false;
    }

    setupTemplate(jsonCanvasArray);
    processFonts(jsonCanvasArray);

    return true;
}

function resetState() {
    savestatecount = 0;
    s_history = false;
}

function isTextsGroup() {
    if (DEBUG) {
        console.log("MIGRATED:: isTextsGroup()");
    }

    const activeObject = canvas.getActiveObject();
    if (!activeObject || !activeObject._objects) {
        return false;
    }

    return activeObject._objects.every(object => /text/.test(object.type));
}

function showErrorToast(message) {
    appSpinner.hide();
    $.toast({
        text: message,
        icon: "error",
        hideAfter: 2000,
        loader: false,
        position: "top-right"
    });
}

function setupTemplate(jsonCanvasArray) {
    const templateSettings = JSON.parse(jsonCanvasArray[0]);
    setTemplateDimensions(templateSettings);

    initializePages(jsonCanvasArray, templateSettings);
    setCanvasSize();
}

function setTemplateDimensions(templateSettings) {
    document.getElementById("loadCanvasWid").value = parseFloat(templateSettings.width / 96);
    document.getElementById("loadCanvasHei").value = parseFloat(templateSettings.height / 96);
    document.getElementById("numOfcanvasrows").value = parseInt(templateSettings.rows);
    document.getElementById("numOfcanvascols").value = parseInt(templateSettings.cols);
}

function initializePages(jsonCanvasArray, templateSettings) {
    const rowsCols = parseInt(templateSettings.rows) * parseInt(templateSettings.cols);
    $("#canvaspages").html("");
    pageindex = 0;
    canvasindex = 0;
    canvasarray = [];

    for (let i = 0; i < (jsonCanvasArray.length - 1) / rowsCols; i++) {
        pageindex = i;
        $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>");
        addCanvasToPage(false, i, jsonCanvasArray);
    }
}

function processFonts(jsonCanvasArray) {
    let fontFamilies = [];
    for (let i = 1; i < jsonCanvasArray.length; i++) {
        if (jsonCanvasArray[i].objects) {
            jsonCanvasArray[i].objects.forEach((object) => {
                extractFontFamilies(object, fontFamilies);
            });
        }
    }

    if (fontFamilies.length === 0) {
        proceedOpenTemplate(jsonCanvasArray);
    } else {
        loadFonts(fontFamilies, jsonCanvasArray);
    }
}

function extractFontFamilies(object, fontFamilies) {
    // Extract font families from the object
}

function loadFonts(families, jsonCanvasArray) {
    families = [...new Set(families)]; // Remove duplicates
    WebFontConfig = {
        // WebFontConfig setup
        active: function () {
            if (DEBUG) {
                console.log("all fonts are loaded");
            }
            proceedOpenTemplate(jsonCanvasArray);
        },
        fontinactive: function (font) {
            if (DEBUG) {
                console.log("Font failed to load: " + font);
            }
        },
        inactive: function () {
            showErrorToast("Fonts have failed to load. Please refresh the browser.");
            proceedOpenTemplate(jsonCanvasArray);
        }
    };
    WebFont.load(WebFontConfig);
}

function checkIfGroupsNeedsSVGLoading(canvas, canvasIndex) {
    if (DEBUG) {
        console.log("MIGRATED:: checkIfGroupsNeedsSVGLoading()");
    }

    canvas._objects.forEach((object, index) => {
        if (object.type === 'group') {
            const needsSvgLoading = object._objects.some(child =>
                child.type === 'group' && child.svg_custom_paths !== undefined);

            if (needsSvgLoading) {
                if (DEBUG) {
                    console.log("checkIfGroupsNeedsSVGLoading(): needsSvgLoading", needsSvgLoading);
                }
                loadSVGForGroupMembers({ canvas, index });
            }
        }
    });

    afterLoadJSON(canvas, canvasIndex);
}

function isSvg(object = canvas.getActiveObject()) {
    if (DEBUG) {
        console.log("MIGRATED:: isSvg()");
    }

    return !!object && !!object.src && /\.sv?g$/i.test(object.src);
}

function updateTemplate(updateOriginal = 0) {
    if (DEBUG) {
        console.log("MIGRATED:: updateTemplate");
    }

    return new Promise((resolve, reject) => {
        if (stopProcess) {
            reject(new Error("Process stopped"));
            return;
        }

        s_history = false;

        if (totalsvgs === convertedsvgs && loadedtemplateid !== 0) {
            isupdatetemplate = false;
            const jsonData = getTemplateJson();

            if (!IsJsonString(jsonData)) {
                showToast("An error occurred while saving the template", "error");
                reject(new Error("Invalid JSON data"));
                return;
            }

            const metrics = $("input[name=metric_units1]:checked").val();
            const pngdataURL = getTemplateThumbnail();
            const crc = crc32(jsonData);
            const url = `${appUrl}editor/template/update`;

            sendTemplateUpdateRequest(url, jsonData, pngdataURL, metrics, crc, updateOriginal)
                .then(resolve)
                .catch(reject);
        }
    });
}

function sendTemplateUpdateRequest(url, jsonData, pngdataURL, metrics, crc, updateOriginal) {
    return new Promise((resolve, reject) => {
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
        }).done((answer) => {
            appSpinner.hide();
            const icon = answer.err ? "error" : "success";
            const text = answer.err ? answer.msg : "Template saved";
            showToast(text, icon);

            if (!answer.err) {
                if (currentUserRole === "customer") {
                    getTemplates2(0, "");
                }
                $("#autosave").data("saved", "yes");
            }

            s_history = true;
            resolve();
        }).fail(() => {
            appSpinner.hide();
            showToast("Error saving template. Please try again", "error");
            reject(new Error("Ajax request failed"));
        });
    });
}

function save_history(forceSave = false) {
    if (DEBUG) {
        console.log("MIGRATED:: save_history()");
    }

    initializeCanvasHistory();

    if (s_history) {
        setTimeout(() => {
            updateCanvasDimensions();
            const canvasState = JSON.stringify(canvas.toDatalessJSON(["locked"]));

            if (shouldSaveState(canvasState, forceSave)) {
                saveCanvasState(canvasState);
            }

            manageHistorySize();
            updateUIAfterSave();
            autoSaveTemplateIfNeeded();
        }, 10);
    }
}

function initializeCanvasHistory() {
    if (!canvas.$history) {
        canvas.$history = [];
        canvas.$h_pos = -1;
    }
}

function updateCanvasDimensions() {
    canvas.cwidth = 96 * $("#loadCanvasWid").val();
    canvas.cheight = 96 * $("#loadCanvasHei").val();
}

function shouldSaveState(canvasState, forceSave) {
    return canvas.$history[canvas.$h_pos] !== canvasState || forceSave;
}

function saveCanvasState(canvasState) {
    canvas.$history[++canvas.$h_pos] = canvasState;
    if (canvas.$history.length - 1 > canvas.$h_pos) {
        canvas.$history = canvas.$history.slice(0, canvas.$h_pos + 1);
    }
}

function manageHistorySize() {
    if (canvas.$history.length > 100) {
        canvas.$history = canvas.$history.slice(-100);
        canvas.$h_pos = canvas.$history.length - 1;
    }

    if (DEBUG) {
        console.log("MIGRATED:: saved. history length: " + canvas.$history.length + " history position: " + canvas.$h_pos);
    }
}

function updateUIAfterSave() {
    $("#redo").hide();
    $("#undo").show();
    $("#autosave").data("saved", "no");
}

function autoSaveTemplateIfNeeded() {
    if (document.getElementById("autosave").checked && canvas.$history.length % 9 === 0 && loadedtemplateid) {
        $.toast({
            text: "Auto saving template...",
            icon: "success",
            position: "top-right",
            hideAfter: 2000
        });

        isupdatetemplate = true;
        s_history = false;
        canvas.discardActiveObject().renderAll();
        processSVGs(true);
        $("#autosave").data("saved", "yes");
    }
}

function changeObjectColor(hex) {
    if (DEBUG) {
        console.log("MIGRATED:: changeObjectColor()");
    }

    const activeObject = canvas.getActiveObject();
    if (activeObject) {
        updateFillColor(activeObject, hex);

        if (activeObject._objects) {
            activeObject.forEachObject((object) => {
                updateFillColor(object, hex);
            });
        }

        canvas.renderAll();
        save_history(1);
    }
}

function updateFillColor(object, hex) {
    if (object.paths) {
        object.paths.forEach((path) => {
            path.set("fill", hex);
        });
    } else {
        setStyle(object, "fill", hex);
    }
}

function isElement(object) {
    if (DEBUG) {
        console.log("MIGRATED:: isElement()");
    }

    if (!object) {
        return false;
    }

    if (object.svg_custom_paths !== undefined) {
        return true;
    }

    const objects = object.objects || object._objects;
    return objects ? hasPathTypeObject(objects) : false;
}

function hasPathTypeObject(objects) {
    for (let i = 0; i < objects.length; i++) {
        const o = objects[i];

        if (o.type === 'path' || o.type === 'path-group') {
            return true;
        }

        if (o.type === 'group') {
            const groupObjects = o.getObjects();
            if (groupObjects.some(ch => ch.type === 'path' || ch.type === 'path-group')) {
                return true;
            }
        }
    }

    return false;
}

function loadTemplate(templateId, checkUnsaved = true) {
    if (DEBUG) {
        console.log("MIGRATED:: loadTemplate()");
    }

    stopProcess = true;
    s_history = false;

    if (!isAutosaveConfirmed() && checkUnsaved) {
        showUnsavedChangesModal(templateId);
        return;
    }

    initializeTemplateLoad(templateId);
    fetchTemplateData(templateId);
}

function isAutosaveConfirmed() {
    return $("#autosave").data("saved") === "yes" || demo_as_id !== 0;
}

function showUnsavedChangesModal(templateId) {
    $("#unsavedChanges").data({ newtemplate: 0, templateid: templateId }).modal("show");
}

function initializeTemplateLoad(templateId) {
    setZoom(1);
    appSpinner.show();
    loadedtemplateid = templateId;
}

function fetchTemplateData(templateId) {
    const url = appUrl + "editor/load-template";

    $.ajax({
        url: url,
        type: "get",
        data: {
            language_code: language_code,
            id: templateId,
            design_as_id: design_as_id,
            demo_as_id: demo_as_id,
            demo_templates: demo_templates
        },
        dataType: "json"
    }).done(handleTemplateDataSuccess)
        .fail(handleTemplateDataError);

    $("#downloads-remaining-text").hide();
    fetchDownloadsRemaining(templateId);
}

function handleTemplateDataSuccess(data) {
    if (data.err === 0) {
        updateTemplateSettings(data);
        if (!openTemplate(data.data)) return;
        updateMetricUnits(data.metrics);
        canvas.calcOffset();
        canvas.renderAll();
        $("#autosave").data("saved", "yes");
        stopProcess = false;
        updateInstructions(data.instructions);
        initializeUIElements();
    } else {
        appSpinner.hide();
        showToast(data.msg, "error");
    }
}

function updateTemplateSettings(data) {
    // Reset default values
    geofilterBackground = 0;
    template_type = "custom";

    // Check if there are options and update settings accordingly
    if (data.options && data.options.length) {
        const options = JSON.parse(data.options);
        template_type = options.type;
        instructionsId = options.instructionsId;

        if ((template_type === "geofilter" || template_type === "geofilter2") && options.geofilterBackground) {
            geofilterBackground = options.geofilterBackground;
        }

        // Assuming 'templateOptions' is a global variable that should be updated
        templateOptions = options;
    }
}

function updateMetricUnits(metrics) {
    $("input[name=metric_units]").val([metrics]);
    $("input[name=metric_units1]").val([metrics]);

    // Resetting active class for all metric unit buttons
    $(".canvas_size_pixels, .canvas_size_inches, .canvas_size_mm").removeClass("active");

    // Setting active class based on the metric units
    switch (metrics) {
        case "px":
            $(".canvas_size_pixels").addClass("active");
            break;
        case "in":
            $(".canvas_size_inches").addClass("active");
            break;
        case "mm":
            $(".canvas_size_mm").addClass("active");
            break;
        default:
            console.error("Unknown metric unit: " + metrics);
            break;
    }
}

function updateInstructions(instructions) {
    if (instructions) {
        $("#instructions").html(instructions).show();
    } else {
        $("#instructions-button").hide();
    }
}

function initializeUIElements() {
    if (demo_as_id > 0){
        setDemoOverlay();
    }
    initMasonry_related(loadedtemplateid);
    loadTemplates_related();
    initMasonry_bg();
}

function handleTemplateDataError(jqXHR, textStatus, errorThrown) {
    appSpinner.hide();
    handleAjaxError(jqXHR);
    showToast("Something went wrong", "error");
}

function handleAjaxError(jqXHR) {
    // Function to handle different Ajax error scenarios
}

function fetchDownloadsRemaining(templateId) {
    const urlDownloadsRemaining = appUrl + "editor/get-remaining-downloads/" + templateId;

    $.ajax({
        url: urlDownloadsRemaining,
        type: "GET",
        dataType: "json"
    }).done((data) => {
        if (data.success && data.remaining > 0) {
            showDownloadsRemaining(data.remaining);
        }
    }).fail(() => {
        // Handle fail scenario
    });
}

function showToast(text, icon) {
    $.toast({
        text: text,
        icon: icon,
        loader: false,
        position: "top-right",
        hideAfter: 2000
    });
}

function getFonts(element, fontFamily) {
    if (DEBUG) {
        console.log("MIGRATED:: getFonts()");
    }

    fontFamily = fontFamily || element.fontFamily;
    let families = collectFontFamilies(element);

    if (families.length) {
        families = removeDuplicateFonts(families);
        loadFonts(families, element);
    } else {
        if (element.type === "group") {
            resetGroupElement(element);
        }
        canvasarray[currentcanvasid].renderAll();
    }
}

function collectFontFamilies(element) {
    let families = [];

    if (element.type === "group") {
        element.forEachObject(child => {
            families = families.concat(getFontFamiliesFromObject(child));
        });
    } else {
        families = getFontFamiliesFromObject(element);
    }

    if (element.fontFamily && !dontLoadFonts.includes(element.fontFamily)) {
        if (DEBUG) {
            console.log(element.fontFamily);
        }
        families.push(element.fontFamily);
    }

    return families;
}

function getFontFamiliesFromObject(object) {
    let families = [];

    if (object.fontFamily && !dontLoadFonts.includes(object.fontFamily)) {
        families.push(object.fontFamily);
    }

    if (!jQuery.isEmptyObject(object.styles)) {
        jQuery.each(object.styles, ($i, $line) => {
            jQuery.each($line, ($i, $style) => {
                if ($style.fontFamily && !dontLoadFonts.includes($style.fontFamily)) {
                    families.push($style.fontFamily);
                }
            });
        });
    }

    return families;
}

function removeDuplicateFonts(families) {
    return families.filter((value, index, self) => {
        return self.indexOf(value) === index;
    });
}

function loadFonts(families, element) {
    WebFontConfig = {
        custom: {
            families: families,
            urls: [appUrl + "editor/get-css-fonts?templates=" + JSON.stringify(families)]
        },
        // ... other properties of WebFontConfig
        fontactive: function (f) {
            // ... handling for 'fontactive'
            updateElementFonts(element, f);
        }
    };

    WebFont.load(WebFontConfig);
}

function updateElementFonts(element, fontFamily) {
    if (DEBUG) {
        console.log("MIGRATED:: font: " + fontFamily + " loaded");
    }

    // Updating the cache for the loaded font
    fabric.charWidthsCache[fontFamily] = {};

    // Add the font to Fabric's font list if not already present
    addFontToFabric(fontFamily);

    // Check if the element is a group and update its objects
    if (element.type === 'group') {
        element.forEachObject((child) => {
            if (isTextType(child) && child.fontFamily === fontFamily) {
                updateTextObject(child);
            }
        });

        // Reset group state and update its coordinates
        resetGroupElement(element);
    } else if (isTextType(element) && element.fontFamily === fontFamily) {
        // Update single text object
        updateTextObject(element);
    }

    // Mark the element as dirty and re-render the canvas
    element.dirty = true;
    canvasarray[currentcanvasid].renderAll();
    dontLoadFonts.push(fontFamily);
}

function isTextType(object) {
    return ["textbox", "text", "i-text"].includes(object.type);
}

function updateTextObject(textObject) {
    textObject.__lineWidths = [];
    textObject.initDimensions();
}

function resetGroupElement(group) {
    if (!group || group.type !== 'group') {
        return;
    }

    // Restore the state of each object in the group
    group._restoreObjectsState();

    // Reset the transform of the group
    fabric.util.resetObjectTransform(group);

    // Recalculate the bounding box of the group
    group._calcBounds();

    // Update the coordinates of each object within the group
    group._updateObjectsCoords();

    // Set the group's coordinates
    group.setCoords();
}

function IsJsonString(str) {
    if (DEBUG) {
        console.log("MIGRATED:: IsJsonString()");
    }

    try {
        JSON.parse(str);
        return true;
    } catch (e) {
        if (DEBUG) {
            console.log(e);
        }
        return false;
    }
}

function getBg(obj, scaleX) {
    if (DEBUG) {
        console.log("MIGRATED:: getBg()");
        console.log("MIGRATED:: getBg() >> scaleX", scaleX);
    }

    return new Promise((resolve, reject) => {
        if (typeof obj === 'undefined') {
            reject("canvas or object does not exist");
            return;
        }

        window.obj = obj; // Consider avoiding global variables if possible
        const bgSrc = obj.bgsrc;
        const zoom = obj.getZoom() || 1;

        if (bgSrc) {
            loadBackgroundImage(bgSrc, obj, zoom, resolve);
        } else if (obj.backgroundColor) {
            resolve(obj.backgroundColor);
        } else {
            resolve("");
        }
    });
}

function loadBackgroundImage(bgSrc, obj, zoom, resolve) {
    fabric.Image.fromURL(bgSrc, (img) => {
        scaleImageToFitCanvas(img, obj, zoom);
        const pattern = createPatternFromImage(img, obj);
        resolve(pattern);
    }, { crossOrigin: "anonymous" });
}

function scaleImageToFitCanvas(img, obj, zoom) {
    if (img.get("width") > img.get("height")) {
        img.scaleToHeight(obj.get("height") / zoom);
    } else {
        img.scaleToWidth(obj.get("width") / zoom);
    }
}

function createPatternFromImage(img, obj) {
    const patternSourceCanvas = new fabric.StaticCanvas();
    patternSourceCanvas.add(img);
    patternSourceCanvas.renderAll();

    obj.bgImg = img;
    obj.patternSourceCanvas = patternSourceCanvas;

    return new fabric.Pattern({
        source: () => {
            patternSourceCanvas.setDimensions({
                width: img.get("width") * img.get("scaleX"),
                height: img.get("height") * img.get("scaleY")
            });
            patternSourceCanvas.renderAll();
            return patternSourceCanvas.getElement();
        },
        repeat: "repeat"
    });
}

function getFontFilename(fontId) {
    if (DEBUG) {
        console.log("MIGRATED:: getFontFilename()");
    }

    return new Promise((resolve, reject) => {
        const url = `${appUrl}editor/get-woff-font-url?font_id=${fontId}`;

        $.getJSON(url)
            .done((data) => {
                if (data.success) {
                    resolve(data.url);
                } else {
                    if (DEBUG) {
                        console.log("An error occurred while receiving the font filename: " + data.msg);
                    }
                    reject(new Error("Error receiving font filename: " + data.msg));
                }
            })
            .fail(() => {
                reject(new Error("Network error while fetching font filename"));
            });
    });
}

function addFontToFabric(fontId) {
    if (DEBUG) {
        console.log("MIGRATED:: addFontToFabric() >> fontId", fontId);
    }

    if (!fontId) return;

    const path = constructPath();
    getFontFilename(fontId)
        .then((fontFilename) => {
            fabric.fontPaths[fontId] = path + fontFilename;
        })
        .catch((error) => {
            if (DEBUG) {
                console.error("Error loading font: ", error);
            }
        });
}

function constructPath() {
    if (window.location.origin) {
        return window.location.origin;
    }
    return window.location.protocol + "//" + window.location.hostname +
        (window.location.port ? ":" + window.location.port : "");
}

function proceedOpenTemplate(jsonCanvasArray) {

    if (DEBUG) {
        console.log("MIGRATED:: proceedOpenTemplate() json: ", jsonCanvasArray);
    }

    s_history = false;

    for (let i = 0; i < canvasindex; i++) {
        processCanvasTemplate(canvasarray[i], jsonCanvasArray[i + 1], i);
    }

    finalizeTemplateLoading();
    return true;
}


function processCanvasTemplate(canvas, json, i) {
    if (!json) {
        afterLoadJSON(canvas, i);
        return;
    }

    let svgCustomData = [];
    const jsonWithoutSvg = extractJsonWithoutSvg(json);
    setupCanvasBackground(canvas, json, i);
    processCanvasObjects(json.objects, canvas, jsonWithoutSvg, svgCustomData, i);
    savestatecount = 0;
}

function extractJsonWithoutSvg(json) {
    return {
        backgroundImage: json.backgroundImage,
        bgColor: json.background,
        cheight: json.cheight,
        cwidth: json.cwidth,
        objects: []
    };
}

function setupCanvasBackground(canvas, json, index) {
    canvas.clear();
    json.backgroundImage = "";
    const bgSrc = json.bgsrc || "";
    const scale = json.bgScale || 1;

    if (bgSrc) {
        canvas.bgsrc = bgSrc;
        canvas.bgScale = scale;
        $("#bgscale").slider("setValue", 100 * scale);
        setCanvasBg(canvas, bgSrc, "", scale, index, true);
    } else if (json.background && typeof json.background === "string") {
        setCanvasBg(canvas, "", json.background, 1, index);
    }
    $("#bgcolorselect").spectrum("set", canvas.backgroundColor);
}

function processCanvasObjects(objects, canvas, jsonWithoutSvg, svgCustomData, index) {
    objects = objects || [];
    let counter = 0;

    objects.forEach((object, objectIndex) => {
        processObject(object, jsonWithoutSvg, svgCustomData, objectIndex);
        counter++;

        if (counter === objects.length) {
            const jsonString = JSON.stringify(jsonWithoutSvg);
            loadObjectOnCanvasFromJSON(canvas, jsonString, svgCustomData, index);
        }
    });

    if (objects.length === 0 && index + 1 >= canvasindex) {
        afterLoadTemplate();
    }
}

function processObject(object, jsonWithoutSvg, svgCustomData, objectIndex) {
    if (DEBUG) {
        console.log("obj: ", object);
    }

    object.selectable = true;
    object.backgroundColor = "";

    if (object.type === "image" && object.bg) {
        handleImageObject(object, jsonWithoutSvg);
    } else if (object.svg_custom_paths && isSvg(object)) {
        svgCustomData[objectIndex] = object;
    } else {
        jsonWithoutSvg.objects.push(object);
    }
}

function handleImageObject(object, jsonWithoutSvg) {
    jsonWithoutSvg.objects.push(object);
    if (!object.src) {
        object.visible = false;
    }
}

function finalizeTemplateLoading() {
    initKeyboardEvents();
    toggleUIElements();
    setWorkspace();
    updatePageNumbers();
    getBgimages2(0, "");
}

function toggleUIElements() {
    $("#canvaspages .page").length > 1 ? $(".deletecanvas").show() : $(".deletecanvas").hide();
    $("#savetemplate, #saveastemplate, .download-menu").show();
    $("#undo").hide();
    $("#bgscale").slider("setValue", 100 * canvas.bgScale);
    $(".sidebar-elements li:not(#relatedProductsPane) a").removeClass("invisible");
    canvasindex > 10 ? $(".download-jpeg-menu-item").hide() : $(".download-jpeg-menu-item").show();
}

function getGradientTypeofObject(object) {
    if (DEBUG) {
        console.log("MIGRATED:: getGradientTypeofObject()");
    }

    if (!object || !isObjectGradient(object.fill)) {
        return false;
    }

    return determineGradientDirection(object.fill);
}

function isObjectGradient(fill) {
    return fill instanceof fabric.Gradient;
}

function determineGradientDirection(gradient) {
    const coords = gradient.coords;

    if (coords.x2 !== 0 && coords.y2 !== 0) {
        return "linear-gradient-d-fill";
    }
    if (coords.x2 !== 0) {
        return "linear-gradient-h-fill";
    }
    if (coords.y2 !== 0) {
        return "linear-gradient-v-fill";
    }
    if (typeof coords.r1 !== 'undefined') {
        return "radial-gradient-fill";
    }

    return false;
}

function setDemoOverlay() {
    // If DEBUG is true, log that this function has been called
    if (DEBUG) {
        console.log("demo>>" + demo_as_id);
        console.log("MIGRATED:: setDemoOverlay()");
    }

    // Retrieve the current scale value from an element with ID 'zoomperc'
    scale = $("#zoomperc").data("scaleValue");
    // Define the URI for the overlay image
    const uri = appUrl + "assets/img/demo_overlay.svg";

    // Load the image from the URI
    fabric.Image.fromURL(uri, function (img) {
        // Configure the image properties: scale, angle, and position
        img.scaleToWidth(70 * scale);
        img.angle = 315;
        img.top = 50 * scale;
        img.left = 20 * scale;

        // Create a new Fabric static canvas and add the image to it
        patternSourceCanvas = new fabric.StaticCanvas();
        patternSourceCanvas.add(img);

        // Create a new pattern using the static canvas as the source
        const pattern = new fabric.Pattern({
            source: function () {
                // Set the dimensions of the pattern source canvas
                patternSourceCanvas.setDimensions({
                    width: 80 * scale,
                    height: 80 * scale
                });
                // Render the canvas to update the visual display
                patternSourceCanvas.renderAll();
                // Return the HTML canvas element of the pattern source canvas
                return patternSourceCanvas.getElement();
            },
            repeat: "repeat"
        });

        // Iterate over each canvas in the canvasarray
        for (let n = 0; n < canvasarray.length; n++) {
            // If the canvas container is visible, set the overlay pattern
            if ($("#divcanvas" + n).is(":visible")) {
                canvasarray[n].setOverlayColor(pattern, function () {
                    // Re-render the canvas to display the updated overlay
                    canvasarray[n].renderAll();
                });
            }
        }
    });
}

function processSVGs(disablespinner) {
    // Logging function call if DEBUG is true
    if (DEBUG) {
        console.log("MIGRATED:: processSVGs()");
    }

    // Reset counters; assuming totalsvgs and convertedsvgs are used globally
    totalsvgs = 0;
    convertedsvgs = 0;

    // Hide publish and PDF download modals
    $("#publishModal").modal("hide");
    $("#pdfdownloadModal").modal("hide");

    // Show spinner unless explicitly disabled
    if (!disablespinner) {
        appSpinner.show();
    }

    // Process document download if applicable
    if (isdownloadpdf) {
        downloadDocument();
    }

    // Save as template if applicable
    if (issaveastemplate) {
        saveAsTemplateFile();
    }

    // Update template if applicable
    if (isupdatetemplate) {
        updateTemplate();
    }
}

function selectCanvas(id) {
    // Logging if DEBUG is true
    if (DEBUG) {
        console.log("MIGRATED:: selectCanvas()");
    }

    // Remove 'divcanvas' prefix from id and convert to integer
    id = parseInt(id.replace("divcanvas", ""));

    if (currentcanvasid !== id) {
        // Deselect any active object in the current canvas
        canvas.discardActiveObject().renderAll();

        // Remove box shadow from all canvases
        for (let i = 0; i < canvasindex; i++) {
            $("#canvas" + i).css("box-shadow", "");
        }

        // Add box shadow to selected canvas if conditions are met
        if (template_type !== "geofilter" && template_type !== "geofilter2") {
            $("#canvas" + id).css("box-shadow", "0px 0px 10px #888888");
        }

        // Update current canvas if different from the selected one
        if (currentcanvasid !== id) {
            currentcanvasid = id;
            const selectedCanvas = canvasarray[id];

            // Update the global canvas reference if selected canvas is valid
            if (selectedCanvas) {
                canvas = selectedCanvas;

                // Set active object if any
                const activeObject = canvas.getActiveObject();
                if (activeObject) {
                    canvas.setActiveObject(activeObject);
                }
            }

            // Remove non-selectable text objects
            removeNonSelectableTextObjects(canvas);

            // Update background scale and color UI elements
            updateBackgroundUI(canvas);
        }
    }
}

function removeNonSelectableTextObjects(canvas) {
    for (let i = canvas._objects.length; i--;) {
        const object = canvas._objects[i];
        if (object.type === "text" && !object.selectable) {
            canvas.remove(object);
        }
    }
}

function updateBackgroundUI(canvas) {
    $("#bgscale").slider("setValue", 100 * canvas.bgScale);
    canvas.renderAll();
    const bgColor = canvas.backgroundColor || "";
    $("#bgcolorselect").spectrum("set", bgColor);
}

function setZoom(newZoomLevel) {
    if (DEBUG) {
        console.log("MIGRATED:: setZoom()");
    }

    // Calculate and normalize the new zoom level
    newZoomLevel = calculateZoomLevel(newZoomLevel);

    // Adjust UI for specific template types
    if (isGeoFilterTemplate(template_type)) {
        adjustGeoFilterUI(newZoomLevel);
    }

    // Adjust canvas size and zoom level for all visible canvases
    adjustCanvasesZoomAndSize(newZoomLevel);

    // Update zoom percentage display and demo overlay if applicable
    updateZoomDisplay(newZoomLevel);
    if (demo_as_id > 0 && !isGeoFilterTemplate(template_type)) {
        setDemoOverlay();
    }
}

function calculateZoomLevel(zoomLevel) {
    if (zoomLevel === undefined) {
        zoomLevel = parseFloat(jQuery("#zoomperc").data("scaleValue")) || 1;
    }
    if (zoomLevel < 0.2) {
        zoomLevel = 0.1;
    }
    if (isGeoFilterTemplate(template_type)) {
        return zoomLevel > 1 ? 1 : zoomLevel;
    }
    return zoomLevel;
}

function isGeoFilterTemplate(templateType) {
    return templateType === "geofilter" || templateType === "geofilter2";
}

function adjustGeoFilterUI(zoomLevel) {
    const marginLeft = $("#phone").width() / 2 * zoomLevel - 1.5;
    const top = (template_type === "geofilter2" ? -63 : -260) * zoomLevel + 63;
    $("#phone").css({
        transform: `scale(${zoomLevel})`,
        marginLeft: `-${marginLeft}px`,
        top: `${top}px`
    });

    const borderRadius = template_type === "geofilter2" ? 100 * zoomLevel : 5;
    setTimeout(() => {
        $(".canvas-background").css("border-radius", `${borderRadius}px`);
    }, 0);
}

function adjustCanvasesZoomAndSize(zoomLevel) {
    const newWidth = 96 * document.getElementById("loadCanvasWid").value * zoomLevel;
    const newHeight = 96 * document.getElementById("loadCanvasHei").value * zoomLevel;

    setCanvasWidthHeight(newWidth, newHeight);

    canvasarray.forEach((canvas, index) => {
        if ($("#divcanvas" + index).is(":visible")) {
            adjustCanvasZoomAndSize(canvas, index, zoomLevel, newWidth, newHeight);
        }
    });
}

function adjustCanvasZoomAndSize(canvas, index, zoomLevel, width, height) {
    canvas.setZoom(zoomLevel);
    canvas.setDimensions({ width: width, height: height });
    if (canvas.bgImg) {
        canvas.bgImg.scale(canvas.bgScale * zoomLevel / 3.125 / fabric.devicePixelRatio);
    }
    canvas.renderAll();
    adjustIconPos(index);
}

function updateZoomDisplay(zoomLevel) {
    $("#zoomperc").html(`${Math.round(100 * zoomLevel)}%`).data("scaleValue", zoomLevel);
}

function setCanvasWidthHeight(width, height) {
    if (DEBUG) {
        console.log("MIGRATED:: setCanvasWidthHeight()");
    }

    if (width) {
        updateCanvasDimensions("width", width);
    }
    if (height) {
        updateCanvasDimensions("height", height);
    }

    updateCanvasSizeInputs(width, height);
}

function updateCanvasDimensions(dimension, value) {
    for (let i = 0; i <= canvasindex; i++) {
        if (canvasarray[i]) {
            setCanvasDimension(canvasarray[i], dimension, value);
            updateDOMElementDimensions(i, dimension, value);
        }
    }
}

function setCanvasDimension(canvas, dimension, value) {
    canvas[dimension] = value;
    canvas.calcOffset();
    canvas.renderAll();
    canvas.setDimensions();
}

function updateDOMElementDimensions(index, dimension, value) {
    const dimensionValue = `${value}px`;
    const elementsToUpdate = [
        document.getElementById("canvas" + index),
        document.getElementsByClassName("upper-canvas")[index],
        document.getElementsByClassName("canvas-container")[index],
        document.getElementsByClassName("canvascontent")[index],
        document.getElementById("divcanvas" + index)
    ];

    elementsToUpdate.forEach(elem => {
        if (elem) {
            elem.style[dimension] = dimensionValue;
            elem[dimension] = value;
        }
    });
}

function updateCanvasSizeInputs(width, height) {
    $("#canvaswidth").val(Math.round(width));
    $("#canvasheight").val(Math.round(height));
}

function addCanvasToPage(dupflag, pageid, jsonarray) {
    if (DEBUG) {
        console.log("MIGRATED:: addCanvasToPage()");
    }

    s_history = false;
    const rows = parseInt(document.getElementById("numOfcanvasrows").value, 10);
    const cols = parseInt(document.getElementById("numOfcanvascols").value, 10);

    $(".deletecanvas").css("display", "block");

    const rc = rows * cols * parseInt(pageid, 10);
    let dupcount = 0;

    createCanvasTable();

    for (let i = 1; i <= rows; i++) {
        addCanvasRow(i, cols, rc, dupflag, dupcount);
    }

    updateAllCanvasDimensions();
    addPageIcons();
    applyTemplateSpecificAdjustments();
    updateUIElements();

    s_history = true;
}

function createCanvasTable() {
    $("#page" + pageindex).append("<table></table>");
}

function addCanvasRow(rowNumber, cols, rc, dupflag, dupcount) {
    const rowElement = $('<tr id="row' + rowNumber + '"></tr>');
    $("#page" + pageindex).find("table").last().append(rowElement);

    for (let j = 1; j <= cols; j++) {
        addNewCanvas(rowNumber);

        if (dupflag) {
            duplicateCanvas(rc + dupcount, currentcanvasid);
            (dupcount)++;
        }
    }
}

function duplicateCanvas(srcCanvasId, destCanvasId) {
    const currentCanvasJson = canvasarray[srcCanvasId].toDatalessJSON(properties_to_save);
    canvas.loadFromJSON(currentCanvasJson, function () {
        setTimeout(function () {
            canvasarray[srcCanvasId].forEachObject(function (obj, index) {
                if (obj.type === "group") {
                    normalizeSvgScale(obj, canvasarray[destCanvasId]._objects[index]);
                }
            });
        }, 10);
    });
}

function updateAllCanvasDimensions() {
    for (let i = 0; canvasarray[i]; i++) {
        canvasarray[i].setDimensions();
        canvasarray[i].renderAll();
    }
}

function addPageIcons() {
    // Clone and append the page number icon
    const pageNumberIcon = $("#pagenumber").clone(true).prop("id", "pagenumber" + pageindex);
    pageNumberIcon.appendTo("#page" + pageindex);

    // Clone and append the duplicate canvas icon
    const duplicateCanvasIcon = $("#duplicatecanvas").clone(true).prop("id", "duplicatecanvas" + pageindex);
    duplicateCanvasIcon.appendTo("#page" + pageindex);

    // Clone and append the delete canvas icon
    const deleteCanvasIcon = $("#deletecanvas").clone(true).prop("id", "deletecanvas" + pageindex);
    deleteCanvasIcon.appendTo("#page" + pageindex);
}

function applyTemplateSpecificAdjustments() {
    // Check if the current template is 'geofilter' or 'geofilter2'
    if (template_type === "geofilter" || template_type === "geofilter2") {
        // Clone and append the left and right arrow icons
        const arrowLeft = $(".background-arrow-right").clone(true);
        const arrowRight = $(".background-arrow-left").clone(true);

        arrowLeft.appendTo("#page" + pageindex);
        arrowRight.appendTo("#page" + pageindex);
    }

    // Additional template-specific adjustments can be added here if needed
}

function updateUIElements() {
    // Iterate over all visible pages and adjust their icon positions
    $(".page:visible").each(function () {
        const pageId = $(this).prop("id").replace("page", "");
        adjustIconPos(pageId);
    });

    // Show or hide various UI elements
    $("#addnewpagebutton, #saveimage, #savetemplate, .download-menu, .download-dropdown, .zoom-control, #options").show();
    $("#choose-img").hide();

    // Update visibility of sidebar elements
    $(".sidebar-elements li:not(#relatedProductsPane) a").removeClass("invisible");

    // Conditional visibility of the JPEG download menu item
    if (canvasindex > 10) {
        $(".download-jpeg-menu-item").hide();
    } else {
        $(".download-jpeg-menu-item").show();
    }

    // Update page numbers, set demo overlay, and apply geofilter overlay if applicable
    updatePageNumbers();

    if (demo_as_id > 0 && template_type !== "geofilter" && template_type !== "geofilter2") {
        setDemoOverlay();
    }

    if (template_type === "geofilter2") {
        setGeofilterOverlay();
    }
}

function adjustIconPos(id) {
    if (DEBUG) {
        console.log("MIGRATED:: adjustIconPos()");
    }

    const pageTable = $("#page" + id).find("table");
    if (pageTable.length) {
        const position = pageTable.position();
        const width = pageTable.outerWidth();
        let topPosition = (pageTable.outerHeight() / 2 || 0) - 20;

        if (isGeoFilterTemplate()) {
            adjustArrowIcons(position, width, topPosition);
        }

        adjustPageNumberIcon(id, position, width, topPosition);

        if (isDoubleSidedTemplate()) {
            topPosition += 25;
            adjustDuplicateCanvasIcon(id, position, width, topPosition);
        }

        adjustDeleteCanvasIcon(id, position, width, topPosition);
        hideDeleteCanvasIfSinglePageVisible();
    }
}

function isGeoFilterTemplate() {
    return template_type === "geofilter" || template_type === "geofilter2";
}

function adjustArrowIcons(position, width, top) {
    $(".background-arrow-right").css({
        position: "absolute",
        top: top - 15 + "px",
        left: position.left + width + 60 + "px"
    }).show();

    $(".background-arrow-left").css({
        position: "absolute",
        top: top - 15 + "px",
        left: position.left - 127 + "px"
    }).show();
}

function adjustPageNumberIcon(id, position, width, top) {
    $("#pagenumber" + id).css({
        position: "absolute",
        top: top + "px",
        left: position.left + width + 30 + "px"
    }).show();
}

function isDoubleSidedTemplate() {
    return template_type === "doublesided" && $(".divcanvas:visible").length === 2;
}

function adjustDuplicateCanvasIcon(id, position, width, top) {
    $("#duplicatecanvas" + id).css({
        position: "absolute",
        top: top + "px",
        left: position.left + width + 10 + "px"
    }).show();
}

function adjustDeleteCanvasIcon(id, position, width, top) {
    $("#deletecanvas" + id).css({
        position: "absolute",
        top: top + "px",
        left: position.left + width + 10 + "px"
    }).show();
}

function hideDeleteCanvasIfSinglePageVisible() {
    if ($(".page:visible").length === 1) {
        $(".deletecanvas").css("display", "none");
    }
}

function afterLoadJSON(canvas, index) {

    if (DEBUG) {
        console.log("MIGRATED:: afterLoadJSON()");
    }

    // Set option to render on add/remove objects
    canvas.renderOnAddRemove = true;

    // Remove old background objects
    removeOldBackgroundObjects(canvas);

    // Standardize text object origins
    standardizeTextObjectOrigins(canvas);

    // Remove images with missing data
    removeInvalidImages(canvas);

    // Set canvas dimensions
    setCanvasDimensions(canvas);

    // Render canvas
    renderCanvas(canvas);

    // Check if last template and call next function
    if (canvasarray.length === index + 1) {
        afterLoadTemplate();
    }

    // Update template load status
    $('#template-status').val('Template Loaded');

}

function removeOldBackgroundObjects(canvas) {
    for (let i = canvas._objects.length; i--;) {
        if (canvas._objects[i].bg) {
            canvas.remove(canvas._objects[i]);
        }
    }
}

function standardizeTextObjectOrigins(canvas) {
    for (let i = 0; i < canvas._objects.length; i++) {
        if (/text/.test(canvas._objects[i].type)) {
            standardizeTextObject(canvas._objects[i]);
        }
    }
}

function standardizeTextObject(textObject) {
    if (textObject.originY !== "top" || textObject.originX !== "center") {
        const centerTopPoint = textObject.getPointByOrigin("center", "top");
        textObject.set({
            originX: "center",
            originY: "top",
            left: centerTopPoint.x,
            top: centerTopPoint.y
        });
        textObject.setCoords();
    }
}

function removeInvalidImages(canvas) {
    for (let i = canvas._objects.length; i--;) {
        if (canvas._objects[i].type === "image"
            && (!canvas._objects[i].width
                || !canvas._objects[i].height
                || !canvas._objects[i].src)) {
            canvas.remove(canvas._objects[i]);
        }
    }
}

function setCanvasDimensions(canvas) {
    canvas.setDimensions();
}

function renderCanvas(canvas) {
    canvas.renderAll();
}

function afterLoadTemplate() {
    if (DEBUG) {
        console.log("MIGRATED:: afterLoadTemplate()");
    }

    Promise.all([backgroundPromise]).then(function () {
        performPostLoadActions();
    });
}

function performPostLoadActions() {
    saveHistoryForAllCanvases();
    selectCanvas("divcanvas0");

    if (!isGeofilterTemplate()) {
        handleNonGeofilterTemplateActions();
    }

    if (isGeofilter2Template()) {
        setGeofilterOverlay();
    }

    if (shouldHideSpinner()) {
        appSpinner.hide();
    } else if (shouldConvertToNewPxFormat()) {
        convertToNewPxFormat();
    }

    setWorkspace();
}

function isGeofilterTemplate() {
    return template_type === "geofilter" || template_type === "geofilter2";
}

function isGeofilter2Template() {
    return template_type === "geofilter2";
}

function handleNonGeofilterTemplateActions() {
    if (templateOptions.metrics === "px") {
        setZoom(1);
    }
    autoZoom();

    if (demo_as_id > 0) {
        setDemoOverlay();
    }
}

function shouldHideSpinner() {
    return isGeofilterTemplate() || (templateOptions.scriptVersion && templateOptions.scriptVersion >= 4) || (templateOptions.metrics !== "px" && !demo_as_id);
}

function shouldConvertToNewPxFormat() {
    return !isGeofilterTemplate() && (!templateOptions.scriptVersion || templateOptions.scriptVersion < 4) && templateOptions.metrics === "px" && !demo_as_id;
}

function addNewCanvas(rowId) {
    if (DEBUG) {
        console.log("MIGRATED:: addNewCanvas()");
    }

    // Reset state count
    savestatecount = 0;

    // Add new canvas element to the page
    createCanvasElement(rowId);

    // Initialize new Fabric canvas
    initializeFabricCanvas();

    // Set canvas properties
    setCanvasProperties();

    // Add canvas to global array and perform initial setup
    canvasarray.push(canvas);
    setInitialCanvasSetup();

    // Update current canvas ID and increment canvas index
    currentcanvasid = canvasindex;
    canvasindex++;

    // Save initial canvas state and reset background color selection
    save_history();
    $("#bgcolorselect").spectrum("set", "");
}

function createCanvasElement(rowId) {
    const canvasId = "canvas" + canvasindex;
    const divId = "divcanvas" + canvasindex;
    const tdHTML = `<td align='center' id='${divId}' class='divcanvas'>
                        <div class='canvascontent'>
                            <canvas id='${canvasId}' class='canvas'></canvas>
                        </div>
                    </td>`;
    $("#page" + pageindex).find("tr#row" + rowId).append(tdHTML);
    $("#" + divId).on("mousedown click contextmenu", function () {
        selectCanvas(this.id);
    });
}

function initializeFabricCanvas() {
    const canvasId = "canvas" + canvasindex;
    canvas = new fabric.Canvas(canvasId, {
        enableRetinaScaling: true
    });
    canvas.index = 0;
    canvas.state = [];
    canvas.rotationCursor = 'url("/design/assets/img/rotatecursor2.png") 10 10, crosshair';
}

function setCanvasProperties() {
    canvas.backgroundColor = "";
    canvas.selectionColor = "rgba(255,255,255,0.3)";
    canvas.selectionBorderColor = "rgba(0,0,0,0.1)";
    canvas.hoverCursor = "pointer";
    canvas.perPixelTargetFind = true;
    canvas.preserveObjectStacking = true;
    canvas.targetFindTolerance = 10;
}

function setInitialCanvasSetup() {
    setCanvasZoom(canvasarray.length - 1);
    initCanvasEvents(canvas);
    initAligningGuidelines(canvas);
    initCenteringGuidelines(canvas);
    initKeyboardEvents();
    canvas.calcOffset();
    canvas.renderAll();
}

function setCanvasZoom(canvasId) {

    if (DEBUG) {
        console.log("MIGRATED:: setCanvasZoom()");
    }

    const templateTypes = ['geofilter', 'geofilter2'];

    // Get input values
    const newZoomLevel = parseFloat($("#zoomperc").data("scaleValue")) || 1;
    const canvasWidth = 96 * document.getElementById("loadCanvasWid").value;
    const canvasHeight = 96 * document.getElementById("loadCanvasHei").value;

    // Limit zoom for template types
    if (templateTypes.includes(template_type)) {
        newZoomLevel = Math.max(Math.min(newZoomLevel, 1), 0.1);
    }

    // Adjust canvas and related elements
    adjustCanvasZoom(canvasId, newZoomLevel, canvasWidth, canvasHeight);

    // Adjust phone position
    adjustPhoneZoom(newZoomLevel);

    // Update zoom display
    $("#zoomperc").html(Math.round(100 * newZoomLevel) + "%").data("scaleValue", newZoomLevel);


}
function adjustCanvasZoom(canvasId, zoom, width, height) {

    // Canvas objects
    let canvas = canvasarray[canvasId];
    let canvasDOM = document.getElementById(`canvas${canvasId}`);
    let upperCanvas = document.getElementsByClassName("upper-canvas")[canvasId];

    // Set dimensions
    canvas.width = width;
    canvas.height = height;

    // Scale elements
    scaleElement(canvasDOM, zoom, width, height);
    scaleElement(upperCanvas, zoom, width, height);

    // Other elements
    scaleOtherElements(canvasId, zoom, width, height);

    // Adjust canvas
    canvas.setZoom(zoom);
    canvas.setDimensions({ width, height });
    canvas.calcOffset();
    canvas.renderAll();
}

function scaleElement(el, zoom, width, height) {
    el.style.width = `${width / zoom}px`;
    el.width = width;
    el.style.height = `${height / zoom}px`;
    el.height = height;
}

function scaleOtherElements(canvasId, zoom, width, height) {
    // Scales other elements related to canvas
    const elems = [
        'canvas-container',
        'canvascontent',
        'divcanvas',
        // `divcanvas${canvasId}`
    ];

    elems.forEach(selector => {
        const elem = document.getElementsByClassName(selector)[canvasId];
        scaleElement(elem, zoom, width, height);
    });
}

function adjustPhoneZoom(zoom) {
    // Adjust phone size and position
    const topOffset = template_type === 'geofilter2' ? -63 : -260;
    const top = (topOffset * zoom) + 63;
    const margin = $("#phone").width() / 2 * zoom - 1.5;

    $("#phone").css({
        transform: `scale(${zoom})`,
        marginLeft: `-${margin}px`,
        top: `${top}px`
    });

    // Adjust background radius
    const radius = template_type === 'geofilter2' ? 100 * zoom : 5;
    setTimeout(() => {
        $(".canvas-background").css("border-radius", `${radius}px`);
    }, 0);
}

function setCanvasBg(canvas, bgsrc, bgcolor, scalex, id, setZoom) {
    if (DEBUG) {
        console.log("MIGRATED:: setCanvasBg()");
    }

    backgroundPromise = createBackgroundPromise(canvas, bgsrc, bgcolor, scalex, setZoom);
}

function createBackgroundPromise(canvas, bgsrc, bgcolor, scalex, setZoom) {
    return new Promise(function(resolve, reject) {
        if (!scalex) {
            $("#bgscale").val(100);
            scalex = 0.32 / fabric.devicePixelRatio;
        }

        if (bgcolor) {
            applyBackgroundColor(canvas, bgcolor, resolve);
        } else if (bgsrc) {
            prepareAndApplyBackgroundImage(canvas, bgsrc, scalex, setZoom, resolve, reject);
        } else {
            resolve();
        }
    });
}

function applyBackgroundColor(canvas, bgcolor, resolve) {
    $("#bgcolorselect").spectrum("set", bgcolor);
    canvas.backgroundImage = "";
    canvas.bgsrc = "";

    canvas.setBackgroundColor(bgcolor, function() {
        canvas.renderAll();
        resolve();
    });
}

function prepareAndApplyBackgroundImage(canvas, bgsrc, scalex, setZoom, resolve, reject) {
    $("#bgcolorselect").spectrum("set", "");
    canvas.bgsrc = bgsrc;
    canvas.bgScale = scalex;

    const scale = parseFloat($("#zoomperc").data("scaleValue"));

    getBg(canvas, scalex * scale).then(function(bgImage) {
        applyBackgroundImage(canvas, bgImage, scalex, scale, setZoom, resolve);
    }).catch(function(error) {
        console.log(error);
        reject(error);
    });

    save_history();
}

function applyBackgroundImage(canvas, bgImage, scalex, scale, setZoom, resolve) {
    canvas.setBackgroundColor(bgImage, function() {
        if (canvas.bgImg) {
            const scaleFactor = scalex * scale / 3.125 / fabric.devicePixelRatio;
            canvas.bgImg.scale(scaleFactor);

            if (setZoom) {
                autoZoom();
            }
        }

        canvas.renderAll();
        resolve();
    });
}

function updatePageNumbers() {
    if (DEBUG) {
        console.log("MIGRATED:: updatePageNumbers()");
    }

    if (isDoubleSidedTemplateType()) {
        updateForDoubleSidedTemplate();
    } else {
        updateForSingleOrMultiplePages();
    }
}

function isDoubleSidedTemplateType() {
    return template_type === "doublesided";
}

function updateForDoubleSidedTemplate() {
    $(".pagenumber").css("visibility", "visible");
    $(".pagenumber:visible").each(function(index) {
        $(this).text(["Front", "Back"][index]);
    });
}

function updateForSingleOrMultiplePages() {
    const visiblePageNumbers = $(".pagenumber:visible");
    if (visiblePageNumbers.length > 1) {
        visiblePageNumbers.each(function(index) {
            $(this).text(index + 1);
        });
        $(".pagenumber").css("visibility", "visible");
    } else {
        $(".pagenumber").css("visibility", "hidden");
    }
}

function autoZoom() {
    if (DEBUG) {
        console.log("MIGRATED:: autoZoom()");
    }

    const canvasBoxHeight = $("#page0").height();
    const canvasBoxWidth = $("#page0").width();
    const windowHeight = $(window).height();
    const windowWidth = $(window).width();
    const sidebarWidth = $(".am-left-sidebar").width();

    calculateAndSetZoom(canvasBoxHeight, canvasBoxWidth, windowHeight, windowWidth, sidebarWidth);
}

function calculateAndSetZoom(canvasBoxHeight, canvasBoxWidth, windowHeight, windowWidth, sidebarWidth) {
    const maxWidth = windowWidth - sidebarWidth;
    const maxHeight = windowHeight - 60; // Considering additional UI elements height

    if (canvasBoxWidth < maxWidth && canvasBoxHeight < maxHeight) {
        setZoom(1);
    } else if (canvasBoxWidth > maxWidth) {
        setZoomToFitWidth(canvasBoxWidth, maxWidth);
    } else if (canvasBoxHeight > maxHeight) {
        setZoomToFitHeight(canvasBoxHeight, maxHeight);
    }
}

function setZoomToFitWidth(canvasWidth, maxWidth) {
    const zoomLevel = 1 / (canvasWidth / maxWidth - 300);
    setZoom(zoomLevel);
}

function setZoomToFitHeight(canvasHeight, maxHeight) {
    const zoomLevel = 1 / (canvasHeight / maxHeight);
    setZoom(zoomLevel);
}

function setCanvasSize() {
    if (DEBUG) {
        console.log("MIGRATED:: setCanvasSize()");
    }

    const canvasWidthInput = document.getElementById("loadCanvasWid").value;
    const canvasHeightInput = document.getElementById("loadCanvasHei").value;

    applyCanvasDimensions(canvasWidthInput, canvasHeightInput);
    adjustIconsAfterResizing();
    hideCanvasSizeModal();
}

function hideCanvasSizeModal() {
    $("#canvaswh_modal").modal("hide");
}

function applyCanvasDimensions(widthInput, heightInput) {
    const widthInPixels = widthInput * 96;
    const heightInPixels = heightInput * 96;
    setCanvasWidthHeight(widthInPixels, heightInPixels);
}

function adjustIconsAfterResizing() {
    adjustIconPos(pageindex);
    $(".deletecanvas").css("display", "none");
}

function saveHistoryForAllCanvases() {
    if (DEBUG) {
        console.log("MIGRATED:: saveHistoryForAllCanvases()");
    }

    setSavingHistoryState(true);
    performAutoZoom();

    for (const currentCanvas of canvasarray) {
        saveHistoryForCanvas(currentCanvas);
    }

    updateUIAfterSavingHistory();
}

function setSavingHistoryState(state) {
    s_history = state;
}

function performAutoZoom() {
    autoZoom();
}

function saveHistoryForCanvas(canvas) {
    canvas = canvas; // Ensure the global canvas is updated
    save_history(1); // Assuming save_history is another function that handles history saving
}

function updateUIAfterSavingHistory() {
    $("#undo").hide();
    $("#autosave").data("saved", "yes");
}

function setWorkspace() {
    if (DEBUG) {
        console.log("MIGRATED:: setWorkspace()");
    }

    // Modularized actions
    function showElement(selector) {
        $(selector).show();
    }

    function hideElement(selector) {
        $(selector).hide();
    }

    function setVisibility(selector, visibility) {
        $(selector).css("visibility", visibility);
    }

    function updateButtonText(selector, text) {
        $(selector).text(text);
    }

    function toggleElementsForTemplate(templateType) {
        switch (templateType) {
            case "custom":
                showElement("#addrow, #deleterow, #addcolumn, #deletecolumn");
                break;
            case "doublesided":
                updateButtonText("#addnewpagebutton", " + Add a Back Side");
                if ($(".divcanvas:visible").length === 2) {
                    hideElement("#addnewpagebutton");
                    setVisibility(".duplicatecanvas", "hidden");
                }
                break;
            case "geofilter":
            case "geofilter2":
                setGeofilterLayout();
                break;
            case "product_image":
                setProductImageLayout();
                break;
        }
    }

    function setGeofilterLayout() {
        hideElement("#addnewpagebutton, #downloadPDF, #downloadJPEG, .bgPane, .duplicatecanvas, #options");
        showElement("#convertGeofilterToNewSize, #background, #phone, .background-arrow");
        $("#canvas0").addClass("canvas-background");
        setGeofilterBackground(geofilterBackground);
    }

    function setProductImageLayout() {
        hideElement("#addnewpagebutton, .download-menu, .duplicatecanvas");
        showElement("#productImageDownload");
    }

    function toggleConversionButtons() {
        const isVisible = $(".divcanvas:visible").length <= 2;
        const isSingleOrCustom = template_type === "single" || (template_type === "custom" && $("#numOfcanvasrows").val() === "1" && $("#numOfcanvascols").val() === "1");
        if (isVisible && isSingleOrCustom) {
            showElement("#convertToDoublesided");
        } else if (template_type === "doublesided") {
            showElement("#convertToSingle");
        }
    }

    function managePageLimits() {
        // If current template has more than 36 pages, hide the add new page button
        const pageLimitReached = $(".pagenumber:visible").length >= 36;
        if (pageLimitReached || (canvasarray[0].cwidth / 96 * (canvasarray[0].cheight / 96) > 100)) {
            setVisibility(".duplicatecanvas", "hidden");
            showElement("#addnewpagebutton, #pageLimitMessage");
        } else {
            setVisibility(".duplicatecanvas", "visible");
            hideElement("#addnewpagebutton, #pageLimitMessage");
        }
    }

    // Main logic
    showElement("#addnewpagebutton, #options");
    hideElement("#background, #phone, .background-arrow, #convertToDoublesided, #convertToSingle, #convertGeofilterToNewSize, #addrow, #deleterow, #addcolumn, #deletecolumn");

    toggleElementsForTemplate(template_type);
    toggleConversionButtons();
    managePageLimits();

    setTimeout(checkDpatterns, 100);
}

function getTemplateJson() {
    logDebug("MIGRATED:: getTemplateJson");

    let jsonCanvasArray = [];
    const templateDimensions = getTemplateDimensions();
    jsonCanvasArray.push(templateDimensions);

    logDebug(`Canvas Index: ${canvasindex}`);
    logDebug(`Initial JSON Canvas Array: ${jsonCanvasArray}`);

    for (let i = 0; i < canvasindex; i++) {
        if (canvasarray[i]) {
            processObjectCanvas(canvasarray[i], jsonCanvasArray, i);
        }
    }
    return formatFinalJson(jsonCanvasArray);
}

function getTemplateDimensions() {
    const width = (96 * parseFloat(document.getElementById("loadCanvasWid").value)).toFixed(2);
    const height = (96 * parseFloat(document.getElementById("loadCanvasHei").value)).toFixed(2);
    const rows = document.getElementById("numOfcanvasrows").value;
    const cols = document.getElementById("numOfcanvascols").value;

    return `{"width": ${width}, "height": ${height}, "rows": ${rows}, "cols": ${cols}}`;
}

function processObjectCanvas(canvas, jsonCanvasArray, index) {
    const tempData = JSON.parse(JSON.stringify(canvas.toDatalessJSON(properties_to_save)));

    tempData.objects.forEach((object, objectIndex) => {
        logDebug(`Processing object ${objectIndex}:`, object);
        processObjectObject(object);
    });

    canvas.discardActiveObject().renderAll();

    if ($("#divcanvas" + index).is(":visible")) {
        jsonCanvasArray.push(tempData);
    }
}

function processObjectObject(object) {
    if (isSvgObject(object)) {
        processSvgObject(object);
    }

    resetObjectPaths(object);
    removeDpatternSource(object);
}

function isSvgObject(object) {
    return object.type === 'path' && object.fill && object.svg_custom_paths;
}

function processSvgObject(object) {
    if (object.objects && $useKeepSvgGroups) {
        object.objects.forEach(child => {
            if (child.svg_custom_paths && child.svg_custom_paths.length) {
                object.svg_custom_paths = object.svg_custom_paths || [];
                object.svg_custom_paths = {
                    svg_custom_paths: child.svg_custom_paths
                };
            }
        });
    }
}

function resetObjectPaths(object) {
    if (object.type === 'path' && object.svg_custom_paths && object.svg_custom_paths.length === 1) {
        delete object.svg_custom_paths;
    }

    object.path = [];
    object.objects = [];
    if (object._objects !== undefined) {
        object._objects = [];
    }
}

function removeDpatternSource(object) {
    if (typeof object.fill === 'object' && object.fill.type === 'Dpattern') {
        delete object.fill.source;
    }

    if (object.objects) {
        object.objects.forEach(child => removeDpatternSource(child));
    }
}

function formatFinalJson(jsonCanvasArray) {
    return JSON.stringify(jsonCanvasArray).replace(/"backgroundImage":{.*?}/gi, '"backgroundImage":""');
}

/**
 * Initiates the process to save the template.
 */
function proceed_savetemplate() {
    logDebug("Entering proceed_savetemplate");

    if (isSaveTemplateModalVisible()) {
        handleVisibleSaveTemplateModal();
    } else {
        handleTemplateProcessing();
    }
}

/**
 * Checks if the save template modal is visible.
 * @returns {boolean} - True if the modal is visible, otherwise false.
 */
function isSaveTemplateModalVisible() {
    return $("#savetemplate_modal").is(":visible");
}

/**
 * Handles the scenario when the save template modal is visible.
 */
function handleVisibleSaveTemplateModal() {
    if (!newTemplateTagsEdit.validate()) { // Assumes 'newTemplateTagsEdit' is an object with a validate method
        logDebug("Validation failed");
        // You might want to handle the validation failure here (e.g., show an error message to the user)
    } else {
        handleTemplateProcessing();
    }
}

/**
 * Handles the processing of the template.
 */
function handleTemplateProcessing() {
    $("#savetemplate_modal").modal("hide");
    appSpinner.show(); // Assumes 'appSpinner' is an object with a show method
    $("#saveastemplate").show();
    canvas.discardActiveObject().renderAll(); // Assumes 'canvas' is a globally accessible fabric.js canvas instance
    processSVGs(); // Assumes 'processSVGs' is a function defined elsewhere
}


/**
 * Generates a thumbnail for the current template.
 * @returns {string} - The data URL of the generated thumbnail.
 */
function getTemplateThumbnail() {
    logDebug("Entering getTemplateThumbnail");

    const firstCanvas = getFirstCanvas();
    const initialZoom = getInitialZoom(firstCanvas);
    const isEmptyBackground = checkIfBackgroundIsEmpty(firstCanvas);

    prepareCanvasForThumbnail(firstCanvas, isEmptyBackground);
    const dataURL = generateThumbnailDataURL(firstCanvas);
    restoreCanvasState(firstCanvas, initialZoom, isEmptyBackground);

    return dataURL;
}

/**
 * Logs a message to the console if in DEBUG mode.
 * @param {string} message - The message to log.
 */
function logDebug(message) {
    if (DEBUG) { // Assumes 'DEBUG' is globally accessible
        console.log(message);
    }
}

/**
 * Retrieves the first canvas from the global array.
 * @returns {fabric.Canvas} - The first canvas object.
 */
function getFirstCanvas() {
    return canvasarray[currentcanvasid]; // Assumes 'canvasarray' and 'currentcanvasid' are globally accessible
}

/**
 * Gets the initial zoom level of the canvas.
 * @param {fabric.Canvas} canvas - The canvas to retrieve the zoom from.
 * @returns {number} - The zoom level.
 */
function getInitialZoom(canvas) {
    return canvas.getZoom();
}

/**
 * Checks if the canvas background is empty.
 * @param {fabric.Canvas} canvas - The canvas to check.
 * @returns {boolean} - True if the background is empty, otherwise false.
 */
function checkIfBackgroundIsEmpty(canvas) {
    return !canvas.backgroundColor;
}

/**
 * Prepares the canvas for thumbnail generation by setting the zoom and background color.
 * @param {fabric.Canvas} canvas - The canvas to prepare.
 * @param {boolean} isEmptyBackground - Indicates if the background is initially empty.
 */
function prepareCanvasForThumbnail(canvas, isEmptyBackground) {
    setZoomForThumbnail();
    if (isEmptyBackground) {
        canvas.set({ backgroundColor: "#ffffff" });
    }
    if (template_type === "geofilter2") { // Assumes 'template_type' is globally accessible
        removeGeofilterOverlay(); // Assumes this function is defined elsewhere
    }
}

/**
 * Generates the data URL for the canvas thumbnail.
 * @param {fabric.Canvas} canvas - The canvas to generate the thumbnail for.
 * @returns {string} - The data URL of the thumbnail.
 */
function generateThumbnailDataURL(canvas) {
    return canvas.toDataURL({
        format: "jpeg",
        quality: 0.7
    });
}

/**
 * Restores the canvas to its initial state after generating the thumbnail.
 * @param {fabric.Canvas} canvas - The canvas to restore.
 * @param {number} initialZoom - The initial zoom level to restore to.
 * @param {boolean} isEmptyBackground - Indicates if the background was initially empty.
 */
function restoreCanvasState(canvas, initialZoom, isEmptyBackground) {
    if (template_type === "geofilter2") {
        setGeofilterOverlay(); // Assumes this function is defined elsewhere
    }
    if (isEmptyBackground) {
        canvas.set({ backgroundColor: "" });
    }
    setZoom(initialZoom);
}

/**
 * Sets the zoom level of the canvas to fit the thumbnail size.
 */
function setZoomForThumbnail() {
    const desiredThumbnailWidth = 800;
    const canvasWidth = 96 * parseFloat(document.getElementById("loadCanvasWid").value);
    setZoom(desiredThumbnailWidth / canvasWidth);
}
