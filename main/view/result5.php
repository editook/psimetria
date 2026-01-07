<?php
include_once('../configs.php');
//MASR-2
session_start();
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");
include("../models/masr2/model_baremo_mujer_6_8a.php");
include("../models/masr2/model_baremo_mujer_9_14a.php");
include("../models/masr2/model_baremo_mujer_15_19a.php");
include("../models/masr2/model_baremo_varon_6_8a.php");
include("../models/masr2/model_baremo_varon_9_14a.php");
include("../models/masr2/model_baremo_varon_15_19a.php");
include("../models/masr2/model_configuration.php");
$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$idClient = 0;
$idpatient = 0;

if(!isset($_SESSION['REST_type_user'])){
    header("Location: ".LOCALHOST."/signin.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['baremo_id'])) {
        $baremo_id = intval($_POST['baremo_id']);
        $id_register = intval($_POST['id_register']);
        $id_user = intval($_POST['id_user']);
        $register = $registerModel->getById($id_user,$id_register);
        $response = $registerModel->updateClient($register['id'],$register['id_client'],$register['age'],$register['sex'],$register['id_type_question'],$baremo_id);
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

if( $_SESSION['REST_type_user'] == 'Administrador' &&  isset($_GET['client']) &&  isset($_GET['patient'])){

    $idClient = $_GET['client'];
    $idpatient = $_GET['patient'];
}

if($_SESSION['REST_type_user'] == 'CLIENTE' &&  isset($_GET['patient'])){
    $idClient = $_SESSION['REST_id_user'];
    $idpatient = $_GET['patient'];
}

$register = $registerModel->getById($idClient,$idpatient);
if($register == null){
    echo "<script>
			alert('FALLO DE ACCESO CODIGO #876 - ".$idpatient." redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
		exit;
    exit;
}
$baremos = $baremoModel->getAll($register['id_type_question']);
//echo json_encode($baremos);
$baremo = null;
$modelConfiguration = new ModelConfiguration();

if($register['baremo_id'] == 51){
    $baremo = new ModelBaremoMujer68();
}
if($register['baremo_id'] == 52){
    $baremo = new ModelBaremoMujer914();
}
if($register['baremo_id'] == 53){
    $baremo = new ModelBaremoMujer1519();
}
if($register['baremo_id'] == 54){
    $baremo = new ModelBaremoVaron68();
}
if($register['baremo_id'] == 55){
    $baremo = new ModelBaremoVaron914();
}
if($register['baremo_id'] == 56){
    $baremo = new ModelBaremoVaron1519();
}


$answers = $answerModel->getAll($register['codes']);
$answers_text = $answerModel->getAnswersTop($register['codes']);
$answers_text = $answers_text['response'];

$def1 = $modelConfiguration->sumatoria($answers,[14,19,24],1);

$fis1 = $modelConfiguration->sumatoria($answers,[1,5,7,8,11,13,15,16,18],1);

$inq1 = $modelConfiguration->sumatoria($answers,[2,12,20,21],1);

$soc1 = $modelConfiguration->sumatoria($answers,[3,4,6,9,10,17,22,23],1);

$def2 = $modelConfiguration->sumatoria($answers,[29,33,38],1)+$modelConfiguration->sumatoria($answers,[40,44,48],0);

$fis2 = $modelConfiguration->sumatoria($answers,[25,27,28,31,34,36,39,42,43,47],1);

$inq2 = $modelConfiguration->sumatoria($answers,[30,35,40,44,46,48],1);

$soc2 = $modelConfiguration->sumatoria($answers,[26,32,37,41,45,49],1);

$def = $def1 + $def2;
$fis = $fis1 + $fis2;
$inq = $inq1 + $inq2;
$soc = $soc1 + $soc2;

$tot = $fis + $inq+$soc;

$inc1 = ($modelConfiguration->getQuestion($answers,2) != $modelConfiguration->getQuestion($answers,8)) ? 1 : 0;
$inc2 = ($modelConfiguration->getQuestion($answers,3) != $modelConfiguration->getQuestion($answers,35)) ? 1 : 0;
$inc3 = ($modelConfiguration->getQuestion($answers,4) != $modelConfiguration->getQuestion($answers,10)) ? 1 : 0;
$inc4 = ($modelConfiguration->getQuestion($answers,6) != $modelConfiguration->getQuestion($answers,49)) ? 1 : 0;
$inc5 = ($modelConfiguration->getQuestion($answers,8) != $modelConfiguration->getQuestion($answers,39)) ? 1 : 0;
$inc6 = ($modelConfiguration->getQuestion($answers,19) != $modelConfiguration->getQuestion($answers,33)) ? 1 : 0;
$inc7 = ($modelConfiguration->getQuestion($answers,23) != $modelConfiguration->getQuestion($answers,37)) ? 1 : 0;
$inc8 = ($modelConfiguration->getQuestion($answers,24) != $modelConfiguration->getQuestion($answers,29)) ? 1 : 0;
$inc9 = ($modelConfiguration->getQuestion($answers,38) == $modelConfiguration->getQuestion($answers,48)) ? 1 : 0;
$inc = $inc1+$inc2+$inc3+$inc4+$inc5+$inc6+$inc7+$inc8+$inc9;

$def_array = $baremo->Defensividad()["$def"];
$def_pc = $def_array[0];
$def_t = $def_array[1];

$tot_array = $baremo->AnciedadTotal()["$tot"];
$tot_pc = $tot_array[0];
$tot_t = $tot_array[1];

$fis_array = $baremo->AnciedadFisiologica()["$fis"];
$fis_pc = $fis_array[0];
$fis_t = $fis_array[1];

$inq_array = $baremo->Inquietud()["$inq"];
$inq_pc = $inq_array[0];
$inq_t = $inq_array[1];

$soc_array = $baremo->AnciedadSocial()["$soc"];
$soc_pc = $soc_array[0];
$soc_t = $soc_array[1];


$ouput1 = "La puntuación de ".$inc.", de ".$register['id_client']." indica ";
$resultado = "";
if ($inc <= 5) {
    $resultado = "una probabilidad baja de inconsistencia en las respuestas. "
               . "Se considera que ha respondido con atención y consideración "
               . "al contenido de los ítems.";
} elseif ($inc <= 6) {
    $resultado = "un 81% de probabilidad de que ha respondido a los reactivos "
               . "sin considerar suficientemente su significado.";
} elseif ($inc <= 7) {
    $resultado = "una probabilidad de un 89% de que las respuestas hayan sido "
               . "dadas de manera descuidada o al azar.";
} else { // $H22 >= 8
    $resultado = "un 92% de probabilidad de que las respuestas hayan sido "
               . "dadas aleatoriamente.";
}
$ouput1 .= $resultado;

$ouput2 = $register['id_client']." obtuvo una puntuación T de ".$def_t.", indica ";
$resultado = "";
if ($def_t <= 39) {
    $resultado = "una mayor sinceridad y voluntad de admitir imperfecciones personales.";
} elseif ($def_t <= 60) {
    $resultado = "una disposición a admitir imperfecciones similar a la mayoría.";
} elseif ($def_t <= 70) {
    $resultado = "cierta renuencia a reconocer imperfecciones, aunque no tan extrema.";
} else { // $L12 >= 71
    $resultado = "una tendencia marcada a negar imperfecciones comunes y a presentarse de manera excesivamente positiva, lo que podría cuestionar la validez de las respuestas del examinado.";
}
$ouput2 .= $resultado;

$ouput3 = "La puntuación T de ".$tot_t.", que obtuvo ".$register['id_client'];
$resultado = "";
if ($tot_t <= 39) {
    $resultado = "indica un nivel de ansiedad menos problemático, reporta niveles de ansiedad notablemente más bajos que el "
               . "promedio de su grupo de edad. Experimenta menos preocupación o nerviosismo que sus "
               . "pares, incluso en situaciones que típicamente generarían cierto grado de ansiedad "
               . "en la mayoría de las personas.";
} elseif ($tot_t <= 60) {
    $resultado = "indica un nivel de ansiedad que no es más problemático. Experimenta un grado de "
               . "preocupación y nerviosismo típico para su grupo de edad.";
} elseif ($tot_t <= 70) {
    $resultado = "indica un nivel de ansiedad moderadamente problemático. Muestra un grado de ansiedad "
               . "notablemente mayor que el promedio de sus pares. Sus experiencias de ansiedad son más "
               . "frecuentes o intensas, y pueden manifestarse a través de preocupaciones "
               . "recurrentes, inquietud o síntomas físicos asociados con la ansiedad.";
} else { // $L20 >= 71
    $resultado = "indica un nivel de ansiedad extremadamente problemático. Exhibe un grado de ansiedad "
               . "considerablemente mayor que sus pares. Experimenta preocupaciones "
               . "intensas y persistentes, y es probable que muestre signos evidentes de nerviosismo "
               . "o inquietud en diversas situaciones.";
}
$ouput3 .= $resultado;

$ouput4 = $register['id_client']."obtuvo una puntuación T de ".$fis_t.", ";
$resultado = "";
if ($fis_t <= 39) {
    $resultado = "indica que experimenta síntomas físicos de ansiedad menos problemáticos que la mayoría de su edad. "
               . "Reporta muy pocas manifestaciones físicas de ansiedad, o estas son de muy baja intensidad. "
               . "Es probable que experimente menos síntomas como dolores de cabeza, "
               . "problemas de sueño o fatiga relacionados con la ansiedad que el promedio de sus pares.";
} elseif ($fis_t <= 60) {
    $resultado = "indica que experimenta síntomas físicos de ansiedad no más problemáticos que la mayoría de su edad. "
               . "Puede reportar ocasionalmente algunas manifestaciones físicas de ansiedad como leves dolores de cabeza, "
               . "cierta dificultad para dormir o fatiga ocasional, pero "
               . "estos síntomas no son más frecuentes o intensos que los experimentados por sus pares.";
} elseif ($fis_t <= 70) {
    $resultado = "indica un nivel moderadamente problemático de síntomas físicos de ansiedad. "
               . "Experimenta manifestaciones fisiológicas de ansiedad de manera más frecuente o intensa que el promedio de sus pares. "
               . "Puede reportar síntomas como problemas de sueño más regulares, dolores de cabeza frecuentes, "
               . "sensaciones de náuseas o fatiga notoria.";
} else { // $L14 >= 71
    $resultado = "indica un nivel extremadamente problemático de síntomas físicos de ansiedad. "
               . "Muestra manifestaciones fisiológicas de ansiedad considerablemente más intensas y frecuentes que sus pares. "
               . "Probablemente, experimenta una constelación de síntomas físicos como dificultades significativas para dormir, "
               . "dolores de cabeza intensos, náuseas frecuentes, sudoración excesiva y fatiga pronunciada.";
}
$ouput4 .= $resultado;

$ouput5 = $register['id_client']."obtuvo una puntuación T de ".$inq_t.", ";
$resultado = "";
if ($inq_t <= 39) {
    $resultado = "indica que experimenta un nivel de inquietud menos problemático que la mayoría de su edad. "
               . "Reporta muy pocas preocupaciones o momentos de nerviosismo, o estos son de muy baja intensidad. "
               . "Es probable que se muestre más tranquilo y relajado que el promedio de sus pares, "
               . "incluso en situaciones que típicamente generarían cierto grado de inquietud en otros.";
} elseif ($inq_t <= 60) {
    $resultado = "indica que experimenta un nivel de preocupaciones y nerviosismo no más problemático que la mayoría de su edad. "
               . "Puede reportar algunas preocupaciones ocasionales o momentos de nerviosismo, "
               . "pero estos son típicos para su grupo de edad y no interfieren su funcionamiento.";
} elseif ($inq_t <= 70) {
    $resultado = "indica un nivel moderadamente problemático de inquietud. "
               . "Experimenta preocupaciones y nerviosismo de manera más frecuente o intensa que el promedio de sus pares. "
               . "Puede reportar pensamientos ansiosos recurrentes, dificultades para relajarse, "
               . "o una tendencia a preocuparse excesivamente por situaciones cotidianas.";
} else { // $L16 >= 71
    $resultado = "refleja un nivel extremadamente problemático de inquietud. "
               . "Muestra un grado de preocupación y nerviosismo considerablemente mayor que sus pares. "
               . "Probablemente, experimenta preocupaciones intensas y persistentes, "
               . "una sensación constante de nerviosismo, y una marcada dificultad para controlar sus pensamientos ansiosos.";
}
$ouput5 .= $resultado;

$ouput6 = $register['id_client']."obtuvo una puntuación T de ".$soc_t.", ";
$resultado = "";
if ($soc_t <= 39) {
    $resultado = "indica que experimenta un nivel de ansiedad social menos problemático que la mayoría de su edad. "
               . "Reporta muy poca incomodidad en situaciones sociales o de desempeño. "
               . "Es probable que se sienta más cómodo que el promedio de sus pares en interacciones sociales, "
               . "al hablar en público o al ser evaluado por otros.";
} elseif ($soc_t <= 60) {
    $resultado = "indica que experimenta un nivel de preocupación en situaciones sociales no más problemático que la mayoría de su edad. "
               . "Puede sentir cierta incomodidad ocasional en situaciones sociales o de desempeño, "
               . "pero esto es típico para su grupo de edad y no interfiere con sus interacciones "
               . "sociales o su rendimiento académico.";
} elseif ($soc_t <= 70) {
    $resultado = "indica un nivel moderadamente problemático de ansiedad social. "
               . "Experimenta preocupaciones en situaciones sociales y de desempeño de manera más frecuente o intensa que el promedio de sus pares. "
               . "Puede reportar temor a ser juzgado negativamente por otros, incomodidad al "
               . "hablar en público, o preocupación excesiva por su desempeño en situaciones sociales o académicas.";
} else { // $L18 >= 71
    $resultado = "indica un nivel extremadamente problemático de ansiedad social. "
               . "Muestra un grado de preocupación en situaciones sociales considerablemente mayor que sus pares. "
               . "Probablemente, experimenta un temor intenso a la evaluación negativa, "
               . "una marcada incomodidad en situaciones sociales, "
               . "y una fuerte ansiedad relacionada con el desempeño en público o en la escuela.";
}
$ouput6 .= $resultado;

$ouput7 =$register['id_client']." respondió afirmativamente a ítems considerados críticos:";

$ouput8 = "";

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,8);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,12);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,30);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,41);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,26);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,28);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}

$answer_questions1 = $modelConfiguration->getByItemOrder($answers,37);//preg8 
if($answer_questions1['response'] == '1'){
    $ouput8 .= $answer_questions1['question']." <br>";
}


?>

<!DOCTYPE html>
<html lang="en">
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

		<!-- Internal Morris Css-->
		<link href="../../assets/plugins/morris.js/morris.css" rel="stylesheet">

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
        
        <link href="https://db.onlinewebfonts.com/c/5f9ecd69838280dcd8a9f0072f92f6a6?family=Ronnia+W01+Regular" rel="stylesheet">
        <style>
            @font-face {
                font-family: "Ronnia W01 Regular";
                src: url("https://db.onlinewebfonts.com/t/5f9ecd69838280dcd8a9f0072f92f6a6.woff2") format("woff2"),
                    url("https://db.onlinewebfonts.com/t/5f9ecd69838280dcd8a9f0072f92f6a6.woff") format("woff");
                }
        </style>
        <link href="../../assets/css/style_profile.css?v=<?=VERSION_CODE?>" rel="stylesheet">
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
			<div class="main-content horizontal-content" >
                <br>
				<!-- container opened -->
				<div class="container" >


					<!-- row -->
					<div class="row row-sm">
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
							<div id="contenido1" class="card card-af5">
								<div  class="card-body">
                                    <div class="row row-sm">
                                        <div class="col-12 col-md-3 col-lg-2 img-container">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/perfil-sf.png?v=<?=VERSION_CODE?>">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/cmasr2.png?v=<?=VERSION_CODE?>">
                                        </div>
                                        <div class="col-12 col-md-9 col-lg-10">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input">Id</span>
                                                        </div><input  style="border: 1px solid black !important;color: black;" class="form-control" value="<?=$register['id_client']?>" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input">Edad</span>
                                                        </div><input  style="border: 1px solid black !important;text-align: center;color: black;" class="form-control" value="<?=$register['age']?>" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input">Sexo</span>
                                                        </div><input  style="border: 1px solid black !important;text-align: center;color: black;" class="form-control" value="<?=$register['sex']?>" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input">Fecha</span>
                                                        </div><input  style="border: 0.5px solid black !important;text-align: center;color: black;" class="form-control" value="<?= date('Y-m-d H:i:s'); ?>" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input" id="basic-addon1">Baremo</span>
                                                        </div>
                                                        <form action="result2.php" method="post" id="form_baremo" style="margin:0;">
                                                            <input type="hidden" name="id_user" id="id_user" value="<?=$idClient?>">
                                                            <input type="hidden" name="id_register" id="id_register" value="<?=$register['id']?>">
                                                            <select  style="border: 0.5px solid black !important;margin:0px;border-radius: 15px;height: 35px;color: black;" class="form-control mg-t-20 select2-no-search" id="baremo_id" name="baremo_id">
                                                                <?php
                                                                foreach($baremos as $baremo){
                                                                ?>
                                                                <option value="<?=$baremo['id']?>" <?=$baremo['active']=='0'?'disabled':''?> <?=$register['baremo_id']==$baremo['id']?'selected':''?>>
                                                                    <?=htmlspecialchars($baremo['name'])?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </form>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-12 col-lg-8">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input" id="basic-addon1">Responsable de aplicación</span>
                                                        </div><input style="border: 0.5px solid black !important;color: black;" aria-describedby="basic-addon1" class="form-control" value="Edgar Espinoza Jimenez" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
								</div>
							</div>
						</div>
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                            <div  id="contenido2" class="card" >
                                <div class="card-body">
                                    <div class="row row-sm">
                                        <div class="col-md-6" style="padding-right:0px;">
                                            <div class="card-body" style="padding-right: 0px;padding-left: 0px;">
                                                    
                                                <div class="table-responsive">
                                                    <table class="table mg-b-0 text-md-nowrap" style="font-size: 18px;color: #000000;">
                                                        
                                                        <tbody style="text-align: right;text-align: center;">
                                                            <tr  class="tr_fill" style="font-weight: bold;">
                                                                <td class="td_fill-masr2" >Escalas</td>
                                                                <th scope="row"  class="text-primary td_name_masr2"></th>
                                                                
                                                                <td class="td_valuepd">PD</td>
                                                                <td class="td_valuetb">PC</td>
                                                                <td class="td_valuetb">T</td>
                                                            </tr>
                                                            <tr  class="tr_fill" style="border-bottom: 2px solid #beecdb !important;">
                                                                    
                                                            </tr>
                                                            <tr class="tr_fill">
                                                                <td class="td_fill-masr2">Defensividad</td>
                                                                <th class="text-primary td_name_masr2" scope="row">DEF</th>
                                                                
                                                                <td class="td_valuepd"><div class="borde-masr2"><?=$def?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$def_pc?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$def_t?></div></td>
                                                            </tr>
                                                            <tr class="tr_fill">
                                                            <td class="td_fill-masr2">Ansiedad Fisiológica</td>
                                                                <th class="text-primary td_name_masr2" scope="row">FIS</th>
                                                                
                                                                <td class="td_valuepd"><div class="borde-masr2"><?=$fis?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$fis_pc?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$fis_t?></div></td>
                                                            </tr>
                                                            <tr class="tr_fill">
                                                            <td class="td_fill-masr2">Inquietud</td>
                                                                <th class="text-primary td_name_masr2" scope="row" >INQ</th>
                                                                
                                                                <td class="td_valuepd"><div class="borde-masr2"><?=$inq?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$inq_pc?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$inq_t?></div></td>
                                                            </tr>
                                                            <tr class="tr_fill">
                                                            <td class="td_fill-masr2">Ansiedad Social</td>
                                                                <th class="text-primary td_name_masr2" scope="row">SOC</th>
                                                                
                                                                <td class="td_valuepd"><div class="borde-masr2"><?=$soc?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$soc_pc?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$soc_t?></div></td>
                                                            </tr>
                                                            <tr class="tr_fill">
                                                            <td class="td_fill-masr2">Ansiedad Total</td>
                                                                <th class="text-primary td_name_masr2" scope="row">TOT</th>
                                                                
                                                                <td class="td_valuepd"><div class="borde-masr2"><?=$tot?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$tot_pc?></div></td>
                                                                <td class="td_valuetb"><div class="borde-masr2"><?=$tot_t?></div></td>
                                                            </tr>
                                                            <tr class="tr_fill">
                                                            <td class="td_fill-masr2">Inconsistencia</td>
                                                                <th class="text-primary td_name_masr2" scope="row">INC</th>
                                                                
                                                                <td class="td_valuepd"><div class="borde-masr2"><?=$inc?></div></td>
                                                                <td class="td_valuetb"></td>
                                                                <td class="td_valuetb"></td>
                                                            </tr>
                                                            <tr  class="tr_fill" style="border-bottom: 2px solid #beecdb !important;">
                                                                    
                                                            </tr>
                                                            <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill-masr2"></td>
                                                                    <th scope="row"  class="text-primary td_name_masr2"></th>
                                                                    
                                                                    <td class="td_valuepd">PD</td>
                                                                    <td class="td_valuetb">PC</td>
                                                                    <td class="td_valuetb">T</td>
                                                                </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left:0px;">
                                            <div class="card-body" style="padding-right: 0px;padding-left: 0px;">
                                                <div class="content-4"><div class="content-green"><h4 class="content-txt" style="width: 218px;">Bajo</h4></div><div class="content-orange"><h4 class="content-txt" style="width: 117px;">Media</h4></div><div class="content-yellow"><h4 class="content-txt" style="width: 60px;">Moderado</h4></div><div class="content-grave"><h4 class="content-txt" style="width: 140px;">Grave</h4></div></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 16px;height: 255px !important;width: 100%;" id="colorss"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 2px;height: 205px !important;" id="flotLine2"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 0px;height: 55px !important;" id="flotLineIndRiesgoPat"></div>
                                                <p class="mg-t-20" style="text-align: left;color: #000000;font-size: 15px !important;margin-left: 20px;"><span style="font-weight: bold;">Nota:</span> Nota: Puntuación típica T (Media=50; Dt = 10)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
						
                        <div class="col-md-12">
                            <div id="contenido3" class="card card-body" style="padding-bottom: 100px;text-align: justify;">
                                <div class="main-content-label mg-b-5">
                                    <h3 style="text-align: center;color: black;font-weight: bold;">Informe escala de ansiedad manifiesta en niños revisada (CMASR-2)</h3>
                                </div>
                                <div class="card-body">
                                    <p class="tx-dark mb-0 tx-13 txt-force-black">La Escala de Ansiedad Manifiesta en Niños Revisada, Segunda Edición (CMASR-2) es un instrumento de autoinforme diseñado para evaluar el nivel y la naturaleza de la ansiedad en niños y adolescentes de 6 a 19 años. Consta de 49 reactivos que el examinado responde con "Sí" o "No". </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title  fw-semibold tx-13">Validez de las Respuestas, </span> El CMASR-2 evalúa la validez de las respuestas del examinado. Esto se logra a través de dos índices:</p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Índice de Respuestas Inconsistentes (INC),</span>  Evalúa si respondió de manera consistente la prueba. Puntuaciones altas en este indican que las respuestas pueden haber sido dadas al azar o sin suficiente atención.</p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput1;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Defensividad (DEF), </span>  Indica si intentó presentar una imagen excesivamente positiva de sí mismo.</p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput2;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Ansiedad General (TOT), </span>  La puntuación de Ansiedad total es considerada la más robusta del CMASR-2. Proporciona una visión general del nivel de ansiedad que experimenta el examinado.</p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput3;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Escalas relacionadas con la ansiedad, </span>  proporciona resultados en tres escalas principales que ofrecen una comprensión más detallada de la naturaleza de la ansiedad del evaluado:</p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Ansiedad Fisiológica (FIS), </span>  Evalúa las manifestaciones físicas de la ansiedad. Se enfoca en aspectos somáticos como náuseas, dificultades de sueño, dolores de cabeza y fatiga. </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput4;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Inquietud (INQ), </span>   Evalúa sentimientos de nerviosismo, preocupaciones sobre posibles daños, y una hipersensibilidad general a las presiones del entorno.  </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput5;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Ansiedad Social (SOC), </span>   Evalúa la ansiedad en situaciones sociales y de desempeño. Mide preocupaciones relacionadas con las interacciones sociales, el miedo a ser juzgado negativamente por otros, y la ansiedad asociada con el rendimiento en situaciones públicas o académicas. </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput6;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Ítems Críticos </span> </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput7;?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"><span class="title fw-semibold tx-13">Ítems significativos </span> </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13 txt-force-black"> <?=$ouput8;?></p>
                                    <br><br>
                                    
                                    <br><br>
                                </div>
                                
                            </div>
                            <div style="justify-self: center;position: absolute;bottom: 0px;">
                                    <!--img id="contenido4"  alt="" class="float-sm-right mg-sm-t-0" style="width:auto" src="../../assets/img/lsb50/image.png"-->
                            </div>
                        </div>

					</div>
					<!-- row closed -->
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

			<?php include("../include/footer.php");?>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<?php include("../include/print_content.php");?>

		<!-- JQuery min js -->
		<script src="../../assets/plugins/jquery/jquery.min.js"></script>

		<!--Internal  Datepicker js -->
		<script src="../../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Internal Flot js -->
		<script src="../../assets/plugins/jquery.flot/jquery.flot.js"></script>
		<script src="../../assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
		<script src="../../assets/plugins/jquery.flot/jquery.flot.resize.js"></script>

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

		<!-- Internal Chart flot js -->
		<!--script src="../../assets/js/chart.flot.js"></script-->

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
        <script src="../../assets/js/print.js?v=<?=VERSION_CODE?>"></script>
        <script src="../../assets/js/flot-circle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script>
           var pathprint = "<?php echo LOCALHOST; ?>";

            $(function() {
            'use strict';
                var colorLine = "black";


                var colores = $.plot($('#colorss'), [{
                    data: [],
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 1,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true,
                        tickColor: 'rgba(171, 167, 167, 0)',
                         markings: [
                            {
                                xaxis: { from: 0, to: 39 },
                                color: '#c0d7ea'
                            },
                            {
                                xaxis: { from: 39, to: 60 },
                                color: '#4fab8a'
                            },
                            {
                                xaxis: { from: 60, to: 71 },
                                color: '#eed7a4'
                            },
                            {
                                xaxis: { from: 71, to: 80 },
                                color: '#faf4e6'
                            },
                            { // Línea punteada en X = 50
                                xaxis: { from: 50, to: 50 },
                                color: '#000', // color de la línea
                                lineWidth: 0.5
                            },
                        ]
                    },
                    yaxis: {
                        min: 0,
                        max: 12,
                        color: '#eee',
                        ticks: [[0, ''], [12, '']], 
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: 'transparent'
                        },
                        show:false
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        show:false,
                        max: 99,
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: '#999'
                        }
                    }
                });

                var newCust = [
                    
                    [<?=$def_t?>,30],
                    [<?=$fis_t?>,20],
                    [<?=$inq_t?>,10],
                    [<?=$soc_t?>,0]
                ];
                
                var plot = $.plot($('#flotLine2'), [{
                    data: newCust,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 5,
                        hoverable: true,
                        borderColor: 'white',
                        borderRadius: 0,
                        innerMargin: -2,
                        show:true,
                         markings: [
                            
                         ]
                    },
                    yaxis: {
                        min: -5,
                        max: 35,
                        color: 'black',
                        ticks: [[0, ''], [15, '']], 
                        tickColor: 'black',
                        tickLength: 0,
                        font: {
                            size: 10,
                            color: 'black'
                        }
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 99,
                        tickColor: 'black',
                        tickLength: 0,
                        ticks: [
                            [1, '1'],
                            [39, '39'],
                            [50, '50'],
                            [30, '30'],
                            [50, '50'],
                            [60, '60'],
                            [70, '70'],
                            [80, '80'],
                        ],
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top'
                    }
                });
              
                
                var flotLineIndRiesgoPat = [
                    [<?=$tot_t?>, 6]
                ];
                
                var plot = $.plot($('#flotLineIndRiesgoPat'), [{
                    data: flotLineIndRiesgoPat,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 1,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true,
                        tickColor: 'rgba(171, 167, 167, 0)'
                    },
                    yaxis: {
                        min: 0,
                        max: 12,
                        color: '#eee',
                        ticks: [[0, ''], [12, '']], 
                        tickColor: 'rgba(171, 167, 167,0.2)',
                        font: {
                            size: 10,
                            color: '#999'
                        }
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 99,
                        tickColor: 'white',
                        ticks: [
                            [1, '1'],
                            [39, '39'],
                            [50, '50'],
                            [30, '30'],
                            [50, '50'],
                            [60, '60'],
                            [70, '70'],
                            [80, '80'],
                        ],
                        tickLength: 0,
                        font: {
                            size: 10,
                            color: 'transparent'
                        },
                        position:'bottom'
                    }
                });
            
            function labelFormatter(label, series) {
                return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
            }
        });
        setTimeout(function() {
            document.getElementById('colorss').style.position = 'absolute';
        }, 1000);
        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });

        </script>
	</body>
</html>