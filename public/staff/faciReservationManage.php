<?php
	require_once("../config.php");
	$status = $_GET['status'];
	$id = $_GET['id'];
	if($status==1){
		$updateAnn = mysqli_query($conn, "UPDATE reservation SET status = 1, updationDate = CURRENT_TIMESTAMP WHERE reservationID = '$id'");
		if(!$updateAnn){
			echo 	"<script>
					alert('Approval Fail!');
					location.href='faciReservation.php';
					</script>";
		}
		else
			echo 	"<script>location.href='faciReservation.php';</script>";
	}
	else if($status==2){
		$reason = $_POST['reason'];
		$updateAnn = mysqli_query($conn, "UPDATE reservation SET status = 2, updationDate = CURRENT_TIMESTAMP, reason = '$reason' WHERE reservationID = '$id'");
		if(!$updateAnn){
			echo 	"<script>
					alert('Reject Fail!');
					location.href='faciReservation.php';
					</script>";
		}
		else
			echo 	"<script>location.href='faciReservation.php';</script>";
	}
?>