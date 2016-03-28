	<?php
	
	require_once 'functions.php';
	session_save_path('/home/c/c4w9a/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
	?>

<html>
	<head>
		<title>Edit Order - edit an order with update constraints</title>
	</head>

	<body>
	<h1>Edit Order</h1>
	<p><a href="view_orders.php">Go back to view orders</a></p>

	</body>
</html>	


<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True;
$db_conn = dbConnect();




function updateOrder($db_conn, $success) {
	$tuple = array (
				":bind1" => $_POST['tracking_number'],
				":bind2" => isset($_POST['status_new'])? $_POST['status_new']:null, //$_POST['status'], UPDATE CONSTRAINT
				":bind13" => isset($_POST['curr_location_new'])? $_POST['curr_location_new']:$_POST['curr_location'],
				":bind3" => isset($_POST['fromname'])? $_POST['fromname']:null,
				":bind4" => isset($_POST['fromaddress'])? $_POST['fromaddress']:null,
				":bind5" => isset($_POST['fromprovince'])? $_POST['fromprovince']:$_POST['from_province_current'],
				":bind6" => isset($_POST['fromphone'])? $_POST['fromphone']:null,
				":bind7" => isset($_POST['toname'])? $_POST['toname']:null,
				":bind8" => isset($_POST['toaddress'])? $_POST['toaddress']:null,
				":bind9" => isset($_POST['toprovince'])? $_POST['toprovince']:$_POST['to_province_now'],
				":bind10" => isset($_POST['tophone'])? $_POST['tophone']:null,
				":bind11" => isset($_POST['deliverytype'])? $_POST['deliverytype']:$_POST['deliverytype_now'],
 				":bind12" => isset($_POST['packagetype'])? $_POST['packagetype']:$_POST['packagetype_now']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("update orders set status=:bind2, curr_location=:bind13, SRC_NAME=:bind3, SRC_ADDR=:bind4, SRC_PROV=:bind5,
				SRC_PHONE=:bind6, DST_NAME=:bind7, DST_ADDR=:bind8, DST_PROV=:bind9, DST_PHONE=:bind10, DL_TYPE=:bind11, PK_TYPE=:bind12 where TRACKING_NUMBER=:bind1", $alltuples, $db_conn, $success);
			
								
			
			OCICommit($db_conn);
}



function inputResultEditOrder($result) { 
	echo "<fieldset>
				<legend>Edit Orders</legend>";
	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		
		$tracking_number = $row['TRACKING_NUMBER'];
		$status = $row['STATUS'];
		$SRC_NAME = $row["SRC_NAME"];
		$SRC_ADDR = $row["SRC_ADDR"];
		$SRC_PROV = $row["SRC_PROV"];
		$SRC_PHONE = $row["SRC_PHONE"];
		$DST_NAME = $row["DST_NAME"];
		$DST_ADDR = $row["DST_ADDR"];
		$DST_PROV = $row["DST_PROV"];
		$DST_PHONE = $row["DST_PHONE"];
		$DL_TYPE = $row["DL_TYPE"];
		$PK_TYPE = $row["PK_TYPE"];
		$CURR_LOCATION = $row["CURR_LOCATION"];
		
		
		
		echo "<form action='edit_orders.php' method='post'> 
		Tracking Number:  <input type='text' name='tracking_number' value='$tracking_number' readonly><br> 
		Status (SELECT AN OPTION REQUIRED):  <input type='text' name='status' value='$status' readonly><br>	
				<input type='radio' name='status_new' value='pending'>pending<br>
				<input type='radio' name='status_new' value='delivered'>delivered<br>
				<input type='radio' name='status_new' value='being processed'>being processed<br>
				<input type='radio' name='status_new' value='in transit'>in transit<br>				
		Current Location:  <input type='text' name='curr_location' value='$CURR_LOCATION' readonly><br>
				<input type='radio' name='curr_location_new' value='BC'>British Columbia<br>
				<input type='radio' name='curr_location_new' value='AB'>Alberta<br>
				<input type='radio' name='curr_location_new' value='SK'>Saskatchewan<br>
				<input type='radio' name='curr_location_new' value='MA'>Manitoba<br>
				<input type='radio' name='curr_location_new' value='ON'>Ontario<br>
				<input type='radio' name='curr_location_new' value='QC'>Quebec<br>
				<input type='radio' name='curr_location_new' value='NB'>New Brunswick<br>
				<input type='radio' name='curr_location_new' value='PE'>Prince Edward Islands<br>
				<input type='radio' name='curr_location_new' value='NL'>Newfoundland andLabrador<br>
				<input type='radio' name='curr_location_new' value='NS'>Nova Scotia<br>";	
			
		echo	"<fieldset>
				<legend>From</legend>
				Name:<br>
				<input type='text' name='fromname' value='$SRC_NAME'><br>
				Address:<br>
				<input type='text' name='fromaddress' value='$SRC_ADDR'><br>
				Province:<br>
				<input type='text' name='from_province_current' value='$SRC_PROV' readonly><br>
				<input type='radio' name='fromprovince' value='BC'>British Columbia<br>
				<input type='radio' name='fromprovince' value='AB'>Alberta<br>
				<input type='radio' name='fromprovince' value='SK'>Saskatchewan<br>
				<input type='radio' name='fromprovince' value='MA'>Manitoba<br>
				<input type='radio' name='fromprovince' value='ON'>Ontario<br>
				<input type='radio' name='fromprovince' value='QC'>Quebec<br>
				<input type='radio' name='fromprovince' value='NB'>New Brunswick<br>
				<input type='radio' name='fromprovince' value='PE'>Prince Edward Islands<br>
				<input type='radio' name='fromprovince' value='NL'>Newfoundland andLabrador<br>
				<input type='radio' name='fromprovince' value='NS'>Nova Scotia<br>
				Phone:<br>
				<input type='text' name='fromphone' value='$SRC_PHONE'><br>
			</fieldset>
			<fieldset>	
				<legend>To</legend>
				Name:<br>
				<input type='text' name='toname' value='$DST_NAME'><br>
				Address:<br>
				<input type='text' name='toaddress' value='$DST_ADDR'><br>
				Province:<br>
				<input type='text' name='to_province_now' value='$DST_PROV' readonly><br>
				<input type='radio' name='toprovince' value='BC'>British Columbia<br>
				<input type='radio' name='toprovince' value='AB'>Alberta<br>
				<input type='radio' name='toprovince' value='SK'>Saskatchewan<br>
				<input type='radio' name='toprovince' value='MA'>Manitoba<br>
				<input type='radio' name='toprovince' value='ON'>Ontario<br>
				<input type='radio' name='toprovince' value='QC'>Quebec<br>
				<input type='radio' name='toprovince' value='NB'>New Brunswick<br>
				<input type='radio' name='toprovince' value='PE'>Prince Edward Islands<br>
				<input type='radio' name='toprovince' value='NL'>Newfoundland andLabrador<br>
				<input type='radio' name='toprovince' value='NS'>Nova Scotia<br>
				Phone:<br>
				<input type='text' name='tophone' value='$DST_PHONE'><br>
			</fieldset>
			<fieldset>	
				<legend>Package Type</legend>
				<input type='text' name='packagetype_now' value='$PK_TYPE' readonly><br>
				<input type='radio' name='packagetype' value='regular letter'>Regular Letter<br>
				<input type='radio' name='packagetype' value='regular parcel'>Regular Parcel<br>
				<input type='radio' name='packagetype' value='large letter'>Large Letter<br>
				<input type='radio' name='packagetype' value='large parcel'>Large Parcel<br>
			</fieldset>
			<fieldset>
				<legend>Delivery Type</legend>
				<input type='text' name='deliverytype_now' value='$DL_TYPE' readonly><br>
				<input type='radio' name='deliverytype' value='standard'>Standard<br>
				<input type='radio' name='deliverytype' value='express'>Express<br>
				<input type='radio' name='deliverytype' value='priority'>Priority<br>
			</fieldset>
			
			<input type='submit' name='submit' value='Submit'>

		</form>		";

	}

	echo "</fieldset>";
}




// Connect Oracle...
if ($db_conn) {
	if ($authentication){
		
	} else {
		header("location: login.php");
	}

		if (array_key_exists('submit', $_POST)) {


			//collectClientInfo($client_id, $db_conn, $success);
			updateOrder($db_conn, $success);
			header("location: view_orders.php");
		}
		

		
	//echo $_POST['tracking_number'];
	$cmdstring = "select * from orders where TRACKING_NUMBER =".strval($_POST['tracking_number']);
	echo $cmdstring;
	$result = executePlainSQL($cmdstring,$db_conn, $success);
	

	inputResultEditOrder($result);
	
	
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

	
?>