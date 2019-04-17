<?php
	function history($conn, $toarr = False){
		$sql = "SELECT DISTINCT(`user`), `users`.`name`, `users`.`student_id` , `validations`.`time`, `validations`.`inside`  FROM `validations` LEFT JOIN `users` ON `validations`.`user` = `users`.`id` ORDER by validations.id DESC";
		
		$result = $conn->query($sql);
		$arr = array();

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
			    array_push($arr, $row);
		    }
// 		    return $arr;
			if($toarr) return  $arr;
		    echo json_encode($arr);
		} else {
		    echo "0 results";
		}
	}
	
	
	function isOutside(){
		
	}
	
	function user_profile($conn, $id){
		$sql = "SELECT * FROM `users` where `id` = $id";
		
		$result = $conn->query($sql);
		$arr = array();

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
			    array_push($arr, $row);
		    }
// 		    return $arr;
			if($toarr) return  $arr;
		    echo json_encode($arr);
		} else {
		    echo "0 results";
		}
	}
?>