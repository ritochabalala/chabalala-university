<?php
// Initialize secure session
require_once("includes/session_security.php");
require_once("includes/config.php");
require_once("includes/security.php");

error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide errors in production
ini_set('log_errors', 1);

if (isset($_POST['submit'])) {
	// Check rate limit
	if (!checkRateLimit('student_login', 5, 900)) {
		echo "<script>
			alert('" . getRateLimitMessage(900) . "');
			window.location.href='index.php';
		</script>";
		exit();
	}

	// Sanitize inputs
	$studentregno = sanitizeInput($_POST['studentregno']);
	$password = $_POST['password'];

	// Validate input
	if (empty($studentregno) || empty($password)) {
		echo "<script>
			alert('Please enter both Student Number and Password');
			window.location.href='index.php';
		</script>";
		exit();
	}

	try {
		// Use prepared statement to prevent SQL injection
		$stmt = $pdo->prepare("SELECT * FROM students WHERE studentregno = :studentregno LIMIT 1");
		$stmt->execute(['studentregno' => $studentregno]);
		$student = $stmt->fetch();

		// Verify password using password_verify (supports both bcrypt and MD5 temporarily)
		if ($student) {
			$passwordMatch = false;

			// Check if it's a bcrypt hash (bcrypt hashes start with $2y$, $2a$, $2b$)
			if (preg_match('/^\$2[ayb]\$.{56}$/', $student['password'])) {
				$passwordMatch = password_verify($password, $student['password']);
			} else {
				// Fallback to MD5 for existing users (temporary)
				$passwordMatch = ($student['password'] === md5($password));

				// If MD5 matched, upgrade to bcrypt
				if ($passwordMatch) {
					$newHash = password_hash($password, PASSWORD_BCRYPT);
					$updateStmt = $pdo->prepare("UPDATE students SET password = :password WHERE studentregno = :studentregno");
					$updateStmt->execute([
						'password' => $newHash,
						'studentregno' => $studentregno
					]);
				}
			}

			if ($passwordMatch) {
				// Regenerate session ID for security
				regenerateSession();

				$_SESSION['login'] = $student['studentregno'];
				$_SESSION['studentregno'] = $student['studentregno'];

				// Log successful login
				$uip = $_SERVER['REMOTE_ADDR'];
				$status = 1;
				$logStmt = $pdo->prepare("INSERT INTO userlog (studentregno, userip, status, logintime) VALUES (:studentregno, :userip, :status, NOW())");
				$logStmt->execute([
					'studentregno' => $_SESSION['login'],
					'userip' => $uip,
					'status' => $status
				]);

				logSecurityEvent('student_login_success', "Student: $studentregno", 'info');

				echo "<script>
					window.location.href='my-profile.php';
				</script>";
				exit();
			}
		}

		// Login failed
		logSecurityEvent('student_login_failed', "Student: $studentregno", 'warning');

		echo "<script>
			alert('The Student Number/Password is incorrect. Please try again');
			window.location.href='index.php';
		</script>";
		exit();

	} catch (PDOException $e) {
		error_log("Login error: " . $e->getMessage());
		logSecurityEvent('student_login_error', $e->getMessage(), 'error');

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
	<title>Student Login</title>

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

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="page-head-line">Please enter your details to login in your student portal</h4>
				</div>
			</div>
			<span
				style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg'] = ""); ?></span>

			<div class="row">
				<form name="admin" method="post">
					<div class="col-md-6">
						<label>Enter Student Number : </label>
						<input type="text" name="studentregno" placeholder="Student Number" class="form-control" />
						<label>Enter Password : </label>
						<input type="password" name="password" placeholder="Password" class="form-control" />
						<hr />
						<button type="submit" name="submit" class="btn btn-info"><span
								class="glyphicon glyphicon-user"></span> &nbsp; Student Login </button>&nbsp;
					</div>
				</form>
				<div class="col-md-6">
					<div class="alert alert-info">
						<strong> Latest News / Updates</strong>
						<marquee direction='up' scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();">
							<ul>
								<?php
								$sql = mysqli_query($con, "select * from news");
								$cnt = 1;
								while ($row = mysqli_fetch_array($sql)) {
									?>
									<li>
										<a
											href="news-details.php?nid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['newstitle']); ?>-<?php echo htmlentities($row['postingDate']); ?></a>
									</li>
								<?php } ?>
							</ul>
						</marquee>
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
	<script src="assets/js/jquery-1.11.1.js"></script>
	<!-- BOOTSTRAP SCRIPTS  -->
	<script src="assets/js/bootstrap.js"></script>
</body>

</html>
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
					        window.open('apply/','_self');
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