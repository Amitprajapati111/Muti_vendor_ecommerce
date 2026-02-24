<?php

function app_protocol(): string {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    return $https ? 'https' : 'http';
}

function base_url(string $path = ''): string {
    $protocol = app_protocol();
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    $base = rtrim($protocol . '://' . $host . $scriptDir, '/');
    $path = ltrim($path, '/');
    return $path ? $base . '/' . $path : $base;
}

function asset(string $path): string {
    return base_url('assets/' . ltrim($path, '/'));
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function current_url(): string {
    $protocol = app_protocol();
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    return $protocol . '://' . $host . $uri;
}

function redirect(string $path): void {
    header('Location: ' . base_url(ltrim($path, '/')));
    exit;
}

function is_post(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function is_get(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET'; }

function session_get(string $key, $default = null) {
    return $_SESSION[$key] ?? $default;
}

function session_set(string $key, $value): void {
    $_SESSION[$key] = $value;
}

function session_forget(string $key): void {
    unset($_SESSION[$key]);
}

function flash(string $key, ?string $message = null)
{
    if ($message === null) {
        $msg = $_SESSION['_flash'][$key] ?? null;
        if (isset($_SESSION['_flash'][$key])) unset($_SESSION['_flash'][$key]);
        return $msg;
    }
    $_SESSION['_flash'][$key] = $message;
}

function current_user() {
    return $_SESSION['auth_user'] ?? null;
}

function require_login(?string $role = null): void {
    $user = current_user();
    if (!$user) {
        flash('error', 'Please login to continue');
        redirect('auth/login');
    }
    if ($role && ($user['role'] ?? null) !== $role) {
        flash('error', 'Unauthorized');
        redirect('auth/login');
    }
}
