<?php
require_once('includes/session_security.php');
require_once('includes/error_handler.php');
include('includes/config.php');
include('includes/security.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {
    date_default_timezone_set('Africa/Johannesburg');// change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    if (isset($_POST['submit'])) {
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
            logMessage("CSRF token validation failed in pincode verification", 'WARNING');
            echo '<script>alert("Invalid form submission. Please try again.")</script>';
            exit();
        }

        // Validate and sanitize pincode
        $pincode = sanitizeInput(trim($_POST['pincode']));

        if (empty($pincode)) {
            echo '<script>alert("Pincode is required!")</script>';
        } else {
            try {
                // Use prepared statement
                $stmt = $dbh->prepare("SELECT * FROM students WHERE pincode = ? AND StudentRegno = ?");
                $stmt->execute([$pincode, $_SESSION['login']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $_SESSION['pcode'] = $pincode;
                    header("location:enroll.php");
                    exit();
                } else {
                    echo '<script>alert("Error: Wrong Pincode. Please Enter a Valid Pincode!")</script>';
                    echo '<script>window.location.href="pincode-verification.php"</script>';
                }
            } catch (PDOException $e) {
                logMessage("Database error in pincode verification: " . $e->getMessage(), 'ERROR');
                echo '<script>alert("An error occurred. Please try again.")</script>';
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Student | Pincode Verification</title>

        <!-- Custom CSS -->
        <?php include('includes/style.php'); ?>
    </head>

    <body>
        <?php include('includes/header.php'); ?>
        <!-- LOGO HEADER END-->
        <?php if ($_SESSION['login'] != "") {
            include('includes/menubar.php');
        }
        ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Student Pincode Verification</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Pincode Verification
                            </div>
                            <font color="red" align="center">
                                <?php echo htmlentities($_SESSION['msg']); ?>
                                <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                            </font>

                            <div class="panel-body">
                                <form name="pincodeverify" method="post">
                                    <?php echo csrfTokenField(); ?>
                                    <div class="form-group">
                                        <label for="pincode">Enter Pincode</label>
                                        <input type="password" class="form-control" id="pincode" name="pincode"
                                            placeholder="Pincode" required />
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-default">Verify</button>
                                    <hr />
                                </form>
                            </div>
                        </div>
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
<?php } ?>