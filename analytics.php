<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/AnalyticsController.php';

$controller = new AnalyticsController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'risk':
        $controller->riskDistribution();
        break;
    case 'attendance':
        $controller->attendanceTrend();
        break;
    default:
        http_response_code(404);
        echo 'Not found';
}