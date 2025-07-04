<?php
//connect.php page//

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "crudapplication";

$conn= mysqli_connect($servername, $username, $password,$dbname );

if ($conn){
   //echo "connection ok ";
}else{
    echo "connection falid";
}

?>
