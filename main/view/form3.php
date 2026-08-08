<?php
    include_once('../configs.php');
	//MACI
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
	$answerService->externalFinishRedirect($register['status'],$is_share); 
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
/* ===========================
   DATOS
=========================== */

var questions1 = <?php echo json_encode($answer_part1)?>;
var questions = <?php echo json_encode($answers)?>;
var fullname  = <?php echo json_encode($register['id_client'])?>;
var testname = <?php echo json_encode($register['type_question_name'])?>;
var oth = { ...questions1[0] };
oth.question = "Otros (escribe cuáles)";
oth.id = '0';
questions = [...questions1,oth, ...questions];
//questions = questions.slice(0, 20);
var options = [
  { value: 1, text: '1' },
  { value: 0, text: '2' }
];

/* ===========================
   ESTADO
=========================== */
let currentIndex = 0;
let answers = [];
let patient = {};
let others = "";
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
          Esta prueba consiste en una lista de frases que la gente joven usa para describirse a sí misma. Se presentan aquí para ayudarte a describir tus sentimientos y actitudes. Cuando contestes trata de hacerlo honesta y seriamente como puedas, ya que los resultados serán utilizados para ayudar a conocerte y poder ayudarte a planear tu futuro. No te preocupes si algunas de las frases no te parecen muy corrientes; se han incluido para ayudar a adolescentes con muchos tipos de problemas. No hay límite de tiempo para completar el inventario, aunque es mejor trabajara un ritmo rápido pero cómodo.
       
        </p>
        
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

/* ===========================
   PREGUNTAS
=========================== */
function renderQuestion() {
	const progressPercent = Math.round(((currentIndex) / questions.length) * 100);
  
	const currentQ = questions[currentIndex];
	if(currentQ.id == "0"){
		options = [
			{ value: 1, text: 'VERDADERO'},
			{ value: 0, text: 'FALSO'}
			];
	}
	var inputSecondQuestion = "";
	if(currentIndex<11){
		inputSecondQuestion = `
		A continuación encontrarás una serie de problemas que suelen preocupar a las personas. Si crees que alguno de ellos es <strong class="text-black-500">TU PRINCIPAL PROBLEMA</strong> , márcalo con un <strong class="text-black-500">1</strong> y si piensas en ello, pero <strong class="text-black-500">NO TE PREOCUPA</strong>, márcalo con un <strong class="text-black-500">2</strong>.
		`;
	}
	else{
		inputSecondQuestion = `Procura contestar con orden; comprueba la numeración de la frase en el Cuadernillo y de la respuesta en esta Hoja.
			Anota sólo una respuesta para cada frase e intenta no dejar frases sin contestar, aunque no estés totalmente seguro de tu respuesta.
			Si no eres capaz de decidirte por V o F ,debes marcar el espacio de la letra F (Falso).`;
	}
	
	const inputOrButtons = currentQ.id == "0"
    ? `<input type="text" id="other_answer" placeholder="Opcional" class="w-full p-4 rounded-xl text-black mb-4" style="border-color: #484848;
    border-width: revert;" />
	<div class="grid grid-cols-1 gap-4">
        <button onclick="answer(1)"
            class="py-4 rounded-xl bg-gradient-to-br from-sky-400 to-cyan-400 font-bold">
            Siguiente
          </button>
      </div>`
    : `<div class="grid grid-cols-2 gap-4">
        ${options.map(opt => `
          <button  onclick="answer(${opt.value})" 
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
					
					<span class="font-bold text-blue/70 text-base mt-1">${opt.text}</span>
						
				</div>
        `).join('')}
      </div>`;

	 return `
		<div class="p-6 md:p-9" style="background: #fff;">

			<div class="flex justify-between items-center mb-6  pb-4">
				<div class="flex items-center gap-3">
				
				<div >
					<h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text">${testname}</h1>
					
					<p class="text-black/80 text-sm leading-relaxed pt-5 border-t border-black/20">
						${inputSecondQuestion}
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

			<div class="card-glass rounded-2xl p-6 md:p-8 mb-8 text-center">
        
				<h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-black leading-tight tracking-wide">
				${escapeHtml(currentQ.question)}
				</h2>
			</div>


			${inputOrButtons}

			<div class="flex justify-between items-center mt-8">
				<button onclick="back()" 
				class="flex items-center gap-2 px-5 py-2 rounded-full bg-black/10 backdrop-blur-sm hover:bg-black/20 transition text-black/90 font-medium text-sm">
				<i class="fas fa-arrow-left text-xs"></i> Anterior
				</button>
				<div class="text-xs text-black/40"><i class="fas fa-hand-pointer"></i> Seleccione una opción</div>
			</div>
		</div>`;
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
	
	const input = document.getElementById("other_answer");
	const other_answer = input ? input.value : "";

  	const data = new FormData();
	data.append('idClient', "<?php echo $idClient?>");
	data.append('patient', "<?php echo $idpatient;?>");
	data.append('codes', "<?php echo $register['codes']?>");
	data.append('is_share', <?php echo (int)$is_share?>);
	data.append('other_answer',other_answer);
	questions.forEach((q, index) => {
		if(q.id != "0"){
			data.append(`question_${q.id}`, answers[index]);
		}
		
	});
	
	
	fetch('form3.php', {
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
		<script src="https://cdn.tailwindcss.com"></script>
  		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<style>
		
		
		input[type="radio"]:checked {
			transform: scale(1.3);
			cursor: pointer;
			accent-color: #0B2B5E; 
		}
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
						

						<form method="<?=!$is_view?'POST':''?>" action="<?=!$is_view?'form4.php':''?>">
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
									<th class="p-3 text-left">Problemas</th>
									<th class="p-3 text-center" width="60">1</th>
									<th class="p-3 text-center" width="60">2</th>
								</tr>
								</thead>
								<tbody id="tableDesktop"></tbody>
							</table>
							</div>

							<!-- MOBILE CARDS -->
							<div class="md:hidden space-y-3" id="mobileContainer"></div>
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
			const answer_part1 = <?php echo json_encode($answer_part1)?>;
			var answersadmin = <?php echo json_encode($answers)?>;
			const device = <?php echo json_encode($device)?>;
			var input_answer = <?php echo json_encode($input_answer)?>;
			var oth = { ...answer_part1[0] };
			oth.question = "Otros (escribe cuáles)";
			oth.id = '0';
			answersadmin = [...answer_part1,oth, ...answersadmin];
			var options = [
				{ value: 1, text: '1'},
				{ value: 0, text: '2'},
				];
			const is_view = <?php echo json_encode($is_view)?>;
			const perPage = 10;
			let currentPage = 0;

			const desktopTable = document.getElementById("tableDesktop");
			const mobileContainer = document.getElementById("mobileContainer");
			const progress = document.getElementById("progress");
			
			function render() {
				desktopTable.innerHTML = "";
				mobileContainer.innerHTML = "";

				const start = currentPage * perPage;
				const end = start + perPage;
				
				//-------------------------------------------------------------------

				answersadmin.slice(start, end).forEach((q, i) => {
					
					const index = start + i;
					if(q.id == '0'){
						options = [
							{ value: 1, text: 'V'},
							{ value: 0, text: 'F'}
							];
					}
					if(index != 10){
						const id = answersadmin[index].id;
					
						/* ===== DESKTOP ===== */
						if(device == "desktop"){
							const tr = document.createElement("tr");

							tr.innerHTML = `
							<td class="p-3">${q.question}</td>
							${options.map(val => `
								<td class="text-center">
								<input type="radio" name="question_${id}" value="${val.value}"
									${answersadmin[index].response == String(val.value)  ? "checked" : ""} ${is_view ? "class='i-disabled'" : ""}>
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

							if (answersadmin[index].response) tr.classList.add("answered");

							desktopTable.appendChild(tr);
							if(index == 9){
								const trq = document.createElement("tr");
								trq.innerHTML = `
								<td class="pl-3">
								<input type="text" id="other_answer" name="other_answer" value="${input_answer}" placeholder="Opcional" 
									class="w-full p-1 rounded-xl text-black" 
									style="border-color: #484848;border-width: revert;" ${is_view ? "class='i-disabled'" : ""}/>
								</td>
								<td class="text-center" style="width: 100px;position: absolute;">
									${answersadmin[index+1].question}
									
									</td>
								`;
								desktopTable.appendChild(trq);
							}
						}
					}
					
					

					/* ===== MOBILE ===== */
					if(device != "desktop"){


						const card = document.createElement("div");
						card.className = "border rounded-lg p-3 shadow-sm";
						if(q.id == '0'){
							card.innerHTML =`
							<p class="mb-2 font-medium">${index+1}. ${q.question}</p>
							<div class="grid grid-cols-1 gap-2 text-center">
								<label class="border rounded p-2 ${q.response!=null?'bg-yellow-100':''}">
								<input type="text" id="other_answer" value="${input_answer}" placeholder="Opcional" class="w-full p-1 rounded-xl text-black" style="border-color: #484848;
								border-width: revert;" />
								</label>
							</div>`;

							const input = card.querySelector("input");

							if (input) {
								input.addEventListener("input", (e) => {
									input_answer = e.target.value;
									answersadmin[10].response = input_answer;
									syncHiddenInputs();
								});
							}
							
						}else{
							card.innerHTML = `
							<p class="mb-2 font-medium">${index+1}. ${q.question}</p>
							<div class="grid grid-cols-2 gap-2 text-center">
								${options.map(val => `
								<label class="border rounded p-2 ${q.response==val.value?'bg-yellow-100':''}">
									<input type="radio" name="question_${q.id}" value="${val.value}"
									class="hidden"
									${q.response == String(val.value) ? "checked" : ""} ${is_view ? "disabled" : ""}>
									${val.text}
								</label>
								`).join("")}
							</div>
							`;

							card.querySelectorAll("input").forEach(input => {
								input.addEventListener("change", () => {
									console.log(input.value);
									answersadmin[index].response = input.value;
									updateProgress();
									syncHiddenInputs();
									render(); 
								});
							});
						}
						

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
						input.value = item.response;
						if(item.id != '0'){
							input.name = "question_" + item.id;
						}
						else{
							input.name = "other_answer";
						}
						
						container.appendChild(input);

					}
				});
			}
			function updateProgress() {
				const total = answersadmin.length-1;
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
			
			document.addEventListener("DOMContentLoaded", () => {
				const input = document.getElementById("other_answer");

				if (input) {
					input.addEventListener("input", (e) => {
						input_answer = e.target.value;
						answersadmin[10].response = input_answer;
						syncHiddenInputs();
					});
				}
			});
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


						

			render();
		</script>									
	</body>
</html>
<?php } ?>