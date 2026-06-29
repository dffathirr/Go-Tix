<?php
// Load environment variables if not loaded
$envFile = __DIR__ . '/../.env';
$envVars = [];
if (file_exists($envFile)) {
    $envVars = parse_ini_file($envFile);
}

// Set base URL from env, default to root if not found
$baseUrl = $envVars['BASE_URL'] ?? 'http://localhost/';
if (!defined('BASE_URL')) {
    define('BASE_URL', $baseUrl);
}
?>