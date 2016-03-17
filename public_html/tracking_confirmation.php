<?php
// NOTE: Make sure to change session path to point to your own public_html dir

include 'functions.php';
require_once 'getTrackingNumber.php';
$db_conn = dbConnect();
$success = true;
$tn = $id;



if (db_conn) {
	
	$orders = executePlainSQL("select * from orders", $db_conn, $success);
	printResult($orders);
}

dbLogout($db_conn);

?>

<h1>Tracking Information</h1>
	<p><a href="index.php">HOME - TRACK YOUR ORDER</a><br>
	<a href="order.php">PLACE A NEW ORDER</a></p>
	<h3>Your Information</h3>
	<h4>Tracking Number</h4>
	<p>Your tracking number is <? php echo 
	$tn; ?> </p>
	

