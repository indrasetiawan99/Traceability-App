<?php
session_start();
if (!isset($_SESSION['data-login'])) {
    header('Location: auth_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Traceability</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skin_color.css">
    <link rel="stylesheet" href="../assets/vendor_components/sweetalert2/css/sweetalert2.min.css">
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
        <div id="loader"></div>

        <!-- Header -->
        <?php
        include('./layout/main_header.php');
        ?>

        <!-- Sidebar -->
        <?php
        include('./layout/side_bar.php');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">

                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Registrasi User</h4>
                            </div>
                            <div class="box-body">
                                <form id="registrasi-user" method="POST" action="">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-form-label col-md-2">NPK</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="npk" name="npk" minlength="4" maxlength="4" placeholder="e.g. 0000" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">Full Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="full-name" name="full-name" placeholder="e.g. Andi Setiawan" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">Short Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="short-name" name="short-name" placeholder="e.g. Andi" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">User Group</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="user-group" name="user-group" placeholder="e.g. Supervisor" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">Operator Skill</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" id="op-skill" name="op-skill" min="0" max="100" placeholder="e.g. 0" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">User Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="user-name" name="user-name" placeholder="e.g. 0000_Andi" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">Password</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="password" name="password" placeholder="e.g. Andi_0000" required>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <label class="col-form-label col-md-2">RFID Tag</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="rfid-tag" name="rfid-tag" placeholder="e.g. 5914868178">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mt-4">
                                        <button id="btn-submit" name="btn-submit" form="registrasi-user" class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- /.content -->
            </div>
        </div>

        <!-- Footer -->
        <?php
        include('./layout/footer.php');
        ?>

    </div>
    <!-- ./wrapper -->

    <!-- Extension Javascript Program -->
    <div>
        <!-- Vendor JS -->
        <script src="js/vendors.min.js"></script>
        <script src="../assets/icons/feather-icons/feather.min.js"></script>
        <script src="../assets/vendor_components/sweetalert2/js/sweetalert2.all.min.js"></script>

        <!-- Power BI Admin App -->
        <script src="js/template.js"></script>
        <script src="js/demo.js"></script>

        <!-- My JS -->
        <script src="./js/my_js/registrasi.js"></script>
    </div>

</body>

</html>