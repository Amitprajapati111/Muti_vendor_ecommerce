<?php

class VendorController extends Controller
{
    public function dashboard(): void
    {
        require_login('vendor');
        $this->view('dashboard/vendor/index');
    }

    public function products(): void
    {
        require_login('vendor');
        $db = Database::getInstance();
        $user = current_user();
        $vendor = (new Vendor())->findByUserId((int)$user['id']);
        if (!$vendor || $vendor['status'] !== 'approved') {
            flash('error', 'Your vendor account is not approved yet.');
            redirect('home');
        }
        $items = $db->query('SELECT * FROM products WHERE vendor_id = ? ORDER BY id DESC', [(int)$vendor['id']])->fetchAll();
        $categories = (new Category())->all();
        $this->view('dashboard/vendor/products', compact('items', 'categories', 'vendor'));
    }

    public function addProduct(): void
    {
        require_login('vendor');
        $user = current_user();
        $vendor = (new Vendor())->findByUserId((int)$user['id']);
        if (!$vendor || $vendor['status'] !== 'approved') { flash('error', 'Not approved'); redirect('home'); }

        if (is_post()) {
            $data = [
                'vendor_id' => (int)$vendor['id'],
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'category_id' => (int)($_POST['category_id'] ?? 0),
                'price' => (float)($_POST['price'] ?? 0),
                'stock' => (int)($_POST['stock'] ?? 0),
                'brand' => trim($_POST['brand'] ?? ''),
                'images' => array_filter(array_map('trim', explode('\n', $_POST['images'] ?? ''))),
            ];
            (new Product())->create($data);
            flash('success', 'Product added');
            redirect('vendor/products');
        }
        redirect('vendor/products');
    }

    public function deleteProduct(int $id): void
    {
        require_login('vendor');
        $user = current_user();
        $vendor = (new Vendor())->findByUserId((int)$user['id']);
        if (!$vendor || $vendor['status'] !== 'approved') { flash('error', 'Not approved'); redirect('home'); }
        $db = Database::getInstance();
        $row = $db->query('SELECT id, vendor_id FROM products WHERE id = ? LIMIT 1', [(int)$id])->fetch();
        if (!$row || (int)$row['vendor_id'] !== (int)$vendor['id']) { flash('error', 'Unauthorized'); redirect('vendor/products'); }
        $db->query('DELETE FROM products WHERE id = ?', [(int)$id]);
        flash('success', 'Product deleted');
        redirect('vendor/products');
    }

    public function orders(): void
    {
        require_login('vendor');
        $user = current_user();
        $vendor = (new Vendor())->findByUserId((int)$user['id']);
        if (!$vendor || $vendor['status'] !== 'approved') { flash('error', 'Not approved'); redirect('home'); }
        $db = Database::getInstance();
        $sql = 'SELECT o.id AS order_id, o.created_at, o.status AS order_status, u.name AS customer_name,
                       oi.id AS item_id, oi.quantity, oi.price, oi.status AS item_status,
                       p.name AS product_name, p.images
                FROM order_items oi
                JOIN orders o ON o.id = oi.order_id
                JOIN products p ON p.id = oi.product_id
                JOIN users u ON u.id = o.customer_id
                WHERE p.vendor_id = ?
                ORDER BY o.id DESC, oi.id ASC';
        $rows = $db->query($sql, [(int)$vendor['id']])->fetchAll();
        // Group by order
        $orders = [];
        foreach ($rows as $r) {
            $oid = (int)$r['order_id'];
            if (!isset($orders[$oid])) {
                $orders[$oid] = [
                    'order_id' => $oid,
                    'created_at' => $r['created_at'],
                    'order_status' => $r['order_status'],
                    'customer_name' => $r['customer_name'],
                    'items' => []
                ];
            }
            $orders[$oid]['items'][] = $r;
        }
        $this->view('dashboard/vendor/orders', ['orders' => $orders, 'vendor' => $vendor]);
    }

    public function updateItemStatus(int $itemId, string $status): void
    {
        require_login('vendor');
        $user = current_user();
        $vendor = (new Vendor())->findByUserId((int)$user['id']);
        if (!$vendor || $vendor['status'] !== 'approved') { flash('error', 'Not approved'); redirect('home'); }
        $allowed = ['pending','shipped','completed'];
        if (!in_array($status, $allowed, true)) { flash('error', 'Invalid status'); redirect('vendor/orders'); }
        $db = Database::getInstance();
        $row = $db->query('SELECT oi.id, p.vendor_id FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE oi.id = ? LIMIT 1', [(int)$itemId])->fetch();
        if (!$row || (int)$row['vendor_id'] !== (int)$vendor['id']) { flash('error', 'Unauthorized'); redirect('vendor/orders'); }
        $db->query('UPDATE order_items SET status = ? WHERE id = ?', [$status, (int)$itemId]);
        flash('success', 'Item status updated to ' . $status);
        redirect('vendor/orders');
    }
}
