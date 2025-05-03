<?php 
include("header.php");
if(!isset($_SESSION['user_name'])){
    header("Location: login.php");
    ob_end_clean(); 
}
$user_id = $_SESSION['user_id'];
//$menu_id = $_SESSION['menu_id'];
if(isset($menu_id)){
    checkPermission($conn, $user_id, $menu_id);
 }
else{
   header("Location: logout.php");
    ob_end_clean(); 
}

$sql3     = "SELECT * FROM menus   ";
$result3  = mysqli_query($conn,$sql3);
$count3   = mysqli_num_rows($result3);

extract($_REQUEST);
if(isset($is_submit) && $is_submit=="Y"){
    // $sql5 =" INSERT INTO role_per(role_id,menus_id) values('$role_id','$menus_id')";
   $sql6     = "SELECT * FROM role_per WHERE role_id='$id'   ";
    $result6  =mysqli_query($conn,$sql6);
    $count6   = mysqli_num_rows($result6);
        if($count6 > 0) {
            foreach($menus_id as $key=>$value){
            $sql9 ="DELETE  FROM role_per WHERE role_id='$id' ";
                        $ok9 =mysqli_query($conn,$sql9);
                        if($ok9){
                            $msg= "THE PERMISSION HAS BEEN UPDATE";
                        }
            }
            foreach($menus_id as $key=>$value){
                $sql5    =" INSERT INTO role_per(role_id,menus_id) values($id,$value)";
                $ok =mysqli_query($conn,$sql5);
                if($ok){
                }
            }

        } else {
                foreach($menus_id as $key=>$value){
                $sql5    =" INSERT INTO role_per(role_id,menus_id) values($id,$value)";
                $ok =mysqli_query($conn,$sql5);
                if($ok){
                }
            }
        }
     

} 
if(isset($mode) && $mode=="per" && isset($id)){

    $sql1_1    = "SELECT role_name FROM roles WHERE id='".$id."'";
    $result1_1 = mysqli_query($conn,$sql1_1);
    $count1_1  =mysqli_num_rows($result1_1);
    if($count1_1 >0){
        $data1_1 =mysqli_fetch_assoc($result1_1);
        $role_id = $data1_1['role_name'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar with Spacing</title>

     <?php include("css.php"); ?>

</head>
<body>
  <?php include("sidebar.php"); ?>

  <div class="content">
    <?php 
    if(isset($mode) && $mode=="per" && isset($id)){ ?>
    <div class="content">
        <h2 class="form-title">Role Permission</h2>
        <?php 
                        if(isset($error)){
                            echo $error;
                        }
                        if(isset($msg)){
                            echo $msg;
                        }
                        ?>
        <form action="" method="POST">
            <input type="hidden" name="is_submit" value="Y">
            <input type="hidden" name="id" value="<?php if(isset($id)) { echo $id;}?>" >

            <input type="text" name="role_id" value="<?php if(isset($role_id)) { echo $role_id;}?>" >
            <form action="process_form.php" method="post">
            <?php 
            if($count3 > 0) {
                foreach($result3 as $data){
                    $checked  = "";
                    $sql4     = "   SELECT * FROM role_per 
                                    WHERE menus_id =  '".$data['id']."'
                                    AND role_id = '".$id."' ";
                    $result4  = mysqli_query($conn,$sql4);
                    $count4   = mysqli_num_rows($result4);
                    if($count4 >0){
                        $checked = "checked";
                    } ?>
                    <label><input type="checkbox" name="menus_id[]" value="<?php echo $data['id'];?>" <?php echo $checked;?>><?php echo $data['menus_name'];?></label><br>
            <?php
                } }  ?>
            <div class="form-group">
                <input type="submit" value="Assgin Per">
            </div>
        </form>
            
                        
            
        </form>
                        
    </div>
    <?php 
    }else {
       echo" <p>Please first select Role! </p>";
    }
    ?>
    <?php include("footer.php"); ?>
 
  </div> 
 </body>
 </html>