<?php

require_once("config.php");
require_once("helpers.php");
	
if(isset($_GET["params"])){
	switch ($_GET["params"]){
		//API
		case "users" 		: users($conn); break;		
		case "addCard" 		: addCard($conn, $_POST); break;		
		case "enter" 		: enter($conn, (isset($_POST["rfid"]))?$_POST["rfid"]:NULL); break;
		case "create_user" 	: create_user($conn, $_POST); break;
		case "withoutCard"	: withoutCard($conn); break;

		//Pages
		case "register" : page("register.html"); break;
		case "list" 	: page("listWO.php", $conn); break;
		case "history" 	: page("history.php", $conn); break;
		case "links" 	: page("links.html"); break;
		case "stat" 	: page("stat.php", $conn); break;
		case "userslist": page("userslist.php", $conn); break;

		default : error(404, $conn, "page not found in index switch");
	}
}else{page("welcome.html");}
?>

