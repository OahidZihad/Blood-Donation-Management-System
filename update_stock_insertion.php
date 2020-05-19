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

	$blood_id = $_POST['blood_id'];
	$qty = $_POST['qty'];

	$sql = "INSERT INTO blood_stock (blood_id, qty)
	VALUES ('$blood_id', '$qty')";

	if ($conn->query($sql) === TRUE) {
	  // echo "New record created successfully";

		echo '<img src="Images/thumbs_up.png" alt="" style="width: 125px;height: 100px;margin-top: 10px;margin-bottom: -10px;">';

		echo '<br><br><div style="font-size:1.25em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">New record created successfully</span></div>';
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

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


