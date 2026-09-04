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
if (!isset($_SESSION['REST_type_user'])) {
	header("Location: " . LOCALHOST . "/signin.php");
}
if (($_SESSION['REST_type_user'] == 'Administrador' || $_SESSION['REST_type_user'] == 'CLIENTE') && (isset($_POST['id_type_question']) && isset($_POST['belong_id']) && isset($_POST['baremo_id']) && isset($_POST['age'])  && isset($_POST['sex']) && isset($_POST['id_client']))) {
	$hash = $answerModel->generateRandomKey();
	if (isset($_POST['id']) && $_POST['id'] != '') {
		$data = $registerModel->updateClient($_POST['id'], $_POST['id_client'], $_POST['age'], $_POST['sex'], $_POST['id_type_question'], $_POST['baremo_id']);
	} else {
		$idRegister = $registerModel->save($_POST['belong_id'], $_POST['id_client'], $_POST['age'], $_POST['sex'], $_POST['baremo_id'], $_POST['id_type_question'], $hash);
		$questions = $questionModel->getAll($_POST['id_type_question']);

		foreach ($questions as $value) {
			$id = $answerModel->save($value['id'], $idRegister, $hash);
		}
	}

	header("Location: " . LOCALHOST . "/view/register.php?client=" . $_POST['belong_id']);
}

if (($_SESSION['REST_type_user'] == 'Administrador' || $_SESSION['REST_type_user'] == 'CLIENTE') &&  isset($_GET['remove_id'])) {

	$value = $registerModel->delete($_GET['remove_id']);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if ($_SESSION['REST_type_user'] == 'Administrador' &&  isset($_GET['client'])) {

	$idClient = $_GET['client'];
}
if ($_SESSION['REST_type_user'] == 'CLIENTE') {
	$idClient = $_SESSION['REST_id_user'];
}
$search_key = "";
if (isset($_GET['search'])) {
	$search_key = $_GET['search'];
}

if ($idClient == 0) {
	header("Location: " . LOCALHOST . "/view/index.php");
	exit;
}



$registers = $registerModel->getAll($idClient, $search_key);

?>

<!DOCTYPE html>
<html lang="es">

<head>

	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title> <?= WEB_TITLE ?> </title>

	<link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon" />

	<link rel="stylesheet" href="../../assets/css/global.css">
	<link rel="stylesheet" href="../../css/tailwind.css">
	<link rel="stylesheet" href="../../assets/css/style_calendary.css">
	<!-- Lucide Icons (local) -->
	<script src="../../assets/js/vendor/lucide.min.js"></script>


</head>

<body>

	<!-- Page -->
	<div class="min-h-screen flex flex-col text-slate-800 page <?= TESTING == '1' ? 'istesting' : '' ?>">
		<?php include("../include/header-v2.php"); ?>

		<main class="flex-1 place-items-center items-center justify-center">
			<div class="container-global w-full flex items-center justify-center mt-10">
				<div class="grid w-full grid-cols-1 md:grid-cols-3 gap-4">
					<div class="md:col-span-2">
						<div class="flex min-h-[50rem] flex-col overflow-hidden rounded-2xl border border-white/80 bg-white shadow-xl">
							<div class="flex items-center justify-between px-5 py-2 sm:px-8">
								<div class="flex items-center gap-2 text-xs text-slate-400">

								</div>

								<div class="flex items-center gap-5 text-slate-700">


								</div>
							</div>

							<div id="searchBar" class="flex items-center gap-2 px-5 py-3 sm:px-8">

								<div class="flex flex-1 items-center gap-2 border border-slate-400 rounded-full bg-slate-100 px-3 py-2 ring-1 ring-slate-200/70 transition focus-within:ring-1">

									<i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-500"></i>

									<input
										id="searchInput"
										placeholder="Buscar..."
										class="flex-1 bg-transparent text-sm outline-none placeholder:text-slate-500" />

								</div>

								<button
									id="cancelSearch"
									type="button"
									class="shrink-0 text-xs font-medium text-slate-600 transition hover:text-slate-800">
									Cancelar
								</button>

							</div>



							<div class="flex-1">
								<section id="mini-calendario" class="min-w-0 border-b border-slate-100">
									<div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-8">
										<h2 class="text-base font-semibold">Calendario</h2>
									</div>

									<div class="flex items-center justify-center gap-2 overflow-x-auto border-b border-slate-300 px-5 py-3 sm:px-8">
										<button id="prevMonthSide" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-50 transition hover:bg-slate-300">
											<i data-lucide="chevron-left" class="h-4 w-4"></i>
										</button>

										<div id="monthList" class="flex min-w-max gap-2"></div>

										<button id="nextMonthSide" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-50 transition hover:bg-slate-300">
											<i data-lucide="chevron-right" class="h-4 w-4"></i>
										</button>
									</div>

									<div id="daysList" class="divide-y divide-slate-100"></div>
								</section>


							</div>
						</div>
					</div>
					<div class="md:col-span-1">

						<div class="flex min-h-[50rem] flex-col overflow-hidden rounded-2xl border border-white/80 bg-white shadow-xl">
							<section class="border-b border-slate-100 px-5 py-5 sm:px-8 sm:py-6">
								<div class="flex flex-wrap items-end justify-between gap-4">
									<div>
										<p class="mt-1 text-sm text-slate-500">

										</p>
									</div>

									<button
										id="openModal"
										class="flex h-10 items-center gap-2 rounded-full bg-black px-5 text-xs font-semibold text-white transition hover:bg-slate-800">
										<i data-lucide="plus" class="h-[15px] w-[15px]"></i>
										Agendar
									</button>
								</div>
							</section>
							<div class="flex flex-1 flex-col">
								<aside class="bg-[#fdfdff]">
									<div class="border-b border-slate-100 px-5 py-4 sm:px-8">
										<div class="flex items-center justify-between">
											<div class="flex flex-1 items-center justify-between gap-4">
												<button id="prevMonth" class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 transition hover:bg-slate-300">
													<i data-lucide="chevron-left" class="h-[15px] w-[15px]"></i>
												</button>

												<h2 id="miniMonthTitle" class="text-sm font-semibold"></h2>

												<button id="nextMonth" class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 transition hover:bg-slate-300">
													<i data-lucide="chevron-right" class="h-[15px] w-[15px]"></i>
												</button>
											</div>
										</div>

										<div id="miniCalendar"></div>
									</div>

									<div class="px-5 py-5 sm:px-8">
										<div class="mb-4 flex items-center justify-between">
											<h2 class="text-base font-semibold">Próximas citas</h2>
											<i data-lucide="calendar-clock" class="h-4 w-4 text-slate-500"></i>
										</div>

										<div id="upcomingList" class="max-h-[450px] overflow-y-auto"></div>
									</div>
								</aside>
							</div>
						</div>
					</div>
				</div>

				<div id="modalBackdrop" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/25 p-5 backdrop-blur-sm">
					<div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
						<div class="flex items-start justify-between">
							<div>
								<h2 class="text-lg font-semibold">Agendar cita</h2>
								<p class="mt-1 text-sm text-slate-500">
									Programa una nueva cita para una prueba psicológica.
								</p>
							</div>

							<button id="closeModal" class="text-2xl leading-none text-slate-600" aria-label="Cerrar">
								&times;
							</button>
						</div>

						<div class="mt-5 space-y-3">
							<input
								id="patientInput"
								placeholder="Nombre del paciente"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />
							<input
								id="patientLasnameInput"
								placeholder="Apellido del paciente"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />

							<select
								id="generoInput"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500">
								<option value="" selected disabled>Seleccionar genero</option>
								<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
							</select>

							<input
								id="gneroOtroInput"
								placeholder="Otro:"
								class="hidden w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />
							
							<input
								id="telefonoInput"
								placeholder="Telefono del paciente"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />
							
							<input
								id="dateInput"
								type="date"
								placeholder="Fecha"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />

							<input
								id="timeInput"
								type="time"
								placeholder="Hora"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />

							<input
								id="timeMaxInput"
								type="number"
								placeholder="Tiempo Max en Min."
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500" />
							
							<select
								id="estadoInput"
								class="w-full rounded-xl border border-slate-400 px-4 py-3 text-sm outline-none focus:border-slate-500">
								<option value="" selected disabled>Seleccionar estado</option>
								<option value="Confirmada">Confirmar</option>
								<option value="Pendiente">Por Confirmar</option>
							</select>

							<div class="flex flex-wrap items-center gap-2">
								<span class="text-xs text-slate-500">Colores:</span>
								<div id="coloresButtons" class="flex flex-wrap gap-1.5"></div>
							</div>

							

							<p id="formError" class="hidden text-xs text-red-500"></p>

							<button
								id="saveAppointment"
								class="w-full rounded-xl bg-black py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
								Guardar cita
							</button>
						</div>
						</div>
					</div>
				</div>
				<!-- Modal para ver nota completa -->
				<div id="modalNota" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/25 p-5 backdrop-blur-sm">
					<div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
						<div class="flex items-start justify-between">
							<h2 class="text-lg font-semibold">Nota</h2>
							<button id="closeModalNota" class="text-2xl leading-none text-slate-600" aria-label="Cerrar">
								&times;
							</button>
						</div>
						<div class="mt-5">
							<p id="notaCompleta" class="text-sm text-slate-600 leading-relaxed"></p>
						</div>
					</div>
				</div>
			</div>
		</main>


		</main>

		<!-- Audio Modal -->
		<?php include("../include/footer.php"); ?>

	</div>
	<!-- End Page -->

	<!-- Back-to-top -->
	<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
	<script src="../../assets/plugins/jquery/jquery.min.js"></script>
	<script src="../../assets/js/header.js"></script>
	<script src="../../assets/js/calendary.js"></script>
</body>

</html>