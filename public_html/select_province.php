	<?php
	session_save_path('/home/c/c4w9a/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
	?>
	
<html>
	<head>
		<title>Select Province</title>
	</head>

	<body>
	
	<h1>Order's Current Location</h1>
	Select Order's Current Province
	<form method="GET" action="view_orders.php">
	  <input type="radio" name="prov" value="bc" checked> British Columbia<br>
	  <input type="radio" name="prov" value="ab"> Alberta<br>
	  <input type="radio" name="prov" value="sk"> Saskatchewan<br>
	  <input type="radio" name="prov" value="ma"> Manitoba<br>
	  <input type="radio" name="prov" value="on"> Ontario<br>
	  <input type="radio" name="prov" value="qc"> Quebec<br>
	  <input type="radio" name="prov" value="nb"> New Brunswick<br>
	  <input type="radio" name="prov" value="pe"> Prince Edward Islands<br>
	  <input type="radio" name="prov" value="nl"> Newfoundland and Labrador<br>
	  <input type="radio" name="prov" value="ns"> Nova Scotia<br>
	  <input type="submit" value="Submit">
	</form>

	</body>
</html>	