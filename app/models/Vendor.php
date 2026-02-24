<?php

class Vendor
{
    private Database $db;

    public function __construct() { $this->db = Database::getInstance(); }

    public function create(int $userId, string $shopName, string $description): int
    {
        $this->db->query('INSERT INTO vendors (user_id, shop_name, description, status) VALUES (?, ?, ?, "pending")', [
            $userId, $shopName, $description
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function findByUserId(int $userId): ?array
    {
        $stmt = $this->db->query('SELECT * FROM vendors WHERE user_id = ? LIMIT 1', [$userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function allPending(): array
    {
        return $this->db->query('SELECT v.*, u.name, u.email FROM vendors v JOIN users u ON u.id=v.user_id WHERE v.status = "pending" ORDER BY v.id DESC')->fetchAll();
    }

    public function updateStatus(int $id, string $status): void
    {
        $this->db->query('UPDATE vendors SET status = ? WHERE id = ?', [$status, $id]);
    }

    public function approved(): array
    {
        return $this->db->query('SELECT id, shop_name FROM vendors WHERE status = "approved" ORDER BY shop_name ASC')->fetchAll();
    }
}
