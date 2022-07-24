<?php
if (isset($_POST['get-part-name'])) {
    include('../connection.php');

    $partName = $_POST['get-part-name'];

    $query1 = "SELECT * FROM remaining_part WHERE part_name = '$partName'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        $qty = $row['qty'];
    }
    $result1->close();

    $query2 = "SELECT * FROM master_product WHERE part_name = '$partName'";
    $result2 = $mysqli->query($query2);
    foreach ($result2 as $row) {
        $position = $row['position'];
    }
    $result2->close();

    $query3 = "DELETE FROM remaining_part WHERE part_name = '$partName'";
    $mysqli->query($query3);

    for ($i = 0; $i < $qty; $i++) {
        $query4 = "UPDATE part_production SET status = 'waiting' WHERE part_name = '$partName' AND datapart IS NULL AND status = 'pending' ORDER BY id ASC LIMIT 1";
        $mysqli->query($query4);
    }

    if ($position == 'Right') {
        $query5 = "UPDATE temp_counting_seq4 SET counting_R = counting_R + $qty";
        $mysqli->query($query5);
    } else if ($position == 'Left') {
        $query6 = "UPDATE temp_counting_seq4 SET counting_L = counting_L + $qty";
        $mysqli->query($query6);
    }

    $mysqli->close();
    header('Location:../../main/operator.php');
}
