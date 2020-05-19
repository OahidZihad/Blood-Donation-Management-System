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

	$sql = "SELECT blood_id, blood_group, qty FROM blood_bank bb JOIN blood_stock bs ON bs.blood_id = bb.id";
	$result = $conn->query($sql);

	
	$conn->close();
?>


<html>
	<head>
		<title>Get Blood</title>
	</head>
	<!-- <body align="center" style="color: Tomato"> -->
		<body align="center" <div style="border: 6px solid red; color: Tomato;border-radius: 50px;width: 30%;margin-left: 460px;margin-top: 60px;background-color:powderblue;"></div>

			<img src="Images/insert_blood.png" alt="" style="width: 100px;height: 150px;margin-top: 10px;margin-bottom: -15px">

		<h1 style="color: Red">Get Blood</h1>

		<form action="get_blood_insertion.php" method="post">

			  <b>Seeker ID:</b><br>
			  <input type="text" name="seeker_id" value=""><br><br>


			  <b>Select Blood Group:</b><br>
			  <select name="blood_id">
			  	<?php
					if ($result->num_rows > 0) {
					  // output data of each row

						 while($row = $result->fetch_assoc()) {
						    echo '<option value="'.$row['blood_id'].'">'.$row[blood_group].' ->'. $row['qty'].'</option>';
					  	}

					} else {
					  echo "No Entry Found!";
					}
				?>
			  </select><br><br>
			  <b>Quantity:</b><br>
			  <input type="text" name="qty" value=""><br><br>
			  
			  <input type="submit" value="Get" style="color: Red">
		</form>
		<br>
		<br>
		
		<a href="index.html" style="color: #0e3c68">HOME</a><br><br>

	</body>
</html>