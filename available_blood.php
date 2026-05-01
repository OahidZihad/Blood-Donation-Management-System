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

	$search = isset($_GET['search']) ? trim($_GET['search']) : '';

	if ($search !== '') {
		$like = '%' . $search . '%';
		$stmt = $conn->prepare(
			"SELECT * FROM blood_bank
			 WHERE blood_group LIKE ? OR address LIKE ? OR bloodbank_phone LIKE ? OR email LIKE ?"
		);
		$stmt->bind_param('ssss', $like, $like, $like, $like);
		$stmt->execute();
		$result = $stmt->get_result();
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

		<form method="GET" action="available_blood.php" style="margin-bottom:16px;">
			<input type="text" name="search" placeholder="Search by blood group, address, phone or email"
				value="<?php echo htmlspecialchars($search); ?>" style="width:340px;padding:4px;">
			<button type="submit">Search</button>
			<?php if ($search !== ''): ?>
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
						    echo '<td>'.$row['id'].'</td>';
						    echo '<td>'.$row['blood_group'].'</td>';
						    echo '<td>'.$row['address'].'</td>';
						    echo '<td>'.$row['bloodbank_phone'].'</td>';
						    echo '<td>'.$row['email'].'</td>';
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