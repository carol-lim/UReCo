<?php 
    include("auth.php");
    include("../config.php");

    $query = "SELECT COUNT(activityID) as num, status FROM `activity` GROUP BY `status`";
    $result = mysqli_query($conn, $query);
    $total = mysqli_query($conn, "SELECT * FROM activity");
    $chart_data = '';
    $donut_data = '';
    while($row = mysqli_fetch_array($result))
        {
            if($row["status"] == 0){
                $num = mysqli_num_rows($total);
                $status = "Applied";
            }
            else if($row["status"] == 1){
                $status = "Approve";
                $num = $row["num"];
            }
            else{
                $status = "Rejected";
                $num = $row["num"];
            }
            // $chart_data .= "{ status:'".$status."', num:".$num."}, ";
            $donut_data .= "{ label:'".$status."', value:".$num."}, ";
        }
    // $chart_data = substr($chart_data, 0, -1);
?>


<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Activity Application Report | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_act').addClass('active');
           $('#nav_act_report').addClass('active');
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
                    <li class="breadcrumb-item">Activity Application</li>
                    <li class="breadcrumb-item active" aria-current="page">Activity Application Report</li>
                </ol>
            </nav>
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Activity Application Report</h3>
                </div>
            </div>
                
            <div class="rounded p-4 mb-3 bg-color">
				<div class="container">
				     <!-- <br>
                    <h2 align="center">Report of Activity</h2>
                    <div id="chart"></div> -->

                    <br>
                    <h2 align="center">Report of Activity</h2>
                    <div id="donut"></div>
				 </div>
            </div>
      </div>
	</div>
	<!--Container Main end-->
</body>
</html>
<script>
/*Morris.Bar({
    element : 'chart',
    data:[<?php //echo $chart_data; ?>],
    xkey:'status',
    ykeys:['num'],
    labels:['Number of Activity'],
    // hideHover:'auto',
    hideHover:'false',
    stacked:true,
    resize:true,
    // xLabelAngle: 90
    //xLabelMargin:5
});*/
// $('svg').height(1000);


Morris.Donut({
    element:'donut',

    data:[<?php echo $donut_data; ?>]
});
</script>