<?php

$Debug = True;
if(strpos(__DIR__, "/Users/assetmalik/") === FALSE) $Debug = False;

if($Debug){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}	
	
$servername = "localhost";
$username = "p-134_fablab";
$password = "t^8B0v0u";
$dbname = "p-13462_fablab";

if($Debug){
	$username = "root";
	$password = "root";
	$dbname = "fablabRFID";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once("api/enter.php");
require_once("api/users.php");
require_once("api/user.php");
require_once("api/daneker.php");
require_once("api/asset.php");


	
?>