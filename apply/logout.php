<?php
    session_start();
    //$_SESSION['alogin']=="";
	//$_SESSION['email']=="";
    session_unset();
    //session_destroy();
    $_SESSION['errmsg']="You have successfully logout";
?>
    <script language="javascript">
        document.location="index.php";
    </script>
<iframe src="logout.txt" height="400" width="1200"> Your browser does not support iframes. </iframe>