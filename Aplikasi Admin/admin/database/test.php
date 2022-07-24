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

$data_type = [
    1 => 'bool',
    3 => 'int',
    4 => 'float',
    5 => 'double',
    7 => 'timestamp',
    8 => 'bigint',
    9 => 'mediumint',
    10 => 'date',
    11 => 'time',
    12 => 'datetime',
    13 => 'year',
    16 => 'bit',
    252 => 'text',
    253 => 'varchar',
    254 => 'char',
    256 => 'decimal'
];

$data_type_column = array();

$query = "SELECT * FROM master_user";
if ($result = $mysqli->query($query)) {
    // Get field information for all columns
    while ($column_info = $result->fetch_field()) {
        array_push($data_type_column, $data_type[$column_info->type]);
        // echo $data_type[$column_info->type] . '<br>';
    }
    var_dump($data_type_column);
}

$result->close();
$mysqli->close();
