<?php
session_start();
include '../includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات
include '../auth/authorize.php'; // التأكد من صلاحيات المستخدم

authorize('Admin'); // السماح للمسؤولين فقط بالدخول إلى صفحة إدارة المستخدمين

// جلب بيانات المستخدمين من قاعدة البيانات
$result = $conn->query("SELECT id, name, email, role FROM users");

while ($user = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$user['id']}</td>
            <td>{$user['name']}</td>
            <td>{$user['email']}</td>
            <td>{$user['role']}</td>
          </tr>";
}

$conn->close();
?>
