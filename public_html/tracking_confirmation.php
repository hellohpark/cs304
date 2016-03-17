<?php
// NOTE: Make sure to change session path to point to your own public_html dir
session_save_path('/home/g/g3d9/public_html');
session_start();
include 'functions.php';
$db_conn = dbConnect();
$success = true;
$tracking_no = $_SESSION['tracking_num'];

if (db_conn) {
	$clients = executePlainSQL("select * from client", $db_conn, $success);
	printResult($clients);
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
	<p>Your tracking number is <? php echo $tracking_no; ?> </p>
	

