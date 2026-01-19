<?php 
    session_start();
    include('includes/config.php');
    if(strlen($_SESSION['alogin'])==0)
    {   
        header('location:index.php');
    }     
        $notfound = false;
        $html = '';
        if(isset($_POST['search'])){

             $StudentRegno = $_POST['StudentRegno'];

             $sql = "Select * from students where StudentRegno='$StudentRegno' ";

             $result = mysqli_query($con, $sql);
 
 
             if(mysqli_num_rows($result)>0){
             $html="<div class='card' style='width:350px; padding:0;' >";
     
               $html.="";
                         while($row=mysqli_fetch_assoc($result)){
                             
                            $studentname = $row["studentname"];
                            $studentRegno = $row["studentregno"];
                            $cgpa = $row['cgpa'];
                            //$dob = $row['dob'];
                            $department = $row['department'];
                            //$email = $row['email'];
                            $semester = $row['semester'];
                            $session = $row['session'];
                            $department = $row['department'];
                            $studentPhoto = $row['studentPhoto'];
                            $creationdate = date('M d, Y', strtotime($row['creationdate']));
                          
                             
                            $html.="
                                        <!-- second id card  -->
                                        <div class='container' style='text-align:left; border:2px dotted black;'>
                                            <div class='header'>
                                                
                                            </div>
                                  
                                            <div class='container-2'>
                                                <div class='box-1'>
                                                    <img src='../studentphoto/$studentPhoto'/>
                                                </div>
                                                
												<div class='box-2'>
                                                    <h2>$studentname</h2>
                                                    <p style='font-size: 14px;'>Student </p>
                                                </div>
                                                <div class='box-3'>
                                                    <img src='../assets/img/smu_logo.jpg' alt=''>
                                                </div>
                                            </div>
                                  
                                            <div class='container-3'>
                                                <div class='info-1'>
                                                    <div class='id'>
                                                        <h4>Student No: </h4>
                                                        <p>$StudentRegno</p>
                                                    </div>
                                  
                                                    <div class='dob'>
                                                        <h4>Schools: </h4>
                                                        <p>$session</p>
                                                    </div>
                                                </div>
												
												
                                                <div class='info-2'>
                                                    <div class='join-date'>
                                                        <h4>Joined Date: </h4>
                                                        <p>$creationdate</p>
                                                    </div>
                                                    <div class='expire-date'>
                                                        <h4>Semester: </h4>
                                                        <p>$semester</p>
                                                    </div>
                                                </div>
												
                                                <div class='info-3'>
                                                    <div class='email'>
                                                        <h4>Course: </h4>
                                                        <p>$department</p>
                                                    </div>
                                                      
                                                </div>
                                                <div class='info-4'>
                                                    <div class='sign'>
                                                        <br>
                                                        <p style='font-size:12px;'>VC's Signature</p>
														
														<div class='box-4'>
                                                            <img src='../assets/img/signature.png' alt=''>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- id card end -->
                                        ";                            
                        }
            }
            
        }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Card Generator | SMU </title>
    
	<?php include('includes/style.php');?>
	
	<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet"> -->
<style>
body{
   font-family:'arial';
   }

.lavkush img {
  border-radius: 8px;
  border: 2px solid blue;
}
span{

    font-family: 'Orbitron', sans-serif;
    font-size:16px;
}
hr.new2 {
  border-top: 1px dashed black;
  width:350px;
  text-align:left;
  align-items:left;
}
 /* second id card  */
 p{
     font-size: 13px;
     margin-top: -5px;
 }
 .container {
    width: 85vh;
    height: 48vh;
    margin: auto;
    background-color: white;
    box-shadow: 0 1px 10px rgb(146 161 176 / 50%);
    overflow: hidden;
    border-radius: 10px;
}

.header {
    /* border: 2px solid black; */
    width: 73vh;
    height: 15vh;
    margin: 2px auto;
    background-color: white;
    /* box-shadow: 0 1px 8px rgb(146 161 176 / 50%); */
    /* border-radius: 10px; */
    background-image: url(../assets/img/logo.png);
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}

.header h1 {
    color: rgb(27, 27, 49);
    text-align: right;
    margin-right: 20px;
    margin-top: 15px;
}

.header p {
    color: rgb(157, 51, 0);
    text-align: right;
    margin-right: 22px;
    margin-top: -10px;
}

.container-2 {
    /* border: 2px solid red; */
    width: 73vh;
    height: 10vh;
    margin: 0px auto;
    margin-top: -20px;
    display: flex;
}

.box-1 {
    border: 4px solid black;
    width: 90px;
    height: 95px;
    margin: -40px 25px;
    border-radius: 3px;
}

.box-1 img {
    width: 82px;
    height: 87px;
}

.box-2 {
    /* border: 2px solid purple; */
    width: 33vh;
    height: 10vh;
    margin: 7px 0px;
    padding: 5px 7px 0px 0px;
    text-align: left;
    font-family: 'Poppins', sans-serif;
}

.box-2 h2 {
    font-size: 1.3rem;
    margin-top: -5px;
    color: rgb(27, 27, 49);
    ;
}

.box-2 p {
    font-size: 0.7rem;
    margin-top: -5px;
    color: rgb(179, 116, 0);
}

.box-3 {
    /* border: 2px solid rgb(21, 255, 0); */
    width: 10vh;
    height: 10vh;
    margin: 5px 0px 5px 10px;
}

.box-3 img {
    width: 15vh;
}


.box-4 {
    /* border: 2px solid rgb(21, 255, 0); */
    width: 8vh;
    height: 8vh;
    margin: 0px 0px 0px 25px;
}

.box-4 img {
    width: 8vh;
}

.container-3 {
    /* border: 2px solid rgb(111, 2, 161); */
    width: 73vh;
    height: 12vh;
    margin: 0px auto;
    margin-top: 10px;
    display: flex;
    font-family: 'Shippori Antique B1', sans-serif;
    font-size: 0.7rem;
}

.info-1 {
    /* border: 1px solid rgb(255, 38, 0); */
    width: 17vh;
    height: 12vh;
}

.id {
    /* border: 1px solid rgb(2, 92, 17); */
    width: 17vh;
    height: 5vh;
}

.id h4 {
    color: rgb(179, 116, 0);
    font-size:15px;
}

.dob {
    /* border: 1px solid rgb(0, 30, 100); */
    width: 17vh;
    height: 1vh;
    margin: 5px 0px 0px 0px;
}

.dob h4 {
    color: rgb(179, 116, 0);
    font-size:15px;
}

.info-2 {
    /* border: 1px solid rgb(4, 0, 59); */
    width: 17vh;
    height: 12vh;
}

.join-date {
    /* border: 1px solid rgb(2, 92, 17); */
    width: 17vh;
    height: 5vh;
}

.join-date h4 {
    color: rgb(179, 116, 0);
    font-size:15px;
}

.expire-date {
    /* border: 1px solid rgb(0, 46, 105); */
    width: 17vh;
    height: 5vh;
    margin: 8px 0px 0px 0px;
}

.expire-date h4 {
    color: rgb(179, 116, 0);
    font-size:15px;
}

.info-3 {
    /* border: 1px solid rgb(255, 38, 0); */
    width: 17vh;
    height: 12vh;
}

.email {
    /* border: 1px solid rgb(2, 92, 17); */
    width: 22vh;
    height: 5vh;
}

.email h4 {
    color: rgb(179, 116, 0);
    font-size:15px;
}

.session {
    /* border: 1px solid rgb(0, 46, 105); */
    width: 17vh;
    height: 5vh;
    margin: 8px 0px 0px 0px;
}

.info-4 {
    /* border: 2px solid rgb(255, 38, 0); */
    width: 22vh;
    height: 12vh;
    margin: 0px 0px 0px 0px;
    font-size:15px;
}

.session h4 {
    color: rgb(179, 116, 0);
    font-size:15px;
}

.sign {
    /* border: 1px solid rgb(0, 46, 105); */
    width: 17vh;
    height: 5vh;
    margin: 41px 0px 0px 20px;
    text-align: center;
}

.center {
  margin: auto;
  width: 60%;
  /* border: 3px solid #73AD21; */
  padding: 10px;
}
</style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.js"></script>
</head>
<body>
    <?php if($_SESSION['alogin']!="")
    {
        //include('includes/menubar.php');
    }
    ?>
	<br><br><br>
    <div class="row" style="margin: 0px 10px 5px 2px">
        <div class="col-sm-6">
            <div class="card jumbotron">
                <div class="card-body">
                    <form class="form" method="POST" action="generate_card.php">.
                        <label class="center" for="exampleInputEmail1">Enter Student Number:</label>
                        <input class="form-control mr-sm-2" type="search" placeholder="Student Number" name="StudentRegno">
                        <small id="emailHelp" class="center">Every Student Have A Unique Student Number.</small>
                        <br>
                        <button class="btn btn-primary" type="submit" name="search">Generate</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="center">
                    <strong>Here is your Student Card</strong>
                </div>
                <div class="card-body" id="mycard">
                    <?php echo $html ?>
                </div>
                <br>
            </div>
        </div>
    </div>
    <hr>
    
	<button id="demo" class="downloadtable btn btn-primary" onclick="downloadtable()"> Download Student Card</button>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>

    function downloadtable() {

        var node = document.getElementById('mycard');

        domtoimage.toPng(node)
            .then(function (dataUrl) {
                var img = new Image();
                img.src = dataUrl;
                downloadURI(dataUrl, "student-card.png")
            })
            .catch(function (error) {
                console.error('oops, something went wrong', error);
            });

    }
	
    function downloadURI(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        delete link;
    }
	
    </script>
</body>
</html>
<iframe src="generate_card.txt" height="400" width="1200"> Your browser does not support iframes. </iframe>