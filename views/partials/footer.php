</div> <!-- content-area -->
</div> <!-- main-wrapper -->
</div> <!-- container-fluid -->

<script>
document.getElementById('themeToggle').addEventListener('click', () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    const icon = document.getElementById('themeIcon');
    if (newTheme === 'dark') {
        icon.classList.replace('bi-sun-fill', 'bi-moon-fill');
    } else {
        icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>