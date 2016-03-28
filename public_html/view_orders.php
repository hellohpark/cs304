<?php
require_once 'functions.php';
	session_save_path('/home/c/c4w9a/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
?>

<html>
	<head>
		<title>View Orders</title>
	</head>

	<body>
	<h1>Orders in Province</h1>
	</body>
</html>	
			
<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True;
$db_conn = dbConnect();

function printResultViewOrder($result) { 
	echo "<fieldset>
				<legend>Orders</legend>";
	echo "<table>";
	echo "<tr><th>Tracking Number</th><th>Status</th><th>Source Address</th><th>Destination Address</th><th>Current Location</th><th>Delivery Type</th><th>Package Type</th><th>Edit</th></tr>";

	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		$TRACKING_NUMBER = strtolower($row["TRACKING_NUMBER"]);
		$DST_PROV = $row["DST_PROV"];
		$DL_TYPE = strtolower($row["DL_TYPE"]);
		$PK_TYPE = strtolower($row["PK_TYPE"]);
		
		
		echo "<tr><td>" . 
		$row["TRACKING_NUMBER"] . "</td><td>" . 
		$row["STATUS"] . "</td><td>" . 
		$row["SRC_NAME"]. ", " .
		$row["SRC_ADDR"]. ", " .
		$row["SRC_PROV"]. ", " .
		$row["SRC_PHONE"] . "</td><td>" . 
		$row["DST_NAME"]. ", " .
		$row["DST_ADDR"]. ", " .
		$row["DST_PROV"]. ", " .
		$row["DST_PHONE"] . "</td><td>" . 
		$row["CURR_LOCATION"] . "</td><td>" . 
		$row["DL_TYPE"] . "</td><td>" . 
		$row["PK_TYPE"] . "</td>";
		echo "<td>
		<form action='edit_orders.php' method='POST'>
		<input type='hidden' name='tracking_number' value='$TRACKING_NUMBER'>
		<input type='submit' name='submit-btn' value='Update Details' />
		</form>
		<form action='view_order_price.php' method='GET'>
		<input type='hidden' name='tracking_number' value='$TRACKING_NUMBER'>
		<input type='hidden' name='toprovince' value='$DST_PROV'>
		<input type='hidden' name='deliverytype' value='$DL_TYPE'>
		<input type='hidden' name='packagetype' value='$PK_TYPE'>
		<input type='submit' name='price' value='Price' />
		</form></td>
		</tr>";
		
	}
	echo "</table>";
	echo "</fieldset>";

}


function executeBoundSQLs($cmdstr, $list, $db_conn, $success) {
	
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo "<br>".$val;
			//echo "<br>".$bind."<br>";
			
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		
		//echo $statement;
		
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); 
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
		
	}
	return $statement;
}


function processPage($db_conn, $success) {
			echo "select * from orders where curr_location =".strtoupper($_GET['prov']);
			$province = array (
 				":bind1" => isset($_GET['prov'])? strtoupper($_GET['prov']):null
				//":bind1" => strtoupper($_GET['prov'])
			);

			$allprovincetuples = array (
				$province
			);

		$results = executeBoundSQLs("select * from orders where curr_location = :bind1", $allprovincetuples, $db_conn, $success);
		
		return $results;

	}

// Connect Oracle...
if ($db_conn) {

	$province = $_GET['prov'];
	
	if (!isset($_GET['prov'])){
		$query_result = executePlainSQL("select * from orders", $db_conn, $success);
		echo "select * from orders";
	} else if (isset($_GET['prov'])){
		$query_result = processPage($db_conn, $success);
	} else {
		$query_result = executePlainSQL("select * from orders", $db_conn, $success);
		echo "select * from orders";
	}
	
	
	printResultViewOrder($query_result);

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

	
?>

