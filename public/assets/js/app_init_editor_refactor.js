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

