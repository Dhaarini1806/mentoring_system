<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/AdminController.php';

require_role('admin');
$controller = new AdminController();
$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'students':
        $controller->students();
        break;
    case 'student_form':
        $controller->studentForm();
        break;
    case 'student_save':
        $controller->saveStudent();
        break;
    case 'student_delete':
        $controller->deleteStudent();
        break;
    case 'mentors':
        $controller->mentors();
        break;
    case 'mentor_form':
        $controller->mentorForm();
        break;
    case 'mentor_save':
        $controller->saveMentor();
        break;
    case 'mentor_delete':
        $controller->deleteMentor();
        break;
    case 'mentor_assignment':
        $controller->mentorAssignment();
        break;
    case 'high_risk':
        $controller->highRiskStudents();
        break;
    case 'reports':
        $controller->reports();
        break;
    default:
        $controller->dashboard();
}