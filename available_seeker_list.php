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

	// Pagination setup
	$limit = 10;
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
	$offset = ($page - 1) * $limit;

	// Count total rows
	$count_sql = "SELECT COUNT(*) as total FROM seeker";
	$count_result = $conn->query($count_sql);
	$total_rows = ($count_result && $row = $count_result->fetch_assoc()) ? (int)$row['total'] : 0;
	$total_pages = ceil($total_rows / $limit);

	// Fetch paginated results
	$sql = "SELECT * FROM seeker LIMIT $limit OFFSET $offset";
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
		
		<a href="index.html" style="color: Red">HOME</a><br><br>

<!-- Pagination Controls -->
<div style="margin-top: 16px;">
<?php
if ($total_pages > 1) {
    echo '<div style="display:inline-block;">';
    if ($page > 1) {
        $prev = $page - 1;
        echo "<a href='?page=$prev'>Previous</a> ";
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<strong style='padding:0 4px;'>$i</strong> ";
        } else {
            echo "<a href='?page=$i' style='padding:0 4px;'>$i</a> ";
        }
    }
    if ($page < $total_pages) {
        $next = $page + 1;
        echo "<a href='?page=$next'>Next</a> ";
    }
    echo '</div>';
}
?>
</div>

	</body>
</html>