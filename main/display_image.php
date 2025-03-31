<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['matricul'])) {
    die("❌ المستخدم غير مسجل الدخول!");
}

$matricul = $_SESSION['matricul'];

$stmt = $conn->prepare("SELECT image FROM tamerdz WHERE matricul = ?");
$stmt->bind_param("s", $matricul);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();
$conn->close();

if ($image) {
    header("Content-Type: image/jpeg");
    echo $image;
} else {
    echo "❌ لا توجد صورة متاحة!";
}
?>
