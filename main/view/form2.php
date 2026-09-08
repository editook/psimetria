<?php
    include_once('../configs.php');
	//AF-5
	session_start();
	include('../connection.php');
	include("../models/model_register.php");
    include("../models/model_question.php");
    include("../models/model_answer.php");
	include("../services/answer_service.php");
    $registerModel = new Register_Model();
    $questionModel = new Question_Model();
	$answerModel = new Answer_Model();
	$answerService = new AnswerService($answerModel,$registerModel);
    $idClient = 0;
    $idpatient = 0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $result = $answerService->processForm($_POST);
		$answerService->externalRedirect($result); 
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

	$answerService->externalFinishRedirect($register['status'],$is_share); 
	
    $answers = $answerModel->getAll($register['codes']);
	$device = $registerModel->getDeviceType();
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
	<link href="../../assets/css/share-form.css?v=<?=VERSION_CODE?>" rel="stylesheet">

</head>

<body class="min-h-screen w-full bg-gradient-to-br from-[#0B2B5E] via-[#0D47A1] to-[#1976D2] flex items-center justify-center p-3 md:p-5 font-sans antialiased">

  <main class="w-full max-w-4xl mx-auto">
    
    <div class="rounded-3xl shadow-2xl overflow-hidden border border-white/20 backdrop-blur-sm bg-white/5 transition-all duration-300">
      <div id="app"></div>
    </div>
  </main>

<script>
/* =============================
   DATOS
============================= */
var questions = <?php echo json_encode($answers)?>;
var fullname  = <?php echo json_encode($register['id_client'])?>;
var testname = <?php echo json_encode($register['type_question_name'])?>;
//questions = questions.slice(0, 10);
let answers = Array(questions.length).fill(null);
let currentIndex = 0;
let patient = {};
let finished = false;
let submittedAt = null;

/* =============================
   RENDER PRINCIPAL
============================= */
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

function renderPatientForm() {
  return `
    <div class="p-6 md:p-10 lg:p-12" style="background: #fff;">
      <!-- Header con progreso decorativo -->
      <div class="flex justify-between items-center mb-6 border-b border-white/20 pb-4">
        <div class="flex items-center gap-3">
          
          <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text">${testname}</h1>
            
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
		 A continuación encontrarás una serie de frases. Lee cada una de ellas cuidadosamente y contesta con un valor entre 1 y 99, según tu grado de acuerdo con lo que se indica.
        </p>
		<div class="flex justify-between items-center px-4 py-1 bg-yellow-100 rounded-md">
			<span class="font-semibold text-sm text-rose-400">1 = En total desacuerdo</span>
			<span class="font-semibold text-sm text-emerald-400">99 = En total acuerdo</span>
		</div>
        <p class="text-black/80 text-sm leading-relaxed mb-5">Por ejemplo, si la frase dice "La música ayuda al bienestar humano" y estás muy de acuerdo, contestarías con un valor alto, como por ejemplo el 94.</p>
		<div class="flex justify-between items-center px-4 py-1 bg-yellow-100 rounded-md">
			<span class="text-black-200 text-sm">La música ayuda al bienestar humano</span>
			<span class="font-semibold text-emerald-400">94</span>	
			
		</div>
        <p class="text-black/80 text-sm leading-relaxed mb-5">Por lo contrario, si estás muy poco de acuerdo, elegirías un valor bajo, por ejemplo el 9.</p>
		<div class="flex justify-between items-center px-4 py-1 bg-yellow-100 rounded-md">
			<span class="text-black-200 text-sm">La música ayuda al bienestar humano</span>
			<span class="font-semibold text-rose-400">9</span>	
			
		</div>
        <p class="text-black/80 text-sm leading-relaxed mb-5">No olvides que dispones de muchas opciones de respuesta, en concreto, puedes elegir entre 99 valores. Escoge el que más se ajuste a tu criterio.</p>
        <p class="text-center font-semibold text-sm sm:text-base text-black/90 mb-4">RECUERDA: CONTESTA CON LA MÁXIMA SINCERIDAD.</p>
        <!-- Cuadro de valores tipo test (igual a la imagen) -->
        
      </div>
      
      <!-- Botón comenzar -->
      <button type="button" onclick="startQuiz()" style="background: #0B2B5E;"
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

function renderQuestion() {
  const progressPercent = Math.round(((currentIndex) / questions.length) * 100);
  
  
  const currentQ = questions[currentIndex];
  const value = questions[currentIndex] ?? '';
  return `
    <div class="p-6 md:p-9" style="background: #fff;">
      
      <div class="flex justify-between items-center mb-6  pb-4">
        <div class="flex items-center gap-3">
          
          <div >
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text">${testname}</h1>
            
            <p class="text-black/80 text-sm leading-relaxed mb-5">
			A continuación encontrarás una serie de frases. Lee cada una de ellas cuidadosamente y contesta con un valor entre 1 y 99, según tu grado de acuerdo con lo que se indica.
			</p>
			<div class="flex justify-between items-center px-4 py-1 bg-yellow-100 rounded-md">
				<span class="font-semibold text-sm text-rose-400">1 = En total desacuerdo</span>
				<span class="font-semibold text-sm text-emerald-400">99 = En total acuerdo</span>
			</div>
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
      <form onsubmit="submitAnswer(event)" class="flex flex-col items-center gap-6">
		<div class="text-center">
			<p class="text-sm text-gray-400 block mb-2">
			Ingrese un valor de 1 a 99
			</p>
			<input id="answerInput" type="number" min="1" max="99" required
			value="${value}"
			class="w-40 text-center text-3xl font-bold bg-black/20 border border-white/20 rounded-lg px-4 py-3 focus:ring-2 focus:ring-cyan-400"/>
		</div>

		<button class="px-12 py-3 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 font-bold">
			Siguiente
		</button>
    </form>
      
      <!-- Navegación Anterior con estilo mejorado -->
      <div class="flex justify-between items-center">
        <button onclick="back()" 
          class="flex items-center gap-2 px-5 py-2 rounded-full bg-black/10 backdrop-blur-sm hover:bg-black/20 transition text-black/90 font-medium text-sm">
          <i class="fas fa-arrow-left text-xs"></i> Anterior
        </button>
        
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

/* =============================
   LOGICA RESPUESTAS
============================= */
function submitAnswer(e) {
  e.preventDefault();
  const value = Number(answerInput.value);

  if (value < 1 || value > 99) return;

  answers[currentIndex] = value;
  currentIndex++;

  if (currentIndex >= questions.length) {
    finished = true;
    submittedAt = new Date();
  }
  render();
}

function goBack() {
  if (currentIndex > 0) currentIndex--;
  render();
}

function restoreAnswer() {
  const input = document.getElementById('answerInput');
  if (input) input.select();
}

/* =============================
   RESUMEN FINAL
============================= */
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
    <button onclick="restart()" class="w-full font-bold py-3 px-8 rounded-full shadow-xl
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

/* =============================
   RESET
============================= */
function restart() {
  
  const data = new FormData();
	data.append('idClient', "<?php echo $idClient?>");
	data.append('patient', "<?php echo $idpatient;?>");
	data.append('codes', "<?php echo $register['codes']?>");
	data.append('is_share', <?php echo (int)$is_share?>);
	questions.forEach((q, index) => {
		data.append(`question_${q.id}`, answers[index]);
	});
	
	
	fetch('form2.php', {
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
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
		<script src="https://cdn.tailwindcss.com"></script>
  		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<style>
		
			.i-disabled {
				pointer-events: none;
			}

			.answered { background-color: #e5fa9f9d; }
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
					<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-4 md:p-6">

						<!-- Header -->
						<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
							<h1 class="text-lg md:text-xl font-semibold">
							<i class="fas fa-clipboard-list text-blue-500"></i>
								Formulario <?=$register['type_question_name']?>
							</h1>
							<br>
							
							<span id="progress" class="text-sm text-gray-600"></span>
						</div>
						<div>
							<p class="text-sm text-black/70 mb-2 mt-2">#<?= $register['id'] ?> ID: <?=$register['id_client']?></p>
						</div>
						<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-8" id="options">

						</div>

						<form method="<?=!$is_view?'POST':''?>" action="<?=!$is_view?'form1.php':''?>">
							<div id="hiddenAnswers"></div>
							<input type="hidden" name="is_share" value="<?=(int)$is_share?>">
							<input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
							<input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
							<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
							<!-- DESKTOP TABLA -->
							<div class="hidden md:block overflow-x-auto">
							<table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
								<thead class="bg-gradient-to-br from-[#0B2B5E] via-[#0D47A1] to-[#0B2B5E] text-white">
								<tr>
									<th class="p-3 text-left">Conteste de 1 a 99 en las casillas correspondientes a cada pregunta</th>
									<th class="p-3 text-center" width="80">1-99</th>
								</tr>
								</thead>
								<tbody id="tableDesktop"></tbody>
							</table>
							</div>

							<!-- MOBILE CARDS -->
							<div class="md:hidden space-y-3" id="mobileContainer"></div>

							<!-- NAV -->
							<div class="mt-6 flex justify-between">
							<button type="button" id="prevBtn"
								class="bg-gray-300 px-4 py-2 rounded">Anterior</button>

							<button type="button" id="nextBtn"
								class="bg-blue-500 text-white px-4 py-2 rounded" style="background: #0B2B5E;">Siguiente</button>
							</div>

							<!-- SUBMIT -->
							<div class="mt-4 flex justify-center">
							<?php if(!$is_view){?>
							<button type="submit"
								class="bg-green-500 text-white px-6 py-2 rounded-lg" >
								<?=$text_button_send?>
							</button>
							<?php }?>
							
							</div>

						</form>
					</div>
					<div class="breadcrumb-header justify-content-between"></div>
                        
					
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
			const answersadmin = <?php echo json_encode($answers)?>;
			const device = <?php echo json_encode($device)?>;
			
			const is_view = <?php echo json_encode($is_view)?>;
			const perPage = 10;
			let currentPage = 0;

			const desktopTable = document.getElementById("tableDesktop");
			const mobileContainer = document.getElementById("mobileContainer");
			const progress = document.getElementById("progress");
			const divoptions = document.getElementById("options");
			
			function render() {
				desktopTable.innerHTML = "";
				mobileContainer.innerHTML = "";

				const start = currentPage * perPage;
				const end = start + perPage;

				answersadmin.slice(start, end).forEach((q, i) => {
					const index = start + i;
					const id = answersadmin[index].id;
					
					/* ===== DESKTOP ===== */
					if(device == "desktop"){
						const tr = document.createElement("tr");

						tr.innerHTML = `
						<td class="p-3 text-gray-900"><span class="font-semibold">${q.item_order}. </span>${q.question}</td>
						
						${[1].map(val => `
							<td class="text-center pr-3">
							<input type="number" style="background: #dddddd;" name="question_${id}" value="${q.response == null || q.response == '0'?"":q.response}" class="w-full p-2 rounded-xl text-black ${is_view ? "i-disabled" : ""}"
								 >
							</td>
						`).join("")}
						`;

						tr.querySelectorAll("input").forEach(input => {
							input.addEventListener("change", () => {
								
								answersadmin[index].response = input.value;
								tr.classList.add("answered");
								
								syncHiddenInputs();
								updateProgress();
							});
						});

						if (q.response!= null && q.response != '0') tr.classList.add("answered");

						desktopTable.appendChild(tr);
					}
					

					/* ===== MOBILE ===== */
					if(device != "desktop"){
						const card = document.createElement("div");
						card.className = "border rounded-lg p-3 shadow-sm";

						card.innerHTML = `
						<p class="mb-2 font-medium">${index+1}. ${q.question}</p>
						<div class="grid grid-cols-1 gap-2 text-center">
							${[1].map(val => `
							<label class="rounded p-2 ${answersadmin[index].response==val?'bg-yellow-100':''}">
								<input type="number" style="background: #dddddd;" name="question_${id}" value="${q.response == null || q.response == '0'?"":q.response}" class="w-full p-2 rounded-xl text-black ${is_view ? "i-disabled" : ""}"
								 >
							</label>
							`).join("")}
						</div>
						`;

						card.querySelectorAll("input").forEach(input => {
							
							input.addEventListener('change', function() {
								// Convertir el valor a número
								let value = parseInt(input.value);
								
								// Validar el valor
								if (isNaN(value)) {
									input.value = input.value || 1; // Si no es número, poner valor mínimo
								} else if (value > 99) {
									input.value = 99;
								} else if (value < 1) {
									input.value = 1;
								}
								answersadmin[index].response = input.value;
								updateProgress();
								syncHiddenInputs();
								render(); 
							});

							// También validar mientras escribe (evento 'input')
							input.addEventListener('input', function() {
								let value = parseInt(input.value);
								
								if (!isNaN(value)) {
									if (value > 99) {
										input.value = 99;
									} else if (value < 1) {
										input.value = 1;
									}
									
								}
							});
						});
						if (q.response!= null && q.response != '0') card.classList.add("answered");
						mobileContainer.appendChild(card);
					}
					
				});

				updateProgress();
			}
			function syncHiddenInputs() {
				const container = document.getElementById("hiddenAnswers");
				container.innerHTML = "";

				answersadmin.forEach(item => {
					if (item.response !== null && item.response !== undefined) {
						const input = document.createElement("input");
						input.type = "hidden";
						input.name = "question_" + item.id;
						input.value = item.response;

						container.appendChild(input);
					}
				});
			}
			function updateProgress() {
				const total = answersadmin.length;
				var answered = 0;
				answersadmin.forEach(item => {
					if(item.response != null){
						answered++;		
					}
				});
				progress.textContent = `${answered} / ${total} respondidas`;
			}

			/* NAV */
			document.getElementById("nextBtn").onclick = () => {
			if ((currentPage + 1) * perPage < answersadmin.length) {
				currentPage++;
				render();
			}
			};

			document.getElementById("prevBtn").onclick = () => {
			if (currentPage > 0) {
				currentPage--;
				render();
			}
			};

			document.querySelector("form").addEventListener("submit", () => {
				desktopTable.innerHTML = "";
				mobileContainer.innerHTML = "";
				syncHiddenInputs();
				
			});
			document.addEventListener("DOMContentLoaded", () => {
				document.addEventListener("keydown", (e) => {
					if (e.key === "Enter") {
						console.log(1);
						e.preventDefault();
					}
				});
			});
			
						

			render();
		</script>
		<script>
			document.addEventListener("DOMContentLoaded", () => {
				document.querySelectorAll('input[name^="question_"]').forEach(input => {
					// Agregar evento cuando el usuario termina de editar (evento 'change')
					input.addEventListener('change', function() {
						// Convertir el valor a número
						let value = parseInt(this.value);
						
						// Validar el valor
						if (isNaN(value)) {
							this.value = this.min || 0; // Si no es número, poner valor mínimo
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
			});
			
		</script>
	</body>
</html>
<?php } ?>