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
                                <h4 class="box-title">Master Data Breaktime</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="db_master_breaktime" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Day</th>
                                                <th>Desc.</th>
                                                <th>S1 Break 1 From</th>
                                                <th>S1 Break 1 To</th>
                                                <th>S1 Break 2 From</th>
                                                <th>S1 Break 2 To</th>
                                                <th>S2 Break 1 From</th>
                                                <th>S2 Break 1 To</th>
                                                <th>S2 Break 2 From</th>
                                                <th>S2 Break 2 To</th>
                                                <th>S3 Break 1 From</th>
                                                <th>S3 Break 1 To</th>
                                                <th>S3 Break 2 From</th>
                                                <th>S3 Break 2 To</th>
                                                <th>S3 Break OT From</th>
                                                <th>S3 Break OT To</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query1 = "SELECT * FROM master_breaktime";
                                            $result1 = $mysqli->query($query1);

                                            $i = 1;
                                            foreach ($result1 as $row1) {
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $row1['break_name']; ?></td>
                                                    <td><?= $row1['description']; ?></td>
                                                    <td><?= $row1['s1_break1_from']; ?></td>
                                                    <td><?= $row1['s1_break1_to']; ?></td>
                                                    <td><?= $row1['s1_break2_from']; ?></td>
                                                    <td><?= $row1['s1_break2_to']; ?></td>
                                                    <td><?= $row1['s2_break1_from']; ?></td>
                                                    <td><?= $row1['s2_break1_to']; ?></td>
                                                    <td><?= $row1['s2_break2_from']; ?></td>
                                                    <td><?= $row1['s2_break2_to']; ?></td>
                                                    <td><?= $row1['s3_break1_from']; ?></td>
                                                    <td><?= $row1['s3_break1_to']; ?></td>
                                                    <td><?= $row1['s3_break2_from']; ?></td>
                                                    <td><?= $row1['s3_break2_to']; ?></td>
                                                    <td><?= $row1['s3_break_OT_from']; ?></td>
                                                    <td><?= $row1['s3_break_OT_to']; ?></td>
                                                    <td><?= $row1['status']; ?></td>
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
                                                <th>Day</th>
                                                <th>Desc.</th>
                                                <th>S1 Break 1 From</th>
                                                <th>S1 Break 1 To</th>
                                                <th>S1 Break 2 From</th>
                                                <th>S1 Break 2 To</th>
                                                <th>S2 Break 1 From</th>
                                                <th>S2 Break 1 To</th>
                                                <th>S2 Break 2 From</th>
                                                <th>S2 Break 2 To</th>
                                                <th>S3 Break 1 From</th>
                                                <th>S3 Break 1 To</th>
                                                <th>S3 Break 2 From</th>
                                                <th>S3 Break 2 To</th>
                                                <th>S3 Break OT From</th>
                                                <th>S3 Break OT To</th>
                                                <th>Status</th>
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