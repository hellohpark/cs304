<?php 
require_once 'functions.php';
$success = True;
$db_conn = dbConnect();
	
session_save_path('/home/g/g3d9/public_html');
session_start();
$_SESSION['authenticated'] = 0;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Login - CPSC 304 Post Office</title>
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
			<h1>Administration Login</h1>
			<p><b>Login</b> as an administrator to view orders</p>
		</div>
	<div class="content">

	<div class="icons"><img src="images/login.png"></div>
	<form action="login.php" method="post">
				<h4>Username:</h4>
				<input type="text" name="username" required><br>
				<h4>Password:</h4>
				<input type="password" name="password" required><br>
			<input type="submit" name='login' value="Login">
		</form>


<?php



if ($db_conn) {

		if (array_key_exists('login', $_POST)) {

			$password = $_POST['password'];
			$username = $_POST['username'];

			$cmdstring = "select * from login where username ='".$username."' and password= '".strval($password)."'";
			echo $cmdstring;
			$result = executePlainSQL($cmdstring,$db_conn, $success);
			$row = OCI_Fetch_Array($result, OCI_BOTH);
			
			if ($row){
				$_SESSION['authenticated'] = 1;
				header("location: select_province.php");
			} else {
				$_SESSION['authenticated'] = 0;
				header("location: login.php");
			}

		}
	
	
		
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
		
?>		

		</div>

		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>

	</body>
</html>