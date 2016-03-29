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
				<img src="everseii.gif" style="height:60px; width:60px; padding:10px">
			</a>
  			<li><a href="admin.php"><b>ADMIN LOGIN</b><br>______________</a></li>
  			<li class="dropdown">
    			<a class="dropbtn" href="order.php"><b>ORDER</b><br>______________</a>
    			<div class="dropdown-content">
        			<section>
       					<a href="order.php">PLACE AN ORDER</a>
       					</section><section>
        				<a href="#">PRICE CALCULATOR</a>
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
			<!-- 3 links below should be part of a menu -->

			<!--<p><a href="order.php">PLACE AN ORDER</a></p>
			<p><a href="login.php">ADMIN LOGIN</a></p>
			<p><a href="estimateprice.php">Estimate Price</a></p>-->

			<!--=========================================-->
		</div>
		<div class="content">
			<form id="home" action="clientinfo.php" method="post" name="track">
				
					Tracking Number:<br>
					<input type="text" name="trackingnumber" required><br>
					<p>Please select order information you'd like to see:</p>
					<input type="checkbox" name="status" value="status">Status of package<br>
					<input type="checkbox" name="from" value="from">Source Information<br>
					<input type="checkbox" name="to" value="to">Destination Information<br>
					<input type="checkbox" name="dt" value="dt">Delivery Type<br>
					<input type="checkbox" name="pt" value="pt">Package Type<br>

				<input type="submit" name='submit' value="Get My Order">
			</form>
		</div>

		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!">
			<img src="everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
	</body>
</html>
