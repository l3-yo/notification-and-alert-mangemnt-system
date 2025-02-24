<?php
session_start();
include '../includes/db_connection.php';
include '../auth/authorize.php';

// السماح فقط لـ Admin Staff بإرسال الإشعارات
authorize('Admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient_id = $_POST['recipient'];
    $message = htmlspecialchars(trim($_POST['message']));
    $type = $_POST['type'];

    // التحقق من صحة بيانات الإدخال
    if (empty($message)) {
        die("Error: Message cannot be empty.");
    }

    // إدخال الإشعار في جدول `notifications`
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, type, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("iss", $recipient_id, $message, $type);

    if ($stmt->execute()) {
        // تسجيل العملية في `notification_logs`
        $recipient_query = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
        $recipient_query->bind_param("i", $recipient_id);
        $recipient_query->execute();
        $recipient = $recipient_query->get_result()->fetch_assoc();

        $log_stmt = $conn->prepare("INSERT INTO notification_logs (recipient_name, recipient_email, message, type, status) VALUES (?, ?, ?, ?, 'Pending')");
        $log_stmt->bind_param("ssss", $recipient['name'], $recipient['email'], $message, $type);
        $log_stmt->execute();
        $log_stmt->close();

        echo "Notification sent successfully!";
        header("Location: notification_logs.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
