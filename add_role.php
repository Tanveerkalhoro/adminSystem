<?php 
include('header.php');
if(!isset($_SESSION['user_name'])){
    header("Location: login.php");
    ob_end_clean(); // Clean the buffer before redirect
}
$user_id = $_SESSION['user_id'];
if(isset($menu_id)){
    checkPermission($conn, $user_id, $menu_id);
}
else{
   header("Location: logout.php");
    ob_end_clean(); // Clean the buffer before redirect
}

extract($_REQUEST);
if(isset($mode) && $mode=="delete"  && isset($id)){
    $sql4     = "DELETE  FROM roles WHERE id='$id' ";
    $result4  =mysqli_query($conn,$sql4);
    if($result4 > 0) {
      $msg="This record has been deleted successfully!";
    }
}
if(isset($mode) && $mode=="edit" && isset($id)){
    $sql2     = "SELECT * FROM roles WHERE id='$id' ";
    $result2  =mysqli_query($conn,$sql2);
    $count2   =mysqli_num_rows($result2);
    if($count2 > 0) {
        $data=mysqli_fetch_assoc($result2);
           $role_name    = $data['role_name'];
    }
}
extract($_POST);
if(isset($is_submit) && $is_submit=="Y"){
    if($role_name ==""){
        $error= "Please Insert Role Name ";
    }
    if($mode=="edit"){
        $sql1  ="UPDATE  roles SET 
        role_name   ='".$role_name."'
         WHERE id   ='".$id."'  ";
       $result1 =mysqli_query($conn,$sql1);
        if($result1 > 0){
            $msg= " You have Updated  record Succesfully";
        }
    }else{
        $sql2     = "SELECT *  FROM roles WHERE role_name = '$role_name' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="INSERT INTO roles(role_name) values('$role_name')";
            $ok =mysqli_query($conn,$sql1);
            if($ok){
                $msg= " You have Insert record Succesfully";
            }else{
                $error= "There is error";
            }
        }
    } 
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>

     <?php include("css.php"); ?>

</head>
<body>
 <?php include("sidebar.php"); ?>
 <div class="content">
    <div >
        <h2 class="form-title">Add Role</h2>
               <?php if(isset($error)){echo $error;}
                     if(isset($msg)){echo $msg;}?>
        <form method="post">
            <input type="hidden" name="is_submit" value="Y">
            <div class="form-group">
                <label for="role_name" >Role Name</label>
                <input type="text" id="role_name" name="role_name" value="<?php if(isset($role_name)) { echo $role_name;}?>" >
            </div>
            <div class="form-group">
                <input type="submit" value="Add Role">
            </div>
        </form>
    </div>
    <div >
    <table>
        <thead>
            <tr>
                <th>S No:</th>
                <th>Role Name</th>
                <th>Role Permissions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT * FROM roles";
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            $i = 1;
            if($count > 0){
                while($data = mysqli_fetch_assoc($result)){
                $id= $data['id'];?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($data['role_name']); ?></td>
                    <td>
                        <a href="add_role.php?menu_id=<?php echo $menu_id;?>&mode=edit&id=<?php echo $id?>">Edit</a>  &nbsp;&nbsp;
                        <a href="add_role.php?menu_id=<?php echo $menu_id;?>&mode=delete&id=<?php echo $id?>">Delete</a>
                    </td> 
                    <td>
                        <?php 
                        if(checkPermission2($conn, $user_id, 3) == 1){
                            echo  '<a href="role_pre.php?menu_id=3&mode=per&id=' . $id . '"> Permissions</a>';
                        } ?>
                    </td>
                </tr>
            <?php
                $i++;
                }
            }?>
        </tbody>
    </table>
    <?php 
    ob_end_flush();
    ?>
 </div> 
<?php include("footer.php"); ?>
 </div> 
 </body>
 </html>