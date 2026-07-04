<?php
    include_once('../configs.php');
	// MCMI IV
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
    $idClient = '0';
    $idpatient = '0';
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
var questions = <?php echo json_encode($answers)?>;
var fullname  = <?php echo json_encode($register['id_client'])?>;
var testname = <?php echo json_encode($register['type_question_name'])?>;
const options = [
  { value: 1, text: 'Verdadero'},
  { value: 0, text: 'Falso'}
];

let currentIndex = 0;
let answers = [];
let patient = {};
let finished = false;
let submittedAt = null;

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
      <div class="flex justify-between items-center mb-6 border-b border-white/20 pb-4">
        <div class="flex items-center gap-3">
          <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text" style="color: #0B2B5E;">${testname}</h1>
          </div>
        </div>
      </div>
      
      <div class="card-glass rounded-2xl p-4 mb-6" style="background: #f3f4f6;">
        <label class="block text-sm font-semibold mb-2 flex items-center gap-2" style="color: #0B2B5E;">ID del Evaluado: ${fullname}</label>
      </div>

      <div class="mb-6 card-glass rounded-2xl mb-7 p-4" style="background: #f3f4f6;">
        <label class="block text-sm font-semibold mb-2 flex items-center gap-2" style="color: #0B2B5E;">Instrucciones</label>
        <p class="text-black/80 text-sm leading-relaxed mb-5">
          Esta prueba consiste en una serie de frases. Lea cada una de ellas y decida si es verdadera (V) o falsa (F) en su caso. Trate de contestar a todas las frases de forma honesta y seria, incluso si no está del todo seguro de su respuesta. No hay límite de tiempo para completar el inventario, pero es recomendable trabajar a un ritmo rápido pero cómodo.
        </p>
      </div>
      
      <button type="button" onclick="startQuiz()" style="background: #0B2B5E;"
        class="w-full relative group overflow-hidden font-bold py-4 px-6 rounded-2xl shadow-xl text-white text-lg tracking-wide transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl focus:outline-none">
        <span class="relative z-10 flex items-center justify-center gap-3"><i class="fas fa-play-circle"></i> Comenzar Cuestionario</span>
      </button>
      <p class="text-center text-black/40 text-xs mt-5"><i class="fas fa-lock"></i> Sus respuestas son confidenciales</p>
    </div>
  `;
}

function startQuiz() {
  patient.name = fullname;
  questions.forEach((q, idx) => {
    if (q.response !== null && q.response !== undefined && q.response !== "") {
      answers[idx] = parseInt(q.response);
    }
  });
  render();
}

function renderQuestion() {
  const progressPercent = Math.round(((currentIndex) / questions.length) * 100);
  const currentQ = questions[currentIndex];
  
  return `
    <div class="p-6 md:p-9" style="background: #fff;">
      <div class="flex justify-between items-center mb-6 pb-4">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-cyan-200 bg-clip-text" style="color: #0B2B5E;">${testname}</h1>
          <p class="text-black/80 text-sm leading-relaxed pt-5 border-t border-black/20">
            Anota sólo una respuesta para cada frase. Si cree que la frase describe su forma de pensar, sentir o actuar, elija Verdadero. De lo contrario, elija Falso.
          </p>
        </div>
      </div>
      <div class="mb-5">
        <div class="flex justify-between text-xs font-semibold text-black/80 mb-1">
          <span><i class="fas fa-tasks mr-1"></i> Progreso</span>
          <span>${currentIndex + 1} / ${questions.length}</span>
        </div>
        <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden shadow-inner" style="background: #e5e7eb;">
          <div class="h-3 bg-gradient-to-r from-cyan-300 via-sky-400 to-blue-500 rounded-full" style="width:${progressPercent}%; background: #0B2B5E;"></div>
        </div>
      </div>

      <div class="card-glass rounded-2xl p-6 md:p-8 mb-8 text-center" style="background: #f8fafc; border: 1px solid #e2e8f0;">
        <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-black leading-tight tracking-wide">
          ${escapeHtml(currentQ.question)}
        </h2>
      </div>

      <div class="grid grid-cols-2 gap-4">
        ${options.map(opt => `
          <button onclick="answer(${opt.value})" 
            class="btn-option rounded-2xl border-[3px] border-blue-700 bg-white px-3 py-4 min-h-[70px] flex items-center justify-center text-center transition-all duration-200 hover:bg-blue-50 hover:scale-[1.02] active:scale-95 shadow-sm">
            <div class="flex flex-col items-center gap-1" style="color: #0B2B5E;">
              <span class="font-bold text-base">${opt.text}</span>
            </div>
          </button>
        `).join('')}
      </div>

      <div class="flex justify-between items-center mt-8">
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

function renderSummary() {
  return `
    <div class="p-8 text-center" style="background: #fff;">
      <h2 class="text-3xl font-bold mb-2" style="color: #0B2B5E;">¡Completado!</h2>
      <p class="text-black/80 mb-4">Gracias por responder. Por favor envíe los resultados.</p>

      <div class="bg-blue/10 p-4 rounded-lg text-left mb-4" style="background: #f1f5f9;">
        <p><b>Nombre:</b> ${patient.name}</p>
        <p><b>Edad:</b> <?=$register['age']?></p>
        <p><b>Fecha:</b> ${submittedAt.toLocaleString()}</p>
      </div>

      <div class="bg-blue/10 p-4 rounded-lg text-left max-h-48 overflow-y-auto border-t border-black/20" style="background: #f1f5f9;">
        ${questions.map((q, i) => `
          <div class="flex justify-between border-b border-black/10 py-1 text-sm">
            <span class="truncate">${q.item_order}. ${q.question}</span>
            <b style="color: #0B2B5E;">${answers[i] === 1 ? 'V' : 'F'}</b>
          </div>
        `).join('')}
      </div>
      <br>
      <button onclick="reset()" class="w-full font-bold py-3 px-8 rounded-full shadow-xl text-white transform transition-all duration-300 hover:scale-105 hover:shadow-2xl" style="background: #0B2B5E;">
        Enviar resultados
      </button>
    </div>
  `;
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
  
  fetch('form7.php', {
    method: 'POST',
    body: data
  }).then(() => {
    window.location.href = 'https://www.google.com';
  });
}

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
  <title> <?=WEB_TITLE?> </title>
  <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon"/>
  <link href="../../assets/css/icons.css?v=<?=VERSION_CODE?>" rel="stylesheet">
  <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">
  <link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>
  <link href="../../assets/css/style.css" rel="stylesheet">
  <link href="../../assets/css/style-dark.css" rel="stylesheet">
  <link href="../../assets/css/boxed.css" rel="stylesheet">
  <link href="../../assets/css/dark-boxed.css" rel="stylesheet">
  <link href="../../assets/css/skin-modes.css" rel="stylesheet" />
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
    .answered { background-color: #e2f0d9; }
  </style>
</head>

<body class="main-body">
  <div id="global-loader">
    <img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
  </div>

  <div class="page <?=TESTING=='1'?'istesting':''?>">
    <?php if(!$is_share) include("../include/header_top.php"); ?>
    <?php if(!$is_share) include("../include/header_bottom.php"); ?>

    <div class="main-content horizontal-content">
      <div class="container">
        <div class="breadcrumb-header justify-content-between"></div>
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-4 md:p-6">
          <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
            <h1 class="text-lg md:text-xl font-semibold" style="color: #0B2B5E;">
              <i class="fas fa-clipboard-list text-blue-500"></i>
              Formulario <?=$register['type_question_name']?>
            </h1>
            <span id="progress" class="text-sm text-gray-600"></span>
          </div>
          <div>
            <p class="text-sm text-black/70 mb-2 mt-2">#<?= $register['id'] ?> ID: <?=$register['id_client']?></p>
          </div>

          <form method="POST" action="form7.php">
            <div id="hiddenAnswers"></div>
            <input type="hidden" name="is_share" value="<?=(int)$is_share?>">
            <input type="hidden" id="patient" name="patient" value="<?=$idpatient?>">
            <input type="hidden" id="idClient" name="idClient" value="<?=$idClient?>">
            <input type="hidden" id="codes" name="codes" value="<?=$register['codes']?>">

            <!-- DESKTOP TABLE -->
            <div class="hidden md:block overflow-x-auto">
              <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                <thead class="text-white" style="background: #0B2B5E;">
                  <tr>
                    <th class="p-3 text-left">Pregunta</th>
                    <th class="p-3 text-center" width="80">V</th>
                    <th class="p-3 text-center" width="80">F</th>
                  </tr>
                </thead>
                <tbody id="tableDesktop"></tbody>
              </table>
            </div>

            <!-- MOBILE CARDS -->
            <div class="md:hidden space-y-3" id="mobileContainer"></div>
            <div class="mt-6 flex justify-between">
              <button type="button" id="prevBtn" class="bg-gray-300 px-4 py-2 rounded">Anterior</button>
              <button type="button" id="nextBtn" class="text-white px-4 py-2 rounded" style="background: #0B2B5E;">Siguiente</button>
            </div>

            <!-- SUBMIT -->
            <div class="mt-4 flex justify-center">
              <?php if(!$is_view){?>
                <button type="submit" class="text-white px-6 py-2 rounded-lg" style="background: #28a745;">
                  <?=$text_button_send?>
                </button>
              <?php }?>
            </div>
          </form>
        </div>
        <div class="breadcrumb-header justify-content-between"></div>
      </div>
    </div>

    <?php include("../include/footer.php");?>
  </div>

  <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
  <script src="../../assets/plugins/jquery/jquery.min.js"></script>
  <script src="../../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
  <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
  <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/plugins/ionicons/ionicons.js"></script>
  <script src="../../assets/plugins/moment/moment.js"></script>
  <script src="../../assets/plugins/select2/js/select2.min.js"></script>
  <script src="../../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="../../assets/plugins/perfect-scrollbar/p-scroll.js"></script>
  <script src="../../assets/js/eva-icons.min.js"></script>
  <script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
  <script src="../../assets/plugins/rating/jquery.barrating.js"></script>
  <script src="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>
  <script src="../../assets/plugins/sidebar/sidebar.js"></script>
  <script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script>
    const answersadmin = <?php echo json_encode($answers)?>;
    const device = <?php echo json_encode($device)?>;
    const options = [
      { value: 1, text: 'V'},
      { value: 0, text: 'F'}
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

      answersadmin.slice(start, end).forEach((q, i) => {
        const index = start + i;
        const id = q.id;

        /* ===== DESKTOP ===== */
        if(device == "desktop"){
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td class="p-3 text-gray-900"><span class="font-semibold">${q.item_order}. </span>${q.question}</td>
            ${options.map(opt => `
              <td class="text-center">
                <input type="radio" name="question_${id}" value="${opt.value}"
                  ${q.response == String(opt.value) ? "checked" : ""} ${is_view ? "class='i-disabled'" : ""}>
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

          if (q.response !== null && q.response !== undefined && q.response !== "") {
            tr.classList.add("answered");
          }
          desktopTable.appendChild(tr);
        }

        /* ===== MOBILE ===== */
        if(device != "desktop"){
          const card = document.createElement("div");
          card.className = "border rounded-lg p-3 shadow-sm";
          card.innerHTML = `
            <p class="mb-2 font-medium">${q.item_order}. ${q.question}</p>
            <div class="grid grid-cols-2 gap-2 text-center">
              ${options.map(opt => `
                <label class="border rounded p-2 ${q.response == String(opt.value) ? 'bg-yellow-100' : ''}">
                  <input type="radio" name="question_${id}" value="${opt.value}" class="hidden"
                    ${q.response == String(opt.value) ? "checked" : ""} ${is_view ? "class='i-disabled'" : ""}>
                  ${opt.text}
                </label>
              `).join("")}
            </div>
          `;

          card.querySelectorAll("input").forEach(input => {
            input.addEventListener("change", () => {
              answersadmin[index].response = input.value;
              updateProgress();
              syncHiddenInputs();
              render(); 
            });
          });
          mobileContainer.appendChild(card);
        }
      });

      updateProgress();
    }

    function syncHiddenInputs() {
      const container = document.getElementById("hiddenAnswers");
      container.innerHTML = "";
      answersadmin.forEach(item => {
        if (item.response !== null && item.response !== undefined && item.response !== "") {
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
      let answered = 0;
      answersadmin.forEach(item => {
        if(item.response !== null && item.response !== undefined && item.response !== ""){
          answered++;		
        }
      });
      progress.textContent = `${answered} / ${total} respondidas`;
    }

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

    render();
  </script>
</body>
</html>
<?php } ?>
