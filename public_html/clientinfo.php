<?php
require ('functions.php');
$db_conn = dbConnect();
$tn = $_POST['trackingnumber'];

//Error-handling
//case1: when tracking number does not exist --> no record

?>


<h1>Tracking Information</h1>
	<a href="index.php">Go back to HOME</a></p>
	<a href="order.php">PLACE A NEW ORDER</a></p>


<?php

//Tracking number is invalid
if (!preg_match('/([0-9][0-9][0-9][0-9])/', $tn)) {

	echo " <script>
		alert('Please input 4 valid numbers for the tracking number');
		window.location='index.php';
		</script>";

}

else if (isset($_POST['status'])||isset($_POST['from'])||isset($_POST['to'])||
	isset($_POST['dt'])||isset($_POST['pt'])) {

	if (isset($_POST['status'])) {getStatus($tn, $db_conn);}
	if (isset($_POST['from'])) {getSrcInfo($tn, $db_conn);}
	if (isset($_POST['to'])) {getDstInfo($tn, $db_conn);}
	if (isset($_POST['dt'])) {getDeliveryType($tn, $db_conn);}
	if (isset($_POST['pt'])) {getPackageType($tn, $db_conn);}
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



	<!-- <h4> Status of Your Package </h4>
	<?php getStatus($tn, $db_conn); ?>
	<br>
	<h4>From</h4>
	<?php getSrcInfo($tn, $db_conn); ?>
	<br>
	<h4>To</h4>
	<?php getDstInfo($tn, $db_conn); ?>
	<br>
	<h4>Delivery Type</h4>
	<?php getDeliveryType($tn, $db_conn); ?>
	<br>
	<h4>Package Type</h4>
	<?php getPackageType($tn, $db_conn); ?> -->
