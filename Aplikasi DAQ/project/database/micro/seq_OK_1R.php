<?php
if (isset($_GET['seq1-status'])) {
    $seq1Status  = $_GET['seq1-status'];
    $position = 'Right';
    // $seq1Status  = 'OK';
    include('../connection.php');

    //Read temp_production for qrName and nik
    $query1 = "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result1 = $mysqli->query($query1);
    $loadSeq1 = mysqli_num_rows($result1);

    foreach ($result1 as $row) {
        $qrName = $row['qrname'];
        $nik = $row['nik'];
    }
    $result1->close();

    //Read part data to get part name
    $query2 = "SELECT * FROM master_product WHERE qrname = '$qrName'";
    $result2 = $mysqli->query($query2);

    foreach ($result2 as $row) {
        $partName = $row['part_name'];
    }
    $result2->close();

    //Read user data to get operator name
    $query3 = "SELECT * FROM master_user WHERE nik = '$nik'";
    $result3 = $mysqli->query($query3);

    foreach ($result3 as $row) {
        $opName = $row['full_name'];
    }
    $result3->close();

    if ($loadSeq1 > 0) {
        $query4 = "INSERT INTO part_production (part_name, position, op_name, seq1_status) VALUES ('$partName', '$position', '$opName', '$seq1Status')";
        $mysqli->query($query4);
    }

    $mysqli->close();
    header("Location: http://192.168.137.1:8081/project/tester/input.php");
}
