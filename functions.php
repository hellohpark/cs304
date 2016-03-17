<?php

$cid;

function dbConnect() {
	return OCILogon("ora_g3d9", "a30775134", "ug");
}

function dbLogout($db_conn) {
	OCILogoff($db_conn);
}

function setClientID($client_id) {
	global $cid;
	$cid = $client_id;
}
function fetchClientID() {
	return $cid;
}

function getTrackingNum() {
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

function collectClientInfo($client_id, $db_conn, $success) {
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
				:bind6, :bind7, :bind8, :bind9, :bind10, :bind11)", $alltuples, $db_conn, $success);
			OCICommit($db_conn);
}

function placeOrder($tracking_num, $db_conn, $success) {
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
			executeBoundSQL("insert into orders values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples, $db_conn, $success);
			OCICommit($db_conn);

}

?>