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


$result = $conn->query("SELECT strm, strm1, strm2, strm3 FROM page WHERE matricul = '$matricul'");
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode([
        "success" => true,
        "progress" => $row["strm"],
        "strm1" => $row["strm1"],
        "strm2" => $row["strm2"],
        "strm3" => $row["strm3"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "لم يتم العثور على بيانات المستخدم"]);
}



$conn->close();

?>
