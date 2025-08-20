<?php
    include_once('../configs.php');
	//LSB-50
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
		$other_answer = $_POST['other_answer'];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $question_id = str_replace('question_', '', $key);
                $value = (int)$value;
                $response = $answerModel->update($question_id,$idpatient,$value,$codes);
            }
        }
        $responseStatus = $answerModel->checkStatus($codes);
		$count = (int)$responseStatus['count'];
		$status = 'TERMINADO';
		if($count > 0){
			$status = 'PENDIENTE';
		}
		$response_input = $answerModel->maciUpdateProblem($other_answer,$idpatient);
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
			header("Location: ".LOCALHOST."/view/register.php?client=".$idUser);
		}
    }
	
	$idCientCode = "";
	$idPatientCode = "";
	$is_share  = false;
	if(isset($_GET['client']) && isset($_GET['patient'])){
		if(strlen($_GET['client'])>10 && strlen($_GET['patient'])>10){
			$idCientCode = $_GET['client'];
        	$idPatientCode = $_GET['patient'];
			$is_share  = true;
		}
	}

	if($idCientCode == ""){
		if(!isset($_SESSION['REST_type_user']) ){
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
	
	}

    if($idClient == 0 || $idpatient == 0 ){
        die();
    }
    $register = $registerModel->getById($idClient,$idpatient);
   
    $answers = $answerModel->getAll($register['codes'],1,160);
	
	$answer_part1 = $answerModel->getAll($register['codes'],1001,1100);
	
	$input_answer_response = $answerModel->getMaciInputProblem($idpatient);
	$input_answer = "";
	if($input_answer_response != null){
		$input_answer = $input_answer_response['response_data'];
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
		.radio-grande {
			width: 20px;
			height: 20px;
		}
		.table-bordered th, .table-bordered td{
			border:1px solid #9499C7;
		}
		.table-striped tbody tr:nth-of-type(odd){
			background-color:#EEEFF6;
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
						<div class="card" style="border: 2px solid #737f9e">
						
							<div class="card-body">
								<div class="row row-sm" style="place-items: center;">
										<div class="col-lg-2 img-container" style="display: flex;justify-content: space-between;align-items: center;align-content: center;">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo" style="height: 100px;width: auto;"  src="../../assets/img/test_image/logomaci.png">
                                        </div>
										<div class="col-lg-10">
										<div class="row">
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<div class="input-group-text">
														<span class="input-group-text" id="basic-addon1">Nombre completo</span>
													</div><input aria-describedby="basic-addon1" class="form-control" style="font-weight: bold;" disabled value="<?=$register['id_client']?>" type="text">
												</div><!-- input-group -->
											</div>
											<div class="col-lg-3">
												<div class="input-group mb-3">
													<div class="input-group-text">
														<span class="input-group-text" id="basic-addon1">Edad</span>
													</div><input aria-describedby="basic-addon1" class="form-control" style="font-weight: bold;" disabled value="<?=$register['age']?>" type="text">
												</div><!-- input-group -->
											</div>
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<div class="input-group-text">
														<span class="input-group-text" id="basic-addon1">Fecha</span>
													</div><input aria-describedby="basic-addon1" class="form-control" style="font-weight: bold;" disabled value="<?= date('Y-m-d H:i:s'); ?>" type="text">
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
						<form method="POST" action="form3.php">
						<div class="card card-table-two">
							<div class="justify-center" style="place-items: center;">
								<div class="boton-format" style="padding: 6px;
										border-radius: 20px;
										background-color: #64b4fa;
										color: white;
										margin: 1px;
										text-align: center;
										width: min-content;font-weight: bold;
										height: auto;">
										INSTRUCCIONES
								</div>
								<p>Esta prueba consiste en una lista de frases que la gente joven usa para describirse a sí misma. Se presentan aquí para ayudarte a describir tus sentimientos y actitudes. Cuando contestes trata de hacerlo honesta y seriamente como puedas, ya que los resultados serán utilizados para ayudar a conocerte y poder ayudarte a planear tu futuro. No te preocupes si algunas de las frases no te parecen muy corrientes; se han incluido para ayudar a adolescentes con muchos tipos de problemas. No hay límite de tiempo para completar el inventario, aunque es mejor trabajara un ritmo rápido pero cómodo. </p>
								<br>
								
							</div>
							<div class="d-flex justify-content-between">
								<h4 class="card-title mb-1">Reactivo de sintomas MACI</h4>
								<i class="mdi mdi-dots-horizontal text-gray"></i>
							</div>
							<span class="tx-12 tx-muted mb-3 ">A continuación encontrarás una serie de problemas que suelen preocupar a las personas. <br>
								Si crees que alguno de ellos es <span style="font-weight: bold;">TU PRINCIPAL PROBLEMA</span> , márcalo con un 1 y si piensas en ello, pero <span style="font-weight: bold;"> NO TE PREOCUPA</span>, márcalo con un 2.							
							
							</span>
							<div class="table-responsive country-table">
								
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
									<input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
									<input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
									<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
									<thead>
										<tr>
											<th class="wd-lg-5p">ID</th>
											<th class="wd-lg-100p">PROBLEMAS</th>
											<th class="wd-lg-25p tx-right">1</th>
											<th class="wd-lg-25p tx-right">2</th>
											<th class="wd-lg-5p">ID</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($answer_part1 as $answer){
										?>
										<tr>
											<td><?=$answer['item_order']?></td>
											<td><?=htmlspecialchars($answer['question'])?></td>
											<td class="tx-right tx-medium tx-inverse">
											<input class="radio-grande" name="question_<?=$answer['id']?>" value="1" type="radio" <?=$answer['response']=='1'?'checked':'' ?>>
											</td>
											<td class="tx-right tx-medium tx-inverse">
											<input class="radio-grande" name="question_<?=$answer['id']?>" value="0" type="radio" <?=$answer['response']=='0'?'checked':'' ?>>
											</td>
											
											<td><?=$answer['item_order']?></td>
										</tr>
										
										<?php }?>
									</tbody>
								</table>
								
								
								
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12">
									<div class="input-group mb-3">
										<div class="input-group-text">
											<span class="input-group-text" id="basic-addon1">Otros (escribe cuáles)</span>
										</div><input aria-describedby="basic-addon1" name="other_answer" class="form-control" style="font-weight: bold;" value="<?=$input_answer;?>" type="text">
									</div><!-- input-group -->
								</div>
							</div>
						</div>
						<div class="card card-table-two">
							<p>Lee las frases del cuadernillo que te han entregado y decide si, aplicadas a ti son verdaderas V o falsas F. Selecciona sobre la columna V en el caso de que la frase sea verdadera o sobre la columna F si fuese falsa.</p>
								<p style="text-align: center;"><span style="font-weight: bold;">Lee y contesta a los dos ejemplos siguientes:</span></p>
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap" style="color:red">
								<thead>
									<tr>
										<th class="wd-lg-5p">ID</th>
										<th class="wd-lg-100p">Ejemplos</th>
										<th class="wd-lg-25p tx-right">V</th>
										<th class="wd-lg-25p tx-right">F</th>
									</tr>
								</thead>
								
								<tbody>
									<tr style="color:red">
										<td class="wd-lg-5p">1</td>
										<td class="wd-lg-100p">Soy un ser humano</td>
										<td class="tx-right tx-medium tx-inverse wd-lg-25p tx-right">
											<input class="radio-grande" name="example1t" value="1" type="radio">
										</td>
										<td class="tx-right tx-medium tx-inverse wd-lg-25p tx-right">
											<input class="radio-grande" name="example1t" value="0" type="radio">
										</td>
									</tr>
									<tr style="color:red">
										<td class="wd-lg-5p">2</td>
										<td class="wd-lg-100p">Mido mas de tres metros</td>
										<td class="tx-right tx-medium tx-inverse wd-lg-25p tx-right">
											<input class="radio-grande" name="example2t" value="1" type="radio">
										</td>
										<td class="tx-right tx-medium tx-inverse wd-lg-25p tx-right">
											<input class="radio-grande" name="example2t" value="0" type="radio">
										</td>
									</tr>
								</tbody>
								</table>
								<br>
							<span class="tx-12 tx-muted mb-3 ">Procura contestar con orden; comprueba la numeración de la frase en el Cuadernillo y de la respuesta en esta Hoja. <br>
								Anota sólo una respuesta para cada frase e intenta no dejar frases sin contestar, aunque no estés totalmente seguro de tu respuesta. <br>
								Si no  eres capaz de decidirte por     V     o     F      ,debes marcar el espacio de la letra     F   (Falso).

							</span>
							<div class="table-responsive country-table">
								
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
									<input type="hidden" name="is_share" value="<?=(int)$is_share?>">
									<input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
									<input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
									<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
									<thead>
										<tr>
											<th class="wd-lg-5p">ID</th>
											<th class="wd-lg-100p">Sintoma</th>
											<th class="wd-lg-25p tx-right">V</th>
											<th class="wd-lg-25p tx-right">F</th>
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
											<input class="radio-grande" name="question_<?=$answer['id']?>" value="1" type="radio" <?=$answer['response']=='1'?'checked':'' ?>>
											</td>
											<td class="tx-right tx-medium tx-inverse">
											<input class="radio-grande" name="question_<?=$answer['id']?>" value="0" type="radio" <?=$answer['response']=='0'?'checked':'' ?>>
											</td>
											
											<td><?=$answer['item_order']?></td>
										</tr>
										
										<?php }?>
									</tbody>
								</table>
								<br>
								<button type="submit" class="btn btn-primary">Actualizar</button>
								
							</div>
						</div>
						</form>
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

	</body>
</html>