<?php 
	require_once 'auth.php';
	include("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
		include("head.html");
	?>
	<title>Search Student | Staff | UReCo</title>
	
	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_user').addClass('active');
           $('#nav_user_stud').addClass('active');
        });

        function FetchBlock(id){
			$('#Block').html('');
			$('#Room').html('');
				$.ajax({
				  type:'post',
				  url: 'ajaxdata.php',
				  data : { college_id : id},
				  success : function(data){
					 $('#Block').html(data);
				  }

				})
			}
			function FetchRoom(id){
			$('#Room').html('');
				$.ajax({
				  type:'post',
				  url: 'ajaxdata.php',
				  data : { block_id : id},
				  success : function(data){
					 $('#Room').html(data);
				  }

				})
			}
			function DeleteStud(id){
				if(confirm('Are you sure?')){
					location = 'deleteStud.php?matrixNo='+id;
				}
				else{
					alert(id);
				}
			}
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="py-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item ">User</li>
			    	<li class="breadcrumb-item active" aria-current="page">Search Student</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Search Student</h3>
				</div>
			</div>
				
			<div class="d-flex flex-column rounded p-4 bg-color">
				<div class="p-2">
	               <h3 >Search for student</h3>
	           </div>

				<form action="searchStudent.php" name="stud_search" method="POST">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="stud_name" id="StudentName" placeholder="Name">
						<input type="text" class="form-control" name="matric_num" id="MatricNumber" placeholder="Matric Num">
						<select class="form-control" name="gender" id="Gender">
							<option value="">Gender</option>
							<option value="2">Female</option>
							<option value="1">Male</option>
						</select>
						<select class="form-control" name="year" id="Year">
							<option value="">Year</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select>
						<select class="form-control" name="faculty" id="Faculty">
							<option value="">Faculty</option>
							<option value="FKE">FKE</option>
							<option value="FKEKK">FKEKK</option>
							<option value="FKM">FKM</option>
							<option value="FKP">FKP</option>
							<option value="FPTT">FPTT</option>
							<option value="FTKEE">FTKEE</option>
							<option value="FTKMP">FTKMP</option>
							<option value="FTMK">FTMK</option>
						</select>
						<?php
							$sql = "SELECT collegeID, collegeName FROM college";
							$result = mysqli_query($conn, $sql);
						?>
						<select class="form-control" name="college_id" id="College" onchange="FetchBlock(this.value)">
							<option class="text-muted" value="">College</option>
							<?php 
								while($row = mysqli_fetch_assoc($result)){
									echo '<option value="'.$row['collegeID'].'">'.$row['collegeName'].'</option>';
								}
							?>
						</select>
						<select class="form-control" name="block_id" id="Block" onchange="FetchRoom(this.value)">
							<option class="text-muted" value="">Block</option>

						</select>
						<select class="form-control" name="room" id="Room">
							<option class="text-muted" value="">Room</option>

						</select>
						<button class="btn btn-outline-secondary" type="submit" name="submit" value="Search">Search</button>
  						<button class="btn btn-outline-secondary" type="reset" name="reset" value="Reset">Reset</button>
					</div>					
				</form>
			</div>
				<div class="d-flex flex-column rounded p-4 mb-3 bg-color">
				<div class="p-2">
               <h3 >Search result</h3>
           </div>
					<div class="table-responsive">  
					<table id="searchStudent" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<th scope="col">#</th>
								<th scope="col">Matric Num</th>
								<th scope="col">Name</th>
								<th scope="col">Gender</th>
								<th scope="col">Contact</th>
								<th scope="col">Email</th>
								<th scope="col">Year</th>
								<th scope="col">Faculty</th>
								<th scope="col">College</th>
								<th scope="col">Block</th>
								<th scope="col">Room ID</th>
							</tr>  
						</thead>
						<tbody>  
						<?php
							if(isset($_POST['submit'])){
								$matric_num = $_POST['matric_num'];
								$stud_name 	= $_POST['stud_name'];
								$gender 	= $_POST['gender'];
								$year 		= $_POST['year'];
								$faculty 	= $_POST['faculty'];
								$college 	= $_POST['college_id'];
								$block 		= $_POST['block_id'];
								$room 		= $_POST['room'];

								//if got any input for search, store the related query parts to the array for second part of query
								if($matric_num != "" || $stud_name != "" || $gender != "" || $year != "" || $faculty != "" || $college != "" || $block != "" || $room != ""  ){
									if(!empty($matric_num)) $query_string_second_part[] = " AND matrixNo LIKE '$matric_num%' ";
									if(!empty($stud_name)) $query_string_second_part[] 	= " AND studName LIKE '$stud_name%' ";
									if(!empty($gender)) $query_string_second_part[] 	= " AND gender = '$gender' ";
									if(!empty($year)) $query_string_second_part[] 		= " AND year = '$year' ";
									if(!empty($faculty)) $query_string_second_part[] 	= " AND faculty = '$faculty' ";
									if(!empty($college)) $query_string_second_part[] 	= " AND college.collegeID = '$college' ";
									if(!empty($block)) $query_string_second_part[] 		= " AND block.blockID = '$block' ";
									if(!empty($room)) $query_string_second_part[] 		= " AND roomID = '$room' ";

									//first part of SQL query: select from multiple tables
									$query_string_First_Part = "SELECT matrixNo, studName, gender, faculty, year, studTel, roomID, block.blockName, college.collegeName, studEmail FROM student JOIN block ON student.blockID = block.blockID JOIN college on student.collegeID = college.collegeID WHERE";
										
									//third part of SQL query 
									/*$query_string_third_Part = "
										AND student.room_bed_id = room_bed.room_bed_id
										AND room_bed.block_id = block.block_id
										AND block.area_id = area.area_id;";*/

									//combine 3 parts of query into single query
									$query_string_second_part = implode(" ", $query_string_second_part);
									$query_string_second_part = preg_replace("/AND/", " ", $query_string_second_part, 1);
									$query1 = $query_string_First_Part.$query_string_second_part;

									$data1 = mysqli_query($conn, $query1) or die ('error');

									if(mysqli_num_rows($data1)>0){
										// result
										$i=0;
										while ($row1 = mysqli_fetch_assoc($data1)){
										$i=$i+1;
							?>
										<tr>
											<th scope="row"><?php echo $i;?></th>
											<td><?php echo htmlentities($row1['matrixNo']);?></td>
											<td><?php echo htmlentities($row1['studName']);?></td>
											<td><?php if($row1['gender'] ==2)
													echo htmlentities('F');
												else
													echo htmlentities('M');?></td>
											<td><?php echo htmlentities($row1['studTel']);?></td>
											<td><?php echo htmlentities($row1['studEmail']);?></td>
											<td><?php echo htmlentities($row1['year']);?></td>
											<td><?php echo htmlentities($row1['faculty']);?></td>
											<td><?php echo htmlentities($row1['collegeName']);?></td>
											<td><?php echo htmlentities($row1['blockName']);?></td>
											<td><?php echo htmlentities($row1['roomID']);?></td>
										</tr>
							<?php
									}
								}
								}
								else{
									$studList = mysqli_query($conn,"SELECT student.*, college.collegeName, block.blockName FROM student JOIN college ON student.collegeID = college.collegeID JOIN block ON student.blockID = block.blockID ORDER BY studName");
									if(mysqli_num_rows($studList)>0){
										// result
										$i=0;
										while ($row = mysqli_fetch_assoc($studList)){
										$i=$i+1;
							?>
										<tr>
											<th scope="row"><?php echo $i;?></th>
											<td><?php echo htmlentities($row['matrixNo']);?></td>
											<td><?php echo htmlentities($row['studName']);?></td>
											<td><?php if($row['gender'] ==2)
													echo htmlentities('F');
												else
													echo htmlentities('M');?></td>
											<td><?php echo htmlentities($row['studTel']);?></td>
											<td><?php echo htmlentities($row['studEmail']);?></td>
											<td><?php echo htmlentities($row['year']);?></td>
											<td><?php echo htmlentities($row['faculty']);?></td>
											<td><?php echo htmlentities($row['collegeName']);?></td>
											<td><?php echo htmlentities($row['blockName']);?></td>
											<td><?php echo htmlentities($row['roomID']);?></td>
										</tr>
							<?php
										}
								}
							}
						}
							?>
			            </tbody>
					</table>  
				</div> 
				</div>
			</div>
	</div>
</div>
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
		    $('#searchStudent').DataTable();
		} );
	</script>  
	<!--Container Main end-->

</body>
</html>