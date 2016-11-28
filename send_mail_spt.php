<html>
<head>
      <script type="text/javascript src="src="https://code.jquery.com/jquery-3.1.1.js"></script>
      <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

</head>
<body>
<?php
//  Include PHPExcel_IOFactory
include 'Classes/PHPExcel/IOFactory.php';
require("PHPMailer_5.2.4/class.phpmailer.php");
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
        $db = mysqli_select_db($conn,"Tracker") or die(mysql_error()) or die(mysql_error());

ini_set('memory_limit', '512M'); // Check connection
ini_set('max_execution_time', 300);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query="SELECT * FROM orders";
$res = mysqli_query($conn,$query);    
    if (!$res) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
    }
    else{

    	$name=array();

    	while($row = mysqli_fetch_row($res)){

    			$NAME_SINGLE  = $row['15'];
            array_push($name, $NAME_SINGLE);

    	}

    	for($i=0;$i<count($name);$i++){

    			/*echo $name[$i];*/

$mail= new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug=2;
$mail->From="tsahay2@gmail.com";
$mail->FromName="Tushar Sahay";
$mail->Host="smtp.gmail.com";
//$mail->SMTPSecure="ssl";
$mail->SMTPSecure="tls";
$mail->Port=587;
$mail->SMTPAuth=true;
$mail->Username="tsahay2@gmail.com";
$mail->Password="TutuSahay123";
$mail->AddAddress($name[$i],"Ram");
$mail->AddReplyTo('tsahay2@gmail.com', 'Tushar');
$mail->WordWrap=50;
$mail->IsHTML(true);
$mail->Subject='Mail testing';
$mail->addCC('sahaytm@rknec.edu');
//$mail->addBCC('tsahay2@gmail.com');
//$content=file_get_contents('https://www.facebook.com/');
//$mail->MsgHTML($content);
//$pdf=file_get_contents('http://localhost/pdf/pdf.php');
//$mail->AddStringAttachment($pdf, "sagar.pdf", $encoding = 'base64', $type = 'application/pdf');
$mail->Body='Test Body
<h1>Hi! Please click on the following link</h1>
<hr><p>http://localhost/Tracker/bootstrap-datatable-php/bootstrap-fileinput-master/examples/datatable.html</p>';
if($mail->send())
{
echo "message send to <br/>";
echo $row['mail'];	
}

else
{
	echo "message not send<br/>";
}


    	}
    }

?>