<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .status-present {
            color: green; /* สีเขียวสำหรับมาเรียน */
        }
        .status-absent {
            color: red; /* สีแดงสำหรับไม่มาเรียน */
        }
        th {
            background-color: #f2f2f2; /* สีพื้นหลังสำหรับหัวข้อ */
            font-weight: bold; /* เน้นข้อความหัวข้อ */
            color: black; /* สีข้อความหัวข้อ */
        }
        #summary {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <div class="head">
            <h1>Student Attendance</h1>
            <nav>
                <a href="logout.php" class="btn">Logout</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <!-- ส่วนแสดงข้อมูลสรุป -->
        <div id="summary">กำลังโหลดข้อมูล...</div>
        <div class="table-responsive">
            <table id="attendance-table">
                <thead>
                    <tr>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อ-สกุล</th>
                        <th>สถานะ</th>
                        <th>เวลามาเรียน</th>
                        <th>รูปภาพที่ตรวจจับได้</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้จะถูกอัปเดตด้วย JavaScript -->
                </tbody>
            </table>
        </div>
    </main>

    <script>
    // ฟังก์ชันสำหรับดึงข้อมูลจาก fetch_logs.php
    function fetchAttendanceLogs() {
        $.ajax({
            url: 'fetch_logs.php', // ไฟล์ PHP ที่ใช้ดึงข้อมูล
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // ลบข้อมูลเก่าในตาราง
                $('#attendance-table tbody').empty();

                // กำหนดตัวแปรสำหรับนับจำนวนนักเรียนมาและไม่มาเรียน
                let countPresent = 0;
                let countAbsent = 0;

                // วนลูปแสดงข้อมูลใหม่จากฐานข้อมูล
                $.each(data, function (index, log) {
                    // สร้างชื่อเต็มของนักศึกษา
                    let full_name = log.first_name + " " + log.last_name;

                    // ตรวจสอบสถานะการมาเรียน
                    let status = log.timestamp === 'ไม่มาเรียน' ? 'ไม่มาเรียน' : 'มาเรียน';
                    let statusClass = status === 'มาเรียน' ? 'status-present' : 'status-absent';

                    // นับจำนวนนักเรียนที่มาเรียนและไม่มาเรียน
                    if (status === 'มาเรียน') {
                        countPresent++;
                    } else {
                        countAbsent++;
                    }

                    // แปลง timestamp เป็น DateTime และจัดรูปแบบ
                    let formatted_date = log.timestamp === 'ไม่มาเรียน' ? 'ไม่พบข้อมูล' : `${new Date(log.timestamp).toLocaleString()}`;

                    // สร้างแถวข้อมูลในตาราง
                    let tableRow = `<tr>
                        <td>${log.student_id}</td>
                        <td>${full_name}</td>
                        <td class="${statusClass}">${status}</td>
                        <td>${formatted_date}</td>
                        <td>${log.image_path ? `<img src="${log.image_path}" alt="Face Image">` : 'ไม่พบข้อมูล'}</td>
                    </tr>`;

                    // เพิ่มแถวใหม่ในตาราง
                    $('#attendance-table tbody').append(tableRow);
                });

                // อัปเดตข้อมูลสรุป
                // อัปเดตข้อมูลสรุป โดยเพิ่ม `<br>` เพื่อขึ้นบรรทัดใหม่
                $('#summary').html(`จำนวนนักศึกษามาเรียน: ${countPresent} คน<br>ไม่มาเรียน: ${countAbsent} คน`);

            },
            error: function () {
                console.log("ไม่สามารถดึงข้อมูลได้");
                $('#summary').text("ไม่สามารถดึงข้อมูลได้");
            }
        });
    }

    // ดึงข้อมูลทันทีที่เปิดหน้าเว็บและทุก ๆ 5 วินาที
    $(document).ready(function () {
        fetchAttendanceLogs();
        setInterval(fetchAttendanceLogs, 5000);
    });
    </script>
</body>
</html>
