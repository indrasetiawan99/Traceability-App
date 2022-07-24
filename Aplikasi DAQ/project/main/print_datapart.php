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
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/print_datapart.css' ?>">

    <title>Manual Print Datapart</title>
    <?php include('../database/connection.php'); ?>
</head>

<body>
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
                        Manual Print Datapart
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
    <div class="container d-flex">
        <!-- Set Scanner Mode -->
        <div>
            <?php
            $query1 = "UPDATE scanner_mode SET mode = 'Manual_Print_Datapart'";
            $mysqli->query($query1);
            ?>
        </div>

        <div class="mx-auto" style="margin-top: 70px;">
            <div class="card bg-white text-dark">
                <div class="card-body">
                    <h2 class="card-title font-weight-bold"> Scan QR-code </h2>
                    <img id="img-status" class="text-center mt-2" style="margin-left: 5px;" src="../assets/img/qr-code-scan.png" height="" width="200" alt="">
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
    </div>
</body>

</html>