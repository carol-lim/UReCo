<?php
  include("auth.php");
	include("../config.php");
	include("../botID.php");
  if(isset($_POST['submit'])){
	$staffID = $_SESSION['staff_id'];
    $staffName = $_SESSION['staff_name'];
    $title = $_POST['title'];
    $block = $_SESSION['block_id'];
    $text = mysqli_real_escape_string($conn,$_POST['annText']);
    $file = $_FILES["file"]["name"]; // file name
    
    // TO-TO: validate file before upload

    if ($staffName!=""&&$title!=""&&$block!=""&&$text!=""&&$file!="") {
		
		$sql_submit_form = "INSERT INTO announcement(annAuthor, title, text, blockID, approveBy, display) VALUES('$staffName', '$title', '$text', '$block', '$staffID', 1)";
		$result_sql_submit_form = mysqli_query($conn, $sql_submit_form);
		if(!$result_sql_submit_form)
			echo 	"<script>alert('Fail Submit Form');
					location.href='annGeneral.php';</script>";
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
			
			$sql_uploaded_file=mysqli_query($conn, "INSERT INTO fileuploaded(annID, fileName, filePath, createdBy) VALUES('$annID', '$upload_file', '$path', '$staffID')");
			if(!$sql_uploaded_file)
				echo "<script>alert('Fail Upload File')</script>";
			else{
				telegram($title."\n".$text."\nBy: ".$staffName, $path."/".$upload_file);
				echo	"<script>alert('Announcement successfully created!');
						location.href='annGeneral.php';</script>";
			}
			
		}
	}
		else
			echo '<script> alert("Failed to submit."); window.location.href="annPost.php";</script>';
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Post Announcement | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_ann').addClass('active');
           $('#nav_ann_mng').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<form action="annPost.php" name="annPost" method="POST" enctype="multipart/form-data">
		<div class="py-4">
			<div class="d-flex flex-column " id="content">
				<nav aria-label="breadcrumb">
				  	<ol class="breadcrumb">
				    	<li class="breadcrumb-item">Announcement</li>
				    	<li class="breadcrumb-item">Manage Announcement</li>
				    	<li class="breadcrumb-item active" aria-current="page">Post Announcement</li>
				  	</ol>
				</nav>
				<div class="d-flex">
					<div class="p-2">
						<h3>Post Announcement</h3>
					</div>
					<div class="p-2">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='annManage.php'">Back</button>
					</div>
				</div>
					
					<div class="rounded p-4 mb-3 bg-color">
						<div class="p-2">
							<h3 >Make Announcement for the Students</h3>
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
	                      <textarea type="text" class="form-control" name="annText" id="Content" placeholder="Announcement Content" maxlength="2000" rows="5" required></textarea>
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