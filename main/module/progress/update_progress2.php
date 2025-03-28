<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tamer";

$matricul = $_SESSION['matricul']; // رقم تسجيل المستخدم من الجلسة

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lesson = "alg" . intval($_POST['lesson']);
    $checked = intval($_POST['checked']);

    // تحديث الدرس في قاعدة البيانات
    $sql = "UPDATE page SET $lesson = $checked WHERE matricul = '$matricul'";
    $conn->query($sql);

    // حساب نسبة التقدم الجديدة
    $result = $conn->query("SELECT alg1, alg2, alg3, alg4 FROM page WHERE matricul = '$matricul'");
    $row = $result->fetch_assoc();
    $progress = round((($row['alg1'] + $row['alg2'] + $row['alg3']  + $row['alg4']) / 4) * 100);

    // تحديث progress في قاعدة البيانات
    $conn->query("UPDATE page SET alg = $progress WHERE matricul = '$matricul'");

    echo json_encode(["success" => true, "progress" => $progress]);
}

$conn->close();
?>
