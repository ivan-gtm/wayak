const express = require('express');
const redis = require('redis');
const { v4: uuidv4 } = require('uuid');
const { fabric } = require('fabric');
const { createCanvas, loadImage } = require('canvas');
const path = require('path');

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

// Function to convert URL to local path
function urlToLocalPath(url) {
  const localPrefix = '/Volumes/wayak/wayak/public/design';
  const urlPrefix = 'http://localhost:8001/design';
  return url.replace(urlPrefix, localPrefix);
}

// [Endpoint 1] - Start Customization Session
app.get('/start-session/:product_id', async (req, res) => {
  const productId = req.params.product_id;
  const sessionId = uuidv4().substring(0, 10); // Generate a 10-character session ID

  try {
    // Fetch template metadata from Redis
    var templateMetadata = await redisClient.get(`template:en:${productId}:jsondata`);
    if (!templateMetadata) {
      return res.status(404).json({ error: 'Template not found' });
    }

    // Replace 'localhost' with 'localhost:8001' in the entire templateMetadata
    templateMetadata = templateMetadata.replace(/localhost/g, 'localhost:8001');

    // Parse the template metadata
    const [dimensions, fabricJSON] = JSON.parse(templateMetadata);

    // Initialize an array to store text object information
    const textObjects = [];

    // Assign unique objectId to each text object and collect text information
    fabricJSON.objects = fabricJSON.objects.map((obj, index) => {
      if (obj.type === 'textbox' || obj.type === 'text') {
        const objectId = `text_${index}`;
        obj.objectId = objectId;
        
        // Collect minimal information for frontend
        textObjects.push({
          objectId: objectId,
          text: obj.text,
          left: obj.left,
          top: obj.top,
          width: obj.width,
          height: obj.height
        });
      }
      return obj;
    });

    // Store modified template metadata in Redis with expiration
    const modifiedMetadata = JSON.stringify([dimensions, fabricJSON]);
    await redisClient.set(`template:en:${sessionId}:demo:json`, modifiedMetadata, {
      EX: 3600 // 60 minutes expiration
    });

    // Prepare the response
    const response = {
      session_id: sessionId,
      template_info: {
        width: dimensions.width,
        height: dimensions.height,
        text_objects: textObjects
      }
    };

    // Return the session ID and template info
    res.json(response);
  } catch (error) {
    console.error('Error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// [Endpoint 2] - Generate Preview
app.post('/generate-preview', async (req, res) => {
  const { session_id, text, object_id } = req.body;

  try {
    // Recover metadata based on session_id
    const templateMetadata = await redisClient.get(`template:en:${session_id}:demo:json`);
    if (!templateMetadata) {
      return res.status(404).json({ error: 'Session not found or expired' });
    }

    const [dimensionsStr, fabricJSON] = JSON.parse(templateMetadata);
    const dimensions = JSON.parse(dimensionsStr);

    // Replace text on corresponding objectId
    fabricJSON.objects = fabricJSON.objects.map(obj => {
      if (obj.objectId === object_id) {
        obj.text = text;
      }
      return obj;
    });

    // Create a node-canvas instance
    const canvas = createCanvas(dimensions.width, dimensions.height);
    const fabricCanvas = new fabric.StaticCanvas(null, {
      width: dimensions.width,
      height: dimensions.height,
      renderOnAddRemove: false
    });

    // Load all images before rendering
    const loadedObjects = await Promise.all(fabricJSON.objects.map(async (obj) => {
      if (obj.type === 'image') {
        const localPath = urlToLocalPath(obj.src);
        try {
          const img = await loadImage(localPath);
          return new fabric.Image(img, {
            ...obj,
            scaleX: obj.scaleX || obj.width / img.width,
            scaleY: obj.scaleY || obj.height / img.height
          });
        } catch (error) {
          console.error(`Error loading image from ${localPath}:`, error);
          return null;
        }
      } else if (obj.type === 'textbox') {
        return new fabric.Textbox(obj.text, obj);
      }
      return obj;
    }));

    // Add loaded objects to canvas
    loadedObjects.forEach(obj => {
      if (obj) fabricCanvas.add(obj);
    });

    // Add watermark
    const watermark = new fabric.Text('PREVIEW', {
      fontSize: 40,
      opacity: 0.5,
      angle: -45,
      left: dimensions.width / 2,
      top: dimensions.height / 2
    });
    fabricCanvas.add(watermark);

    // Render the canvas
    fabricCanvas.renderAll();

    // Convert fabricCanvas to node-canvas using toDataURL
    const dataURL = fabricCanvas.toDataURL();
    const img = await loadImage(dataURL);
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);

    // Resize the image while maintaining aspect ratio
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

    // Convert canvas to buffer
    const buffer = resizedCanvas.toBuffer('image/png');

    // Send the image as response
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