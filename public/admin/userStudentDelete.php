<?php
	require_once('../config.php');
		$sql = "delete student, user from student inner join user on user.username = student.matrixNo where matrixNo = '".$_GET['matrixNo']."'";
		$result = mysqli_query($conn, $sql);
		if(!$result)
			echo "Error deleting record: " . mysqli_error($conn);
		else{
			echo "	<script> 
					alert('Record succesfully deleted!');
					location = 'userStudentSearch.php';
					</script>";
			exit();
		}
			mysqli_close($conn);
		
?>