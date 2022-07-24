<?php
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'traceability_qrcode');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$mysqli) {
    die("Connection failed: " . $mysqli->error);
}

$query = "UPDATE machine_status SET status = 0";
$mysqli->query($query);

$mysqli->close();
header('Location: input.php');
