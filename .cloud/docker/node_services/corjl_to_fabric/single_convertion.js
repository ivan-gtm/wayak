const express = require('express');
const bodyParser = require('body-parser');
const { fabric } = require('fabric');
const { JSDOM } = require('jsdom');

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
    console.log(`Processing node: ${node.tagName}`); // Debug: Node processing
    switch (node.tagName.toLowerCase()) {
        case 'text':
            const parentNode = node.closest('g[id^="drawing_1_canvas_group_text_parent_"]');
            let [a, b, c, d, e, f] = [1, 0, 0, 1, 0, 0];

            if (parentNode) {
                const parentTransform = parentNode.getAttribute('transform');
                const matrixMatch = parentTransform.match(/matrix\(([^)]+)\)/);
                if (matrixMatch) {
                    [a, b, c, d, e, f] = matrixMatch[1].split(',').map(Number);
                }
            }

            const tspans = node.getElementsByTagName('tspan');
            const x = parseFloat(node.getAttribute('x') || 0);
            let y = parseFloat(node.getAttribute('y') || 0);
            const fontSize = parseFloat(node.getAttribute('font-size') || 16);
            const fill = node.getAttribute('fill') || 'black';
            const size = parseFloat(node.getAttribute('size') || 0);

            for (const tspan of tspans) {
                const dy = parseFloat(tspan.getAttribute('dy') || 0);
                y += dy;

                const transformedX = a * x + c * y + e;
                const transformedY = b * x + d * y + f;

                fabricObjects.push(new fabric.Textbox(tspan.textContent, {
                    originX: "center",
                    originY: "top",
                    left: transformedX,
                    top: transformedY + size,
                    fontSize,
                    fill,
                    textAlign: "right",
                    selectable: true,
                    editable: true,
                    evented: true
                }));

                console.log('Added text from tspan'); // Debug: Text added
            }
            break;

        case 'image':
            const xlinkHref = node.getAttribute('xlink:href');
            if (xlinkHref) {
                await new Promise((resolve, reject) => {
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
                        console.log('Added image'); // Debug: Image added
                        resolve();
                    }, { crossOrigin: 'Anonymous' });
                });
            }
            break;
    }

    // Process child nodes
    for (const childNode of node.childNodes) {
        if (childNode.nodeType === Node.ELEMENT_NODE) {
            await processNode(childNode, fabricObjects, Node);
        }
    }
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
