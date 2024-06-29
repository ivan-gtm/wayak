const express = require('express');
const bodyParser = require('body-parser');
const OpenAI = require('openai');

const app = express();
const port = 3000;

app.use(bodyParser.json());

const openai = new OpenAI({
    apiKey: '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' // Replace with your OpenAI API key
});

// Function to extract text from Fabric JSON and keep track of positions
function extractTextNodes(fabricJson) {
    const textNodes = [];
    fabricJson.objects.forEach((obj, index) => {
        if (obj.type === 'i-text' || obj.type === 'textbox') {
            textNodes.push({ index, text: obj.text });
        }
    });
    return textNodes;
}

// Function to concatenate text nodes with a special separator
function concatenateTextNodes(textNodes) {
    return textNodes.map(node => node.text).join('<<separator>>');
}

// Function to split translated text and replace text nodes in the original JSON
function replaceTextNodes(fabricJson, translatedText, textNodes) {
    const translatedSegments = translatedText.split('<<separator>>');
    textNodes.forEach((node, idx) => {
        fabricJson.objects[node.index].text = translatedSegments[idx] || '';
    });
    return fabricJson;
}

// Function to translate text using GPT API
async function translateText(text) {
    const prompt = `Translate the following text to Spanish (MX), keeping each sentence separate by '<<separator>>':\n\n${text}`;

    const response = await openai.chat.completions.create({
        messages: [{ role: "system", content: "You are a helpful assistant." }, { role: "user", content: prompt }],
        model: "gpt-4o",
    });

    const translatedText = response.choices[0].message.content.trim();
    return translatedText;
}

app.post('/translate', async (req, res) => {
    try {
        const inputArray = req.body;
        if (!Array.isArray(inputArray) || inputArray.length < 2) {
            return res.status(400).send({ error: 'Invalid input format' });
        }

        const fabricJson = inputArray[1]; // Assuming the fabric JSON is the second element
        if (typeof fabricJson !== 'object' || !fabricJson.objects) {
            return res.status(400).send({ error: 'Invalid fabric JSON format' });
        }

        // Extract and concatenate text nodes
        const textNodes = extractTextNodes(fabricJson);
        const concatenatedText = concatenateTextNodes(textNodes);

        // Translate text
        const translatedText = await translateText(concatenatedText);

        // Replace text nodes in the original JSON with translated text
        const translatedJson = replaceTextNodes(fabricJson, translatedText, textNodes);

        // Return the translated JSON
        res.json(translatedJson);
    } catch (error) {
        res.status(400).send({ error: 'Error translating text', details: error.message });
    }
});

app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
