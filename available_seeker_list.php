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

	$per_page = 20;
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
	if ($page < 1) $page = 1;
	$offset = ($page - 1) * $per_page;

	$count_result = $conn->query("SELECT COUNT(*) AS total FROM seeker");
	$count_row = $count_result->fetch_assoc();
	$total_rows = $count_row['total'];
	$total_pages = ceil($total_rows / $per_page);

	$sql = "SELECT * FROM seeker LIMIT $per_page OFFSET $offset";
	$result = $conn->query($sql);

	$conn->close();
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
		<br>
		<br>
		
		<?php if ($total_pages > 1): ?>
		<div style="margin-top:10px;">
			<?php if ($page > 1): ?>
				<a href="?page=<?php echo $page - 1; ?>">&laquo; Prev</a>&nbsp;
			<?php endif; ?>
			<?php for ($i = 1; $i <= $total_pages; $i++): ?>
				<?php if ($i == $page): ?>
					<strong><?php echo $i; ?></strong>&nbsp;
				<?php else: ?>
					<a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>&nbsp;
				<?php endif; ?>
			<?php endfor; ?>
			<?php if ($page < $total_pages): ?>
				<a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<br>
		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>