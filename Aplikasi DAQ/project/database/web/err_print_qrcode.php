<?php
if ($_POST['err-print-qrcode'] == 'Read') {
    include('../connection.php');

    $query1 = "SELECT * FROM part_production WHERE seq4_status IS NULL ORDER BY id DESC";
    $result1 = $mysqli->query($query1);
    $i = 1;
    foreach ($result1 as $row) {
        $part_name = $row['part_name'];
        $date_time = $row['date_time'];
        $qrcode = $row['qrcode'];

        echo "<tr>";
        echo "<td scope=\"row\" class=\"align-middle\"> $i </td>";
        echo "<td class=\"align-middle\"> $part_name </td>";
        echo "<td class=\"align-middle\"> $date_time </td>";
        echo "<td>";
        echo "<a href=\"http://10.14.134.44/project/database/web/error_print_qrcode.php?err-print-qrcode=$qrcode&part-name=$part_name\">";
        echo "<button type=\"button\" class=\"btn btn-success btn-block\">Print</button>";
        echo "</a>";
        echo "</td>";
        echo "</tr>";
        $i++;
    }
    $result1->close();

    $mysqli->close();
}
