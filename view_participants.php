<?php
session_start();
require 'db_connection.php';

$query = "SELECT * FROM users WHERE role = 'participant'";
$participants_result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Participants</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Participants List</h2>
    <ul>
        <?php while ($participant = pg_fetch_assoc($participants_result)): ?>
            <li><?= htmlspecialchars($participant['username']) ?> - <?= htmlspecialchars($participant['email']) ?> - <?= htmlspecialchars($participant['phone']) ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
