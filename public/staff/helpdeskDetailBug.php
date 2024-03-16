<?php
    include("auth.php");
    include("../config.php");
    $staff_id=$_SESSION['staff_id'];
    $hdid=$_GET['hdid'];
    $status=$_GET['status'];

    if (isset($_POST['informMT'])) {
        // echo '<script>alert("submitting");</script>';
        $t='Informed Maintenance Team';
        $d='Waiting Maintenance Team to response and fix the reported problem';

        $stmt = mysqli_query($conn, "UPDATE helpdesk SET mtView=1, mtWork=0 WHERE hdID ='$hdid'");
        $sql=mysqli_query($conn, "INSERT INTO helpdesktracker(statusName, description, createdBy, hdID) VALUES('$t','$d','$staff_id', '$hdid')");
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

            // $mail->addAttachment($path.'/'.$upload_file);         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Please take action on Helpdesk '.$hdid;
            // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->Body    = '<b>Dear colleague,</b><br><br><br>Please take action on the new Helpdesk '.$hdid.'<br>Thank you.<br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$_SESSION['staff_name'].'<br>'.$staff_id.'<br>Staff<br>' .$_SESSION['college_name'].' '.$_SESSION['block_name'];
            $mail->AltBody ='Dear colleague, please take action on the new Helpdesk '.$hdid.'    (Do not reply, this is an auto generated email) --by:['.$_SESSION['staff_name'].' '.$staff_id.']'.' Staff of '.$_SESSION['college_name'].' '.$_SESSION['block_name'];

            if(!$mail->send()) { 
                echo '<script>alert("Successfully informed Maintenance Team of the block. The status of Helpdesk "+"'.$hdid.'"+" has been updated as \"Informed Maintenance Team.\" [Mailer] Email could not be sent to Maintenance Team.");window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=open"</script>';
                
                } else {
                    echo '<script>alert("Successfully informed Maintenance Team of the block. The status of Helpdesk "+"'.$hdid.'"+" has been updated as \"Informed Maintenance Team.\" [Mailer] Email has been sent to Maintenance Team." );window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=open"</script>';
                  
                }

        }else{
            echo '<script>alert("Failed to informed Maintenance Team of the block.");window.location.href="helpdeskTraceUpdate.php?hdid="+"'.$hdid.'"+"&status=open</script>';
        }

    }

    if(isset($_GET['del'])){
        $sqlfile=mysqli_query($conn, "SELECT filePath, fileName FROM fileuploaded WHERE hdID='$hdid' ");
        while($row=mysqli_fetch_array($sqlfile)){
            unlink($row['file_path'].'/'.$row['file_name']);
        }
        rmdir('../uploaded_files/'.$hdid);

        mysqli_query($conn, "DELETE FROM fileuploaded WHERE hdID='$hdid' ");
        mysqli_query($conn, "DELETE FROM helpdesktracker WHERE hdID='$hdid' ");
        mysqli_query($conn, "DELETE FROM helpdesk WHERE hdID='$hdid' ");
        $affectedRows = mysqli_affected_rows($conn);
        if($affectedRows >= 1){
            echo '<script>alert("Helpdesk '.$hdid.' has been deleted!"); window.location.href="helpdeskClosed.php"</script>';
        }else{
            echo '<script>alert("Helpdesk '.$hdid.' failed to be deleted!");window.location.href="helpdeskClosed.php"</script>';
        }
    }   

?>
<!DOCTYPE html>
<html>
<head>
    <?php include("head.html");?>
    <title>Helpdesk Detail | Staff | UReCo</title>

    <script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_manage').addClass('active');
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
                    <li class="breadcrumb-item">Manage Helpdesk</li>
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
            <?php 
                $result = mysqli_query($conn, "SELECT statusName FROM helpdesktracker WHERE hdID = '$hdid' ORDER BY creationDate DESC LIMIT 1"); 
                $roww   = mysqli_fetch_assoc($result);
                if ($roww['statusName']=="Closed"||$roww['statusName']=="closed"){
            ?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskTraceUpdate.php?hdid=<?php echo $hdid;?>&status=<?php echo $status?>'">Trace</button>
            <?php 
                    $date1=strtotime($row['closeDate']);
                    $date2=strtotime(date('Y-m-d H:i:s'));

                    $diff = abs($date2 - $date1);  
                    $years = floor($diff / (365*60*60*24));  
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 

                    if ($days>=30){
            ?>        
                    <button type="delete" class="btn btn-primary" name='del' id="del-btn" onclick="confirm('Are you sure to delete this helpdesk?');">Delete</button>
            <?php 
                    }
            ?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskClosed.php'">Back</button>
            <?php 
                }
                else {
            ?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskTraceUpdate.php?hdid=<?php echo $hdid;?>&status=<?php echo $status?>'">Trace & Update</button>
                    <?php if ($status == "open"){?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskManage.php'">Back</button>
                    <?php }else{?>
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskClosed.php'">Back</button>
                    <?php }?>
            <?php 
                }
            ?>
                </div>
            </div>
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
					if ($roww['statusName']!="Closed"||$roww['statusName']!="closed"){ 
					 $result2 = mysqli_query($conn, "SELECT mtView FROM helpdesk WHERE hdID = '$hdid'"); 
					$rowww  = mysqli_fetch_assoc($result2);
					if ($rowww['mtView']!=1) { ?>
				<div class="container">
					<div class="row mb-3">
						<label for="status" class="col-sm-2 form-label">Status</label>
						<div class="col-sm-4">
							<p id="status" class="py-2"><?php echo htmlentities($roww['statusName']); ?></p>
						</div>
					</div>
					<form method="POST" name="helpdesk" action="helpdeskDetail.php?hdid=<?php echo $hdid?>&status=open" enctype="multipart/form-data">
					<div class="row mb-3">
						 <label for="Action" class="col-sm-2 form-label">Action</label>
						<div class="col-sm-4">
							<button type="submit" name="informMT" class="btn btn-danger" onclick="return confirm('Are you sure you want to inform Maintenance Team?');">Inform Maintenance Team</button>
						</div>
					</div>
				<?php } else { ?>
					<div class="row mb-3">
						<label for="Action" class="col-sm-2 form-label">Action</label>
						<div class="col-sm-4">
							<p>Informed Maintenance Team</p>
						</div>
					</div>
				<?php } ?>  
				</form>
				</div>
				<?php } else{ ?>
				<div class="container">
					<div class="row mb-3">
						<label for="status" class="col-sm-2 form-label">Status</label>
						<div class="col-sm-4">
							<p id="status" class="py-2"><?php echo htmlentities($roww['statusName']); ?></p>
						</div>
					</div>
				</div>
				<?php } ?>
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

