const express = require('express');
const { fabric } = require('fabric');
const { JSDOM } = require('jsdom');
const { createCanvas } = require('canvas');
const PDFDocument = require('pdfkit');
const app = express();
const port = 3000;

app.use(express.json());

const { window } = new JSDOM();
global.window = window;
global.document = window.document;

function generateImageFromJSON(jsonData, dimensions) {
    return new Promise((resolve, reject) => {
        const canvas = createCanvas(dimensions.width, dimensions.height);
        const fabricCanvas = new fabric.StaticCanvas(null, { width: dimensions.width, height: dimensions.height });

        fabricCanvas.loadFromJSON(jsonData, () => {
            fabricCanvas.renderAll();
            const dataUrl = fabricCanvas.toDataURL({
                format: 'png',
                multiplier: 1
            });
            resolve(dataUrl);
        });
    });
}

function createPDFWithImage(imageData, dimensions, res) {
    const doc = new PDFDocument({ size: [dimensions.width, dimensions.height] });
    res.setHeader('Content-Type', 'application/pdf');
    res.setHeader('Content-Disposition', 'attachment; filename="output.pdf"');
    doc.pipe(res);

    const imageBuffer = Buffer.from(imageData.split(",")[1], 'base64');
    doc.image(imageBuffer, 0, 0, { width: dimensions.width, height: dimensions.height });
    doc.end();
}

app.post('/documents/download-pdf-file', async (req, res) => {
    const dimensionsString = req.body[0];
    const dimensions = JSON.parse(dimensionsString.replace(/\+/g, ''));
    
    const promises = req.body.slice(1).map(jsonData => generateImageFromJSON(jsonData, dimensions));

    Promise.all(promises).then(imageDatas => {
        if (imageDatas.length > 0) {
            createPDFWithImage(imageDatas[0], dimensions, res);
        } else {
            res.status(400).send("No valid canvas objects found.");
        }
    }).catch(error => {
        console.error("Error generating image or PDF:", error);
        res.status(500).send("Error processing the request");
    });
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
