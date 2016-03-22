<!DOCTYPE html>
<!--TODO: Only admin will have access to view all orders from each province-->

<h1>Administration Login --> Only admin will have access to view all orders from each province</h1>
	<p><a href="index.php">Go back to main</a></p>
	<form action="clientinfo.php" method="post">
		<fieldset>
			<legend>Admin Login:</legend>
				Username:<br>
				<input type="text" name="username" required><br>
				Password:<br>
				<input type="password" name="password" required><br>
		</fieldset>
			<input type="submit" name='login' value="login">
		</form>
	</body>
</html>
