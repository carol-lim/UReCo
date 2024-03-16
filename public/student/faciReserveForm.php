<?php
	include("auth.php");
	include("../config.php");
  if(isset($_POST['submit'])){
	$matrixNo = $_SESSION['matrixNo'];
    $studName=$_SESSION['studName'];
    $facility=$_POST['facility'];
	$rawdate = htmlentities($_POST['date']);
	$date = date('Y-m-d', strtotime($rawdate));
	$start = $_POST['start'];
	$end = $_POST['end'];
    $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);
    
    // TO-TO: validate file before upload
		
		$sql_get_staff = "SELECT staffID FROM staff WHERE blockID ='".$_SESSION['blockID']."'";
		$result_sql_get_staff = mysqli_query($conn, $sql_get_staff);
		while($getStaffID = mysqli_fetch_assoc($result_sql_get_staff))
			$staffID = $getStaffID['staffID'];
		
		$sql_submit_form = "INSERT INTO reservation(facilityID, date, timeStart, timeEnd, remarks, approveBy, applicant) VALUES('$facility', '$date', '$start', '$end', '$remarks', '$staffID', '$studName')";
		$result_sql_submit_form = mysqli_query($conn, $sql_submit_form);
		if(!$result_sql_submit_form)
			echo "<script>alert('Fail Submit Form');location('faciReserve.php');</script>";
		else{	
				
				$sql_get_rid = mysqli_query($conn, "SELECT reservationID FROM reservation ORDER BY creationDate DESC LIMIT 1");
				$get_rid = mysqli_fetch_assoc($sql_get_rid);
				$rid = $get_rid['reservationID'];
				
				$sql_get_fname = mysqli_query($conn, "SELECT facilityName FROM facility WHERE facilityID ='".$facility."'");
				$get_fname = mysqli_fetch_assoc($sql_get_fname);
				$fname = $get_fname['facilityName'];
				
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

				//$mail->addAttachment($path.'/'.$upload_file);         // Add attachments
				// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Facility Reservation';
				// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->Body    = '<b>Dear staff of '.$_SESSION['collegeName'].',</b><br><br>Reservation made by '.$studName.'('.$matrixNo.') for '.$facility.' with a remarks:<br><br>'.$_POST['remarks'].'<br><br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$studName.'<br>'.$matrixNo ;
				$mail->AltBody = 'Dear staff of ['.$_SESSION['collegeName'].'], Reservation made by '.$studName.'('.$matrixNo.') for '.$facility.' with a remarks:'.$_POST['remarks'].'(Do not reply, this is an auto generated email) --by:['.$studName.'<br>'.$matrixNo.']';

				if(!$mail->send()) {
					// echo '[Mailer] Message could not be sent.';
				  echo '<script> alert("Thank you! Your request has been successfully submitted! Your Reservation Referral Number is "+"'.$rid.'. [Mailer] Email could not be sent to staff."); window.location.href="faciReserve.php";</script>';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
				} 
				else {
					// echo '[Mailer] Message has been sent';
				  echo '<script> alert("Thank you! Your request has been successfully submitted! Your Announcement Referral Number is "+"'.$rid.'. [Mailer] Email has been sent to staff."); window.location.href="faciReserve.php";</script>';
				}
			}
	}
		
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Facility Reservation Form | Student | UReCo</title>

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
				    
				today = yyyy + '-' + mm + '-' + dd;
           // tell sidebar to active current navlink
           $('#nav_faci').addClass('active');
           $('#nav_faci_reserve').addClass('active');
					 $('#ReserveDate').attr('min', today);

        });

        function validEndTime(){
        	var x = document.getElementById("TimeStart").value;
        	document.getElementById("TimeEnd").setAttribute('minTime', x);
        }
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<form action="faciReserveForm.php" name="faciReserve" method="POST" enctype="multipart/form-data">
		<div class="py-4">
			<div class="d-flex flex-column " id="content">
				<nav aria-label="">
				  	<ol class="breadcrumb">
				    	<li class="breadcrumb-item">Facility Reservation</li>
				    	<li class="breadcrumb-item">My Facility Reservation</li>
				    	<li class="breadcrumb-item active" aria-current="page">Facility Reservation Form</li>
				  	</ol>
				</nav>
				<div class="d-flex">
					<div class="p-2">
						<h3>Facility Reservation Form</h3>
					</div>
					<div class="p-2">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='faciReserve.php'">Back</button>
					</div>
				</div>
					
					<div class="rounded p-4 mb-3 bg-color">
						<div class="p-2">
	          	<h3 >Reserve your slot</h3>
	          </div>
	          <div class="container">
	              <div class="row mb-3">
	                  <label for="selectFacility" class="col-sm-4 form-label">Facility</label>
	                  <div class="col-sm-4">
	                      <select name="facility" id="selectFacility" class="form-control" >
	                        <option value="">Select Facility</option>
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
	                  <label for="ReserveDate" class="col-sm-4 form-label">Date</label>
	                  <div class="col-sm-4">
	                      <input type="date" class="form-control" name="date" id="ReserveDate" min="2021-12-12" required>
	                  </div>
	              </div>
	              <div class="row mb-3">
	                  <label for="TimeStart" class="col-sm-4 form-label">Start Time</label>
	                  <div class="col-sm-4">
	                      <input type="time" class="form-control" name="start" id="TimeStart" onchange="validEndTime();" required>
	                  </div>
	              </div>
	              <div class="row mb-3">
	                  <label for="TimeEnd" class="col-sm-4 form-label">End Time</label>
	                  <div class="col-sm-4">
	                    <input type="time" class="form-control" name="end" id="TimeEnd" minTime="05:00" maxTime="23:59" required>
	                  </div>
	              </div>
	         
	              <div class="row mb-3">
	                  <label for="textAreaRemarks" class="col-sm-4 form-label">Remarks</label>
	                  <div class="col-sm-6">
	                      <textarea type="text" class="form-control" name="remarks" id="textAreaRemarks" placeholder="You may state the number of people involved, the reason of reservation, etc." maxlength="2000" rows="5" required></textarea>
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