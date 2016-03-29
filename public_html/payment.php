<!DOCTYPE html>
<html>
<head>
<title>Payment - CPSC 304 Post Office</title>
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
			<h1>Payment</h1>
			<p><b>Provide payment</b> to place your order</p>
		</div>

<div class="content">
<?php 
session_save_path('/home/g/v7e8/public_html');
session_start();
require 'functions.php';

$tn = $_SESSION['tracking_num'];

?>
	<form action="tracking_confirmation.php" method="post">
				<h4>Card Number:</h4>
				<input type="text" name="cardname"><br>

				<h4>Security Code:</h4>
				<input type="text" name="securitycode"><br>
				
				<h4>Expiration Month:</h4>
				<!--TODO: Drop down menu using Bootstrap-->
				<select name="expmonths">
					<option value="January">January</option>
					<option value="February">February</option>
					<option value="March">March</option>
					<option value="April">April</option>
					<option value="May">May</option>
					<option value="June">June</option>
					<option value="July">July</option>
					<option value="August">August</option>
					<option value="September">September</option>
					<option value="October">October</option>
					<option value="November">November</option>
					<option value="December">December</option>
				</select>
				<br>
					
				<h4>Expiration Year:</h4>
				<!--TODO: Drop down menu using Bootstrap, years from 2016 to 2025-->
				<select name="expyear">
					<option value="2016">2016</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
					<option value="2022">2022</option>
					<option value="2023">2023</option>
					<option value="2024">2024</option>
					<option value="2025">2025</option>
				</select>
			<br>
			<input type="submit" name="submit" value="continue">
		</form>

		<form method="POST" action="payment.php">
		<p><input type="submit" name="cancel" value="cancel"></p>
		</form>

<?php
$success = True; 
$db_conn = dbConnect();

if ($db_conn) {

	if (array_key_exists('cancel', $_POST)) {
		
		executePlainSQL("delete from orders where tracking_number='$tn'", $db_conn, $success);
		executePlainSQL("delete from price where tracking_number='$tn'", $db_conn, $success);
		OCICommit($db_conn);
	}

	if ($_POST && $success) {		
		header("location: index.php");
	}
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