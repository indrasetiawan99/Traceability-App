<?php
$baseURL = 'http://10.14.134.44/project/';
session_start();
if (!isset($_SESSION['data-login'])) {
    header("Location: " . $baseURL . 'main/login.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- JQuery -->
    <script src="<?= $baseURL . 'assets/vendor_component/jquery/jquery-3.5.1.js' ?>" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/css/bootstrap.min.css' ?>" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/select2/dist/css/select2.min.css' ?>">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/datatables/css/jquery.dataTables.min.css' ?>">

    <!-- Bootstrap JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js' ?>"></script>

    <!-- Select2 JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/select2/dist/js/select2.min.js' ?>"></script>

    <!-- Datatables JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/datatables/js/jquery.dataTables.min.js' ?>"></script>

    <!-- Bootstrap Multiselect CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/bootstrap-multiselect/css/bootstrap-multiselect.css' ?>">

    <!-- Bootstrap Multiselect JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-multiselect/js/bootstrap-multiselect.js' ?>"></script>

    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="../assets/vendor_component/sweetalert2/css/sweetalert2.min.css">

    <!-- Sweetalert2 JS -->
    <script src="../assets/vendor_component/sweetalert2/js/sweetalert2.all.min.js"></script>

    <!-- My CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/operator.css' ?>">

    <title>Operator View</title>

    <?php include('../database/connection.php'); ?>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-white bg-dark">
        <a class="navbar-brand" href="#">
            <img src="<?= $baseURL . 'assets/img/logo-api-panjang.png'; ?>" width="" height="40" alt="">
        </a>

        <div class="col">
            <div class="row">
                <span class="ml-auto font-weight-bold c1">Operator Interface</span>
            </div>
            <div class="row">
                <span class="ml-auto c1">Production Line |</span>
                <span class="c2">.</span>
                <span class="c1" id="the-line">Embedding</span>
            </div>
        </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="col">
            <div class="row mt-2">
                <span class="mt-2 font-weight-bold">
                    <?= $_SESSION['usergroup']; ?> | <?= $_SESSION['fullname']; ?>
                </span>
                <a href="<?= $baseURL . 'database/web/logout_db.php' ?>" class="ml-auto px-2">
                    <button class="btn btn-danger">
                        <img src="../assets/img/logout.png" width="28">
                    </button>
                </a>
                <?php
                if ($_SESSION['usergroup'] != 'Operator') {
                ?>
                    <div class="px-2">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#handleError">
                            <img src="../assets/img/ekstensi.png" alt="" width="30">
                        </button>
                    </div>
                <?php
                }
                ?>
                <div class="px-2">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#dandory-timer-modal" onclick="start()">
                        <img src="../assets/img/dandory.png" alt="" width="30">
                    </button>
                </div>
                <div class="px-2">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cek-jig-nut">
                        <img src="../assets/img/cek.png" alt="" width="30">
                    </button>
                </div>
                <div class="px-2">
                    <button id="btn-on-off" class="btn btn-warning">
                        <img src="../assets/img/power.png" alt="" width="30">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid mt-2">
        <!-- Set Scanner Mode -->
        <div>
            <?php
            $query1 = "UPDATE scanner_mode SET mode = 'Normal'";
            $mysqli->query($query1);
            ?>
        </div>

        <input type="text" id="type-of-page" value="operator-interface" hidden readonly>
        <table class="table-secondary w705">
            <thead class="text-center font-weight-bold">
                <tr>
                    <td class="w60">#</td>
                    <td>Product Name</td>
                    <td class="w40">Pack</td>
                    <td class="w60"><span class="c3">.</span> Target</td>
                    <td class="w210">Action</td>
                    <td class="w20"></td>
                </tr>
            </thead>
        </table>

        <div class="table-responsive mt-1 w705 h250">
            <table class="table table-bordered">
                <div>
                    <tbody class="text-center">
                        <!-- On Process -->
                        <?php
                        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                        if (!$mysqli) {
                            die("Connection failed: " . $mysqli->error);
                        }

                        $query1 = "SELECT * FROM setup_production WHERE status = 'On Process' ORDER BY start_time ASC";
                        $result1 = $mysqli->query($query1);
                        $i = 1;
                        foreach ($result1 as $row) :
                        ?>
                            <tr>
                                <td class="align-middle w20">
                                    <img src="../assets/img/on-process.png" width="30px" alt="">
                                </td>
                                <td class="align-middle"><?= $row['part_name']; ?></td>
                                <?php
                                $partName = $row['part_name'];
                                $query2 = "SELECT * FROM master_product WHERE part_name = '$partName'";
                                $result2 = $mysqli->query($query2);
                                foreach ($result2 as $row2) {
                                    $packaging = $row2['packaging'];
                                    $position = $row2['position'];
                                }
                                ?>
                                <td class="align-middle w40"><?= $packaging; ?></td>
                                <td class="align-middle w60"><?= $row['target']; ?></td>
                                <td class="align-middle w210">
                                    <?php
                                    $ngFile = '';
                                    $fnsFile = '';
                                    $ng_modal = '';
                                    if ($position == 'Right') {
                                        $ngFile = 'btn_NG_R';
                                        $fnsFile = 'btn_FNS_R';
                                        $ng_modal = '-R';
                                    } else if ($position == 'Left') {
                                        $ngFile = 'btn_NG_L';
                                        $fnsFile = 'btn_FNS_L';
                                        $ng_modal = '-L';
                                    }
                                    ?>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#part-ng-modal<?= $ng_modal; ?>">Not Good</button>
                                    <span>-</span>
                                    <a href="../database/web/<?= $fnsFile; ?>.php?seq4-status=finish">
                                        <button class="btn btn-success">Finish</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        endforeach;

                        $result1->close();
                        $mysqli->close();
                        ?>

                        <!-- Off Process -->
                        <?php
                        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                        if (!$mysqli) {
                            die("Connection failed: " . $mysqli->error);
                        }

                        $query1 = "SELECT * FROM setup_production WHERE status = 'Off Process' ORDER BY start_time ASC";
                        $result1 = $mysqli->query($query1);
                        $i = 1;
                        foreach ($result1 as $row) :
                        ?>
                            <tr>
                                <td class="align-middle w20">
                                    <img src="../assets/img/off-process.png" width="30px" alt="">
                                </td>
                                <td class="align-middle"><?= $row['part_name']; ?></td>
                                <?php
                                $partName = $row['part_name'];
                                $query2 = "SELECT * FROM master_product WHERE part_name = '$partName'";
                                $result2 = $mysqli->query($query2);
                                foreach ($result2 as $row2) {
                                    $packaging = $row2['packaging'];
                                    $position = $row2['position'];
                                }
                                ?>
                                <td class="align-middle w40"><?= $packaging; ?></td>
                                <td class="align-middle w60"><?= $row['target']; ?></td>
                                <td class="align-middle w210">
                                    <?php
                                    $ngFile = '';
                                    $fnsFile = '';
                                    $ng_modal = '';
                                    if ($position == 'Right') {
                                        $ngFile = 'btn_NG_R';
                                        $fnsFile = 'btn_FNS_R';
                                        $ng_modal = '-R';
                                    } else if ($position == 'Left') {
                                        $ngFile = 'btn_NG_L';
                                        $fnsFile = 'btn_FNS_L';
                                        $ng_modal = '-L';
                                    }
                                    ?>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#part-ng-modal<?= $ng_modal; ?>">Not Good</button>
                                    <span>-</span>
                                    <a href="../database/web/<?= $fnsFile; ?>.php?seq4-status=finish">
                                        <button class="btn btn-success">Finish</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        endforeach;

                        $result1->close();
                        $mysqli->close();
                        ?>
                        <?php for ($n = 0; $n < 5; $n++) { ?>
                            <tr>
                                <td class="align-middle w20">-</td>
                                <td class="align-middle">-</td>
                                <td class="align-middle w40">-</td>
                                <td class="align-middle w60">-</td>
                                <td class="align-middle w210">-</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </div>
            </table>
        </div>
        <!-- </center> -->
    </div>

    <!-- Footer -->
    <footer class="fixed-bottom">
        <div class="card-footer text-muted bg-dark h70">
            <div class="row">
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#input-part">
                        <img src="../assets/img/input.png" alt="" width="30">
                    </button>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#remaining">
                        <img src="../assets/img/reuse.png" alt="" width="36"><span style="color: #ffc107;">.</span><span id="badge-remaining-part" class="badge badge-dark"></span>
                    </button>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#downtime">
                        <img src="../assets/img/jam.png" alt="" width="30"><span style="color: #ffc107;">.</span><span id="badge-downtime" class="badge badge-dark"></span>
                    </button>
                </div>
                <?php
                if ($_SESSION['usergroup'] != 'Operator') {
                ?>
                    <div class="col-sm-2">
                        <a href="../main/supervisor.php">
                            <button class="btn btn-warning btn-lg btn-block">
                                <img src="../assets/img/user.png" width="30">
                            </button>
                        </a>
                    </div>
                <?php
                }
                ?>
                <div class="col px-4">
                    <div class="row">
                        <span class="ml-auto font-weight-bold c1" id="jam"></span>
                    </div>
                    <div class="row">
                        <span class="ml-auto font-weight-bold c1" id="tanggal"></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- The Modal 1 : Input Production -->
    <div class="modal" id="input-part">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Input Part Production</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <div class="form-group">
                        <label for="part-name">Operator</label>
                        <input type="text" class="form-control" id="id-operator" name="id-operator" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Cavity</label>
                        <select class="form-control select2" name="cavity" id="cavity" style="width: 100%;" required>
                            <option value="" selected disabled>-- Select --</option>
                            <option value="1-Right">1-Right</option>
                            <option value="1-Left">1-Left</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Part LH</label>
                        <?php
                        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                        if (!$mysqli) {
                            die("Connection failed: " . $mysqli->error);
                        }

                        $query1 = "SELECT DISTINCT part_name FROM setup_production WHERE part_name LIKE '% LH %' AND status = 'Off Process'";
                        $result1 = $mysqli->query($query1);
                        ?>
                        <select class="form-control select2" name="left-part" id="left-part" style="width: 100%;" disabled>
                            <option value="" id="cav-left" selected disabled>-- Select --</option>
                            <?php
                            while ($row = $result1->fetch_assoc()) {
                                echo "<option value='" . $row["part_name"] . "'>" . $row["part_name"] . "</option>";
                            }
                            $result1->close();
                            $mysqli->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Part RH</label>
                        <?php
                        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                        if (!$mysqli) {
                            die("Connection failed: " . $mysqli->error);
                        }

                        $query1 = "SELECT DISTINCT part_name FROM setup_production WHERE part_name LIKE '% RH %' AND status = 'Off Process'";
                        $result1 = $mysqli->query($query1);
                        ?>
                        <select size="1" class="form-control select2" name="right-part" id="right-part" style="width: 100%;" disabled>
                            <option value="" id="cav-right" selected disabled>-- Select --</option>
                            <?php
                            while ($row = $result1->fetch_assoc()) {
                                echo "<option value='" . $row["part_name"] . "'>" . $row["part_name"] . "</option>";
                            }
                            $result1->close();
                            $mysqli->close();
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="submit-input-product">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 2 : Downtime-->
    <div class="modal" id="downtime">
        <div class="modal-dialog-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title font-weight-bold">Downtime</h3>
                    <button class="btn btn-success ml-2" data-toggle="modal" data-target="#input-start-downtime">
                        <img src="../assets/img/tambah.png" width="30" alt="">
                    </button>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <table id="remaining-table" class="table table-bordered mt-1" style="white-space: nowrap;">
                        <thead class="text-center font-weight-bold thead-dark" style="background-color: darkgrey;">
                            <tr>
                                <td scope="col">#</td>
                                <td scope="col">Jenis Downtime</td>
                                <td scope="col">Deskripsi</td>
                                <td scope="col">Start</td>
                                <td scope="col">User Started</td>
                                <td scope="col">Finish</td>
                                <td scope="col">User Finished</td>
                                <td scope="col">Total Waktu</td>
                            </tr>
                        </thead>
                        <tbody id="downtime-table">
                        </tbody>
                        <script>
                            function Edit_Start_Downtime(user, category, id, desc, mode) {
                                document.getElementById('user-start-dnt-edit').value = user;
                                document.getElementById('id-start-dnt-edit').value = Number(id);
                                document.getElementById('desc-dnt-edit').value = desc;

                                if (mode == 'Select') {
                                    document.getElementById('select-category-dnt-edit').value = category;
                                    document.getElementById("input-dnt-cat-edit").style.display = "none";
                                    document.getElementById("select-dnt-cat-edit").style.display = "block";
                                } else if (mode == 'Input') {
                                    document.getElementById('input-category-dnt-edit').value = category;
                                    document.getElementById("cb-dnt-cat-edit").checked = true;
                                    document.getElementById("select-dnt-cat-edit").style.display = "none";
                                    document.getElementById("input-dnt-cat-edit").style.display = "block";
                                }
                            }

                            function Input_Finish_Downtime(id) {
                                document.getElementById('id-finish-dnt').value = Number(id);
                            }
                        </script>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 3 : Remaining Part Control-->
    <div class="modal" id="remaining">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Remaining Product</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <div class="col">
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <button class="btn btn-info btn-block" data-toggle="modal" data-target="#view-remaining">View</button>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-info btn-block" data-toggle="modal" data-target="#get-remaining">Get</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 4 : Input Part NG Right-->
    <div class="modal" id="part-ng-modal-R">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Input Part NG</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <?php
                    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                    if (!$mysqli) {
                        die("Connection failed: " . $mysqli->error);
                    }

                    $query1 = "SELECT * FROM temp_production WHERE part_name LIKE '% RH %'";
                    $result1 = $mysqli->query($query1);
                    foreach ($result1 as $row1) {
                        $partname_R = $row1['part_name'];
                    };
                    $result1->close();
                    ?>
                    <div class="form-group">
                        <label>Part Name</label>
                        <input name="part-ng-name-R" id="part-ng-name-R" class="form-control" value="<?= $partname_R ?>" readonly>
                    </div>
                    <?php
                    $query2 = "SELECT DISTINCT * FROM master_rejection";
                    $result2 = $mysqli->query($query2);
                    ?>
                    <div class="form-row">
                        <div class="col-12">
                            <label>NG Category</label>
                            <div id="select-ng-cat-R">
                                <select name="select-category-ng-R" id="select-category-ng-R" class="form-control" multiple="multiple">
                                    <?php
                                    $query1 = "SELECT * FROM master_rejection";
                                    $result1 = $mysqli->query($query1);

                                    while ($row1 = $result1->fetch_assoc()) {
                                        echo "<option value='" . $row1["category"] . "'>" . $row1["category"] . "</option>";
                                    }

                                    $result1->close();
                                    $mysqli->close();
                                    ?>
                                </select>
                            </div>
                            <div id="input-ng-cat-R">
                                <input type="text" class="form-control" name="input-category-ng-R" id="input-category-ng-R" readonly>
                            </div>
                            <div class="">
                                <input type="checkbox" id="cb-ng-cat-R" name="cb-ng-cat-R" class="mt-4 ml-2" style="scale: 2.0;">
                                <label for="cb-ng-cat-R" class="ml-2">Lain-lain</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submit-part-ng-R">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 5 : Input Part NG Left-->
    <div class="modal" id="part-ng-modal-L">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Input Part NG</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <?php
                    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                    if (!$mysqli) {
                        die("Connection failed: " . $mysqli->error);
                    }

                    $query1 = "SELECT * FROM temp_production WHERE part_name LIKE '% LH %'";
                    $result1 = $mysqli->query($query1);
                    foreach ($result1 as $row1) {
                        $partname_L = $row1['part_name'];
                    };
                    $result1->close();
                    ?>
                    <div class="form-group">
                        <label>Part Name</label>
                        <input name="part-ng-name-L" id="part-ng-name-L" class="form-control" value="<?= $partname_L ?>" readonly>
                    </div>
                    <?php
                    $query2 = "SELECT DISTINCT * FROM master_rejection";
                    $result2 = $mysqli->query($query2);
                    ?>
                    <div class="form-row">
                        <div class="col-12">
                            <label>NG Category</label>
                            <div id="select-ng-cat-L">
                                <select name="select-category-ng-L" id="select-category-ng-L" class="form-control" multiple="multiple">
                                    <?php
                                    $query1 = "SELECT * FROM master_rejection";
                                    $result1 = $mysqli->query($query1);

                                    while ($row1 = $result1->fetch_assoc()) {
                                        echo "<option value='" . $row1["category"] . "'>" . $row1["category"] . "</option>";
                                    }

                                    $result1->close();
                                    $mysqli->close();
                                    ?>
                                </select>
                            </div>
                            <div id="input-ng-cat-L">
                                <input type="text" class="form-control" name="input-category-ng-L" id="input-category-ng-L" readonly>
                            </div>
                            <div class="">
                                <input type="checkbox" id="cb-ng-cat-L" name="cb-ng-cat-L" class="mt-4 ml-2" style="scale: 2.0;">
                                <label for="cb-ng-cat-L" class="ml-2">Lain-lain</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submit-part-ng-L">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 6 : View Remaining Product -->
    <div class="modal" id="view-remaining">
        <div class="modal-dialog-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">View Remaining Product</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <table id="remaining-table" class="table table-bordered" style="white-space: nowrap;">
                        <thead class="text-center font-weight-bold thead-dark" style="background-color: darkgrey;">
                            <tr>
                                <td scope="col">#</td>
                                <td scope="col">Part Name</td>
                                <td scope="col">Part Number API</td>
                                <td scope="col">Part Number Cust.</td>
                                <td scope="col">Qty</td>
                                <td scope="col">Datetime</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                            if (!$mysqli) {
                                die("Connection failed: " . $mysqli->error);
                            }

                            $query1 = "SELECT * FROM remaining_part";
                            $result1 = $mysqli->query($query1);
                            $i = 1;
                            foreach ($result1 as $row) :
                            ?>
                                <tr>
                                    <td scope="row"><?= $i; ?></td>
                                    <td><?= $row['part_name']; ?></td>
                                    <td><?= $row['pn_api']; ?></td>
                                    <td><?= $row['pn_cust']; ?></td>
                                    <td><?= $row['qty']; ?></td>
                                    <td><?= $row['date_time']; ?></td>
                                </tr>
                            <?php
                                $i++;
                            endforeach;
                            $result1->close();
                            $mysqli->close();
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 7 : Get Remaining Product -->
    <div class="modal" id="get-remaining">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Get Remaining Product</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <form id="get-remaining-part" method="POST" action="../database/web/getRemaining.php">
                        <?php
                        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                        if (!$mysqli) {
                            die("Connection failed: " . $mysqli->error);
                        }

                        $query1 = "SELECT * FROM remaining_part";
                        $result1 = $mysqli->query($query1);
                        ?>
                        <div class="form-group">
                            <label>Part Name</label>
                            <select name="get-part-name" id="get-part-name" class="form-control select2" style="width: 100%;" required>
                                <option selected disabled>-- Select --</option>
                                <?php
                                while ($row = $result1->fetch_assoc()) {
                                    echo "<option value='" . $row["part_name"] . "'>" . $row["part_name"] . "</option>";
                                }
                                $result1->close();
                                $mysqli->close();
                                ?>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submit-get-part" form="get-remaining-part"></form>Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 8 : Fitur tambahan-->
    <div class="modal" id="handleError">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Extension</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <div class="col">
                        <div class="row">
                            <div class="col text-center mt-2">
                                <a href="<?= $baseURL . 'main/handleErrorQrcode.php'; ?>">
                                    <button class="btn btn-info btn-block">Print QR-code</button>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center mt-1">
                                <a href="<?= $baseURL . 'main/print_datapart.php'; ?>">
                                    <button class="btn btn-info btn-block">Print Datapart</button>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center mt-1">
                                <a href="<?= $baseURL . 'main/repair_qrcode.php'; ?>">
                                    <button class="btn btn-info btn-block">Repair QR-code</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 9 : Cek Jig dan Nut-->
    <div class="modal" id="cek-jig-nut">
        <div class="modal-dialog-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Kesesuaian Jig dan Stud Nut</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <center>
                        <h5 class="font-weight-bold">Planning</h5>
                    </center>
                    <table id="" class="table table-bordered" style="white-space: nowrap;">
                        <thead class="text-center font-weight-bold table-secondary">
                            <tr>
                                <td class="w335">Jig</td>
                                <td>Nut</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>
                                    <h6 id="jig-plan" class=""></h6>
                                </td>
                                <td>
                                    <h6 id="nut-plan" class=""></h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <center>
                        <h5 class="font-weight-bold">Aktual</h5>
                    </center>
                    <table id="" class="table table-bordered" style="white-space: nowrap;">
                        <thead class="text-center font-weight-bold table-secondary">
                            <tr>
                                <td class="w335">Jig</td>
                                <td>Nut</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>
                                    <h6 id="jig-actual" class=""></h6>
                                </td>
                                <td>
                                    <h6 id="nut-actual" class=""></h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 10 : Input Start Downtime -->
    <div class="modal" id="input-start-downtime">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Input Start Downtime</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <?php
                    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                    if (!$mysqli) {
                        die("Connection failed: " . $mysqli->error);
                    }
                    ?>
                    <div class="form-group">
                        <label>User Data</label>
                        <input type="text" class="form-control" id="user-start-dnt" name="user-start-dnt" required readonly>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <label>Downtime Category</label>
                            <div id="select-dnt-cat">
                                <select name="select-category-dnt" id="select-category-dnt" style="width: 100%;" class=" form-control select2" required>
                                    <option value="" selected disabled>-- Select --</option>
                                    <?php
                                    $query5 = "SELECT * FROM master_downtime";
                                    $result5 = $mysqli->query($query5);

                                    while ($row5 = $result5->fetch_assoc()) {
                                        echo "<option value='" . $row5["category"] . "'>" . $row5["category"] . "</option>";
                                    }

                                    $result5->close();
                                    $mysqli->close();
                                    ?>
                                </select>
                            </div>
                            <div id="input-dnt-cat">
                                <input type="text" class="form-control" name="input-category-dnt" id="input-category-dnt" required readonly>
                            </div>
                            <div class="">
                                <input type="checkbox" id="cb-dnt-cat" name="cb-dnt-cat" class="class-cb big">
                                <label for="cb-dnt-cat" class="lbl-cb big"></label>
                                <label for="cb-dnt-cat" class="lbl-cb2">Lain-lain</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Downtime Description</label>
                            <input type="text" class="form-control" name="desc-dnt" id="desc-dnt">
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submit-start-dnt"></form>Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 11 : Edit Start Downtime -->
    <div class="modal" id="edit-start-downtime">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Edit Downtime</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <?php
                    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                    if (!$mysqli) {
                        die("Connection failed: " . $mysqli->error);
                    }
                    ?>
                    <div class="form-group" hidden>
                        <label>ID Data</label>
                        <input type="number" class="form-control" id="id-start-dnt-edit" name="id-start-dnt-edit">
                    </div>
                    <div class="form-group">
                        <label>User Data</label>
                        <input type="text" class="form-control" id="user-start-dnt-edit" name="user-start-dnt-edit" required readonly>
                    </div>
                    <div class="form-group">
                        <label>User Confirmation</label>
                        <input type="text" class="form-control" id="conf-start-dnt-edit" name="conf-start-dnt-edit" required readonly>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <label>Downtime Category</label>
                            <div id="select-dnt-cat-edit">
                                <select name="select-category-dnt-edit" id="select-category-dnt-edit" style="width: 100%;" class=" form-control select2" required>
                                    <option value="" selected disabled>-- Select --</option>
                                    <?php
                                    $query5 = "SELECT * FROM master_downtime";
                                    $result5 = $mysqli->query($query5);

                                    while ($row5 = $result5->fetch_assoc()) {
                                        echo "<option value='" . $row5["category"] . "'>" . $row5["category"] . "</option>";
                                    }
                                    $result5->close();
                                    ?>
                                </select>
                            </div>
                            <div id="input-dnt-cat-edit">
                                <input type="text" class="form-control" name="input-category-dnt-edit" id="input-category-dnt-edit" required readonly>
                            </div>
                            <div class="">
                                <input type="checkbox" id="cb-dnt-cat-edit" name="cb-dnt-cat-edit" class="mt-4 ml-2" style="scale: 2.0;">
                                <label for="cb-dnt-cat-edit" class="ml-2">Lain-lain</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Downtime Description</label>
                            <input type="text" class="form-control" name="desc-dnt-edit" id="desc-dnt-edit" required>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submit-start-dnt-edit"></form>Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 12 : Input Finish Downtime -->
    <div class="modal" id="input-finish-downtime">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Input Finish Downtime</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <?php
                    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                    if (!$mysqli) {
                        die("Connection failed: " . $mysqli->error);
                    }
                    ?>
                    <div class="form-group" hidden>
                        <label>ID Data</label>
                        <input type="number" class="form-control" id="id-finish-dnt" name="id-finish-dnt">
                    </div>
                    <div class="form-group">
                        <label>User Data</label>
                        <input type="text" class="form-control" id="user-finish-dnt" name="user-finish-dnt" required readonly>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="submit-finish-dnt"></form>Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 13 : Dandori Time-->
    <div class="modal" id="dandory-timer-modal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Dandori Time</h3>
                    <button type="button" class="close" data-dismiss="modal" onclick="reset()">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <div class="text-center">
                        <h1 id="dandory-timer">00:00:00</h1>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="pause()" id="submit-dandory-time">Stop</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset()">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Extension Javascript Program -->
    <div>
        <script src="<?= $baseURL . 'main/js/timer.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance2.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/print.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/cavity.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/readRfid2.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/inputProduct.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/print_wip.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/controlMachine.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/badge_downtime.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/badge_remaining_part.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/cek_jig_nut.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/downtime.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/rejection.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/dandory.js' ?>"></script>
        <script>
            $(function() {
                $('.select2').select2();
            });
        </script>
    </div>
</body>

</html>