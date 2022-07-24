<?php
include('../connection.php');

if ($_POST['action'] == 'read') {
    date_default_timezone_set("Asia/Jakarta");
    $datetime_now = date("Y-m-d H:i:s");
    $date_now = substr($datetime_now, 0, 10);
    $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
    $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));

    // Search shift 1 time
    $query13 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
    $result13 = $mysqli->query($query13);
    foreach ($result13 as $row13) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift1_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row13['start_time'];
            $shift1_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row13['end_time'];
        } else {
            $shift1_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row13['start_time'];
            $shift1_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row13['end_time'];
        }
    }
    $result13->close();

    // Search shift 3 time
    $query14 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
    $result14 = $mysqli->query($query14);
    foreach ($result14 as $row14) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift3_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row14['start_time'];
            $shift3_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row14['end_time'];
        } else {
            $shift3_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row14['start_time'];
            $shift3_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row14['end_time'];
        }
    }
    $result14->close();

    if ($datetime_now >= $shift1_start && $datetime_now <= $shift1_end) {
        $shift_start = $shift1_start;
        $shift_end = $shift1_end;
    } else if ($datetime_now >= $shift3_start && $datetime_now <= $shift3_end) {
        $shift_start = $shift3_start;
        $shift_end = $shift3_end;
    }

    $query1 = "SELECT * FROM setup_production WHERE status != 'Finish'";
    $result1 = $mysqli->query($query1);
    $cek_part = mysqli_num_rows($result1);
    if ($cek_part > 0) {
        foreach ($result1 as $row1) {
            $partName = $row1['part_name'];
            $date_string = substr($row1['start_time'], 0, 10);
            $start_time = $row1['start_time'];
        }
        $date = date("Y-m-d", strtotime($date_string));
        $date_setup_shift_min2 = date('Y-m-d H:i:s', strtotime($date . ' 00:00:00'));
        $date_setup_shift_max2 = date('Y-m-d H:i:s', strtotime($date . ' 05:59:59'));

        // Search shift 1 time
        $query13 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
        $result13 = $mysqli->query($query13);
        foreach ($result13 as $row13) {
            if ($start_time >= $date_setup_shift_min2 && $start_time <= $date_setup_shift_max2) {
                $shift1_start2 = date('Y-m-d', strtotime('-1 days', strtotime($date))) . ' ' . $row13['start_time'];
                $shift1_end2 = date('Y-m-d', strtotime('-1 days', strtotime($date))) . ' ' . $row13['end_time'];
            } else {
                $shift1_start2 = date('Y-m-d', strtotime($date)) . ' ' . $row13['start_time'];
                $shift1_end2 = date('Y-m-d', strtotime($date)) . ' ' . $row13['end_time'];
            }
        }
        $result13->close();

        // Search shift 3 time
        $query14 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
        $result14 = $mysqli->query($query14);
        foreach ($result14 as $row14) {
            if ($start_time >= $date_setup_shift_min2 && $start_time <= $date_setup_shift_max2) {
                $shift3_start2 = date('Y-m-d', strtotime('-1 days', strtotime($date))) . ' ' . $row14['start_time'];
                $shift3_end2 = date('Y-m-d', strtotime($date)) . ' ' . $row14['end_time'];
            } else {
                $shift3_start2 = date('Y-m-d', strtotime($date)) . ' ' . $row14['start_time'];
                $shift3_end2 = date('Y-m-d', strtotime('+1 days', strtotime($date))) . ' ' . $row14['end_time'];
            }
        }
        $result14->close();

        if ($start_time >= $shift1_start2 && $start_time <= $shift1_end2) {
            $shift_start2 = $shift1_start2;
            $shift_end2 = $shift1_end2;
        } else if ($start_time >= $shift3_start2 && $start_time <= $shift3_end2) {
            $shift_start2 = $shift3_start2;
            $shift_end2 = $shift3_end2;
        }

        if ($datetime_now >= $shift_end2) {
            $query2 = "SELECT * FROM master_product WHERE part_name = '$partName'";
            $result2 = $mysqli->query($query2);
            foreach ($result2 as $row) {
                $position = $row['position'];
                $pnApi = $row['pn_api'];
                $pnCust = $row['pn_cust'];
            }
            $result2->close();

            $query3 = "SELECT * FROM part_production WHERE part_name = '$partName' AND position = '$position' AND seq3_status = 'OK' AND qrcode IS NOT NULL AND status = 'waiting'";
            $result3 = $mysqli->query($query3);
            $counting = mysqli_num_rows($result3);
            $result3->close();

            if ($counting > 0) {
                $query4 = "SELECT * FROM remaining_part WHERE part_name = '$partName'";
                $result4 = $mysqli->query($query4);
                $cek_part = mysqli_num_rows($result4);
                $result4->close();

                if ($cek_part > 0) {
                    date_default_timezone_set("Asia/Jakarta");
                    $datetime = date("Y-m-d H:i:s");
                    $query5 = "UPDATE remaining_part SET qty = qty + $counting, date_time = '$datetime' WHERE part_name = '$partName'";
                    $mysqli->query($query5);
                } else {
                    $query5 = "INSERT INTO remaining_part (part_name, pn_api, pn_cust, qty) VALUES ('$partName','$pnApi', '$pnCust', '$counting')";
                    $mysqli->query($query5);
                }

                if ($position == 'Right') {
                    $query6 = "UPDATE temp_counting_seq4 SET counting_R = 0";
                    $mysqli->query($query6);
                } else if ($position == 'Left') {
                    $query6 = "UPDATE temp_counting_seq4 SET counting_L = 0";
                    $mysqli->query($query6);
                }

                $query7 = "UPDATE part_production SET status = 'pending' WHERE part_name = '$partName' AND datapart IS NULL AND status = 'waiting'";
                $mysqli->query($query7);

                $query14 = "INSERT temp_datapart_wip (part_name) VALUES ('$partName')";
                $mysqli->query($query11);
            }
            $query13 = "DELETE FROM part_production WHERE status IS NULL";
            $mysqli->query($query13);

            $query8 = "UPDATE setup_production SET status = 'Finish' WHERE part_name = '$partName' AND status != 'Finish'";
            $mysqli->query($query8);

            $query9 = "UPDATE recapitulation SET status = 'Finish' WHERE part_name = '$partName' AND status = 'On Process'";
            $mysqli->query($query9);

            $query10 = "DELETE FROM temp_production WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
            $mysqli->query($query10);

            $query11 = "SELECT * FROM temp_production WHERE seq_status = 'Active'";
            $result11 = $mysqli->query($query11);
            $loadCurrent = mysqli_num_rows($result11);
            $result11->close();
            if ($loadCurrent == 0) {
                $query12 = "ALTER TABLE temp_production AUTO_INCREMENT = 0";
                $mysqli->query($query12);
            }
        }
    }
}

$mysqli->close();
