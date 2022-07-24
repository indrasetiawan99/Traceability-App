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

    <?php include('../database/connection.php'); ?>
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
                                <h4 class="box-title">Data Rejection</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="tr_rejection" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px;">No</th>
                                                <th>Part Name</th>
                                                <th>QR-code</th>
                                                <th>Category</th>
                                                <th>Datetime</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ng_category = array('Crack', 'Dimensi', 'Ejector Mark', 'Short Shoot', 'Wide Line', 'Kontaminasi', 'Buble', 'Flow Mark', 'Bending', 'Sink Mark', 'Burn Mark', 'Scratch', 'Silver', 'Blackspot', 'Gloss', 'Mutih', 'Minyak', 'Jetting', 'Over Cut', 'Burry', 'Check Of', 'Colour (Visual)', 'Setting', 'Lain-lain');
                                            $field_category = array('crack', 'dimensi', 'ejector_mark', 'short_shoot', 'wide_line', 'kontaminasi', 'buble', 'flow_mark', 'bending', 'sink_mark', 'burn_mark', 'scratch', 'silver', 'blackspot', 'gloss', 'mutih', 'minyak', 'jetting', 'over_cut', 'burry', 'check_of', 'colour', 'setting');
                                            $str_ng_category = '';

                                            $query1 = "SELECT * FROM rejection ORDER BY id DESC";
                                            $result1 = $mysqli->query($query1);

                                            $n = 1;
                                            foreach ($result1 as $row1) {
                                                for ($i = 0; $i < 23; $i++) {
                                                    if ($row1[$field_category[$i]] == 'Yes') {
                                                        if ($str_ng_category == '') {
                                                            $str_ng_category .=  $ng_category[$i];
                                                        } else {
                                                            $str_ng_category .=  ', ' . $ng_category[$i];
                                                        }
                                                    }
                                                }
                                                if ($row1['lain_lain'] != NULL) {
                                                    $str_ng_category .=  'Lain-lain';
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $n; ?></td>
                                                    <td><?= $row1['part_name']; ?></td>
                                                    <td><?= $row1['qrcode']; ?></td>
                                                    <td><?= $str_ng_category; ?></td>
                                                    <td><?= $row1['date_time']; ?></td>
                                                </tr>
                                            <?php
                                                $n++;
                                                $str_ng_category = '';
                                            }
                                            $result1->close();
                                            $mysqli->close();
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Part Name</th>
                                                <th>Category</th>
                                                <th>QR-code</th>
                                                <th>Datetime</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
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
        <script src="../assets/vendor_components/datatable/datatables.min.js"></script>
        <script src="./js/pages/data-table.js"></script>
        <script src="../assets/vendor_components/sweetalert2/js/sweetalert2.all.min.js"></script>

        <!-- Power BI Admin App -->
        <script src="js/template.js"></script>
        <script src="js/demo.js"></script>

        <!-- My JS -->
        <script src=""></script>
    </div>

</body>

</html>