<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/StudentController.php';

require_role('student');
$controller = new StudentController();
$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'profile':
        $controller->profile();
        break;
    case 'attendance':
        $controller->attendance();
        break;
    case 'marks':
        $controller->marks();
        break;
    case 'counseling':
        $controller->counselingHistory();
        break;
    default:
        $controller->dashboard();
}