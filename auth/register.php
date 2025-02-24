<?php
session_start();
include '../includes/db_connection.php'; // الاتصال بقاعدة البيانات
include '../auth/authorize.php'; // التأكد من صلاحيات المستخدم

// السماح فقط لـ Admin Staff و IT Specialist بإضافة مستخدمين جدد
authorize('Admin');

// التحقق مما إذا كان الطلب عبر POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // الأدوار المسموح بإضافتها فقط
    $allowed_roles = ['Judge', 'Lawyer', 'Litigant', 'Prosecutors', 'Police Department', 'Admin', 'IT Specialist'];

    if (!in_array($role, $allowed_roles)) {
        die("Invalid role selection.");
    }

    // التحقق مما إذا كان البريد الإلكتروني مستخدمًا بالفعل
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Error: Email is already registered.");
    }
    $stmt->close();

    // تشفير كلمة المرور
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // إدخال المستخدم الجديد في جدول users
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
    
    if ($stmt->execute()) {
        // تسجيل العملية في activity_logs
        $admin_id = $_SESSION['user_id'];
        $action = "Created new user";
        $details = "User: $name, Role: $role";

        $log_stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, ?, ?)");
        $log_stmt->bind_param("iss", $admin_id, $action, $details);
        $log_stmt->execute();
        $log_stmt->close();

        echo "User registered successfully!";
        header("Location: ../admin/user_management.html"); // إعادة التوجيه إلى صفحة إدارة المستخدمين
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
