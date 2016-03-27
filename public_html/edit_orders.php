	<?php
	
	require_once 'functions.php';
	session_save_path('/home/c/c4w9a/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
	?>

<html>
	<head>
		<title>Edit Orders</title>
	</head>

	<body>
	<h1>Edit Order</h1>

	</body>
</html>	


<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True;
$db_conn = dbConnect();



function updateOrder($db_conn, $success) {
	$tuple = array (
				":bind1" => $_POST['trackingno'],
				":bind2" => $_POST['status'],
				":bind3" => isset($_POST['fromname'])? $_POST['fromname']:null,
				":bind4" => isset($_POST['fromaddress'])? $_POST['fromaddress']:null,
				":bind5" => isset($_POST['fromprovince'])? $_POST['fromprovince']:null,
				":bind6" => isset($_POST['fromphone'])? $_POST['fromphone']:null,
				":bind7" => isset($_POST['toname'])? $_POST['toname']:null,
				":bind8" => isset($_POST['toaddress'])? $_POST['toaddress']:null,
				":bind9" => isset($_POST['toprovince'])? $_POST['toprovince']:null,
				":bind10" => isset($_POST['tophone'])? $_POST['tophone']:null,
				":bind11" => isset($_POST['deliverytype'])? $_POST['deliverytype']:null,
 				":bind12" => isset($_POST['packagetype'])? $_POST['packagetype']:null
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("update orders set status=:bind2, SRC_NAME=:bind3, SRC_ADDR=:bind4, SRC_PROV=:bind5,
				SRC_PHONE=:bind6, DST_NAME=:bind7, DST_ADDR=:bind8, DST_PROV=:bind9, DST_PHONE=:bind10, DL_TYPE=:bind11, PK_TYPE=:bind12 where TRACKING_NUMBER=:bind1", $alltuples, $db_conn, $success);
			OCICommit($db_conn);
}



function inputResultEditOrder($result) { 
	echo "<fieldset>
				<legend>Edit Orders</legend>";

	
	
	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		
		$trackingno = $row['TRACKING_NUMBER'];
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
		
		
		
		echo "<form action='edit_orders.php' method='post'> Tracking Number:  <input type='text' name='trackingno' value='$trackingno' readonly><br> Status:  <input type='text' name='status' value='$status' readonly><br>";
			
			
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
				<input type='radio' name='packagetype' value='Regular Letter'>Regular Letter<br>
				<input type='radio' name='packagetype' value='Regular Parcel'>Regular Parcel<br>
				<input type='radio' name='packagetype' value='Large Letter'>Large Letter<br>
				<input type='radio' name='packagetype' value='Large Parcel'>Large Parcel<br>
			</fieldset>
			<fieldset>
				<legend>Delivery Type</legend>
				<input type='text' name='deliverytype_now' value='$DL_TYPE' readonly><br>
				<input type='radio' name='deliverytype' value='Standard'>Standard<br>
				<input type='radio' name='deliverytype' value='Express'>Express<br>
				<input type='radio' name='deliverytype' value='Priority'>Priority<br>
			</fieldset>
			
			<input type='submit' name='submit' value='Submit'>

		</form>		";

		
		
	}

	echo "</fieldset>";

}


// Connect Oracle...
if ($db_conn) {


		if (array_key_exists('submit', $_POST)) {


			//collectClientInfo($client_id, $db_conn, $success);
			updateOrder($db_conn, $success);
			header("location: view_orders.php?prov=bc");

		}
		

	//echo $_GET['orderId'];
	$cmdstring = "select * from orders where TRACKING_NUMBER =".strval($_GET['orderId']);
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