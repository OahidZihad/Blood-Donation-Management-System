<!DOCTYPE html>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "blood_db";

	$pageSize = 10;
	$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
	$offset = ($page - 1) * $pageSize;

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	// Get total count
	$countResult = $conn->query("SELECT COUNT(*) as total FROM seeker");
	$totalRows = ($countResult && $row = $countResult->fetch_assoc()) ? (int)$row['total'] : 0;
	$totalPages = (int)ceil($totalRows / $pageSize);

	// Paginated fetch
	$sql = "SELECT * FROM seeker LIMIT $pageSize OFFSET $offset";
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
		<br>
		
		<div>
		<?php
		if ($totalPages > 1) {
		    if ($page > 1) {
		        echo '<a href="available_seeker_list.php?page=' . ($page - 1) . '" style="margin-right:10px">&laquo; Previous</a>';
		    }
		    echo 'Page ' . $page . ' of ' . $totalPages;
		    if ($page < $totalPages) {
		        echo '<a href="available_seeker_list.php?page=' . ($page + 1) . '" style="margin-left:10px">Next &raquo;</a>';
		    }
		}
		?>
		</div>
		<br>
		<a href="index.html" style="color: Red">HOME</a><br><br>
	</body>
</html>
