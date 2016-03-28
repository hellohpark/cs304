<?php 

require_once 'functions.php';
$success = True;
$db_conn = dbConnect();
	
session_save_path('/home/g/g3d9/public_html');
session_start();
$_SESSION['authenticated'] = 0;
?>

<h1>Administration Login --> Only admin will have access to view all orders from each post office</h1>
	<p><a href="index.php">Go back to main</a></p>
	<form action="login.php" method="post">
		<fieldset>
			<legend>Admin Login:</legend>
				Username:<br>
				<input type="text" name="username" required><br>
				Password:<br>
				<input type="password" name="password" required><br>
		</fieldset>
			<input type="submit" name='login' value="Login">
		</form>
	</body>
</html>

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