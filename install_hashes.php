<?php
/**
 * One-time setup: creates or updates login users with known passwords.
 * Run once (e.g. open in browser), then delete or restrict access.
 */
require_once __DIR__ . '/config/db.php';
$db = DB::getInstance()->getConnection();

$users = [
    ['username' => 'admin',   'password' => 'Admin@123',  'role' => 'admin'],
    ['username' => 'mentor1', 'password' => 'Pass@123',   'role' => 'mentor'],
    ['username' => 'student1','password' => 'Pass@123',  'role' => 'student'],
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

echo 'Setup complete. You can log in with the sample accounts. Delete or protect this file.';
