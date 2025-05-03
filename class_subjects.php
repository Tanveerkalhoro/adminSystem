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
    $sql3     = "DELETE  FROM class_subjects WHERE id='$id' ";
     $result3  =mysqli_query($conn,$sql3);
    if($result3 > 0) {
      $msg="This record has been deleted successfully!";
    }
}


if(isset($mode) && $mode=="edit" && isset($id)){
    $sql2     = "SELECT * FROM class_subjects WHERE id='$id' ";
    $result2  =mysqli_query($conn,$sql2);
    $count2   =mysqli_num_rows($result2);
    if($count2 > 0) {
        $data=mysqli_fetch_assoc($result2);
           $class_id    = $data['class_id'];
           $subject_id    = $data['subject_id'];
    }
}


extract($_POST);
if(isset($is_submit) && $is_submit=="Y"){
    if($class_id ==""){
        $error= "Please Insert Role Name ";
    }


    if($mode=="edit"){
        $sql2     = "SELECT *  FROM class_subjects WHERE class_id = '$class_id' AND subject_id = '$subject_id' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
            if($count2 > 0) {
                $error= "Sorry ! This record is already exist.";
            } else {
                $sql1  ="UPDATE  class_subjects SET 
                class_id   ='".$class_id."',
                subject_id   ='".$subject_id."'
                 WHERE id   ='".$id."'  "; 
                $result1 =mysqli_query($conn,$sql1);
                if($result1 > 0){
                    $msg= " You have Updated  record Succesfully";
                }
            }
    }else{
        $sql2     = "SELECT *  FROM class_subjects WHERE class_id = '$class_id' AND subject_id = '$subject_id' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="INSERT INTO class_subjects(class_id,subject_id) values('$class_id','$subject_id')";
            $ok =mysqli_query($conn,$sql1);
            if($ok){
                $msg= " You have Insert record Succesfully";
            }
            else{
                $error= "There is error";
            }
        }
    } 
    

}

$sql3    = "SELECT DISTINCT * FROM classes ORDER BY class_name";
$result3  =mysqli_query($conn,$sql3);

$sql4    = "SELECT  * FROM  subjects ";
$result4  =mysqli_query($conn,$sql4);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Subjects of Classes</title>

        <?php include("css.php"); ?>

    </head>
    <body>
        <?php include("sidebar.php"); ?>
        <div class="content">
            <div>
                <h2 class="form-title">Subjects of Classes</h2>
                <?php 
                if(isset($error)){ echo $error; }
                if(isset($msg)){ echo $msg; } ?>
                <form method="post">
                    <input type="hidden" name="is_submit" value="Y">
                
                    <div class="form-group">
                        <select id="class_id" name="class_id" value="<?php if(isset($class_id)) { echo $class_id;}?>">
                            <option value=""> Select Classes</option>
                            <?php
                            $count3   =mysqli_num_rows($result3);
                            if($count3 > 0) {
                                while($data=mysqli_fetch_assoc($result3)){?>
                                    <option value="<?php echo $data['class_id']; ?>" <?php if (isset($class_id) && $class_id == $data['class_id']) { ?> selected="selected" <?php } ?>> <?php echo $data['class_name']; ?>  </option>
                            <?php
                                }
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="subject_id" name="subject_id" value="<?php if(isset($subject_id)) { echo $subject_id;}?>">
                            <option value=""> Select Subjects</option>
                            <?php
                              $count4   =mysqli_num_rows($result4);
                            if($count4 > 0) {
                                while($data1=mysqli_fetch_assoc($result4)){?>
                            
                                    <option value="<?php echo $data1['subject_id']; ?>" <?php if (isset($subject_id) && $subject_id == $data1['subject_id']) { ?> selected="selected" <?php } ?>> <?php echo $data1['subject_name']; ?>  </option>
                            <?php
                                }
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                    <input type="submit" value="Add Subjects To Class">
                    </div>
                </form>
            </div>
            <div>
                <table>
                     <thead>
                        <tr>
                            <th>S No:</th>
                            <th>Class </th>
                            <th>Subject </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.* ,b.class_name ,c.subject_name
                                FROM class_subjects a
                                INNER JOIN classes b ON a.class_id    = b.class_id
                                INNER JOIN subjects c ON a.subject_id =  c.subject_id
                                ORDER BY b.class_name";
                        $result = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($result);
                        $i = 1;
                        if($count > 0){
                            while($data = mysqli_fetch_assoc($result)){
                            $id= $data['id'];?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($data['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($data['subject_name']); ?></td>
                                <td>
                                    <a href="class_subjects.php?menu_id=<?php echo $menu_id;?>&mode=edit&id=<?php echo $id?>">Edit</a>  &nbsp;&nbsp;
                                    <a href="class_subjects.php?menu_id=<?php echo $menu_id;?>&mode=delete&id=<?php echo $id?>">Delete</a>
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
        <?php 
        include("footer.php"); ?>
        </div> 
    </body>
 </html>