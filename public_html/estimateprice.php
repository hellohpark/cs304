<html>
<head>
<title>Price Calculator - CPSC 304 Post Office</title>
<link rel="stylesheet" type="text/css" href="postyle.css">
</head>
<body>

<!-- Navigation Toolbar (declared in reverse order due to float:right) -->
		<ul class="nav">
			<a href="index.php" style="float:left" title="I am a logo!">
				<img src="everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
  			<li><a href="login.php"><b>ADMIN LOGIN</b><br>______________</a></li>
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
			<h1>Price Calculator</h1>
			<p><b>Estimate</b> the cost of your package</p>
	</div>
	<div class="content">
		<h1></h1>
		<form action="estimate.php" method="post">
				<h4>Destination Province:</h4>
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
				
				<br>
				<h4>Package Type:</h4>
				<input type="radio" name="packagetype" value="regular letter" required>Regular Letter<br>
				<input type="radio" name="packagetype" value="regular parcel">Regular Parcel<br>
				<input type="radio" name="packagetype" value="large letter">Large Letter<br>
				<input type="radio" name="packagetype" value="large parcel">Large Parcel<br>
				
				<br>
				<h4>Delivery Type:</h4>
				<input type="radio" name="deliverytype" value="standard" required>Standard<br>
				<input type="radio" name="deliverytype" value="express">Express<br>
				<input type="radio" name="deliverytype" value="priority">Priority<br>

				<br>
				<!-- Example of join query -->
				<h4>Select the price information you'd like to see:</h4>
				<input type="checkbox" name="estimatepr" value="estimatepr">Provincial Rate<br>
				<input type="checkbox" name="estimatept" value="estimatept">Package Type Price<br>
				<input type="checkbox" name="estimatedt" value="estimatedt">Delivery Type Price<br>
				<input type="checkbox" name="estimatetotal" value="estimatetotal">Total Price<br>
			
				<input type="submit" name="submit" value="Submit">

		</form>
	</div>

	<!-- Footer -->
	<div class="footer">
	<a href="index.php" title="I am a logo!"><img src="everseii.gif" style="height:60px; width:60px; padding:10px">
	</a><br>
	I am a logo! CPSC 304 2016
	<!-- End Footer -->
	</div>
		
	</body>

</html>	

<?php 

// TODO: Prevent clients from clicking submit without any input
if (array_key_exists('submit', $_POST)) {
	header("location: estimate.php");
}


?>