document.addEventListener("DOMContentLoaded", function () {
    const progressBar = document.getElementById("progress-bar");
    const progressText = document.getElementById("progress-text");

    if (!progressBar || !progressText) {
        console.error("Error: عناصر شريط التقدم غير موجودة في HTML.");
        return;
    }

    const checkboxes = document.querySelectorAll(".lesson-checkbox");

    // ✅ تحميل تقدم المستخدم عند فتح الصفحة
    fetch("progress/get_progress4.php")
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // تحديث شريط التقدم
            progressBar.style.width = data.progress + "%";
            progressText.innerText = data.progress + "%";

            // ✅ تحديث كل checkbox بحالتها المخزنة في قاعدة البيانات
            checkboxes.forEach(checkbox => {
                const lesson = checkbox.getAttribute("data-lesson"); // جلب رقم الدرس
                if (data[`elec${lesson}`] == 1) { // تأكد أن القيمة تساوي 1 وليس true فقط
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });  
        }
    })
    .catch(error => console.error("Fetch error:", error));

    // ✅ تحديث التقدم عند تغيير checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            const lesson = this.getAttribute("data-lesson");
            const checked = this.checked ? 1 : 0;

            // تحديث الواجهة فورًا
            let checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            let newProgress = Math.round((checkedCount / checkboxes.length) * 100);
            progressBar.style.width = newProgress + "%";
            progressText.innerText = newProgress + "%";

            // ✅ إرسال التحديث إلى السيرفر
            fetch("progress/update_progress4.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `lesson=${lesson}&checked=${checked}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error("Error updating progress:", data.message);
                }
            })
            .catch(error => console.error("Fetch error:", error));
        });
    });
});