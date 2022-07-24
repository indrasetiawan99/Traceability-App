<?php
$baseURL = 'http://10.14.134.44/project/';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- JQuery -->
    <script src="<?= $baseURL . 'assets/vendor_component/jquery/jquery-3.5.1.js' ?>" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/css/bootstrap.min.css' ?>" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.min.js' ?>" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/popper.min.js' ?>" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Content -->
    <div class="container-fluid">
        <div class="col">
            <h2 class="font-weight-bold">Part RH</h2>
            <div class="row">
                <div class="col-sm-5">
                    <label for="">Part Name: </label>
                    <h3 id="partname"></h3>
                </div>
                <div class="col-sm-2">
                    <label for="">Target: </label>
                    <h3 id="target"></h3>
                </div>
                <div class="col-sm-2">
                    <label for="">Status: </label>
                    <h3 id="status"></h3>
                </div>
                <div class="col-sm-3">
                    <label for="">Datetime: </label>
                    <h3 id="datetime"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <label for="">Cum. Target: </label>
                    <h1 id="cum_target"></h1>
                </div>
                <div class="col-sm-2">
                    <label for="">Cum. Actual: </label>
                    <h1 id="cum_actual"></h1>
                </div>
                <div class="col-sm-2">
                    <label for="">Rejection: </label>
                    <h1 id="rejection"></h1>
                </div>
                <div class="col-sm-3">
                    <label for="">Efficiency: </label>
                    <h1 id="efficiency"></h1>
                </div>
            </div>
        </div>
        <hr style="display:block; margin-top: 0.5em; margin-bottom: 0.5em; margin-left: auto; margin-right: auto; border-style: inset; border-width: 2px;">
        <div class="col">
            <h2 class="font-weight-bold">Part LH</h2>
            <div class="row">
                <div class="col-sm-5">
                    <label for="">Part Name: </label>
                    <h3 id="partname2"></h3>
                </div>
                <div class="col-sm-2">
                    <label for="">Target: </label>
                    <h3 id="target2"></h3>
                </div>
                <div class="col-sm-2">
                    <label for="">Status: </label>
                    <h3 id="status2"></h3>
                </div>
                <div class="col-sm-3">
                    <label for="">Datetime: </label>
                    <h3 id="datetime2"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <label for="">Cum. Target: </label>
                    <h1 id="cum_target2"></h1>
                </div>
                <div class="col-sm-2">
                    <label for="">Cum. Actual: </label>
                    <h1 id="cum_actual2"></h1>
                </div>
                <div class="col-sm-2">
                    <label for="">Rejection: </label>
                    <h1 id="rejection2"></h1>
                </div>
                <div class="col-sm-3">
                    <label for="">Efficiency: </label>
                    <h1 id="efficiency2"></h1>
                </div>
            </div>
        </div>
        <hr style="display:block; margin-top: 0.5em; margin-bottom: 0.5em; margin-left: auto; margin-right: auto; border-style: inset; border-width: 2px;">
        <div class="col">
            <h2 class="font-weight-bold">Machine</h2>
            <div class="row">
                <div class="col-sm-2">
                    <label for="">Downtime (Sec): </label>
                    <h1 id="downtime"></h1>
                </div>
                <div class="col-sm-2">
                    <label for="">Machine Status: </label>
                    <h1 id="machine_status"></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- The Javascript -->
    <script src="dashboard.js"></script>
</body>

</html>