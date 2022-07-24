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

                    <!-- Tracing QR-code -->
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <h4 class="box-title col-2 text-right" style="margin-top: 5px;">QR-code</h4>
                                    <div class="col-6">
                                        <input class="form-control" type="text" id="src-qrcode" name="src-qrcode">
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-light" id="btn-src-qrcode" style="margin-top: -4px;">Search</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Data Part Code</label>
                                            <input type="text" class="form-control" id="tr-qr-datapart-code" name="tr-qr-datapart-code" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">Sequence Number</label>
                                            <input type="text" class="form-control" id="tr-qr-seq-num" name="tr-qr-seq-num" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">Datetime</label>
                                            <input type="text" class="form-control" id="tr-qr-datetime" name="tr-qr-datetime" readonly>
                                        </div>
                                    </div>

                                    <h5 class="box-title mt-30">Data Operator</h5>
                                    <div class="row">
                                        <div class="col-2">
                                            <label for="">NPK</label>
                                            <input type="text" class="form-control" id="tr-qr-npk" name="tr-qr-npk" readonly>
                                        </div>
                                        <div class="col-8">
                                            <label for="">Name</label>
                                            <input type="text" class="form-control" id="tr-qr-name" name="tr-qr-name" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label for="">Operator Skill</label>
                                            <input type="text" class="form-control" id="tr-qr-skill" name="tr-qr-skill" readonly>
                                        </div>
                                    </div>

                                    <h5 class="box-title mt-30">Data Part</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Part Name</label>
                                            <input type="text" class="form-control" id="tr-qr-partname" name="tr-qr-partname" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">SKU</label>
                                            <input type="text" class="form-control" id="tr-qr-sku" name="tr-qr-sku" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">Customer</label>
                                            <input type="text" class="form-control" id="tr-qr-customer" name="tr-qr-customer" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <label for="">Part Number API</label>
                                            <input type="text" class="form-control" id="tr-qr-pn-api" name="tr-qr-pn-api" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="">Part Number Customer</label>
                                            <input type="text" class="form-control" id="tr-qr-pn-cust" name="tr-qr-pn-cust" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <label for="">Packaging</label>
                                            <input type="text" class="form-control" id="tr-qr-pack" name="tr-qr-pack" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control" id="tr-qr-address" name="tr-qr-address" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">Job Number</label>
                                            <input type="text" class="form-control" id="tr-qr-job-num" name="tr-qr-job-num" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="">Time Production</label>
                                            <input type="text" class="form-control" id="tr-qr-time-prod" name="tr-qr-time-prod" readonly>
                                        </div>
                                    </div>

                                    <h5 class="box-title mt-30">Quality</h5>
                                    <div class="row">
                                        <div class="col-1">
                                            <label for="">Status</label>
                                            <input type="text" class="form-control" id="tr-qr-status" name="tr-qr-status" readonly>
                                        </div>
                                        <div class="col-11">
                                            <label for="">Description</label>
                                            <input type="text" class="form-control" id="tr-qr-desc" name="tr-qr-desc" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>

                    <!-- Tracing Data Part Code -->
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <h4 class="box-title col-2 text-right" style="margin-top: 5px;">Data Part Code</h4>
                                    <div class="col-6">
                                        <input class="form-control" type="text" id="src-datapart" name="src-datapart">
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-light" id="btn-src-datapart" style="margin-top: -4px;">Search</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="tr_quick" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;">No</th>
                                                <th class="text-center">QR-code</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-datapart-code">
                                        </tbody>
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
        <script src="./js/my_js/quick_trace.js"></script>
    </div>

</body>

</html>