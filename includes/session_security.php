<?php
/**
 * Secure Session Management
 * Handles session initialization, security, and timeout
 */

// Prevent multiple session starts
if (session_status() === PHP_SESSION_NONE) {
    // Secure session configuration
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');

    // Enable secure flag if HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }

    // Set custom session name
    $sessionName = getenv('SESSION_NAME') ?: 'chabalala_session';
    session_name($sessionName);

    session_start();
}

/**
 * Check and handle session timeout
 */
function checkSessionTimeout()
{
    $timeout = getenv('SESSION_LIFETIME') ?: 1800; // 30 minutes default

    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $elapsed = time() - $_SESSION['LAST_ACTIVITY'];

        if ($elapsed > $timeout) {
            session_unset();
            session_destroy();
            return false;
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();
    return true;
}

/**
 * Regenerate session ID after successful login
 * Prevents session fixation attacks
 */
function regenerateSession()
{
    session_regenerate_id(true);
    $_SESSION['LAST_ACTIVITY'] = time();
}

/**
 * Check if user is authenticated
 */
function isAuthenticated($sessionKey = 'login')
{
    if (!checkSessionTimeout()) {
        return false;
    }

    return isset($_SESSION[$sessionKey]);
}

/**
 * Require authentication or redirect
 */
function requireAuth($sessionKey = 'login', $redirectUrl = 'index.php')
{
    if (!isAuthenticated($sessionKey)) {
        header("Location: " . $redirectUrl);
        exit();
    }
}

/**
 * Destroy session completely
 */
function destroySession()
{
    $_SESSION = array();

    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}
