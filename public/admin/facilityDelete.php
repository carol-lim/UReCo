<?php
	require_once('../config.php');
		$sql = "delete from facility where facilityID = '".$_GET['id']."'";
		$result = mysqli_query($conn, $sql);
		if(!$result)
			echo "Error deleting record: " . mysqli_error($conn);
		else{
			echo "	<script> 
					alert('Record succesfully deleted!');
					location = 'facilityList.php';
					</script>";
			exit();
		}
			mysqli_close($conn);
		
?>