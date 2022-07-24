<?php
if ($_POST['action'] == 'update') {
    $production_time = 0;
    $dandory_time = 0;
    $downtime = 0;
    $performance = 0;
    $availability = 0;
    $update_dandory_time = 0;
    $quality_RH = 0;
    $quality_LH = 0;
    $quality = 0;
    $oee = 0;

    include('../connection.php');
    date_default_timezone_set("Asia/Jakarta");
    $name_of_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $day = $name_of_day[date('w')];
    $datetime_now = date("Y-m-d H:i:s");
    $date_now = substr($datetime_now, 0, 10);
    $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
    $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));

    // Search shift 1 time
    $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row1) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift1_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row1['start_time'];
            $shift1_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row1['end_time'];
            $br_OT = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' 19:00:00';
        } else {
            $shift1_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row1['start_time'];
            $shift1_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row1['end_time'];
            $br_OT = date('Y-m-d', strtotime($date_now)) . ' 19:00:00';
        }
    }
    $result1->close();

    // Search shift 3 time
    $query2 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row2) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift3_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row2['start_time'];
            $shift3_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row2['end_time'];
        } else {
            $shift3_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row2['start_time'];
            $shift3_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row2['end_time'];
        }
    }
    $result2->close();

    if ($datetime_now >= $shift1_start && $datetime_now <= $shift1_end) {
        $shift = 'shift1';
        $shift_start = $shift1_start;
        $shift_end = $shift1_end;
        $available_time = 8 * 3600;
    } else if ($datetime_now >= $shift3_start && $datetime_now <= $shift3_end) {
        $shift = 'shift3';
        $shift_start = $shift3_start;
        $shift_end = $shift3_end;
        $available_time = 8 * 3600;
    }

    if ($shift == 'shift3') {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $real_shift_time = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' 21:00:00';
        } else {
            $real_shift_time = date('Y-m-d', strtotime($date_now)) . ' 21:00:00';
        }

        if ($datetime_now <= $br_OT) {
            $shift = 'shift3_2';
            $available_time = (8 * 3600) - (10 * 60);
        }
    } else {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $real_shift_time = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' 15:00:00';
        } else {
            $real_shift_time = date('Y-m-d', strtotime($date_now)) . ' 15:00:00';
        }
    }
    $gt_real_shift_time = strtotime($real_shift_time);

    $query9 = "SELECT * FROM dandory WHERE datetime >= '$shift_start' AND datetime <= '$shift_end'";
    $result9 = $mysqli->query($query9);
    foreach ($result9 as $row9) {
        $update_dandory_time += $row9['total_time'];
    }
    $result9->close();

    //PART RH
    $query5 = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
    $result5 = $mysqli->query($query5);
    foreach ($result5 as $row5) {
        $partname1 = $row5['part_name'];
    }
    $result5->close();

    $query6 = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$partname1' ORDER BY id ASC LIMIT 1";
    $result6 = $mysqli->query($query6);
    $cekLoading1 = mysqli_num_rows($result6);
    if ($cekLoading1 > 0) {
        foreach ($result6 as $row6) {
            $downtime = $row6['downtime'];
            $dandory_time = $row6['dandory'];
            $quality_RH = $row6['efficiency'];
        }
        $result6->close();
    }

    //PART LH
    $query7 = "SELECT * FROM setup_production WHERE status != 'Finish' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
    $result7 = $mysqli->query($query7);
    foreach ($result7 as $row7) {
        $partname2 = $row7['part_name'];
    }
    $result7->close();

    $query8 = "SELECT * FROM recapitulation WHERE status = 'On Process' AND part_name = '$partname2' ORDER BY id ASC LIMIT 1";
    $result8 = $mysqli->query($query8);
    $cekLoading2 = mysqli_num_rows($result8);
    if ($cekLoading2 > 0) {
        foreach ($result8 as $row8) {
            $downtime = $row8['downtime'];
            $dandory_time = $row8['dandory'];
            $quality_LH = $row8['efficiency'];
        }
        $result8->close();
    }

    $query10 = "UPDATE recapitulation SET dandory = $update_dandory_time WHERE status = 'On Process' AND part_name = '$partname1' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query10);
    $query10 = "UPDATE recapitulation SET dandory = $update_dandory_time WHERE status = 'On Process' AND part_name = '$partname2' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query10);

    $query4 = "SELECT * FROM setup_production WHERE start_time >= '$shift_start' AND start_time <= '$shift_end'";
    $result4 = $mysqli->query($query4);
    $dt_start_compare = '';
    foreach ($result4 as $row4) {
        $dt_start = $row4['start_time'];
        if ($dt_start_compare != $dt_start) {
            $dt_finish = $row4['end_time'];
            $gt_start = strtotime($row4['start_time']);
            $gt_finish = strtotime($row4['end_time']);

            if ($shift == 'shift1') {
                $query3 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
                $result3 = $mysqli->query($query3);
                foreach ($result3 as $row3) {
                    $break1_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s1_break1_from'];
                    $break1_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s1_break1_to'];
                    $break2_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s1_break2_from'];
                    $break2_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s1_break2_to'];
                    $break3_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s2_break1_from'];
                    $break3_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s2_break1_to'];
                }
                $result3->close();

                $gt_break1_from  = strtotime($break1_from);
                $gt_break2_from  = strtotime($break2_from);
                $gt_break3_from  = strtotime($break3_from);
                $gt_break3_to  = strtotime($break3_to);

                if ($dt_start <= $break1_from) {
                    if ($dt_finish < $break1_from) {
                        $production_time += ($gt_finish - $gt_start);
                    } else if ($dt_finish >= $break1_from && $dt_finish < $break1_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break1_from);
                        $production_time += ($pure_finish - $gt_start);
                    } else if ($dt_finish >= $break1_to && $dt_finish < $break2_from) {
                        $production_time += (($gt_finish - $gt_start) - 600);
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                        $production_time += ($pure_finish - $gt_start - 600);
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        if ($dt_finish > $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 3600) - ($gt_finish - $gt_real_shift_time));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 3600);
                        }
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += (($pure_finish - $gt_start - 3600) - 3600);
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (((($gt_finish - $gt_start) - 4200) - 3600) - ($gt_finish - $gt_break3_to));
                    }
                } else if ($dt_start <= $break2_from) {
                    if ($dt_finish < $break2_from) {
                        $production_time += ($gt_finish - $gt_start);
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                        $production_time += ($pure_finish - $gt_start);
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        if ($dt_finish > $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 3000) - ($gt_finish - $gt_real_shift_time));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 3000);
                        }
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += (($pure_finish - $gt_start - 3000) - 3600);
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (((($gt_finish - $gt_start) - 3600) - 3600) - ($gt_finish - $gt_break3_to));
                    }
                } else if ($dt_start <= $break3_from) {
                    if ($dt_finish < $break3_from) {
                        $production_time += ($gt_finish - $gt_start);
                        if ($dt_finish > $real_shift_time) {
                            $production_time += (($gt_finish - $gt_start) - ($gt_finish - $gt_real_shift_time));
                        } else {
                            $production_time += ($gt_finish - $gt_start);
                        }
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += (($pure_finish - $gt_start) - 3600);
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (((($gt_finish - $gt_start) - 600) - 3600) - ($gt_finish - $gt_break3_to));
                    }
                } else if ($dt_start >= $break3_to) {
                    $production_time += ((($gt_finish - $gt_start) - 3600) - ($gt_finish - $gt_break3_to));
                }
            } else if ($shift == 'shift3') {
                $query3 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
                $result3 = $mysqli->query($query3);
                foreach ($result3 as $row3) {
                    if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                        $break1_from = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row3['s2_break2_from'];
                        $break1_to = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row3['s2_break2_to'];
                        $break2_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break1_from'];
                        $break2_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break1_to'];
                        $break3_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break2_from'];
                        $break3_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break2_to'];
                    } else {
                        $break1_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s2_break2_from'];
                        $break1_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s2_break2_to'];
                        $break2_from = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break1_from'];
                        $break2_to = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break1_to'];
                        $break3_from = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break2_from'];
                        $break3_to = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break2_to'];
                    }
                }
                $result3->close();

                $gt_break1_from  = strtotime($break1_from);
                $gt_break2_from  = strtotime($break2_from);
                $gt_break3_from  = strtotime($break3_from);

                if ($dt_start <= $break1_from) {
                    if ($dt_finish < $break1_from) {
                        $production_time += 0;
                    } else if ($dt_finish >= $break1_from && $dt_finish < $break1_to) {
                        $production_time += 0;
                    } else if ($dt_finish >= $break1_to && $dt_finish < $break2_from) {
                        $production_time += (((($gt_finish - $gt_start) - 3000) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                        $production_time += ((($pure_finish - $gt_start - 3000) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        $production_time += (((($gt_finish - $gt_start) - 5400) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += ((($pure_finish - $gt_start - 5400) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (((($gt_finish - $gt_start) - 6600) - 7200) - ($gt_break1_from - $gt_start));
                    }
                } else if ($dt_start <= $break2_from) {
                    if ($dt_finish < $break2_from) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += (($gt_finish - $gt_start) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += ($gt_finish - $gt_start);
                        }
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        if ($dt_start < $real_shift_time) {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                            $production_time += (($pure_finish - $gt_start) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                            $production_time += ($pure_finish - $gt_start);
                        }
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 2400) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 2400);
                        }
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        if ($dt_start < $real_shift_time) {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                            $production_time += (($pure_finish - $gt_start - 2400) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                            $production_time += ($pure_finish - $gt_start - 2400);
                        }
                    } else if ($dt_finish >= $break3_to) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 3600) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 3600);
                        }
                    }
                } else if ($dt_start <= $break3_from) {
                    if ($dt_finish < $break3_from) {
                        $production_time += ($gt_finish - $gt_start);
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += ($pure_finish - $gt_start);
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (($gt_finish - $gt_start) - 1200);
                    }
                } else if ($dt_start >= $break3_to) {
                    $production_time += ($gt_finish - $gt_start);
                }
            } else if ($shift == 'shift3_2') {
                $query3 = "SELECT * FROM master_breaktime WHERE status = 'Active' AND break_name = '$day'";
                $result3 = $mysqli->query($query3);
                foreach ($result3 as $row3) {
                    if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
                        $break1_from = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row3['s2_break2_from'];
                        $break1_to = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row3['s2_break2_to'];
                        $break_OT_from = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row3['s3_break_OT_from'];
                        $break_OT_to = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row3['s3_break_OT_to'];
                        $break2_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break1_from'];
                        $break2_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break1_to'];
                        $break3_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break2_from'];
                        $break3_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break2_to'];
                    } else {
                        $break1_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s2_break2_from'];
                        $break1_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s2_break2_to'];
                        $break_OT_from = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break_OT_from'];
                        $break_OT_to = date('Y-m-d', strtotime($date_now)) . ' ' . $row3['s3_break_OT_to'];
                        $break2_from = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break1_from'];
                        $break2_to = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break1_to'];
                        $break3_from = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break2_from'];
                        $break3_to = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row3['s3_break2_to'];
                    }
                }
                $result3->close();

                $gt_break1_from  = strtotime($break1_from);
                $gt_break_OT_from  = strtotime($break_OT_from);
                $gt_break2_from  = strtotime($break2_from);
                $gt_break3_from  = strtotime($break3_from);

                if ($dt_start <= $break1_from) {
                    if ($dt_finish < $break1_from) {
                        $production_time += 0;
                    } else if ($dt_finish >= $break1_from && $dt_finish < $break1_to) {
                        $production_time += 0;
                    } else if ($dt_finish >= $break1_to && $dt_finish < $break_OT_from) {
                        $production_time += (((($gt_finish - $gt_start) - 3000) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break_OT_from && $dt_finish < $break_OT_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break_OT_from);
                        $production_time += ((($pure_finish - $gt_start - 3000) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break_OT_to && $dt_finish < $break2_from) {
                        $production_time += (((($gt_finish - $gt_start) - 3600) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                        $production_time += ((($pure_finish - $gt_start - 3600) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        $production_time += (((($gt_finish - $gt_start) - 6000) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += ((($pure_finish - $gt_start - 6000) - 7200) - ($gt_break1_from - $gt_start));
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (((($gt_finish - $gt_start) - 7200) - 7200) - ($gt_break1_from - $gt_start));
                    }
                } else if ($dt_start <= $break_OT_from) {
                    if ($dt_finish < $break_OT_from) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += (($gt_finish - $gt_start) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += ($gt_finish - $gt_start);
                        }
                    } else if ($dt_finish >= $break_OT_from && $dt_finish < $break_OT_to) {
                        if ($dt_start < $real_shift_time) {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break_OT_from);
                            $production_time += (($pure_finish - $gt_start) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break_OT_from);
                            $production_time += ($pure_finish - $gt_start);
                        }
                    } else if ($dt_finish >= $break_OT_to && $dt_finish < $break2_from) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 600) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 600);
                        }
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        if ($dt_start < $real_shift_time) {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                            $production_time += (($pure_finish - $gt_start - 600) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                            $production_time += ($pure_finish - $gt_start - 600);
                        }
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 3000) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 3000);
                        }
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        if ($dt_start < $real_shift_time) {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                            $production_time += (($pure_finish - $gt_start - 3000) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                            $production_time += ($pure_finish - $gt_start - 3000);
                        }
                    } else if ($dt_finish >= $break3_to) {
                        if ($dt_start < $real_shift_time) {
                            $production_time += ((($gt_finish - $gt_start) - 4200) - ($gt_real_shift_time - $gt_start));
                        } else {
                            $production_time += (($gt_finish - $gt_start) - 4200);
                        }
                    }
                } else if ($dt_start <= $break2_from) {
                    if ($dt_finish < $break2_from) {
                        $production_time += ($gt_finish - $gt_start);
                    } else if ($dt_finish >= $break2_from && $dt_finish < $break2_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break2_from);
                        $production_time += ($pure_finish - $gt_start);
                    } else if ($dt_finish >= $break2_to && $dt_finish < $break3_from) {
                        $production_time += (($gt_finish - $gt_start) - 2400);
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += ($pure_finish - $gt_start - 2400);
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (($gt_finish - $gt_start) - 3600);
                    }
                } else if ($dt_start <= $break3_from) {
                    if ($dt_finish < $break3_from) {
                        $production_time += ($gt_finish - $gt_start);
                    } else if ($dt_finish >= $break3_from && $dt_finish < $break3_to) {
                        $pure_finish = $gt_finish - ($gt_finish - $gt_break3_from);
                        $production_time += ($pure_finish - $gt_start);
                    } else if ($dt_finish >= $break3_to) {
                        $production_time += (($gt_finish - $gt_start) - 1200);
                    }
                } else if ($dt_start >= $break3_to) {
                    $production_time += ($gt_finish - $gt_start);
                }
            }

            $dt_start_compare = $dt_start;
        }
    }
    $result4->close();

    $availability = ($production_time / $available_time) * 100;
    if ($availability >= 100) {
        $availability = 100;
    }
    $performance = (($production_time - $dandory_time - $downtime) / ($production_time - $dandory_time)) * 100;
    $quality = ($quality_RH + $quality_LH) / 2;
    $oee = ($availability * $performance * $quality) / 10000;

    $query11 = "UPDATE recapitulation SET availability = $availability, performance = $performance, oee = $oee WHERE status = 'On Process' AND part_name = '$partname1' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query11);
    $query12 = "UPDATE recapitulation SET availability = $availability, performance = $performance, oee = $oee WHERE status = 'On Process' AND part_name = '$partname2' ORDER BY id ASC LIMIT 1";
    $mysqli->query($query12);

    $mysqli->close();
}
