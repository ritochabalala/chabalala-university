<?php
include("includes/config.php");
session_start();

if (isset($_SESSION['email'])) {

} else {
	header('location:index.php');
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>User | Apply Course/Check Status </title>

	<?php include('includes/style.php'); ?>
</head>

<body>
	<!-- Designed and developed by Rito Chabalala -->
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<strong>Welcome: </strong> <?php echo $_SESSION['email'] ?>
				</div>
			</div>
		</div>
	</header>
	<!-- HEADER END-->

	<div class="navbar navbar-inverse set-radius-zero">
		<div class="container">
			<!-- <div class="left-div">
				<i class="fa fa-user login-icon" ></i>
			</div> -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="home.php"><img src="../assets/img/smu_logo.jpg" width="250"
						height="50"></a>
			</div>
		</div>
	</div>

	<!-- Designed and developed by Rito Chabalala -->


	<!-- Add menu links -->
	<?php include('includes/menubar.php'); ?>

	<!--This Is Header-->
	<!-- Designed and developed by Rito Chabalala -->
	<header id="main-header" class="bg-primary py-2 text-white">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1><i class="fa fa-tachometer"></i> Dashboard for a User</h1>
				</div>
			</div>
		</div>
	</header>
	<!--This is section-->
	<br>
	<!-- Designed and developed by Rito Chabalala -->
	<section id="sections" class="py-4 mb-4 bg-faded">
		<div class="container">
			<div class="row">
				<div class="col-md"></div>
				<div class="col-md-3">
					<a href="#" class="btn btn-primary btn-block" style="border-radius:0%;" data-toggle="modal"
						data-target="#addPostModal"><i class="fa fa-plus"></i> Apply a Course</a>
				</div>
				<div class="col-md-3">
					<a href="#" class="btn btn-warning btn-block" style="border-radius:0%;" data-toggle="modal"
						data-target="#addCateModal"><i class="fa fa-spinner"></i> Pendings</a>
				</div>
				<div class="col-md-3">
					<a href="#" class="btn btn-success btn-block" style="border-radius:0%;" data-toggle="modal"
						data-target="#addUsertModal"><i class="fa fa-check"></i> Approved Course</a>
				</div>
				<div class="col-md"></div>
			</div>
		</div>
	</section>
	<!----Section2 for showing Post Model ---->

	<!-- MENU SECTION END-->
	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-head-line">User Panels </h1>
				</div>

				<!----Section2 for showing Post Model ---->
				<!-- Designed and developed by Rito Chabalala -->
				<section id="post">
					<div class="container">
						<div class="row">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<th>#</th>
									<th>Name</th>
									<th>Surname</th>
									<th>Email</th>
									<th>Matric/Previous Result</th>
									<th>CGPA</th>
									<th>Course</th>
									<th>Apply Date</th>
									<th>Status</th>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT * FROM apply WHERE email='" . $_SESSION['email'] . "'";
									$que = mysqli_query($con, $sql);
									$cnt = 1;
									while ($result = mysqli_fetch_assoc($que)) {
										?>
										<tr>
											<td><?php echo $cnt; ?></td>
											<td><?php echo $result['firstname']; ?></td>
											<td><?php echo $result['lastname']; ?></td>
											<td><?php echo $result['email']; ?></td>
											<td><?php echo $result['photo']; ?></td>
											<td><?php echo $result['cgpa']; ?></td>
											<td><?php echo $result['department']; ?></td>
											<td><?php echo $result['applydate']; ?></td>
											<td>
												<?php
												if ($result['status'] == 0) {
													echo "<span class='badge badge-warning'>Pending</span>";
												} else {
													echo "<span class='badge badge-success'>Approved</span>";
												}

												$cnt++;
									}
									?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</section>
				<br>

				<!-- Creating Modal -->
				<!-- Header Post -->
				<div class="modal fade" id="addPostModal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-primary text-white">
								<div class="modal-title">
									<h5>Apply Course</h5>
								</div>
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								<form action="" method="post">
									<div class="form-group">
										<label class="form-control-label">Name</label>
										<input type="text" name="firstname" placeholder="First Name"
											class="form-control" />

										<label class="form-control-label">Surname</label>
										<input type="text" name="lastname" placeholder="Last Name"
											class="form-control" />

										<input type="hidden" name="email" value="<?php echo $_SESSION['email'] ?>">
										<label class="form-control-label">Course</label>
										<select name="department" class="form-control">
											<option value="">Select Course</option>
											<option value="MBChB">Bachelor of Medicine and Bachelor of Surgery (MBChB)
											</option>
											<option value="B Rad">Bachelor of Diagnostic Radiograpy (B Rad)</option>
											<option value="B Cur">Bachelor of Nursing Sciences and Art (B Cur)</option>
											<option value="BDS">Bachelor of Dental Surgery (BDS)</option>
											<option value="BDT">Bachelor of Dental Therapy (BDT)</option>
											<option value="BoH">Bachelor of Oral Hygiene (BoH)</option>
											<option value="B SLP & A">Bachelor of Speech Language, Pathology and
												Audiology (B SLP & A)</option>
											<option value="BSc">Bachelor of Science (BSc)</option>
											<option value="BSc Dietetics">Bachelor of Science in Dietetics (BSc
												Dietetics)</option>
											<option value="BPharm">Bachelor of Pharmacy (BPharm)</option>
											<option value="B Occ Ther">Bachelor of Occupational Therapy (B Occ Ther)
											</option>
											<option value="BSc Physio">Bachelor of Science in Physiotherapy (BSc Physio)
											</option>
											<option value="BSc Hons">Bachelor of Science Honours (BSc Hons)</option>
											<option value="MSc">Masters of Sciences (MSc)</option>
											<option value="PhD">Doctor of Philosophy (PhD)</option>
										</select>
									</div>

									<div class="form-group">
										<label class="form-control-label">Gender</label>
										<select name="gender" class="form-control">
											<option value="">Select Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Other">Other</option>
										</select>
									</div>

									<div class="form-group">
										<label for="address">User Address</label>
										<input name="address" type="text" placeholder="Address" class="form-control"
											required="">
									</div>

									<div class="form-group">
										<label class="form-control-label">Parent/Guardian Name</label>
										<input type="text" name="parentname" placeholder="Parent/Guardian Name"
											class="form-control" required />
									</div>

									<div class="form-group">
										<label class="form-control-label">Parent/Guardian Number</label>
										<input type="text" name="parentnumber" placeholder="Parent/Guardian Number"
											class="form-control" required />
									</div>

									<div class="form-group">
										<label class="form-control-label">School Name</label>
										<input type="text" name="schoolname" placeholder="School Name"
											class="form-control" required />
									</div>

									<div class="form-group">
										<label for="photo">Upload your Matric/Previous Result</label>
										<input name="photo" type="file" class="form-control" id="photo" required />
									</div>

									<div class="form-group">
										<label for="CGPA">Cumulative Grade Point Average (CGPA) </label>
										<input type="text" class="form-control" name="cgpa"
											placeholder="Cumulative Grade Point Average (CGPA). e.g 7.5" required />
									</div>

									<div class="form-group">
										<label class="form-control-label">Apply Date</label>
										<input type="date" name="applydate" class="form-control" />
									</div>

									<div class="modal-footer">
										<button class="btn btn-danger" style="border-radius:0%;"
											data-dismiss="modal">Close</button>
										<input type="hidden" name="status" value="0">
										<input type="submit" class="btn btn-success" style="border-radius:0%;"
											name="apply" value="Apply">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!--Modal Category-->
				<div class="modal fade" id="addCateModal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-warning text-white">
								<div class="modal-title">
									<h5>Pending Applications</h5>
								</div>
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<th>#</th>
										<th>Name</th>
										<th>Surname</th>
										<th>Email</th>
										<th>Matric/Previous Result</th>
										<th>CGPA</th>
										<th>Course</th>
										<th>Apply Date</th>
										<th>Status</th>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * FROM apply WHERE status = 0 && email='" . $_SESSION['email'] . "'";
										$que = mysqli_query($con, $sql);
										$cnt = 1;
										while ($result = mysqli_fetch_assoc($que)) {
											?>

											<tr>
												<td><?php echo $cnt; ?></td>
												<td><?php echo $result['firstname']; ?></td>
												<td><?php echo $result['lastname']; ?></td>
												<td><?php echo $result['email']; ?></td>
												<td><?php echo $result['photo']; ?></td>
												<td><?php echo $result['cgpa']; ?></td>
												<td><?php echo $result['department']; ?></td>
												<td><?php echo $result['applydate']; ?></td>

												<td>
													<?php
													if ($result['status'] == 0) {
														echo "<span class='badge badge-warning'>Pending</span>";
													} else {
														echo "<span class='badge badge-success'>Approved</span>";
													}
													$cnt++;
										}
										?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- User Modal -->
				<div class="modal fade" id="addUsertModal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-success text-white">
								<div class="modal-title">
									<h5>Total Approved Applications</h5>
								</div>
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<th>#</th>
										<th>Name</th>
										<th>Surname</th>
										<th>Email</th>
										<th>Matric/Previous Result</th>
										<th>CGPA</th>
										<th>Course</th>
										<th>Apply Date</th>
										<th>Status</th>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * FROM apply WHERE status = 1 AND email='" . $_SESSION['email'] . "'";
										$que = mysqli_query($con, $sql);
										$cnt = 1;
										while ($result = mysqli_fetch_assoc($que)) {
											?>


											<tr>
												<td><?php echo $cnt; ?></td>
												<td><?php echo $result['firstname']; ?></td>
												<td><?php echo $result['lastname']; ?></td>
												<td><?php echo $result['email']; ?></td>
												<td><?php echo $result['photo']; ?></td>
												<td><?php echo $result['cgpa']; ?></td>
												<td><?php echo $result['department']; ?></td>
												<td><?php echo $result['applydate']; ?></td>
												<td>
													<?php
													if ($result['status'] == 0) {
														echo "<span class='badge badge-warning'>Pending</span>";
													} else {
														echo "<span class='badge badge-success'>Approved</span>";
													}
													$cnt++;
										}
										?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
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
<?php
if (isset($_POST['apply'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$department = $_POST['department'];
	$gender = $_POST['gender'];
	$address = $_POST['address'];
	$parentname = $_POST['parentname'];
	$parentnumber = $_POST['parentnumber'];
	$schoolname = $_POST['schoolname'];
	$photo = $_POST['photo'];
	$cgpa = $_POST['cgpa'];
	$applydate = $_POST['applydate'];
	$status = $_POST['status'];

	$sql = "INSERT INTO apply(firstname,lastname,email,department,gender,address,parentname,parentnumber,schoolname,photo,cgpa,applydate,status)VALUES('$firstname','$lastname','$email','$department','$gender','$address','$parentname','$parentnumber','$schoolname','$photo','$cgpa','$applydate','$status')";

	$run = mysqli_query($con, $sql);

	if ($run == true) {

		echo "<script> 
					alert('Application Submitted, Please wait for approval status');
					window.open('dashboard.php','_self');
				  </script>";
	} else {
		echo "<script> 
			alert('Failed To Apply');
			</script>";
	}
}

?>