<?php
  include("auth.php");
  include("../config.php");
  
  $annid = $_GET['id'];
  
  $retrive_ann = mysqli_query($conn, "SELECT * FROM announcement WHERE annID = '$annid'");
  $ra = mysqli_fetch_assoc($retrive_ann);
  $dbTitle = $ra['title'];
  $dbText = $ra['text'];
  
  $retrive_img = mysqli_query($conn, "SELECT * FROM fileuploaded WHERE annID = '$annid'");
  $ri = mysqli_fetch_assoc($retrive_img);
	  $dbPath = $ri['filePath'];
	  $dbName = $ri['fileName'];
  
  if(isset($_POST['submit'])){
	$staffID = $_SESSION['staff_id'];
    $staffName = $_SESSION['staff_name'];
    $title = $_POST['title'];
    $block = $_SESSION['block_id'];
    $text = mysqli_real_escape_string($conn,$_POST['annText']);
    $file = $_FILES["file"]["name"]; // file name
    
    // TO-TO: validate file before upload
	
	if ($title!=""&&$text!=""&&$file!="") {
		
		$updateAnn = "UPDATE announcement SET title = '$title', text = '$text' WHERE annID = '$annid'";
		$resultAnn = mysqli_query($conn, $updateAnn);
		if(!$resultAnn)
			echo "<script>alert('Update Failed!');location.href='annDetail.php?id=".$annid."'</script>";
		
		unlink($dbPath.'/'.$dbName);
		
		$path = "../uploaded_files/announcement/".$annid;
		if (!file_exists($path))
			mkdir($path);
		$upload_file = date("YmdHis").'_'.$_FILES['file']['name'];// correct file & filename into db
		move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
		
		$updateImg = "UPDATE fileuploaded SET fileName = '$upload_file', filePath = '$path' WHERE annID = '$annid'";
		$resultImg = mysqli_query($conn, $updateImg);
		if(!$resultImg)
			echo "<script>alert('Update Image Failed!');location.href='annDetail.php?id=".$annid."'</script>";
		else
			echo "<script>alert('Update Success!');location.href='annDetail.php?id=".$annid."'</script>";
	}
	else
		echo "<script>alert('Update Failed!');location.href='annDetail.php?id=".$annid."'</script>";
  }

?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Edit Announcement | Staff | UReCo</title>

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
	<form action="annEdit.php?id=<?php echo $annid ?>" name="annEdit" method="POST" enctype="multipart/form-data">
		<div class="py-4">
			<div class="d-flex flex-column " id="content">
				<nav aria-label="breadcrumb">
				  	<ol class="breadcrumb">
				    	<li class="breadcrumb-item">Announcement</li>
				    	<li class="breadcrumb-item">Manage Announcement</li>
				    	<li class="breadcrumb-item active" aria-current="page">Edit Announcement</li>
				  	</ol>
				</nav>
				<div class="d-flex">
					<div class="p-2">
						<h3>Edit Announcement</h3>
					</div>
					<div class="p-2">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='annDetail.php?id=<?php echo $annid ?>'">Back</button>
					</div>
				</div>
      		<form method="POST" name="annEdit" action="annEdit.php?id=<?php echo $annid ?>" enctype="multipart/form-data">
					
					<div class="rounded p-4 mb-3 bg-color">
						<div class="container">
	              <div class="row mb-3">
	                  <label for="Title" class="col-sm-3 form-label">Title</label>
	                  <div class="col-sm-4">
	                      <input type="text" class="form-control" name="title" id="Title" placeholder="Title" value="<?php echo htmlentities($dbTitle) ?>" required>
	                  </div>
	              </div>
	              <div class="row mb-3">
	                  <label for="Content" class="col-sm-3 form-label">Announcement Content</label>
	                  <div class="col-sm-6">
	                      <textarea type="text" class="form-control" name="content" id="Content" placeholder="Announcement Content" maxlength="2000" rows="5" required><?php echo htmlentities($dbText) ?></textarea>
	                  </div>
	              </div>
	              <div class="row mb-3">
	                <label for="file" class="col-sm-3 form-label">Upload photo</label>
	                <div class="col-sm-4">
	                    <input type="file" name="file" id="file" class="form-control" onchange="loadFile(event)" required><br>
	                    <img id="output" style="max-height: 10rem; max-width: 10rem;" src="<?php echo $dbPath.'/'.$dbName; ?>">
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
	      </form>
	  	</div>
	  	<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Submit" onclick="return confirm('Are you sure you want to submit?');">
		</div><!-- py-4 -->
	</form>            
	<!--Container Main end-->

</body>
</html>