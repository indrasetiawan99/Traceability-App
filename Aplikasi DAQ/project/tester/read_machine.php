<?php

header('Access-Control-Allow-Origin: *');

//setting header to json
header('Content-Type: application/json');

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

if ($_POST['action'] == 'read') {
    $query = "SELECT * FROM machine_status";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $machineStatus = $row['status'];
    }
    $result->close();

    $data = [
        'machineStatus' => $machineStatus
    ];

    $mysqli->close();
    print json_encode($data);
}
