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
    $lesson = "elec" . intval($_POST['lesson']);
    $checked = intval($_POST['checked']);

    // تحديث الدرس في قاعدة البيانات
    $sql = "UPDATE page SET $lesson = $checked WHERE matricul = '$matricul'";
    $conn->query($sql);

    // حساب نسبة التقدم الجديدة
    $result = $conn->query("SELECT elec1, elec2, elec3 FROM page WHERE matricul = '$matricul'");
    $row = $result->fetch_assoc();
    $progress = round((($row['elec1'] + $row['elec2'] + $row['elec3']) / 3) * 100);

    // تحديث progress في قاعدة البيانات
    $conn->query("UPDATE page SET elec = $progress WHERE matricul = '$matricul'");

    echo json_encode(["success" => true, "progress" => $progress]);
}

$conn->close();
?>
