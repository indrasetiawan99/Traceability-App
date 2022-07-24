<?php
if (isset($_GET['seq4-status'])) {
    include('../connection.php');
    $position = 'Left';

    $query1 = "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = '$position'";
    $result1 = $mysqli->query($query1);
    $loadCurrentPart = mysqli_num_rows($result1);
    foreach ($result1 as $row) {
        $partName = $row['part_name'];
    }
    $result1->close();

    if ($loadCurrentPart > 0) {
        $query2 = "SELECT * FROM master_product WHERE part_name = '$partName'";
        $result2 = $mysqli->query($query2);

        foreach ($result2 as $row) {
            $pnApi = $row['pn_api'];
            $pnCust = $row['pn_cust'];
        }
        $result2->close();

        $query4 = "SELECT * FROM part_production WHERE part_name = '$partName' AND position = 'Left' AND seq3_status = 'OK' AND qrcode IS NOT NULL AND status = 'waiting'";
        $result4 = $mysqli->query($query4);
        $counting_L = mysqli_num_rows($result4);
        $result4->close();

        if ($counting_L > 0) {
            $query10 = "SELECT * FROM remaining_part WHERE part_name = '$partName'";
            $result10 = $mysqli->query($query10);
            $cek_part = mysqli_num_rows($result10);
            $result10->close();

            if ($cek_part > 0) {
                date_default_timezone_set("Asia/Jakarta");
                $datetime = date("Y-m-d H:i:s");
                $query5 = "UPDATE remaining_part SET qty = qty + $counting_L, date_time = '$datetime' WHERE part_name = '$partName'";
                $mysqli->query($query5);
            } else {
                $query5 = "INSERT INTO remaining_part (part_name, pn_api, pn_cust, qty) VALUES ('$partName','$pnApi', '$pnCust', '$counting_L')";
                $mysqli->query($query5);
            }

            $query6 = "UPDATE temp_counting_seq4 SET counting_L = 0";
            $mysqli->query($query6);

            $query7 = "UPDATE part_production SET status = 'pending' WHERE part_name = '$partName' AND datapart IS NULL AND status = 'waiting'";
            $mysqli->query($query7);

            $query11 = "INSERT temp_datapart_wip (part_name) VALUES ('$partName')";
            $mysqli->query($query11);
        }
        $query12 = "DELETE FROM part_production WHERE status IS NULL";
        $mysqli->query($query12);

        $query9 = "UPDATE setup_production SET status = 'Finish' WHERE part_name = '$partName' AND status = 'On Process'";
        $mysqli->query($query9);

        $query9 = "UPDATE recapitulation SET status = 'Finish' WHERE part_name = '$partName' AND status = 'On Process'";
        $mysqli->query($query9);

        $query3 = "DELETE FROM temp_production WHERE seq_status = 'Active' AND position = '$position' ORDER BY id ASC LIMIT 1";
        $mysqli->query($query3);

        $query0 = "SELECT * FROM temp_production WHERE seq_status = 'Active'";
        $result0 = $mysqli->query($query0);
        $loadCurrent = mysqli_num_rows($result0);
        $result0->close();
        if ($loadCurrent == 0) {
            $query8 = "ALTER TABLE temp_production AUTO_INCREMENT = 0";
            $mysqli->query($query8);
        }

        $mysqli->close();
        header('location:../../main/operator.php');
    } else {
        $mysqli->close();
        header('location:../../main/operator.php');
    }
}
