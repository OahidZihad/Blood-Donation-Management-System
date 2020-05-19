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

	$sql = "SELECT id, blood_group FROM blood_bank";
	$result = $conn->query($sql);

	
	$conn->close();
?>


<html>
	<head>
		<title>Update Blood Stock</title>
	</head>
	<body align="center" <body align="center" <body align="center" <div style="border: 6px solid red; color: Tomato;border-radius: 50px;width: 30%;margin-left: 475px;margin-top: 80px;background-color:powderblue;"></div>

		<img src="Images/add_blood.png" alt="" style="width: 130px;height: 150px;margin-top: 10px;margin-bottom: -15px">

		<h1 style="color: Red">Update Blood Stock</h1>

		<form action="update_stock_insertion.php" method="post">
			  <b>Select Blood Group:</b><br>
			  <select name="blood_id">
			  	<?php
					if ($result->num_rows > 0) {
					  // output data of each row

						 while($row = $result->fetch_assoc()) {
						    echo '<option value="'.$row['id'].'">'.$row[blood_group].'</option>';
					  	}

					} else {
					  echo "No Entry Found!";
					}
				?>
			  </select><br><br>
			  <b>Quantity:</b><br>
			  <input type="text" name="qty" value=""><br><br>
			  
			  <input type="submit" value="Submit" style="color: Red">
		</form>
		<br>
		<br>
		
		<a href="index.html" style="color: #0e3c68">HOME</a><br><br>

	</body>
</html>