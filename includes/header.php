<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="/includes/header.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="/dashboard.php">Dashboard</a></li>
            <li><a href="/admin/user_management.html">Manage Users</a></li>
            <li><a href="/admin/notification_logs.html">Notification Logs</a></li>
            <li><a href="/admin/activity_monitoring.html">Activity Monitoring</a></li>
            <li><a href="/admin/system_settings.html">System Settings</a></li>
            <li><a href="/auth/logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
