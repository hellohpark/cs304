	<?php
	require_once 'functions.php';
	
	session_save_path('/home/g/g3d9/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
	
	$success = True;
	$db_conn = dbConnect();

	?>
	
<!DOCTYPE html>
<html>
	<head>
		<title>Orders Statistics - CPSC 304 Post Office</title>
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
			<h1>Orders Statistics</h1>
			<p><b>Manage</b> orders in post office</p>
		</div>
		<div class="content">
		<div class="icons"><img src="images/stats.png"></div>
	
	<p><a href="login.php" class="button">Log out</a></p>
	
	<form method="GET" action="view_orders.php">
	<h3>View Orders in Post Office</h3>
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
	</form>

	
		<form action="select_province.php" method="post">
			<h3>Shutdown a Post Office - deletion on cascade for orders, not allowed if order has a price associated</h3>
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
		</form>	
		
		
		<form action="stats.php" method="post">
			<h3>Post Office with Max/Min Order Worth:</h3>
				<input type="radio" name="maxmin_OPTION" value="max" required>Max<br>
				<input type="radio" name="maxmin_OPTION" value="min">Min<br>
			
			<input type="submit" name="maxmin" value="Find Post Office">
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
document.getElementById('show_id').style.display='none';" class="link">[Show]</a><span id="spoiler_id" style="display: none"><a onclick="document.getElementById('spoiler_id').style.display='none'; document.getElementById('show_id').style.display='';" class="link" style="text-align:left">[Hide]</a><br>


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
</span>

	</body>
</html>	