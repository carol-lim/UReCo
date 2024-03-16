<?php
	include("auth.php");
	include("../config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.paginate.js"></script>
	<title>Announcement | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_ann').addClass('active');
           $('#nav_ann_gen').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Announcement</li>
			    	<li class="breadcrumb-item active" aria-current="page">General Announcement</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Announcement</h3>
				</div>
				<div class="p-2">
					<a href="https://t.me/s/ureco_ann" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="right" title="Get announcement notification in UReCo Telegram group" style="font-size: 1.5rem;"><i class="fab fa-telegram" aria-hidden="true"></i></a>
				</div>
			</div>
				
			<div class="rounded p-4 bg-color">
			<!-- buttons of blocks -->
				<div class="d-flex">
					<div class="p-2">
						<h3>Filter: </h3>
					</div>
					<div class="p-2">
						<div class="dropdown ">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="satria" data-bs-toggle="dropdown" aria-expanded="false">Satria</button>
						  <ul class="dropdown-menu" aria-labelledby="satria">
						    <li><a class="dropdown-item" href="annGeneral.php?id=LK">Lekir</a></li>
						    <li><a class="dropdown-item" href="annGeneral.php?id=LU">Lekiu</a></li>
						    <li><hr class="dropdown-divider"></li>
						    <li><a class="dropdown-item" href="annGeneral.php?id=J">Jebat</a></li>
						    <li><a class="dropdown-item" href="annGeneral.php?id=K">Kasturi</a></li>
						    <li><a class="dropdown-item" href="annGeneral.php?id=T">Tuah</a></li>
						  </ul>
						</div>	
					</div>	
					<div class="p-2">
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="lestari" data-bs-toggle="dropdown" aria-expanded="false">Lestari</button>
						  <ul class="dropdown-menu" aria-labelledby="lestari">
						    <li><a class="dropdown-item" href="annGeneral.php?id=A">Alpha</a></li>
						    <li><hr class="dropdown-divider"></li>
						    <li><a class="dropdown-item" href="annGeneral.php?id=B">Beta</a></li>
						  </ul>
						</div>
					</div>
				</div>	
			<!-- ann cards -->
				<div class="row row-cols-1 row-cols-md-4 g-4" id="anncardlist">
				<?php
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$sql_ann=mysqli_query($conn, "SELECT announcement.*, block.blockName, college.collegeName, fileuploaded.fileName, fileuploaded.filePath FROM announcement JOIN staff ON announcement.approveBy=staff.staffID JOIN block ON block.blockID=staff.blockID JOIN college ON college.collegeID=block.collegeID JOIN fileuploaded ON announcement.annID = fileuploaded.annID WHERE display=1 AND announcement.blockID ='$id' ORDER BY creationDate DESC");
					}
					else
						$sql_ann=mysqli_query($conn, "SELECT announcement.*, block.blockName, college.collegeName, fileuploaded.fileName, fileuploaded.filePath FROM announcement JOIN staff ON announcement.approveBy=staff.staffID JOIN block ON block.blockID=staff.blockID JOIN college ON college.collegeID=block.collegeID JOIN fileuploaded ON announcement.annID = fileuploaded.annID WHERE display=1 ORDER BY creationDate DESC");
					
					if(mysqli_num_rows($sql_ann)>0){
						while($row = mysqli_fetch_array($sql_ann)){  
				?>
			    <div class="col">
				    <div class="card h-100">
						<img class="card-img-top" style="max-height: 10rem; object-fit: cover;" src="<?php echo htmlentities($row['filePath']."/".$row['fileName'])?>" alt="cover photo">
						<div class="card-body">
							<h5 class="card-title"><?php echo htmlentities($row['title'])?></h5>
							<p class="card-text truncate-para"><?php echo htmlentities($row['text'])?></p>
							<a href="annDetail.php?id=<?php echo htmlentities($row['annID'])?>" class="btn btn-primary">view detail</a>
						</div>
						<div class="card-footer">
							<small class="text-muted"><?php echo htmlentities($row['creationDate'])?><br><?php echo htmlentities($row['collegeName'])?> <?php echo htmlentities($row['blockName'])?></small>
						</div>
					</div>
					</div>
			   <?php 
						}
					}
			   ?>
				
			</div>
			<br>
			<div id="anncardlist-pagination" style="display:none" class="pb-5" align="center">
			    <a id="anncardlist-previous" href="#" class="disabled">&laquo; Previous</a> 
			    <a id="anncardlist-next" href="#">Next &raquo;</a> 
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#anncardlist').paginate({itemsPerPage: 4});
			});
		</script>
			</div>
		</div>
	</div>
	<!--Container Main end-->

</body>
</html>