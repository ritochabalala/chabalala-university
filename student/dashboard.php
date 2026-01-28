<?php
require_once('includes/session_security.php');
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Africa/Johannesburg');// change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Student | Student Portal</title>

        <!-- Custom CSS -->
        <?php include('includes/style.php'); ?>
    </head>
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.cpass.value == "") {
                alert("Current Password Filed is Empty !!");
                document.chngpwd.cpass.focus();
                return false;
            }
            else if (document.chngpwd.newpass.value == "") {
                alert("New Password Filed is Empty !!");
                document.chngpwd.newpass.focus();
                return false;
            }
            else if (document.chngpwd.cnfpass.value == "") {
                alert("Confirm Password Filed is Empty !!");
                document.chngpwd.cnfpass.focus();
                return false;
            }
            else if (document.chngpwd.newpass.value != document.chngpwd.cnfpass.value) {
                alert("Password and Confirm Password Field do not match  !!");
                document.chngpwd.cnfpass.focus();
                return false;
            }
            return true;
        }
    </script>

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
                        <h1 class="page-head-line">Student Portal</h1>
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