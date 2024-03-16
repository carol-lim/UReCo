
<?php
include('../config.php');
if(!empty($_POST["subcategory_id"])) {
	$id=intval($_POST['subcategory_id']);
	if(!is_numeric($id)){
		echo htmlentities("invalid subcategory_id");
		exit;
	}else{
		$stmt = mysqli_query($conn, "SELECT avgFixDay FROM subcategory WHERE scID ='$id' AND display=1");
		while($row=mysqli_fetch_array($stmt)){
			echo htmlentities($row['avgFixDay']);
		}
	}
}
?>