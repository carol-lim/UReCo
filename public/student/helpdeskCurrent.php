<?php
	include("auth.php");
	include("../config.php");
	$matrixNo = $_SESSION['matrixNo'];
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Current Helpdesk | Student | UReCo</title>

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
			    	<li class="breadcrumb-item active" aria-current="page">Current Helpdesk</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Current Helpdesk</h3>
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskForm.php'">Request</button>
				</div>
			</div>
				
			<div class="rounded p-4 bg-color">
				<div class="table-responsive">  
					<table id="helpdesk_current" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<td>Referral Number</td>  
								<td>Category</td>  
								<td>Subcategory</td>  
								<td>Days Need</td>
								<td>Open at</td>
								<td>Due at</td>
								<td>Status</td>
							</tr>  
						</thead>
						<tbody>  
						<?php  
						$query = mysqli_query($conn, "SELECT helpdesk.*, category.categoryName, subcategory.scName FROM helpdesk JOIN category ON helpdesk.category = category.categoryID JOIN subcategory ON helpdesk.subcategory = subcategory.scID WHERE matrixNo ='$matrixNo' AND closeDate IS NULL"); 
						if(mysqli_num_rows($query)>0){
							while($row = mysqli_fetch_array($query)){  
								?>
			                    <tr>
									<td><a href="helpdeskDetail.php?hdid=<?php echo $row['hdID']?>&status=open"><?php echo htmlentities($row['hdID']);?></a></td>
									<td><?php echo htmlentities($row['categoryName']);?></td>
									<td><?php echo htmlentities($row['scName']);?></td>
									<td><?php echo htmlentities($row['daysNeed']);?></td>
									<td><?php echo htmlentities($row['openDate']);?></td>
									<td>
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
											
									</td>
									<td>
										<?php  
										$hdid = $row['hdID'];
										$result = mysqli_query($conn, "SELECT statusName FROM helpdesktracker WHERE hdID = '$hdid' ORDER BY creationDate DESC LIMIT 1"); 
										$roww 	= mysqli_fetch_assoc($result);
										
										echo htmlentities($roww['statusName']);?>
									</td>

			                    </tr>
						<?php
			            	} } ?>
			            </tbody>
					</table>  
				</div>
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
	    $('#helpdesk_current').DataTable();
	} );
</script>  
</body>
</html>