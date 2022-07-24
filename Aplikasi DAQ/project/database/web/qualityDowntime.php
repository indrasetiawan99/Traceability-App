<?php
include('../connectionJSON.php');
$data = [];
$counter = 0;
$partname = '-';
$target = 0;
$status = '-';
$datetime = '-';
$t_prod = 0;
$start_time = '-';
$end_time = '-';
$created_at = '-';

if ($_POST['action'] == 'ReadS1' || $_POST['action'] == 'ReadS3') {
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
            $target = $row['target'];
            $status = $row['status'];
            $datetime = $row['date_time'];
        }
        $result->close();

        $query = "SELECT * FROM master_product WHERE part_name = '$partname'";
        $result = $mysqli->query($query);
        foreach ($result as $row) {
            $t_prod = $row['time_production'];
        }
        $result->close();

        $query = "SELECT * FROM setup_production WHERE part_name = '$partname' AND status = 'On Process' ORDER BY id ASC LIMIT 1";
        $result = $mysqli->query($query);
        $cekLoading2 = mysqli_num_rows($result);
        if ($cekLoading2 > 0) {
            foreach ($result as $row) {
                $start_time = $row['start_time'];
                $end_time = $row['end_time'];
                $created_at = $row['date_time'];
            }
        } else {
            $query = "SELECT * FROM setup_production WHERE part_name = '$partname' AND status = 'Off Process' ORDER BY id ASC LIMIT 1";
            $result = $mysqli->query($query);
            foreach ($result as $row) {
                $start_time = $row['start_time'];
                $end_time = $row['end_time'];
                $created_at = $row['date_time'];
            }
        }
        $result->close();

        if (($_POST['action'] == 'ReadS1')) {
            $day = $_POST['day'];

            $query = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
            $result = $mysqli->query($query);
            foreach ($result as $row) {
                $break1_from = $row['s1_break1_from'];
                $break1_to = $row['s1_break1_to'];
                $break2_from = $row['s1_break2_from'];
                $break2_to = $row['s1_break2_to'];
                $break3_from = $row['s2_break1_from'];
                $break3_to = $row['s2_break1_to'];
            }
            $result->close();
        }

        if (($_POST['action'] == 'ReadS3')) {
            $day = $_POST['day'];

            $query = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
            $result = $mysqli->query($query);
            foreach ($result as $row) {
                $break1_from = $row['s2_break2_from'];
                $break1_to = $row['s2_break2_to'];
                $break2_from = $row['s3_break1_from'];
                $break2_to = $row['s3_break1_to'];
                $break3_from = $row['s3_break2_from'];
                $break3_to = $row['s3_break2_to'];
            }
            $result->close();
        }
    }
    $data1 = [
        'counter' => $counter,
        't_prod' => $t_prod,
        'start' => $start_time,
        'finish' => $end_time,
        'break1_from' => $break1_from,
        'break1_to' => $break1_to,
        'break2_from' => $break2_from,
        'break2_to' => $break2_to,
        'break3_from' => $break3_from,
        'break3_to' => $break3_to,
        'partname' => $partname,
        'target' => $target,
        'status' => $status,
        'datetime' => $datetime,
        'created_at' => $created_at
    ];
    $data += $data1;
}

if ($_POST['action'] == 'Read_Machine') {
    $query1 = "SELECT * FROM machine_status";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $machineStatus = $row1['status'];
    }
    $result1->close();

    $data2 = [
        'machineStatus' => $machineStatus,
    ];
    $data += $data2;
}

if ($_POST['action'] == 'Update_Quality') {
    $cum_target = $_POST['cum_target'];

    $query = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $partname = $row['part_name'];
    }
    $result->close();

    $query2 = "UPDATE recapitulation SET cum_target = '$cum_target' WHERE status = 'On Process' AND part_name = '$partname' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query2);
}

print json_encode($data);
$mysqli->close();
