
<h1>Price Information</h1>
	
	<h3>Order Price Information</h3>
	
	<?php
	// NOTE: Make sure to change session path to point to your own public_html dir
	session_save_path('/home/g/g3d9/public_html');
	session_start();

	$tn = $_SESSION['tracking_num'];
	$pr = $_SESSION['toprovince']; 
	$pt = $_SESSION['packagetype'];
	$dt = $_SESSION['deliverytype'];

	require 'functions.php';
	$db_conn = dbConnect();
	$success = true;

	if ($db_conn) {

		echo nl2br("Tracking Number: ".$tn."\n");
		getTotalPrice($tn, $pr, $dt, $pt, $db_conn, $success);
	
		$temp = executePlainSQL("select pr_price + pt_price + dt_price from pricematrix where 
			pro_province_name='$pr' and dt_type='$dt' and pt_type='$pt'", $db_conn, $success);
		while ($row = OCI_Fetch_Array($temp, OCI_BOTH)) {
			echo nl2br("Total Price "." = "."$".$row[0]."\n");

		}
			
	}

	dbLogout($db_conn);

	?> 
	<br>
	<form action='payment.php'>
		<input type="submit" name="pay" value="Pay by Credit">
	</form>
	<form method="POST" action="price.php">
		<input type="submit" name="cancel" value="Cancel Order">
	</form>

<?php
$success = True; 

if ($db_conn) {

	if (array_key_exists('cancel', $_POST)) {
		
		executePlainSQL("delete from orders where tracking_number='$tn'", $db_conn, $success);
		executePlainSQL("delete from price where tracking_number='$tn'", $db_conn, $success);
		OCICommit($db_conn);
	}

	if ($_POST && $success) {		
		header("location: index.php");
	}
	dbLogout($db_conn);
}
?>
	