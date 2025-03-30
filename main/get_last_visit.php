<?php
session_start();
require_once 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق مما إذا كان المستخدم مسجلاً
if (!isset($_SESSION['matricul'])) {
    die("User not logged in.");
}

$matricul = $_SESSION['matricul'];

$sql = "SELECT last_visit FROM page WHERE matricul = '$matricul'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_visit = new DateTime($row["last_visit"]);
    $today = new DateTime();
    $yesterday = (clone $today)->modify('-1 day');

    if ($last_visit->format('Y-m-d') === $today->format('Y-m-d')) {
        echo "Today";
    } elseif ($last_visit->format('Y-m-d') === $yesterday->format('Y-m-d')) {
        echo "Yesterday";
    } else {
        echo $last_visit->format('Y-m-d');
    }
} else {
    echo "No previous visit";
}

$conn->close();
?>
