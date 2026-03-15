<?php
require_once __DIR__ . '/../config/db.php';

class MentorAssignment {
    private $db;
    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function assign($mentorId, $studentId) {
        $sql = "INSERT INTO mentor_assignment (mentor_id, student_id) VALUES (:mentor_id, :student_id)
                ON DUPLICATE KEY UPDATE mentor_id = VALUES(mentor_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':mentor_id', (int)$mentorId, PDO::PARAM_INT);
        $stmt->bindValue(':student_id', (int)$studentId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getStudentsByMentor($mentorId) {
        $sql = "SELECT s.* FROM students s
                INNER JOIN mentor_assignment ma ON ma.student_id = s.id
                WHERE ma.mentor_id = :mentor_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':mentor_id', (int)$mentorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMentorByStudent($studentId) {
        $sql = "SELECT m.* FROM mentors m
                INNER JOIN mentor_assignment ma ON ma.mentor_id = m.id
                WHERE ma.student_id = :student_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':student_id', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /** Get all assignments with mentor and student names for admin listing */
    public function getAssignments() {
        $sql = "SELECT ma.id, ma.mentor_id, ma.student_id,
                m.name AS mentor_name, m.department AS mentor_dept,
                s.roll_no, s.first_name, s.last_name, s.department AS student_dept
                FROM mentor_assignment ma
                INNER JOIN mentors m ON m.id = ma.mentor_id
                INNER JOIN students s ON s.id = ma.student_id
                ORDER BY m.name, s.roll_no";
        return $this->db->query($sql)->fetchAll();
    }
}