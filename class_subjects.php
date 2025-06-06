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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
<div class="col-md-12">
                <div class="form-group">
                    <div class="custom-select" style="width:200px;">
                        <select name="class_id2" id="class_id2">
                            <option value="">Select Class:</option>
                            <?php 
                            $sql11 = "SELECT 
                                        MIN(a.class_id) AS class_subject_id, -- or any other aggregate function
                                        b.class_name,
                                        MIN(c.subject_name) AS subject_name -- adjust as needed
                                        FROM class_subjects a
                                        INNER JOIN classes b ON a.class_id = b.class_id
                                        INNER JOIN subjects c ON a.subject_id = c.subject_id
                                        GROUP BY b.class_name";
                            $result11 = mysqli_query($conn,$sql11);
                            $count11 = mysqli_num_rows($result11);
                            if($count11 > 0){
                                while($data11 = mysqli_fetch_assoc($result11)){ ?>
                                    <option value="<?php echo $data11['class_subject_id']?>" <?php if(isset($class_id) && $class_id == $data11['class_subject_id']){ echo " selected "; }?> ><?php echo $data11['class_name']; ?></option>
                                <?php
                                }
                            }	
                            ?>
                        </select>
                    </div>
                    <div class="custom-select" style="width:200px;">
                        <select name="subject_id2" id="subject_id2">
                            <option value="0">Select Subject:</option>
                            <?php 
                                if(isset($class_id2)) { 
                                    // echo $class_id2 ;
                                    // die;
                                   $sql12 = "SELECT a.*,b.class_name,c.subject_name
                                        FROM class_subjects a
                                        INNER JOIN classes b ON a.class_id =b.class_id	
                                        INNER JOIN subjects c ON a.subject_id =c.subject_id 
                                        WHERE a.class_id='$class_id' ";
                                     $result12 = mysqli_query($conn,$sql12);
                                    $count12 = mysqli_num_rows($result12);
                                    if($count12 > 0) {
                                        while( $data12 = mysqli_fetch_assoc($result12)){?>
                                            <option value="<?php echo $data12['subject_id']; ?>"><?php echo $data12['subject_name']; ?></option>																
                                            <?php
                                        }																 
                                    } 
                                }?>
                        </select>
                    </div>
                    
                </div>
                
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
        <script>
	

		$(document).ready(function(){
			$('#class_id2').on('change', function() {
				data = [];
				data[0] = class_id2; // source field name
				data[1] = 'subject_id2'; // target field
				data[2] = null;
				data[3] = null;
				data[4] = null;
				generate_combo_new(data);
			});
		});


		function generate_combo_new(data) {
			source_field = data[0];
			target_field = data[1];
			other_option = data[2];
			default_value = data[3];
			other_value = data[4];

			var dataString = '';
			dataString = dataString + "source_field=" + $(source_field).attr('name') + "&" + $(source_field).attr('name') + "=" + $(source_field).val() + "";
			dataString = dataString + "&target_field=" + target_field;
			if (other_option != null) {
				dataString = dataString + "&other_option=1";
			}
			if (other_value != null) {
				dataString = dataString + "&other_value=" + other_value;
			}

			//alert(dataString);
			// extra variables for query
			if (data[4] != null) {
				for (i = 4; i < data.length; i++) {
					dataString = dataString + "&" + data[i] + "=" + $('#' + data[i] + '').val() + "";
				}
			}
			//alert(source_field);
			$.ajax({
				url: 'generate_combo.php',
				type: 'POST',
				dataType: 'json',
				data: dataString,

				success: function(result) {

					$('#' + target_field).html(""); //clear old options
					result = eval(result);
					for (i = 0; i < result.length; i++) {
						for (key in result[i]) {
							$('#' + target_field).get(0).add(new Option(result[i][key], [key]), document.all ? i : null);
						}
					}
					if (default_value != null) {
						$('#' + target_field).val(default_value); //select default value
					} else {
						$("option:first", target_field).attr("selected", "selected"); //select first option
					}

					$('#' + target_field).css("display", "inline");

				}
			});
		}

	</script>
    </body>
 </html>