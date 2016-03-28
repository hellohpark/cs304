<?php 
session_save_path('/home/c/c4w9a/public_html');
session_start();
$_SESSION['authenticated'] = 0;
?>

<h1>Administration Login --> Only admin will have access to view all orders from each province</h1>
	<p><a href="index.php">Go back to main</a></p>
	<form action="select_province.php" method="post">
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

	