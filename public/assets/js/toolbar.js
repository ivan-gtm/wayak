// Use 'const' for constants and 'let' for variables that may change. 
// Improved function documentation for clarity.
/**
 * Sets up the symbols panel with UTF-8 symbols based on the active font.
 * If a font is provided as an argument, it uses that; otherwise, it uses the font of the currently active object in the canvas.
 * It relies on a global `DEBUG` flag for logging and `canvas` and `$fontUTF8Symbols` global variables.
 * @param {string} [font=""] The font to set up symbols for. Optional.
 */
function setupSymbolsPanel(font = "") {
    // Log for debugging purposes if DEBUG flag is true
    if (DEBUG) {
        console.log("MIGRATED:: setupSymbolsPanel()");
    }

    // Use 'let' for variables that may change. Improved variable names for clarity.
    let activeFont = font;
    const activeTextObject = canvas.getActiveObject();

    // Check if there's an active text object and proceed.
    if (activeTextObject) {
        // If no font is provided, use the font family of the active object.
        if (!activeFont) {
            activeFont = activeTextObject.fontFamily;
        }

        // Function to handle the markup creation and update the DOM.
        const updateSymbolsPanel = (symbols) => {
            let markup = symbols.map(symbol => `<span data-code="${symbol}" class="utf8-symbol">&#${symbol}</span>`).join('');
            $(".utf8-symbols").html(markup).css("font-family", activeFont);
        };

        // Check if the font has associated UTF-8 symbols and is an object.
        if ($fontUTF8Symbols[activeFont] && typeof $fontUTF8Symbols[activeFont] === "object") {
            updateSymbolsPanel($fontUTF8Symbols[activeFont]);
        } else {
            // If the symbols for the font are not already loaded, load them.
            checkUTF8Symbols(activeFont, (keys) => {
                if (Array.isArray(keys) && keys.length > 0) {
                    $fontUTF8Symbols[activeFont] = keys;
                    updateSymbolsPanel(keys);
                }
            });
        }
    }
}

/**
 * Fetches UTF-8 symbols for a specified font by making an AJAX call to retrieve the font's URL,
 * and then loads the font to extract the symbols. Uses a callback to return the symbols if successful.
 * Relies on global `DEBUG` flag for logging, and `appUrl` global variable for building the request URL.
 * @param {string} font The font identifier for which UTF-8 symbols are to be fetched. Optional.
 * @param {Function} callback The callback function to call with the fetched symbols. Optional.
 */
function checkUTF8Symbols(font = "", callback = () => {}) {
    if (DEBUG) {
        console.log("MIGRATED:: checkUTF8Symbols()");
    }

    // Return false immediately if no font is specified.
    if (!font) {
        return false;
    }

    // Build the URL for the AJAX request.
    const url = `${appUrl}editor/get-woff-font-url?font_id=${font}`;

    // Perform the AJAX request.
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json"
    }).done(data => {
        if (data.success) {
            // Load the font using opentype.js library.
            opentype.load(data.url, (err, loadedFont) => {
                if (err) {
                    $.toast({
                        text: "Could not load font.",
                        icon: "error",
                        loader: false,
                        position: "top-right"
                    });
                } else {
                    // Extract unicode values for all glyphs in the font.
                    const keys = Object.values(loadedFont.glyphs.glyphs)
                        .filter(glyph => glyph.unicode !== undefined)
                        .map(glyph => glyph.unicode);

                    // Call the callback function with the keys.
                    callback(keys);
                }
            });
        }
    }).fail(() => {
        $.toast({
            text: "Glyph font request error",
            icon: "error",
            loader: false,
            position: "top-right"
        });
        return false;
    });
}

/**
 * Sets a style on a Fabric.js canvas object, with special handling for text editing mode and font family changes.
 * It updates the UI component for font selection accordingly.
 * @param {Object} object The canvas object to modify.
 * @param {String} styleName The name of the style property to set.
 * @param {String} value The value to set for the style property.
 */
function setStyle(object, styleName, value) {
    if (DEBUG) {
        console.log("MIGRATED:: setStyle()");
    }

    const isFontFamilyChange = styleName === "fontFamily";

    // Function to handle updating the font dropdown UI.
    const updateFontDropdownUI = () => {
        $("#font-dropdown").on("shown.bs.dropdown", function() {
            const $fontSearch = $("#fontSearch").focus();
            const $selectedFont = $(`#fonts-dropdown li a[data-ff="${value}"]`);
            const scrollTopValue = $selectedFont.position().top - $("#fonts-dropdown li:first").position().top;

            $("#fonts-dropdown").scrollTop(scrollTopValue);
            $("#fonts-dropdown li a").removeClass("font-selected");
            $selectedFont.addClass("font-selected");
        });
    };

    if (object) {
        const shouldApplyToAll = !object.isEditing || object.selectionStart === object.selectionEnd || object.selectionStart === 0 && object.selectionEnd === object.text.length;
        
        if (shouldApplyToAll) {
            object.removeStyle(styleName);
            object[styleName] = value;
            
            if (isFontFamilyChange) updateFontDropdownUI();
        } else {
            // When object is editing and there's a text selection.
            const selectionStyles = object.getSelectionStyles();
            const newStyle = { [styleName]: value };

            if ($.isEmptyObject(selectionStyles)) {
                object.setSelectionStyles(newStyle, object.selectionStart, object.selectionEnd);
            } else {
                $.each(selectionStyles, (index, style) => {
                    const isSelectedStyle = style[styleName] === value && styleName !== "fill";
                    style[styleName] = isSelectedStyle ? "" : value;
                    object.setSelectionStyles(style, object.selectionStart + index, object.selectionStart + index + 1);
                });
            }

            if (isFontFamilyChange) object.setSelectionStyles(newStyle, object.selectionStart, object.selectionEnd);
        }

        object.dirty = true;
        canvas.renderAll();
        save_history();
    }
}

/**
 * Sets the visibility of all controls for a Fabric.js canvas object unless the object is locked.
 * @param {fabric.Object} object The canvas object whose controls visibility will be set.
 */
function setControlsVisibility(object) {
    if (DEBUG) {
        console.log("MIGRATED:: setControlsVisibility()");
    }

    // Check if the object is not locked before setting controls visibility.
    if (!object.locked) {
        const visibility = {
            tl: true, // Top Left
            tr: true, // Top Right
            bl: true, // Bottom Left
            br: true, // Bottom Right
            mt: true, // Middle Top
            mb: true, // Middle Bottom
            ml: true, // Middle Left
            mr: true, // Middle Right
        };

        object.setControlsVisibility(visibility);
        object.hasControls = true;
    }
}

// Assuming 'DEBUG' is a global flag that, if true, enables logging for debugging purposes.
const deleteitembtn = document.getElementById("deleteitem");

/**
 * Deletes the currently active object or selection from the canvas, unless it's locked.
 */
function deleteItem() {
    if (DEBUG) {
        console.log("MIGRATED:: deleteItem()");
    }

    const activeObject = canvas.getActiveObject();
    if (!activeObject) return;

    if (activeObject.type === "activeSelection" && activeObject._objects) {
        activeObject.getObjects().forEach(object => {
            if (!object.locked) canvas.remove(object);
        });
    } else if (!activeObject.locked) {
        canvas.remove(activeObject);
    }

    canvas.discardActiveObject().renderAll();
    save_history(); // Assuming save_history() is a function that handles the history/state management.
}

// Attach the event listener using a more modern approach, if the button exists.
if (deleteitembtn) {
    deleteitembtn.addEventListener('click', deleteItem);
}


