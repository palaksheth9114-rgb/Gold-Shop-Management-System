<?php
// Authentication Check File
// Include this at the top of protected pages (like index.php, api.php, etc.)

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Optional: Check session timeout (30 minutes of inactivity)
$timeout_duration = 1800; // 30 minutes in seconds

if (isset($_SESSION['login_time'])) {
    $elapsed_time = time() - $_SESSION['login_time'];
    
    if ($elapsed_time > $timeout_duration) {
        // Session expired due to inactivity
        session_unset();
        session_destroy();
        header('Location: login.php?timeout=1');
        exit;
    }
}

// Update last activity time
$_SESSION['login_time'] = time();

// Function to get current logged-in user information
function getCurrentUser() {
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role' => $_SESSION['role'] ?? 'user'
    ];
}

// Function to check if user has a specific role
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

// Function to check if user is admin
function isAdmin() {
    return hasRole('admin');
}

// Function to check if user is manager or admin
function isManagerOrAdmin() {
    return hasRole('admin') || hasRole('manager');
}

// Function to require admin access
function requireAdmin() {
    if (!isAdmin()) {
        header('HTTP/1.1 403 Forbidden');
        die('Access Denied: Admin privileges required');
    }
}

// Function to require manager or admin access
function requireManagerOrAdmin() {
    if (!isManagerOrAdmin()) {
        header('HTTP/1.1 403 Forbidden');
        die('Access Denied: Manager or Admin privileges required');
    }
}
?>