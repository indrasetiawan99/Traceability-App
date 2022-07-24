<?php
if ($_POST['action'] == 'input-R') {
    include('../connectionJSON.php');

    $partname = $_POST['part-name'];
    $category = $_POST['category'];
    $mode = $_POST['mode'];
    $position = 'Right';
    $status = 'reject';
    $seq4Status  = 'NG';
    $err_load = 'Yes';

    //Read temp_production for part_name and nik
    $query1 = "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result1 = $mysqli->query($query1);

    foreach ($result1 as $row) {
        $partName = $row['part_name'];
        $nik = $row['nik'];
    }
    $result1->close();

    //Read master_user to get operator name
    $query3 = "SELECT * FROM master_user WHERE nik = '$nik'";
    $result3 = $mysqli->query($query3);

    foreach ($result3 as $row) {
        $opName = $row['full_name'];
    }
    $result3->close();

    $query4 = "SELECT * FROM part_production 
                    WHERE seq1_status = 'OK' AND seq2_status = 'OK' AND seq3_status = 'OK' 
                        AND seq4_status is NULL AND part_name = '$partName' AND op_name = '$opName' 
                        AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result4 = $mysqli->query($query4);
    $loadSeq4 = mysqli_num_rows($result4);
    foreach ($result4 as $row) {
        $qrcode = $row['qrcode'];
    }
    $result4->close();

    if ($loadSeq4 > 0) {
        $err_load = 'No';
        $query5 = "UPDATE part_production SET seq4_status='$seq4Status', status='$status' 
                        WHERE seq1_status = 'OK'  AND seq2_status = 'OK' AND seq3_status = 'OK' 
                            AND seq4_status is NULL AND part_name = '$partName' AND op_name = '$opName' 
                            AND position = '$position' ORDER BY id ASC LIMIT 1";
        $mysqli->query($query5);

        if ($mode == 'select') {
            $data_select = json_decode(stripslashes($category));
            $ng_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting');

            for ($i = 0; $i < count($data_select); $i++) {
                $search = array_search($data_select[$i], $ng_category);

                // Initial insert data
                if ($i == 0) {
                    $query6 = "INSERT INTO rejection(part_name, qrcode) VALUES ('$partName', '$qrcode')";
                    $mysqli->query($query6);
                }
                if (is_int($search) == true) {
                    if ($search == 0) {
                        $query6 = "UPDATE rejection SET crack = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 1) {
                        $query6 = "UPDATE rejection SET dimensi = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 2) {
                        $query6 = "UPDATE rejection SET ejector_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 3) {
                        $query6 = "UPDATE rejection SET short_shoot = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 4) {
                        $query6 = "UPDATE rejection SET wide_line = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 5) {
                        $query6 = "UPDATE rejection SET kontaminasi = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 6) {
                        $query6 = "UPDATE rejection SET buble = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 7) {
                        $query6 = "UPDATE rejection SET flow_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 8) {
                        $query6 = "UPDATE rejection SET bending = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 9) {
                        $query6 = "UPDATE rejection SET sink_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 10) {
                        $query6 = "UPDATE rejection SET burn_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 11) {
                        $query6 = "UPDATE rejection SET scratch = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 12) {
                        $query6 = "UPDATE rejection SET silver = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 13) {
                        $query6 = "UPDATE rejection SET blackspot = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 14) {
                        $query6 = "UPDATE rejection SET gloss = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 15) {
                        $query6 = "UPDATE rejection SET mutih = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 16) {
                        $query6 = "UPDATE rejection SET minyak = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 17) {
                        $query6 = "UPDATE rejection SET jetting = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 18) {
                        $query6 = "UPDATE rejection SET over_cut = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 19) {
                        $query6 = "UPDATE rejection SET burry = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 20) {
                        $query6 = "UPDATE rejection SET check_of = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 21) {
                        $query6 = "UPDATE rejection SET colour = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 22) {
                        $query6 = "UPDATE rejection SET setting = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    }
                }
            }
        } else {
            $query6 = "INSERT INTO rejection(part_name, qrcode, lain_lain) VALUES ('$partName', '$qrcode', '$category')";
            $mysqli->query($query6);
        }
    }

    $mysqli->close();
    $data = [
        'err_load' => $err_load
    ];
    print json_encode($data);
} else if ($_POST['action'] == 'input-L') {
    include('../connectionJSON.php');

    $partname = $_POST['part-name'];
    $category = $_POST['category'];
    $mode = $_POST['mode'];
    $position = 'Left';
    $status = 'reject';
    $seq4Status  = 'NG';
    $err_load = 'Yes';

    //Read temp_production for part_name and nik
    $query1 = "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result1 = $mysqli->query($query1);

    foreach ($result1 as $row) {
        $partName = $row['part_name'];
        $nik = $row['nik'];
    }
    $result1->close();

    //Read master_user to get operator name
    $query3 = "SELECT * FROM master_user WHERE nik = '$nik'";
    $result3 = $mysqli->query($query3);

    foreach ($result3 as $row) {
        $opName = $row['full_name'];
    }
    $result3->close();

    $query4 = "SELECT * FROM part_production 
                    WHERE seq1_status = 'OK' AND seq2_status = 'OK' AND seq3_status = 'OK' 
                        AND seq4_status is NULL AND part_name = '$partName' AND op_name = '$opName' 
                        AND position = '$position' ORDER BY id ASC LIMIT 1";
    $result4 = $mysqli->query($query4);
    $loadSeq4 = mysqli_num_rows($result4);
    foreach ($result4 as $row) {
        $qrcode = $row['qrcode'];
    }
    $result4->close();

    if ($loadSeq4 > 0) {
        $err_load = 'No';
        $query5 = "UPDATE part_production SET seq4_status='$seq4Status', status='$status' 
                        WHERE seq1_status = 'OK'  AND seq2_status = 'OK' AND seq3_status = 'OK' 
                            AND seq4_status is NULL AND part_name = '$partName' AND op_name = '$opName' 
                            AND position = '$position' ORDER BY id ASC LIMIT 1";
        $mysqli->query($query5);

        if ($mode == 'select') {
            $data_select = json_decode(stripslashes($category));
            $ng_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting');

            for ($i = 0; $i < count($data_select); $i++) {
                $search = array_search($data_select[$i], $ng_category);

                // Initial insert data
                if ($i == 0) {
                    $query6 = "INSERT INTO rejection(part_name, qrcode) VALUES ('$partName', '$qrcode')";
                    $mysqli->query($query6);
                }
                if (is_int($search) == true) {
                    if ($search == 0) {
                        $query6 = "UPDATE rejection SET crack = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 1) {
                        $query6 = "UPDATE rejection SET dimensi = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 2) {
                        $query6 = "UPDATE rejection SET ejector_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 3) {
                        $query6 = "UPDATE rejection SET short_shoot = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 4) {
                        $query6 = "UPDATE rejection SET wide_line = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 5) {
                        $query6 = "UPDATE rejection SET kontaminasi = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 6) {
                        $query6 = "UPDATE rejection SET buble = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 7) {
                        $query6 = "UPDATE rejection SET flow_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 8) {
                        $query6 = "UPDATE rejection SET bending = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 9) {
                        $query6 = "UPDATE rejection SET sink_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 10) {
                        $query6 = "UPDATE rejection SET burn_mark = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 11) {
                        $query6 = "UPDATE rejection SET scratch = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 12) {
                        $query6 = "UPDATE rejection SET silver = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 13) {
                        $query6 = "UPDATE rejection SET blackspot = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 14) {
                        $query6 = "UPDATE rejection SET gloss = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 15) {
                        $query6 = "UPDATE rejection SET mutih = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 16) {
                        $query6 = "UPDATE rejection SET minyak = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 17) {
                        $query6 = "UPDATE rejection SET jetting = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 18) {
                        $query6 = "UPDATE rejection SET over_cut = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 19) {
                        $query6 = "UPDATE rejection SET burry = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 20) {
                        $query6 = "UPDATE rejection SET check_of = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 21) {
                        $query6 = "UPDATE rejection SET colour = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    } else if ($search == 22) {
                        $query6 = "UPDATE rejection SET setting = 'Yes' WHERE qrcode = '$qrcode'";
                        $mysqli->query($query6);
                    }
                }
            }
        } else {
            $query6 = "INSERT INTO rejection(part_name, qrcode, lain_lain) VALUES ('$partName', '$qrcode', '$category')";
            $mysqli->query($query6);
        }
    }

    $mysqli->close();
    $data = [
        'err_load' => $err_load
    ];
    print json_encode($data);
}
