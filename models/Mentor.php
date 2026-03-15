<?php
require_once __DIR__ . '/../config/db.php';

class Mentor {
    private $db;
    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM mentors ORDER BY name");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM mentors WHERE id=:id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO mentors (user_id, staff_id, name, department, designation, contact_no, email)
                VALUES (:user_id, :staff_id, :name, :department, :designation, :contact_no, :email)";
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE mentors SET staff_id=:staff_id, name=:name, department=:department,
                designation=:designation, contact_no=:contact_no, email=:email WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        foreach ($data as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mentors WHERE id=:id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}