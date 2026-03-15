<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/MentorAssignment.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Attendance.php';
require_once __DIR__ . '/../models/Marks.php';
require_once __DIR__ . '/../models/CounselingSession.php';
require_once __DIR__ . '/../models/RiskEngine.php';

class MentorController {

    public function dashboard() {
        require_role('mentor');
        $assignment = new MentorAssignment();
        $students = $assignment->getStudentsByMentor($this->getMentorId());
        include __DIR__ . '/../views/mentor/dashboard.php';
    }

    private function getMentorId() {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM mentors WHERE user_id=:uid LIMIT 1");
        $stmt->bindValue(':uid', (int)$_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row ? (int)$row['id'] : 0;
    }

    public function students() {
        require_role('mentor');
        $assignment = new MentorAssignment();
        $students = $assignment->getStudentsByMentor($this->getMentorId());
        include __DIR__ . '/../views/mentor/students_list.php';
    }

    public function studentProfile() {
        require_role('mentor');
        $studentId = (int)($_GET['student_id'] ?? 0);
        $studentModel = new Student();
        $student = $studentId ? $studentModel->getById($studentId) : null;
        if (!$student) {
            header('Location: ' . BASE_URL . 'mentor/index.php');
            exit;
        }
        $attendance = new Attendance();
        $marks = new Marks();
        $sessionModel = new CounselingSession();
        $attendancePercent = $attendance->getOverallPercentage($studentId);
        $avgMarks = $marks->getAveragePercentage($studentId);
        $sessions = $sessionModel->getByStudent($studentId);
        include __DIR__ . '/../views/mentor/student_profile.php';
    }

    public function counselingForm() {
        require_role('mentor');
        $studentId = (int)($_GET['student_id'] ?? 0);
        include __DIR__ . '/../views/mentor/counseling_form.php';
    }

    public function saveCounseling() {
        require_role('mentor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) die('Invalid CSRF');

            $mentorId = $this->getMentorId();
            $sessionModel = new CounselingSession();
            $data = [
                'mentor_id' => $mentorId,
                'student_id' => (int)$_POST['student_id'],
                'session_date' => $_POST['session_date'],
                'mode' => sanitize($_POST['mode']),
                'summary' => sanitize($_POST['summary']),
                'action_items' => sanitize($_POST['action_items']),
                'next_followup_date' => $_POST['next_followup_date'] ?: null
            ];
            $sessionModel->create($data);

            $risk = new RiskEngine();
            $risk->recalculateForStudent((int)$_POST['student_id']);

            header('Location: ' . BASE_URL . 'mentor/index.php?page=students');
            exit;
        }
    }

    public function attendanceForm() {
        require_role('mentor');
        $studentId = (int)($_GET['student_id'] ?? 0);
        include __DIR__ . '/../views/mentor/attendance_form.php';
    }

    public function saveAttendance() {
        require_role('mentor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) die('Invalid CSRF');
            $attendance = new Attendance();
            $studentId = (int)$_POST['student_id'];
            $monthYear = sanitize($_POST['month_year']);
            $total = (int)$_POST['total_classes'];
            $attended = (int)$_POST['attended_classes'];
            $attendance->upsert($studentId, $monthYear, $total, $attended);

            $risk = new RiskEngine();
            $risk->recalculateForStudent($studentId);

            header('Location: ' . BASE_URL . 'mentor/index.php?page=students');
            exit;
        }
    }

    public function marksForm() {
        require_role('mentor');
        $studentId = (int)($_GET['student_id'] ?? 0);
        include __DIR__ . '/../views/mentor/marks_form.php';
    }

    public function saveMarks() {
        require_role('mentor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) die('Invalid CSRF');
            $marks = new Marks();
            $studentId = (int)$_POST['student_id'];
            $marks->upsert(
                $studentId,
                sanitize($_POST['subject_code']),
                sanitize($_POST['subject_name']),
                sanitize($_POST['exam_type']),
                (float)$_POST['internal_mark'],
                (float)$_POST['max_mark']
            );

            $risk = new RiskEngine();
            $risk->recalculateForStudent($studentId);

            header('Location: ' . BASE_URL . 'mentor/index.php?page=students');
            exit;
        }
    }
}