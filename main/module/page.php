
<?php
session_start(); // بدء الجلسة

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "tamer");

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}  

header('Content-Type: text/plain'); // تأكد من عرض النص فقط لتسهيل التصحيح

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "🔹 Received lesson1: " . (isset($_POST['lesson1']) ? $_POST['lesson1'] : "لم يتم إرسال");
}


// التحقق مما إذا كان المستخدم قد سجل الدخول ولديه matricul مخزن في الجلسة
if (!isset($_SESSION['matricul'])) {
    die("❌ يرجى تسجيل الدخول أولاً.");
}

// جلب matricul من الجلسة
$matricul = $_SESSION['matricul'];

// التحقق مما إذا تم إرسال بيانات عبر AJAX
if (isset($_POST['lesson1'])) {
    $lesson1 = $_POST['lesson1']; // جلب قيمة CheckBox (1 أو 0)

    // تحديث قيمة algo1 في قاعدة البيانات بناءً على matricul
    $stmt = $conn->prepare("UPDATE page SET algo1 = ? WHERE matricul = ?");
    $stmt->bind_param("is", $lesson1, $matricul);

    if ($stmt->execute()) {
        echo "✅ تم تحديث البيانات بنجاح!";
    } else {
        echo "❌ حدث خطأ أثناء التحديث: " . $stmt->error;
    }

    // إغلاق الاتصال
    $stmt->close();
    $conn->close();
}
?>
