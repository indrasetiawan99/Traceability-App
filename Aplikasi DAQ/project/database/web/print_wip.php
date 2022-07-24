<?php
include('../connectionJSON.php');

if ($_POST['action'] == 'Read') {
    $query1 = "SELECT * FROM temp_datapart_wip";
    $result1 = $mysqli->query($query1);
    $cekData = mysqli_num_rows($result1);

    if ($cekData > 0) {
        foreach ($result1 as $row) {
            $part_name = $row['part_name'];
        }

        $data = [
            'part_name' => $part_name,
            'status' => "active"
        ];
    } else {
        $data = [
            'part_name' => "",
            'status' => "inactive"
        ];
    }

    $result1->close();
    print json_encode($data);
} else if ($_POST['action'] == 'Delete') {
    $part_name = $_POST['part-name'];
    $query2 = "DELETE FROM temp_datapart_wip WHERE part_name = '$part_name'";
    $mysqli->query($query2);
}
$mysqli->close();
