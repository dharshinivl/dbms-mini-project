<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in as an organizer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'organizer') {
    header('Location: login.php');
    exit();
}

// Handle participant deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_id = $_POST['team_id'];

    // Delete participant from the Teams table
    $query = "DELETE FROM teams WHERE team_id = $1";
    $result = pg_query_params($conn, $query, array($team_id));

    if ($result) {
        echo "Participant deleted successfully!";
    } else {
        echo "Error deleting participant: " . pg_last_error($conn);
    }
}

// Fetch participants to display
$query = "SELECT * FROM teams";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Participant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Delete Participant</h1>

    <form action="delete_participant.php" method="POST">
        <label for="team_id">Select Participant to Delete:</label>
        <select id="team_id" name="team_id" required>
            <?php while ($team = pg_fetch_assoc($result)): ?>
                <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?> (Leader: <?= $team['leader_name'] ?>)</option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Delete Participant</button>
    </form>

    <br>
    <a href="organizer_home.php">Back to Home</a>
</body>
</html>
