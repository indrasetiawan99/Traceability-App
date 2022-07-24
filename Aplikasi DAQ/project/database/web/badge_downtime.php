<?php
if ($_POST['badge_downtime'] == 'Read') {
    include('../connectionJSON.php');

    $query1 = "SELECT * FROM downtime WHERE start_downtime IS NOT NULL AND end_downtime IS NULL";
    $result1 = $mysqli->query($query1);
    $val_badge = mysqli_num_rows($result1);
    $result1->close();
    $mysqli->close();

    $data = [
        'badge_downtime' => $val_badge
    ];

    print json_encode($data);
}

if ($_POST['badge_downtime'] == 'Write') {
    include('../connection.php');

    date_default_timezone_set("Asia/Jakarta");
    $datetime_now = date("Y-m-d H:i:s");
    $date_now = substr($datetime_now, 0, 10);
    $date_setup_shift_min = date('Y-m-d H:i:s', strtotime($date_now . ' 00:00:00'));
    $date_setup_shift_max = date('Y-m-d H:i:s', strtotime($date_now . ' 05:59:59'));

    // Search shift 1 time
    $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 1'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift1_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
            $shift1_end = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['end_time'];
        } else {
            $shift1_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
            $shift1_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
        }
    }
    $result1->close();

    // Search shift 3 time
    $query1 = "SELECT * FROM master_shift WHERE status = 'Active' AND shift_name = 'Shift 3'";
    $result1 = $mysqli->query($query1);
    foreach ($result1 as $row) {
        if ($datetime_now >= $date_setup_shift_min && $datetime_now <= $date_setup_shift_max) {
            $shift3_start = date('Y-m-d', strtotime('-1 days', strtotime($date_now))) . ' ' . $row['start_time'];
            $shift3_end = date('Y-m-d', strtotime($date_now)) . ' ' . $row['end_time'];
        } else {
            $shift3_start = date('Y-m-d', strtotime($date_now)) . ' ' . $row['start_time'];
            $shift3_end = date('Y-m-d', strtotime('+1 days', strtotime($date_now))) . ' ' . $row['end_time'];
        }
    }
    $result1->close();

    if ($datetime_now >= $shift1_start && $datetime_now <= $shift1_end) {
        $shift_start = $shift1_start;
        $shift_end = $shift1_end;
    } else if ($datetime_now >= $shift3_start && $datetime_now <= $shift3_end) {
        $shift_start = $shift3_start;
        $shift_end = $shift3_end;
    }

    $query2 = "SELECT * FROM downtime WHERE start_downtime IS NOT NULL AND end_downtime IS NULL ORDER BY id DESC";
    $result2 = $mysqli->query($query2);
    $i = 1;
    foreach ($result2 as $row2) {
        $mode = "";
        $id = $row2['id'];
        $user = $row2['user_start'];
        $desc = $row2['description'];
        $category = $row2['category'];
        $start_downtime = $row2['start_downtime'];

        $query3 = "SELECT * FROM master_user WHERE nik = '$user'";
        $result3 = $mysqli->query($query3);
        foreach ($result3 as $row3) {
            $name = $row3['nospace_name'];
            $full_name = $row3['full_name'];
        }
        $result3->close();

        $query3 = "SELECT * FROM master_downtime WHERE category = '$category'";
        $result3 = $mysqli->query($query3);
        $cek_category = mysqli_num_rows($result3);
        if ($cek_category > 0) {
            $mode = 'Select';
        } else {
            $mode = 'Input';
        }

        if ($start_downtime >= $shift_start && $start_downtime <= $shift_end) {
            echo '<tr>';
            echo "<td scope='row' class='align-middle text-center'> $i </td>";
            echo "<td class='align-middle text-center'> $category ";
            echo '<button type="button" class="btn btn-warning ml-2" data-toggle="modal" data-target="#edit-start-downtime" onclick="Edit_Start_Downtime(\'' . $user . '_' . $name . '\', \'' . $category . '\', \'' . $id . '\', \'' . $desc . '\', \'' . $mode . '\')">';
            echo "<img src=\"../assets/img/input.png\" width=\"30\"></button>";
            echo '</td>';
            echo "<td class='align-middle text-center'> $desc </td>";
            echo "<td class='align-middle text-center'> $start_downtime </td>";
            echo "<td class='align-middle text-center'> $full_name </td>";
            echo "<td class='align-middle text-center'>";
            echo '<button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#input-finish-downtime" onclick="Input_Finish_Downtime(\'' . $id . '\')">';
            echo "<img src=\"../assets/img/input.png\" width=\"30\"></button>";
            echo '</td>';
            echo "<td class='align-middle text-center'></td>";
            echo "<td class='align-middle text-center'></td>";
            echo '</tr>';
            $i++;
        }
    }
    $result2->close();

    $query2 = "SELECT * FROM downtime WHERE start_downtime IS NOT NULL AND end_downtime IS NOT NULL ORDER BY id DESC";
    $result2 = $mysqli->query($query2);
    $i = 1;
    foreach ($result2 as $row2) {
        $mode = "";
        $id = $row2['id'];
        $user = $row2['user_start'];
        $desc = $row2['description'];
        $category = $row2['category'];
        $user_end = $row2['user_end'];
        $end_downtime = $row2['end_downtime'];
        $start_downtime = $row2['start_downtime'];
        $total_time = round($row2['total_time'] / 60);
        // $total_time = $row2['total_time'];

        $query3 = "SELECT * FROM master_user WHERE nik = '$user'";
        $result3 = $mysqli->query($query3);
        foreach ($result3 as $row3) {
            $name = $row3['nospace_name'];
            $full_name = $row3['full_name'];
        }
        $result3->close();

        $query3 = "SELECT * FROM master_user WHERE nik = '$user_end'";
        $result3 = $mysqli->query($query3);
        foreach ($result3 as $row3) {
            $name_end = $row3['nospace_name'];
            $full_name_end = $row3['full_name'];
        }
        $result3->close();

        $query3 = "SELECT * FROM master_downtime WHERE category = '$category'";
        $result3 = $mysqli->query($query3);
        $cek_category = mysqli_num_rows($result3);
        if ($cek_category > 0) {
            $mode = 'Select';
        } else {
            $mode = 'Input';
        }

        if ($start_downtime >= $shift_start && $start_downtime <= $shift_end) {
            echo '<tr>';
            echo "<td scope='row' class='align-middle text-center'> $i </td>";
            echo "<td class='align-middle text-center'> $category ";
            echo '<button type="button" class="btn btn-warning ml-2" data-toggle="modal" data-target="#edit-start-downtime" onclick="Edit_Start_Downtime(\'' . $user . '_' . $name . '\', \'' . $category . '\', \'' . $id . '\', \'' . $desc . '\', \'' . $mode . '\')">';
            echo "<img src=\"../assets/img/input.png\" width=\"30\"></button>";
            echo '</td>';
            echo "<td class='align-middle text-center'> $desc </td>";
            echo "<td class='align-middle text-center'> $start_downtime </td>";
            echo "<td class='align-middle text-center'> $full_name </td>";
            echo "<td class='align-middle text-center'> $end_downtime </td>";
            echo "<td class='align-middle text-center'> $full_name_end </td>";
            echo "<td class='align-middle text-center'> $total_time '</td>";
            echo '</tr>';
            $i++;
        }
    }
    $result2->close();

    $mysqli->close();
}
