<?php
session_start();
include 'includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات
include 'auth/authorize.php'; // حماية الصفحة

authorize('Admin'); // السماح فقط للمسؤولين بالدخول إلى لوحة التحكم

// جلب عدد الإشعارات من قاعدة البيانات
$result = $conn->query("SELECT COUNT(*) AS count FROM notifications");
$notifications_count = $result->fetch_assoc()['count'];

echo $notifications_count; // عرض عدد الإشعارات
?>
