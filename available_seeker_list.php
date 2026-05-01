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

	$page = max(1, intval($_GET['page'] ?? 1));
	$per_page = 10;
	$offset = ($page - 1) * $per_page;

	$count_result = $conn->query("SELECT COUNT(*) AS total FROM seeker");
	$total = $count_result->fetch_assoc()['total'];
	$total_pages = ceil($total / $per_page);

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
		<div style="text-align:center;margin-top:10px;">
			<?php if ($page > 1): ?>
				<a href="?page=<?php echo $page - 1; ?>" style="color:Red;">&#8592; Prev</a>
			<?php else: ?>
				<span style="color:grey;">&#8592; Prev</span>
			<?php endif; ?>
			&nbsp; Page <?php echo $page; ?> of <?php echo $total_pages; ?> &nbsp;
			<?php if ($page < $total_pages): ?>
				<a href="?page=<?php echo $page + 1; ?>" style="color:Red;">Next &#8594;</a>
			<?php else: ?>
				<span style="color:grey;">Next &#8594;</span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<br>

		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>