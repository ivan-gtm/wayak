const express = require('express');
const bodyParser = require('body-parser');
const crypto = require('crypto');

const app = express();
app.use(bodyParser.json());

function generateId() {
  return crypto.randomBytes(8).toString('hex');
}

function extractTextObjects(fabricJson) {
  const textObjects = [];

  function processTextObject(obj) {
    if (obj.type === 'textbox' || obj.type === 'i-text' || obj.type === 'text') {
      const textObj = {
        id: generateId(),
        type: obj.type,
        text: obj.text,
        // originX: obj.originX,
        // originY: obj.originY,
        left: obj.left,
        top: obj.top,
        // width: obj.width,
        // height: obj.height
      };
      textObjects.push(textObj);
    }
  }

  if (Array.isArray(fabricJson)) {
    fabricJson.forEach(page => {
      if (page.objects && Array.isArray(page.objects)) {
        page.objects.forEach(processTextObject);
      }
    });
  } else if (fabricJson.objects && Array.isArray(fabricJson.objects)) {
    fabricJson.objects.forEach(processTextObject);
  }

  return textObjects;
}

app.post('/extract-text', (req, res) => {
  const fabricJson = req.body;
  
  if (!fabricJson) {
    return res.status(400).json({ error: 'Invalid JSON data' });
  }

  const extractedTextObjects = extractTextObjects(fabricJson);
  res.json(extractedTextObjects);
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});