<?php
/**
 * Security Helper Functions
 * XSS protection, input validation, CSRF tokens
 */

/**
 * Escape output to prevent XSS attacks
 */
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize input
 */
function sanitizeInput($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
        return $data;
    }

    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

/**
 * Validate student registration number
 */
function validateStudentRegno($regno)
{
    return preg_match('/^[0-9]{9}$/', $regno);
}

/**
 * Validate email
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 */
function validatePassword($password)
{
    // At least 8 characters, 1 uppercase, 1 lowercase, 1 number
    return strlen($password) >= 8
        && preg_match('/[A-Z]/', $password)
        && preg_match('/[a-z]/', $password)
        && preg_match('/[0-9]/', $password);
}

/**
 * Generate CSRF token
 */
function generateCSRFToken()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validateCSRFToken($token)
{
    if (!isset($_SESSION['csrf_token']) || !isset($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token input field
 */
function csrfTokenField()
{
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . escape($token) . '">';
}

/**
 * Require CSRF token validation
 */
function requireCSRFToken()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!validateCSRFToken($token)) {
            http_response_code(403);
            die('CSRF token validation failed');
        }
    }
}

/**
 * Validate file upload
 */
function validateFileUpload($file, $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxSize = 5242880)
{
    $errors = [];

    if (!isset($file['error']) || is_array($file['error'])) {
        $errors[] = 'Invalid file upload';
        return $errors;
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $errors[] = 'File exceeds maximum size';
            break;
        default:
            $errors[] = 'Unknown upload error';
            break;
    }

    if ($file['size'] > $maxSize) {
        $errors[] = 'File size exceeds ' . ($maxSize / 1048576) . 'MB';
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowedTypes)) {
        $errors[] = 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes);
    }

    return $errors;
}

/**
 * Generate secure random filename
 */
function generateSecureFilename($extension)
{
    return bin2hex(random_bytes(16)) . '.' . $extension;
}

/**
 * Log security event
 */
function logSecurityEvent($event, $details = '', $severity = 'info')
{
    $logFile = __DIR__ . '/../logs/security.log';
    $logDir = dirname($logFile);

    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user = $_SESSION['login'] ?? 'anonymous';

    $logEntry = sprintf(
        "[%s] [%s] [%s] [%s] %s - %s\n",
        $timestamp,
        $severity,
        $ip,
        $user,
        $event,
        $details
    );

    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Rate limiting
 */
function checkRateLimit($action, $maxAttempts = 5, $timeWindow = 900)
{
    $key = $action . '_' . $_SERVER['REMOTE_ADDR'];

    if (!isset($_SESSION['rate_limit'])) {
        $_SESSION['rate_limit'] = [];
    }

    $now = time();

    if (!isset($_SESSION['rate_limit'][$key])) {
        $_SESSION['rate_limit'][$key] = [
            'attempts' => 1,
            'first_attempt' => $now
        ];
        return true;
    }

    $data = &$_SESSION['rate_limit'][$key];

    // Reset if time window passed
    if ($now - $data['first_attempt'] > $timeWindow) {
        $data = [
            'attempts' => 1,
            'first_attempt' => $now
        ];
        return true;
    }

    $data['attempts']++;

    if ($data['attempts'] > $maxAttempts) {
        logSecurityEvent('rate_limit_exceeded', $action, 'warning');
        return false;
    }

    return true;
}

/**
 * Get error message for rate limit
 */
function getRateLimitMessage($timeWindow = 900)
{
    $minutes = ceil($timeWindow / 60);
    return "Too many attempts. Please try again in $minutes minutes.";
}
