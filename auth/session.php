<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_type']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function requireRole($role) {
    if (!isLoggedIn() || $_SESSION['user_type'] !== $role) {
        header("Location: unauthorized.php");
        exit();
    }
}

function getUserFullName() {
    if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
        return $_SESSION['first_name'] . " " . $_SESSION['last_name'];
    }

    return "Guest";
}
?>