<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in as an organizer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'organizer') {
    header('Location: login.php');
    exit();
}

// Get the current date and time
$current_time = date('Y-m-d H:i:s');

// Delete matches where the match_time has passed
$query = "DELETE FROM matches WHERE match_time < $1";
$result = pg_query_params($conn, $query, array($current_time));

if ($result) {
    echo "Past matches deleted successfully!";
} else {
    echo "Error cleaning up matches: " . pg_last_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Match Cleanup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Match Cleanup</h1>
    <p>Past matches have been deleted successfully.</p>
    <a href="home.php">Back to Home</a>
</body>
</html>
