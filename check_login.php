<?php
/**
 * Temporary diagnostic: run to see why login might fail. DELETE after fixing login.
 * Open: http://localhost:8080/mentoring_system/check_login.php
 */
header('Content-Type: text/html; charset=utf-8');
echo '<pre>';

try {
    require_once __DIR__ . '/config/db.php';
    $db = DB::getInstance()->getConnection();
    echo "1. Database connection: OK\n\n";
} catch (Exception $e) {
    echo "1. Database connection: FAILED - " . $e->getMessage() . "\n";
    exit;
}

try {
    $cols = $db->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_ASSOC);
    echo "2. Table 'users' exists. Columns: ";
    echo implode(', ', array_column($cols, 'Field')) . "\n\n";
} catch (Exception $e) {
    echo "2. Table 'users': FAILED - " . $e->getMessage() . "\n";
    echo "   Run setup_users.php first to create the table.\n";
    exit;
}

$stmt = $db->query("SELECT id, username, role FROM users");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "3. Users in table: " . count($rows) . "\n";
foreach ($rows as $r) {
    echo "   - id={$r['id']} username={$r['username']} role={$r['role']}\n";
}
echo "\n";

$admin = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
$admin->execute(['admin']);
$user = $admin->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "4. User 'admin': NOT FOUND. Run setup_users.php to create it.\n";
    exit;
}
echo "4. User 'admin' found (id={$user['id']})\n";
$hashCol = isset($user['password_hash']) ? 'password_hash' : (isset($user['password']) ? 'password' : null);
if (!$hashCol) {
    echo "   No password column found. Table must have 'password_hash' or 'password'.\n";
    exit;
}
$storedHash = $user[$hashCol];
echo "   Stored hash length: " . strlen($storedHash ?? '') . " (should be 60 for bcrypt)\n";
$ok = password_verify('Admin@123', $storedHash);
echo "   password_verify('Admin@123', stored): " . ($ok ? 'TRUE' : 'FALSE') . "\n";

if (!$ok) {
    echo "\n   => Login will fail. Run setup_users.php to reset the password, then delete this file.\n";
} else {
    echo "\n   => Password is correct. If login still fails, check session/cookies or BASE_URL.\n";
}
echo '</pre>';
