<?php
require ('functions.php');
$db_conn = dbConnect();
$tn = $_POST['trackingnumber'];
$success = true;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tracking Information - CPSC 304 Post Offic</title>
		<link rel="stylesheet" type="text/css" href="postyle.css">
	</head>

<body>

<!-- Navigation Toolbar (declared in reverse order due to float:right) -->
		<ul class="nav">
			<a href="index.php" style="float:left" title="I am a logo!">
				<img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
  			<li class="dropdown">
  				<a class="dropbtn" href="login.php"><b>ADMIN LOGIN</b><br>______________</a>
  				<div class="dropdown-content">
  					<section>
  						<a href="index.php">LOGOUT</a></section></div></li>
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
			<h1>Your Tracking Information</h1>
			<p><b>Details</b> on your package</p>
		</div>

<div class="content">
<div class="icons"><img src="images/client_info.png"></div>
<?php

//Tracking number is invalid
if (!preg_match('/^[0-9][0-9][0-9][0-9]$/', $tn)) {

	echo " <script>
		alert('Please input 4 valid numbers for the tracking number');
		window.location='index.php';
		</script>";

}

else if (isset($_POST['status'])||isset($_POST['from'])||isset($_POST['to'])||
	isset($_POST['dt'])||isset($_POST['pt'])||isset($_POST['price'])) {
	getClientInfo($tn, $db_conn, $success);
}
//Tracking number is valid BUT at least one checkbox isn't checked off
else if (!isset($_POST['status'])&& !isset($_POST['from'])&& !isset($_POST['to'])&&
	!isset($_POST['dt'])&&!isset($_POST['pt'])){
	echo " <script>
		alert('Please select at least one of the order information you would like to see');
		window.location='index.php';
		</script>";

}

dbLogout($db_conn); ?>

</div>
		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>
	</div>
</body>
</html>

