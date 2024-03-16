<?php
	require_once("../config.php");
	include('../botID.php');
	$id = $_GET['id'];
	
	if(isset($_POST['approve'])){
		$updateAnn = mysqli_query($conn, "UPDATE announcement SET display = 1, updationDate = CURRENT_TIMESTAMP WHERE annID = '$id'");
		$get_ann = mysqli_query($conn, "SELECT announcement.*, CONCAT(fileuploaded.filePath,'/',fileuploaded.fileName) as file FROM announcement JOIN fileuploaded ON announcement.annID = fileuploaded.annID WHERE announcement.annID = '$id'");
		$ga = mysqli_fetch_assoc($get_ann);
		$text = $ga['title']."\n".$ga['text']."\nBy: ".$ga['annAuthor'];
		$file = $ga['file'];
		if(!$updateAnn){
			echo 	"<script>
					alert('Approval Fail!');
					location.href='annManage.php';
					</script>";
		}
		else{
			telegram($text, $file);
			echo 	"<script>location.href='annManage.php';</script>";
		}
	}
	
	if(isset($_POST['reject'])){
		$reason = $_POST['reason'];
		$updateAnn = mysqli_query($conn, "UPDATE announcement SET display = 2, updationDate = CURRENT_TIMESTAMP, reason = '$reason' WHERE annID = '$id'");
		if(!$updateAnn){
			echo 	"<script>
					alert('Reject Fail!');
					location.href='annManage.php';
					</script>";
		}
		else{
			echo 	"<script>location.href='annManage.php';</script>";
		}
	}
	
	if(isset($_POST['delete'])){
		$updateAnn = mysqli_query($conn, "UPDATE announcement SET display = 2, updationDate = CURRENT_TIMESTAMP, reason = 'Monthly Clearing' WHERE annID = '$id'");
		if(!$updateAnn){
			echo 	"<script>
					alert('Delete Fail!');
					location.href='annManage.php';
					</script>";
		}
		else{
			echo 	"<script>location.href='annManage.php';</script>";
		}
	}
		
?>