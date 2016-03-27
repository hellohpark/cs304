<!DOCTYPE html>
<!--TODO: Only admin will have access to view all orders from each province-->
<head>
<title>Administrator Login - CPSC 304 Post Office</title>
<link rel="stylesheet" type="text/css" href="postyle.css">
</head>

<body>
    <div class="mainpanel">
        <a href="index.php" style="float:left" name="I am a logo!"><img src="everseii.gif"></a>
		<ul class="nav">
  			<li><a href="index.php">Track Your Order</a></li>
  			<li class="dropdown">
    			<a class="dropbtn" href="order.php">Orders</a>
    			<div class="dropdown-content">
        			<section>
       					<a href="order.php">Place a New Order</a>
        				<a href="#">Price Calculator</a>
    				</section>
    			</div>
  			</li>
  			<li style="float:right;"><a class="active" href="admin.php">Sign In</a></li>
		</ul>

		<div class="content">
			<h1>Administration Login --> Only admin will have access to view all orders from each province</h1>
			<form action="clientinfo.php" method="post">
				<fieldset>
				    <legend>Admin Login</legend>
					Username:<br>
					<input type="text" name="username" required><br>
					Password:<br>
					<input type="password" name="password" required><br>
				</fieldset>
				<input type="submit" name='login' value="login">
			</form>
		</div>
	</div>
</body>
</html>
