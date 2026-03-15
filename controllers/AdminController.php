<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Mentor.php';
require_once __DIR__ . '/../models/MentorAssignment.php';
require_once __DIR__ . '/../models/RiskEngine.php';
require_once __DIR__ . '/../models/User.php';

class AdminController {

    public function dashboard() {
        require_role('admin');
        $studentModel = new Student();
        $riskEngine = new RiskEngine();

        $db = DB::getInstance()->getConnection();
        $totalStudents = $db->query("SELECT COUNT(*) AS c FROM students")->fetch()['c'];
        $totalMentors = $db->query("SELECT COUNT(*) AS c FROM mentors")->fetch()['c'];

        $high = $db->query("SELECT COUNT(*) AS c FROM students WHERE risk_level='HIGH'")->fetch()['c'];
        $medium = $db->query("SELECT COUNT(*) AS c FROM students WHERE risk_level='MEDIUM'")->fetch()['c'];
        $safe = $db->query("SELECT COUNT(*) AS c FROM students WHERE risk_level='SAFE'")->fetch()['c'];

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function students() {
        require_role('admin');
        $studentModel = new Student();
        $students = $studentModel->getAll();
        include __DIR__ . '/../views/admin/students_list.php';
    }

    public function studentForm() {
        require_role('admin');
        $studentModel = new Student();
        $userModel = new User();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $student = null;
        if ($id) {
            $student = $studentModel->getById($id);
        }
        $users = $userModel->getByRole('student');
        include __DIR__ . '/../views/admin/student_form.php';
    }

    public function saveStudent() {
        require_role('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) {
                die('Invalid CSRF token');
            }
            $studentModel = new Student();
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $data = [
                'roll_no' => sanitize($_POST['roll_no'] ?? ''),
                'register_number' => sanitize($_POST['register_number'] ?? ''),
                'academic_year' => sanitize($_POST['academic_year'] ?? ''),
                'course' => sanitize($_POST['course'] ?? ''),
                'branch' => sanitize($_POST['branch'] ?? ''),
                'lateral_entry' => sanitize($_POST['lateral_entry'] ?? 'No'),
                'quota' => sanitize($_POST['quota'] ?? ''),
                'first_name' => sanitize($_POST['first_name'] ?? ''),
                'last_name' => sanitize($_POST['last_name'] ?? ''),
                'dob' => !empty($_POST['dob']) ? $_POST['dob'] : null,
                'age' => !empty($_POST['age']) ? (int)$_POST['age'] : null,
                'gender' => sanitize($_POST['gender'] ?? ''),
                'email' => sanitize($_POST['email'] ?? ''),
                'mobile_no' => sanitize($_POST['mobile_no'] ?? ''),
                'department' => sanitize($_POST['branch'] ?? $_POST['department'] ?? ''),
                'program' => sanitize($_POST['program'] ?? ''),
                'semester' => (int)($_POST['semester'] ?? 0),
                'contact_no' => sanitize($_POST['contact_no'] ?? ''),
                'address' => sanitize($_POST['address_communication'] ?? $_POST['address'] ?? ''),
                'address_communication' => sanitize($_POST['address_communication'] ?? ''),
                'address_permanent' => sanitize($_POST['address_permanent'] ?? ''),
                'community' => sanitize($_POST['community'] ?? ''),
                'caste' => sanitize($_POST['caste'] ?? ''),
                'nationality' => sanitize($_POST['nationality'] ?? ''),
                'religion' => sanitize($_POST['religion'] ?? ''),
            ];
            if ($id <= 0) {
                $data['user_id'] = (int)($_POST['user_id'] ?? 0);
                $studentModel->create($data);
            } else {
                $studentModel->update($id, $data);
            }
            header('Location: ' . BASE_URL . 'admin/index.php?page=students');
            exit;
        }
    }

    public function deleteStudent() {
        require_role('admin');
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $studentModel = new Student();
            $studentModel->delete($id);
        }
        header('Location: ' . BASE_URL . 'admin/index.php?page=students');
        exit;
    }

    public function mentors() {
        require_role('admin');
        $mentorModel = new Mentor();
        $mentors = $mentorModel->getAll();
        include __DIR__ . '/../views/admin/mentors_list.php';
    }

    public function mentorForm() {
        require_role('admin');
        $mentorModel = new Mentor();
        $userModel = new User();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $mentor = null;
        if ($id) {
            $mentor = $mentorModel->getById($id);
        }
        $users = $userModel->getByRole('mentor');
        include __DIR__ . '/../views/admin/mentor_form.php';
    }

    public function saveMentor() {
        require_role('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) {
                die('Invalid CSRF token');
            }
            $mentorModel = new Mentor();
            $data = [
                'user_id' => (int)($_POST['user_id'] ?? 0),
                'staff_id' => sanitize($_POST['staff_id']),
                'name' => sanitize($_POST['name']),
                'department' => sanitize($_POST['department']),
                'designation' => sanitize($_POST['designation']),
                'contact_no' => sanitize($_POST['contact_no']),
                'email' => sanitize($_POST['email']),
            ];
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            if ($id > 0) {
                $mentorModel->update($id, $data);
            } else {
                $mentorModel->create($data);
            }
            header('Location: ' . BASE_URL . 'admin/index.php?page=mentors');
            exit;
        }
    }

    public function deleteMentor() {
        require_role('admin');
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $mentorModel = new Mentor();
            $mentorModel->delete($id);
        }
        header('Location: ' . BASE_URL . 'admin/index.php?page=mentors');
        exit;
    }

    public function mentorAssignment() {
        require_role('admin');
        $mentorModel = new Mentor();
        $studentModel = new Student();
        $assignmentModel = new MentorAssignment();
        $mentors = $mentorModel->getAll();
        $students = $studentModel->getAll(1000, 0);
        $assignments = $assignmentModel->getAssignments();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST[CSRF_TOKEN_NAME] ?? '')) {
                die('Invalid CSRF token');
            }
            $mentorId = (int)$_POST['mentor_id'];
            foreach ($_POST['student_ids'] as $sid) {
                $assignmentModel->assign($mentorId, (int)$sid);
            }
            header('Location: ' . BASE_URL . 'admin/index.php?page=mentor_assignment&success=1');
            exit;
        }

        include __DIR__ . '/../views/admin/mentor_assignment.php';
    }

    public function highRiskStudents() {
        require_role('admin');
        $studentModel = new Student();
        $students = $studentModel->getHighRisk();
        include __DIR__ . '/../views/admin/high_risk_students.php';
    }

    public function reports() {
        require_role('admin');
        include __DIR__ . '/../views/admin/reports.php';
    }
}