<?php
session_start();

$error = '';
$success = '';

// Check for logout message
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $success = 'You have been successfully logged out!';
}

// Check for timeout message
if (isset($_GET['timeout']) && $_GET['timeout'] === '1') {
    $error = 'Your session has expired due to inactivity. Please login again.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    $conn = getDBConnection();
    
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    
    // Query to check user credentials
    $stmt = $conn->prepare("SELECT id, username, password, role, email FROM users WHERE email = ? AND status = 'active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Check if password matches (supports both plain text and hashed passwords)
        $passwordMatch = false;
        
        // First try password_verify for hashed passwords
        if (password_verify($password, $user['password'])) {
            $passwordMatch = true;
        } 
        // If that fails, try plain text comparison (for your current database)
        else if ($password === $user['password']) {
            $passwordMatch = true;
        }
        
        if ($passwordMatch) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['login_time'] = time();
            
            // Update last login time
            $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param("i", $user['id']);
            $updateStmt->execute();
            $updateStmt->close();
            
            // Redirect to dashboard
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    } else {
        $error = 'Invalid email or password';
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gold Shop Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 40px 30px;
            text-align: center;
            color: #fff;
        }
        
        .login-header h1 {
            font-size: 2em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .login-header p {
            font-size: 1em;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 600;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .error-message {
            background: #fed7d7;
            color: #742a2a;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #e53e3e;
            font-size: 14px;
            animation: shake 0.5s;
        }
        
        .success-message {
            background: #c6f6d5;
            color: #22543d;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #38a169;
            font-size: 14px;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f7fafc;
            color: #718096;
            font-size: 13px;
        }
        
        .icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
        }
        
        .credentials-info {
            background: #bee3f8;
            color: #2c5282;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3182ce;
            font-size: 13px;
        }
        
        .credentials-info h4 {
            margin-bottom: 8px;
            font-size: 14px;
        }      
   
        @media (max-width: 480px) {
            .login-container {
                margin: 0 10px;
            }
            
            .login-header h1 {
                font-size: 1.5em;
            }
            
            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>💎 Gold Shop</h1>
            <p>Management System Login</p>
        </div>
        
        <div class="login-body">
            <?php if ($success): ?>
                <div class="success-message">
                    ✅ <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error-message">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">
                        <span class="icon">📧</span> Email
                    </label>
                    <input type="email" id="email" name="email" required autofocus placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <span class="icon">🔒</span> Password
                    </label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                
                <button type="submit" class="btn-login">Login to Dashboard</button>
            </form>
            <div style="text-align:center; margin-top:14px;">
                <a href="signup.php" style="color:#764ba2; font-weight:600; text-decoration:none;">Create an account</a>
                 · 
                <a href="forgot_password.php" style="color:#764ba2; font-weight:600; text-decoration:none;">Forgot password?</a>
            </div>
        </div>
        
        <div class="login-footer">
            © 2025 Gold Shop Management System. All rights reserved.
        </div>
    </div>
</body>
</html>