<?php
	function enter($conn, $rfid){
		if($rfid===NULL) error(400, $conn, "Empty RFID attempt");
		
		if(exists($conn, $rfid)){
			$rfid2 = alphanumeric($rfid);

			$num = (isInside($conn, $rfid2))?"0":"1";

			$sql = "INSERT INTO `validations`(`user`, `inside`) VALUES ((SELECT `id` from users WHERE uid = '$rfid2'), `inside` = $num)";
			
			
			if (($conn->query($sql) === TRUE)) {
				header("HTTP/1.0 200 Success");
				$arr = array("Success");
			    die(json_encode($arr));
			} else {
			    error(400, $conn, "Error adding to DB");
			}
		}else{
			error(400, $conn, "No such UID");
		}
	}
	
	function isInside($conn, $rfid){
		$sql = "SELECT `inside` FROM `validations` WHERE `user`= (SELECT `id` FROM `users` WHERE `uid` = '$rfid') AND `time` + 24*3600 > NOW() ORDER BY `id` DESC LIMIT 1";
		$result = $conn->query($sql)->fetch_assoc();
		print_r($result);
		return ($result["inside"]);

	}
	
	function exists($conn, $rfid){
		
		$stmt = $conn->prepare("SELECT * FROM `users` WHERE `uid` = ?");
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

	function inside($conn){
		$sql = "SELECT COUNT(*) as count FROM `validations` WHERE `inside`=1 AND `time`+24*3600>NOW() ";
			$result = $conn->query($sql)->fetch_assoc();				
			return  ($result["count"]);
		}
?>