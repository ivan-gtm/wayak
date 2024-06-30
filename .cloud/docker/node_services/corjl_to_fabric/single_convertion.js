const express = require('express');
const bodyParser = require('body-parser');
const { fabric } = require('fabric');
const { JSDOM } = require('jsdom');
const { SVGPathData } = require('svg-pathdata');
const { round } = require('lodash');


const app = express();
const port = 3000;

// Increase the size limit to 50MB (adjust as needed)
const sizeLimit = '50mb';

// Use raw body parser for text/plain with increased size limit
app.use(bodyParser.raw({ type: 'text/plain', limit: sizeLimit }));

// Also increase the limit for JSON and URL-encoded data
app.use(bodyParser.json({ limit: sizeLimit }));
app.use(bodyParser.urlencoded({ extended: true, limit: sizeLimit }));

console.log('Starting server...'); // Debug: Server start

async function convertSvgToFabric(svgContent) {
    console.log('Converting SVG to Fabric...'); // Debug: SVG conversion start
    const dom = new JSDOM(svgContent);
    const document = dom.window.document;
    const { Node } = dom.window;

    // Parse SVG content
    const svgElement = document.documentElement;

    // Get SVG dimensions
    const width = parseFloat(svgElement.getAttribute('width')) || 1500;
    const height = parseFloat(svgElement.getAttribute('height')) || 2100;

    console.log(`Canvas size set to: ${width}x${height}`); // Debug: Canvas size

    // Create canvas with SVG dimensions
    const canvas = new fabric.Canvas(null, { width, height });

    // Process SVG elements
    const fabricObjects = [];
    await processNode(svgElement, fabricObjects, Node);

    // // Reverse the order of fabric objects
    // fabricObjects.reverse();

    console.log(`Processed ${fabricObjects.length} Fabric objects`); // Debug: Object count

    // Add objects to canvas
    canvas.add(...fabricObjects);

    // Convert canvas to JSON
    const json = canvas.toJSON();

    console.log('SVG converted to Fabric JSON'); // Debug: Conversion complete
    return json;
}

async function processNode(node, fabricObjects, Node) {
    console.log(`Processing node: ${node.tagName.toLowerCase()}`);

    switch (node.tagName.toLowerCase()) {
        case 'text':
            handleTextNode(node, fabricObjects);
            break;

        case 'image':
            await handleImageNode(node, fabricObjects);
            break;

        // case 'rect':
        //     handleRectNode(node, fabricObjects);
        //     break;

        case 'circle':
            handleCircleNode(node, fabricObjects);
            break;

        // case 'path':
        //     handlePathNode(node, fabricObjects);
        //     break;
    }

    for (const childNode of node.childNodes) {
        if (childNode.nodeType === Node.ELEMENT_NODE) {
            await processNode(childNode, fabricObjects, Node);
        }
    }
}

function handleTextNode(node, fabricObjects) {
    console.log(`\n<<<<<>>>>>>`);
    let parentNode = node.closest('g[id^="drawing_1_canvas_group_element_"]');
    let textParentNode = node.closest('g[id^="drawing_1_canvas_group_text_parent_"]');
    console.log(`parentNode: ${node.outerHTML}`);
    console.log(`parentNode: ${parentNode.outerHTML}`);
    console.log(`textParentNode: ${textParentNode.outerHTML}`);

    let [a, b, c, d, matrixX, matrixY] = [1, 0, 0, 1, 0, 0];
    if (parentNode && textParentNode) {
        console.log('Parent node found:');
        let parentTransform = textParentNode.getAttribute('transform');
        console.log(`Parent transform: ${parentTransform}`);
        let matrixMatch = parentTransform.match(/matrix\(([^)]+)\)/);
        if (matrixMatch) {
            [a, b, c, d, matrixX, matrixY] = matrixMatch[1].split(',').map(Number);
            console.log(`Matrix values: a=${a}, b=${b}, c=${c}, d=${d}, matrixX=${matrixX}, matrixY=${matrixY}`);
        }
    } else {
        console.log('No parent node found');
    }

    let rectElement = parentNode ? parentNode.querySelector('rect[id^="drawing_1_canvas_rect_"]') : null;
    let rectAreaWidth = 0, rectAreaHeight = 0, rectAreaX = 0, rectAreaY = 0;
    if (rectElement) {
        rectAreaWidth = parseFloat(rectElement.getAttribute('width') || 0);
        rectAreaHeight = parseFloat(rectElement.getAttribute('height') || 0);
        rectAreaX = parseFloat(rectElement.getAttribute('x') || 0);
        rectAreaY = parseFloat(rectElement.getAttribute('y') || 0);
        console.log(`Rect dimensions: width=${rectAreaWidth}, height=${rectAreaHeight}`);
    } else {
        console.log('No rect element found');
    }

    let tspans = node.getElementsByTagName('tspan');
    let x = parseFloat(node.getAttribute('x') || 0);
    let y = parseFloat(node.getAttribute('y') || 0);
    let fontSize = parseFloat(node.getAttribute('font-size') || 16);
    let fill = node.getAttribute('fill') || 'black';

    for (let tspan of tspans) {
        let dy = parseFloat(tspan.getAttribute('dy') || 0);
        let dx = parseFloat(tspan.getAttribute('x') || 0);
        console.log(`<<TEXTO>>: ${tspan.textContent}`);
        fabricObjects.push(new fabric.Textbox(tspan.textContent, {
            left: rectAreaX,
            top: round(matrixY + y + dy),
            height: rectAreaHeight,
            width: rectAreaWidth,
            fontSize,
            fill,
            textAlign: "right",
            selectable: true,
            editable: true,
            evented: true
        }));
        console.log('Added text from tspan');
    }
}

async function handleImageNode(node, fabricObjects) {
    let xlinkHref = node.getAttribute('xlink:href');
    if (xlinkHref) {
        await new Promise((resolve) => {
            fabric.Image.fromURL(xlinkHref, (img) => {
                const containerWidth = parseFloat(node.getAttribute('width'));
                const containerHeight = parseFloat(node.getAttribute('height'));
                const scaleX = containerWidth / img.width;
                const scaleY = containerHeight / img.height;

                if (scaleX > scaleY) {
                    img.scaleToWidth(containerWidth);
                } else {
                    img.scaleToHeight(containerHeight);
                }

                img.set({
                    left: parseFloat(node.getAttribute('x') || 0) + (containerWidth - img.getScaledWidth()) / 2,
                    top: parseFloat(node.getAttribute('y') || 0) + (containerHeight - img.getScaledHeight()) / 2,
                    originX: 'left',
                    originY: 'top'
                });

                fabricObjects.push(img);
                console.log('Added image');
                resolve();
            }, { crossOrigin: 'Anonymous' });
        });
    }
}

function handleRectNode(node, fabricObjects) {
    fabricObjects.push(new fabric.Rect({
        left: parseFloat(node.getAttribute('x') || 0),
        top: parseFloat(node.getAttribute('y') || 0),
        width: parseFloat(node.getAttribute('width')),
        height: parseFloat(node.getAttribute('height')),
        fill: node.getAttribute('fill') || 'transparent',
        stroke: node.getAttribute('stroke') || 'transparent',
        strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
    }));
    console.log('Added rectangle');
}

function handleCircleNode(node, fabricObjects) {
    fabricObjects.push(new fabric.Circle({
        left: parseFloat(node.getAttribute('cx')) - parseFloat(node.getAttribute('r')),
        top: parseFloat(node.getAttribute('cy')) - parseFloat(node.getAttribute('r')),
        radius: parseFloat(node.getAttribute('r')),
        fill: node.getAttribute('fill') || 'transparent',
        stroke: node.getAttribute('stroke') || 'transparent',
        strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
    }));
    console.log('Added circle');
}

function handlePathNode(node, fabricObjects) {
    const pathData = new SVGPathData(node.getAttribute('d'));
    const path = new fabric.Path(pathData.encode(), {
        fill: node.getAttribute('fill') || 'transparent',
        stroke: node.getAttribute('stroke') || 'transparent',
        strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
    });
    fabricObjects.push(path);
    console.log('Added path');
}


app.post('/convert', async (req, res) => {
    console.log('Received SVG conversion request'); // Debug: Request received
    try {
        let svgContent;
        if (Buffer.isBuffer(req.body)) {
            svgContent = req.body.toString('utf8');
        } else if (typeof req.body === 'string') {
            svgContent = req.body;
        } else {
            throw new Error('Invalid content type received');
        }

        console.log('Received SVG content:', svgContent.substring(0, 100) + '...'); // Log the first 100 characters

        if (!svgContent || typeof svgContent !== 'string' || !svgContent.trim().startsWith('<')) {
            throw new Error('Invalid SVG content received');
        }

        const fabricJson = await convertSvgToFabric(svgContent);
        res.json(fabricJson);
        console.log('Conversion successful, sent response'); // Debug: Response sent
    } catch (error) {
        console.error('Error during conversion:', error); // Debug: Error logging
        res.status(500).json({ error: error.message || 'Failed to convert SVG' });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`); // Debug: Server started
});
