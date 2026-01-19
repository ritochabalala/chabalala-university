<?php
include("includes/config.php");
error_reporting(0);
?>
<?php if($_SESSION['login']!="")
{?>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					<strong>Welcome: <?php echo $_SESSION['studentregno']?> </strong>
                    &nbsp;&nbsp;

                    <strong>Last Login:<?php 
                    $ret=mysqli_query($con,"SELECT  * from userlog where studentRegno='".$_SESSION['login']."' order by id desc limit 1,1");
                    $row=mysqli_fetch_array($ret);
                    echo $row['userip']; ?> at <?php echo $row['loginTime'];?></strong>
                </div>
            </div>
        </div>
    </header>
    <?php } ?>
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
				<a class="navbar-brand" href="dashboard.php"><img src="assets/img/smu_logo.jpg" width="250" height="50"></a>
            </div>
        </div>
    </div>