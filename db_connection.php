<?php
// db_connection.php
$conn = pg_connect("host=localhost dbname=sports_event user=postgres password=Afrah#27");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
