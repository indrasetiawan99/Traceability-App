<?php
if (isset($_POST['add-part-name'])) {
    include('../connection.php');
    date_default_timezone_set("Asia/Jakarta");

    $partname = $_POST['add-part-name'];
    $target = $_POST['add-target'];
    $startDate = $_POST['add-start-date'];
    $startHour = $_POST['add-start-hour'];
    $startMin = $_POST['add-start-min'];
    $finishDate = $_POST['add-finish-date'];
    $finishHour = $_POST['add-finish-hour'];
    $finishMin = $_POST['add-finish-min'];

    $date1 = new DateTime($startDate);
    $date2 = new DateTime($finishDate);
    $date1 = $date1->format('Y-m-d');
    $date2 = $date2->format('Y-m-d');

    $dateTime1 = $date1 . " " . $startHour . ':' . $startMin;
    $dateTime2 = $date2 . " " . $finishHour . ':' . $finishMin;

    $query = "INSERT INTO setup_production(part_name, target, start_time, end_time) VALUES('$partname', '$target', '$dateTime1', '$dateTime2')";
    $mysqli->query($query);

    $query = "INSERT INTO recapitulation(part_name, target, start_time, end_time) VALUES ('$partname', '$target', '$dateTime1', '$dateTime2')";
    $mysqli->query($query);

    $mysqli->close();
    header('Location:../../main/supervisor.php');
}
