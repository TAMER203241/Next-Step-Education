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
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("SELECT matricul FROM tamerdz WHERE matricul = ?");
    $stmt->bind_param("s", $matricul);
    $stmt->execute();
     $stmt->store_result();

    if ($stmt->num_rows > 0) {
         $_SESSION['register_error'] = ' رقم التسجيل مستخدم ';
        $_SESSION['active_form'] = ' تم التسجيل بنجاح ';

    } else {
        
        $stmt = $conn->prepare("INSERT INTO tamerdz (nom, prenom, matricul, specialite, section ,groupe, pass) VALUES (?, ?, ?, ? ,? ,? ,?)");
        $stmt->bind_param("sssssss", $nom, $prenom, $matricul, $specialite, $section, $groupe, $pass);
        $stmt->execute();
        
        $stm = $conn->prepare("INSERT INTO page ( matricul) VALUES (? )");
        $stm->bind_param("s", $matricul );
        $stm->execute();
        
    }

    header("Location: index.php");
        $stmt->close();
        $stm->close();
         exit();
    
   
}

if (isset($_POST['login'])) {
    $matricul = $_POST['Z1'];
    $pass = $_POST['Z2'];

    $result = $conn->query("SELECT * FROM tamerdz WHERE matricul = '$matricul'");
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
       }else { $_SESSION['login_error'] = 'Incorrect email or password';
              $_SESSION['active_form'] = 'login';
              header("Location: index.php");
             exit(); }
}else { $_SESSION['login_error'] = 'Incorrect email or password';
$_SESSION['active_form'] = 'login';
header("Location: index.php");
exit();
   }

}

?>
