<?php
session_start();
require('dbconnect.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้รับข้อมูล username และ password จากแบบฟอร์มหรือไม่
if (isset($_POST['username']) && isset($_POST['password'])) {
    $Username = $_POST['username'];
    $password = $_POST['password']; // ไม่แฮชรหัสผ่าน

    // สร้างคำสั่ง SQL เพื่อตรวจสอบ username และ password จากตาราง admin
    $sql = "SELECT * FROM admin_id WHERE username = ? AND password = ?"; // เปลี่ยนจาก admin_id เป็น admin
    
    // ใช้ prepared statement เพื่อป้องกัน SQL injection
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $Username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // ตรวจสอบว่ามีผลลัพธ์หรือไม่
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);

        // เก็บข้อมูล user_id ใน session
        $_SESSION["user_id"] = $username; // สมมุติว่าในตารางมี column ที่ชื่อว่า id

        // นำผู้ใช้ไปยังหน้า admin_page.php เมื่อเข้าสู่ระบบสำเร็จ
        header("location: content.php");
        exit();
    } else {
        // แจ้งเตือนเมื่อ username หรือ password ไม่ถูกต้อง
        echo "<script>";
        echo "alert('Your username or password is incorrect.');";
        echo "window.history.back();"; // กลับไปที่หน้า login
        echo "</script>";
        exit();
    }
} else {
    // หากไม่มีการส่งข้อมูล username หรือ password
    header("location: index.php");
    exit();
}
?>
