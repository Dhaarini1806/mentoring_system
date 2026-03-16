<?php
/**
 * Migration: adds comprehensive student fields (Personal, Parent, Academic, Aadhar, Free Ed).
 * Run: .../mentoring_system/database/add_all_student_fields.php
 */
require_once __DIR__ . '/../config/db.php';
$db = DB::getInstance()->getConnection();

$columns = [
    // Personal Info additions
    "ADD COLUMN mother_tongue VARCHAR(50) NULL",
    "ADD COLUMN linguistic_minority VARCHAR(10) NULL DEFAULT 'No'",
    "ADD COLUMN goals TEXT NULL",
    "ADD COLUMN how_heard_about_college VARCHAR(100) NULL",
    "ADD COLUMN residency_type VARCHAR(50) NULL",
    "ADD COLUMN mode_of_transport VARCHAR(50) NULL",
    "ADD COLUMN boarding_place VARCHAR(100) NULL",
    "ADD COLUMN blood_group VARCHAR(10) NULL",

    // Father's details
    "ADD COLUMN father_name VARCHAR(100) NULL",
    "ADD COLUMN father_mobile VARCHAR(20) NULL",
    "ADD COLUMN father_email VARCHAR(100) NULL",
    "ADD COLUMN father_qualification VARCHAR(100) NULL",
    "ADD COLUMN father_occupation VARCHAR(100) NULL",
    "ADD COLUMN father_office_address TEXT NULL",
    "ADD COLUMN father_annual_income VARCHAR(50) NULL",

    // Mother's details
    "ADD COLUMN mother_name VARCHAR(100) NULL",
    "ADD COLUMN mother_mobile VARCHAR(20) NULL",
    "ADD COLUMN mother_email VARCHAR(100) NULL",
    "ADD COLUMN mother_qualification VARCHAR(100) NULL",
    "ADD COLUMN mother_occupation VARCHAR(100) NULL",
    "ADD COLUMN mother_office_address TEXT NULL",
    "ADD COLUMN mother_annual_income VARCHAR(50) NULL",

    // Academic Detail (Standard X)
    "ADD COLUMN x_school_name VARCHAR(200) NULL",
    "ADD COLUMN x_register_no VARCHAR(50) NULL",
    "ADD COLUMN x_board VARCHAR(100) NULL",
    "ADD COLUMN x_medium VARCHAR(50) NULL",
    "ADD COLUMN x_passing_month_year VARCHAR(50) NULL",
    "ADD COLUMN x_marks_json TEXT NULL",
    "ADD COLUMN x_total_marks VARCHAR(20) NULL",
    "ADD COLUMN x_percentage_cgpa VARCHAR(20) NULL",
    "ADD COLUMN x_marksheet_path VARCHAR(255) NULL",

    // Qualifying Examination Details (10+2)
    "ADD COLUMN xii_school_name VARCHAR(200) NULL",
    "ADD COLUMN xii_register_no VARCHAR(50) NULL",
    "ADD COLUMN xii_board VARCHAR(100) NULL",
    "ADD COLUMN xii_medium VARCHAR(50) NULL",
    "ADD COLUMN xii_passing_month_year VARCHAR(50) NULL",
    "ADD COLUMN xii_marks_json TEXT NULL",
    "ADD COLUMN xii_total_marks VARCHAR(20) NULL",
    "ADD COLUMN xii_percentage_cgpa VARCHAR(20) NULL",
    "ADD COLUMN xii_marksheet_path VARCHAR(255) NULL",

    // Aadhar & Free Education
    "ADD COLUMN aadhar_number VARCHAR(20) NULL",
    "ADD COLUMN aadhar_path VARCHAR(255) NULL",
    "ADD COLUMN is_first_graduate VARCHAR(10) NULL DEFAULT 'No'",
    "ADD COLUMN fg_certificate_path VARCHAR(255) NULL",
    "ADD COLUMN reference TEXT NULL"
];

echo "<pre>";
foreach ($columns as $col) {
    try {
        $db->exec("ALTER TABLE students " . $col);
        echo "Success: " . $col . "\n";
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "Already exists: " . explode(' ', trim($col), 4)[2] . "\n";
        } else {
            echo "Error running [ALTER TABLE students $col]: " . $e->getMessage() . "\n";
        }
    }
}
echo "Migration finished.</pre>";
