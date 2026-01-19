<?php
session_start();
error_reporting(0);
include("includes/config.php");
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' and password='$password'");
    $num = mysqli_fetch_array($query);
    if ($num > 0) {
        $_SESSION['alogin'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        header("location:dashboard.php");
        exit();
    } else {
        $_SESSION['errmsg'] = "The Username/Password is Incorrect. Please try again";
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