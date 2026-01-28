<?php
/**
 * Database Configuration
 * Uses environment variables for security
 */

// Load environment variables
if (!function_exists('loadEnv')) {
    function loadEnv($filePath)
    {
        if (!file_exists($filePath)) {
            die('Environment file not found');
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_ENV)) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
            }
        }
    }
}

// Load .env file only once
if (!defined('DB_SERVER')) {
    // Detect the correct path to .env file
    $envPath = __DIR__ . '/../.env';

    // If called from a subdirectory (e.g., student/includes), adjust path
    if (!file_exists($envPath)) {
        $envPath = __DIR__ . '/../../.env';
    }

    loadEnv($envPath);

    // Database configuration
    define('DB_SERVER', getenv('DB_SERVER'));
    define('DB_USER', getenv('DB_USER'));
    define('DB_PASS', getenv('DB_PASS'));
    define('DB_NAME', getenv('DB_NAME'));
}

// Create PDO connection for prepared statements (only once)
if (!isset($GLOBALS['dbh'])) {
    try {
        $GLOBALS['dbh'] = new PDO(
            "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        $dbh = $GLOBALS['dbh']; // Make available in local scope
        $pdo = $dbh; // Alias for backward compatibility
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed. Please contact administrator.");
    }
} else {
    $dbh = $GLOBALS['dbh'];
    $pdo = $dbh; // Alias for backward compatibility
}

// Legacy mysqli connection for backward compatibility (will be phased out)
if (!isset($GLOBALS['con'])) {
    $GLOBALS['con'] = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_errno()) {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        die("Failed to connect to MySQL. Please contact administrator.");
    }

    // Set charset for mysqli
    mysqli_set_charset($GLOBALS['con'], "utf8mb4");
    $con = $GLOBALS['con']; // Make available in local scope
} else {
    $con = $GLOBALS['con'];
}
?>