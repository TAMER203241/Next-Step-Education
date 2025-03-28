console.log("✅ تم تحميل JavaScript بنجاح!");

const checkboxes = document.querySelectorAll('.lesson-checkbox');
const progressBar = document.querySelector('.progress-bar');
const progressPercentage = document.querySelector('.progress-percentage');
function updateProgress() {
    const total = checkboxes.length;
    const checked = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
    const percentage = (checked / total) * 100;
    progressBar.style.width = `${percentage}%`;
    progressPercentage.textContent = `${Math.round(percentage)}%`;
}

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateProgress);
});




document.addEventListener("DOMContentLoaded", function() {
    var checkbox = document.getElementById("lesson1");
    const checkboxes = document.querySelectorAll('.lesson-checkbox');
    const progressBar = document.querySelector('.progress-bar');
    const progressPercentage = document.querySelector('.progress-percentage');

    function updateProgress() {
        const total = checkboxes.length;
        const checked = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
        const percentage = (checked / total) * 100;
        progressBar.style.width = `${percentage}%`;
        progressPercentage.textContent = `${Math.round(percentage)}%`;
    }

document.getElementById("lesson1").addEventListener("change", function() {
    var lesson1Value = this.checked ? 1 : 0;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "page.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log("🔍 استجابة السيرفر:", xhr.responseText);
            document.getElementById("response").innerHTML = xhr.responseText;
        }
    };

    console.log("📤 إرسال: lesson1=" + lesson1Value);
    xhr.send("lesson1=" + lesson1Value);
});



   var xhr = new XMLHttpRequest();
    xhr.open("GET", "checkbox.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let savedState = JSON.parse(xhr.responseText); // تحويل النص إلى JSON

            // تحديث كل checkBox بناءً على البيانات القادمة من السيرفر
            checkboxes.forEach((checkbox, index) => {
                checkbox.checked = savedState[index] == 1; // ضبط حالة CheckBox
            });

            // تحديث شريط التقدم بعد تحميل الحالات
            updateProgress();
        }
    };
    xhr.send();

    // حفظ حالة CheckBox عند التغيير
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            updateProgress();

            let checkboxIndex = Array.from(checkboxes).indexOf(this);
            let checkboxValue = this.checked ? 1 : 0;

            var xhrSave = new XMLHttpRequest();
            xhrSave.open("POST", "checkbox.php", true);
            xhrSave.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhrSave.onreadystatechange = function() {
                if (xhrSave.readyState === 4) {
                    console.log("🔍 استجابة السيرفر:", xhrSave.responseText);
                }
            };
            xhrSave.send(`lesson${checkboxIndex + 1}=${checkboxValue}`);
        });
    });
});

