<?php
// inc/auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
    return current_user() !== null;
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: /proiect_php_app/login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/'));
        exit;
    }
}
