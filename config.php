<?php
// config.php - Database and Security Configuration

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'zerfaucet');
define('DB_USER', 'root');
define('DB_PASS', '');

// Security configuration
define('ALLOWED_ORIGINS', ['localhost', '127.0.0.1', 'yourdomain.com']);
define('MAX_CLAIMS_PER_IP', 1);
define('ENCRYPTION_KEY', 'zerfaucet-encryption-key-2024-secure');

// API Configuration
define('ZER_API_URL', 'https://zerochain.info/api/rawtxbuild');
define('API_TIMEOUT', 30);

// Faucet Settings
define('FAUCET_REWARD', 0.00001);
define('CLAIM_COOLDOWN', 86400);
define('TRANSACTION_FEES', 0.00000001);

// Connect to Database
function getDB() {
    static $db = null;
    if ($db === null) {
        try {
            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", 
                         DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch(PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection error. Please check your database configuration.");
        }
    }
    return $db;
}

// Security Functions
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validateWalletAddress($address) {
    return preg_match('/^t1[a-zA-Z0-9]{33}$/', $address);
}

function getClientIP() {
    $ip_keys = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR', 
        'HTTP_X_REAL_IP', 
        'HTTP_CLIENT_IP',
        'REMOTE_ADDR'
    ];
    
    foreach ($ip_keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ips = explode(',', $_SERVER[$key]);
            $ip = trim($ips[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// Set security headers
function setSecurityHeaders() {
    header("X-Frame-Options: DENY");
    header("X-Content-Type-Options: nosniff");
    header("X-XSS-Protection: 1; mode=block");
    header("Referrer-Policy: strict-origin-when-cross-origin");
}

setSecurityHeaders();
?>
