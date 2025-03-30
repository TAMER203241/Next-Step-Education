<?php
session_start();
require_once 'config.php';

$matricul = $_SESSION['matricul']; // رقم تسجيل المستخدم من الجلسة


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lesson = "ana" . intval($_POST['lesson']);
    $checked = intval($_POST['checked']);

    // تحديث الدرس في قاعدة البيانات
    $sql = "UPDATE page SET $lesson = $checked WHERE matricul = '$matricul'";
    $conn->query($sql);

    // حساب نسبة التقدم الجديدة
    $result = $conn->query("SELECT ana1, ana2, ana3 FROM page WHERE matricul = '$matricul'");
    $row = $result->fetch_assoc();
    $progress = round((($row['ana1'] + $row['ana2'] + $row['ana3']) / 3) * 100);

    // تحديث progress في قاعدة البيانات
    $conn->query("UPDATE page SET ana = $progress WHERE matricul = '$matricul'");

    echo json_encode(["success" => true, "progress" => $progress]);
}

$conn->close();
?>

