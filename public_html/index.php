<!DOCTYPE html>
<html>
	<head>
		<title>Home - CPSC 304 Post Office</title>
		<link rel="stylesheet" type="text/css" href="postyle.css">
	</head>

	<body>

	<!-- Navigation Toolbar (declared in reverse order due to float:right) -->
		<ul class="nav">
			<a href="index.php" style="float:left" title="I am a logo!">
				<img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
  			<li> <a href="login.php"><b>ADMIN LOGIN</b><br>______________</a></li>
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
			<h1>Send 'N Track</h1>
			<p><b>Track</b> your order</p>
		</div>
		<div class="content">
		<div class="icons"><img src="images/index.png"></div>
			<form id="home" action="clientinfo.php" method="post" name="track">
				
					<h4>Tracking Number:</h4>
					<input type="text" name="trackingnumber" required><br>
					<h4>Please select order information you'd like to see:</h4>
					<input type="checkbox" name="status" value="status">Status of package<br>
					<input type="checkbox" name="from" value="from">Source Information<br>
					<input type="checkbox" name="to" value="to">Destination Information<br>
					<input type="checkbox" name="dt" value="dt">Delivery Type<br>
					<input type="checkbox" name="pt" value="pt">Package Type<br>
					<input type="checkbox" name="price" value="price">Price Information<br>
					<br>
				<input type="submit" name='submit' value="Get My Order">
			</form>
		</div>

		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>

		<a id="show_id" onclick="document.getElementById('spoiler_id').style.display='';
		document.getElementById('show_id').style.display='none';" 
		class="link">[Show DB Tables]</a>
		<span id="spoiler_id" style="display: none">
			<a onclick="document.getElementById('spoiler_id').style.display='none'; 
			document.getElementById('show_id').style.display='';" 
			class="link" style="text-align:left">[Hide]</a><br>

		<!-- Reset DB -->
		<form method="POST" action="order.php">
   
		<p><input type="submit" value="Reset Database" name="reset"></p>
		</form>
	

	</body>
</html>

<?php
require 'functions.php';
$db_conn = dbConnect();
$success = True;

if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
		
		executePlainSQL("delete from price", $db_conn, $success);
		executePlainSQL("delete from orders", $db_conn, $success);
		OCICommit($db_conn);

		if ($_POST && $success) {		
			header("location: index.php");
		}
	} else {
		$orders = executePlainSQL("select * from orders", $db_conn, $success);
		printOrdersTable($orders);

		$price = executePlainSQL("select * from price", $db_conn, $success);
		printPriceTable($price);

	}

dbLogout($db_conn);
} 
else {
//TODO: Error handling
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>
