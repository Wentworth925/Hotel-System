<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function is_logged_in() {
    return !empty($_SESSION['user']);
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: /hotel_system_final/login.php');
        exit;
    }
}
function is_admin() {
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'admin';
}
?>
