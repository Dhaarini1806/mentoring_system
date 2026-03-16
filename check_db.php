<?php
require_once __DIR__ . '/config/db.php';
$db = DB::getInstance()->getConnection();

echo "Tables in " . DB_NAME . ":\n";
$stmt = $db->query("SHOW TABLES");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    echo "- " . $row[0] . "\n";
    $stmt2 = $db->query("DESCRIBE " . $row[0]);
    while ($col = $stmt2->fetch()) {
        echo "  " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
}
