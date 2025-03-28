
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

$result = $conn->query("SELECT stat, stat1, stat2, stat3 FROM page WHERE matricul = '$matricul'");
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode([
        "success" => true,
        "progress" => $row["stat"],
        "stat1" => $row["stat1"],
        "stat2" => $row["stat2"],
        "stat3" => $row["stat3"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "لم يتم العثور على بيانات المستخدم"]);
}


$conn->close();


?>
