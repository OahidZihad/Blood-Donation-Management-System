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

	$blood_id = (int)$_POST['blood_id'];
	$qty = (int)$_POST['qty'];

	// Use INSERT ... ON DUPLICATE KEY UPDATE to handle both new and existing stock entries
	$stmt = $conn->prepare("INSERT INTO blood_stock (blood_id, qty) VALUES (?, ?) ON DUPLICATE KEY UPDATE qty = qty + VALUES(qty)");
	$stmt->bind_param("ii", $blood_id, $qty);

	if ($stmt->execute()) {
	  // echo "New record created successfully";

		echo '<img src="Images/thumbs_up.png" alt="" style="width: 125px;height: 100px;margin-top: 10px;margin-bottom: -10px;">';

		echo '<br><br><div style="font-size:1.25em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">New record created successfully</span></div>';
	} else {
	  echo "Error: " . $stmt->error;
	}

	$stmt->close();
	$conn->close();
?>

<html>
	<head>
		<title>Update Stock Insertion</title>
	</head>
	<body align="center" <div style="border: 6px solid red; color: Red;border-radius: 50px;width: 30%;margin-left: 475px;margin-top: 170px;background-color:powderblue;"></div>
		<br>
		<br>
		
		<a href="update_stock.php" style="color: #0e3c68">GO BACK</a>
		<br>
		<br>
		<a href="index.html" style="color: #0e3c68">HOME</a><br><br>
	</body>
</html>


