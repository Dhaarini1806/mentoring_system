<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Mentoring System'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
            <img src="<?php echo BASE_URL; ?>assets/images/logo.svg" style="height:32px;" alt="">
            Mentoring Portal
        </a>
        <div class="d-flex">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="navbar-text me-3 small">
                    <?php echo sanitize($_SESSION['user']['username']); ?> (<?php echo sanitize($_SESSION['user']['role']); ?>)
                </span>
                <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">