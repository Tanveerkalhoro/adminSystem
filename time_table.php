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
    $sql3     = "DELETE  FROM time_table WHERE id='$id' ";
    $result3  =mysqli_query($conn,$sql3);
    if($result3 > 0) {
      $msg="This record has been deleted successfully!";
    }
}


if(isset($mode) && $mode=="edit" && isset($id)){
    $sql2     = "SELECT * FROM time_table WHERE id='$id' ";
    $result2  =mysqli_query($conn,$sql2);
    $count2   =mysqli_num_rows($result2);
    if($count2 > 0) {
        $data=mysqli_fetch_assoc($result2);
           $class_subject_id    = $data['class_subject_id'];
           $day_id    = $data['day_id'];
    }
}


extract($_POST);
if(isset($is_submit) && $is_submit=="Y"){
    if($day_id ==""){
        $error= "Please Select CLass & Subject ";
    }
    if($class_subject_id ==""){
        $error= "Please Select Teacher ";
    }


    if(isset($mode) && $mode=="edit"){
        $sql2     = "SELECT *  FROM time_table WHERE class_subject_id = '$class_subject_id' AND day_id = '$day_id' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="UPDATE  time_table SET 
                        class_subject_id   ='".$class_subject_id."',
                        day_id   ='".$day_id."'
                        WHERE id   ='".$id."'  ";
                    
            $result1 =mysqli_query($conn,$sql1);
                if($result1 > 0){
                    $msg= " You have Updated  record Succesfully";
                        }
          }
    
    }else{
        $sql2     = "SELECT *  FROM time_table WHERE class_subject_id = '$class_subject_id' AND day_id = '$day_id' ";
        $result2  = mysqli_query($conn, $sql2);
        $count2  = mysqli_num_rows($result2);
        if($count2 > 0) {
            $error= "Sorry ! This record is already exist.";
        } else {
            $sql1  ="INSERT INTO time_table(class_subject_id,day_id) values('$class_subject_id','$day_id')";
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

$sql3    = "SELECT * FROM day_time ";
$result3  =mysqli_query($conn,$sql3);

$sql4    = "SELECT a.*,c.class_name,d. subject_name ,e.full_name
            FROM `teacher_subjects` a
            INNER JOIN `class_subjects` b ON a.class_subject_id =b.id
            INNER JOIN classes c ON b.class_id =c.class_id
            INNER JOIN subjects d ON b.subject_id =d.subject_id
            INNER JOIN teachers_info e ON e.teacher_id =a.teacher_id";
$result4  =mysqli_query($conn,$sql4);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Time Table</title>

        <?php include("css.php"); ?>

    </head>
    <body>
        <?php include("sidebar.php"); ?>
        <div class="content">
            <div>
                <h2 class="form-title">Time Table</h2>
                <?php 
                if(isset($error)){ echo $error; }
                if(isset($msg)){ echo $msg; } ?>
                <form method="post">
                    <input type="hidden" name="is_submit" value="Y">
                    <div class="form-group">
                        <select id="class_subject_id" name="class_subject_id" value="<?php if(isset($class_subject_id)) { echo $class_subject_id;}?>">
                            <option value=""> Select Teacher</option>
                            <?php
                              $count4   =mysqli_num_rows($result4);
                            if($count4 > 0) {
                                while($data1=mysqli_fetch_assoc($result4)){?>
                            
                            <option value="<?php echo $data1['id']; ?>" <?php if (isset($class_subject_id) && $class_subject_id == $data1['id']) { ?> selected="selected" <?php } ?>> <?php echo $data1['full_name']; ?> :<?php echo $data1['class_name']; ?>: <?php echo $data1['subject_name']; ?> </option>
                            <?php
                                }
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="day_id" name="day_id" value="<?php if(isset($day_id)) { echo $day_id;}?>">
                            <option value=""> Select Day & Time</option>
                            <?php
                            $count3   =mysqli_num_rows($result3);
                            if($count3 > 0) {
                                while($data=mysqli_fetch_assoc($result3)){?>
                                    <option value="<?php echo $data['day_id']; ?>" <?php if (isset($day_id) && $day_id == $data['day_id']) { ?> selected="selected" <?php } ?>> <?php echo $data['day']; ?>: <?php echo $data['time_start']; ?>:<?php echo $data['time_end']; ?> </option>
                            <?php
                                }
                            }?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                    <input type="submit" value="Add Time Table">
                    </div>
                </form>
            </div>
            <div>
                <table>
                     <thead>
                        <tr>
                            <th>S No:</th>
                            <th>Teacher Name </th>
                            <th>Time Table </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                         $sql = "SELECT a.* ,c.subject_name, d.class_name, f.full_name ,g.day,g.time_start,g.time_end
                        FROM `time_table` a
                        INNER JOIN teacher_subjects e ON e.id = a.class_subject_id
                        INNER JOIN teachers_info f ON f.teacher_id =  e.teacher_id
                        INNER JOIN class_subjects b ON b.id =  e.class_subject_id
                        INNER JOIN subjects c ON c.subject_id =  b.subject_id
                        INNER JOIN classes d ON b.class_id    = d.class_id
                        INNER JOIN day_time g ON a.day_id = g.day_id";
                        $result = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($result);
                        $i = 1;
                        if($count > 0){
                            while($data = mysqli_fetch_assoc($result)){
                            $id= $data['id'];?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo ($data['full_name']); ?>:<?php echo ($data['class_name']); ?>:<?php echo ($data['subject_name']); ?></td>
                                <td><?php echo ($data['day']); ?>:<?php echo ($data['time_start']); ?>:<?php echo ($data['time_end']); ?></td>
                                <td>
                                    <a href="time_table.php?menu_id=<?php echo $menu_id;?>&mode=edit&id=<?php echo $id?>">Edit</a>  &nbsp;&nbsp;
                                    <a href="time_table.php?menu_id=<?php echo $menu_id;?>&mode=delete&id=<?php echo $id?>">Delete</a>
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