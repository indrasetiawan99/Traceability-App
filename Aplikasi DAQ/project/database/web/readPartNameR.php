<?php
include('../connection.php');

$query1 = "SELECT DISTINCT part_name FROM master_product WHERE position = 'Right'";
$result = $mysqli->query($query1);

if ($result->num_rows > 0) {
	// output data of each row
	while ($row = $result->fetch_assoc()) {
		echo "<option value='" . $row["part_name"] . "'>" . $row["part_name"] . "</option>";
	}
} else {
	echo "Tidak Ada Data";
}
$result->close();
$mysqli->close();
