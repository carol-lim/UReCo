<?php
	include("auth.php");
	include("../config.php");
  if(isset($_POST['submit'])){
	$matrixNo = $_SESSION['matrixNo'];
    $studName=$_SESSION['studName'];
	$activityName = $_POST['activityName'];
    $venue=$_POST['venue'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$file = $_FILES['file']['name'];
    
    // TO-TO: validate file before upload
		
		$sql_get_staff = "SELECT staffID FROM staff WHERE collegeID ='".$_SESSION['collegeID']."' ORDER BY RAND() LIMIT 1";
		$result_sql_get_staff = mysqli_query($conn, $sql_get_staff);
		while($getStaffID = mysqli_fetch_assoc($result_sql_get_staff))
			$staffID = $getStaffID['staffID'];
		
		$result_get_fname = mysqli_query($conn, "SELECT facilityName FROM facility WHERE collegeID = '$venue'");
		while($getFname = mysqli_fetch_assoc($result_get_fname))
			$facility = $getFname['facilityName'];
		
		$sql_submit_form = "INSERT INTO activity(name, organizer, dateStart, dateEnd, venue, approveBy) VALUES('$activityName', '$studName', '$start', '$end', '$venue', '$staffID')";
		$result_sql_submit_form = mysqli_query($conn, $sql_submit_form);
		if(!$result_sql_submit_form)
			echo "<script>alert('Fail Submit Form');location='actApplication.php';</script>";
		else{	
				
				$sql_get_aid = mysqli_query($conn, "SELECT activityID FROM activity ORDER BY creationDate DESC LIMIT 1");
				$get_aid = mysqli_fetch_assoc($sql_get_aid);
				$aid = $get_aid['activityID'];
			
				$path = "../uploaded_files/activity/".$aid;
				if (!file_exists($path)) {
					mkdir($path);
				}
				
				$upload_file = date("YmdHis").'_'.$_FILES['file']['name'];// correct file & filename into db
				move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
				
				$sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(aID, fileName, filePath, createdBy) VALUES('$aid', '$upload_file', '$path', '$matrixNo')");
				if(!$sql_uploaded_file)
					echo "<script>alert('Fail Upload File')</script>";
				else{
					
					require '../PHPMailerAutoload.php';
					require '../credential.php';

					$mail = new PHPMailer;

					// $mail->SMTPDebug = 4;                               // Enable verbose debug output

					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = EMAIL;                 // SMTP username
					$mail->Password = PASS;                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to

					$mail->setFrom(EMAIL, 'UTeM College Management System');
					// $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
					// $mail->addAddress($staff_email[]);               // Name is optional
					// $mail->addAddress($staff_email[]);               // Name is optional
					$mail->addAddress('ariefazfar.am@gmail.com');               // Name is optional
					// $mail->addReplyTo('info@example.com', 'Information');
					$mail->addReplyTo(EMAIL);
					// $mail->addCC('cc@example.com');
					// $mail->addBCC('bcc@example.com');

					$mail->addAttachment($path.'/'.$upload_file);         // Add attachments
					// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
					$mail->isHTML(true);                                  // Set email format to HTML

					$mail->Subject = 'Facility Reservation';
					// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
					$mail->Body    = '<b>Dear staff of '.$_SESSION['collegeName'].',</b><br><br>Activity application made by '.$studName.'('.$matrixNo.') and is goind to be held at '.$facility.'. Below attached the documentation for the activity.<br><br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$studName.'<br>'.$matrixNo ;
					$mail->AltBody = 'Dear staff of ['.$_SESSION['collegeName'].'], Activity application made by '.$studName.'('.$matrixNo.') and is goind to be held at '.$facility.' Below attached the documentation for the activity.(Do not reply, this is an auto generated email) --by:['.$studName.'<br>'.$matrixNo.']';

					if(!$mail->send()) {
						// echo '[Mailer] Message could not be sent.';
					  echo '<script> alert("Thank you! Your application has been successfully submitted! Your Application Referral Number is "+"'.$aid.'. [Mailer] Email could not be sent to staff."); window.location.href="actApplication.php";</script>';
						// echo 'Mailer Error: ' . $mail->ErrorInfo;
					} 
					else {
						// echo '[Mailer] Message has been sent';
					  echo '<script> alert("Thank you! Your application has been successfully submitted! Your Application Referral Number is "+"'.$aid.'. [Mailer] Email has been sent to staff."); window.location.href="actApplication.php";</script>';
					}
				}
		}
  }
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Activity Application Form | Student | UReCo</title>

	<script type="text/javascript">

        $(document).ready(function($){
	        var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth() + 1; //January is 0!
			var yyyy = today.getFullYear();

			if (dd < 10) {
			   dd = '0' + dd;
			}

			if (mm < 10) {
			   mm = '0' + mm;
			} 
			    
			today = yyyy + '-' + mm + '-' + dd + 'T00:00';
           // tell sidebar to active current navlink
           $('#nav_act').addClass('active');
           $('#nav_act_app').addClass('active');
		   $('#TimeStart').attr('min', today);
		   $('#TimeEnd').attr('min', today);

        });

        function validEndTime(){
        	var x = document.getElementById("TimeStart").value;
        	document.getElementById("TimeEnd").setAttribute('min', x);
        }
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<form action="actApplicationForm.php" name="apply" method="POST" enctype="multipart/form-data">
		<div class="py-4">
			<div class="d-flex flex-column " id="content">
				<nav aria-label="breadcrumb">
				  	<ol class="breadcrumb">
				    	<li class="breadcrumb-item">Activity Application</li>
				    	<li class="breadcrumb-item">My Activity Application</li>
				    	<li class="breadcrumb-item active" aria-current="page">Activity Application Form</li>
				  	</ol>
				</nav>
				<div class="d-flex">
					<div class="p-2">
						<h3>Activity Application Form</h3>
					</div>
					<div class="p-2">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='actApplication.php'">Back</button>
					</div>
				</div>
					
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
		          		<h3 >Apply Activity</h3>
		          	</div>
	          		<div class="container">
		              <div class="row mb-3">
		              	  <label for="ActivityName" class="col-sm-3 form-label">Activity Name</label>
		                  <div class="col-sm-4">
		                      <input type="text" class="form-control" name="activityName" id="ActivityName" placeholder="Activity Name" required>
		                  </div>
	                  </div>
	                  <div class="row mb-3">
		                  <label for="selectVenue" class="col-sm-3 form-label">Venue</label>
		                  <div class="col-sm-4">
		                      <select name="venue" id="selectVenue" class="form-control" >
		                        <option value="">Select Venue</option>
					              <?php 
					                $sql=mysqli_query($conn, "SELECT * FROM facility");
               						while ($rw=mysqli_fetch_array($sql)) {
					              ?>
					              <option value="<?php echo htmlentities($rw['facilityID']);?>"><?php echo htmlentities($rw['facilityName']);?></option>
					              <?php
					                }
					              ?>
		                      </select>
		                  </div>
		              </div>
		              <div class="row mb-3">
		                  <label for="TimeStart" class="col-sm-3 form-label">Start</label>
		                  <div class="col-sm-4">
		                      <input type="datetime-local" class="form-control" name="start" id="TimeStart" min="2021-12-12T00:00" onchange="validEndTime();" required>
		                  </div>
		              </div>
		              <div class="row mb-3">
		                  <label for="TimeEnd" class="col-sm-3 form-label">End</label>
		                  <div class="col-sm-4">
		                      <input type="datetime-local" class="form-control" name="end" id="TimeEnd" min="2021-12-12T00:00:00" required>
		                  </div>
		              </div>
		              <div class="row mb-3">
		                <label for="file" class="col-sm-3 form-label">Upload Documentation</label>
		                <div class="col-sm-4">
		                    <input type="file" name="file" id="file" class="form-control" required><br>
		              	</div>
		          	  </div>
			 	 </div>
			  </div>
	  	</div>
	  	<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" onclick="return confirm('Are you sure you want to submit?');" value="Submit">
	</div><!-- py-4 -->
  </form>            
	<!--Container Main end-->
</body>
</html>