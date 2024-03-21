class AppSpinner {
    constructor() {
        if (DEBUG) {
            console.log("MIGRATED:: AppSpinner()");
        }
    }

    show() {
        if (!$("#appSpinner").is(":visible")) {
            $("#appSpinner").show();
        }
    }

    hide() {
        if ($("#appSpinner").is(":visible")) {
            $("#appSpinner").hide();
        }
    }
}

const appSpinner = new AppSpinner();


/**
 * Loads settings from a specified endpoint and applies them to the corresponding elements on the page.
 */
function loadSettings() {
    if (DEBUG) {
        console.log("MIGRATED:: loadSettings()");
    }

    const url = `${appUrl}editor/load-settings`;

    $.getJSON(url).done(response => {
        if (response.err === 0) {
            response.data.forEach(setting => {
                const settingElement = $(`#${setting.set_key}`);
                if (settingElement.length) {
                    // Safely parse the boolean value from the setting's value without using eval.
                    const value = parseBoolean(setting.set_value);
                    settingElement.prop("checked", value);
                }
            });
        }
    });
}

/**
 * Safely parses a boolean value from a string.
 * @param {String} value The string to parse.
 * @return {Boolean} The parsed boolean value, defaulting to false for unrecognized strings.
 */
function parseBoolean(value) {
    return /^(true|1)$/i.test(value);
}

function getBgimages2($offset, $tags) {}
function getRelatedProducts(templateId, page) {}

/**
 * Sorts an unordered list (UL) either in ascending or descending order.
 * @param {string|HTMLElement} ul The unordered list element or its ID.
 * @param {boolean} sortDescending Whether to sort the list in descending order.
 */
function sortUnorderedList(ul, sortDescending = false) {
    if (DEBUG) {
        console.log("MIGRATED:: sortUnorderedList()");
    }

    // Resolve the UL element from ID or direct reference
    if (typeof ul === "string") {
        ul = document.getElementById(ul);
    }

    if (!ul) {
        alert("The UL object is null!");
        return;
    }

    // Extract list items and their texts
    const lis = Array.from(ul.getElementsByTagName("LI"));
    const vals = lis.map(li => ({
        text: li.textContent,
        element: li
    }));

    // Sort list items by text, case insensitive
    vals.sort((a, b) => a.text.toLowerCase().localeCompare(b.text.toLowerCase()));

    if (sortDescending) {
        vals.reverse();
    }

    // Reinsert list items in sorted order
    vals.forEach(val => ul.appendChild(val.element));
}

/**
 * Initializes a Masonry grid layout with infinite scrolling for a given container.
 */
var flag_scroll_templates_template = !1
  , limit_template = 20
  , aContainer_template = "#template_container"
  , aSearch_template = "#templatesearch"
  , aMethod_template = "get-thumbnails"
  , type_template = "template";


/**
 * Initializes Masonry layout and Infinite Scroll for template container.
 */
function initMasonry_template() {
    if (DEBUG) {
        console.log("MIGRATED:: initMasonry_template()");
    }

    const $container = $(aContainer_template);

    // Check if Infinite Scroll has been initialized and destroy it if it has
    if ($container.data("infiniteScroll")) {
        $container.infiniteScroll('destroy');
    }

    // Check if Masonry has been initialized and destroy it if it has
    if ($container.data('masonry')) {
        $container.masonry('destroy');
    }

    // Clear the container's content after destroying the plugins
    $container.html("");

    // Initialize Masonry
    infinites[type_template] = $container.masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: true,
        stagger: 30,
        visibleStyle: { transform: "translateY(0)", opacity: 1 },
        hiddenStyle: { transform: "translateY(100px)", opacity: 0 }
    });

    // Store the Masonry instance
    masonrys[type_template] = infinites[type_template].data("masonry");

    // Initialize Infinite Scroll
    infinites[type_template].infiniteScroll({
        path: function() {
            const tags = $(aSearch_template).val() || "";
            return `${appUrl}editor/${aMethod_template}/?load_count=${this.loadCount}&limit_template=${limit_template}&tags=${tags}&design_as_id=${design_as_id}&demo_as_id=${demo_as_id}&demo_templates=${demo_templates}&id=${demo_templates}&language_code=${language_code}`;
        },
        responseType: "text",
        outlayer: masonrys[type_template],
        history: false,
        scrollThreshold: false
    });

    // Additional setup for UI elements
    loadReadMore(aContainer_template, "loadTemplates_template");
    $container.next().find(".iscroll-button").show();
    $('#template-status').val("Thumbs Loaded");
}

/**
 * Appends a "load more" HTML structure after a specified container.
 * If a "page-load" element already exists after the container, it is removed before the new content is added.
 * @param {string} container The selector for the container after which the HTML will be appended.
 */
function loadReadMore(container) {
    if (DEBUG) {
        console.log("MIGRATED:: loadReadMore()");
    }
    
    // Remove existing "page-load" element if present
    const $nextElement = $(container).next();
    if ($nextElement.hasClass("page-load")) {
        $nextElement.remove();
    }

    // Construct the HTML for the "load more" feature using a template literal
    const htmlLoad = `
        <div class="page-load">
            <div class="loader-ellips">
                <img class="loading-spin" src="${appUrl}design/assets/img/loader.svg">
            </div>
            <p class="iscroll-last">End of Results</p>
        </div>
    `;

    // Append the newly constructed HTML after the specified container
    $(container).after(htmlLoad);
}

/**
 * Triggers the loading of the next page of templates and updates the layout and UI accordingly.
 */
function loadTemplates_template() {
    if (DEBUG) {
        console.log("MIGRATED:: loadTemplates_template()");
    }

    // Trigger loading the next page of templates
    infinites[type_template].infiniteScroll("loadNextPage");

    // Update the Masonry layout after a short delay to ensure items are loaded
    setTimeout(() => masonrys[type_template].layout(), 200);

    // Hide the loading animation after a longer delay to allow for content to fully load
    setTimeout(() => $(aContainer_template).next().find(".loader-ellips").hide(), 1500);
}

// let templateId_image;

// Improved variable declarations with let and const, and more descriptive names.
let isScrollEnabledForImages = false;
const imagesLimit = 24;
const imagesContainerSelector = ".uploaded_images_list";
// let searchQueryForImages = ""; // Assuming this might be updated elsewhere
const methodForImages = "get-uploaded-images";
const typeForImages = "image";


/**
 * Initializes Masonry layout and Infinite Scroll for images container.
 * @param {string} templateId - The template ID to use for fetching images.
 */
function initMasonry_image(templateId) {
    if (DEBUG) {
        console.log("MIGRATED:: initMasonry_image()");
    }

    // Update global template ID for images
    templateId_image = templateId;

    const $container = $(imagesContainerSelector);

    // Check and destroy existing Infinite Scroll and Masonry instances
    if ($container.data("infiniteScroll") !== null) {
        $container.html(""); // Clear existing content
        if ($container.data("infiniteScroll")) {
            $container.infiniteScroll('destroy');
        }
    
        // Check if Masonry has been initialized and destroy it if it has
        if ($container.data('masonry')) {
            $container.masonry('destroy');
        }
    }

    // Initialize Masonry with settings
    infinites[typeForImages] = $container.masonry({
        itemSelector: ".thumb",
        columnWidth: 1,
        percentPosition: true,
        stagger: 30,
        visibleStyle: { transform: "translateY(0)", opacity: 1 },
        hiddenStyle: { transform: "translateY(100px)", opacity: 0 }
    });

    // Store the Masonry instance
    masonrys[typeForImages] = infinites[typeForImages].data("masonry");

    // Initialize Infinite Scroll with path function and settings
    infinites[typeForImages].infiniteScroll({
        path: () => `${appUrl}editor/${methodForImages}/${imagesLimit}/${this.loadCount}`,
        responseType: "text",
        outlayer: masonrys[typeForImages],
        history: false,
        scrollThreshold: false
    });

    // Additional setup for UI elements
    loadReadMore(imagesContainerSelector, "loadTemplates_image");
    $container.next().find(".iscroll-button").show();
}

/**
 * Loads the next page of images using Infinite Scroll and updates the layout and UI.
 * Assumes global variables 'infinites' and 'masonrys' are initialized elsewhere.
 */
function loadTemplates_image() {
    if (DEBUG) {
        console.log("MIGRATED:: loadTemplates_image()");
    }

    // Trigger loading the next page of images.
    infinites[typeForImages].infiniteScroll("loadNextPage");

    // After a brief delay, update the Masonry layout and show the loading indicator for new images.
    setTimeout(() => {
        if (masonrys[typeForImages]) {
            masonrys[typeForImages].layout();
            $(".infinite-scroll-request_image_products").show(); // Assumes this selector targets the relevant loading indicator.
        }
    }, 500);

    // After a longer delay, hide the loader ellipsis to indicate that loading is complete.
    setTimeout(() => {
        $(imagesContainerSelector).next().find(".loader-ellips").hide();
    }, 1500);
}

/**
 * Fetches and processes additional images based on the provided offset.
 * The function adjusts UI elements based on the user's role and the fetched data.
 * @param {number} offset The offset from which to start fetching images.
 */
function getUploadedImages(offset) {
    if (DEBUG) {
        console.log("MIGRATED:: getUploadedImages()");
    }

    // Construct the URL for fetching images.
    const url = `${appUrl}editor/get-additional-assets/?offset=${offset}`;

    // Fetch the images.
    $.getJSON(url, function(data) {
        if (!data.success) {
            console.error('Failed to fetch images.');
            return;
        }

        const isUploadTabVisible = currentUserRole === "administrator" || currentUserRole === "designer";
        const shouldShowUploadTab = isUploadTabVisible && (!isNaN(design_as_id) && design_as_id > 0 || data.images.length > 0);

        // Update UI based on conditions.
        $("#tab-upload").toggle(shouldShowUploadTab);
        if (shouldShowUploadTab) {
            $("#tab-upload .dz-message").hide();
            $("#myAwesomeDropzone").css({ border: "none" }).removeClass("dz-clickable");
        }
    });
}

/**
 * Constructs HTML for a template item based on the provided row data.
 * @param {Object} row - The data object for the current template item.
 * @returns {string} The HTML string for the template item.
 */
function getItemHTML_template(row) {
    if (DEBUG) {
        console.log("MIGRATED:: getItemHTML_template()");
    }

    let instructionsOverlay = '';
    if (row.instructionsId) {
        instructionsOverlay = `<a class="instructions-overlay" onclick="loadInstructions(${row.template_id})" data-toggle="modal" data-target="#sellerInstructions"><h3>Seller Instructions</h3></a>`;
    }

    let deleteButton = '';
    if (currentUserRole !== "designer") {
        deleteButton = `<i class="fa fa-trash-o deleteTemp" id="${row.template_id}"></i>`;
    }

    return `
        <div class="col-xs-6 thumb" id="${row.template_id}">
            ${instructionsOverlay}
            <a class="thumbnail" data-target="${row.template_id}">
                <span class="thumb-overlay"><h3>${row.template_name}</h3></span>
                <div class="expired-notice" style="display:none;">EXPIRED</div>
                <img class="tempImage img-responsive" src="${row.temp_source}" alt="">
            </a>
            <div class="badge-container">
                <span class="badge dims">${row.width} x ${row.height} ${row.metrics}</span>
                <span class="badge tempId">ID: ${row.template_id}</span>
                ${deleteButton}
            </div>
        </div>
    `;
}

function getItemHTML_text(item) {
    return `
        <div class="col-xs-6 thumb ${item.isownitem}" id="${item.text_id}">
            <a class="thumbnail" title="${item.text_name}" href="#" data-target="${item.text_id}">
                <img class="textImage img-responsive" src="${item.text_thumbnail}" alt="">
            </a>
            <i class="fa fa-trash-o deleteText" id="${item.text_id}"></i>
        </div>
    `;
}

var infinites = [], masonrys = [], flag_scroll_templates_element = !1
, limit_element = 24
, aContainer_element = "#catimage_container"
, aSearch_element = "#elementssearch"
, aMethod_element = "get-elements"
, type_element = "element";

var flag_scroll_templates_bg = !1
  , limit_bg = 24
  , aContainer_bg = "#background_container"
  , aSearch_bg = "#bgsearch"
  , aMethod_bg = "get-backgrounds"
  , type_bg = "bg";
  var flag_scroll_templates_text = !1
  , limit_text = 24
  , aContainer_text = "#text_container"
  , aSearch_text = "#textsearch"
  , aMethod_text = "get-texts"
  , type_text = "text";

  var flag_scroll_templates_related = !1, limit_related = 24, aContainer_related = "#related_products_container", aSearch_related = "", aMethod_related = "get-related-products", type_related = "related", templateId_related;

Dropzone.autoDiscover = false;

var canvasScale = 1, currentcanvasid = 0, canvasindex = 0, pageindex = 0, canvasarray = [], isdownloadpdf = !1, isupdatetemplate = !1, issaveastemplate = !1, totalsvgs = 0, convertedsvgs = 0, loadedtemplateid = 0, activeObjectCopy, keystring = "", remstring = "", savestatecount = 0, stopProcess = !1, templatesloading = !1, backgroundsLoading = !1, elementsLoading = !1, textsLoading = !1, rotationStep = 1, properties_to_save = Array("format", "patternSourceCanvas", "bgImg", "src", "svg_custom_paths", "hidden", "cwidth", "cheight", "locked", "selectable", "editable", "bg", "logoid", "evented", "id", "bgsrc", "bgScale", "lockMovementX", "lockMovementY"), isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0, isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor), isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor), s_history = !1, previewSvg, offsetTemplates = 0, offsetRelatedProducts = 0, offsetTexts = 0, offsetElements = 0, offsetBackgrounds = 0, template_type, geofilterBackground, instructionsId, svg_custom_data = [], localStorageKey = "wayak.design", templateOptions, backgroundPromise, duplicatedTemplateId, lastShadowBlur, lastShadowHorizontalOffset, lastShadowVerticalOffset, lastShadowColor, historyTable, $fontUTF8Symbols = {}, $useKeepSvgGroups = !1, dontLoadFonts = [], $copyOnePageAcrossSheet = !1;

InfiniteScroll.prototype.loadNextPage = function() {
    if (!this.isLoading && this.canLoad) {
        const path = this.getAbsolutePath();
        this.isLoading = true;

        const handleLoad = (response) => this.onPageLoad(response, path);
        const handleError = (error) => this.onPageError(error, path);
        const handleLast = (response) => this.lastPageReached(response, path);

        request(path, this.options.responseType, handleLoad, handleError, handleLast);
        this.dispatchEvent("request", null, [path]);
    }
};

const request = (url, responseType = '', onLoad, onError, onLast) => {
    const req = new XMLHttpRequest();
    req.open("GET", url, true);
    req.responseType = responseType;
    req.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    if (demo_as_id && demoJwt !== "") {
        req.setRequestHeader("x-demo-wayak-jwt", demoJwt);
    }

    req.onload = () => {
        if (req.status === 200) onLoad(req.response);
        else if (req.status === 204) onLast(req.response);
        else onError(new Error(req.statusText));
    };

    req.onerror = () => onError(new Error(`Network error requesting ${url}`));

    req.send();
};

$(document).ready(function() {
    setupDropzone();
    initializeSelect2();
    setupInitialUIState();
    initializeMasonryAndTemplates();
    getUploadedImages(0);

    sortUnorderedList("fonts-dropdown");
    initializeFontDropdown();
    
    setupInfiniteScroll(aContainer_template, type_template, getItemHTML_template, limit_template, 'flag_scroll_templates_template');
    
    // Not necessary for startup
    setupInfiniteScroll(aContainer_bg, type_bg, getItemHTML_bg, limit_bg, 'flag_scroll_templates_bg');
    setupInfiniteScroll(aContainer_text, type_text, getItemHTML_text, limit_text, 'flag_scroll_templates_text');
    setupInfiniteScroll(aContainer_related, type_related, getItemHTML_related, limit_related, 'flag_scroll_relateds_related');
    setupInfiniteScroll(imagesContainerSelector, typeForImages, getItemHTML_image, imagesLimit, 'flag_scroll_images_image');    
});

$("#template_container").on("click", ".thumbnail", function() {
    jQuery(this).data("target") && loadTemplate(jQuery(this).data("target"))
});

function setupDropzone() {
    if ($("#myAwesomeDropzone").data('dropzone')) return; // Prevent initializing Dropzone multiple times

    $("#myAwesomeDropzone").dropzone({
        url: `${appUrl}editor/template/upload-image`,
        paramName: "file[]",
        maxFilesize: 20,
        thumbnailWidth: 140,
        previewsContainer: ".uploaded_images",
        acceptedFiles: ".png,.jpg,.jpeg,.svg",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            this.on("success", function(file, response) {
                handleDropzoneSuccess(file, response);
            });
        }
    });
}

function getItemHTML_bg(item) {
    if (DEBUG) {
        console.log("getItemHTML_bg()");
    }
    
    // Template for the common part of the item HTML
    const commonHTML = `
        <div class="col-xs-4 thumb ${item.is_own_item}" id="${item.id}">
            <a class="thumbnail bgImage" href="#" data-imgsrc="${item.url}">
                <img class="img-responsive" src="${item.thumb}" alt="">
                <span class="thumb-overlay"><h3>${item.name}</h3></span>
            </a>
    `;

    // Conditionally add the delete button for certain roles
    const deleteButtonHTML = ["superadmin", "administrator"].includes(currentUserRole) ? 
        `<i class="fa fa-trash-o deleteBg" id="${item.id}"></i>` : 
        "";

    // Combine the common HTML with the conditional part and close the div
    return `${commonHTML} ${deleteButtonHTML}</div>`;
}


function handleDropzoneSuccess(file, response) {
    const data = JSON.parse(response);
    if (!data.success) {
        $.toast({
            text: data.msg,
            icon: "error",
            loader: false,
            position: "top-right",
            hideAfter: 3000
        });
        return;
    }

    $(file.previewElement).data("id", data.id);
    if (!demo_as_id) {
        const deleteBtnHtml = `<i class="fa fa-trash-o deleteImage" data-target="${data.id}"></i>`;
        appendImageToMasonry(data, deleteBtnHtml);
    }
}

function appendImageToMasonry(data, deleteBtnHtml) {
    $(".uploaded_images .dz-preview").each(function() {
        const imgSrc = $(this).find(".dz-image img").attr("src");
        const name = $(this).find(".dz-filename span").html();
        const newItemHtml = `
            <div data-id="${data.id}" class="dz-preview dz-processing dz-image-preview dz-success dz-complete thumb">
                <div class="dz-image">
                    <img data-dz-thumbnail="" alt="${name}" src="${imgSrc}">
                </div>
                ${deleteBtnHtml}
            </div>
        `;
        const newItem = $(newItemHtml);
        infinites.image.infiniteScroll("appendItems", newItem).masonry("appended", newItem);
    });
    $(".uploaded_images").empty(); // Clear the previews container
}

function initializeSelect2() {
    $("#template_tags, #element_tags, #bg_tags, #new_element_tags").select2({
        tags: true,
        width: "100%",
        tokenSeparators: [","]
    });

    $("input[name=metric_units1], input[name=metric_units]").val(["in"]);
}

function setupInitialUIState() {
    $("#undo, #productImageDownload, #addnewpagebutton, #saveimage, #saveastemplate, .download-menu, .zoom-control, #options, #savetemplate").hide();
}

function initializeMasonryAndTemplates() {
    initMasonry_template();
    loadTemplates_template();
    initMasonry_image();
    loadTemplates_image();
}

function initializeFontDropdown() {
    if (DEBUG) {
        console.log("initializeFontDropdown()");
    }

    $("#fonts-dropdown li a").click(function(e) {
        e.preventDefault();
        const selectedFontFamily = $(this).data("ff");
        const fontDisplayName = $(this).parent().find("span").html();
        const activeObject = canvas.getActiveObject();

        updateDropdownDisplay($(this), selectedFontFamily, fontDisplayName);
        if (activeObject) {
            loadAndApplyFont(activeObject, selectedFontFamily);
        }

        if (activeObject && activeObject._objects && isTextsGroup()) {
            loadFontsForGroup(activeObject, selectedFontFamily);
        }

        save_history();
    });
}

function updateDropdownDisplay($element, fontFamily, displayName) {
    if (DEBUG) {
        console.log("updateDropdownDisplay()");
    }

    $element.parents(".btn-group").find(".dropdown-toggle").html(
        `<span style="overflow:hidden"><a style="font-family: ${fontFamily}" href="#" data-ff="${fontFamily}" size="3">${displayName}</a>&nbsp;&nbsp;<span class="caret"></span></span>`
    );
}

function loadAndApplyFont(object, fontFamily) {
    getFonts2(object, fontFamily).then(result => {
        console.log("getFonts2() success", result); // Consider removing DEBUG flag for simplicity
        applyFontToObject(result.object, result.font);
    }).catch(result => {
        console.error(`font ${result.font} failed to load`);
    });
}

function loadFontsForGroup(group, fontFamily) {
    group.forEachObject(object => {
        getFonts2(object, fontFamily).then(result => {
            applyFontToObject(result.object, result.font);
            result.object.initDimensions();
        }).then(() => {
            updateGroupAfterFontLoad(group);
        }).catch(result => {
            console.error(`font ${result.font} failed to load for object`);
        });
    });
}

function applyFontToObject(object, fontFamily) {
    fabric.charWidthsCache[fontFamily] = {};
    object.__lineWidths = [];
    object._charWidthsCache = {};
    setStyle(object, "fontFamily", fontFamily);
    object.charSpacing = 0;
    object.setCoords();
}

function updateGroupAfterFontLoad(group) {
    group._restoreObjectsState();
    fabric.util.resetObjectTransform(group);
    group._calcBounds();
    group._updateObjectsCoords();
    group.setCoords();
    canvas.renderAll();
}

function setupInfiniteScroll(containerSelector, itemType, itemHTMLFunction, limit, flagVarName) {
    $(containerSelector).on("load.infiniteScroll", function(event, response) {
        const data = JSON.parse(response);
        const itemsData = data.data || data.products || data.images; // Adapt based on the expected data structure
        const itemsHTML = itemsData.map(itemHTMLFunction).join("");
        const $items = $(itemsHTML);

        $items.imagesLoaded(function() {
            infinites[itemType].infiniteScroll("appendItems", $items).masonry("appended", $items);
        });

        if (itemsData.length) {
            setTimeout(function() {
                window[flagVarName] = false;
                $(containerSelector).next().find(".iscroll-last").hide();
            }, 500);
        }

        if (itemsData.length < limit) {
            $(containerSelector).next().find(".loader-ellips, .iscroll-button").hide();
            $(containerSelector).next().find(".iscroll-last").show();
        }
    });
}

function getItemHTML_related(product) {
    if (DEBUG) {
        console.log("getItemHTML_related()");
    }

    // Create and configure the new element with chaining
    var newElement = $("<div/>")
        .addClass("grid-item")
        .css({
            "width": "140px",
            "float": "left",
            "margin": "0 0 10px 10px"
        });

    // Create the product link and configure attributes
    var productLink = $("<a/>")
        .attr({
            "href": product.url,
            "target": "_blank"
        });

    // Create the product image, set its source and width, and append it to the link
    $("<img/>")
        .attr("src", product.image)
        .css("width", "100%")
        .appendTo(productLink);

    // Append the link to the new element and return the outer HTML
    return newElement.append(productLink).prop('outerHTML');
}

function getItemHTML_image(product) {
    if (DEBUG) {
        console.log("getItemHTML_image()");
    }
    
    // Conditionally render the delete button based on `demo_as_id`
    const deleteBtn = demo_as_id 
        ? "" 
        : `<i data-target="${product.id}" class="fa fa-trash-o deleteImage"></i>`;

    // Use template literals to construct the HTML string
    return `
        <div data-id="${product.id}" class="dz-preview dz-processing dz-image-preview dz-success dz-complete thumb">
            <div class="dz-image">
                <img data-dz-thumbnail="" alt="${product.filename}" src="${product.img}">
            </div>
            <!-- The details div is commented out, if needed in the future, it can be uncommented and used
            <div class="dz-details">
                <div class="dz-filename"><span data-dz-name="">${product.filename}</span></div>
            </div>
            -->
            ${deleteBtn}
        </div>
    `;
}

