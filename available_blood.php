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

	// Pagination
	$perPage = 20;
	$page    = max(1, intval($_GET['page'] ?? 1));
	$offset  = ($page - 1) * $perPage;

	// Total row count for page calculation
	$countResult = $conn->query("SELECT COUNT(*) AS total FROM blood_bank");
	$totalRows   = $countResult->fetch_assoc()['total'];
	$totalPages  = (int) ceil($totalRows / $perPage);
	if ($totalPages < 1) { $totalPages = 1; }

	$sql    = "SELECT * FROM blood_bank LIMIT $perPage OFFSET $offset";
	$result = $conn->query($sql);

	$conn->close();
?>

<html>
	<head>
		<title>Available Blood</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 50%;margin-left: 330px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood in Blood Bank</h1>

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
		
		<!-- Pagination navigation -->
		<div align="center" style="margin: 10px;">
			<?php if ($page > 1): ?>
				<a href="?page=<?= $page - 1 ?>" style="color: Red;">&#8592; Previous</a> &nbsp;
			<?php endif; ?>
			Page <?= $page ?> of <?= $totalPages ?>
			<?php if ($page < $totalPages): ?>
				&nbsp; <a href="?page=<?= $page + 1 ?>" style="color: Red;">Next &#8594;</a>
			<?php endif; ?>
		</div>
		<br>

		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>