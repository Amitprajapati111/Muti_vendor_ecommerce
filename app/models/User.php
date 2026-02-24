<?php

class User
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->query('SELECT * FROM users WHERE email = ? LIMIT 1', [$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->query('SELECT * FROM users WHERE id = ? LIMIT 1', [$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(array $data): int
    {
        $this->db->query('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)', [
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ]);
        return (int)$this->db->lastInsertId();
    }
}
