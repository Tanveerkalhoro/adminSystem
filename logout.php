<?php 

include('header.php');
 
session_destroy();
header("Location: login.php");
ob_end_clean(); // Clean the buffer before redirect
exit();


?>