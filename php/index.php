<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Test PHP File</title>
</head>
<body>
    <?php
        /*$num1 = 0;
        $num2 = 1;
        for($i = 0; $i < 5; $i++){
            $num2 += $num1;
            if(($num2 % 2) != 0){
               echo '['.$num2.'] ';
            }
            else {
               echo $num2. ' ';
            }
            $num1 = $num2;
        }*/
	   
	    /*$DaysOfWeek = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        foreach ($DaysOfWeek as $Day) {
            echo "<p>$Day</p>\n";
        }*/
		
        //create a for loop that will do something 10 times in row
for ($i=0;$i<7;$i++) {

    //every time the loop runs, lets create a random number
    //between 1 and 20 using the rand() function
    $currentRandomNumber = rand(1,4);

    //now, if the random number we made on this loop iteration
    //leaves no remainder when divided by two, it must be even,
    //otherwise it must be odd
    if ($currentRandomNumber % 2 === 0) {
        echo $currentRandomNumber . ' is even.';
    } else {
        echo $currentRandomNumber . ' is odd.';
    }
}
    ?>
</body>
</html>

