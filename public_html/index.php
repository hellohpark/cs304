<!DOCTYPE html>
<html>
	<head>
		<title>Home - CPSC 304 Post Office</title>
	</head>

	<body>
		<h1>Send 'N Track</h1>
		<p><a href="order.php">PLACE AN ORDER</a></p>
		<p><a href="admin.php">ADMIN LOGIN</a></p>
		<form action="clientinfo.php" method="post">
			<fieldset>
				<legend>Track your order:</legend>
				Tracking Number:<br>
				<input type="text" name="trackingnumber" required><br>
				<p>Please select order information you'd like to see</p>
				<input type="checkbox" name="status" value="status">Status of package<br>
				<input type="checkbox" name="from" value="from">Source Information<br>
				<input type="checkbox" name="to" value="to">Destination Information<br>
				<input type="checkbox" name="dt" value="dt">Delivery Type<br>
				<input type="checkbox" name="pt" value="pt">Package Type<br>
			</fieldset>

			<input type="submit" name='submit' value="Get My Order">
		</form>
	</body>
</html>

<?php 

// TODO: Prevent clients from clicking submit without any input
if (array_key_exists('submit', $_POST)) {
	header("location: clientinfo.php");
}


?>