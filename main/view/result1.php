<?php
include_once('../configs.php');

session_start();
require '../../vendor/autoload.php';

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");
include("../models/lsb50/model_baremo_clinica_psic_mujeres.php");
include("../models/lsb50/model_baremo_clinica_psic_varones.php");
include("../models/lsb50/model_baremo_pob_gral_mujeres.php");
include("../models/lsb50/model_baremo_pob_gral_varones.php");
include("../models/lsb50/model_lsb_configuration.php");


$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$baremoConfiguration = new ModelLsbConfiguration();
$idClient = 0;
$idpatient = 0;

$device = $registerModel->getDeviceType();
if ($device === 'mobile') {
    include("../include/no_permit.php");
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
if(!$register['is_show_result']){
    include("mantenimiento.php");
    exit;
}
$baremos = $baremoModel->getAll($register['id_type_question']);

$baremo = new ModelBaremoPobGralVarones(); //baremo=1
if ($register['baremo_id'] == 2) {
    $baremo = new ModelBaremoPobGralMujeres();
}
if ($register['baremo_id'] == 3) {
    $baremo = new ModelBaremoClinicaPsiVarones();
}
if ($register['baremo_id'] == 4) {
    $baremo = new ModelBaremoClinicaPsiMujeres();
}

$answers = $answerModel->getAll($register['codes']);
$answers_text = $answerModel->getAnswersTop($register['codes']);
$answers_text = $answers_text['response'];
#escala de validez
//$questions =  $questionModel->getAll($register['id_type_question']);
$array_min = [2, 4, 9, 11, 12, 13, 30, 49];
$array_mag = [5, 10, 17, 22, 26, 29, 42, 46];
$min = $answerModel->sumatoria(($answers), $array_min);
$mag = $answerModel->sumatoria(($answers), $array_mag);
$Pmin = round($min / count($array_min), 2);
$Pmag = round($mag / count($array_mag), 2);
$Pmin = number_format((float)$Pmin, 2);
$Pmag = number_format((float)$Pmag, 2);
//echo $min.' '.$Pmin.'|';
//echo $mag.' '.$Pmag.'|';

//escalas clinicas
$array_psicoreac = [6, 7, 8, 15, 16, 24, 26, 29, 30, 31, 33, 36, 38, 40];
$psicoreactividad = round($answerModel->sumatoria(($answers), $array_psicoreac), 2);

$Ppsicoreactividad = round($psicoreactividad / count($array_psicoreac), 2);
$Ppsicoreactividad = number_format((float)$Ppsicoreactividad, 2);
//echo $psicoreactividad.' '.$Ppsicoreactividad.'|';

$array_hipersenc = [16, 24, 26, 29, 30, 38, 40];
$hipersenc = $answerModel->sumatoria(($answers), $array_hipersenc);
$Phipersenc = round($hipersenc / count($array_hipersenc), 2);
$Phipersenc = number_format((float)$Phipersenc, 2);
//echo $hipersenc.' '.$Phipersenc.'|';

$array_obs_comp = [6, 7, 8, 15, 31, 33, 36];
$obs_comp = $answerModel->sumatoria(($answers), $array_obs_comp);
$Pobs_comp = round($obs_comp / count($array_obs_comp), 2);
$Pobs_comp = number_format((float)$Pobs_comp, 2);
//echo $obs_comp.' '.$Pobs_comp.'|';

$array_anciedad = [4, 9, 18, 22, 25, 34, 35, 47, 50];
$anciedad = $answerModel->sumatoria(($answers), $array_anciedad);
$Panciedad = round($anciedad / count($array_anciedad), 2);
$Panciedad = number_format((float)$Panciedad, 2);
//echo $anciedad.' '.$Panciedad.'|';

$array_hostilidad = [3, 9, 23, 41, 44, 48];
$hostilidad = $answerModel->sumatoria(($answers), $array_hostilidad);
$Phostilidad = round($hostilidad / count($array_hostilidad), 2);
$Phostilidad = number_format((float)$Phostilidad, 2);
//echo $hostilidad.' '.$Phostilidad.'|';

$array_somatizacion = [1, 5, 11, 19, 20, 43, 45, 46];
$somatizacion = $answerModel->sumatoria(($answers), $array_somatizacion);
$Psomatizacion = round($somatizacion / count($array_somatizacion), 2);
$Psomatizacion = number_format((float)$Psomatizacion, 2);
//echo $somatizacion.' '.$Psomatizacion.'|';

$array_depresion = [2, 12, 17, 21, 28, 32, 37, 39, 42, 49];
$depresion = $answerModel->sumatoria(($answers), $array_depresion);
$Pdepresion = round($depresion / count($array_depresion), 2);
$Pdepresion = number_format((float)$Pdepresion, 2);
//echo $depresion.' '.$Pdepresion.'|';

$array_alsuenio = [13, 14, 27];
$alsuenio = $answerModel->sumatoria(($answers), $array_alsuenio);
$Palsuenio = round($alsuenio / count($array_alsuenio), 2);
$Palsuenio = number_format((float)$Palsuenio, 2);
//echo $alsuenio.' '.$Palsuenio.'|';

$array_alsuenio_ampl = [2, 13, 14, 27, 34, 37, 50];
$alsuenio_ampl = $answerModel->sumatoria(($answers), $array_alsuenio_ampl);
$Palsuenio_ampl = round($alsuenio_ampl / count($array_alsuenio_ampl), 2);
$Palsuenio_ampl = number_format((float)$Palsuenio_ampl, 2);
//echo $alsuenio_ampl.' '.$Palsuenio_ampl.'|';

//indice riesgo patologico
$array_irp = [5, 17, 18, 22, 25, 29, 31, 32, 35, 42, 47, 50];
$irp = $answerModel->sumatoria(($answers), $array_irp);
$Pirp = round($irp / count($array_irp), 2);
$Pirp = number_format((float)$Pirp, 2);
//echo $irp.' '.$Pirp.'|';
//indices generales
$ind_global_sev = $psicoreactividad + $anciedad + $hostilidad + $somatizacion + $depresion + $alsuenio;
$Pind_global_sev = round($ind_global_sev / count($answers), 2);
$Pind_global_sev = number_format((float)$Pind_global_sev, 2);
//echo $ind_global_sev.' '.$Pind_global_sev.'|';

$num_sintomas = $answerModel->ocurrencias(($answers), 0);
$Pnum_sintomas = count($answers) - $num_sintomas;
$Pnum_sintomas = number_format((float)$Pnum_sintomas, 2);
//echo $num_sintomas.' '.$Pnum_sintomas.'|';

$ind_intesidad_sintomas = $ind_global_sev;
$Pind_intesidad_sintomas = round($ind_intesidad_sintomas / $Pnum_sintomas, 2);
$Pind_intesidad_sintomas = number_format((float)$Pind_intesidad_sintomas, 2);
//echo $ind_intesidad_sintomas.' '.$Pind_intesidad_sintomas.'|';

//BAREMO DE POBLACION CLINICA PSICOPATOLOGICA MUJERES																													
//MIN
$mins = $baremo->getMin();

//MAG
$mags = $baremo->getMag();
//PR
$prs = $baremo->getPr();
//HP
$hps = $baremo->getHp();
//OB-OP
$obs = $baremo->getOb();
//AN
$ans = $baremo->getAn();
//HS
$hss = $baremo->getHs();
//SM
$sms = $baremo->getSm();

//DE
$des = $baremo->getDe();

//SU
$sus = $baremo->getSu();

//SU-A
$suas = $baremo->getSua();

//IRP-SI
$irpsis = $baremo->getIrpSi();
//GLOBAL
$globals = $baremo->getGlobal();

//NUM
$nums = $baremo->getNum();
//echo json_encode($nums);
//INT
$ints = $baremo->getInt();

$value_min = $mins["$Pmin"];
$text_min = "";
if ($value_min <= 3) {
    $text_min = "Indica una tendencia muy baja a minimizar síntomas. Reporta experimentar síntomas comunes con una frecuencia similar o mayor a la población general.";
} elseif ($value_min <= 16) {
    $text_min = "Indica una tendencia baja a minimizar síntomas. Informa de la presencia de síntomas frecuentes de manera consistente con lo esperado en la población general.";
} elseif ($value_min <= 84) {
    $text_min = "Indica una tendencia promedio a minimizar síntomas. Su informe de síntomas comunes se encuentra dentro del rango típico observado en la población general.";
} elseif ($value_min <= 95) {
    $text_min = "Indica una posible minimización de síntomas. Puede estar reportando menos síntomas de lo que se esperaría, lo que podría requerir una consideración más detallada para entender la razón de esta subestimación.";
} elseif ($value_min >= 97) {
    $text_min = "Indica una tendencia muy elevada a minimizar síntomas. Informa de muy pocos o ninguno de los síntomas comunes que la mayoría de las personas en la población general suelen reportar, lo que sugiere una posible subestimación significativa de su sintomatología.";
}

//$final_text_min = "Minimización esta escala evalúa la tendencia del sujeto a minimizar o negar la presencia de síntomas comunes. Está compuesta por 8 ítems que se refieren a síntomas relativamente menores y frecuentes en la población general ";
//$final_text_min .=$register['id_client']." obtuvo un Pc ".$value_min." ".$text_min;
function descripcion_bajo($valor)
{
    if ($valor <= 3) {
        return "considerablemente por debajo del promedio";
    } elseif ($valor <= 15) {
        return "por debajo del promedio";
    } else {
        return "promedio";
    }
}

function descripcion_alto($valor)
{
    if ($valor <= 94) {
        return "ligeramente por encima del promedio";
    } elseif ($valor <= 99) {
        return "considerablemente por encima del promedio";
    } else {
        return "excesivamente por encima del promedio";
    }
}

$final_text_min = "";
$value_mag = $mags["$Pmag"];
$I13 = $value_min;
$I14 = $value_mag;

if ($I13 <= 84 && $I14 <= 84) {
    $interpretacion =
        "Minimización PC $I13 (" . descripcion_bajo($I13) . "): reconoce la frecuencia e intensidad de síntomas comunes de forma esperable. " .
        "Magnificación PC $I14 (" . descripcion_bajo($I14) . "): no evidencia magnificación de síntomas poco frecuentes.";
}

// ---- CASO 2: Minimización >=85 y Magnificación <=84 ----
elseif ($I13 >= 85 && $I14 <= 84) {
    $interpretacion =
        "Minimización PC $I13 (" . descripcion_alto($I13) . "): indica tendencia a minimizar la presencia o intensidad de síntomas habituales, lo que puede reflejar negación consciente o intento de mostrar una imagen más favorable. " .
        "Magnificación PC $I14 (" . descripcion_bajo($I14) . "): no evidencia exageración.";
}

// ---- CASO 3: Minimización <=84 y Magnificación >=85 ----
elseif ($I13 <= 84 && $I14 >= 85) {
    $interpretacion =
        "Minimización PC $I13 (" . descripcion_bajo($I13) . "): no evidencia minimización. " .
        "Magnificación PC $I14 (" . descripcion_alto($I14) . "): indica una tendencia leve a magnificar la sintomatología poco frecuente.";
}

// ---- CASO 4: Minimización >=85 y Magnificación >=85 ----
else {
    $interpretacion =
        "Minimización PC $I13 (" . descripcion_alto($I13) . "): indica sesgo minimizador significativo; " .
        "Magnificación PC $I14 (" . descripcion_alto($I14) . "): indica sesgo aumentador significativo. " .
        "Perfil contradictorio que combina negación de síntomas frecuentes y exageración de los infrecuentes; requiere evaluación complementaria.";
}
$final_text_min = $interpretacion;
$value_mag = $mags["$Pmag"];
$text_mag = "";
if ($value_mag <= 3) {
    $text_mag = "Indica que reporta una frecuencia e intensidad de síntomas poco comunes significativamente menor que la población clínica psicopatológica. Esta puntuación sugiere una ausencia de magnificación de síntomas.";
} elseif ($value_mag <= 16) {
    $text_mag = "Indica que informa síntomas poco comunes con una frecuencia e intensidad menor que la media de la población clínica psicopatológica. Esta puntuación indica una baja tendencia a magnificar síntomas.";
} elseif ($value_mag <= 84) {
    $text_mag = "Indica que reporta síntomas poco comunes con una frecuencia e intensidad similar a la población clínica psicopatológica. Esta puntuación refleja una tendencia promedio en el reporte de síntomas, sin indicios de magnificación.";
} elseif ($value_mag <= 96) {
    $text_mag = "Indica que informa de más síntomas poco comunes o con mayor intensidad que la población clínica psicopatológica típica. Esta puntuación sugiere una posible tendencia a magnificar la sintomatología.";
} elseif ($value_mag >= 97) {
    $text_mag = "Indica que reporta múltiples síntomas poco comunes con una frecuencia e intensidad inusualmente altas, incluso en comparación con la población clínica psicopatológica. Esta puntuación indica una alta probabilidad de magnificación de síntomas, lo que podría reflejar:<br> 
    a) Un trastorno psicopatológico grave con sintomatología amplia y extrema. <br>
    b) Una situación de desesperación real, donde se informa del sufrimiento de forma indiscriminada y aumentada como petición de ayuda. <br>
    c) Un posible sesgo de respuesta consciente ante una situación que podría derivar en una ventaja o beneficio secundario. <br>
    d) Una dramatización exagerada, más inconsciente, asociada a una finalidad victimista o ganancia secundaria emocional. <br>
    e) En casos específicos, como el trastorno facticio, podría reflejar un refuerzo por desempeñar el papel de enfermo.";
}
$final_text_mag = "Magnificación esta escala evalúa la tendencia a exagerar o magnificar la sintomatología. Está compuesta por 8 ítems que se refieren a síntomas poco frecuentes incluso en poblaciones clínicas";
$final_text_mag .= $register['id_client'] . " obtuvo un Pc " . $mags["$Pmag"] . " " . $text_mag;

$value_global = $globals["$Pind_global_sev"];

$I16 = $value_global;
$text_global = "";

if ($I16 <= 3) {
    $text_global = "presenta un nivel de sufrimiento psíquico y psicosomático considerablemente por debajo del promedio. "
        . "Indica una afectación global mínima, con una intensidad muy baja de síntomas en general. "
        . "La experiencia de malestar es escasa y no representa una preocupación en términos de afectación general.";
} elseif ($I16 <= 16) {
    $text_global = "presenta un nivel de sufrimiento psíquico y psicosomático por debajo del promedio. "
        . "Indica una afectación global menor, con síntomas que se presentan con una intensidad más baja que la que se observa normalmente. "
        . "El malestar expresado es reducido y se manifiesta de forma ocasional o leve.";
} elseif ($I16 <= 84) {
    $text_global = "presenta un nivel de sufrimiento psíquico y psicosomático dentro del rango promedio. "
        . "Indica que la intensidad general de los síntomas experimentados se encuentra en un nivel similar al que suele observarse en la mayoría de las personas. "
        . "El malestar está presente, pero no destaca por ser ni excesivo ni inusualmente bajo.";
} elseif ($I16 <= 96) {
    $text_global = "presenta un nivel de sufrimiento psíquico y psicosomático por encima del promedio. "
        . "Indica una afectación global elevada, caracterizada por un malestar psicológico que se manifiesta con más intensidad de lo habitual. "
        . "El número de síntomas y la forma en que los experimenta superan lo esperable en comparación con la población general.";
} elseif ($I16 >= 97) {
    $text_global = "presenta un nivel de sufrimiento psíquico y psicosomático considerablemente por encima del promedio. "
        . "Indica una afectación global elevada, en la que tanto el número como la intensidad de los síntomas expresados son mayores que los observados en la mayoría de las personas. "
        . "El resultado refleja una experiencia de malestar constante, amplia y de alta intensidad.";
}

$final_text_global = "Desde una perspectiva integral, el Índice Global de Severidad (evalúa el grado de afectación psicopatológica general del evaluado (a), combinando tanto el número de síntomas como su intensidad. Es la medida más sensible del nivel global de malestar psicológico), ";
$final_text_global .= " el resultado indica que " . $text_global;

$value_num = $nums["$Pnum_sintomas"];

$text_num = "";
$I17 = $value_num;

// Variable de resultado
$text_num = "";

if ($I17 <= 3) {
    $text_num = "indica que refleja que la cantidad de síntomas reportados es considerablemente inferior al promedio, "
        . "lo cual indica una escasa extensión de malestar psicológico reconocido en el momento de la evaluación.";
} elseif ($I17 <= 16) {
    $text_num = "indica que la extensión de la sintomatología se encuentra por debajo del promedio, "
        . "lo que indica que el evaluado reporta una cantidad reducida de síntomas en comparación con la mayoría de las personas.";
} elseif ($I17 <= 84) {
    $text_num = "indica que el número de síntomas reportados se encuentra dentro del promedio en comparación con la población normativa. "
        . "Esto indica que la extensión de la sintomatología que presenta no se aleja de lo que habitualmente se observa en la mayoría de las personas.";
} elseif ($I17 <= 96) {
    $text_num = "indica que presenta una mayor cantidad de síntomas en comparación con la mayoría de las personas, "
        . "lo cual indica una extensión por encima del promedio en cuanto a la cantidad de manifestaciones psicológicas reportadas.";
} elseif ($I17 >= 97) {
    $text_num = "indica que el número de síntomas que manifiesta se encuentra considerablemente por encima del promedio, "
        . "lo que señala una amplia extensión de malestar psicológico, es decir, ha reconocido experimentar un conjunto amplio de síntomas que superan claramente lo esperado en la población general.";
}

$final_text_num = "Respecto a la amplitud sintomática, el Índice de Número de Síntomas (evalúa la amplitud o extensión de la sintomatología, indicando cuántos síntomas diferentes experimenta el evaluado (a), independientemente de su intensidad. Responde a la pregunta sobre cuán diversa es la sintomatología), ";
$final_text_num .= "el resultado obtenido " . $text_num;

$value_int = $ints["$Pind_intesidad_sintomas"];
$text_int = "";
$I18 = $value_int;
if ($I18 <= 3) {
    $text_int = "indica que el nivel de malestar asociado a los síntomas presentes se encuentra considerablemente por debajo del promedio, "
        . "lo cual sugiere que los síntomas experimentados son vivenciados con baja intensidad; sus respuestas tienen un estilo “minimizador” (estoicismo).";
} elseif ($I18 <= 16) {
    $text_int = "indica que la intensidad de los síntomas que manifiesta es ligeramente inferior a la media, "
        . "indicando que, aunque hay síntomas presentes, estos son vivenciados con un grado de malestar por debajo del promedio.";
} elseif ($I18 <= 84) {
    $text_int = "indica que la intensidad promedio de los síntomas reportados se sitúa dentro del rango esperado para la población general. "
        . "Esto indica que, si bien hay síntomas presentes, su intensidad no difiere considerablemente de la mayoría de las personas.";
} elseif ($I18 <= 96) {
    $text_int = "indica que se identifica que la persona presenta una intensidad sintomática por encima del promedio, "
        . "lo que indica que los síntomas reconocidos son vivenciados con un nivel de malestar mayor al que comúnmente se observa.";
} elseif ($I18 >= 97) {
    $text_int = "indica que el malestar que experimenta en relación con los síntomas reportados se encuentra considerablemente por encima del promedio, "
        . "lo que indica una intensidad elevada de las manifestaciones psicopatológicas afirmadas; sus respuestas tienen un estilo “aumentador”.";
}

$final_text_int = "En cuanto a la intensidad con la que se perciben los síntomas, el Índice de Intensidad de los Síntomas Presentes (evalúa específicamente la intensidad o severidad de los síntomas que el evaluado (a) afirma tener. Proporciona información sobre cuán intensamente experimenta los síntomas que reporta), ";
$final_text_int .= "el resultado obtenido " . $text_int;

$I30 = $irpsis["$Pirp"];
$text_irpsis = "";
if ($I30 <= 3) {
    $text_irpsis = "El resultado indica que presenta una puntuación considerablemente por debajo del promedio. "
        . "Indica ausencia de concentración de síntomas poco frecuentes y de baja intensidad en la población general que sean, simultáneamente, más frecuentes e intensos en la población clínica. "
        . "No se observa el conglomerado de desvalorización, incomprensión, miedo, somatización y hostilidad con ideas de suicidio en un nivel que resulte predictivo para la inclusión en población afectada con psicopatología.";
} elseif ($I30 <= 16) {
    $text_irpsis = "El resultado indica que presenta una puntuación por debajo del promedio. "
        . "Indica que la presencia de síntomas poco frecuentes en la población general y más frecuentes en la población clínica es baja. "
        . "El conglomerado de desvalorización, incomprensión, miedo, somatización y hostilidad con ideas de suicidio no se configura en un grado que resulte predictivo de inclusión en población afectada con psicopatología.";
} elseif ($I30 <= 84) {
    $text_irpsis = "El resultado indica que presenta una puntuación en el rango promedio. "
        . "Indica un nivel de síntomas acorde al intervalo esperado: algunos elementos del conglomerado (desvalorización, incomprensión, miedo, somatización, hostilidad e ideas de suicidio) "
        . "pueden estar presentes pero sin alcanzar una configuración que, por sí misma, resulte especialmente predictiva para la inclusión en población afectada con psicopatología.";
} elseif ($I30 <= 96) {
    $text_irpsis = "El resultado indica que presenta una puntuación por encima del promedio. "
        . "Indica una mayor presencia de síntomas poco frecuentes en la población general, pero más frecuentes e intensos en la población clínica. "
        . "El conglomerado de desvalorización, incomprensión, miedo, somatización y hostilidad junto con ideas de suicidio aparece con una organización que empieza a adquirir relevancia predictiva "
        . "para la inclusión en una población afectada con psicopatología.";
} elseif ($I30 >= 97) {
    $text_irpsis = "El resultado indica que presenta una puntuación considerablemente por encima del promedio. "
        . "Indica una presencia marcada de síntomas poco frecuentes en población general y más frecuentes e intensos en población clínica. "
        . "El conglomerado de desvalorización, incomprensión, miedo, somatización y hostilidad con ideas de suicidio se manifiesta de manera que resulta claramente predictiva "
        . "(en los términos definidos para el índice) para la inclusión a una población afectada con psicopatología, "
        . "orientando sobre su posible pertenencia a una población clínica con trastornos psicopatológicos.";
}

$final_text_baja = "En este apartado, se interpreta la escala que explora la presencia de síntomas de baja probabilidad en población general y elevada en población clínica, conformando un conjunto de desvalorización, incomprensión, miedo, somatización, hostilidad e ideas de suicidio. ";
$final_text_baja .= $text_irpsis;


$array_ind = [$psicoreactividad, $hipersenc, $obs_comp, $anciedad, $hostilidad, $somatizacion, $depresion, $alsuenio, $alsuenio_ampl];
$array_pd = [$Ppsicoreactividad, $Phipersenc, $Pobs_comp, $Panciedad, $Phostilidad, $Psomatizacion, $Pdepresion, $Palsuenio, $Palsuenio_ampl];
$array_pc = [$prs["$Ppsicoreactividad"], $hps["$Phipersenc"], $obs["$Pobs_comp"], $ans["$Panciedad"], $hss["$Phostilidad"], $sms["$Psomatizacion"], $des["$Pdepresion"], $sus["$Palsuenio"], $suas["$Palsuenio_ampl"]];

$top1 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $prs["$Ppsicoreactividad"], $Ppsicoreactividad, $psicoreactividad, 0);
$top2 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $hps["$Phipersenc"], $Phipersenc, $hipersenc, 1);
$top3 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $obs["$Pobs_comp"], $Pobs_comp, $obs_comp, 2);
$top4 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $ans["$Panciedad"], $Panciedad, $anciedad, 3);
$top5 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $hss["$Phostilidad"], $Phostilidad, $hostilidad, 4);
$top6 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $sms["$Psomatizacion"], $Psomatizacion, $somatizacion, 5);
$top7 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $des["$Pdepresion"], $Pdepresion, $depresion, 6);
$top8 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $sus["$Palsuenio"], $Palsuenio, $alsuenio, 7);
$top9 = $baremoConfiguration->getIndex($array_pc, $array_pd, $array_ind, $suas["$Palsuenio_ampl"], $Palsuenio_ampl, $alsuenio_ampl, 8);

$data_values = [
    "Psicoreactividad" => $top1,
    "Hipersensibilidad" => $top2,
    "Obsesión-Compulsión" => $top3,
    "Ansiedad" => $top4,
    "Hostilidad" => $top5,
    "Somatización" => $top6,
    "Depresión" => $top7,
    "Alteración de sueño" => $top8,
    "Alteración de sueño - ampliada" => $top9

];
$data_ts = [
    "Psicoreactividad" => $prs["$Ppsicoreactividad"],
    "Hipersensibilidad" => $hps["$Phipersenc"],
    "Obsesión-Compulsión" => $obs["$Pobs_comp"],
    "Ansiedad" => $ans["$Panciedad"],
    "Hostilidad" => $hss["$Phostilidad"],
    "Somatización" => $sms["$Psomatizacion"],
    "Depresión" => $des["$Pdepresion"],
    "Alteración de sueño" => $sus["$Palsuenio"],
    "Alteración de sueño - ampliada" => $suas["$Palsuenio_ampl"]

];
asort($data_values);
//desde aqui quitar
$data_tops = $baremoConfiguration->getTop($data_values, $data_ts);
$datatop1 = $data_tops[0];

$salidatop1 = "La puntuación superior corresponde a " . $datatop1["name"] . " (" . $datatop1["message2"] . "), " . $datatop1["message1"];
if ($datatop1["message2"] == "" && $datatop1["message1"] == "") {
    $salidatop1 = "Ninguna de las escalas ha superado la media normativa para realizar una interpretación cualitativa.";
}

$datatop2 = $data_tops[1];
$salidatop2 = "En segundo lugar, se sitúa " . $datatop2["name"] . " (" . $datatop2["message2"] . "), " . $datatop2["message1"];
if ($datatop2["message2"] == "" && $datatop2["message1"] == "") {
    $salidatop2 = "";
}

$datatop3 = $data_tops[2];
$salidatop3 = "Posteriormente, se registra la escala " . $datatop3["name"] . " (" . $datatop3["message2"] . "), " . $datatop3["message1"];
if ($datatop3["message2"] == "" && $datatop3["message1"] == "") {
    $salidatop3 = "";
}

$datatop4 = $data_tops[3];
$salidatop4 = "Finalmente, dentro de las puntuaciones altas, se incluye " . $datatop4["name"] . " (" . $datatop4["message2"] . "), " . $datatop4["message1"];
if ($datatop4["message2"] == "" && $datatop4["message1"] == "") {
    $salidatop4 = "";
}

$message_criterios = "Criterios de Disimulación (NUM<4 e INT=1) o Simulación de síntoma, considerar las siguientes puntuaciones (NUM>46 e INT>3,5)";


$H17 = $Pnum_sintomas;
$H18 = $Pind_intesidad_sintomas;
$I14 = $mags["$Pmag"];
$resultado_mag = "";
if ($I14 <= 84) {
    $resultado_mag = "";
} elseif ($I14 <= 94) {
    $resultado_mag = "sin embargo, considerar una hipótesis de una magnificación leve de síntoma";
} elseif ($I14 >= 95) {
    $resultado_mag = "sin embargo, considerar una hipótesis de magnificación de síntoma";
} else {
    $resultado_mag = "";
}
$S140 = $resultado_mag;
$message_criterios_out = "";
if ($H17 > 46 && $H18 > 3.5) {
    $message_criterios_out = "Considerar hipótesis de simulación o fingimiento de síntoma";
} elseif ($H17 < 4 && $H18 == 1) {
    $message_criterios_out = "Disimulación de sintomatología psicopatológica, con sesgo de deseabilidad social o defensividad";
} else {
    $message_criterios_out = "No cumple los criterios para considerar simulación de síntoma " . $S140;
}

$cant_magnificacion = 0;
$message_magnificacion = "";

$mag1 = $answerModel->sumatoria(($answers), [10]);
if ($mag1 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 10);
    $message_magnificacion .=  $mag1 == 3 ? " (Bastante) <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}

$mag2 = $answerModel->sumatoria(($answers), [17]);
if ($mag2 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 17);
    $message_magnificacion .=  $mag2 == 3 ? " (Bastante). <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}
$mag3 = $answerModel->sumatoria(($answers), [22]);
if ($mag3 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 22);
    $message_magnificacion .=  $mag3 == 3 ? " (Bastante). <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}

$mag4 = $answerModel->sumatoria(($answers), [26]);
if ($mag4 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 26);
    $message_magnificacion .=  $mag4 == 3 ? " (Bastante). <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}

$mag4 = $answerModel->sumatoria(($answers), [29]);
if ($mag4 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 29);
    $message_magnificacion .=  $mag4 == 3 ? " (Bastante). <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}

$mag4 = $answerModel->sumatoria(($answers), [42]);
if ($mag4 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 42);
    $message_magnificacion .=  $mag4 == 3 ? " (Bastante). <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}

$mag4 = $answerModel->sumatoria(($answers), [46]);
if ($mag4 >= 3) {
    $message_magnificacion .= $answerModel->getQuestion($answers, 46);
    $message_magnificacion .=  $mag4 == 3 ? " (Bastante). <br>" : " (Mucho). <br>";
    $cant_magnificacion += 1;
}
//------------------------------
$message_magnificacion2 = "";
$cant_magnificacion2 = 0;

$raw_resp = $answerModel->getRawResponse($answers, 2);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [2]);
    if ($mag4 <=1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 2) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}

$raw_resp = $answerModel->getRawResponse($answers, 4);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [4]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 4) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}

$raw_resp = $answerModel->getRawResponse($answers, 9);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [9]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 9) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}

$raw_resp = $answerModel->getRawResponse($answers, 11);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [11]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 11) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }

}
$raw_resp = $answerModel->getRawResponse($answers, 12);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [12]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 12) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}

$raw_resp = $answerModel->getRawResponse($answers, 13);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [13]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 13) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}

$raw_resp = $answerModel->getRawResponse($answers, 30);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [30]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 30) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}

$raw_resp = $answerModel->getRawResponse($answers, 49);
if ($raw_resp !== null && $raw_resp <= 1) {
    $mag4 = $answerModel->sumatoria(($answers), [49]);
    if ($mag4 <= 1) {
        $message_magnificacion2 .= $answerModel->getQuestion($answers, 49) . ($mag4==1?" (Poco) <br>":"(Nada) <br>");
        $cant_magnificacion2 += 1;
    }
}


$message_sintomas = "";
$cant_sintomas_ind = 0;
$array_sintomas = $answerModel->getArrayDataIndex($answers, 4);
foreach ($array_sintomas as $asnwer) {
    $cant_sintomas_ind += 1;
    $message_sintomas .= $asnwer . '<br>';
}
//desde aqui quitar

$value_an = $ans["$Panciedad"];
$value_hs = $hss["$Phostilidad"];
$value_su_a = $suas["$Palsuenio_ampl"];
$value_pr = $prs["$Ppsicoreactividad"];
$value_irpsi = $irpsis["$Pirp"];

$condicion1 = $value_irpsi >= 97;
$condicion2 = $value_global >= 97;
$array_esc_cli = [$value_pr, $hps["$Phipersenc"], $obs["$Pobs_comp"], $value_an, $value_hs, $sms["$Psomatizacion"], $des["$Pdepresion"], $sus["$Palsuenio"], $value_su_a];
$count_esc_cli = 0;
foreach ($array_esc_cli as $value) {
    if ($value >= 97) {
        $count_esc_cli += 1;
    }
}
$condicion3 = $count_esc_cli >= 2;
$recomendacion_baremo = "";
if ($condicion1 || $condicion2 || $condicion3) {
    $recomendacion_baremo = "Aplicar baremación con población clínica";
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
    <link href="../../assets/css/style_result1.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
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
                                <img src="../../assets/img/test_image/logolsb5.jpeg?v=<?= VERSION_CODE ?>" class="img-logo">
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

                                    <!-- ESCALAS DE VALIDEZ -->
                                    <div>
                                        <div class="section-header">
                                            <div class="title-pill">
                                                ESCALA DE VALIDEZ
                                            </div>

                                            <div class="header-pills">
                                                <span class="pill">PD</span>
                                                <span class="pill">Pc</span>
                                            </div>

                                        </div>

                                        <div class="row-item">
                                            <span class="code">Min</span>
                                            <span class="label-text">Minimización</span>
                                            <span class="value mr4"><?= number_format($Pmin, 2) ?></span>
                                            <span class="value ml4"><?= $mins["$Pmin"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Mag</span>
                                            <span class="label-text">Magnificación</span>
                                            <span class="value mr4"><?= number_format($Pmag, 2) ?></span>
                                            <span class="value ml4"><?= $mags["$Pmag"] ?></span>
                                        </div>
                                    </div>

                                    <!-- INDICES GENERALES -->
                                    <div class="section">
                                        <div class="section-header">
                                            <div class="title-pill">
                                                ÍNDICES GENERALES
                                            </div>
                                            <div class="header-pills">
                                                <span class="pill">PD</span>
                                                <span class="pill">Pc</span>
                                            </div>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">GLOBAL</span>
                                            <span class="label-text">Índice global de severidad</span>
                                            <span class="value mr4"><?= number_format($Pind_global_sev, 2) ?></span>
                                            <span class="value ml4"><?= $globals["$Pind_global_sev"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">NUM</span>
                                            <span class="label-text">Número de síntomas presentes</span>
                                            <span class="value mr4"><?= number_format($Pnum_sintomas, 2) ?></span>
                                            <span class="value ml4"><?= $nums["$Pnum_sintomas"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">INT</span>
                                            <span class="label-text">Índice de intensidad de síntomas presentes</span>
                                            <span class="value mr4"><?= number_format($Pind_intesidad_sintomas, 2) ?></span>
                                            <span class="value ml4"><?= $ints["$Pind_intesidad_sintomas"] ?></span>
                                        </div>
                                    </div>

                                    <!-- ESCALAS CLINICAS -->
                                    <div class="section">
                                        <div class="section-header">
                                            <div class="title-pill">
                                                ESCALAS CLÍNICAS
                                            </div>
                                            <div class="header-pills">
                                                <span class="pill">PD</span>
                                                <span class="pill">Pc</span>
                                            </div>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Pr</span>
                                            <span class="label-text">Psicorreactividad</span>
                                            <span class="value mr4"><?= number_format($Ppsicoreactividad, 2) ?></span>
                                            <span class="value ml4"><?= $prs["$Ppsicoreactividad"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Hp</span>
                                            <span class="label-text">Hipersensibilidad</span>
                                            <span class="value mr4"><?= number_format($Phipersenc, 2) ?></span>
                                            <span class="value ml4"><?= $hps["$Phipersenc"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Ob</span>
                                            <span class="label-text">Obsesión-compulsión</span>
                                            <span class="value mr4"><?= number_format($Pobs_comp, 2) ?></span>
                                            <span class="value ml4"><?= $obs["$Pobs_comp"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">An</span>
                                            <span class="label-text">Ansiedad</span>
                                            <span class="value mr4"><?= number_format($Panciedad, 2) ?></span>
                                            <span class="value ml4"><?= $ans["$Panciedad"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Hs</span>
                                            <span class="label-text">Hostilidad</span>
                                            <span class="value mr4"><?= number_format($Phostilidad, 2) ?></span>
                                            <span class="value ml4"><?= $hss["$Phostilidad"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Sm</span>
                                            <span class="label-text">Somatización</span>
                                            <span class="value mr4"><?= number_format($Psomatizacion, 2) ?></span>
                                            <span class="value ml4"><?= $sms["$Psomatizacion"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">De</span>
                                            <span class="label-text">Depresión</span>
                                            <span class="value mr4"><?= number_format($Pdepresion, 2) ?></span>
                                            <span class="value ml4"><?= $des["$Pdepresion"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Su</span>
                                            <span class="label-text">Alteraciones del sueño</span>
                                            <span class="value mr4"><?= number_format($Palsuenio, 2) ?></span>
                                            <span class="value ml4"><?= $sus["$Palsuenio"] ?></span>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">Su-a</span>
                                            <span class="label-text">Alteraciones del sueño - ampliada</span>
                                            <span class="value mr4"><?= number_format($Palsuenio_ampl, 2) ?></span>
                                            <span class="value ml4"><?= $suas["$Palsuenio_ampl"] ?></span>
                                        </div>
                                    </div>

                                    <!-- INDICE DE RIESGO -->
                                    <div class="section">
                                        <div class="section-header">
                                            <div class="title-pill">
                                                INDICE DE RIESGO PSICOPATOLÓGICO
                                            </div>
                                            <div class="header-pills">
                                                <span class="pill">PD</span>
                                                <span class="pill">Pc</span>
                                            </div>
                                        </div>

                                        <div class="row-item">
                                            <span class="code">IRPsi</span>
                                            <span class="label-text">Índice de riesgo psicopatológico</span>
                                            <span class="value mr4"><?= number_format($Pirp, 2) ?></span>
                                            <span class="value ml4"><?= $irpsis["$Pirp"] ?></span>
                                        </div>
                                    </div>
                                    <div class="section">
                                        <div class="section-header">
                                            <div class="title-pill-none">
                                                
                                            </div>
                                            <div class="header-pills">
                                                <span class="pill">PD</span>
                                                <span class="pill">Pc</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6" style="padding:0px">
                                <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                <div class="ht-100 ht-sm-300" style="margin-top: -7px;height:690px !important;width: 100%;" id="colorss"></div>
                                <div class="ht-100 ht-sm-300" style="margin-top: -7px;height: 119px !important;width: 100%;" id="colorss2"></div>
                                <div class="ht-100 ht-sm-300" style="margin-top: -10px;margin-bottom:3px;height: 115px !important;" id="flotLine2"></div>
                                <div class="ht-100 ht-sm-300" style="height: 130px !important;" id="flotLineIndGeneral"></div>
                                <div class="ht-100 ht-sm-300" style="margin-top:10px;height: 350px !important;" id="flotLineEscalasClinicas"></div>
                                <div class="ht-100 ht-sm-300" style="margin-top:15px;   margin-bottom: 15px;height: 75px !important;" id="flotLineIndRiesgoPat"></div>
                                <p style="color:#232323;text-align: left;font-size: 15px !important;">Nota Pc: (Percentil), escala ordinal.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    

                    <div class="col-md-12">
                        <div id="contenido3" class="card card-body" style="padding-bottom: 100px;text-align: justify;">
                            <h4 class="tx-15" id="jsonvalue4">VALIDEZ DEL PERFIL</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue5">El LSB-50 incluye dos escalas de validez diseñadas para detectar posibles sesgos de respuesta que podrían afectar la interpretación de los resultados:</p>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue5_1"><?= $final_text_min ?></p><br><br>
                            <h4 class="tx-15" id="jsonvalue6">ÍNDICES GENERALES</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue7">Los índices generales en el LSB-50 son medidas que proporcionan una visión global del nivel de sufrimiento psicopatológico del evaluado(a). En este caso, sus resultados indican que:<br>
                            </p>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue7_1"><?= $final_text_global ?></p>
                            <br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue7_2"><?= $final_text_num ?></p>
                            <br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue7_3"><?= $final_text_int ?></p><br><br>

                            <h4 class="tx-15" id="jsonvalue8">ÍNDICES DE RIESGO PATOLÓGICO </h4><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue9">
                                Explora la presencia de síntomas cuya probabilidad de aparición e intensidad es baja en la población general, no clínica y, por el contrario, alta en la población clínica. Evalúa la presencia de síntomas asociados a la población clínica psicopatológica, formando un conglomerado de desvalorización, incomprensión, miedo, somatización y hostilidad junto con ideas de suicidio. En su conjunto, resultan predictivos para la inclusión del evaluado en una población afectada con psicopatología.
                            </p>
                            <br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue9_1"><?= $final_text_baja ?></p>
                            <br><br>

                            <h4 class="tx-15" id="jsonvalue12">ESCALAS CLÍNICAS </h4><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13">
                                La valoración de las escalas del LSB-50 informa sobre el perfil psicopatológico del sujeto, es decir, sobre cuál es la forma de expresión particular de la psicopatología. A continuación se describen las cuatro escalas con mayor puntuación relativa dentro del conjunto clínico:
                            </p>
                            <br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13_1"><?= $salidatop1 ?></p><br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13_2"><?= $salidatop2 ?></p><br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13_3"><?= $salidatop3 ?></p><br><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue13_4"><?= $salidatop4 ?></p><br><br>


                            <h4 class="tx-15" id="jsonvalue14"> <?= $message_criterios; ?></h4><br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue15"><?= $message_criterios_out ?></p>
                            <h4 class="tx-15" id="jsonvalue16">Se identificaron(<?= $cant_magnificacion ?>/8) ítems de magnificación que van de bastante a mucho</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue17">
                                <?= $message_magnificacion ?>
                            </p>
                            <h4 class="tx-15" id="jsonvalue18">Se identificaron(<?= $cant_magnificacion2 ?>/8) ítems de disimulación que van de poco a nada</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue19">
                                <?= $message_magnificacion2 ?>
                            </p>
                            <h4 class="tx-15" id="jsonvalue20">Síntomas individuales</h4>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue21">
                                Por último, se valorarán los aspectos idiosincrásicos o tendencias particulares, se identifico (<?= $cant_sintomas_ind ?>/50) puntuados con la máxima intensidad («4»)

                            </p>
                            <br>
                            <p class="tx-dark mb-0 txt-force-black" id="jsonvalue21_1"><?= $message_sintomas ?></p>

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
            type: 2,
            image: "contenido2"
        });
        jsonpdf.push({
            type: 3
        });
        
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue4')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue5')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue5_1')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue6')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue7')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue7_1')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue7_2')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue7_3')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue8')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue9')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue9_1')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue12')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue13')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue13_1')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue13_2')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue13_3')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue13_4')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue14')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 5,
            text: getvalue('jsonvalue15')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue16')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 8,
            text: getvalue('jsonvalue17')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue18')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 8,
            text: getvalue('jsonvalue19')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue20')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 8,
            text: getvalue('jsonvalue21')
        });
        jsonpdf.push({
            type: 5,
            text: ''
        });
        jsonpdf.push({
            type: 8,
            text: getvalue('jsonvalue21_1')
        });

        $(function() {
            'use strict';
            var colorLine = "black";
            var newCust = [
                [<?= $mins["$Pmin"] ?>, 10],
                [<?= $mags["$Pmag"] ?>, 0]
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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true
                },
                yaxis: {
                    min: -5,
                    max: 15,
                    color: 'transparent',
                    ticks: [
                        [0, ''],
                        [15, '']
                    ],
                    tickColor: 'transparent',
                    tickLength: 0,
                    show: false,
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    min: 0,
                    max: 99,
                    tickColor: 'black',
                    ticks: [
                        [1, '1'],
                        [3, '3'],
                        [16, '16'],
                        [50, '50'],
                        [84, '84'],
                        [96, '97'],
                        [99, '99'],
                    ],
                    tickLength: 0,
                    font: {
                        size: 10,
                        color: 'black'
                    },
                    position: 'top'
                }
            });

            var flotLineIndGeneral = [
                [<?= $globals["$Pind_global_sev"] ?>, 20],
                [<?= $nums["$Pnum_sintomas"] ?>, 10],
                [<?= $ints["$Pind_intesidad_sintomas"] ?>, 0]
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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true
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
                    min: 0,
                    max: 99,
                    tickColor: 'transparent',
                    font: {
                        size: 10,
                        color: 'transparent'
                    },
                    position: 'top',
                    show: false
                }
            });
            var flotLineEscalasClinicas = [
                [<?= $prs["$Ppsicoreactividad"] ?>, 80],
                [<?= $hps["$Phipersenc"] ?>, 70],
                [<?= $obs["$Pobs_comp"] ?>, 60],
                [<?= $ans["$Panciedad"] ?>, 50],
                [<?= $hss["$Phostilidad"] ?>, 40],
                [<?= $sms["$Psomatizacion"] ?>, 30],
                [<?= $des["$Pdepresion"] ?>, 20],
                [<?= $sus["$Palsuenio"] ?>, 10],
                [<?= $suas["$Palsuenio_ampl"] ?>, 0]
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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true
                },
                yaxis: {
                    min: -5,
                    max: 85,
                    color: '#737f9e',
                    ticks: [
                        [0, ''],
                        [85, '']
                    ],
                    tickColor: 'rgba(171, 167, 167, 0)',
                    font: {
                        size: 10,
                        color: '#999'
                    },
                    show: false
                },
                xaxis: {
                    color: '#eee',
                    min: 0,
                    max: 99,
                    tickColor: 'rgba(171, 167, 167, 0)',
                    font: {
                        size: 10,
                        color: '#999'
                    },
                    position: 'top',
                    show: false
                }
            });

            var flotLineIndRiesgoPat = [
                [<?= $irpsis["$Pirp"] ?>, 6]
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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true,
                    tickColor: 'rgba(171, 167, 167, 0)'
                },
                yaxis: {
                    min: 0,
                    max: 12,
                    color: '#eee',
                    ticks: [
                        [0, ''],
                        [12, '']
                    ],
                    tickColor: 'rgba(171, 167, 167,0.2)',
                    font: {
                        size: 10,
                        color: '#999'
                    }
                },
                xaxis: {
                    color: '#eee',
                    min: 0,
                    max: 99,
                    tickColor: 'black',
                    ticks: [
                        [1, '1'],
                        [3, '3'],
                        [16, '16'],
                        [50, '50'],
                        [84, '84'],
                        [96, '97'],
                        [99, '99'],
                    ],
                    tickLength: 0,
                    font: {
                        size: 10,
                        color: 'black'
                    },
                    position: 'bottom'
                }
            });

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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true
                },
                yaxis: {
                    min: -5,
                    max: 85,
                    color: 'black',
                    ticks: [
                        [0, ''],
                        [85, '']
                    ],
                    tickColor: 'black',
                    font: {
                        size: 10,
                        color: 'black'
                    },
                    show: false
                },
                xaxis: {
                    color: '#eee',
                    min: 0,
                    max: 99,
                    tickColor: 'black',
                    font: {
                        size: 10,
                        color: 'black'
                    },
                    position: 'top',
                    show: false
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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true,
                    tickColor: 'rgba(171, 167, 167, 0)',
                    markings: [{
                            xaxis: {
                                from: 0,
                                to: 3
                            },
                            color: '#c6d5ec'
                        },
                        {
                            xaxis: {
                                from: 3,
                                to: 16
                            },
                            color: '#95b4dd'
                        },
                        {
                            xaxis: {
                                from: 16,
                                to: 85
                            },
                            color: '#40ab96'
                        },
                        {
                            xaxis: {
                                from: 84,
                                to: 97
                            },
                            color: '#fee1bb'
                        },
                        {
                            xaxis: {
                                from: 97,
                                to: 99
                            },
                            color: '#fef0db'
                        },
                        { // Línea punteada en X = 50
                            xaxis: {
                                from: 50,
                                to: 50
                            },
                            color: '#000', // color de la línea
                            lineWidth: 0.5
                        },
                        { // Línea horizontal en y = 6
                            yaxis: {
                                from: 10.19,
                                to: 10.19
                            },
                            color: 'white',
                            lineWidth: 1.5
                        },
                        { // Línea horizontal en y = 6
                            yaxis: {
                                from: 7.63,
                                to: 7.63
                            },
                            color: 'white',
                            lineWidth: 1.5
                        },
                        { // Línea horizontal en y = 6
                            yaxis: {
                                from: 1.10,
                                to: 1.10
                            },
                            color: 'white',
                            lineWidth: 1.5
                        }
                    ]
                },
                yaxis: {
                    min: 0,
                    max: 12,
                    color: '#eee',
                    ticks: [
                        [0, ''],
                        [12, '']
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
                    borderWidth: 1,
                    borderColor: 'transparent',
                    hoverable: true,
                    show: true,
                    tickColor: 'rgba(171, 167, 167, 0)',
                    markings: [{
                            xaxis: {
                                from: 84,
                                to: 94
                            },
                            color: 'rgba(13, 165, 140, 0.44)'
                        },
                        {
                            xaxis: {
                                from: 0,
                                to: 50
                            },
                            color: '#40ab96'
                        }
                    ]
                },
                yaxis: {
                    min: 0,
                    max: 12,
                    color: '#eee',
                    ticks: [
                        [0, ''],
                        [12, '']
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

            function labelFormatter(label, series) {
                return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
            }
        });
        setTimeout(function() {
            document.getElementById('colorss').style.position = 'absolute';
        }, 1000);
        setTimeout(function() {
            document.getElementById('colorss2').style.position = 'absolute';
        }, 1000);
        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });
    </script>
    <script src="../../assets/js/print.js?v=<?= VERSION_CODE ?>"></script>
</body>

</html>