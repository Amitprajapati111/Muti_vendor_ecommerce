<?php

class AdminController extends Controller
{
    private function requireAdmin(): void
    {
        $user = current_user();
        if (!$user || $user['role'] !== 'admin') { flash('error', 'Admin only'); redirect('auth/login'); }
    }

    public function dashboard(): void
    {
        $this->requireAdmin();
        $db = Database::getInstance();
        $stats = [
            'users' => (int)$db->query('SELECT COUNT(*) c FROM users')->fetch()['c'],
            'vendors' => (int)$db->query('SELECT COUNT(*) c FROM vendors')->fetch()['c'],
            'products' => (int)$db->query('SELECT COUNT(*) c FROM products')->fetch()['c'],
            'orders' => (int)$db->query('SELECT COUNT(*) c FROM orders')->fetch()['c'],
        ];
        $this->view('dashboard/admin/index', compact('stats'));
    }

    public function vendors(): void
    {
        $this->requireAdmin();
        $vendors = (new Vendor())->allPending();
        $this->view('dashboard/admin/vendors', compact('vendors'));
    }

    public function approveVendor(int $id): void
    {
        $this->requireAdmin();
        (new Vendor())->updateStatus($id, 'approved');
        flash('success', 'Vendor approved');
        redirect('admin/vendors');
    }

    public function rejectVendor(int $id): void
    {
        $this->requireAdmin();
        (new Vendor())->updateStatus($id, 'rejected');
        flash('success', 'Vendor rejected');
        redirect('admin/vendors');
    }

    public function categories(): void
    {
        $this->requireAdmin();
        $cats = (new Category())->all();
        $this->view('dashboard/admin/categories', ['categories' => $cats]);
    }

    public function addCategory(): void
    {
        $this->requireAdmin();
        if (is_post()) {
            $name = trim($_POST['name'] ?? '');
            if ($name !== '') {
                (new Category())->create($name);
                flash('success', 'Category added');
            } else {
                flash('error', 'Name is required');
            }
        }
        redirect('admin/categories');
    }

    public function deleteCategory(int $id): void
    {
        $this->requireAdmin();
        (new Category())->delete((int)$id);
        flash('success', 'Category deleted');
        redirect('admin/categories');
    }
}
