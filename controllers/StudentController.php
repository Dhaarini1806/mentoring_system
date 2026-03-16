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
            
            // Handle file uploads
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $files = ['x_marksheet', 'xii_marksheet', 'aadhar_file', 'fg_certificate'];
            $filePaths = [];
            foreach ($files as $f) {
                if (!empty($_FILES[$f]['name'])) {
                    $ext = pathinfo($_FILES[$f]['name'], PATHINFO_EXTENSION);
                    $filename = $f . '_' . $studentId . '_' . time() . '.' . $ext;
                    move_uploaded_file($_FILES[$f]['tmp_name'], $uploadDir . $filename);
                    $filePaths[$f . '_path'] = 'uploads/' . $filename;
                }
            }

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
                
                // Personal & Misc
                'mother_tongue' => sanitize($_POST['mother_tongue'] ?? ''),
                'linguistic_minority' => sanitize($_POST['linguistic_minority'] ?? 'No'),
                'goals' => sanitize($_POST['goals'] ?? ''),
                'how_heard_about_college' => sanitize($_POST['how_heard_about_college'] ?? ''),
                'residency_type' => sanitize($_POST['residency_type'] ?? ''),
                'mode_of_transport' => sanitize($_POST['mode_of_transport'] ?? ''),
                'boarding_place' => sanitize($_POST['boarding_place'] ?? ''),
                'blood_group' => sanitize($_POST['blood_group'] ?? ''),

                // Father's Details
                'father_name' => sanitize($_POST['father_name'] ?? ''),
                'father_mobile' => sanitize($_POST['father_mobile'] ?? ''),
                'father_email' => sanitize($_POST['father_email'] ?? ''),
                'father_qualification' => sanitize($_POST['father_qualification'] ?? ''),
                'father_occupation' => sanitize($_POST['father_occupation'] ?? ''),
                'father_office_address' => sanitize($_POST['father_office_address'] ?? ''),
                'father_annual_income' => sanitize($_POST['father_annual_income'] ?? ''),

                // Mother's Details
                'mother_name' => sanitize($_POST['mother_name'] ?? ''),
                'mother_mobile' => sanitize($_POST['mother_mobile'] ?? ''),
                'mother_email' => sanitize($_POST['mother_email'] ?? ''),
                'mother_qualification' => sanitize($_POST['mother_qualification'] ?? ''),
                'mother_occupation' => sanitize($_POST['mother_occupation'] ?? ''),
                'mother_office_address' => sanitize($_POST['mother_office_address'] ?? ''),
                'mother_annual_income' => sanitize($_POST['mother_annual_income'] ?? ''),

                // Academic (X)
                'x_school_name' => sanitize($_POST['x_school_name'] ?? ''),
                'x_register_no' => sanitize($_POST['x_register_no'] ?? ''),
                'x_board' => sanitize($_POST['x_board'] ?? ''),
                'x_medium' => sanitize($_POST['x_medium'] ?? ''),
                'x_passing_month_year' => sanitize($_POST['x_passing_month_year'] ?? ''),
                'x_total_marks' => sanitize($_POST['x_total_marks'] ?? ''),
                'x_percentage_cgpa' => sanitize($_POST['x_percentage_cgpa'] ?? ''),
                'x_marks_json' => json_encode($_POST['x_marks'] ?? []),

                // Academic (XII)
                'xii_school_name' => sanitize($_POST['xii_school_name'] ?? ''),
                'xii_register_no' => sanitize($_POST['xii_register_no'] ?? ''),
                'xii_board' => sanitize($_POST['xii_board'] ?? ''),
                'xii_medium' => sanitize($_POST['xii_medium'] ?? ''),
                'xii_passing_month_year' => sanitize($_POST['xii_passing_month_year'] ?? ''),
                'xii_total_marks' => sanitize($_POST['xii_total_marks'] ?? ''),
                'xii_percentage_cgpa' => sanitize($_POST['xii_percentage_cgpa'] ?? ''),
                'xii_marks_json' => json_encode($_POST['xii_marks'] ?? []),

                // Aadhar & Free Ed
                'aadhar_number' => sanitize($_POST['aadhar_number'] ?? ''),
                'is_first_graduate' => sanitize($_POST['is_first_graduate'] ?? 'No'),
                'reference' => sanitize($_POST['reference'] ?? ''),
            ];

            // Add file paths to data if uploaded
            foreach ($filePaths as $key => $path) {
                $data[$key] = $path;
            }

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