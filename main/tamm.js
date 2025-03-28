

// استرجاع بيان تاع اناليز
document.addEventListener("DOMContentLoaded", function() {
    console.log("جاري تحميل البيانات...");
    fetch('module/progress/get_progress.php')
        .then(response => response.json())
        .then(data => {
            console.log("البيانات المسترجعة:", data); // التحقق من أن البيانات تصل
            if (data.success) {
                let progress = data.progress; // استخراج progress

                let progressBar = document.querySelector('#anabar');
                let progressPercentage = document.querySelector('#ana');

                if (progressBar && progressPercentage) {
                    progressBar.style.width = progress + "%";
                    progressPercentage.textContent = progress + "%";
                    console.log("تم التحديث بنجاح!");
                } else {
                    console.error("تعذر العثور على العناصر!");
                }
            } else {
                console.error("خطأ في استرجاع البيانات:", data.message);
            }
        })
        .catch(error => console.error("خطأ في الاتصال:", error));
});

//استرجال بيانات تاع strm
document.addEventListener("DOMContentLoaded", function() {
    console.log("جاري تحميل البيانات...");
    fetch('module/progress/get_progress3.php')
        .then(response => response.json())
        .then(data => {
            console.log("البيانات المسترجعة:", data); // التحقق من أن البيانات تصل
            if (data.success) {
                let progress = data.progress; // استخراج progress

                let progressBar = document.querySelector('#strmbar');
                let progressPercentage = document.querySelector('#strm');

                if (progressBar && progressPercentage) {
                    progressBar.style.width = progress + "%";
                    progressPercentage.textContent = progress + "%";
                    console.log("تم التحديث بنجاح!");
                } else {
                    console.error("تعذر العثور على العناصر!");
                }
            } else {
                console.error("خطأ في استرجاع البيانات:", data.message);
            }
        })
        .catch(error => console.error("خطأ في الاتصال:", error));
});

// استرجاع بيانات تاع الغو
document.addEventListener("DOMContentLoaded", function() {
    console.log("جاري تحميل البيانات...");
    fetch('module/progress/get_progress1.php')
        .then(response => response.json())
        .then(data => {
            console.log("البيانات المسترجعة:", data); // التحقق من أن البيانات تصل
            if (data.success) {
                let progress = data.progress; // استخراج progress

                let progressBar = document.querySelector('#algobar');
                let progressPercentage = document.querySelector('#algo');

                if (progressBar && progressPercentage) {
                    progressBar.style.width = progress + "%";
                    progressPercentage.textContent = progress + "%";
                    console.log("تم التحديث بنجاح!");
                } else {
                    console.error("تعذر العثور على العناصر!");
                }
            } else {
                console.error("خطأ في استرجاع البيانات:", data.message);
            }
        })
        .catch(error => console.error("خطأ في الاتصال:", error));
});

// استرجاع بيانات تاع الجبر
document.addEventListener("DOMContentLoaded", function() {
    console.log("جاري تحميل البيانات...");
    fetch('module/progress/get_progress2.php')
        .then(response => response.json())
        .then(data => {
            console.log("البيانات المسترجعة:", data); // التحقق من أن البيانات تصل
            if (data.success) {
                let progress = data.progress; // استخراج progress

                let progressBar = document.querySelector('#algbar');
                let progressPercentage = document.querySelector('#alg');

                if (progressBar && progressPercentage) {
                    progressBar.style.width = progress + "%";
                    progressPercentage.textContent = progress + "%";
                    console.log("تم التحديث بنجاح!");
                } else {
                    console.error("تعذر العثور على العناصر!");
                }
            } else {
                console.error("خطأ في استرجاع البيانات:", data.message);
            }
        })
        .catch(error => console.error("خطأ في الاتصال:", error));
});

// استرجاع بيانات تاع الكتريك
document.addEventListener("DOMContentLoaded", function() {
    console.log("جاري تحميل البيانات...");
    fetch('module/progress/get_progress4.php')
        .then(response => response.json())
        .then(data => {
            console.log("البيانات المسترجعة:", data); // التحقق من أن البيانات تصل
            if (data.success) {
                let progress = data.progress; // استخراج progress

                let progressBar = document.querySelector('#elecbar');
                let progressPercentage = document.querySelector('#elec');

                if (progressBar && progressPercentage) {
                    progressBar.style.width = progress + "%";
                    progressPercentage.textContent = progress + "%";
                    console.log("تم التحديث بنجاح!");
                } else {
                    console.error("تعذر العثور على العناصر!");
                }
            } else {
                console.error("خطأ في استرجاع البيانات:", data.message);
            }
        })
        .catch(error => console.error("خطأ في الاتصال:", error));
});

// استرجاع بيانات تاع ستاتيستيك
document.addEventListener("DOMContentLoaded", function() {
    console.log("جاري تحميل البيانات...");
    fetch('module/progress/get_progress5.php')
        .then(response => response.json())
        .then(data => {
            console.log("البيانات المسترجعة:", data); // التحقق من أن البيانات تصل
            if (data.success) {
                let progress = data.progress; // استخراج progress

                let progressBar = document.querySelector('#statbar');
                let progressPercentage = document.querySelector('#stat');

                if (progressBar && progressPercentage) {
                    progressBar.style.width = progress + "%";
                    progressPercentage.textContent = progress + "%";
                    console.log("تم التحديث بنجاح!");
                } else {
                    console.error("تعذر العثور على العناصر!");
                }
            } else {
                console.error("خطأ في استرجاع البيانات:", data.message);
            }
        })
        .catch(error => console.error("خطأ في الاتصال:", error));
});




// هذي تاع الوضع الليلي 

document.addEventListener('DOMContentLoaded', function () {
    var modeSwitch = document.querySelector('.mode-switch');
    modeSwitch.addEventListener('click', function () { document.documentElement.classList.toggle('dark');
    modeSwitch.classList.toggle('active');
    });
    var listView = document.querySelector('.list-view');
    var gridView = document.querySelector('.grid-view');
    var projectsList = document.querySelector('.project-boxes');
    listView.addEventListener('click', function () {
    gridView.classList.remove('active');
    listView.classList.add('active');
    projectsList.classList.remove('jsGridView');
    projectsList.classList.add('jsListView');
    });
    gridView.addEventListener('click', function () {
    gridView.classList.add('active');
    listView.classList.remove('active');
    projectsList.classList.remove('jsListView');
    projectsList.classList.add('jsGridView');
    });
    document.querySelector('.messages-btn').addEventListener('click', function () {
    document.querySelector('.messages-section').classList.add('show');
    });
    document.querySelector('.messages-close').addEventListener('click', function() {
    document.querySelector('.messages-section').classList.remove('show');
    });
    });


  // هذي تاع الساعة متخربش فيها

    function updateClock() { 
        const now = new Date();
        const day = now.getDate().toString().padStart(2, '0');
        const month = (now.getMonth() + 1).toString().padStart(2, '0');
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const dayName = days[now.getDay()];
        
        
        const dateString = `${dayName} ${day}/${month}`;
        
       
        document.getElementById("date").textContent = dateString;
    }
    


    updateClock();
