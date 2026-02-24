<?php

class Category
{
    private Database $db;

    public function __construct() { $this->db = Database::getInstance(); }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM categories ORDER BY name ASC')->fetchAll();
    }

    public function create(string $name): int
    {
        $this->db->query('INSERT INTO categories (name) VALUES (?)', [$name]);
        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id): void
    {
        $this->db->query('DELETE FROM categories WHERE id = ?', [$id]);
    }
}
