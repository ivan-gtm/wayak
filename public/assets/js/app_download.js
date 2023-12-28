$(document).ready(function() {
    $("#downloadAsPNG").click(initiateDownloadProcess);
    $("#downloadAsJPEG").click(initiateJpegDownload);
    $("#downloadAsPDF").click(handlePdfDownload);
});

function logDebug(message) {
    if (DEBUG) { // Assumes 'DEBUG' is globally accessible
        console.log(message);
    }
}

function initiateDownloadProcess() {
    registerDownload("PNG", undefined, handleDownloadRegistration);
}

function handleDownloadRegistration(downloadCallback) {
    if (isDemoMode()) {
        showDemoModeError();
    } else {
        prepareCanvasForDownloadPNG();
        processCanvasForDownloadPNG(downloadCallback);
    }
}

function prepareCanvasForDownloadPNG() {
    canvas.discardActiveObject().renderAll(); // Assumes 'canvas' is globally accessible
    appSpinner.show(); // Assumes 'appSpinner' is globally accessible
    $("#zoomperc").data("oldScaleValue", $("#zoomperc").data("scaleValue"));
    setZoom(1); // Assumes 'setZoom' is a globally accessible function
}

function processCanvasForDownloadPNG(downloadCallback) {
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
        prepareCanvasForDownloadJPEG();
        processCanvasForJpegDownload(downloadCallback);
    }
}

function isDemoMode() {
    return demo_as_id > 0; // Assumes 'demo_as_id' is a globally defined variable
}

function prepareCanvasForDownloadJPEG() {
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
        singleCanvasDownloadJPEG(options, "jpeg", downloadCallback);
    } else {
        multipleCanvasDownloadJPEG(options, "jpeg", downloadCallback);
    }
}

function singleCanvasDownloadJPEG(options, format, downloadCallback) {
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

function multipleCanvasDownloadJPEG(options, format, downloadCallback) {
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

function downloadImageProxy(options = {}) {
    logDebug("MIGRATED:: downloadImageProxy()");

    const canvases = options.canvases || canvasarray; // Assumes 'canvasarray' is globally accessible
    let readyCanvases = options.readyCanvases || [];
    const callback = options.callback || getDefaultCallback(canvases);
    let currentIndex = options.currentIndex || 0;

    processCanvasImageProxy(canvases[currentIndex], currentIndex, canvases, readyCanvases, callback);
}



function getDefaultCallback(canvases) {
    return canvases.length === 1 ? downloadImage2 : downloadImage3; // Assumes these functions are defined elsewhere
}

function processCanvasImageProxy(canvas, index, canvases, readyCanvases, callback) {
    const tempCanvas = createTempCanvas(canvas);
    tempCanvas.loadFromJSON(JSON.stringify(canvas.toDatalessJSON(properties_to_save)), () => { // Assumes 'properties_to_save' is globally accessible
        setCanvasBackground(canvas, tempCanvas); // Assumes this function is defined elsewhere
        addBackgroundLayer(canvas, tempCanvas) // Assumes this is a promise-returning function defined elsewhere
            .then(tempCanvas => {
                logDebug(`Processing canvas index: ${index}`);
                readyCanvases[index] = tempCanvas;

                if (readyCanvases.length >= canvases.length || index > canvases.length) {
                    callback({ canvases: readyCanvases });
                } else {
                    downloadImageProxy({
                        canvases: canvases,
                        readyCanvases: readyCanvases,
                        currentIndex: index + 1,
                        callback: callback
                    });
                }
            })
            .catch(error => {
                logDebug(error);
            });
    });
}

function createTempCanvas(canvas) {
    const tempCanvas = new fabric.StaticCanvas(); // Assumes 'fabric' is globally accessible
    tempCanvas.setDimensions({
        width: canvas.get("width"),
        height: canvas.get("height")
    });

    if (typeof canvas.backgroundColor !== "string") {
        canvas.backgroundColor = "";
    }

    return tempCanvas;
}

function setCanvasBackground(canvas, tempCanvas) {
    setCanvasBg(canvas, canvas.bgsrc, "", canvas.bgScale); // Assumes 'setCanvasBg' is a function defined elsewhere
}

function removeDeletedCanvasesProxy(options = {}) {
    logDebug("MIGRATED:: removeDeletedCanvasesProxy");

    const canvases = options.canvases || canvasarray; // Assumes 'canvasarray' is globally accessible
    logDebug(`Canvases: ${canvases}`);

    prepareForRemoval(canvases);
}



function prepareForRemoval(canvases) {
    rasterizeObjectsProxy({
        canvases: canvases,
        callback: removeDeletedCanvases // Assumes 'removeDeletedCanvases' is a function defined elsewhere
    });
}

function downloadImage2(options = {}) {
    logDebug("MIGRATED:: downloadImage2");

    const canvases = options.canvases || canvasarray; // Assumes 'canvasarray' is globally accessible
    let format = getFormat(options.format);
    const id = loadedtemplateid || "new"; // Assumes 'loadedtemplateid' is globally accessible
    const filename = `wayak_${id}.${format}`;
    const metrics = $("input[name=metric_units1]:checked").val();
    const multiplier = getMultiplier(format, metrics);

    canvases.forEach((canvas, index) => {
        if (canvas) {
            processCanvas(canvas, format, multiplier, filename);
        }
    });
    
    appSpinner.hide();
    resetView();
}

function getFormat(inputFormat) {
    let format = inputFormat || "jpeg";
    if (format === "jpg") {
        format = "jpeg";
    }
    return format;
}

function getMultiplier(format, metrics) {
    if ((format === "jpeg" || (format === "png" && metrics === "px")) && !/geofilter/.test(template_type)) { // Assumes 'template_type' is globally accessible
        return 3.125;
    }
    return 1;
}

function processCanvas(canvas, format, multiplier, filename) {
    setCanvasBackground(canvas, format);
    setCanvasDimensions(canvas); // Assumes this is a function that sets dimensions
    // handleGeofilterOverlay();

    let dataURL = getCanvasDataURL(canvas, format, multiplier);
    dataURL = adjustDataURLForType(dataURL, format);
    saveImageDataURL(dataURL, filename, format);
}

function setCanvasBackground(canvas, format) {
    if (format === "jpeg" && !canvas.backgroundColor) {
        canvas.set({ backgroundColor: "#ffffff" });
    }
}

function getCanvasDataURL(canvas, format, multiplier) {
    return canvas.toDataURL({
        format: format,
        quality: 1,
        multiplier: multiplier / fabric.devicePixelRatio, // Assumes 'fabric' is globally accessible
        enableRetinaScaling: true
    });
}

function adjustDataURLForType(dataURL, format) {
    if (format === "jpeg") {
        return setJpegDPI(dataURL); // Assumes 'setJpegDPI' is a function defined elsewhere
    } else if (format === "png" && template_type !== "geofilter" && template_type !== "geofilter2") {
        return setPngDPI(dataURL); // Assumes 'setPngDPI' is a function defined elsewhere
    }
    return dataURL;
}

function saveImageDataURL(dataURL, filename, format) {
    if (isMacAndSafari() || isGeofilterTemplate(format)) { // Assumes these are functions that determine the browser and template type
        postImageData(appUrl + "design/saveimage.php", dataURL, filename); // Assumes 'appUrl' is globally accessible
    } else {
        downloadDirectly(dataURL, filename);
    }
}

function resetView() {
    setZoom($("#zoomperc").data("oldScaleValue")); // Assumes 'setZoom' is a function defined elsewhere
    toggleHiddenStatusOfObjects(); // Assumes this is a function defined elsewhere
}

function setJpegDPI(dataURI) {
    logDebug("Entering setJpegDPI");

    const { raw, mimeString } = decomposeDataURI(dataURI);
    let hexString = convertRawToHex(raw);
    hexString = adjustJpegHex(hexString);

    return constructDataURI(mimeString, hexString);
}

function setPngDPI(dataURI) {
    logDebug("Entering setPngDPI");

    const { raw, mimeString } = decomposeDataURI(dataURI);
    let hexString = convertRawToHex(raw);
    hexString = adjustPngHex(hexString);

    return constructDataURI(mimeString, hexString);
}

function decomposeDataURI(dataURI) {
    const parts = dataURI.split(",");
    return {
        raw: atob(parts[1]),
        mimeString: parts[0]
    };
}

function convertRawToHex(raw) {
    let hexString = "";
    for (let i = 0; i < raw.length; i++) {
        const hex = raw.charCodeAt(i).toString(16).padStart(2, '0').toUpperCase();
        hexString += hex;
    }
    return hexString;
}

function adjustJpegHex(hexString) {
    return hexString.slice(0, 26) + "01012C012C" + hexString.slice(36);
}

function adjustPngHex(hexString) {
    return hexString.slice(0, 70) + "00097048597300000EC400000EC401952B0E1B0000" + hexString.slice(70);
}

function constructDataURI(mimeString, hexString) {
    const binaryString = hexString.match(/\w{2}/g).map(a => String.fromCharCode(parseInt(a, 16))).join("");
    const base64 = btoa(binaryString);
    return mimeString + "," + base64;
}

/**
 * Posts image data to a specified URL.
 * @param {string} url - The URL to which the image data should be posted.
 * @param {string} dataURL - The base64 encoded image data.
 * @param {string} filename - The name of the file when saved on the server.
 */
function postImageData(url, dataURL, filename) {
    if (DEBUG) {
        console.log("Entering postImageData");
    }

    // Extract the image type from the Data URL
    const imageType = dataURL.split(',')[0].split(':')[1].split(';')[0];

    // Convert the base64 string to a Blob
    const blob = dataURItoBlob(dataURL);

    // Prepare form data
    const formData = new FormData();
    formData.append('file', blob, filename);
    formData.append('template_type', template_type); // Assumes 'template_type' is globally accessible

    // Perform the AJAX request
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false, // prevent jQuery from converting the data into a query string
        contentType: false, // set to false because jQuery will set the Content-Type incorrectly otherwise
        success: function(response) {
            // Handle success
            console.log("Image successfully uploaded: ", response);
            // You might want to perform additional actions here, like updating the UI
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error("Image upload failed: ", error);
            // Implement error handling logic here
        }
    });
}

/**
 * Converts a data URI to a Blob.
 * @param {string} dataURI - The data URI to convert.
 * @returns {Blob} - The resulting Blob object.
 */
function dataURItoBlob(dataURI) {
    const byteString = atob(dataURI.split(',')[1]);
    const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    const ab = new ArrayBuffer(byteString.length);
    const ia = new Uint8Array(ab);

    for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ab], {type: mimeString});
}

/**
 * Checks if the current browser is Safari running on a Mac.
 * @returns {boolean} - True if the browser is Safari on Mac, otherwise false.
 */
function isMacAndSafari() {
    const userAgent = navigator.userAgent;
    const isMac = userAgent.includes('Macintosh');
    const isSafari = userAgent.includes('Safari') && !userAgent.includes('Chrome');

    return isMac && isSafari;
}

/**
 * Initiates a direct download of image data.
 * @param {string} dataURL - The base64 encoded image data.
 * @param {string} filename - The name of the file when saved.
 */
function downloadDirectly(dataURL, filename) {
    if(DEBUG) {
        console.log("MIGRATED:: downloadDirectly()");
    }

    // Convert the base64 string to a Blob
    const blob = dataURItoBlob(dataURL);

    // Create a URL for the Blob
    const url = URL.createObjectURL(blob);

    // Create a temporary anchor element and trigger the download
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();

    // Clean up by removing the element and revoking the Blob URL
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

/**
 * Handles the addition or removal of a geofilter overlay on the canvas.
 * @param {fabric.Canvas} canvas - The canvas object to apply the geofilter overlay to.
 */
function handleGeofilterOverlay(canvas) {
    if (isGeofilterTemplate()) {
        // If the current template is a geofilter, add the overlay
        addGeofilterOverlay(canvas);
    } else {
        // If it's not a geofilter, remove the overlay if it exists
        removeGeofilterOverlay(canvas);
    }
}

/**
 * Adds a geofilter overlay to the canvas.
 * @param {fabric.Canvas} canvas - The canvas object to apply the overlay to.
 */
function addGeofilterOverlay(canvas) {
    // Assuming you have a predefined overlay (like an image or graphic)
    const overlay = new fabric.Image('path/to/your/overlay.png', {
        // Set properties as needed, for example:
        left: 0,
        top: 0,
        scaleX: canvas.width / overlay.width,
        scaleY: canvas.height / overlay.height,
    });

    // Add the overlay to the canvas
    canvas.add(overlay);
    canvas.renderAll();
}

/**
 * Removes the geofilter overlay from the canvas, if it exists.
 * @param {fabric.Canvas} canvas - The canvas object to remove the overlay from.
 */
function removeGeofilterOverlay(canvas) {
    // This assumes that the overlay has a specific type or id that you can use to identify it
    const overlay = canvas.getObjects().find(obj => obj.type === 'geofilterOverlay');
    if (overlay) {
        canvas.remove(overlay);
        canvas.renderAll();
    }
}

/**
 * Checks if the current template is a 'geofilter' type.
 * @returns {boolean} - True if the current template is a geofilter, otherwise false.
 */
function isGeofilterTemplate() {
    // Replace 'geofilter' with the actual condition or variable that denotes a geofilter template
    return template_type === 'geofilter' || template_type === 'geofilter2'; // Assumes 'template_type' is globally accessible
}
