<?php
	function enter($conn, $rfid){
		if($rfid===NULL) error(400, $conn, "Empty RFID attempt");
		
		if(exists($conn, $rfid)){
			$rfid2 = alphanumeric($rfid);
			$sql = "INSERT INTO `validations` (`rfid`, `time`) VALUES ('$rfid2', CURRENT_TIMESTAMP)";
			
			if (($conn->query($sql) === TRUE)) {
				header("HTTP/1.0 200 Success");
				$arr = array("Success");
			    die(json_encode($arr));
			} else {
			    error(400, $conn, "Error adding to DB");
			}
		}else{
			$value = get_value_of_var($conn, "last_to_reg");
			$time  = get_time_of_var($conn, "last_to_reg");
			if($value==NULL) error(400, $conn, "No rfid");
			if(time()-strtotime($time)>180) error(400, $conn, "RFID timeout");
			$arr = array(
				"rfid"	=> $rfid,
				"user_id" => $value
			);
			set_value_of_var($conn, "last_to_reg", NULL);
			addCard($conn, $arr);
		}
	}
	
	function exists($conn, $rfid){
		
		$stmt = $conn->prepare("SELECT * FROM `rfids` WHERE `rfid` = ?");
		if ($stmt === FALSE) {
			error(400, $conn, "Mysql Error on RFID exists: " . $conn->error);
		}
		$stmt->bind_param("s", $rfid);
		$stmt->execute();
		
		$result = $stmt->fetch();
		$stmt->close();	
				
		return  ($result);
	}
	
	function overall($conn){
		$sql = "SELECT COUNT(`id`) as `count` FROM `validations` WHERE 1";
		$result = $conn->query($sql)->fetch_assoc();
				
		return  ($result);
	}

?>