<?php
include('../connectionJSON.php');

$action = $_GET['action'];

if ($action == "read") {
    $query1 = "SELECT * FROM temp_datapart";
    $result1 = $mysqli->query($query1);
    $cekData = mysqli_num_rows($result1);

    $code = "";
    if ($cekData != 0) {
        foreach ($result1 as $row) {
            $id = $row['id'];
            $name = $row['op_name'];
            $uniqNum = $row['uniq_number'];
            $code = $row['code'];
            $packaging = $row['packaging'];
            $partName = $row['part_name'];
            $pnApi = $row['pn_api'];
            $pnCust = $row['pn_cust'];
            $job_no = $row['job_no'];
            $address = $row['address'];
            $date = $row['date'];
            $time = $row['time'];
            $datetime = $row['date_time'];
            $datetime2 = $row['date_time2'];
        }

        $query2 = "SELECT * FROM master_product WHERE part_name = '$partName'";
        $result2 = $mysqli->query($query2);
        foreach ($result2 as $row) {
            $pos_part_ = $row['position'];
        }
        $result2->close();

        if ($pos_part_ == 'Right') {
            $pos_part = 'RH';
        } else if ($pos_part_ == 'Left') {
            $pos_part = 'LH';
        }

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime();
        $time_now = $date_now->format('Y-m-d H:i:s');
        $shift1_time = $date_now->format('Y-m-d') . ' 06:00:00';
        $shift3_time = $date_now->format('Y-m-d') . ' 18:00:00';

        if ($time_now >= $shift1_time && $time_now < $shift3_time) {
            $shift = '1';
            $sTime = '06:00:00';
        } else {
            $shift = '3';
            $sTime = '18:00:00';
        }

        $section = 'ASSY';
        $part = 'FG';

        $data_ = [
            'uniqNum' => $uniqNum,
            'code' => $code,
            'name' => $name,
            'partName' => $partName,
            'pnApi' => $pnApi,
            'pnCust' => $pnCust,
            'job_no' => $job_no,
            'address' => $address,
            'pack' => $packaging,
            'date' => $date,
            'time' => $time,
            'dateTime' => $datetime,
            'shift' => $shift,
            'pos_part' => $pos_part,
            'status' => "active"
        ];

        $myfile = fopen("../../txt-maris/$uniqNum-$pnApi.txt", "w") or die("Unable to open file!");
        $txt = "$datetime2|$uniqNum|$pnApi|$partName|$packaging|$shift|$sTime|$shift|$section|$part|$name|$date|$time|Ready";
        fwrite($myfile, $txt);
        fclose($myfile);
    } else {
        $data_ = [
            'uniqNum' => "",
            'code' => "",
            'name' => "",
            'partName' => "",
            'pnApi' => "",
            'pnCust' => "",
            'job_no' => "",
            'address' => "",
            'pack' => "",
            'date' => "",
            'time' => "",
            'dateTime' => "",
            'shift' => "",
            'pos_part' => "",
            'status' => "inactive"
        ];
    }

    $data = [$data_];

    $result1->close();

    print json_encode($data);
} else if ($action == "delete") {
    $query1 = "SELECT * FROM temp_datapart";
    $result1 = $mysqli->query($query1);

    foreach ($result1 as $row) {
        $code = $row['code'];
    }

    $query2 = "DELETE FROM temp_datapart";
    $mysqli->query($query2);

    unlink('../../upload/qrcode/item-' . $code . '.png');
    unlink('../../upload/barcode/item-' . $code . '.jpg');
}

$mysqli->close();
