from flask import Flask, request, jsonify
import os
import re
import json
from bardapi import Bard

os.environ['_BARD_API_KEY']="cAhW7t8qcu9EVNrXVWPx2ZXPM1_jNVooWKNAXPRq83CwM7kS5ppofiW_QbBlAEtDB6LY9Q."

# Extract JSON from string using regular expressions
def extract_json(s):
    # Regular expression pattern to match content between ```json and ```
    pattern = r'```json\n(.*?)\n```'
    match = re.search(pattern, s, re.DOTALL)
    
    if match:
        json_str = match.group(1).strip()
        try:
            parsed = json.loads(json_str)
            return parsed
        except json.JSONDecodeError:
            pass

    return None


app = Flask(__name__)

@app.route('/get_image_description', methods=['POST'])
def get_image_description():
    data = request.json
    file_name = data.get('file_name')
    prompt_text = data.get('prompt_text')
    if not file_name or not prompt_text:
        return jsonify({'error': 'file_name and prompt_text are required'}), 400
    try:
        with open(f"./images/{file_name}", "rb") as f:
            image_data = f.read()
        
        string = '''
        Prompt for Metadata Creation based on Product Image:

        Given a product image, you are tasked with creating metadata for it. Please follow the guidelines below:

        Provide your response in a JSON format, adhering strictly to the structure specified. Exclude any extraneous details.
        For the "title" field, craft something that's both captivating and engaging.
        Translate the "title" into the languages "es", "fr", "pt", and "en", and place them under the "localizedTitle" field using their respective ISO 639-1 language codes.
        Populate the "keywords" field with single-word descriptors related to the color, occasion, theme, and event evident in the image. Ensure you list at least 5 keywords.
        Translate all the keywords into the languages "es", "fr", "pt", and "en", maintaining the structure shown in the example.
        Your final response must follow this JSON structure and be a valid JSON:
        
        {
            "title": "",
            "keywords": {
                "en": ["invitation"],
                "es": ["invitación"],
                "fr": ["invitation"],
                "pt": ["convite"]
            },
            "localizedTitle": {
                "en": "Elephant and Zebra Baby Shower Invitation",
                "es": "Invitación de Baby Shower de Elefante y Zebra",
                "fr": "Invitation à la baby shower éléphant et zèbre",
                "pt": "Convite para chá de bebê de elefante e zebra"
            }
        }

        '''

        single_quote_string = string.replace('"', "'")

        token = 'cAhW7t8qcu9EVNrXVWPx2ZXPM1_jNVooWKNAXPRq83CwM7kS5ppofiW_QbBlAEtDB6LY9Q.'
        bard = Bard(token=token)
        bard_answer = bard.ask_about_image(single_quote_string, image_data)
        
        # Extract JSON from the bard response
        extracted_json_results = extract_json(bard_answer['content'])
        print('+++++++++++++++++++++')
        print(bard_answer['content'])
        print('+++++++++++++++++++++')
        print(json.dumps(extracted_json_results, indent=4))

        # for result in extracted_json_results:

        return json.dumps(extracted_json_results, indent=4)

    except FileNotFoundError:
        return jsonify({'error': f'File {file_name} not found in /images directory'}), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
