<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gold_shop_db');

// Create database connection
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        $conn->set_charset("utf8mb4");
        return $conn;
    } catch (Exception $e) {
        die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]));
    }
}

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Helper function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Helper function to sanitize date (preserves YYYY-MM-DD format)
function sanitizeDate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    // Validate date format YYYY-MM-DD
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
        return $data;
    }
    return $data; // Return as-is if not in expected format (let DB handle validation)
}

// Helper function to sanitize phone number (preserves format with spaces, dashes, plus signs)
function sanitizePhone($data) {
    $data = trim($data);
    $data = stripslashes($data);
    // Remove only potentially dangerous characters but preserve phone format
    $data = preg_replace('/[<>"\']/', '', $data);
    return $data;
}

// Helper function to generate next ID
function generateNextID($conn, $table, $prefix) {
    $sql = "SELECT id FROM $table WHERE id LIKE '$prefix%' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = intval(substr($row['id'], strlen($prefix)));
        $nextId = $lastId + 1;
    } else {
        $nextId = 1;
    }
    
    return $prefix . str_pad($nextId, 4, '0', STR_PAD_LEFT);
}

// Send JSON response
function sendResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    $response = [
        'success' => $success,
        'message' => $message
    ];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}
?>