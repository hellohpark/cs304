<html>
	<head>
		<title>Order Page - CPSC 304 Post Office</title>
	</head>

	<body>
		<p><a href="index.php">HOME - TRACK YOUR ORDER</a></p>
		<h1>Place An Order</h1>
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
	</body>
</html>	


<?php

function dbConnect() {
	return OCILogon("ora_g3d9", "a30775134", "ug");
}


$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = dbConnect();

function dbLogout() {
	global $db_conn;
	OCILogoff($db_conn);
}
$client_id = mt_rand(1111,9999);
$tracking_num = mt_rand(1111, 9999);

function executePlainSQL($cmdstr) { 
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); 

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);        
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); 
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;
}

	function executeBoundSQL($cmdstr, $list) {
	
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); 
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}

}

function printResult($result) { 
	echo "<br>Got data from table client:<br>";
	echo "<table>";
	//echo "<tr><th>TrackingNumber</th><th>Status</th></tr><th>Src_Addr</th></tr><th>Dst_Addr</th></tr><th>CurrentProvince</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
	}
	echo "</table>";

}

function collectClientInfo() {
	global $client_id, $db_conn;
	$tuple = array (
				":bind1" => $client_id,
				":bind2" => isset($_POST['fromname'])? $_POST['fromname']:null,
				":bind3" => isset($_POST['fromaddress'])? $_POST['fromaddress']:null,
				":bind4" => isset($_POST['fromprovince'])? $_POST['fromprovince']:null,
				":bind5" => isset($_POST['fromphone'])? $_POST['fromphone']:null,
				":bind6" => isset($_POST['toname'])? $_POST['toname']:null,
				":bind7" => isset($_POST['toaddress'])? $_POST['toaddress']:null,
				":bind8" => isset($_POST['toprovince'])? $_POST['toprovince']:null,
				":bind9" => isset($_POST['tophone'])? $_POST['tophone']:null,
				":bind10" => isset($_POST['deliverytype'])? $_POST['deliverytype']:null,
				":bind11" => isset($_POST['packagetype'])? $_POST['packagetype']:null
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into client values (:bind1, :bind2, :bind3, :bind4, :bind5,
				:bind6, :bind7, :bind8, :bind9, :bind10, :bind11)", $alltuples);
			OCICommit($db_conn);
}

function placeOrder() {
	global $tracking_num, $db_conn;
	$status = 'pending';
	$tuple = array (
				":bind1" => $tracking_num,
				":bind2" => $status,
				":bind3" => isset($_POST['fromaddress'])? $_POST['fromaddress']:null,
				":bind4" => isset($_POST['toaddress'])? $_POST['toaddress']:null,
				":bind5" => isset($_POST['fromprovince'])? $_POST['fromprovince']:null
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into orders values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
			OCICommit($db_conn);

}

if ($db_conn) {

	// TODO: Not working properly
	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> Removing all rows <br>";
		executePlainSQL("Delete from orders");

		// // Create new table...
		// echo "<br> creating new table <br>";
		// executePlainSQL("create table tab1 (nid number, name varchar2(30), primary key (nid))");
		OCICommit($db_conn);

	} else 
		if (array_key_exists('submit', $_POST)) {

			collectClientInfo();
			placeOrder();

	}


	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: order.php");	//TODO: will throw an error
	} else {
	// Select data...
		$result = executePlainSQL("select * from client");
		printResult($result);	
	}

		//Commit to save changes...
	dbLogout();
// } else {
// 		echo "cannot connect";
// 		$e = OCI_Error(); // For OCILogon errors pass no handle
// 		echo htmlentities($e['message']);
// 	}


?>

