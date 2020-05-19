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