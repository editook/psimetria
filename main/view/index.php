<?php
	include_once('../configs.php');

	session_start();
	include('../connection.php');
	include("../models/model_user.php");
	include("../models/model_register.php");
	include("../models/model_answer.php");
	include("../models/model_baremo.php");
	$userModel = new User_Model();
	if(!isset($_SESSION['REST_type_user'])){
		header("Location: ".LOCALHOST."/signin.php");
	}
	if($_SESSION['REST_type_user'] == "CLIENTE"){
		header("Location: ".LOCALHOST."/view/register.php");//?client=".$_SESSION['REST_id_user']
	}
	if( isset($_POST['full_name']) && isset($_POST['name_user']) && isset($_POST['password'])){
		//echo $_POST['iduser'].' '.$_POST['full_name'].' '.$_POST['name_user'].' '.$_POST['active'].' '.$_POST['password'];
		
		if(isset($_POST['iduser']) && $_POST['iduser'] != ''){
			$data = $userModel->update($_POST['iduser'],$_POST['full_name'],$_POST['name_user'],$_POST['active']);
			
			$password = $_POST['password'];
			if($password != "*****"){
				$data = $userModel->updatePassword($_POST['iduser'],$password);
			}
		}
		else{
			$data = $userModel->save($_POST['full_name'],$_POST['name_user'],$_POST['password']);
		}
		if($data !== false){
			header("Location: ".LOCALHOST."/view/index.php");
		}
	}
	if(isset($_POST['id_user_remove'])){
		$data = $userModel->delete($_POST['id_user_remove']);

		if($data !== false){
			header("Location: ".LOCALHOST."/view/index.php");
		}
	}

	
	$users = $userModel->getAllByType('CLIENTE');
	foreach ($users as &$user) {
		$dateTime = new DateTime($user['date_create']);
		$user['date_create'] =  $dateTime->format('d/m/Y');
	}
	unset($user);
	$resultado_clients = [];
	$count_users =0;
	if(count($users)>0){
		$fechaReferencia = DateTime::createFromFormat('d/m/Y', $users[0]['date_create']);
		$resultado_clients = [1]; // El primer valor siempre es 1

		// Procesar las fechas restantes
		$count_users =1;
		for ($i = 1; $i < count($users); $i++) {
			if($users[$i]['active'] == '1'){
				$fechaActual = DateTime::createFromFormat('d/m/Y', $users[$i]['date_create']);
				$diferencia = $fechaReferencia->diff($fechaActual);
				$count_users++;
				// Obtener la diferencia en días y sumar 1 (porque empezamos desde 1)
				$diasDiferencia = $diferencia->days + 1;
				$resultado_clients[] = $diasDiferencia;
			}
			
		}
	}
	

	$clients_view = implode(",", $resultado_clients);

	$answerModel = new Answer_Model();
	$answers = $answerModel->getAll();
	$registerModel = new Register_Model();

	$baremoModel = new Baremo_Model();
	$baremos = $baremoModel->getAll();
	$total_baremos = 0;
	$total_baremos_all = count($baremos);
	foreach ($baremos as $baremo) {
		if($baremo['active'] == '1'){
			$total_baremos++;
		}
	}

	$total_completed = $registerModel->getTotalCompleted('','TERMINADO');
	$total_pending = $registerModel->getTotalCompleted('','PENDIENTE');

	$totalTest = $total_completed['total'] + $total_pending['total'];
	$total_porcentaje_test = 0;
	if($totalTest > 0){
		$total_porcentaje_test = ($total_completed['total'] / $totalTest) * 100;
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
		<title><?=LOCALHOST?></title>

		<!-- Favicon -->
		<link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="../../assets/css/icons.css" rel="stylesheet">

		<!-- Bootstrap css -->
		<link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!--  Custom Scroll bar-->
		<link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--  Sidebar css -->
		<link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!--- Internal Morris css-->
		<link href="../../assets/plugins/morris.js/morris.css" rel="stylesheet">

		<!--- Style css --->
		<link href="../../assets/css/style.css" rel="stylesheet">
		<link href="../../assets/css/boxed.css" rel="stylesheet">
		<link href="../../assets/css/dark-boxed.css" rel="stylesheet">

		<!--- Dark-mode css --->
		<link href="../../assets/css/style-dark.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="../../assets/css/skin-modes.css" rel="stylesheet" />
		<style>
			@media (max-width: 768px) {
				.containermobile {
					margin-top:50px;
				}
				.icons-list{
					flex-wrap: nowrap;
				}
				.icons-list-item{
					height: auto;
    				width: auto;
				}
			}
		</style>
	</head>

	<body class="main-body">

		<!-- Loader -->
		<div id="global-loader">
			<img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<!-- main-header opened -->
			<?php include("../include/header_top.php");?>
			<!-- /main-header -->
			<!--Horizontal-main -->
			<?php include("../include/header_bottom.php");?>
			<!--Horizontal-main -->

			<!-- main-content opened -->
			<div class="main-content horizontal-content">

				<!-- container opened -->
				<div class="container containermobile">
					<!-- /breadcrumb -->
					<br>
					<!-- row -->
					<div class="row row-sm">
						<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
							<div class="card overflow-hidden sales-card bg-primary-gradient">
								<div class="ps-3 pt-3 pe-3 pb-2 pt-0">
									<div class="">
										<h6 class="mb-3 tx-12 text-white">TOTAL CLIENTES</h6>
									</div>
									<div class="pb-0 mt-0">
										<div class="d-flex">
											<div class="">
												<h4 class="tx-20 fw-bold mb-1 text-white"><?=$count_users?> de <?=count($users)?> </h4>
												<p class="mb-0 tx-12 text-white op-7">Activos(Grafica de segun la fecha)</p>
											</div>
										</div>
									</div>
								</div>
								<span id="compositeline" class="pt-1"><?=$clients_view?></span>
							</div>
						</div>
						<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
							<div class="card overflow-hidden sales-card bg-danger-gradient">
								<div class="ps-3 pt-3 pe-3 pb-2 pt-0">
									<div class="">
										<h6 class="mb-3 tx-12 text-white">TOTAL PREGUNTAS</h6>
									</div>
									<div class="pb-0 mt-0">
										<div class="d-flex">
											<div class="">
												<h4 class="tx-20 fw-bold mb-1 text-white"><?=count($answers)?></h4>
												<p class="mb-0 tx-12 text-white op-7">Actualizado <?=date('Y');?></p>
											</div>
											<span class="float-end my-auto ms-auto">
												<i class="fas fa-arrow-circle-up text-white"></i>
												<span class="text-white op-7">Activos</span>
											</span>
										</div>
									</div>
								</div>
								<span id="compositeline2" class="pt-1"></span>
							</div>
						</div>
						<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
							<div class="card overflow-hidden sales-card bg-success-gradient">
								<div class="ps-3 pt-3 pe-3 pb-2 pt-0">
									<div class="">
										<h6 class="mb-3 tx-12 text-white">TOTAL BAREMOS</h6>
									</div>
									<div class="pb-0 mt-0">
										<div class="d-flex">
											<div class="">
												<h4 class="tx-20 fw-bold mb-1 text-white"><?=$total_baremos?> de <?=$total_baremos_all?></h4>
												<p class="mb-0 tx-12 text-white op-7">Actualizado <?=date('Y');?></p>
											</div>
											<span class="float-end my-auto ms-auto">
												<i class="fas fa-arrow-circle-up text-white"></i>
												<span class="text-white op-7"> <?=round(($total_baremos / $total_baremos_all) * 100, 2);?>%</span>
											</span>
										</div>
									</div>
								</div>
								<span id="compositeline3" class="pt-1"></span>
							</div>
						</div>
						<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
							<div class="card overflow-hidden sales-card bg-warning-gradient">
								<div class="ps-3 pt-3 pe-3 pb-2 pt-0">
									<div class="">
										<h6 class="mb-3 tx-12 text-white">TEST</h6>
									</div>
									<div class="pb-0 mt-0">
										<div class="d-flex">
											<div class="">
												<h4 class="tx-20 fw-bold mb-1 text-white"><?=$total_completed['total']?> de <?=$totalTest?></h4>
												<p class="mb-0 tx-12 text-white op-7"><?=$total_pending['total']?> Pendientes</p>
											</div>
											<span class="float-end my-auto ms-auto">
												<i class="fas fa-arrow-circle-up text-white"></i>
												<span class="text-white op-7"> <?=round($total_porcentaje_test, 2);?>%</span>
											</span>
										</div>
									</div>
								</div>
								<span id="compositeline4" class="pt-1"></span>
							</div>
						</div>
					</div>
					<!-- row closed -->

					<!-- row opened -->
					<div class="row row-sm">
						<div class="col-md-12 col-lg-12 col-xl-7">
							<div class="card">
								<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
									<div class="d-flex justify-content-between">
										<h4 class="card-title mb-0">Estado de registros</h4>
										<i class="mdi mdi-dots-horizontal text-gray"></i>
									</div>
									<p class="tx-12 text-muted mb-0">Estado y seguimiento de registros. Datos estadisticos de las pruebas.</p>
								</div>
								<div class="card-body">
									<div class="total-revenue">
										<div>
										  <h4><?=$total_completed['total']?></h4>
										  <label><span class="bg-primary"></span>Completados</label>
										</div>
										<div>
										  <h4><?=$total_pending['total']?></h4>
										  <label><span class="bg-danger"></span>Pendientes</label>
										</div>
										<div>
										  <h4>0</h4>
										  <label><span class="bg-warning"></span>Cancelados</label>
										</div>
									  </div>
									<div id="bar" class="sales-bar mt-4"></div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-xl-5">
						<div class="card">
								<div class="card-header pb-1">
									<div class="d-flex justify-content-between">
										<h3 class="card-title mb-2">CLIENTES</h3>
										<p style="font-size: large;font-weight: bold;"><a class="modal-effect" data-bs-effect="effect-scale" data-bs-toggle="modal" onclick="createCliente()"
										href="#modaldemo8">+</a></p>
									</div>
									
									<p class="tx-12 mb-0 text-muted">Listado de clientes registrados</p>
									
								</div>
								<div class="card-body p-0 customers mt-1">
									<div class="list-group list-lg-group list-group-flush" style="border-top: ridge;">
										
										<?php
										foreach($users as $user){
										?>
										<div class="list-group-item list-group-item-action" href="#" style="border-bottom: ridge;">
											<div class="media mt-0">
												<img class="avatar-lg rounded-circle me-3 my-auto" src="../../assets/img/users/user.png" alt="Foto">
												<div class="media-body">
													<div class="d-flex align-items-center">
														<div class="mt-0">
															<h5 class="mb-1 tx-15"><?=$user['full_name']?></h5>
															<p class="mb-0 tx-13 text-muted">ID: #<?=$user['id']?> <span style="color: black;"> <?=$user['date_create']?></span> <span class="text-<?=$user['active']=='1'?'success':'danger'?> ms-2"><?=$user['active']=='1'?'Activo':'Inactivo'?></span></p>
														</div>
														<span class="ms-auto fs-16 mt-2">
														<ul class="icons-list">
													
																<li class="icons-list-item" onclick="updateUser('<?=$user['id']?>','<?=$user['full_name']?>','<?=$user['name_user']?>','','<?=$user['active']?>')" style="cursor:pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
																<path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
																<path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
															</svg></li>
															<li class="icons-list-item" onclick="page(`<?=LOCALHOST.'/view/register.php?client='.$user['id']?>`)" style="cursor:pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
																<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"></path>
															</svg></li>

															<li class="icons-list-item" onclick="removeUser('<?=$user['id']?>')" style="cursor:pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-backspace-fill" viewBox="0 0 16 16">
																<path d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"></path>
															</svg></li>


														</ul>
														</span>
													</div>
												</div>
											</div>
										</div>
										<?php }?>
										
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- row closed -->

					
				</div>
			</div>
			<!-- Container closed -->

		<!-- Modal effects -->
		<div class="modal fade" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title" id="CreateModalTitle">Creacion de cliente</h6><button aria-label="Close" class="close"
							data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form class="needs-validation was-validated" action="index.php" method="post">
						<div class="modal-body">
							
								<div class="row row-sm">
									<div class="col-lg-12">
										<div class="form-group has-success mg-b-0">
											<input type="hidden" id="iduser" name="iduser" value="">
											<input class="form-control" id="full_name" name="full_name" placeholder="Nombre Completo" required="" type="text" value="">
											<input class="form-control mg-t-20" id="name_user" name="name_user" placeholder="Usuario" required="" type="text" value="">
											<input class="form-control mg-t-20" id="password" name="password" placeholder="Contraseña" required="" type="password" value="">
											
											<select class="form-control mg-t-20 select2-no-search" id="active" name="active">
												<option value="1">
													Activo
												</option>
												<option value="0">
													Inactivo
												</option>
											</select>
										
										</div>
									</div>
								</div>
							
						</div>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="submit">Guardar Cambios</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal" id="modaldemo5">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content tx-size-sm">
					<div class="modal-body tx-center pd-y-20 pd-x-20">
						<button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
						<form action="index.php" method="post">
							<input type="hidden" id="id_user_remove" name="id_user_remove" value="">	
						
						<h4 class="tx-danger mg-b-20">Esta seguro que desea continuar?</h4>
						<p class="mg-b-20 mg-x-20">Se eliminara el registro y los registros relacionados a este</p><button aria-label="Close" class="btn ripple btn-danger pd-x-25" type="submit">Continuar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal effects-->


			<!-- Footer opened -->
			<?php include("../include/footer.php");?>
			
			<!-- Footer closed -->

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
		
		
		<!-- JQuery min js -->
		<script src="../../assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Ionicons js -->
		<script src="../../assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="../../assets/plugins/moment/moment.js"></script>

		<!--Internal Sparkline js -->
		<script src="../../assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

		<!-- Moment js -->
		<script src="../../assets/plugins/raphael/raphael.min.js"></script>

		<!-- Internal Piety js -->
		<script src="../../assets/plugins/peity/jquery.peity.min.js"></script>

		<!-- Rating js-->
		<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../../assets/plugins/rating/jquery.barrating.js"></script>

		<!-- P-scroll js -->
		<script src="../../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="../../assets/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!-- Sidemenu js-->
		<script src="../../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- Eva-icons js -->
		<script src="../../assets/js/eva-icons.min.js"></script>

		<!--Internal Apexchart js-->
		<script src="../../assets/js/apexcharts.js"></script>

		<!-- Horizontalmenu js-->
		<script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

		<!-- Sticky js -->
		<script src="../../assets/js/sticky.js"></script>

		<!-- Internal Chart js -->
		<script src="../../assets/plugins/chart.js/Chart.bundle.min.js"></script>

		<!--Internal  index js -->
		<script src="../../assets/js/index.js"></script>

		<!-- custom js -->
		<script src="../../assets/js/custom.js"></script>
		
		<script>
			function createCliente(){
				updateUser();
				$('#CreateModalTitle').text("Registro de cliente");
				$('#password').val("");
				$('#active').val(1).trigger('change');
			}
			function updateUser(id='',full_name='',name_user='',password='',active=''){
				$('#CreateModalTitle').text("Actualizacion de cliente");
				$('#iduser').val(id);
				$('#full_name').val(full_name);
				$('#name_user').val(name_user);
				$('#active').val(active);
				$('#password').val("******");
				$('#modaldemo8').modal('show');
			}
			function removeUser(id){
				$('#id_user_remove').val(id);
				$('#modaldemo5').modal('show');
			}
			function page(url){
				window.location.href = url;
			}
       
    </script>
	</body>
</html>