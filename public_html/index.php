<!DOCTYPE html>
<html>
	<head>
		<title>Home - CPSC 304 Post Office</title>
	</head>

	<body>
		<h1>Welcome to .... hi HAHAHAHAHHA</h1>
		<p><a href="order.php">PLACE AN ORDER</a></p>
		<form action="clientinfo.php" method="post">
			<fieldset>
				<legend>Track your order:</legend>
				Tracking Number:<br>
				<input type="text" name="trackingnumber"><br>
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