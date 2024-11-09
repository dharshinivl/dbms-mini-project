<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the current user's username
    $username = $_SESSION['username'];

    // Retrieve the user_id from the users table
    $user_query = "SELECT user_id FROM users WHERE username = $1";
    $user_result = pg_query_params($conn, $user_query, array($username));

    if ($user_row = pg_fetch_assoc($user_result)) {
        $user_id = $user_row['user_id']; // Retrieve the user_id for the logged-in user

        // Collect feedback details
        $sport_name = $_POST['sport_name'];
        $feedback = $_POST['feedback'];

        // Insert feedback into the feedback table
        $insert_query = "INSERT INTO feedback (user_id, sport_name, feedback) VALUES ($1, $2, $3)";
        $insert_result = pg_query_params($conn, $insert_query, array($user_id, $sport_name, $feedback));

        if ($insert_result) {
            echo "<p style='color: green;'>Feedback submitted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error submitting feedback: " . pg_last_error($conn) . "</p>";
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
    <title>Feedback</title>
</head>
<body>
    <h2>Submit Your Feedback</h2>
    <form action="feedback.php" method="POST">
        <label for="sport_name">Sport Name:</label>
        <input type="text" name="sport_name" required>

        <label for="feedback">Your Feedback:</label>
        <textarea name="feedback" required></textarea>

        <button type="submit">Submit Feedback</button>
    </form>
    
    <a href="home.php">Go to Home</a>
    <a href="calendar.php">Go to Calendars</a>
    <a href="requirements.php">Go to Requirements</a>
</body>
</html>
