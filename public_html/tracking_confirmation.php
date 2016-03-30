<!DOCTYPE html>
<html>
	<head>
		<title>Tracking Information - CPSC 304 Post Office</title>
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
			<h1>Tracking Confirmation</h1>
			<p>Please take note of your <b>Tracking Number</b></p>
		</div>
		<div class="content">

		<div class="icons"><img src="images/tracking_confirmation.png"></div>


	<p>Your tracking number is
	<?php
	// NOTE: Make sure to change session path to point to your own public_html dir
	session_save_path('/home/g/g3d9/public_html');
	session_start();

	$tn = $_SESSION['tracking_num'];
	echo $tn;
	?>
</p>

	<a id="show_id" onclick="document.getElementById('spoiler_id').style.display='';
		document.getElementById('show_id').style.display='none';" 
		class="link">[Show DB Tables]</a>
		<span id="spoiler_id" style="display: none">
			<a onclick="document.getElementById('spoiler_id').style.display='none'; 
			document.getElementById('show_id').style.display='';" 
			class="link" style="text-align:left">[Hide]</a><br>
			
	<?php
	require 'functions.php';
	$db_conn = dbConnect();
	$success = true;

	if ($db_conn) {
	
		$orders = executePlainSQL("select * from orders", $db_conn, $success);
		printOrdersTable($orders);
		$prices = executePlainSQL("select * from price", $db_conn, $success);
		printPriceTable($prices);
	}

	dbLogout($db_conn);

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