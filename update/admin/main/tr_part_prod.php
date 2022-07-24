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
                                <h4 class="box-title">Data Part Production</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="tr_part_prod" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>QR-code</th>
                                                <th>Data Part</th>
                                                <th>Part Name</th>
                                                <th>Operator Name</th>
                                                <th>Seq 1</th>
                                                <th>Seq 2</th>
                                                <th>Seq 3</th>
                                                <th>Seq 4</th>
                                                <th>Status</th>
                                                <th>Datetime</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query1 = "SELECT * FROM part_production ORDER BY id DESC";
                                            $result1 = $mysqli->query($query1);

                                            $i = 1;
                                            foreach ($result1 as $row1) {
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $row1['qrcode']; ?></td>
                                                    <td><?= $row1['datapart']; ?></td>
                                                    <td><?= $row1['part_name']; ?></td>
                                                    <td><?= $row1['op_name']; ?></td>
                                                    <td><?= $row1['seq1_status']; ?></td>
                                                    <td><?= $row1['seq2_status']; ?></td>
                                                    <td><?= $row1['seq3_status']; ?></td>
                                                    <td><?= $row1['seq4_status']; ?></td>
                                                    <td><?= $row1['status']; ?></td>
                                                    <td><?= $row1['date_time']; ?></td>
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            $result1->close();
                                            $mysqli->close();
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>QR-code</th>
                                                <th>Data Part</th>
                                                <th>Part Name</th>
                                                <th>Operator Name</th>
                                                <th>Seq 1</th>
                                                <th>Seq 2</th>
                                                <th>Seq 3</th>
                                                <th>Seq 4</th>
                                                <th>Status</th>
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