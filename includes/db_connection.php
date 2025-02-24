<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "notification_system";

// إنشاء الاتصال بقاعدة البيانات
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
