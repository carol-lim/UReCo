<?php
	include("auth.php");
	include("../config.php");
	$staffName = $_SESSION['staff_name'];
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Manage Announcement | Staff | UReCo</title>

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
	<div class="py-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Announcement</li>
			    	<li class="breadcrumb-item active" aria-current="page">Manage Announcement</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Manage Announcement</h3>
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='annPost.php'">Post New Announcement</button>
				</div>
			</div>
				
			<div class="rounded p-4 bg-color">
				<div class="table-responsive">  
					<table id="annManage" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<td>Referral Number</td>  
								<td>Title</td>  
								<td>Author</td>  
								<td>Block</td>
								<td>Created At</td>
								<td>Updated at</td>
								<td>Status</td>
								<td>Action</td>
								<td>Reason</td>
							</tr>  
						</thead>
						<tbody>  
						<?php  
							$query = mysqli_query($conn, "SELECT announcement.*, block.blockName FROM announcement JOIN block on announcement.blockID = block.blockID"); 
							if(mysqli_num_rows($query)>0){
								while($row = mysqli_fetch_array($query)){
						?>
	                    <tr>
							<td><a href="annDetail.php?id=<?php echo htmlentities($row['annID']);?>"><?php echo htmlentities($row['annID'])?></a></td>
							<td><?php echo htmlentities($row['title']);?></td>
							<td><?php echo htmlentities($row['annAuthor']);?></td>
							<td><?php echo htmlentities($row['blockName']);?></td>
							<td><?php echo htmlentities($row['creationDate']);?></td>
							<td><?php echo htmlentities($row['updationDate']);?></td>
							<td><?php 	if($row['display']== 0)
											echo htmlentities('Pending');
										else if($row['display']== 1)
											echo htmlentities('Approved');
										else
											echo htmlentities('Rejected/Deleted');
							?></td>
							<td>
							<?php	if($row['display'] == 0){?>
								<form method="POST" name="approve" action="annManageAction.php?id=<?php echo $row['annID']; ?>">
								<input type="submit" name="approve" class="btn btn-warning m-1" value="Approve" onclick="return confirm('Are you sure about the approval?')">
								</form>
								<button type="reject" class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</button>

								<form method="POST" name="reject" action="annManageAction.php?id=<?php echo $row['annID']; ?>">
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
							else if($row['display'] == 1){?>
								<form method="POST" name="delete" action="annManageAction.php?id=<?php echo $row['annID']; ?>">
								<input type="submit" name="delete" class="btn btn-warning" value="Delete" onclick="return confirm('Are you sure about the approval?')">
								</form><?php }
								
							else{?>
								<p>Rejected/Deleted</p><?php } ?>
							</td>
							<td><?php 	if($row['reason'] != NULL){echo htmlentities($row['reason']);}
										else{echo htmlentities("-");}?></td>
	                    </tr>
				<?php
	            	}
	            } ?>
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
	    $('#annManage').DataTable();
	} );
</script>  
</body>
</html>