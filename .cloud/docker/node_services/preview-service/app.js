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
  console.log('Connected to Redis');
})();

// Global Set to keep track of loaded fonts
const loadedFonts = new Set();

// Function to convert URL to local path
function urlToLocalPath(url) {
  const localPrefix = '/Volumes/wayak/wayak/public/design';
  const urlPrefix = 'http://localhost:8001/design';
  console.log(`Converting URL: ${url} to local path`);
  return url.replace(urlPrefix, localPrefix);
}

// Function to load fabric object
async function loadFabricObject(obj) {
  console.log(`Attempting to load fabric object of type: ${obj.type}`);
  const localPath = urlToLocalPath(obj.src);
  console.log(`Local path for object: ${localPath}`);
  try {
    console.log(`Loading image from: ${localPath}`);
    const img = await loadImage(localPath);
    console.log('Image loaded successfully');
    let fabricImage = new fabric.Image(img, { ...obj, filters: [] });
    console.log('Fabric Image object created');

    // Only attempt to apply filters if they exist
    if (obj.filters && obj.filters.length > 0) {
      console.log(`Attempting to apply ${obj.filters.length} filters`);
      try {
        fabricImage.filters = obj.filters.map(filterObj => {
          console.log(`Applying filter: ${filterObj.type}`);
          const FilterClass = fabric.Image.filters[filterObj.type];
          return new FilterClass(filterObj);
        });
        fabricImage.applyFilters();
        console.log('Filters applied successfully');
      } catch (filterError) {
        console.warn(`Warning: Failed to apply filters to image ${localPath}. Loading without filters.`, filterError);
        // If filter application fails, we keep the image without filters
      }
    }

    console.log('Fabric object loaded successfully');
    return fabricImage;
  } catch (error) {
    console.error(`Error loading image from ${localPath}:`, error);
    return null;
  }
}

// Function to load different types of fabric objects
async function createFabricObject(obj) {
  console.log(`Creating fabric object of type: ${obj.type}`);
  switch (obj.type) {
    case 'image':
      return await loadFabricObject(obj);
    case 'textbox':
      console.log('Creating textbox object');
      return new fabric.Textbox(obj.text, obj);
    case 'i-text':
      console.log('Creating i-text object');
      return new fabric.IText(obj.text, obj);
    case 'line':
      console.log('Creating line object');
      return new fabric.Line([obj.x1, obj.y1, obj.x2, obj.y2], obj);
    case 'circle':
      console.log('Creating circle object');
      return new fabric.Circle(obj);
    case 'triangle':
      console.log('Creating triangle object');
      return new fabric.Triangle(obj);
    case 'ellipse':
      console.log('Creating ellipse object');
      return new fabric.Ellipse(obj);
    case 'rect':
      console.log('Creating rectangle object');
      return new fabric.Rect(obj);
    case 'polyline':
      console.log('Creating polyline object');
      return new fabric.Polyline(obj.points, obj);
    case 'polygon':
      console.log('Creating polygon object');
      return new fabric.Polygon(obj.points, obj);
    case 'path':
      console.log('Creating path object');
      return new fabric.Path(obj.path, obj);
    case 'group':
      console.log('Creating group object');
      const groupObjects = await Promise.all(obj.objects.map(createFabricObject));
      return new fabric.Group(groupObjects, obj);
    case 'path-group':
      console.log('Creating path-group object');
      const pathGroupObjects = await Promise.all(obj.objects.map(createFabricObject));
      return new fabric.PathGroup(pathGroupObjects, obj);
    default:
      console.warn(`Unknown object type: ${obj.type}`);
      return obj;
  }
}

// Function to load font if not already loaded
async function loadFont(fontId, fontPath) {
  if (loadedFonts.has(fontId)) {
    console.log(`Font ${fontId} already loaded`);
    return;
  }

  const fontName = fontId;
  const fontFilePath = urlToLocalPath(fontPath);

  console.log(`Attempting to load font: ${fontName} from ${fontFilePath}`);
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

  console.log(`Starting customization session for product ID: ${productId}`);
  console.log(`Generated session ID: ${sessionId}`);

  try {
    let templateMetadata = await redisClient.get(`template:en:${productId}:jsondata`);
    if (!templateMetadata) {
      console.error(`Template not found for product ID: ${productId}`);
      return res.status(404).json({ error: 'Template not found' });
    }

    console.log('Template metadata retrieved from Redis');
    templateMetadata = templateMetadata.replace(/localhost/g, 'localhost:8001');
    const [dimensions, fabricJSON] = JSON.parse(templateMetadata);
    console.log(`Template dimensions: ${JSON.stringify(dimensions)}`);
    console.log(`Number of objects in template: ${fabricJSON.objects.length}`);

    const textObjects = fabricJSON.objects
      .map((obj, index) => {
        const objectId = `text_${index}`;
        obj.objectId = objectId;
        if (['textbox', 'text', 'i-text', 'supertext'].includes(obj.type)) {
          console.log(`Found text object: ${objectId}`);
          return { objectId, text: obj.text, left: obj.left, top: obj.top, width: obj.width, height: obj.height };
        }
        return null;
      })
      .filter(obj => obj !== null);

    console.log(`Number of text objects found: ${textObjects.length}`);

    const modifiedMetadata = JSON.stringify([dimensions, fabricJSON]);
    await redisClient.set(`template:en:${sessionId}:demo:json`, modifiedMetadata, { EX: 3600 });
    console.log(`Modified metadata stored in Redis for session: ${sessionId}`);

    res.json({ session_id: sessionId, template_info: { width: dimensions.width, height: dimensions.height, text_objects: textObjects } });
  } catch (error) {
    console.error('Error in start-session:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// [Endpoint 2] - Generate Preview
app.post('/generate-preview', async (req, res) => {
  const { session_id, text, object_id } = req.body;
  console.log(`Generating preview for session: ${session_id}, object: ${object_id}`);

  try {
    const templateMetadata = await redisClient.get(`template:en:${session_id}:demo:json`);
    if (!templateMetadata) {
      console.error(`Session not found or expired: ${session_id}`);
      return res.status(404).json({ error: 'Session not found or expired' });
    }

    console.log('Template metadata retrieved from Redis');
    const [dimensionsStr, fabricJSON] = JSON.parse(templateMetadata);
    const dimensions = JSON.parse(dimensionsStr);
    console.log(`Canvas dimensions: ${JSON.stringify(dimensions)}`);

    console.log(`Total objects in template: ${fabricJSON.objects.length}`);
    console.log('Loading fonts...');
    const fontLoadPromises = fabricJSON.objects
      .filter(obj => obj.fontFamily)
      .map(async (obj) => {
        const fontId = obj.fontFamily;
        console.log(`Fetching font URL for font ID: ${fontId}`);
        const fontUrlResponse = await fetch(`http://localhost:8001/editor/get-woff-font-url?font_id=${fontId}`);
        const fontUrlData = await fontUrlResponse.json();
        if (fontUrlData.success) {
          console.log(`Font URL fetched successfully for font ID: ${fontId}`);
          await loadFont(fontId, fontUrlData.url);
        } else {
          console.error(`Failed to fetch font URL for font ID: ${fontId}`);
        }
      });

    await Promise.all(fontLoadPromises);
    console.log('All fonts loaded');

    console.log(`Updating text for object: ${object_id}`);
    fabricJSON.objects = fabricJSON.objects.map((obj, index) => {
      console.log(`Object ${index + 1}/${fabricJSON.objects.length}:`);
      console.log(`  Type: ${obj.type}`);
      console.log(`  ID: ${obj.objectId || 'N/A'}`);
      console.log(`  Position: (${obj.left}, ${obj.top})`);
      if (obj.width && obj.height) {
        console.log(`  Size: ${obj.width}x${obj.height}`);
      }
      if (obj.text) {
        console.log(`  Text: "${obj.text}"`);
      }
      if (obj.src) {
        console.log(`  Image source: ${obj.src}`);
      }
      if (obj.objectId === object_id) {
        console.log(`  Updating text from "${obj.text}" to "${text}"`);
        obj.text = text;
      }
      return obj;
    });

    const updatedTemplateMetadata = JSON.stringify([dimensionsStr, fabricJSON]);
    await redisClient.set(`template:en:${session_id}:demo:json`, updatedTemplateMetadata);
    console.log('Updated template metadata stored in Redis');

    console.log('Creating canvas...');
    const canvas = createCanvas(dimensions.width, dimensions.height);
    const fabricCanvas = new fabric.StaticCanvas(null, {
      width: dimensions.width,
      height: dimensions.height,
      renderOnAddRemove: false
    });

    console.log('Loading objects onto canvas...');
    const loadedObjects = await Promise.all(fabricJSON.objects.map(createFabricObject));
    loadedObjects.forEach((obj, index) => {
      if (obj) {
        console.log(`Adding object ${index + 1}/${loadedObjects.length} to canvas:`);
        console.log(`  Type: ${obj.type}`);
        console.log(`  ID: ${obj.objectId || 'N/A'}`);
        console.log(`  Position: (${obj.left}, ${obj.top})`);
        if (obj.width && obj.height) {
          console.log(`  Size: ${obj.width}x${obj.height}`);
        }
        if (obj.text) {
          console.log(`  Text: "${obj.text}"`);
        }
        if (obj.src) {
          console.log(`  Image source: ${obj.src}`);
        }
        if (obj.clipPath) {
          console.log(`  Has clip path: ${obj.clipPath.type}`);
        }
        try {
          fabricCanvas.add(obj);
        } catch (error) {
          console.error(`Error adding object ${index + 1} to canvas:`, error);
        }
      } else {
        console.warn(`Object ${index + 1}/${loadedObjects.length} is null and will not be added to canvas`);
      }
    });

    console.log('Adding watermark...');
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
    console.log('Watermark added');

    console.log('Rendering canvas...');
    fabricCanvas.renderAll();

    console.log('Converting canvas to image...');
    const dataURL = fabricCanvas.toDataURL();
    const img = await loadImage(dataURL);
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);

    console.log('Resizing image...');
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

    console.log('Sending response...');
    const buffer = resizedCanvas.toBuffer('image/png');
    res.contentType('image/png');
    res.send(buffer);
    console.log('Preview generated and sent successfully');
  } catch (error) {
    console.error('Error in generate-preview:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// Error handling middleware
app.use((err, req, res, next) => {
  console.error('Unhandled error:', err.stack);
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