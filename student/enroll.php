<?php
require_once('includes/session_security.php');
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0 or strlen($_SESSION['pcode']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $studentregno = $_POST['studentregno'];
        $pincode = $_POST['Pincode'];
        $session = $_POST['session'];
        $dept = $_POST['department'];
        $level = $_POST['level'];
        $course = $_POST['course'];
        $sem = $_POST['sem'];
        $ret = mysqli_query($con, "insert into courseenrolls(studentregno,pincode,session,department,level,course,semester) values('$studentregno','$pincode','$session','$dept','$level','$course','$sem')");

        if ($ret) {
            echo "<script> 
			            alert('Enroll Successfully !!');
			            window.open('enroll-history.php','_self');
			        </script>";
        } else {
            echo "<script> 
			            alert('Error : Not Enroll');
			            window.open('enroll.php','_self');
			        </script>";
        }
    }
    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Student | Course Enroll</title>

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
                        <h1 class="page-head-line">Course Enroll </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Course Enroll
                            </div>
                            <font color="green" align="center">
                                <?php echo htmlentities($_SESSION['msg']); ?>
                                <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                            </font>

                            <?php
                            $sql = mysqli_query($con, "select * from students where StudentRegno='" . $_SESSION['login'] . "'");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($sql)) {
                                ?>

                                <div class="panel-body">
                                    <form name="dept" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="studentname">Student Name </label>
                                            <input type="text" class="form-control" id="studentname" name="studentname"
                                                value="<?php echo htmlentities($row['studentname']); ?>" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="studentregno">Student Number </label>
                                            <input type="text" class="form-control" id="studentregno" name="studentregno"
                                                value="<?php echo htmlentities($row['studentregno']); ?>"
                                                placeholder="Student Number" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="Pincode">Pincode </label>
                                            <input type="text" class="form-control" id="Pincode" name="Pincode" readonly
                                                value="<?php echo htmlentities($row['pincode']); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="Pincode">Student Photo </label>

                                            <?php if ($row['studentPhoto'] == "") { ?>
                                                <img src="studentphoto/noimage.png" width="200" height="200"><?php } else { ?>
                                                <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']); ?>"
                                                    width="200" height="200">
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label for="Session">School </label>
                                        <select class="form-control" name="session" required="required">
                                            <option value="">Select School </option>
                                            <?php
                                            $sql = mysqli_query($con, "select * from session");
                                            while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo htmlentities($row['id']); ?>">
                                                    <?php echo htmlentities($row['session']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Department">Course </label>
                                        <select class="form-control" name="department" required="required">
                                            <option value="">Select Course</option>
                                            <?php
                                            $sql = mysqli_query($con, "select * from department");
                                            while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo htmlentities($row['id']); ?>">
                                                    <?php echo htmlentities($row['department']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Semester">Semester </label>
                                        <select class="form-control" name="sem" required="required">
                                            <option value="">Select Semester</option>
                                            <?php
                                            $sql = mysqli_query($con, "select * from semester");
                                            while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo htmlentities($row['id']); ?>">
                                                    <?php echo htmlentities($row['semester']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Level">Level </label>
                                        <select class="form-control" name="level" required="required">
                                            <option value="">Select Level</option>
                                            <?php
                                            $sql = mysqli_query($con, "select * from level");
                                            while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo htmlentities($row['id']); ?>">
                                                    <?php echo htmlentities($row['level']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Course">Module </label>
                                        <select class="form-control" name="course" id="course" onBlur="courseAvailability()"
                                            required="required">
                                            <option value="">Select Module</option>
                                            <?php
                                            $sql = mysqli_query($con, "select * from course");
                                            while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo htmlentities($row['id']); ?>">
                                                    <?php echo htmlentities($row['courseName']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <span id="course-availability-status1" style="font-size:12px;">
                                    </div>
                                    <button type="submit" name="submit" id="submit" class="btn btn-default">Enroll</button>
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
            function courseAvailability() {
                $("#loaderIcon").show();
                jQuery.ajax(
                    {
                        url: "/check_availability.php",
                        //url: "https://201806940-smu-registrations.000webhostapp.com/php/check_availability.php",
                        data: 'cid=' + $("#course").val(),
                        type: "POST",
                        success: function (data) {
                            $("#course-availability-status1").html(data);
                            $("#loaderIcon").hide();
                        },
                        error: function () { }
                    });
            }
        </script>

    </body>

    </html>
<?php } ?>