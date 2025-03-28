function togglePassword(element) {
    const input = element.parentElement.previousElementSibling;
    const icon = element.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ri-eye-off-line text-gray-400';
    } else {
        input.type = 'password';
        icon.className = 'ri-eye-line text-gray-400';
    }
}

function showSignup() {
    document.getElementById('signup-container').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideSignup() {
    document.getElementById('signup-container').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-image').classList.remove('hidden');
            document.getElementById('default-avatar').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.querySelector('p').textContent = message;
    toast.classList.remove('hidden');
    toast.className = `fixed top-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded shadow-lg`;
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}




;