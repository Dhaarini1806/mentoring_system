<?php
require_once __DIR__ . '/../config/config.php';

class AnalyticsController {

    public function riskDistribution() {
        require_role('admin');
        header('Content-Type: application/json');
        $db = DB::getInstance()->getConnection();
        $data = [];
        foreach (['HIGH','MEDIUM','SAFE'] as $level) {
            $stmt = $db->prepare("SELECT COUNT(*) AS c FROM students WHERE risk_level=:rl");
            $stmt->bindValue(':rl', $level);
            $stmt->execute();
            $row = $stmt->fetch();
            $data[$level] = (int)$row['c'];
        }
        echo json_encode($data);
        exit;
    }

    public function attendanceTrend() {
        require_role('admin');
        header('Content-Type: application/json');
        $db = DB::getInstance()->getConnection();
        $sql = "SELECT month_year, AVG(attended_classes / total_classes * 100) AS avgp
                FROM attendance
                GROUP BY month_year
                ORDER BY month_year";
        $rows = $db->query($sql)->fetchAll();
        echo json_encode($rows);
        exit;
    }
}