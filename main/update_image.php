<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['matricul'])) {
    die("❌ المستخدم غير مسجل الدخول!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update1'])) {
    $matricul = $_SESSION['matricul'];

    // ✅ التحقق من استلام الصورة
    if (!isset($_FILES['image1']) || $_FILES['image1']['error'] !== 0) {
        die("❌ يرجى اختيار صورة جديدة!");
    }

    // ✅ قراءة بيانات الصورة
    $image_tmp = $_FILES['image1']['tmp_name'];
    $image_data = file_get_contents($image_tmp);

    // ✅ التحقق من حجم الصورة (بحد أقصى 2MB)
    if ($_FILES['image1']['size'] > 2 * 1024 * 1024) {
        die("❌ حجم الصورة كبير جدًا! الحد الأقصى 2MB.");
    }

    // ✅ التحقق من نوع الصورة (PNG, JPG, GIF فقط)
    $image_type = mime_content_type($image_tmp);
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($image_type, $allowed_types)) {
        die("❌ نوع الملف غير مدعوم! يرجى رفع صورة بصيغة JPG أو PNG أو GIF.");
    }

    // ✅ تحديث الصورة في قاعدة البيانات
    $stmt = $conn->prepare("UPDATE tamerdz SET image = ? WHERE matricul = ?");
    if (!$stmt) {
        die("⚠️ خطأ في الاستعلام: " . $conn->error);
    }

    // ✅ تمرير متغيرين (الصورة + matricul)
    $stmt->bind_param("bs", $null, $matricul);
    $stmt->send_long_data(0, $image_data);

    if ($stmt->execute()) {
        echo "✅ تم تحديث الصورة بنجاح!";
        header("Location: main.php");
        exit();
    } else {
        echo "⚠️ حدث خطأ أثناء التحديث! " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
