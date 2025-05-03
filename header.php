<?php 
session_start(); 
ob_start(); 
#session_name("projectd");
//We start the session 
include("connection.php");

if(isset($_GET['menu_id'])){
    $menu_id = $_GET['menu_id'];
}

function checkPermission($conn, $user_id, $menu_id){
  
    $sql        = " SELECT a.* 
                    FROM users a 
                    INNER JOIN `role_per` b ON a.`role_id` = b.role_id
                    WHERE a.id = '".$user_id."'
                    AND b.`menus_id` = '".$menu_id."' ";
                  
    $result2    = mysqli_query($conn,$sql);
    $count2     = mysqli_num_rows($result2);
    
    if($count2 == 0 && $_SESSION['user_type'] != 'SuperAdmin'){  
        header("Location: logout.php");
        ob_end_clean(); 
    }
    else
    {
        return true;
    }
}

function checkPermission2($conn, $user_id, $menu_id){
  
    $sql        = " SELECT a.* 
                    FROM users a 
                    INNER JOIN `role_per` b ON a.`role_id` = b.role_id
                    WHERE a.id = '".$user_id."'
                    AND b.`menus_id` = '".$menu_id."' ";
    $result2    = mysqli_query($conn,$sql);
    $count2     = mysqli_num_rows($result2);
    if($count2 == 0 && $_SESSION['user_type'] != 'SuperAdmin'){  
         return "0";
    }
    else
    {
        return "1";
    }
}


?>