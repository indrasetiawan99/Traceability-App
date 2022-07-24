<?php
if ($_POST['action'] == 'Write') {
    include('../connection.php');

    $query1 = "SELECT * FROM repair_qrcode WHERE cek_qrcode IS NULL";
    $result1 = $mysqli->query($query1);
    $i = 1;
    foreach ($result1 as $row1) {
        echo "<tr>";
        echo "<td class=\"align-middle text-center w50\">$i</td>";
        echo "<td class=\"align-middle\">" . $row1['qrcode'] . "</td>";
        echo "</tr>";
        $i++;
    }
    $result1->close();

    for ($n = 0; $n < 5; $n++) {
        echo "<tr>";
        echo "<td class=\"align-middle w50\">-</td>";
        echo "<td class=\"align-middle\">-</td>";
        echo "</tr>";
    }

    $mysqli->close();
}

if ($_POST['action'] == 'Read') {
    include('../connectionJSON.php');
    $partname = '-';

    $query2 = "SELECT * FROM repair_qrcode WHERE cek_qrcode IS NULL";
    $result2 = $mysqli->query($query2);
    $cek = mysqli_num_rows($result2);
    if ($cek > 0) {
        foreach ($result2 as $row2) {
            $qrcode = $row2['qrcode'];
        }

        $query3 = "SELECT * FROM part_production WHERE qrcode = '$qrcode'";
        $result3 = $mysqli->query($query3);
        foreach ($result3 as $row3) {
            $partname = $row3['part_name'];
        }
        $result3->close();
    }
    $result2->close();

    $query4 = "SELECT * FROM repair_qrcode WHERE cek_qrcode IS NULL";
    $result4 = $mysqli->query($query4);
    $cekRepairQrcode = mysqli_num_rows($result4);
    $result4->close();
    if ($cekRepairQrcode == 0) {
        $query5 = "DELETE FROM repair_qrcode";
        $mysqli->query($query5);
    }

    $data = [
        'part_name' => $partname
    ];
    $mysqli->close();
    print json_encode($data);
}
