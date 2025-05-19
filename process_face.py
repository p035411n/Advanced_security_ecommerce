import dlib
from imutils import face_utils
import cv2
import sys

def process_face(image_path):
    # Read the image
    img = cv2.imread(image_path)
    if img is None:
        print(f"Error: Image at {image_path} could not be loaded.")
        sys.exit(1)

    # Initialize face detector and shape predictor
    detector = dlib.get_frontal_face_detector()
    predictor = dlib.shape_predictor("shape_predictor_68_face_landmarks.dat")

    # Detect faces in the image
    faces = detector(img)
    if len(faces) == 0:
        print("No faces detected in the image.")
        sys.exit(1)

    for face in faces:
        # Get the landmarks
        shape = predictor(img, face)
        landmarks = face_utils.shape_to_np(shape)
        
        # For now, just print the landmarks for each face
        print(f"Landmarks for detected face: {landmarks}")
    
    print("Face processed successfully.")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python process_face.py <image_path>")
        sys.exit(1)

    image_path = sys.argv[1]
    process_face(image_path)
