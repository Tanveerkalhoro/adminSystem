<?php
include("connection.php");
extract($_REQUEST);
switch ($source_field) {
	case 'class_id2':
		$sql 	= "	SELECT a.*,b.class_name,c.subject_name
                    FROM class_subjects a
                    INNER JOIN classes b ON a.class_id =b.class_id	
                    INNER JOIN subjects c ON a.subject_id =c.subject_id 
                    WHERE a.class_id='".$class_id2."' ;";
		$result	= mysqli_query($conn, $sql);
		$count	=mysqli_num_rows($result);
		if ($count > 0) {
			$array[] = array('0' => 'Select Subject');
			while ($row = mysqli_fetch_assoc($result)) {
				$array[] = array($row['subject_id'] => $row['subject_name']);
			}
		} else {
			$array[] = array('0' => 'No City');
		}
		break;	
		case 'class_id22':
			$sql 	= "	SELECT * FROM city WHERE class_id2 = '".$class_id22."' ;";
			$result	= mysqli_query($conn, $sql);
			$count	=mysqli_num_rows($result);
			if ($count > 0) {
				$array[] = array('0' => 'Select City');
				while ($row = mysqli_fetch_assoc($result)) {
					$array[] = array($row['city_id'] => $row['city_name']);
				}
			} else {
				$array[] = array('0' => 'No City');
			}
			break;	
		
}
echo json_encode($array);
