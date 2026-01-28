<?php
require_once('includes/session_security.php');
require_once('includes/config.php');
require_once('includes/security.php');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Require authentication
requireAuth('login', 'index.php');

if (isset($_POST['submit'])) {
    $studentname = sanitizeInput($_POST['studentname']);
    $cgpa = sanitizeInput($_POST['cgpa']);
    $session = sanitizeInput($_POST['session']);
    $department = sanitizeInput($_POST['department']);
    $semester = sanitizeInput($_POST['semester']);
    $regno = $_SESSION['login'];

    // Handle file upload
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $errors = validateFileUpload($_FILES['photo']);

        if (empty($errors)) {
            $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $photo = generateSecureFilename($extension);

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], "studentphoto/" . $photo)) {
                echo '<script>alert("Failed to upload photo")</script>';
                echo '<script>window.location.href="my-profile.php"</script>';
                exit();
            }
        } else {
            echo '<script>alert("' . implode(', ', $errors) . '")</script>';
            echo '<script>window.location.href="my-profile.php"</script>';
            exit();
        }
    }

    try {
        // Update student profile using prepared statement
        if ($photo) {
            $stmt = $pdo->prepare("UPDATE students SET studentname = :name, studentPhoto = :photo, cgpa = :cgpa, session = :session, department = :dept, semester = :semester WHERE StudentRegno = :regno");
            $stmt->execute([
                'name' => $studentname,
                'photo' => $photo,
                'cgpa' => $cgpa,
                'session' => $session,
                'dept' => $department,
                'semester' => $semester,
                'regno' => $regno
            ]);
        } else {
            $stmt = $pdo->prepare("UPDATE students SET studentname = :name, cgpa = :cgpa, session = :session, department = :dept, semester = :semester WHERE StudentRegno = :regno");
            $stmt->execute([
                'name' => $studentname,
                'cgpa' => $cgpa,
                'session' => $session,
                'dept' => $department,
                'semester' => $semester,
                'regno' => $regno
            ]);
        }

        logSecurityEvent('profile_updated', "Student: $regno", 'info');

        echo '<script>alert("Student Record updated Successfully !!")</script>';
        echo '<script>window.location.href="my-profile.php"</script>';
        exit();

    } catch (PDOException $e) {
        error_log("Profile update error: " . $e->getMessage());
        logSecurityEvent('profile_update_error', $e->getMessage(), 'error');

        echo '<script>alert("Something went wrong. Please try again.")</script>';
        echo '<script>window.location.href="my-profile.php"</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Student | Student Profile</title>

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
                    <h1 class="page-head-line">Student Profile </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Student Profile
                        </div>
                        <font color="green" align="center">
                            <?php echo htmlentities($_SESSION['msg']); ?>
                            <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                        </font>
                        <?php $sql = mysqli_query($con, "select * from students where studentregno='" . $_SESSION['login'] . "'");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($sql)) { ?>

                            <div class="panel-body">
                                <form name="dept" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="studentname">Student Name </label>
                                        <input type="text" class="form-control" id="studentname" name="studentname" readonly
                                            value="<?php echo htmlentities($row['studentname']); ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="studentregno">Student Number </label>
                                        <input type="text" class="form-control" id="studentregno" name="studentregno"
                                            value="<?php echo htmlentities($row['studentregno']); ?>"
                                            placeholder="Student Reg no" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="Pincode">Pincode </label>
                                        <input type="text" class="form-control" id="Pincode" name="Pincode" readonly
                                            value="<?php echo htmlentities($row['pincode']); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="CGPA">Cumulative Grade Point Average (CGPA) </label>
                                        <input type="text" class="form-control" id="cgpa" name="cgpa" readonly
                                            value="<?php echo htmlentities($row['cgpa']); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="session">School </label>
                                        <input type="text" class="form-control" id="session" name="session" readonly
                                            value="<?php echo htmlentities($row['session']); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="department">Course </label>
                                        <input type="text" class="form-control" id="department" name="department" readonly
                                            value="<?php echo htmlentities($row['department']); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="semester">Semester </label>
                                        <input type="text" class="form-control" id="semester" name="semester" readonly
                                            value="<?php echo htmlentities($row['semester']); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="Pincode">Student Photo </label>
                                        <?php if ($row['studentPhoto'] == "") { ?>
                                            <img src="studentphoto/noimage.png" width="200" height="200"><?php } else { ?>
                                            <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']); ?>"
                                                width="200" height="200">
                                        <?php } ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="Pincode">Upload New Photo </label>
                                        <input type="file" class="form-control" id="photo" name="photo"
                                            value="<?php echo htmlentities($row['studentPhoto']); ?>" />
                                    </div>
                                <?php } ?>
                                <button type="submit" name="submit" id="submit" class="btn btn-default">Update</button>
                            </form>
                            <br>
                            <a href="generate_card.php" target="_blank">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary"><i
                                        class="fa fa-address-card"></i>Generate Student Card</button>
                            </a>
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