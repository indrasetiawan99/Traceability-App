<?php
if (!empty($_POST['Mode'])) {
    include('../connection.php');
    $mode = $_POST['Mode'];
    $query = "UPDATE scanner_mode SET mode = '$mode'";
    $mysqli->query($query);
    $mysqli->close();
}
