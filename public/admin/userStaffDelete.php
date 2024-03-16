<?php
	require_once('../config.php');
		$sql = "delete staff, user from staff inner join user on user.username = staff.staffID where staffID = '".$_GET['id']."'";
		$result = mysqli_query($conn, $sql);
		if(!$result)
			echo "Error deleting record: " . mysqli_error($conn);
		else{
			echo "	<script> 
					alert('Record succesfully deleted!');
					location = 'userStaffList.php';
					</script>";
			exit();
		}
			mysqli_close($conn);
		
?>