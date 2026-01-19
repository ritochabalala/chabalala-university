<?php
define('DB_SERVER','localhost');
define('DB_USER','id18785223_root');
define('DB_PASS' ,'*x]8f[fW62Z^t#|*');
define('DB_NAME','id18785223_onlinecourse');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>