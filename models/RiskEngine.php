<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Attendance.php';
require_once __DIR__ . '/Marks.php';
require_once __DIR__ . '/CounselingSession.php';

class RiskEngine {
    private $db;
    private $attendance;
    private $marks;
    private $sessions;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
        $this->attendance = new Attendance();
        $this->marks = new Marks();
        $this->sessions = new CounselingSession();
    }

    public function recalculateForStudent($studentId) {
        $attendancePercent = $this->attendance->getOverallPercentage($studentId);
        $averageMarks = $this->marks->getAveragePercentage($studentId);
        $lastSessionDate = $this->sessions->getLastSessionDate($studentId);

        $risk = 'SAFE';
        $now = new DateTime();

        $noCounseling30 = false;
        if ($lastSessionDate) {
            $last = new DateTime($lastSessionDate);
            $diff = $last->diff($now)->days;
            if ($diff > 30) {
                $noCounseling30 = true;
            }
        } else {
            $noCounseling30 = true;
        }

        if (($attendancePercent !== null && $attendancePercent < 75) ||
            ($averageMarks !== null && $averageMarks < 50) ||
            $noCounseling30) {
            $risk = 'HIGH';
        } elseif ($attendancePercent !== null && $attendancePercent >= 75 && $attendancePercent <= 85) {
            $risk = 'MEDIUM';
        }

        $stmt = $this->db->prepare("UPDATE students SET risk_level=:risk WHERE id=:sid");
        $stmt->bindValue(':risk', $risk);
        $stmt->bindValue(':sid', (int)$studentId, PDO::PARAM_INT);
        $stmt->execute();

        return $risk;
    }
}