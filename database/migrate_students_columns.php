<?php
/**
 * One-time migration: adds registration and personal info columns to students table.
 * Run once in browser: .../mentoring_system/database/migrate_students_columns.php
 * Then delete or protect this file.
 */
require_once __DIR__ . '/../config/db.php';
$db = DB::getInstance()->getConnection();

$columns = [
    "ADD COLUMN register_number VARCHAR(50) NULL",
    "ADD COLUMN academic_year VARCHAR(20) NULL",
    "ADD COLUMN course VARCHAR(30) NULL",
    "ADD COLUMN branch VARCHAR(30) NULL",
    "ADD COLUMN lateral_entry VARCHAR(10) NULL DEFAULT 'No'",
    "ADD COLUMN quota VARCHAR(30) NULL",
    "ADD COLUMN dob DATE NULL",
    "ADD COLUMN age INT NULL",
    "ADD COLUMN email VARCHAR(100) NULL",
    "ADD COLUMN mobile_no VARCHAR(20) NULL",
    "ADD COLUMN address_communication VARCHAR(500) NULL",
    "ADD COLUMN address_permanent VARCHAR(500) NULL",
    "ADD COLUMN community VARCHAR(50) NULL",
    "ADD COLUMN caste VARCHAR(50) NULL",
    "ADD COLUMN nationality VARCHAR(50) NULL",
    "ADD COLUMN religion VARCHAR(50) NULL",
];

foreach ($columns as $col) {
    try {
        $db->exec("ALTER TABLE students " . $col);
        echo "Added: " . explode(' ', trim($col))[2] . "<br>";
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "Already exists: " . explode(' ', trim($col))[2] . "<br>";
        } else {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}

echo "<p><strong>Migration done.</strong> Delete this file after use.</p>";
