<?php
$baseURL = 'http://10.14.134.44/project/';
session_start();
if (!isset($_SESSION['data-login'])) {
    header("Location: " . $baseURL . 'main/login.php');
} else if ($_SESSION['usergroup'] == 'Operator') {
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

    <!-- Bootstrap JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js' ?>"></script>

    <!-- Select2 JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/select2/dist/js/select2.min.js' ?>"></script>

    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="../assets/vendor_component/sweetalert2/css/sweetalert2.min.css">

    <!-- Sweetalert2 JS -->
    <script src="../assets/vendor_component/sweetalert2/js/sweetalert2.all.min.js"></script>

    <!-- My CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/supervisor.css' ?>">

    <title>Supervisor View</title>
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
                <span class="ml-auto c1">Production Setup</span>
            </div>
            <div class="row">
                <span class="ml-auto c2">Production Line |</span>
                <span class="c3">.</span>
                <span class="c2" id="the-line">Embedding</span>
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
                <a href=" <?= $baseURL . 'database/web/logout_db.php' ?>" class="ml-auto px-2">
                    <button class="btn btn-danger">
                        <img src="../assets/img/logout.png" width="28">
                    </button>
                </a>
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

        <table class="table-secondary w705">
            <thead class="text-center font-weight-bold">
                <tr>
                    <td class="w50">#</td>
                    <td>Product Name</td>
                    <td class="w60">Target</td>
                    <td class="w120">Start</td>
                    <td class="w120">Finish</td>
                    <td class="w20"></td>
                </tr>
            </thead>
        </table>

        <div class="table-responsive mt-1 h250 w705">
            <form id="form-delete" method="POST" action="../database/web/deleteSetup.php">
                <table class="table table-bordered">
                    <div>
                        <tbody class="text-center">
                            <?php
                            $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                            if (!$mysqli) {
                                die("Connection failed: " . $mysqli->error);
                            }
                            $query1 = "SELECT * FROM setup_production WHERE status != 'Finish'";
                            $result1 = $mysqli->query($query1);

                            $i = 1;
                            foreach ($result1 as $row) :
                            ?>
                                <tr>
                                    <td class="align-middle custom-control-lg custom-control custom-checkbox w50">
                                        <input id="cb-<?= $i; ?>" name="cb-status[<?= $i; ?>]" value="<?= $row['id']; ?>" type="checkbox" class="align-middle custom-control-input">
                                        <label class="custom-control-label" for="cb-<?= $i; ?>"></label>
                                    </td>
                                    <td class="align-middle"><?= $row['part_name']; ?></td>
                                    <td class="align-middle w60"><?= $row['target']; ?></td>
                                    <?php
                                    $datetime1 = new DateTime($row['start_time']);
                                    $datetime2 = new DateTime($row['end_time']);
                                    ?>
                                    <td class="align-middle w120"><?= $datetime1->format('d/m H:i'); ?></td>
                                    <td class="align-middle w120"><?= $datetime2->format('d/m H:i'); ?></td>
                                </tr>
                            <?php
                                $i++;
                            endforeach;

                            $result1->close();
                            $mysqli->close();
                            ?>
                            <?php for ($n = 0; $n < 5; $n++) { ?>
                                <tr>
                                    <td class="align-middle w30">-</td>
                                    <td class="align-middle">-</td>
                                    <td class="align-middle w60">-</td>
                                    <td class="align-middle w120">-</td>
                                    <td class="align-middle w120">-</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </div>
                </table>
            </form>
        </div>
        <!-- </center> -->
    </div>

    <!-- Footer -->
    <footer class="fixed-bottom">
        <div class="card-footer text-muted bg-dark h70">
            <div class="row">
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#add">
                        <img src="../assets/img/tambah.png" width="30" alt="">
                    </button>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-danger btn-lg btn-block" form="form-delete">
                        <img src="../assets/img/delete.png" width="25" alt="">
                    </button>
                </div>
                <div class="col-sm-2">
                    <button id="btn-edit" type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#edit">
                        <img src="../assets/img/input.png" alt="" width="30">
                    </button>
                </div>
                <div class="col-sm-2">
                    <a href="<?= $baseURL . 'main/operator.php' ?>">
                        <button class="btn btn-warning btn-lg btn-block">
                            <img src="../assets/img/user.png" width="30" alt="">
                        </button>
                    </a>
                </div>
                <div class="col px-4">
                    <div class="row">
                        <span class="ml-auto font-weight-bold c2" id="jam"></span>
                    </div>
                    <div class="row">
                        <span class="ml-auto font-weight-bold c2" id="tanggal"></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- The Modal 1 : Add Setup Production -->
    <div class="modal" id="add">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Add Setup Production</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <form id="form-tambah" method="POST" action="../database/web/addSetup.php">
                        <div class="form-group">
                            <label for="add-part-name">Part Name</label>
                            <?php
                            $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                            if (!$mysqli) {
                                die("Connection failed: " . $mysqli->error);
                            }

                            $query1 = "SELECT * FROM master_product";
                            $result1 = $mysqli->query($query1);
                            ?>
                            <select name="add-part-name" id="add-part-name" class="form-control select2" style="width: 100%;" required>
                                <option value="" selected disabled>-- Select --</option>
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
                            <label for="target">Target</label>
                            <input type="number" class="form-control" id="add-target" name="add-target" required>
                        </div>
                        <div class="form-group">
                            <label>Start</label>
                            <div class="form-row">
                                <div class="col-6">
                                    <input type="date" class="form-control" id="add-start-date" name="add-start-date" required>
                                </div>
                                <div>
                                    <h4>-</h4>
                                </div>
                                <div class="col-2">
                                    <select class="select2" name="add-start-hour" id="add-start-hour" style="width: 100%;" required>
                                        <option selected disabled>--</option>
                                        <?php
                                        for ($i = 0; $i < 24; $i++) {
                                        ?>
                                            <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                        <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <h4>:</h4>
                                </div>
                                <div class="col-2">
                                    <select class="select2" name="add-start-min" id="add-start-min" style="width: 100%;" required>
                                        <option selected disabled>--</option>
                                        <?php
                                        for ($i = 0; $i < 60; $i++) {
                                        ?>
                                            <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                        <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Finish</label>
                            <div class="form-row">
                                <div class="col-6">
                                    <input type="date" class="form-control" id="add-finish-date" name="add-finish-date" required>
                                </div>
                                <div>
                                    <h4>-</h4>
                                </div>
                                <div class="col-2">
                                    <select class="select2" name="add-finish-hour" id="add-finish-hour" style="width: 100%;" required>
                                        <option selected disabled>--</option>
                                        <?php
                                        for ($i = 0; $i < 24; $i++) {
                                        ?>
                                            <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                        <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <h4>:</h4>
                                </div>
                                <div class="col-2">
                                    <select class="select2" name="add-finish-min" id="add-finish-min" style="width: 100%;" required>
                                        <option selected disabled>--</option>
                                        <?php
                                        for ($i = 0; $i < 60; $i++) {
                                        ?>
                                            <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                        <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" form="form-tambah" value="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal 2 : Edit Setup Production -->
    <div class="modal" id="edit">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Edit Setup Production</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <form id="form-edit" method="POST" action="../database/web/editSetupSave.php">
                        <div class="box" id="box1">
                            <div class="box-header with-border">
                                <h6 class="box-title">Edit Setup Production 1</h6>
                            </div>
                            <div class="form-group">
                                <label>Part Name</label>
                                <input type="text" class="form-control" id="edit-part-name1" name="edit-part-name1" readonly>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="number" class="form-control" id="edit-target1" name="edit-target1">
                            </div>
                            <div class="form-group">
                                <label>Start - Date format: mm/dd/yyyy</label>
                                <div class="form-row">
                                    <div class="col-6">
                                        <input type="date" class="form-control" id="edit-start-date1" name="edit-start-date1">
                                    </div>
                                    <div>
                                        <h4>-</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-start-hour1" id="edit-start-hour1" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>:</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-start-min1" id="edit-start-min1" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 60; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Finish - Date format: mm/dd/yyyy</label>
                                <div class="form-row">
                                    <div class="col-6">
                                        <input type="date" class="form-control" id="edit-finish-date1" name="edit-finish-date1">
                                    </div>
                                    <div>
                                        <h4>-</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-finish-hour1" id="edit-finish-hour1" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>:</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-finish-min1" id="edit-finish-min1" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 60; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box" id="box2">
                            <hr class="b1">
                            <div class="box-header with-border">
                                <h6 class="box-title">Edit Setup Production 2</h6>
                            </div>
                            <div class="form-group">
                                <label>Part Name</label>
                                <input type="text" class="form-control" id="edit-part-name2" name="edit-part-name2" readonly>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="number" class="form-control" id="edit-target2" name="edit-target2">
                            </div>
                            <div class="form-group">
                                <label>Start - Date format: mm/dd/yyyy</label>
                                <div class="form-row">
                                    <div class="col-6">
                                        <input type="date" class="form-control" id="edit-start-date2" name="edit-start-date2">
                                    </div>
                                    <div>
                                        <h4>-</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-start-hour2" id="edit-start-hour2" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>:</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-start-min2" id="edit-start-min2" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 60; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Finish - Date format: mm/dd/yyyy</label>
                                <div class="form-row">
                                    <div class="col-6">
                                        <input type="date" class="form-control" id="edit-finish-date2" name="edit-finish-date2">
                                    </div>
                                    <div>
                                        <h4>-</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-finish-hour2" id="edit-finish-hour2" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>:</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-finish-min2" id="edit-finish-min2" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 60; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box" id="box3">
                            <hr class="b1">
                            <div class="box-header with-border">
                                <h6 class="box-title">Edit Setup Production 3</h6>
                            </div>
                            <div class="form-group">
                                <label>Part Name</label>
                                <input type="text" class="form-control" id="edit-part-name3" name="edit-part-name3" readonly>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="number" class="form-control" id="edit-target3" name="edit-target3">
                            </div>
                            <div class="form-group">
                                <label>Start - Date format: mm/dd/yyyy</label>
                                <div class="form-row">
                                    <div class="col-6">
                                        <input type="date" class="form-control" id="edit-start-date3" name="edit-start-date3">
                                    </div>
                                    <div>
                                        <h4>-</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-start-hour3" id="edit-start-hour3" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>:</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-start-min3" id="edit-start-min3" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 60; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Finish - Date format: mm/dd/yyyy</label>
                                <div class="form-row">
                                    <div class="col-6">
                                        <input type="date" class="form-control" id="edit-finish-date3" name="edit-finish-date3">
                                    </div>
                                    <div>
                                        <h4>-</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-finish-hour3" id="edit-finish-hour3" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <h4>:</h4>
                                    </div>
                                    <div class="col-2">
                                        <select class="select2" name="edit-finish-min3" id="edit-finish-min3" style="width: 100%;">
                                            <option selected disabled>--</option>
                                            <?php
                                            for ($i = 0; $i < 60; $i++) {
                                            ?>
                                                <option value="<?= $i = sprintf("%02d", $i); ?>"><?= $i = sprintf("%02d", $i); ?></option>
                                            <?php
                                            };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" form="form-edit" value="submit">Submit</button>
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
        <script src="<?= $baseURL . 'main/js/editSetup.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/controlMachine.js' ?>"></script>
        <script>
            $(function() {
                $('.select2').select2();
            })
        </script>
    </div>
</body>

</html>