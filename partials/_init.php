<?php
// Shared bootstrap: include at the very top of every page, before any output.

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

require_once __DIR__ . '/_dbconnect.php';

// Escape a value for HTML output.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function is_logged_in()
{
    return !empty($_SESSION['loggedin']) && !empty($_SESSION['srno']);
}

function current_user_id()
{
    return is_logged_in() ? (int) $_SESSION['srno'] : null;
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

// Stop the request if the POSTed CSRF token is missing or wrong.
function csrf_verify()
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(419);
        exit('Invalid or expired form. Go back, refresh the page and try again.');
    }
}

function redirect($path)
{
    header('Location: ' . $path);
    exit();
}
