<?php $tracking_num = mt_rand(1111, 9999);?>

	<h1>Tracking Information</h1>
	<p><a href="index.php">HOME - TRACK YOUR ORDER</a><br>
	<a href="order.php">PLACE A NEW ORDER</a></p>
	<!-- For testing purposes -->
	<input type="submit" name="reset" value="Reset DB">
	<!--=======================-->
	<h3>Your Information</h3>
	<h4>Tracking Number</h4>
	<p>Your tracking number is <?php echo $tracking_num; ?></p>
	<h4>From</h4>
	Name: <?php echo $_POST["fromname"]; ?><br>
	Address: <?php echo $_POST["fromaddress"]; ?><br>
	Province: <?php echo $_POST["fromprovince"]; ?><br>
	Phone: <?php echo $_POST["fromphone"]; ?><br>
	<br>
	<h4>To</h4>
	Name: <?php echo $_POST["toname"]; ?><br>
	Address: <?php echo $_POST["toaddress"]; ?><br>
	Province: <?php echo $_POST["toprovince"]; ?><br>
	Phone: <?php echo $_POST["tophone"]; ?><br>
	<br>
	<h4>Package Type</h4>
	<?php echo $_POST["packagetype"]; ?><br>
	<br>
	<h4>Delivery Type</h4>
	<?php echo $_POST["deliverytype"]; ?><br>

<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_g3d9", "a30775134", "ug");

function executePlainSQL($cmdstr) { 
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); 

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);        
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); 
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;
}

	function executeBoundSQL($cmdstr, $list) {
	
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); 
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}

}

function printResult($result) { 
	echo "<br>Got data from table orders:<br>";
	echo "<table>";
	echo "<tr><th>ID</th><th>Name</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
	}
	echo "</table>";

}

if ($db_conn) {

	// TODO: Not working properly
	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> Removing all rows <br>";
		executePlainSQL("Delete from orders");

		// // Create new table...
		// echo "<br> creating new table <br>";
		// executePlainSQL("create table tab1 (nid number, name varchar2(30), primary key (nid))");
		OCICommit($db_conn);

	} else 
		if (array_key_exists('submit', $_POST)) {

			$status = 'pending';
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $tracking_num,
				":bind2" => $status,
				":bind3" => $_POST['fromaddress'],
				":bind4" => $_POST['toaddress'],
				":bind5" => $_POST['fromprovince']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into orders values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
			OCICommit($db_conn);

		} else {
			echo 'Hey, everything failed!';
		}
	}


	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		//header("location: oracle-test.php");	//TODO: will throw an error
	} else {
	// Select data...
		$result = executePlainSQL("select * from orders");
		printResult($result);	
	}

		//Commit to save changes...
	OCILogoff($db_conn);
// } else {
// 		echo "cannot connect";
// 		$e = OCI_Error(); // For OCILogon errors pass no handle
// 		echo htmlentities($e['message']);
// 	}


?>



<!--
/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
 -->


