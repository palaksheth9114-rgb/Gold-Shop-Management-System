<?php
// Logout Script
// This file handles user logout and session cleanup

// Start the session
session_start();

// Store username for goodbye message (optional)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

// Unset all session variables
$_SESSION = array();

// Delete the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session completely
session_destroy();

// Redirect to login page with logout message
header('Location: login.php?logout=success');
exit;
?>