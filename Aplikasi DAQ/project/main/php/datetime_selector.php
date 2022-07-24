<?php
date_default_timezone_set("Asia/Jakarta");
$datetime = date("d/m/Y H:i"); // Exp: 02/03/2021 10:30
$month_name = date('F'); //Exp: March
$date = intval(substr($datetime, 0, 2));
$month = intval(substr($datetime, 3, 2));
$year = intval(substr($datetime, 6, 4));
$hour = intval(substr($datetime, 11, 2));
$minute = intval(substr($datetime, 14, 2));
$min = array();
$hr = array();
$dt = array();
$mth = array();
$yr = array();
$date_result = array();

if ($minute <= 10) {
    $minute = 10;

    for ($i = 0; $i <= 4; $i++) {
        array_push($min, $minute + (10 * $i));
    }
    array_push($min, 0);

    for ($i = 0; $i <= 4; $i++) {
        array_push($hr, $hour);
    }
    array_push($hr, $hour + 1);
} else if ($minute <= 20) {
    $minute = 20;

    for ($i = 0; $i <= 3; $i++) {
        array_push($min, $minute + (10 * $i));
    }
    for ($i = 0; $i <= 1; $i++) {
        array_push($min, 0 + (10 * $i));
    }

    for ($i = 1; $i <= 4; $i++) {
        array_push($hr, $hour);
    }
    for ($i = 1; $i <= 2; $i++) {
        array_push($hr, $hour + 1);
    }
} else if ($minute <= 30) {
    $minute = 30;

    for ($i = 0; $i <= 2; $i++) {
        array_push($min, $minute + (10 * $i));
    }
    for ($i = 0; $i <= 2; $i++) {
        array_push($min, 0 + (10 * $i));
    }

    for ($i = 1; $i <= 3; $i++) {
        array_push($hr, $hour);
    }
    for ($i = 1; $i <= 3; $i++) {
        array_push($hr, $hour + 1);
    }
} else if ($minute <= 40) {
    $minute = 40;

    for ($i = 0; $i <= 1; $i++) {
        array_push($min, $minute + (10 * $i));
    }
    for ($i = 0; $i <= 3; $i++) {
        array_push($min, 0 + (10 * $i));
    }

    for ($i = 1; $i <= 2; $i++) {
        array_push($hr, $hour);
    }
    for ($i = 1; $i <= 4; $i++) {
        array_push($hr, $hour + 1);
    }
} else if ($minute <= 50) {
    $minute = 50;

    $min = array($minute);
    for ($i = 0; $i <= 4; $i++) {
        array_push($min, 0 + (10 * $i));
    }

    array_push($hr, $hour);
    for ($i = 1; $i <= 5; $i++) {
        array_push($hr, $hour + 1);
    }
} else if ($minute <= 60) {
    $minute = 0;

    for ($i = 0; $i <= 5; $i++) {
        array_push($min, $minute + (10 * $i));
    }

    for ($i = 1; $i <= 6; $i++) {
        array_push($hr, $hour + 1);
    }
}

for ($i = 1; $i <= 6; $i++) {
    array_push($dt, $date);
    array_push($mth, $month);
    array_push($yr, $year);
}

for ($i = 0; $i <= 5; $i++) {
    if ($hr[$i] >= 24) {
        $hr[$i] -= 24;
        $dt[$i] += 1;
        if ($month_name == 'January' || $month_name == 'March' || $month_name == 'May' || $month_name = 'July' || $month_name = 'August' || $month_name = 'October' || $month_name = 'December') {
            if ($dt[$i] > 31) {
                $dt[$i] -= 31;
                $mth[$i] += 1;
            }
        }
        if ($month_name == 'February') {
            $kabisat = fmod($year, 4);
            if ($kabisat == 0) {
                if ($dt[$i] > 29) {
                    $dt[$i] -= 29;
                    $mth[$i] += 1;
                }
            } else {
                if ($dt[$i] > 28) {
                    $dt[$i] -= 28;
                    $mth[$i] += 1;
                }
            }
        }
        if ($month_name == 'April' || $month_name == 'June' || $month_name == 'September' || $month_name == 'November') {
            if ($dt[$i] > 30) {
                $dt[$i] -= 30;
                $mth[$i] += 1;
            }
        }
        if ($mth[$i] > 12) {
            $mth[$i] -= 12;
            $yr[$i] += 1;
        }
    }
}

for ($i = 0; $i <= 5; $i++) {
    array_push($date_result, str_pad($dt[$i], 2, "0", STR_PAD_LEFT) . '/' . str_pad($mth[$i], 2, "0", STR_PAD_LEFT) . '/' . $yr[$i]);
}
