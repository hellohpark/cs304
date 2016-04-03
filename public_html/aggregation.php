<?php
require 'functions.php';
	
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
			<p><b>Number of orders</b> statistics</p>
		</div>
		<div class="content">
	
	<div class="icons"><img src="images/stats.png"></div>

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


function inputResultProvince2($result){
	echo "<fieldset>
				<legend>Post Office Order Status - aggregation query</legend>";
		echo "<table>";		
		echo "<tr><th>Delivery Type</th><th>Number of Orders with the Delivery Type</th></tr>";		
				
		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		
			$curr_location = $row['DL_TYPE'];
			$order_count = $row['DL_COUNT'];

			echo "<tr><td>" . 
			$curr_location . "</td><td>" . 
			$order_count . "</td></tr>";
			
		}
	
	echo "</table>";
	echo "</fieldset>";	
}

if ($db_conn) {

	if ($authentication){		
	} else {
		header("location: login.php");
	}

	if (array_key_exists('login', $_POST)) {

			$password = $_POST['password'];
			$username = $_POST['username'];

			$cmdstring = "select * from admin where username =".$username."and password=".strval($password);
			echo $cmdstring;
			$result = executePlainSQL($cmdstring,$db_conn, $success);
			
			
			header("location: select_province.php");

	}
	
	if (array_key_exists('aggr_submit', $_POST)) {

			if (isset($_POST['num_orders'])) {
				$cmdstring2 = "select curr_location, count(curr_location) as order_count from orders group by (curr_location)";
				
				$provinceresult = executePlainSQL($cmdstring2,$db_conn, $success);
				inputResultProvince($provinceresult);
			}

			if (isset($_POST['num_dt'])) {
				$cmdstring3 = "select dl_type, count(dl_type) as dl_count from orders O1 group by dl_type having 1 < (select count(*) from orders O2 where O1.dl_type = O2.dl_type) ";
				
				$provinceresult2 = executePlainSQL($cmdstring3,$db_conn, $success);
				inputResultProvince2($provinceresult2);
			}
		}

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
	
<?php // Show SQL statements
if (isset($_POST['num_orders'])) {
	$cmdstring = "select curr_location, count(curr_location) as order_count from orders group by (curr_location)";
	echo "<br>".$cmdstring."<br>";
}
if (isset($_POST['num_dt'])) {
	$cmdstring = "select dl_type, count(dl_type) as dl_count from orders O1 group by dl_type having 1 < (select count(*) from orders O2 where O1.dl_type = O2.dl_type) ";
	echo "<br>".$cmdstring."<br>";
}

?>
	
</span>

</body>
</html>	