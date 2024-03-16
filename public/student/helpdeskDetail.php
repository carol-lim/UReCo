<?php
    include("auth.php");
    include("../config.php");
    $hdid=$_GET['hdid'];
    $status=$_GET['status'];
    $matrixNo=$_SESSION['matrixNo'];


    if (isset($_POST['feedback'])) {
        $sat=$_POST['satisfactory'];
        $reason=mysqli_real_escape_string($conn,$_POST['reason']);
        $file=$_FILES["file"]["name"]; // file name
        if ($sat!=""&&$reason!=""&&$file!="") {
            mysqli_query($conn,"INSERT INTO helpdesktracker(statusName, description, createdBy, hdID) VALUES('$sat','$reason' ,'$matrixNo', '$hdid')");
            
            $sql_get_status_id=mysqli_query($conn,"SELECT hdtID FROM helpdesktracker ORDER BY hdtID DESC LIMIT 1");
            $result_sql_get_status_id=mysqli_fetch_assoc($sql_get_status_id);
            $status_id =$result_sql_get_status_id['hdtID'];

            $path = "../uploaded_files/helpdesk/".$hdid;
            if (!file_exists($path)) {
                mkdir($path);
            }

            $upload_file = date("YmdHis").'_'.$_FILES["file"]["name"];// correct file & filename into db
            move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path

            //insert uploaded_file 
            //TODO control if number of file >1
            $sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(hdID, htdID, fileName, filePath, createdBy) VALUES('$hdid', '$status_id','$upload_file', '$path', '$matrixNo')");

            // mt_view: 0=MT cannot see anything, 1=MT can see but staff informed btn disabled, 2=MT can see while staff inform btn enabled.
            mysqli_query($conn, "UPDATE helpdesk SET mtView=2, mtWork=3 WHERE hdID ='$hdid'");

            $affectedRows = mysqli_affected_rows($conn);
            if($affectedRows >= 1){

                // email

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

                $mail->addAttachment($path.'/'.$upload_file);         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Feedback of Service Desk '.$hdid;
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->Body    = '<b>Dear staff and Maintenance Team of '.$_SESSION['collegeName'].' '.$_SESSION['blockName'].',</b><br><br><br>My satisfactory: '.$_POST['satisfactory'].'<br>Reason: '.$_POST['reason'].'<br><br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$_SESSION['studName'].'<br>'.$matrixNo ;
                $mail->AltBody = 'Dear staff and Maintenance Team of ['.$_SESSION['collegeName'].' '.$_SESSION['block_Name'].'], My satisfactory: '.$_POST['satisfactory'].'. Reason: '.$_POST['reason'].'(Do not reply, this is an auto generated email) --by:['.$_SESSION['studName'].'<br>'.$matrixNo.']';

                if(!$mail->send()) {
                    // echo '[Mailer] Message could not be sent.';
                  echo '<script> alert("Successfully submit feedback. The status of Service Desk "+"'.$hdid.'"+" has been updated as \""+"'.$sat.'"+"\". [Mailer] Email could not be sent to staff and Maintenance Team."); window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open";</script>';
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    // echo '[Mailer] Message has been sent';
                  echo '<script> alert("Successfully submit feedback. The status of Service Desk "+"'.$hdid.'"+" has been updated as \""+"'.$sat.'"+"\". [Mailer] Email has been sent to staff and Maintenance Team."); window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open";</script>';
                }

            }else{
                echo '<script>alert("Failed to submit feedback.");window.location.href="helpdeskTrace.php?hdid="+"'.$hdid.'"+"&status=open</script>';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("head.html");?>
    <title>Helpdesk Detail | Student | UReCo</title>

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
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Helpdesk Detail of #<?php echo htmlentities($row['hdID']);?></h3>
                </div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskTrace.php?hdid=<?php echo $hdid;?>&status=<?php echo $status?>'">Trace</button>
                    <?php if ($status == "open"){?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskCurrent.php'">Back</button>
                    <?php }else{?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskClosed.php'">Back</button>
                    <?php }?>
                </div>
            </div>
                
            <div class="rounded p-4 mb-3 bg-color">
                <div class="p-2">
                    <h3 >Progress</h3>
                </div>
                <div class="container">
                    <?php  
                        $result = mysqli_query($conn, "SELECT statusName FROM helpdesktracker WHERE hdID = '$hdid' ORDER BY creationDate DESC LIMIT 1"); 
                        $roww   = mysqli_fetch_assoc($result);
                    ?>
                    <div class="row mb-3">
                        <label for="status" class="col-sm-2 form-label">Status</label>
                        <div class="col-sm-4">
                            <p id="status" class="py-2"><?php echo htmlentities($roww['statusName']);

                        if (($roww['statusName']=="Closed"||$roww['statusName']=="closed") && $status=="open") {

                                    echo '<script>$(document).ready(function() { window.location = "http://192.168.1.11/ureco/public/student/helpdeskDetail.php?hdid="+"'.$hdid.'"+"&status=closed"; }); </script>';
                            }
                        ?></p>
                        </div>
                    </div>
                    <?php 
                        if ($roww['statusName']!="Closed"||$roww['statusName']!="closed"){ 
                            if ($row['mtWork']==2) {
                    ?>
                    <form method="POST" name="helpdesk" action="helpdeskDetail.php?hdid=<?php echo $hdid?>&status=open" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="Satisfaction" class="col-sm-2 form-label">Satisfaction</label>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#feedbackModal">Feedback</button>
                            </div>
                        </div>

                        <!-- Modal start -->
                        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                <div class="modal-body">
                                    <div class="form-group pb-2">
                                        <label for="selectSatisfactory">Satisfactory</label>
                                        <select name="satisfactory" id="selectSatisfactory" class="form-control custom-select my-1 mr-sm-2" required>
                                            <option value="">Select Satisfactory</option>
                                            <option value="Satisfied">Satisfied</option>
                                            <option value="Dissatisfied">Dissatisfied</option>
                                        </select>
                                    </div>
                                    <div class="form-group pb-2">
                                        <label for="textAreaReason">Reason</label>
                                        <textarea type="text" class="form-control" name="reason" id="textAreaReason" placeholder="Reason" maxlength="2000" rows="5" required></textarea>
                                    </div>
                                    <div class="form-group pb-2">
                                        <label for="file">Upload photo as proof</label>
                                        <input type="file" name="file" id="file" class="form-control" onchange="loadFile(event)" required><br>
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
                                    <button type="submit" name="feedback" id="feedback" class="btn btn-primary" onclick="return confirm('Are you sure about the feedback?');">Submit</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal end -->
                    </form>


                        <?php } else if ($row['mtWork']==3) {?>
                            <div class="row mb-3">
                                <label for="Satisfaction" class="col-sm-2 form-label">Satisfaction</label>
                                <div class="col-sm-4">
                                    <p>Feedback submitted</p>
                                </div>
                            </div>
                        <?php } ?>  

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
                            <p id="Subcategory" class="py-2">
                                <?php 
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
                                ?>  
                            </p>
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