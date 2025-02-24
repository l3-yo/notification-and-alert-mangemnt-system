<?php
session_start();
include '../includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات
include '../auth/authorize.php'; // التأكد من صلاحيات المستخدم

authorize('Admin'); // السماح فقط للمسؤولين بعرض مراقبة الأنشطة

// جلب بيانات الأنشطة من قاعدة البيانات
$result = $conn->query("SELECT users.name, activity_logs.action, activity_logs.details, activity_logs.timestamp 
                        FROM activity_logs 
                        JOIN users ON activity_logs.user_id = users.id");

while ($log = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$log['name']}</td>
            <td>{$log['action']}</td>
            <td>{$log['details']}</td>
            <td>{$log['timestamp']}</td>
          </tr>";
}

$conn->close();
?>
