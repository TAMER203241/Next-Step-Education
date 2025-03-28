
<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}



?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#6366F1'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
  
</head>
<body class="bg-gray-50 min-h-screen">
    <div id="login-container" class="flex min-h-screen">
        <div class="w-full max-w-md m-auto bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                
                <h1 class="text-2xl font-bold text-gray-900"> Next-Step Education</h1>
                <h2 class="text-2xl font-bold text-gray-900">تسجيل الدخول</h2>
                <?= showError($errors['login']);?>
                <?= showError($errors['register']);?>
            </div>

            <form id="login-form" class="space-y-6" action="tamer.php" method="post" >
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"   > رقم التسجيل </label>
                    <div class="relative">
                        <input type="number" name="Z1" required class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary" placeholder=" ادخل رقم التسجيل ">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="ri-mail-line text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <input type="password" name="Z2" required class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary" placeholder="أدخل كلمة المرور">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword(this)">
                            <i class="ri-eye-line text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <button name="login" type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors font-medium" >تسجيل الدخول</button>
            </form>

            <div class="mt-6 text-center">
                <button onclick="showSignup()" class="text-primary hover:text-primary/80 text-sm font-medium">إنشاء حساب جديد</button>
            </div>
        </div>
    </div>

    <div id="signup-container" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">إنشاء حساب جديد</h2>
                <button onclick="hideSignup()" class="text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form id="signup-form" class="space-y-6" action="tamer.php" method="post"  >
                

                <div class="grid grid-cols-2 gap-4">
                
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">  الاسم  </label>
                        <input  name="prenom" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">اللقب</label>
                        <input name="nom" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> رقم التسجيل </label>
                    <div class="relative">
                        <input name="matricul" type="number" required class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="ri-mail-line text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <input name="pass" type="password" required class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword(this)">
                            <i class="ri-eye-line text-gray-400"></i>
                        </div>
                    </div>
                </div>
        
                <button name="register" type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors font-medium" >إنشاء الحساب</button>
            </form>
        </div>
    </div>

    <div id="toast" class="fixed top-4 right-4 hidden bg-green-500 text-white px-6 py-3 rounded shadow-lg">
        <p class="text-sm"></p>
    </div>

    <script src="index.js"> </script>
</body>
</html>