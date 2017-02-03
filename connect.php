<?php 
$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "2016_02_16_charts";
$dbname = "2016_07_06_charts";

/*$arr1 = [63,42,48];
$arr2 = [22,20];
$arr3 = array_merge($arr1,$arr2);
echo count($arr3);
print_r($arr3);
exit;*/


$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully\n";

$db_selected = mysqli_select_db($conn,$dbname);
if($db_selected)
    echo "DB selected successfully\n";
else{
        echo "No DB selected\n";
        exit(1);
    }
    
?>