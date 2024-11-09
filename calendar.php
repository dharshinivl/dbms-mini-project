<?php
session_start();
require 'db_connection.php';

$username = $_SESSION['username'];

$query_user = "SELECT user_id FROM users WHERE username = $1";
$result_user = pg_query_params($conn, $query_user, array($username));

if ($result_user && pg_num_rows($result_user) > 0) {
    $user = pg_fetch_assoc($result_user);
    $user_id = $user['user_id'];

    $query_team = "SELECT sport_name FROM teams WHERE leader_id = $1";
    $result_team = pg_query_params($conn, $query_team, array($user_id));

    if ($result_team && pg_num_rows($result_team) > 0) {
        $team = pg_fetch_assoc($result_team);
        $sport_name = $team['sport_name'];

        $query_matches = "SELECT * FROM matches WHERE sport_name = $1";
        $matches_result = pg_query_params($conn, $query_matches, array($sport_name));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calendar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Upcoming Matches for <?= htmlspecialchars($sport_name) ?></h2>
    <ul>
        <?php while ($match = pg_fetch_assoc($matches_result)): ?>
            <li>
                <?= htmlspecialchars($match['match_date']) ?> - <?= htmlspecialchars($match['match_time']) ?> - <?= htmlspecialchars($match['match_venue']) ?>
                (<?= date_diff(new DateTime(), new DateTime($match['match_date']))->format('%a days left') ?>)
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
