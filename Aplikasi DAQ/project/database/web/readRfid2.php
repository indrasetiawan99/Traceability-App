<?php
include('../connectionJSON.php');

if ($_POST['action'] == 'read') {
	$query1 = "SELECT * FROM temp_rfid_data";
	$result = $mysqli->query($query1);
	$dataRfid = "-";
	foreach ($result as $row) {
		$nik = $row['nik'];
		$opName = $row['op_name'];
		$dataRfid = $nik . '-' . $opName;
	}

	if ($dataRfid == '-') {
		$dataRfid = "";
	}

	$data = [
		'dataRfid' => $dataRfid
	];

	$result->close();
	$mysqli->close();

	print json_encode($data);
}

if ($_POST['action'] == 'delete') {
	$query1 = "DELETE FROM temp_rfid_data";
	$mysqli->query($query1);

	$mysqli->close();
}
