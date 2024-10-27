import cv2
import numpy as np
import face_recognition as face_rec
import mysql.connector
from datetime import datetime, timedelta
import requests
from PIL import Image, ImageDraw, ImageFont

# ฟังก์ชันเพื่อแปลงหมายเลขเดือนเป็นชื่อเดือนภาษาไทย
def get_thai_month(month_number):
    thai_months = [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
        "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม",
        "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ]
    return thai_months[month_number - 1]

# เชื่อมต่อฐานข้อมูล MySQL
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="student_tracking"
)

# คิวรีข้อมูลจากตาราง students
cursor = db.cursor()
cursor.execute("SELECT student_id, first_name, last_name, major, faculty, face_image_path FROM students")
students_data = cursor.fetchall()

# สร้าง dictionary เก็บข้อมูลของนักศึกษา
people = {}
student_info_map = {}
for row in students_data:
    student_id = row[0]
    full_name = f"{row[1]} {row[2]}"
    major = row[3]
    faculty = row[4]
    image_path = row[5]
    people[full_name] = image_path
    student_info_map[full_name] = {
        "student_id": student_id,
        "major": major,
        "faculty": faculty
    }

# สร้างลิสต์สำหรับเก็บการเข้ารหัสใบหน้าและชื่อ
known_face_encodings = []
known_face_names = []

# วนลูปเพื่อโหลดรูปภาพและสร้างการเข้ารหัสใบหน้า
for name, image_path in people.items():
    try:
        image = face_rec.load_image_file(image_path)
        encoding = face_rec.face_encodings(image)[0]
        known_face_encodings.append(encoding)
        known_face_names.append(name)
    except IndexError:
        print(f"ใบหน้าในรูปภาพ '{image_path}' ไม่สามารถเข้ารหัสได้ หรือไฟล์ภาพเสียหาย")
    except FileNotFoundError:
        print(f"ไม่พบไฟล์ภาพ: '{image_path}'")

# ตรวจสอบว่าโหลดข้อมูลสำเร็จ
print(f"Loaded {len(known_face_names)} faces: {known_face_names}")

# สร้างตัวแปรเก็บเวลาแคปล่าสุดของแต่ละคน
last_capture_time = {}

# ฟังก์ชันสำหรับส่งข้อความและภาพไปที่ Telegram
def send_telegram_message(message, image_path):
    bot_token = '7824025556:AAHM4XGm0dhttgcFsuYYt58rw5YTYWNxdTc'
    chat_id = '5987115638'
    telegram_url = f"https://api.telegram.org/bot{bot_token}/sendPhoto"
    
    with open(image_path, 'rb') as photo:
        params = {
            'chat_id': chat_id,
            'caption': message
        }
        response = requests.post(telegram_url, data=params, files={'photo': photo})
    
    if response.status_code == 200:
        print("Notification sent to Telegram successfully!")
    else:
        print(f"Failed to send notification. Status code: {response.status_code}")

# ฟังก์ชันเพื่อวาดข้อความภาษาไทยบนภาพ
def draw_thai_text(image, text, position):
    font_path = "./angsana.ttc"
    font_size = 30
    font = ImageFont.truetype(font_path, font_size)
    image_pil = Image.fromarray(cv2.cvtColor(image, cv2.COLOR_BGR2RGB))
    draw = ImageDraw.Draw(image_pil)
    draw.text(position, text, font=font, fill=(255, 0, 0))
    return cv2.cvtColor(np.array(image_pil), cv2.COLOR_RGB2BGR)

# เปิดการเข้าถึงกล้องเว็บแคม
video_capture = cv2.VideoCapture("vdo.MOV")

# กำหนดค่า frame rate ที่ต้องการตรวจจับ (เช่น ทุกๆ 5 เฟรม)
process_every_n_frames = 5
frame_count = 0

while True:
    ret, frame = video_capture.read()
    if not ret:
        break

    frame_count += 1

    if frame_count % process_every_n_frames == 0:
        original_frame = frame.copy()
        small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)
        rgb_small_frame = cv2.cvtColor(small_frame, cv2.COLOR_BGR2RGB)

        face_locations = face_rec.face_locations(rgb_small_frame)
        face_encodings = face_rec.face_encodings(rgb_small_frame, face_locations)

        face_names = []

        for face_encoding in face_encodings:
            face_distances = face_rec.face_distance(known_face_encodings, face_encoding)
            best_match_index = np.argmin(face_distances)
            confidence = 1 - face_distances[best_match_index]

            if confidence >= 0.5:
                name = known_face_names[best_match_index]
            else:
                name = "UNKNOWN"

            face_names.append(name)

        for (top, right, bottom, left), name in zip(face_locations, face_names):
            top *= 4
            right *= 4
            bottom *= 4
            left *= 4

            cv2.rectangle(frame, (left, top), (right, bottom), (0, 0, 255), 2)
            frame = draw_thai_text(frame, name, (left, top - 40))

            if name != "UNKNOWN":
                current_time = datetime.now()

                if name not in last_capture_time or (current_time - last_capture_time[name]) > timedelta(minutes=10):
                    timestamp = current_time.strftime('%Y-%m-%d_%H-%M-%S')
                    image_filename = f"captured_faces/{name}_{timestamp}.jpg"
                    face_image = original_frame[top:bottom, left:right]
                    cv2.imwrite(image_filename, face_image)

                    student_info = student_info_map[name]
                    student_id = student_info["student_id"]
                    major = student_info["major"]
                    faculty = student_info["faculty"]

                    sql_insert = "INSERT INTO face_detection_logs (student_id, timestamp, image_path) VALUES (%s, %s, %s)"
                    cursor.execute(sql_insert, (student_id, current_time, image_filename))
                    db.commit()

                    last_capture_time[name] = current_time
                    print(f"Captured {name}'s face (student_id: {student_id}) at {timestamp}")

                    day = current_time.day
                    month = get_thai_month(current_time.month)
                    year = current_time.year + 543
                    time_formatted = current_time.strftime('%H:%M นาที')

                    message = (
                        f"รหัสนักศึกษา: {student_id}\n"
                        f"ชื่อ: {name}\n"
                        f"สาขา: {major}\n"
                        f"คณะ: {faculty}\n"
                        "สถานะ: มาโรงเรียนแล้ว\n"
                        f"วันที่: {day} เดือน {month} ปี พ.ศ. {year}\n"
                        f"เวลา: {time_formatted}"
                    )
                    
                    send_telegram_message(message, image_filename)

    cv2.imshow('Webcam', frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

video_capture.release()
cv2.destroyAllWindows()
cursor.close()
db.close()
