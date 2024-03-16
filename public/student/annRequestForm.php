<?php
  include("auth.php");
	include("../config.php");
  if(isset($_POST['submit'])){
	$matrixNo = $_SESSION['matrixNo'];
    $studName=$_SESSION['studName'];
    $title=$_POST['title'];
    $block=$_SESSION['blockID'];
    $text=mysqli_real_escape_string($conn,$_POST['content']);
    $file=$_FILES["file"]["name"]; // file name
    
    // TO-TO: validate file before upload

    if ($studName!=""&&$title!=""&&$block!=""&&$text!=""&&$file!="") {
		
		$sql_get_staff = "SELECT staffID FROM staff WHERE blockID ='$block'";
		$result_sql_get_staff = mysqli_query($conn, $sql_get_staff);
		while($getStaffID = mysqli_fetch_assoc($result_sql_get_staff))
			$staffID = $getStaffID['staffID'];
		
		$sql_submit_form = "INSERT INTO announcement(annAuthor, title, text, blockID, approveBy) VALUES('$studName', '$title', '$text', '$block', '$staffID')";
		$result_sql_submit_form = mysqli_query($conn, $sql_submit_form);
		if(!$result_sql_submit_form)
			echo "<script>alert('Fail Submit Form')</script>";
		else{
			
			$sql_get_annid = "SELECT annID FROM announcement ORDER by annID DESC LIMIT 1";
			$result_sql_get_annid = mysqli_query($conn, $sql_get_annid);
			while($getAnnID = mysqli_fetch_assoc($result_sql_get_annid))
				$annID = $getAnnID['annID'];
			
			$path = "../uploaded_files/announcement/".$annID;
			if (!file_exists($path)) {
				mkdir($path);
			}
			
			$upload_file = date("YmdHis").'_'.$_FILES['file']['name'];// correct file & filename into db
			move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
			
			$sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(annID, fileName, filePath, createdBy) VALUES('$annID', '$upload_file', '$path', '$matrixNo')");
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

				$mail->Subject = 'Announcement Request';
				// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->Body    = '<b>Dear staff of '.$_SESSION['collegeName'].' '.$block.',</b><br><br><br>Announcement request by '.$studName.'('.$matrixNo.'). The announcement:<br><br>'.$title.'<br>'.$text.'<br><br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$studName.'<br>'.$matrixNo ;
				$mail->AltBody = 'Dear staff of ['.$_SESSION['collegeName'].' '.$block.'], Announcement request by '.$studName.'('.$matrixNo.'). The announcement: '.$_POST['annText'].'(Do not reply, this is an auto generated email) --by:['.$studName.'<br>'.$matrixNo.']';

				if(!$mail->send()) {
					// echo '[Mailer] Message could not be sent.';
				  echo '<script> alert("Thank you! Your request has been successfully submitted! Your Announcement Referral Number is "+"'.$annID.'. [Mailer] Email could not be sent to staff."); window.location.href="annRequest.php";</script>';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					// echo '[Mailer] Message has been sent';
				  echo '<script> alert("Thank you! Your request has been successfully submitted! Your Announcement Referral Number is "+"'.$annID.'. [Mailer] Email has been sent to staff."); window.location.href="annRequest.php";</script>';
				}
			  }
			}
			
		}
		else
			echo '<script> alert("Failed to submit."); window.location.href="annRequest.php";</script>';
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Announcement Request Form | Student | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_ann').addClass('active');
           $('#nav_ann_req').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<form action="annRequestForm.php" name="annRequest" method="POST" enctype="multipart/form-data">
		<div class="py-4">
			<div class="d-flex flex-column " id="content">
				<nav aria-label="breadcrumb">
				  	<ol class="breadcrumb">
				    	<li class="breadcrumb-item">Announcement</li>
				    	<li class="breadcrumb-item">Announcement Request</li>
				    	<li class="breadcrumb-item active" aria-current="page">Announcement Request Form</li>
				  	</ol>
				</nav>
				<div class="d-flex">
					<div class="p-2">
						<h3>Announcement Request Form</h3>
					</div>
					<div class="p-2">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='annRequest.php'">Back</button>
					</div>
				</div>
					
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Make Announcement for Your College Mates</h3>
					</div>
					<div class="container">
	              <div class="row mb-3">
	                  <label for="Title" class="col-sm-3 form-label">Title</label>
	                  <div class="col-sm-4">
	                      <input type="text" class="form-control" name="title" id="Title" placeholder="Title" required>
	                  </div>
	              </div>
	              <div class="row mb-3">
	                  <label for="Content" class="col-sm-3 form-label">Announcement Content</label>
	                  <div class="col-sm-6">
	                      <textarea type="text" class="form-control" name="content" id="Content" placeholder="Announcement Content" maxlength="2000" rows="5" required></textarea>
	                  </div>
	              </div>
	              <div class="row mb-3">
	                <label for="file" class="col-sm-3 form-label">Upload photo</label>
	                <div class="col-sm-4">
	                    <input type="file" name="file" id="file" class="form-control" onchange="loadFile(event)" required><br>
	                    <img id="output" style="max-height: 10rem; max-width: 10rem;">
	                    <div id="preview"></div>
	                    <script>
	                        var loadFile = function(event) {
	                          var output = document.getElementById('output');
	                          output.src = URL.createObjectURL(event.target.files[0]);
	                          output.onload = function() {
	                            URL.revokeObjectURL(output.src) // free memory
	                          }
	                        };
	                    </script>
	                </div>
	              </div>
		          </div>
	      	</div>
	  	</div>
	  	<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Submit" onclick="return confirm('Are you sure you want to submit?');">
		</div><!-- py-4 -->
	</form>            
	<!--Container Main end-->

</body>
</html>