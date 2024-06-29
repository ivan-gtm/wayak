const fs = require('fs').promises;
const path = require('path');
const redis = require('redis');
const { fabric } = require('fabric');
const { JSDOM } = require('jsdom');
const { SVGPathData } = require('svg-pathdata');

// Create and connect to the Redis client
const client = redis.createClient();

// Connect to Redis
(async () => {
  await client.connect();
})();

// Handle Redis connection errors
client.on('error', (err) => console.log('Redis Client Error', err));

async function convertSvgToFabric(svgContent) {
    const { window } = new JSDOM();
    global.window = window;
    global.document = window.document;

    // Create a temporary canvas
    const canvas = new fabric.Canvas(null, { width: 600, height: 400 });

    // Parse SVG content
    const parser = new DOMParser();
    const svgDoc = parser.parseFromString(svgContent, 'image/svg+xml');
    const svgElement = svgDoc.documentElement;

    // Get SVG dimensions
    const viewBox = svgElement.getAttribute('viewBox');
    let [minX, minY, width, height] = viewBox ? viewBox.split(' ').map(Number) : [0, 0, 600, 400];

    // Set canvas size
    canvas.setWidth(width);
    canvas.setHeight(height);

    // Process SVG elements
    const fabricObjects = [];
    await processNode(svgElement, fabricObjects);

    // Add objects to canvas
    canvas.add(...fabricObjects);

    // Convert canvas to JSON
    const json = canvas.toJSON();

    return json;
}

async function processNode(node, fabricObjects) {
    switch (node.tagName.toLowerCase()) {
        case 'rect':
            fabricObjects.push(new fabric.Rect({
                left: parseFloat(node.getAttribute('x') || 0),
                top: parseFloat(node.getAttribute('y') || 0),
                width: parseFloat(node.getAttribute('width')),
                height: parseFloat(node.getAttribute('height')),
                fill: node.getAttribute('fill') || 'transparent',
                stroke: node.getAttribute('stroke') || 'transparent',
                strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
            }));
            break;
        case 'circle':
            fabricObjects.push(new fabric.Circle({
                left: parseFloat(node.getAttribute('cx')) - parseFloat(node.getAttribute('r')),
                top: parseFloat(node.getAttribute('cy')) - parseFloat(node.getAttribute('r')),
                radius: parseFloat(node.getAttribute('r')),
                fill: node.getAttribute('fill') || 'transparent',
                stroke: node.getAttribute('stroke') || 'transparent',
                strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
            }));
            break;
        case 'path':
            const pathData = new SVGPathData(node.getAttribute('d'));
            const path = new fabric.Path(pathData.encode(), {
                fill: node.getAttribute('fill') || 'transparent',
                stroke: node.getAttribute('stroke') || 'transparent',
                strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
            });
            fabricObjects.push(path);
            break;
        case 'text':
            fabricObjects.push(new fabric.Text(node.textContent, {
                left: parseFloat(node.getAttribute('x') || 0),
                top: parseFloat(node.getAttribute('y') || 0),
                fontSize: parseFloat(node.getAttribute('font-size') || 16),
                fill: node.getAttribute('fill') || 'black'
            }));
            break;
    }

    // Process child nodes
    for (const childNode of node.childNodes) {
        if (childNode.nodeType === Node.ELEMENT_NODE) {
            await processNode(childNode, fabricObjects);
        }
    }
}

async function getRedisKeys(pattern) {
    let cursor = 0;
    const keys = [];
    do {
        const result = await client.scan(cursor, {
            MATCH: pattern,
            COUNT: 100
        });
        cursor = result.cursor;
        keys.push(...result.keys);
    } while (cursor !== 0);
    return keys;
}

async function getTemplatePages(collectionId) {
    const dirPath = `/public/corjl/design/template/${collectionId}`;
    const files = await fs.readdir(dirPath);
    const templates = {};

    for (const file of files) {
        if (file.startsWith('svg_template_') && file.endsWith('.svg')) {
            const match = file.match(/svg_template_(\d+)_page_(\d+)\.svg/);
            if (match) {
                const templateNum = match[1];
                const filePath = path.join(dirPath, file);
                const svgData = await fs.readFile(filePath, 'utf8');
                const fabricJson = await convertSvgToFabric(svgData);
                if (!templates[templateNum]) {
                    templates[templateNum] = [];
                }
                templates[templateNum].push(fabricJson);
            }
        }
    }
    return templates;
}

async function processCollections() {
    const keys = await getRedisKeys('corjl:*');

    for (const key of keys) {
        const collectionId = key.split(':')[1];
        const templates = await getTemplatePages(collectionId);

        for (const [templateNum, pages] of Object.entries(templates)) {
            const templateKey = `template:${templateNum}:jsondata`;
            await client.set(templateKey, JSON.stringify(pages));
            await client.hSet('corj:collections:converted_templates', templateKey, collectionId);
        }
    }

    console.log('Templates processed and saved to Redis.');
}

// Call the function and handle any errors
processCollections()
    .catch(console.error)
    .finally(() => client.quit());