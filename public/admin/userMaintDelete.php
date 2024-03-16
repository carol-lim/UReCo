<?php
	require_once('../config.php');
		$sql = "delete maintenance, user from maintenance inner join user on user.username = maintenance.maintID where maintID = '".$_GET['id']."'";
		$result = mysqli_query($conn, $sql);
		if(!$result)
			echo "Error deleting record: " . mysqli_error($conn);
		else{
			echo "	<script> 
					alert('Record succesfully deleted!');
					location = 'userMaintList.php';
					</script>";
			exit();
		}
			mysqli_close($conn);
		
?>