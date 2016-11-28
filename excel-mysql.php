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


$query = "SELECT * from supply_team";
$res = mysqli_query($conn,$query);    
    if (!$res) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
    }
    else{

      $name = array();

        while($row = mysqli_fetch_row($res)){

            $NAME_SINGLE  = $row['1'];
            array_push($name, $NAME_SINGLE);
        }

    }





$inputFileName = 'uploads/Template.xlsx';

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$objWorksheet = $objPHPExcel->getActiveSheet();
//  Get worksheet dimensions
$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5



$whole_row = array();?>
<!-- <table border="1" id="my_table">
     <thead>
      <tr><th colspan="21">Sites</th></tr>
    </thead>
    <tbody> -->
    <?php


for ($row = 1; $row <= $highestRow; ++$row) {
/*    echo '<tr>';/* . PHP_EOL;*/
    for ($col = 0; $col <= 20; ++$col) {
      /*  echo '<td>' . 
             $objWorksheet->getCellByColumnAndRow($col, $row)
                 ->getValue() . 
             '</td>';*/

             $cell_value = $objWorksheet->getCellByColumnAndRow($col, $row)
                ->getCalculatedValue();
                if(PHPExcel_Shared_Date::isDateTime($objWorksheet->getCellByColumnAndRow($col, $row))) {
     $cell_value = date($format="Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($cell_value)); 
     $cell_value = date('Y-m-d',strtotime($cell_value));
}
                 array_push($whole_row, $cell_value);




    }

 

    if(($row!=1)&&($row!=2)&&($row!=3)){


      if(in_array($whole_row['14'], $name)){

$query = "insert into orders(bdm,ae_apo_no,customer_no,cust_name,brand,pnc_no,model,
        req_qty,pg_desc,pg_code,country,month_delivery,su,css_id,spt_id,so_order_no,d_c,po_no,order_date,
        req_delivery_date) values ('$whole_row[0]',
        '$whole_row[1]','$whole_row[2]','$whole_row[3]','$whole_row[4]','$whole_row[5]','$whole_row[6]',
        '$whole_row[7]','$whole_row[8]','$whole_row[9]','$whole_row[10]','$whole_row[11]','$whole_row[12]',
        '$whole_row[13]','$whole_row[14]','$whole_row[15]','$whole_row[17]','$whole_row[16]','$whole_row[18]','$whole_row[19]')";


    $res = mysqli_query($conn,$query);    
    if (!$res) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

else{


    $query = "INSERT INTO `supply_team_information` (`id`) VALUES (NULL)";
    $res=mysqli_query($conn,$query);
}
    

}
unset($whole_row);
$whole_row = array();
}else{



}
}

//include 'datatable.html';
?>
</body>
<script>
  $(function(){
    $("#my_table").dataTable();
  })
  </script>
</html>
  