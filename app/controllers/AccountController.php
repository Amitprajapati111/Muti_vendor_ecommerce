<?php

class AccountController extends Controller
{
    public function profile(): void
    {
        require_login();
        $u = current_user();
        if (is_post()) {
            $name = trim($_POST['name'] ?? '');
            if ($name !== '' && $name !== $u['name']) {
                Database::getInstance()->query('UPDATE users SET name = ? WHERE id = ?', [$name, (int)$u['id']]);
                $u['name'] = $name;
                session_set('auth_user', $u);
                flash('success', 'Profile updated.');
            }
        }
        $this->view('account/profile', ['user' => $u]);
    }

    public function orders(): void
    {
        require_login('customer');
        $user = current_user();
        $orderModel = new Order();
        $orders = $orderModel->getByCustomer((int)$user['id']);
        // Attach items for each order
        foreach ($orders as &$o) {
            $o['items'] = $orderModel->items((int)$o['id']);
        }
        $this->view('account/orders', compact('orders'));
    }
}
