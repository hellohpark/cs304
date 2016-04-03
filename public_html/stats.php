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
		<title>Select Province - CPSC 304 Post Office</title>
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
			<h1>Order Statistics</h1>
			<p><b>Max or min</b> statistics</p>
		</div>
		<div class="content">
	
	<div class="icons"><img src="images/stats.png"></div>

<?php


function inputResultMaxMin($maxminresult){

		echo "<table>";		
		echo "<tr><th>Post Office</th><th>Average Order Worth</th></tr>";		
				
		while ($row = OCI_Fetch_Array($maxminresult, OCI_BOTH)) {
		

			echo "<tr><td>" . 
			$row['CU'] . "</td><td>" . 
			$row['AP'] . "</td></tr>";
			
		}
	
	echo "</table>";
}
function inputResultPrice($priceresult){
	echo "<fieldset>
				<legend>All Noncancelled Orders - all orders with a price associated</legend>";
		echo "<table>";		
		echo "<tr><th>Tracking Number</th><th>Total Price</th><th>Current Location</th><th>Delivery Type</th><th>Package Type</th></tr>";		
				
		while ($row = OCI_Fetch_Array($priceresult, OCI_BOTH)) {
		

			echo "<tr><td>" . 
			$row['TRACKING_NUMBER'] . "</td><td>" . 
			$row['TOTAL_PRICE'] . "</td><td>" .
			$row['PR_PROVINCE_NAME'] . "</td><td>" .
			$row['DT_TYPE'] . "</td><td>" .
			$row['PT_TYPE'] . "</td></tr>";
			
		}
	
	echo "</table>";
	echo "</fieldset>";	
}

if ($db_conn) {
	if ($authentication){
		
	} else {
		header("location: login.php");
	}
	
	if (array_key_exists('reset_prices', $_POST)) {
		$cmdstring0 = "DELETE FROM price";
		$cmdstring1 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('5555',	8.4,	'SK',	'express',	'regular letter')";
		$cmdstring2 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('6666',	16.6,	'MA',	'express',	'regular parcel')";
		$cmdstring3 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('7777',	16.8,	'ON',	'express',	'regular parcel')";
		$cmdstring4 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('8888',	17,		'QC',	'express',	'regular parcel')";
		$cmdstring5 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('9999',	14.2,	'NB',	'priority',	'regular letter')";
		$cmdstring6 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('5678',	22.8,	'ON',	'standard',	'large parcel')";
		$cmdstring7 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('1111',	4,		'BC',	'standard',	'regular letter')";
		$cmdstring8 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('2222',	8,		'BC',	'express',	'regular letter')";
		$cmdstring9 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('4444',	4.2,	'AB',	'standard',	'regular letter')";
		$cmdstring10 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('1234',	16.4,	'PE',	'priority',	'large letter')";
		$cmdstring11 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('2345',	11.6,	'NL',	'express',	'large letter')";
		$cmdstring12 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('3456',	7.8,	'NS',	'standard',	'large letter')";
		$cmdstring13 = "insert into price (tracking_number,total_price,pr_province_name,dt_type,pt_type)  values ('4567',	31.8,	'ON',	'priority',	'large parcel')";
		executePlainSQL($cmdstring0,$db_conn, $success);
		executePlainSQL($cmdstring1,$db_conn, $success);
		executePlainSQL($cmdstring2,$db_conn, $success);
		executePlainSQL($cmdstring3,$db_conn, $success);
		executePlainSQL($cmdstring4,$db_conn, $success);
		executePlainSQL($cmdstring5,$db_conn, $success);
		executePlainSQL($cmdstring6,$db_conn, $success);
		executePlainSQL($cmdstring7,$db_conn, $success);
		executePlainSQL($cmdstring8,$db_conn, $success);
		executePlainSQL($cmdstring9,$db_conn, $success);
		executePlainSQL($cmdstring10,$db_conn, $success);
		executePlainSQL($cmdstring11,$db_conn, $success);
		executePlainSQL($cmdstring12,$db_conn, $success);
		executePlainSQL($cmdstring13,$db_conn, $success);
		OCICommit($db_conn);
	}
	
		if (array_key_exists('login', $_POST)) {

			$password = $_POST['password'];
			$username = $_POST['username'];

			$cmdstring = "select * from admin where username =".$username."and password=".strval($password);
			echo $cmdstring;
			$result = executePlainSQL($cmdstring,$db_conn, $success);
			
			
			header("location: select_province.php");

		}

		
		if (array_key_exists('maxmin', $_POST)) {

			$maxmin = $_POST['maxmin_OPTION'];
			
			
			$cmdstringMaxmin = "SELECT curr_location as cu, average_price as ap FROM (SELECT curr_location, AVG(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location) where average_price= (select ".$maxmin."(average_price) from (SELECT curr_location, avg(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location))";
			
			//echo $cmdstringMaxmin;
			
			$maxminresult = executePlainSQL($cmdstringMaxmin,$db_conn, $success);
			
			inputResultMaxMin($maxminresult);

		}
		
	$cmdstringProjection = "SELECT * FROM price";
	echo "<br>".$cmdstringProjection."<br>";
	$priceresult = executePlainSQL($cmdstringProjection,$db_conn, $success);
	inputResultPrice($priceresult);
		
		
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
		
?>	

<p><a href="select_province.php" class="button">Go back to post offices</a></p>
	
	</div>

		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>

<a id="show_id" onclick="document.getElementById('spoiler_id').style.display=''; 
document.getElementById('show_id').style.display='none';" class="link">[Show SQL Query]</a><span id="spoiler_id" style="display: none"><a onclick="document.getElementById('spoiler_id').style.display='none'; document.getElementById('show_id').style.display='';" class="link" style="text-align:left">[Hide]</a><br>
	
<?php 
$maxmin = $_POST["maxmin_OPTION"];
echo "SELECT curr_location as cu, average_price as ap FROM (SELECT curr_location, AVG(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location) where average_price= (select ".$maxmin."(average_price) from (SELECT curr_location, avg(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location))";

?>
</span>

	</body>
</html>	