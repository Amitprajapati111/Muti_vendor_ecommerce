<?php

class Product
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function featured(int $limit = 8): array
    {
        $stmt = $this->db->query('SELECT p.*, c.name AS category_name, v.shop_name, rr.avg_rating, rr.rating_count FROM products p 
            LEFT JOIN categories c ON c.id=p.category_id 
            LEFT JOIN vendors v ON v.id=p.vendor_id 
            LEFT JOIN (
                SELECT product_id, AVG(rating) AS avg_rating, COUNT(*) AS rating_count FROM reviews GROUP BY product_id
            ) rr ON rr.product_id = p.id
            ORDER BY p.id DESC LIMIT ' . (int)$limit);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->query('SELECT p.*, c.name AS category_name, v.shop_name, v.id as vendor_shop_id, rr.avg_rating, rr.rating_count 
            FROM products p 
            LEFT JOIN categories c ON c.id=p.category_id 
            LEFT JOIN vendors v ON v.id=p.vendor_id 
            LEFT JOIN (
                SELECT product_id, AVG(rating) AS avg_rating, COUNT(*) AS rating_count FROM reviews GROUP BY product_id
            ) rr ON rr.product_id = p.id
            WHERE p.id = ? LIMIT 1', [$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function paginate(int $page = 1, int $perPage = 12, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        $where = [];
        $params = [];
        if (!empty($filters['q'])) { $where[] = 'p.name LIKE ?'; $params[] = '%' . $filters['q'] . '%'; }
        if (!empty($filters['category_id'])) { $where[] = 'p.category_id = ?'; $params[] = (int)$filters['category_id']; }
        if (!empty($filters['min'])) { $where[] = 'p.price >= ?'; $params[] = (float)$filters['min']; }
        if (!empty($filters['max'])) { $where[] = 'p.price <= ?'; $params[] = (float)$filters['max']; }
        if (!empty($filters['brand'])) { $where[] = 'p.brand = ?'; $params[] = $filters['brand']; }
        if (!empty($filters['vendor_id'])) { $where[] = 'p.vendor_id = ?'; $params[] = (int)$filters['vendor_id']; }
        $having = '';
        if (!empty($filters['min_rating'])) {
            // Use HAVING on derived column from subquery
            $having = ' HAVING (rr.avg_rating IS NOT NULL AND rr.avg_rating >= ?)';
            $params[] = (float)$filters['min_rating'];
        }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $sql = 'SELECT p.*, c.name AS category_name, v.shop_name, rr.avg_rating, rr.rating_count 
                FROM products p 
                LEFT JOIN categories c ON c.id=p.category_id 
                LEFT JOIN vendors v ON v.id=p.vendor_id 
                LEFT JOIN (
                    SELECT product_id, AVG(rating) AS avg_rating, COUNT(*) AS rating_count FROM reviews GROUP BY product_id
                ) rr ON rr.product_id = p.id 
                ' . $whereSql . 
                $having . ' 
                ORDER BY p.id DESC LIMIT ' . (int)$perPage . ' OFFSET ' . (int)$offset;
        $items = $this->db->query($sql, $params)->fetchAll();

        $countSql = 'SELECT COUNT(*) as cnt FROM (
                        SELECT p.id, rr.avg_rating FROM products p 
                        LEFT JOIN (
                            SELECT product_id, AVG(rating) AS avg_rating FROM reviews GROUP BY product_id
                        ) rr ON rr.product_id = p.id 
                        ' . $whereSql . $having . '
                     ) t';
        $total = (int)$this->db->query($countSql, $params)->fetch()['cnt'];

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pages' => (int)ceil($total / $perPage),
        ];
    }

    public function create(array $data): int
    {
        $this->db->query('INSERT INTO products (vendor_id, name, description, category_id, price, stock, images, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
            $data['vendor_id'], $data['name'], $data['description'], $data['category_id'], $data['price'], $data['stock'], json_encode($data['images'] ?? []), $data['brand'] ?? null
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function related(int $productId, ?int $categoryId, int $limit = 8): array
    {
        if (!$categoryId) { return []; }
        $sql = 'SELECT p.*, c.name AS category_name, v.shop_name, rr.avg_rating, rr.rating_count
                FROM products p 
                LEFT JOIN categories c ON c.id=p.category_id 
                LEFT JOIN vendors v ON v.id=p.vendor_id 
                LEFT JOIN (
                    SELECT product_id, AVG(rating) AS avg_rating, COUNT(*) AS rating_count FROM reviews GROUP BY product_id
                ) rr ON rr.product_id = p.id 
                WHERE p.category_id = ? AND p.id <> ? 
                ORDER BY p.id DESC LIMIT ' . (int)$limit;
        return $this->db->query($sql, [(int)$categoryId, (int)$productId])->fetchAll();
    }
}
