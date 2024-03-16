<?php
    include("auth.php");
    include("../config.php");
      if(isset($_POST['submit'])){
        $matrixNo=$_SESSION['matrixNo'];
        $block=$_SESSION['blockID'];
        $category=$_POST['category'];
        $subcategory=$_POST['subcategory'];
        $description=mysqli_real_escape_string($conn,$_POST['description']);
        $file=$_FILES["file"]["name"]; // file name
        
        // TO-TO: validate file before upload

        if ($matrixNo!=""&&$category!=""&&$subcategory!=""&&$description!=""&&$file!="") {
            //get avg fix day for daysNeed
            $result_get_afd = mysqli_query($conn, "SELECT avgFixDay FROM subcategory WHERE scID = '$subcategory' AND display = '1'");
            while($get_afd = mysqli_fetch_assoc($result_get_afd))
                $daysNeed = $get_afd['avgFixDay'];
            //submit form
            $sql_submit_form = mysqli_query($conn, "INSERT INTO helpdesk(matrixNo, category, subcategory, description, daysNeed) VALUES('$matrixNo', '$category', '$subcategory', '$description', '$daysNeed')");
            if(!$sql_submit_form)
                echo "<script>alert('Fail submit form!')</script>";
            else{
                //get hdID
                $result_get_hdid = mysqli_query($conn, 'SELECT hdID FROM helpdesk ORDER BY openDate DESC LIMIT 1');
                while($get_hdid = mysqli_fetch_assoc($result_get_hdid))
                    $hdid = $get_hdid['hdID'];
                // insert status into helpdesktracker
                $sql_submit_status = mysqli_query($conn, "INSERT INTO helpdesktracker(statusName, description, createdBy, hdID) VALUES('Ticket Submitted', 'Student submitted new service desk form.', '$matrixNo', '$hdid')");
                if(!$sql_submit_status)
                    echo "<script>alert('Fail submit form!')</script>";
                else{
                    //get hdtID
                    $result_get_hdtid = mysqli_query($conn, 'SELECT hdtID FROM helpdesktracker ORDER BY creationDate DESC LIMIT 1');
                    while($get_hdtid = mysqli_fetch_assoc($result_get_hdtid))
                        $hdtid = $get_hdtid['hdtID'];
                    //create file path
                    $path = "../uploaded_files/helpdesk/".$hdid;
                    if (!file_exists($path))
                        mkdir($path);
                    //move file to correct path folder
                    $upload_file = date("YmdHis").'_'.$_FILES["file"]["name"];// correct file & filename into db
                    move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
                    //add uploaded file to database
                    $sql_upload_file = mysqli_query($conn, "INSERT INTO fileuploaded(hdID, hdtID, fileName, filePath, createdBy) VALUES('$hdid', '$hdtid', '$upload_file', '$path', '$matrixNo')");
                    if(!$sql_upload_file)
                        echo "<script>alert('Fail upload file!')</script>";
                    else{
                        //get random staff email from student's block and college
                        $result_get_se = mysqli_query($conn, "SELECT staffEmail FROM staff WHERE blockID = '$block' ORDER BY RAND() LIMIT 1");
                        while($get_se = mysqli_fetch_assoc($result_get_se))
                            $staffEmail = $get_se['staffEmail'];
                        //get category and subcategory name
                        $result_get_cn = mysqli_query($conn, "SELECT categoryName FROM category WHERE categoryID = '$category'");
                        while($get_cn = mysqli_fetch_assoc($result_get_cn))
                            $categoryName = $get_cn['categoryName'];
                        $result_get_scn = mysqli_query($conn, "SELECT scName FROM subcategory WHERE scID = '$subcategory'");
                        while($get_scn = mysqli_fetch_assoc($result_get_scn))
                            $subcategoryName = $get_scn['scName'];
                        
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

                        $mail->Subject = 'New Service Desk: '.$categoryName.' '.$subcategoryName;
                        // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                        $mail->Body    = '<b>Dear staff of '.$_SESSION['collegeName'].' '.$_SESSION['blockName'].',</b><br><br><br>'.$_POST['description'].'<br><br><br><small>Do not reply, this is an auto generated email.</small><br><br><br>'.$_SESSION['studName'].'<br>'.$matrixNo ;
                        $mail->AltBody = 'Dear staff of ['.$_SESSION['collegeName'].' '.$_SESSION['blockName'].'], '.$_POST['description'].'(Do not reply, this is an auto generated email) --by:['.$_SESSION['studName'].'<br>'.$matrixNo.']';

                        if(!$mail->send()){
                            // echo '[Mailer] Message could not be sent.';
                          echo '<script> alert("Thank you! Your ticket has been successfully submitted! Your Service Referral Number is "+"'.$hdid.'. [Mailer] Email could not be sent to staff."); window.location.href="helpdeskCurrent.php";</script>';
                            // echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else{
                            // echo '[Mailer] Message has been sent';
                          echo '<script> alert("Thank you! Your ticket has been successfully submitted! Your Service Referral Number is "+"'.$hdid.'. [Mailer] Email has been sent to staff."); window.location.href="helpdeskCurrent.php";</script>';
                        }
                    }
                }
            }
        }else
            echo '<script> alert("Failed to submit."); window.location.href="helpdeskCurrent.php";</script>';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("head.html");?>
    <title>Request New Helpdesk | Student | UReCo</title>

    <script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_current').addClass('active');
        });

        // get subcategory of certain category
        function getCategory(val) {
          //alert(val);
          $("#selectSubCategory").html("Select Subcategory");
          $.ajax({
            type: "POST",
            url: "helpdeskGetSubcat.php",
            data:'category_id='+val,
            success: function(data){
              $("#selectSubCategory").html(data);
            }
          });
        }
        function getSubCategoryAvgFixDay(val) {
          //alert(val);
          $.ajax({
            type: "POST",
            url: "helpdeskGetSubcatAvgFixDay.php",
            data:'subcategory_id='+val,

            success: function(data){
              $("#avg_fix_day").html(data);
            }
          });
        }
    </script>
</head>
<body id="body-pd">
    <?php include("sidebar.html");?>
    <div class="py-4">

        <div class="d-flex flex-column " id="content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Maintenance Helpdesk</li>
                    <li class="breadcrumb-item">Current Helpdesk</li>
                    <li class="breadcrumb-item active" aria-current="page">Request New Helpdesk</li>
                </ol>
            </nav>          
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Request New Helpdesk</h3>
                </div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskCurrent.php'">Back</button>
                </div>
            </div>
                
            <form method="POST" name="helpdesk" action="helpdeskForm.php" enctype="multipart/form-data">
                <div class="rounded p-4 mb-3 bg-color">
                    <div class="p-2">
                        <h3 >Tell us what problem</h3>
                    </div>
                    <div class="container">
                        <div class="row mb-3">
                            <label for="selectCategory" class="col-sm-4 form-label">Category</label>
                            <div class="col-sm-4">
                                <select name="category" id="selectCategory" class="form-control" onChange="getCategory(this.value);" required>
                                  <option value="">Select Category</option>
                                  <?php 
                                    $sql=mysqli_query($conn, "SELECT categoryID,categoryName FROM category WHERE display = 1");
                                    while ($rw=mysqli_fetch_array($sql)) {
                                  ?>
                                  <option value="<?php echo htmlentities($rw['categoryID']);?>"><?php echo htmlentities($rw['categoryName']);?></option>
                                  <?php
                                    }
                                  ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="selectSubCategory" class="col-sm-4 form-label">Subcategory</label>
                            <div class="col-sm-4">
                                <select name="subcategory" id="selectSubCategory" class="form-control" onChange="getSubCategoryAvgFixDay(this.value);" required>
                                  <option value="">Select Subcategory</option>
                                </select>
                            </div>
                        </div>
                   
                        <div class="row mb-3">
                            <label for="textAreaDescription" class="col-sm-4 form-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text" class="form-control" name="description" id="textAreaDescription" placeholder="Please describe (WHEN, WHERE, WHAT, WHY, HOW) the matter you faced as subtle as possible" maxlength="2000" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="file" class="col-sm-4 form-label">Upload photo as proof</label>
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
                <div class="rounded p-4 mb-3 bg-color">
                        <div class="p-2">
                            <h3 >What you could expect</h3>
                        </div>
                    <div class="container">
                        <div class="row mb-3">
                            <label for="label" class="col-sm-12 form-label">It takes average <span id="avg_fix_day"></span> days to complete the fixing.</label>
                        </div>
                    </div>
                </div>                
        </div>
        <input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Submit" onclick="return confirm('Are you sure you want to submit?');">
		</form>
    </div>
    <!--Container Main end-->
</body>
</html>