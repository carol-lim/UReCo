<?php
	session_start();
	unset($_SESSION['staff_id'],
		$_SESSION['staff_id'],
		$_SESSION['staff_name'],
		$_SESSION['block_name'],
		$_SESSION['block_id'],
		$_SESSION['college_name'],
		$_SESSION['college_id'],
		$_SESSION['profilePic']);
	session_destroy(); 
	header("location: ../index.php");
?>