<?php
session_start();
include '../includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات
include '../auth/authorize.php'; // التأكد من صلاحيات المستخدم

authorize('Admin'); // السماح فقط للمسؤولين بعرض سجل الإشعارات

// جلب بيانات الإشعارات من قاعدة البيانات
$result = $conn->query("SELECT recipient_name, recipient_email, message, type, status, sent_time FROM notification_logs");

while ($log = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$log['recipient_name']}</td>
            <td>{$log['recipient_email']}</td>
            <td>{$log['message']}</td>
            <td>{$log['type']}</td>
            <td>{$log['status']}</td>
            <td>{$log['sent_time']}</td>
          </tr>";
}

$conn->close();
?>
