<?php
    include_once('../configs.php');
	//CMASR-2
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
    $answers = $answerModel->getAll($register['codes'],1,160);
	
	$answer_part1 = $answerModel->getAll($register['codes'],1001,1100);
	
	$input_answer_response = $answerModel->getMaciInputProblem($idpatient);
	$input_answer = "";
	if($input_answer_response != null){
		$input_answer = $input_answer_response['response_data'];
	}
	$device = $registerModel->getDeviceType();
?>

<!DOCTYPE html>
<?php if (($device === 'tablet' || $device === 'mobile')) { ?>

<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=WEB_TITLE?> </title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen w-full bg-gradient-to-br from-[#1F2B3D] via-[#283B50] to-[#3C506D] flex items-center justify-center p-4 font-sans text-white">

  <main class="w-full max-w-lg bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden">

    <!-- CONTENEDOR DINÁMICO -->
    <div id="app"></div>

  </main>

<script>
/* ===========================
   DATOS
=========================== */

var questions = <?php echo json_encode($answers)?>;

const options = [
  { value: 1, text: 'Si', class: 'from-sky-400 to-cyan-400' },
  { value: 0, text: 'No', class: 'from-emerald-400 to-teal-400' }
];
//from-fuchsia-600 to-purple-700
//from-slate-700 to-gray-900
/* ===========================
   ESTADO
=========================== */
let currentIndex = 0;
let answers = [];
let patient = {};
let finished = false;
let submittedAt = null;

/* ===========================
   RENDER
=========================== */
function render() {
  const app = document.getElementById('app');

  if (!patient.name) {
    app.innerHTML = renderPatientForm();
    return;
  }

  if (!finished) {
    app.innerHTML = renderQuestion();
    return;
  }

  app.innerHTML = renderSummary();
}

/* ===========================
   FORMULARIO PACIENTE
=========================== */
function renderPatientForm() {
  return `
  <div class="p-8 sm:p-12">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold text-cyan-300">FORMULARIO <?=$register['type_question_name']?></h2>
        </div>
		
		<div class="mb-4">
		<label for="fullName" class="block mb-2 text-sm font-medium text-gray-300">Nombre Completo</label>
		<input type="text" disabled value="<?=$register['id_client']?>" id="fullName" formControlName="fullName"
			class="w-full bg-black/20 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all"
			placeholder="Ej. Juan Pérez">
		</div>
        
        <div class="mb-8 p-4 bg-black/20 border border-white/10 rounded-lg text-left text-sm text-gray-300 space-y-3">
          <h3 class="text-base font-bold text-cyan-300 text-center">INSTRUCCIONES</h3>
          <p>Las oraciones que aparecen en este formulario dicen cómo piensan y sienten algunas personas acerca mismas. Lee con cuidado cada oración y luego encierra en un círculo la palabra que corresponda a tu respuesta. Marca una "X" en la columna de Sí, si piensas que así eres y en la columna No si crees que no eres asi. Responde a cada oración, incluso si te resulta difícil elegir una respuesta que se aplique a ti. No marques Sí y No para la misma oración.</p>
			<br>
		  <p>No hay respuestas correctas ni incorrectas; sólo tú puedes decirnos cómo piensas y sientes con respecto a ti mismo. Recuerda, después de leer cada oración, pregúntate: "¿Es cierto en mi caso?". Si es así, encierra Sí en un círculo; si no lo es, encierra el No.</p>
          
        </div>

        
		
		<button type="button" onclick="startQuiz()"
		class="w-full py-3 px-8 font-bold rounded-full text-white shadow-lg
         bg-gradient-to-r from-[#3C506D] to-[#627892]
         hover:scale-105 hover:shadow-2xl
         transform transition-all duration-300
         focus:outline-none focus:ring-4 focus:ring-[#627892]/50
         disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
		Comenzar Cuestionario
		</button>
        
      </div>`;
}

function startQuiz() {
  patient.name = document.getElementById('fullName').value;
  render();
}

/* ===========================
   PREGUNTAS
=========================== */
function renderQuestion() {
  const progress = Math.round((currentIndex / questions.length) * 100);

  return `
  <div class="p-8">

    <div class="text-center border-b border-white/10 pb-4 mb-4">
      <p class="font-bold">${patient.name}</p>
    </div>

    <p class="text-cyan-300 mb-2">Pregunta ${currentIndex + 1} de ${questions.length}</p>
    <div class="w-full bg-black/30 rounded-full h-2 mb-6">
      <div class="h-2 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-full"
        style="width:${progress}%"></div>
    </div>

    <h2 class="text-2xl font-bold text-center mb-6">
      ${questions[currentIndex].question}
    </h2>

    <div class="grid grid-cols-2 gap-4">
      ${options.map(o => `
        <button onclick="answer(${o.value})"
          class="py-4 rounded-xl bg-gradient-to-br ${o.class} font-bold">
          ${o.text}
        </button>
      `).join('')}
    </div>

    <button onclick="back()" class="mt-6 text-gray-400 hover:text-white">
      ← Anterior
    </button>
  </div>`;
}

function answer(value) {
  answers[currentIndex] = value;
  currentIndex++;

  if (currentIndex === questions.length) {
    finished = true;
    submittedAt = new Date();
  }
  render();
}

function back() {
  if (currentIndex > 0) currentIndex--;
  render();
}

/* ===========================
   RESUMEN
=========================== */
function renderSummary() {
  return `
  <div class="p-8 text-center">

    <h2 class="text-3xl font-bold text-emerald-400 mb-2">¡Completado!</h2>
    <p class="text-gray-300 mb-4">Gracias por responder</p>

    <div class="bg-black/30 p-4 rounded-lg text-left mb-4">
      <p><b>Nombre:</b> ${patient.name}</p>
      <p><b>Edad:</b> <?=$register['age']?></p>
      <p><b>Fecha:</b> ${submittedAt.toLocaleString()}</p>
    </div>

    <div class="bg-black/30 p-4 rounded-lg text-left max-h-48 overflow-y-auto">
      ${questions.map((q, i) => `
        <div class="flex justify-between border-b border-white/10 py-1">
          <span class="truncate">${q.question}</span>
          <b class="text-emerald-400">${answers[i]}</b>
        </div>
      `).join('')}
    </div>
	<br>
    <button onclick="reset()" class="w-full py-3 px-8 font-bold rounded-full text-white shadow-lg
         bg-gradient-to-r from-[#3C506D] to-[#627892]
         hover:scale-105 hover:shadow-2xl
         transform transition-all duration-300
         focus:outline-none focus:ring-4 focus:ring-[#627892]/50
         disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
      Enviar resultados
    </button>
  </div>`;
}

function reset() {
	

  	const data = new FormData();
	data.append('idClient', "<?php echo $idClient?>");
	data.append('patient', "<?php echo $idpatient;?>");
	data.append('codes', "<?php echo $register['codes']?>");
	data.append('is_share', <?php echo (int)$is_share?>);
	questions.forEach((q, index) => {
		data.append(`question_${q.id}`, answers[index]);
	});
	
	
	fetch('form5.php', {
		method: 'POST',
		body: data
	});
	window.location.href = 'https://www.google.com';
}

/* INIT */
render();
</script>

</body>
</html>


<?php } else { ?>
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
		.radio-grande{
			appearance: none; /* quitamos el estilo nativo del radio */
			-webkit-appearance: none;
			width: 20px;
						height: 20px;
			border-radius: 50%;
			background: white;
			position: relative;
			cursor: pointer;
			font-size: 12px;
			text-align: center;
		}
		.radio-grande2{
			appearance: none; /* quitamos el estilo nativo del radio */
			-webkit-appearance: none;
			width: 20px;
						height: 20px;
			border-radius: 50%;
			background: white;
			position: relative;
			cursor: pointer;
			font-size: 12px;
			text-align: center;
		}
		.radio-grande2[value="0"]::before {
			content: "2"; /* usa el value del input */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: rgba(0,0,0,0.5);
			font-size: 12px;
			pointer-events: none; /* evita bloquear clic */
		}
		.radio-grande2[value="1"]::before {
			content: "1"; /* usa el value del input */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: rgba(0,0,0,0.5);
			font-size: 12px;
			pointer-events: none; /* evita bloquear clic */
		}
		.radio-grande[value="1"]::before {
			content: "X"; /* usa el value del input */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: rgba(0,0,0,0.5);
			font-size: 12px;
			pointer-events: none; /* evita bloquear clic */
		}
		.radio-grande[value="0"]::before {
			content: "X"; /* usa el value del input */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: rgba(0,0,0,0.5);
			font-size: 12px;
			pointer-events: none; /* evita bloquear clic */
		}
		.radio-grande:checked {
			background: #04468c;
			color: rgba(0,0,0,1);
		}
		.radio-grande2:checked {
			background: #04468c;
			color: rgba(0,0,0,1);
		}
		.table-bordered th, .table-bordered td{
			border:1px solid rgba(0,0,0,1);
		}
		.table-striped tbody tr:nth-of-type(odd){
			background-color:#EEEFF6;
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
		.col-id {
			background-color: #04468c !important; 
			color: white !important;            
			font-weight: bold;
			text-align: center;
		}
		.col-text {
			background-color: #04468c !important; 
			color: white !important;            
			font-weight: bold;
			text-align: center;
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
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo" style="height: 100px;width: auto;"  src="../../assets/img/test_image/cmasr2.png">
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
						<form method="<?=!$is_view?'POST':''?>" action="<?=!$is_view?'form3.php':''?>">
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
								<p>Las oraciones que aparecen en este formulario dicen cómo piensan y sienten algunas personas acerca mismas. Lee con cuidado cada oración y luego encierra en un círculo la palabra que corresponda a tu respuesta. Marca una "X" en la columna de Sí, si piensas que así eres y en la columna No si crees que no eres asi. Responde a cada oración, incluso si te resulta difícil elegir una respuesta que se aplique a ti. No marques Sí y No para la misma oración. <br>
							 	<br> No hay respuestas correctas ni incorrectas; sólo tú puedes decirnos cómo piensas y sientes con respecto a ti mismo. Recuerda, después de leer cada oración, pregúntate: "¿Es cierto en mi caso?". Si es así, encierra Sí en un círculo; si no lo es, encierra el No. </p>
								<br>
								
							</div>
							
							<br>
							
						</div>
						<div class="card card-table-two">
							
							<div class="table-responsive country-table">
								
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
									<input type="hidden" name="is_share" value="<?=(int)$is_share?>">
									<input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
									<input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
									<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
									<thead>
										<tr>
											<th class="wd-lg-5p"></th>
											<th class="wd-lg-100p"></th>
											<th class="wd-lg-25p tx-right col-text">SI</th>
											<th class="wd-lg-25p tx-right col-text">NO</th>
											<th class="wd-lg-5p" ></th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($answers as $answer){
										?>
										<tr>
											<td class="col-id"><?=$answer['item_order']?></td>
											<td><?=htmlspecialchars($answer['question'])?></td>
											<td class="tx-right tx-medium tx-inverse">
											<input class="radio-grande" name="question_<?=$answer['id']?>" value="1" type="radio" <?=$answer['response']=='1'?'checked':'' ?> <?=$is_view?'disabled':''?>>
											</td>
											<td class="tx-right tx-medium tx-inverse">
											<input class="radio-grande" name="question_<?=$answer['id']?>" value="0" type="radio" <?=$answer['response']=='0'?'checked':'' ?> <?=$is_view?'disabled':''?>>
											</td>
											
											<td class="col-id"><?=$answer['item_order']?></td>
										</tr>
										
										<?php }?>
									</tbody>
								</table>
								<br>
								<?php if(!$is_view){?>
								<button type="submit" class="btn btn-primary"><?=$text_button_send?></button>
								<?php }?>
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
		<script>
			document.addEventListener("DOMContentLoaded", function () {
				const radios = document.querySelectorAll("input[name='example1t']");
				const textoSpan = document.getElementById("text_test_show1");

				radios.forEach(radio => {
					radio.addEventListener("change", function () {
						if (this.checked) {
							if (this.value === "1") {
								textoSpan.textContent = "Muy bien, continua con la otra frase.";
							} else if (this.value === "0") {
								textoSpan.textContent = "Vuelve a leer correctamente el ejemplo.";
							}
						}
					});
				});

				const radios2 = document.querySelectorAll("input[name='example2t']");
				const textoSpan2 = document.getElementById("text_test_show2");

				radios2.forEach(radio => {
					radio.addEventListener("change", function () {
						if (this.checked) {
							if (this.value === "0") {
								textoSpan2.textContent = "Muy bien, procede a responser las frases.";
							} else if (this.value === "1") {
								textoSpan2.textContent = "Vuelve a leer correctamente el ejemplo.";
							}
						}
					});
				});
			});
		</script>										
	</body>
</html>
<?php } ?>