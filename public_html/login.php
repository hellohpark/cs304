<?php 
session_save_path('/home/c/c4w9a/public_html');
session_start();
$_SESSION['authenticated'] = 0;
?>

<html>
	<head>
		<title>Login</title>
	</head>

	<body>
	<h1>Admin Login</h1>
	
	<form action="select_province.php">
	  Username: <input type="text" name="user">
	  <br><br>
	  Password: <input type="text" name="password">
	  <br><br>
	  <input type="submit">
	</form>	
	
	</body>
</html>	