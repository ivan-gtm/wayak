function logDebugInfo(message, data = '') {
    if (DEBUG) {
        console.log(message, data);
    }
}

function setCanvasBackground(lcanvas, bgImageSrc, bgColor, bgScale, index, forceImageBackground = false) {
    if (bgImageSrc) {
        // Sets the canvas background image
        setCanvasBg(lcanvas, bgImageSrc, "", bgScale, index, forceImageBackground);
    } else if (bgColor && typeof bgColor === 'string' && !bgImageSrc) {
        // Sets the canvas background color if no image source is provided
        setCanvasBg(lcanvas, "", bgColor, 1, index);
    }
}

function loadSVGData(lcanvas, svgData, svgIndex) {
    if (!svgData || typeof svgData.src === 'undefined') return;

    fabric.loadSVGFromURL(svgData.src, function(objects, options, svgElements, allSvgElements) {
        var loadedObject = keepSvgGroups(objects, svgElements, allSvgElements, options);
        
        logDebugInfo("loadedObject", loadedObject);
        
        lcanvas.discardActiveObject().renderAll();
        
        applyObjectProperties(loadedObject, svgData, svgIndex);

        // After all properties have been applied, add the object to the canvas
        lcanvas.add(loadedObject);
        loadedObject.setCoords();
        
        // Finalize the object's setup
        finalizeObject(loadedObject, svgData, svgIndex, lcanvas);
    });
}

function applyObjectProperties(loadedObject, svgData, svgIndex) {
    // Basic properties
    loadedObject.set({
        top: svgData.top,
        left: svgData.left,
        shadow: svgData.shadow,
        stroke: svgData.stroke,
        strokeWidth: svgData.strokeWidth,
        opacity: svgData.opacity,
        index: svgIndex,
        locked: svgData.locked,
        src: svgData.src,
        svg_custom_paths: svgData.svg_custom_paths,
        originX: svgData.originX || "center",
        originY: svgData.originY || "center",
        width: svgData.width,
        height: svgData.height
    });

    // Conditional properties
    if (svgData.fill) {
        if (typeof svgData.fill === 'string') {
            loadedObject.fill = svgData.fill;
        } else if (typeof svgData.fill === 'object' && (svgData.fill.type === 'Dpattern' || svgData.fill.type === 'pattern')) {
            try {
                fabric.Dpattern.fromObject(svgData.fill, function(fillPattern) {
                    loadedObject.set({ fill: fillPattern, dirty: true });
                });
            } catch (e) {
                console.log("Error setting fill pattern:", e, svgData.fill);
                // Fallback to directly setting the fill property in case of error
                loadedObject.fill = svgData.fill;
            }
        }
    }

    // Apply gradient if applicable
    var gradientType = getGradientTypeofObject(svgData);
    if (gradientType !== false) {
        applyGradient(svgData.fill.colorStops[0].color, svgData.fill.colorStops[1].color, gradientType, loadedObject);
    } else {
        // This seems like a fallback or alternate gradient application method
        // The implementation will depend on the specifics of applyGradient2
        applyGradient2(svgData, loadedObject);
    }

    // Set transformation properties
    updateObjectPosition(loadedObject, svgData);

    // Here we assume that applyGradient, applyGradient2, and updateObjectPosition are implemented elsewhere.
    // These functions handle specific property applications based on SVG data.
}

function finalizeObject(loadedObject, svgData, svgIndex, lcanvas) {
    // Set additional properties like scaleX, scaleY, flipX, flipY, angle
    loadedObject.set({
        scaleX: svgData.scaleX || 1,
        scaleY: svgData.scaleY || 1,
        flipX: svgData.flipX || false,
        flipY: svgData.flipY || false,
        angle: svgData.angle || 0
    });

    // Adjust position if origin is not centered
    if (loadedObject.originX !== 'center' || loadedObject.originY !== 'center') {
        const centerPoint = loadedObject.getCenterPoint();
        loadedObject.set({
            left: centerPoint.x,
            top: centerPoint.y,
            originX: 'center',
            originY: 'center'
        });
    }

    // Ensure the object's coordinates are updated
    loadedObject.setCoords();

    // Optionally, handle custom path operations or additional customizations
    processSVGCustomPaths(loadedObject, svgData, svgIndex);

    // Ensure the object has a rotating point if needed
    if (svgData.hasRotatingPoint) {
        loadedObject.hasRotatingPoint = true;
    }

    // If there's any additional behavior or adjustments needed for the object, apply them here

    // Finally, ensure the canvas is updated with the new object
    lcanvas.renderAll();
}

function applyFillPattern(loadedObject, svgData) {
    if (typeof svgData.fill === 'object' && (svgData.fill.type === 'Dpattern' || svgData.fill.type === 'pattern')) {
        try {
            fabric.Dpattern.fromObject(svgData.fill, function(pattern) {
                loadedObject.set({ fill: pattern });
                loadedObject.dirty = true; // Mark the object as needing a re-render
            });
        } catch (error) {
            console.error("Error applying fill pattern:", error, svgData.fill);
            // Fallback to a default fill if the pattern application fails
            loadedObject.fill = 'gray'; // Example fallback color
            loadedObject.dirty = true;
        }
    }
}

function applyGradientFill(loadedObject, svgData) {
    // Check if gradient fill data is available
    if (svgData.fill && typeof svgData.fill === 'object' && svgData.fill.type === 'gradient') {
        var gradientOptions = {};

        if (svgData.fill.gradientType === 'linear') {
            gradientOptions = {
                type: 'linear',
                coords: {
                    x1: svgData.fill.coords.x1,
                    y1: svgData.fill.coords.y1,
                    x2: svgData.fill.coords.x2,
                    y2: svgData.fill.coords.y2
                },
                colorStops: svgData.fill.colorStops
            };
        } else if (svgData.fill.gradientType === 'radial') {
            gradientOptions = {
                type: 'radial',
                coords: {
                    r1: svgData.fill.coords.r1,
                    r2: svgData.fill.coords.r2,
                    cx: svgData.fill.coords.cx,
                    cy: svgData.fill.coords.cy,
                    fx: svgData.fill.coords.fx,
                    fy: svgData.fill.coords.fy
                },
                colorStops: svgData.fill.colorStops
            };
        }

        // Create the gradient fill
        var gradient = new fabric.Gradient(gradientOptions);

        // Apply the gradient fill to the loaded object
        loadedObject.set({ fill: gradient });
    }
}

function processSVGCustomPaths(loadedObject, svgData, svgIndex) {
    if (typeof svgData.svg_custom_paths !== 'object' || !svgData.svg_custom_paths.length) {
        return; // No custom paths to process
    }

    svgData.svg_custom_paths.forEach((pathData, pathIndex) => {
        if (!pathData || typeof pathData.action === 'undefined') return;

        // Assuming loadedObject could be a group of objects (e.g., when loading complex SVGs)
        var targetObject = loadedObject._objects ? loadedObject._objects[pathIndex] : loadedObject;

        switch (pathData.action) {
            case 'fill':
                // Apply fill color or gradient
                if (typeof pathData.color_value === 'string') {
                    targetObject.set('fill', pathData.color_value);
                } else if (typeof pathData.color_value === 'object' && pathData.color_value.type === 'gradient') {
                    // Here, you would call a function similar to applyGradientFill but tailored for individual paths
                    applyPathGradientFill(targetObject, pathData.color_value);
                }
                break;
            case 'stroke':
                // Apply stroke color
                targetObject.set('stroke', pathData.color_value);
                if (pathData.strokeWidth !== undefined) {
                    targetObject.set('strokeWidth', pathData.strokeWidth);
                }
                break;
            default:
                console.warn('Unknown action for custom path:', pathData.action);
        }
    });

    // Ensure the object is updated on the canvas
    if (loadedObject._updateObjectsCoords) {
        loadedObject._updateObjectsCoords(); // For groups, update coordinates of all objects
    }
    loadedObject.setCoords(); // Update the coordinates of the parent object or individual path
}

function updateObjectPosition(loadedObject, svgData) {
    // Apply scale, flip, and rotation properties
    loadedObject.set({
        scaleX: svgData.scaleX || 1,
        scaleY: svgData.scaleY || 1,
        flipX: !!svgData.flipX,
        flipY: !!svgData.flipY,
        angle: svgData.angle || 0
    });

    // Update position if specified, considering the object's current origin point
    if (svgData.top !== undefined && svgData.left !== undefined) {
        loadedObject.setPositionByOrigin(new fabric.Point(svgData.left, svgData.top), 'center', 'center');
    }

    // Adjust origin to center for rotation and scaling, if not already set
    if (loadedObject.originX !== 'center' || loadedObject.originY !== 'center') {
        const center = loadedObject.getCenterPoint();
        loadedObject.set({
            originX: 'center',
            originY: 'center',
            left: center.x,
            top: center.y
        });
    }

    loadedObject.setCoords(); // Update the object's coordinates for interaction and rendering
}

function finalizeObjectExpanded(loadedObject, lcanvas) {
    // Ensure the object is fully integrated into the canvas environment
    lcanvas.add(loadedObject);
    loadedObject.setCoords();

    // Apply any final transformations or adjustments that may be needed
    // This could include alignment checks, ensuring the object is within canvas bounds, etc.

    // Trigger a canvas re-render to display the newly added object
    lcanvas.renderAll();

    // Additional checks or operations after the object has been added and rendered
    // Example: Checking the object's visibility within the current viewport
    checkObjectVisibility(loadedObject, lcanvas);

    // Any additional logging or operations to signify completion of the object's integration
    console.log('Object finalized and added to canvas:', loadedObject);
}

function checkObjectVisibility(object, canvas) {
    // Placeholder for visibility checks or adjustments
    // This could involve scrolling the canvas to the object's location or adjusting zoom
}

function processSVGCustomeData(lcanvas, svgCustomeData, svgIndex) {
    if (!svgCustomeData || svgCustomeData.length === 0) return;

    svgCustomeData.forEach((customeDataItem, index) => {
        if (customeDataItem && customeDataItem.src) {
            // Assuming customeDataItem contains SVG data similar to the primary SVG
            fabric.loadSVGFromURL(customeDataItem.src, function(objects, options) {
                var customeObject = fabric.util.groupSVGElements(objects, options);

                // Apply basic properties from the customeDataItem, similar to how primary SVG data was handled
                customeObject.set({
                    left: customeDataItem.left || 0,
                    top: customeDataItem.top || 0,
                    scaleX: customeDataItem.scaleX || 1,
                    scaleY: customeDataItem.scaleY || 1,
                    angle: customeDataItem.angle || 0,
                    opacity: customeDataItem.opacity || 1
                });

                // Apply any special handling or properties specific to custome data
                // For example, handling custom interactions, bindings, or visibility conditions

                // Finalize the custom object's setup and add it to the canvas
                lcanvas.add(customeObject);
                customeObject.setCoords();

                // Optionally, log the addition or perform additional operations specific to custom SVG data
                console.log(`Custom SVG data processed and added at index: ${svgIndex}, custom index: ${index}`);
            });
        }
    });

    // After processing all custom SVG data, optionally re-render the canvas or perform additional checks
    lcanvas.renderAll();
}

function checkAndLoadGroupsSVGLoading(lcanvas, svgIndex) {
    // Assuming there's a way to identify groups within the canvas that may have associated SVG data to load
    lcanvas.getObjects().forEach((obj, index) => {
        if (obj.type === 'group' && obj.needsSVGLoading) {
            // Placeholder for the logic to load SVG content for the group
            // This could involve checking a property on the group for an SVG URL or data to load
            let svgDataForGroup = obj.svgData; // Assuming each group has an 'svgData' property with the SVG data or URL
            
            if (svgDataForGroup) {
                // Load the SVG data for the group. This could be a URL or direct SVG content.
                // The specific loading function would depend on how your application handles SVG loading,
                // similar to the initial SVG loading process for the canvas.
                loadSVGDataForGroup(lcanvas, obj, svgDataForGroup, index);
            }
        }
    });

    // After checking and potentially loading SVGs for all groups, you might want to update the canvas
    lcanvas.renderAll();
}

function loadSVGDataForGroup(lcanvas, group, svgData, groupIndex) {
    // This function is a placeholder for the actual SVG loading logic for a group.
    // It would involve loading the SVG (possibly using fabric.loadSVGFromURL or similar),
    // then processing the loaded SVG to create fabric objects,
    // and finally adding these objects to the group.
    
    console.log(`Loading SVG data for group at index ${groupIndex}.`);
    // Example: Load SVG, then add to group
    // fabric.loadSVGFromURL(svgData.url, function(objects, options) {
    //     var svgGroup = fabric.util.groupSVGElements(objects, options);
    //     group.addWithUpdate(svgGroup);
    //     lcanvas.renderAll();
    // });
}

function setDemoOverlayIfNeeded(lcanvas) {
    // Check if the demo mode is active; this might depend on a global variable or a property of the canvas
    if (demo_as_id) { // Assuming `demo_as_id` is a flag indicating demo mode is active
        // Define the overlay properties
        const overlayText = 'DEMO MODE ACTIVE';
        const overlayOptions = {
            left: lcanvas.width / 2,
            top: lcanvas.height / 2,
            fontSize: 20,
            fontStyle: 'italic',
            fill: '#FF0000',
            stroke: '#FFFFFF',
            strokeWidth: 2,
            selectable: false,
            evented: false,
            opacity: 0.5
        };

        // Create a text object for the overlay
        const overlay = new fabric.Text(overlayText, overlayOptions);

        // Adjust the text object's position to be centered
        overlay.set({
            originX: 'center',
            originY: 'center'
        });

        // Add the overlay to the canvas
        lcanvas.add(overlay);

        // Optionally, bring the overlay to the front
        lcanvas.bringToFront(overlay);

        // Render the canvas to display the overlay
        lcanvas.renderAll();

        setDemoOverlay();
    }
}

// Assuming all helper functions (1-12) are defined elsewhere in the script
function loadObjectOnCanvasFromJSON(lcanvas, json, svg_custom_data12, i) {
    logDebugInfo("loadObjectOnCanvasFromJSON() Start", json);

    lcanvas.renderOnAddRemove = false;

    lcanvas.loadFromJSON(json, function() {
        setCanvasBackground(lcanvas, lcanvas.bgsrc, lcanvas.bgColor, lcanvas.bgScale, i);

        if (svg_custom_data12 && svg_custom_data12.length > 0) {
            $.each(svg_custom_data12, function(svg_i, svg_data) {
                loadSVGData(lcanvas, svg_data, svg_i, function() {
                    // Check and load groups if needed after loading SVG data
                    if (svg_custom_data12.length == svg_i + 1) { // Last iteration
                        checkIfGroupsNeedsSVGLoading(lcanvas, i);
                    }
                });
            });
        } else {
            // If there's no custom SVG data, directly check if groups need SVG loading
            checkIfGroupsNeedsSVGLoading(lcanvas, i);
        }

        // Set the demo overlay if needed
        setDemoOverlayIfNeeded(lcanvas);
    });

    // Additional or alternative global settings or overlays could be managed here
}

// Adjust the loadSVGData function to include a callback for when SVG data loading and processing are complete
function loadSVGData(lcanvas, svgData, svgIndex, callback) {
    if (!svgData || typeof svgData.src === 'undefined') return;

    fabric.loadSVGFromURL(svgData.src, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        applyObjectProperties(loadedObject, svgData, svgIndex);
        finalizeObject(loadedObject, lcanvas);
        processSVGCustomeData(lcanvas, svgData.svg_custom_data, svgIndex);

        // Call the callback function if provided, to allow for sequential operations
        if (typeof callback === 'function') {
            callback();
        }
    });
}
