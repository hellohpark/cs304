<?php
require_once 'functions.php';
	session_save_path('/home/c/c4w9a/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
?>

<html>
	<head>
		<title>View Order Price</title>
	</head>

	<body>
	<h1>Order Price</h1>
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
	// $tracking = array (
		// ":bind1" => isset($_GET['tracking_number'])? "'".$_GET['tracking_number']."'":null
	// );

	// $alltrackingtuples = array (
		// $tracking
	// );

	// executeBoundSQL("DELETE FROM price WHERE tracking_number = :bind1", $alltrackingtuples, $db_conn, $success);
		
	executePlainSQL($cmdstring,$db_conn, $success);
	
	OCICommit($db_conn);	
}

function recalculatePrice($db_conn, $success) {


	// $tuple = array (
		// ":bind1" => "'".$_GET['tracking_number']."'",
		// ":bind2" => isset($_GET['toprovince'])? "'".$_GET['toprovince']."'":null,
		// ":bind3" => isset($_GET['deliverytype'])? "'".$_GET['deliverytype']."'":null,
		// ":bind4" => isset($_GET['packagetype'])? "'".$_GET['packagetype']."'":null,
	// );
	// $alltuples = array (
		// $tuple
	// );
	// executeBoundSQL("insert into price select :bind1, pr_price + pt_price + dt_price, :bind2, :bind3, :bind4 from pricematrix where pro_province_name= :bind2 and dt_type= :bind3 and pt_type = :bind4", $alltuples, $db_conn, $success);


	$tracking_number = strval($_GET['tracking_number']);
	$toprovince = isset($_GET['toprovince'])? $_GET['toprovince']:null;
	$deliverytype = isset($_GET['deliverytype'])? $_GET['deliverytype']:null;
	$packagetype = isset($_GET['packagetype'])? $_GET['packagetype']:null;
	
	// $cmdstring = "insert into price select ".$tracking_number." ,pr_price + pt_price + dt_price, ".$toprovince." , ".$deliverytype.", ".$packagetype." from pricematrix where pro_province_name= ".$toprovince." and dt_type= ".$deliverytype." and pt_type = ".$packagetype."";
		
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


			//collectClientInfo($client_id, $db_conn, $success);
			deletePrice($db_conn, $success);
			header("location: view_orders.php");
		}

			// if ((isset($_GET['toprovince'])||isset($_GET['to_province_now']))&&(isset($_GET['deliverytype'])||isset($_GET['deliverytype_now']))&&(isset($_GET['packagetype'])||(isset($_GET['packagetype_now'])))){
				// echo "true";
				// deletePrice($db_conn, $success);
				// recalculatePrice($db_conn, $success);
			// }		
	
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

