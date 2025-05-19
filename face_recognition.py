import sys
import tensorflow as tf
import cv2
import numpy as np

# Load the pre-trained model (Facenet model in this example)
model = tf.keras.models.load_model('facenet_model.h5')

# Function to get face embeddings
def get_face_embedding(image_path):
    image = cv2.imread(image_path)
    
    # Preprocess the image and detect face
    face = detect_face(image)
    if face is None:
        print("No face detected!")
        return None
    
    # Resize the face image to the size expected by the model (e.g., 160x160)
    face = cv2.resize(face, (160, 160))
    
    # Normalize the pixel values to [0, 1]
    face = face.astype('float32') / 255.0
    
    # Reshape face for the model (e.g., adding batch dimension)
    face = np.expand_dims(face, axis=0)

    # Get the embedding
    embedding = model.predict(face)
    return embedding

# Face detection function using OpenCV Haar Cascade
def detect_face(image):
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
    faces = face_cascade.detectMultiScale(image, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
    if len(faces) > 0:
        x, y, w, h = faces[0]
        return image[y:y+h, x:x+w]
    return None

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python process_face.py <image_path>")
        sys.exit(1)
    
    image_path = sys.argv[1]
    embedding = get_face_embedding(image_path)

    if embedding is not None:
        print("Face Embedding:")
        print(embedding)
    else:
        print("Face detection or embedding failed.")
