<?php
	include("../config.php");
	require_once 'auth.php';
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Home | Admin | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_home').addClass('active');
        });
    </script>
</head>
<body id="body-pd" style="background-image: url('../../asset/admin.jpg'); background-size: cover;">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb" >
			    	<li class="breadcrumb-item active" aria-current="page">Home</li>
			  	</ol>
			</nav>	
		</div>
	</div>
	<div>
		<p class="text-center fs-1">Welcome, Admin.</p>
	</div>
	<!--Container Main end-->

</body>
</html>