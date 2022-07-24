<?php
session_start();
$_SESSION['data-login'] = '';
unset($_SESSION['data-login']);
session_unset();
session_destroy();

include('connection.php');
$mysqli->close();

header("Location:../main/auth_login.php");
