<?php
if (isset($_GET['seq3-status'])) {
    $seqStatus  = 'OK';
    $position = 'Right';

    include('../connection.php');
    require('../../assets/vendor/autoload.php');

    $query0 = "SELECT * FROM jig_and_nut";
    $result0 = $mysqli->query($query0);
    foreach ($result0 as $row) {
        $cek_jig = $row['jig'];
        $cek_nut = $row['nut'];
    }
    $result0->close();

    //Read temp_production for part name and nik
    $query1 = "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result1 = $mysqli->query($query1);
    $load_seq_R = mysqli_num_rows($result1);

    foreach ($result1 as $row) {
        $partName = $row['part_name'];
        $nik = $row['nik'];
    }
    $result1->close();

    //Read user data to get operator name
    $query2 = "SELECT * FROM master_user WHERE nik = '$nik'";
    $result2 = $mysqli->query($query2);

    foreach ($result2 as $row) {
        $opName = $row['full_name'];
    }
    $result2->close();

    $query4 = "SELECT * FROM master_product WHERE part_name = '$partName'";
    $result4 = $mysqli->query($query4);
    foreach ($result4 as $row) {
        $jig = $row['jig'];
        $nut = $row['nut'];
        $pn_cust = $row['pn_cust'];
        $pack = $row['packaging'];
        $type = $row['type'];
        $pos_part_ = $row['position'];
    }
    $result4->close();

    if ($pos_part_ == 'Right') {
        $pos_part = 'RH';
    } else if ($pos_part_ == 'Left') {
        $pos_part = 'LH';
    }

    date_default_timezone_set("Asia/Jakarta");

    $datetime = date("Y-m-d H:i:s");
    $datetimeQR = date("dmy_H.i.s");

    if ($load_seq_R > 0 && $cek_jig == $jig && $cek_nut == $nut) {
        $query5 = "SELECT * FROM uniq_code_qr";
        $result5 = $mysqli->query($query5);
        foreach ($result5 as $row5) {
            $temp_var = $row5['date'];
            $cycle = $row5['cycle'];
            $year_month_last = date(substr($temp_var, 0, 7));
        }
        $result5->close();

        $year_month_now = date("Y-m");
        $date_now = date("Y-m-d");

        if ($year_month_now > $year_month_last || $cycle < 1) {
            $query6 = "UPDATE uniq_code_qr SET cycle = 1, date = '$date_now'";
            $mysqli->query($query6);
        }
        $id = sprintf("%05d", $cycle);
        $uniq_number = substr(date('Y'), 2) . date('m') . $id;

        $query6 = "UPDATE uniq_code_qr SET cycle = cycle + 1";
        $mysqli->query($query6);

        $valQRcode = $uniq_number . '_' . $pn_cust . '_' . 'API' . '_' . $pack . '_' . $nik . '_' . $datetimeQR;

        $query3 = "INSERT INTO part_production (part_name, position, op_name, seq1_status, seq2_status, seq3_status, date_time, qrcode) VALUES ('$partName', '$position', '$opName', '$seqStatus', '$seqStatus', '$seqStatus', '$datetime', '$valQRcode')";
        $mysqli->query($query3);

        if ($valQRcode != '') {
            $print_data = "
            <0x10>CT~~CD,~CC^~CT~
            ^XA~TA000~JSN^LT0^MNW^MTT^PON^PMN^LH0,0^JMA^PR5,5~SD15^JUS^LRN^CI0^XZ
            ^XA
            ^MMT
            ^PW400
            ^LL0080
            ^LS0
            ^FT150,102^BQN,2,3
            ^FH\^FDLA," . $valQRcode . "^FS
            ^FT151,110^A0N,19,19^FH\^FD" . $type . " / " . $pos_part . "^FS
            ^PQ1,0,1,Y^XZ        
            ";
            $fp = pfsockopen("192.168.1.203", 9100);
            fputs($fp, $print_data);
            fclose($fp);
        }
    }

    $mysqli->close();
}
