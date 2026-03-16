<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/AuthController.php';

$auth = new AuthController();
$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'google_login':
        $auth->googleLogin();
        break;
    case 'google_callback':
        $auth->googleCallback();
        break;
    case 'logout':
        $auth->logout();
        break;
    default:
        $auth->login();
}