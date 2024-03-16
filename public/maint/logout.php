<?php
	session_start();
	unset($_SESSION['maint_id'],
		$_SESSION['maint_name'],
		$_SESSION['block_name'],
		$_SESSION['block_id'],
		$_SESSION['college_name'],
		$_SESSION['college_id'],
		$_SESSION['profilePic']);
	session_destroy(); 
	header("location: ../index.php");
?>