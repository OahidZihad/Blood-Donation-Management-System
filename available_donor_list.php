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

	$perPage = 20;
	$page = max(1, (int)($_GET['page'] ?? 1));
	$offset = ($page - 1) * $perPage;

	$countResult = $conn->query("SELECT COUNT(*) AS total FROM donor");
	$totalRows = $countResult->fetch_assoc()['total'];
	$totalPages = (int)ceil($totalRows / $perPage);

	$sql = "SELECT * FROM donor LIMIT $perPage OFFSET $offset";
	$result = $conn->query($sql);


	$conn->close();
?>


<html>
	<head>
		<title>Available Doner</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 60%;margin-left: 270px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood Doner</h1>

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
		<?php if ($totalPages > 1): ?>
		<div align="center">
			<?php if ($page > 1): ?>
				<a href="?page=<?php echo $page - 1; ?>" style="color: Red">&#8592; Prev</a>
				&nbsp;&nbsp;
			<?php endif; ?>
			Page <?php echo $page; ?> of <?php echo $totalPages; ?>
			<?php if ($page < $totalPages): ?>
				&nbsp;&nbsp;
				<a href="?page=<?php echo $page + 1; ?>" style="color: Red">Next &#8594;</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<br>

		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>