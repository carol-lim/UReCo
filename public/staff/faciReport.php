<?php 
    include("auth.php");
    include("../config.php");
    $sql_fid = mysqli_query($conn, "SELECT facilityID from facility");
    $chart_data = "";
    while($row1 = mysqli_fetch_assoc($sql_fid)){
        $fid = $row1['facilityID'];
        $get_num_reserve = mysqli_query($conn, "SELECT * FROM reservation WHERE facilityID = '$fid'");
        $reserveNum = mysqli_num_rows($get_num_reserve);
        $sql_fname = mysqli_query($conn, "SELECT CONCAT(college.collegeName,' ', facilityName) as facilityName FROM facility JOIN college ON facility.collegeID = college.collegeID WHERE facilityID = '$fid'");
        while($row2 = mysqli_fetch_assoc($sql_fname)){
            $chart_data .= "{ facility:'".$row2['facilityName']."', reserve_num:".$reserveNum."}, ";
        }
    }
    $chart_data = substr($chart_data, 0, -1);
?>


<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Facility Reservation Report | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_faci').addClass('active');
           $('#nav_faci_report').addClass('active');
        });
    </script>

   <!-- morris for chart -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
	<link rel="stylesheet" type="text/css" href="http://www.prepbootstrap.com/Content/shieldui-lite/dist/css/light/all.min.css" />
	<script type="text/javascript" src="http://www.prepbootstrap.com/Content/shieldui-lite/dist/js/shieldui-lite-all.min.js"></script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Facility Reservation</li>
                    <li class="breadcrumb-item active" aria-current="page">Facility Reservation Report</li>
                </ol>
            </nav>
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Facility Reservation Report</h3>
                </div>
            </div>
                
            <div class="rounded p-4 mb-3 bg-color">
				<div class="container">
				     <br>
                    <h2 align="center">Report of Facility Reserved</h2>
                    <p align="left">Number of <br>Reservation</p> 
                    <div id="chart"></div>
                    <p align="center">Facility</p> 
				 </div>
            </div>
      </div>
	</div>
	<!--Container Main end-->
</body>
</html>
<script>
Morris.Bar({
    element : 'chart',
    data:[<?php echo $chart_data; ?>],
    xkey:'facility',
    ykeys:['reserve_num'],
    labels:['Number of Reservation'],
    // hideHover:'auto',
    hideHover:'false',
    stacked:true,
    resize:true,
    //xLabelAngle: 90
    //xLabelMargin:5
});
//$('svg').height(500);
</script>