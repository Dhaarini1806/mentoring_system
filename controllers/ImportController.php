<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Mentor.php';
require_once __DIR__ . '/../models/MentorAssignment.php';

class ImportController {
    public function index() {
        require_role('admin');
        include __DIR__ . '/../views/admin/import.php';
    }

    public function importStudents() {
        require_role('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file']['tmp_name'];
            if (($handle = fopen($file, "r")) !== FALSE) {
                // Skip header
                fgetcsv($handle, 1000, ",");
                $studentModel = new Student();
                $count = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Expected CSV format: roll_no, first_name, last_name, email, department, domain, is_honours, is_minor
                    $studentData = [
                        'roll_no' => sanitize($data[0]),
                        'first_name' => sanitize($data[1]),
                        'last_name' => sanitize($data[2]),
                        'email' => sanitize($data[3]),
                        'department' => sanitize($data[4]),
                        'domain' => sanitize($data[5] ?? ''),
                        'is_honours' => (int)($data[6] ?? 0),
                        'is_minor' => (int)($data[7] ?? 0),
                    ];
                    $studentModel->create($studentData);
                    $count++;
                }
                fclose($handle);
                $_SESSION['message'] = "Successfully imported $count students.";
            }
            header('Location: ' . BASE_URL . 'admin/index.php?page=import');
            exit;
        }
    }

    public function importAssignments() {
        require_role('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file']['tmp_name'];
            if (($handle = fopen($file, "r")) !== FALSE) {
                fgetcsv($handle, 1000, ","); // Skip header
                $assignmentModel = new MentorAssignment();
                $mentorModel = new Mentor();
                $studentModel = new Student();
                $count = 0;
                
                // Cache mentors and students by staff_id and roll_no
                $allMentors = $mentorModel->getAll();
                $mentorsByStaffId = [];
                foreach ($allMentors as $m) $mentorsByStaffId[$m['staff_id']] = $m['id'];
                
                $db = DB::getInstance()->getConnection();
                $allStudents = $db->query("SELECT id, roll_no FROM students")->fetchAll();
                $studentsByRollNo = [];
                foreach ($allStudents as $s) $studentsByRollNo[$s['roll_no']] = $s['id'];

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Expected CSV format: mentor_staff_id, student_roll_no
                    $staffId = sanitize($data[0]);
                    $rollNo = sanitize($data[1]);
                    
                    if (isset($mentorsByStaffId[$staffId]) && isset($studentsByRollNo[$rollNo])) {
                        $assignmentModel->assign($mentorsByStaffId[$staffId], $studentsByRollNo[$rollNo]);
                        $count++;
                    }
                }
                fclose($handle);
                $_SESSION['message'] = "Successfully created $count assignments.";
            }
            header('Location: ' . BASE_URL . 'admin/index.php?page=import');
            exit;
        }
    }
}
