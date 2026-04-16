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
    $idClient = '0';
    $idpatient = '0';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $idUser = $_POST['idClient'];
        $idpatient = $_POST['patient'];
		
		$codes = $_POST['codes'];
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
		$array = $registerModel->updateStatus($idUser,$idpatient,$status);
		$is_share_link = $_POST['is_share'];
		if($is_share_link == "1"){
			echo "<script>
				alert('FALLO DE ACCESO CODIGO #876 - ".$idpatient." redirigiendo...');
				window.location.href = 'https://www.google.com';
			</script>";
			exit;
		}
		else{
			header("Location: ".LOCALHOST);
			exit;
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
    $answers = $answerModel->getAll($register['codes']);
	
	$device = $registerModel->getDeviceType();
	//echo json_encode($register);
?>

<!DOCTYPE html>
<?php if ($is_share) { ?>

<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=WEB_TITLE?> </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
	<style>
	* { font-family: 'Inter', sans-serif; }
	/* scroll suave y personalizado */
	.custom-scroll::-webkit-scrollbar { width: 4px; }
	.custom-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); border-radius: 10px; }
	.custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.4); border-radius: 10px; }
	.card-glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.2); }
	.btn-option { transition: all 0.2s ease; transform: scale(1); }
	.btn-option:active { transform: scale(0.97); }
	.progress-bar-animated { transition: width 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1); }
	.hover-scale { transition: transform 0.2s ease, box-shadow 0.2s ease; }
	.hover-scale:hover { transform: translateY(-2px); box-shadow: 0 20px 25px -12px rgba(0,0,0,0.25); }
	.option-card { backdrop-filter: blur(4px); background: rgba(0, 0, 0, 0.25); border-radius: 1.5rem; transition: all 0.2s; }
	.option-card:hover { background: rgba(255,255,255,0.15); transform: translateY(-2px); }
	</style>

</head>

<body class="min-h-screen w-full bg-gradient-to-br from-[#0B2B5E] via-[#0D47A1] to-[#1976D2] flex items-center justify-center p-3 md:p-5 font-sans antialiased">

  <main class="w-full max-w-4xl mx-auto">
    <!-- Tarjeta principal con efecto glassmorphism premium -->
    <div class="rounded-3xl shadow-2xl overflow-hidden border border-white/20 backdrop-blur-sm bg-white/5 transition-all duration-300">
      <div id="app"></div>
    </div>
  </main>
<script>
/* ===========================
   DATOS
=========================== */

var questions = <?php echo json_encode($answers)?>;
questions = questions.slice(0, 10);
//console.log(questions);
var fullname  = <?php echo json_encode($register['id_client'])?>;

var testname = <?php echo json_encode($register['type_question_name'])?>;
const options = [
  { value: 0, text: 'Nada'},
  { value: 1, text: 'Poco'},
  { value: 2, text: 'Moderadamente'},
  { value: 3, text: 'Bastante'},
  { value: 4, text: 'Mucho'}
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

//FORMULARIO PACIENTE
function renderPatientForm() {
  return `
    <div class="p-6 md:p-10 lg:p-12" style="background: #fff;">
      <!-- Header con progreso decorativo -->
      <div class="flex justify-between items-center mb-6 border-b border-white/20 pb-4">
        <div class="flex items-center gap-3">
          
          <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text">${testname}</h1>
            <p class="text-sm text-black/70">Evaluación de síntomas</p>
          </div>
        </div>
      </div>
      
      <!-- Info paciente (precargado) -->
      <div class="card-glass rounded-2xl">
        <label class="block text-sm font-semibold mb-2 flex items-center gap-2">ID: ${fullname}</label>
        
      </div>

      <!-- Instrucciones mejoradas (estilo imagen) -->
      <div class="mb-6 card-glass rounded-2xl mb-7">
        
        <label class="block text-sm font-semibold mb-2 flex items-center gap-2">Instrucciones</label>
        <p class="text-black/80 text-sm leading-relaxed mb-5">
          Encontrará una serie de afirmaciones sobre <strong class="text-amber-300">MOLESTIAS o PROBLEMAS</strong> que pueden afectar en mayor o menor medida a todas las personas. Conteste cada una teniendo en cuenta lo que ha experimentado durante las <strong>últimas semanas</strong>, incluido el día de hoy.
        <br>
        Para ello, marque junto a cada afirmación una de las siguientes opciones:
          </p>
        
        <!-- Cuadro de valores tipo test (igual a la imagen) -->
        <div class="bg-gradient-to-br from-white-900/60 to-white/40 rounded-2xl p-4 border border-white/20" style="background:white">
          <p class="text-center font-semibold text-sm sm:text-base text-white/90 mb-4">
            <i class="fas fa-chart-simple mr-2"></i> Valore el grado de cada síntoma en las últimas semanas:
          </p>
          <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-center">
            ${options.map(opt => `
              
              <button 
      class="
        btn-option
        rounded-2xl
        border-[3px]
        border-blue-700
        bg-white
        px-3
        py-2
        min-h-[70px]
        flex
        items-center
        justify-center
        text-center
        transition-all
        duration-200
        hover:bg-blue-50
        hover:scale-[1.02]
        active:scale-95
        shadow-sm
      ">
      <div class="flex flex-col items-center gap-1" style="color: rgb(29 78 216 / var(--tw-border-opacity, 1));">
        <span class="text-base text-black/70 uppercase tracking-wide">${opt.value}</span>
        <span class="font-bold text-blue/70 text-base mt-1">${opt.text}</span>
              
       </div>
            `).join('')}
          </div>
        </div>
      </div>
      
      <!-- Botón comenzar -->
      <button type="button" onclick="startQuiz()"
        class="w-full relative group overflow-hidden font-bold py-4 px-6 rounded-2xl shadow-xl bg-gradient-to-r from-[#3B82F6] via-[#1E6DFF] to-[#0A4DDA] text-white text-lg tracking-wide
        transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-blue-400/50">
        <span class="relative z-10 flex items-center justify-center gap-3"><i class="fas fa-play-circle"></i> Comenzar Cuestionario</span>
        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      </button>
      <p class="text-center text-white/40 text-xs mt-5"><i class="fas fa-lock-open"></i> Sus respuestas son confidenciales</p>
    </div>
  `;
}


function startQuiz() {
  patient.name = fullname;
  render();
}

//PREGUNTAS
function renderQuestion() {
  const progressPercent = Math.round(((currentIndex) / questions.length) * 100);
  
  console.log(progressPercent);
  const currentQ = questions[currentIndex];
  
  return `
    <div class="p-6 md:p-9" style="background: #fff;">
      
      <div class="flex justify-between items-center mb-6  pb-4">
        <div class="flex items-center gap-3">
          
          <div >
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text">${testname}</h1>
            <p class="text-sm text-black/70">Evaluación de síntomas</p>
            <p class="text-black/80 text-sm leading-relaxed pt-5 border-t border-black/20">
                Encontrará una serie de afirmaciones sobre <strong class="text-amber-300">MOLESTIAS o PROBLEMAS</strong> que pueden afectar en mayor o menor medida a todas las personas. Conteste cada una teniendo en cuenta lo que ha experimentado durante las <strong>últimas semanas</strong>, incluido el día de hoy.
                </p>
          </div>
           
        </div>
      </div>
      
      
      <div class="mb-5">
        <div class="flex justify-between text-xs font-semibold text-black/80 mb-1">
          <span><i class="fas fa-tasks mr-1"></i> </span>
          <span>${currentIndex + 1} / ${questions.length}</span>
        </div>
        <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden shadow-inner">
          <div class="h-3 bg-gradient-to-r from-cyan-300 via-sky-400 to-blue-500 rounded-full progress-bar-animated" style="width:${progressPercent}%"></div>
        </div>
      </div>
      
      <!-- Tarjeta de pregunta moderna -->
      <div class="card-glass rounded-2xl p-6 md:p-8 mb-8 text-center">
        
        <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-black leading-tight tracking-wide">
          ${escapeHtml(currentQ.question)}
        </h2>
      </div>
      
      <!-- Botones de opción estilo premium (5 columnas en desktop, 2 en mobile mejorado) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-8">
  ${options.map(opt => `
    <button onclick="answer(${opt.value})"
      class="
        btn-option
        rounded-2xl
        border-[3px]
        border-blue-700
        bg-white
        px-3
        py-2
        min-h-[70px]
        flex
        items-center
        justify-center
        text-center
        transition-all
        duration-200
        hover:bg-blue-50
        hover:scale-[1.02]
        active:scale-95
        shadow-sm
      ">
      <div class="flex flex-col items-center gap-1" style="color: rgb(29 78 216 / var(--tw-border-opacity, 1));">
        <span class="text-base text-black/70 uppercase tracking-wide">${opt.value}</span>
        <span class="font-bold text-blue/70 text-base mt-1">${opt.text}</span>
              
       </div>

    </button>
  `).join('')}
</div>
      
      <!-- Navegación Anterior con estilo mejorado -->
      <div class="flex justify-between items-center">
        <button onclick="back()" 
          class="flex items-center gap-2 px-5 py-2 rounded-full bg-black/10 backdrop-blur-sm hover:bg-black/20 transition text-black/90 font-medium text-sm">
          <i class="fas fa-arrow-left text-xs"></i> Anterior
        </button>
        <div class="text-xs text-black/40"><i class="fas fa-hand-pointer"></i> Seleccione una opción</div>
      </div>
    </div>
  `;
}
function escapeHtml(str) {
  if(!str) return '';
  return str.replace(/[&<>]/g, function(m) {
    if(m === '&') return '&amp;';
    if(m === '<') return '&lt;';
    if(m === '>') return '&gt;';
    return m;
  }).replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, function(c) {
    return c;
  });
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
  <div class="p-8 text-center" style="background: #fff;">

    <h2 class="text-3xl font-bold text-black-400 mb-2">¡Completado!</h2>
    <p class="text-black/80 mb-4">Gracias por responder</p>

    <div class="bg-blue/10 p-4 rounded-lg text-left mb-4">
      <p><b>Nombre:</b> ${patient.name}</p>
      <p><b>Edad:</b> <?=$register['age']?></p>
      <p><b>Fecha:</b> ${submittedAt.toLocaleString()}</p>
    </div>

    <div class="bg-blue/10 p-4 rounded-lg text-left max-h-48 overflow-y-auto border-t border-black/20">
      ${questions.map((q, i) => `
        <div class="flex justify-between border-b border-white/10 py-1">
          <span class="truncate">${q.question}</span>
          <b class="text-black-400">${answers[i]}</b>
        </div>
      `).join('')}
    </div>
	<br>
    <button onclick="reset()" class="w-full font-bold py-3 px-8 rounded-full shadow-xl
         bg-gradient-to-r from-[#4D8DFF] to-[#0162E8]
         text-white
         transform transition-all duration-300
         hover:scale-105 hover:shadow-2xl
         focus:outline-none focus:ring-4 focus:ring-[#6EA3FF]/50
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
	
	
	fetch('form1.php', {
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
		<link href="../../assets/css/icons.css?v=<?=VERSION_CODE?>" rel="stylesheet">

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
		.radio-grande::before {
			content: attr(value); /* usa el value del input */
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			color: rgba(0,0,0,0.5);
			font-size: 12px;
			pointer-events: none; /* evita bloquear clic */
		}
		.radio-grande:checked {
			background: #0162e8;
			color: rgba(0,0,0,1);
		}
		.table-bordered th, .table-bordered td{
			border:1px solid #0162e8;
		}
		.table-striped tbody tr:nth-of-type(odd){
			background-color:#E6F0FF;
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
		<div class="page <?=TESTING=='1'?'istesting':''?>">

			
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
						<div class="card" style="border: 0px solid transparent !important;box-shadow: none !important;background-color: #dcdcdc !important;">
						
							<div class="card-body">
								<div class="row row-sm" style="place-items: center;">
										<div class="col-lg-2 img-container" style="display: flex;justify-content: space-between;align-items: center;align-content: center;">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo" style="height: 100px;width: auto;"  src="../../assets/img/test_image/logolsb5.jpeg">
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
								<div class="justify-center" style="place-items: center;">
									<div class="boton-format" style="padding: 10px;
    border-radius: 20px;
    background-color: #0162e8;
    color: white;
    margin: 1px;
    text-align: center;
    width: min-content;font-weight: bold;
    height: auto;">
										INSTRUCCIONES
									</div>
									<p>Encontrara una serie de afirmaciones sobre <span style="font-weight: bold;">MOLESTIAS o PROBLEMAS</span> que pueden afectar en mayor o menor medida
									a todas las personas. Conteste a cada una ellas teniendo en cuenta aquello o experimentado <span style="font-weight: bold;">durante las ultimas semanas, incluido el dia  de hoy.</span>
									<br>
									Para ello, marque junto a cada aformacion una de las siguientes opciones:	
									</p>
									<p style="font-weight: bold;color:#0162e8">Valore el grado que ha tenido cada uno  de los siguientes sintomas en las ultimas semanas.</p>
									<table class="table table-striped table-bordered" style="border:1px solid black;table-layout: fixed;font-weight: bold;color:#0162e8;text-align-last: center;">
										<thead>	
											<tr>
												<th style="width:70px;max-width: 70px;background: #0162e8;color: white;">0</th>
												<th style="width:70px;max-width: 70px;background: #0162e8;color: white;">1</th>
												<th style="width:70px;max-width: 70px;background: #0162e8;color: white;">2</th>
												<th style="width:70px;max-width: 70px;background: #0162e8;color: white;">3</th>
												<th style="width:70px;max-width: 70px;background: #0162e8;color: white;">4</th>
											</tr>
										</thead>
										<tbody>
											<tr style="color:#505991">
											<td>Nada</td>
											<td>Poco</td>
											<td>Moderadamente</td>
											<td>Bastante</td>
											<td>Mucho</td>
											</tr>
											
										</tbody>
									</table>
									<br>
								</div>

								
								<div class="table-responsive country-table">
                                    <form method="<?=!$is_view?'POST':''?>" action="<?=!$is_view?'form1.php':''?>">
                                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
										<input type="hidden" name="is_share" value="<?=(int)$is_share?>">
                                        <input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
                                        <input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
										<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
                                        
										<tbody>
                                            <?php
                                                foreach($answers as $answer){
                                            ?>
											<tr>
                                                <td><?=$answer['item_order']?></td>
												<td><?=htmlspecialchars($answer['question'])?></td>
												<td class="tx-right tx-medium tx-inverse">
                                                <input class="radio-grande" name="question_<?=$answer['id']?>" value="0" type="radio" <?=$answer['response']=='0'?'checked':'' ?> <?=$is_view?'disabled':''?>>
                                            	
											</td>
                                                <td class="tx-right tx-medium tx-inverse">
                                                <input class="radio-grande" name="question_<?=$answer['id']?>" value="1" type="radio" <?=$answer['response']=='1'?'checked':'' ?> <?=$is_view?'disabled':''?>>
                                                </td>
                                                <td class="tx-right tx-medium tx-inverse">
                                                <input class="radio-grande" name="question_<?=$answer['id']?>" value="2" type="radio" <?=$answer['response']=='2'?'checked':'' ?> <?=$is_view?'disabled':''?>>
                                                </td>
                                                <td class="tx-right tx-medium tx-inverse">
                                                <input class="radio-grande" name="question_<?=$answer['id']?>" value="3" type="radio" <?=$answer['response']=='3'?'checked':'' ?> <?=$is_view?'disabled':''?>>
                                                </td>
                                                <td class="tx-right tx-medium tx-inverse">
                                                <input class="radio-grande" name="question_<?=$answer['id']?>" value="4" type="radio" <?=$answer['response']=='4'?'checked':'' ?> <?=$is_view?'disabled':''?>>
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

				<!-- Sticky js -->
		<script src="../../assets/js/sticky.js"></script>

		<!-- Right-sidebar js -->
		<script src="../../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- custom js -->
		<script src="../../assets/js/custom.js"></script>

	</body>
</html>

<?php } ?>