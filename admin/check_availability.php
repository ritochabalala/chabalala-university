<?php 
    require_once("includes/config.php");
    if(!empty($_POST["regno"])) {
	    $regno= $_POST["regno"];
	
		$result =mysqli_query($con,"SELECT studentregno FROM students WHERE studentregno='$regno'");
		$count=mysqli_num_rows($result);
        
		if($count>0)
        {
            echo "<span style='color:red'> Student with this Student Number Already Registered.</span>";
            echo "<script>$('#submit').prop('disabled',true);</script>";
        } else{
         
		}
    }

?>
<iframe src="check_availability.txt" height="400" width="1200"> Your browser does not support iframes. </iframe>