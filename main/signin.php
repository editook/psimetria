<?php
	include_once('configs.php');

	session_start();
	include('connection.php');
	include("models/model_user.php");

	if( isset($_POST['user']) && isset($_POST['password']) )
	{
		$userModel = new User_Model();
		//$user = $userModel->updatePassword('1', 'admin');
		$user = $userModel->getValidatedByLoginByPassword($_POST['user'], $_POST['password']);
		//echo json_encode($user);
		//exit;
		if( $user != null ){
			$_SESSION['REST_id_user']   = $user['id'];
        	$_SESSION['REST_type_user'] = $user['type_user'];
			$_SESSION['REST_name_user'] = $user['full_name'];
			if($user['type_user'] == 'Administrador'){
				header("Location: ".LOCALHOST."/view/index.php");
			}
			if($user['type_user'] == 'CLIENTE'){
				header("Location: ".LOCALHOST."/view/register.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

		<!-- Title -->
		<title><?=WEB_TITLE?></title>

		<!-- Favicon -->
		<link rel="icon" href="../assets/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="../assets/css/icons.css" rel="stylesheet">

		<!-- Bootstrap css -->
		<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!--  Right-sidemenu css -->
		<link href="../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!--  Custom Scroll bar-->
		<link href="../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- Style css --->
		<link href="../assets/css/style.css" rel="stylesheet">
		<link href="../assets/css/boxed.css" rel="stylesheet">
		<link href="../assets/css/dark-boxed.css" rel="stylesheet">

		<!--- Dark-mode css --->
		<link href="../assets/css/style-dark.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="../assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="../assets/css/animate.css" rel="stylesheet">

	</head>
	<body class="error-page1 main-body bg-light text-dark">

		<!-- Loader -->
		<div id="global-loader">
			<img src="../assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div class="container-fluid">
				<div class="row no-gutter">
					<!-- The image half -->
					<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
						<div class="row wd-100p mx-auto text-center">
							<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
								<img src="../assets/img/brand/favicon.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
							</div>
						</div>
					</div>
					<!-- The content half -->
					<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
						<div class="login d-flex align-items-center py-2">
							<!-- Demo content-->
							<div class="container p-0">
								<div class="row">
									<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
										<div class="card-sigin">
											
											<div class="card-sigin">
												<div class="main-signup-header">
													<h2>Bienvenido!</h2>
													<h5 class="fw-semibold mb-4">Por favor inicia sesión para continuar.</h5>
													<form action="signin.php" method="post">
														<div class="form-group">
															<label>Usuario</label> <input name="user" class="form-control" placeholder="Ingresa tu usuario" type="text">
														</div>
														<div class="form-group">
															<label>Contraseña</label> <input name="password" class="form-control" placeholder="Ingresa tu contraseña" type="password">
														</div><button class="btn btn-main-primary btn-block">Iniciar sesión
														</button>
													</form>
													<div class="main-signin-footer mt-5">
														<p><a href="#">¿Has olvidado tu contraseña?</a></p>
														<p>Contactarse con el administrador <a target="_bank" href="https://api.whatsapp.com/send?phone=59168525271">+591 68525271 </a></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- End -->
						</div>
					</div><!-- End -->
				</div>
			</div>

		</div>
		<!-- End Page -->

		<!-- JQuery min js -->
		<script src="../assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Ionicons js -->
		<script src="../assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="../assets/plugins/moment/moment.js"></script>

		<!-- P-scroll js -->
		<script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

		<!-- eva-icons js -->
		<script src="../assets/js/eva-icons.min.js"></script>

		<!-- Rating js-->
		<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../assets/plugins/rating/jquery.barrating.js"></script>

		<!-- Custom Scroll bar Js-->
		<script src="../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- custom js -->
		<script src="../assets/js/custom.js"></script>

	</body>
</html>