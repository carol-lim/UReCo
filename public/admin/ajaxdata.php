<?php 
include_once '../config.php';

if (isset($_POST['college_id'])) {
	$sql = "SELECT * FROM block where collegeID='".$_POST['college_id']."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0 ) {
			echo '<option value="">Select Block</option>';
		 while ($row = mysqli_fetch_assoc($result)) {
				echo '<option value='.$row['blockID'].'>'.$row['blockName'].'</option>';
		 }
	}else{

		echo '<option>No Block Found!</option>';
	}

}
elseif (isset($_POST['block_id'])) {
	 

	$sql = "SELECT * FROM room where blockID='".$_POST['block_id']."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0 ) {
			echo '<option value="">Select Room</option>';
		 while ($row = mysqli_fetch_assoc($result)) {
				echo '<option value='.$row['roomID'].'>'.$row['roomID'].'</option>';
		 }
	}else{

		echo '<option>No Room Found!</option>';
	}

}


?>