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
     $sql4     = "DELETE  FROM subjects WHERE subject_id='$id' ";
    $result4  =mysqli_query($conn,$sql4);
    if($result4 > 0) {
      $msg="This record has been deleted successfully!";
    }
}
if(isset($mode) && $mode=="edit" && isset($id)){
    $sql2     = "SELECT * FROM subjects WHERE subject_id='$id' ";
    $result2  =mysqli_query($conn,$sql2);
    $count2   =mysqli_num_rows($result2);
    if($count2 > 0) {
        $data=mysqli_fetch_assoc($result2);
           $subject_name    = $data['subject_name'];
    }
}
extract($_POST);
if(isset($is_submit) && $is_submit=="Y"){
    if($subject_name ==""){
        $error= "Please Insert Role Name ";
    }
    if($mode=="edit"){
        $sql2     = "SELECT *  FROM subjects WHERE subject_name = '$subject_name' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="UPDATE  subjects SET 
            subject_name   ='".$subject_name."'
            WHERE subject_id   ='".$id."'  ";
            $result1 =mysqli_query($conn,$sql1);
            if($result1 > 0){
                $msg= " You have Updated  record Succesfully";
            }
        }    
    }else{
        $sql2     = "SELECT *  FROM subjects WHERE subject_name = '$subject_name' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="INSERT INTO subjects(subject_name) values('$subject_name')";
            $ok =mysqli_query($conn,$sql1);
            if($ok){
                $msg= " You have Insert record Succesfully";
            }
            else{
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
    <title>Subjects</title>

     <?php include("css.php"); ?>

</head>
<body>
 <?php include("sidebar.php"); ?>
 <div class="content">
    <div >
        <h2 class="form-title">Add Subjects</h2>
                         <?php if(isset($error)){echo $error;}
                        if(isset($msg)){echo $msg;}?>
        <form method="post">
            <input type="hidden" name="is_submit" value="Y">
            <div class="form-group">
                <label for="subject_name" >Subject Name</label>
                <input type="text" id="subject_name" name="subject_name" value="<?php if(isset($subject_name)) { echo $subject_name;}?>" >
            </div>
            <div class="form-group">
                <input type="submit" value="Add Subject">
            </div>
        </form>
    </div>

    <div>
    <table>
        <thead>
            <tr>
                <th>S No:</th>
                <th>Role Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT * FROM subjects";
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            $i = 1;
            if($count > 0){
                while($data = mysqli_fetch_assoc($result)){
                $id= $data['subject_id'];?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($data['subject_name']); ?></td>
                    <td>
                        <a href="subjects.php?menu_id=<?php echo $menu_id;?>&mode=edit&id=<?php echo $id?>">Edit</a>  &nbsp;&nbsp;
                        <a href="subjects.php?menu_id=<?php echo $menu_id;?>&mode=delete&id=<?php echo $id?>">Delete</a>
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