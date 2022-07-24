<?php
include('../connectionJSON.php');
$data = [];
$partname = '-';
$cum_target = 0;
$partOK = 0;
$partNG = 0;
$efficiency = 0;

if ($_POST['action'] == 'Update') {
    $query = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $partname = $row['part_name'];
        $start_time = $row['start_time'];
        $end_time = $row['end_time'];
    }
    $result->close();

    $query1 = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$partname' ORDER BY id ASC LIMIT 1";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $cum_target = $row1['cum_target'];
    }
    $result1->close();

    $query2 = "SELECT * FROM part_production WHERE part_name = '$partname' AND status != 'reject' AND status IS NOT NULL AND status != 'pending' AND date_time >= '$start_time' AND date_time <= '$end_time'";
    $result2 = $mysqli->query($query2);
    $partOK = mysqli_num_rows($result2);
    $result2->close();

    $query3 = "SELECT * FROM part_production WHERE part_name = '$partname' AND status = 'reject' AND date_time >= '$start_time' AND date_time <= '$end_time'";
    $result3 = $mysqli->query($query3);
    $partNG = mysqli_num_rows($result3);
    $result3->close();

    $query4 = "UPDATE recapitulation SET cum_actual = '$partOK' WHERE status = 'On Process' AND part_name = '$partname'";
    $mysqli->query($query4);

    $query5 = "UPDATE recapitulation SET rejection = '$partNG' WHERE status = 'On Process' AND part_name = '$partname'";
    $mysqli->query($query5);

    if ($cum_target != 0) {
        $efficiency = round(($partOK / $cum_target) * 100, 2);
    }
    $query6 = "UPDATE recapitulation SET efficiency = '$efficiency' WHERE status = 'On Process' AND part_name = '$partname'";
    $mysqli->query($query6);

    $data1 = [
        'part_OK' => $partOK,
        'part_NG' => $partNG,
        'efficiency' => $efficiency
    ];
    $data += $data1;
}

print json_encode($data);
$mysqli->close();
