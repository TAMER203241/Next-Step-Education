
<?php
session_start();
require_once 'config.php';
$matricul = $_SESSION['matricul'];


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "فشل الاتصال بقاعدة البيانات"]));
}

$result = $conn->query("SELECT ana, ana1, ana2, ana3 FROM page WHERE matricul = '$matricul'");
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode([
        "success" => true,
        "progress" => $row["ana"],
        "ana1" => $row["ana1"],
        "ana2" => $row["ana2"],
        "ana3" => $row["ana3"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "لم يتم العثور على بيانات المستخدم"]);
}


$conn->close();


?>
