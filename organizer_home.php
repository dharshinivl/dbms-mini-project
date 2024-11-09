<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'organizer') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Organizer Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, <?= $_SESSION['username'] ?></h2>
    <div class="navigation">
        <a href="add_match.php">Add Match</a>
        <a href="view_participants.php">View Participants</a>
        <a href="view_feedback.php">View Feedback</a>
        <a href="delete_participant.php">delete participant</a>
    </div>
</body>
</html>
