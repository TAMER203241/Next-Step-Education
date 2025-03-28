<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tamer"; 

$matricul = $_SESSION['matricul'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

$result = $conn->query("SELECT algo, algo1, algo2, algo3, algo4 FROM page WHERE matricul = '$matricul'");
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode([
        "success" => true,
        "progress" => $row["algo"],
        "algo1" => $row["algo1"],
        "algo2" => $row["algo2"],
        "algo3" => $row["algo3"],
        "algo4" => $row["algo4"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "لم يتم العثور على بيانات المستخدم"]);
}


$conn->close();


?>