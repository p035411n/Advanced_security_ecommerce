# app.py
from flask import Flask, request, jsonify
import face_recognition
import base64
from io import BytesIO
from PIL import Image
import numpy as np

app = Flask(__name__)

# Route to capture face data from front-end
@app.route('/signup', methods=['POST'])
def signup():
    try:
        # Get the base64 image data from the form
        face_data = request.form.get('face_data')
        if not face_data:
            return jsonify({"error": "No face data received"}), 400

        # Decode the base64 data
        face_data = face_data.split(",")[1]  # Remove prefix before base64 data
        img_data = base64.b64decode(face_data)
        
        # Convert bytes to an image
        img = Image.open(BytesIO(img_data))
        img_array = np.array(img)
        
        # Detect faces using face_recognition
        face_locations = face_recognition.face_locations(img_array)

        if len(face_locations) == 0:
            return jsonify({"error": "No face detected"}), 400
        
        # Example: Process the face (in real implementation, you could train the model or save the face)
        # For example, save the image or add it to a database for later training
        # You could use `face_encodings` for further processing or model training.
        face_encoding = face_recognition.face_encodings(img_array, face_locations)[0]
        
        # Save face encoding to the database (this part would need to be modified as per your DB structure)
        # For now, return a success response
        return jsonify({"message": "Face data received and processed successfully!"}), 200
    
    except Exception as e:
        return jsonify({"error": str(e)}), 500


if __name__ == "__main__":
    app.run(debug=True)
