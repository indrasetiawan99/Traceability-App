<?php
if ($_POST['action'] == 'search-qrcode') {
    include('./connectionJSON.php');

    $qrcode = $_POST['qrcode'];
    $seq_num = substr($qrcode, 0, 9);

    $npk = $qrcode;
    for ($i = 0; $i < 4; $i++) {
        $npk = substr($npk, strpos($npk, '_') + 1);
    }
    $npk = substr($npk, 0, strpos($npk, '_'));

    $tr_datapart = '';
    $datetime = '';
    $name = '';
    $op_skill = '';
    $part_name = '';
    $sku = '';
    $cust = '';
    $pn_api = '';
    $pn_cust = '';
    $pack = '';
    $address = '';
    $job_num = '';
    $time_prod = '';
    $status = '';
    $str_ng_category = '';

    $query1 = "SELECT * FROM part_production WHERE qrcode = '$qrcode'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        $tr_datapart = $row1['datapart'];
        $name = $row1['op_name'];
        $part_name = $row1['part_name'];
        $datetime = $row1['date_time'];
        $status = $row1['status'];
    }
    if ($status == 'reject') {
        $status = 'NG';
    } else if ($status == NULL) {
        $status = 'NULL';
    } else {
        $status = 'OK';
    }
    $result1->close();

    $query2 = "SELECT * FROM master_product WHERE part_name = '$part_name'";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row2) {
        $sku = $row2['sku_maris'];
        $cust = $row2['customer'];
        $pn_api = $row2['pn_api'];
        $pn_cust = $row2['pn_cust'];
        $pack = $row2['packaging'];
        $time_prod = $row2['time_production'];
        $job_num = $row2['job_no'];
        $address = $row2['address'];
    }
    $result2->close();

    $query3 = "SELECT * FROM master_user WHERE nik = '$npk'";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $op_skill = $row3['op_skill'];
    }
    $result3->close();

    $ng_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting', 'Lain-lain');
    $field_category = array('crack', 'dimensi', 'ejector_mark', 'short_shoot', 'wide_line', 'kontaminasi', 'buble', 'flow_mark', 'bending', 'sink_mark', 'burn_mark', 'scratch', 'silver', 'blackspot', 'gloss', 'mutih', 'minyak', 'jetting', 'over_cut', 'burry', 'check_of', 'colour', 'setting');
    $query4 = "SELECT * FROM rejection WHERE qrcode = '$qrcode'";
    $result4 = $mysqli->query($query4);

    $i = 1;
    foreach ($result4 as $row4) {
        for ($ii = 0; $ii < 23; $ii++) {
            if ($row4[$field_category[$ii]] == 'Yes') {
                if ($str_ng_category == '') {
                    $str_ng_category .=  $ng_category[$ii];
                } else {
                    $str_ng_category .=  ', ' . $ng_category[$ii];
                }
            }
        }
        if ($row4['lain_lain'] != NULL) {
            $str_ng_category .=  'Lain-lain';
        }
        $i++;
    }
    $result4->close();

    $data = [
        'tr_datapart' => $tr_datapart,
        'seq_num' => $seq_num,
        'datetime' => $datetime,
        'npk' => $npk,
        'name' => $name,
        'op_skill' => $op_skill . ' %',
        'part_name' => $part_name,
        'sku' => $sku,
        'cust' => $cust,
        'pn_api' => $pn_api,
        'pn_cust' => $pn_cust,
        'pack' => $pack,
        'address' => $address,
        'job_num' => $job_num,
        'time_prod' => $time_prod . ' s',
        'status' => $status,
        'desc' => $str_ng_category
    ];
    $mysqli->close();
    print json_encode($data);
}

if ($_POST['action'] == 'search-datapart-code') {
    include('./connectionJSON.php');

    $data_a = array();
    $datapart_code = $_POST['datapart-code'];
    $query5 = "SELECT * FROM part_production WHERE datapart = '$datapart_code'";
    $result5 = $mysqli->query($query5);
    foreach ($result5 as $row5) {
        $temp_var = $row5['qrcode'];
        array_push($data_a, $temp_var);
    }
    $result5->close();

    $mysqli->close();
    print json_encode($data_a);
}
