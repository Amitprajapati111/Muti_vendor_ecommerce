<?php

class AuthController extends Controller
{
    public function login(): void
    {
        $userModel = new User();
        if (is_post()) {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = $userModel->findByEmail($email);
            $ok = false;
            if ($user) {
                // Primary: verify hashed password
                if (!empty($user['password']) && strlen((string)$user['password']) >= 55 && password_verify($password, $user['password'])) {
                    $ok = true;
                }
                // Dev fallback: allow plaintext match when APP_DEBUG is true (useful for seed/demo data)
                if (!$ok && defined('APP_DEBUG') && APP_DEBUG && $password === $user['password']) {
                    $ok = true;
                }
            }
            if ($ok) {
                unset($user['password']);
                session_set('auth_user', $user);
                flash('success', 'Welcome back, ' . e($user['name']) . '!');
                redirect('home');
            }
            flash('error', 'Invalid credentials');
        }
        $this->view('auth/login');
    }

    public function register(): void
    {
        $userModel = new User();
        $vendorModel = new Vendor();
        if (is_post()) {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'customer';

            if ($userModel->findByEmail($email)) {
                flash('error', 'Email already registered');
                $this->view('auth/register');
                return;
            }

            $userId = $userModel->create(compact('name', 'email', 'password', 'role'));

            if ($role === 'vendor') {
                $shop_name = trim($_POST['shop_name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $vendorModel->create($userId, $shop_name, $description);
                flash('success', 'Vendor registration submitted. Await admin approval.');
            } else {
                flash('success', 'Registration successful. You can now login.');
            }
            redirect('auth/login');
            return;
        }
        $this->view('auth/register');
    }

    public function logout(): void
    {
        session_forget('auth_user');
        flash('success', 'Logged out');
        redirect('home');
    }

    public function forgot(): void
    {
        if (is_post()) {
            $email = trim($_POST['email'] ?? '');
            $user = (new User())->findByEmail($email);
            if ($user) {
                $token = bin2hex(random_bytes(16));
                Database::getInstance()->query('INSERT INTO password_resets (user_id, token, expires_at, used) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE), 0)', [
                    (int)$user['id'], $token, PASSWORD_RESET_EXPIRY_MINUTES
                ]);
                $link = base_url('auth/reset/' . $token);
                flash('success', 'Password reset link (for demo): ' . $link);
            } else {
                flash('error', 'No user found with that email');
            }
        }
        $this->view('auth/forgot');
    }

    public function reset(string $token): void
    {
        $db = Database::getInstance();
        $row = $db->query('SELECT * FROM password_resets WHERE token = ? AND used = 0 AND expires_at > NOW() LIMIT 1', [$token])->fetch();
        if (!$row) {
            flash('error', 'Invalid or expired token');
            redirect('auth/forgot');
        }
        if (is_post()) {
            $password = $_POST['password'] ?? '';
            $db->query('UPDATE users SET password = ? WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), (int)$row['user_id']]);
            $db->query('UPDATE password_resets SET used = 1 WHERE id = ?', [(int)$row['id']]);
            flash('success', 'Password updated. You may login now.');
            redirect('auth/login');
        }
        $this->view('auth/reset', ['token' => $token]);
    }
}
