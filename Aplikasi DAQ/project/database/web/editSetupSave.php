<?php
include('../connection.php');
date_default_timezone_set("Asia/Jakarta");
if (isset($_POST['edit-part-name1'])) {
    $partname = $_POST['edit-part-name1'];
    $target = $_POST['edit-target1'];
    $startDate = $_POST['edit-start-date1'];
    $startHour = $_POST['edit-start-hour1'];
    $startMin = $_POST['edit-start-min1'];
    $finishDate = $_POST['edit-finish-date1'];
    $finishHour = $_POST['edit-finish-hour1'];
    $finishMin = $_POST['edit-finish-min1'];

    $date1 = new DateTime($startDate);
    $date2 = new DateTime($finishDate);
    $date1 = $date1->format('Y-m-d');
    $date2 = $date2->format('Y-m-d');

    $dateTime1 = $date1 . " " . $startHour . ':' . $startMin;
    $dateTime2 = $date2 . " " . $finishHour . ':' . $finishMin;

    $query1 = "UPDATE setup_production SET target = '$target', start_time = '$dateTime1', end_time = '$dateTime2' WHERE part_name = '$partname'";
    $mysqli->query($query1);
}

if (isset($_POST['edit-part-name2'])) {
    $partname = $_POST['edit-part-name2'];
    $target = $_POST['edit-target2'];
    $startDate = $_POST['edit-start-date2'];
    $startHour = $_POST['edit-start-hour2'];
    $startMin = $_POST['edit-start-min2'];
    $finishDate = $_POST['edit-finish-date2'];
    $finishHour = $_POST['edit-finish-hour2'];
    $finishMin = $_POST['edit-finish-min2'];

    $date1 = new DateTime($startDate);
    $date2 = new DateTime($finishDate);
    $date1 = $date1->format('Y-m-d');
    $date2 = $date2->format('Y-m-d');

    $dateTime1 = $date1 . " " . $startHour . ':' . $startMin;
    $dateTime2 = $date2 . " " . $finishHour . ':' . $finishMin;

    $query1 = "UPDATE setup_production SET target = '$target', start_time = '$dateTime1', end_time = '$dateTime2' WHERE part_name = '$partname'";
    $mysqli->query($query1);
}

if (isset($_POST['edit-part-name3'])) {
    $partname = $_POST['edit-part-name3'];
    $target = $_POST['edit-target3'];
    $startDate = $_POST['edit-start-date3'];
    $startHour = $_POST['edit-start-hour3'];
    $startMin = $_POST['edit-start-min3'];
    $finishDate = $_POST['edit-finish-date3'];
    $finishHour = $_POST['edit-finish-hour3'];
    $finishMin = $_POST['edit-finish-min3'];

    $date1 = new DateTime($startDate);
    $date2 = new DateTime($finishDate);
    $date1 = $date1->format('Y-m-d');
    $date2 = $date2->format('Y-m-d');

    $dateTime1 = $date1 . " " . $startHour . ':' . $startMin;
    $dateTime2 = $date2 . " " . $finishHour . ':' . $finishMin;

    $query1 = "UPDATE setup_production SET target = '$target', start_time = '$dateTime1', end_time = '$dateTime2' WHERE part_name = '$partname'";
    $mysqli->query($query1);
}

$mysqli->close();
header('Location:../../main/supervisor.php');
