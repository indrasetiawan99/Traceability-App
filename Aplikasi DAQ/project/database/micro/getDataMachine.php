<?php
include('../connection.php');

if (isset($_GET['machine'])) {
    $query1 = "SELECT * FROM machine_status";

    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        $machineStatus = $row["status"];
    }
    $result1->close();

    echo $machineStatus;
    $mysqli->close();
}
