<?php 
session_save_path('/home/g/g3d9/public_html');
session_start();
require 'functions.php';

$tn = $_SESSION['tracking_num'];

?>

<h1>Payment</h1>
	<form action="tracking_confirmation.php" method="post">
			<fieldset>
				<legend>Payment Card</legend>
				Card Number: <input type="text" name="cardname"><br>
				Security Code: <input type="text" name="securitycode"><br>
				Expiration Month:
				<!--TODO: Drop down menu using Bootstrap-->
				<input list="expmonths">
					<datalist id="expmonths">
						<option value="January">
						<option value="February">
						<option value="March">
						<option value="April">
						<option value="May">
						<option value="June">
						<option value="July">
						<option value="August">
						<option value="September">
						<option value="October">
						<option value="November">
						<option value="December">
					</datalist>
				<br>
					
				Expiration Year:
				<!--TODO: Drop down menu using Bootstrap, years from 2016 to 2025-->
				
			</fieldset>
			
			<input type="submit" name="submit" value="continue">
		</form>

		<form method="POST" action="payment.php">
		<p><input type="submit" name="cancel" value="cancel"></p>
		</form>

<?php
$success = True; 
$db_conn = dbConnect();

if ($db_conn) {

	if (array_key_exists('cancel', $_POST)) {
		
		executePlainSQL("delete from orders where tracking_number='$tn'", $db_conn, $success);
		executePlainSQL("delete from price where tracking_number='$tn'", $db_conn, $success);
		OCICommit($db_conn);
	}

	if ($_POST && $success) {		
		header("location: index.php");
	}
}
?>