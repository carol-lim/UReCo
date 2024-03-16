<?php
	// creates a session or resumes the current one
	session_start();
	date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date('Y-m-d');
    $time = date('H:i:s');
	if(!isset($_SESSION["matrixNo"])){
		header("Location: index.php");
		exit(); 
	}
?>
