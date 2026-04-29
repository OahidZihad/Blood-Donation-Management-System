<!DOCTYPE html>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "blood_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$seeker_id = $_POST['seeker_id'];
	$blood_id = $_POST['blood_id'];
	$qty = $_POST['qty'];

	// Validate that sufficient stock is available before dispensing
	$check_sql = "SELECT qty FROM blood_stock WHERE blood_id = '$blood_id'";
	$check_result = $conn->query($check_sql);
	$available = 0;
	if ($check_result && $check_result->num_rows > 0) {
		$stock_row = $check_result->fetch_assoc();
		$available = (int)$stock_row['qty'];
	}

	if ((int)$qty <= 0) {
		echo '<br><br><div style="font-size:1.25em;font-weight:bold;color:red;"><span>Error: Quantity must be a positive number.</span></div>';
	} elseif ((int)$qty > $available) {
		echo '<br><br><div style="font-size:1.25em;font-weight:bold;color:red;"><span>Error: Insufficient stock. Available quantity: ' . $available . '</span></div>';
	} else {

	$sql = "INSERT INTO donation_history (seeker_id, blood_id, qty)
	VALUES ('$seeker_id', '$blood_id', '$qty')";

	if ($conn->query($sql) === TRUE) {
	  // echo "New record created successfully<br><br>";
		echo '<img src="Images/thumbs_up.png" alt="" style="width: 125px;height: 100px;margin-top: 10px;margin-bottom: -10px;">';

		echo '<br><br><div style="font-size:1.50em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">New record created successfully</span></div>';
	  $sql = "UPDATE blood_stock SET qty = (qty-$qty) WHERE blood_id = $blood_id";
	  if ($conn->query($sql) === TRUE) {
	  		// echo "Blood Stock Updated";
	  	echo '<br><br><div style="font-size:1.25em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">Blood Stock Updated</span></div>';
	  	  }


	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	} // end stock check

	$conn->close();
?>

<html>
	<head>
		<title>Get Blood Insertion</title>
	</head>
	<!-- <body align="center" style="color: Tomato"> -->
		<body align="center" <div style="border: 6px solid red; color: Red;border-radius: 50px;width: 35%;margin-left: 435px;margin-top: 170px;background-color:powderblue;"></div>
		<br>
		<br>
		
		<a href="get_blood.php" style="color: #0e3c68">GO BACK</a>
		<br>
		<br>
		<a href="index.html" style="color: #0e3c68">HOME</a><br><br>
	</body>
</html>