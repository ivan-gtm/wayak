const fs = require('fs').promises;
const path = require('path');
const redis = require('redis');
const { promisify } = require('util');
const { parse } = require('fast-xml-parser');

const client = redis.createClient();
const scanAsync = promisify(client.scan).bind(client);
const setAsync = promisify(client.set).bind(client);
const hsetAsync = promisify(client.hset).bind(client);

async function convertSvgToFabric(svgString) {
    return new Promise((resolve, reject) => {
        parseString(svgString, (err, result) => {
            if (err) {
                reject('Failed to parse SVG');
                return;
            }

            const svg = result.svg;
            const objects = [];
            const width = parseFloat(svg.$.width);
            const height = parseFloat(svg.$.height);

            svg.g.forEach(group => {
                if (group.image) {
                    group.image.forEach(img => {
                        const href = img.$['xlink:href'];
                        const obj = {
                            type: 'image',
                            src: href,
                            width: parseFloat(img.$.width),
                            height: parseFloat(img.$.height),
                            left: parseFloat(img.$.x),
                            top: parseFloat(img.$.y)
                        };
                        objects.push(obj);
                    });
                } else if (group.text) {
                    group.text.forEach(text => {
                        const tspan = text.tspan[0];
                        const obj = {
                            type: 'text',
                            text: tspan._,
                            left: parseFloat(text.$.x),
                            top: parseFloat(text.$.y),
                            fontFamily: text.$.fontFamily,
                            fontSize: parseFloat(text.$.fontSize),
                            fill: text.$.fill
                        };
                        objects.push(obj);
                    });
                } else if (group.rect) {
                    group.rect.forEach(rect => {
                        const width = parseFloat(rect.$.width);
                        const height = parseFloat(rect.$.height);
                        const x = parseFloat(rect.$.x);
                        const y = parseFloat(rect.$.y);
                        const fill = rect.$.fill;
                        const transform = rect.parentElement.$.transform;

                        if (width < height) { // Likely a line
                            let angle = 0;

                            // Extract the rotation angle from the transform attribute
                            if (transform && transform.includes('matrix')) {
                                const values = transform.match(/matrix\(([^)]+)\)/)[1].split(', ').map(parseFloat);
                                angle = Math.atan2(values[1], values[0]) * (180/Math.PI);
                            }

                            const halfHeight = height / 2;
                            const startX = x;
                            const startY = y + halfHeight;
                            const endX = x + height * Math.sin(angle * (Math.PI/180));
                            const endY = y + halfHeight - height * Math.cos(angle * (Math.PI/180));

                            const lineObj = {
                                type: 'line',
                                x1: startX,
                                y1: startY,
                                x2: endX,
                                y2: endY,
                                stroke: fill,
                                strokeWidth: width
                            };

                            objects.push(lineObj);
                        }
                    });
                }
            });

            const jsonResponse = {
                version: '4.7.1',
                objects: objects,
                background: 'white',
                width: width,
                height: height
            };

            resolve(jsonResponse);
        });
    });
}

async function getRedisKeys(pattern) {
    let cursor = '0';
    const keys = [];
    do {
        const res = await scanAsync(cursor, 'MATCH', pattern);
        cursor = res[0];
        keys.push(...res[1]);
    } while (cursor !== '0');
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
            await setAsync(templateKey, JSON.stringify(pages));
            // Storing the collection name for each template in a hash map
            await hsetAsync('corj:converted_templates', templateKey, collectionId);
        }
    }

    console.log('Templates processed and saved to Redis.');
}

processCollections();
