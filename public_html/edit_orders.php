	<?php
	
	require_once 'functions.php';
	session_save_path('/home/g/g3d9/public_html');
	session_start();

	$authentication = $_SESSION['authenticated'];
	?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit Orders - CPSC 304 Post Office</title>
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
			<h1>Edit Order</h1>
			<p><b>Edit</b> your order</p>
		</div>
		<div class="content">



<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True;
$db_conn = dbConnect();




function updateOrder($db_conn, $success) {
	$tuple = array (
				":bind1" => $_POST['tracking_number'],
				":bind2" => isset($_POST['status_new'])? $_POST['status_new']:null, //$_POST['status'], UPDATE CONSTRAINT
				":bind13" => isset($_POST['curr_location_new'])? $_POST['curr_location_new']:$_POST['curr_location'],
				":bind3" => isset($_POST['fromname'])? $_POST['fromname']:null,
				":bind4" => isset($_POST['fromaddress'])? $_POST['fromaddress']:null,
				":bind5" => isset($_POST['fromprovince'])? $_POST['fromprovince']:$_POST['from_province_current'],
				":bind6" => isset($_POST['fromphone'])? $_POST['fromphone']:null,
				":bind7" => isset($_POST['toname'])? $_POST['toname']:null,
				":bind8" => isset($_POST['toaddress'])? $_POST['toaddress']:null,
				":bind9" => isset($_POST['toprovince'])? $_POST['toprovince']:$_POST['to_province_now'],
				":bind10" => isset($_POST['tophone'])? $_POST['tophone']:null,
				":bind11" => isset($_POST['deliverytype'])? $_POST['deliverytype']:$_POST['deliverytype_now'],
 				":bind12" => isset($_POST['packagetype'])? $_POST['packagetype']:$_POST['packagetype_now']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("update orders set status=:bind2, curr_location=:bind13, SRC_NAME=:bind3, SRC_ADDR=:bind4, SRC_PROV=:bind5,
				SRC_PHONE=:bind6, DST_NAME=:bind7, DST_ADDR=:bind8, DST_PROV=:bind9, DST_PHONE=:bind10, DL_TYPE=:bind11, PK_TYPE=:bind12 where TRACKING_NUMBER=:bind1", $alltuples, $db_conn, $success);
			
								
			
			OCICommit($db_conn);
}



function inputResultEditOrder($result) { 
	
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		
		$tracking_number = $row['TRACKING_NUMBER'];
		$status = $row['STATUS'];
		$SRC_NAME = $row["SRC_NAME"];
		$SRC_ADDR = $row["SRC_ADDR"];
		$SRC_PROV = $row["SRC_PROV"];
		$SRC_PHONE = $row["SRC_PHONE"];
		$DST_NAME = $row["DST_NAME"];
		$DST_ADDR = $row["DST_ADDR"];
		$DST_PROV = $row["DST_PROV"];
		$DST_PHONE = $row["DST_PHONE"];
		$DL_TYPE = $row["DL_TYPE"];
		$PK_TYPE = $row["PK_TYPE"];
		$CURR_LOCATION = $row["CURR_LOCATION"];
		
		
		
		echo "<form action='edit_orders.php' method='post'> 
		Tracking Number:  <input type='text' name='tracking_number' value='$tracking_number' readonly><br> <br>
		Status (SELECT AN OPTION REQUIRED):  <input type='text' name='status' value='$status' readonly><br>	
				<input type='radio' name='status_new' value='pending'>pending<br>
				<input type='radio' name='status_new' value='delivered'>delivered<br>
				<input type='radio' name='status_new' value='being processed'>being processed<br>
				<input type='radio' name='status_new' value='in transit'>in transit<br>	<br>		
		Current Location:  <input type='text' name='curr_location' value='$CURR_LOCATION' readonly><br>
				<input type='radio' name='curr_location_new' value='BC'>British Columbia<br>
				<input type='radio' name='curr_location_new' value='AB'>Alberta<br>
				<input type='radio' name='curr_location_new' value='SK'>Saskatchewan<br>
				<input type='radio' name='curr_location_new' value='MA'>Manitoba<br>
				<input type='radio' name='curr_location_new' value='ON'>Ontario<br>
				<input type='radio' name='curr_location_new' value='QC'>Quebec<br>
				<input type='radio' name='curr_location_new' value='NB'>New Brunswick<br>
				<input type='radio' name='curr_location_new' value='PE'>Prince Edward Islands<br>
				<input type='radio' name='curr_location_new' value='NL'>Newfoundland andLabrador<br>
				<input type='radio' name='curr_location_new' value='NS'>Nova Scotia<br><br>";	
			
		echo	"<h3>From</h3>
				<h4>Name:</h4>
				<input type='text' name='fromname' value='$SRC_NAME'><br>
				<h4>Address:</h4>
				<input type='text' name='fromaddress' value='$SRC_ADDR'><br>
				<h4>Province:</h4>
				<input type='text' name='from_province_current' value='$SRC_PROV' readonly><br>
				<input type='radio' name='fromprovince' value='BC'>British Columbia<br>
				<input type='radio' name='fromprovince' value='AB'>Alberta<br>
				<input type='radio' name='fromprovince' value='SK'>Saskatchewan<br>
				<input type='radio' name='fromprovince' value='MA'>Manitoba<br>
				<input type='radio' name='fromprovince' value='ON'>Ontario<br>
				<input type='radio' name='fromprovince' value='QC'>Quebec<br>
				<input type='radio' name='fromprovince' value='NB'>New Brunswick<br>
				<input type='radio' name='fromprovince' value='PE'>Prince Edward Islands<br>
				<input type='radio' name='fromprovince' value='NL'>Newfoundland andLabrador<br>
				<input type='radio' name='fromprovince' value='NS'>Nova Scotia<br>
				<h4>Phone:</h4>
				<input type='text' name='fromphone' value='$SRC_PHONE'><br>
				<h3>To</h3>
				<h4>Name:</h4>
				<input type='text' name='toname' value='$DST_NAME'><br>
				<h4>Address:</h4>
				<input type='text' name='toaddress' value='$DST_ADDR'><br>
				<h4>Province:</h4>
				<input type='text' name='to_province_now' value='$DST_PROV' readonly><br>
				<input type='radio' name='toprovince' value='BC'>British Columbia<br>
				<input type='radio' name='toprovince' value='AB'>Alberta<br>
				<input type='radio' name='toprovince' value='SK'>Saskatchewan<br>
				<input type='radio' name='toprovince' value='MA'>Manitoba<br>
				<input type='radio' name='toprovince' value='ON'>Ontario<br>
				<input type='radio' name='toprovince' value='QC'>Quebec<br>
				<input type='radio' name='toprovince' value='NB'>New Brunswick<br>
				<input type='radio' name='toprovince' value='PE'>Prince Edward Islands<br>
				<input type='radio' name='toprovince' value='NL'>Newfoundland andLabrador<br>
				<input type='radio' name='toprovince' value='NS'>Nova Scotia<br>
				<h4>Phone:</h4>
				<input type='text' name='tophone' value='$DST_PHONE'><br><br>
				<h4>Package Type</h4>
				<input type='text' name='packagetype_now' value='$PK_TYPE' readonly><br>
				<input type='radio' name='packagetype' value='regular letter'>Regular Letter<br>
				<input type='radio' name='packagetype' value='regular parcel'>Regular Parcel<br>
				<input type='radio' name='packagetype' value='large letter'>Large Letter<br>
				<input type='radio' name='packagetype' value='large parcel'>Large Parcel<br>
				<h4>Delivery Type</h4>
				<input type='text' name='deliverytype_now' value='$DL_TYPE' readonly><br>
				<input type='radio' name='deliverytype' value='standard'>Standard<br>
				<input type='radio' name='deliverytype' value='express'>Express<br>
				<input type='radio' name='deliverytype' value='priority'>Priority<br><br>
			
			<input type='submit' name='submit' value='Submit'>

		</form>		";

	}
}




// Connect Oracle...
if ($db_conn) {
	if ($authentication){
		
	} else {
		header("location: login.php");
	}

		if (array_key_exists('submit', $_POST)) {


			//collectClientInfo($client_id, $db_conn, $success);
			updateOrder($db_conn, $success);
			header("location: view_orders.php");
		}
		

		
	//echo $_POST['tracking_number'];
	$cmdstring = "select * from orders where TRACKING_NUMBER =".strval($_POST['tracking_number']);
	//echo $cmdstring;
	$result = executePlainSQL($cmdstring,$db_conn, $success);
	

	inputResultEditOrder($result);
	
	
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

	
?>

	<p><a href="view_orders.php" class="button">Go back to view orders</a></p>
</div>

		<!-- Footer -->
		<div class="footer">
		<a href="index.php" title="I am a logo!"><img src="images/everseii.gif" style="height:60px; width:60px; padding:10px">
		</a><br>
		I am a logo! CPSC 304 2016
		<!-- End Footer -->
		</div>

<a id="show_id" onclick="document.getElementById('spoiler_id').style.display=''; 
document.getElementById('show_id').style.display='none';" class="link">[Show]</a><span id="spoiler_id" style="display: none"><a onclick="document.getElementById('spoiler_id').style.display='none'; document.getElementById('show_id').style.display='';" class="link" style="text-align:left">[Hide]</a><br>

<?php 	$cmdstring = "select * from orders where TRACKING_NUMBER =".strval($_POST['tracking_number']);
	echo $cmdstring; ?>

</span>


	</body>
</html>	