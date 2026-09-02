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

	$search_name = isset($_GET['name']) ? trim($_GET['name']) : '';
	$search_blood_group = isset($_GET['blood_group']) ? trim($_GET['blood_group']) : '';

	if ($search_name !== '' || $search_blood_group !== '') {
		$conditions = [];
		$types = '';
		$params = [];

		if ($search_name !== '') {
			$conditions[] = "name LIKE ?";
			$types .= 's';
			$params[] = '%' . $search_name . '%';
		}
		if ($search_blood_group !== '') {
			$conditions[] = "blood_group LIKE ?";
			$types .= 's';
			$params[] = '%' . $search_blood_group . '%';
		}

		$sql = "SELECT * FROM donor WHERE " . implode(" AND ", $conditions);
		$stmt = $conn->prepare($sql);
		$stmt->bind_param($types, ...$params);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
	} else {
		$sql = "SELECT * FROM donor";
		$result = $conn->query($sql);
	}

	
	$conn->close();
?>


<html>
	<head>
		<title>Available Doner</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 60%;margin-left: 270px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood Doner</h1>

		<form method="GET" action="available_donor_list.php" style="margin-bottom: 15px;">
			<label for="name" style="color: Red"><strong>Name:</strong></label>
			<input type="text" id="name" name="name" placeholder="e.g. John" value="<?php echo htmlspecialchars($search_name); ?>">
			&nbsp;
			<label for="blood_group" style="color: Red"><strong>Blood Group:</strong></label>
			<input type="text" id="blood_group" name="blood_group" placeholder="e.g. A+" value="<?php echo htmlspecialchars($search_blood_group); ?>">
			<input type="submit" value="Search">
			<?php if ($search_name !== '' || $search_blood_group !== ''): ?>
				<a href="available_donor_list.php">Clear</a>
			<?php endif; ?>
		</form>

		<table align="center" border="1">
			<thead>
				<th style="color: Tomato">ID</th>
				<th style="color: Tomato">Name</th>
				<th style="color: Tomato">Blood Group</th>
				<th style="color: Tomato">Last Donation Date</th>
				<th style="color: Tomato">Contact No</th>
				<th style="color: Tomato">Address</th>
				<th style="color: Tomato">Email</th>
			</thead>
			<tbody>
				<?php
					if ($result->num_rows > 0) {
					  // output data of each row

						 while($row = $result->fetch_assoc()) {
						    echo '<tr>';
						    echo '<td>'.htmlspecialchars($row['id']).'</td>';
						    echo '<td>'.htmlspecialchars($row['name']).'</td>';
						    echo '<td>'.htmlspecialchars($row['blood_group']).'</td>';
						    echo '<td>'.htmlspecialchars($row['last_donation_date']).'</td>';
						    echo '<td>'.htmlspecialchars($row['contact_no']).'</td>';
						    echo '<td>'.htmlspecialchars($row['address']).'</td>';
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
