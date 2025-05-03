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
    $sql3     = "DELETE  FROM teacher_subjects WHERE id='$id' ";
    $result3  =mysqli_query($conn,$sql3);
    if($result3 > 0) {
      $msg="This record has been deleted successfully!";
    }
}


if(isset($mode) && $mode=="edit" && isset($id)){
    $sql2     = "SELECT * FROM teacher_subjects WHERE id='$id' ";
    $result2  =mysqli_query($conn,$sql2);
    $count2   =mysqli_num_rows($result2);
    if($count2 > 0) {
        $data=mysqli_fetch_assoc($result2);
           $teacher_id    = $data['teacher_id'];
           $class_subject_id    = $data['class_subject_id'];
    }
}


extract($_POST);
if(isset($is_submit) && $is_submit=="Y"){
    if($class_subject_id ==""){
        $error= "Please Select CLass & Subject ";
    }
    if($teacher_id ==""){
        $error= "Please Select Teacher ";
    }


    if(isset($mode) && $mode=="edit"){
        $sql2     = "SELECT *  FROM teacher_subjects WHERE teacher_id = '$teacher_id' AND class_subject_id = '$class_subject_id' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="UPDATE  teacher_subjects SET 
                    teacher_id   ='".$teacher_id."',
                    class_subject_id   ='".$class_subject_id."'
                    WHERE id   ='".$id."'  ";
                
                    $result1 =mysqli_query($conn,$sql1);
                if($result1 > 0){
                    $msg= " You have Updated  record Succesfully";
                }
        }
    }else{
        $sql2     = "SELECT *  FROM teacher_subjects WHERE teacher_id = '$teacher_id' AND class_subject_id = '$class_subject_id' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="INSERT INTO teacher_subjects(teacher_id,class_subject_id) values('$teacher_id','$class_subject_id')";
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

$sql3    = "SELECT a.* ,b.class_name ,c.subject_name
            FROM class_subjects a
            INNER JOIN classes b ON a.class_id    = b.class_id
            INNER JOIN subjects c ON a.subject_id =  c.subject_id
            ORDER BY b.class_name";
$result3  =mysqli_query($conn,$sql3);

$sql4    = "SELECT  * FROM  teachers_info ";
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
                        <select id="teacher_id" name="teacher_id" value="<?php if(isset($teacher_id)) { echo $teacher_id;}?>">
                            <option value=""> Select Teacher</option>
                            <?php
                              $count4   =mysqli_num_rows($result4);
                            if($count4 > 0) {
                                while($data1=mysqli_fetch_assoc($result4)){?>
                            
                                    <option value="<?php echo $data1['teacher_id']; ?>" <?php if (isset($teacher_id) && $teacher_id == $data1['teacher_id']) { ?> selected="selected" <?php } ?>> <?php echo $data1['full_name']; ?>  </option>
                            <?php
                                }
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="class_subject_id" name="class_subject_id" value="<?php if(isset($class_subject_id)) { echo $class_subject_id;}?>">
                            <option value=""> Select Classes</option>
                            <?php
                            $count3   =mysqli_num_rows($result3);
                            if($count3 > 0) {
                                while($data=mysqli_fetch_assoc($result3)){?>
                                    <option value="<?php echo $data['id']; ?>" <?php if (isset($class_subject_id) && $class_subject_id == $data['id']) { ?> selected="selected" <?php } ?>> <?php echo $data['class_name']; ?>: <?php echo $data['subject_name']; ?> </option>
                            <?php
                                }
                            }?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                    <input type="submit" value="Add Subjects To Teacher">
                    </div>
                </form>
            </div>
            <div>
                <table>
                     <thead>
                        <tr>
                            <th>S No:</th>
                            <th>Teacher Name </th>
                            <th>Class & Subject </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.* ,b.class_name ,c.subject_name ,e.full_name
                                FROM teacher_subjects a
                                INNER JOIN teachers_info e ON a.teacher_id =  e.teacher_id
                                INNER JOIN class_subjects d ON a.class_subject_id =  d.id
                                 INNER JOIN subjects c ON d.subject_id =  c.subject_id
                                INNER JOIN classes b ON d.class_id    = b.class_id
                                ORDER BY b.class_name";
                        $result = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($result);
                        $i = 1;
                        if($count > 0){
                            while($data = mysqli_fetch_assoc($result)){
                            $id= $data['id'];?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo ($data['full_name']); ?></td>
                                <td><?php echo ($data['class_name']); ?>:<?php echo ($data['subject_name']); ?></td>
                                <td>
                                    <a href="teacher_sub.php?menu_id=<?php echo $menu_id;?>&mode=edit&id=<?php echo $id?>">Edit</a>  &nbsp;&nbsp;
                                    <a href="teacher_sub.php?menu_id=<?php echo $menu_id;?>&mode=delete&id=<?php echo $id?>">Delete</a>
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