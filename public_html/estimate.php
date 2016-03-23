
<h1>Estimate Price for your Package</h1>
	<a href="index.php">Go back to HOME</a></p>
	<a href="order.php">PLACE A NEW ORDER</a></p>
	<a href="estimateprice.php">Make a new estimate</a></p>

<?php
require ('functions.php');
$db_conn = dbConnect();
$success = true;

estimatePrice($db_conn, $success);

//Error-handling
//case1: when tracking number does not exist --> no record
dbLogout($db_conn);
?>