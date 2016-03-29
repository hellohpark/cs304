<!DOCTYPE html>
<html>
<head>
	<title>Estimated Price - CPSC 304 Post Offic</title>
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
		<h1>Your Estimated Price</h1>
		<p><b>Estimate</b> the cost of your package</p>
	</div>
	<div class="content">

<?php
require ('functions.php');
$db_conn = dbConnect();
$success = true;

estimatePrice($db_conn, $success);

//Error-handling
//case1: when tracking number does not exist --> no record
dbLogout($db_conn);
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