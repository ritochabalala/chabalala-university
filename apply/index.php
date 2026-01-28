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
	if (!checkRateLimit('user_login', 5, 900)) {
		echo "<script>
			alert('" . getRateLimitMessage(900) . "');
			window.location.href='index.php';
		</script>";
		exit();
	}

	// Sanitize inputs
	$email = sanitizeInput($_POST['email']);
	$password = $_POST['password'];

	// Validate input
	if (empty($email) || empty($password)) {
		echo "<script>
			alert('Please enter both Email and Password');
			window.location.href='index.php';
		</script>";
		exit();
	}

	// Validate email format
	if (!validateEmail($email)) {
		echo "<script>
			alert('Please enter a valid email address');
			window.location.href='index.php';
		</script>";
		exit();
	}

	try {
		// Use prepared statement to prevent SQL injection
		$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
		$stmt->execute(['email' => $email]);
		$user = $stmt->fetch();

		// Verify password using password_verify (supports both bcrypt and MD5 temporarily)
		if ($user) {
			$passwordMatch = false;

			// Check if it's a bcrypt hash (bcrypt hashes start with $2y$, $2a$, $2b$)
			if (preg_match('/^\$2[ayb]\$.{56}$/', $user['password'])) {
				$passwordMatch = password_verify($password, $user['password']);
			} else {
				// Fallback to MD5 for existing users (temporary)
				$passwordMatch = ($user['password'] === md5($password));

				// If MD5 matched, upgrade to bcrypt
				if ($passwordMatch) {
					$newHash = password_hash($password, PASSWORD_BCRYPT);
					$updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
					$updateStmt->execute([
						'password' => $newHash,
						'email' => $email
					]);
				}
			}

			if ($passwordMatch) {
				// Regenerate session ID for security
				regenerateSession();

				$_SESSION['email'] = $user['email'];
				$_SESSION['user_id'] = $user['id'];

				logSecurityEvent('user_login_success', "User: $email", 'info');

				echo "<script>
					window.location.href='dashboard.php';
				</script>";
				exit();
			}
		}

		// Login failed
		logSecurityEvent('user_login_failed', "User: $email", 'warning');

		echo "<script>
			alert('The login details are incorrect. Please try again!');
			window.location.href='index.php';
		</script>";
		exit();
		logSecurityEvent('user_login_failed', "User: $email", 'warning');

		echo "<script>
			alert('The login details are incorrect. Please try again!');
			window.location.href='index.php';
		</script>";
		exit();

	} catch (PDOException $e) {
		error_log("User login error: " . $e->getMessage());
		logSecurityEvent('user_login_error', $e->getMessage(), 'error');

		echo "<script>
			alert('An error occurred. Please try again later.');
			window.location.href='index.php';
		</script>";
		exit();
	}
}
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