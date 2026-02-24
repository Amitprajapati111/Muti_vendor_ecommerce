<?php

class Order
{
    private Database $db;

    public function __construct() { $this->db = Database::getInstance(); }

    public function create(int $customerId, float $total, string $status = 'pending'): int
    {
        $this->db->query('INSERT INTO orders (customer_id, total_amount, status, created_at) VALUES (?, ?, ?, NOW())', [
            $customerId, $total, $status
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function addItem(int $orderId, int $productId, int $quantity, float $price): void
    {
        $this->db->query('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)', [
            $orderId, $productId, $quantity, $price
        ]);
    }

    public function getByCustomer(int $customerId): array
    {
        $sql = 'SELECT * FROM orders WHERE customer_id = ? ORDER BY id DESC';
        return $this->db->query($sql, [$customerId])->fetchAll();
    }

    public function items(int $orderId): array
    {
        $sql = 'SELECT oi.*, p.name, p.images FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE oi.order_id = ?';
        return $this->db->query($sql, [$orderId])->fetchAll();
    }
}
