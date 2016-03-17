<?php
require_once('functions.php');

$db_conn = dbConnect();

$success = true;
$fromname;
$fromaddress;
$fromprovince;
$fromphone;
$toname;
$toaddress;
$toprovince;
$tophone;
$deliverytype;
$packagetype;

function getClientInfo() {

	global $fromname, $fromaddress, $fromprovince, $fromphone,
	$toname, $toaddress, $toprovince, $tophone, $deliverytype, $packagetype, $db_conn;

	$client_id = fetchClientID();
	$sql = "select * from client where cid=:bind1";
	$statement = OCIParse($db_conn, $sql);
	OCIBindByName($statement, ':bind1', $client_id);
	OCIExecute($statement, OCI_DEFAULT);

	$row = OCI_Fetch_Array($statement, OCI_BOTH);
	$fromname = $row[1];
	$fromaddress = $row[2];
	$fromprovince = $row[3];
	$fromphone = $row[4];
	$toname = $row[5];
	$toaddress = $row[6];
	$toprovince = $row[7];
	$tophone = $row[8];
	$deliverytype = $row[9];
	$packagetype = $row[10];
}

if ($db_conn) {
	$clients = executePlainSQL("select * from client", $db_conn, $success);
	printResult($clients);
	$orders = executePlainSQL("select * from orders", $db_conn, $success);
	printResult($orders);

	getClientInfo();
	echo $toprovince;
}



dbLogout($db_conn);

?>

<h1>Tracking Information</h1>
	<p><a href="index.php">HOME - TRACK YOUR ORDER</a><br>
	<a href="order.php">PLACE A NEW ORDER</a></p>
	<h3>Your Information</h3>
	<h4>Tracking Number</h4>
	<p>Your tracking number is></p>
	<h4>From</h4>
	Name: <?php echo $fromname; ?><br>
	Address: <?php echo $fromaddress; ?><br>
	Province: <?php echo $fromprovince; ?><br>
	Phone: <?php echo $fromphone; ?><br>
	<br>
	<h4>To</h4>
	Name: <?php echo $toname; ?><br>
	Address: <?php echo $toaddress; ?><br>
	Province: <?php echo $toprovince; ?><br>
	Phone: <?php echo $tophone; ?><br>
	<br>
	<h4>Package Type</h4>
	<?php echo $deliverytype; ?><br>
	<br>
	<h4>Delivery Type</h4>
	<?php echo $packagetype; ?><br>
	


