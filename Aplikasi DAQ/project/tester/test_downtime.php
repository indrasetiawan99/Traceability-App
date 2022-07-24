<?php
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'traceability_qrcode');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$mysqli) {
    die("Connection failed: " . $mysqli->error);
}

date_default_timezone_set("Asia/Jakarta");
$diff = 0;
$start_downtime_ = '2021-04-07 17:23:37';
$name_of_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$day = $name_of_day[date('w')];
$end_downtime_ = '2021-04-07 17:24:04';
$date_start = substr($start_downtime_, 0, 10);

echo '<br>';
echo 'Day is: ' . $day . '<br>';
echo 'Date start is: ' . $date_start . '<br>';
echo '<br>';
echo 'Start downtime: ' . $start_downtime_ . '<br>';
echo 'End downtime: ' . $end_downtime_ . '<br>';

// Search shift 1 time
$query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
$result1 = $mysqli->query($query1);
foreach ($result1 as $row) {
    $shift1_start = date('Y-m-d', strtotime($date_start)) . ' ' . $row['start_time'];
    $shift1_end = date('Y-m-d', strtotime($date_start)) . ' ' . $row['end_time'];
}
$result1->close();

// Search shift 3 time
$query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
$result1 = $mysqli->query($query1);
foreach ($result1 as $row) {
    $shift3_start = date('Y-m-d', strtotime($date_start)) . ' ' . $row['start_time'];
    $shift3_end = date('Y-m-d', strtotime('+1 days', strtotime($date_start))) . ' ' . $row['end_time'];
}
$result1->close();

$br_OT = date('Y-m-d', strtotime($date_start)) . ' 19:00:00';

$query1 = "SELECT * FROM downtime WHERE end_downtime IS NULL AND start_downtime <= '$start_downtime_'";
$result1 = $mysqli->query($query1);
$cek_downtime_cond1 = mysqli_num_rows($result1);
$result1->close();
echo '<br>';
echo 'Cek downtime condition 1: ' . $cek_downtime_cond1 . '<br>';

$query1 = "SELECT * FROM downtime WHERE id != '1' AND end_downtime > '$start_downtime_' AND end_downtime <= '$end_downtime_'";
$result1 = $mysqli->query($query1);
$cek_downtime_cond2 = mysqli_num_rows($result1);
echo '<br>';
echo 'Cek downtime condition 2: ' . $cek_downtime_cond2 . '<br>';

if ($cek_downtime_cond1 > 0) {
    $diff = 0;
} else if ($cek_downtime_cond2 > 0) {
    foreach ($result1 as $row1) {
        $start_downtime_cond2 = $row1['end_downtime'];
    }
    $result1->close();
    $start_downtime_ = $start_downtime_cond2;

    if ($start_downtime_ >= $shift1_start && $start_downtime_ <= $shift1_end) {
        $shift = 'shift1';
        $shift_start = $shift1_start;
        $shift_end = $shift1_end;
    } else if ($start_downtime_ >= $shift3_start && $start_downtime_ <= $shift3_end) {
        $shift = 'shift3';
        $shift_start = $shift3_start;
        $shift_end = $shift3_end;
    }

    if ($shift == 'shift3') {
        if ($start_downtime_ <= $br_OT) {
            $shift = 'shift3_2';
        }
    }
    echo '<br>';
    echo 'The shift is: ' . $shift . '<br>';

    $start_downtime  = strtotime($start_downtime_);
    $end_downtime = strtotime($end_downtime_);

    if ($shift == 'shift1') {
        $query1 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            $break1_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break1_from'];
            $break1_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break1_to'];
            $break2_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break2_from'];
            $break2_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break2_to'];
            $break3_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break1_from'];
            $break3_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break1_to'];
        }
        $result1->close();

        $gt_break1_from  = strtotime($break1_from);
        $gt_break2_from  = strtotime($break2_from);
        $gt_break3_from  = strtotime($break3_from);

        if ($start_downtime_ <= $break1_from) {
            if ($end_downtime_ < $break1_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_from && $end_downtime_ < $break1_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break1_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 600;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 600;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 3600;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 4200;
            }
        } else if ($start_downtime_ <= $break2_from) {
            if ($end_downtime_ < $break2_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            }
        } else if ($start_downtime_ <= $break3_from) {
            if ($end_downtime_ < $break3_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 600;
            }
        } else if ($start_downtime_ >= $break3_to) {
            $diff  = $end_downtime - $start_downtime;
        }
    } else if ($shift == 'shift3') {
        $query1 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            $break1_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_from'];
            $break1_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_to'];
            $break2_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_from'];
            $break2_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_to'];
            $break3_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_from'];
            $break3_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_to'];
        }
        $result1->close();

        $gt_break1_from  = strtotime($break1_from);
        $gt_break2_from  = strtotime($break2_from);
        $gt_break3_from  = strtotime($break3_from);

        if ($start_downtime_ <= $break1_from) {
            if ($end_downtime_ < $break1_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_from && $end_downtime_ < $break1_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break1_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 5400;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 5400;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 6600;
            }
        } else if ($start_downtime_ <= $break2_from) {
            if ($end_downtime_ < $break2_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 2400;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 2400;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            }
        } else if ($start_downtime_ <= $break3_from) {
            if ($end_downtime_ < $break3_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 1200;
            }
        } else if ($start_downtime_ >= $break3_to) {
            $diff  = $end_downtime - $start_downtime;
        }
    } else if ($shift == 'shift3_2') {
        $query1 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            $break1_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_from'];
            $break1_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_to'];
            $break_OT_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break_OT_from'];
            $break_OT_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break_OT_to'];
            $break2_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_from'];
            $break2_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_to'];
            $break3_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_from'];
            $break3_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_to'];
        }
        $result1->close();

        $gt_break1_from  = strtotime($break1_from);
        $gt_break_OT_from  = strtotime($break_OT_from);
        $gt_break2_from  = strtotime($break2_from);
        $gt_break3_from  = strtotime($break3_from);

        if ($start_downtime_ <= $break1_from) {
            if ($end_downtime_ < $break1_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_from && $end_downtime_ < $break1_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break1_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_to && $end_downtime_ < $break_OT_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break_OT_from && $end_downtime_ < $break_OT_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break_OT_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break_OT_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 3600;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 6000;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 6000;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 7200;
            }
        } else if ($start_downtime_ <= $break_OT_from) {
            if ($end_downtime_ < $break_OT_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break_OT_from && $end_downtime_ < $break_OT_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break_OT_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break_OT_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 600;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 600;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 4200;
            }
        } else if ($start_downtime_ <= $break2_from) {
            if ($end_downtime_ < $break2_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 2400;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 2400;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            }
        } else if ($start_downtime_ <= $break3_from) {
            if ($end_downtime_ < $break3_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 1200;
            }
        } else if ($start_downtime_ >= $break3_to) {
            $diff  = $end_downtime - $start_downtime;
        }
    }
} else {
    if ($start_downtime_ >= $shift1_start && $start_downtime_ <= $shift1_end) {
        $shift = 'shift1';
        $shift_start = $shift1_start;
        $shift_end = $shift1_end;
    } else if ($start_downtime_ >= $shift3_start && $start_downtime_ <= $shift3_end) {
        $shift = 'shift3';
        $shift_start = $shift3_start;
        $shift_end = $shift3_end;
    }

    if ($shift == 'shift3') {
        if ($start_downtime_ <= $br_OT) {
            $shift = 'shift3_2';
        }
    }

    echo '<br>';
    echo 'The shift is: ' . $shift . '<br>';

    $start_downtime  = strtotime($start_downtime_);
    $end_downtime = strtotime($end_downtime_);

    if ($shift == 'shift1') {
        $query1 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            $break1_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break1_from'];
            $break1_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break1_to'];
            $break2_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break2_from'];
            $break2_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s1_break2_to'];
            $break3_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break1_from'];
            $break3_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break1_to'];
        }
        $result1->close();

        $gt_break1_from  = strtotime($break1_from);
        $gt_break2_from  = strtotime($break2_from);
        $gt_break3_from  = strtotime($break3_from);

        if ($start_downtime_ <= $break1_from) {
            if ($end_downtime_ < $break1_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_from && $end_downtime_ < $break1_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break1_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 600;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 600;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 3600;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 4200;
            }
        } else if ($start_downtime_ <= $break2_from) {
            if ($end_downtime_ < $break2_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            }
        } else if ($start_downtime_ <= $break3_from) {
            if ($end_downtime_ < $break3_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 600;
            }
        } else if ($start_downtime_ >= $break3_to) {
            $diff  = $end_downtime - $start_downtime;
        }
    } else if ($shift == 'shift3') {
        $query1 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            $break1_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_from'];
            $break1_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_to'];
            $break2_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_from'];
            $break2_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_to'];
            $break3_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_from'];
            $break3_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_to'];
        }
        $result1->close();

        $gt_break1_from  = strtotime($break1_from);
        $gt_break2_from  = strtotime($break2_from);
        $gt_break3_from  = strtotime($break3_from);

        if ($start_downtime_ <= $break1_from) {
            if ($end_downtime_ < $break1_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_from && $end_downtime_ < $break1_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break1_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 5400;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 5400;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 6600;
            }
        } else if ($start_downtime_ <= $break2_from) {
            if ($end_downtime_ < $break2_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 2400;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 2400;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            }
        } else if ($start_downtime_ <= $break3_from) {
            if ($end_downtime_ < $break3_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 1200;
            }
        } else if ($start_downtime_ >= $break3_to) {
            $diff  = $end_downtime - $start_downtime;
        }
    } else if ($shift == 'shift3_2') {
        $query1 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row) {
            $break1_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_from'];
            $break1_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s2_break2_to'];
            $break_OT_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break_OT_from'];
            $break_OT_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break_OT_to'];
            $break2_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_from'];
            $break2_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break1_to'];
            $break3_from = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_from'];
            $break3_to = date('Y-m-d', strtotime($date_start)) . ' ' . $row['s3_break2_to'];
        }
        $result1->close();

        $gt_break1_from  = strtotime($break1_from);
        $gt_break_OT_from  = strtotime($break_OT_from);
        $gt_break2_from  = strtotime($break2_from);
        $gt_break3_from  = strtotime($break3_from);

        if ($start_downtime_ <= $break1_from) {
            if ($end_downtime_ < $break1_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_from && $end_downtime_ < $break1_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break1_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break1_to && $end_downtime_ < $break_OT_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break_OT_from && $end_downtime_ < $break_OT_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break_OT_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break_OT_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 3600;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 6000;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 6000;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 7200;
            }
        } else if ($start_downtime_ <= $break_OT_from) {
            if ($end_downtime_ < $break_OT_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break_OT_from && $end_downtime_ < $break_OT_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break_OT_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break_OT_to && $end_downtime_ < $break2_from) {
                $diff  = ($end_downtime - $start_downtime) - 600;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime - 600;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 3000;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 3000;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 4200;
            }
        } else if ($start_downtime_ <= $break2_from) {
            if ($end_downtime_ < $break2_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_from && $end_downtime_ < $break2_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break2_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break2_to && $end_downtime_ < $break3_from) {
                $diff  = ($end_downtime - $start_downtime) - 2400;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime - 2400;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 3600;
            }
        } else if ($start_downtime_ <= $break3_from) {
            if ($end_downtime_ < $break3_from) {
                $diff  = $end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_from && $end_downtime_ < $break3_to) {
                $pure_end_downtime = $end_downtime - ($end_downtime - $gt_break3_from);
                $diff  = $pure_end_downtime - $start_downtime;
            } else if ($end_downtime_ >= $break3_to) {
                $diff  = ($end_downtime - $start_downtime) - 1200;
            }
        } else if ($start_downtime_ >= $break3_to) {
            $diff  = $end_downtime - $start_downtime;
        }
    }
}

echo '<br>';
echo 'Total downtime: ' . $diff . ' second<br>';
$mysqli->close();
