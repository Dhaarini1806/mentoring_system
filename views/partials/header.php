<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Mentoring System'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
            <img src="<?php echo BASE_URL; ?>assets/images/logo.png" style="height:32px;" alt="Logo">
            Mentoring Portal
        </a>
        <div class="d-flex align-items-center">
            <!-- Theme Toggle -->
            <button id="themeToggle" class="btn btn-sm btn-outline-light me-3">
                <i class="bi bi-sun-fill" id="themeIcon"></i>
            </button>

            <?php if (isset($_SESSION['user'])): ?>
                <span class="navbar-text me-3 small d-none d-md-inline">
                    <?php echo sanitize($_SESSION['user']['username']); ?> (<?php echo sanitize($_SESSION['user']['role']); ?>)
                </span>
                <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    // Immediate script to prevent flash of un-themed content
    const theme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', theme);
    window.addEventListener('DOMContentLoaded', () => {
        const icon = document.getElementById('themeIcon');
        if (theme === 'dark') {
            icon.classList.replace('bi-sun-fill', 'bi-moon-fill');
        }
    });
</script>

<div class="container-fluid p-0">
    <div class="main-wrapper">