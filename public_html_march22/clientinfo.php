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

	<h3>Your Information</h3>

	<h4> Status of Your Package </h4>
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
	<?php getPackageType($tn, $db_conn); ?>

<?php dbLogout($db_conn); ?>