<?php
$baseURL = 'http://10.14.134.44/project/';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JQuery -->
    <script src="../assets/vendor_component/jquery/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor_component/bootstrap-4.6.0-dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="../assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Multiselect CSS -->
    <link rel="stylesheet" href="../assets/vendor_component/bootstrap-multiselect/css/bootstrap-multiselect.css">

    <!-- Bootstrap Multiselect JS -->
    <script src="../assets/vendor_component/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>

    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="../assets/vendor_component/sweetalert2/css/sweetalert2.min.css">

    <!-- Sweetalert2 JS -->
    <script src="../assets/vendor_component/sweetalert2/js/sweetalert2.all.min.js"></script>

    <title>Tester</title>
</head>

<body>
    <!-- Content -->
    <div class="container mt-4">
        <div class="col">
            <button class="btn btn-primary" data-toggle="modal" data-target="#timer-modal" onclick="start()">Timer</button>
        </div>
    </div>

    <!-- The Modal 3 : Remaining Part Control-->
    <div class="modal" id="timer-modal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Timer</h3>
                    <button type="button" class="close" data-dismiss="modal" onclick="reset()">×</button>
                </div>

                <!-- Modal body -->
                <div class="container-fluid modal-body">
                    <div class="text-center">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="pause()">Stop</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Exstension Javascript Program -->
    <script src="./test.js"></script>

</body>

</html>