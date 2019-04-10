<?php
	function users($conn){
		$sql = "SELECT * from `users`";
		
		$result = $conn->query($sql);
		$arr = array();

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
			    array_push($arr, $row);
		    }
		    echo json_encode($arr);
		} else {
		    echo "0 results";
		}
	}
	
	function withoutCard($conn, $toarr = False){
		$sql = "SELECT id, `name`, email, student_id, rfids.rfid FROM `users` LEFT JOIN `rfids` ON users.id = rfids.rfid_user WHERE rfids.rfid IS NULL";
		
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
	
	function get_value_of_var($conn, $name){
		$stmt = $conn->prepare("SELECT `value` FROM `variables` WHERE `name` = ?");
		if ($stmt === FALSE) {
			error(400, $conn, "No such variable " . $conn->error);
		}
		$stmt->bind_param("s", $name);
		$stmt->execute();
		
		$result = mysqli_stmt_get_result($stmt);//$stmt->fetch();
		$result = mysqli_fetch_array($result);
		$stmt->close();	
				
		return  ($result[0]);
	}
	
	function get_time_of_var($conn, $name){
		$stmt = $conn->prepare("SELECT `time` FROM `variables` WHERE `name` = ?");
		if ($stmt === FALSE) {
			error(400, $conn, "No such variable " . $conn->error);
		}
		$stmt->bind_param("s", $name);
		$stmt->execute();
		
		$result = mysqli_stmt_get_result($stmt);//$stmt->fetch();
		$result = mysqli_fetch_array($result);
		$stmt->close();	
				
		return  ($result[0]);
	}
	
	function set_value_of_var($conn, $name, $value){
		$stmt = $conn->prepare("UPDATE `variables` SET `value`= ? WHERE `name` = ?");
		if ($stmt === FALSE) {
			error(400, $conn, "No such variable " . $conn->error);
		}
		$stmt->bind_param("ss", $value, $name);
		$stmt->execute();
		
// 		$result = mysqli_stmt_get_result($stmt);//$stmt->fetch();
// 		$result = mysqli_fetch_array($result);
		$stmt->close();	
				
// 		return  ($result[0]);
	}
	
	function get_user_by_id($conn, $id){
		$stmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = ?");
		if ($stmt === FALSE) {
			error(400, $conn, "No such variable " . $conn->error);
		}
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$result = mysqli_stmt_get_result($stmt);//$stmt->fetch();
		$result = mysqli_fetch_array($result);
		$stmt->close();	
				
		return  ($result);
	}
?>