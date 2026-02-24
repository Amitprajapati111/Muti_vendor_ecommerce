<?php

class Wishlist
{
    private Database $db;

    public function __construct() { $this->db = Database::getInstance(); }

    public function add(int $customerId, int $productId): void
    {
        $sql = 'INSERT INTO wishlists (customer_id, product_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE product_id = VALUES(product_id)';
        $this->db->query($sql, [$customerId, $productId]);
    }

    public function remove(int $customerId, int $productId): void
    {
        $this->db->query('DELETE FROM wishlists WHERE customer_id = ? AND product_id = ?', [$customerId, $productId]);
    }

    public function isInWishlist(int $customerId, int $productId): bool
    {
        $row = $this->db->query('SELECT id FROM wishlists WHERE customer_id = ? AND product_id = ? LIMIT 1', [$customerId, $productId])->fetch();
        return !empty($row);
    }

    public function allForCustomer(int $customerId): array
    {
        $sql = 'SELECT w.*, p.name, p.price, p.images FROM wishlists w JOIN products p ON p.id=w.product_id WHERE w.customer_id = ? ORDER BY w.id DESC';
        return $this->db->query($sql, [$customerId])->fetchAll();
    }
}
