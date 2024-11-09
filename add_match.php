<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sport_name = $_POST['sport_name'];
    $match_date = $_POST['match_date'];
    $match_time = $_POST['match_time'];
    $match_venue = $_POST['match_venue'];

    $query = "INSERT INTO matches (sport_name, match_date, match_time, match_venue) VALUES ($1, $2, $3, $4)";
    $result = pg_query_params($conn, $query, array($sport_name, $match_date, $match_time, $match_venue));

    if ($result) {
        echo "Match added!";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Match</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="add_match.php" method="POST">
        <h2>Add Match</h2>
        <input type="text" name="sport_name" placeholder="Sport Name" required>
        <input type="date" name="match_date" required>
        <input type="time" name="match_time" required>
        <input type="text" name="match_venue" placeholder="Venue" required>
        <button type="submit">Add Match</button>
    </form>
</body>
</html>
