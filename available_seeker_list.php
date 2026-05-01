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

	$perPage = 10;
	$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	if ($page < 1) {
		$page = 1;
	}
	$countSql = "SELECT COUNT(*) AS total FROM seeker";
	$countResult = $conn->query($countSql);
	$totalRows = $countResult->fetch_assoc()['total'];
	$totalPages = ceil($totalRows / $perPage);
	if ($totalPages > 0 && $page > $totalPages) {
		$page = $totalPages;
	}
	$offset = ($page - 1) * $perPage;

	$sql = "SELECT * FROM seeker ORDER BY id LIMIT $perPage OFFSET $offset";
	$result = $conn->query($sql);
?>


<html>
	<head>
		<title>Available Seeker</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 40%;margin-left: 400px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood Seeker</h1>

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
		<?php if ($totalPages > 1) { ?>
			<br>
			<div>
				<?php if ($page > 1) { ?>
					<a href="available_seeker_list.php?page=<?php echo $page - 1; ?>" style="color: Red">Previous</a>
				<?php } ?>
				<span> Page <?php echo $page; ?> of <?php echo $totalPages; ?> </span>
				<?php if ($page < $totalPages) { ?>
					<a href="available_seeker_list.php?page=<?php echo $page + 1; ?>" style="color: Red">Next</a>
				<?php } ?>
			</div>
		<?php } ?>
		<?php $conn->close(); ?>
		<br>
		<br>
		
		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>
