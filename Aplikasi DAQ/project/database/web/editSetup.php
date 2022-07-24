<?php
include('../connectionJSON.php');
$data = [];

if ($_GET['jumlahData'] >= 1) {
    $id = $_POST['idPart1'];

    $query1 = "SELECT * FROM setup_production WHERE id='$id'";
    $result1 = $mysqli->query($query1);

    foreach ($result1 as $row) {
        $partname = $row['part_name'];
        $target = $row['target'];
        $startDT = $row['start_time'];
        $endDT = $row['end_time'];
    }
    $result1->close();

    $query4 = "UPDATE recapitulation SET target = '$target' WHERE part_name = '$partname' AND status = 'On Process' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query4);

    $startTime = substr($startDT, 11, 5);
    $startDate = substr($startDT, 0, 10);
    $endTime = substr($endDT, 11, 5);
    $endDate = substr($endDT, 0, 10);

    $data1 = [
        'partname1' => $partname,
        'target1' => $target,
        'startTime1' => $startTime,
        'startDate1' => $startDate,
        'endTime1' => $endTime,
        'endDate1' => $endDate
    ];
    $data += $data1;
}
if ($_GET['jumlahData'] >= 2) {
    $id = $_POST['idPart2'];

    $query2 = "SELECT * FROM setup_production WHERE id='$id'";
    $result2 = $mysqli->query($query2);

    foreach ($result2 as $row) {
        $partname = $row['part_name'];
        $target = $row['target'];
        $startDT = $row['start_time'];
        $endDT = $row['end_time'];
    }
    $result2->close();

    $query5 = "UPDATE recapitulation SET target = '$target' WHERE part_name = '$partname' AND status = 'On Process' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query5);

    $startTime = substr($startDT, 11, 5);
    $startDate = substr($startDT, 0, 10);
    $endTime = substr($endDT, 11, 5);
    $endDate = substr($endDT, 0, 10);

    $data2 = [
        'partname2' => $partname,
        'target2' => $target,
        'startTime2' => $startTime,
        'startDate2' => $startDate,
        'endTime2' => $endTime,
        'endDate2' => $endDate
    ];
    $data += $data2;
}
if ($_GET['jumlahData'] >= 3) {
    $id = $_POST['idPart3'];

    $query3 = "SELECT * FROM setup_production WHERE id='$id'";
    $result3 = $mysqli->query($query3);

    foreach ($result3 as $row) {
        $partname = $row['part_name'];
        $target = $row['target'];
        $startDT = $row['start_time'];
        $endDT = $row['end_time'];
    }
    $result3->close();

    $query6 = "UPDATE recapitulation SET target = '$target' WHERE part_name = '$partname' AND status = 'On Process' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query6);

    $startTime = substr($startDT, 11, 5);
    $startDate = substr($startDT, 0, 10);
    $endTime = substr($endDT, 11, 5);
    $endDate = substr($endDT, 0, 10);

    $data3 = [
        'partname3' => $partname,
        'target3' => $target,
        'startTime3' => $startTime,
        'startDate3' => $startDate,
        'endTime3' => $endTime,
        'endDate3' => $endDate
    ];
    $data += $data3;
}

$mysqli->close();
print json_encode($data);
