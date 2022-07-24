<?php
if ($_POST['action'] == 'input') {
    if ($_POST['type'] == 'start-downtime') {
        include('../connection.php');

        $desc = $_POST['desc'];
        $category = $_POST['category'];
        $user = substr($_POST['nik'], 0, 4);

        date_default_timezone_set("Asia/Jakarta");
        $start_downtime = date("Y-m-d H:i:s");

        $query1 = "INSERT INTO downtime (category, user_start, start_downtime, description) VALUES ('$category', '$user', '$start_downtime', '$desc')";
        $mysqli->query($query1);

        $mysqli->close();
    } else if ($_POST['type'] == 'finish-downtime') {
        include('../connectionJSON.php');

        $err_user = 'Yes';
        $diff = 0;
        $id = $_POST['id'];
        $user = substr($_POST['nik'], 0, 4);

        $query1 = "SELECT * FROM downtime WHERE id = '$id'";
        $result1 = $mysqli->query($query1);
        foreach ($result1 as $row1) {
            $user_start = $row1['user_start'];
            $start_downtime_ = $row1['start_downtime'];
        }
        $result1->close();

        if ($user != $user_start) {
            $err_user = 'No';
            date_default_timezone_set("Asia/Jakarta");
            $name_of_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            $day = $name_of_day[date('w')];
            $end_downtime_ = date("Y-m-d H:i:s");
            $date_start = substr($start_downtime_, 0, 10);
            $datetime_now = date('Y-m-d H:i:s');
            $date_now = substr($datetime_now, 0, 10);
            $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
            $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));

            // Search shift 1 time
            $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
            $result1 = $mysqli->query($query1);
            foreach ($result1 as $row) {
                if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                    $shift1_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
                    $shift1_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['end_time'];
                } else {
                    $shift1_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
                    $shift1_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
                }
            }
            $result1->close();

            // Search shift 3 time
            $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
            $result1 = $mysqli->query($query1);
            foreach ($result1 as $row) {
                if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                    $shift3_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
                    $shift3_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
                } else {
                    $shift3_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
                    $shift3_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row['end_time'];
                }
            }
            $result1->close();

            $br_OT = date('Y-m-d', strtotime($date_now)) . ' 19:00:00';

            $query1 = "UPDATE downtime SET user_end = '$user', end_downtime = '$end_downtime_' WHERE id = '$id'";
            $mysqli->query($query1);

            $query1 = "SELECT * FROM downtime WHERE end_downtime IS NULL AND start_downtime <= '$start_downtime_'";
            $result1 = $mysqli->query($query1);
            $cek_downtime_cond1 = mysqli_num_rows($result1);
            $result1->close();

            $query1 = "SELECT * FROM downtime WHERE id != '$id' AND start_downtime < '$start_downtime_' AND end_downtime > '$start_downtime_' AND end_downtime <= '$end_downtime_'";
            $result1 = $mysqli->query($query1);
            $cek_downtime_cond2 = mysqli_num_rows($result1);

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

                $start_downtime = strtotime($start_downtime_);
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

            $query1 = "UPDATE downtime SET total_time = '$diff' WHERE id = '$id'";
            $mysqli->query($query1);
        }

        $data = [
            'err_user' => $err_user
        ];
        $mysqli->close();
        print json_encode($data);
    }
}
if ($_POST['action'] == 'edit') {
    if ($_POST['type'] == 'start-downtime') {
        include('../connection.php');

        $id = $_POST['id'];
        $desc = $_POST['desc'];
        $category = $_POST['category'];

        $query2 = "UPDATE downtime SET category = '$category', description = '$desc' WHERE id = '$id'";
        $mysqli->query($query2);

        $mysqli->close();
    }
}
if ($_POST['action'] == 'update') {
    include('../connectionJSON.php');
    $diff = 0;

    date_default_timezone_set("Asia/Jakarta");
    $datetime_now = date("Y-m-d H:i:s");
    $date_now = substr($datetime_now, 0, 10);
    $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
    $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));

    // Search shift 1 time
    $query3 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift1_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
            $shift1_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['end_time'];
        } else {
            $shift1_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
            $shift1_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
        }
    }
    $result3->close();

    // Search shift 3 time
    $query3 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift3_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
            $shift3_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
        } else {
            $shift3_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
            $shift3_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row['end_time'];
        }
    }
    $result3->close();

    if ($datetime_now >= $shift1_start && $datetime_now <= $shift1_end) {
        $shift_start = $shift1_start;
        $shift_end = $shift1_end;
    } else if ($datetime_now >= $shift3_start && $datetime_now <= $shift3_end) {
        $shift_start = $shift3_start;
        $shift_end = $shift3_end;
    }

    $query3 = "SELECT * FROM downtime WHERE start_downtime >= '$shift_start' AND end_downtime <= '$shift_end'";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $diff  += $row3['total_time'];
    }
    $result3->close();

    $query3 = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% LH %' AND start_time >= '$shift_start' ORDER BY start_time ASC LIMIT 1";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $partname_L = $row3['part_name'];
    }
    $result3->close();

    $query3 = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% RH %' AND start_time >= '$shift_start' ORDER BY start_time ASC LIMIT 1";
    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $partname_R = $row3['part_name'];
    }
    $result3->close();

    $query3 = "UPDATE recapitulation SET downtime = '$diff' WHERE status = 'On Process' AND part_name = '$partname_L' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query3);
    $query3 = "UPDATE recapitulation SET downtime = '$diff' WHERE status = 'On Process' AND part_name = '$partname_R' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query3);

    $mysqli->close();
}
