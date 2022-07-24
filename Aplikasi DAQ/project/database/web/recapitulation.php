<?php
include('../connectionJSON.php');
$data = [];
$counter = 0;
$partname = '-';
$downtime = 0;
$target = 0;
$status = '-';
$datetime = '-';
$t_prod = 0;
$start_time = '-';
$end_time = '-';
$partOK = 0;
$partNG = 0;
$efficiency = 0;

$counter2 = 0;
$partname2 = '-';
$downtime2 = 0;
$target2 = 0;
$status2 = '-';
$datetime2 = '-';
$t_prod2 = 0;
$start_time2 = '-';
$end_time2 = '-';
$partOK2 = 0;
$partNG2 = 0;
$efficiency2 = 0;

//PART RH
$query = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
$result = $mysqli->query($query);
foreach ($result as $row) {
    $partname = $row['part_name'];
}
$result->close();

$query = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$partname' ORDER BY id ASC LIMIT 1";
$result = $mysqli->query($query);
$cekLoading = mysqli_num_rows($result);
if ($cekLoading > 0) {
    foreach ($result as $row) {
        $counter = $row['cum_target'];
        $downtime = $row['downtime'];
        $target = $row['target'];
        $status = $row['status'];
        $datetime = $row['date_time'];
        $partOK = $row['cum_actual'];
        $partNG = $row['rejection'];
        $efficiency = $row['efficiency'];
    }
    $result->close();
}
$data1 = [
    'counter' => $counter,
    'result_downtime' => $downtime,
    'partname' => $partname,
    'target' => $target,
    'status' => $status,
    'datetime' => $datetime,
    'part_OK' => $partOK,
    'part_NG' => $partNG,
    'efficiency' => $efficiency
];
$data += $data1;

//PART LH
$query = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
$result = $mysqli->query($query);
foreach ($result as $row) {
    $partname2 = $row['part_name'];
}
$result->close();

$query = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$partname2' ORDER BY id ASC LIMIT 1";
$result = $mysqli->query($query);
$cekLoading = mysqli_num_rows($result);
if ($cekLoading > 0) {
    foreach ($result as $row) {
        $counter2 = $row['cum_target'];
        $downtime2 = $row['downtime'];
        $target2 = $row['target'];
        $status2 = $row['status'];
        $datetime2 = $row['date_time'];
        $partOK2 = $row['cum_actual'];
        $partNG2 = $row['rejection'];
        $efficiency2 = $row['efficiency'];
    }
    $result->close();
}
$data2 = [
    'counter2' => $counter2,
    'result_downtime2' => $downtime2,
    'partname2' => $partname2,
    'target2' => $target2,
    'status2' => $status2,
    'datetime2' => $datetime2,
    'part_OK2' => $partOK2,
    'part_NG2' => $partNG2,
    'efficiency2' => $efficiency2
];
$data += $data2;

$query1 = "SELECT * FROM machine_status";
$result1 = $mysqli->query($query1);
foreach ($result1 as $row1) {
    $machineStatus = $row1['status'];
}
$result1->close();

$data3 = [
    'machineStatus' => $machineStatus
];
$data += $data3;

print json_encode($data);
$mysqli->close();
