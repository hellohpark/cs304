<!DOCTYPE html>
<html>
<head>
	<title>Tracking Information - CPSC 304 Post Office</title>
</head>
<body>
	<h1>Tracking Information</h1>
	<p><a href="index.php">HOME - TRACK YOUR ORDER</a><br>
	<a href="order.php">PLACE A NEW ORDER</a></p>
	<h3>Your Information</h3>
	<h4>Tracking Number</h4>
	<p>Your tracking number is <?php echo mt_rand(10000000, 99999999) ?></p>
	<h4>From</h4>
	Name: <?php echo $_POST["fromname"]; ?><br>
	Address: <?php echo $_POST["fromaddress"]; ?><br>
	Province: <?php echo $_POST["fromprovince"]; ?><br>
	Phone: <?php echo $_POST["fromphone"]; ?><br>
	<br>
	<h4>To</h4>
	Name: <?php echo $_POST["toname"]; ?><br>
	Address: <?php echo $_POST["toaddress"]; ?><br>
	Province: <?php echo $_POST["toprovince"]; ?><br>
	Phone: <?php echo $_POST["tophone"]; ?><br>
	<br>
	<h4>Package Type</h4>
	<?php echo $_POST["packagetype"]; ?><br>
	<br>
	<h4>Delivery Type</h4>
	<?php echo $_POST["deliverytype"]; ?><br>
</body>
</html>