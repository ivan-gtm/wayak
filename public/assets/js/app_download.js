$(document).ready(function() {
    $("#downloadAsPNG").click(initiateDownloadProcess);
    $("#downloadAsJPEG").click(initiateJpegDownload);
    $("#downloadAsPDF").click(handlePdfDownload);
});

function initiateDownloadProcess() {
    registerDownload("PNG", undefined, handleDownloadRegistration);
}

function handleDownloadRegistration(downloadCallback) {
    if (isDemoMode()) {
        showDemoModeError();
    } else {
        prepareCanvasForDownload();
        processCanvasForDownload(downloadCallback);
    }
}

function isDemoMode() {
    return demo_as_id > 0; // Assumes 'demo_as_id' is a globally defined variable
}

function showDemoModeError() {
    $.toast({
        text: "Not allowed in demo mode",
        icon: "error",
        loader: false,
        position: "top-right"
    });
}

function prepareCanvasForDownload() {
    canvas.discardActiveObject().renderAll(); // Assumes 'canvas' is globally accessible
    appSpinner.show(); // Assumes 'appSpinner' is globally accessible
    $("#zoomperc").data("oldScaleValue", $("#zoomperc").data("scaleValue"));
    setZoom(1); // Assumes 'setZoom' is a globally accessible function
}

function processCanvasForDownload(downloadCallback) {
    removeDeletedCanvases(canvasarray, function(options) { // Assumes 'canvasarray' is globally accessible
        if (options.canvases.length === 1) {
            singleCanvasDownload(options, downloadCallback);
        } else {
            multipleCanvasDownload(options, downloadCallback);
        }
    });
}

function singleCanvasDownload(options, downloadCallback) {
    if (["geofilter", "geofilter2"].includes(template_type)) { // Assumes 'template_type' is globally defined
        downloadImage2({
            canvases: options.canvases,
            format: "png"
        });
        downloadCallback();
    } else {
        downloadImageProxy({
            canvases: options.canvases,
            callback: function(updatedOptions) {
                downloadImage2({
                    canvases: updatedOptions.canvases,
                    format: "png"
                });
                downloadCallback();
            }
        });
    }
}

function multipleCanvasDownload(options, downloadCallback) {
    downloadImageProxy({
        canvases: options.canvases,
        callback: function(updatedOptions) {
            downloadImage3({
                canvases: updatedOptions.canvases,
                format: "png"
            });
            downloadCallback();
        }
    });
}

function initiateJpegDownload() {
    const downloadOptions = {
        saveBleed: $("input#savebleed").is(":checked")
    };
    registerDownload("JPEG", downloadOptions, handleJpegDownloadRegistration);
}

function handleJpegDownloadRegistration(downloadCallback) {
    toggleHiddenStatusOfObjects();
    if (isDemoMode()) {
        showDemoModeError();
    } else {
        prepareCanvasForDownload();
        processCanvasForJpegDownload(downloadCallback);
    }
}

function isDemoMode() {
    return demo_as_id > 0; // Assumes 'demo_as_id' is a globally defined variable
}

function showDemoModeError() {
    $.toast({
        text: "Not allowed in demo mode",
        icon: "error",
        loader: false,
        position: "top-right"
    });
}

function prepareCanvasForDownload() {
    canvas.discardActiveObject().renderAll(); // Assumes 'canvas' is globally accessible
    appSpinner.show(); // Assumes 'appSpinner' is globally accessible
    $("#zoomperc").data("oldScaleValue", $("#zoomperc").data("scaleValue"));
    setZoom(1); // Assumes 'setZoom' is a globally accessible function
}

function processCanvasForJpegDownload(downloadCallback) {
    removeDeletedCanvases(canvasarray, function(options) { // Assumes 'canvasarray' is globally accessible
        if ($("#savebleed").is(":checked")) {
            createBleedAndDownload(options);
        } else {
            processJpegDownload(options, downloadCallback);
        }
        downloadCallback();
    });
}

function createBleedAndDownload(options) {
    createBleed({
        canvases: options.canvases,
        callback: function(updatedOptions) {
            downloadImageProxy({
                canvases: updatedOptions.canvases
            });
        }
    });
}

function processJpegDownload(options, downloadCallback) {
    if (options.canvases.length === 1) {
        singleCanvasDownload(options, "jpeg", downloadCallback);
    } else {
        multipleCanvasDownload(options, "jpeg", downloadCallback);
    }
}

function singleCanvasDownload(options, format, downloadCallback) {
    downloadImageProxy({
        canvases: options.canvases,
        callback: function(updatedOptions) {
            downloadImage2({
                canvases: updatedOptions.canvases,
                format: format
            });
            downloadCallback();
        }
    });
}

function multipleCanvasDownload(options, format, downloadCallback) {
    downloadImageProxy({
        canvases: options.canvases,
        callback: function(updatedOptions) {
            downloadImage3({
                canvases: updatedOptions.canvases,
                format: format
            });
            downloadCallback();
        }
    });
}

function createBleed(options = {}) {
    logDebug("Entering createBleed()");

    const canvases = options.canvases || canvasarray;
    const canvasesWithBleed = options.canvasesWithBleed || [];
    const callback = options.callback || downloadImage2;
    let index = options.index || 0;

    processDownloadCanvas(canvases, canvasesWithBleed, index, callback);
}

function logDebug(message) {
    if (DEBUG) {
        console.log(message);
    }
}

function processDownloadCanvas(canvases, canvasesWithBleed, index, callback) {
    const currentCanvas = canvases[index];
    const dimensions = getCanvasDimensionsWithBleed(currentCanvas);

    const bleedCanvas = createBleedCanvas(dimensions);
    canvasesWithBleed[index] = bleedCanvas;

    loadCanvasFromJSON(currentCanvas, bleedCanvas, () => {
        if (canvases[++index]) {
            createBleed({
                canvases: canvases,
                index: index,
                callback: callback,
                canvasesWithBleed: canvasesWithBleed
            });
        } else {
            setTimeout(() => callback({ canvases: canvasesWithBleed }), 100);
        }
    });
}

function getCanvasDimensionsWithBleed(canvas) {
    return {
        width: parseInt(canvas.get("width") + 24),
        height: parseInt(canvas.get("height") + 24)
    };
}

function createBleedCanvas(dimensions) {
    const element = fabric.util.createCanvasElement();
    element.width = dimensions.width;
    element.height = dimensions.height;

    const bleedCanvas = new fabric.StaticCanvas(element);
    bleedCanvas.setDimensions(dimensions);

    return bleedCanvas;
}

function loadCanvasFromJSON(sourceCanvas, targetCanvas, onComplete) {
    const json = JSON.stringify(sourceCanvas.toDatalessJSON(properties_to_save));

    targetCanvas.loadFromJSON(json, onComplete, (o, object) => {
        logDebug(`Object's left: ${object.left}, top: ${object.top}`);
        adjustObjectPosition(object);
    });
}

function adjustObjectPosition(object) {
    object.set({
        left: object.left + 12,
        top: object.top + 12
    });
    object.setCoords();
}

function handlePdfDownload() {
    const docUserId = 123123123;

    abortPreviousAjaxRequest();
    if (isDemoMode()) {
        showDemoModeError();
    } else {
        initiatePdfDownload(docUserId);
    }
}

function abortPreviousAjaxRequest() {
    if (ajaxRequestRef) {
        ajaxRequestRef.abort();
    }
}

function isDemoMode() {
    return demo_as_id > 0; // Assumes 'demo_as_id' is globally accessible
}

function showDemoModeError() {
    $.toast({
        text: "Not allowed in demo mode",
        icon: "error",
        loader: false,
        position: "top-right"
    });
}

function initiatePdfDownload(docUserId) {
    downloadPdfTimer(120);
    prepareCanvasForDownload();

    const pdfOptions = gatherPdfOptions();
    const templateJson = getTemplateJson(); // Assumes 'getTemplateJson' is a function defined elsewhere
    const urlDocument = appUrl + "admin/Documents/download-pdf-file"; // Assumes 'appUrl' is globally accessible

    showPdfCreationToast();
    submitPdfRequest(urlDocument, docUserId, templateJson, pdfOptions);
}

function prepareCanvasForDownload() {
    canvas.discardActiveObject().renderAll(); // Assumes 'canvas' is globally accessible
}

function gatherPdfOptions() {
    const canvases = canvasarray; // Assumes 'canvasarray' is globally accessible
    const globalRow = parseInt($("#numOfcanvasrows").val());
    const globalCol = parseInt($("#numOfcanvascols").val());
    const pages = calculateNumberOfPages();
    const canvasDimensions = getCanvasDimensions(canvases[0]);
    const userOptions = getUserOptions();
    const pageSize = getPageSize();
    const metrics = $("input[name=metric_units1]:checked").val();

    return {
        canvases, globalRow, globalCol, pages,
        canvasWidth: canvasDimensions.width,
        canvasHeight: canvasDimensions.height,
        userOptions,
        pageSize,
        metrics
    };
}

function calculateNumberOfPages() {
    const visibleCanvasCount = $(".divcanvas:visible").length;
    const rows = parseInt(document.getElementById("numOfcanvasrows").value);
    const cols = parseInt(document.getElementById("numOfcanvascols").value);

    return visibleCanvasCount / rows / cols;
}

function getCanvasDimensions(canvas) {
    return {
        width: canvas.get("width") / canvas.getZoom(),
        height: canvas.get("height") / canvas.getZoom()
    };
}

function getUserOptions() {
    return {
        bleed: $("#savebleedPdf").is(":checked"),
        trimsMarks: $("#savecrop").is(":checked"),
        savePaper: $("#savePaper").is(":checked")
    };
}

function getPageSize() {
    return $(".paper-size.active").find('input[name="paperSize"]').val() === "a4" ? "a4" : "us-letter";
}

function showPdfCreationToast() {
    $.toast({
        heading: "Creating PDF...",
        text: "Please wait. Your document is being prepared.",
        icon: "info",
        loader: false, // Set to true if you want a loader icon
        allowToastClose: false,
        position: "top-right",
        hideAfter: false, // False will make it stay until user interaction
        stack: 1,
        beforeShow: function() {
            // This function is called before the toast is shown
            // Modify the toast element as needed
            const infoToast = $(".jq-toast-single.jq-has-icon.jq-icon-info").first();
            infoToast.removeClass("jq-icon-info").addClass("toast-loader-icon");
            // 'toast-loader-icon' should be a class in your CSS that styles the toast to indicate loading
        },
        afterShown: function() {
            // This function is called after the toast is shown
            // Perform any actions here that should happen after the toast appears
        },
        beforeHide: function() {
            // This function is called before the toast is hidden
            // Perform any cleanup or pre-hide actions here
        },
        afterHidden: function() {
            // This function is called after the toast is hidden
            // Perform any actions here that should happen after the toast is gone
        }
    });
}


function submitPdfRequest(url, docUserId, templateJson, options) {
    $.ajax({
        url: url,
        method: "POST",
        data: {
            webSocketConn: webSocketConn, // Assumes 'webSocketConn' is globally accessible
            demoAsId: demo_as_id, // Assumes 'demo_as_id' is globally accessible
            docUserId: docUserId,
            templateId: loadedtemplateid, // Assumes 'loadedtemplateid' is globally accessible
            templateJson: templateJson,
            pages: options.pages,
            canvasWidth: options.canvasWidth,
            canvasHeight: options.canvasHeight,
            rows: options.globalRow,
            cols: options.globalCol,
            bleed: options.bleed,
            trimsMarks: options.trimsMarks,
            savePaper: options.savePaper,
            pageSize: options.pageSize,
            pageType: template_type, // Assumes 'template_type' is globally accessible
            metrics: options.metrics
        },
        dataType: "json"
    }).done(function(responseData) {
        handlePdfRequestDone(responseData); // Assumes 'handlePdfRequestDone' is a function defined elsewhere
    }).fail(function(jqXHR, textStatus) {
        console.error("Request failed: " + textStatus);
        // Handle request failure here (e.g., display error message)
    });
}


function handlePdfRequestDone(data) {
    pdfRequestId = data.requestId; // Assumes 'pdfRequestId' is globally accessible
    pullingType = "pdf"; // Assumes 'pullingType' is globally accessible
    if (!webSocketConn) { // Assumes 'webSocketConn' is globally accessible
        clearTimeout(referenceUpdates); // Assumes 'referenceUpdates' is globally accessible
        checkDocsUpdates(pdfRequestId); // Assumes 'checkDocsUpdates' is a function defined elsewhere
    }
}
