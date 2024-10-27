
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <form action="chk.php" method="post">
            <h1>Login</h1>
            <div class="input-box first">
                <input name="username" type="text" placeholder="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box second">
                <input name="password" type="password" placeholder="password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>สำหรับเจ้าหน้าที่เท่านั้น</p>
            </div>
        </form>

    </div>
</body>

</html>