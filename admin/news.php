<?php
require_once('../includes/session_security.php');
require_once('../includes/error_handler.php');
include('includes/config.php');
include('../includes/security.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit();
} else {
    // Code for News Insertion
    if (isset($_POST['submit'])) {
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
            logMessage("CSRF token validation failed in news submission", 'WARNING');
            echo '<script>alert("Invalid form submission. Please try again.")</script>';
            exit();
        }

        // Validate and sanitize inputs
        $ntitle = sanitizeInput($_POST['newstitle']);
        $ndescription = sanitizeInput($_POST['description']);

        if (empty($ntitle) || empty($ndescription)) {
            echo '<script>alert("Title and description are required")</script>';
        } else {
            try {
                $stmt = $dbh->prepare("INSERT INTO news(newstitle,newsDescription) VALUES(?,?)");
                $ret = $stmt->execute([$ntitle, $ndescription]);
                if ($ret) {
                    logMessage("News added: $ntitle", 'INFO');
                    echo '<script>alert("News added successfully")</script>';
                    echo "<script>window.location.href='news.php'</script>";
                } else {
                    logMessage("Failed to add news: $ntitle", 'ERROR');
                    echo '<script>alert("Something went wrong. Please try again.")</script>';
                    echo "<script>window.location.href='news.php'</script>";
                }
            } catch (PDOException $e) {
                logMessage("Database error adding news: " . $e->getMessage(), 'ERROR');
                echo '<script>alert("An error occurred. Please try again.")</script>';
            }
        }
    }

    //Code Deletion
    if (isset($_GET['del'])) {
        $nid = (int) $_GET['id']; // Cast to integer for safety
        try {
            $stmt = $dbh->prepare("DELETE FROM news WHERE id = ?");
            $stmt->execute([$nid]);
            logMessage("News deleted: ID $nid", 'INFO');
            echo '<script>alert("News deleted successfully.")</script>';
            echo '<script>window.location.href="news.php"</script>';
        } catch (PDOException $e) {
            logMessage("Database error deleting news: " . $e->getMessage(), 'ERROR');
            echo '<script>alert("An error occurred. Please try again.")</script>';
        }
    }
    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Admin | News</title>

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
                        <h1 class="page-head-line">Add News </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                News
                            </div>

                            <div class="panel-body">
                                <form name="dept" method="post">
                                    <?php echo csrfTokenField(); ?>
                                    <div class="form-group">
                                        <label for="department">News Title </label>
                                        <input type="text" class="form-control" id="newstitle" name="newstitle"
                                            placeholder="News Title" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="department">News Description </label>
                                        <textarea class="form-control" id="description" name="description"
                                            placeholder="News Description" required></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage News
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>News Title</th>
                                            <th>News Description</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($con, "select * from news");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo htmlentities($row['newstitle']); ?></td>
                                                <td><?php echo htmlentities($row['newsDescription']); ?></td>
                                                <td><?php echo htmlentities($row['postingDate']); ?></td>
                                                <td>
                                                    <a href="news.php?id=<?php echo $row['id'] ?>&del=delete"
                                                        onClick="return confirm('Are you sure you want to delete?')">
                                                        <button class="btn btn-danger">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  End  Bordered Table  -->
                </div>
            </div>
        </div>

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('../includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY SCRIPTS -->
        <script src="../assets/js/jquery-1.11.1.js"></script>
        <!-- BOOTSTRAP SCRIPTS  -->
        <script src="../assets/js/bootstrap.js"></script>
    </body>

    </html>
<?php } ?>