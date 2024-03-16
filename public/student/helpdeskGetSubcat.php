<?php
include('../config.php');
if(!empty($_POST["category_id"])) {
	$id=intval($_POST['category_id']);
	if(!is_numeric($id)){
		echo htmlentities("invalid category_id");
		exit;
	}else{
		$stmt = mysqli_query($conn, "SELECT scID, scName FROM subcategory WHERE categoryID ='$id' AND display=1");
?>
		<option selected="selected">Select Subcategory</option>
	<?php
		while($row=mysqli_fetch_array($stmt)){
	?>
		<option value="<?php echo htmlentities($row['scID']); ?>"><?php echo htmlentities($row['scName']); ?></option>
	<?php
		}
	}
}
?>