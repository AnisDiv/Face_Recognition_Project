<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db = 'student_tracking';
$con = mysqli_connect($host, $username, $password, $db);
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
  echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูล MySQL ได้:   " . mysqli_connect_error();
}