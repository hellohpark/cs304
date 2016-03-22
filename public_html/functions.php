<?php

$client_id;

function dbConnect() {
	// NOTE: Change DB information to your own
	return OCILogon("ora_g3d9", "a30775134", "ug");
}

function dbLogout($db_conn) {
	OCILogoff($db_conn);
}


function getTrackingNumber() {
	$tracking_num = mt_rand(1111, 9999);
	return $tracking_num;
}

function executePlainSQL($cmdstr, $db_conn, $success) { 
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

	function executeBoundSQL($cmdstr, $list, $db_conn, $success) {
	
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


function signIn($db_conn, $success){
		$orders = executePlainSQL("select * from login", $db_conn, $success);
	
	
}


function placeOrder($tracking_num, $db_conn, $success) {
	$status = 'pending';
	$curr_loc = isset($_POST['fromprovince'])? $_POST['fromprovince']:null;
	$tuple = array (
				":bind1" => $tracking_num,
				":bind2" => $status,
				":bind3" => isset($_POST['fromname'])? $_POST['fromname']:null,
				":bind4" => isset($_POST['fromaddress'])? $_POST['fromaddress']:null,
				":bind5" => $curr_loc,
				":bind6" => isset($_POST['fromphone'])? $_POST['fromphone']:null,
				":bind7" => isset($_POST['toname'])? $_POST['toname']:null,
				":bind8" => isset($_POST['toaddress'])? $_POST['toaddress']:null,
				":bind9" => isset($_POST['toprovince'])? $_POST['toprovince']:null,
				":bind10" => isset($_POST['tophone'])? $_POST['tophone']:null,
				":bind11" => isset($_POST['deliverytype'])? $_POST['deliverytype']:null,
 				":bind12" => isset($_POST['packagetype'])? $_POST['packagetype']:null,
 				":bind13" => $curr_loc
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into orders values (:bind1, :bind2, :bind3, :bind4, :bind5,
				:bind6, :bind7, :bind8, :bind9, :bind10, :bind11, :bind12, :bind13)", $alltuples, $db_conn, $success);
			OCICommit($db_conn);
}


function getClientInfo($tracking_number, $db) {

	$db_conn = $db;

	//Fetch tracking number provided by client
	$tn = $tracking_number;

	$sql = "select * from orders where tracking_number=:bind";
	$statement = OCIParse($db_conn, $sql);
	OCIBindByName($statement, ':bind', $tn);
	OCIExecute($statement, OCI_DEFAULT);

	$result = OCI_Fetch_Array($statement, OCI_BOTH);
	return $result;

}

function getStatus($tracking_number, $db) {
	$r = getClientInfo($tracking_number, $db);
	echo nl2br("Tracking Number: ".$r[0]."\n");
	echo nl2br("Status of package: ".$r[1]."\n");
	echo nl2br("Current location of package: ".$r[12]."\n");
}

function getSrcInfo($tracking_number, $db){
	$r = getClientInfo($tracking_number, $db);
	echo nl2br("Name: ".$r[2]."\n");
	echo nl2br("Address: ".$r[3]."\n");
	echo nl2br("Province: ".$r[4]."\n");
	echo nl2br("Phone: ".$r[5]."\n");
}

function getDstInfo($tracking_number, $db) {
	$r = getClientInfo($tracking_number, $db);
	echo nl2br("Name: ".$r[6]."\n");
	echo nl2br("Address: ".$r[7]."\n");
	echo nl2br("Province: ".$r[8]."\n");
	echo nl2br("Phone: ".$r[9]."\n");

}

function getDeliveryType($tracking_number, $db) {
	$r = getClientInfo($tracking_number, $db);
	echo nl2br($r[10]."\n");

}

function getPackageType($tracking_number, $db) {
	$r = getClientInfo($tracking_number, $db);
	echo nl2br($r[11]."\n");
}






?>