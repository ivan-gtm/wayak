const express = require('express');
const bodyParser = require('body-parser');
const parseString = require('xml2js').parseString;

const app = express();
const PORT = 3000;

app.use(bodyParser.text({type: 'application/xml'}));

app.post('/convert', (req, res) => {
    const xml = req.body;

    parseString(xml, (err, result) => {
        if (err) {
            res.status(500).send('Failed to parse SVG');
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

        res.json(jsonResponse);
    });
});

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
