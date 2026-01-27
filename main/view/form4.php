<?php
    include_once('../configs.php');
	//SCL-90-R
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

<body class="min-h-screen w-full bg-gradient-to-br from-[#013A8A] via-[#1b369c] to-[#5E7BFF] flex items-center justify-center p-4 font-sans text-white">

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
  { value: 0, text: 'Nada', class: 'from-sky-400 to-cyan-400' },
  { value: 1, text: 'Poco', class: 'from-emerald-400 to-teal-400' },
  { value: 2, text: 'Moderadamente', class: 'from-violet-400 to-fuchsia-400' },
  { value: 3, text: 'Bastante', class: 'from-amber-400 to-yellow-400' },
  { value: 4, text: 'Mucho', class: 'from-rose-400 to-red-400' }
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
          <p>Encontrara una serie de afirmaciones sobre MOLESTIAS o PROBLEMAS que pueden afectar en mayor o menor medida a todas las personas. Conteste a cada una ellas teniendo en cuenta aquello o experimentado durante las ultimas semanas, incluido el dia de hoy.</p>
          <p>Para ello, marque junto a cada afirmación una de las siguientes opciones:</p>
          
          	<div class="bg-gray-900/50 rounded-xl p-4">
				<p class="text-center font-semibold text-sm sm:text-base mb-4">
					HASTA QUÉ PUNTO SE HA SENTIDO MOLESTO POR EL SÍNTOMA
				</p>

				<div class="grid grid-cols-3 sm:grid-cols-5 gap-3 text-center font-mono">
					
					<div class="p-2 rounded-lg bg-gray-800">
					<span class="font-bold block text-base">0</span>
					<span class="text-xs">Nada</span>
					</div>

					<div class="p-2 rounded-lg bg-gray-800">
					<span class="font-bold block text-base">1</span>
					<span class="text-xs">Poco</span>
					</div>

					<div class="p-2 rounded-lg bg-gray-800">
					<span class="font-bold block text-base">2</span>
					<span class="text-xs break-words">Moderadamente</span>
					</div>

					<div class="p-2 rounded-lg bg-gray-800">
					<span class="font-bold block text-base">3</span>
					<span class="text-xs">Bastante</span>
					</div>

					<div class="p-2 rounded-lg bg-gray-800">
					<span class="font-bold block text-base">4</span>
					<span class="text-xs">Mucho</span>
					</div>

				</div>
			</div>


        </div>

        
		
		
		<button type="button" onclick="startQuiz()"
		class="w-full font-bold py-3 px-8 rounded-full shadow-xl
         bg-gradient-to-r from-[#5E7BFF] to-[#1b369c]
         text-white
         transform transition-all duration-300
         hover:scale-105 hover:shadow-2xl
         focus:outline-none focus:ring-4 focus:ring-[#6EA3FF]/50
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
    <button onclick="reset()" class="w-full font-bold py-3 px-8 rounded-full shadow-xl
         bg-gradient-to-r from-[#5E7BFF] to-[#1b369c]
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
	
	
	fetch('form4.php', {
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
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=1'>
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
			color: rgba(0,0,0,1);
			font-size: 12px;
			pointer-events: none; /* evita bloquear clic */
		}
		.radio-grande:checked {
			background: #25498e;
			color: rgba(0,0,0,1);
		}
		.table-bordered th, .table-bordered td{
			border:1px solid #2f4f7034;
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
						<div class="card" style="border: 0px solid transparent !important;box-shadow: none !important;background-color: #70bdd6 !important;">
						
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
    background-color: #1b369c;
    color: white;
    margin: 1px;
    text-align: center;
    width: min-content;font-weight: bold;
    height: auto;">
										CUESTIONARIO
									</div>
									<p>Encontrara una serie de afirmaciones sobre <span style="font-weight: bold;">MOLESTIAS o PROBLEMAS</span> que pueden afectar en mayor o menor medida
									a todas las personas. Conteste a cada una ellas teniendo en cuenta aquello o experimentado <span style="font-weight: bold;">durante las ultimas semanas, incluido el dia  de hoy.</span>
									<br>
									Para ello, marque junto a cada aformacion una de las siguientes opciones:	
									</p>
									<p style="font-weight: bold;
    background: #1b369c;
    color: white;
    padding: 5px;
    border-radius: .25rem;">HASTA QUÉ PUNTO SE HA SENTIDO MOLESTO POR EL SÍNTOMA	</p>
									<table class="table table-bordered" style="border:1px solid black;table-layout: fixed;font-weight: bold;color:#4BB694;text-align-last: center;">
										<thead>	
											<tr>
												<th style="width:70px;max-width: 70px;background: white;color: #59a6c6;">0</th>
												<th style="width:70px;max-width: 70px;background: white;color: #59a6c6;">1</th>
												<th style="width:70px;max-width: 70px;background: white;color: #59a6c6;">2</th>
												<th style="width:70px;max-width: 70px;background: white;color: #59a6c6;">3</th>
												<th style="width:70px;max-width: 70px;background: white;color: #59a6c6;">4</th>
											</tr>
										</thead>
										<tbody>
											<tr style="color:#59a6c6">
											<td>Nada</td>
											<td>Poco</td>
											<td>Moderadamente</td>
											<td>Bastante</td>
											<td>Mucho o Extremadamente</td>
											</tr>
											
										</tbody>
									</table>
									<br>
								</div>

								<div class="table-responsive country-table">
                                    <form method="<?=!$is_view?'POST':''?>" action="<?=!$is_view?'form1.php':''?>">
                                    <table class="table table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap" style="background: #eceeb6 !important;">
										<input type="hidden" name="is_share" value="<?=(int)$is_share?>">
                                        <input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
                                        <input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
										<input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">
                                        
										<tbody>
                                            <?php
                                                foreach($answers as $answer){
                                            ?>
											<tr>
                                                <td style="color:#25498e;font-weight: bold;text-align: center;"><?=$answer['item_order']?></td>
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
                                                <td style="color:#25498e;font-weight: bold;text-align: center;"><?=$answer['item_order']?></td>
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