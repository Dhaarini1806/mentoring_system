<?php
// Global configuration

// Base URL must point to application root (mentoring_system/), not the current script directory.
// When inside admin/index.php, SCRIPT_NAME is e.g. /mentoring_system/admin/index.php — we want base = /mentoring_system/
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
if (preg_match('#^(.*)/(?:admin|mentor|student)(?:/|$)#', $scriptDir, $m)) {
    $scriptDir = $m[1] ?: '/'; // application root (e.g. /mentoring_system)
}
$base = ($scriptDir === '' || $scriptDir === '/') ? '/' : rtrim($scriptDir, '/') . '/';
define('BASE_URL', $protocol . '://' . $host . $base);
define('DB_HOST', 'localhost');
define('DB_NAME', 'mentoring_system');
define('DB_USER', 'root');
define('DB_PASS', ''); // default XAMPP

// CSRF settings
define('CSRF_TOKEN_NAME', 'csrf_token');

// Session settings (must set ini options before session_start())
session_name('mentor_portal_session');
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();

// Regenerate session ID periodically
if (!isset($_SESSION['regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = time();
} elseif (time() - $_SESSION['regenerated'] > 300) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = time();
}

// Autoloader for models and controllers
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../models/' . $class . '.php',
        __DIR__ . '/../controllers/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Helper: generate & verify CSRF tokens
function generate_csrf_token() {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function verify_csrf_token($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

// Helper: check role and redirect
function require_role($role) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}

// Sanitization helper
function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}