<?php
session_start(); // เริ่มต้นการใช้ session

// ลบข้อมูลเซสชันทั้งหมด
session_unset(); // ล้างข้อมูลทั้งหมดใน session
session_destroy(); // ทำลาย session

// เปลี่ยนเส้นทางไปที่หน้าเข้าสู่ระบบหรือหน้าแรก
header("Location: index.php"); // หรือเปลี่ยนเส้นทางไปหน้าแรกของเว็บ
exit(); // หยุดการทำงานของสคริปต์
?>
