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

	// Search/filter inputs
	$name        = isset($_GET['name'])        ? trim($_GET['name'])        : '';
	$blood_group = isset($_GET['blood_group']) ? trim($_GET['blood_group']) : '';
	$address     = isset($_GET['address'])     ? trim($_GET['address'])     : '';

	$where = [];
	if ($name !== '') {
		$n = mysqli_real_escape_string($conn, $name);
		$where[] = "name LIKE '%$n%'";
	}
	if ($blood_group !== '') {
		$bg = mysqli_real_escape_string($conn, $blood_group);
		$where[] = "blood_group = '$bg'";
	}
	if ($address !== '') {
		$a = mysqli_real_escape_string($conn, $address);
		$where[] = "address LIKE '%$a%'";
	}

	$sql = "SELECT * FROM seeker";
	if (!empty($where)) {
		$sql .= " WHERE " . implode(" AND ", $where);
	}
	$result = $conn->query($sql);


	$conn->close();
?>


<html>
	<head>
		<title>Available Seeker</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 40%;margin-left: 400px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood Seeker</h1>

		<form method="GET" action="available_seeker_list.php" style="margin-bottom: 15px;">
			<label style="color: Tomato; font-weight: bold;">Name:</label>
			<input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Search by name" />
			&nbsp;
			<label style="color: Tomato; font-weight: bold;">Blood Group:</label>
			<input type="text" name="blood_group" value="<?php echo htmlspecialchars($blood_group); ?>" placeholder="e.g. A+" style="width: 55px;" />
			&nbsp;
			<label style="color: Tomato; font-weight: bold;">Address:</label>
			<input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" placeholder="Search by address" />
			&nbsp;
			<input type="submit" value="Search" style="color: white; background-color: Tomato; border: none; padding: 4px 12px; cursor: pointer;" />
			<a href="available_seeker_list.php" style="color: Red; margin-left: 10px;">Clear</a>
		</form>

		<table align="center" border="1">
			<thead>
				<th style="color: Tomato">ID</th>
				<th style="color: Tomato">Name</th>
				<th style="color: Tomato">Address</th>
				<th style="color: Tomato">Age</th>
				<th style="color: Tomato">Blood Group</th>
				<th style="color: Tomato">Contact No</th>
			</thead>
			<tbody>
				<?php
					if ($result->num_rows > 0) {
					  // output data of each row

						 while($row = $result->fetch_assoc()) {
						    echo '<tr>';
						    echo '<td>'.$row['id'].'</td>';
						    echo '<td>'.$row['name'].'</td>';
						    echo '<td>'.$row['address'].'</td>';
						    echo '<td>'.$row['age'].'</td>';
						    echo '<td>'.$row['blood_group'].'</td>';
						    echo '<td>'.$row['contact_no'].'</td>';
							echo '</tr>';
					  	}

					} else {
					  echo "No Entry Found!";
					}
				?>
			</tbody>

		</table>
		<br>
		<br>
		
		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>