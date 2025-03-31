<?php
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $matricul = trim($_POST['matricul']);
    $specialite = trim($_POST['specialite']);
    $section = trim($_POST['section']);
    $groupe = trim($_POST['groupe']);
    $pass = password_hash(trim($_POST['pass']), PASSWORD_DEFAULT); // 🔹 تشفير كلمة المرور

    // التحقق مما إذا كان هناك صورة مرفوعة
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // التحقق من أن رقم التسجيل غير مكرر
    $stmt = $conn->prepare("SELECT matricul FROM tamerdz WHERE matricul = ?");
    $stmt->bind_param("s", $matricul);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['register_error'] = 'رقم التسجيل مستخدم بالفعل';
        $_SESSION['active_form'] = 'register';
    } else {
        if ($image !== null) {
            // إدخال المستخدم مع الصورة
            $stmt = $conn->prepare("INSERT INTO tamerdz (nom, prenom, matricul, specialite, section, groupe, image, pass) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssbs", $nom, $prenom, $matricul, $specialite, $section, $groupe, $image, $pass);
            $stmt->send_long_data(6, $image);

            $stm = $conn->prepare("INSERT INTO page ( matricul) VALUES (? )");
        $stm->bind_param("s", $matricul );
        $stm->execute();

        } else {
            // إدخال المستخدم بدون صورة
            $stmt = $conn->prepare("INSERT INTO tamerdz (nom, prenom, matricul, specialite, section, groupe, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nom, $prenom, $matricul, $specialite, $section, $groupe, $pass);

            $stm = $conn->prepare("INSERT INTO page ( matricul) VALUES (? )");
        $stm->bind_param("s", $matricul );
        $stm->execute();

        }

        if ($stmt->execute()) {
            $_SESSION['register_success'] = "تم إنشاء الحساب بنجاح!";
        } else {
            $_SESSION['register_error'] = "حدث خطأ أثناء التسجيل.";
        }
    }

    $stmt->close();
    $stm->close();
    header("Location: index.php");
    exit();
}







if (isset($_POST['login'])) {
    $matricul = trim($_POST['Z1']);
    $pass = trim($_POST['Z2']);

    $stmt = $conn->prepare("SELECT * FROM tamerdz WHERE matricul = ?");
    $stmt->bind_param("s", $matricul);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['pass'])) {
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['matricul'] = $user['matricul'];
            $_SESSION['specialite'] = $user['specialite'];
            $_SESSION['section'] = $user['section'];
            $_SESSION['groupe'] = $user['groupe'];
            header("Location: main/main.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'كلمة المرور غير صحيحة';
            $_SESSION['active_form'] = 'login';
        }
    } else {
        $_SESSION['login_error'] = 'رقم التسجيل غير صحيح';
        $_SESSION['active_form'] = 'login';
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}
?>