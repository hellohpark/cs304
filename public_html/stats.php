	<?php
	
	require_once 'functions.php';
	
	session_save_path('/home/v/v7e8/public_html');
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

		
		if (array_key_exists('maxmin', $_POST)) {

			$maxmin = $_POST['maxmin_OPTION'];
			
			
			$cmdstringMaxmin = "SELECT curr_location as cu, average_price as ap FROM (SELECT curr_location, AVG(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location) where average_price= (select ".$maxmin."(average_price) from (SELECT curr_location, avg(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location))";
			
			//echo $cmdstringMaxmin;
			
			$maxminresult = executePlainSQL($cmdstringMaxmin,$db_conn, $success);
			
			inputResultMaxMin($maxminresult);

		}
		
	
		
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
document.getElementById('show_id').style.display='none';" class="link">[Show]</a><span id="spoiler_id" style="display: none"><a onclick="document.getElementById('spoiler_id').style.display='none'; document.getElementById('show_id').style.display='';" class="link" style="text-align:left">[Hide]</a><br>
	
<?php 
$maxmin = $_POST["maxmin_OPTION"];
echo "SELECT curr_location as cu, average_price as ap FROM (SELECT curr_location, AVG(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location) where average_price= (select ".$maxmin."(average_price) from (SELECT curr_location, avg(total_price) as average_price FROM orders, price where orders.tracking_number = price.tracking_number group by curr_location))";

?>
</span>

	</body>
</html>	