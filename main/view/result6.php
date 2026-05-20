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
include("../models/ippr/model_baremo_34.php");
include("../models/ippr/model_baremo56.php");
include("../models/ippr/model_configuration.php");



$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();

$baremoConfiguration = new ModelIpprConfiguration();
$idClient = 0;
$idpatient = 0;

$device = $registerModel->getDeviceType();
if ($device === 'mobile') {
    echo "No disponible para telefonos moviles o dispositivos pequeños";
    exit;
}

if (!isset($_SESSION['REST_type_user'])) {
    header("Location: " . LOCALHOST . "/signin.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['baremo_id'])) {
        $baremo_id = intval($_POST['baremo_id']);
        $id_register = intval($_POST['id_register']);
        $id_user = intval($_POST['id_user']);
        $register = $registerModel->getById($id_user, $id_register);
        $response = $registerModel->updateClient($register['id'], $register['id_client'], $register['age'], $register['sex'], $register['id_type_question'], $baremo_id);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

if ($_SESSION['REST_type_user'] == 'Administrador' &&  isset($_GET['client']) &&  isset($_GET['patient'])) {

    $idClient = $_GET['client'];
    $idpatient = $_GET['patient'];
}

if ($_SESSION['REST_type_user'] == 'CLIENTE' &&  isset($_GET['patient'])) {
    $idClient = $_SESSION['REST_id_user'];
    $idpatient = $_GET['patient'];
}

$register = $registerModel->getById($idClient, $idpatient);
if ($register == null) {
    echo "<script>
			alert('FALLO DE ACCESO CODIGO #876 - " . $idpatient . " redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
    exit;
}
$baremos = $baremoModel->getAll($register['id_type_question']);
//echo json_encode($register);
$baremo = new ModelBaremo56();
if ($register['baremo_id'] == 57) {
    $baremo = new ModelBaremo34();
}

$answers = $answerModel->getAll($register['codes']);


$cientifico_ac = $baremoConfiguration->sumatoria($answers,[45,59,65,71,81,123]);
$cientifico_pr = $baremoConfiguration->sumatoria($answers,[62,74,76,130,142,148]);
//echo $cientifico_ac .'<br>';
//echo $cientifico_pr .'<br><br>';
$tecnico_ac = $baremoConfiguration->sumatoria($answers,[7,35,77,87,105,107,]);
$tecnico_pr = $baremoConfiguration->sumatoria($answers,[2,56,110,120,128,152]);
$s = $baremoConfiguration->getByItemOrder($answers,152);
//echo $tecnico_ac .'<br>';
//echo $tecnico_pr .'<br><br>';

$sanidad_ac = $baremoConfiguration->sumatoria($answers,[5,37,73,135,143,167,]);
$sanidad_pr = $baremoConfiguration->sumatoria($answers,[18,104,112,132,158,178]);
//echo $sanidad_ac .'<br>';
//echo $sanidad_pr .'<br><br>';
$cientificosocial_ac = $baremoConfiguration->sumatoria($answers,[17,91,93,113,115,159,]);
$cientificosocial_pr = $baremoConfiguration->sumatoria($answers,[48,95,126,146,172,174]);
//echo $cientificosocial_ac .'<br>';
//echo $cientificosocial_pr .'<br><br>';
$juridicosocial_ac = $baremoConfiguration->sumatoria($answers,[23,29,89,119,137,145,]);
$juridicosocial_pr = $baremoConfiguration->sumatoria($answers,[6,32,99,102,108,170]);
//echo $juridicosocial_ac .'<br>';
//echo $juridicosocial_pr .'<br><br>';
$comunicacion_ac = $baremoConfiguration->sumatoria($answers,[13,51,75,103,133,157,]);
$comunicacion_pr = $baremoConfiguration->sumatoria($answers,[4,22,92,144,150,160,]);
//echo $comunicacion_ac .'<br>';
//echo $comunicacion_pr .'<br><br>';
$psicopedagogia_ac = $baremoConfiguration->sumatoria($answers,[43,57,67,100,109,177]);
$psicopedagogia_pr = $baremoConfiguration->sumatoria($answers,[66,88,134,140,162,164,]);
//echo $psicopedagogia_ac .'<br>';
//echo $psicopedagogia_pr .'<br><br>';
$empresarial_admin_ac = $baremoConfiguration->sumatoria($answers,[33,53,83,153,169,175]);
$empresarial_admin_pr = $baremoConfiguration->sumatoria($answers,[8,40,46,72,118,166,]);
//echo $empresarial_admin_ac .'<br>';
//echo $empresarial_admin_pr .'<br><br>';
$informatica_ac = $baremoConfiguration->sumatoria($answers,[3,25,55,63,141,149,]);
$informatica_pr = $baremoConfiguration->sumatoria($answers,[20,44,50,80,138,154,]);
//echo $informatica_ac .'<br>';
//echo $informatica_pr .'<br><br>';
$agrario_ac = $baremoConfiguration->sumatoria($answers,[31,47,79,96,101,125,]);
$agrario_pr = $baremoConfiguration->sumatoria($answers,[12,54,64,94,116,176,]);
//echo $agrario_ac .'<br>';
//echo $agrario_pr .'<br><br>';
$artistico_plastico_ac = $baremoConfiguration->sumatoria($answers,[9,85,117,131,165,179]);
$artistico_plastico_pr = $baremoConfiguration->sumatoria($answers,[14,60,78,90,106,124,]);
//echo $artistico_plastico_ac .'<br>';
//echo $artistico_plastico_pr .'<br><br>';
$artistico_musical_ac = $baremoConfiguration->sumatoria($answers,[15,21,61,82,155,163,]);
$artistico_musical_pr = $baremoConfiguration->sumatoria($answers,[26,42,52,82,122,168]);
//echo $artistico_musical_ac .'<br>';
//echo $artistico_musical_pr .'<br><br>';
$fuerzas_ac = $baremoConfiguration->sumatoria($answers,[1,11,19,27,49,173]);
$fuerzas_pr = $baremoConfiguration->sumatoria($answers,[16,69,70,86,114,180]);
//echo $fuerzas_ac .'<br>';
//echo $fuerzas_pr .'<br><br>';
$deportes_ac = $baremoConfiguration->sumatoria($answers,[41,68,121,129,147,151,]);
$deportes_pr = $baremoConfiguration->sumatoria($answers,[28,36,38,84,97,156,]);
//echo $deportes_ac .'<br>';
//echo $deportes_pr .'<br><br>';
$turismo_ac = $baremoConfiguration->sumatoria($answers,[39,111,127,139,161,171]);
$turismo_pr = $baremoConfiguration->sumatoria($answers,[10,24,30,34,58,136]);
//echo $turismo_ac .'<br>';
//echo $turismo_pr .'<br><br>';
$cientifico_ac_pc = $baremo->getCientifico("Ac",$cientifico_ac);
$cientifico_pr_pc = $baremo->getCientifico("Pr",$cientifico_pr);

$tecnico_ac_pc= $baremo->getTecnico("Ac",$tecnico_ac);
$tecnico_pr_pc = $baremo->getTecnico("Pr",$tecnico_pr);

$sanidad_ac_pc = $baremo->getSanidad("Ac",$sanidad_ac);
$sanidad_pr_pc = $baremo->getSanidad("Pr",$sanidad_pr);

$cientificosocial_ac_pc = $baremo->getCientificoSocial("Ac",$cientificosocial_ac);
$cientificosocial_pr_pc = $baremo->getCientificoSocial("Pr",$cientificosocial_pr);

$juridicosocial_ac_pc = $baremo->getJuridicoSocial("Ac",$juridicosocial_ac);
$juridicosocial_pr_pc = $baremo->getJuridicoSocial("Pr",$juridicosocial_pr);

$comunicacion_ac_pc = $baremo->getComunicacion("Ac",$comunicacion_ac);
$comunicacion_pr_pc = $baremo->getComunicacion("Pr",$comunicacion_pr);

$psicopedagogia_ac_pc = $baremo->getPsicopedagogia("Ac",$psicopedagogia_ac);
$psicopedagogia_pr_pc = $baremo->getPsicopedagogia("Pr",$psicopedagogia_pr);

$empresarial_admin_ac_pc = $baremo->getEmpresarialAdmin("Ac",$empresarial_admin_ac);
$empresarial_admin_pr_pc = $baremo->getEmpresarialAdmin("Pr",$empresarial_admin_pr);

$informatica_ac_pc = $baremo->getInformatica("Ac",$informatica_ac);
$informatica_pr_pc = $baremo->getInformatica("Pr",$informatica_pr);

$agrario_ac_pc = $baremo->getAgrario("Ac",$agrario_ac);
$agrario_pr_pc = $baremo->getAgrario("Pr",$agrario_pr);

$artistico_plastico_ac_pc = $baremo->getArtisticoPlastico("Ac",$artistico_plastico_ac);
$artistico_plastico_pr_pc = $baremo->getArtisticoPlastico("Pr",$artistico_plastico_pr);

$artistico_musical_ac_pc = $baremo->getArtisticoMusical("Ac",$artistico_musical_ac);
$artistico_musical_pr_pc = $baremo->getArtisticoMusical("Pr",$artistico_musical_pr);

$fuerzas_ac_pc = $baremo->getFuerzas("Ac",$fuerzas_ac);
$fuerzas_pr_pc = $baremo->getFuerzas("Pr",$fuerzas_pr);

$deportes_ac_pc = $baremo->getDeportes("Ac",$deportes_ac);
$deportes_pr_pc = $baremo->getDeportes("Pr",$deportes_pr);

$turismo_ac_pc = $baremo->getTurismo("Ac",$turismo_ac);
$turismo_pr_pc = $baremo->getTurismo("Pr",$turismo_pr);

$json3 = "Las frases que a continuación se presentan se basan en las puntuaciones directas (PD) y en los percentiles (Pc) del perfil gráfico, así como en la suposición de que ".$register['id_client']." ha contestado comprendiendo los enunciados y con máxima atención. Cabe recordar que los percentiles indican el porcentaje de la muestra normativa que se sitúa por debajo de la puntuación de la persona examinada, por lo que los resultados informan de su interés en comparación con el grupo normativo seleccionado.";

$responsejson = $baremoConfiguration->getResponseJson($answers);
$json5_1 = $responsejson["text"];
$json5_2 = $baremoConfiguration->getResponseJsonMessage($responsejson["total"]);
$json5 =  "Antes de proceder a la interpretación, se realizan algunas comprobaciones para determinar el cuidado o la atención que ".$register['id_client']." ha puesto al responder al inventario";
   

$json7 = "Si hubiera que resumir los resultados de la evaluación en un solo párrafo, el principal hallazgo es que ".$register['id_client']." ha mostrado un interés destacado por los siguientes campos profesionales:";
$result = $baremoConfiguration->GetValueOrder(
    $cientifico_pr_pc,
    $tecnico_pr_pc,
    $sanidad_pr_pc,
    $cientificosocial_pr_pc,
    $juridicosocial_pr_pc,
    $comunicacion_pr_pc,
    $psicopedagogia_pr_pc,
    $empresarial_admin_pr_pc,
    $informatica_pr_pc,
    $agrario_pr_pc,
    $artistico_plastico_pr_pc,
    $artistico_musical_pr_pc,
    $fuerzas_pr_pc,
    $deportes_pr_pc,
    $turismo_pr_pc,
    //
    $cientifico_ac_pc,
    $tecnico_ac_pc,
    $sanidad_ac_pc,
    $cientificosocial_ac_pc,
    $juridicosocial_ac_pc,
    $comunicacion_ac_pc,
    $psicopedagogia_ac_pc,
    $empresarial_admin_ac_pc,
    $informatica_ac_pc,
    $agrario_ac_pc,
    $artistico_plastico_ac_pc,
    $artistico_musical_ac_pc,
    $fuerzas_ac_pc,
    $deportes_ac_pc,
    $turismo_ac_pc,
);



$json8 = "1. ".ucwords(strtolower(array_key_first($result["resultados"][0]))).'<br>';
$json8 .= "2. ".ucwords(strtolower(array_key_first($result["resultados"][1]))).'<br>';
$json8 .= "3. ".ucwords(strtolower(array_key_first($result["resultados"][2]))).'<br>';
$json8 .= "4. ".ucwords(strtolower(array_key_first($result["resultados"][3]))).'<br>';
$json8 .= "5. ".ucwords(strtolower(array_key_first($result["resultados"][4]))).'<br>';
$json9 = "En los siguientes apartados se profundiza en este aspecto y se añaden otras informaciones que pueden resultar importantes para interpretar el perfil vocacional observado.";

$json11 = "El campo profesional por el que ha mostrado un mayor interés es ".ucwords(strtolower(array_key_first($result["resultados"][0])));
$json11 .= ". Este campo incluye las actividades relacionadas con ".$result["actividades"][array_key_first($result["resultados"][0])]["interes"];
$json11 .= " Algunas profesiones tipo son las de ".$result["resultados"][0][array_key_first($result["resultados"][0])]["profesion"];
$valor2 = $result["resultados"][1][array_key_first($result["resultados"][1])]["valor"];
$json12 = " Adicionalmente, también ha mostrado un interés ".$baremoConfiguration->clasificarNivel($valor2).", aunque menor, por otros campos profesionales. Estos campos son los siguientes:";

$json13 = $baremoConfiguration->evaluarInteresSecundario($valor2);
$json14 = "Campo ".ucwords(strtolower(array_key_first($result["resultados"][1])));
$json15 = "• Ejemplo de posibles profesiones: ".$result["resultados"][1][array_key_first($result["resultados"][1])]["profesion"];

$valor3 = $result["resultados"][2][array_key_first($result["resultados"][2])]["valor"];
$json16 = $baremoConfiguration->evaluarInteresSecundario($valor3);
$json17 = "Campo ".ucwords(strtolower(array_key_first($result["resultados"][2])));
$json18 = "• Ejemplo de posibles profesiones: ".$result["resultados"][2][array_key_first($result["resultados"][2])]["profesion"];

$valor4 = $result["resultados"][3][array_key_first($result["resultados"][3])]["valor"];
$json19 = $baremoConfiguration->evaluarInteresSecundario($valor3);
$json20 = "Campo ".ucwords(strtolower(array_key_first($result["resultados"][3])));
$json21 = "• Ejemplo de posibles profesiones: ".$result["resultados"][3][array_key_first($result["resultados"][3])]["profesion"];

$valor5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["valor"];
$json22 = $baremoConfiguration->evaluarInteresSecundario($valor5);
$json23 = "Campo ".ucwords(strtolower(array_key_first($result["resultados"][4])));
$json24 = "• Ejemplo de posibles profesiones: ".$result["resultados"][4][array_key_first($result["resultados"][4])]["profesion"];

$json28 = "Un perfil en el que aparecen puntuaciones muy diferentes en los apartados AC y PR puede indicar que ".$register['id_client'];
$json28 .= " no tiene información suficiente sobre lo que implican las profesiones a que corresponden esas puntuaciones. Cuando esto sucede, puede resultar de mucha utilidad considerar el contenido de los elementos y las respuestas a cada uno de ellos, para saber el  grado de conocimiento que tiene del tipo de actividades que implican las profesiones.";

$dis = $result["discrepancia"];
$json29 = "En este caso, no se han observado discrepancias entre las puntuaciones de Actividades y Profesiones en ninguno de los campos profesionales. Esto indica que ".$register['id_client']." tiene un conocimiento coherente de las actividades que implican las distintas profesiones.";
$json29 = "";
if($dis == 0){
    $json29 = "En este caso, se han observado diferencias marcadas entre los dos aspectos (AC y PR) en los siguientes campos profesionales:";
}
$valor_ac_1 = $result["resultados"][0][array_key_first($result["resultados"][0])]["ac"];
$valor_pr_1 = $result["resultados"][0][array_key_first($result["resultados"][0])]["pr"];

$valor_ac_5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["ac"];
$valor_pr_5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["pr"];
$json30 = "";
if($baremoConfiguration->getValueAbs($valor_ac_1,$valor_pr_1) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][0])));
    if($valor_pr_1>$valor_pr_5){
        $json30 .= "– campo de alta preferencia.";
    }
    $json30 .= "<br>";
}

$valor_ac_2 = $result["resultados"][1][array_key_first($result["resultados"][1])]["ac"];
$valor_pr_2 = $result["resultados"][1][array_key_first($result["resultados"][1])]["pr"];

$valor_ac_5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["ac"];
$valor_pr_5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_2,$valor_pr_2) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][1])));
    if($valor_pr_2>$valor_pr_5){
        $json30 .= "– campo de alta preferencia.";
    }
    $json30 .= "<br>";
}

$valor_ac_3 = $result["resultados"][2][array_key_first($result["resultados"][2])]["ac"];
$valor_pr_3 = $result["resultados"][2][array_key_first($result["resultados"][2])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_3,$valor_pr_3) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][2])));
    $json30 .= "<br>";
}

$valor_ac_4 = $result["resultados"][3][array_key_first($result["resultados"][3])]["ac"];
$valor_pr_4 = $result["resultados"][3][array_key_first($result["resultados"][3])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_4,$valor_pr_4) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][3])));
    $json30 .= "<br>";
}

$valor_ac_5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["ac"];
$valor_pr_5 = $result["resultados"][4][array_key_first($result["resultados"][4])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_5,$valor_pr_5) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][4])));
    $json30 .= "<br>";
}

$valor_ac_6 = $result["resultados"][5][array_key_first($result["resultados"][5])]["ac"];
$valor_pr_6 = $result["resultados"][5][array_key_first($result["resultados"][5])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_6,$valor_pr_6) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][5])));
    $json30 .= "<br>";
}

$valor_ac_7 = $result["resultados"][6][array_key_first($result["resultados"][6])]["ac"];
$valor_pr_7 = $result["resultados"][6][array_key_first($result["resultados"][6])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_7,$valor_pr_7) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][6])));
    $json30 .= "<br>";
}

$valor_ac_8 = $result["resultados"][7][array_key_first($result["resultados"][7])]["ac"];
$valor_pr_8 = $result["resultados"][7][array_key_first($result["resultados"][7])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_8,$valor_pr_8) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][7])));
    $json30 .= "<br>";
}

$valor_ac_9 = $result["resultados"][8][array_key_first($result["resultados"][8])]["ac"];
$valor_pr_9 = $result["resultados"][8][array_key_first($result["resultados"][8])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_9,$valor_pr_9) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][8])));
    $json30 .= "<br>";
}

$valor_ac_10 = $result["resultados"][9][array_key_first($result["resultados"][9])]["ac"];
$valor_pr_10 = $result["resultados"][9][array_key_first($result["resultados"][9])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_10,$valor_pr_10) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][9])));
    $json30 .= "<br>";
}

$valor_ac_11 = $result["resultados"][10][array_key_first($result["resultados"][10])]["ac"];
$valor_pr_11 = $result["resultados"][10][array_key_first($result["resultados"][10])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_11,$valor_pr_11) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][10])));
    $json30 .= "<br>";
}

$valor_ac_12 = $result["resultados"][11][array_key_first($result["resultados"][11])]["ac"];
$valor_pr_12 = $result["resultados"][11][array_key_first($result["resultados"][11])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_12,$valor_pr_12) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][11])));
    $json30 .= "<br>";
}

$valor_ac_13 = $result["resultados"][12][array_key_first($result["resultados"][12])]["ac"];
$valor_pr_13 = $result["resultados"][12][array_key_first($result["resultados"][12])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_13,$valor_pr_13) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][12])));
    $json30 .= "<br>";
}
$valor_ac_14 = $result["resultados"][13][array_key_first($result["resultados"][13])]["ac"];
$valor_pr_14 = $result["resultados"][13][array_key_first($result["resultados"][13])]["pr"];

if($baremoConfiguration->getValueAbs($valor_ac_14,$valor_pr_14) == 1){
    $json30 .= ". ".ucwords(strtolower(array_key_first($result["resultados"][13])));
    $json30 .= "<br>";
}
$json32 = "Muchas veces un sencillo examen de los resultados de la prueba es suficiente para que el orientador se haga cargo de la influencia de estos factores externos y pueda utilizarlos para indicar a ".$register['id_client']." algún campo profesional más vinculado a sus intereses y que resulte igualmente lucrativo o prestigioso.<br> En todo caso, cuando las puntuaciones presenten diferencias marcadas entre los dos aspectos de una escala, se deben revisar cuidadosamente las respuestas para averiguar si están anotadas en el lugar correcto.";

$json34 = "Una situación que aparece con bastante frecuencia en la orientación profesional es que alumnos con bajo nivel en algún aspecto aptitudinal específico expresen un alto interés por estudios o profesiones que requieren prioritariamente esa aptitud. En general, estos casos son considerados «poco realistas» y se cree que las personas de estas características tienen pocas probabilidades de completar los estudios que les lleven a esa profesión.";
$json35 = "El orientador debe considerar, en tales casos, que en las profesiones se presentan, generalmente, distintos niveles que requieren diversos grados de aptitudes y de formación y que, casi siempre, es posible encontrar en ellos uno apropiado para las características de ".$register['id_client'].".";
$json36 ="A pesar de ello, se debe tener en cuenta que la predicción del éxito en los estudios a partir de la evaluación de las aptitudes no tiene carácter de certeza absoluta, aunque es cierto que las personas con un nivel aptitudinal alto en los aspectos requeridos para los estudios de una carrera concreta tienen mayor probabilidad de tener éxito en dichos estudios que aquellos que en esos aspectos presentan un nivel bajo.";

$ac_15 = $result["resultados"][14][array_key_first($result["resultados"][14])]["ac"];
$pr_15 = $result["resultados"][14][array_key_first($result["resultados"][14])]["pr"];
$rechazos1 = $baremoConfiguration->getValueRechazo($ac_15,$pr_15);
$ac_14 = $result["resultados"][13][array_key_first($result["resultados"][13])]["ac"];
$pr_14 = $result["resultados"][13][array_key_first($result["resultados"][13])]["pr"];
$rechazos2 = $baremoConfiguration->getValueRechazo($ac_14,$pr_14);
$ac_13 = $result["resultados"][12][array_key_first($result["resultados"][12])]["ac"];
$pr_13 = $result["resultados"][12][array_key_first($result["resultados"][12])]["pr"];
$rechazos3 = $baremoConfiguration->getValueRechazo($ac_13,$pr_13);
$ac_12 = $result["resultados"][11][array_key_first($result["resultados"][11])]["ac"];
$pr_12 = $result["resultados"][11][array_key_first($result["resultados"][11])]["pr"];
$rechazos4 = $baremoConfiguration->getValueRechazo($ac_12,$pr_12);
$ac_11 = $result["resultados"][10][array_key_first($result["resultados"][10])]["ac"];
$pr_11 = $result["resultados"][10][array_key_first($result["resultados"][10])]["pr"];
$rechazos5 = $baremoConfiguration->getValueRechazo($ac_11,$pr_11);
$ac_10 = $result["resultados"][9][array_key_first($result["resultados"][9])]["ac"];
$pr_10 = $result["resultados"][9][array_key_first($result["resultados"][9])]["pr"];
$rechazos6 = $baremoConfiguration->getValueRechazo($ac_10,$pr_10);
$ac_9 = $result["resultados"][8][array_key_first($result["resultados"][8])]["ac"];
$pr_9 = $result["resultados"][8][array_key_first($result["resultados"][8])]["pr"];
$rechazos7 = $baremoConfiguration->getValueRechazo($ac_9,$pr_9);
$rechazos = "En el caso de la persona evaluada, no se ha detectado un rechazo significativo hacia ningún campo profesional específico. Todos los campos presentan niveles de interés dentro de un rango moderado.";
$totalrechazos = $rechazos1+$rechazos2+$rechazos3+$rechazos4+$rechazos5+$rechazos6+$rechazos7;
if($totalrechazos>0){
    $rechazos = "En el caso de la persona evaluada, se ha detectado un rechazo significativo hacia los siguientes campos profesionales: <br>";
    if($baremoConfiguration->getValueRechazo($ac_15,$pr_15)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][14])));
        $rechazos .= "<br>";
    }
    
    if($baremoConfiguration->getValueRechazo($ac_14,$pr_14)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][13])));
        $rechazos .= "<br>";
    }
    
    if($baremoConfiguration->getValueRechazo($ac_13,$pr_13)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][12])));
        $rechazos .= "<br>";
    }
    
    if($baremoConfiguration->getValueRechazo($ac_12,$pr_12)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][11])));
        $rechazos .= "<br>";
    }
    if($baremoConfiguration->getValueRechazo($ac_11,$pr_11)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][10])));
        $rechazos .= "<br>";
    }
    if($baremoConfiguration->getValueRechazo($ac_10,$pr_10)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][9])));
        $rechazos .= "<br>";
    }
    if($baremoConfiguration->getValueRechazo($ac_9,$pr_9)){
        $rechazos .= ucwords(strtolower(array_key_first($result["resultados"][8])));
        $rechazos .= "<br>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="EditoApps <?= WEB_TITLE ?>">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <!-- Title -->
    <title> <?= WEB_TITLE ?> </title>

    <!-- Favicon -->
    <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.css?v=<?= VERSION_CODE ?>" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Internal Morris Css-->
    <link href="../../assets/plugins/morris.js/morris.css" rel="stylesheet">

    <!--  Right-sidemenu css -->
    <link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!--  Custom Scroll bar-->
    <link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" />

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
    <link href="../../assets/css/style_result6.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
</head>

<body class="main-body">

    <!-- Loader -->
    <div id="global-loader">
        <img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page <?= TESTING == '1' ? 'istesting' : '' ?>">

        <!-- main-header opened -->
        <?php include("../include/header_top.php"); ?>
        <!-- /main-header -->
        <!--Horizontal-main -->
        <?php include("../include/header_bottom.php"); ?>
        <!--Horizontal-main -->
        <!-- main-content opened -->
        <div class="main-content horizontal-content">
            <br>
            <!-- container opened -->
            <div class="container">


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
                                <img src="../../assets/img/test_image/ippr.png?v=<?= VERSION_CODE ?>" class="img-logo">
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

                    <div id="contenido2" class="col-md-12 col-xl-12 col-xs-12 col-sm-12" style="padding: 90px 40px;">
                        <div  class="row">
                            <div class="col-md-6" style="padding: 0;">

                                <div class="container-panel">

                                    <div class="section-header">
                                        <div class="title-header">
                                            CAMPOS PROFESIONALES
                                        </div>

                                        <div class="header-right">
                                            <span class="header-pill">PD</span>
                                            <span class="header-pill">PC</span>
                                        </div>
                                    </div>

                                    <!-- ITEM -->
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            CIENTÍFICO
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $cientifico_ac ?></span>
                                                <span class="value-box"><?= $cientifico_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $cientifico_pr ?></span>
                                                <span class="value-box"><?= $cientifico_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- ITEM -->
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            TÉCNICO
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $tecnico_ac ?></span>
                                                <span class="value-box"><?= $tecnico_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $tecnico_pr ?></span>
                                                <span class="value-box"><?= $tecnico_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- ITEM -->
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            SANIDAD
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $sanidad_ac ?></span>
                                                <span class="value-box"><?= $sanidad_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $sanidad_pr ?></span>
                                                <span class="value-box"><?= $sanidad_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- ITEM -->
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            CIENTÍFICO SOCIAL / HUMANIDADES
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $cientificosocial_ac ?></span>
                                                <span class="value-box"><?= $cientificosocial_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $cientificosocial_pr ?></span>
                                                <span class="value-box"><?= $cientificosocial_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- ITEM -->
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            JURÍDICO SOCIAL
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $juridicosocial_ac ?></span>
                                                <span class="value-box"><?= $juridicosocial_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $juridicosocial_pr ?></span>
                                                <span class="value-box"><?= $juridicosocial_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            COMUNICACIÓN INFORMACIÓN					
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $comunicacion_ac ?></span>
                                                <span class="value-box"><?= $comunicacion_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $comunicacion_pr ?></span>
                                                <span class="value-box"><?= $comunicacion_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            PSICOPEDAGÓGICO
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $psicopedagogia_ac ?></span>
                                                <span class="value-box"><?= $psicopedagogia_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $psicopedagogia_pr ?></span>
                                                <span class="value-box"><?= $psicopedagogia_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            EMPRESARIAL/ADMINISTRATIVO/ COMERCIAL
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $empresarial_admin_ac ?></span>
                                                <span class="value-box"><?= $empresarial_admin_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $empresarial_admin_pr ?></span>
                                                <span class="value-box"><?= $empresarial_admin_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            INFORMÁTICA
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $informatica_ac ?></span>
                                                <span class="value-box"><?= $informatica_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $informatica_pr ?></span>
                                                <span class="value-box"><?= $informatica_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            AGRARIO/AGROPECUARIO/AMBIENTAL
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $agrario_ac ?></span>
                                                <span class="value-box"><?= $agrario_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $agrario_pr ?></span>
                                                <span class="value-box"><?= $agrario_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            ARTÍSTICO - PLÁSTICO/ ARTESANÍA /MODA
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $artistico_plastico_ac ?></span>
                                                <span class="value-box"><?= $artistico_plastico_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $artistico_plastico_pr ?></span>
                                                <span class="value-box"><?= $artistico_plastico_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            ARTÍSTICO MUSICAL/ ESPECTÁCULO
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $artistico_musical_ac ?></span>
                                                <span class="value-box"><?= $artistico_musical_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $artistico_musical_pr ?></span>
                                                <span class="value-box"><?= $artistico_musical_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            FUERZAS ARMADAS/SEGURIDAD/PROTECCIÓN
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $fuerzas_ac ?></span>
                                                <span class="value-box"><?= $fuerzas_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $fuerzas_pr ?></span>
                                                <span class="value-box"><?= $fuerzas_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession">
                                        <div class="profession-name">
                                            DEPORTIVO 
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $deportes_ac ?></span>
                                                <span class="value-box"><?= $deportes_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $deportes_pr ?></span>
                                                <span class="value-box"><?= $deportes_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row-profession no-border">
                                        <div class="profession-name">
                                            TURISMO Y HOTELERÍA
                                        </div>

                                        <div class="profession-values">

                                            <div class="value-row">
                                                <span class="mini-label">Ac</span>

                                                <span class="value-box"><?= $turismo_ac ?></span>
                                                <span class="value-box"><?= $turismo_ac_pc ?></span>
                                            </div>

                                            <div class="value-row">
                                                <span class="mini-label">Pr</span>

                                                <span class="value-box"><?= $turismo_pr ?></span>
                                                <span class="value-box"><?= $turismo_pr_pc ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <p style="color:#232323;text-align: left;font-size: 20px !important;"><span style="font-weight: bold;">Nota</span> Pc: (percentil), escala ordinal.</p>
                                </div>

                            </div>

                            <div class="col-md-6" style="padding:0px">
                                <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                    <div class="interes">Interés</div>
                                    <div class="scale-container">

                                        <div class="scale-item very-low">
                                            Muy bajo
                                        </div>

                                        <div class="scale-item low">
                                            Bajo
                                        </div>

                                        <div class="scale-item medium-low">
                                            Medio bajo
                                        </div>

                                        <div class="scale-item medium">
                                            Medio
                                        </div>

                                        <div class="scale-item medium-high">
                                            Medio alto
                                        </div>

                                        <div class="scale-item high">
                                            Alto
                                        </div>

                                        <div class="scale-item very-high">
                                            Muy Alto
                                        </div>

                                    </div>
                                    <div class="ht-100 ht-sm-300" style="margin-top: 8px;height:1367px !important;width: 100%;" id="colorss"></div>
                               
                                
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    

                    <div class="col-md-12">
                        <div id="contenido3" class="card card-body" style="padding-bottom: 100px;text-align: justify;">
                            <h4 class="tx-15" id="jsonvalue1">INTRODUCCIÓN</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue2">Este informe de carácter automático pretende servir de ayuda a la interpretación de los resultados obtenidos en el test IPP-R, Intereses y Preferencias Profesionales - Revisado. Se trata de un inventario diseñado para conocer e identificar los campos profesionales que se adaptan mejor a las preferencias y características de la persona evaluada, de forma que se pueda facilitar el proceso de exploración y la toma de decisiones sobre los estudios a realizar en el futuro y las posibles profesiones a desempeña</p>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue3"><?= $json3 ?></p><br>
                            <h4 class="tx-15" id="jsonvalue3_1">VALIDEZ DE LA APLICACIÓN</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue4"><?= $json5 ?></p><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue4_1"><?= $json5_1 ?></p><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue4_2"><?= $json5_2 ?></p><br>
                            <h4 class="tx-15" id="jsonvalue5">VISIÓN GENERAL</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue7"><?= $json7 ?><br><br>
                            </p>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue8"><?= $json8 ?><br>
                            </p>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue9"><?= $json9 ?><br><br>
                            </p>
                            
                            <br>
                            <h4 class="tx-15" id="jsonvalue9_1">PREFERENCIAS DESTACADAS</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue10">En este apartado se tratan los campos profesionales por los que la persona evaluada muestra un interés notable. Para ello, se consideran conjuntamente las actividades y profesiones de cada campo y se comparan las elecciones de la persona con las de una muestra representativa. Los resultados indican, por tanto, su posición en relación con dicha muestra.</p>
                            <br>
                            
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue11"><?= $json11 ?><br><br>
                            </p>
                            
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue12"><?= $json12 ?><br><br>
                            </p>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13"><?= $json13 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue14"><?= $json14 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue15"><?= $json15 ?><br><br>
                            </p>

                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue16"><?= $json16 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue17"><?= $json17 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue18"><?= $json18 ?><br><br>
                            </p>

                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue19"><?= $json19 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue20"><?= $json20 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue21"><?= $json21 ?><br><br>
                            </p>

                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue22"><?= $json22 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue23"><?= $json23 ?><br>
                            </p>
                              <p class="tx-dark mb-0 txt-force-black" id="jsonvalue24"><?= $json24 ?><br><br>
                            </p>
                            <p class="tx-dark txt-curvo mb-0 txt-force-black" id="jsonvalue25">Por último, conviene contrastar en el siguiente apartado las discrepancias que se han detectado entre las actividades y las profesiones propias de alguno de los campos profesionales apuntados anteriormente, lo que podría sugerir una intervención o dar lugar a un reajuste de las preferencias de la persona.</p>
                            <br>
                            <h4 class="tx-15" id="jsonvalue26">DISCREPANCIAS NOTABLES</h4>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue27">Discrepancias entre puntuaciones en Actividades (AC) y en Profesiones (PR)</p>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue28"> <?= $json28 ?></p><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue29"> <?= $json29 ?></p><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue30"> <?= ($json30) ?></p><br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue31">En algunos casos este tipo de perfil se debe a causas diferentes a los intereses del propio individuo; su elección puede estar motivada por circunstancias que no tienen relación directa con la vocación: la presión familiar, el prestigio, la remuneración, etc.</p>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue32"><?= ($json32) ?></p> <br>
                            <h4 class="tx-15" id="jsonvalue33">Discrepancia entre intereses y aptitudes</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue34"><?= ($json34) ?></p> <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue35"><?= ($json35) ?></p> <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue36"><?= ($json36) ?></p> <br> <br>
                            <h4 class="tx-15" id="jsonvalue37">RECHAZOS</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue38">Los rechazos pueden ser tan importantes o más que las elecciones. Al igual que conviene orientar a la persona hacia las profesiones sobre las que muestre un mayor interés, del mismo modo conviene evitar cualquier factor, familiar o externo, que le lleve a tomar una elección claramente alejada de su interés, puesto que existiría una elevada probabilidad de fracaso profesional.</p>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue39"><?= ($rechazos) ?></p> <br> <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue40">Este resultado supone que ha manifestado de un modo sistemático su desinterés por las actividades y profesiones propias de estos campos profesionales, aspectos que convendría tener en cuenta a la hora de decidir sobre su itinerario educativo o profesional.</p>
                            <br>
                            <h4 class="tx-15" id="jsonvalue41">ADVERTENCIAS Y PRECAUCIONES</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue42">Para una interpretación adecuada de los resultados analizados conviene tener presentes, entre otras, las siguientes advertencias y precauciones:</p> <br>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue43">- El IPP-R, como su nombre indica, pretende evaluar únicamente los intereses profesionales y no otros aspectos que puedan ser igualmente decisivos. En concreto, no se están evaluando las aptitudes ni otros factores de índole práctica que pueden condicionar la elección profesional, como serían las expectativas de encontrar empleo, de recibir una determinada remuneración económica, la normativa de acceso a los distintos estudios, etc.</p> <br>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue44">- El inventario informa sobre el interés por las profesiones y actividades de cada campo profesional en el momento presente, pero podrían obtenerse resultados diferentes con el paso del tiempo. Del mismo modo, no agota todo el abanico de profesiones y actividades existente. Lo importante es conocer los campos genéricos de preferencia, pues normalmente el interés se extenderá a otras profesiones o actividades de características similares, aunque no hayan sido citadas expresamente.</p> <br>
                        </div>


                    </div>

                </div>
                <!-- row closed -->
            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->

        <?php include("../include/footer.php"); ?>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <?php include("../include/print_content.php"); ?>

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
    <script src="../../assets/js/custom.js?v=<?= VERSION_CODE ?>"></script>

    <script src="../../assets/js/flot-circle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const name_user = "<?php echo $register['id_client'] ?>";
        const testname = "<?php echo $register['type_question_name'] ?>";
        const filenamepdf = (name_user + "_" + testname).replace(/\s+/g, '');
        var jsonpdf = [];
        jsonpdf.push({
            type: 2,
            image: "contenido1"
        });
        jsonpdf.push({
            type: 9,
            image: "contenido2",
            size: 100
        });
        
        
        jsonpdf.push({type:7,text:getvalue('jsonvalue1')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue2')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue3')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue3_1')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue4')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue4_1')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue4_2')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue5')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue7')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue8')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue9')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue9_1')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue10')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue11')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue12')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue13')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue14')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue15')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue16')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue17')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue18')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue19')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue20')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue21')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue22')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue23')} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue24')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue25')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue26')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue27')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue28')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue29')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue30')} );//fallando desde aqui
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} ); 
        jsonpdf.push({type:5,text:getvalue('jsonvalue31')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue32')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue33')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue34')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue35')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue36')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue37')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue38')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:8,text:getvalue('jsonvalue39')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue40')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:7,text:getvalue('jsonvalue41')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue42')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue43')} );
        jsonpdf.push({type:5,text:''} );
        jsonpdf.push({type:5,text:getvalue('jsonvalue44')} );

        $(function() {
            'use strict';
            var colorLine = "black";
            const data = [

                // 1
                [[<?= $cientifico_ac_pc ?>, 31.5], [<?= $cientifico_pr_pc ?>, 30.5]],

                // 2
                [[<?= $tecnico_ac_pc ?>, 29.3], [<?= $tecnico_pr_pc ?>, 28.3]],

                // 3
                [[<?= $sanidad_ac_pc ?>, 26.7], [<?= $sanidad_pr_pc ?>, 25.7]],

                // 4
                [[<?= $cientificosocial_ac_pc ?>, 24.5], [<?= $cientificosocial_pr_pc ?>, 23.5]],

                // 5
                [[<?= $juridicosocial_ac_pc ?>, 22], [<?= $juridicosocial_pr_pc ?>, 21]],

                // 6
                [[<?= $comunicacion_ac_pc ?>, 19.7], [<?= $comunicacion_pr_pc ?>, 18.7]],

                // 7
                [[<?= $psicopedagogia_ac_pc ?>, 17.4], [<?= $psicopedagogia_pr_pc ?>, 16.4]],

                // 8
                [[<?= $empresarial_admin_ac_pc ?>, 15.0], [<?= $empresarial_admin_pr_pc ?>, 14.0]],

                // 9
                [[<?= $informatica_ac_pc ?>, 12.6], [<?= $informatica_pr_pc ?>, 11.6]],

                // 10
                [[<?= $agrario_ac_pc ?>, 10.3], [<?= $agrario_pr_pc ?>, 9.3]],

                // 11
                [[<?= $artistico_plastico_ac_pc ?>, 8], [<?= $artistico_plastico_pr_pc ?>, 7]],

                // 12
                [[<?= $artistico_musical_ac_pc ?>, 5.6], [<?= $artistico_musical_pr_pc ?>, 4.6]],

                // 13
                [[<?= $fuerzas_ac_pc ?>, 3.1], [<?= $fuerzas_pr_pc ?>, 2.1]],

                // 14
                [[<?= $deportes_ac_pc ?>, 0.8], [<?= $deportes_pr_pc ?>, -0.2]],

                // 15
                [[<?= $turismo_ac_pc ?>, -1.5], [<?= $turismo_pr_pc ?>, -2.5]]
            ];
            const series = data.map(item => ({
                data: item,
                lines: {
                    show: true,
                    lineWidth: 2
                },
                points: {
                    show: true,
                    radius: 5,
                    fill: true,
                    fillColor: "#000",
                    lineWidth: 2
                },
                color: "#000"
            }));

               $.plot("#colorss", series, {

                grid: {
                    hoverable: false,
                    clickable: false,
                    borderWidth: 0,
                    borderColor: "white",
                    markings: [

                        /* =========================
                        COLUMNAS DE COLOR
                        ========================= */

                        {
                            xaxis: { from: 0, to: 6 },
                            color: "#e87443"
                        },

                        {
                            xaxis: { from: 6, to: 18 },
                            color: "#e7cb84"
                        },

                        {
                            xaxis: { from: 18, to: 31 },
                            color: "#e5e39c"
                        },

                        {
                            xaxis: { from: 31, to: 68 },
                            color: "#cfd883"
                        },

                        {
                            xaxis: { from: 68, to: 81 },
                            color: "#b4cd59"
                        },

                        {
                            xaxis: { from: 81, to: 92 },
                            color: "#88aa43"
                        },

                        {
                            xaxis: { from: 92, to: 99 },
                            color: "#5f7d39"
                        },

                        /* =========================
                        LINEA PUNTEADA
                        ========================= */

                        {
                            xaxis: {
                                from: 50,
                                to: 50
                            },
                            color: "#333",
                            lineWidth: 1
                        },

                        /* =========================
                        LINEAS HORIZONTALES
                        ========================= */
                        {
                            yaxis: {
                                from: 29.9,
                                to: 29.9
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from: 27.5,
                                to: 27.5
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },

                        {
                            yaxis: {
                                from: 25.1,
                                to: 25.1
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },

                        {
                            yaxis: {
                                from: 22.8,
                                to: 22.8
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },

                        {
                            yaxis: {
                                from: 20.4,
                                to: 20.4
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },

                        {
                            yaxis: {
                                from: 18,
                                to: 18
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },

                        {
                            yaxis: {
                                from: 15.7,
                                to: 15.7
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from: 13.3,
                                to: 13.3
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        }
                        ,
                        {
                            yaxis: {
                                from: 10.9,
                                to: 10.9
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from: 8.5,
                                to: 8.5
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from: 6.2,
                                to: 6.2
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from: 3.8,
                                to: 3.8
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from:1.4,
                                to: 1.4
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        },
                        {
                            yaxis: {
                                from: -0.9,
                                to: -0.9
                            },
                            color: "#ffffff",
                            lineWidth: 2
                        }

                    ]
                },

                xaxis: {
                    min: 0,
                    max: 99,
                    color: 'black',
                    tickColor: 'black',
                    tickLength: 0,
                    position:'top',
                    ticks: [
                            [1, '<b style="font-size: 18px;font-weight: 500;">1</b>'],
                            [6, '<b style="font-size: 18px;font-weight: 500;">3</b>'],
                            [16, '<b style="font-size: 18px;font-weight: 500;">16</b>'],
                            [30, '<b style="font-size: 18px;font-weight: 500;">30</b>'],
                            [50, '<b style="font-size: 18px;font-weight: 500;">50</b>'],
                            [68, '<b style="font-size: 18px;font-weight: 500;">70</b>'],
                            [81, '<b style="font-size: 18px;font-weight: 500;">84</b>'],
                            [93, '<b style="font-size: 18px;font-weight: 500;">97</b>'],
                            [99, '<b style="font-size: 18px;font-weight: 500;">99</b>'],
                        ],
                    font: {
                        size: 12,
                        color: 'black'
                    },
                },
                yaxis: {
                    min: -3,
                    max: 32.1,
                    show: false
                }
            });    

        });
        
        
        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });
    </script>
    <script src="../../assets/js/print.js?v=<?= VERSION_CODE ?>"></script>
</body>

</html>