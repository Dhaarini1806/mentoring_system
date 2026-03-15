<?php
require_once __DIR__ . '/../config/db.php';

class Attendance {
    private $db;
    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function upsert($studentId, $monthYear, $total, $attended) {
        $sql = "INSERT INTO attendance (student_id, month_year, total_classes, attended_classes)
                VALUES (:student_id, :month_year, :total_classes, :attended_classes)
                ON DUPLICATE KEY UPDATE total_classes = :total_classes, attended_classes = :attended_classes";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':student_id', (int)$studentId, PDO::PARAM_INT);
        $stmt->bindValue(':month_year', $monthYear);
        $stmt->bindValue(':total_classes', (int)$total, PDO::PARAM_INT);
        $stmt->bindValue(':attended_classes', (int)$attended, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getByStudent($studentId) {
        $stmt = $this->db->prepare("SELECT * FROM attendance WHERE student_id=:sid ORDER BY month_year DESC");
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOverallPercentage($studentId) {
        $stmt = $this->db->prepare("SELECT SUM(total_classes) AS total, SUM(attended_classes) AS attended
                                    FROM attendance WHERE student_id=:sid");
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row || $row['total'] == 0) return null;
        return ($row['attended'] / $row['total']) * 100;
    }
}