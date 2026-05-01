<?php

// --- Server-side validation ---

$allowed_types = ['donor', 'blood_bank', 'seeker'];

$entity_type = isset($_POST['entity_type']) ? trim($_POST['entity_type']) : '';
$entity_id   = isset($_POST['entity_id'])   ? intval($_POST['entity_id'])   : 0;
$score       = isset($_POST['score'])        ? intval($_POST['score'])        : 0;
$comment     = isset($_POST['comment'])      ? trim($_POST['comment'])        : null;

$errors = [];

if (!in_array($entity_type, $allowed_types, true)) {
    $errors[] = "Invalid entity type. Must be donor, blood_bank, or seeker.";
}

if ($entity_id < 1) {
    $errors[] = "Entity ID must be a positive integer.";
}

if ($score < 1 || $score > 10) {
    $errors[] = "Score must be between 1 and 10.";
}

if (!empty($errors)) {
    echo "<!DOCTYPE html><html><head><title>Rating Error</title></head><body>";
    echo "<h2 style='color:red;text-align:center'>Validation Error</h2>";
    echo "<ul style='color:Tomato;width:50%;margin:auto'>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul>";
    echo "<p style='text-align:center'><a href='rate_entity.html'>Go back</a></p>";
    echo "</body></html>";
    exit;
}

// --- Database insert ---

$conn = new mysqli("localhost", "root", "", "blood_db");

if ($conn->connect_error) {
    die("<h2 style='color:red;text-align:center'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</h2>");
}

$stmt = $conn->prepare(
    "INSERT INTO `rating` (`entity_type`, `entity_id`, `score`, `comment`) VALUES (?, ?, ?, ?)"
);

// comment may be NULL
$comment_val = ($comment !== '') ? $comment : null;

$stmt->bind_param("siis", $entity_type, $entity_id, $score, $comment_val);

if ($stmt->execute()) {
    echo "<!DOCTYPE html><html><head><title>Rating Submitted</title></head><body>";
    echo "<h2 style='color:green;text-align:center'>Rating submitted successfully!</h2>";
    echo "<p style='text-align:center'>Entity Type: <strong>" . htmlspecialchars($entity_type) . "</strong> | ";
    echo "Entity ID: <strong>" . htmlspecialchars($entity_id) . "</strong> | ";
    echo "Score: <strong>" . htmlspecialchars($score) . "/10</strong></p>";
    echo "<p style='text-align:center'><a href='rate_entity.html'>Rate another</a> &nbsp;|&nbsp; <a href='index.html'>Home</a></p>";
    echo "</body></html>";
} else {
    echo "<!DOCTYPE html><html><head><title>Rating Error</title></head><body>";
    echo "<h2 style='color:red;text-align:center'>Failed to submit rating.</h2>";
    echo "<p style='text-align:center;color:Tomato'>" . htmlspecialchars($stmt->error) . "</p>";
    echo "<p style='text-align:center'><a href='rate_entity.html'>Go back</a></p>";
    echo "</body></html>";
}

$stmt->close();
$conn->close();
?>
