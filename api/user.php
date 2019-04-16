<?php
	function create_user($conn, $raw){
		
// 		print_r($raw);
// 		echo "*".$raw["email"]."*";
		
		if(empty($raw) || $raw==NULL || $raw == "") error(400, $conn, "Empty create_user");
		
// 		$data = alphanumeric($rfid);
// 		$sql = "INSERT INTO `validations` (`name`, `student_id`) VALUES ('$rfid2', CURRENT_TIMESTAMP)";
		$stmt = $conn->prepare("INSERT INTO users (`name`, `student_id`, `email`, 'uid') VALUES (?, ?, ?, ?)");
		if ($stmt === FALSE) {
			error(400, $conn, "Mysql Error: " . $conn->error);
		}
		$stmt->bind_param("sss", $name, $student_id, $email, $uid);
		
		$name = $raw["name"];
		$student_id = $raw["student_id"];
		$email = $raw["email"];
		$uid = $raw["uid"];
		
		$stmt->execute();
		
		$last_id = $conn->insert_id;
// 		echo "<h1>".$last_id."</h1>";
		set_value_of_var($conn, "last_to_reg", $last_id);
		
		success();
		
		$stmt->close();
	}
	
	function addCard($conn, $raw){
		if(empty($raw) || $raw==NULL || $raw == "") error(400, $conn, "Empty addCard");
		
		$card = $raw["rfid"];
		$user_id = $raw["user_id"];
		
		if(exists($conn, $card)){
			error(400, $conn, "Card duplicate error");
		}else{
			
			$stmt = $conn->prepare("INSERT INTO rfids (`rfid_user`, `rfid`) VALUES (?, ?)");
			if ($stmt === FALSE) {
				error(400, $conn, "Mysql Error: " . $conn->error);
			}
			$stmt->bind_param("is", $user_id, $card);
			$stmt->execute();
			
			success();
			
			$stmt->close();		
			
		}
	}
?>