<?php
include_once('../configs.php');

session_start();
require '../../vendor/autoload.php';
use Dompdf\Dompdf;

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");

include("../models/scl90/model_baremo_poblacion_general_no_clinica_mujeres.php");
include("../models/scl90/model_baremo_poblacion_general_no_clinica_varones.php");
include("../models/scl90/model_baremo_nuestra_psiquitria_varones.php");
include("../models/scl90/model_baremo_nuestra_psiquitria_mujeres.php");
include("../models/scl90/model_baremo_dmt_pacientes_disfusion.php");

include("../models/scl90/model_scl_configuration.php");
$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$sclConfiguration = new ModelSclConfiguration();
$idClient = 0;
$idpatient = 0;

$device = $registerModel->getDeviceType();
if ($device === 'mobile') {
    echo "No disponible para telefonos moviles o dispositivos pequeños";
    exit;
}

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
}
$baremos = $baremoModel->getAll($register['id_type_question']);
//echo json_encode($register);
if($register['baremo_id'] == 46){
    $baremo = new ModelSCLBaremoPoblacionGeneralVarones();
}
if($register['baremo_id'] == 47){
    $baremo = new ModelSCLBaremoPoblacionGeneralMujeres();
}
if($register['baremo_id'] == 48){
    $baremo = new ModelSCLBaremoPacientesDisfusion();
}
if($register['baremo_id'] == 49){
    $baremo = new ModelSCLBaremoPsiquiatriaVarones();
}
if($register['baremo_id'] == 50){
    $baremo = new ModelSCLBaremoPsiquiatriaMujeres();
}
$answers = $answerModel->getAll($register['codes']);

//$totalSumatoria = $answerModel->sumatoriaTodo($answers);

$value_som = $answerModel->sumatoria($answers,[1,4,12,27,40,42,48,49,52,53,56,58]);
$value_obs = $answerModel->sumatoria($answers,[3,9,10,28,38,45,46,51,55,65]);
$value_int = $answerModel->sumatoria($answers,[6,21,34,36,37,41,61,69,73]);
$value_dep = $answerModel->sumatoria($answers,[5,14,15,20,22,26,29,30,31,32,54,71,79]);
$value_ans = $answerModel->sumatoria($answers,[2,17,23,33,39,57,72,78,80,86]);
$value_hos = $answerModel->sumatoria($answers,[11,24,63,67,74,81]);
$value_fob = $answerModel->sumatoria($answers,[13,25,47,50,70,75,82]);
$value_par = $answerModel->sumatoria($answers,[8,18,43,68,76,83]);
$value_psi = $answerModel->sumatoria($answers,[7,16,35,62,77,84,85,87,88,90]);

$itemadicionales = $answerModel->sumatoria($answers,[19,44,59,60,64,66,89]);

$gsi = $value_som+$value_obs+$value_int+$value_dep+$value_ans+$value_hos+$value_fob+$value_par+$value_psi+$itemadicionales;
$gsi = number_format($gsi/count($answers),2);

$pst = $sclConfiguration->contarNoCeros($answers);

$psdi = number_format(($gsi*90)/$pst,2);

$array_gsi = $baremo->getGSI();
$gsi_t = $array_gsi["$gsi"][0];
$gsi_pc = $array_gsi["$gsi"][1];

$array_pst = $baremo->getPST();
$pst_t = $array_pst["$pst"][0];
$pst_pc = $array_pst["$pst"][1];

$array_psdi = $baremo->getPSDI();
$psdi_t = $array_psdi["$psdi"][0];
$psdi_pc = $array_psdi["$psdi"][1];
//echo json_encode($valor);

$som = number_format($value_som/12,2);
$array_som = $baremo->getSOM();
$som_t = $array_som["$som"][0];
$som_pc = $array_som["$som"][1];

$obs = number_format($value_obs/10,2);
$array_obs = $baremo->getOBS();
$obs_t = $array_obs["$obs"][0];
$obs_pc = $array_obs["$obs"][1];

$int = number_format($value_int/9,2);
$array_int = $baremo->getINT();
$int_t = $array_int["$int"][0];
$int_pc = $array_int["$int"][1];

$dep = number_format($value_dep/13,2);
$array_dep = $baremo->getDEP();
$dep_t = $array_dep["$dep"][0];
$dep_pc = $array_dep["$dep"][1];

$ans = number_format($value_ans/10,2);
$array_ans = $baremo->getANS();
$ans_t = $array_ans["$ans"][0];
$ans_pc = $array_ans["$ans"][1];

$hos = number_format($value_hos/6,2);
$array_hos = $baremo->getHOS();
$hos_t = $array_hos["$hos"][0];
$hos_pc = $array_hos["$hos"][1];


$fob = number_format($value_fob/7,2);
$array_fob = $baremo->getFOB();
$fob_t = $array_fob["$fob"][0];
$fob_pc = $array_fob["$fob"][1];

$par = number_format($value_par/6,2);
$array_par = $baremo->getPAR();
$par_t = $array_par["$par"][0];
$par_pc = $array_par["$par"][1];

$psi = number_format($value_psi/10,2);
$array_psi = $baremo->getpsi();
$psi_t = $array_psi["$psi"][0];
$psi_pc = $array_psi["$psi"][1];

$resultado = "";
if ($gsi_t <= 50) {
    $resultado = "Indica que se encuentran dentro del rango normal. Esta categoría indica que los síntomas reportados no son significativos ni en número ni en intensidad, situándose dentro de los parámetros esperados para la población general. Esta puntuación sugiere la ausencia de sintomatología que pudiera influir en la capacidad funcional de manera sustancial.";
} elseif ($gsi_t <= 63) {
    $resultado = "Refleja un nivel de malestar psicológico y somático ligeramente superior al normal. Los síntomas son más pronunciados que en la media de la población, aunque no alcanzan niveles de alta severidad. Esta categoría podría indicar la presencia de sintomatología leve que, aunque perceptible, no necesariamente afecta de manera crítica el desempeño o las capacidades.";
} elseif ($gsi_t >= 64) {
    $resultado = "Indica un nivel elevado de malestar psicológico y somático. Los síntomas reportados son numerosos e intensos, significativamente superiores a los observados en la población general. Esta categoría sugiere una psicopatología significativa que podría tener implicaciones importantes en la evaluación de la capacidad funcional y el estado psicológico.";
}

$indiceglobal1 = "El Índice Global de Severidad (GSI) del SCL-90-R evalúa la medida general de la intensidad del malestar psicológico y somático. En este caso";
$indiceglobal1 .= ", se observa una puntuación T de ".$gsi_t.", ".$resultado;

if ($pst_t <= 50) {
    $resultado = "Indica que el número total de síntomas reportados se encuentra dentro del rango considerado normal. Los síntomas presentes no son numerosos y se alinean con lo esperado en la población general. Esta puntuación sugiere una baja frecuencia de síntomas psicológicos y somáticos.";
} elseif ($pst_t <= 63) {
    $resultado = "Indica que el número de síntomas reportados es ligeramente elevado. La cantidad de síntomas presentes es superior a la media de la población general, aunque no alcanza niveles de alta severidad. Esta puntuación indica una mayor presencia de síntomas, aunque de baja intensidad.";
} elseif ($pst_t >= 64) {
    $resultado = "Indica que el número total de síntomas reportados es elevado. La cantidad de síntomas presentes es significativamente mayor que la observada en la población general. Esta puntuación refleja una alta frecuencia de síntomas psicológicos y somáticos, indicando una severidad significativa.";
}

$indiceglobal2 = "El Total de Síntomas Positivos (PST) contabiliza la cantidad total de síntomas presentes, indicando la amplitud y diversidad de la psicopatología, en este índice obtuvo una puntuación T de ";
$indiceglobal2 .= " ".$pst_t.", ".$resultado;

if ($psdi_t <= 50) {
    $resultado = "Refleja que la intensidad del malestar asociado con los síntomas reportados se encuentra dentro del rango considerado normal. Los síntomas presentes no generan un malestar significativo y se alinean con lo esperado en la población general. Esta puntuación indica que, aunque pueda haber síntomas presentes, estos no son percibidos como altamente perturbadores.";
} elseif ($psdi_t <= 63) {
    $resultado = "Refleja que la intensidad del malestar asociado con los síntomas es ligeramente superior a la media. El malestar generado por los síntomas es superior al promedio de la población general, aunque no alcanza niveles de alta severidad. Esta puntuación sugiere que los síntomas presentes son percibidos con una intensidad de malestar mayor, aunque manejable.";
} elseif ($psdi_t >= 64) {
    $resultado = "Refleja que la intensidad del malestar asociado con los síntomas reportados es elevada. El malestar generado por los síntomas es significativamente superior al observado en la población general. Esta puntuación refleja una alta severidad en la percepción del malestar, indicando que los síntomas presentes son intensamente perturbadores.";
}

$indiceglobal3 = "El Índice de Malestar Sintomático Positivo (PSDI) relaciona el malestar global con el número de síntomas, siendo un indicador de la intensidad media de los síntomas. En este caso, se observa una puntuación T de ";
$indiceglobal3 .= $psdi_t.", ".$resultado;

$array_ind = [$value_som,$value_obs,$value_int,$value_dep,$value_ans,$value_hos,$value_fob,$value_par,$value_psi];

//$array_pd = [$som_pc,$obs_pc,$int_pc,$dep_pc,$ans_pc,$hos_pc,$fob_pc,$par_pc,$psi_pc];
$array_pd = [$som,$obs,$int,$dep,$ans,$hos,$fob,$par,$psi];
$array_pd = array_map('floatval', $array_pd);

$array_t = [$som_t,$obs_t,$int_t,$dep_t,$ans_t,$hos_t,$fob_t,$par_t,$psi_t];

$top1 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$som_t,$som,$value_som,0);
$top2 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$obs_t,$obs,$value_obs,1);
$top3 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$int_t,$int,$value_int,2);
$top4 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$dep_t,$dep,$value_dep,3);
$top5 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$ans_t,$ans,$value_ans,4);
$top6 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$hos_t,$hos,$value_hos,5);
$top7 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$fob_t,$fob,$value_fob,6);
$top8 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$par_t,$par,$value_par,7);
$top9 = $sclConfiguration->getIndex($array_t,$array_pd,$array_ind,$psi_t,$psi,$value_psi,8);

$data_values = [
    "Somatización" => $top1,
    "Obsesión-compulsión" =>$top2, 
    "Sensibilidad interpersonal" => $top3,
    "Depresión" => $top4,
    "Ansiedad" => $top5,
    "Hostilidad" => $top6,
    "Ansiedad fóbica" => $top7,
    "Ideación paranoide" => $top8,
    "Psicoticismo" => $top9
    
];
$data_ts = [
    "Somatización" => $som_t,
    "Obsesión-compulsión" =>$obs_t, 
    "Sensibilidad interpersonal" => $int_t,
    "Depresión" => $dep_t,
    "Ansiedad" => $ans_t,
    "Hostilidad" => $hos_t,
    "Ansiedad fóbica" => $fob_t,
    "Ideación paranoide" => $par_t,
    "Psicoticismo" => $psi_t
    
];
asort($data_values);

        
$data_tops = $sclConfiguration->getTop($data_values,$data_ts);
$datatop1 = $data_tops[0];
$salidatop1 = $datatop1["name"]." esta dimensión ".$datatop1["message2"]." El resultado obtenido ".$datatop1["message1"];
if($datatop1["message2"]=="" && $datatop1["message1"] == ""){
    $salidatop1 = "Las escalas evaluadas no registran puntajes T superiores a 51; en consecuencia, no se considera viable realizar una interpretación cualitativa de ninguna de ellas.";
}

$datatop2 = $data_tops[1];
$salidatop2 = $datatop2["name"]." esta dimensión ".$datatop2["message2"]." El resultado obtenido ".$datatop2["message1"];
if($datatop2["message2"]=="" && $datatop2["message1"] == ""){
    $salidatop2 = "";
}
$datatop3 = $data_tops[2];
$salidatop3 = $datatop3["name"]." esta dimensión ".$datatop3["message2"]." El resultado obtenido ".$datatop3["message1"];
if($datatop3["message2"]=="" && $datatop3["message1"] == ""){
    $salidatop3 = "";
}
$datatop4 = $data_tops[3];
$salidatop4 = $datatop4["name"]." esta dimensión ".$datatop4["message2"]." El resultado obtenido ".$datatop4["message1"];
if($datatop4["message2"]=="" && $datatop4["message1"] == ""){
    $salidatop4 = "";
}
$indicador_salida = "";
$sexo_value = $register["sex"];
if ($pst <= 4) {
    $indicador_salida = "El resultado indica que se debe considerar negación de síntoma o minimización de patología.";
} elseif ($sexo_value == "FEMENINO" && $pst >= 60) {
    $indicador_salida = "El resultado indica una tendencia aumentador o exageración de la patología.";
} elseif ($sexo_value == "MASCULINO" && $pst >= 50) {
    $indicador_salida = "El resultado indica una tendencia aumentador o exageración de la patología.";
} else {
    $indicador_salida = "No se observa una tendencia a maximizar o minimizar la patología.";
}
$cant_answers_text = 0;
$pr44 = $answerModel->sumatoria($answers,[44]);
$answers_text = "";
if($pr44>=3){
    $answers_text .= "44 Problemas para dormir";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$pr44 = $answerModel->sumatoria($answers,[19]);

if($pr44>=3){
    $answers_text .= "19 Poco apetito";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$pr44 = $answerModel->sumatoria($answers,[59]);

if($pr44>=3){
    $answers_text .= "59 Pensamientos acerca de la muerte o el morirse";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$pr44 = $answerModel->sumatoria($answers,[60]);

if($pr44>=3){
    $answers_text .= "60 Comer en exceso";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$pr44 = $answerModel->sumatoria($answers,[64]);

if($pr44>=3){
    $answers_text .= "64 Despertarse muy temprano";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$pr44 = $answerModel->sumatoria($answers,[66]);

if($pr44>=3){
    $answers_text .= "66 Sueño intranquilo";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$pr44 = $answerModel->sumatoria($answers,[89]);

if($pr44>=3){
    $answers_text .= "89 Sentimientos de culpa";
    $answers_text .= $pr44 == 3?" (Bastante) <br>":" (Extremadamente) <br>";
    $cant_answers_text+=1;
}

$recomendacion_baremo = "";
$array = [$som_pc,$obs_pc,$int_pc,$dep_pc,$ans_pc,$hos_pc,$fob_pc,$par_pc,$psi_pc];
if($gsi_pc>=90 || $sclConfiguration->contarMayoresIguales($array,90)>= 2){
    $recomendacion_baremo = "Aplicar Baremos población psiquiátrica";
}
elseif($gsi_pc >= 80 || $sclConfiguration->contarMayoresIguales($array, 80) >= 2){
    $cond_mujer = ($register['sex'] == "FEMENINO") && ($gsi_pc >= 80 || contarMayoresIguales($array, 80) >= 2);
    $cond_varon = ($register['sex'] == "MASCULINO") && ($gsi_pc >= 70 || contarMayoresIguales($array, 70) >= 2);
    if ($cond_mujer || $cond_varon) {
        $recomendacion_baremo = "Aplicar Baremos población psiquiátrica";
    } else {
        $recomendacion_baremo = "Aplicar Baremos disfunción psicosomática témporo-mandibular";
    }
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
		<link href="../../assets/css/icons.css?v=<?=VERSION_CODE?>" rel="stylesheet">

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
        <link href="../../assets/css/style_profile4.css?v=<?=VERSION_CODE?>" rel="stylesheet">
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
                            <div id="contenidoID" class="card-scl90" style="border-radius: 17px;position: absolute;width: 90%;top: 30px;">
                                <div  class="card-body" style="padding:10px 5px 10px 5px">
                                    <div class="row row-sm">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="input-group">
                                                <div class="input-group-text setting-input">
                                                    <span class="input-group-text setting-input">Id</span>
                                                </div><input  style="color: black;    height: 30px !important;" class="form-control" value="<?=$register['id_client']?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    
								</div>
                            </div>
							<div id="contenido1" class="card card-scl90">
								<div class="card-body">
                                    <div class="row row-sm">
                                        <div class="col-12 col-md-3 col-lg-2 img-container" style="padding-left: 25px;">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/perfil-sf.png?v=<?=VERSION_CODE?>">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/scl90.jpeg?v=<?=VERSION_CODE?>">
                                        </div>
                                        <div class="col-12 col-md-9 col-lg-10">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Id</span>
                                                        </div><input class="form-control" style="color: black;" value="<?=$register['id_client']?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-2 col-lg-2">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Edad</span>
                                                        </div><input class="form-control" style="text-align: center;color: black;" value="<?=$register['age']?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Sexo</span>
                                                        </div><input class="form-control" style="text-align: center;color: black;" value="<?=$register['sex']?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Fecha</span>
                                                        </div><input class="form-control" style="text-align: center;color: black;" value="<?= date('Y-m-d H:i'); ?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-7 col-lg-7">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red" id="basic-addon1">Baremo</span>
                                                        </div>
                                                        <form action="result2.php" method="post" id="form_baremo" style="margin:0;">
                                                            <input type="hidden" name="id_user" id="id_user" value="<?=$idClient?>">
                                                            <input type="hidden" name="id_register" id="id_register" value="<?=$register['id']?>">
                                                            <select style="width: 400px;margin:0px;border-radius: 15px;height: 35px;color: black;" class="form-control mg-t-20 select2-no-search" id="baremo_id" name="baremo_id">
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
                                                <div class="col-md-5 col-lg-5">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red" id="basic-addon1">Evaluador</span>
                                                        </div><input style="color: black;" class="form-control" value="<?=$register['evaluador']?>" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red" id="basic-addon1">Recomendaciones de baremo</span>
                                                        </div><input style="color: black;" class="form-control"  type="text" value="<?=$recomendacion_baremo?>"> 
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
									
								</div>
							</div>
						</div>
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                            <div id="contenido2" class="card" >
                                <div class="card-body" style="padding-left: 100px;padding-right: 100px;">
                                   <div class="row row-sm" style="place-content: center;">
                                        <div class="col-md-7" style="padding-right:0px;">
                                            <div class="card-body" style="padding-right: 0px;padding-left: 0px;">
                                                <div style="margin-bottom: 75px;">
                                                    <div class="table-responsive">
                                                        <table class="table mg-b-0 text-md-nowrap">
                                                            
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    
                                                                    <td class="td_fill"><div class="borde-text">Indices Globales</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">T</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Índice global de gravedad o severidad</div> <div class="width-move2">GSI</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$gsi?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$gsi_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$gsi_pc?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Total de Síntomas Positivos</div><div class="width-move2">PST</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$pst?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$pst_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$pst_pc?></div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Distrés de síntomas Positivos</div><div class="width-move2">PSDI</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$psdi?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$psdi_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$psdi_pc?></div></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table mg-b-0 text-md-nowrap" style="margin-top:5px">
                                                            
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill"><div class="borde-text">Dimensiones sintomáticas</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">T</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Somatización</div><div class="width-move2">SOM</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$som?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$som_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$som_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Obsesión-compulsión</div><div class="width-move2">OBS</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$obs?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$obs_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$obs_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Sensibilidad interpersonal</div><div class="width-move2">INT</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$int?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$int_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$int_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Depresión</div><div class="width-move2">DEP</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$dep?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$dep_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$dep_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Ansiedad</div><div class="width-move2">ANS</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$ans?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$ans_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$ans_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Hostilidad</div><div class="width-move2">HOS</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$hos?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$hos_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$hos_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Ansiedad fóbica</div><div class="width-move2">FOB</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$fob?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$fob_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$fob_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Ideación paranoide</div><div class="width-move2">PAR</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$par?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$par_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$par_pc?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-subtitle">Psicoticismo</div><div class="width-move2">PSI</div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$psi?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$psi_t?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-scl90"><?=$psi_pc?></td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                        <table class="table mg-b-0 text-md-nowrap" style="margin-top:5px">
                                                           
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill"></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">T</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>          
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="padding-left:0px;">
                                            <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="content-4"><div class="content-green"><h4 class="content-txt" style="width: 195px;">Sin morbilidad</h4></div><div class="content-orange"><h4 class="content-txt" style="width: 50px;">Menor</h4></div><div class="content-yellow"><h4 class="content-txt" style="width: 140px;">Con morbilidad</h4></div></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 16px;height: 520px !important;width: 100%;" id="colorss"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 12px;height: 150px !important;" id="flotLineIndGeneral"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 10px;height: 370px !important;" id="flotLineEscalasClinicas"></div>
                                                <span style="text-align: left;font-size: 14px;padding-left: 10px;">Nota T: Media 50 y Desviacion tipica de 10</span>
                                            </div>
                                        </div>
                                   </div>
                                    
                                </div>
                            </div>
                            

                        </div>
						
                        <div class="col-md-12">
                            <div id="contenido3" class="card card-body" style="padding-bottom: 100px;text-align: justify;">
                                <div class="main-content-label mg-b-5">
                                    <h1 style="text-align: center;"  id="jsonvalue1">INFORME CUESTIONARIO DE 90 SÍNTOMAS (SCL-90-R)</h1>
                                </div>
                                <div class="card-body">
                                    <h4 class="tx-15" id="jsonvalue2">I. ÍNDICES GLOBALES</h4>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue3">
                                        <?=$indiceglobal1?>
                                    </p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue4">
                                        <?=$indiceglobal2?>
                                    </p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue5">
                                        <?=$indiceglobal3?>
                                    </p>

                                </div>
                                <div class="card-body ">
                                    <h4 class="tx-15" id="jsonvalue6">II. DIMENSIONES SINTOMÁTICAS</h4>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue7">En este apartado se presentan los resultados de las dimensiones específicas del SCL 90 R, donde se identifican cuatro puntajes superiores a las demás dimensiones sintomáticas: <br>
                                    </p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue8">
                                        <?=$salidatop1?>
                                    </p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue9">
                                        <?=$salidatop2?>
                                    </p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue10">
                                        <?=$salidatop3?>
                                    </p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13" id="jsonvalue11">
                                        <?=$salidatop4?>
                                    </p>
                                    
                                </div>
                                <div class="card-body">
                                        <h4 class="tx-15" id="jsonvalue12">III. INDICADOR DE POSIBLE SIMULACIÓN DE SÍNTOMA</h4>
                                        <p class="tx-dark mb-0 tx-13" id="jsonvalue13">PST= PD<=4 es altamente sospechoso de negación de síntoma o minimización de patología. PST PD>=50 varones PST PD>=60 Mujeres es altamente sospechoso, tendencia aumentador o exageración de la patología.
                                        </p>
                                        <br>
                                        <p class="tx-dark mb-0 tx-13" id="jsonvalue14">
                                            <?=$indicador_salida?>
                                        </p>
                                        <br><br>
                                    
                                </div>
                                <div class="card-body ">
                                        <h4 class="tx-15" id="jsonvalue15">Ítems Adicionales - Síntomas misceláneos</h4>
                                        <p class="tx-dark mb-0 tx-13" id="jsonvalue16">
                                        Derogatis considera que, aunque son indicadores de la gravedad del estado del sujeto, no constituyen una dimensión sintomática especifica. 
                                        </p>
                                </div>
                                <div class="card-body">
                                        <h4 class="tx-15" id="jsonvalue17">Se identificaron (<?=$cant_answers_text?>/7) Items síntomas misceláneos con una intensidad que varia de bastante a extremadamente</h4>
                                        <p class="tx-dark mb-0 tx-13" id="jsonvalue18">
                                        <?=$answers_text?><br>
                                        </p>
                                </div>
                                
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

        <script src="../../assets/js/flot-circle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script>
            const name_user = "<?php echo $register['id_client'] ?>";
            const testname = "<?php echo $register['type_question_name']?>";
            const filenamepdf = (name_user+"_"+testname).replace(/\s+/g, '');
            var jsonpdf = [];
            jsonpdf.push({type:2,image:"contenido1"} );
            jsonpdf.push({type:2,image:"contenido2"} );
            jsonpdf.push({type:4,text:getvalue('jsonvalue1')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:7,text:getvalue('jsonvalue2')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue3')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue4')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue5')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:7,text:getvalue('jsonvalue6')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue7')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue8')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue9')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} ); 
            jsonpdf.push({type:5,text:getvalue('jsonvalue10')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue11')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:7,text:getvalue('jsonvalue12')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue13')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue14')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:7,text:getvalue('jsonvalue15')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue16')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:7,text:getvalue('jsonvalue17')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:8,text:getvalue('jsonvalue18')} );
            $(function() {
            'use strict';
                var colorLine = "black";
                
                var flotLineIndGeneral = [
                    [<?=$gsi_t?>, 20],
                    [<?=$pst_t?>, 10],
                    [<?=$psdi_t?>, 0]
                ];
                
                var plot = $.plot($('#flotLineIndGeneral'), [{
                    data: flotLineIndGeneral,
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
                        show:true
                    },
                    yaxis: {
                        min: -5,
                        max: 25,
                        color: '#eee',
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: 'transparent'
                        }
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 99,
                        tickColor: 'transparent',
                        ticks: [
                            [0, '10'],
                            [50, '50'],
                            [63, '63'],
                            [75, '75'],
                            [99, '100']
                        ],
                        tickLength: 0,
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top'
                    }
                });
                var flotLineEscalasClinicas = [
                    [<?=$som_t?>, 80],
                    [<?=$obs_t?>, 70],
                    [<?=$int_t?>, 60],
                    [<?=$dep_t?>, 50],
                    [<?=$ans_t?>, 40],
                    [<?=$hos_t?>, 30],
                    [<?=$fob_t?>, 20],
                    [<?=$par_t?>, 10],
                    [<?=$psi_t?>, 0]
                ];
                
                var plot = $.plot($('#flotLineEscalasClinicas'), [{
                    data: flotLineEscalasClinicas,
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
                        show:true
                    },
                    yaxis: {
                        min: -5,
                        max: 85,
                        color: '#737f9e',
                        ticks: [[0, ''], [85, '']], 
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: '#999'
                        },
                        show:false
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 99,
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: '#999'
                        },
                        position:'top',
                        show:false
                    }
                });
            

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
                                xaxis: { from: 0, to: 50 },
                                color: '#4bb694'
                            },
                            {
                                xaxis: { from: 50.5, to: 63 }, 
                                color: '#ead3b4'
                            },
                            {
                                xaxis: { from: 63, to: 100 },
                                color: '#ffefdd', 
                                lineWidth: 0.5
                            },
                            { // Línea punteada en X = 50
                                xaxis: { from: 50, to: 50 },
                                color: '#000', // color de la línea
                                lineWidth: 0.9
                            },
                            { // Línea horizontal
                                yaxis: { from: 8.7, to: 8.7 },
                                color: 'white', // color rojo
                                lineWidth: 5
                            }
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
        <script src="../../assets/js/print.js?v=<?=VERSION_CODE?>"></script>
	</body>
</html>