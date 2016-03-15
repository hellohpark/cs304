<html>
	<head>
		<title>Order Page - CPSC 304 Post Office</title>
	</head>

	<body>
		<p><a href="index.php">HOME - TRACK YOUR ORDER</a></p>
		<h1>Place An Order</h1>
		<form action="order_confirmation.php" method="post">
			<fieldset>
				<legend>From</legend>
				Name:<br>
				<input type="text" name="fromname"><br>
				Address:<br>
				<input type="text" name="fromaddress"><br>
				Province:<br>
				<input type="radio" name="fromprovince" value="British Columbia">British Columbia<br>
				<input type="radio" name="fromprovince" value="Alberta">Alberta<br>
				<input type="radio" name="fromprovince" value="Saskatchewan">Saskatchewan<br>
				<input type="radio" name="fromprovince" value="Manitoba">Manitoba<br>
				<input type="radio" name="fromprovince" value="Ontario">Ontario<br>
				<input type="radio" name="fromprovince" value="Quebec">Quebec<br>
				<input type="radio" name="fromprovince" value="New Brunswick">New Brunswick<br>
				<input type="radio" name="fromprovince" value="Prince Edward Island">Prince Edward Islands<br>
				<input type="radio" name="fromprovince" value="Newfoundland and Labrador">Newfoundland andLabrador<br>
				<input type="radio" name="fromprovince" value="Nova Scotia">Nova Scotia<br>
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
				<input type="radio" name="toprovince" value="British Columbia">British Columbia<br>
				<input type="radio" name="toprovince" value="Alberta">Alberta<br>
				<input type="radio" name="toprovince" value="Saskatchewan">Saskatchewan<br>
				<input type="radio" name="toprovince" value="Manitoba">Manitoba<br>
				<input type="radio" name="toprovince" value="Ontario">Ontario<br>
				<input type="radio" name="toprovince" value="Quebec">Quebec<br>
				<input type="radio" name="toprovince" value="New Brunswick">New Brunswick<br>
				<input type="radio" name="toprovince" value="Prince Edward Island">Prince Edward Islands<br>
				<input type="radio" name="toprovince" value="Newfoundland and Labrador">Newfoundland andLabrador<br>
				<input type="radio" name="toprovince" value="Nova Scotia">Nova Scotia<br>
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

			<input type="submit" value="Submit">
		</form>
	</body>
</html>		