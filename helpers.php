<?php
	
$ROOT = dirname(__FILE__);	
$path = $_SERVER['DOCUMENT_ROOT'];

function redirect($route) {
	header("Location: ".$ROOT.'/'.$route);
	die();
}

function page($name, $conn = NULL){
	require_once("pages/head.html");
	require_once("pages/".$name);
	require_once("pages/bottom.html");
}

function error($code, $conn, $log = NULL){
	$description = '';
	switch($code){
		case 400: $description = "Bad Request Error"; break;
		case 404: $description = "Not Found"; break;
	}
	header("HTTP/1.0 $code $description");
	$arr = array($code, $description);
	$stmt = $conn->prepare("INSERT INTO error_logs (`report`, `code`, `location`) VALUES (?, ?, ?)");
	if ($stmt === FALSE) {
	    die ("Mysql Error: " . $conn->error);
	}
	$stmt->bind_param("sis", $log, $code, $location);
	$location = $_SERVER['REQUEST_URI'];
	$stmt->execute();
	$stmt->close();
	die(json_encode($arr));
}

function alphanumeric($raw){
	return preg_replace("/[^a-zA-Z0-9]+/", "", $raw);
}

function success(){
	header("HTTP/1.0 200 Success");
	$arr = array("Success");
    die(json_encode($arr));
}


?>