<?php
// Initialize secure session
require_once("../includes/session_security.php");
require_once("includes/config.php");
require_once("../includes/security.php");

error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide errors in production
ini_set('log_errors', 1);

if (isset($_POST['submit'])) {
    // Check rate limit
    if (!checkRateLimit('admin_login', 5, 900)) {
        $_SESSION['errmsg'] = getRateLimitMessage(900);
        header("location:index.php");
        exit();
    }

    // Sanitize inputs
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION['errmsg'] = "Please enter both Username and Password";
        header("location:index.php");
        exit();
    }

    try {
        // Use prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        // Verify password using password_verify (supports both bcrypt and MD5 temporarily)
        if ($admin) {
            $passwordMatch = false;

            // Check if it's a bcrypt hash (bcrypt hashes start with $2y$, $2a$, $2b$)
            if (preg_match('/^\$2[ayb]\$.{56}$/', $admin['password'])) {
                $passwordMatch = password_verify($password, $admin['password']);
            } else {
                // Fallback to MD5 for existing users (temporary)
                $passwordMatch = ($admin['password'] === md5($password));

                // If MD5 matched, upgrade to bcrypt
                if ($passwordMatch) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $updateStmt = $pdo->prepare("UPDATE admin SET password = :password WHERE username = :username");
                    $updateStmt->execute([
                        'password' => $newHash,
                        'username' => $username
                    ]);
                }
            }

            if ($passwordMatch) {
                // Regenerate session ID for security
                regenerateSession();

                $_SESSION['alogin'] = $admin['username'];
                $_SESSION['id'] = $admin['id'];

                logSecurityEvent('admin_login_success', "Admin: $username", 'info');

                header("location:dashboard.php");
                exit();
            }
        }

        // Login failed
        logSecurityEvent('admin_login_failed', "Admin: $username", 'warning');
        $_SESSION['errmsg'] = "The Username/Password is Incorrect. Please try again";
        header("location:index.php");
        exit();

    } catch (PDOException $e) {
        error_log("Admin login error: " . $e->getMessage());
        logSecurityEvent('admin_login_error', $e->getMessage(), 'error');

        $_SESSION['errmsg'] = "An error occurred. Please try again later.";
        header("location:index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Admin Login</title>

    <?php include('includes/style.php'); ?>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="../">Home </a></li>
                            <li><a href="../apply/">User Login</a></li>
                            <li><a href="../admin">Admin Login </a></li>
                            <li><a href="../">Student Portal </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Please enter your details to login in Admin Panel </h4>
                </div>
            </div>
            <span
                style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg'] = ""); ?></span>
            <div class="row">
                <form name="admin" method="post">
                    <div class="col-md-6">
                        <label>Enter Username : </label>
                        <input type="text" name="username" placeholder="Username" class="form-control" required />
                        <label>Enter Password : </label>
                        <input type="password" name="password" placeholder="Password" class="form-control" required />
                        <hr />
                        <button type="submit" name="submit" class="btn btn-info"><span
                                class="glyphicon glyphicon-user"></span> &nbsp;Login </button>&nbsp;
                    </div>
                </form>
                <div class="col-md-6">
                    <img src="../assets/img/admin.png" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>
</body>

</html>