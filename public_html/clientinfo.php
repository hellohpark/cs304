<?php
require ('functions.php');
$db_conn = dbConnect();
$tn = $_POST['trackingnumber'];
$success = true;

//Error-handling
//case1: when tracking number does not exist --> no record

?>


<h1>Tracking Information</h1>
	<a href="index.php">Go back to HOME</a></p>
	<a href="order.php">PLACE A NEW ORDER</a></p>


<?php

//Tracking number is invalid
if (!preg_match('/^[0-9][0-9][0-9][0-9]$/', $tn)) {

	echo " <script>
		alert('Please input 4 valid numbers for the tracking number');
		window.location='index.php';
		</script>";

}

else if (isset($_POST['status'])||isset($_POST['from'])||isset($_POST['to'])||
	isset($_POST['dt'])||isset($_POST['pt'])) {
	getClientInfo($tn, $db_conn, $success);
}
//Tracking number is valid BUT at least one checkbox isn't checked off
else if (!isset($_POST['status'])&& !isset($_POST['from'])&& !isset($_POST['to'])&&
	!isset($_POST['dt'])&&!isset($_POST['pt'])){
	echo " <script>
		alert('Please select at least one of the order information you would like to see');
		window.location='index.php';
		</script>";

}

dbLogout($db_conn); ?>
