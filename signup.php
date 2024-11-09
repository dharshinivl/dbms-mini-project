<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, email, phone, role) VALUES ($1, $2, $3, $4, $5)";
    $result = pg_query_params($conn, $query, array($username, $password, $email, $phone, $role));

    if ($result) {
        header('Location: login.php');
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <form action="signup.php" method="POST">
            <h2>Sign Up</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <select name="role" required>
                <option value="participant">Participant</option>
                <option value="organizer">Organizer</option>
            </select>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
