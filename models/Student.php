<?php
require_once __DIR__ . '/../config/db.php';

class Student {
    private $db;

    /** All fillable columns (for create/update). Run database/migrate_students_columns.php to add new ones. */
    private static $columns = [
        'user_id', 'roll_no', 'register_number', 'academic_year', 'course', 'branch',
        'lateral_entry', 'quota', 'first_name', 'last_name', 'dob', 'age', 'gender',
        'email', 'mobile_no', 'department', 'program', 'semester', 'contact_no',
        'address', 'address_communication', 'address_permanent', 'community', 'caste', 'nationality', 'religion',
        'mother_tongue', 'linguistic_minority', 'goals', 'how_heard_about_college', 'residency_type', 'mode_of_transport', 'boarding_place', 'blood_group',
        'father_name', 'father_mobile', 'father_email', 'father_qualification', 'father_occupation', 'father_office_address', 'father_annual_income',
        'mother_name', 'mother_mobile', 'mother_email', 'mother_qualification', 'mother_occupation', 'mother_office_address', 'mother_annual_income',
        'x_school_name', 'x_register_no', 'x_board', 'x_medium', 'x_passing_month_year', 'x_marks_json', 'x_total_marks', 'x_percentage_cgpa', 'x_marksheet_path',
        'xii_school_name', 'xii_register_no', 'xii_board', 'xii_medium', 'xii_passing_month_year', 'xii_marks_json', 'xii_total_marks', 'xii_percentage_cgpa', 'xii_marksheet_path',
        'aadhar_number', 'aadhar_path', 'is_first_graduate', 'fg_certificate_path', 'reference',
        'domain', 'is_honours', 'is_minor'
    ];

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function getAll($limit = 50, $offset = 0) {
        $sql = "SELECT * FROM students ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $cols = array_intersect(self::$columns, array_keys($data));
        if (empty($cols)) {
            $cols = ['user_id', 'roll_no', 'first_name', 'last_name', 'gender', 'department', 'program', 'semester', 'contact_no', 'address'];
        }
        $placeholders = array_map(fn($c) => ':' . $c, $cols);
        $sql = "INSERT INTO students (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        foreach ($cols as $c) {
            $stmt->bindValue(':' . $c, $data[$c] ?? null);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $cols = array_intersect(self::$columns, array_keys($data));
        if (empty($cols)) {
            return false;
        }
        $set = implode(', ', array_map(fn($c) => $c . '=:' . $c, $cols));
        $sql = "UPDATE students SET " . $set . " WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        foreach ($cols as $c) {
            $stmt->bindValue(':' . $c, $data[$c] ?? null);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id=:id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getHighRisk() {
        $stmt = $this->db->query("SELECT * FROM students WHERE risk_level = 'HIGH'");
        return $stmt->fetchAll();
    }
}
