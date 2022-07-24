<?php
// Data Angka Shift 1
if ($_POST['read'] == 'Data-angka-s1') {
    include('connectionJSON.php');

    $data_a = [];
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 1';
    $part_NG_s1 = 0;
    $total_dnt_s1 = 0;
    $quality_s1 = 0;
    $availability_s1 = 0;
    $performance_s1 = 0;
    $oee_s1 = 0;

    // Search Shift 1 Time
    $query = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row['start_time'];
        $shift_end = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row['end_time'];
    }
    $result->close();

    $query = "SELECT * FROM recapitulation WHERE start_time >= '$shift_start' AND end_time <= '$shift_end'";
    $result = $mysqli->query($query);
    $i = 0;
    foreach ($result as $row) {
        $part_NG_s1 += $row['rejection'];
        $total_dnt_s1 = round($row['downtime'] / 60);
        $quality_s1 += $row['efficiency'];
        $availability_s1 += $row['availability'];
        $performance_s1 += $row['performance'];
        $oee_s1 += $row['oee'];
        $i++;
    }
    if ($i > 1) {
        $quality_s1 /= $i;
        $availability_s1 /= $i;
        $performance_s1 /= $i;
        $oee_s1 /= $i;
    }
    $result->close();

    if ($oee_s1 == 0) {
        $oee_s1 = 1;
    }
    $data_a1 = [
        'part_NG_s1' => round($part_NG_s1),
        'total_dnt_s1' => round($total_dnt_s1),
        'quality_s1' => round($quality_s1),
        'availability_s1' => round($availability_s1),
        'performance_s1' => round($performance_s1),
        'oee_s1' => $oee_s1
    ];
    $data_a += $data_a1;

    $mysqli->close();
    print json_encode($data_a);
}

// Downtime Shift 1
if ($_POST['read'] == 'Downtime-s1') {
    include('connectionJSON.php');
    date_default_timezone_set("Asia/Jakarta");
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 1';
    $data_b = [];
    $data_b1 = [];
    $total_time = 0;

    $query2 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row2) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row2['start_time'];
        $shift_end = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row2['end_time'];
    }
    $result2->close();

    $dnt_category = array();
    $query2 = "SELECT * FROM master_downtime";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row2) {
        $rest_category = $row2['category'];
        array_push($dnt_category, "$rest_category");
    }
    array_push($dnt_category, "Lain-lain");
    $result2->close();

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
            $data_b1 += $rest_data1;
        }

        $total_time = 0;
        $rest_data1 = [];
    }
    $data_b += $data_b1;

    $mysqli->close();
    print json_encode($data_b);
}

// NG Part Shift 1
if ($_POST['read'] == 'NG-part-s1') {
    include('connectionJSON.php');
    date_default_timezone_set("Asia/Jakarta");
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 1';
    $data_c = [];
    $data_c1 = [];
    $total_NG = 0;

    $query3 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row3['start_time'];
        $shift_end = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row3['end_time'];
    }
    $result3->close();

    $NG_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting');
    $NG_field = array('crack', 'dimensi', 'ejector_mark', 'short_shoot', 'wide_line', 'kontaminasi', 'buble', 'flow_mark', 'bending', 'sink_mark', 'burn_mark', 'scratch', 'silver', 'blackspot', 'gloss', 'mutih', 'minyak', 'jetting', 'over_cut', 'burry', 'check_of', 'colour', 'setting');
    for ($i = 0; $i < count($NG_category); $i++) {
        $NG_category_ = $NG_category[$i];
        $NG_field_ = $NG_field[$i];
        $query3 = "SELECT * FROM rejection WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND $NG_field_ = 'Yes'";
        $result3 = $mysqli->query($query3);
        foreach ($result3 as $row3) {
            $total_NG += 1;
        }
        $result3->close();

        if ($total_NG > 0) {
            $rest_data1 = [
                "$NG_category_" => "$total_NG"
            ];
            $data_c1 += $rest_data1;
        }

        $total_NG = 0;
        $rest_data1 = [];
    }
    $query3 = "SELECT * FROM rejection WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND lain_lain IS NOT NULL";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $total_NG += 1;
    }
    $result3->close();

    if ($total_NG > 0) {
        $rest_data1 = [
            "Lain-lain" => "$total_NG"
        ];
        $data_c1 += $rest_data1;
    }
    $data_c += $data_c1;

    $mysqli->close();
    print json_encode($data_c);
}

// Data Hourly Achievement Shift 1
if ($_POST['read'] == 'Data-hourly-s1') {
    include('connectionJSON.php');

    $data_d = [];
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 1';
    $RH_periode_s1 = array();
    $LH_periode_s1 = array();

    // Search Shift 1 Time
    $query4 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result4 = $mysqli->query($query4);
    foreach ($result4 as $row) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row['start_time'];
        $shift_end = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row['end_time'];
    }
    $result4->close();

    for ($i = 0; $i < 12; $i++) {
        $temp_datetime = $daily_report_date . ' ' . str_pad(strval($i + 6), 2, '0', STR_PAD_LEFT);

        $rest_qty = 0;
        $query4 = "SELECT * FROM part_production WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND status != 'reject' AND status IS NOT NULL AND date_time LIKE '$temp_datetime%' AND part_name LIKE '% RH %'";
        $result4 = $mysqli->query($query4);
        foreach ($result4 as $row4) {
            $rest_qty += 1;
        }
        $result4->close();
        array_push($RH_periode_s1, "$rest_qty");

        $rest_qty = 0;
        $query4 = "SELECT * FROM part_production WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND status != 'reject' AND status IS NOT NULL AND date_time LIKE '$temp_datetime%' AND part_name LIKE '% LH %'";
        $result4 = $mysqli->query($query4);
        foreach ($result4 as $row4) {
            $rest_qty += 1;
        }
        $result4->close();
        array_push($LH_periode_s1, "$rest_qty");
    }

    $data_d1 = [
        "RH_qty" => $RH_periode_s1,
        "LH_qty" => $LH_periode_s1
    ];
    $data_d += $data_d1;
    $mysqli->close();
    print json_encode($data_d);
}

// NG Part Description Shift 1
if ($_POST['read'] == 'NG-desc-s1') {
    include('connectionJSON.php');

    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 1';
    $data_e = [];
    $data_e1 = array();
    $data_e2 = array();
    $data_e3 = array();
    $data_e4 = array();

    // Search Shift 1 Time
    $query5 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result5 = $mysqli->query($query5);
    foreach ($result5 as $row5) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row5['start_time'];
        $shift_end = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row5['end_time'];
    }
    $result5->close();

    $ng_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting', 'Lain-lain');
    $field_category = array('crack', 'dimensi', 'ejector_mark', 'short_shoot', 'wide_line', 'kontaminasi', 'buble', 'flow_mark', 'bending', 'sink_mark', 'burn_mark', 'scratch', 'silver', 'blackspot', 'gloss', 'mutih', 'minyak', 'jetting', 'over_cut', 'burry', 'check_of', 'colour', 'setting');
    $str_ng_category = '';

    $query5 = "SELECT * FROM rejection WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' ORDER BY id DESC";
    $result5 = $mysqli->query($query5);

    foreach ($result5 as $row5) {
        for ($i = 0; $i < 23; $i++) {
            if ($row5[$field_category[$i]] == 'Yes') {
                if ($str_ng_category == '') {
                    $str_ng_category .=  $ng_category[$i];
                } else {
                    $str_ng_category .=  ', ' . $ng_category[$i];
                }
            }
        }
        if ($row5['lain_lain'] != NULL) {
            $str_ng_category .=  'Lain-lain';
        }

        array_push($data_e1, $row5['part_name']);
        array_push($data_e2, $row5['qrcode']);
        array_push($data_e3, $str_ng_category);
        array_push($data_e4, $row5['date_time']);
        $str_ng_category = '';
    }
    $result5->close();

    $data_e = [$data_e1, $data_e2, $data_e3, $data_e4];
    $mysqli->close();
    print json_encode($data_e);
}

// Downtime Description Shift 1
if ($_POST['read'] == 'Dnt-desc-s1') {
    include('connectionJSON.php');
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 1';
    $data_f = [];
    $data_f1 = array();
    $data_f2 = array();
    $data_f3 = array();
    $data_f4 = array();
    $data_f5 = array();
    $data_f6 = array();
    $data_f7 = array();

    // Search Shift 1 Time
    $query6 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result6 = $mysqli->query($query6);
    foreach ($result6 as $row6) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row6['start_time'];
        $shift_end = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row6['end_time'];
    }
    $result6->close();

    $query6 = "SELECT * FROM downtime WHERE start_downtime >= '$shift_start' AND start_downtime <= '$shift_end' ORDER BY id DESC";
    $result6 = $mysqli->query($query6);
    foreach ($result6 as $row6) {
        array_push($data_f1, $row6['category']);
        array_push($data_f2, $row6['user_start']);
        array_push($data_f3, $row6['start_downtime']);
        array_push($data_f4, $row6['user_end']);
        array_push($data_f5, $row6['end_downtime']);
        array_push($data_f6, $row6['description']);
        array_push($data_f7, $row6['total_time']);
    }
    $result6->close();

    $data_f = [$data_f1, $data_f2, $data_f3, $data_f4, $data_f5, $data_f6, $data_f7];
    $mysqli->close();
    print json_encode($data_f);
}

// Data Angka Shift 3
if ($_POST['read'] == 'Data-angka-s3') {
    include('connectionJSON.php');

    $data_g = [];
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 3';
    $part_NG_s3 = 0;
    $total_dnt_s3 = 0;
    $quality_s3 = 0;
    $availability_s3 = 0;
    $performance_s3 = 0;
    $oee_s3 = 0;

    $query7 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result7 = $mysqli->query($query7);
    foreach ($result7 as $row7) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row7['start_time'];
        $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($daily_report_date))) . ' ' . $row7['end_time'];
    }
    $result7->close();

    $query7 = "SELECT * FROM recapitulation WHERE start_time >= '$shift_start' AND end_time <= '$shift_end'";
    $result7 = $mysqli->query($query7);
    $i = 0;
    foreach ($result7 as $row7) {
        $part_NG_s3 += $row7['rejection'];
        $total_dnt_s3 = round($row7['downtime'] / 60);
        $quality_s3 += $row7['efficiency'];
        $availability_s3 += $row7['availability'];
        $performance_s3 += $row7['performance'];
        $oee_s3 += $row7['oee'];
        $i++;
    }
    if ($i > 1) {
        $quality_s3 /= $i;
        $availability_s3 /= $i;
        $performance_s3 /= $i;
        $oee_s3 /= $i;
    }
    $result7->close();

    if ($oee_s3 == 0) {
        $oee_s3 = 1;
    }
    $data_g1 = [
        'part_NG_s3' => round($part_NG_s3),
        'total_dnt_s3' => round($total_dnt_s3),
        'quality_s3' => round($quality_s3),
        'availability_s3' => round($availability_s3),
        'performance_s3' => round($performance_s3),
        'oee_s3' => $oee_s3
    ];
    $data_g += $data_g1;

    $mysqli->close();
    print json_encode($data_g);
}

// Downtime Shift 3
if ($_POST['read'] == 'Downtime-s3') {
    include('connectionJSON.php');
    date_default_timezone_set("Asia/Jakarta");
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 3';
    $data_h = [];
    $data_h1 = [];
    $total_time = 0;

    $query8 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result8 = $mysqli->query($query8);
    foreach ($result8 as $row8) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row8['start_time'];
        $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($daily_report_date))) . ' ' . $row8['end_time'];
    }
    $result8->close();

    $dnt_category = array();
    $query8 = "SELECT * FROM master_downtime";
    $result8 = $mysqli->query($query8);
    foreach ($result8 as $row8) {
        $rest_category = $row8['category'];
        array_push($dnt_category, "$rest_category");
    }
    array_push($dnt_category, "Lain-lain");
    $result8->close();

    for ($i = 0; $i < count($dnt_category); $i++) {
        $dnt_category_ = $dnt_category[$i];
        $query8 = "SELECT * FROM downtime WHERE start_downtime >= '$shift_start' AND start_downtime <= '$shift_end' AND category = '$dnt_category_'";
        $result8 = $mysqli->query($query8);
        foreach ($result8 as $row8) {
            $total_time += number_format($row8['total_time'] / 60, 2);
        }
        $result8->close();

        if ($total_time > 0) {
            $rest_data1 = [
                "$dnt_category_" => "$total_time"
            ];
            $data_h1 += $rest_data1;
        }

        $total_time = 0;
        $rest_data1 = [];
    }
    $data_h += $data_h1;

    $mysqli->close();
    print json_encode($data_h);
}

// NG Part Shift 3
if ($_POST['read'] == 'NG-part-s3') {
    include('connectionJSON.php');
    date_default_timezone_set("Asia/Jakarta");
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 3';
    $data_i = [];
    $data_i1 = [];
    $total_NG = 0;

    $query9 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result9 = $mysqli->query($query9);
    foreach ($result9 as $row9) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row9['start_time'];
        $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($daily_report_date))) . ' ' . $row9['end_time'];
    }
    $result9->close();

    $NG_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting');
    $NG_field = array('crack', 'dimensi', 'ejector_mark', 'short_shoot', 'wide_line', 'kontaminasi', 'buble', 'flow_mark', 'bending', 'sink_mark', 'burn_mark', 'scratch', 'silver', 'blackspot', 'gloss', 'mutih', 'minyak', 'jetting', 'over_cut', 'burry', 'check_of', 'colour', 'setting');
    for ($i = 0; $i < count($NG_category); $i++) {
        $NG_category_ = $NG_category[$i];
        $NG_field_ = $NG_field[$i];
        $query9 = "SELECT * FROM rejection WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND $NG_field_ = 'Yes'";
        $result9 = $mysqli->query($query9);
        foreach ($result9 as $row9) {
            $total_NG += 1;
        }
        $result9->close();

        if ($total_NG > 0) {
            $rest_data1 = [
                "$NG_category_" => "$total_NG"
            ];
            $data_i1 += $rest_data1;
        }

        $total_NG = 0;
        $rest_data1 = [];
    }
    $query9 = "SELECT * FROM rejection WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND lain_lain IS NOT NULL";
    $result9 = $mysqli->query($query9);
    foreach ($result9 as $row9) {
        $total_NG += 1;
    }
    $result9->close();

    if ($total_NG > 0) {
        $rest_data1 = [
            "Lain-lain" => "$total_NG"
        ];
        $data_i1 += $rest_data1;
    }
    $data_i += $data_i1;

    $mysqli->close();
    print json_encode($data_i);
}

// Data Hourly Achievement Shift 3
if ($_POST['read'] == 'Data-hourly-s3') {
    include('connectionJSON.php');

    $data_j = [];
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 3';
    $RH_periode_s3 = array();
    $LH_periode_s3 = array();

    $query10 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result10 = $mysqli->query($query10);
    foreach ($result10 as $row10) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row10['start_time'];
        $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($daily_report_date))) . ' ' . $row10['end_time'];
    }
    $result10->close();

    for ($i = 0; $i < 12; $i++) {
        $temp_datetime = $daily_report_date . ' ' . str_pad(strval($i + 18), 2, '0', STR_PAD_LEFT);
        if ($i > 5) {
            $temp_datetime = $daily_report_date . ' ' . str_pad(strval($i + 18 - 24), 2, '0', STR_PAD_LEFT);
        }

        $rest_qty = 0;
        $query10 = "SELECT * FROM part_production WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND status != 'reject' AND status IS NOT NULL AND date_time LIKE '$temp_datetime%' AND part_name LIKE '% RH %'";
        $result10 = $mysqli->query($query10);
        foreach ($result10 as $row10) {
            $rest_qty += 1;
        }
        $result10->close();
        array_push($RH_periode_s3, "$rest_qty");

        $rest_qty = 0;
        $query10 = "SELECT * FROM part_production WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' AND status != 'reject' AND status IS NOT NULL AND date_time LIKE '$temp_datetime%' AND part_name LIKE '% LH %'";
        $result10 = $mysqli->query($query10);
        foreach ($result10 as $row10) {
            $rest_qty += 1;
        }
        $result10->close();
        array_push($LH_periode_s3, "$rest_qty");
    }

    $data_j1 = [
        "RH_qty" => $RH_periode_s3,
        "LH_qty" => $LH_periode_s3
    ];
    $data_j += $data_j1;
    $mysqli->close();
    print json_encode($data_j);
}

// NG Part Description Shift 3
if ($_POST['read'] == 'NG-desc-s3') {
    include('connectionJSON.php');

    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 3';
    $data_k = [];
    $data_k1 = array();
    $data_k2 = array();
    $data_k3 = array();
    $data_k4 = array();

    $query11 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result11 = $mysqli->query($query11);
    foreach ($result11 as $row11) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row11['start_time'];
        $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($daily_report_date))) . ' ' . $row11['end_time'];
    }
    $result11->close();

    $ng_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting', 'Lain-lain');
    $field_category = array('crack', 'dimensi', 'ejector_mark', 'short_shoot', 'wide_line', 'kontaminasi', 'buble', 'flow_mark', 'bending', 'sink_mark', 'burn_mark', 'scratch', 'silver', 'blackspot', 'gloss', 'mutih', 'minyak', 'jetting', 'over_cut', 'burry', 'check_of', 'colour', 'setting');
    $str_ng_category = '';

    $query11 = "SELECT * FROM rejection WHERE date_time >= '$shift_start' AND date_time <= '$shift_end' ORDER BY id DESC";
    $result11 = $mysqli->query($query11);

    foreach ($result11 as $row11) {
        for ($i = 0; $i < 23; $i++) {
            if ($row11[$field_category[$i]] == 'Yes') {
                if ($str_ng_category == '') {
                    $str_ng_category .=  $ng_category[$i];
                } else {
                    $str_ng_category .=  ', ' . $ng_category[$i];
                }
            }
        }
        if ($row11['lain_lain'] != NULL) {
            $str_ng_category .=  'Lain-lain';
        }

        array_push($data_k1, $row11['part_name']);
        array_push($data_k2, $row11['qrcode']);
        array_push($data_k3, $str_ng_category);
        array_push($data_k4, $row11['date_time']);
        $str_ng_category = '';
    }
    $result11->close();

    $data_k = [$data_k1, $data_k2, $data_k3, $data_k4];
    $mysqli->close();
    print json_encode($data_k);
}

// Downtime Description Shift 3
if ($_POST['read'] == 'Dnt-desc-s3') {
    include('connectionJSON.php');
    $daily_report_date = $_POST['daily-report-date'];
    $shift_now = 'Shift 3';
    $data_l = [];
    $data_l1 = array();
    $data_l2 = array();
    $data_l3 = array();
    $data_l4 = array();
    $data_l5 = array();
    $data_l6 = array();
    $data_l7 = array();

    $query12 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = '$shift_now'";
    $result12 = $mysqli->query($query12);
    foreach ($result12 as $row12) {
        $shift_start = date('Y-m-d', strtotime($daily_report_date)) . ' ' . $row12['start_time'];
        $shift_end = date('Y-m-d', strtotime('+1 days', strtotime($daily_report_date))) . ' ' . $row12['end_time'];
    }
    $result12->close();

    $query12 = "SELECT * FROM downtime WHERE start_downtime >= '$shift_start' AND start_downtime <= '$shift_end' ORDER BY id DESC";
    $result12 = $mysqli->query($query12);
    foreach ($result12 as $row12) {
        array_push($data_l1, $row12['category']);
        array_push($data_l2, $row12['user_start']);
        array_push($data_l3, $row12['start_downtime']);
        array_push($data_l4, $row12['user_end']);
        array_push($data_l5, $row12['end_downtime']);
        array_push($data_l6, $row12['description']);
        array_push($data_l7, $row12['total_time']);
    }
    $result12->close();

    $data_l = [$data_l1, $data_l2, $data_l3, $data_l4, $data_l5, $data_l6, $data_l7];
    $mysqli->close();
    print json_encode($data_l);
}
