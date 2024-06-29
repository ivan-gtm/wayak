const fs = require('fs').promises;
const path = require('path');
const redis = require('redis');
const { fabric } = require('fabric');
const { JSDOM } = require('jsdom');
const { SVGPathData } = require('svg-pathdata');

console.log('Starting script...'); // Debug: Script start

// Create and connect to the Redis client
const client = redis.createClient({
    url: 'redis://127.0.0.1:6381'
});

console.log('Redis client created'); // Debug: Redis client creation

// Connect to Redis
(async () => {
  await client.connect();
  console.log('Connected to Redis'); // Debug: Redis connection
})();

// Handle Redis connection errors
client.on('error', (err) => console.log('Redis Client Error', err));

async function convertSvgToFabric(svgContent) {
    console.log('Converting SVG to Fabric...'); // Debug: SVG conversion start
    const dom = new JSDOM(svgContent);
    const document = dom.window.document;
    const { Node } = dom.window;

    // Create a temporary canvas
    const canvas = new fabric.Canvas(null, { width: 600, height: 400 });

    // Parse SVG content
    const svgElement = document.documentElement;

    // Get SVG dimensions
    const viewBox = svgElement.getAttribute('viewBox');
    let [minX, minY, width, height] = viewBox ? viewBox.split(' ').map(Number) : [0, 0, 600, 400];

    console.log(`Canvas size set to: ${width}x${height}`); // Debug: Canvas size

    // Set canvas size
    canvas.setWidth(width);
    canvas.setHeight(height);

    // Process SVG elements
    const fabricObjects = [];
    await processNode(svgElement, fabricObjects, Node);

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
            console.log('Added rectangle'); // Debug: Rectangle added
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
            console.log('Added circle'); // Debug: Circle added
            break;
        case 'path':
            const pathData = new SVGPathData(node.getAttribute('d'));
            const path = new fabric.Path(pathData.encode(), {
                fill: node.getAttribute('fill') || 'transparent',
                stroke: node.getAttribute('stroke') || 'transparent',
                strokeWidth: parseFloat(node.getAttribute('stroke-width') || 1)
            });
            fabricObjects.push(path);
            console.log('Added path'); // Debug: Path added
            break;
        case 'text':
            fabricObjects.push(new fabric.Text(node.textContent, {
                left: parseFloat(node.getAttribute('x') || 0),
                top: parseFloat(node.getAttribute('y') || 0),
                fontSize: parseFloat(node.getAttribute('font-size') || 16),
                fill: node.getAttribute('fill') || 'black'
            }));
            console.log('Added text'); // Debug: Text added
            break;
    }

    // Process child nodes
    for (const childNode of node.childNodes) {
        if (childNode.nodeType === Node.ELEMENT_NODE) {
            await processNode(childNode, fabricObjects, Node);
        }
    }
}

async function getRedisKeys(pattern) {
    console.log(`Fetching Redis keys with pattern: ${pattern}`); // Debug: Redis key fetching
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
    console.log(`Found ${keys.length} keys`); // Debug: Key count
    return keys;
}

async function getTemplatePages(collectionId) {
    console.log(`Processing collection: ${collectionId}`); // Debug: Collection processing
    const dirPath = `/Users/daniel/Documents/GitHub/wayak/public/corjl/design/template/${collectionId}`;
    const files = await fs.readdir(dirPath);
    const templates = {};

    for (const file of files) {
        if (file.startsWith('svg_template_') && file.endsWith('.svg')) {
            console.log(`Processing file: ${file}`); // Debug: File processing
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
                console.log(`Added template ${templateNum}, page ${match[2]}`); // Debug: Template page added
            }
        }
    }
    return templates;
}

async function processCollections() {
    console.log('Starting to process collections...'); // Debug: Collection processing start
    const keys = await getRedisKeys('corjl:*');

    for (const key of keys) {
        const collectionId = key.split(':')[1];
        console.log(`Processing collection ID: ${collectionId}`); // Debug: Collection ID
        const templates = await getTemplatePages(collectionId);

        for (const [templateNum, pages] of Object.entries(templates)) {
            const templateKey = `template:${templateNum}:jsondata`;
            await client.set(templateKey, JSON.stringify(pages));
            await client.hSet('corj:collections:converted_templates', templateKey, collectionId);
            console.log(`Saved template ${templateNum} to Redis`); // Debug: Template saved
        }
    }

    console.log('Templates processed and saved to Redis.');
}

// Call the function and handle any errors
processCollections()
    .then(() => console.log('Script completed successfully')) // Debug: Script completion
    .catch(error => console.error('Error during script execution:', error)) // Debug: Error logging
    .finally(() => {
        console.log('Closing Redis connection...'); // Debug: Redis disconnection
        client.quit();
    });