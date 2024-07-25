const express = require('express');
const redis = require('redis');
const { v4: uuidv4 } = require('uuid');
const { fabric } = require('fabric');
const { createCanvas, loadImage, registerFont } = require('canvas');
const path = require('path');
const fs = require('fs');

const app = express();
const port = 3000;

// Create Redis client
const redisClient = redis.createClient();

// Middleware to parse JSON bodies
app.use(express.json());

// Connect to Redis
(async () => {
  await redisClient.connect();
})();

// Global Set to keep track of loaded fonts
const loadedFonts = new Set();

// Function to convert URL to local path
function urlToLocalPath(url) {
  const localPrefix = '/Volumes/wayak/wayak/public/design';
  const urlPrefix = 'http://localhost:8001/design';
  return url.replace(urlPrefix, localPrefix);
}

// Function to load fabric object
async function loadFabricObject(obj) {
  const localPath = urlToLocalPath(obj.src);
  try {
    const img = await loadImage(localPath);
    return new fabric.Image(img, obj);
  } catch (error) {
    console.error(`Error loading image from ${localPath}:`, error);
    return null;
  }
}

// Function to load different types of fabric objects
async function createFabricObject(obj) {
  switch (obj.type) {
    case 'image':
      return await loadFabricObject(obj);
    case 'textbox':
      return new fabric.Textbox(obj.text, obj);
    case 'i-text':
      return new fabric.IText(obj.text, obj);
    case 'line':
      return new fabric.Line([obj.x1, obj.y1, obj.x2, obj.y2], obj);
    case 'circle':
      return new fabric.Circle(obj);
    case 'triangle':
      return new fabric.Triangle(obj);
    case 'ellipse':
      return new fabric.Ellipse(obj);
    case 'rect':
      return new fabric.Rect(obj);
    case 'polyline':
      return new fabric.Polyline(obj.points, obj);
    case 'polygon':
      return new fabric.Polygon(obj.points, obj);
    case 'path':
      return new fabric.Path(obj.path, obj);
    case 'group':
      const groupObjects = await Promise.all(obj.objects.map(createFabricObject));
      return new fabric.Group(groupObjects, obj);
    case 'path-group':
      const pathGroupObjects = await Promise.all(obj.objects.map(createFabricObject));
      return new fabric.PathGroup(pathGroupObjects, obj);
    default:
      return obj;
  }
}

// Function to load font if not already loaded
async function loadFont(fontId, fontPath) {
  if (loadedFonts.has(fontId)) return;

  const fontName = fontId;
  const fontFilePath = urlToLocalPath(fontPath);

  if (fs.existsSync(fontFilePath)) {
    registerFont(fontFilePath, { family: fontName });
    loadedFonts.add(fontId);
    console.log(`Font loaded: ${fontName} from ${fontFilePath}`);
  } else {
    console.error(`Font file not found: ${fontFilePath}`);
  }
}

// [Endpoint 1] - Start Customization Session
app.get('/start-session/:product_id', async (req, res) => {
  const productId = req.params.product_id;
  const sessionId = uuidv4().substring(0, 10);

  try {
    let templateMetadata = await redisClient.get(`template:en:${productId}:jsondata`);
    if (!templateMetadata) {
      return res.status(404).json({ error: 'Template not found' });
    }

    templateMetadata = templateMetadata.replace(/localhost/g, 'localhost:8001');
    const [dimensions, fabricJSON] = JSON.parse(templateMetadata);
    const textObjects = fabricJSON.objects
      .map((obj, index) => {
        const objectId = `text_${index}`;
        obj.objectId = objectId;
        if (['textbox', 'text', 'i-text', 'supertext'].includes(obj.type)) {
          return { objectId, text: obj.text, left: obj.left, top: obj.top, width: obj.width, height: obj.height };
        }
        return null;
      })
      .filter(obj => obj !== null);

    const modifiedMetadata = JSON.stringify([dimensions, fabricJSON]);
    await redisClient.set(`template:en:${sessionId}:demo:json`, modifiedMetadata, { EX: 3600 });

    res.json({ session_id: sessionId, template_info: { width: dimensions.width, height: dimensions.height, text_objects: textObjects } });
  } catch (error) {
    console.error('Error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// [Endpoint 2] - Generate Preview
app.post('/generate-preview', async (req, res) => {
  const { session_id, text, object_id } = req.body;

  try {
    const templateMetadata = await redisClient.get(`template:en:${session_id}:demo:json`);
    if (!templateMetadata) {
      return res.status(404).json({ error: 'Session not found or expired' });
    }

    const [dimensionsStr, fabricJSON] = JSON.parse(templateMetadata);
    const dimensions = JSON.parse(dimensionsStr);

    const fontLoadPromises = fabricJSON.objects
      .filter(obj => obj.fontFamily)
      .map(async (obj) => {
        const fontId = obj.fontFamily;
        const fontUrlResponse = await fetch(`http://localhost:8001/editor/get-woff-font-url?font_id=${fontId}`);
        const fontUrlData = await fontUrlResponse.json();
        if (fontUrlData.success) {
          await loadFont(fontId, fontUrlData.url);
        }
      });

    await Promise.all(fontLoadPromises);

    fabricJSON.objects = fabricJSON.objects.map(obj => {
      if (obj.objectId === object_id) {
        obj.text = text;
      }
      return obj;
    });

    const updatedTemplateMetadata = JSON.stringify([dimensionsStr, fabricJSON]);
    await redisClient.set(`template:en:${session_id}:demo:json`, updatedTemplateMetadata);

    const canvas = createCanvas(dimensions.width, dimensions.height);
    const fabricCanvas = new fabric.StaticCanvas(null, {
      width: dimensions.width,
      height: dimensions.height,
      renderOnAddRemove: false
    });

    const loadedObjects = await Promise.all(fabricJSON.objects.map(createFabricObject));
    loadedObjects.forEach(obj => {
      if (obj) fabricCanvas.add(obj);
    });

    const watermark = new fabric.Text('PREVIEW', {
      fontSize: 40,
      opacity: 0.5,
      angle: -45,
      left: dimensions.width / 2,
      top: dimensions.height / 2,
      originX: 'center',
      originY: 'center'
    });
    fabricCanvas.add(watermark);

    fabricCanvas.renderAll();

    const dataURL = fabricCanvas.toDataURL();
    const img = await loadImage(dataURL);
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);

    const maxWidth = 600;
    const maxHeight = 800;
    const aspectRatio = dimensions.width / dimensions.height;
    let newWidth, newHeight;

    if (dimensions.width > dimensions.height) {
      newWidth = Math.min(dimensions.width, maxWidth);
      newHeight = newWidth / aspectRatio;
    } else {
      newHeight = Math.min(dimensions.height, maxHeight);
      newWidth = newHeight * aspectRatio;
    }

    const resizedCanvas = createCanvas(newWidth, newHeight);
    const resizedCtx = resizedCanvas.getContext('2d');
    resizedCtx.drawImage(canvas, 0, 0, newWidth, newHeight);

    const buffer = resizedCanvas.toBuffer('image/png');
    res.contentType('image/png');
    res.send(buffer);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// Error handling middleware
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).send('Something broke!');
});

// Start the server
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});

// Graceful shutdown
process.on('SIGINT', async () => {
  console.log('Shutting down gracefully...');
  await redisClient.quit();
  process.exit(0);
});
