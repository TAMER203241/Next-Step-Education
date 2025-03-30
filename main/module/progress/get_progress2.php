<?php
session_start();
require_once 'config.php';

$matricul = $_SESSION['matricul'];


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

$result = $conn->query("SELECT alg, alg1, alg2, alg3, alg4 FROM page WHERE matricul = '$matricul'");
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode([
        "success" => true,
        "progress" => $row["alg"],
        "alg1" => $row["alg1"],
        "alg2" => $row["alg2"],
        "alg3" => $row["alg3"],
        "alg4" => $row["alg4"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "لم يتم العثور على بيانات المستخدم"]);
}


$conn->close();


?>