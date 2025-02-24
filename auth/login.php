<?php
session_start();
require '../includes/db_connection.php'; // استدعاء الاتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role);
    $stmt->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        header("Location: ../dashboard.php"); 
        exit;
    } else {
        echo "Invalid email or password.";
    }
    
    $stmt->close();
}
$conn->close();
?>
