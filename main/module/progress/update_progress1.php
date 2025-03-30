<?php
session_start();
require_once 'config.php';
$matricul = $_SESSION['matricul']; // رقم تسجيل المستخدم من الجلسة


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lesson = "algo" . intval($_POST['lesson']);
    $checked = intval($_POST['checked']);

    // تحديث الدرس في قاعدة البيانات
    $sql = "UPDATE page SET $lesson = $checked WHERE matricul = '$matricul'";
    $conn->query($sql);

    // حساب نسبة التقدم الجديدة
    $result = $conn->query("SELECT algo1, algo2, algo3, algo4 FROM page WHERE matricul = '$matricul'");
    $row = $result->fetch_assoc();
    $progress = round((($row['algo1'] + $row['algo2'] + $row['algo3']  + $row['algo4']) / 4) * 100);

    // تحديث progress في قاعدة البيانات
    $conn->query("UPDATE page SET algo = $progress WHERE matricul = '$matricul'");

    echo json_encode(["success" => true, "progress" => $progress]);
}

$conn->close();
?>

