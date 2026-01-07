<?php
    include_once('../configs.php');

	session_start();
	include('../connection.php');
	include("../models/model_user.php");
	include("../models/model_register.php");
	include("../models/model_question.php");
	include("../models/model_baremo.php");
	include("../models/model_answer.php");
    $registerModel = new Register_Model();
	$questionModel = new Question_Model();
	$baremoModel = new Baremo_Model();
	$answerModel = new Answer_Model();
	$userModel = new User_Model();
    $idClient = 0;
	if(!isset($_SESSION['REST_type_user'])){
		header("Location: ".LOCALHOST."/signin.php");
	}
	if(($_SESSION['REST_type_user'] == 'Administrador' || $_SESSION['REST_type_user'] == 'CLIENTE') && ( isset($_POST['id_type_question']) && isset($_POST['belong_id']) && isset($_POST['baremo_id']) && isset($_POST['age'])  && isset($_POST['sex']) && isset($_POST['id_client']))){
		$hash = $answerModel->generateRandomKey();
		if(isset($_POST['id']) && $_POST['id'] != ''){
			$data = $registerModel->updateClient($_POST['id'],$_POST['id_client'],$_POST['age'],$_POST['sex'],$_POST['id_type_question'],$_POST['baremo_id']);
		}
		else{
			$idRegister = $registerModel->save($_POST['belong_id'],$_POST['id_client'],$_POST['age'],$_POST['sex'],$_POST['baremo_id'],$_POST['id_type_question'],$hash);
			$questions = $questionModel->getAll($_POST['id_type_question']);

			foreach ($questions as $value) {
				$id = $answerModel->save($value['id'],$idRegister,$hash);
			}
		}

		header("Location: ".LOCALHOST."/view/register.php?client=".$_POST['belong_id']);
	}

	if( ($_SESSION['REST_type_user'] == 'Administrador' || $_SESSION['REST_type_user'] == 'CLIENTE') &&  isset($_GET['remove_id'])){

		$value = $registerModel->delete($_GET['remove_id']);

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	if( $_SESSION['REST_type_user'] == 'Administrador' &&  isset($_GET['client'])){

		$idClient = $_GET['client'];
	}
	if($_SESSION['REST_type_user'] == 'CLIENTE'){
		$idClient = $_SESSION['REST_id_user'];
	}
	$search_key ="";
	if(isset($_GET['search'])){
		$search_key = $_GET['search'];
	}

    if($idClient == 0){
        die();
    }

	

    $registers = $registerModel->getAll($idClient,$search_key);
	$param_extra = $registerModel->getRandomCipherMethod();
	$claveEncriptado = $registerModel->getKeyEncripter();
	foreach ($registers as &$register) {
		$dateTime = new DateTime($register['date_create']);
		$register['date_create'] =  $dateTime->format('d/m/Y');
		$register['urlshare'] = urlencode($registerModel->encriptar($register['id']."_".$param_extra, $claveEncriptado));
	}
	unset($register);

	$total_completed = $registerModel->getTotalCompleted($idClient,'TERMINADO');
	$total_pending = $registerModel->getTotalCompleted($idClient,'PENDIENTE');
	$totalTest = $total_completed['total'] + $total_pending['total'];

	$questions = $questionModel->getAllTypeQuestion();
	$baremos = $baremoModel->getAll();
	foreach ($questions as $value) {
		$value['name'] = htmlspecialchars($value['name']);
	}

	$urlshare_client = urlencode($registerModel->encriptar($idClient."_".$param_extra, $claveEncriptado));
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
		<title> <?=WEB_TITLE?> </title>

		<!-- Favicon -->
		<link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="../../assets/css/icons.css" rel="stylesheet">

		<!-- Bootstrap css -->
		<link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!--  Right-sidemenu css -->
		<link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!--  Custom Scroll bar-->
		<link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- Style css-->
		<link href="../../assets/css/style.css" rel="stylesheet">
		<link href="../../assets/css/style-dark.css" rel="stylesheet">
		<link href="../../assets/css/boxed.css" rel="stylesheet">
		<link href="../../assets/css/dark-boxed.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="../../assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="../../assets/css/animate.css" rel="stylesheet">

		<style>
			.toast-copiado {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #1ab6cf;
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    font-weight: bold;
    z-index: 9999;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    animation: fadeOut 0.5s ease-in-out 4.5s forwards;
}

/* Animación para desvanecerse */
@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(-50%) translateY(-10px);
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
				<div class="container">
				<br>

				<div class="row row-sm">
					<div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-primary-gradient text-white ">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-users tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Pacientes</span>
											<h2 class="text-white mb-0"><?=count($registers)?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-danger-gradient text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-bar-chart-2 tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Test</span>
											<h2 class="text-white mb-0"><?=$totalTest?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-success-gradient text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-bar-chart-2 tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Completados</span>
											<h2 class="text-white mb-0"><?=$total_completed['total']?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-warning-gradient text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-bar-chart-2 tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Pendientes</span>
											<h2 class="text-white mb-0"><?=$total_pending['total']?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
					<!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between"></div>
					<!--Row-->
					<div class="row row-sm">
						<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
							<div class="card">
								<div class="card-header pb-0">
									
									<div class="d-flex justify-content-between">
										<h4 class="card-title mg-b-0">LISTA DE REGISTROS</h4>
										<div class="main-header-center  ms-4" style="margin:0;justify-content: right;">
											<input  id="searchInputInit" value="<?=$search_key?>" class="form-control" style="height: 40px;width: 350px;
        border-radius: 20px;
        background: #ecf0fa;
        border: 1px solid #ecf0fa;" placeholder="Buscar..." type="search">
											<button type="button"  class="btn" onclick="search(`<?=LOCALHOST.'/view/register.php?client='.$idClient.'&search='?>`)" style="position: relative;
    top: 0;
    right: 60px;
        background-color: transparent;
        height: 40px;
        color: #b4bdce;
        transition: none;
        font-size: 16px;
        padding-right: 13px;"><i class="fe fe-search"></i></button>
										</div>
										<i class="mdi mdi-plus text-gray" data-bs-effect="effect-scale" onclick="updateClient()" data-bs-toggle="modal"
										href="#modaldemo8" style="cursor:pointer"></i>
									</div>
									
									<p class="tx-12 tx-gray-500 mb-2">Registro de todos los pacientes registradas</p>
								</div>
								<div class="card-body">
									<div class="table-responsive border-top userlist-table">
										<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-lg-8p"><span>ID</span></th>
													<th class="wd-lg-20p"><span>Creado</span></th>
													<th class="wd-lg-8p"><span>Paciente</span></th>
                                                    <th class="wd-lg-20p"><span>Edad</span></th>
													
													<th class="wd-lg-20p"><span>Estado</span></th>
                                                    <th class="wd-lg-20p"><span>Baremo</span></th>
													<th class="wd-lg-20p"><span>Tipo</span></th>
													<th class="wd-lg-20p">Accion</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
                                                foreach($registers as $data){
													
													
                                                ?>
												<tr>
													<td>#<?=$data['id']?></td>
													<td>
                                                        <?=$data['date_create']?>
													</td>
													<td><?=$data['id_client']?></td>
													<td>
                                                        <?=$data['age']?>
													</td>
                                                    
													<td class="text-center">
														<span class="label text-<?=$data['status']=='PENDIENTE'?'warning':'success'?> d-flex"><div class="dot-label bg-<?=$data['status']=='PENDIENTE'?'warning':'success'?>-300 me-1"></div><?=$data['status']?></span>
													</td>
                                                    <td>
                                                        <?=htmlspecialchars($data['name'])?>
													</td>
                                                    <td>
                                                        <?=$data['type_question_name']?>
													</td>
													<td>
                                                        <div class="d-flex my-xl-auto right-content">
															<?php //id_type_question => 3 = MACI, 2 = AF-5, 1 = LSB-50, 
															$redirect = '0';
															$redirect = $data['id_type_question'] == 1?'1':$redirect;
															$redirect = $data['id_type_question'] == 2?'2':$redirect;
															$redirect = $data['id_type_question'] == 3?'3':$redirect;
															$redirect = $data['id_type_question'] == 4?'4':$redirect;
															$redirect = $data['id_type_question'] == 5?'5':$redirect;
															$text_test = "Ajustar";
															if($data['status'] == 'TERMINADO'){
																$text_test = "Ver prueba";
															}
															?>
                                                            <div class="pe-1  mb-xl-0" style="cursor:pointer" onclick="page(`<?=LOCALHOST.'/view/form'.$redirect.'.php?client='.$idClient.'&patient='.$data['id']?>`)"><span class="badge bg-primary-transparent text-primary ms-auto float-end"><?=$text_test?></span></div>
															<div class="pe-1  mb-xl-0" style="<?=$data['status'] == 'PENDIENTE'?'pointer-events: none;opacity: 0.3;':'cursor:pointer'?>" onclick="page(`<?=LOCALHOST.'/view/result'.$redirect.'.php?client='.$idClient.'&patient='.$data['id']?>`)"><span class="badge bg-primary-transparent text-primary ms-auto float-end">Resultado</span></div>

                                                            <div class="pe-1  mb-xl-0" style="cursor:pointer" data-bs-effect="effect-scale" data-bs-toggle="modal"
																href="#modaldemo8" onclick="updateClient(`<?=$data['id']?>`,`<?=$data['id_client']?>`,`<?=$data['age']?>`,`<?=$data['sex']?>`,`<?=$data['id_type_question']?>`,`<?=$data['baremo_id']?>`)"><i class="text-warning las la-pen"></i></div>
															<div  class="pe-1  mb-xl-0" style="cursor:pointer" data-bs-effect="effect-scale" data-bs-toggle="modal"
																href="#modalshare9" onclick="openShareLink(`<?=$urlshare_client?>`,`<?=$redirect?>`,`<?=$data['urlshare']?>`)"><i class=" las la-share"></i></div>
                                                            <div class="pe-1  mb-xl-0" onclick="eliminarRegistro(`<?=$data['id_client']?>`,`<?=$data['id']?>`)" href="#modalremove1" data-bs-effect="effect-scale" data-bs-toggle="modal" style="cursor:pointer"><i class=" text-danger las la-trash"></i></div>
                                                        </div>
                                                        
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div><!-- COL END -->
					</div>
					<!-- row closed  -->
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->
			<!-- Modal effects -->
		<div class="modal fade" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Creacion de Paciente</h6><button aria-label="Close" class="close"
							data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form class="needs-validation was-validated" action="register.php" method="post">
						<div class="modal-body">
							
								<div class="row row-sm">
									<div class="col-lg-12">
										<div class="form-group has-success mg-b-0">
											<input type="hidden" id="id" name="id" value="">
											<input type="hidden" id="belong_id" name="belong_id" value="<?=$idClient?>">
											<input class="form-control" id="id_client" name="id_client" placeholder="Nombre Completo" required="" type="text" value="">
											<input class="form-control mg-t-20" id="age" name="age" placeholder="Edad" required="" type="number" value="">
											
											<select class="form-control mg-t-20 select2-no-search" id="sex" name="sex">
												<option value="" selected disabled>
													SEXO
												</option>
												<option value="MASCULINO">
													MASCULINO
												</option>
												<option value="FEMENINO">
													FEMENINO
												</option>
											</select>
											
											<select class="form-control mg-t-20 select2-no-search" id="id_type_question" name="id_type_question">
												<option value="" selected disabled>
													TIPO DE EVALUACION
												</option>
												<?php
                                                foreach($questions as $question){
                                                ?>
												<option value="<?=$question['id']?>">
													<?=htmlspecialchars($question['name'])?> con valores(<?=$question['value_data']?>)
												</option>
												<?php } ?>
											</select>
											<select class="form-control mg-t-20 select2-no-search" id="baremo_id" name="baremo_id">
												
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
		
		<div class="modal fade" id="modalshare9">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Compartir formulario</h6><button aria-label="Close" class="close"
							data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
							
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="form-group has-success mg-b-0">
									<input class="form-control" style="background: papayawhip;" id="input_share_model" name="id_client" type="text" value="">
									
								</div>
							</div>
						</div>
						
					</div>
					<div class="modal-footer">
						<input class="form-control mb-2" style="width: 150px;" id="input_share_number" type="text" placeholder="Numero">
						<button class="btn ripple btn-primary" onclick="shareWhatsApp()" type="button">Compartir por WhastApp</button>
						<button class="btn ripple btn-secondary" onclick="copiarMensaje()" type="button">Copiar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalremove1">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Eliminar Test</h6><button aria-label="Close" class="close"
							data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
							
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="form-group has-success mg-b-0">
									<input class="form-control" style="background: papayawhip;" id="id_eliminar" disabled type="text" value="">
									<input type="hidden" id="id_client_remove" name="id_client_remove" value="">
								</div>
							</div>
						</div>
						
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-danger" onclick="eliminarRegistroModal()" type="button">Eliminar</button>
						<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<div id="mensajeCopiado" class="toast-copiado" style="display: none;">
			✅ Mensaje copiado al portapapeles
		</div>
			
			<!-- Audio Modal -->
			<?php include("../include/footer.php");?>

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<!-- JQuery min js -->
		<script src="../../assets/plugins/jquery/jquery.min.js"></script>

		<!--Internal  Datepicker js -->
		<script src="../../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Ionicons js -->
		<script src="../../assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="../../assets/plugins/moment/moment.js"></script>

		<!-- Internal Select2 js-->
		<script src="../../assets/plugins/select2/js/select2.min.js"></script>

		<!-- P-scroll js -->
		<script src="../../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="../../assets/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!-- eva-icons js -->
		<script src="../../assets/js/eva-icons.min.js"></script>

		<!-- Rating js-->
		<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../../assets/plugins/rating/jquery.barrating.js"></script>

		<!-- Custom Scroll bar Js-->
		<script src="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- Horizontalmenu js-->
		<script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

				<!-- Sticky js -->
		<script src="../../assets/js/sticky.js"></script>

		<!-- Right-sidebar js -->
		<script src="../../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- custom js -->
		<script src="../../assets/js/custom.js?v=<?=VERSION_CODE?>"></script>
		<script>
			const baremos = <?=json_encode($baremos);?>;
			const selectElement = document.getElementById("baremo_id");
			//cambio de baremos
			document.getElementById("id_type_question").addEventListener("change", function () {
				const id = this.value;
				reloadBaremos(id);
				
			});
			function createOption(baremo){
				const option = document.createElement("option");
				option.value = baremo.id;
				option.text = baremo.name;
				if (baremo.active == '0') {
					option.disabled = true;
				}
				return option;
			}
			function reloadBaremos(id){
				
				selectElement.innerHTML = '<option value="" disabled selected>Seleccionar</option>';

				const rangos = {
					1: [1, 4],//form1
					2: [5, 37],//form2
					3: [38, 45],//form3
					4: [46, 50],//form4
					5: [51, 56],//form5
				};

				const [min, max] = rangos[id] || [0, 0];

				baremos.forEach(baremo => {
					const baremoId = Number(baremo.id);
					if (baremoId >= min && baremoId <= max) {
						selectElement.appendChild(createOption(baremo));
					}
				});
			}
			function page(url){
				//window.location.href = url;
				window.open(url, '_blank');
			}
			function openShareLink(client_id,redirect,patient_id){
				var url = '<?=LOCALHOST?>'+"/view/form"+redirect+".php?client="+client_id+"&patient="+patient_id;
				const input_share_model = document.getElementById("input_share_model");
				input_share_model.value = url;
			}
			function shareWhatsApp(){
				const numero = $('#input_share_number').val().trim();
				if (!/^\d{8,15}$/.test(numero)) {
					alert("Número no válido. Incluye el código de país, sin espacios ni signos.");
					return;
				}
				const valor = document.getElementById("input_share_model").value.trim();
				let url = "https://wa.me/"+numero +"?text=" + encodeURIComponent(valor);
        		window.open(url, '_blank');
			}
			function eliminarRegistro(nombre_completo,id){
				document.getElementById("id_eliminar").value = nombre_completo;
				document.getElementById("id_client_remove").value = id;
				//id_client_remove
			}
			function eliminarRegistroModal(){
				//id_client_remove
				const remove_id = document.getElementById("id_client_remove").value;
				window.location.href = '<?=LOCALHOST.'/view/register.php?remove_id='?>'+remove_id;
			}
			function copiarMensaje(){
				const valor = document.getElementById("input_share_model").value.trim();
				navigator.clipboard.writeText(valor)
							.then(() => {
								navigator.clipboard.writeText(valor)
					.then(() => {
						// Mostrar toast
						const toast = document.getElementById("mensajeCopiado");
						toast.style.display = "block";

						// Ocultar después de 5 segundos
						setTimeout(() => {
							toast.style.display = "none";
						}, 4000);
					})
					.catch(err => {
						console.error("Error al copiar: ", err);
						alert("Hubo un error al copiar el mensaje.");
					});
				})
				.catch(err => {
					console.error("Error al copiar: ", err);
				});
			}
			$('#searchInputInit').on('keydown', function(e) {
				if (e.key === 'Enter' || e.keyCode === 13) {
					e.preventDefault();
					search('<?=LOCALHOST.'/view/register.php?client='.$idClient.'&search='?>');
				}
			});
			function search(url) {
				const valor = document.getElementById("searchInputInit").value.trim();
				window.location.href = url+valor;

			}
			
			function updateClient(id='',id_client='',age='',sex='',id_type_question='',baremo_id=''){
				//console.log(id,id_client,age,id_type_question,baremo_id);
				$('#id').val(id);
				$('#id_client').val(id_client);
				$('#age').val(age);
				$('#sex').val(sex).trigger('change');
				$('#id_type_question').val(id_type_question).trigger('change');
				setTimeout(function() {
					reloadBaremos(id_type_question);
					$('#baremo_id').val(baremo_id).trigger('change');		
				}, 500);
			}
    </script>
	</body>
</html>