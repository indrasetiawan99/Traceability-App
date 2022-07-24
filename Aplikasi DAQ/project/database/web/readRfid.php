<?php
include('../connectionJSON.php');

if ($_POST['action'] == 'read') {
	$query1 = "SELECT * FROM temp_rfid_data";
	$result1 = $mysqli->query($query1);

	$nik = "";
	foreach ($result1 as $row) {
		$nik = $row['nik'];
	}

	$query2 = "SELECT * FROM master_user WHERE nik = '$nik'";
	$result2 = $mysqli->query($query2);

	$password = "";
	foreach ($result2 as $row) {
		$username = $row['username'];
		$password = $row['password'];
	}

	$data = [
		'username' => $username,
		'password' => $password
	];
	$result1->close();
	$result2->close();
	$mysqli->close();

	print json_encode($data);
}

if ($_POST['action'] == 'delete') {
	$query1 = "DELETE FROM temp_rfid_data";
	$mysqli->query($query1);

	$mysqli->close();
}
