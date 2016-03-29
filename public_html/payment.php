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
				<select name="expmonths">
					<option value="January">January</option>
					<option value="February">February</option>
					<option value="March">March</option>
					<option value="April">April</option>
					<option value="May">May</option>
					<option value="June">June</option>
					<option value="July">July</option>
					<option value="August">August</option>
					<option value="September">September</option>
					<option value="October">October</option>
					<option value="November">November</option>
					<option value="December">December</option>
				</select>
				<br>
					
				Expiration Year:
				<!--TODO: Drop down menu using Bootstrap, years from 2016 to 2025-->
				<select name="expyear">
					<option value="2016">2016</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
					<option value="2022">2022</option>
					<option value="2023">2023</option>
					<option value="2024">2024</option>
					<option value="2025">2025</option>
				</select>

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