<?php 
include("header.php");
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
if(isset($mode) && $mode=="delete" && isset($id)){
    $sql4     = "DELETE  FROM teachers_info WHERE teacher_id='$id' ";
    $result4  =mysqli_query($conn,$sql4);
    if($result4 > 0) {
       $msg="This record has been deleted successfully!";
    }
}
if(isset($mode) && $mode=="edit" && isset($id)){
    $sql2     = "SELECT * FROM teachers_info WHERE teacher_id='$id' ";
    $result2  =mysqli_query($conn,$sql2);
    $count2   =mysqli_num_rows($result2);
    if($count2 > 0) {
        $data=mysqli_fetch_assoc($result2);
           $full_name    = $data['full_name'];
           $user_name    = $data['user_name'];
           $email        = $data['email'];
           $pasword      = $data['pasword'];
           $role_id      = $data['role_id'];
    }
}
extract($_POST);
if(isset($is_submit) && $is_submit=="Y"){
    if($role_id ==""){
        $error = "Please Select User Role";
    }
    if($pasword ==""){
        $error = "Please Insert  password";
    }
    if($email ==""){
        $error= "Please Insert email address";
    }
    if($full_name ==""){
        echo "Please Insert user Name";
    }
    if($user_name ==""){
        $error= "Please Insert full Name";
    }
    if(empty($error)){
        if($mode=="edit"){
                $sql1  ="UPDATE  teachers_info SET 
                full_name   ='".$full_name."',
                user_name   ='".$user_name."',
                email       ='".$email."',
                pasword     ='".$pasword."',
                role_id     ='".$role_id."'
                 WHERE id   ='".$id."'  ";
               $result1 =mysqli_query($conn,$sql1);
                if($result1 > 0){
                    $msg = " You have Updated  record Succesfully";
                }
        }else{
            $sql2     = "SELECT * FROM teachers_info WHERE user_name='$user_name' AND full_name='$full_name' AND email='$email' ";
            $result2  =mysqli_query($conn,$sql2);
            $count2   =mysqli_num_rows($result2);
            if($count2 > 0) {
                $error = "Sorry ! This record is already exist.";
            } else {
                $sql1  ="INSERT INTO teachers_info(full_name,user_name,email,pasword,role_id) values('$full_name','$user_name','$email','$pasword','$role_id')";
                $result1 =mysqli_query($conn,$sql1);
                if($result1 > 0){
                    $msg = " You have inser record Succesfully";
                }
            }
        }
    }
}
$sql3    = "SELECT * FROM roles  ";
$result3  =mysqli_query($conn,$sql3);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
     <?php include("css.php"); ?>
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="content">
         <div >
         <h2 class="form-title">Teacher Data Form</h2>
        <?php 
        if(isset($error)){echo $error;}
        if(isset($msg)){echo $msg;}?>
        <form action="" method="POST">
            <input type="hidden" name="is_submit" value="Y">
            <div class="form-group">
                <label for="full_name" >Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php if(isset($full_name)) { echo $full_name;}?>" >
            </div>
            <div class="form-group">
                <label for="user_name" >User Name</label>
                <input type="text" id="user_name" name="user_name" value="<?php if(isset($user_name)) { echo $user_name;}?>" >
            </div>
            <div class="form-group">
                <label for="email" >Email</label>
                <input type="email" id="email" name="email" value="<?php if(isset($email)) { echo $email;}?>" >
            </div>
            <div class="form-group">
                <label for="pasword" >Password</label>
                <input type="text" id="pasword" name="pasword" value="<?php if(isset($pasword)) { echo $pasword;}?>" >
            </div>
            <div class="form-group">
                <select id="role_id" name="role_id" value="<?php if(isset($role_id)) { echo $role_id;}?>">
                    <option value="">-- Select User Role --</option>
                    <?php
                    $count3   =mysqli_num_rows($result3);
                    if($count3 > 0) {
                            echo $count3 ;
                        while($data=mysqli_fetch_assoc($result3)){
                            ?>
                            <option value="<?php echo $data['id']; ?>" <?php if (isset($role_id) && $role_id == $data['id']) { ?> selected="selected" <?php } ?>> <?php echo $data['role_name']; ?>  </option>
                            <?php
                        }
                    }?>
                 </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Rgister">
            </div>
        </form>
        </div>
        <div >
            <table>
                <thead>
                    <tr>
                        <th>S No:</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Subjects Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $sql = "SELECT a.* ,b.role_name
                    FROM teachers_info a
                    INNER JOIN roles b on a.role_id = b.id  ";
                    $result = mysqli_query($conn,$sql);
                    $count = mysqli_num_rows($result);
                    if($count > 0){
                        while($data = mysqli_fetch_assoc($result)){
                        $id= $data['teacher_id'];?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($data['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($data['email']); ?></td>
                        <td><?php echo htmlspecialchars($data['role_name']); ?></td>
                        <td>
                            <a href="teachers.php?menu_id=<?php echo $menu_id;?>&mode=edit&id=<?php echo $id?>">Edit</a>  &nbsp;&nbsp;
                            <a href="teachers.php?menu_id=<?php echo $menu_id;?>&mode=delete&id=<?php echo $id?>">Delete</a>
                        </td>                  
                        <td>
                        <?php 
                        if(checkPermission2($conn, $user_id, 16) == 1){
                            echo  '<a href="teacher_sub.php?menu_id=15&mode=per&id=' . $id . '"> Permissions</a>';
                        } ?>
                    </td>
                 </tr>
                    <?php
                        $i++;
                        }
                    }
                    ?>
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