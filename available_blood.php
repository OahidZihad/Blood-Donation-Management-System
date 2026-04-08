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

	$per_page = 10;
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
	$page = max(1, $page);
	$offset = ($page - 1) * $per_page;

	$total_result = $conn->query("SELECT COUNT(*) AS cnt FROM blood_bank");
	$total_rows = $total_result->fetch_assoc()['cnt'];
	$total_pages = (int)ceil($total_rows / $per_page);

	$sql = "SELECT * FROM blood_bank LIMIT $per_page OFFSET $offset";
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
		<div align="center">
			<?php
				if ($total_pages > 1) {
					for ($i = 1; $i <= $total_pages; $i++) {
						if ($i == $page) {
							echo "<strong style='margin: 0 4px;'>[$i]</strong>";
						} else {
							echo "<a href='?page=$i' style='margin: 0 4px; color: Red;'>$i</a>";
						}
					}
				}
			?>
		</div>
		<br>
		<br>

		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>