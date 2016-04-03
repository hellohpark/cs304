<?php

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

function isUniqueTrackingNumber($db_conn) {

	//Check if tracking number is already used
	do {
		$tn = getTrackingNumber();
		$sql = "select tracking_number from orders where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
	} while ($r[0] == $tn);

	return $tn;


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

function printOrdersTable($result) { 
	echo "<br>ORDERS Table:<br>";
	echo "<table>";
	echo "<tr>
	<th>TrackingNumber</th>
	<th>Status</th>
	<th>Source Information</th>
	<th>Destination Information</th>
	<th>Delivery Type</th>
	<th>Package Type</th>
	<th>Current Location</th>
	</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>".$row[0]
		."</td><td>".$row[1]
		."</td><td>".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]
		."</td><td>".$row[6]." ".$row[7]." ".$row[8]." ".$row[9]
		."</td><td>".$row[10]
		."</td><td>".$row[11]
		."</td><td>".$row[12]
		."</td></tr>"; 
	}
	echo "</table>";

}

function printPriceTable($result) { 
	echo "<br>PRICE Table:<br>";
	echo "<table>";
	echo "<tr>
	<th>TrackingNumber</th>
	<th>Total Price</th>
	<th>Destination Provice</th>
	<th>Delivery Type</th>
	<th>Package Type</th>
	</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>".$row[0]
		."</td><td>".$row[1]
		."</td><td>".$row[2]
		."</td><td>".$row[3]
		."</td><td>".$row[4]
		."</td></tr>"; 
	}
	echo "</table>";

}


// function printResult($result) { 
// 	echo "<br>Got data from table ORDERS:<br>";
// 	echo "<table>";
// 	//echo "<tr><th>TrackingNumber</th><th>Status</th></tr><th>Src_Addr</th></tr><th>Dst_Addr</th></tr><th>CurrentProvince</th></tr>";

// 	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
// 		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
// 	}
// 	echo "</table>";

// }


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

function getPrice($tracking_num, $db_conn, $success) {
	
	$pr = isset($_POST['toprovince'])? $_POST['toprovince']:null;
	$dt = isset($_POST['deliverytype'])? $_POST['deliverytype']:null;
	$pt = isset($_POST['packagetype'])? $_POST['packagetype']:null;

	$temp = executePlainSQL("select pr_price + pt_price + dt_price from pricematrix where 
			pro_province_name='$pr' and dt_type='$dt' and pt_type='$pt'", $db_conn, $success);
	$total_price;
	while ($row = OCI_Fetch_Array($temp, OCI_BOTH)) {
		echo $row[0];
		$total_price = $row[0];

	}	

	$tuple = array (
				":bind1" => $tracking_num,
				":bind2" => $total_price,
				":bind3" => isset($_POST['toprovince'])? $_POST['toprovince']:null,
				":bind4" => isset($_POST['deliverytype'])? $_POST['deliverytype']:null,
 				":bind5" => isset($_POST['packagetype'])? $_POST['packagetype']:null
			);
	$alltuples = array (
				$tuple
	);	

	$price = executeBoundSQL("insert into price values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples, $db_conn, $success);
	OCICommit($db_conn);

}

function getPriceInfo($tracking_number, $pr, $dt, $pt, $db_conn, $success){
	$temp = executePlainSQL("select pr_price from provincialrate where pro_province_name='$pr'", $db_conn, $success);
	while ($row = OCI_Fetch_Array($temp, OCI_BOTH)) {
		echo nl2br("Provincial Rate for ".$pr." = "."$".$row[0]."\n");
	}

	$temp = executePlainSQL("select dt_price from deliverytype where dt_type='$dt'", $db_conn, $success);
	while ($row = OCI_Fetch_Array($temp, OCI_BOTH)) {
		echo nl2br("Delivery Rate for ".$dt." = "."$".$row[0]."\n");

	}
	$temp = executePlainSQL("select pt_price from packagetype where pt_type='$pt'", $db_conn, $success);
	while ($row = OCI_Fetch_Array($temp, OCI_BOTH)) {
		echo nl2br("Package Rate for ".$pt." = "."$".$row[0]."\n");
	}

}


function getClientInfo($tn, $db_conn, $success) {

	//Check if order exists
	$sql = "select tracking_number from orders where tracking_number=:bind";
	$statement = OCIParse($db_conn, $sql);
	OCIBindByName($statement, ':bind', $tn);
	OCIExecute($statement, OCI_DEFAULT);
	$r = OCI_Fetch_Array($statement, OCI_BOTH);

	if ($r[0] == 0) {
		echo " <script>
		alert('An order with the tracking number you have provided does not exist.');
		window.location='index.php';
		</script>";
		return;
	}
	if (isset($_POST['status'])) {
		$sql = "select tracking_number, status, curr_location from orders where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
		echo nl2br("STATUS INFORMATION\n");
		echo nl2br("Tracking Number: ".$r[0]."\n");
		echo nl2br("Status of package: ".$r[1]."\n");
		echo nl2br("Current location of package: ".$r[2]."\n");
		echo nl2br("\n");
		echo nl2br("\n");
	}
	if (isset($_POST['from'])) {
		$sql = "select src_name, src_addr, src_prov, src_phone from orders where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
		echo nl2br("SOURCE/FROM INFORMATION\n");
		echo nl2br("Name: ".$r[0]."\n");
		echo nl2br("Address: ".$r[1]."\n");
		echo nl2br("Province: ".$r[2]."\n");
		echo nl2br("Phone: ".$r[3]."\n");
		echo nl2br("\n");
		echo nl2br("\n");
	}
	if (isset($_POST['to'])) {
		$sql = "select dst_name, dst_addr, dst_prov, dst_phone from orders where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
		echo nl2br("DESTINATION/TO INFORMATION\n");
		echo nl2br("Name: ".$r[0]."\n");
		echo nl2br("Address: ".$r[1]."\n");
		echo nl2br("Province: ".$r[2]."\n");
		echo nl2br("Phone: ".$r[3]."\n");
		echo nl2br("\n");
		echo nl2br("\n");
	}
	if (isset($_POST['dt'])) {
		$sql = "select dl_type from orders where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
		echo nl2br("Delivery Type: ".$r[0]."\n");
		echo nl2br("\n");
		echo nl2br("\n");
	}
	if (isset($_POST['pt'])) {
		$sql = "select pk_type from orders where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
		echo nl2br("Package Type: ".$r[0]."\n");
		echo nl2br("\n");
		echo nl2br("\n");
	}
	if (isset($_POST['price'])) {
		$sql = "select total_price, pr_province_name, dt_type, pt_type from price where tracking_number=:bind";
		$statement = OCIParse($db_conn, $sql);
		OCIBindByName($statement, ':bind', $tn);
		OCIExecute($statement, OCI_DEFAULT);
		$r = OCI_Fetch_Array($statement, OCI_BOTH);
		$total_price = $r[0];
		echo nl2br("PRICE INFORMATION\n");
		getPriceInfo($tn, $r[1], $r[2], $r[3], $db_conn, $success);
		echo nl2br("Total price you have paid: "."$".$r[0]."\n");
	}

}


function estimatePrice($db_conn, $success) {
	$pr = isset($_POST['toprovince'])? $_POST['toprovince']:null;
	$dt = isset($_POST['deliverytype'])? $_POST['deliverytype']:null;
	$pt = isset($_POST['packagetype'])? $_POST['packagetype']:null;


	if (isset($_POST['estimatepr'])) {
		$temp = executePlainSQL("select pr_price from provincialrate where pro_province_name='$pr'", $db_conn, $success);
		while ($r = OCI_Fetch_Array($temp, OCI_BOTH)) {
		echo nl2br($pr." Provincial Rate: "."$".$r[0]."\n");
		}
	}
	if (isset($_POST['estimatedt'])) {
		$temp = executePlainSQL("select dt_price from deliverytype where dt_type='$dt'", $db_conn, $success);
		while ($r = OCI_Fetch_Array($temp, OCI_BOTH)) {
			echo nl2br($dt." Delivery Type Price: "."$".$r[0]."\n");

		}
	}
	if (isset($_POST['estimatept'])) {
		$temp = executePlainSQL("select pt_price from packagetype where pt_type='$pt'", $db_conn, $success);
		while ($r= OCI_Fetch_Array($temp, OCI_BOTH)) {
			echo nl2br($pt." Package Type Price: "."$".$r[0]."\n");

		}
	}
	if (isset($_POST['estimatetotal'])) {
		$temp = executePlainSQL("select pr_price + pt_price + dt_price from provincialrate cross join deliverytype
		cross join packagetype where pro_province_name='$pr' and dt_type='$dt' and pt_type='$pt'", $db_conn, $success);
		while ($r = OCI_Fetch_Array($temp, OCI_BOTH)) {
			echo nl2br("Total Price: "."$".$r[0]."\n");

		}	
	}
}



function checkValidOrder($phonenum, $name) {
	// Invalid phone number
	
	if (!preg_match("/^[0-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]$/", $phonenum) ||
		!preg_match("/^[a-zA-Z ]*$/", $name)) {
		return false;
	}
	else return true;

}



?>


