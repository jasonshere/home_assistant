# USAGE
# With default parameters
#     python3 03_recognise.py
# OR specifying the encodings, screen resolution, output video and display
#     python3 03_recognise.py -e encodings.pickle -r 240 -o output/capture.avi -y 1

## Acknowledgement
## This code is adapted from:
## https://www.pyimagesearch.com/2018/06/18/face-recognition-with-opencv-python-and-deep-learning/

# import the necessary packages
from imutils.video import VideoStream
import face_recognition
import argparse
import imutils
import pickle
import time
import cv2
import os
import random
import string
import boto3

def notify():
    # Create an SNS client
    client = boto3.client(
        'sns',
	aws_access_key_id="AKIAIZA4XW4YZP6VMEHA",
	aws_secret_access_key="ptjdVh/OtLv0g5/Ofgz2Nc6n7CuPJDMzSkd3X/4d",
	region_name="us-east-1"
    )
    # Send your sms message.
    client.publish(
        PhoneNumber="+61402358178",
	Message="There is intruder in your house!"
    )

def record(frame):
    rand_name = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(16))
    face_detector = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')
    cv2.namedWindow("record images")

    folder = './dataset/intruders'
    if not os.path.exists(folder):
        os.makedirs(folder)

    cv2.imshow("Intruders", frame)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    faces = face_detector.detectMultiScale(gray, 1.3, 5)
    for (x,y,w,h) in faces:
        cv2.rectangle(frame, (x,y), (x+w,y+h), (255,0,0), 2)
        img_name = "{}/{}.jpg".format(folder, rand_name)
        cv2.imwrite(img_name, frame[y:y+h,x:x+w])
    return rand_name

# construct the argument parser and parse the arguments
ap = argparse.ArgumentParser()
ap.add_argument("-e", "--encodings", default='encodings.pickle',
        help="path to serialized db of facial encodings")
ap.add_argument("-r", "--resolution", type=int, default=240,
        help="Resolution of the video feed")
ap.add_argument("-o", "--output", type=str,
        help="path to output video")
ap.add_argument("-y", "--display", type=int, default=0,
        help="whether or not to display output frame to screen")
ap.add_argument("-d", "--detection-method", type=str, default="hog",
        help="face detection model to use: either `hog` or `cnn`")
args = vars(ap.parse_args())

# load the known faces and embeddings
print("[INFO] loading encodings...")
data = pickle.loads(open(args["encodings"], "rb").read())

# initialize the video stream and pointer to output video file, then
# allow the camera sensor to warm up
print("[INFO] starting video stream...")
vs = VideoStream(src=0).start()
writer = None
time.sleep(2.0)

# loop over frames from the video file stream
while True:
    # grab the frame from the threaded video stream
   frame = vs.read()

   # convert the input frame from BGR to RGB then resize it to have
   # a width of 750px (to speedup processing)
   rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
   rgb = imutils.resize(frame, width=args["resolution"])
   r = frame.shape[1] / float(rgb.shape[1])

   # detect the (x, y)-coordinates of the bounding boxes
   # corresponding to each face in the input frame, then compute
   # the facial embeddings for each face
   boxes = face_recognition.face_locations(rgb,
           model=args["detection_method"])
   encodings = face_recognition.face_encodings(rgb, boxes)
   names = []

   # loop over the facial embeddings
   for encoding in encodings:
       # attempt to match each face in the input image to our known
      # encodings
      matches = face_recognition.compare_faces(data["encodings"],
              encoding)
      name = "Unknown"

      # check to see if we have found a match
      if True in matches:
          # find the indexes of all matched faces then initialize a
         # dictionary to count the total number of times each face
         # was matched
         matchedIdxs = [i for (i, b) in enumerate(matches) if b]
         counts = {}

         # loop over the matched indexes and maintain a count for
         # each recognized face face
         for i in matchedIdxs:
            name = data["names"][i]
            counts[name] = counts.get(name, 0) + 1

         # determine the recognized face with the largest number
         # of votes (note: in the event of an unlikely tie Python
         # will select first entry in the dictionary)
         name = max(counts, key=counts.get)

      # update the list of names
      names.append(name)

   # loop over the recognized faces
   for ((top, right, bottom, left), name) in zip(boxes, names):
       # rescale the face coordinates
      top = int(top * r)
      right = int(right * r)
      bottom = int(bottom * r)
      left = int(left * r)

      # draw the predicted face name on the image
      #cv2.rectangle(frame, (left, top), (right, bottom),
         #(0, 255, 0), 2)
      #y = top - 15 if top - 15 > 15 else top + 15
      #cv2.putText(frame, name, (left, y), cv2.FONT_HERSHEY_SIMPLEX,
      #    0.75, (0, 255, 0), 2)
      
      # print to console, identified person
      print('Person found: {}'.format(name)) 
      try:
          if name == 'Unknown':
              file_name = record(frame)
              s3 = boto3.resource('s3')
              s3.meta.client.upload_file('dataset/intruders/{}.jpg'. format(file_name), 'intruders', 'faces/{}.jpg'. format(file_name))
              notify()
      except Exception as e:
          print("Please try again")
      # Set a flag to sleep the cam for fixed time
      time.sleep(3.0)


   # if the video writer is None *AND* we are supposed to write
   # the output video to disk initialize the writer
   if writer is None and args["output"] is not None:
      fourcc = cv2.VideoWriter_fourcc(*"MJPG")
      writer = cv2.VideoWriter(args["output"], fourcc, 20, (frame.shape[1], frame.shape[0]), True)

      # if the writer is not None, write the frame with recognized
   # faces t odisk
   if writer is not None:
       writer.write(frame)

   # check to see if we are supposed to display the output frame to
   # the screen
   if args["display"] > 0:
      cv2.imshow("Frame", frame)
      key = cv2.waitKey(1) & 0xFF

      # if the `q` key was pressed, break from the loop
      if key == ord("q"):
          break

# do a bit of cleanup
cv2.destroyAllWindows()
vs.stop()

# check to see if the video writer point needs to be released
if writer is not None:
    writer.release()







