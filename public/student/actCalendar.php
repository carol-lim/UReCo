<!DOCTYPE html>
<html>
<head>
	<?php 
		include("auth.php");
		include("../config.php");
		include("head.html");
		include("headCalendar.html");
		
		$get_date = mysqli_query($conn, "SELECT * FROM activity WHERE status='1'");
		while($row = mysqli_fetch_assoc($get_date)){
			date('Y-m-d', strtotime($row['dateStart']));
			$start = date('Y-m-d', strtotime($row['dateStart']))."T".date('H:m:s', strtotime($row['dateStart']));
			$end = date('Y-m-d', strtotime($row['dateEnd']))."T".date('H:m:s', strtotime($row['dateEnd']));
			$event[] = "{title:'".$row['name']."',start:'".$start."',end:'".$end."'}";
		}
			$event = implode(", ", $event);
	?>
	
	<title>Facility Reservation Calendar | Student | UReCo</title>

	<script type="text/javascript">
     $(document).ready(function($){
        // tell sidebar to active current navlink
        $('#nav_act').addClass('active');
        $('#nav_act_calendar').addClass('active');
     });

     	// get current date
      var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();

		var output = d.getFullYear() + '-' +
		    (month<10 ? '0' : '') + month + '-' +
		    (day<10 ? '0' : '') + day;

     // calendar
 	  document.addEventListener('DOMContentLoaded', function() {
	    var calendarEl = document.getElementById('calendar');

	    var calendar = new FullCalendar.Calendar(calendarEl, {
	      initialDate: output,
	      initialView: 'timeGridWeek',
	      nowIndicator: true,
	      headerToolbar: {
	        left: 'prev,next today',
	        center: 'title',
	        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
	      },
	      navLinks: true, // can click day/week names to navigate views
	      editable: false,
	      selectable: true,
	      selectMirror: true,
	      dayMaxEvents: true, // allow "more" link when too many events
	      events: [<?php echo htmlentities($event);
	      /*{
	      	title: 'Satria Common Room (Book Sharing Session)',
          	start: '2021-12-23T14:00:00',
          	end: '2021-12-23T18:00:00'
	      }*/
	      ?>]
	    });

	    calendar.render();
	  });        
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Activity </li>
			    	<li class="breadcrumb-item active" aria-current="page">Activity Application Calendar</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Activity Application Calendar</h3>
				</div>
			</div>

			<div id='calendar' class="mb-3"></div>

		</div>
	</div>
	<!--Container Main end-->
</body>
</html>