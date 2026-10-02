<?php
// Database credentials come from environment variables, or from a local
// config file that is not committed (copy config.example.php to config.local.php).
$config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',
    'name' => getenv('DB_NAME') ?: 'codingsols',
];

$localConfig = __DIR__ . '/../config.local.php';
if (is_file($localConfig)) {
    $config = array_merge($config, require $localConfig);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['name']);
mysqli_set_charset($con, 'utf8mb4');
