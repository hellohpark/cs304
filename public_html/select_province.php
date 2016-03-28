	<?php
	
	require_once 'functions.php';
	
	session_save_path('/home/c/c4w9a/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
	
	$success = True;
	$db_conn = dbConnect();

	?>
	
<html>
	<head>
		<title>Select Province - allow admin to select a post office and view order statistics</title>
	</head>

	<body>
	
	<h1>Orders Statistics</h1>
	<p><a href="login.php">Log out</a></p>
	
	<form method="GET" action="view_orders.php">
	<fieldset>
	<legend>View Orders in Post Office</legend>
	<br>
	  <input type="radio" name="prov" value="bc"> British Columbia<br>
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
	</fieldset>
	</form>

	
		<form action="select_province.php" method="post">
			<fieldset>
			<legend>Shutdown a Post Office - deletion on cascade for orders, not allowed if order has a price associated</legend>
				<br>
				<input type="radio" name="province" value="BC">British Columbia<br>
				<input type="radio" name="province" value="AB">Alberta<br>
				<input type="radio" name="province" value="SK">Saskatchewan<br>
				<input type="radio" name="province" value="MA">Manitoba<br>
				<input type="radio" name="province" value="ON">Ontario<br>
				<input type="radio" name="province" value="QC">Quebec<br>
				<input type="radio" name="province" value="NB">New Brunswick<br>
				<input type="radio" name="province" value="PE">Prince Edward Islands<br>
				<input type="radio" name="province" value="NL">Newfoundland and Labrador<br>
				<input type="radio" name="province" value="NS">Nova Scotia<br>
			
			<input type="submit" name="shut" value="Shutdown">
			</fieldset>
		</form>	
		
		
		<form action="stats.php" method="post">
			<fieldset>
			<legend>Post Office with Max/Min Order Worth:</legend>
				<br>
				<input type="radio" name="maxmin_OPTION" value="max" required>Max<br>
				<input type="radio" name="maxmin_OPTION" value="min">Min<br>
			
			<input type="submit" name="maxmin" value="Find Post Office">
			</fieldset>
		</form>		
	
	</body>
</html>	

<?php

function inputResultProvince($result){
	echo "<fieldset>
				<legend>Post Office Order Status - aggregation query</legend>";
		echo "<table>";		
		echo "<tr><th>Post Office</th><th>Number of Orders</th></tr>";		
				
		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		
			$curr_location = $row['CURR_LOCATION'];
			$order_count = $row['ORDER_COUNT'];

			echo "<tr><td>" . 
			$curr_location . "</td><td>" . 
			$order_count . "</td></tr>";
			
		}
	
	echo "</table>";
	echo "</fieldset>";	
}

function inputResultPriority($result){
	echo "<fieldset>
				<legend>Post Office with High Priority Status - division query</legend>";
		echo "<table>";		
		echo "<tr><th>Post Office</th></tr>";		
				
		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		
			$curr_location = $row['CURR_LOCATION'];

			echo "<tr><td>" . 
			$curr_location . "</td></tr>";
			
		}
	
	echo "</table>";
	echo "</fieldset>";	
}

function inputResultMaxMin($maxminresult){
	echo "<fieldset>
				<legend>Post Office with Highest Average Order Worth - nested aggregation query</legend>";
		echo "<table>";		
		echo "<tr><th>Post Office</th><th>Average Order Worth</th></tr>";		
				
		while ($row = OCI_Fetch_Array($maxminresult, OCI_BOTH)) {
		

			echo "<tr><td>" . 
			$row['CU'] . "</td><td>" . 
			$row['AP'] . "</td></tr>";
			
		}
	
	echo "</table>";
	echo "</fieldset>";	
}


if ($db_conn) {


	if ($authentication){
		
	} else {
		header("location: login.php");
	}


		if (array_key_exists('shut', $_POST)) {

			$province = $_POST['province'];

			$cmdstring = "DELETE FROM postoffice WHERE po_province_name ='".$province."'";

			
			echo $cmdstring;
			
			$result = executePlainSQL($cmdstring,$db_conn, $success);

			OCICommit($db_conn);
		}
		
		if (array_key_exists('maxmin', $_POST)) {

			$maxmin = $_POST['maxmin_OPTION'];
			
			
			$cmdstringMaxmin = "SELECT curr_location as cu, average_price as ap FROM (SELECT curr_location, AVG(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location) where average_price= (select ".$maxmin."(average_price) from (SELECT curr_location, avg(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location))";
			
			echo $cmdstringMaxmin;
			
			$maxminresult = executePlainSQL($cmdstringMaxmin,$db_conn, $success);
			
			inputResultMaxMin($maxminresult);

		}
		
	
	
	$cmdstring2 = "select curr_location, count(curr_location) as order_count from orders group by (curr_location)";
	echo "<br>".$cmdstring2."<br>";
	$provinceresult = executePlainSQL($cmdstring2,$db_conn, $success);
	inputResultProvince($provinceresult);
	
	
	$cmdstringDivision = "SELECT distinct curr_location FROM orders PS1 WHERE NOT EXISTS (SELECT * FROM deliverytype WHERE NOT EXISTS (SELECT * FROM orders PS2 WHERE PS1.curr_location = PS2.curr_location AND PS2.dl_type = deliverytype.dt_type))";
	echo "<br>".$cmdstringDivision."<br>";
	$priorityresult = executePlainSQL($cmdstringDivision,$db_conn, $success);
	inputResultPriority($priorityresult);
	
	
		
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
		
?>	