<?php
session_start();
require_once 'config.php';

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$matricul = $_SESSION['matricul']; // جلب المعرف من الجلسة

// إذا كان الطلب من نوع GET، جلب القيم المخزنة
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $stmt = $conn->prepare("SELECT algo1, algo2, algo3, algo4 FROM page WHERE matricul = ?");
    $stmt->bind_param("s", $matricul);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode([$row['algo1'], $row['algo2'], $row['algo3'], $row['algo4']]);
    } else {
        echo json_encode([0, 0, 0, 0]);
    }

    $stmt->close();
    exit();
}

// إذا كان الطلب من نوع POST، تحديث البيانات
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lessonIndex = null;
    $lessonValue = null;

    foreach ($_POST as $key => $value) {
        if (preg_match('/lesson(\d+)/', $key, $matches)) {
            $lessonIndex = intval($matches[1]);
            $lessonValue = $value == "1" ? 1 : 0;
            break;
        }
    }

    if ($lessonIndex !== null) {
        $columnName = "algo" . $lessonIndex;

        $stmt = $conn->prepare("UPDATE page SET $columnName = ? WHERE matricul = ?");
        $stmt->bind_param("is", $lessonValue, $matricul);

        if ($stmt->execute()) {
            echo "✅ تم تحديث $columnName بالقيمة $lessonValue بنجاح!";
        } else {
            echo "❌ خطأ أثناء التحديث: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❌ لم يتم إرسال أي بيانات صحيحة!";
    }
}

$conn->close();
?>
