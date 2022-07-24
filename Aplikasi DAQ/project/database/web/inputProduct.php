<?php
if (isset($_POST['id-operator'])) {
    include('../connectionJSON.php');

    $nik = $_POST['id-operator'];
    $cavity = $_POST['cavity'];
    $partNameR = $_POST['right-part'];
    $partNameL = $_POST['left-part'];

    $errUser = 'yes';
    $errSkill = 'yes';
    $errProd1 = 'yes';
    $errProd2 = 'yes';
    $usergroup = 'Operator';

    if ($partNameR != '' && $partNameL != '') {
        $query1 = "SELECT * FROM master_user WHERE nik = '$nik'";
        $query2 = "SELECT * FROM master_product WHERE part_name = '$partNameR'";
        $query3 = "SELECT * FROM master_product WHERE part_name = '$partNameL'";

        $result1 = $mysqli->query($query1);
        $result2 = $mysqli->query($query2);
        $result3 = $mysqli->query($query3);

        $cekNik = mysqli_num_rows($result1);

        foreach ($result1 as $row) {
            $opSkill = $row["op_skill"];
            $userGroup = $row["usergroup"];
        }
        $result1->close();

        foreach ($result2 as $row) {
            $packagingTargetR = $row["packaging"];
        }
        $result2->close();

        foreach ($result3 as $row) {
            $packagingTargetL = $row["packaging"];
        }
        $result3->close();

        if ($cekNik > 0) {
            $errUser = 'no';

            if ($userGroup == "Supervisor") {
                $errSkill = 'no';

                $query11 = "SELECT * FROM temp_production";
                $result11 = $mysqli->query($query11);
                $cekProd = mysqli_num_rows($result11);
                $result11->close();

                if ($cekProd == 0) {
                    $errProd1 = 'no';

                    $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
                    $result12 = $mysqli->query($query12);
                    foreach ($result12 as $row) {
                        $cekPartnameR = $row['part_name'];
                    }
                    $result12->close();
                    $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
                    $result12 = $mysqli->query($query12);
                    foreach ($result12 as $row) {
                        $cekPartnameL = $row['part_name'];
                    }
                    $result12->close();

                    if ($cekPartnameR == $partNameR && $cekPartnameL == $partNameL) {
                        $errProd2 = 'no';
                        $query4 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameR', '$nik', '$packagingTargetR', 'Right')";
                        $query5 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameL', '$nik', '$packagingTargetL', 'Left')";

                        if ($mysqli->query($query4) == TRUE && $mysqli->query($query5) == TRUE) {
                            $query6 = "DELETE FROM temp_rfid_data";
                            $mysqli->query($query6);

                            $query7 = "SELECT * FROM setup_production WHERE part_name = '$partNameR' AND status = 'Off Process'";
                            $result7 = $mysqli->query($query7);
                            $cekPartnameR = mysqli_num_rows($result7);
                            if ($cekPartnameR > 0) {
                                $query8 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameR' AND status = 'Off Process'";
                                $mysqli->query($query8);
                            }

                            $query9 = "SELECT * FROM setup_production WHERE part_name = '$partNameL' AND status = 'Off Process'";
                            $result9 = $mysqli->query($query9);
                            $cekPartnameL = mysqli_num_rows($result9);
                            if ($cekPartnameL > 0) {
                                $query10 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameL' AND status = 'Off Process'";
                                $mysqli->query($query10);
                            }
                        }
                    }
                }
            } else {
                if ($opSkill >= 75) {
                    $errSkill = 'no';

                    $query11 = "SELECT * FROM temp_production";
                    $result11 = $mysqli->query($query11);
                    $cekProd = mysqli_num_rows($result11);
                    $result11->close();

                    if ($cekProd == 0) {
                        $errProd1 = 'no';

                        $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
                        $result12 = $mysqli->query($query12);
                        foreach ($result12 as $row) {
                            $cekPartnameR = $row['part_name'];
                        }
                        $result12->close();
                        $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
                        $result12 = $mysqli->query($query12);
                        foreach ($result12 as $row) {
                            $cekPartnameL = $row['part_name'];
                        }
                        $result12->close();

                        if ($cekPartnameR == $partNameR && $cekPartnameL == $partNameL) {
                            $errProd2 = 'no';
                            $query4 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameR', '$nik', '$packagingTargetR', 'Right')";
                            $query5 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameL', '$nik', '$packagingTargetL', 'Left')";

                            if ($mysqli->query($query4) == TRUE && $mysqli->query($query5) == TRUE) {
                                $query6 = "DELETE FROM temp_rfid_data";
                                $mysqli->query($query6);

                                $query7 = "SELECT * FROM setup_production WHERE part_name = '$partNameR' AND status = 'Off Process'";
                                $result7 = $mysqli->query($query7);
                                $cekPartnameR = mysqli_num_rows($result7);
                                if ($cekPartnameR > 0) {
                                    $query8 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameR' AND status = 'Off Process'";
                                    $mysqli->query($query8);
                                }

                                $query9 = "SELECT * FROM setup_production WHERE part_name = '$partNameL' AND status = 'Off Process'";
                                $result9 = $mysqli->query($query9);
                                $cekPartnameL = mysqli_num_rows($result9);
                                if ($cekPartnameL > 0) {
                                    $query10 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameL' AND status = 'Off Process'";
                                    $mysqli->query($query10);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $query6 = "DELETE FROM temp_rfid_data";
            $mysqli->query($query6);
        }
    } else if ($partNameR != '') {
        $query1 = "SELECT * FROM master_user WHERE nik = '$nik'";
        $query2 = "SELECT * FROM master_product WHERE part_name = '$partNameR'";

        $result1 = $mysqli->query($query1);
        $result2 = $mysqli->query($query2);

        $cekNik = mysqli_num_rows($result1);

        foreach ($result1 as $row) {
            $opSkill = $row["op_skill"];
            $userGroup = $row["usergroup"];
        }
        $result1->close();

        foreach ($result2 as $row) {
            $packagingTarget = $row["packaging"];
        }
        $result2->close();

        if ($cekNik > 0) {
            $errUser = 'no';

            if ($userGroup == "Supervisor") {
                $errSkill = 'no';

                $query11 = "SELECT * FROM temp_production WHERE part_name LIKE '% RH %'";
                $result11 = $mysqli->query($query11);
                $cekProd = mysqli_num_rows($result11);
                $result11->close();

                if ($cekProd == 0) {
                    $errProd1 = 'no';

                    $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
                    $result12 = $mysqli->query($query12);
                    foreach ($result12 as $row) {
                        $cekPartnameR = $row['part_name'];
                    }
                    $result12->close();

                    if ($cekPartnameR == $partNameR) {
                        $errProd2 = 'no';
                        $query3 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameR', '$nik', '$packagingTarget', 'Right')";

                        if ($mysqli->query($query3) == TRUE) {
                            $query4 = "DELETE FROM temp_rfid_data";
                            $mysqli->query($query4);

                            $query7 = "SELECT * FROM setup_production WHERE part_name = '$partNameR' AND status = 'Off Process'";
                            $result7 = $mysqli->query($query7);
                            $cekPartnameR = mysqli_num_rows($result7);
                            if ($cekPartnameR > 0) {
                                $query8 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameR' AND status = 'Off Process'";
                                $mysqli->query($query8);
                            }
                        }
                    }
                }
            } else {
                if ($opSkill >= 75) {
                    $errSkill = 'no';

                    $query11 = "SELECT * FROM temp_production WHERE part_name LIKE '% RH %'";
                    $result11 = $mysqli->query($query11);
                    $cekProd = mysqli_num_rows($result11);
                    $result11->close();

                    if ($cekProd == 0) {
                        $errProd1 = 'no';

                        $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% RH %' ORDER BY start_time ASC LIMIT 1";
                        $result12 = $mysqli->query($query12);
                        foreach ($result12 as $row) {
                            $cekPartnameR = $row['part_name'];
                        }
                        $result12->close();

                        if ($cekPartnameR == $partNameR) {
                            $errProd2 = 'no';
                            $query3 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameR', '$nik', '$packagingTarget', 'Right')";

                            if ($mysqli->query($query3) == TRUE) {
                                $query4 = "DELETE FROM temp_rfid_data";
                                $mysqli->query($query4);

                                $query7 = "SELECT * FROM setup_production WHERE part_name = '$partNameR' AND status = 'Off Process'";
                                $result7 = $mysqli->query($query7);
                                $cekPartnameR = mysqli_num_rows($result7);
                                if ($cekPartnameR > 0) {
                                    $query8 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameR' AND status = 'Off Process'";
                                    $mysqli->query($query8);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $query4 = "DELETE FROM temp_rfid_data";
            $mysqli->query($query4);
        }
    } else if ($partNameL != '') {
        $query1 = "SELECT * FROM master_user WHERE nik = '$nik'";
        $query2 = "SELECT * FROM master_product WHERE part_name = '$partNameL'";

        $result1 = $mysqli->query($query1);
        $result2 = $mysqli->query($query2);

        $cekNik = mysqli_num_rows($result1);

        foreach ($result1 as $row) {
            $opSkill = $row["op_skill"];
            $userGroup = $row["usergroup"];
        }
        $result1->close();

        foreach ($result2 as $row) {
            $packagingTarget = $row["packaging"];
        }
        $result2->close();

        if ($cekNik > 0) {
            $errUser = 'no';

            if ($userGroup == "Supervisor") {
                $errSkill = 'no';

                $query11 = "SELECT * FROM temp_production WHERE part_name LIKE '% LH %'";
                $result11 = $mysqli->query($query11);
                $cekProd = mysqli_num_rows($result11);
                $result11->close();

                if ($cekProd == 0) {
                    $errProd1 = 'no';

                    $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
                    $result12 = $mysqli->query($query12);
                    foreach ($result12 as $row) {
                        $cekPartnameL = $row['part_name'];
                    }
                    $result12->close();

                    if ($cekPartnameL == $partNameL) {
                        $errProd2 = 'no';
                        $query3 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameL', '$nik', '$packagingTarget', 'Left')";

                        if ($mysqli->query($query3) == TRUE) {
                            $query4 = "DELETE FROM temp_rfid_data";
                            $mysqli->query($query4);

                            $query9 = "SELECT * FROM setup_production WHERE part_name = '$partNameL' AND status = 'Off Process'";
                            $result9 = $mysqli->query($query9);
                            $cekPartnameL = mysqli_num_rows($result9);
                            if ($cekPartnameL > 0) {
                                $query10 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameL' AND status = 'Off Process'";
                                $mysqli->query($query10);
                            }
                        }
                    }
                }
            } else {
                if ($opSkill >= 75) {
                    $errSkill = 'no';

                    $query11 = "SELECT * FROM temp_production WHERE part_name LIKE '% LH %'";
                    $result11 = $mysqli->query($query11);
                    $cekProd = mysqli_num_rows($result11);
                    $result11->close();

                    if ($cekProd == 0) {
                        $errProd1 = 'no';

                        $query12 = "SELECT * FROM setup_production WHERE status = 'Off Process' AND part_name LIKE '% LH %' ORDER BY start_time ASC LIMIT 1";
                        $result12 = $mysqli->query($query12);
                        foreach ($result12 as $row) {
                            $cekPartnameL = $row['part_name'];
                        }
                        $result12->close();

                        if ($cekPartnameL == $partNameL) {
                            $errProd2 = 'no';
                            $query3 = "INSERT INTO temp_production (part_name, nik, packaging, position) VALUES ('$partNameL', '$nik', '$packagingTarget', 'Left')";

                            if ($mysqli->query($query3) == TRUE) {
                                $query4 = "DELETE FROM temp_rfid_data";
                                $mysqli->query($query4);

                                $query9 = "SELECT * FROM setup_production WHERE part_name = '$partNameL' AND status = 'Off Process'";
                                $result9 = $mysqli->query($query9);
                                $cekPartnameL = mysqli_num_rows($result9);
                                if ($cekPartnameL > 0) {
                                    $query10 = "UPDATE setup_production SET status = 'On Process' WHERE part_name = '$partNameL' AND status = 'Off Process'";
                                    $mysqli->query($query10);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $query4 = "DELETE FROM temp_rfid_data";
            $mysqli->query($query4);
        }
    }
    $data = [
        'errUser' => $errUser,
        'errSkill' => $errSkill,
        'errProd1' => $errProd1,
        'errProd2' => $errProd2
    ];

    $mysqli->close();
    print json_encode($data);
}
