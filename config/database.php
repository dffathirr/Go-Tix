<?php

// Function to parse the .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        // handle empty values
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

// Get the root directory path relative to this file
$rootPath = dirname(__DIR__);

// Load the .env variables
loadEnv($rootPath . '/.env');

$host = $_ENV['HOSTNAME'] ?? 'localhost';
$port = $_ENV['PORT'] ?? '3306';
$dbname = $_ENV['DATABASE'] ?? 'db_gotix';
$username = $_ENV['USERNAME'] ?? 'root';
$password = $_ENV['PASSWORD'] ?? '';

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Return a simple error message to the browser if connection fails
    die("Database Connection Failed: " . $e->getMessage() . "<br>Please check your .env configuration.");
}
