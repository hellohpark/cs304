<!--Test Oracle file for UBC CPSC304 2011 Winter Term 2
  Created by Jiemin Zhang
  Modified by Simona Radu
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

<html>
	<head>
		<title>Order Page - CPSC 304 Post Office</title>
	</head>

	<body>
		<p><a href="index.php">HOME - TRACK YOUR ORDER</a></p>
		<h1>Place An Order</h1>
		<form action="testing.php" method="post">
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

		<form method="POST" action="testing.php">
   
	<p><input type="submit" value="Reset" name="reset"></p>
	</form>


	</body>
</html>	


<?php

include 'functions.php';

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = dbConnect();

$client_id = getClientID();
$tracking_num = getTrackingNum();

if ($db_conn) {

	// TODO: Not working properly
	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> Removing all rows <br>";
		executePlainSQL("delete from client", $db_conn, $success);

		// // Create new table...
		// echo "<br> creating new table <br>";
		// executePlainSQL("create table tab1 (nid number, name varchar2(30), primary key (nid))");
		OCICommit($db_conn);

	} else 
		if (array_key_exists('submit', $_POST)) {


			collectClientInfo($client_id, $db_conn, $success);
			placeOrder($tracking_num, $db_conn, $success);

	}


	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: order.php");	//TODO: will throw an error
	} else {
	// Select data...
		$result = executePlainSQL("select * from client", $db_conn, $success);
		printResult($result);	
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

