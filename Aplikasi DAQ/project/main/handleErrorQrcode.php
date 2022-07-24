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

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/datatables/css/jquery.dataTables.min.css' ?>">

    <!-- Datatables JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/datatables/js/jquery.dataTables.min.js' ?>"></script>

    <!-- My CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/handleErrorQrcode.css' ?>">

    <title>Manual Print Qr-code</title>
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
                    <h4 class="mx-auto c1 font-weight-bold text-center">
                        Manual Print Qr-code
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
        <div class="row">
            <div class="col-12">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Part Name</th>
                            <th>Datetime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="err-qrcode-table">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Part Name</th>
                            <th>Datetime</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Extension Javascript Program -->
    <div>
        <script src="<?= $baseURL . 'main/js/timer.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance2.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/print.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/err_print_qrcode.js' ?>"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
    </div>
</body>

</html>