<?php
function userlist($conn, $toarr = False){
    $sql = "SELECT * FROM `users` ORDER BY id DESC";
    
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

function uidExists($conn, $uid, $email) {
    $sql = "SELECT * FROM `users` ORDER BY id DESC where `uid`='$uid' or `email`='$email'";
		
    $result = $conn->query($sql);

    return ($result->num_rows);
}
?>