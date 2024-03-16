<?php
	require_once("../config.php");
	$status = $_GET['status'];
	$id = $_GET['id'];
	if($status==1){
		$updateAnn = mysqli_query($conn, "UPDATE activity SET status = 1, updationDate = CURRENT_TIMESTAMP WHERE activityID = '$id'");
		if(!$updateAnn){
			echo 	"<script>
					alert('Approval Fail!');
					location.href='actApplication.php';
					</script>";
		}
		else
			echo 	"<script>location.href='actApplication.php';</script>";
	}
	else if($status==2){
		$reason = $_POST['reason'];
		$updateAnn = mysqli_query($conn, "UPDATE activity SET status = 2, updationDate = CURRENT_TIMESTAMP, reason = '$reason' WHERE activityID = '$id'");
		if(!$updateAnn){
			echo 	"<script>
					alert('Reject Fail!');
					location.href='actApplication.php';
					</script>";
		}
		else
			echo 	"<script>location.href='actApplication.php';</script>";
	}
?>