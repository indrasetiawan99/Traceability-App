<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Traceability QR-code | Dashboard</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../assets/vendor_component/bootstrap-4.6.0-dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<body style="background-color: #6C756B;">

	<!-- Navbar -->
	<nav class="navbar" style="background-color: #F2F4FF;">
		<div class="row">
			<a class="" href="#">
				<img src="../assets/img/logo-api-panjang.png" width="" height="43" alt="" style="margin-top: 5px; margin-left:30px; margin-bottom:5px;">
			</a>
			<h4 class="font-weight-bold" style="margin-top: 5px; margin-left: 310px; margin-right: 205px; font-size: 33px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">EMBEDDING</h4>
			<div style="margin-left: 18px; margin-top: 2px;">
				<div class="row">
					<h6 id="day-name" class="font-weight-bold" style="margin-top: 0px; margin-left: 0px;"></h6>
				</div>
				<div class="row">
					<hr style="margin-top: -4px; margin-left: 0px; margin-right: 0px; border-top: 3px solid black; width: 250px;">
				</div>
				<div class="row">
					<h6 id="date-now" class="font-weight-bold" style="margin-top: -15px; margin-left: 0px; margin-right: 0px;"></h6>
				</div>
				<h4 class="font-weight-bold" style="margin-top: -52px; margin-left: 240px; margin-right: 0px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size:32px;"><span id="hours-now"></span>:<span id="minutes-now"></span></h4>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<div class="container-fluid" style="background-color: #6C756B;">
		<div class="row mt-2">
			<!-- Part LH -->
			<div class="col-sm-6">
				<div class="card" style="background-color: #93ACB5;">
					<div class="card-body">
						<div class="card-title">
							<h4>
								<span style="background-color: #F2F4FF; padding: 4px 10px; border-radius: 10px; font-weight: bolder">LH</span>
								<span style="background-color: #F2F4FF; padding: 4px 10px; font-size: 1em; border-radius: 10px; font-weight: bold">
									<marquee style="position: relative; top:-2px; min-width: 87%; max-width: 87%;" behavior="scroll" scrollamount="2">
										<span id="part-name-LH" style="display: inline-block"></span>
									</marquee>
								</span>
							</h4>
						</div>
					</div>
					<div class="" style="margin-left: 20px; margin-right: 20px;">
						<div class="row">
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">Target</p>
							</div>
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">Cum. Target</p>
							</div>
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">OK</p>
							</div>
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">NG</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<p id="target-LH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
							<div class="col-sm-3">
								<p id="cum-target-LH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
							<div class="col-sm-3">
								<p id="part-OK-LH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
							<div class="col-sm-3">
								<p id="part-NG-LH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Part RH -->
			<div class="col-sm-6">
				<div class="card" style="background-color: #93ACB5;">
					<div class="card-body">
						<div class="card-title">
							<h4>
								<span style="background-color: #F2F4FF; padding: 4px 10px; border-radius: 10px; font-weight: bolder">RH</span>
								<span style="background-color: #F2F4FF; padding: 4px 10px; font-size: 1em; border-radius: 10px; font-weight: bold">
									<marquee style="position: relative; top:-2px; min-width: 86%; max-width: 86%;" behavior="scroll" scrollamount="2">
										<span id="part-name-RH" style="display: inline-block"></span>
									</marquee>
								</span>
							</h4>
						</div>
					</div>
					<div class="" style="margin-left: 20px; margin-right: 20px;">
						<div class="row">
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">Target</p>
							</div>
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">Cum. Target</p>
							</div>
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">OK</p>
							</div>
							<div class="col-sm-3">
								<p class="text-center font-weight-bold" style="font-size: 20px; border-radius: 10px; color: #F2F4FF;">NG</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<p id="target-RH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
							<div class="col-sm-3">
								<p id="cum-target-RH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
							<div class="col-sm-3">
								<p id="part-OK-RH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
							<div class="col-sm-3">
								<p id="part-NG-RH" class="text-center font-weight-bold" style="font-size: 40px; background-color: #F2F4FF; border-radius: 10px;"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<!-- OEE -->
			<div class="col-sm-8">
				<div class="card h-100" style="background-color: #93ACB5;">
					<div class="card-body">
						<div class="card-title">
							<h4 class="font-weight-bold" style="color: #F2F4FF;">Overall Equipment Effectiveness (OEE)</h4>
						</div>
						<div class="row" style="position: fixed;">
							<div id="oee-chart" style="margin-top: -20px; margin-left: 20px; margin-bottom: -49px;"></div>
							<div style="margin-top: 0px; margin-left: -50px;">
								<div style="width: 400px; margin-top: 20px; margin-left: 0px;">
									<label for="">Availability ( <span id="lbl-availability"></span>% )</label>
									<div class="progress" style="height: 12px;">
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-availability"></div>
									</div>
								</div>
								<div style="width: 400px; margin-top: 10px; margin-left: 0px;">
									<label for="">Performance ( <span id="lbl-performance"></span>% )</label>
									<div class="progress" style="height: 12px;">
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-performance"></div>
									</div>
								</div>
								<div style="width: 400px; margin-top: 10px; margin-left: 0px;">
									<label for="">Quality ( <span id="lbl-quality"></span>% )</label>
									<div class="progress" style="height: 12px;">
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 70%" id="chart-quality"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Line Stop -->
			<div class="col-sm-4">
				<div class="card" style="background-color: #93ACB5;">
					<div class="card-body">
						<div class="card-title">
							<div class="row">
								<h4 class="font-weight-bold" id="title-line-stop" style="margin-left: 15px; color: #F2F4FF;">Line Stop</h4>
								<h1 id="total-line-stop" class="font-weight-bold" style="margin-left: 170px; border-radius: 10px; color: black; background-color: #F2F4FF; padding: 4px 15px;"></h1>
							</div>
						</div>
						<div class="row">
							<canvas id="line-stop" height="115"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class="fixed-bottom">
		<div class="card-footer text-muted" style="background-color: #F2F4FF;">
			<div class="row">
				<div class="col-12">
					<!-- <div class="col-10" style="border-radius: 10px; background-color: #93ACB5;"> -->
					<marquee behavior="scroll" scrollamount="6" style="margin-top: 4px; color: black; font-weight:bold;">
						<h5>Operator: <span id="operator-name-npk"></span> | Planning Start: <span id="planning-start"></span> | Planning Finish: <span id="planning-finish"></span> | Customer Name: <span id="cust-name"></span> | Machine Status: <span id="machine-status"></span></h5>
					</marquee>
				</div>
			</div>
		</div>
	</footer>

	<!-- Extension Javascript Program -->
	<div>
		<!-- JQuery -->
		<script src="../assets/vendor_component/jquery/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

		<!-- Bootstrap JS -->
		<script src="../assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>

		<!-- Apex Chart -->
		<script src="../assets/vendor_component/apexcharts-bundle/dist/apexcharts.js"></script>

		<!-- Chart JS -->
		<script src="../assets/vendor_component/chart.js-master/Chart.min.js"></script>

		<!-- My JS -->
		<script src="./js/dashboard.js"></script>
	</div>

</body>

</html>