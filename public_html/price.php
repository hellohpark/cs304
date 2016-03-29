<!DOCTYPE html>
<html>
	<head>
		<title>Price - CPSC 304 Post Office</title>
		<link rel="stylesheet" type="text/css" href="postyle.css">
	</head>

	<body>

	<!-- Navigation Toolbar (declared in reverse order due to float:right) -->
		<ul class="nav">
			<a href="index.php" style="float:left" title="I am a logo!">
				<img src="everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
  			<li><a href="login.php"><b>ADMIN LOGIN</b><br>______________</a></li>
  			<li class="dropdown">
    			<a class="dropbtn" href="order.php"><b>ORDER</b><br>______________</a>
    			<div class="dropdown-content">
        			<section>
       					<a href="order.php">PLACE AN ORDER</a>
       					</section><section>
        				<a href="estimateprice.php">PRICE CALCULATOR</a>
    				</section>
    			</div>
  			</li>
  			<li><a href="index.php#track"><b>TRACK</b><br>______________</a></li>
  			<li><a href="index.php"><b>HOME</b><br>______________</a></li>
		</ul>
	<!-- End navigation -->

		<div class="contentheader">
			<h1>Price Information</h1>
			<p><b>Order</b> price information</p>
		</div>
		<div class="content">
	
	<?php
	// NOTE: Make sure to change session path to point to your own public_html dir
	session_save_path('/home/g/v7e8/public_html');
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
		header("location: index.php");
	}

	if ($_POST && $success) {		
		header("location: index.php");
	}
	dbLogout($db_conn);
}
?>
</div>
		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>
</body>
</html>