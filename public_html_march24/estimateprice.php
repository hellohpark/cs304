<html>

		<p><a href="index.php">HOME - TRACK YOUR ORDER </a></p>
		<h1>Estimate the cost of your package</h1>
		<form action="estimate.php" method="post">
			<fieldset>	
				<legend>Destination Province</legend>
				Province:<br>
				<input type="radio" name="toprovince" value="BC" required>British Columbia<br>
				<input type="radio" name="toprovince" value="AB">Alberta<br>
				<input type="radio" name="toprovince" value="SK">Saskatchewan<br>
				<input type="radio" name="toprovince" value="MA">Manitoba<br>
				<input type="radio" name="toprovince" value="ON">Ontario<br>
				<input type="radio" name="toprovince" value="QC">Quebec<br>
				<input type="radio" name="toprovince" value="NB">New Brunswick<br>
				<input type="radio" name="toprovince" value="PE">Prince Edward Islands<br>
				<input type="radio" name="toprovince" value="NL">Newfoundland andLabrador<br>
				<input type="radio" name="toprovince" value="NS">Nova Scotia<br>
			</fieldset>
			<fieldset>	
				<legend>Package Type</legend>
				<input type="radio" name="packagetype" value="regular letter" required>Regular Letter<br>
				<input type="radio" name="packagetype" value="regular parcel">Regular Parcel<br>
				<input type="radio" name="packagetype" value="large letter">Large Letter<br>
				<input type="radio" name="packagetype" value="large parcel">Large Parcel<br>
			</fieldset>
			<fieldset>
				<legend>Delivery Type</legend>
				<input type="radio" name="deliverytype" value="standard" required>Standard<br>
				<input type="radio" name="deliverytype" value="express">Express<br>
				<input type="radio" name="deliverytype" value="priority">Priority<br>
			</fieldset>
			<fieldset>
				<!-- Example of join query -->
				<legend>Select the price information you'd like to see:</legend>
				<input type="checkbox" name="estimatepr" value="estimatepr">Provincial Rate<br>
				<input type="checkbox" name="estimatept" value="estimatept">Package Type Price<br>
				<input type="checkbox" name="estimatedt" value="estimatedt">Delivery Type Price<br>
				<input type="checkbox" name="estimatetotal" value="estimatetotal">Total Price<br>

			</fieldset>
			
			<input type="submit" name="submit" value="Submit">

		</form>
		
</html>	

<?php 

// TODO: Prevent clients from clicking submit without any input
if (array_key_exists('submit', $_POST)) {
	header("location: estimate.php");
}


?>