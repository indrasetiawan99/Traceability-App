<?php
if ($_POST['action'] == 'Input') {
    include('../connection.php');

    $total_time = $_POST['total-time'];
    $query1 = "INSERT INTO dandory (total_time) VALUES ('$total_time')";
    $mysqli->query($query1);

    $mysqli->close();
}
