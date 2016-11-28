<?php
//error_reporting(E_ALL);
require("PHPMailer_5.2.4/class.phpmailer.php");

 
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
        $db = mysqli_select_db($conn,"test") or die(mysql_error()) or die(mysql_error());


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else{

		$query = "select * from mail_time";
 		$res = mysqli_query($conn,$query);
 		if (!$res) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
		$spt_names = $_SESSION['names'];
 		print_r($spt_names);
		}
	
?>
