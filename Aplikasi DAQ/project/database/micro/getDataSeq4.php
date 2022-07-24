<?php
if ($_GET['sequence4'] == 'Left') {
    include('../connection.php');
    $query1 = "SELECT * FROM seq4_status";

    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        $seq4_L = $row["status_L"];
    }
    $result1->close();

    echo $seq4_L;
    $mysqli->close();
}
if ($_GET['sequence4'] == 'Left_Off') {
    include('../connection.php');
    $query2 = "UPDATE seq4_status SET status_L = '0'";
    $mysqli->query($query2);

    $mysqli->close();
}
if ($_GET['sequence4'] == 'Right') {
    include('../connection.php');
    $query3 = "SELECT * FROM seq4_status";

    $result3 = $mysqli->query($query3);
    foreach ($result3 as $row3) {
        $seq4_R = $row3["status_R"];
    }
    $result3->close();

    echo $seq4_R;
    $mysqli->close();
}
if ($_GET['sequence4'] == 'Right_Off') {
    include('../connection.php');
    $query4 = "UPDATE seq4_status SET status_R = '0'";
    $mysqli->query($query4);

    $mysqli->close();
}
