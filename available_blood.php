<!DOCTYPE html>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "blood_db";
	$per_page = 5;
	$search = isset($_GET['search']) ? trim($_GET['search']) : "";
	$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

	if ($page < 1) {
		$page = 1;
	}

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$where_clause = "";

	if ($search !== "") {
		$escaped_search = $conn->real_escape_string($search);
		$where_clause = " WHERE id LIKE '%$escaped_search%' OR blood_group LIKE '%$escaped_search%' OR address LIKE '%$escaped_search%' OR bloodbank_phone LIKE '%$escaped_search%' OR email LIKE '%$escaped_search%'";
	}

	$count_sql = "SELECT COUNT(*) AS total FROM blood_bank" . $where_clause;
	$count_result = $conn->query($count_sql);
	$total_rows = 0;

	if ($count_result && $count_row = $count_result->fetch_assoc()) {
		$total_rows = (int) $count_row['total'];
	}

	$total_pages = $total_rows > 0 ? (int) ceil($total_rows / $per_page) : 1;

	if ($page > $total_pages) {
		$page = $total_pages;
	}

	$offset = ($page - 1) * $per_page;
	$sql = "SELECT * FROM blood_bank" . $where_clause . " ORDER BY id ASC LIMIT $per_page OFFSET $offset";
	$result = $conn->query($sql);
	$search_value = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

	
	$conn->close();
?>

<html>
	<head>
		<title>Available Blood</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 50%;margin-left: 330px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood in Blood Bank</h1>

		<form method="get" action="available_blood.php">
			<input type="text" name="search" value="<?php echo $search_value; ?>" placeholder="Search available blood">
			<input type="submit" value="Search">
		</form>
		<br>

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
		<?php
			if ($total_rows > 0) {
				echo '<p style="color: Red">Page '.$page.' of '.$total_pages.'</p>';

				if ($page > 1) {
					echo '<a href="?'.htmlspecialchars(http_build_query(array('search' => $search, 'page' => $page - 1)), ENT_QUOTES, 'UTF-8').'" style="color: Red">Previous</a>&nbsp;&nbsp;';
				}

				if ($page < $total_pages) {
					echo '<a href="?'.htmlspecialchars(http_build_query(array('search' => $search, 'page' => $page + 1)), ENT_QUOTES, 'UTF-8').'" style="color: Red">Next</a>';
				}
			}
		?>
		<br>
		<br>
		
		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>
