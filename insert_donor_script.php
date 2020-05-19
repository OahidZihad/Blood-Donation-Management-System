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

	$id = $_POST['id'];
	$name = $_POST['name'];
	$blood_group = $_POST['blood_group'];
	$last_donation_date = $_POST['last_donation_date'];
	$contact_no = $_POST['contact_no'];
	$address = $_POST['address'];
	$email = $_POST['email'];

	$sql = "INSERT INTO donor (id,name,blood_group,last_donation_date, contact_no,address,email)
	VALUES ('$id', '$name', '$blood_group','$last_donation_date', '$contact_no', '$address',  '$email')";

	if ($conn->query($sql) === TRUE) {

	  echo '<img src="Images/thumbs_up.png" alt="" style="width: 125px;height: 100px;margin-top: 10px;margin-bottom: -10px;">';

	  echo '<br><br><div style="font-size:1.25em;font-weight:bold;"><span style="font-size:1.25em;font-weight:bold;">New record created successfully</span></div>';
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
?>

<html>
	<head>
		<title>Insert Blood Script</title>
	</head>
	<body align="center" <div style="border: 6px solid red; color: Red;border-radius: 50px;width: 30%;margin-left: 475px;margin-top: 170px;background-color:powderblue;"></div>
		<br>
		<br>
		
		<a href="insert_donor.html" style="color: #0e3c68">GO BACK</a>
		<br>
		<br>
		<a href="index.html" style="color: #0e3c68">HOME</a><br><br>
	</body>
</html>


