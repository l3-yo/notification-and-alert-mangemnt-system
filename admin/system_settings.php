<?php
session_start();
include '../includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات
include '../auth/authorize.php'; // التأكد من صلاحيات المستخدم

authorize('Admin'); // السماح فقط للمسؤولين بتعديل إعدادات النظام

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $default_notification = $_POST['default_notification'];
    $max_message_length = $_POST['max_message_length'];
    $enable_logging = $_POST['enable_logging'];

    // تحديث الإعدادات في قاعدة البيانات
    $stmt = $conn->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_name = 'default_notification_method'");
    $stmt->bind_param("s", $default_notification);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_name = 'max_message_length'");
    $stmt->bind_param("s", $max_message_length);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_name = 'enable_logging'");
    $stmt->bind_param("s", $enable_logging);
    $stmt->execute();

    echo "Settings updated successfully!";
}

$conn->close();
?>
