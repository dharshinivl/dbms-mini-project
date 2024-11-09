<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user details from the session
    $username = $_SESSION['username'];

    // Get the participant's user_id from the database
    $user_query = "SELECT user_id FROM users WHERE username = $1";
    $user_result = pg_query_params($conn, $user_query, array($username));

    if ($user_row = pg_fetch_assoc($user_result)) {
        $leader_id = $user_row['user_id']; // Retrieve the user_id for the logged-in participant

        // Now, retrieve the other registration details
        $leader_name = $_POST['leader_name'];
        $leader_age = $_POST['leader_age'];
        $leader_gender = $_POST['leader_gender'];
        $leader_dept = $_POST['leader_dept'];
        $sport_name = $_POST['sport_name'];
        $team_name = $_POST['team_name'];

        // Insert into the Teams table
        $insert_query = "INSERT INTO teams (leader_id, leader_name, leader_age, leader_gender, leader_dept, sport_name, team_name) VALUES ($1, $2, $3, $4, $5, $6, $7)";
        $insert_result = pg_query_params($conn, $insert_query, array($leader_id, $leader_name, $leader_age, $leader_gender, $leader_dept, $sport_name, $team_name));

        if ($insert_result) {
            echo "<p style='color: green;'>Team registered successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error registering team: " . pg_last_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Error retrieving user ID.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    <title>Team Registration</title>
</head>
<body>
    <h2>Register Your Team</h2>
    <form action="home.php" method="POST">
        <label for="leader_name">Leader Name:</label>
        <input type="text" name="leader_name" required>
        
        <label for="leader_age">Leader Age:</label>
        <input type="number" name="leader_age" required>

        <label for="leader_gender">Leader Gender:</label>
        <select name="leader_gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="leader_dept">Leader Department:</label>
        <input type="text" name="leader_dept" required>

        <label for="sport_name">Sport Name:</label>
        <input type="text" name="sport_name" required>

        <label for="team_name">Team Name:</label>
        <input type="text" name="team_name" required>

        <button type="submit">Register Team</button>
    </form>
    
    <a href="calendar.php">Go to Calendars</a>
    <a href="requirements.php">Go to Requirements</a>
    <a href="feedback.php">Go to Feedback</a>
</body>
</html>
