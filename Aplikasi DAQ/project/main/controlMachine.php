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
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/controlMachine.css' ?>">

    <title>Control Machine</title>
    <?php include('../database/connection.php'); ?>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-white bg-dark">
        <h4 class="mx-auto c1 font-weight-bold">
            Tempelkan Kartu RFID untuk Merubah Status
        </h4>
    </nav>

    <!-- Content -->
    <div class="container d-flex">
        <div class="mx-auto" style="margin-top: 70px;">
            <div class="card bg-light text-dark">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold">Machine Status</h3>
                    <img id="img-status" class="text-center mt-2" style="margin-left: 50px;" src="" height="" width="" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="fixed-bottom">
        <div class="card-footer text-muted bg-dark h70">
            <div class="row">
                <div class="col-sm-3">
                    <a href="<?= $baseURL . 'database/web/controlMachine_db.php?action=No&from=' . $_GET['from'] ?>">
                        <button type="button" class="btn btn-danger btn-lg btn-block">Back</button>
                    </a>
                </div>
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

    <!-- Extension Javascript Program -->
    <div>
        <script src="<?= $baseURL . 'main/js/timer.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/print.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance2.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/controlMachine2.js' ?>"></script>
    </div>
</body>

</html>