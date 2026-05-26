<?php
session_start();
require_once 'config.php';

$conn = getDBConnection();
$error = '';
$success = '';
$step = 'email';
$email = '';
$questionText = '';
$questionId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? 'email';
    if ($mode === 'email') {
        $email = sanitizeInput($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $stmt = $conn->prepare('SELECT u.id, u.security_question_id, q.question FROM users u LEFT JOIN security_questions q ON u.security_question_id = q.id WHERE u.email = ? AND u.status = "active"');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                if (!empty($row['security_question_id']) && !empty($row['question'])) {
                    $step = 'verify';
                    $questionText = $row['question'];
                    $questionId = (int)$row['security_question_id'];
                } else {
                    $error = 'Security question not set for this account.';
                }
            } else {
                $error = 'No active account found with this email.';
            }
            $stmt->close();
        }
    } elseif ($mode === 'verify') {
        $email = sanitizeInput($_POST['email'] ?? '');
        $answer = trim($_POST['security_answer'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email.';
            $step = 'email';
        } elseif ($answer === '' || $newPassword === '' || $confirmPassword === '') {
            $error = 'All fields are required.';
            $step = 'email';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'Passwords do not match.';
            $step = 'email';
        } else {
            $stmt = $conn->prepare('SELECT security_answer_hash, security_question_id FROM users WHERE email = ? AND status = "active"');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                $answerHash = $row['security_answer_hash'] ?? '';
                if ($answerHash && password_verify($answer, $answerHash)) {
                    $hash = password_hash($newPassword, PASSWORD_BCRYPT);
                    $up = $conn->prepare('UPDATE users SET password = ?, last_login = NULL WHERE email = ?');
                    $up->bind_param('ss', $hash, $email);
                    if ($up->execute()) {
                        $success = 'Password reset successful. You can now login.';
                        $step = 'done';
                    } else {
                        $error = 'Failed to update password. Please try again.';
                        $step = 'email';
                    }
                    $up->close();
                } else {
                    $error = 'Incorrect security answer.';
                    $step = 'email';
                }
            } else {
                $error = 'Account not found.';
                $step = 'email';
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Gold Shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #F7971E 0%, #FFD200 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { background: #fff; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.3); overflow: hidden; max-width: 520px; width: 100%; }
        .header { background: linear-gradient(135deg, #F7971E 0%, #FFD200 100%); padding: 28px; color: #fff; text-align: center; }
        .body { padding: 26px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 8px; color: #4a5568; font-weight: 600; font-size: 14px; }
        input { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: all .2s; }
        input:focus { outline: none; border-color: #F7971E; box-shadow: 0 0 0 3px rgba(247, 151, 30, .15); }
        .btn { width: 100%; padding: 14px; background: #F7971E; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; }
        .btn:hover { opacity: .95; }
        .error { background: #fed7d7; color: #742a2a; padding: 12px 15px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #e53e3e; font-size: 14px; }
        .success { background: #c6f6d5; color: #22543d; padding: 12px 15px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #38a169; font-size: 14px; }
        .links { text-align: center; margin-top: 12px; }
        .links a { color: #F7971E; font-weight: 600; text-decoration: none; }
        .question { background: #f7fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px; margin-bottom: 10px; color: #2d3748; }
    </style>
    <script>
        function keepEmail(val){
            var els = document.querySelectorAll('.carry-email');
            els.forEach(function(e){ e.value = val; });
        }
    </script>
    </head>
<body>
    <div class="container">
        <div class="header"><h2>Reset your password</h2></div>
        <div class="body">
            <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            <?php if ($success): ?><div class="success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

            <?php if ($step === 'email'): ?>
                <form method="POST" action="" oninput="keepEmail(this.email.value)">
                    <input type="hidden" name="mode" value="email">
                    <div class="form-group">
                        <label for="email">Registered Email</label>
                        <input type="email" id="email" name="email" required placeholder="Enter your registered email">
                    </div>
                    <button type="submit" class="btn">Continue</button>
                </form>
                <div class="links"><a href="login.php">Back to Login</a></div>
            <?php elseif ($step === 'verify'): ?>
                <form method="POST" action="">
                    <input type="hidden" name="mode" value="verify">
                    <input type="hidden" name="email" class="carry-email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="form-group">
                        <div class="question">Security Question: <strong><?php echo htmlspecialchars($questionText); ?></strong></div>
                    </div>
                    <div class="form-group">
                        <label for="security_answer">Your Answer</label>
                        <input type="text" id="security_answer" name="security_answer" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn">Reset Password</button>
                </form>
                <div class="links"><a href="login.php">Back to Login</a></div>
            <?php elseif ($step === 'done'): ?>
                <div class="links"><a href="login.php">Back to Login</a></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


