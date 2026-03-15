<?php
require_once __DIR__ . '/../config/db.php';

class Marks {
    private $db;
    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function upsert($studentId, $subjectCode, $subjectName, $examType, $mark, $max = 100) {
        $sql = "INSERT INTO marks (student_id, subject_code, subject_name, exam_type, internal_mark, max_mark)
                VALUES (:sid, :scode, :sname, :exam, :mark, :max)
                ON DUPLICATE KEY UPDATE internal_mark = :mark, max_mark = :max, subject_name = :sname";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->bindValue(':scode', $subjectCode);
        $stmt->bindValue(':sname', $subjectName);
        $stmt->bindValue(':exam', $examType);
        $stmt->bindValue(':mark', $mark);
        $stmt->bindValue(':max', $max);
        return $stmt->execute();
    }

    public function getByStudent($studentId) {
        $stmt = $this->db->prepare("SELECT * FROM marks WHERE student_id=:sid");
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAveragePercentage($studentId) {
        $stmt = $this->db->prepare("SELECT AVG(internal_mark / max_mark * 100) AS avgp
                                    FROM marks WHERE student_id=:sid");
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row && $row['avgp'] !== null ? (float)$row['avgp'] : null;
    }
}