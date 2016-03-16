<html>
	<head>
		<title>Order Page - CPSC 304 Post Office</title>
	</head>

	<body>
		<p><a href="index.php">HOME - TRACK YOUR ORDER</a></p>
		<h1>Place An Order</h1>
		<form action="oracle-test.php" method="post">
			<fieldset>
				<legend>From</legend>
				Name:<br>
				<input type="text" name="fromname"><br>
				Address:<br>
				<input type="text" name="fromaddress"><br>
				Province:<br>
				<input type="radio" name="fromprovince" value="BC">British Columbia<br>
				<input type="radio" name="fromprovince" value="AB">Alberta<br>
				<input type="radio" name="fromprovince" value="SK">Saskatchewan<br>
				<input type="radio" name="fromprovince" value="MA">Manitoba<br>
				<input type="radio" name="fromprovince" value="ON">Ontario<br>
				<input type="radio" name="fromprovince" value="QC">Quebec<br>
				<input type="radio" name="fromprovince" value="NB">New Brunswick<br>
				<input type="radio" name="fromprovince" value="PE">Prince Edward Islands<br>
				<input type="radio" name="fromprovince" value="NL">Newfoundland andLabrador<br>
				<input type="radio" name="fromprovince" value="NS">Nova Scotia<br>
				Phone:<br>
				<input type="text" name="fromphone"><br>
			</fieldset>
			<fieldset>	
				<legend>To</legend>
				Name:<br>
				<input type="text" name="toname"><br>
				Address:<br>
				<input type="text" name="toaddress"><br>
				Province:<br>
				<input type="radio" name="toprovince" value="BC">British Columbia<br>
				<input type="radio" name="toprovince" value="AB">Alberta<br>
				<input type="radio" name="toprovince" value="SK">Saskatchewan<br>
				<input type="radio" name="toprovince" value="MA">Manitoba<br>
				<input type="radio" name="toprovince" value="ON">Ontario<br>
				<input type="radio" name="toprovince" value="QC">Quebec<br>
				<input type="radio" name="toprovince" value="NB">New Brunswick<br>
				<input type="radio" name="toprovince" value="PE">Prince Edward Islands<br>
				<input type="radio" name="toprovince" value="NL">Newfoundland andLabrador<br>
				<input type="radio" name="toprovince" value="NS">Nova Scotia<br>
				Phone:<br>
				<input type="text" name="tophone"><br>
			</fieldset>
			<fieldset>	
				<legend>Package Type</legend>
				<input type="radio" name="packagetype" value="Regular Letter">Regular Letter<br>
				<input type="radio" name="packagetype" value="Regular Parcel">Regular Parcel<br>
				<input type="radio" name="packagetype" value="Large Letter">Large Letter<br>
				<input type="radio" name="packagetype" value="Large Parcel">Large Parcel<br>
			</fieldset>
			<fieldset>
				<legend>Delivery Type</legend>
				<input type="radio" name="deliverytype" value="Standard">Standard<br>
				<input type="radio" name="deliverytype" value="Express">Express<br>
				<input type="radio" name="deliverytype" value="Priority">Priority<br>
			</fieldset>

			<input type="submit" name="submit" value="Submit">
		</form>
	</body>
</html>		