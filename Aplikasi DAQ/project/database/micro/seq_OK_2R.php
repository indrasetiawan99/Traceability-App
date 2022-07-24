<?php
if (isset($_GET['seq2-status'])) {
    $seq2Status  = $_GET['seq2-status'];
    $position = 'Right';
    // $seq2Status  = 'OK';

    include('../connection.php');

    //Read temp_production for qrName and nik
    $query1 = "SELECT * FROM temp_production 
                    WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result1 = $mysqli->query($query1);

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

    $query4 = "SELECT * FROM part_production 
                    WHERE seq1_status = 'OK' AND seq2_status is NULL AND part_name = '$partName' 
                        AND op_name = '$opName' AND position = '$position'";
    $result4 = $mysqli->query($query4);
    $loadSeq2 = mysqli_num_rows($result4);
    $result4->close();

    if ($loadSeq2 > 0) {
        $query5 = "UPDATE part_production SET seq2_status='$seq2Status' 
                        WHERE seq1_status = 'OK' AND seq2_status is NULL AND part_name = '$partName' 
                        AND op_name = '$opName' AND position = '$position' ORDER BY id ASC LIMIT 1";
        $mysqli->query($query5);
    }

    $mysqli->close();
    header("Location: http://192.168.137.1:8081/project/tester/input.php");
}
