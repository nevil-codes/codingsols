<?php
require_once __DIR__ . '/_init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../index.php');
}
csrf_verify();

$email = trim($_POST['loginemail'] ?? '');
$pass = $_POST['loginpass'] ?? '';

$stmt = mysqli_prepare($con, 'SELECT srno, user_email, user_pass FROM users WHERE user_email = ?');
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($row && password_verify($pass, $row['user_pass'])) {
    session_regenerate_id(true);
    $_SESSION['loggedin'] = true;
    $_SESSION['srno'] = (int) $row['srno'];
    $_SESSION['useremail'] = $row['user_email'];
    redirect('../index.php');
}

redirect('../index.php?login=false');
