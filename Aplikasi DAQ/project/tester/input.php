<?php
$baseURL = 'http://10.14.134.44/project/';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial</title>

    <!-- JQuery -->
    <script src="<?= $baseURL . 'assets/vendor_component/jquery/jquery-3.5.1.js' ?>" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/css/bootstrap.min.css' ?>" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.min.js' ?>" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js' ?>" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <div class="mt-3">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="font-weight-bold">Control Power Machine</h4>
                    <a href="./on_machine.php">
                        <button class="btn btn-success">Mesin ON</button>
                    </a>
                    <a href="./off_machine.php">
                        <button class="btn btn-danger">Mesin OFF</button>
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <h4 class="font-weight-bold">Set Jig</h4>
                    <a href="../database/micro/jig_and_nut.php?Set=Jig_A">
                        <button class="btn btn-success">JIG D01N</button>
                    </a>
                    <a href="../database/micro/jig_and_nut.php?Set=Jig_B">
                        <button class="btn btn-success">JIG D64G</button>
                    </a>
                    <a href="../database/micro/jig_and_nut.php?Set=Jig_C">
                        <button class="btn btn-success">JIG D13/D14</button>
                    </a>
                </div>
                <div class="col-sm-6">
                    <h4 class="font-weight-bold">Set Nut</h4>
                    <a href="../database/micro/jig_and_nut.php?Set=Nut_A">
                        <button class="btn btn-success">NUT D01N</button>
                    </a>
                    <a href="../database/micro/jig_and_nut.php?Set=Nut_B">
                        <button class="btn btn-success">NUT D64G</button>
                    </a>
                    <a href="../database/micro/jig_and_nut.php?Set=Nut_C">
                        <button class="btn btn-success">NUT D13/D14</button>
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <h4 class="font-weight-bold">Signal Part LH</h4>
                    <a href="../database/micro/seq_OK_3L.php?seq3-status=OK">
                        <button class="btn btn-success">Seq-3-OK</button>
                    </a>
                </div>
                <div class="col-sm-6">
                    <h4 class="font-weight-bold">Signal Part RH</h4>
                    <a href="../database/micro/seq_OK_3R.php?seq3-status=OK">
                        <button class="btn btn-success">Seq-3-OK</button>
                    </a>
                </div>
            </div>
        </div>
        <form class="mt-3" method="POST" action="./set_time.php">
            <h4 class="font-weight-bold">Set Value Of Time</h4>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Start Date</label>
                    <input type="date" class="form-control" id="start-date" name="start-date" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Start Time</label>
                    <input type="time" class="form-control" id="start-time" name="start-time" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Finish Date</label>
                    <input type="date" class="form-control" id="finish-date" name="finish-date" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Finish Time</label>
                    <input type="time" class="form-control" id="finish-time" name="finish-time" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Break 1 From</label>
                    <input type="time" class="form-control" id="break1-from" name="break1-from" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Break 1 To</label>
                    <input type="time" class="form-control" id="break1-to" name="break1-to" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Break 2 From</label>
                    <input type="time" class="form-control" id="break2-from" name="break2-from" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Break 2 To</label>
                    <input type="time" class="form-control" id="break2-to" name="break2-to" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Break 3 From</label>
                    <input type="time" class="form-control" id="break3-from" name="break3-from" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Break 3 To</label>
                    <input type="time" class="form-control" id="break3-to" name="break3-to" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

</body>

</html>