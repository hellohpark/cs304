
<h1>Tracking Information</h1>
	<p><a href="index.php">HOME - TRACK YOUR ORDER</a><br>
	<a href="order.php">PLACE A NEW ORDER</a></p>
	<h3>Your Information</h3>
	<h4>Tracking Number</h4>
	<p>Your tracking number is
	<?php
	// NOTE: Make sure to change session path to point to your own public_html dir
	session_save_path('/home/g/v7e8/public_html');
	session_start();

	$tn = $_SESSION['tracking_num'];
	echo $tn;

	require 'functions.php';
	$db_conn = dbConnect();
	$success = true;

	if ($db_conn) {
	
		$orders = executePlainSQL("select * from orders", $db_conn, $success);
		printResult($orders);
		$prices = executePlainSQL("select * from price", $db_conn, $success);
		printResult($prices);
	}

	dbLogout($db_conn);

	?> </p>
	

