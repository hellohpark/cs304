<?php
require_once 'functions.php';
session_save_path('/home/g/g3d9/public_html');
session_start();

$authentication = $_SESSION['authenticated'];
?>

<html>
	<head>
		<title>View Order Price - view price of an order, recalculate price at each page load</title>
	</head>

	<body>
	<h1>Order Price</h1>
	<p><a href="view_orders.php">Go back to view orders</a></p>
	</body>
</html>	
			
<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True;
$db_conn = dbConnect();


function deletePrice($db_conn, $success) {


	$cmdstring = "DELETE FROM price WHERE tracking_number ='".strval($_GET['tracking_number'])."'";
	echo "<br>".$cmdstring."<br>";

	executePlainSQL($cmdstring,$db_conn, $success);
	
	OCICommit($db_conn);	
}

function recalculatePrice($db_conn, $success) {


	$tracking_number = strval($_GET['tracking_number']);
	$toprovince = isset($_GET['toprovince'])? $_GET['toprovince']:null;
	$deliverytype = isset($_GET['deliverytype'])? $_GET['deliverytype']:null;
	$packagetype = isset($_GET['packagetype'])? $_GET['packagetype']:null;
	
		
		$cmdstring = "insert into price select '".$tracking_number."' ,pr_price + pt_price + dt_price, '".$toprovince."' , '".$deliverytype."', '".$packagetype."' from pricematrix where pro_province_name= '".$toprovince."' and dt_type= '".$deliverytype."' and pt_type = '".$packagetype."'";
		
	echo $cmdstring;
	
	executePlainSQL($cmdstring,$db_conn, $success);
		
	OCICommit($db_conn);	
}


function inputResultPrice($priceresult){
	echo "<fieldset>
				<legend>Order Price</legend>";
				
		while ($row = OCI_Fetch_Array($priceresult, OCI_BOTH)) {
		
			$tracking_number = $row['TRACKING_NUMBER'];
			$total_price = $row['TOTAL_PRICE'];
			$pr_province_name = $row["PR_PROVINCE_NAME"];
			$dt_type = $row["DT_TYPE"];
			$pt_type = $row["PT_TYPE"];

		echo "<form action='view_order_price.php' method='get'> 
		 
		Tracking Number:  <input type='text' name='tracking_number' value='$tracking_number' readonly><br>
		Total Price:  <input type='text' name='total_price' value='$total_price' readonly><br>
		Destination Province:  <input type='text' name='pr_province_name' value='$pr_province_name' readonly><br>
		Delivery Type:  <input type='text' name='dt_type' value='$dt_type' readonly><br>
		Package Type:  <input type='text' name='pt_type' value='$pt_type' readonly><br>
				
			<input type='submit' name='delete_price' value='Delete Price'>

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
		if (array_key_exists('delete_price', $_GET)) {


			deletePrice($db_conn, $success);
			header("location: view_orders.php");
		}


	
	deletePrice($db_conn, $success);
	recalculatePrice($db_conn, $success);
	
	$cmdstring2 = "select * from price where TRACKING_NUMBER = '".strval($_GET['tracking_number'])."'";
	echo "<br>".$cmdstring2."<br>";
	$priceresult = executePlainSQL($cmdstring2,$db_conn, $success);

	
	inputResultPrice($priceresult);

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

	
?>

