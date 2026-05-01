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
			"SELECT * FROM donor
			 WHERE name LIKE ? OR blood_group LIKE ? OR contact_no LIKE ? OR address LIKE ? OR email LIKE ?"
		);
		$stmt->bind_param('sssss', $like, $like, $like, $like, $like);
		$stmt->execute();
		$result = $stmt->get_result();
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

		<form method="GET" action="available_donor_list.php" style="margin-bottom:16px;">
			<input type="text" name="search" placeholder="Search by name, blood group, contact, address or email"
				value="<?php echo htmlspecialchars($search); ?>" style="width:380px;padding:4px;">
			<button type="submit">Search</button>
			<?php if ($search !== ''): ?>
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
						    echo '<td>'.$row['id'].'</td>';
						    echo '<td>'.$row['name'].'</td>';
						    echo '<td>'.$row['blood_group'].'</td>';
						    echo '<td>'.$row['last_donation_date'].'</td>';
						    echo '<td>'.$row['contact_no'].'</td>';
						    echo '<td>'.$row['address'].'</td>';
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