<?php
include('../connectionJSON.php');
$data = [];
$jig_plan = '-';
$nut_plan = '-';
$jig_actual = '-';
$nut_actual = '-';
$part_name = '-';

if ($_POST['Action'] == 'Read') {
    $query1 = "SELECT * FROM jig_and_nut";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        $jig_actual = $row['jig'];
        $nut_actual = $row['nut'];
    }
    $result1->close();

    $query2 = "SELECT * FROM temp_production ORDER BY id ASC LIMIT 1";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row) {
        $part_name = $row['part_name'];
    }
    $result2->close();

    $query3 = "SELECT * FROM master_product WHERE part_name = '$part_name'";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row) {
        $jig_plan = $row['jig'];
        $nut_plan = $row['nut'];
    }
    $result3->close();

    $data1 = [
        'jig_plan' => $jig_plan,
        'nut_plan' => $nut_plan,
        'jig_actual' => $jig_actual,
        'nut_actual' => $nut_actual
    ];
    $data += $data1;
}

print json_encode($data);
$mysqli->close();
