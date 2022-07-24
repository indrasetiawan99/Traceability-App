<?php
session_start();
$_SESSION['data-login'] = '';
unset($_SESSION['data-login']);
session_unset();
session_destroy();

include('../connection.php');
$query = "DELETE FROM temp_rfid_data";
$mysqli->query($query);
$mysqli->close();

header("Location:../../main/login.php");
