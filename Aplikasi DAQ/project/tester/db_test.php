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

$query5 = "SELECT * FROM uniq_code";
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
    $query6 = "UPDATE uniq_code SET cycle = 1, date = '$date_now'";
    $mysqli->query($query6);
}

$id = sprintf("%04d", $cycle);
$uniq_number = substr(date('Y'), 2) . date('m') . $id;

echo 'Year month last: ' . $year_month_last . '<br>';
echo 'Year month now: ' . $year_month_now . '<br>';
echo 'Cycle : ' . $cycle . '<br>';
echo 'Date now : ' . $date_now . '<br>';
echo 'Uniq Number : ' . $uniq_number . '<br>';
