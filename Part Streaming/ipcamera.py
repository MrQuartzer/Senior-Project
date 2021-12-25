import cv2

ds_factor = 0.6

class VideoCamera(object):
    def __init__(self):
        self.Video = cv2.VideoCapture('rtsp://admin:abc12345@192.168.1.64/H264?ch=1&subtype=0')
    
    def __del__(self):
        self.Video.release()

    def get_frame(self):
        ret, frame = self.Video.read()
        frame = cv2.resize(frame,None,fx=ds_factor,fy=ds_factor,interpolation=cv2.INTER_AREA)
        gray=cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        
        ret, jpeg = cv2.imencode('.jpg', frame)
        return jpeg.tobytes()