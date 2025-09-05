<?php
    include_once('../configs.php');
	//AF-5
	session_start();
	include('../connection.php');
	include("../models/model_register.php");
    include("../models/model_question.php");
    include("../models/model_answer.php");
    $registerModel = new Register_Model();
    $questionModel = new Question_Model();
	$answerModel = new Answer_Model();
    $idClient = 0;
    $idpatient = 0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $idUser = $_POST['idClient'];
        $idpatient = $_POST['patient'];
		$codes = $_POST['codes'];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'response_') === 0) {
                $question_id = str_replace('response_', '', $key);
				if($value == '0'){
					$value = null;
				}
                $response = $answerModel->update($question_id,$idpatient,$value,$codes);
            }
        }
        $responseStatus = $answerModel->checkStatus($codes);
		$count = (int)$responseStatus['count'];
		$status = 'TERMINADO';
		if($count > 0){
			$status = 'PENDIENTE';
		}
		$array = $registerModel->updateStatus($idUser,$idpatient,$status);
        $is_share_link = $_POST['is_share'];
		if($is_share_link == "1"){
			echo "<script>
				alert('Formulario actualizado correctamente.');
				window.location.href = 'https://www.google.com';
			</script>";
			exit;
		}
		else{
			header("Location: ".LOCALHOST);
		}
    }

	$idCientCode = "";
	$idPatientCode = "";
	$is_share  = false;
	$is_view = false;
	$text_button_send = "Corregir resultados";
	if(isset($_GET['client']) && isset($_GET['patient'])){
		if(strlen($_GET['client'])>10 && strlen($_GET['patient'])>10){
			$idCientCode = $_GET['client'];
        	$idPatientCode = $_GET['patient'];
			$is_share  = true;
		}
	}
	if($idCientCode == ""){
		if(!isset($_SESSION['REST_type_user'])){
			header("Location: ".LOCALHOST."/signin.php");
		}
		if( $_SESSION['REST_type_user'] == 'Administrador' &&  isset($_GET['client']) &&  isset($_GET['patient'])){

			$idClient = $_GET['client'];
			$idpatient = $_GET['patient'];
		}
		if($_SESSION['REST_type_user'] == 'CLIENTE' &&  isset($_GET['patient'])){
			$idClient = $_SESSION['REST_id_user'];
			$idpatient = $_GET['patient'];
		}
	}
	
	if($idCientCode != "" && $idPatientCode != ""){
		$claveEncriptado = $registerModel->getKeyEncripter();

		$response_data= $registerModel->desencriptar($idCientCode,$claveEncriptado);
		$response_data_clientIds = explode("_", $response_data);
		$idClient = $response_data_clientIds[0];

		$response_data = $registerModel->desencriptar($idPatientCode,$claveEncriptado);
		$response_data_PatientIds = explode("_", $response_data);
		$idpatient = $response_data_PatientIds[0];
		$text_button_send = "Enviar resultados";
	}

    $register = $registerModel->getById($idClient,$idpatient);
	if($register == null){
		echo "<script>
			alert('FALLO DE ACCESO CODIGO #876 - ".$idpatient." redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
		exit;
	}
    if($register['status'] == 'TERMINADO'){
		$is_view = true;
	}
    $answers = $answerModel->getAll($register['codes']);
	
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
			.labels {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        
        .labels p {
            font-weight: 600;
            color: black;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .top-label {
            align-self: flex-start;
        }
		.bottom-label {
            align-self: flex-end;
        }
		.sizepeity{
			height:70px;
			width: 500px;
		}
		.table-bordered th, .table-bordered td{
			border:1px solid #F8AB63;
		}
		.table-striped tbody tr:nth-of-type(odd){
			background-color:#FEF2E7;
		}
		@media (max-width: 480px) {
			.sizepeity{
				height:70px;
				width: 100%;
			}
		}
		p{
			font-size: 16px !important;
		}
		span{
			font-size: 16px !important;
		}
		td{
			font-size: 16px !important;
		}
		th{
			font-size: 16px !important;
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
			<?php if(!$is_share) include("../include/header_top.php"); ?>
			<!-- /main-header -->
			<!--Horizontal-main -->
			<?php if(!$is_share) include("../include/header_bottom.php"); ?>
			<!--Horizontal-main -->

			<!-- main-content opened -->
			<div class="main-content horizontal-content">

				<!-- container opened -->
				<div class="container">

					<!-- breadcrumb -->
                    <div class="breadcrumb-header justify-content-between"></div>
					
					<!--Row-->
					<div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
					<h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1" style="text-align: center;">Formulario <?=$register['type_question_name']?></h2>
					<br>
						<div class="card" style="border: 0px solid transparent !important;box-shadow: none !important;background-color: #d7d9ea  !important;">
						
							<div class="card-body">
								
								<div class="row row-sm" style="place-items: center;">
										<div class="col-lg-2 img-container" style="display: flex;justify-content: space-between;align-items: center;align-content: center;">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo" style="height: 100px;width: auto;"  src="../../assets/img/test_image/logoaf5.jpeg">
                                        </div>
										<div class="col-lg-10">
										<div class="row">
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<div class="input-group-text" style="background-color: white;">
														<span class="input-group-text" id="basic-addon1" style="background-color: white;">Nombre completo</span>
													</div><input aria-describedby="basic-addon1" class="form-control" style="font-weight: bold;background-color: white;" disabled value="<?=$register['id_client']?>" type="text">
												</div><!-- input-group -->
											</div>
											<div class="col-lg-3">
												<div class="input-group mb-3">
													<div class="input-group-text" style="background-color: white;">
														<span class="input-group-text" style="background-color: white;" id="basic-addon1">Edad</span>
													</div><input aria-describedby="basic-addon1" class="form-control" style="font-weight: bold;background-color: white;" disabled value="<?=$register['age']?>" type="text">
												</div><!-- input-group -->
											</div>
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<div class="input-group-text" style="background-color: white;">
														<span class="input-group-text" style="background-color: white;" id="basic-addon1">Fecha</span>
													</div><input aria-describedby="basic-addon1" class="form-control" style="font-weight: bold;background-color: white;" disabled value="<?= date('Y-m-d H:i:s'); ?>" type="text">
												</div><!-- input-group -->
											</div>
										</div>
									
									</div>
								</div>
								
								
							</div>
						</div>
					</div>
					<!-- row closed  -->
					<div class="col-md-12 col-lg-12 col-xl-12">
							<div class="card card-table-two">
								<div class="justify-center">
									<div class="boton-format" style="padding: 6px;
										border-radius: 20px;
										background-color: orange;
										color: white;
										margin: 1px;
										text-align: center;JUSTIFY-CONTENT: CENTER;justify-self: center;
										width: min-content;font-weight: bold;
										height: auto;">
										INSTRUCCIONES
									</div>
									<p>A continuacion encontraras una serie de frases. Lee cada una de ellas cuidadosamente y contesta con un valor entre 1 y 99 , segun tu grado de acuerdo con los que se indica.</p>
									
									<div style="margin: 30px 0;display: flex;position: relative;place-items: center;JUSTIFY-CONTENT: CENTER;">
										<div class="labels">
											<p class="bottom-label">1 en total desacuerdo</p>
										</div>
										<div style="height: 70px;position: relative;overflow: hidden;">
											<svg class="peity sizepeity" ><polygon fill="rgba(245, 139, 39,.2)" points="0 69.5 0 68.81 500 0.5 500 69.5"></polygon><polyline fill="none" points="0 68.81 500 0.5" stroke="orange" stroke-width="1" stroke-linecap="square"></polyline></svg>
										
										</div>
										<div class="labels">
											
											<p class="top-label">99 en total acuerdo</p>
										</div>
									</div>
									<p>Por ejemplo si la frase dice "<span style="font-weight: bold;">La musica ayuda al bienestar humano</span>" y estas muy deacuerdo, contestarias con un valor alto, como por ejemplo el 94, anotando tu respuesta de la siguiente manera:</p>
									
									<p  style="font-weight: bold;color: orange;">La musica ayuda al bienestar humano .............................. 94</p>
									
									<p>Por lo contario si estas muy poco deacuerdo, eligirias un valor bajo, por ejemplo el, y lo anotarias de la siguiente manera:</p>
									
									<p  style="font-weight: bold;color: orange;">La musica ayuda al bienestar humano .............................. 9</p>
									
									<p>No olvides  que dispones de muchas opciones de respuesta, en concreto, puedes elegir entre 99 valores. Escoge el que mas se ajuste a tu criterio.</p>
									<p  style="font-weight: bold;">RECUERDA CONTESTA CON LA MAXIMA SINCERIDAD.</p>
								</div>
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-1">Listado de estados</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
								<span class="tx-12 tx-muted mb-3 ">1 en total desacuerdo y 99 en total acuerdo</span>
								
								<div class="table-responsive country-table">
                                    <form method="<?=!$is_view?'POST':''?>" action="<?=!$is_view?'form2.php':''?>">
                                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
										<input type="hidden" name="is_share" value="<?=(int)$is_share?>">
                                        <input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
                                        <input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
										<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
                                        <thead>
											<tr>
                                                <th class="wd-lg-5p">ID</th>
												<th class="wd-lg-100p">Conteste de 1 a 99 en las casillas correspondientes a cada pregunta</th>
												<th class="wd-lg-25p tx-center">1-99</th>
                                                <th class="wd-lg-5p">ID</th>
											</tr>
										</thead>
										<tbody>
                                            <?php
                                                foreach($answers as $answer){
                                            ?>
											<tr>
                                                <td><?=$answer['item_order']?></td>
												<td><?=htmlspecialchars($answer['question'])?></td>
												<td class="tx-right tx-medium tx-inverse">
												<input type="number" name="response_<?=$answer['id']?>" value="<?=$answer['response']!=0?$answer['response']:''?>" <?=$is_view?'disabled':''?> min="1" max="99">
                                                </td>
                                                
                                                <td><?=$answer['item_order']?></td>
											</tr>
                                            
                                            <?php }?>
										</tbody>
									</table>
                                    <br>
                                    <?php if(!$is_view){?>
									<button type="submit" class="btn btn-primary"><?=$text_button_send?></button>
									<?php }?>
                                    </form>
								</div>
							</div>
						</div>
                        
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

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

		<!-- Right-sidebar js -->
		<script src="../../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- custom js -->
		<script src="../../assets/js/custom.js"></script>
		<script>
			// Seleccionar todos los inputs que comienzan con "response_"
			document.querySelectorAll('input[name^="response_"]').forEach(input => {
				// Agregar evento cuando el usuario termina de editar (evento 'change')
				input.addEventListener('change', function() {
					// Convertir el valor a número
					let value = parseInt(this.value);
					
					// Validar el valor
					if (isNaN(value)) {
						this.value = this.min || 1; // Si no es número, poner valor mínimo
					} else if (value > 99) {
						this.value = 99;
					} else if (value < 1) {
						this.value = 1;
					}
				});

				// También validar mientras escribe (evento 'input')
				input.addEventListener('input', function() {
					let value = parseInt(this.value);
					
					if (!isNaN(value)) {
						if (value > 99) {
							this.value = 99;
						} else if (value < 1) {
							this.value = 1;
						}
					}
				});
			});
		</script>
	</body>
</html>