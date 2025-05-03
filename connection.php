<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "projectdb";

$conn = mysqli_connect($localhost,$username,$password,$database);
if($conn) {
//    echo "<br><br><br><br><br>conect";
}else die();


?>