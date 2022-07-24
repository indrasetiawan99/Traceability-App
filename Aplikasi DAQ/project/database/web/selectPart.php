<?php
// koneksi database
include('../connection.php');

$query1 = "SELECT * FROM master_product";
$result1 = $mysqli->query($query1);

while ($row = $result1->fetch_assoc()) {
    echo "<option value='" . $row["part_name"] . "'>" . $row["part_name"] . "</option>";
}

$result1->close();
$mysqli->close();
