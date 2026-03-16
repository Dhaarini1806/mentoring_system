<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/AuditLog.php';

class AuthController {

    public function login() {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $csrf = $_POST[CSRF_TOKEN_NAME] ?? '';

            if (!empty($email) && !str_ends_with(strtolower($email), '@rmkcet.ac.in')) {
                $errors[] = 'Please use your institutional email address (@rmkcet.ac.in).';
            } elseif (!verify_csrf_token($csrf)) {
                $errors[] = 'Invalid CSRF token.';
            } else {
                $userModel = new User();
                $user = $userModel->findByEmail($email);
                if ($user && $userModel->verifyPassword($user, $password)) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'email' => $user['email']
                    ];
                    session_regenerate_id(true);

                    $audit = new AuditLog();
                    $audit->log($user['id'], 'LOGIN', 'User logged in');

                    if ($user['role'] === 'admin') {
                        header('Location: ' . BASE_URL . 'admin/index.php');
                    } elseif ($user['role'] === 'mentor') {
                        header('Location: ' . BASE_URL . 'mentor/index.php');
                    } else {
                        header('Location: ' . BASE_URL . 'student/index.php');
                    }
                    exit;
                } else {
                    $errors[] = 'Invalid email or password.';
                }
            }
        }
        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        if (isset($_SESSION['user'])) {
            $audit = new AuditLog();
            $audit->log($_SESSION['user']['id'], 'LOGOUT', 'User logged out');
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}