<?php
if ($_POST['badge-remaining-part'] == 'Read') {
    include('../connectionJSON.php');

    $query1 = "SELECT * FROM remaining_part";
    $result1 = $mysqli->query($query1);
    $val_badge = mysqli_num_rows($result1);
    $result1->close();
    $mysqli->close();

    $data = [
        'badge_remaining_part' => $val_badge
    ];

    print json_encode($data);
}
