<?php
if ($_GET['Set'] == 'Jig_A') {
    include('../connection.php');
    $query1 = "UPDATE jig_and_nut SET jig = 'D01N'";
    $mysqli->query($query1);
    $mysqli->close();
}
if ($_GET['Set'] == 'Jig_B') {
    include('../connection.php');
    $query2 = "UPDATE jig_and_nut SET jig = 'D64G'";
    $mysqli->query($query2);
    $mysqli->close();
}
if ($_GET['Set'] == 'Jig_C') {
    include('../connection.php');
    $query3 = "UPDATE jig_and_nut SET jig = 'D13/D14'";
    $mysqli->query($query3);
    $mysqli->close();
}

if ($_GET['Set'] == 'Nut_A') {
    include('../connection.php');
    $query5 = "UPDATE jig_and_nut SET nut = 'D01N'";
    $mysqli->query($query5);
    $mysqli->close();
}
if ($_GET['Set'] == 'Nut_B') {
    include('../connection.php');
    $query6 = "UPDATE jig_and_nut SET nut = 'D64G'";
    $mysqli->query($query6);
    $mysqli->close();
}
if ($_GET['Set'] == 'Nut_C') {
    include('../connection.php');
    $query7 = "UPDATE jig_and_nut SET nut = 'D13/D14'";
    $mysqli->query($query7);
    $mysqli->close();
}
