<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mentoring Portal - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #e9ecef 100%);
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: var(--rmkcet-primary);
            color: white;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175);
            border-bottom: 4px solid var(--rmkcet-secondary);
        }
        .login-card .form-label {
            color: rgba(255,255,255,0.9);
            font-weight: 400;
        }
        .login-card .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
        }
        .login-card .form-control:focus {
            background: rgba(255,255,255,0.15);
            box-shadow: 0 0 0 0.25rem rgba(254, 193, 39, 0.25);
            border-color: var(--rmkcet-secondary);
        }
        .btn-login {
            background: var(--rmkcet-secondary);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 0.75rem;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            background: #e5ad23;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card login-card p-4 mx-auto" style="max-width: 420px; width:100%;">
        <div class="text-center mb-4">
            <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Logo" style="height:80px; filter: drop-shadow(0 0 10px rgba(0,0,0,0.2));">
            <h4 class="mt-3 fw-bold">Mentoring Portal</h4>
            <p class="small opacity-75">RMK College of Engineering and Technology</p>
        </div>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger py-2 small">
                <?php foreach ($errors as $e): ?>
                    <div><?php echo $e; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php 
        $get_error = $_GET['error'] ?? '';
        if ($get_error): 
            $msg = 'An error occurred during authentication.';
            if ($get_error === 'invalid_domain') $msg = 'Please use your institutional @rmkcet.ac.in email.';
            if ($get_error === 'user_not_found') $msg = 'Account not found. Please contact admin.';
            if ($get_error === 'google_auth_failed') $msg = 'Google authentication failed.';
        ?>
            <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars(BASE_URL . 'index.php', ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo generate_csrf_token(); ?>">
            <div class="mb-3">
                <label class="form-label">Email ID (@rmkcet.ac.in)</label>
                <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="username@rmkcet.ac.in" pattern="[a-zA-Z0-9._%+-]+@rmkcet\.ac\.in$" title="Please use your @rmkcet.ac.in email address">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>

        <div class="text-center mt-4 mb-3">
            <span class="text-white-50">OR</span>
        </div>

        <a href="<?php echo BASE_URL; ?>index.php?page=google_login" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2">
            <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" alt="Google Logo" style="width: 20px; height: 20px;">
            Sign in with Google
        </a>
    </div>
</div>
</body>
</html>