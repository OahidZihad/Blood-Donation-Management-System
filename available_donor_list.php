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

	$where = [];
	$params = [];
	$types = '';
	if (!empty($_GET['blood_group'])) {
	    $where[] = 'blood_group = ?';
	    $params[] = $_GET['blood_group'];
	    $types .= 's';
	}
	if (!empty($_GET['address'])) {
	    $where[] = 'address LIKE ?';
	    $params[] = '%' . $_GET['address'] . '%';
	    $types .= 's';
	}

	$sql = "SELECT * FROM donor";
	if ($where) {
	    $sql .= " WHERE " . implode(" AND ", $where);
	}
	$stmt = $conn->prepare($sql);
	if ($params) {
	    $stmt->bind_param($types, ...$params);
	}
	$stmt->execute();
	$result = $stmt->get_result();

	$conn->close();
?>


<html>
	<head>
		<title>Available Doner</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 60%;margin-left: 270px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood Doner</h1>

		<form method="get" action="available_donor_list.php" style="margin-bottom: 20px;">
			<b>Blood Group:</b>
			<select name="blood_group">
				<option value="">-- All --</option>
				<option value="A+" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'A+') echo 'selected'; ?>>A+</option>
				<option value="A-" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'A-') echo 'selected'; ?>>A-</option>
				<option value="B+" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'B+') echo 'selected'; ?>>B+</option>
				<option value="B-" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'B-') echo 'selected'; ?>>B-</option>
				<option value="AB+" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'AB+') echo 'selected'; ?>>AB+</option>
				<option value="AB-" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'AB-') echo 'selected'; ?>>AB-</option>
				<option value="O+" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'O+') echo 'selected'; ?>>O+</option>
				<option value="O-" <?php if (isset($_GET['blood_group']) && $_GET['blood_group'] === 'O-') echo 'selected'; ?>>O-</option>
			</select>
			&nbsp;&nbsp;
			<b>Address:</b>
			<input type="text" name="address" value="<?php echo htmlspecialchars($_GET['address'] ?? ''); ?>" placeholder="e.g. Dhaka">
			&nbsp;
			<input type="submit" value="Search" style="color: Red">
			&nbsp;
			<a href="available_donor_list.php" style="color: Red">Clear</a>
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
