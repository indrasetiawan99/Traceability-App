<?php
// Achivement
if ($_POST['read'] == 'Data1') {
    include('connectionJSON.php');
    $data = [];
    $part_name_LH = '-';
    $target_LH = 0;
    $cum_target_LH = 0;
    $part_OK_LH = 0;
    $part_NG_LH = 0;
    $part_name_RH = '-';
    $target_RH = 0;
    $cum_target_RH = 0;
    $part_OK_RH = 0;
    $part_NG_RH = 0;
    $planning_start = '-';
    $planning_finish = '-';
    $cust_name = '-';
    $operator_name_npk = '-';
    $machine_status = '-';
    $operator_npk = '';
    $operator_name = '';
    $total_line_stop = 0;
    $quality_RH = 0;
    $quality_LH = 0;
    $quality = 0;
    $availability = 0;
    $performance = 0;
    $oee = 0;

    //PART RH
    $query = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $part_name_RH = $row['part_name'];
        $planning_start = $row['start_time'];
        $planning_finish = $row['end_time'];
    }
    $result->close();

    $query = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$part_name_RH' ORDER BY id ASC LIMIT 1";
    $result = $mysqli->query($query);
    $cekLoading = mysqli_num_rows($result);
    if ($cekLoading > 0) {
        foreach ($result as $row) {
            $cum_target_RH = $row['cum_target'];
            $target_RH = $row['target'];
            $part_OK_RH = $row['cum_actual'];
            $part_NG_RH = $row['rejection'];
            $total_line_stop = round($row['downtime'] / 60);
            $quality_RH = $row['efficiency'];
            $availability = $row['availability'];
            $performance = $row['performance'];
            $oee = $row['oee'];
        }
        $result->close();
    }
    $data1 = [
        'part_name_RH' => $part_name_RH,
        'cum_target_RH' => $cum_target_RH,
        'target_RH' => $target_RH,
        'part_OK_RH' => $part_OK_RH,
        'part_NG_RH' => $part_NG_RH,
    ];
    $data += $data1;

    //PART LH
    $query = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $part_name_LH = $row['part_name'];
        $planning_start = $row['start_time'];
        $planning_finish = $row['end_time'];
    }
    $result->close();

    $query = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$part_name_LH' ORDER BY id ASC LIMIT 1";
    $result = $mysqli->query($query);
    $cekLoading = mysqli_num_rows($result);
    if ($cekLoading > 0) {
        foreach ($result as $row) {
            $cum_target_LH = $row['cum_target'];
            $target_LH = $row['target'];
            $part_OK_LH = $row['cum_actual'];
            $part_NG_LH = $row['rejection'];
            $total_line_stop = round($row['downtime'] / 60);
            $quality_LH = $row['efficiency'];
            $availability = $row['availability'];
            $performance = $row['performance'];
            $oee = $row['oee'];
        }
        $result->close();

        $quality = round(($quality_RH + $quality_LH) / 2);
    }
    $data2 = [
        'part_name_LH' => $part_name_LH,
        'cum_target_LH' => $cum_target_LH,
        'target_LH' => $target_LH,
        'part_OK_LH' => $part_OK_LH,
        'part_NG_LH' => $part_NG_LH,
        'quality' => $quality,
        'availability' => $availability,
        'performance' => $performance,
        'oee' => $oee
    ];
    $data += $data2;

    // Machine status
    $query1 = "SELECT * FROM machine_status";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $machine_status = $row1['status'];
    }
    $result1->close();
    if ($machine_status == 1) {
        $machine_status = 'ON';
    } else if ($machine_status == 0) {
        $machine_status = 'OFF';
    }
    $data3 = [
        'machine_status' => $machine_status,
        'planning_start' => $planning_start,
        'planning_finish' => $planning_finish,
        'total_line_stop' => $total_line_stop
    ];
    $data += $data3;

    // Operator NPK & Name, Customer Name
    $query1 = "SELECT * FROM temp_production";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $operator_npk = $row1['nik'];
    }
    $result1->close();
    $query1 = "SELECT * FROM master_user WHERE nik = '$operator_npk'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $operator_name = $row1['full_name'];
    }
    $result1->close();
    $operator_name_npk = $operator_name . ' - ' . $operator_npk;
    $query1 = "SELECT * FROM master_product WHERE part_name = '$part_name_RH'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $cust_name = $row1['customer'];
    }
    $result1->close();
    $query1 = "SELECT * FROM master_product WHERE part_name = '$part_name_LH'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $cust_name = $row1['customer'];
    }
    $result1->close();
    $data4 = [
        'operator_name_npk' => $operator_name_npk,
        'cust_name' => $cust_name
    ];
    $data += $data4;

    $datetime_now = date("Y-m-d H:i:s");
    $date_now = substr($datetime_now, 0, 10);
    $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
    $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));
    $shift_now = $_POST['shift'];
    if ($shift_now == 'Shift 1') {
        $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                $shift_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['end_time'];
            } else {
                $shift_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
            }
        }
        $result1->close();
    } else if ($shift_now == 'Shift 3') {
        $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                $shift_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
            } else {
                $shift_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row['end_time'];
            }
        }
        $result1->close();
    }

    $query1 = "SELECT * FROM downtime WHERE start_downtime > '$shift_start' AND start_downtime < '$shift_end' AND end_downtime IS NULL";
    $result1 = $mysqli->query($query1);
    $cek_downtime = mysqli_num_rows($result1);
    $result1->close();
    if ($cek_downtime > 0) {
        $downtime = 'Yes';
    } else {
        $downtime = 'No';
    }
    $data5 = [
        "downtime" => $downtime
    ];
    $data += $data5;

    $mysqli->close();
    print json_encode($data);
}

// Line Stop
if ($_POST['read'] == 'Data2') {
    include('connectionJSON.php');
    date_default_timezone_set("Asia/Jakarta");
    $datetime_now = date("Y-m-d H:i:s");
    $date_now = substr($datetime_now, 0, 10);
    $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
    $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));
    $shift_now = $_POST['shift'];
    // $shift_now = 'Shift 1';
    $dataa = [];
    $dataa1 = [];
    $total_time = 0;

    if ($shift_now == 'Shift 1') {
        $query2 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
        $result2 = $mysqli->query($query2);
        foreach ($result2 as $row) {
            if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                $shift_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['end_time'];
            } else {
                $shift_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
            }
        }
        $result2->close();
    } else if ($shift_now == 'Shift 3') {
        $query2 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
        $result2 = $mysqli->query($query2);
        foreach ($result2 as $row) {
            if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                $shift_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
            } else {
                $shift_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
                $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row['end_time'];
            }
        }
        $result2->close();
    }

    $dnt_category = array();
    $query2 = "SELECT * FROM master_downtime";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row2) {
        $rest_category = $row2['category'];
        array_push($dnt_category, "$rest_category");
    }
    array_push($dnt_category, "Lain-lain");
    $result2->close();

    $query2 = "SELECT * FROM setup_production WHERE start_time >= '$shift_start' AND start_time <= '$shift_end' AND status != 'Finish'";
    $result2 = $mysqli->query($query2);
    $cek_prod = mysqli_num_rows($result2);
    $result2->close();
    if ($cek_prod > 0) {
        for ($i = 0; $i < count($dnt_category); $i++) {
            $dnt_category_ = $dnt_category[$i];
            $query2 = "SELECT * FROM downtime WHERE start_downtime >= '$shift_start' AND start_downtime <= '$shift_end' AND category = '$dnt_category_'";
            $result2 = $mysqli->query($query2);
            foreach ($result2 as $row2) {
                $total_time += number_format($row2['total_time'] / 60, 2);
            }
            $result2->close();

            if ($total_time > 0) {
                $rest_data1 = [
                    "$dnt_category_" => "$total_time"
                ];
                $dataa1 += $rest_data1;
            }

            $total_time = 0;
            $rest_data1 = [];
        }
        $dataa += $dataa1;
    }

    $mysqli->close();
    print json_encode($dataa);
}
