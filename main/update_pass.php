<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['matricul'])) {
    die("خطأ: المستخدم غير مسجل الدخول!");
}
require_once 'config.php';

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $matricul = $_SESSION['matricul'];
    $new_password = $_POST['newpass'];

    if (empty($new_password)) {
        die("❌ كلمة المرور الجديدة مطلوبة!");
    }

    // تشفير كلمة المرور قبل تخزينها
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE tamerdz SET pass = ? WHERE matricul = ?");
    $stmt->bind_param("ss", $hashed_password, $matricul);



    
    if ($stmt->execute()) {
        echo "✅ تم تغيير كلمة المرور بنجاح!";
        header("Location: main.php");
    } else {
        echo "⚠️ حدث خطأ أثناء التحديث!";
    }

    $stmt->close();
}

$conn->close();
?>
