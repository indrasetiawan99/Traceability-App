<?php
if (isset($_POST['username'])) {
    include('connectionJSON.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $err_username = 'yes';
    $err_password = 'yes';

    $query1 = "SELECT * FROM master_user WHERE username = '$username'";
    $result1 = $mysqli->query($query1);
    $cek_user = mysqli_num_rows($result1);

    if ($cek_user != 0) {
        $err_username = 'no';

        $query2 = "SELECT * FROM master_user WHERE username = '$username' AND password = '$password'";
        $result2 = $mysqli->query($query2);
        $cek_pass = mysqli_num_rows($result2);

        if ($cek_pass != 0) {
            $err_password = 'no';

            foreach ($result2 as $row) {
                $usergroup = $row['usergroup'];
                $name = $row['full_name'];
            }
            $result2->close();

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['data-login'] = $username . "_" . $password;
            $_SESSION['usergroup'] = $usergroup;

            date_default_timezone_set("Asia/Jakarta");
            $datetime = date("Y-m-d H:i:s");
            $query3 = "UPDATE master_user SET last_login = '$datetime' WHERE username = '$username' AND password = '$password'";
            $mysqli->query($query3);
        }
    }

    $data = [
        'err_username' => $err_username,
        'err_password' => $err_password
    ];

    $result1->close();
    $mysqli->close();

    print json_encode($data);
}
