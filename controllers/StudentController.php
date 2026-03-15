<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/MentorAssignment.php';
require_once __DIR__ . '/../models/Attendance.php';
require_once __DIR__ . '/../models/Marks.php';
require_once __DIR__ . '/../models/CounselingSession.php';

class StudentController {

    private function getStudentId() {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM students WHERE user_id=:uid LIMIT 1");
        $stmt->bindValue(':uid', (int)$_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row ? (int)$row['id'] : 0;
    }

    public function dashboard() {
        require_role('student');
        $studentId = $this->getStudentId();
        $studentModel = new Student();
        $attendance = new Attendance();
        $marks = new Marks();
        $sessionModel = new CounselingSession();

        $student = $studentModel->getById($studentId);
        $attendancePercent = $attendance->getOverallPercentage($studentId);
        $avgMarks = $marks->getAveragePercentage($studentId);
        $sessions = $sessionModel->getByStudent($studentId);
        $assignmentModel = new MentorAssignment();
        $mentor = $studentId ? $assignmentModel->getMentorByStudent($studentId) : null;

        include __DIR__ . '/../views/student/dashboard.php';
    }

    public function profile() {
        require_role('student');
        $studentId = $this->getStudentId();
        $studentModel = new Student();
        $student = $studentModel->getById($studentId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) die('Invalid CSRF');
            $data = [
                'first_name' => sanitize($_POST['first_name'] ?? ''),
                'last_name' => sanitize($_POST['last_name'] ?? ''),
                'dob' => !empty($_POST['dob']) ? $_POST['dob'] : null,
                'age' => !empty($_POST['age']) ? (int)$_POST['age'] : null,
                'gender' => sanitize($_POST['gender'] ?? ''),
                'email' => sanitize($_POST['email'] ?? ''),
                'mobile_no' => sanitize($_POST['mobile_no'] ?? ''),
                'contact_no' => sanitize($_POST['contact_no'] ?? ''),
                'address' => sanitize($_POST['address_communication'] ?? $_POST['address'] ?? ''),
                'address_communication' => sanitize($_POST['address_communication'] ?? ''),
                'address_permanent' => sanitize($_POST['address_permanent'] ?? ''),
                'community' => sanitize($_POST['community'] ?? ''),
                'caste' => sanitize($_POST['caste'] ?? ''),
                'nationality' => sanitize($_POST['nationality'] ?? ''),
                'religion' => sanitize($_POST['religion'] ?? ''),
                'department' => sanitize($_POST['department'] ?? ''),
                'program' => sanitize($_POST['program'] ?? ''),
                'semester' => (int)($_POST['semester'] ?? 0),
            ];
            $studentModel->update($studentId, $data);
            header('Location: ' . BASE_URL . 'student/index.php?page=profile&saved=1');
            exit;
        }

        include __DIR__ . '/../views/student/profile.php';
    }

    public function attendance() {
        require_role('student');
        $studentId = $this->getStudentId();
        $attendance = new Attendance();
        $rows = $attendance->getByStudent($studentId);
        include __DIR__ . '/../views/student/attendance.php';
    }

    public function marks() {
        require_role('student');
        $studentId = $this->getStudentId();
        $marks = new Marks();
        $rows = $marks->getByStudent($studentId);
        include __DIR__ . '/../views/student/marks.php';
    }

    public function counselingHistory() {
        require_role('student');
        $studentId = $this->getStudentId();
        $sessionModel = new CounselingSession();
        $rows = $sessionModel->getByStudent($studentId);
        include __DIR__ . '/../views/student/counseling_history.php';
    }
}