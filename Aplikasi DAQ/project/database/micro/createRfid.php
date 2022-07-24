<?php
if (isset($_GET['rfidTag'])) {
    include('../connection.php');
    $rfidTag  = $_GET['rfidTag'];

    $query1 = "SELECT * FROM master_user WHERE rfid_tag = '$rfidTag'";

    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        $nik = $row["nik"];
        $name = $row["nospace_name"];
    }
    $result1->close();

    $query2 = "DELETE FROM temp_rfid_data";
    $mysqli->query($query2);

    $query3 = "ALTER TABLE temp_rfid_data AUTO_INCREMENT = 0";
    $mysqli->query($query3);

    $query4 = "INSERT INTO temp_rfid_data (nik, op_name) VALUES ('$nik', '$name')";
    $mysqli->query($query4);

    $query5 = "SELECT * FROM machine_status WHERE action = 'Yes'";
    $result5 = $mysqli->query($query5);
    foreach ($result5 as $row) {
        $machineStatus = $row['status'];
    }
    $cekMachineStatus = mysqli_num_rows($result5);
    $result5->close();

    if ($cekMachineStatus > 0) {
        if ($machineStatus == 0) {
            $valMachine = 1;
        } else if ($machineStatus == 1) {
            $valMachine = 0;
        }
        $query6 = "UPDATE machine_status SET status = '$valMachine'";
        $mysqli->query($query6);
    }

    $mysqli->close();
}
