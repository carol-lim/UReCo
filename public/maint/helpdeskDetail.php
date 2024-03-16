<?php
    include("auth.php");
    include("../config.php");
    $maint_id=$_SESSION['maint_id'];
    $hdid=$_GET['hdid'];
    $status=$_GET['status'];
    //TODO toggle off upload
    if (isset($_POST['working'])) {
        $file1=$_FILES["file1"]["name"]; // file name
        if ($file1!="") {

            // mt-work: 0=working on it btn, 1=done btn, 2=waiting feedback & stud feedback btn, 3=waiting feedback & stud fb btn disabled
            mysqli_query($conn, "UPDATE helpdesk SET mtWork=1 WHERE hdID='$hdid'");

            //insert new status
            mysqli_query($conn, "INSERT INTO helpdesktracker(statusName, description, createdBy, hdID) VALUES('Working on It','Maintenance Team is working on the problem, please be patient.' ,'$maint_id', '$hdid')");

            //get status id
            $sql_get_status_id=mysqli_query($conn, "SELECT hdtID FROM helpdesktracker ORDER BY hdtID DESC LIMIT 1");
            $result_sql_get_status_id=mysqli_fetch_assoc($sql_get_status_id);
            $status_id =$result_sql_get_status_id['hdtID'];

            $path = "../uploaded_files/helpdesk/".$hdid;
            if (!file_exists($path)) {
                mkdir($path);
            }

            $upload_file1 = date("YmdHis").'_'.$_FILES["file1"]["name"];// correct file & filename into db
            move_uploaded_file($_FILES["file1"]["tmp_name"], $path.'/'.$upload_file1); //current file, datetime_name into $path

            //insert uploaded_file 
            //TODO control if number of file >1
            $sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(hdID, hdtID, fileName, filePath, createdBy) VALUES('$hdid', '$status_id','$upload_file1', '$path', '$maint_id')");

            $affectedRows = mysqli_affected_rows($conn);
            if($affectedRows >= 1){

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

                $mail->setFrom(EMAIL, 'UTeM Hostel Management System');
                // $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                // $mail->addAddress($staff_email[]);               // Name is optional
                // $mail->addAddress($staff_email[]);               // Name is optional
                $mail->addAddress('ariefazfar.am@gmail.com');               // Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                $mail->addReplyTo(EMAIL);
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                $mail->addAttachment($path.'/'.$upload_file1);         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Working on Helpdesk '.$hdid;
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->Body    = '<b>Dear student,</b><br><br><br>I am working on the Helpdesk '.$hdid.'. Please be patient.<br>Thank you.<br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$_SESSION['maint_name'].'<br>'.$worker_id.'<br>Maintenance Team Worker<br>' .$_SESSION['college_name'].' '.$_SESSION['block_name'];
                $mail->AltBody ='Dear student, I am working on the Helpdesk '.$hdid.'. Please be patient.    (Do not reply, this is an auto generated email) --by:['.$_SESSION['maint_name'].' '.$maint_id.']'.' Maintenance Team Worker of '.$_SESSION['college_name'].' '.$_SESSION['block_name'];

                if(!$mail->send()) { 
                    echo '<script>alert("Successfully uploaded picture before fix. The status of Helpdesk "+"'.$hdid.'"+" has been updated as \"Working on It.\". Please update again when done fixing. [Mailer] Email could not be sent to student.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open"</script>';
                    
                    } else {
                    echo '<script>alert("Successfully uploaded picture before fix. The status of Helpdesk "+"'.$hdid.'"+" has been updated as \"Working on It.\". Please update again when done fixing. [Mailer] Email has been sent to student.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open"</script>';
                      
                    }

            }else{
                echo '<script>alert("Failed to upload picture before fix or update status.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open</script>';
            }

        }
    }

    if (isset($_POST['done'])) {
        $file2=$_FILES["file2"]["name"]; // file name
        if ($file2!="") {
            // mt-work: 0=working on it btn, 1=done btn, 2=waiting feedback
            mysqli_query($conn, "UPDATE helpdesk SET mtWork=2 WHERE hdID='$hdid'");

            //insert new status
            mysqli_query($conn, "INSERT INTO helpdesktracker(statusName, description, createdBy, hdID) VALUES('Done, feedback needed','Maintenance Team has fixed the problem, student please provide feedback.','$maint_id', '$hdid')");

            //get status id
            $sql_get_status_id=mysqli_query($conn, "SELECT hdtID FROM helpdesktracker ORDER BY hdtID DESC LIMIT 1");
            $result_sql_get_status_id=mysqli_fetch_assoc($sql_get_status_id);
            $status_id =$result_sql_get_status_id['hdtID'];


            $path = "../uploaded_files/helpdesk/".$hdid;
            if (!file_exists($path)) {
                mkdir($path);
            }

            $upload_file2 = date("YmdHis").'_'.$_FILES["file2"]["name"];// correct file & filename into db
            move_uploaded_file($_FILES["file2"]["tmp_name"], $path.'/'.$upload_file2); //current file, datetime_name into $path

            //insert uploaded_file 
            //TODO control if number of file >1
            $sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(hdID, hdtID, fileName, filePath, createdBy) VALUES('$hdid', '$status_id','$upload_file2', '$path', '$maint_id')");

            $affectedRows = mysqli_affected_rows($conn);

            if($affectedRows >= 1){
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

                $mail->setFrom(EMAIL, 'UTeM Hostel Management System');
                // $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                // $mail->addAddress($staff_email[]);               // Name is optional
                // $mail->addAddress($staff_email[]);               // Name is optional
                $mail->addAddress('ariefazfar.am@gmail.com');               // Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                $mail->addReplyTo(EMAIL);
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                $mail->addAttachment($path.'/'.$upload_file2);         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Done working on Helpdesk '.$hdid.'. Feedback needed.';
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->Body    = '<b>Dear student,</b><br><br><br>I have done working on the Helpdesk '.$hdid.'. Please provide your feedback.<br>Thank you.<br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$_SESSION['maint_name'].'<br>'.$maint_id.'<br>Maintenance Team Worker<br>' .$_SESSION['college_name'].' '.$_SESSION['block_name'];
                $mail->AltBody ='Dear student, I have done working on the Helpdesk '.$hdid.'. Please provide your feedback.    (Do not reply, this is an auto generated email) --by:['.$_SESSION['maint_name'].' '.$maint_id.']'.' Maintenance Team Worker of'.$_SESSION['college_name'].' '.$_SESSION['block_name'];

                if(!$mail->send()) { 
                    echo '<script>alert("Successfully uploaded picture after fix. The status of Service Helpdesk "+"'.$hdid.'"+" has been updated as \"Done, feedback needed.\" [Mailer] Email could not be sent to student.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open"</script>';
                    
                    } else {
                    echo '<script>alert("Successfully uploaded picture after fix. The status of Helpdesk "+"'.$hdid.'"+" has been updated as \"Done, feedback needed.\" [Mailer] Email has been sent to student.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open"</script>';
                      
                    }
            }else{
                echo '<script>alert("Failed to upload picture after fix or update status.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open</script>';
            }

        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("head.html");?>
    <title>Helpdesk Detail | Maintenance Team | UReCo</title>

    <script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_current').addClass('active');
        });

    </script>
</head>
<body id="body-pd">
    <?php include("sidebar.html");?>
    <div class="py-4">

        <div class="d-flex flex-column " id="content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Maintenance Helpdesk</li>
                    <?php if ($status == "open"){?>
                    <li class="breadcrumb-item">Current Helpdesk</li>
                    <?php }else{?>
                    <li class="breadcrumb-item">Closed Helpdesk</li>
                    <?php }?>
                    <li class="breadcrumb-item active" aria-current="page">Helpdesk Detail</li>
                </ol>
            </nav>
            
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Helpdesk <?php echo htmlentities($hdid);?></h3>
                </div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskTrace.php?hdid=<?php echo $hdid;?>&status=<?php echo $status?>'">Trace</button>
                    <?php if ($status == "open"){?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskManage.php'">Back</button>
                    <?php }else{?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskClosed.php'">Back</button>
                    <?php }?>
                </div>
            </div>
            <?php
                $query=mysqli_query($conn, "
                    SELECT helpdesk.*, student.* , category.categoryName, subcategory.scName 
                    FROM helpdesk 
                    JOIN student ON helpdesk.matrixNo = student.matrixNo
                    JOIN category ON helpdesk.category = category.categoryID
                    JOIN subcategory ON helpdesk.subcategory = subcategory.scID
                    WHERE helpdesk.hdID='$hdid'");
                while($row=mysqli_fetch_array($query)){
            ?>
			<div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Student</h3>
                </div>
                <div class="container">
                    <div class="row mb-3">
                        <label for="matric_num" class="col-sm-2 form-label">Matric Number</label>
                        <div class="col-sm-4">
                            <p id="matric_num" class="py-2"><?php echo htmlentities($row['matrixNo']);?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 form-label">Student Name</label>
                        <div class="col-sm-4">
                            <p id="name" class="py-2"><?php echo htmlentities($row['studName']);?></p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Progress</h3>
                </div>
                <?php  
                    $result = mysqli_query($conn, "SELECT statusName FROM helpdesktracker WHERE hdID = '$hdid' ORDER BY creationDate DESC LIMIT 1"); 
                    $roww   = mysqli_fetch_assoc($result);
                ?>
                <div class="container">
                    <div class="row mb-3">
                        <label for="status" class="col-sm-2 form-label">Status</label>
                        <div class="col-sm-4">
                            <p id="status" class="py-2"><?php echo htmlentities($roww['statusName']);

                                if (($roww['statusName']=="Closed"||$roww['statusName']=="closed") && $status=="open") {

                                    echo '<script>$(document).ready(function() { window.location = "http://192.168.1.11/ureco/public/maint/helpdeskDetail.php?hdid="+"'.$hdid.'"+"&status=closed"; }); </script>';
                                }?>
                            </p>
                        </div>
                    </div>
                <?php if ($roww['statusName']!="Closed"||$roww['statusName']!="closed") { ?>
                    <form method="POST" name="helpdesk" action="helpdeskDetail.php?hdid=<?php echo $hdid?>&status=open" enctype="multipart/form-data">

                        <?php if ($row['mtWork']==0) {?>
                        <div class="row mb-3">
                            <label for="Action" class="col-sm-2 form-label">Action</label>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#workingModal">Working on It</button>
                            </div>
                        </div>
                        <!-- Modal working start -->
                        <div class="modal fade" id="workingModal" tabindex="-1" aria-labelledby="workingTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="workingTitle">Before working on it</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="form-group">
                                            <label for="file1">Upload photo as proof</label>
                                            <input type="file" name="file1" id="file1" class="form-control" onchange="loadFile(event)" required><br>
                                            <img id="output" style="max-height: 10rem; max-width: 10rem;">
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="working" id="working" class="btn btn-primary" onclick="return confirm('Are you sure you are working on it?');">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal working end-->

                        <?php }else if ($row['mtWork']==1) {?>
                        <div class="row mb-3">
                            <label for="Action" class="col-sm-2 form-label">Action</label>
                            <div class="col-sm-4">
                                 <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#doneModal">Done Fixing</button>
                            </div>
                        </div>

                        <!-- Modal Done start -->
                        <div class="modal fade" id="doneModal" tabindex="-1" aria-labelledby="doneTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="doneTitle">Done Fixing</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="form-group">
                                            <label for="file1">Upload photo as proof</label>
                                            <input type="file" name="file2" id="file2" class="form-control" onchange="loadFile(event)" required><br>
                                            <img id="output" style="max-height: 10rem; max-width: 10rem;">
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="done" id="working" class="btn btn-primary" onclick="return confirm('Are you sure you have done fixing?');">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Done end -->

                    </form>
                        <?php } else if($row['mtWork']==2){ ?>   
                            <div class="row mb-3">
                                <label for="Action" class="col-sm-2 form-label">Action</label>
                                <div class="col-sm-4">
                                    <p>Waiting Feedback</p>
                                </div>
                            </div>
                        <?php } else if($row['mtWork']==3){ ?>  
                            <div class="row mb-3">
                                <label for="Action" class="col-sm-2 form-label">Action</label>
                                <div class="col-sm-4">
                                    <p>Feedback Provided</p>
                                </div>
                            </div>
                        <?php }?>

                <?php } ?>  
                </div>
            </div>
            <div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Photos</h3>
                </div>
                <div class="container w-50">
                    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                      <div class="carousel-indicators">
					  <?php
						$get_img = mysqli_query($conn, "SELECT * FROM fileuploaded WHERE hdID = '$hdid' ORDER BY hdtID ASC");
						$get_img1 = mysqli_query($conn, "SELECT * FROM fileuploaded WHERE hdID = '$hdid' ORDER BY hdtID ASC");
						$count1 = 0;
						$count2 = 0;
						while($rowInd = mysqli_fetch_array($get_img)){ 
							if($count1 == 0){ ?>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
					  <?php $count1 = $count1 + 1;}
							else{ ?>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?php echo htmlentities($count1); ?>" aria-label="Slide <?php echo htmlentities($count1+1); ?>"></button>
							<?php $count1 = $count1 + 1;}
						}							?>
                      </div>
                      <div class="carousel-inner">
					  <?php while($rowImg = mysqli_fetch_array($get_img1)){
						  if($count2 == 0){ ?>
                        <div class="carousel-item active" data-bs-interval="5000">
                          <img src="<?php echo htmlentities($rowImg['filePath']); ?>/<?php echo htmlentities($rowImg['fileName']); ?>" class="d-block w-100" alt="<?php echo htmlentities($rowImg['fileName']); ?>">
                          <div class="carousel-caption d-none d-md-block">
                            <h5></h5>
                            <p></p>
                          </div>
                        </div>
					  <?php $count2 = $count2 + 1;}
						else{ ?>
                        <div class="carousel-item" data-bs-interval="2000">
                          <img src="<?php echo htmlentities($rowImg['filePath']);?>/<?php echo htmlentities($rowImg['fileName']);?>" class="d-block w-100" alt="<?php echo htmlentities($rowImg['fileName']);?>">
                          <div class="carousel-caption d-none d-md-block">
                            <h5></h5>
                            <p></p>
                          </div>
                        </div>
						<?php }
					  }						?>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                    </div>                   
                </div>
            </div>
            <div class="rounded p-4 mb-3 bg-color">
                    <div class="p-2">
                        <h3 >Description</h3>
                    </div>
                <div class="container">
                    <div class="col-sm-12">
                        <p id="Description" class="py-2"><?php echo htmlentities($row['description']);?></p>
                    </div>
                </div>
            </div>    
            <div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Category</h3>
                </div>
                <div class="container">
                    <div class="row mb-3">
                        <label for="Category" class="col-sm-2 form-label">Category</label>
                        <div class="col-sm-4">
                            <p id="Category" class="py-2"><?php echo htmlentities($row['categoryName']);?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="Subcategory" class="col-sm-2 form-label">Subcategory</label>
                        <div class="col-sm-4">
                            <p id="Subcategory" class="py-2"><?php echo htmlentities($row['scName']);?></p>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Time span</h3>
                </div>
                <div class="container">
                    <div class="row mb-3">
                        <label for="Category" class="col-sm-2 form-label">Open at </label>
                        <div class="col-sm-4">
                            <p id="Category" class="py-2"><?php echo htmlentities($row['openDate']);?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="Subcategory" class="col-sm-2 form-label">Due at</label>
                        <div class="col-sm-4">
                            <p id="Subcategory" class="py-2"><?php 
                            $days=$row['daysNeed'];
                            if($days==""){
                                echo htmlentities("");  
                            }
                            else{
                                $date= date_create($row['openDate']);
                                date_add($date, date_interval_create_from_date_string($days.' days'));
                                $duedate=date_format($date, 'Y-m-d H:i:s');
                                echo htmlentities($duedate);
                            }
                            ?>  </p>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label for="Subcategory" class="col-sm-2 form-label">Closed at</label>
                        <div class="col-sm-4">
                            <p id="Subcategory" class="py-2"><?php echo htmlentities($row['closeDate']);?></p>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label for="Subcategory" class="col-sm-2 form-label">Day(s) expected</label>
                        <div class="col-sm-4">
                            <p id="Subcategory" class="py-2"><?php echo htmlentities($row['daysNeed']);?></p>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label for="Subcategory" class="col-sm-2 form-label">Day(s) used</label>
                        <div class="col-sm-4">
                            <p id="Subcategory" class="py-2"><?php echo htmlentities($row['daysUsed']);?></p>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Person In Charge</h3>
                </div>
                <div class="container">
                    <div class="row mb-3">
                        <label for="staff" class="col-sm-2 form-label">Staff</label>
                        <div class="col-sm-4">
                            <?php 	$get_staff = mysqli_query($conn, "SELECT helpdesktracker.createdBy, staff.staffName FROM helpdesktracker JOIN staff ON helpdesktracker.createdBy = staff.staffID WHERE hdID='$hdid' AND createdBy LIKE 'S%' LIMIT 1");
									$rowStaff = mysqli_fetch_assoc($get_staff);?>
                            <p id="staff" class="py-2"><?php if(mysqli_num_rows($get_staff)>0){echo htmlentities($rowStaff['staffName']);}else{echo htmlentities('-');}?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="mt" class="col-sm-2 form-label">Maint Team</label>
                        <div class="col-sm-4">
                           <?php 	$get_maint = mysqli_query($conn, "SELECT helpdesktracker.createdBy, maintenance.maintName FROM helpdesktracker JOIN maintenance ON helpdesktracker.createdBy = maintenance.maintID WHERE hdID='$hdid' AND createdBy LIKE 'M%' LIMIT 1");
									$rowMaint = mysqli_fetch_assoc($get_maint);?>
							<p id="mt" class="py-2"><?php if(mysqli_num_rows($get_maint)>0){echo htmlentities($rowMaint['maintName']);}else{echo htmlentities('-');}?></p>
                        </div>
                    </div>
                </div>
            </div> 
            <?php } ?>  

        </div>
    </div>

    <!--Container Main end-->
</body>
</html>