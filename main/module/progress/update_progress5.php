<?php
session_start();
require_once 'config.php';

$matricul = $_SESSION['matricul']; // رقم تسجيل المستخدم من الجلسة


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lesson = "stat" . intval($_POST['lesson']);
    $checked = intval($_POST['checked']);

    // تحديث الدرس في قاعدة البيانات
    $sql = "UPDATE page SET $lesson = $checked WHERE matricul = '$matricul'";
    $conn->query($sql);

    // حساب نسبة التقدم الجديدة
    $result = $conn->query("SELECT stat1, stat2, stat3 FROM page WHERE matricul = '$matricul'");
    $row = $result->fetch_assoc();
    $progress = round((($row['stat1'] + $row['stat2'] + $row['stat3']) / 3) * 100);

    // تحديث progress في قاعدة البيانات
    $conn->query("UPDATE page SET stat = $progress WHERE matricul = '$matricul'");

    echo json_encode(["success" => true, "progress" => $progress]);
}

$conn->close();
?>
