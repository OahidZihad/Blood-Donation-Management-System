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

	$search_blood_group = isset($_GET['blood_group']) ? trim($_GET['blood_group']) : '';

	if ($search_blood_group !== '') {
		$sql = "SELECT * FROM blood_bank WHERE blood_group LIKE ?";
		$stmt = $conn->prepare($sql);
		$like_val = '%' . $search_blood_group . '%';
		$stmt->bind_param("s", $like_val);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
	} else {
		$sql = "SELECT * FROM blood_bank";
		$result = $conn->query($sql);
	}

	
	$conn->close();
?>

<html>
	<head>
		<title>Available Blood</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 50%;margin-left: 330px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood in Blood Bank</h1>

		<form method="GET" action="available_blood.php" style="margin-bottom: 15px;">
			<label for="blood_group" style="color: Red"><strong>Search by Blood Group:</strong></label>
			<input type="text" id="blood_group" name="blood_group" placeholder="e.g. A+" value="<?php echo htmlspecialchars($search_blood_group); ?>">
			<input type="submit" value="Search">
			<?php if ($search_blood_group !== ''): ?>
				<a href="available_blood.php">Clear</a>
			<?php endif; ?>
		</form>

		<table align="center" border="1">
			<thead>
				<th style="color: Tomato">ID</th>
				<th style="color: Tomato">Blood Group</th>
				<th style="color: Tomato">Address</th>
				<th style="color: Tomato">Bloodbank Phone No</th>
				<th style="color: Tomato">Email</th>
			</thead>
			<tbody>
				<?php
					if ($result->num_rows > 0) {
					  // output data of each row

						 while($row = $result->fetch_assoc()) {
						    echo '<tr>';
						    echo '<td>'.htmlspecialchars($row['id']).'</td>';
						    echo '<td>'.htmlspecialchars($row['blood_group']).'</td>';
						    echo '<td>'.htmlspecialchars($row['address']).'</td>';
						    echo '<td>'.htmlspecialchars($row['bloodbank_phone']).'</td>';
						    echo '<td>'.htmlspecialchars($row['email']).'</td>';
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
