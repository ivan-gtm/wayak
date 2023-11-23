from flask import Flask, request, jsonify
import os
import re
import json
from bardapi import Bard
import requests

# Set up environment variables
# os.environ['_BARD_API_KEY'] = "cghW7kByc5YYcD7dOnznChWJMugE4pul0c1-9c8MW3pPX6aTFYE2TkHbtIxD7RCYg2WnMg."

# Initialize a reusable session object
token = 'dQhW7vNkvpVOZDVZsNdLfqZbNHOtl6mO6kHy207FM9qfYOxa4GXudR6M8VaA6fWSLDlE0g.'
session = requests.Session()
session.headers = {
    "Host": "bard.google.com",
    "X-Same-Domain": "1",
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36",
    "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
    "Origin": "https://bard.google.com",
    "Referer": "https://bard.google.com/",
}
session.cookies.set("__Secure-1PSID", token)

# proxy_url = "pbhNC_DtKuiHHlEg8CjalA:@smartproxy.crawlbase.com:8012"
# proxies={
#         'http': 'http://pbhNC_DtKuiHHlEg8CjalA:@smartproxy.crawlbase.com:8012',
#         'https': 'http://pbhNC_DtKuiHHlEg8CjalA:@smartproxy.crawlbase.com:8012'
# }

# Initialize Bard with the session
bard = Bard(token=token, session=session, timeout=30)

# Function to extract JSON from a string
def extract_json(s):
    pattern = r'```json\n(.*?)\n```'
    match = re.search(pattern, s, re.DOTALL)
    if match:
        json_str = match.group(1).strip()
        try:
            return json.loads(json_str)
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
        For "title",avoid including personal details and create something that is both captivating and appealing to the sale of the product.
        Translate the "title" into the languages "es", "fr", "pt", and "en", and place them under the "localizedTitle" field using their respective ISO 639-1 language codes.
        Populate the "keywords" field with single-word descriptors related to the color, occasion, theme, and event evident in the image. Ensure you list at least 5 keywords.
        Translate all the keywords into the languages "es", "fr", "pt", and "en", maintaining the structure shown in the example.
        Your final response must follow this JSON structure and be a valid JSON:
        
        {
            "title": "",
            "keywords": {
                "en": [],
                "es": [],
                "fr": [],
                "pt": []
            },
            "localizedTitle": {
                "en": "",
                "es": "",
                "fr": "",
                "pt": ""
            }
        }

        '''
        single_quote_string = string.replace('"', "'")
        bard_answer = bard.ask_about_image(single_quote_string, image_data)
        extracted_json_results = extract_json(bard_answer['content'])
        return jsonify(extracted_json_results)
    except FileNotFoundError:
        return jsonify({'error': f'File {file_name} not found in /images directory'}), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
