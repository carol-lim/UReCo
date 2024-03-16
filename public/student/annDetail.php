<?php
  include("auth.php");
  include("../config.php");
  $annid=$_GET['id'];
  
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Announcement Detail | Student | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_ann').addClass('active');
           $('#nav_ann_gen').addClass('active');
        });
        function redirect() {
	      window.location.href="ann_page.php";
	    }
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Announcement</li>
			    	<li class="breadcrumb-item active" aria-current="page">Announcement Detail</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Announcement Detail</h3> 
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-primary" id="back-btn" onclick="location.href='annGeneral.php'">Back</button>
				</div>
			</div>
				
			<div class="rounded p-4 bg-color">
				<div class="container">
				    <?php 
				       $sql_ann=mysqli_query($conn, "SELECT announcement.*, block.blockName, block.collegeID, college.collegeName, fileuploaded.fileName, fileuploaded.filePath FROM announcement JOIN block ON announcement.blockID = block.blockID JOIN college ON block.collegeID = college.collegeID JOIN fileuploaded on announcement.annID = fileuploaded.annID WHERE announcement.annID='$annid'");

         			 while($row=mysqli_fetch_array($sql_ann)){
				    ?>
				    <div class="row justify-content-center">
				      <div class="col-12 col-sm-8" align="center">
				        <small class="text-muted"><?php echo htmlentities($row['collegeName'])?> <?php echo htmlentities($row['blockName'])?> <?php echo htmlentities($row['creationDate'])?></small>
				        <h2 align="center"><?php echo htmlentities($row['title']) ?></h2>
				      </div>
				    </div>
				    <div class="row justify-content-center">
				      <div class="col-12 col-sm-8 py-4" align="center">
				        <img class="rounded img-fluid" style="max-height: 25rem;" src="<?php echo htmlentities($row['filePath']."/".$row['fileName'])?>" alt="cover photo">
				    	</div>
				    </div>
				    <div class="row justify-content-center">
				      <div class="col-12 col-sm-8 py-4" align="justify">
				      	<p class="text-break"><?php echo htmlentities($row['text']) ?></p>
				    	</div>
				      <div class="col-12 col-sm-8 " align="center">
					        <footer class="blockquote-footer">
					          <cite class="text-muted"><?php echo htmlentities($row['annAuthor']) ?></cite>
					        </footer>
				    	</div>
				    </div>
		      </div>
				    <?php }?>
			</div>
	</div>
	<!--Container Main end-->

</body>
</html>