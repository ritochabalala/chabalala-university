<?php
require_once('includes/session_security.php');
error_reporting(0);
include("includes/config.php");
if (isset($_POST['submit'])) {
    $regno = $_POST['regno'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "SELECT * FROM students WHERE StudentRegno='$regno' and password='$password'");
    $num = mysqli_fetch_array($query);
    if ($num > 0) {
        $extra = "change-password.php"; //change-password
        $_SESSION['login'] = $_POST['regno'];
        $_SESSION['id'] = $num['studentRegno'];
        $_SESSION['sname'] = $num['studentName'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        $log = mysqli_query($con, "insert into userlog(studentRegno,userip,status) values('" . $_SESSION['login'] . "','$uip','$status')");
    } else {
        $_SESSION['errmsg'] = "Invalid Student Number or Password";
        $extra = "index.php";
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http:index.php");
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Student | Student Login</title>

    <!-- Custom CSS -->
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
                            <li><a href="index.php">Home </a></li>
                            <li><a href="apply/">User Login</a></li>
                            <li><a href="admin/">Admin Login </a></li>
                            <li><a href="index.php">Student Portal</a></li>
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
                    <h4 class="page-head-line">News Details </h4>
                </div>
            </div>

            <div class="col-md-12">
                <div class="alert alert-info">
                    <ul>
                        <?php $nid = $_GET['nid'];
                        $sql = mysqli_query($con, "select * from news where id='$nid'");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($sql)) {
                            ?>
                            <h3><?php echo htmlentities($row['newstitle']); ?></h3>
                            <small><?php echo htmlentities($row['postingDate']); ?></small>
                            <hr />
                            <p><?php echo htmlentities($row['newsDescription']); ?></p>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>

</html>