<?php

class Review
{
    private Database $db;

    public function __construct() { $this->db = Database::getInstance(); }

    public function forProduct(int $productId): array
    {
        $sql = 'SELECT r.*, u.name FROM reviews r JOIN users u ON u.id=r.customer_id WHERE r.product_id = ? ORDER BY r.id DESC';
        return $this->db->query($sql, [$productId])->fetchAll();
    }

    public function add(int $productId, int $customerId, int $rating, string $comment): int
    {
        $this->db->query('INSERT INTO reviews (product_id, customer_id, rating, comment) VALUES (?, ?, ?, ?)', [
            $productId, $customerId, $rating, $comment
        ]);
        return (int)$this->db->lastInsertId();
    }
}
