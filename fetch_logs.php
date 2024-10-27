<?php
// fetch_logs.php - ดึงข้อมูลจากฐานข้อมูลและส่งกลับแบบ JSON
header('Content-Type: application/json'); // กำหนด content type เป็น JSON

// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_tracking";

$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// คิวรีข้อมูลจากตาราง students และ face_detection_logs
$sql = "SELECT students.student_id, students.first_name, students.last_name, 
               COALESCE(MAX(logs.timestamp), 'ไม่มาเรียน') AS timestamp,
               COALESCE(MAX(logs.image_path), '') AS image_path
        FROM students
        LEFT JOIN face_detection_logs AS logs ON students.student_id = logs.student_id
        GROUP BY students.student_id, students.first_name, students.last_name
        ORDER BY students.student_id ASC"; // เรียงตามรหัสนักศึกษา

$result = $conn->query($sql);

// สร้าง array สำหรับเก็บข้อมูล
$logs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

// แปลงข้อมูลเป็น JSON และส่งกลับ
echo json_encode($logs);

// ปิดการเชื่อมต่อ
$conn->close();
?>
