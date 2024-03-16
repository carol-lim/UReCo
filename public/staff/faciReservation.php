<?php
	include("auth.php");
	include("../config.php");
	$staffID = $_SESSION['staff_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Facility Reservation | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_faci').addClass('active');
           $('#nav_faci_reserve').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Facility Reservation</li>
			    	<li class="breadcrumb-item active" aria-current="page">Facility Reservation</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Facility Reservation</h3>
				</div>
			</div>
				
			<div class="rounded p-4 bg-color">
				<div class="table-responsive">  
					<table id="faciReserve" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<td>Referral Number</td>  
								<td>Facility</td>  
								<td>Date</td>  
								<td>Start</td>  
								<td>End</td>
								<td>Created At</td>
								<td>Remarks</td>
								<td>Status</td>
								<td>Action</td>
								<td>Reason</td>
							</tr>  
						</thead>
						<tbody>  
						<?php  
						$query = mysqli_query($conn, "SELECT reservation.*, facility.facilityName FROM reservation JOIN facility on reservation.facilityID = facility.facilityID WHERE approveBy = '$staffID'"); 
						if(mysqli_num_rows($query)>0){
							$i=0;
							while($row = mysqli_fetch_array($query)){  
							$i=$i+1;
								?>
			                    <tr>
									<td><?php echo htmlentities($row['reservationID']);?></td>
									<td><?php echo htmlentities($row['facilityName']);?></td>
									<td><?php echo htmlentities($row['date']);?></td>
									<td><?php echo htmlentities($row['timeStart']);?></td>
									<td><?php echo htmlentities($row['timeEnd']);?></td>
									<td><?php echo htmlentities($row['creationDate']);?></td>
									<td><?php echo htmlentities($row['remarks']);?></td>
									<td><?php 	if($row['status']== 0)
													echo htmlentities('Pending');
												else if($row['status']== 1)
													echo htmlentities('Approved');
												else
													echo htmlentities('Rejected/Deleted');
									?></td>
									<td><?php	if($row['status']== 0){?>
											<input type="button" class="btn btn-warning m-1" onclick="location.href='faciReservationManage.php?status=1&&id=<?php echo $row['reservationID'];?>'" value="Approve">
											<button type="reject" class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</button>

								<form method="POST" name="reject" action="faciReservationManage.php?status=2&&id=<?php echo $row['reservationID']; ?>">
								<!-- Modal start -->
					         <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					             <div class="modal-dialog modal-dialog-centered">
					                 <div class="modal-content">
					                     <div class="modal-header">
					                         <h5 class="modal-title" id="exampleModalLabel">Reject request</h5>
					                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					                     </div>
						                 <div class="modal-body">
						                     <div class="form-group pb-2">
						                         <label for="textAreaReason">Please provide the reason of rejection</label>
						                         <textarea type="text" class="form-control" name="reason" id="textAreaReason" placeholder="Reason" maxlength="2000" rows="5" required></textarea>
						                     </div>
						                 </div>
						                 <div class="modal-footer">
						                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						                     <button type="submit" name="reject" id="reject" class="btn btn-primary" onclick="return confirm('Are you sure about the rejection?'); ">Submit</button>
						                 </div>
					                 </div>
					             </div>
					         </div>
					         <!-- Modal end -->
					         </form>

										<?php }
											else if($row['status']== 1){?>
											<p>Approved</p><?php }
											else{ ?>
											<p>Rejected</p><?php } ?>
								</td>
								<td><?php 	if($row['reason'] != NULL){echo htmlentities($row['reason']);}
											else{echo htmlentities("-");}?></td>
			                    </tr>
						<?php
			            	}
			            }?>
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
	    $('#faciReserve').DataTable();
	} );
</script>  	
</body>
</html>