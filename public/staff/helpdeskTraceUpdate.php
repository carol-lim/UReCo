<?php
    include("auth.php");
    include("../config.php");
    $staff_id=$_SESSION['staff_id'];
    $hdid = $_GET['hdid'];
    $currentTime=date('Y-m-d H:i:s');
    $status=$_GET['status'];
    
    if(isset($_POST['submit'])){
        $status_name=$_POST['status'];
        $description=mysqli_real_escape_string($conn,$_POST['description']);

        if($status_name!="" && $description!="" && $hdid!=""){
            if($status_name=="Closed"||$status_name=="closed"){
                $close=mysqli_query($conn, "UPDATE helpdesk SET closeDate = '$currentTime', daysUsed = DATEDIFF(closeDate, openDate)+1 WHERE hdID='$hdid'");
            }

            $sql=mysqli_query($conn, "INSERT INTO helpdesktracker(statusName, description, createdBy, hdID) VALUES('$status_name','$description','$staff_id', '$hdid')");
                

                require '../PHPMailerAutoload.php';
                require '../credential.php';

                $mail = new PHPMailer;

            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                //get status id
                $sql_get_status_id=mysqli_query($conn, "SELECT hdtID FROM helpdesktracker ORDER BY hdtID DESC LIMIT 1");
                $result_sql_get_status_id=mysqli_fetch_assoc($sql_get_status_id);
                $status_id =$result_sql_get_status_id['hdtID'];

                //create folder for each complaint/case : mkdir("caseId");
                $path = "../uploaded_files/".$hdid;
                if (!file_exists($path)) {
                mkdir($path);
                }

                //move file to correct path folder
                $upload_file = date("YmdHis").'_'.$_FILES["file"]["name"];// correct file & filename into db
                move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
                
                $mail->addAttachment($path.'/'.$upload_file);         // Add attachments

                //insert uploaded_file 
                //TODO control if number of file >1
                $sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(hdID, hdtID, fileName, filePath, createdBy) VALUES('$hdid', '$status_id','$upload_file', '$path', '$staff_id')");
            }

            $affectedRows = mysqli_affected_rows($conn);
            if($affectedRows >= 1){
                

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

                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Helpdesk '.$hdid. ' status update: '.$status_name;
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->Body    = '<b>Dear student,</b><br><br><br>'.$_POST['description'].'<br><br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$_SESSION['staff_name'].'<br>'.$staff_id.'<br>Staff<br>' .$_SESSION['college_name'].' '.$_SESSION['block_name'];
                $mail->AltBody = $_POST['description'].'(Do not reply, this is an auto generated email) --by:['.$_SESSION['staff_name'].' '.$staff_id.']'.' Staff of '.$_SESSION['college_name'].' '.$_SESSION['block_name'];

                if(!$mail->send()) {
                  if($status_name=="Closed"||$status_name=="closed"){
                    echo '<script>alert("Helpdesk has been closed successfully! [Mailer] Email could not be sent to student.");window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=closed";</script>';
                    }
                    else{
                        echo '<script>alert("New status has been added successfully! [Mailer] Email could not be sent to student.");window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=open";</script>';
                    }
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                   if($status_name=="Closed"||$status_name=="closed"){
                    echo '<script>alert("Helpdesk has been closed successfully! [Mailer] Email has been sent to student.");window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=closed";</script>';
                    }
                    else{
                        echo '<script>alert("New status has been added successfully! [Mailer] Email has been sent to student.");window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=open";</script>';
                    }
                }

            }else{
                echo '<script>alert("New status failed to be added");window.location.href="helpdeskTraceUpdate.php?sdid="+"'.$hdid.'"+"&status=open";</script>';
                // header("helpdeskTraceUpdate.php?sdid=".$sdid);
            }
        }
        else{
            echo "fill up the form!";
        }
        echo "<meta http-equiv='refresh' content='0'>";
    }


?>
<!DOCTYPE html>
<html>
<head>
    <?php include("head.html");?>
    <title>Trace Helpdesk | Staff | UReCo</title>

    <script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_current').addClass('active');
        });

        $(function() {
            $('#dropdownStatus a').click(function() {
                console.log($(this).attr('data-value'));
                $('#inputStatus').val($(this).attr('data-value'));
            });
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
                    <li class="breadcrumb-item">Manage Helpdesk</li>
                    <li class="breadcrumb-item">Helpdesk Detail</li>
                    <li class="breadcrumb-item active" aria-current="page">Trace Helpdesk</li>
                </ol>
            </nav>
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Trace Helpdesk #<?php echo htmlentities($hdid);?></h3>
                </div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskDetail.php?hdid=<?php echo $hdid?>&status=<?php echo $status?>'">Back</button>
                </div>
            </div>
                
                <?php if($status=="open"){?>
            <div class="rounded p-4 mb-3 bg-color" id="updateForm" >
                <?php }else if($status=="closed"){?>
            <div class="rounded p-4 mb-3 bg-color d-none" id="updateForm" >
                <?php }?>

                <div class="p-2">
                    <h3 >Update Status for Helpdesk <?php//echo htmlentities($hdid);?></h3>
                </div>
                <form method="POST" action="helpdeskTraceUpdate.php?hdid=<?php echo $hdid?>&status=<?php echo $status?>" name="update_status" enctype="multipart/form-data">
                <div class="container">
                    <div class="row mb-3">
                        <label for="inputStatus" class="col-sm-3 form-label">Status</label>
                        <div class="col-sm-4">
                            <div class="input-group mb-3">
                              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Status</button>
                              <div class="dropdown-menu" id="dropdownStatus">
                                    <a class="dropdown-item" href="#" data-value="Ticket Accepted">Ticket Accepted</a>
                                    <a class="dropdown-item" href="#" data-value="Checking Truth">Checking Truth</a>
                                    <a class="dropdown-item" href="#" data-value="Informed Maintenance Team">Informed Maintenance Team</a>
                                    <a class="dropdown-item" href="#" data-value="Fixing Damage">Fixing Damage</a>
                                    <a class="dropdown-item" href="#" data-value="Resolving Problem">Resolving Problem</a>
                                    <a class="dropdown-item" href="#" data-value="Done, waiting for student's feedback">Done, waiting for student's feedback</a>
                                    <a class="dropdown-item" href="#" data-value="Closed">Closed</a>
                                </div>
                              <input type="text" name="status" class="form-control" aria-label="status" id="inputStatus" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="textAreaDescription" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" name="description" id="textAreaDescription" placeholder="Please describe the description of the status as subtle as possible" maxlength="1000" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="file" class="col-sm-3 col-form-label">Upload photo</label>
                        <div class="col-sm-4">
                            <input type="file" name="file" id="file" class="form-control" onchange="loadFile(event)" ><br>
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
                    <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to submit?');">Update Status</button>
                    <!-- <button type="reset" name="reset" class="btn btn-primary" >Reset</button> -->
                </form>
            </div>

            </div>
            <div class="rounded p-4 mb-3 bg-color">
               <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="content">
                                <ul class="timeline">
                                    <?php  
                                    $query = mysqli_query($conn, "
                                        SELECT * FROM helpdesktracker WHERE hdID = '$hdid' ORDER BY creationDate DESC"); 
                                    if(mysqli_num_rows($query)>0){
                                        while($row = mysqli_fetch_array($query)){  
                                    ?>
                                    <li class="event" data-date="<?php echo htmlentities($row['creationDate'])?>">
                                        <h3><?php echo htmlentities($row['statusName']) ?></h3>
                                        <p><?php echo htmlentities($row['description']) ?></p>
                        <?php
                            $status_id=$row['hdtID'];
                            $sql_get_file=mysqli_query($conn, "
                                SELECT *
                                FROM fileuploaded 
                                WHERE hdtID='$status_id'");
                            while($result_get_file=mysqli_fetch_array($sql_get_file)){
                        ?>
                            <a href="<?php echo htmlentities($result_get_file['filePath']);?>/<?php echo htmlentities($result_get_file['fileName']);?>" target="_blank">
                                <img src="<?php echo htmlentities($result_get_file['filePath']);?>/<?php echo htmlentities($result_get_file['fileName']);?>" alt="<?php echo htmlentities($result_get_file['fileName']);?>" class="img-thumbnail" style="max-width: 5rem" >
                            </a><br>
                        <?php }?>

                                        <small>By: 
                                            <?php 
                                            echo htmlentities($row['createdBy']);
                                            $person_id=$row['createdBy'];
                                            $firstCharacter = $person_id[0];
                                            if ($firstCharacter == 'D' || $firstCharacter == 'B'){
                                                $sql = mysqli_query($conn, "SELECT studName FROM student WHERE matrixNo ='$person_id'"); 
                                                $roww = mysqli_fetch_assoc($sql); 
                                                echo htmlentities(" ".$roww['studName']);
                                            }
                                            else if ($firstCharacter == 'S'){
                                                $sql = mysqli_query($conn, "SELECT staffName FROM staff WHERE staffID ='$person_id'"); 
                                                $roww = mysqli_fetch_assoc($sql); 
                                                echo htmlentities(" ".$roww['staffName']);
                                            }
                                            else if ($firstCharacter == 'M'){
                                                $sql = mysqli_query($conn, "SELECT maintName FROM maintenance WHERE maintID ='$person_id'"); 
                                                $roww = mysqli_fetch_assoc($sql); 
                                                echo htmlentities(" ".$roww['maintName']);
                                            }
                                            else echo htmlentities(" Anonymous");
                                            ?>
                                        </small>
                                    </li>
                                    <?php
                                        }
                                    }else{
                                    ?>
                                    <h2>No action taken...</h2>
                                    <?php 
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
           
        </div>
    </div>

    <!--Container Main end-->
</body>
</html>