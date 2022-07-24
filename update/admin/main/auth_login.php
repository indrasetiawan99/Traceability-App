<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Admin Traceability - Log in </title>

	<!-- Vendors Style-->
	<link rel="stylesheet" href="css/vendors_css.css">

	<!-- Style-->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/skin_color.css">
	<link rel="stylesheet" href="../assets/vendor_components/sweetalert2/css/sweetalert2.min.css">

</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(../images/auth-bg/bg-2.jpg)">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center no-gutters">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded30 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">Login</h2>
								<p class="mb-0">Aplikasi Admin Traceability</p>
							</div>
							<div class="p-40">
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
										</div>
										<input id="username" name="username" type="text" class="form-control pl-15 bg-transparent" placeholder="Username">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
										</div>
										<input id="password" name="password" type="password" class="form-control pl-15 bg-transparent" placeholder="Password">
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-center">
										<button id="btn-submit" type="submit" class="btn btn-danger mt-10">SIGN IN</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
	<script src="js/vendors.min.js"></script>
	<script src="../assets/icons/feather-icons/feather.min.js"></script>
	<script src="../assets/vendor_components/sweetalert2/js/sweetalert2.all.min.js"></script>

	<!-- My JS -->
	<script src="js/my_js/login.js"></script>
</body>

</html>