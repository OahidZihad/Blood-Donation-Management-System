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

	// Retrieve and sanitize inputs
	$entity_type = isset($_POST['entity_type']) ? $_POST['entity_type'] : '';
	$entity_id   = isset($_POST['entity_id'])   ? (int) $_POST['entity_id']  : 0;
	$score       = isset($_POST['score'])        ? (int) $_POST['score']      : 0;
	$comment     = isset($_POST['comment'])      ? trim($_POST['comment'])    : '';

	// Server-side validation
	$allowed_types = array('donor', 'blood_bank', 'seeker');
	$errors = array();

	if (!in_array($entity_type, $allowed_types)) {
		$errors[] = "Invalid entity type. Must be one of: donor, blood_bank, seeker.";
	}

	if ($entity_id < 1) {
		$errors[] = "Entity ID must be a positive integer.";
	}

	if ($score < 1 || $score > 10) {
		$errors[] = "Score must be between 1 and 10 (inclusive).";
	}

	if (count($errors) > 0) {
		echo '<div style="color: red; font-size: 1.1em;">';
		echo '<strong>Validation failed:</strong><ul>';
		foreach ($errors as $err) {
			echo '<li>' . htmlspecialchars($err) . '</li>';
		}
		echo '</ul></div>';
	} else {
		// Use prepared statement to avoid SQL injection
		$stmt = $conn->prepare(
			"INSERT INTO rating (entity_type, entity_id, score, comment) VALUES (?, ?, ?, ?)"
		);

		// comment may be empty string — store NULL if blank
		$comment_value = ($comment !== '') ? $comment : null;
		$stmt->bind_param("siis", $entity_type, $entity_id, $score, $comment_value);

		if ($stmt->execute()) {
			echo '<img src="Images/thumbs_up.png" alt="" style="width: 125px;height: 100px;margin-top: 10px;margin-bottom: -10px;">';
			echo '<br><br><div style="font-size:1.25em;font-weight:bold;">';
			echo '<span style="font-size:1.25em;font-weight:bold;">Rating submitted successfully!</span>';
			echo '</div>';
		} else {
			echo '<div style="color: red;">Error submitting rating: ' . htmlspecialchars($stmt->error) . '</div>';
		}

		$stmt->close();
	}

	$conn->close();
?>

<html>
	<head>
		<title>Rate Entity Script</title>
	</head>
	<body align="center" style="border: 6px solid red; color: Red; border-radius: 50px; width: 30%; margin-left: auto; margin-right: auto; margin-top: 100px; background-color: powderblue; padding: 20px;">

		<br>
		<br>

		<a href="rate_entity.html" style="color: #0e3c68">GO BACK</a>
		<br>
		<br>
		<a href="index.html" style="color: #0e3c68">HOME</a><br><br>
	</body>
</html>
