<?php 
    include("auth.php");
    include("../config.php");

    $query = "SELECT COUNT(hdID) as num, closeDate, mtWork FROM helpdesk GROUP BY mtWork";
    $result = mysqli_query($conn, $query);
    $total = mysqli_query($conn, "SELECT * FROM helpdesk");
    $chart_data_1 = "{status:'Total', num:'".mysqli_num_rows($total)."'}, ";
    while($row = mysqli_fetch_array($result)){
        if($row['closeDate'] != NULL && $row['mtWork'] == 3){
            $status = "Closed";
            $num = $row['num'];
        }
        else if($row['closeDate'] == NULL){
            $status = "Open";
            $num = $row['num'];
        }
        $chart_data_1 .= "{ status:'".$status."', num:".$num."}, ";
    }
    $chart_data_1 = substr($chart_data_1, 0, -1);
    
    
    $sql_fid = mysqli_query($conn, "SELECT categoryID from category");
    $chart_data_2 = "";
    while($row1 = mysqli_fetch_assoc($sql_fid)){
        $fid = $row1['categoryID'];
        $get_num_reserve = mysqli_query($conn, "SELECT * FROM helpdesk WHERE category = '$fid'");
        $reserveNum = mysqli_num_rows($get_num_reserve);
        $sql_fname = mysqli_query($conn, "SELECT categoryName FROM category WHERE categoryID = '$fid'");
        while($row2 = mysqli_fetch_assoc($sql_fname)){
            $chart_data_2 .= "{ cname:'".$row2['categoryName']."', num:".$reserveNum."}, ";
        }
    }
	
	$chart_data_3 = "";
	$sql_satisfy = mysqli_query($conn, "SELECT COUNT(statusName) as num FROM `helpdesktracker` WHERE statusName = 'Satisfied' ORDER BY statusName");
	while($rowSatisfy = mysqli_fetch_assoc($sql_satisfy)){
		$chart_data_3 .= "{ label:'Satisfied', value:".$rowSatisfy['num']."}, ";
	}
	
	$sql_nsatisfy = mysqli_query($conn, "SELECT COUNT(statusName) as num FROM `helpdesktracker` WHERE statusName = 'Dissatisfied' ORDER BY statusName");
	while($rowNsatisfy = mysqli_fetch_assoc($sql_nsatisfy)){
		$chart_data_3 .= "{ label:'Dissatisfied', value:".$rowNsatisfy['num']."}, ";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Maintenance Helpdesk Report | Staff | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_report').addClass('active');
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
                    <li class="breadcrumb-item">Maintenance Helpdesk</li>
                    <li class="breadcrumb-item active" aria-current="page">Helpdesk Report</li>
                </ol>
            </nav>
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Helpdesk Report</h3>
                </div>
            </div>
                
            <div class="rounded p-4 mb-3 bg-color">
    			<div class="container">
    			     <br>
    			     <h2 align="center">Report of Helpdesk</h2>
    				<br>
    				<h4 align="center">Number of Helpdesk Opened</h4>
					<p align="left">Number of <br>Cases</p> 
    			     <div id="chart-1"></div>
					 <p align="center">Cases</p> 
    				<br>
    				<h4 align="center">Average Use of Time Based on Category</h4>
					<p align="left">Number of <br>Cases</p> 
    				<div id="chart-2"></div>
					<p align="center">Category</p> 
                    <br>
                    <h4 align="center">Satisfaction</h4>
                    <div id="chart-3"></div>
    			 </div>
            </div>
      </div>
	</div>
	<!--Container Main end-->

</body>
</html>
<script>
Morris.Bar({
    element : 'chart-1',
    data:[<?php echo $chart_data_1; ?>],
    xkey:'status',
    ykeys:['num'],
    labels:['Number of Cases'],
    // hideHover:'auto',
    hideHover:'false',
    stacked:true,
    resize:true,
    // xLabelAngle: 90
    //xLabelMargin:5
});
// $('svg').height(1000);

Morris.Bar({
    element : 'chart-2',
    data:[<?php echo $chart_data_2; ?>],
    xkey:'cname',
    ykeys:['num'],
    labels:['Number of Cases'],
    // hideHover:'auto',
    hideHover:'false',
    stacked:true,
    resize:true,
    // xLabelAngle: 90
    //xLabelMargin:5
});

Morris.Donut({
    element:'chart-3',

    data:[<?php echo $chart_data_3; ?>]
});
</script>