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
	echo "<tr><th>Tracking Number</th><th>Status</th><th>Source Address</th><th>Destination Address</th><th>Current Location</th><th>Edit</th></tr>";

	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["TRACKING_NUMBER"] . "</td><td>" . $row["STATUS"] . "</td><td>" . $row["SRC_NAME"] . "</td><td>" . $row["SRC_ADDR"] . "</td><td>" . $row["SRC_PROV"] . "</td>";
		echo "<td><form action='edit_orders.php' method='GET'><input type='hidden' name='orderId' value=".$row["TRACKING_NUMBER"]."><input type='submit' name='submit-btn' value='Update Details' /></form></td>";
		echo "<td>" . $row["SRC_PHONE"] . "</td><td>" . $row["DST_NAME"] . "</td><td>" . $row["DST_ADDR"] . "</td><td>" . $row["DST_PROV"] . "</td><td>" . $row["DST_PHONE"] . "</td><td>" . $row["DL_TYPE"] . "</td><td>" . $row["PK_TYPE"] . "</td></tr>"; //or just use "echo $row[0]" 
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
			//echo strtoupper($_GET['prov']);
			$province = array (
 				":bind1" => isset($_GET['prov'])? strtoupper($_GET['prov']):null
				//":bind1" => strtoupper($_GET['prov'])
			);

			$allprovincetuples = array (
				$province
			);

		$results = executeBoundSQLs("select * from orders where src_prov = :bind1", $allprovincetuples, $db_conn, $success);
		// $resultBC = executePlainSQL("select * from orders where src_prov = 'BC'", $db_conn, $success);
		// $resultAB = executePlainSQL("select * from orders where src_prov = 'AB'", $db_conn, $success);
		// $resultSK = executePlainSQL("select * from orders where src_prov = 'SK'", $db_conn, $success);
		// $resultMA = executePlainSQL("select * from orders where src_prov = 'MA'", $db_conn, $success);
		// $resultON = executePlainSQL("select * from orders where src_prov = 'ON'", $db_conn, $success);
		// $resultQC = executePlainSQL("select * from orders where src_prov = 'QC'", $db_conn, $success);
		// $resultNB = executePlainSQL("select * from orders where src_prov = 'NB'", $db_conn, $success);
		// $resultPE = executePlainSQL("select * from orders where src_prov = 'PE'", $db_conn, $success);
		// $resultNL = executePlainSQL("select * from orders where src_prov = 'NL'", $db_conn, $success);
		// $resultNS = executePlainSQL("select * from orders where src_prov = 'NS'", $db_conn, $success);
		
		
		
		printResultViewOrder($results);
		// printResultViewOrder($resultBC);
		// printResultViewOrder($resultAB);
		// printResultViewOrder($resultSK);
		// printResultViewOrder($resultMA);
		// printResultViewOrder($resultON);
		// printResultViewOrder($resultQC);
		// printResultViewOrder($resultNB);
		// printResultViewOrder($resultPE);
		// printResultViewOrder($resultNL);
		// printResultViewOrder($resultNS);
	}

// Connect Oracle...
if ($db_conn) {

	processPage($db_conn, $success);

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}




	
?>

