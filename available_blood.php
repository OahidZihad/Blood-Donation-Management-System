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

	$blood_group = $_GET['blood_group'] ?? '';

	$sql    = "SELECT * FROM blood_bank WHERE 1=1";
	$params = [];
	$types  = '';
	if ($blood_group) { $sql .= " AND blood_group = ?"; $params[] = $blood_group; $types .= 's'; }

	$stmt = $conn->prepare($sql);
	if ($params) $stmt->bind_param($types, ...$params);
	$stmt->execute();
	$result = $stmt->get_result();

	$conn->close();
?>

<html>
	<head>
		<title>Available Blood</title>
	</head>
	<body align="center" <div style="border: 6px solid red; border-radius: 50px;width: 50%;margin-left: 330px;margin-top: 20px;background-color:powderblue;"></div>

		<h1 style="color: Red">Available Blood in Blood Bank</h1>

		<form method="get" action="available_blood.php" style="margin-bottom: 15px;">
			<label for="blood_group">Blood Group:</label>
			<select name="blood_group" id="blood_group">
				<option value="">-- All --</option>
				<?php
					$groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
					foreach ($groups as $g) {
						$selected = ($blood_group === $g) ? 'selected' : '';
						echo "<option value=\"$g\" $selected>$g</option>";
					}
				?>
			</select>
			&nbsp;
			<input type="submit" value="Search">
			&nbsp;
			<a href="available_blood.php">Reset</a>
		</form>

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
		
		<a href="index.html" style="color: Red">HOME</a><br><br>

	</body>
</html>