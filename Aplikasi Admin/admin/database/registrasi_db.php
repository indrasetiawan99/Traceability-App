<?php
if (isset($_POST['cek-user'])) {
    include('./connectionJSON.php');
    $cek_npk = $_POST['cek-user'];
    $data_a = [];
    $err_user = 'Yes';

    $query1 = "SELECT * FROM master_user WHERE nik = '$cek_npk'";
    $result1 = $mysqli->query($query1);
    $cek_user = mysqli_num_rows($result1);
    $result1->close();
    if ($cek_user < 1) {
        $err_user = 'No';
    }

    $data_a = [
        'err_user' => $err_user
    ];
    $mysqli->close();
    print json_encode($data_a);
}

if (isset($_POST['npk'])) {
    include('./connection.php');
    $npk = $_POST['npk'];
    $full_name = $_POST['full-name'];
    $short_name = $_POST['short-name'];
    $user_group = $_POST['user-group'];
    $op_skill = $_POST['op-skill'];
    $user_name = $_POST['user-name'];
    $password = $_POST['password'];
    $nospace_name = nospace_str($full_name, '_');
    $rfid_tag = $_POST['rfid-tag'];

    $query2 = "INSERT INTO master_user (nik, username, password, rfid_tag, name, full_name, nospace_name, usergroup, op_skill) VALUES ('$npk', '$user_name', '$password', '$rfid_tag', '$short_name', '$full_name', '$nospace_name', '$user_group', '$op_skill')";
    $mysqli->query($query2);

    $mysqli->close();
}

function nospace_str($string, $separator)
{
    $temp_string = $string . ' ';
    $result = '';
    for ($i = 0; $i < 10; $i++) {
        $index_string = strpos($temp_string, ' ');
        if ($index_string != false) {
            if ($result == '') {
                $result .= substr($temp_string, 0, $index_string);
            } else {
                $result .= $separator . substr($temp_string, 0, $index_string);
            }
            $temp_string = substr($temp_string, $index_string + 1);
        } else {
            break;
        }
    }

    return $result;
}
