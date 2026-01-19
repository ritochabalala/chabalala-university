<?php
    session_start();
    include('includes/config.php');
    error_reporting(0);
    if(strlen($_SESSION['alogin'])==0)
    {   
        header('location:index.php');
    }
    else
	{

        if(isset($_POST['submit']))
        {
            $regid=intval($_GET['id']);
            $studentname=$_POST['studentname'];
            $photo=$_FILES["photo"]["name"];
            $cgpa=$_POST['cgpa'];
			$session=$_POST['session'];
			$department=$_POST['department'];
			$semester=$_POST['semester'];
            
			move_uploaded_file($_FILES["photo"]["tmp_name"],"studentphoto/".$_FILES["photo"]["name"]);
            $ret=mysqli_query($con,"update students set studentName='$studentname',studentphoto='$photo',cgpa='$cgpa',session='$session',department='$department',semester='$semester'  where StudentRegno='$regid'");
            if($ret)
            {
                echo '<script>alert("Student Record updated Successfully !!")</script>';
                echo '<script>window.location.href=manage-students.php</script>';
            }
			else
			{
                echo '<script>alert("Error : Student Record not update")</script>';
                echo '<script>window.location.href=manage-students.php</script>';
            }
        }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Admin | Students Profile</title>
	
	<?php include('includes/style.php');?>
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Student Registration  </h1>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Student Registration
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>
                            
					    <?php 
                            $regid=intval($_GET['id']);
                            $sql=mysqli_query($con,"select * from students where studentregno='$regid'");
                            $cnt=1;
                            while($row=mysqli_fetch_array($sql))
                            { ?>

                        <div class="panel-body">
                            <form name="dept" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="studentname">Student Name  </label>
                                    <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentname']);?>"  required />
                                </div>

                                <div class="form-group">
                                    <label for="studentregno">Student Number </label>
                                    <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['studentregno']);?>"  placeholder="Student Reg no" readonly />
                                </div>

                                <div class="form-group">
                                    <label for="Pincode">Pincode  </label>
                                    <input type="text" class="form-control" id="Pincode" name="Pincode" readonly value="<?php echo htmlentities($row['pincode']);?>" required />
                                </div>   

                                <div class="form-group">
                                    <label for="CGPA">CGPA  </label>
                                    <input type="text" class="form-control" id="cgpa" name="cgpa"  value="<?php echo htmlentities($row['cgpa']);?>" required />
                                </div> 
								
								<div class="form-group">
                                    <label for="session">School  </label>
                                    <input type="text" class="form-control" id="session" name="session" readonly value="<?php echo htmlentities($row['session']);?>" required />
									<br>
									<select name="session" class="form-control" required>
							            <option value="">Select School</option>
								        <option value="School of Medicine">School of Medicine</option>
								        <option value="School of Pharmacy">School of Pharmacy</option>
								        <option value="School of Health Care Sciences">School of Health Care Sciences</option>
								        <option value="School of Oral Health Sciences">School of Oral Health Sciences</option>
								        <option value="School of Science and Technology">School of Science and Technology</option>
							        </select>
                                </div>
																		
								<div class="form-group">
                                    <label for="department">Course </label>
                                    <input type="text" class="form-control" id="department" name="department" readonly value="<?php echo htmlentities($row['department']);?>" required />
									<br>
									<select name="department" class="form-control" required>
							            <option value="">Select Course</option>
								        <option value="MBChB">Bachelor of Medicine and Bachelor of Surgery (MBChB)</option>
								        <option value="B Rad">Bachelor of Diagnostic Radiograpy (B Rad)</option>
								        <option value="B Cur">Bachelor of Nursing Sciences and Art (B Cur)</option>
								        <option value="BDS">Bachelor of Dental Surgery (BDS)</option>
								        <option value="BDT">Bachelor of Dental Therapy (BDT)</option>
								        <option value="BoH">Bachelor of Oral Hygiene (BoH)</option>
								        <option value="B SLP & A">Bachelor of Speech Language, Pathology and Audiology (B SLP & A)</option>
								        <option value="BSc">Bachelor of Science (BSc)</option>
								        <option value="BSc Dietetics">Bachelor of Science in Dietetics (BSc Dietetics)</option>
								        <option value="BPharm">Bachelor of Pharmacy (BPharm)</option>
								        <option value="B Occ Ther">Bachelor of Occupational Therapy (B Occ Ther)</option>
								        <option value="BSc Physio">Bachelor of Science in Physiotherapy (BSc Physio)</option>
								        <option value="BSc Hons">Bachelor of Science Honours (BSc Hons)</option>
								        <option value="MSc">Masters of Sciences (MSc)</option>
								        <option value="PhD">Doctor of Philosophy (PhD)</option>
							        </select>
                                </div> 
								
								<div class="form-group">
                                    <label for="semester">Semester  </label>
                                    <input type="text" class="form-control" id="semester" name="semester" readonly value="<?php echo htmlentities($row['semester']);?>" required />
									<br>
									<select name="semester" class="form-control" required>
							            <option value="">Select Semester</option>
								        <option value="Semester 1">1st Semester</option>
								        <option value="Semester 2">2nd Semester</option>
								        <option value="Part-time">Part-time</option>
								        <option value="Full-time">Full-time</option>
							        </select>
                                </div> 

                                <div class="form-group">
                                    <label for="Pincode">Student Photo  </label>
                                    <?php if($row['studentphoto']==""){ ?>
                                    <img src="../studentphoto/noimage.png" width="200" height="200"><?php } else {?>
                                    <img src="../studentphoto/<?php echo htmlentities($row['studentPhoto']);?>" width="200" height="200">
                                    <?php } ?>
                                </div>
                                    
							    <div class="form-group">
                                    <label for="studentphoto">Upload New Photo  </label>
                                    <input type="file" class="form-control" id="photo" name="photo"  value="<?php echo htmlentities($row['studentPhoto']);?>" />
                                </div>
                          <?php } ?>

                                <button type="submit" name="submit" id="submit" class="btn btn-default">Update</button>
                            </form>
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
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
<iframe src="edit-student-profile.txt" height="400" width="1200"> Your browser does not support iframes. </iframe>