<?php 
session_save_path('/home/g/g3d9/public_html');
session_start();
require 'functions.php';

$tracking_num = getTrackingNumber();
$_SESSION['tracking_num'] = $tracking_num;

?>


<!--TODO: Prevent empty forms from being submitted-->
<html>
	<head>
		<title>Order Page - CPSC 304 Post Office</title>
	</head>

	<body>
		<p><a href="index.php">HOME - TRACK YOUR ORDER </a></p>
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
				<input type="radio" name="toprovince" value="BC" required>British Columbia<br>
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
				<input type="radio" name="packagetype" value="regular letter" required>Regular Letter<br>
				<input type="radio" name="packagetype" value="regular parcel">Regular Parcel<br>
				<input type="radio" name="packagetype" value="large letter">Large Letter<br>
				<input type="radio" name="packagetype" value="large parcel">Large Parcel<br>
			</fieldset>
			<fieldset>
				<legend>Delivery Type</legend>
				<input type="radio" name="deliverytype" value="standard" required>Standard<br>
				<input type="radio" name="deliverytype" value="express">Express<br>
				<input type="radio" name="deliverytype" value="priority">Priority<br>
			</fieldset>
			
			<input type="submit" name="submit" value="Submit">

		</form>
		<form method="POST" action="order.php">
   
		<p><input type="submit" value="Reset" name="reset"></p>
		</form>

	</body>
</html>	


<?php
$success = True; 
$db_conn = dbConnect();

$_SESSION['toprovince'] = $_POST['toprovince'];
$_SESSION['packagetype'] = $_POST['packagetype'];
$_SESSION['deliverytype'] = $_POST['deliverytype'];
$_SESSION['db'] = $db_conn;


if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
		
		executePlainSQL("delete from orders", $db_conn, $success);
		executePlainSQL("delete from price", $db_conn, $success);
		OCICommit($db_conn);

		if ($_POST && $success) {		
			header("location: order.php");
		}

	} else if (array_key_exists('submit', $_POST)) {

		//Invalid phone number
		if (checkValidOrder($_POST['tophone'])&&checkValidOrder($_POST['fromphone'])&&
			checkValidOrder($_POST['toname'])&&checkValidOrder($_POST['fromname'])) {
				placeOrder($tracking_num, $db_conn, $success);
				getPrice($tracking_num, $db_conn, $success);
				header("location: price.php");
		}
		else {
			echo "<script> alert('Please input valid names and phone numbers:\\nNames should be composed of upper and lower case only\\nPhone numbers should consist of numbers from 0-9 and be in the form: xxx-xxx-xxxx');
			window.location = 'order.php';</script>";
		
		}
	}

		$orders = executePlainSQL("select * from orders", $db_conn, $success);
		printResult($orders);

		$price = executePlainSQL("select * from price", $db_conn, $success);
		printResult($price);
		


	dbLogout($db_conn);


} 
else {
//TODO: Error handling
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>

