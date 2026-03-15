<?php
require_once __DIR__ . '/../config/db.php';

class AuditLog {
    private $db;
    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function log($userId, $action, $details = null) {
        $sql = "INSERT INTO audit_logs (user_id, action, details, ip_address, user_agent)
                VALUES (:user_id, :action, :details, :ip_address, :user_agent)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId ?: null, PDO::PARAM_INT);
        $stmt->bindValue(':action', $action);
        $stmt->bindValue(':details', $details);
        $stmt->bindValue(':ip_address', $_SERVER['REMOTE_ADDR'] ?? '');
        $stmt->bindValue(':user_agent', $_SERVER['HTTP_USER_AGENT'] ?? '');
        $stmt->execute();
    }
}