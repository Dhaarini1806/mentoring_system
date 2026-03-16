<?php
require_once __DIR__ . '/../config/db.php';

try {
    $db = DB::getInstance()->getConnection();
    
    // Add domain, is_honours, is_minor columns to students table
    $sql = "ALTER TABLE students 
            ADD COLUMN IF NOT EXISTS domain VARCHAR(100) DEFAULT NULL,
            ADD COLUMN IF NOT EXISTS is_honours TINYINT(1) DEFAULT 0,
            ADD COLUMN IF NOT EXISTS is_minor TINYINT(1) DEFAULT 0";
    
    $db->exec($sql);
    echo "Student classification fields added successfully.\n";
} catch (PDOException $e) {
    echo "Error adding fields: " . $e->getMessage() . "\n";
}
