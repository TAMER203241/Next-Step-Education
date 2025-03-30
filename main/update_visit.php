<?php
session_start(); // بدء الجلسة
require_once 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق مما إذا كان المستخدم مسجلاً
if (!isset($_SESSION['matricul'])) {
    die("User not logged in.");
}

$matricul = $_SESSION['matricul'];
$current_time = date("Y-m-d H:i:s");

// تحديث أو إدراج تاريخ آخر زيارة
$sql = "INSERT INTO page (matricul, last_visit) VALUES ('$matricul', '$current_time')
        ON DUPLICATE KEY UPDATE last_visit='$current_time'";

if ($conn->query($sql) === TRUE) {
    echo "Visit updated";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
