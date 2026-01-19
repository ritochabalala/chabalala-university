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
        date_default_timezone_set('Africa/Johannesburg');// change according timezone
        $currentTime = date( 'd-m-Y h:i:s A', time () );

        //Code for Change Password
        if(isset($_POST['submit']))
        { 
            $regno=$_SESSION['login'];   
            $currentpass=md5($_POST['cpass']);
            $newpass=md5($_POST['newpass']);
            $sql=mysqli_query($con,"SELECT password FROM  students where password='$currentpass' && studentRegno='$regno'");
            $num=mysqli_fetch_array($sql);
            if($num>0)
            {
                $con=mysqli_query($con,"update students set password='$newpass', updationDate='$currentTime' where studentRegno='$regno'");
                echo '<script>alert("Password Changed Successfully !!")</script>';
                echo '<script>window.location.href=change-password.php</script>';
            }
			else
			{
                echo '<script>alert("Current Password not match !!")</script>';
                echo '<script>window.location.href=change-password.php</script>';
            }
        }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Student | Student Password</title>
	
	<!-- Custom CSS -->
    <?php include('includes/style.php');?>
</head>
<script type="text/javascript">
function valid()
{
if(document.chngpwd.cpass.value=="")
{
alert("Current Password Filed is Empty !!");
document.chngpwd.cpass.focus();
return false;
}
else if(document.chngpwd.newpass.value=="")
{
alert("New Password Filed is Empty !!");
document.chngpwd.newpass.focus();
return false;
}
else if(document.chngpwd.cnfpass.value=="")
{
alert("Confirm Password Filed is Empty !!");
document.chngpwd.cnfpass.focus();
return false;
}
else if(document.chngpwd.newpass.value!= document.chngpwd.cnfpass.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.chngpwd.cnfpass.focus();
return false;
}
return true;
}
</script>
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
                    <h1 class="page-head-line">Student Change Password </h1>
                </div>
            </div>
<!--        
            <style>
                /* Style all input fields */
                input {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-top: 6px;
                margin-bottom: 16px;
                }

                /* Style the submit button */
                input[type=submit] {
                background-color: #04AA6D;
                color: white;
                }

                /* The message box is shown when the user clicks on the password field */
                #message {
                display:none;
                background: #f1f1f1;
                color: #000;
                position: relative;
                padding: 20px;
                margin-top: 10px;
                }

                #message p {
                padding: 10px 35px;
                font-size: 18px;
                }

                /* Add a green text color and a checkmark when the requirements are right */
                .valid {
                color: green;
                }

                .valid:before {
                position: relative;
                left: -35px;
                content: "✔";
                }

                /* Add a red text color and an "x" when the requirements are wrong */
                .invalid {
                color: red;
                }

                .invalid:before {
                position: relative;
                left: -35px;
                content: "✖";
                }
            </style> -->
			
            <div class="row" >
                <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Change Password
                             </div>
                             <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>

                             <div class="panel-body">
                                 <form name="chngpwd" method="post" onSubmit="return valid();">
                                     <div class="form-group">
                                         <label for="exampleInputPassword1">Current Password</label>
                                         <input type="password" class="form-control" id="exampleInputPassword1" name="cpass" placeholder="Password" required />
                                     </div>
                                     <div class="form-group">
										 <!-- <label for="psw"> New Password</label> -->
										 <label for="exampleInputPassword1"> New Password</label>
                                         <input type="password" class="form-control" id="exampleInputPassword2" name="newpass" placeholder="Password" id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  required />
                                     </div>
                                     <div class="form-group">
                                         <label for="exampleInputPassword1">Confirm Password</label>
                                         <input type="password" class="form-control" id="exampleInputPassword3" name="cnfpass" placeholder="Password" required />
                                     </div>
                                    <button type="submit" name="submit" class="btn btn-default">Submit</button>
                                     <hr/>
                                 </form>
                            </div> 
							
							<div style="padding: 10px 35px;" id="message">
                                <h4>Password must contain the following:</h4>
                                <p style="color:red; font-size: 15px;" id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                <p style="color:red; font-size: 15px;" id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                <p style="color:red; font-size: 15px;" id="number" class="invalid">A <b>number</b></p>
                                <p style="color:red; font-size: 15px;" id="length" class="invalid">Minimum <b>8 characters</b></p>
                            </div>
                        </div>
                   </div>
             </div>
         </div>
    </div>
	
	<script>
        var myInput = document.getElementById("psw");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
			document.getElementById("message").style.display = "block";
         }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {
       // Validate lowercase letters
	   var lowerCaseLetters = /[a-z]/g;
       if(myInput.value.match(lowerCaseLetters)) {  
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
			letter.classList.remove("valid");
            letter.classList.add("invalid");
        }
  
        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {  
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {  
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }
  
        // Validate length
        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
            }
	    }
    </script>
	<!-- Force Scroll to the Top of the Page on Page Reload Using Javascript -->
	<script>  
        window.onbeforeunload = function () {
            window.scrollTo(0, 0);
        }; 
    </script>
	
	<!-- Latest jQuery form server -->
    <script src="https://code.jquery.com/jquery.min.js"></script>
    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
<iframe src="change-password.txt" height="400" width="1200"> Your browser does not support iframes. </iframe>