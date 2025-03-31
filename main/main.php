
<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['nom'])) {
    header("Location: index.php");
    exit();
}

// تعيين قيمة matricul
$matricul = $_SESSION['matricul'];

// جلب الصورة من قاعدة البيانات
$stmt = $conn->prepare("SELECT image FROM tamerdz WHERE matricul = ?");
$stmt->bind_param("s", $matricul);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> STEPPING </title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
theme: {
extend: {
colors: {
primary: '#4A90E2',
secondary: '#82C4E1'
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
<style>
  body{
    background-color: rgba(0, 0, 0, 0.29);
  }
:where([class^="ri-"])::before { content: "\f3c2"; }
@media (min-width: 768px) {
.grid-cards {
grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
}
}

</style>
</head>
<body >
<header class="bg-white shadow-sm fixed w-full top-0 z-50">
  <div class="container mx-auto px-4 h-16 flex items-center justify-between">
    
    <!-- اسم المستخدم في أقصى اليسار -->
    <div class="flex-1 flex justify-start items-center gap-4 relative">
      <div class="cursor-pointer flex items-center gap-2" onclick="toggleProfile()">

      <img src="display_image.php" class="w-10 h-10 rounded-full object-cover" alt="Profile">
<span class="font-medium"> <?php echo htmlspecialchars($_SESSION['nom']) . "  " . htmlspecialchars($_SESSION['prenom']); ?> </span>
</div>
<div id="profileModal" class="hidden absolute right-0 top-12 w-72 bg-white rounded-lg shadow-lg p-4 border">


  <div class="space-y-3">
    <div>
      <p class="text-sm text-gray-500"> nom et prenom </p>
      <p class="font-medium">  <?php echo htmlspecialchars($_SESSION['nom']) . "  " . htmlspecialchars($_SESSION['prenom']); ?>  </p>
    </div>
    <div>
      <p class="text-sm text-gray-500"> matricul </p>
      <p class="font-medium">  <?php echo htmlspecialchars($_SESSION['matricul']) ; ?>  </p>
    </div>
    <div>
      <p class="text-sm text-gray-500"> filiere </p>
      <p class="font-medium"> <?php echo htmlspecialchars($_SESSION['specialite']) ; ?> </p>
    </div>
    <div>
      <p class="text-sm text-gray-500"> section </p>
      <p class="font-medium"> <?php echo htmlspecialchars($_SESSION['section']) ; ?> </p>
    </div>
    <div>
      <p class="text-sm text-gray-500"> groupe </p>
      <p class="font-medium"> <?php echo htmlspecialchars($_SESSION['groupe']) ; ?> </p>
    </div>
    <div class="pt-2">
      <button onclick="showPasswordModal()" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors">
        changer le mot de passe
      </button>
    </div>
    <div class="pt-2">
      <button onclick="showimageModal()" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors">
      changer la photo de profile
      </button>
    </div>
  </div>
</div>

<div id="passwordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-96">
    <form action="update_pass.php"  method="POST" >
    <h3 class="text-lg font-semibold mb-4"> changer le mot de passe </h3>
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"> Nouveau mot de passe </label>
        <input name="newpass" type="text" id="newPassword" class="w-full border rounded-button px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/20">
      </div>
      </form>
      <div class="flex gap-2">
        <button type="submit"  name="update" onclick="updatePassword()" class="flex-1 bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors"> envoyer </button>
        <button onclick="closePasswordModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-button hover:bg-gray-200 transition-colors"> Annuler </button>
      </div>
    </div>

  </div>



</div>


<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 w-96">
    <form action="update_image.php" method="POST" enctype="multipart/form-data">
      <h3 class="text-lg font-semibold mb-4">Changer la photo de profil</h3>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle photo</label>
          <input name="image1" type="file" accept="image/*" required class="w-full px-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-primary focus:border-primary">
        </div>
      </div>
      <div class="flex gap-2 mt-4">
        <button type="submit" name="update1" class="flex-1 bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors">
          Envoyer
        </button>
        <button type="button" onclick="closeimageModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-button hover:bg-gray-200 transition-colors">
          Annuler
        </button>
      </div>
    </form>
  </div>
</div>



</div>




<script>
function toggleProfile() {
  const modal = document.getElementById('profileModal');
  modal.classList.toggle('hidden');
}
function showPasswordModal() {
  document.getElementById('passwordModal').classList.remove('hidden');
  document.getElementById('profileModal').classList.add('hidden');
}
function showimageModal() {
  document.getElementById('imageModal').classList.remove('hidden');
  document.getElementById('profileModal').classList.add('hidden');
}
function closePasswordModal() {
  document.getElementById('passwordModal').classList.add('hidden');
}
function closeimageModal() {
  document.getElementById('imageModal').classList.add('hidden');
}
function updatePassword() {
  closeimageModal();
}
function updatePassword() {
 // const newPassword = document.getElementById('newPassword').value;
 // const confirmPassword = document.getElementById('confirmPassword').value;
  
  //if (!newPassword || !confirmPassword) {
   // showNotification('يرجى ملء جميع الحقول', 'error');
   // return;
 // }
  
  //if (newPassword !== confirmPassword) {
   // showNotification('كلمات المرور غير متطابقة', 'error');
   // return;
 // }
 // showNotification('تم تحديث كلمة المرور بنجاح', 'success');
  closePasswordModal();
}
function showNotification(message, type) {
  const notification = document.createElement('div');
  notification.className = `fixed top-4 left-4 p-4 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} z-50`;
  notification.textContent = message;
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.remove();
  }, 3000);
}
document.addEventListener('click', (e) => {
  const profileModal = document.getElementById('profileModal');
  const passwordModal = document.getElementById('passwordModal');
  
  if (!e.target.closest('#profileModal') && !e.target.closest('.cursor-pointer')) {
    profileModal.classList.add('hidden');
  }
  
  if (e.target === passwordModal) {
    closePasswordModal();
  }
});
</script>





<div class="absolute left-1/2 transform -translate-x-1/2">
  <div class="relative flex bg-gray-200 rounded-full p-1 w-40">
    <!-- زر S1 -->
    <input type="radio" id="s1" name="switch" value="s1" class="hidden peer/s1" onclick="showAlert()">
    <label for="s1" class="w-1/2 text-center py-2 rounded-full cursor-pointer peer-checked/s1:bg-green-500 peer-checked/s1:text-white transition">S1</label>

    <!-- زر S2 (مفعل افتراضيًا) -->
    <input type="radio" id="s2" name="switch" value="s2" class="hidden peer/s2" checked>
    <label for="s2" class="w-1/2 text-center py-2 rounded-full cursor-pointer peer-checked/s2:bg-green-500 peer-checked/s2:text-white transition">S2</label>
  </div>
</div>

<script>
  function showAlert() {
    alert("  صفحة S1 غير جاهزة حاليا ");
    document.getElementById("s2").checked = true; // إعادة تحديد S2 تلقائيًا
  } 
</script>




    <!-- اسم الموقع في أقصى اليمين -->
    <div class="flex-1 flex justify-end">
      <h1 class="text-xl font-bold text-right">Next-Step Education</h1>
    </div>

</div>
</header>








<main class="container mx-auto px-4 pt-24 pb-8">
<div class="grid grid-cards gap-6 md:grid-cols-3">






<div class="bg-orange-50 rounded-lg p-6 shadow-sm text-right flex flex-col items-end" 
     onclick="window.location.href='module/ANALYSE2.html'" 
     dir="rtl">
  
  <h3 class="text-lg font-semibold mb-4 w-full text-left">Analyse 2</h3>

  <div class="relative pt-1 w-full">
    <div class="flex mb-2 items-center justify-end w-full"> 
      <span id="ana" class="text-xs font-semibold inline-block text-orange-600">0%</span>
    </div>

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-orange-200 w-full flex-row-reverse">
      <div id="anabar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500"
           style="width: 0%; direction: rtl; float: right;">
      </div>
    </div>

    <!-- ⏳ Countdown Display -->
    <div class="text-orange-600 font-semibold text-sm mt-2 text-left ">
      next test  : <span id="countdown"> </span>[ for section A ]
    </div>

  </div>

</div>

<script>
// 🎯 ✅ Set exam date (Change this as needed)
const examDate = new Date("2025-04-06T09:40:00").getTime(); 

function updateCountdown() {
    const now = new Date().getTime();
    const timeRemaining = examDate - now;

    if (timeRemaining <= 0) {
        document.getElementById("countdown").innerHTML = "The exam has started!";
        return;
    }

    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    document.getElementById("countdown").innerHTML = `${days} days ${hours} hours`;
}

// 🔄 Update the countdown every hour instead of every second (since seconds/minutes are removed)
setInterval(updateCountdown, 60 * 60 * 1000);

// 🔥 Run the countdown immediately on page load
updateCountdown();
</script>











<div class="bg-purple-50 rounded-lg p-6 shadow-sm text-right flex flex-col items-end" 
     onclick="window.location.href='module/ALGO2.html'" 
     dir="rtl">
  
  <h3 class="text-lg font-semibold mb-4 w-full text-left">Algorithme 2</h3>

  <div class="relative pt-1 w-full">
    <div class="flex mb-2 items-center justify-end w-full"> 
      <span id="algo" class="text-xs font-semibold inline-block text-purple-600">0%</span>
    </div>

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-purple-200 w-full flex-row-reverse">
      <div id="algobar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500"
           style="width: 0%; direction: rtl; float: right;">
      </div>
    </div>

    <!-- ⏳ Countdown Display -->
    <div class="text-purple-600 font-semibold text-sm mt-2 text-left">
      next test  : <span id="countdown-algo"></span>
    </div>

  </div>

</div>

<script>
// 🎯 ✅ Set exam date (Change this as needed)
const examDateAlgo = new Date("2025-04-20T10:00:00").getTime(); 

function updateCountdownAlgo() {
    const now = new Date().getTime();
    const timeRemaining = examDateAlgo - now;

    if (timeRemaining <= 0) {
        document.getElementById("countdown-algo").innerHTML = "The exam has started!";
        return;
    }

    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    document.getElementById("countdown-algo").innerHTML = `${days} days ${hours} hours`;
}

// 🔄 Update the countdown every hour instead of every second
setInterval(updateCountdownAlgo, 60 * 60 * 1000);

// 🔥 Run the countdown immediately on page load
updateCountdownAlgo();
</script>





<div class="bg-blue-50 rounded-lg p-6 shadow-sm text-right flex flex-col items-end" 
     onclick="window.location.href='module/ALGEBRE2.html'" 
     dir="rtl">
  
  <h3 class="text-lg font-semibold mb-4 w-full text-left">Algebre 2</h3>

  <div class="relative pt-1 w-full">
    <div class="flex mb-2 items-center justify-end w-full"> 
      <span id="alg" class="text-xs font-semibold inline-block text-blue-600">0%</span>
    </div>

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200 w-full flex-row-reverse">
      <div id="algbar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"
           style="width: 0%; direction: rtl; float: right;">
      </div>
    </div>

    <!-- ⏳ Countdown Display -->
    <div class="text-blue-600 font-semibold text-sm mt-2 text-left">
     next test  : <span id="countdown-algebre"></span>
    </div>

  </div>

</div>

<script>
// 🎯 ✅ Set exam date (Change this as needed)
const examDateAlgebre = new Date("2025-04-25T10:00:00").getTime(); 

function updateCountdownAlgebre() {
    const now = new Date().getTime();
    const timeRemaining = examDateAlgebre - now;

    if (timeRemaining <= 0) {
        document.getElementById("countdown-algebre").innerHTML = "The exam has started!";
        return;
    }

    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    document.getElementById("countdown-algebre").innerHTML = `${days} days ${hours} hours`;
}

// 🔄 Update the countdown every hour instead of every second
setInterval(updateCountdownAlgebre, 60 * 60 * 1000);

// 🔥 Run the countdown immediately on page load
updateCountdownAlgebre();
</script>





<div class="bg-pink-50 rounded-lg p-6 shadow-sm text-right flex flex-col items-end" 
     onclick="window.location.href='module/STRM2.html'" 
     dir="rtl">
  
  <h3 class="text-lg font-semibold mb-4 w-full text-left">STRM 2</h3>

  <div class="relative pt-1 w-full">
    <div class="flex mb-2 items-center justify-end w-full"> 
      <span id="strm" class="text-xs font-semibold inline-block text-pink-600">0%</span>
    </div>

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-pink-200 w-full flex-row-reverse">
      <div id="strmbar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"
           style="width: 0%; direction: rtl; float: right;">
      </div>
    </div>

    <!-- ⏳ Countdown Display -->
    <div class="text-pink-600 font-semibold text-sm mt-2 text-left">
      next test  : <span id="countdown-strm"></span>
    </div>

  </div>

</div>

<script>
// 🎯 ✅ Set exam date (Change this as needed)
const examDateStrm = new Date("2025-05-10T10:00:00").getTime(); 

function updateCountdownStrm() {
    const now = new Date().getTime();
    const timeRemaining = examDateStrm - now;

    if (timeRemaining <= 0) {
        document.getElementById("countdown-strm").innerHTML = "The exam has started!";
        return;
    }

    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    document.getElementById("countdown-strm").innerHTML = `${days} days ${hours} hours`;
}

// 🔄 Update the countdown every hour instead of every second
setInterval(updateCountdownStrm, 60 * 60 * 1000);

// 🔥 Run the countdown immediately on page load
updateCountdownStrm();
</script>






<div class="bg-green-50 rounded-lg p-6 shadow-sm text-right flex flex-col items-end" 
     onclick="window.location.href='module/ELECTRICITE.html'" 
     dir="rtl">
  
  <h3 class="text-lg font-semibold mb-4 w-full text-left">Electrique</h3>

  <div class="relative pt-1 w-full">
    <div class="flex mb-2 items-center justify-end w-full"> 
      <span id="elec" class="text-xs font-semibold inline-block text-green-600">0%</span>
    </div>

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200 w-full flex-row-reverse">
      <div id="elecbar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"
           style="width: 0%; direction: rtl; float: right;">
      </div>
    </div>

    <!-- ⏳ Countdown Display -->
    <div class="text-green-600 font-semibold text-sm mt-2 text-left">
      next test  : <span id="countdown-elec"></span>
    </div>

  </div>

</div>

<script>
// 🎯 ✅ Set exam date (Change this as needed)
const examDateElec = new Date("2025-06-15T10:00:00").getTime(); 

function updateCountdownElec() {
    const now = new Date().getTime();
    const timeRemaining = examDateElec - now;

    if (timeRemaining <= 0) {
        document.getElementById("countdown-elec").innerHTML = "The exam has started!";
        return;
    }

    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    document.getElementById("countdown-elec").innerHTML = `${days} days ${hours} hours`;
}

// 🔄 Update the countdown every hour
setInterval(updateCountdownElec, 60 * 60 * 1000);

// 🔥 Run the countdown immediately on page load
updateCountdownElec();
</script>




<div class="bg-indigo-50 rounded-lg p-6 shadow-sm text-right flex flex-col items-end" 
     onclick="window.location.href='module/STAT&PROBA.html'" 
     dir="rtl">
  
  <h3 class="text-lg font-semibold mb-4 w-full text-left">PROBA/STAT</h3>

  <div class="relative pt-1 w-full">
    <div class="flex mb-2 items-center justify-end w-full"> 
      <span id="stat" class="text-xs font-semibold inline-block text-indigo-600">0%</span>
    </div>

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200 w-full flex-row-reverse">
      <div id="statbar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"
           style="width: 0%; direction: rtl; float: right;">
      </div>
    </div>

    <!-- ⏳ Countdown Display -->
    <div class="text-indigo-600 font-semibold text-sm mt-2 text-left">
      next test  : <span id="countdown-stat"></span>
    </div>

  </div>

</div>

<script>
// 🎯 ✅ Set exam date (Change this as needed)
const examDateStat = new Date("2025-06-20T09:00:00").getTime(); 

function updateCountdownStat() {
    const now = new Date().getTime();
    const timeRemaining = examDateStat - now;

    if (timeRemaining <= 0) {
        document.getElementById("countdown-stat").innerHTML = "The exam has started!";
        return;
    }

    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

    document.getElementById("countdown-stat").innerHTML = `${days} days ${hours} hours`;
}

// 🔄 Update the countdown every hour
setInterval(updateCountdownStat, 60 * 60 * 1000);

// 🔥 Run the countdown immediately on page load
updateCountdownStat();
</script>




</div>
</main>


<script src="new.js" >  </script>

</body>
</html>