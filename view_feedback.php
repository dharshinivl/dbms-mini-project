<?php
session_start();
require 'db_connection.php';

$query = "SELECT feedback.feedback, users.username FROM feedback JOIN users ON feedback.user_id = users.user_id";
$feedback_result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Feedback</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Feedback</h2>
    <ul>
        <?php while ($feedback = pg_fetch_assoc($feedback_result)): ?>
            <li><strong><?= htmlspecialchars($feedback['username']) ?>:</strong> <?= htmlspecialchars($feedback['feedback']) ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
