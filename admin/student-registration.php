<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $studentname = $_POST['studentname'];
        $cgpa = $_POST['cgpa'];
        $session = $_POST['session'];
        $department = $_POST['department'];
        $semester = $_POST['semester'];
        $studentregno = $_POST['studentregno'];
        $password = md5($_POST['password']);
        $pincode = rand(100000, 999999);

        $sql = "INSERT INTO students(studentname,cgpa,session,department,semester,studentregno,password,pincode)VALUES('$studentname','$cgpa','$session','$department','$semester','$studentregno','$password','$pincode')";
        $result = mysqli_query($con, $sql);
        if ($result == true) {
            echo '<script>alert("Student Registered Successfully. Pincode is "+"' . $pincode . '")</script>';
            echo "<script> 
					    window.open('manage-students.php','_self');
				    </script>";
        } else {
            echo "<script> 
					    alert('Something Went Wrong. Please try again!');
					    window.open('student-registration.php','_self');
				    </script>";
        }
    }
    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Admin | Students Registration</title>

        <?php include('includes/style.php'); ?>
    </head>

    <body>
        <?php include('includes/header.php'); ?>
        <!-- LOGO HEADER END-->
        <?php if ($_SESSION['alogin'] != "") {
            include('includes/menubar.php');
        }
        ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Students Registration </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Student Registration Form
                            </div>
                            <font color="green" align="center">
                                <?php echo htmlentities($_SESSION['msg']); ?>    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                            </font>


                            <div class="panel-body">
                                <form name="dept" method="post">
                                    <div class="form-group">
                                        <label for="studentname">Student Name </label>
                                        <input type="text" class="form-control" id="studentname" name="studentname"
                                            placeholder="Student Name" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="cgpa">Cumulative Grade Point Average (CGPA) </label>
                                        <input type="text" class="form-control" id="cgpa" name="cgpa"
                                            placeholder="Cumulative Grade Point Average (CGPA). e.g 7.5" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="session">School </label>
                                        <select name="session" class="form-control">
                                            <option value="">Select School</option>
                                            <option value="School of Medicine">School of Medicine</option>
                                            <option value="School of Pharmacy">School of Pharmacy</option>
                                            <option value="School of Health Care Sciences">School of Health Care Sciences
                                            </option>
                                            <option value="School of Oral Health Sciences">School of Oral Health Sciences
                                            </option>
                                            <option value="School of Science and Technology">School of Science and
                                                Technology</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="department">Course </label>
                                        <select name="department" class="form-control">
                                            <option value="">Select Course</option>
                                            <option value="MBChB">Bachelor of Medicine and Bachelor of Surgery (MBChB)
                                            </option>
                                            <option value="B Rad">Bachelor of Diagnostic Radiograpy (B Rad)</option>
                                            <option value="B Cur">Bachelor of Nursing Sciences and Art (B Cur)</option>
                                            <option value="BDS">Bachelor of Dental Surgery (BDS)</option>
                                            <option value="BDT">Bachelor of Dental Therapy (BDT)</option>
                                            <option value="BoH">Bachelor of Oral Hygiene (BoH)</option>
                                            <option value="B SLP & A">Bachelor of Speech Language, Pathology and Audiology
                                                (B SLP & A)</option>
                                            <option value="BSc">Bachelor of Science (BSc)</option>
                                            <option value="BSc Dietetics">Bachelor of Science in Dietetics (BSc Dietetics)
                                            </option>
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
                                        <label for="semester">Semester </label>
                                        <select name="semester" class="form-control">
                                            <option value="">Select Semester</option>
                                            <option value="Semester 1">1st Semester</option>
                                            <option value="Semester 2">2nd Semester</option>
                                            <option value="Part-time">Part-time</option>
                                            <option value="Full-time">Full-time</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="studentregno">Student Number </label>
                                        <input type="text" class="form-control" id="studentregno" name="studentregno"
                                            onBlur="userAvailability()" placeholder="Student Number" required />
                                        <span id="user-availability-status1" style="font-size:12px;">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password </label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter password" required />
                                    </div>

                                    <button type="submit" name="submit" id="submit" class="btn btn-default">Submit</button>
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
        <script>
            function userAvailability() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'regno=' + $("#studentregno").val(),
                    type: "POST",
                    success: function (data) {
                        $("#user-availability-status1").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function () { }
                });
            }
        </script>

    </body>

    </html>
<?php } ?>