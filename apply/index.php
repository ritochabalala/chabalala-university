<?php
session_start();
error_reporting(0);
include("includes/config.php");

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$password = md5($_POST['password']);

	$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

	$run = mysqli_query($con, $sql);
	$check = mysqli_num_rows($run);

	if ($check == 1) {
		session_start();
		$_SESSION['email'] = $email;

		echo "<script> 
					window.open('dashboard.php','_self');
				  </script>";
	} else {
		echo "<script> 
			alert('The login details are incorrect.  Please try again!');
			window.open('index.php','_self');
			</script>";
	}
}

//$_SESSION['errmsg']="";

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>User Login</title>

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
							<li><a href="../">Student Login </a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!--This Is Header-->
	<header id="main-header" class="bg-primary py-2 text-white">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1><i class="fa fa-user"></i> User Login</h1>
				</div>
			</div>
		</div>
	</header>
	<!--This is section-->
	<!-- Designed and developed by Rito Chabalala -->

	<br>
	<!--This is section-->
	<section id="sections" class="py-4 mb-4 bg-faded">
		<div class="container">
			<div class="row">
				<div class="col-md"></div>
				<div class="col-md-2">
					<a href="#" class="btn btn-danger btn-block" style="border-radius:0%;" data-toggle="modal"
						data-target="#addEmpModal"><i class="fa fa-users"></i> Apply @ SMU</a>
				</div>
				<div class="col-md"></div>
			</div>
		</div>
	</section>
	<!-- Designed and developed by Rito Chabalala -->

	<!-- Add Users Modal -->
	<div class="modal fade" id="addEmpModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<div class="modal-title">
						<h5>Created an account</h5>
					</div>
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<div class="form-group">
							<label class="form-control-label">Name</label>
							<input type="text" name="name" placeholder="Name" class="form-control" required />
						</div>

						<div class="form-group">
							<label class="form-control-label">Email</label>
							<input type="email" name="email" placeholder="Email" class="form-control" required />
						</div>

						<div class="form-group">
							<label class="form-control-label">Password</label>
							<input type="password" name="password" placeholder="Password" class="form-control"
								required />
						</div>

						<div class="form-group">
							<label class="form-control-label">Confirm Password</label>
							<input type="password" name="cpassword" placeholder="Confirm Password" class="form-control"
								required />
						</div>

						<div class="modal-footer">
							<button class="btn btn-danger" style="border-radius:0%;" data-dismiss="modal">Close</button>
							<input type="hidden" name="status" value="0">
							<input type="submit" class="btn btn-success" style="border-radius:0%;" name="adduser"
								value="Create">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php

	if (isset($_POST['adduser'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$password = md5($_POST['password']);
		$cpassword = md5($_POST['cpassword']);

		if ($password == $cpassword) {
			$sql = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($con, $sql);
			if (!$result->num_rows > 0) {
				$sql = "INSERT INTO users(name,email,password)VALUES('$name','$email','$password')";
				$result = mysqli_query($con, $sql);
				if ($result == true) {

					echo "<script> 
					        alert('Congratulation! Account Created');
					        window.open('index.php','_self');
				        </script>";

					$name = "";
					$email = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";

				} else {
					echo "<script>alert('Woops! Something Went Wrong.')</script>";
				}
			} else {
				echo "<script>alert('Woops! Email Already Exists.')</script>";
			}

		} else {
			echo "<script>alert('Passwords Not Matched.')</script>";
		}
	}
	?>

	<!---- Section2 for showing Post Model ---->
	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="page-head-line">Please enter your details to check your status/apply </h4>
				</div>
			</div>
			<span
				style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg'] = ""); ?></span>
			<div class="row">
				<form name="admin" method="post">
					<div class="col-md-6">
						<label>Enter Email: </label>
						<input type="email" name="email" placeholder="Email" class="form-control" required />
						<label>Enter Password: </label>
						<input type="password" name="password" placeholder="Password" class="form-control" required />
						<hr />
						<button type="submit" name="submit" class="btn btn-primary"><span
								class="glyphicon glyphicon-user"></span> &nbsp;User Login </button>&nbsp;
					</div>
				</form>
				<div class="col-md-6">
					<img src="../assets/img/user.png" class="img-responsive">
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
<!-- Designed and developed by Rito Chabalala -->