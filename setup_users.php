<?php
/**
 * One-time setup: creates users table (if needed) and sets login passwords.
 * Open in browser: http://localhost:8080/mentoring_system/setup_users.php
 * Then delete this file.
 */
require_once __DIR__ . '/config/db.php';
$db = DB::getInstance()->getConnection();

// Create users table if it doesn't exist (match User model expectations)
$db->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(80) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'student',
        email VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

$users = [
    ['username' => 'admin',    'password' => 'Admin@123', 'role' => 'admin'],
    ['username' => 'mentor1',  'password' => 'Pass@123',  'role' => 'mentor'],
    ['username' => 'student1', 'password' => 'Pass@123', 'role' => 'student'],
];

foreach ($users as $u) {
    $hash = password_hash($u['password'], PASSWORD_DEFAULT);
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$u['username']]);
    $row = $stmt->fetch();

    if ($row) {
        $up = $db->prepare("UPDATE users SET password_hash = ?, role = ? WHERE username = ?");
        $up->execute([$hash, $u['role'], $u['username']]);
    } else {
        $ins = $db->prepare("INSERT INTO users (username, password_hash, role, email) VALUES (?, ?, ?, NULL)");
        $ins->execute([$u['username'], $hash, $u['role']]);
    }
}

header('Content-Type: text/html; charset=utf-8');
echo '<p><strong>Setup complete.</strong> Log in with: admin / Admin@123 (or mentor1/student1 with Pass@123).</p>';
echo '<p>Delete <code>setup_users.php</code> and <code>install_hashes.php</code> after use.</p>';
