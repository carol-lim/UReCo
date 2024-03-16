<?php
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$dbname = "ureco";

	$conn = mysqli_connect($server, $user, $pass, $dbname);

	if (!$conn) {
		die("Database Connection Failed." . mysqli_connect_error()); 
	}
	// to test if the database is connected
	// else{
	// 	echo "Database Connection Established.";
	// }
?>