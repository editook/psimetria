<?php
include_once('../configs.php');
	//AF-5
session_start();
require '../../vendor/autoload.php';

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");
include("../models/af/model_baremo_adultos_mujeres.php");
include("../models/af/model_baremo_adultos_varones.php");
include("../models/af/model_baremo_universitario_mujeres.php");
include("../models/af/model_baremo_universitario_varones.php");
include("../models/af/model_baremo_10_12_mujeres.php");
include("../models/af/model_baremo_10_12_varones.php");
include("../models/af/model_baremo_12_14_mujeres.php");
include("../models/af/model_baremo_12_14_varones.php");
include("../models/af/model_baremo_14_16_mujeres.php");
include("../models/af/model_baremo_14_16_varones.php");
include("../models/af/model_baremo_16_18_mujeres.php");
include("../models/af/model_baremo_16_18_varones.php");
$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$idClient = 0;
$idpatient = 0;

$device = $registerModel->getDeviceType();
if ($device === 'mobile') {
    include("../include/no_permit.php");
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
    exit;
}
$baremos = $baremoModel->getAll($register['id_type_question']);
//echo json_encode($baremos);
$baremo = null;

if($register['baremo_id'] == 5){
    $baremo = new ModelBaremo1012Mujeres();
}
if($register['baremo_id'] == 6){
    $baremo = new ModelBaremo1012Varones();
}
if($register['baremo_id'] == 7){
    $baremo = new ModelBaremo1214Mujeres();
}
if($register['baremo_id'] == 8){
    $baremo = new ModelBaremo1214Varones();
}
if($register['baremo_id'] == 9){
    $baremo = new ModelBaremo1416Mujeres();
}
if($register['baremo_id'] == 10){
    $baremo = new ModelBaremo1416Varones();
}
if($register['baremo_id'] == 11){
    $baremo = new ModelBaremo1618Mujeres();
}
if($register['baremo_id'] == 12){
    $baremo = new ModelBaremo1618Varones();
}
if($register['baremo_id'] == 13){
    $baremo = new ModelBaremoUniversitarioMujeres();
}
if($register['baremo_id'] == 14){
    $baremo = new ModelBaremoUniversitarioVarones();
}
if($register['baremo_id'] == 15){
    $baremo = new ModelBaremoAdultosMujeres();
}
if($register['baremo_id'] == 16){
    $baremo = new ModelBaremoAdultosVarones();
}


$answers = $answerModel->getAll($register['codes']);
$answers_text = $answerModel->getAnswersTop($register['codes']);
$answers_text = $answers_text['response'];
//dimensiones
//Acad./Laboral
//$questions =  $questionModel->getAll($register['id_type_question']);
$divisor = 60;
$array_aca_lab = [1,6,11,16,21,26];
$response_aca_lab = $answerModel->sumatoria($answers,$array_aca_lab);
$response_aca_lab_dp = round($response_aca_lab/$divisor,2);

$array_social = [2,7,17,27];
$response_social = $answerModel->sumatoria($answers,$array_social) + (100 - $answerModel->getValueModel($answers,22)) + (100 - $answerModel->getValueModel($answers,12));
$response_social_dp = round($response_social/$divisor,2);

$array_emocional = [3,8,13,18,23,28];
$response_emocional = 600 - $answerModel->sumatoria($answers,$array_emocional);
$response_emocional_dp = round($response_emocional/$divisor,2);

$array_familiar = [9,19,24,29];
$response_familiar = (100 - $answerModel->getValueModel($answers,4)) + $answerModel->sumatoria($answers,$array_familiar) + (100 - $answerModel->getValueModel($answers,14));
$response_familiar_dp = round($response_familiar/$divisor,2);

$array_fisico = [5,10,15,20,25,30];
$response_fisico = $answerModel->sumatoria($answers,$array_fisico);
$response_fisico_dp = round($response_fisico / $divisor,2);
 
//echo $response_aca_lab.' '.$response_social.' '.$response_emocional.' '.$response_familiar.' '.$response_fisico.'<br>';
//echo $response_aca_lab_dp.' '.$response_social_dp.' '.$response_emocional_dp.' '.$response_familiar_dp.' '.$response_fisico_dp;

//Académico/Laboral

$aca_pd = number_format((float)$response_aca_lab_dp, 2);
//echo $aca_pd.'<br>';
//echo $response_aca_lab_dp;
$aca_pc = $baremo->getAcad();

$soc_pd = number_format((float)$response_social_dp, 2);
$soc_pc = $baremo->getSoc();

$emo_pd = number_format((float)$response_emocional_dp, 2);
$emo_pc = $baremo->getEmo();

$fam_pd = number_format((float)$response_familiar_dp, 2);
$fam_pc = $baremo->getFami();

$fis_pd = number_format((float)$response_fisico_dp, 2);
$fis_pc = $baremo->getFis();
$text_aca = "";
$value_aca = $aca_pc["$aca_pd"];

if ($value_aca <= 3) {
    $text_aca = "Este rango indica que experimenta una percepción muy negativa de su desempeño en roles académicos y laborales. Se siente inadecuado, incompetente o incapaz de satisfacer las expectativas relacionadas con estas áreas. Esta percepción se asocia con sentimientos de insatisfacción, bajo ajuste psicosocial y dificultad para relacionarse con figuras de autoridad o compañeros en estos contextos. Además, podría reflejarse en absentismo, falta de motivación y conflictos interpersonales.";
} elseif ($value_aca <= 16) {
    $text_aca = "Este rango indica una percepción negativa del propio desempeño. Aunque no es tan extremo, siente que no cumple del todo con las expectativas de sus roles. Es probable que experimente cierta inseguridad al recibir retroalimentación de superiores o compañeros, lo que limita su desarrollo en estos contextos.";
} elseif ($value_aca <= 84) {
    $text_aca = "En este rango se refleja una percepción equilibrada y aceptable de su desempeño. Se siente satisfecho con su capacidad para cumplir con las responsabilidades mínimas esperadas, sin destacarse notablemente. Este nivel se asocia con un ajuste psicosocial adecuado, donde cumple con las expectativas básicas y mantiene relaciones funcionales con sus compañeros y superiores.";
} elseif ($value_aca <= 97) {
    $text_aca = "Este rango refleja una percepción elevada del propio desempeño académico y laboral. Se siente competente y eficiente. Se refuerza por la retroalimentación positiva recibida de figuras de autoridad y compañeros. Este nivel de autoconcepto se relaciona con cualidades como responsabilidad, liderazgo y capacidad para adaptarse a diferentes contextos, lo que favorece el reconocimiento y la valoración de su desempeño.";
} else { // Para valores >= 98
    $text_aca = "En este rango, se percibe seguro de sus habilidades en roles académicos y laborales. Es probable que reciba elogios y reconocimientos frecuentes, lo que fortalece sus capacidades y motiva su desempeño. Este nivel de percepción está vinculado con un ajuste psicosocial sobresaliente y con una influencia positiva en su entorno, al ser percibido como un modelo a seguir por sus pares y superiores.";
}
$text_aca = "El nivel de autoconcepto en el campo ACADÉMICO/LABORAL, ".$register['id_client']." obtuvo un percentil de ".$value_aca.", ".$text_aca;

$value_soc = $soc_pc["$soc_pd"];
$text_soc = "";
if ($value_soc <= 3) {
    $text_soc =  "Este rango indica una percepción muy negativa del desempeño en las relaciones sociales. Experimenta dificultades significativas para formar y mantener una red social, sintiéndose aislado o rechazado por los demás. Presenta una autoevaluación negativa de sus cualidades interpersonales (como ser amigable o alegre), lo que influye en la aparición de comportamientos relacionados con la inseguridad social, la sintomatología depresiva o el retraimiento. La conexión con el entorno social es mínima, lo que afecta tanto el bienestar psicosocial como las dinámicas de ajuste social.";
} elseif ($value_soc <= 16) {
    $text_soc =  "Este rango indica una percepción negativa de sus propias habilidades sociales. Experimenta inseguridad para interactuar con otros, sentir que carece de carisma o ser percibido como distante. Aunque puede mantener algunas relaciones, sin embargo, encuentra dificultades para ampliarlas o fortalecerlas, lo que genera sentimientos de exclusión o insuficiencia en contextos grupales. Este nivel podría vincularse con comportamientos disruptivos ocasionales o con una tendencia al retraimiento social.";
} elseif ($value_soc <= 84) {
    $text_soc =  "Este rango refleja una percepción equilibrada y funcional del propio desempeño social. Se siente cómodo en la interacción social básica, con capacidad para mantener relaciones estables y una red social funcional, aunque sin destacar particularmente por su facilidad para ampliar esta red o por cualidades especialmente valoradas en las relaciones (amigable, alegre). Se relaciona con un ajuste psicosocial adecuado, donde se evitan conductas disruptivas, y con la capacidad para mantener relaciones interpersonales satisfactorias dentro de los estándares aceptados.";
} elseif ($value_soc <= 97) {
    $text_soc =  "En este rango, se percibe como socialmente competente, amigable y agradable. Es probable que tenga una red social amplia, con habilidades que le permiten fortalecer sus relaciones y generar vínculos significativos. Este nivel está asociado con una alta aceptación y estima por parte de sus pares, así como con un ajuste psicosocial satisfactorio. Las cualidades como la conducta prosocial pueden ser evidentes.";
} else { // Para valores >= 98
    $text_soc =  "Este rango indica una percepción muy positiva y segura de sus propias habilidades sociales. Se considera sociable, alegre y capaz de generar conexiones satisfactorias con facilidad. Su red social es extensa y diversa. Este nivel está relacionado con un ajuste psicosocial excepcional, una marcada capacidad para influir en los demás de manera positiva y una alta valoración por parte de quienes lo rodean.";
}
$text_soc = "El nivel de autoconcepto en el campo SOCIAL, ".$register['id_client']." obtuvo un percentil de ".$value_soc.", ".$text_soc;

$value_emo = $emo_pc["$emo_pd"];
$text_emo = "";
if ($value_emo <= 3) {
    $text_emo = "Este rango refleja una percepción muy negativa sobre el control y manejo emocional. Experimenta nerviosismo, temor y reactividad emocional, especialmente en situaciones que implican interacción con figuras de autoridad o en contextos percibidos como demandantes. Esta percepción está asociada con la ansiedad, sintomatología depresiva y dificultades en la integración social, tanto en el aula como en el ámbito laboral.";
} elseif ($value_emo <= 16) {
    $text_emo = "En este rango, manifiesta cierta inseguridad respecto a su capacidad para gestionar emociones en contextos específicos. Aunque no tan marcado, experimenta niveles bajos de nerviosismo o temor en situaciones sociales y emocionales. Estas dificultades influyen en la percepción de aceptación por parte de los demás, especialmente en entornos con demandas elevadas, como la interacción con figuras de autoridad.";
} elseif ($value_emo <= 84) {
    $text_emo = "Este rango refleja una percepción equilibrada del control emocional. Siente que tiene un manejo adecuado de sus emociones en la mayoría de las situaciones, experimenta ocasionales momentos de inseguridad o nerviosismo en contextos específicos. Este nivel de autoconcepto emocional está asociado con un ajuste emocional funcional, una integración social satisfactoria y un bienestar psicosocial.";
} elseif ($value_emo <= 97) {
    $text_emo = "Este rango indica una percepción positiva de control y manejo emocional. Se siente seguro(a) y competente en su capacidad para responder adecuadamente a las demandas emocionales de la vida cotidiana. Muestra habilidades sociales efectivas, autocontrol emocional y una integración social destacada, incluso en situaciones percibidas como desafiantes, como la interacción con figuras de autoridad. Este nivel se relaciona con un mayor bienestar y una baja propensión a la ansiedad o la sintomatología depresiva.";
} else { // Para valores >= 98
    $text_emo = "Este rango refleja una percepción muy positiva sobre el control emocional y la capacidad de respuesta adaptativa. Se percibe como emocionalmente estable, seguro y capaz de manejar con éxito incluso las situaciones más demandantes. Es probable que tenga un alto nivel de aceptación social, un sólido bienestar emocional y un autocontrol. Este rango también sugiere una mínima probabilidad de experimentar estados emocionales negativos como ansiedad o depresión, y una alta capacidad para fomentar relaciones interpersonales saludables y positivas.";
}
$text_emo = "El nivel de autoconcepto de ".$register['id_client']." en el campo EMOCIONAL obtuvo un percentil de ".$value_emo." ".$text_emo;

$value_fam = $fam_pc["$fam_pd"];
$text_fam = "";
if ($value_fam <= 3) {
    $text_fam = "Este rango indica una percepción muy negativa respecto al entorno familiar. Siente que no es aceptado ni apoyado por los miembros de su familia, experimentando sentimientos de rechazo, crítica o decepción. Percibe una carencia de afecto y confianza en las relaciones familiares, lo cual podría impactar significativamente en su bienestar emocional, su ajuste psicosocial y su capacidad para integrarse en otros contextos sociales o laborales. Este nivel también podría estar asociado con una mayor vulnerabilidad a la sintomatología depresiva, la ansiedad o conductas de riesgo como el consumo de sustancias.";
} elseif ($value_fam <= 16) {
    $text_fam = "Este rango refleja una percepción negativa del entorno familiar. Aunque puede haber experiencias positivas ocasionales, siente que no recibe un apoyo constante o suficiente por parte de su familia. Percibe crítica o indiferencia, lo cual genera sentimientos de insatisfacción y una menor implicación en el entorno familiar.";
} elseif ($value_fam <= 84) {
    $text_fam = "En este rango, tiene una percepción equilibrada de su entorno familiar. Siente un nivel aceptable de confianza, afecto y apoyo, aunque no necesariamente destaca en términos de felicidad o implicación plena dentro del núcleo familiar. Este nivel indica que cuenta con una base emocional y social suficiente para su ajuste psicosocial y su desempeño en otros contextos.";
} elseif ($value_fam <= 97) {
    $text_fam = "Este rango refleja una percepción positiva del entorno familiar. Siente que su familia le apoya, le acepta y le brinda un ambiente de confianza y afecto. Es probable que se sienta integrado en el núcleo familiar, lo cual contribuye a un buen ajuste psicosocial y un bienestar emocional y un desempeño positivo en otros contextos, como el escolar o laboral. Este nivel de percepción está asociado con un sentimiento general de felicidad y pertenencia dentro de la familia.";
} else { // Para valores >= 98
    $text_fam = "Este rango indica una percepción muy positiva del entorno familiar. Se siente plenamente apoyado, aceptado y querido por su familia, lo que genera un profundo sentimiento de felicidad y pertenencia. Es probable que valore altamente las relaciones familiares y que su núcleo familiar actúe como una fuente sólida de bienestar emocional y apoyo. Este nivel de autoconcepto familiar está relacionado con una buena integración social y ajuste psicosocial y un bajo riesgo de sintomatología depresiva, ansiedad o conductas de riesgo.";
}
$text_fam = "El nivel de autoconcepto en el campo FAMILIAR, ".$register['id_client']." obtuvo un percentil de ".$value_fam.", ".$text_fam;

$value_fis = $fis_pc["$fis_pd"];
$text_fis = "";
if ($value_fis <= 3) {
    $text_fis = "Este rango refleja una percepción muy negativa sobre el aspecto físico y la condición física. Se siente insatisfecho con su apariencia, percibiéndose poco atractivo o inelegante, y experimenta una baja valoración de sus habilidades deportivas. Evita actividades sociales o deportivas debido a inseguridades, lo que puede limitar su integración social y contribuir a sentimientos de aislamiento o desajuste. Esta percepción puede estar asociada con un mayor riesgo de ansiedad, insatisfacción corporal y una percepción deficiente de bienestar físico y emocional.";
} elseif ($value_fis <= 16) {
    $text_fis = "En este rango, experimenta inseguridades respecto a su aspecto físico y habilidades deportivas. Aunque no tan marcado, siente que su apariencia o condición física no es lo que desea, lo que puede afectar su motivación para participar en actividades sociales o deportivas. Estas inseguridades afectan de forma tenue su bienestar emocional y su ajuste social.";
} elseif ($value_fis <= 84) {
    $text_fis = "Este rango sugiere una percepción equilibrada del aspecto físico y la condición física. Se siente razonablemente satisfecho con su apariencia y habilidades deportivas, aunque sin destacar particularmente en estos aspectos. Mantiene un nivel funcional de integración social y escolar, participando en actividades físicas y sociales de manera adecuada, sin experimentar inseguridades significativas relacionadas con su físico.";
} elseif ($value_fis <= 97) {
    $text_fis = "Este rango refleja una percepción positiva sobre el aspecto físico y las habilidades deportivas. Se siente atractivo, cuida su apariencia y se percibe hábil en la práctica de deportes o actividades físicas. Esta percepción fortalece su bienestar emocional, su motivación personal y su ajuste social, y contribuye a una participación activa en actividades deportivas y sociales. Disfruta de una integración social y de una percepción de bienestar.";
} else { // Para valores >= 98
    $text_fis = "Este rango indica una percepción muy positiva de su aspecto físico y la condición física. Se siente atractivo y elegante, se percibe como exitoso en actividades deportivas y valorado socialmente por estas habilidades. Este nivel de autoconcepto físico está asociado con una integración social y un bienestar físico y emocional.";
}
$text_fis = "El nivel de autoconcepto en el campo FISICO, ".$register['id_client']." obtuvo un percentil de ".$value_fis.", ".$text_fis;
$title_ = "AUTOCONCEPTO";
$comment_1 = "El autoconcepto es la percepción que una persona tiene de sí misma, basada en sus experiencias y relaciones con los demás. El AF-5 evalúa cinco dimensiones clave del autoconcepto:";

$pro_tot_pd = number_format(($aca_pd+$soc_pd+$emo_pd+$fam_pd+$fis_pd)/5,2);
$pro_tot_pc = ($aca_pc["$aca_pd"]+$soc_pc["$soc_pd"]+$emo_pc["$emo_pd"]+$fam_pc["$fam_pd"]+$fis_pc["$fis_pd"])/5;
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
		<link href="../../assets/css/style.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
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
        <!---<link href="../../assets/css/style_profile.css?v=<?=VERSION_CODE?>" rel="stylesheet">-->
        <link href="../../assets/css/style_result2.css?v=<?=VERSION_CODE?>" rel="stylesheet">
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
					<div class="row row-sm container-short">
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                            <div id="contenidoID" style="position: absolute;width: 90%;top: 30px;z-index: -1;">
                                <div class="container-header">
                                    <div class="container-body">
                                        <div class="container-row-bg">
                                            <span class="label">Id:</span>
                                            <input class="field form-control" value="<?= $register['id_client'] ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="contenido1" class="container-header">
                                <div class="container-left">
                                    <div class="perfil-vertical">PERFIL</div>
                                    <div class="divider"></div>
                                    <img src="../../assets/img/test_image/logoaf5.jpeg?v=<?= VERSION_CODE ?>" class="img-logo">
                                </div>
                                <div  class="container-body">

                                    <div class="container-row">
                                        <span class="label">Id:</span>
                                        <input class="field form-control" value="<?= $register['id_client'] ?>" />
                                    </div>

                                    <div class="container-row">
                                        <span class="label">Edad:</span>
                                        <input class="field form-control max" value="<?= $register['age'] ?>" />

                                        <span class="label">Sexo:</span>
                                        <input class="field form-control max" value="<?= $register['sex'] ?>" />

                                        <span class="label">Fecha de aplicación:</span>
                                        <input class="field form-control max" value="<?= date('d/m/Y') ?>" />
                                    </div>

                                    <div class="container-row">
                                        <span class="label">Baremo:</span>

                                        <form action="result2.php" method="post" id="form_baremo" style="margin:0;width: 100%;">
                                            <input type="hidden" name="id_user" id="id_user" value="<?= $idClient ?>">
                                            <input type="hidden" name="id_register" id="id_register" value="<?= $register['id'] ?>">
                                            <select class="field form-control max-left" id="baremo_id" name="baremo_id">
                                                <?php
                                                foreach ($baremos as $baremo) {
                                                ?>
                                                    <option value="<?= $baremo['id'] ?>" <?= $baremo['active'] == '0' ? 'disabled' : '' ?> <?= $register['baremo_id'] == $baremo['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($baremo['name']) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </form>
                                    </div>

                                    <div class="container-row row-m0">
                                        <span class="label">Responsable de la aplicación:</span>
                                        <input class="field form-control max-left" value="<?= $register['evaluador'] ?>">
                                    </div>

                                </div>
                            </div>
							
						</div>
                        <div id="contenido2" class="col-md-12 col-xl-12 col-xs-12 col-sm-12" style="padding: 50px 40px;">
                            <div  class="row">
                                <div class="col-md-6" style="padding: 0;">
                                    <div class="container-panel">
                                        <table class="score-table">
                                            <thead>
                                                <tr>
                                                    <th class="title" colspan="2">Puntuación general</th>
                                                    <th class="th-small">PD</th>
                                                    <th class="th-small" style="padding-right: 17px;">Pc</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="label-text">Autoconcepto total</td>
                                                    <td class="code">TOT</td>
                                                    <td class="p-left"><span class="box"><?=$pro_tot_pd?></span></td>
                                                    <td><span class="box"><?=$pro_tot_pc?></span></td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding:0px;">
                                    <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                        <div style="position: absolute;z-index: -1;left: -10px;margin-top: -10px;height:90px  !important;width: 106%;" id="colorss2"></div>
                                        <div style="margin-top: -3px;height: 60px !important;" id="flotLine1"></div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0;">
                                    <div class="container-panel">
                                        <table class="score-table">
                                            <thead>
                                                <tr>
                                                    <th class="title" colspan="2">Puntuaciones específicas</th>
                                                    <th class="th-small">PD</th>
                                                    <th class="th-small" style="padding-right: 17px;">Pc</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td class="label-text">Autoconcepto académico/laboral</td>
                                                    <td class="code">ACA</td>
                                                    <td class="p-left"><span class="box"><?=number_format($aca_pd,2)?></span></td>
                                                    <td><span class="box"><?=$aca_pc["$aca_pd"]?></span></td>
                                                </tr>

                                                <tr>
                                                    <td class="label-text">Autoconcepto social</td>
                                                    <td class="code">SOC</td>
                                                    <td class="p-left"><span class="box"><?=number_format($soc_pd,2)?></span></td>
                                                    <td><span class="box"><?=$soc_pc["$soc_pd"]?></span></td>
                                                </tr>

                                                <tr>
                                                    <td class="label-text">Autoconcepto emocional</td>
                                                    <td class="code">EMO</td>
                                                    <td class="p-left"><span class="box"><?=number_format($emo_pd,2)?></span></td>
                                                    <td><span class="box"><?=$emo_pc["$emo_pd"]?></span></td>
                                                </tr>

                                                <tr>
                                                    <td class="label-text">Autoconcepto familiar</td>
                                                    <td class="code">FAM</td>
                                                    <td class="p-left"><span class="box"><?=number_format($fam_pd,2)?></span></td>
                                                    <td><span class="box"><?=$fam_pc["$fam_pd"]?></span></td>
                                                </tr>

                                                <tr>
                                                    <td class="label-text">Autoconcepto físico</td>
                                                    <td class="code">FIS</td>
                                                    <td class="p-left"><span class="box"><?=number_format($fis_pd,2)?></span></td>
                                                    <td><span class="box"><?=$fis_pc["$fis_pd"]?></span></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding:0px;">
                                    <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                        <div class="ht-100 ht-sm-300" style="z-index: -1;left: -10px;margin-top: -10px;height:275px  !important;width: 106%;" id="colorss"></div>
                                        <div  style="margin-top: -3px;height: 249px !important;" id="flotLine2"></div>
                                        <p style="color:#232323;text-align: left;font-size: 15px !important;margin-top: 16px;"><span style="font-weight: bold;">Nota Pc:</span> (Percentil), escala ordinal.</p>
                                    </div>
                                </div>
                            </div>
                            
                            

                        </div>
						
                        <div class="col-md-12">
                            <div id="contenido3" class="card card-body " style="padding-bottom: 100px;text-align: justify;">
                                <div class="main-content-label mg-b-5" hidden>
                                    <h1 style="text-align: center;" id="jsonvalue1"><?=$title_?></h1>
                                </div>
                                <div class="card-body">
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue2"><?=$comment_1?></p>
                                    <br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue3"><span class="title  fw-semibold tx-13" id="jsonvalue4">Académico/Laboral:</span> Cómo se percibe la persona en relación con su desempeño académico o laboral.</p>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue5"><span class="title fw-semibold tx-13" id="jsonvalue6">Social:</span>  Cómo se percibe la persona en sus relaciones sociales y su capacidad para integrarse en grupos.</p>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue7"><span class="title fw-semibold tx-13" id="jsonvalue8">Emocional:</span> Cómo se percibe la persona en cuanto a su estado emocional y capacidad para manejar sus emociones.</p>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue9"><span class="title fw-semibold tx-13" id="jsonvalue10">Familiar:</span> Cómo se percibe la persona en relación con su familia y su sentido de pertenencia e integración en ella.</p>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue11"><span class="title fw-semibold tx-13" id="jsonvalue12">Físico:</span> Cómo se percibe la persona en cuanto a su aspecto físico y condición física.</p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13">La evaluación del autoconcepto es de gran interés porque la opinión que cada persona tiene de sí misma condiciona en gran manera sus expectativas y, consecuentemente, sus logros y resultados y su grado de adaptación social. </p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue14"><?=$text_aca?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue15"><span class="title fw-semibold tx-13" id="jsonvalue16">Nota:</span> En niños y adolescentes, el autoconcepto académico también correlaciona positivamente con los estilos parentales de inducción, afecto y apoyo; y, negativamente, con los de coerción, indiferencia y negligencia (Musitu y Allatt, 1994; Estarelles, 1987; Musitu, Román y Gutiérrez, 1996; Lamb, Ketterlinus y Fracasso, 1992).</p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue17"><?=$text_soc?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue18"><span class="title fw-semibold tx-13" id="jsonvalue19">Nota:</span> En niños y adolescentes, esta dimensión está relacionada muy positivamente con las prácticas de socialización parental de afecto, comprensión y apoyo; y negativamente, con la coerción, la negligencia y la indiferencia (Musitu y Allatt, 1994; Musitu, Román yGutiérrez, 1996).</p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue20"><?=$text_emo?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue21"><span class="title fw-semibold tx-13" id="jsonvalue22">Nota:</span> En niños y adolescentes, esta dimensión correlaciona positivamente con las prácticas parentales de afecto, comprensión, inducción y apoyo, mientras que lo hace negativamente con la coerción verbal y física, la indiferencia, la negligencia y los malos tratos (Broderick,1993; Pinazo, 1993; Gracia, 1991; Lila, 1995; Herrero, 1992, 1994; Cava, 1995, 1998; Llinares,1998; Musitu, Román y Gutiérrez, 1996; Gracia y Musitu, 1993).</p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue23"><?=$text_fam?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue24"><span class="title fw-semibold tx-13" id="jsonvalue25">Nota:</span>  En niños y adolescentes, el autoconcepto familiar se relaciona positivamente con los estilos parentales de afecto, comprensión y apoyo; y negativamente con la coerción, la violencia, la indiferencia y la negligencia (Gracia, Herrero y Musitu, 1995; Gracia, 1991;Agudelo, 1997; Arango, 1996).</p>
                                    <br><br>
                                    <p class="tx-dark mb-0 txt-force-black" id="jsonvalue26"><?=$text_fis?></p>
                                    <br><br>
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
            //jsonpdf.push({type:1,imageurl:pathBase+'/assets/img/brand/image.png'} );
            jsonpdf.push({type:2,image:"contenido1"} );
            jsonpdf.push({type:2,image:"contenido2"} );
            jsonpdf.push({type: 3});
            //jsonpdf.push({type:4,text:getvalue('jsonvalue1')} );
            //jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue2')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue3'),subtitle:getvalue('jsonvalue4')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue5'),subtitle:getvalue('jsonvalue6')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue7'),subtitle:getvalue('jsonvalue8')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue9'),subtitle:getvalue('jsonvalue10')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue11'),subtitle:getvalue('jsonvalue12')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue13')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue14')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue15'),subtitle:getvalue('jsonvalue16')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue17')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue18'),subtitle:getvalue('jsonvalue19')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue20')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue21'),subtitle:getvalue('jsonvalue22')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue23')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:6,text:getvalue('jsonvalue24'),subtitle:getvalue('jsonvalue25')} );
            jsonpdf.push({type:5,text:''} );
            jsonpdf.push({type:5,text:getvalue('jsonvalue26')} );
            
            $(function() {
            'use strict';
                var colorLine = "black";
                var newCust = [
                    [<?=$aca_pc["$aca_pd"]?>, 40],
                    [<?=$soc_pc["$soc_pd"]?>,30],
                    [<?=$emo_pc["$emo_pd"]?>,20],
                    [<?=$fam_pc["$fam_pd"]?>,10],
                    [<?=$fis_pc["$fis_pd"]?>,0]
                ];
                var newCust1 = [
                    [<?=$pro_tot_pc?>, 10],
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
                        borderWidth: 0,
                        hoverable: true,
                        borderColor: 'white',
                        borderRadius: 40,
                        innerMargin: -40,
                        show:true,
                         markings: [
                            
                         ]
                    },
                    yaxis: {
                        min: -5,
                        max: 45,
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
                            [3, '3'],
                            [16, '16'],
                            [30, '30'],
                            [50, '50'],
                            [70, '70'],
                            [84, '84'],
                            [94, '94'],
                            [99, '99'],
                        ],
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top'
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
                        radius: 3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth: 2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show: false
                    },
                    grid: {
                        borderWidth: 20,
                        hoverable: true,
                        borderColor: 'white',
                        borderRadius: 40,
                        innerMargin: -10,
                        show:true,
                        markings: [
                           {
                                xaxis: { from: 0, to: 10.00 },
                                color: '#fdc780'
                            },
                            {
                                xaxis: { from: 10.20, to: 29.80 },
                                color: '#eed68a'
                            },
                            {
                                xaxis: { from: 30.00, to: 40.00 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 40.20, to: 47.00 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 47.00, to: 58.80 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 59.00, to: 69.00 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 69.20, to: 88.80 },
                                color: '#8faa3c'
                            },
                            {
                                xaxis: { from: 89.00, to: 99 },
                                color: '#627430'
                            },
                            { // Línea punteada en X = 50
                                xaxis: { from: 49.5, to: 49.5 },
                                color: '#000', // color de la línea
                                lineWidth: 0.5
                            },
                        ]
                    },
                    yaxis: {
                        min: 0,
                        max: 99,
                        color: '#eee',
                        ticks: [
                            [0, ''],
                            [99, '']
                        ],
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: 'transparent'
                        },
                        show: false
                    },
                    xaxis: {
                        color: '#eee',
                        min: 0,
                        show: false,
                        max: 99,
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: '#999'
                        }
                    }
                });
                var colores = $.plot($('#colorss2'), [{
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
                        radius: 3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth: 2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show: false
                    },
                    grid: {
                        borderWidth: 20,
                        hoverable: true,
                        borderColor: 'white',
                        borderRadius: 40,
                        innerMargin: -10,
                        show:true,
                        markings: [
                           {
                                xaxis: { from: 0, to: 10.00 },
                                color: '#fdc780'
                            },
                            {
                                xaxis: { from: 10.20, to: 29.80 },
                                color: '#eed68a'
                            },
                            {
                                xaxis: { from: 30.00, to: 40.00 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 40.20, to: 47.00 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 47.00, to: 58.80 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 59.00, to: 69.00 },
                                color: '#e4e98c'
                            },
                            {
                                xaxis: { from: 69.20, to: 88.80 },
                                color: '#8faa3c'
                            },
                            {
                                xaxis: { from: 89.00, to: 99 },
                                color: '#627430'
                            },
                            { // Línea punteada en X = 50
                                xaxis: { from: 49.5, to: 49.5 },
                                color: '#000', // color de la línea
                                lineWidth: 0.5
                            },
                        ]
                    },
                    yaxis: {
                        min: 0,
                        max: 99,
                        color: '#eee',
                        ticks: [
                            [0, ''],
                            [99, '']
                        ],
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: 'transparent'
                        },
                        show: false
                    },
                    xaxis: {
                        color: '#eee',
                        min: 0,
                        show: false,
                        max: 99,
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: '#999'
                        }
                    }
                });
                var plot = $.plot($('#flotLine1'), [{
                    data: newCust1,
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
                        borderWidth: 0,
                        hoverable: true,
                        borderColor: 'white',
                        borderRadius: 40,
                        innerMargin: -40,
                        show:true,
                         markings: [
                            
                         ]
                    },
                    yaxis: {
                        min: -5,
                        max: 45,
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
                            [3, '3'],
                            [16, '16'],
                            [30, '30'],
                            [50, '50'],
                            [70, '70'],
                            [84, '84'],
                            [94, '94'],
                            [99, '99'],
                        ],
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top'
                    }
                });
                
            setTimeout(function() {
                document.getElementById('colorss').style.position = 'absolute';
            }, 1000);
            
            function labelFormatter(label, series) {
                return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
            }

            
        });

        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });

        </script>
        <script src="../../assets/js/print.js?v=<?=VERSION_CODE?>"></script>
	</body>
</html>