<script>
    (function () {
        const slides = document.querySelectorAll('.dashboard-bg .dashboard-slide');
        if (!slides.length) return;
        let current = 0;
        setInterval(() => {
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }, 6000);
    })();
</script>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\components\admin-dashboard-background-script.blade.php ENDPATH**/ ?>