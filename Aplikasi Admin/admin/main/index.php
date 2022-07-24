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

					<!-- Date Selection -->
					<div class="form-group row">
						<div class="col-4"></div>
						<label class="col-form-label col-1 text-right">Date</label>
						<div class="col-2">
							<input id="daily-report-date" class="form-control" type="date" name="date">
						</div>
						<div class="col-1">
							<button id="btn-daily-report" class="btn btn-light btn-block" style="margin-top: -4px;">View</button>
						</div>
					</div>

					<!-- Shift 1 -->
					<h2 class="my-20 text-dark">Shift 1</h2>
					<div class="row">

						<!-- OEE -->
						<div class="col-7">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">OEE</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="row oee-shift1">
										<div id="oee-s1" style="margin-top: 0px; margin-left: -150px; margin-bottom: 0px;"></div>
										<div style="margin-top: -240px; margin-left: 260px;">
											<div style="width: 300px; margin-top: 20px; margin-left: 0px;">
												<label for="">Availability ( <span id="lbl-availability-s1"></span>% )</label>
												<div class="progress" style="height: 12px;">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-availability-s1"></div>
												</div>
											</div>
											<div style="width: 300px; margin-top: 10px; margin-left: 0px;">
												<label for="">Performance ( <span id="lbl-performance-s1"></span>% )</label>
												<div class="progress" style="height: 12px;">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-performance-s1"></div>
												</div>
											</div>
											<div style="width: 300px; margin-top: 10px; margin-left: 0px;">
												<label for="">Quality ( <span id="lbl-quality-s1"></span>% )</label>
												<div class="progress" style="height: 12px;">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-quality-s1"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- Downtime -->
						<div class="col-5">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">Downtime</h4>
								</div>
								<h1 id="total-dnt-s1" class="font-weight-bold bg-secondary" style="margin-left: 345px; margin-right: 20px; margin-top: -60px; border-radius: 10px; padding: 4px 4px;">0'</h1>
								<!-- /.box-header -->
								<div class="box-body">
									<canvas id="downtime-s1" height="195"></canvas>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- Hourly Achievement -->
						<div class="col-7">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">Hourly Achievement</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<canvas id="achivement-s1" height="365"></canvas>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- NG Part -->
						<div class="col-5">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">NG Part</h4>
								</div>
								<h1 id="total-ng-s1" class="font-weight-bold bg-secondary" style="margin-left: 345px; margin-right: 20px; margin-top: -60px; border-radius: 10px; padding: 4px 4px;">0</h1>
								<!-- /.box-header -->
								<div class="box-body">
									<canvas id="ng-part-s1" height="272"></canvas>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- NG Part Description -->
						<div class="col-12">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">NG Part Description</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="table-responsive">
										<table id="rejection-shift1" class="table table-bordered table-striped" style="width:100%">
											<thead>
												<tr>
													<th style="width: 10px;">No</th>
													<th>Part Name</th>
													<th>QR-Code</th>
													<th>Category</th>
													<th>Datetime</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
											<tfoot>
												<tr>
													<th>No</th>
													<th>Part Name</th>
													<th>QR-Code</th>
													<th>Category</th>
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

						<!-- Downtime Description -->
						<div class="col-12">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">Downtime Description</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="table-responsive">
										<table id="downtime-shift1" class="table table-bordered table-striped" style="width:100%">
											<thead>
												<tr>
													<th style="width: 10px;">No</th>
													<th>Category</th>
													<th>User Started</th>
													<th>Start Downtime</th>
													<th>User Finished</th>
													<th>Finish Downtime</th>
													<th>Description</th>
													<th>Total Time</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
											<tfoot>
												<tr>
													<th>No</th>
													<th>Category</th>
													<th>User Started</th>
													<th>Start Downtime</th>
													<th>User Finished</th>
													<th>Finish Downtime</th>
													<th>Description</th>
													<th>Total Time</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
					</div>

					<!-- Shift 3 -->
					<h2 class="my-20 text-dark">Shift 3</h2>
					<div class="row">

						<!-- OEE -->
						<div class="col-7">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">OEE</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="row oee-shift1">
										<div id="oee-s3" style="margin-top: 0px; margin-left: -150px; margin-bottom: 0px;"></div>
										<div style="margin-top: -240px; margin-left: 260px;">
											<div style="width: 300px; margin-top: 20px; margin-left: 0px;">
												<label for="">Availability ( <span id="lbl-availability-s3"></span>% )</label>
												<div class="progress" style="height: 12px;">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-availability-s3"></div>
												</div>
											</div>
											<div style="width: 300px; margin-top: 10px; margin-left: 0px;">
												<label for="">Performance ( <span id="lbl-performance-s3"></span>% )</label>
												<div class="progress" style="height: 12px;">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-performance-s3"></div>
												</div>
											</div>
											<div style="width: 300px; margin-top: 10px; margin-left: 0px;">
												<label for="">Quality ( <span id="lbl-quality-s3"></span>% )</label>
												<div class="progress" style="height: 12px;">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-quality-s3"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- Downtime -->
						<div class="col-5">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">Downtime</h4>
								</div>
								<h1 id="total-dnt-s3" class="font-weight-bold bg-secondary" style="margin-left: 345px; margin-right: 20px; margin-top: -60px; border-radius: 10px; padding: 4px 4px;">0'</h1>
								<!-- /.box-header -->
								<div class="box-body">
									<canvas id="downtime-s3" height="195"></canvas>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- Hourly Achievement -->
						<div class="col-7">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">Hourly Achievement</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<canvas id="achivement-s3" height="365"></canvas>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- NG Part -->
						<div class="col-5">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">NG Part</h4>
								</div>
								<h1 id="total-ng-s3" class="font-weight-bold bg-secondary" style="margin-left: 345px; margin-right: 20px; margin-top: -60px; border-radius: 10px; padding: 4px 4px;">0</h1>
								<!-- /.box-header -->
								<div class="box-body">
									<canvas id="ng-part-s3" height="272"></canvas>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>

						<!-- NG Part Description -->
						<div class="col-12">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">NG Part Description</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="table-responsive">
										<table id="rejection-shift3" class="table table-bordered table-striped" style="width:100%">
											<thead>
												<tr>
													<th style="width: 10px;">No</th>
													<th>Part Name</th>
													<th>QR-Code</th>
													<th>Category</th>
													<th>Datetime</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
											<tfoot>
												<tr>
													<th>No</th>
													<th>Part Name</th>
													<th>QR-Code</th>
													<th>Category</th>
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

						<!-- Downtime Description -->
						<div class="col-12">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="box-title">Downtime Description</h4>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="table-responsive">
										<table id="downtime-shift3" class="table table-bordered table-striped" style="width:100%">
											<thead>
												<tr>
													<th style="width: 10px;">No</th>
													<th>Category</th>
													<th>User Started</th>
													<th>Start Downtime</th>
													<th>User Finished</th>
													<th>Finish Downtime</th>
													<th>Description</th>
													<th>Total Time</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
											<tfoot>
												<tr>
													<th>No</th>
													<th>Category</th>
													<th>User Started</th>
													<th>Start Downtime</th>
													<th>User Finished</th>
													<th>Finish Downtime</th>
													<th>Description</th>
													<th>Total Time</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
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
		<script src="../assets/vendor_components/datatable/datatables.min.js"></script>
		<script src="./js/pages/data-table.js"></script>
		<script src="../assets/vendor_components/sweetalert2/js/sweetalert2.all.min.js"></script>
		<script src="../assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
		<script src="../assets/vendor_components/chart.js-master/Chart.min.js"></script>
		<script src="../assets/vendor_components/jscharting/js/jscharting.js"></script>
		<script src="../assets/vendor_components/jscharting/js/modules/types.js"></script>

		<!-- Power BI Admin App -->
		<script src="js/template.js"></script>
		<script src="js/demo.js"></script>

		<!-- My JS -->
		<script src="./js/my_js/index.js"></script>
	</div>

</body>

</html>