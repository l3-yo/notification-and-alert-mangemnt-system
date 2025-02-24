<?php
session_start();
include '../includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات
include '../auth/authorize.php'; // التأكد من تسجيل الدخول

authorize('User'); // السماح للمستخدمين فقط بتعديل التفضيلات

$user_id = $_SESSION['user_id'];

// جلب القيم من النموذج
$email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
$sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;
$app_notifications = isset($_POST['app_notifications']) ? 1 : 0;

// تحديث التفضيلات في قاعدة البيانات
$stmt = $conn->prepare("UPDATE notification_preferences SET email_notifications = ?, sms_notifications = ?, app_notifications = ? WHERE user_id = ?");
$stmt->bind_param("iiii", $email_notifications, $sms_notifications, $app_notifications, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Preferences updated successfully!";
} else {
    echo "No changes were made.";
}

$stmt->close();
$conn->close();
?>
