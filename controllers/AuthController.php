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

    public function googleLogin() {
        $params = [
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type' => 'offline',
            'prompt' => 'select_account'
        ];
        $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query($params);
        header('Location: ' . $url);
        exit;
    }

    public function googleCallback() {
        if (!isset($_GET['code'])) {
            header('Location: ' . BASE_URL . 'index.php');
            exit;
        }

        $code = $_GET['code'];
        $params = [
            'code' => $code,
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'grant_type' => 'authorization_code'
        ];

        // Exchange code for token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        if (!isset($data['access_token'])) {
            header('Location: ' . BASE_URL . 'index.php?error=google_auth_failed');
            exit;
        }

        // Fetch user info
        $ch = curl_init('https://www.googleapis.com/oauth2/v3/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $data['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        $userInfo = json_decode($response, true);

        $email = $userInfo['email'] ?? '';
        if (!$email || !str_ends_with(strtolower($email), '@rmkcet.ac.in')) {
            header('Location: ' . BASE_URL . 'index.php?error=invalid_domain');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'email' => $user['email']
            ];
            session_regenerate_id(true);

            $audit = new AuditLog();
            $audit->log($user['id'], 'LOGIN_GOOGLE', 'User logged in via Google');

            if ($user['role'] === 'admin') {
                header('Location: ' . BASE_URL . 'admin/index.php');
            } elseif ($user['role'] === 'mentor') {
                header('Location: ' . BASE_URL . 'mentor/index.php');
            } else {
                header('Location: ' . BASE_URL . 'student/index.php');
            }
            exit;
        } else {
            header('Location: ' . BASE_URL . 'index.php?error=user_not_found');
            exit;
        }
    }
}