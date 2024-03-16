<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
   <title>Login | UReCo</title>
   <link rel="stylesheet" type="text/css" href="../css/login.css">
   <!-- favicon -->
   <link rel="shortcut icon" type="image/png" href="../asset/favicon-32x32.png">   
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body style="background-image: url(../asset/satriablurred.jpg);background-size:cover">
   <div class="container">
      <header>UReCo</header>
      <h2>Forgot your password?</h2>
      <br>
      <p>No worries! Enter your username, we'll send you an email.</p>
      <form method="POST" name="forget" action="forgetPass.php">
         <div class="input-field">
            <input type="text" name="username" required>
            <label>Username</label>
         </div>
         <div class="button">
            <div class="inner"></div>
            <button type="submit" name="forget">Send Request</button>
         </div>
         <div>
               <a href="index.php" class="pass-link">Back to Login</a>
         </div>
      </form>
   </div>
</body>
</html>

<?php
	// connect to db
	require_once 'config.php';

	// if submit button is clicked
	if (isset($_POST['forget'])){
		// assign variables that post from login form
		$id  = $_POST['username'];
		// prepare SQL query
		//$sql = "SELECT stud_name, matric_num, password, student.room_bed_id as room, room_bed.block_id as bid, block.area_id as aid, block_name, area_name FROM student JOIN room_bed ON student.room_bed_id = room_bed.room_bed_id JOIN block ON room_bed.block_id=block.block_id JOIN area ON block.area_id=area.area_id WHERE matric_num = '$id'";
		$sql = "SELECT password, accType FROM user WHERE username = '$id'";
		// connect query to db
		$result = mysqli_query($conn, $sql);
		// store number of row of the result returned
		$row 	= mysqli_num_rows($result);
		// store result of SQL query
		$roww 	= mysqli_fetch_assoc($result);
		$accType = $roww['accType'];
		if($row == 0){
			echo "	<script>
						alert('Invalid Matric Number')
						location = 'forgetPass.php'
					</script>";
			exit();
		}
		//check account type
		if(($accType == 1)){
			//prepare SQL query for student
			$sqls = "SELECT studName, studEmail FROM student WHERE matrixNo = '$id'";
			$results = mysqli_query($conn, $sqls);
			$rows = mysqli_fetch_assoc($results);
			//assign data to variables
			$stud_name = $rows['studName'];
			$stud_email = $rows['studEmail'];
			// check number of row of the result returned
			// return 0 row: the entered staff_id does not match database 
			if ($row == 0) {
			// show alert then redirect to login form
			echo "	<script>
						alert('Invalid Matric Number')
						location = 'forgetPass.php'
					</script>";
			exit();
			}
			else{
				require 'PHPMailerAutoload.php';
				require 'credential.php';

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

				$mail->Subject = 'Password Reset';
				// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->Body    = '<b>Dear '.$stud_name.',</b><br><br><br>Click the link below to reset your password:<br>http://192.168.1.11/urecolatest/public/reset_pass.php?id='.$id.'<br><br><br><small>Do not reply, this is an auto generated email.</small>';
				$mail->AltBody = 'Dear  ['.$stud_name.'], Click the link below to reset your password. (Do not reply, this is an auto generated email)';

				if(!$mail->send()) {
					// echo '[Mailer] Message could not be sent.';
				  echo '<script> alert("Failed to send email. Try Again."); window.location.href="forgetPass.php";</script>';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					// echo '[Mailer] Message has been sent';
				  echo '<script> alert("A link to reset your password has been sent to your email."); window.location.href="index.php";</script>';
				}
			};	
		}
		else if($accType == 2){
			$sqlStaff = "SELECT staffName, staffEmail FROM staff WHERE staffID = '$id'";
			$resultStaff = mysqli_query($conn, $sqlStaff);
			$rowStaff = mysqli_fetch_assoc($resultStaff);
			$staff_email = $rowStaff['staffEmail'];
			$staff_name = $rowStaff['staffName'];
			
			if ($row == 0) {
			// show alert then redirect to login form
			echo "	<script>
						alert('Invalid Staff ID')
						location = 'forgetPass.php'
					</script>";
			exit();
			}
			
			else{
				require 'PHPMailerAutoload.php';
				require 'credential.php';

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

				$mail->Subject = 'Password Reset';
				// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->Body    = '<b>Dear '.$staff_name.',</b><br><br><br>Click the link below to reset your password:<br>http://192.168.1.11/UReCo/reset_pass.php?id='.$id.'<br><br><br><small>Do not reply, this is an auto generated email.</small>';
				$mail->AltBody = 'Dear  ['.$staff_name.'], Click the link below to reset your password. (Do not reply, this is an auto generated email)';

				if(!$mail->send()) {
					// echo '[Mailer] Message could not be sent.';
				  echo '<script> alert("Failed to send email. Try Again."); window.location.href="forgetPass.php";</script>';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					// echo '[Mailer] Message has been sent';
				  echo '<script> alert("A link to reset your password has been sent to your email."); window.location.href="index.php";</script>';
				}
			};
		}
		else if($accType == 3){
			$sqlMaint = "SELECT maintName, maintEmail FROM maintenance WHERE maintID = '$id'";
			$resultMaint = mysqli_query($conn, $sqlMaint);
			$rowMaint = mysqli_fetch_assoc($resultMaint);
			$maint_email = $rowMaint['maintEmail'];
			$maint_name = $rowMaint['maintName'];
			
			if ($row == 0) {
			// show alert then redirect to login form
			echo "	<script>
						alert('Invalid Staff ID')
						location = 'forgetPass.php'
					</script>";
			exit();
			}
			else{
				require 'PHPMailerAutoload.php';
				require 'credential.php';

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

				$mail->Subject = 'Password Reset';
				// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->Body    = '<b>Dear '.$maint_name.',</b><br><br><br>Click the link below to reset your password:<br>http://192.168.1.11/UReCo/reset_pass.php?id='.$id.'<br><br><br><small>Do not reply, this is an auto generated email.</small>';
				$mail->AltBody = 'Dear  ['.$maint_name.'], Click the link below to reset your password. (Do not reply, this is an auto generated email)';

				if(!$mail->send()) {
					// echo '[Mailer] Message could not be sent.';
				  echo '<script> alert("Failed to send email. Try Again."); window.location.href="forgetPass.php";</script>';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					// echo '[Mailer] Message has been sent';
				  echo '<script> alert("A link to reset your password has been sent to your email."); window.location.href="index.php";</script>';
				}
			};
		}
	}
?>