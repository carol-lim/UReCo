<?php
	include("auth.php");
	include("../config.php");

?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Visitor Log | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_visitor').addClass('active');
        });
    </script>
   <?php
	
		if(isset($_POST['sort'])){
			$rawdate = htmlentities($_POST['sort']);
			$date = date('Y-m', strtotime($rawdate));
			$query = mysqli_query($conn, "SELECT * FROM visitor WHERE date LIKE '$date%'");
			$numVisitor = mysqli_num_rows($query);
			echo "<script>document.getElementById('mytext').value = $date;</script>";
		}
		else{
			$query = mysqli_query($conn, "SELECT * FROM visitor");
			$numVisitor = mysqli_num_rows($query);
		}
	?>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb" id="mapping">
                 <li class="breadcrumb-item active" aria-current="page">Visitor Log</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Visitor Log</h3>
				</div>
			</div>

			<div class="d-flex flex-wrap rounded p-4 bg-color">
				<div class="container">
              <div class="row mb-3">
                  <label for="sort" class="col-sm-4 form-label">Sort by month: </label>
                  <div class="col-sm-4">
                     <form action="" method="POST">
								<input type="month" name="sort" class="form-control mb-1" id="sort">
							</form>
                  </div>
              </div>
              <div class="row mb-3">
                  <label for="all" class="col-sm-4 form-label">View all: </label>
                  <div class="col-sm-4">
                     <button class="btn btn-primary" name="all" id="all" onclick="location='visitorLog.php'">View All</button>
                  </div>
              </div>
              <div class="row mb-3">
                  <label for="num_vis" class="col-sm-4 form-label">Number of visitor: </label>
                  <div class="col-sm-4">
                     <p id="num_vis"><?php echo $numVisitor ?></p>
                  </div>
              </div>
				</div>
				<div class="table-responsive">  
					<table id="visitor" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">
						<thead>  
							<tr>  
								<td>#</td>  
								<td>NRIC</td>  
								<td>Name</td>  
								<td>Date</td>  
								<td>Time</td>
								<td>Reason</td>
							</tr>  
						</thead>
						<tbody>  
						<?php
							if($numVisitor > 0){
								$i=0;
								while($row = mysqli_fetch_array($query)){  
								$i=$i+1;
									?>
			                    <tr>
									<td><?php echo $i;?></td>
									<td><?php echo htmlentities($row['ic']);?></td>
									<td><?php echo htmlentities($row['name']);?></td>
									<td><?php echo htmlentities(date('d/m/Y', strtotime($row['date'])));?></td>
									<td><?php echo htmlentities(date('H:m:s', strtotime($row['date'])));?></td>
									<td><?php echo htmlentities($row['reason']);?></td>
						<?php
			            	}
			            }else{
			          ?>
			            <tr>
			              <td colspan="7" align="center">No visitor.</td>
			            </tr>
			          <?php } ?>
			            </tbody>
					</table>  
				</div>
			</div>
	</div>
	<!--Container Main end-->
	<!-- datatable js -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>  
	<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>            
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
	<!-- datatable css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap4.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />  
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css"/>
<script>  
	$(document).ready(function() {
	    $('#visitor').DataTable();
	} );

	jQuery(function(){
		jQuery('#sort').change(function(){
			this.form.submit();
		});
	});
	
</script> 
</body>
</html>