<!DOCTYPE html>
<html>
	<head>
		<title>Home - CPSC 304 Post Office</title>
		<link rel="stylesheet" type="text/css" href="postyle.css">
	</head>

	<body>

	<!-- Navigation Toolbar (declared in reverse order due to float:right) -->
		<ul class="nav">
			<a href="index.php" style="float:left" title="I am a logo!">
				<img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
  			<li class="dropdown">
  				<a class="dropbtn" href="login.php"><b>ADMIN LOGIN</b><br>______________</a>
  				<div class="dropdown-content">
  					<section>
  						<a href="index.php">LOGOUT</a></section></div></li>
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
			<h1>Send 'N Track</h1>
			<p><b>Track</b> your order</p>
		</div>
		<div class="content">
		<div class="icons"><img src="images/index.png"></div>
			<form id="home" action="clientinfo.php" method="post" name="track">
				
					<h4>Tracking Number:</h4>
					<input type="text" name="trackingnumber" required><br>
					<h4>Please select order information you'd like to see:</h4>
					<input type="checkbox" name="status" value="status">Status of package<br>
					<input type="checkbox" name="from" value="from">Source Information<br>
					<input type="checkbox" name="to" value="to">Destination Information<br>
					<input type="checkbox" name="dt" value="dt">Delivery Type<br>
					<input type="checkbox" name="pt" value="pt">Package Type<br>
					<br>
				<input type="submit" name='submit' value="Get My Order">
			</form>
		</div>

		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>
	</body>
</html>
