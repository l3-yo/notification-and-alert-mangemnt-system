<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.html"); // توجيه المستخدم إلى لوحة التحكم إذا كان مسجلاً
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css"> <!-- استدعاء ملف CSS الرئيسي -->
</head>
<body>
    <div class="container">
        <h1>Welcome to the Notification Management System</h1>
        <p>Please <a href="auth/login.html">Login</a> or <a href="auth/register.html">Register</a></p>
    </div>
</body>
</html>
