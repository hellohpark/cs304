<?php
include 'functions.php';
?>

<html>
	<head>
		<title>View Orders</title>
	</head>

	<body>
	</body>
</html>	
			
<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True;
$db_conn = dbConnect();

function printResultViewOrder($result) { 
	echo "<fieldset>
				<legend>Province</legend>";
	echo "<table>";
	echo "<tr><th>Tracking Number</th><th>Status</th><th>Source Address</th><th>Destination Address</th><th>Current Location</th><th>Edit</th></tr>";

	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["TRACKING_NUMBER"] . "</td><td>" . $row["STATUS"] . "</td><td>" . $row["SRC_NAME"] . "</td><td>" . $row["SRC_ADDR"] . "</td><td>" . $row["SRC_PROV"] . "</td><td>" . $row["SRC_PHONE"] . "</td><td>" . $row["DST_NAME"] . "</td><td>" . $row["DST_ADDR"] . "</td><td>" . $row["DST_PROV"] . "</td><td>" . $row["DST_PHONE"] . "</td><td>" . $row["DL_TYPE"] . "</td><td>" . $row["PK_TYPE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
	echo "</fieldset>";

}

// Connect Oracle...
if ($db_conn) {

		$result = executePlainSQL("select * from orders", $db_conn, $success);
		$resultBC = executePlainSQL("select * from orders where src_prov = 'BC'", $db_conn, $success);
		$resultAB = executePlainSQL("select * from orders where src_prov = 'AB'", $db_conn, $success);
		$resultSK = executePlainSQL("select * from orders where src_prov = 'SK'", $db_conn, $success);
		$resultMA = executePlainSQL("select * from orders where src_prov = 'MA'", $db_conn, $success);
		$resultON = executePlainSQL("select * from orders where src_prov = 'ON'", $db_conn, $success);
		$resultQC = executePlainSQL("select * from orders where src_prov = 'QC'", $db_conn, $success);
		$resultNB = executePlainSQL("select * from orders where src_prov = 'NB'", $db_conn, $success);
		$resultPE = executePlainSQL("select * from orders where src_prov = 'PE'", $db_conn, $success);
		$resultNL = executePlainSQL("select * from orders where src_prov = 'NL'", $db_conn, $success);
		$resultNS = executePlainSQL("select * from orders where src_prov = 'NS'", $db_conn, $success);
		
		printResultViewOrder($result);
		printResultViewOrder($resultBC);
		printResultViewOrder($resultAB);
		printResultViewOrder($resultSK);
		printResultViewOrder($resultMA);
		printResultViewOrder($resultON);
		printResultViewOrder($resultQC);
		printResultViewOrder($resultNB);
		printResultViewOrder($resultPE);
		printResultViewOrder($resultNL);
		printResultViewOrder($resultNS);

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}




	
?>

