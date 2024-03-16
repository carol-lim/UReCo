<?php
	session_start();
	unset($_SESSION['matrixNo'],
		$_SESSION['studName'],
		$_SESSION['roomID'],
		$_SESSION['blockID'],
		$_SESSION['blockName'],
		$_SESSION['collegeID'],		
		$_SESSION['collegeName'],
		$_SESSION['profilePic']);
	session_destroy(); 
	header("location: ../index.php");
?>