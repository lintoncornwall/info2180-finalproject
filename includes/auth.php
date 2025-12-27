<?php
session_start();

function isLoggedIn(): bool {
    return isset($_SESSION['user']); //will tell if user is logged in
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header("Location: login.php"); //go to log in page if not already log in
        exit;
    }
}

function isAdmin(): bool {
    return isLoggedIn() && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'; //tell if user is admin
}

function requireAdmin(): void {
    requireLogin();
    if (!isAdmin()) {
        http_response_code(403);
        echo "403 Forbidden - Admins only."; //block if it is not admin
        exit;
    }
}
