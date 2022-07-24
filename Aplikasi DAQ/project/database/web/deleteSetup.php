<?php
if (!empty($_POST['cb-status'])) {
    include('../connection.php');
    $checked_values = $_POST['cb-status'];
    foreach ($checked_values as $val) {
        $query2 = "SELECT * FROM setup_production WHERE id = '$val'";
        $result2 = $mysqli->query($query2);
        foreach ($result2 as $row) {
            $partname = $row['part_name'];
            $target = $row['target'];
        }
        $query3 = "DELETE FROM recapitulation WHERE part_name = '$partname' AND target = '$target' AND status = 'On Process'";
        $mysqli->query($query3);

        $query1 = "DELETE FROM setup_production WHERE id = '$val'";
        $mysqli->query($query1);
    }
    $mysqli->close();
}

header('Location:../../main/supervisor.php');
