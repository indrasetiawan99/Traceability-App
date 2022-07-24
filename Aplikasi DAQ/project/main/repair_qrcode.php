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

    <!-- Bootstrap JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js' ?>"></script>

    <!-- My CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/repair_qrcode.css' ?>">

    <title>Repair QR-code</title>
    <?php include('../database/connection.php'); ?>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-white bg-dark">
        <div class="col">
            <div class="row">
                <div class="col-sm-2">
                    <a href="<?= $baseURL . 'main/operator.php'; ?>">
                        <button type="button" class="btn btn-danger btn-lg btn-block">Back</button>
                    </a>
                </div>
                <div class="col-sm-8 mt-2">
                    <h4 class="mx-auto font-weight-bold text-center c1">
                        Repair QR-code
                    </h4>
                </div>
                <div class="col-sm-2">
                    <div class="row">
                        <span class="ml-auto font-weight-bold c1" id="jam"></span>
                    </div>
                    <div class="row">
                        <span class="ml-auto font-weight-bold c1" id="tanggal"></span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid mt-3">
        <div class="col">
            <div class="row">
                <div class="col-sm-6">
                    <input type="radio" class="radioMode" name="radioMode" value="Step1_Repair_Qrcode" id="mode1" checked>
                    <label for="mode1" class="font-weight-bold radio">Scan Datapart (Step 1)</label>
                </div>
                <div class="col-sm-6">
                    <input type="radio" class="radioMode" name="radioMode" value="Step2_Repair_Qrcode" id="mode2">
                    <label for="mode2" class="font-weight-bold radio">Scan QR-code (Step 2)</label>
                </div>
            </div>
            <!-- <div class="row"> -->
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Part Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="part-name-repair" readonly>
                </div>
                <div class="col-sm-2">
                    <a href="../database/web/repair_qrcode_db2.php?action=Print">
                        <button class="btn btn-success btn-block">Print</button>
                    </a>
                </div>
            </div>
            <!-- </div> -->
            <div class="row">
                <table class="table-secondary w705">
                    <thead class="text-center font-weight-bold">
                        <tr>
                            <td class="w50">#</td>
                            <td>QR-code Part</td>
                            <td class="w20"></td>
                        </tr>
                    </thead>
                </table>

                <div class="table-responsive mt-1 h250 w705">
                    <table class="table table-bordered">
                        <div>
                            <tbody class="text-center" id="repair_qrcode">
                                <?php for ($n = 0; $n < 5; $n++) { ?>
                                    <tr>
                                        <td class="align-middle w50">-</td>
                                        <td class="align-middle">-</td>
                                        <td class="align-middle w120">-</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </div>
                    </table>
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
        <script src="<?= $baseURL . 'main/js/scannerMode.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/repair_qrcode.js' ?>"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
    </div>
</body>

</html>