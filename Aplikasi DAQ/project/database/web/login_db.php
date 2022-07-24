<?php
// koneksi database
include('../connectionJSON.php');

// mengambil isian dari form login
$username = $_GET['username'];
$password = $_GET['password'];

$errUsername = 'yes';
$errPassword = 'yes';
$usergroup = 'Operator';

$query1 = "SELECT * FROM master_user WHERE username = '$username'";
$result1 = $mysqli->query($query1);
$cekUser = mysqli_num_rows($result1);

if ($cekUser != 0) {
    $errUsername = 'no';

    $query2 = "SELECT * FROM master_user WHERE username = '$username' AND password = '$password'";
    $result2 = $mysqli->query($query2);
    $cekPass = mysqli_num_rows($result2);

    if ($cekPass != 0) {
        $errPassword = 'no';

        foreach ($result2 as $row) {
            $usergroup = $row['usergroup'];
            $fullName = $row['full_name'];
        }
        $result2->close();

        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $fullName;
        $_SESSION['data-login'] = $username . "_" . $password;
        $_SESSION['usergroup'] = $usergroup;

        date_default_timezone_set("Asia/Jakarta");
        $datetime = date("Y-m-d H:i:s");
        $query3 = "UPDATE master_user SET last_login = '$datetime' WHERE username = '$username' AND password = '$password'";
        $mysqli->query($query3);
    }
}

$data = [
    'errUsername' => $errUsername,
    'errPassword' => $errPassword,
    'usergroup' => $usergroup
];

$result1->close();
$mysqli->close();

print json_encode($data);
