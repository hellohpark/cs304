<?php 
session_save_path('/home/v/v7e8/public_html');
session_start();
require 'functions.php';

$success = True; 
$db_conn = dbConnect();

//$tracking_num = getTrackingNumber();
$tracking_num = isUniqueTrackingNumber($db_conn);
$_SESSION['tracking_num'] = $tracking_num;

?>


<!--TODO: Prevent empty forms from being submitted-->
<!DOCTYPE html>
<html>
	<head>
		<title>Order - CPSC 304 Post Office</title>
		<link rel="stylesheet" type="text/css" href="postyle.css">
	</head>

	<body>

	<!-- Navigation Toolbar (declared in reverse order due to float:right) -->
		<ul class="nav">
			<a href="index.php" style="float:left" title="I am a logo!">
				<img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
			<!-- WHY DOESN'T THIS WORK D; -->

			
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
			<h1>Place An Order</h1>
			<p><b>Place</b> a new order</p>
		</div>

		<div class="content">

		<div class="icons"><img src="images/order.png"></div>
		<form action="order.php" method="post">
			<h2>From:</h2>
				<h4>Name:</h4>
				<input type="text" name="fromname"><br>
				<h4>Address:</h4>
				<input type="text" name="fromaddress"><br>
				<h4>Province:</h4>
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
				<h4>Phone:</h4>
				<input type="text" name="fromphone"><br>

				<h3>To:</h3>
				<h4>Name:</h4>
				<input type="text" name="toname"><br>
				<h4>Address:</h4>
				<input type="text" name="toaddress"><br>
				<h4>Province:</h4>
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
				<h4>Phone:</h4>
				<input type="text" name="tophone"><br>

				<h4>Package Type:</h4>
				<input type="radio" name="packagetype" value="regular letter" required>Regular Letter<br>
				<input type="radio" name="packagetype" value="regular parcel">Regular Parcel<br>
				<input type="radio" name="packagetype" value="large letter">Large Letter<br>
				<input type="radio" name="packagetype" value="large parcel">Large Parcel<br>

				<h4>Delivery Type:</h4>
				<input type="radio" name="deliverytype" value="standard" required>Standard<br>
				<input type="radio" name="deliverytype" value="express">Express<br>
				<input type="radio" name="deliverytype" value="priority">Priority<br>

			<br>
			<input type="submit" name="submit" value="Submit">

		</form>
		<form method="POST" action="order.php">
   
		<p><input type="submit" value="Reset" name="reset"></p>
		</form>


<?php

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
		if (checkValidOrder($_POST['tophone'],$_POST['toname'])&&checkValidOrder($_POST['fromphone'],$_POST['fromname'])) {
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

</div>
<!-- Footer -->
<div class="footer">
<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
</a><br>
I am a logo! CPSC 304 2016
<!-- End Footer -->
</div>
	</body>
</html>	