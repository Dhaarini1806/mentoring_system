<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/MentorController.php';

require_role('mentor');
$controller = new MentorController();
$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'students':
        $controller->students();
        break;
    case 'student_profile':
        $controller->studentProfile();
        break;
    case 'counseling_form':
        $controller->counselingForm();
        break;
    case 'counseling_save':
        $controller->saveCounseling();
        break;
    case 'attendance_form':
        $controller->attendanceForm();
        break;
    case 'attendance_save':
        $controller->saveAttendance();
        break;
    case 'marks_form':
        $controller->marksForm();
        break;
    case 'marks_save':
        $controller->saveMarks();
        break;
    default:
        $controller->dashboard();
}