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
	$blood_id = (int)$_POST['blood_id'];
	$qty = (int)$_POST['qty'];

	// Check that sufficient stock is available before deducting
	$check = $conn->prepare("SELECT qty FROM blood_stock WHERE blood_id = ?");
	$check->bind_param("i", $blood_id);
	$check->execute();
	$check->bind_result($available_qty);
	$check->fetch();
	$check->close();

	if ($qty <= 0 || $available_qty === null || $qty > $available_qty) {
	  echo "Error: Requested quantity (" . htmlspecialchars($qty) . ") exceeds available stock (" . (int)$available_qty . ").";
	  $conn->close();
	  exit;
	}

	$stmt = $conn->prepare("INSERT INTO donation_history (seeker_id, blood_id, qty) VALUES (?, ?, ?)");
	$stmt->bind_param("sii", $seeker_id, $blood_id, $qty);

	if ($stmt->execute()) {
	  // echo "New record created successfully<br><br>";
		echo '<img src="Images/thumbs_up.png" alt="" style="width: 125px;height: 100px;margin-top: 10px;margin-bottom: -10px;">';

		echo '<br><br><div style="font-size:1.50em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">New record created successfully</span></div>';
	  $stmt->close();
	  $upd = $conn->prepare("UPDATE blood_stock SET qty = (qty - ?) WHERE blood_id = ?");
	  $upd->bind_param("ii", $qty, $blood_id);
	  if ($upd->execute()) {
	  		// echo "Blood Stock Updated";
	  	echo '<br><br><div style="font-size:1.25em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">Blood Stock Updated</span></div>';
	  	  }
	  $upd->close();
	} else {
	  echo "Error: " . $stmt->error;
	  $stmt->close();
	}

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