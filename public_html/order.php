<?php 
include 'functions.php';
// NOTE: Make sure to change session path to point to your own public_html dir
session_save_path('/home/g/g3d9/public_html');
session_start();
// Tracking # = client_id
$tracking_num = getTrackingNum();
$client_id = $tracking_num;

$_SESSION['tracking_num'] = $tracking_num;

?>


<html>
	<head>
		<title>Order Page - CPSC 304 Post Office</title>
	</head>

	<body>
		<p><a href="index.php">HOME - TRACK YOUR ORDER</a></p>
		<h1>Place An Order HIHIHIHIHIHIH</h1>
		<!--TODO: change destination for action after submit pressed-->
		<form action="order.php" method="post">
			<fieldset>
				<legend>From</legend>
				Name:<br>
				<input type="text" name="fromname"><br>
				Address:<br>
				<input type="text" name="fromaddress"><br>
				Province:<br>
				<input type="radio" name="fromprovince" value="BC">British Columbia<br>
				<input type="radio" name="fromprovince" value="AB">Alberta<br>
				<input type="radio" name="fromprovince" value="SK">Saskatchewan<br>
				<input type="radio" name="fromprovince" value="MA">Manitoba<br>
				<input type="radio" name="fromprovince" value="ON">Ontario<br>
				<input type="radio" name="fromprovince" value="QC">Quebec<br>
				<input type="radio" name="fromprovince" value="NB">New Brunswick<br>
				<input type="radio" name="fromprovince" value="PE">Prince Edward Islands<br>
				<input type="radio" name="fromprovince" value="NL">Newfoundland andLabrador<br>
				<input type="radio" name="fromprovince" value="NS">Nova Scotia<br>
				Phone:<br>
				<input type="text" name="fromphone"><br>
			</fieldset>
			<fieldset>	
				<legend>To</legend>
				Name:<br>
				<input type="text" name="toname"><br>
				Address:<br>
				<input type="text" name="toaddress"><br>
				Province:<br>
				<input type="radio" name="toprovince" value="BC">British Columbia<br>
				<input type="radio" name="toprovince" value="AB">Alberta<br>
				<input type="radio" name="toprovince" value="SK">Saskatchewan<br>
				<input type="radio" name="toprovince" value="MA">Manitoba<br>
				<input type="radio" name="toprovince" value="ON">Ontario<br>
				<input type="radio" name="toprovince" value="QC">Quebec<br>
				<input type="radio" name="toprovince" value="NB">New Brunswick<br>
				<input type="radio" name="toprovince" value="PE">Prince Edward Islands<br>
				<input type="radio" name="toprovince" value="NL">Newfoundland andLabrador<br>
				<input type="radio" name="toprovince" value="NS">Nova Scotia<br>
				Phone:<br>
				<input type="text" name="tophone"><br>
			</fieldset>
			<fieldset>	
				<legend>Package Type</legend>
				<input type="radio" name="packagetype" value="Regular Letter">Regular Letter<br>
				<input type="radio" name="packagetype" value="Regular Parcel">Regular Parcel<br>
				<input type="radio" name="packagetype" value="Large Letter">Large Letter<br>
				<input type="radio" name="packagetype" value="Large Parcel">Large Parcel<br>
			</fieldset>
			<fieldset>
				<legend>Delivery Type</legend>
				<input type="radio" name="deliverytype" value="Standard">Standard<br>
				<input type="radio" name="deliverytype" value="Express">Express<br>
				<input type="radio" name="deliverytype" value="Priority">Priority<br>
			</fieldset>
			
			<input type="submit" name="submit" value="Submit">

		</form>
		<form method="POST" action="order.php">
   
		<p><input type="submit" value="Reset" name="reset"></p>
		</form>

	</body>
</html>	


<?php

//include 'functions.php';

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = dbConnect();


// // Tracking # = client_id
// $tracking_num = getTrackingNum();
// $client_id = $tracking_num;

// $_SESSION['tracking_num'] = $tracking_num;
// //setClientID($client_id);

if ($db_conn) {

	// TODO: Not working properly
	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> Removing all rows <br>";
		executePlainSQL("delete from client", $db_conn, $success);
		executePlainSQL("delete from orders", $db_conn, $success);

		// // Create new table...
		// echo "<br> creating new table <br>";
		// executePlainSQL("create table tab1 (nid number, name varchar2(30), primary key (nid))");
		OCICommit($db_conn);

		if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: order.php");	//TODO: will throw an error
	}

	} else 
		if (array_key_exists('submit', $_POST)) {


			collectClientInfo($client_id, $db_conn, $success);
			placeOrder($tracking_num, $db_conn, $success);
		}

			if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: tracking_confirmation.php");
		//TODO: resetting will take client to tracking_confirmation
		}
		else {
			$clients = executePlainSQL("select * from client", $db_conn, $success);
		printResult($clients);
		$orders = executePlainSQL("select * from orders", $db_conn, $success);
		printResult($orders);

		}

	

}

		//Commit to save changes...
	dbLogout($db_conn);
// } else {
// 		echo "cannot connect";
// 		$e = OCI_Error(); // For OCILogon errors pass no handle
// 		echo htmlentities($e['message']);
// 	}

?>

