
<?php
session_start();
if (!isset($_SESSION['nom'])) {
    header("Location: index.php");

    exit();

}



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
    background-color: rgba(245, 237, 224, 0.29);
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
<div class="container mx-auto px-4 h-16 flex justify-between items-center">
<h1 class="text-xl font-bold"> Next-Step Education </h1>
<div class="flex items-center gap-4 relative">
<div class="cursor-pointer flex items-center gap-2" onclick="toggleProfile()">
<img src="../photo/photo_2025-03-18_18-35-35.jpg" class="w-10 h-10 rounded-full object-cover" alt="Profile">
<span class="font-medium"> <?php echo htmlspecialchars($_SESSION['nom']) . "  " . htmlspecialchars($_SESSION['prenom']); ?> </span>
</div>
<div id="profileModal" class="hidden absolute left-0 top-12 w-72 bg-white rounded-lg shadow-lg p-4 border">
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
      <p class="font-medium"> mathematique </p>
    </div>
    <div>
      <p class="text-sm text-gray-500"> section </p>
      <p class="font-medium"> A </p>
    </div>
    <div class="pt-2">
      <button onclick="showPasswordModal()" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors">
        changer le mot de passe
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
<script>
function toggleProfile() {
  const modal = document.getElementById('profileModal');
  modal.classList.toggle('hidden');
}
function showPasswordModal() {
  document.getElementById('passwordModal').classList.remove('hidden');
  document.getElementById('profileModal').classList.add('hidden');
}
function closePasswordModal() {
  document.getElementById('passwordModal').classList.add('hidden');
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
</div>
</header>








<main class="container mx-auto px-4 pt-24 pb-8">
<div class="grid grid-cards gap-6 md:grid-cols-3">


<div class="bg-orange-50 rounded-lg p-6 shadow-sm" onclick="window.location.href='module/ANALYSE2.html' " >
<h3 class="text-lg font-semibold mb-4"> Analyse 2 </h3>
<div class="relative pt-1">
<div class="flex mb-2 items-center justify-between">
<div class="text-right">
<span id="ana" class="text-xs font-semibold inline-block text-orange-600">0%</span>
</div>
</div>
<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-orange-200">
<div id="anabar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500"></div>
</div>
</div>
</div>





<div class="bg-purple-50 rounded-lg p-6 shadow-sm" onclick="window.location.href='module/ALGO2.html' ">
<h3 class="text-lg font-semibold mb-4"> Algorithme 2 </h3>
<div class="relative pt-1">
<div class="flex mb-2 items-center justify-between">
<div class="text-right">
<span id="algo" class="text-xs font-semibold inline-block text-purple-600">0%</span>
</div>
</div>
<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-purple-200">
<div id="algobar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500"></div>
</div>
</div>
</div>




<div class="bg-blue-50 rounded-lg p-6 shadow-sm" onclick="window.location.href='module/ALGEBRE2.html' ">
<h3 class="text-lg font-semibold mb-4"> Algebre 2 </h3>
<div class="relative pt-1">
<div class="flex mb-2 items-center justify-between">
<div class="text-right">
<span id="alg" class="text-xs font-semibold inline-block text-blue-600">0%</span>
</div>
</div>
<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
<div id="algbar"  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
</div>
</div>
</div>




<div class="bg-pink-50 rounded-lg p-6 shadow-sm"  onclick="window.location.href='module/STRM2.html' ">
<h3 class="text-lg font-semibold mb-4"> STRM 2 </h3>
<div class="relative pt-1">
<div class="flex mb-2 items-center justify-between">
<div class="text-right">
<span id="strm" class="text-xs font-semibold inline-block text-pink-600">0%</span>
</div>
</div>
<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-pink-200">
<div id="strmbar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"></div>
</div>
</div>
</div>





<div class="bg-green-50 rounded-lg p-6 shadow-sm" onclick="window.location.href='module/ELECTRICITE.html' ">
<h3 class="text-lg font-semibold mb-4"> electrique </h3>
<div class="relative pt-1">
<div class="flex mb-2 items-center justify-between">
<div class="text-right">
<span id="elec"  class="text-xs font-semibold inline-block text-green-600">0%</span>
</div>
</div>
<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
<div id="elecbar"  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
</div>
</div>
</div>



<div class="bg-indigo-50 rounded-lg p-6 shadow-sm"  onclick="window.location.href='module/STAT&PROBA.html' ">
<h3 class="text-lg font-semibold mb-4"> STAT/PROBA </h3>
<div class="relative pt-1">
<div class="flex mb-2 items-center justify-between">
<div class="text-right">
<span id="stat"  class="text-xs font-semibold inline-block text-indigo-600">0%</span>
</div>
</div>
<div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200">
<div id="statbar"  class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
</div>
</div>
</div>



</div>
</main>


<script src="tamm.js" >  </script>

</body>
</html>