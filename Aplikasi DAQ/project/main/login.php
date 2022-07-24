<?php
$baseURL = 'http://10.14.134.44/project/';
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

    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="../assets/vendor_component/sweetalert2/css/sweetalert2.min.css">

    <!-- Sweetalert2 JS -->
    <script src="../assets/vendor_component/sweetalert2/js/sweetalert2.all.min.js"></script>

    <!-- My CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'main/css/login.css' ?>">

    <title>Login</title>

    <?php include('../database/connection.php'); ?>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-white bg-dark">
        <a class="navbar-brand" href="#">
            <div class="col">
                <div class="row">
                    <img src="<?= $baseURL . 'assets/img/logo-api-panjang.png'; ?>" width="" height="40" alt="">
                </div>
            </div>
        </a>

        <div class="col">
            <div class="row">
                <span class="ml-auto" id="jam" style="color: #d7d7d7; font-weight: bold;"></span>
            </div>
            <div class="row">
                <span class="ml-auto" id="tanggal" style="color: #d7d7d7; font-weight: bold;"></span>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <!-- Set Scanner Mode -->
        <div>
            <?php
            $query1 = "UPDATE scanner_mode SET mode = 'Normal'";
            $mysqli->query($query1);
            ?>
        </div>

        <div class="row">
            <div class="col">
                <center>
                    <div class="mt-5" id="formContent">
                        <!-- Tabs Titles -->

                        <!-- Icon -->
                        <div class="">
                            <h2>Login</h2>
                            <hr style="width:50%;text-align:center;">
                        </div>

                        <!-- Login Form -->
                        <!-- <form id="login-form" name="login-form" method="POST" action="../database/web/login_db.php"> -->
                        <input type="text" id="username" name="username" placeholder="username" required>
                        <input type="password" id="password" name="password" placeholder="password" required>
                        <input type="submit" id="btn-submit" name="submit" value="submit">
                        <!-- </form> -->
                    </div>
                </center>
            </div>
        </div>
    </div>

    <!-- Extension Javascript Program -->
    <div>
        <script src="<?= $baseURL . 'main/js/timer.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/performance2.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/print.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/login.js' ?>"></script>
        <script src="<?= $baseURL . 'main/js/readRfid.js' ?>"></script>
    </div>
</body>

</html>