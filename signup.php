<?php
session_start();
require_once 'config.php';

$conn = getDBConnection();
$error = '';
$success = '';

// Load security questions
$questions = [];
$qres = $conn->query("SELECT id, question FROM security_questions ORDER BY id ASC");
if ($qres) {
    while ($row = $qres->fetch_assoc()) {
        $questions[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitizeInput($_POST['full_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $questionId = intval($_POST['security_question_id'] ?? 0);
    $answer = trim($_POST['security_answer'] ?? '');

    if ($fullName === '' || $email === '' || $password === '' || $confirmPassword === '' || $questionId <= 0 || $answer === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // Check email uniqueness
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'An account with this email already exists.';
        }
        $stmt->close();

        if ($error === '') {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $answerHash = password_hash($answer, PASSWORD_BCRYPT);
            // Use email as username to stay compatible with existing code expecting username
            $username = $email;
            $role = 'user';

            $insert = $conn->prepare('INSERT INTO users (username, password, email, full_name, security_question_id, security_answer_hash, role) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $insert->bind_param('ssssiss', $username, $passwordHash, $email, $fullName, $questionId, $answerHash, $role);
            if ($insert->execute()) {
                $success = 'Account created successfully. You can now log in.';
            } else {
                $error = 'Failed to create account. Please try again.';
            }
            $insert->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Gold Shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { background: #fff; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; max-width: 520px; width: 100%; }
        .header { background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%); padding: 32px 28px; color: #fff; text-align: center; }
        .header h1 { font-size: 1.6em; }
        .body { padding: 28px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; color: #4a5568; font-weight: 600; font-size: 14px; }
        input, select { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: all .2s; }
        input:focus, select:focus { outline: none; border-color: #43cea2; box-shadow: 0 0 0 3px rgba(67, 206, 162, .15); }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn { width: 100%; padding: 14px; background: #185a9d; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; }
        .btn:hover { opacity: .95; }
        .note { text-align: center; margin-top: 10px; font-size: 13px; color: #4a5568; }
        .error { background: #fed7d7; color: #742a2a; padding: 12px 15px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #e53e3e; font-size: 14px; }
        .success { background: #c6f6d5; color: #22543d; padding: 12px 15px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #38a169; font-size: 14px; }
        .links { text-align: center; margin-top: 16px; }
        .links a { color: #185a9d; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Create your account</h1>
        </div>
        <div class="body">
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="security_question_id">Security Question</label>
                    <select id="security_question_id" name="security_question_id" required>
                        <option value="">Select a question</option>
                        <?php foreach ($questions as $q): ?>
                            <option value="<?php echo (int)$q['id']; ?>"><?php echo htmlspecialchars($q['question']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="security_answer">Your Answer</label>
                    <input type="text" id="security_answer" name="security_answer" required>
                </div>
                <button type="submit" class="btn">Create account</button>
            </form>
            <div class="links">
                <p class="note">Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>


