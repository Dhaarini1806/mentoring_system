<?php
require_once __DIR__ . '/../config/db.php';

class CounselingSession {
    private $db;
    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO counseling_sessions (mentor_id, student_id, session_date, mode, summary, action_items, next_followup_date)
                VALUES (:mentor_id, :student_id, :session_date, :mode, :summary, :action_items, :next_followup_date)";
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function getByStudent($studentId) {
        $stmt = $this->db->prepare("SELECT cs.*, m.name AS mentor_name 
                                    FROM counseling_sessions cs
                                    INNER JOIN mentors m ON m.id = cs.mentor_id
                                    WHERE cs.student_id=:sid ORDER BY cs.session_date DESC");
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLastSessionDate($studentId) {
        $stmt = $this->db->prepare("SELECT session_date FROM counseling_sessions
                                    WHERE student_id=:sid ORDER BY session_date DESC LIMIT 1");
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row ? $row['session_date'] : null;
    }
}