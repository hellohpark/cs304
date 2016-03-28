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
		<title>Select Province - view nested aggregation query result</title>
	</head>

	<body>
	
	<h1>Orders Statistics</h1>
	<p><a href="select_province.php">Go back to select a post office</a></p>
	
	
	
	</body>
</html>	

<?php


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
			
			echo $cmdstringMaxmin;
			
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