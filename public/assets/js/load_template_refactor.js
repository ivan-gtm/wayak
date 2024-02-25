/**
 * Logs debug messages to the console if DEBUG mode is enabled.
 * @param {string} message - The message to log.
 * @param {any} [data] - Optional data to log alongside the message.
 */
function logDebug(message, data) {
    if (window.DEBUG) { // Assuming DEBUG is a global variable.
        if (data !== undefined) {
            console.log(message, data);
        } else {
            console.log(message);
        }
    }
  }
  
  /**
   * Sets the background of the canvas.
   * @param {fabric.Canvas} canvas - The Fabric.js canvas instance.
   * @param {string} imageUrl - The URL of the background image. Empty string if setting a color.
   * @param {string} color - The background color. Used if imageUrl is empty.
   * @param {number} scale - The scale at which to apply the background image.
   * @param {number} index - The z-index at which the background should be placed.
   * @param {boolean} shouldRender - Whether the canvas should be re-rendered after setting the background.
   */
  function setBackground(canvas, imageUrl, color, scale = 1, index, shouldRender = true) {
    if (imageUrl) {
        // If an image URL is provided, set the canvas background to that image
        fabric.Image.fromURL(imageUrl, function(img) {
            img.scale(scale).set({
                originX: 'left',
                originY: 'top'
            });
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                // Optional: Set additional image properties here, if needed
            });
            if (shouldRender) {
                canvas.renderAll();
            }
        });
    } else if (color && typeof color === 'string') {
        // If a color string is provided, set the canvas background to that color
        canvas.setBackgroundColor(color, function() {
            if (shouldRender) {
                canvas.renderAll();
            }
        });
    }
  }
  
  /**
   * Loads an SVG from a given URL and applies custom properties before adding it to the canvas.
   * @param {fabric.Canvas} canvas - The Fabric.js canvas instance.
   * @param {string} svgUrl - The URL of the SVG to load.
   * @param {Object} svgProperties - Object containing properties to be applied to the loaded SVG.
   * @param {number} index - The index at which the SVG should be added in the canvas' object stack.
   */
  function loadSVG(canvas, svgUrl, svgProperties, index) {
    fabric.loadSVGFromURL(svgUrl, function(objects, options) {
        var svgGroup = fabric.util.groupSVGElements(objects, options);
        applyObjectProperties(svgGroup, svgProperties);
  
        // Add the SVG group to the canvas
        canvas.add(svgGroup);
        svgGroup.moveTo(index);
  
        // Optional: Perform additional canvas adjustments here if necessary
        canvas.renderAll();
    });
  }
  
  /**
  * Applies given properties to a Fabric object.
  * @param {fabric.Object} fabricObject - The Fabric object to modify.
  * @param {Object} properties - Object containing properties to be applied.
  */
  function applyObjectProperties(fabricObject, properties) {
    for (let prop in properties) {
        if (properties.hasOwnProperty(prop)) {
            fabricObject.set(prop, properties[prop]);
        }
    }
  
    // Special handling for properties that require additional processing
    if (properties.fill && typeof properties.fill === 'object' && properties.fill.type) {
        // Handle special fill types (e.g., patterns, gradients) here
        // This is just a placeholder; specifics depend on the fill type
    }
  
    fabricObject.setCoords();
  }
  
  /**
   * Applies given properties to a Fabric object. This function is versatile and can handle
   * setting a wide range of properties including position, appearance, and custom attributes.
   * @param {fabric.Object} fabricObject - The Fabric object to which properties will be applied.
   * @param {Object} properties - An object containing key-value pairs of properties to apply.
   */
  function applyObjectProperties(fabricObject, properties) {
    // Apply standard properties directly
    fabricObject.set(properties);
  
    // Check and apply any special properties that need additional handling
    // Example: Applying a shadow property
    if (properties.shadow) {
        // Assuming properties.shadow is in a format Fabric.js can accept directly
        fabricObject.setShadow(properties.shadow);
    }
  
    // Example: Applying a fill pattern
    if (properties.fill && typeof properties.fill === 'object' && properties.fill.type === 'pattern') {
        fabric.Pattern.fromObject(properties.fill, (pattern) => {
            fabricObject.set('fill', pattern);
        });
    }
  
    // Example: Applying gradients (linear or radial)
    if (properties.fill && typeof properties.fill === 'object' && (properties.fill.type === 'linear' || properties.fill.type === 'radial')) {
        fabric.Gradient.fromObject(properties.fill, (gradient) => {
            fabricObject.set('fill', gradient);
        });
    }
  
    // Additional special properties can be handled here
  
    // Ensure the object's position and scaling are updated
    fabricObject.setCoords();
  }
  
  /**
   * Processes and applies custom SVG data to objects on the canvas.
   * @param {fabric.Canvas} canvas - The Fabric.js canvas instance.
   * @param {Array} svgCustomData - An array of objects containing custom SVG data.
   * @param {function} callback - A callback function to execute after all custom data has been applied.
   */
  function handleSvgCustomData(canvas, svgCustomData, callback) {
    if (!svgCustomData || svgCustomData.length === 0) {
        if (typeof callback === "function") {
            callback();
        }
        return;
    }
  
    svgCustomData.forEach((data, index) => {
        if (!data || !data.src) return; // Skip if data is not valid or missing essential properties
  
        fabric.loadSVGFromURL(data.src, (objects, options) => {
            const svgObject = fabric.util.groupSVGElements(objects, options);
            applyObjectProperties(svgObject, {
                left: data.left,
                top: data.top,
                scaleX: data.scaleX,
                scaleY: data.scaleY,
                angle: data.angle,
                originX: data.originX || 'center',
                originY: data.originY || 'center',
                stroke: data.stroke,
                strokeWidth: data.strokeWidth,
                fill: data.fill // This could be a color, pattern, or gradient
            });
  
            // Custom processing for svg_custom_paths or any other custom data
            if (data.svg_custom_paths) {
                // Example: Apply custom paths modifications here
            }
  
            canvas.add(svgObject);
            svgObject.moveTo(index);
  
            if (index === svgCustomData.length - 1 && typeof callback === "function") {
                callback(); // Execute callback when the last SVG is processed
            }
        });
    });
  }
  
  /**
   * Applies fill properties to a fabric object or each object within a group.
   * @param {fabric.Object|fabric.Group} object - The fabric object or group to which the fill will be applied.
   * @param {Object|string} fill - The fill properties to apply. This can be a string for solid colors or an object for gradients or patterns.
   */
  function applyFillToObjects(object, fill) {
    // Function to apply fill to a single object
    const applyFillToObject = (obj, fillData) => {
        if (typeof fillData === 'string') {
            // Solid color fill
            obj.set('fill', fillData);
        } else if (fillData.type && fillData.type === 'pattern') {
            // Pattern fill
            fabric.Pattern.fromObject(fillData, pattern => {
                obj.set('fill', pattern);
            });
        } else if (fillData.type && (fillData.type === 'linear' || fillData.type === 'radial')) {
            // Gradient fill
            fabric.Gradient.fromObject(fillData, gradient => {
                obj.set('fill', gradient);
            });
        }
    };
  
    if (object.type === 'group') {
        // If the object is a group, apply the fill to each object in the group
        object.getObjects().forEach(obj => applyFillToObject(obj, fill));
    } else {
        // If the object is not a group, apply the fill directly to the object
        applyFillToObject(object, fill);
    }
  
    object.setCoords(); // Update object coordinates after applying fill
  }
  
  /**
   * Applies stroke properties to a fabric object or each object within a group.
   * @param {fabric.Object|fabric.Group} object - The fabric object or group to which the stroke will be applied.
   * @param {string} strokeColor - The color of the stroke.
   * @param {number} strokeWidth - The width of the stroke.
   */
  function applyStrokeToObjects(object, strokeColor, strokeWidth) {
    // Helper function to apply stroke properties to a single object
    const applyStroke = (obj, color, width) => {
        obj.set({
            stroke: color,
            strokeWidth: width
        });
    };
  
    if (object.type === 'group') {
        // If the object is a group, apply the stroke to each object in the group
        object.getObjects().forEach(childObject => applyStroke(childObject, strokeColor, strokeWidth));
    } else {
        // If the object is not a group, apply the stroke directly to the object
        applyStroke(object, strokeColor, strokeWidth);
    }
  
    // Ensure the object's coordinates and visual state are updated
    object.setCoords();
    if (object.canvas) {
        object.canvas.renderAll();
    }
  }
  
  /**
   * Applies a gradient fill to a fabric object.
   * @param {fabric.Object} object - The fabric object to which the gradient will be applied.
   * @param {Object} gradientProps - The properties of the gradient to apply.
   */
  function applyGradientFill(object, gradientProps) {
    let gradient;
  
    // Determine the type of gradient and construct it accordingly
    if (gradientProps.type === 'linear') {
        gradient = new fabric.Gradient({
            type: 'linear',
            coords: {
                x1: gradientProps.coords.x1,
                y1: gradientProps.coords.y1,
                x2: gradientProps.coords.x2,
                y2: gradientProps.coords.y2
            },
            colorStops: gradientProps.colorStops
        });
    } else if (gradientProps.type === 'radial') {
        gradient = new fabric.Gradient({
            type: 'radial',
            coords: {
                r1: gradientProps.coords.r1,
                r2: gradientProps.coords.r2,
                x1: gradientProps.coords.x1,
                y1: gradientProps.coords.y1,
                x2: gradientProps.coords.x2,
                y2: gradientProps.coords.y2
            },
            colorStops: gradientProps.colorStops
        });
    }
  
    // Apply the constructed gradient to the object's fill
    if (gradient) {
        object.set('fill', gradient);
        object.setCoords(); // Update object's coordinates to reflect changes
  
        // If the object is part of a canvas, request a render to display changes
        if (object.canvas) {
            object.canvas.renderAll();
        }
    } else {
        console.error('Unsupported gradient type or missing properties.');
    }
  }
  
  /**
   * Inserts an SVG object into a Fabric.js canvas at a specified index.
   * @param {fabric.Canvas} canvas - The Fabric.js canvas instance.
   * @param {fabric.Object} svgObject - The SVG object to be inserted.
   * @param {number} index - The index at which to insert the SVG object.
   */
  function insertSvgIntoCanvas(canvas, svgObject, index) {
    // Add the SVG object to the canvas without rendering
    canvas.add(svgObject);
  
    // Move the SVG object to the specified index
    canvas.moveTo(svgObject, index);
  
    // Optional: Adjust the SVG object's position or other properties before rendering
    // svgObject.set({ top: 100, left: 100, scaleX: 0.5, scaleY: 0.5 });
  
    // Render the canvas to display changes
    canvas.renderAll();
  }
  
  /**
   * Performs final adjustments on the Fabric.js canvas. This function can be used to re-enable
   * rendering optimizations, apply global transformations, or execute callbacks after objects
   * have been loaded and modified.
   * @param {fabric.Canvas} canvas - The Fabric.js canvas instance to finalize.
   * @param {Function} [callback] - An optional callback function to execute after finalization.
   */
  function finalizeCanvas(canvas, callback) {
    // Re-enable rendering optimizations if they were disabled
    canvas.renderOnAddRemove = true;
  
    // Perform any necessary global transformations or adjustments
    // Example: canvas.setViewportTransform([scaleX, skewX, skewY, scaleY, translateX, translateY]);
  
    // Ensure the canvas is fully up to date
    canvas.renderAll();
  
    // Execute the callback function if provided
    if (typeof callback === 'function') {
        callback();
    }
  }
  
  /**
   * Loads objects onto a Fabric.js canvas from JSON data, sets the canvas background,
   * handles SVG custom data, and applies various properties using a series of modular functions.
   * @param {fabric.Canvas} canvas - The Fabric.js canvas instance.
   * @param {string} json - JSON string representing the objects to load onto the canvas.
   * @param {Array} svgCustomData - Array of objects containing custom SVG data.
   * @param {number} i - An index or identifier that might be used for layering or other logic.
   */
  function loadObjectOnCanvasFromJSON(canvas, json, svgCustomData, i) {
    // Load the canvas from JSON data
    canvas.loadFromJSON(json, function() {
        logDebug("Canvas loaded from JSON");
  
        // Assuming background settings are part of the JSON or separately defined
        // You might need to adjust this part to fit how your background settings are structured
        if (canvas.bgsrc) {
            setBackground(canvas, canvas.bgsrc, "", canvas.bgScale, i, true);
        }
        if (canvas.bgColor && typeof canvas.bgColor === 'string' && !canvas.bgsrc) {
            setBackground(canvas, "", canvas.bgColor, 1, i, true);
        }
  
        // Handle SVG custom data if provided
        if (svgCustomData && svgCustomData.length > 0) {
            handleSvgCustomData(canvas, svgCustomData, () => {
                logDebug("SVG custom data processed.");
                // Finalize canvas after SVG data has been handled
                finalizeCanvas(canvas, () => {
                    logDebug("Canvas finalized after handling SVG custom data.");
                });
            });
        } else {
            // Directly finalize the canvas if no SVG custom data to process
            finalizeCanvas(canvas, () => {
                logDebug("Canvas finalized without SVG custom data.");
            });
        }
    });
  }
  
  