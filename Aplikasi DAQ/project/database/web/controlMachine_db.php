<?php
if (($_GET['action'] == 'Yes')) {
    include('../connection.php');
    $action = $_GET['action'];
    $query = "UPDATE machine_status SET action = '$action'";
    $mysqli->query($query);
    $mysqli->close();
    header('Location:../../main/controlMachine.php?from=' . $_GET['from']);
} else if (($_GET['action'] == 'No')) {
    include('../connection.php');
    $action = $_GET['action'];
    $query = "UPDATE machine_status SET action = '$action'";
    $mysqli->query($query);
    $mysqli->close();
    header('Location:../../main/' . $_GET['from'] . '.php');
} else if (($_GET['action'] == 'Check')) {
    include('../connectionJSON.php');

    session_start();
    $username = substr($_SESSION['username'], 0, 4);

    $query = "SELECT * FROM master_user WHERE nik = '$username'";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $opSkill = $row['op_skill'];
        $usergroup = $row['usergroup'];
    }
    $result->close();
    $errSkill = 'yes';

    if ($opSkill >= 75) {
        $errSkill = 'no';
    } else if ($usergroup != 'Operator') {
        $errSkill = 'no';
    }

    $data = [
        'errSkill' => $errSkill,
        'usergroup' => $usergroup
    ];

    $mysqli->close();
    print json_encode($data);
} else if (($_GET['action'] == 'Read')) {
    include('../connectionJSON.php');

    $query = "SELECT * FROM machine_status";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $machineStatus = $row['status'];
    }

    $data = [
        'machineStatus' => $machineStatus
    ];

    $mysqli->close();
    print json_encode($data);
}
