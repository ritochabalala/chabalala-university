<?php
    session_start();
    include('includes/config.php');
    error_reporting(0);
    if(strlen($_SESSION['login'])==0)
    {   
        header('location:index.php');
    }
    else
	{
        if(isset($_POST['submit']))
        {
            $studentname=$_POST['studentname'];
            $photo=$_FILES["photo"]["name"];
            $cgpa=$_POST['cgpa'];
			$session=$_POST['session'];
			$department=$_POST['department'];
			$semester=$_POST['semester'];
			
            move_uploaded_file($_FILES["photo"]["tmp_name"],"studentphoto/".$_FILES["photo"]["name"]);
            $ret=mysqli_query($con,"update students set studentname='$studentname',studentPhoto='$photo',cgpa='$cgpa',session='$session',department='$department',semester='$semester' where StudentRegno='".$_SESSION['login']."'");
            if($ret)
            {
                echo '<script>alert("Student Record updated Successfully !!")</script>';
                echo '<script>window.location.href=my-profile.php</script>';    
            }
			else{
                echo '<script>alert("Something went wrong . Please try again.!")</script>';
                echo '<script>window.location.href=my-profile.php</script>';    
            }
        }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Student | Student Profile</title>
	
	<!-- Custom CSS -->
    <?php include('includes/style.php');?>
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php');
}
?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Student Profile  </h1>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Student Profile
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>
                            <?php $sql=mysqli_query($con,"select * from students where studentregno='".$_SESSION['login']."'");
                            $cnt=1;
                            while($row=mysqli_fetch_array($sql))
                            { ?>

                        <div class="panel-body">
                            <form name="dept" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="studentname">Student Name  </label>
                                    <input type="text" class="form-control" id="studentname" name="studentname" readonly value="<?php echo htmlentities($row['studentname']);?>"  />
                                </div>

                                <div class="form-group">
                                    <label for="studentregno">Student Number   </label>
                                    <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['studentregno']);?>"  placeholder="Student Reg no" readonly />
                                </div>

                                <div class="form-group">
                                    <label for="Pincode">Pincode  </label>
                                    <input type="text" class="form-control" id="Pincode" name="Pincode" readonly value="<?php echo htmlentities($row['pincode']);?>" required />
                                </div>   

                                <div class="form-group">
                                    <label for="CGPA">Cumulative Grade Point Average (CGPA)  </label>
                                    <input type="text" class="form-control" id="cgpa" name="cgpa" readonly value="<?php echo htmlentities($row['cgpa']);?>" required />
                                </div>  
								
								<div class="form-group">
                                    <label for="session">School  </label>
                                    <input type="text" class="form-control" id="session" name="session" readonly value="<?php echo htmlentities($row['session']);?>" required />
                                </div>
																		
								<div class="form-group">
                                    <label for="department">Course </label>
                                    <input type="text" class="form-control" id="department" name="department" readonly value="<?php echo htmlentities($row['department']);?>" required />
                                </div> 
								
								<div class="form-group">
                                    <label for="semester">Semester  </label>
                                    <input type="text" class="form-control" id="semester" name="semester" readonly value="<?php echo htmlentities($row['semester']);?>" required />
                                </div> 

                                <div class="form-group">
                                    <label for="Pincode">Student Photo  </label>
                                    <?php if($row['studentPhoto']==""){ ?>
                                    <img src="studentphoto/noimage.png" width="200" height="200"><?php } else {?>
                                    <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']);?>" width="200" height="200">
                                    <?php } ?>
                                </div>
                                
								<div class="form-group">
                                    <label for="Pincode">Upload New Photo  </label>
                                    <input type="file" class="form-control" id="photo" name="photo"  value="<?php echo htmlentities($row['studentPhoto']);?>" />
                                </div>
                            <?php } ?>
                                <button type="submit" name="submit" id="submit" class="btn btn-default">Update</button>
                            </form> 
                            <br>
							<a href="generate_card.php" target="_blank">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary"><i class="fa fa-address-card"></i>Generate Student Card</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
<iframe src="my-profile.txt" height="400" width="1200"> Your browser does not support iframes. </iframe>