<?php
require_once __DIR__ . '/_init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../index.php');
}
csrf_verify();

$user_email = trim($_POST['signupEmail1'] ?? '');
$password = $_POST['signuppassword'] ?? '';
$cpassword = $_POST['signupcpassword'] ?? '';

$error = null;
if (!filter_var($user_email, FILTER_VALIDATE_EMAIL) || strlen($user_email) > 30) {
    $error = 'Enter a valid email address';
} elseif (strlen($password) < 8) {
    $error = 'Password must be at least 8 characters';
} elseif ($password !== $cpassword) {
    $error = 'Passwords do not match';
} else {
    $stmt = mysqli_prepare($con, 'SELECT 1 FROM users WHERE user_email = ?');
    mysqli_stmt_bind_param($stmt, 's', $user_email);
    mysqli_stmt_execute($stmt);
    if (mysqli_fetch_row(mysqli_stmt_get_result($stmt))) {
        $error = 'Email already in use';
    }
}

if ($error !== null) {
    redirect('../index.php?signupsuccess=false&error=' . urlencode($error));
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($con, 'INSERT INTO users (user_email, user_pass, timestamp) VALUES (?, ?, current_timestamp())');
mysqli_stmt_bind_param($stmt, 'ss', $user_email, $hash);
mysqli_stmt_execute($stmt);

redirect('../index.php?signupsuccess=true');
