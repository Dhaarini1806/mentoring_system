<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($username, $password, $role, $email = null) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password_hash, role, email) 
                VALUES (:username, :password_hash, :role, :email)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password_hash', $hash);
        $stmt->bindValue(':role', $role);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function verifyPassword($user, $password) {
        $hash = $user['password_hash'] ?? $user['password'] ?? '';
        return $hash !== '' && password_verify($password, $hash);
    }

    /** Get users by role for linking to student/mentor records */
    public function getByRole($role) {
        $stmt = $this->db->prepare("SELECT id, username, email FROM users WHERE role = :role ORDER BY username");
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}