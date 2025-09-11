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
include("../models/lsb50/model_baremo_clinica_psic_mujeres.php");
include("../models/lsb50/model_baremo_clinica_psic_varones.php");
include("../models/lsb50/model_baremo_pob_gral_mujeres.php");
include("../models/lsb50/model_baremo_pob_gral_varones.php");
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
}
$baremos = $baremoModel->getAll($register['id_type_question']);
//echo json_encode($register);
$baremo = new ModelBaremoPobGralVarones();//baremo=1
if($register['baremo_id'] == 2){
    $baremo = new ModelBaremoPobGralMujeres();
}
if($register['baremo_id'] == 3){
    $baremo = new ModelBaremoClinicaPsiVarones();
}
if($register['baremo_id'] == 4){
    $baremo = new ModelBaremoClinicaPsiMujeres();
}

$answers = $answerModel->getAll($register['codes']);
$answers_text = $answerModel->getAnswersTop($register['codes']);
$answers_text = $answers_text['response'];
#escala de validez
//$questions =  $questionModel->getAll($register['id_type_question']);
$array_min = [2,4,9,11,12,13,30,49];
$array_mag = [5,10,17,22,26,29,42,46];
$min = $answerModel->sumatoria(($answers),$array_min);
$mag = $answerModel->sumatoria(($answers),$array_mag);
$Pmin = round($min/count($array_min),2);
$Pmag = round($mag/count($array_mag),2);
//echo $min.' '.$Pmin.'|';
//echo $mag.' '.$Pmag.'|';

//escalas clinicas
$array_psicoreac = [6,7,8,15,16,24,26,29,30,31,33,36,38,40];
$psicoreactividad = round($answerModel->sumatoria(($answers),$array_psicoreac),2);
$Ppsicoreactividad = round($psicoreactividad/count($array_psicoreac),2);
//echo $psicoreactividad.' '.$Ppsicoreactividad.'|';

$array_hipersenc = [16,24,26,29,30,38,40];
$hipersenc = $answerModel->sumatoria(($answers),$array_hipersenc);
$Phipersenc = round($hipersenc/count($array_hipersenc),2);
//echo $hipersenc.' '.$Phipersenc.'|';

$array_obs_comp = [6,7,8,15,31,33,36];
$obs_comp = $answerModel->sumatoria(($answers),$array_obs_comp);
$Pobs_comp = round($obs_comp/count($array_obs_comp),2);
//echo $obs_comp.' '.$Pobs_comp.'|';

$array_anciedad = [4,9,18,22,25,34,35,47,50];
$anciedad = $answerModel->sumatoria(($answers),$array_anciedad);
$Panciedad = round($anciedad/count($array_anciedad),2);
//echo $anciedad.' '.$Panciedad.'|';

$array_hostilidad = [3,9,23,41,44,48];
$hostilidad = $answerModel->sumatoria(($answers),$array_hostilidad);
$Phostilidad = round($hostilidad/count($array_hostilidad),2);
//echo $hostilidad.' '.$Phostilidad.'|';

$array_somatizacion = [1,5,11,19,20,43,45,46];
$somatizacion = $answerModel->sumatoria(($answers),$array_somatizacion);
$Psomatizacion = round($somatizacion/count($array_somatizacion),2);
//echo $somatizacion.' '.$Psomatizacion.'|';

$array_depresion = [2,12,17,21,28,32,37,39,42,49];
$depresion = $answerModel->sumatoria(($answers),$array_depresion);
$Pdepresion = round($depresion/count($array_depresion),2);
//echo $depresion.' '.$Pdepresion.'|';

$array_alsuenio = [13,14,27];
$alsuenio = $answerModel->sumatoria(($answers),$array_alsuenio);
$Palsuenio = round($alsuenio/count($array_alsuenio),2);
//echo $alsuenio.' '.$Palsuenio.'|';

$array_alsuenio_ampl = [2,13,14,27,34,37,50];
$alsuenio_ampl = $answerModel->sumatoria(($answers),$array_alsuenio_ampl);
$Palsuenio_ampl = round($alsuenio_ampl/count($array_alsuenio_ampl),2);
//echo $alsuenio_ampl.' '.$Palsuenio_ampl.'|';

//indice riesgo patologico
$array_irp = [5,17,18,22,25,29,31,32,35,42,47,50];
$irp = $answerModel->sumatoria(($answers),$array_irp);
$Pirp = round($irp/count($array_irp),2);
//echo $irp.' '.$Pirp.'|';
//indices generales
$ind_global_sev = $psicoreactividad+$anciedad+$hostilidad+$somatizacion+$depresion+$alsuenio;
$Pind_global_sev = round($ind_global_sev/count($answers),2);
//echo $ind_global_sev.' '.$Pind_global_sev.'|';

$num_sintomas = $answerModel->ocurrencias(($answers),0);
$Pnum_sintomas = count($answers) - $num_sintomas;
//echo $num_sintomas.' '.$Pnum_sintomas.'|';

$ind_intesidad_sintomas = $ind_global_sev;
$Pind_intesidad_sintomas = round($ind_intesidad_sintomas/$Pnum_sintomas,2);
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

$final_text_min = "Minimización esta escala evalúa la tendencia del sujeto a minimizar o negar la presencia de síntomas comunes. Está compuesta por 8 ítems que se refieren a síntomas relativamente menores y frecuentes en la población general ";
$final_text_min .=$register['id_client']." obtuvo un Pc ".$value_min." ".$text_min;

$value_mag = $mags["$Pmag"];
$text_mag = "";
if ($value_mag <= 3) {
    $text_mag= "Indica que reporta una frecuencia e intensidad de síntomas poco comunes significativamente menor que la población clínica psicopatológica. Esta puntuación sugiere una ausencia de magnificación de síntomas.";
} elseif ($value_mag <= 16) {
    $text_mag= "Indica que informa síntomas poco comunes con una frecuencia e intensidad menor que la media de la población clínica psicopatológica. Esta puntuación indica una baja tendencia a magnificar síntomas.";
} elseif ($value_mag <= 84) {
    $text_mag= "Indica que reporta síntomas poco comunes con una frecuencia e intensidad similar a la población clínica psicopatológica. Esta puntuación refleja una tendencia promedio en el reporte de síntomas, sin indicios de magnificación.";
} elseif ($value_mag <= 96) {
    $text_mag= "Indica que informa de más síntomas poco comunes o con mayor intensidad que la población clínica psicopatológica típica. Esta puntuación sugiere una posible tendencia a magnificar la sintomatología.";
} elseif ($value_mag >= 97) {
    $text_mag= "Indica que reporta múltiples síntomas poco comunes con una frecuencia e intensidad inusualmente altas, incluso en comparación con la población clínica psicopatológica. Esta puntuación indica una alta probabilidad de magnificación de síntomas, lo que podría reflejar:<br> 
    a) Un trastorno psicopatológico grave con sintomatología amplia y extrema. <br>
    b) Una situación de desesperación real, donde se informa del sufrimiento de forma indiscriminada y aumentada como petición de ayuda. <br>
    c) Un posible sesgo de respuesta consciente ante una situación que podría derivar en una ventaja o beneficio secundario. <br>
    d) Una dramatización exagerada, más inconsciente, asociada a una finalidad victimista o ganancia secundaria emocional. <br>
    e) En casos específicos, como el trastorno facticio, podría reflejar un refuerzo por desempeñar el papel de enfermo.";
}
$final_text_mag = "Magnificación esta escala evalúa la tendencia a exagerar o magnificar la sintomatología. Está compuesta por 8 ítems que se refieren a síntomas poco frecuentes incluso en poblaciones clínicas";
$final_text_mag .= $register['id_client']." obtuvo un Pc ".$mags["$Pmag"]." ".$text_mag;

$value_global = $globals["$Pind_global_sev"];
$text_global="";
if ($value_global <= 3) {
    $text_global= "Indica que el nivel general de malestar psíquico y psicosomático es significativamente bajo. Esto podría indicar una ausencia notable de sintomatología psicopatológica o una presencia muy leve de síntomas.";
} elseif ($value_global <= 16) {
    $text_global= "Indica un nivel de malestar que es leve y probablemente no representativo de una perturbación psicológica significativa. Podría experimentar algunos síntomas, pero en un grado que no sugiere una alteración psicopatológica grave.";
} elseif ($value_global <= 84) {
    $text_global= "Indica que las puntuaciones dentro de este amplio rango se consideran normales o típicas, indicando un nivel de malestar que es común en la población general. Con estas puntuaciones experimenta síntomas que no son inusuales ni excesivamente severos.";
} elseif ($value_global <= 96) {
    $text_global= "Indica un nivel moderado de sufrimiento psicológico global. Esto indica una mayor intensidad y/o número de síntomas en comparación con lo que se considera típico, lo que puede reflejar una mayor afectación psicopatológica.";
} elseif ($value_global >= 97) {
    $text_global= "Indica un alto grado de malestar psíquico y psicosomático. Esto refleja una afectación psicopatológica significativa, con múltiples síntomas experimentados con gran intensidad, lo que sugiere un impacto considerable en el bienestar psicológico.";
}
$final_text_global = $register['id_client']." obtuvo un percentil de ".$globals["$Pind_global_sev"]." en el Índice Global de severidad que evalúa el grado de afectación psicopatológica general del evaluado (a), combinando tanto el número de síntomas como su intensidad. Es la medida más sensible del nivel global de malestar psicológico.";
$final_text_global .=" Una puntuación en el percentil ".$globals["$Pind_global_sev"].", ".$text_global;

$value_num = $nums["$Pnum_sintomas"];

$text_num = "";
if ($value_num <= 3) {
    $text_num= "Informa muy pocos síntomas psicopatológicos. Esto indica una cantidad de síntomas menor que la que experimenta la mayoría de las personas, lo que podría interpretarse como una ausencia de psicopatología significativa o una indicación de una buena salud mental.";
} elseif ($value_num <= 16) {
    $text_num= "Indica que experimenta algunos síntomas psicopatológicos, pero la cantidad total de síntomas es relativamente baja y no sugiere una psicopatología amplia o diversa.";
} elseif ($value_num <= 84) {
    $text_num= "Indica que la cantidad de síntomas reportados se considera promedio en comparación con la población general. En este rango experimenta una cantidad de síntomas psicopatológicos que no se desvía significativamente de lo que es común en la población general.";
} elseif ($value_num <= 96) {
    $text_num= "Indica que está experimentando una cantidad moderada de síntomas psicopatológicos. Esto indica una mayor amplitud en la psicopatología que lo que se observa típicamente en la población general.";
} elseif ($value_num >= 97) {
    $text_num= "Indica una cantidad de síntomas psicopatológicos considerablemente mayor que la mayoría de las personas. Esto refleja una extensa variedad y amplitud de síntomas psicopatológicos y sugiere que podría estar experimentando múltiples problemas psicológicos.";
}
$final_text_num = "En el Número de síntomas presentes que evalúa la amplitud o extensión de la sintomatología, indicando cuántos síntomas diferentes experimenta el evaluado (a), independientemente de su intensidad. Responde a la pregunta sobre cuán diversa es la sintomatología. ";
$final_text_num .= "Obtuvo una puntuación en el percentil ".$value_num.", ".$text_num;

$value_int = $ints["$Pind_intesidad_sintomas"];
$text_int = "";
if ($value_int <= 3) {
    $text_int = "Informa una baja intensidad en los síntomas que ha reconocido. Esto podría indicar que, aunque experimenta ciertos síntomas, estos no son particularmente severos o perturbadores.";
} elseif ($value_int <= 16) {
    $text_int =  "Indica que la intensidad de los síntomas reconocidos es leve. Podría estar experimentando síntomas, pero a un nivel que no es excesivamente disruptivo o severo.";
} elseif ($value_int <= 84) {
    $text_int =  "Indica que dentro de este rango amplio se consideran normales y representan la intensidad promedio de síntomas que se podría esperar en la población general. Informa una intensidad de síntomas que es común y no indica una severidad inusual.";
} elseif ($value_int <= 96) {
    $text_int =  "Indica una intensidad de síntomas moderada. Esto sugiere que los síntomas reconocidos son más intensos que lo que se observa comúnmente, lo que puede ser indicativo de un mayor nivel de malestar psicológico.";
} elseif ($value_int >= 97) {
    $text_int =  "Indica una intensidad de síntomas muy alta. Informa una severidad de síntomas considerable, lo que implica un impacto significativo en su bienestar psicológico.";
}
$final_text_int = "Y en el Índice de intensidad de síntomas presentes que evalúa específicamente la intensidad o severidad de los síntomas que el evaluado (a) afirma tener. Proporciona información sobre cuán intensamente experimenta los síntomas que reporta. ";
$final_text_int .= "En esta escala obtuvo una puntuación en el percentil ".$value_int.", ".$text_int;

$value_an = $ans["$Panciedad"];
$text_an="";
if ($value_an <= 3) {
    $text_an= "Indica que experimenta una ansiedad mínima, con muy pocas manifestaciones de nerviosismo, miedo o angustia. Los síntomas típicos de trastornos de ansiedad generalizada, pánico, o ansiedad fóbica son casi inexistentes. La capacidad para manejar situaciones estresantes o ansiedad-provocadoras es alta, con poca o ninguna evitación de situaciones debido al miedo.";
} elseif ($value_an <= 16) {
    $text_an= "Indica que presenta una leve manifestación de ansiedad. Puede haber ocasional inquietud o nerviosismo en situaciones específicas, como estar en espacios abiertos o tener que salir de casa, pero estos sentimientos son manejables y no limitan significativamente la vida cotidiana. Los miedos repentinos y sin causa aparente son raros y no interfieren de manera considerable con el funcionamiento diario.";
} elseif ($value_an <= 84) {
    $text_an= "Indica que la ansiedad se encuentra en un nivel considerado normativo. Puede experimentar momentos de inquietud, nerviosismo o miedo en situaciones que comúnmente provocan ansiedad, como espacios abiertos o estar solo, pero estos sentimientos son parte de una respuesta normal a situaciones cotidianas y no indican una ansiedad patológica. La evitación de ciertas situaciones debido al miedo puede ocurrir, pero no es predominante.";
} elseif ($value_an <= 96) {
    $text_an= "Indica que hay una presencia moderada de síntomas de ansiedad. La inquietud, los miedos irracionales, y el nerviosismo pueden ser más frecuentes y tener un impacto en la vida diaria, llevando a la evitación de situaciones que provocan ansiedad. Sin embargo, aún mantiene cierta capacidad para funcionar a pesar de estos desafíos.";
} elseif ($value_an >= 97) {
    $text_an= "Indica que la ansiedad es intensa, con síntomas graves que reflejan un trastorno de ansiedad generalizada, pánico, o ansiedad fóbica. La inquietud, el miedo, y el nerviosismo son constantes. La evitación de situaciones por miedo es común, y los pensamientos o imágenes intrusivos provocan una ansiedad significativa. Experimenta una preocupación constante por la posibilidad de que ocurran eventos negativos, lo que domina su experiencia diaria.";
}
$final_text_an = "En la escala de Anciedad(An) que explora manifestaciones de ansiedad generalizada, pánico y ansiedad fóbica. ";
$final_text_an .=$register['id_client']." obtuvo una puntuación en el percentil ".$value_an.", Este resultado ".$text_an;


$value_hs = $hss["$Phostilidad"];
$text_hs="";
if ($value_hs <= 3) {
    $text_hs= "Indica una mínima presencia de hostilidad. Casi no experimenta impulsos de destruir cosas, irritabilidad, o ataques de ira incontrolables. Es poco probable que participe en discusiones frecuentes o muestre arrebatos de agresividad hacia otros. Su capacidad para controlar emociones negativas como la ira y el resentimiento es alta, lo que indica un manejo efectivo de las respuestas emocionales en situaciones potencialmente provocadoras.";
} elseif ($value_hs <= 16) {
    $text_hs= "Indica una leve manifestación de comportamientos hostiles. Puede sentirse ocasionalmente irritable o mostrar enojo, pero estos sentimientos son controlables y no conducen a acciones destructivas o dañinas. Los impulsos agresivos son raros y, cuando ocurren, se manejan de manera que no afectan negativamente a los demás significativamente. Las discusiones con otros son infrecuentes y no suelen escalar a conflictos serios.";
} elseif ($value_hs <= 84) {
    $text_hs= "Indica que la presencia de hostilidad está en un nivel considerado normativo. Puede sentirse irritable o enojado(a), pero estas emociones están dentro del rango de lo que se considera una respuesta emocional típica. Puede haber momentos esporádicos de discusiones o frustración, pero estos no dominan su comportamiento ni afectan de manera significativa sus relaciones interpersonales.";
} elseif ($value_hs <= 96) {
    $text_hs= "Indica que hay una presencia moderada de hostilidad. La irritabilidad, el enojo y los impulsos de agresividad son más frecuentes y pueden ser más difíciles de controlar. Es posible que participe en discusiones con más regularidad y experimente ataques de ira que desafían su capacidad para mantener el control emocional. Aunque estos comportamientos pueden influir en sus interacciones con los demás, aún existe un esfuerzo por gestionar las emociones negativas.";
} elseif ($value_hs >= 97) {
    $text_hs= "Indica una alta presencia de hostilidad, con reacciones frecuentes y severas de pérdida de control emocional. Los impulsos de destruir objetos, la irritabilidad crónica, los ataques de ira incontrolables, y los arrebatos de agresividad física son prominentes. Estas manifestaciones de hostilidad afectan significativamente las relaciones interpersonales y pueden conducir a consecuencias negativas en diferentes aspectos.";
}

$final_text_hs = "Por otro lado, en la escala de Hostilidad(Hs) que evalúa reacciones de pérdida de control emocional con manifestaciones de agresividad, ira o resentimiento. ";
$final_text_hs .= $register['id_client']." obtuvo una puntuación en el percentil ".$value_hs.". Este resultado ".$text_hs;

$value_su_a = $suas["$Palsuenio_ampl"];
$text_su_a = "";
if ($value_su_a <= 3) {
    $text_su_a= "Indica que la presencia de alteraciones en el sueño es mínima, y los síntomas asociados con ansiedad y depresión que podrían afectar el sueño son casi inexistentes. Raramente experimenta despertares nocturnos, sueño agitado, o dificultades para conciliar el sueño, y los sentimientos de tristeza, soledad o miedo no tienen un impacto significativo en la calidad del sueño.";
} elseif ($value_su_a <= 16) {
    $text_su_a= "Indica una manifestación leve de alteraciones en el sueño, con algunos síntomas de ansiedad y depresión que pueden afectar ocasionalmente la calidad del sueño. Puede haber episodios esporádicos de despertares nocturnos o dificultades para conciliar el sueño, pero estos son manejables. Los sentimientos de tristeza o ansiedad son leves y no interfieren de manera considerable con el sueño.";
} elseif ($value_su_a <= 84) {
    $text_su_a= "Indica que la presencia de alteraciones en el sueño y los síntomas ansioso-depresivos asociados está dentro de un rango considerado normativo. Aunque puede experimentar de vez en cuando dificultades para dormir o sentirse triste o ansiosa, estos no sugieren un problema significativo. Los episodios de sueño alterado o dificultades para conciliar el sueño son parte de las variaciones normales del sueño.";
} elseif ($value_su_a <= 96) {
    $text_su_a= "Indica que hay una presencia moderada de alteraciones en el sueño, con síntomas de ansiedad y depresión que afectan más la calidad del sueño. Los despertares nocturnos, el sueño agitado, y las dificultades para dormir son más frecuentes. La tristeza, la soledad, y los miedos pueden contribuir a estas alteraciones, indicando un vínculo entre los estados emocionales y los problemas de sueño.";
} elseif ($value_su_a >= 97) {
    $text_su_a= "Indica que experimenta una alta presencia de alteraciones graves en el sueño, intensamente afectadas por síntomas de ansiedad y depresión. Los problemas de sueño, como despertares frecuentes, dificultades para conciliar el sueño, y sueño agitado, son constantes y severos. Los sentimientos intensos de tristeza, soledad, y miedo tienen un impacto significativo en la calidad del sueño, lo que sugiere una conexión entre los trastornos del sueño y los estados ansioso-depresivos.";
}
$final_text_sua = "También se observa que en la escala de Alteración de sueño ampliada	que evalúa la presencia específica de alteraciones del sueño junto con manifestaciones de las escalas Ansiedad y Depresión que clínicamente están asociadas a problemas de sueño. ";
$final_text_sua .= $register['id_client']." obtuvo una puntuación en el percentil ".$value_hs.". Este resultado ".$text_su_a;

$value_pr = $prs["$Ppsicoreactividad"];
$text_pr ="";
if ($value_pr <= 3) {
    $text_pr = "exhibe una baja tendencia a la autoobservación excesiva y a reaccionar de manera significativa a la percepción externa o interna. La interacción social y la autoimagen no parecen estar fuertemente influenciadas por preocupaciones sobre juicios externos o análisis interno intensivo.";
} elseif ($value_pr <= 16) {
    $text_pr = "indica una leve sensibilidad en la percepción de uno mismo en relación con los demás y hacia la propia imagen. Hay una ligera inclinación a la autoobservación, pero no domina el comportamiento ni el bienestar emocional de manera significativa. La influencia de la percepción externa sobre la autoestima y el comportamiento es limitada, permitiendo una adaptación funcional a la mayoría de las situaciones sociales.";
} elseif ($value_pr <= 84) {
    $text_pr = "muestra una cantidad moderada de autoobservación y preocupación por la imagen personal y cómo se percibe en contextos sociales, lo cual es común y esperado en la población general. Esta sensibilidad no suele interferir con la capacidad de funcionar de manera efectiva en la vida diaria.";
} elseif ($value_pr <= 96) {
    $text_pr = "indica una sensibilidad moderada en la percepción de uno mismo tanto en relación con los demás como hacia la propia imagen. La autoobservación puede ser más frecuente y las preocupaciones sobre cómo es percibido por otros pueden influir en el comportamiento y en las interacciones sociales más de lo que podría considerarse típico, aunque aún dentro de límites que permiten un funcionamiento adecuado.";
} else {
    $text_pr = "indica una alta sensibilidad en la percepción de uno mismo en relación con los demás y hacia la propia imagen, junto con una tendencia significativa a la autoobservación excesiva. Esta intensa preocupación por la percepción externa e interna puede afectar profundamente el comportamiento, las interacciones sociales y el bienestar emocional, indicando una reactividad psicológica que sobrepasa lo esperado en la población general. La percepción de uno mismo está fuertemente influenciada por el miedo al juicio y por una crítica interna constante.";
}
$final_text_pr = "Por último, se observa que en la escala de Psicoreactividad(Pr) que evalúa la sensibilidad en la percepción de uno mismo en relación con los demás y la propia imagen.";
$final_text_pr .= $register['id_client']." obtuvo una puntuación en el percentil ".$value_pr.". Este resultado ".$text_pr;

$value_irpsi = $irpsis["$Pirp"];
$text_irpsi = "";
if ($value_irpsi <= 3) {
    $text_irpsi =  "indica una presencia mínima de síntomas psicopatológicos. Los síntomas evaluados por este índice son prácticamente inexistentes o de intensidad muy baja.";
} elseif ($value_irpsi <= 16) {
    $text_irpsi =  "indica una manifestación leve de síntomas asociados a la psicopatología. Los síntomas están presentes pero con una frecuencia e intensidad bajas, que no interfieren significativamente con el funcionamiento diario.";
} elseif ($value_irpsi <= 84) {
    $text_irpsi =  "indica un nivel de síntomas psicopatológicos dentro del rango promedio de la población general. La presencia de síntomas es variable, pero no alcanza niveles clínicamente significativos.";
} elseif ($value_irpsi <= 96) {
    $text_irpsi =  "indica una presencia de síntomas psicopatológicos por encima del promedio, pero sin alcanzar niveles clínicos significativos. Los síntomas son más frecuentes o intensos que en la población general, pero no llegan a ser comparables con una población clínica.";
} else {
    $text_irpsi =  "indica una alta presencia de síntomas psicopatológicos graves que afectan significativamente el funcionamiento. La intensidad de estos síntomas indica una afectación importante y la presencia de un conglomerado de desvalorización, incomprensión, miedo, somatización y hostilidad con ideas de suicidio. En este nivel, los síntomas son comparables a una población clínica, psicopatológica o psiquiátrica.";
}
$final_text_iprsi = "El Índice de riesgo psicopatológico explora la presencia de síntomas cuya probabilidad de aparición e intensidad es baja en la población general no clínica y, por el contrario, alta en la población clínica.";
$final_text_iprsi .= " En este caso, ".$register['id_client']." obtuvo una puntuación en el percentil ".$value_irpsi.", ".$text_irpsi;


$final_text_sint = "";
if ($Pnum_sintomas > 46 && $Pind_intesidad_sintomas > 3.5) {
    $final_text_sint = "Considerar hipótesis de simulación o de fingimiento de síntoma";
} elseif ($Pnum_sintomas <= 4 && $Pind_intesidad_sintomas < 1) {
    $final_text_sint = "Ocultamiento de sintomatología psicopatológica, con sesgo de deseabilidad social o con formas de defensividad";
} else {
    $final_text_sint = "Reporta síntomas genuinos y sinceros";
}
$condicion1 = $value_irpsi >= 97;
$condicion2 = $value_global >= 97;
$array_esc_cli = [$value_pr,$hps["$Phipersenc"],$obs["$Pobs_comp"],$value_an,$value_hs,$sms["$Psomatizacion"],$des["$Pdepresion"],$sus["$Palsuenio"],$value_su_a];
$count_esc_cli = 0;
foreach ($array_esc_cli as $value) {
    if($value>=97){
        $count_esc_cli+=1;
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
							<div id="contenido1" class="card card-lsb5">
								<div class="card-body">
                                    <div class="row row-sm">
                                        <div class="col-12 col-md-3 col-lg-2 img-container">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/perfil-sf.png?v=<?=VERSION_CODE?>">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/logolsb5.jpeg?v=<?=VERSION_CODE?>">
                                        </div>
                                        <div class="col-12 col-md-9 col-lg-10">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Id</span>
                                                        </div><input class="form-control" style="color: black;" value="<?=$register['id_client']?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Edad</span>
                                                        </div><input class="form-control" style="text-align: center;color: black;" value="<?=$register['age']?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Sexo</span>
                                                        </div><input class="form-control" style="text-align: center;color: black;" value="<?=$register['sex']?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red">Fecha</span>
                                                        </div><input class="form-control" style="text-align: center;color: black;" value="<?= date('Y-m-d H:i:s'); ?>" type="text"/>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red" id="basic-addon1">Baremo</span>
                                                        </div>
                                                        <form action="result2.php" method="post" id="form_baremo" style="margin:0;">
                                                            <input type="hidden" name="id_user" id="id_user" value="<?=$idClient?>">
                                                            <input type="hidden" name="id_register" id="id_register" value="<?=$register['id']?>">
                                                            <select style="margin:0px;border-radius: 15px;height: 35px;color: black;" class="form-control mg-t-20 select2-no-search" id="baremo_id" name="baremo_id">
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
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text setting-input">
                                                            <span class="input-group-text setting-input color-red" id="basic-addon1">Evaluador</span>
                                                        </div><input style="color: black;" class="form-control" value="<?=$register['evaluador']?>" type="text">
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-lg-12">
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
                                <div class="card-body">
                                   <div class="row row-sm">
                                        <div class="col-md-6" style="padding-right:0px;">
                                            <div class="card-body" style="padding-right: 0px;padding-left: 0px;">
                                                <div style="margin-bottom: 75px;">
                                                    <div class="table-responsive">
                                                        <table class="table mg-b-0 text-md-nowrap">
                                                            
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    
                                                                    <td class="td_fill"><div class="borde-text">Escala de validez</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Min</div>Minimacion</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pmin,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$mins["$Pmin"]?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Mag</div>Magnificacion</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pmag,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$mags["$Pmag"]?></div></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table mg-b-0 text-md-nowrap" style="margin-top:5px">
                                                            
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill"><div class="borde-text">Indices generales</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Global</div>Índice Global de severidad</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pind_global_sev,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$globals["$Pind_global_sev"]?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Num</div>Número de síntomas presentes</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pnum_sintomas,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$nums["$Pnum_sintomas"]?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Int</div>Índice de intensidad de síntomas presentes</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pind_intesidad_sintomas,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$ints["$Pind_intesidad_sintomas"]?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table mg-b-0 text-md-nowrap" style="margin-top:5px">
                                                            
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill"><div class="borde-text">Escalas clinicas</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Pr</div>Psicoreactividad</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Ppsicoreactividad,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$prs["$Ppsicoreactividad"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Hp</div>Hipersensibilidad</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Phipersenc,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$hps["$Phipersenc"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Op</div>Obsesión-Compulsión</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pobs_comp,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$obs["$Pobs_comp"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">An</div>Ansiedad</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Panciedad,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$ans["$Panciedad"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Hs</div>Hostilidad</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Phostilidad,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$hss["$Phostilidad"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Sm</div>Somatización</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Psomatizacion,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$sms["$Psomatizacion"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">De</div>Depresión</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pdepresion,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$des["$Pdepresion"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Su</div>Alteración de sueño</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Palsuenio,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$sus["$Palsuenio"]?></td>
                                                                </tr>

                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">Su-a</div>Alteración de sueño ampliada</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Palsuenio_ampl,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$suas["$Palsuenio_ampl"]?></td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                        <table class="table mg-b-0 text-md-nowrap" style="margin-top:15px">
                                                           
                                                            <tbody style="text-align: right;text-align: center;">
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill"><div class="borde-text">Índices de riesgo patológico</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PD</div></td>
                                                                    <td class="td_valuepd2" style="width: 70px;"><div class="borde-text">PC</div></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td  class="td_fill"><div class="width-move">IRPsi</div>Índice de riesgo psicopatológico</td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=number_format($Pirp,2)?></div></td>
                                                                    <td class="td_valuepd2"><div class="borde-lsb5"><?=$irpsis["$Pirp"]?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>          
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left:0px;">
                                            <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="ht-100 ht-sm-300" style="margin-top: 15px;height: 520px !important;width: 100%;" id="colorss"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 15px;height: 87px !important;width: 100%;" id="colorss2"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 10px;height: 80px !important;" id="flotLine2"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 10px;height: 100px !important;" id="flotLineIndGeneral"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 10px;height: 250px !important;" id="flotLineEscalasClinicas"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 20px;height: 60px !important;" id="flotLineIndRiesgoPat"></div>
                                                <p class="mg-t-20" style="text-align: right;">Nota Pc: (Percentil), escala ordinal.</p>
                                            </div>
                                        </div>
                                   </div>
                                    
                                </div>
                            </div>
                            

                        </div>
						
                        <div class="col-md-12">
                            <div id="contenido3" class="card card-body" style="padding-bottom: 100px;text-align: justify;">
                                <div class="main-content-label mg-b-5">
                                    <h1 style="text-align: center;">INFORME CUALITATIVO LSB-50</h1>
                                </div>
                                <div class="card-body">
                                    <h4 class="tx-15">INTRODUCCIÓN</h4>
                                    <p class="tx-dark mb-0 tx-13">El LSB-50 (Listado de Síntomas Breve) es un instrumento de evaluación psicopatológica diseñado para proporcionar información sobre las variables clínicas de la persona evaluada. El presente informe ha sido creado con el objetivo de facilitar la interpretación de los resultados obtenidos a partir de sus respuestas y puntuaciones en el LSB-50.</p>
                                </div>
                                <div class="card-body ">
                                    <h4 class="tx-15">VALIDEZ DEL PERFIL</h4>
                                    <p class="tx-dark mb-0 tx-13">El LSB-50 incluye dos escalas de validez diseñadas para detectar posibles sesgos de respuesta que podrían afectar la interpretación de los resultados: <br>
                                    <?=$final_text_min?> <br><br>
                                    <?=$final_text_mag?>
                                    </p>
                                </div>
                                <div class="card-body">
                                        <h4 class="tx-15">ÍNDICES GENERALES</h4>
                                        <p class="tx-dark mb-0 tx-13">Los índices generales en el LSB-50 son medidas que proporcionan una visión global del nivel de sufrimiento psicopatológico del evaluado(a). En este caso, sus resultados indican que:<br>
                                        <?=$final_text_global?> <br><br>
                                        <?=$final_text_num?><br><br>
                                        <?=$final_text_int?><br><br>
                                        A continuación, se presentan los resultados obtenidos en las escalas clínicas del LSB-50. Estas escalas proporcionan información sobre diferentes dimensiones psicopatológicas, permitiendo así comprender el perfil sintomático específico del evaluado(a). La interpretación de estas escalas nos ayudará a identificar las áreas de mayor relevancia clínica y a entender la forma particular en que se manifiesta el malestar psicológico en este caso. Se describen 4 escalas destacadas en sus resultados, las cuales, en conjunto, ofrecen una visión integral del cuadro clínico presentado.
                                        <br><br>
                                        <?=$final_text_an?><br><br>
                                        <?=$final_text_hs?><br><br>
                                        <?=$final_text_sua?><br><br>
                                        <?=$final_text_pr?><br><br>
                                        <?=$final_text_iprsi?><br><br>
                                        </p>
                                </div>
                                <div class="card-body ">
                                        <h4 class="tx-15">Posible Simulación de síntoma, considerar las siguientes puntuaciones (NUM>46 Y INT>3,5)</h4>
                                        <p class="tx-dark mb-0 tx-13">
                                        <?=$final_text_sint?>
                                        </p>
                                </div>
                                <div class="card-body">
                                        <h4 class="tx-15">Síntomas individuales </h4>
                                        <p class="tx-dark mb-0 tx-13">
                                        <?=$answers_text?><br>
                                        </p>
                                </div>
                                
                            </div>
                            <div style="justify-self: center;position: absolute;bottom: 0px;">
                                    <img id="contenido4"  alt="" class="float-sm-right mg-sm-t-0" style="width:150px" src="../../assets/img/lsb50/image.png">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script>
            var pathprint = "<?php echo LOCALHOST; ?>";
            $(function() {
            'use strict';
                var colorLine = "black";
                var newCust = [
                    [<?=$mins["$Pmin"]?>, 10],
                    [<?=$mags["$Pmag"]?>, 0]
                ];
                
                var plot = $.plot($('#flotLine2'), [{
                    data: newCust,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
                        max: 15,
                        color: 'transparent',
                        ticks: [[0, ''], [15, '']], 
                        tickColor: 'transparent',
                        tickLength: 0,
                        show:false,
                        font: {
                            size: 10,
                            color: '#999'
                        }
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
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
                        position:'top'
                    }
                });

                var flotLineIndGeneral = [
                    [<?=$globals["$Pind_global_sev"]?>, 20],
                    [<?=$nums["$Pnum_sintomas"]?>, 10],
                    [<?=$ints["$Pind_intesidad_sintomas"]?>, 0]
                ];
                
                var plot = $.plot($('#flotLineIndGeneral'), [{
                    data: flotLineIndGeneral,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
                        font: {
                            size: 10,
                            color: 'transparent'
                        },
                        position:'top',
                        show:false
                    }
                });
                var flotLineEscalasClinicas = [
                    [<?=$prs["$Ppsicoreactividad"]?>, 80],
                    [<?=$hps["$Phipersenc"]?>, 70],
                    [<?=$obs["$Pobs_comp"]?>, 60],
                    [<?=$ans["$Panciedad"]?>, 50],
                    [<?=$hss["$Phostilidad"]?>, 40],
                    [<?=$sms["$Psomatizacion"]?>, 30],
                    [<?=$des["$Pdepresion"]?>, 20],
                    [<?=$sus["$Palsuenio"]?>, 10],
                    [<?=$suas["$Palsuenio_ampl"]?>, 0]
                ];
                
                var plot = $.plot($('#flotLineEscalasClinicas'), [{
                    data: flotLineEscalasClinicas,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
            
                var flotLineIndRiesgoPat = [
                    [<?=$irpsis["$Pirp"]?>, 6]
                ];
                
                var plot = $.plot($('#flotLineIndRiesgoPat'), [{
                    data: flotLineIndRiesgoPat,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
                        position:'bottom'
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
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
                        color: 'black',
                        ticks: [[0, ''], [85, '']], 
                        tickColor: 'black',
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        show:false
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 99,
                        tickColor: 'black',
                        font: {
                            size: 10,
                            color: 'black'
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
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
                                xaxis: { from: 0, to: 3 },
                                color: '#c6d5ec'
                            },
                            {
                                xaxis: { from: 3, to: 16 }, 
                                color: '#95b4dd'
                            }
                            ,
                            {
                                xaxis: { from: 16, to: 85 }, 
                                color: '#40ab96'
                            }
                            ,
                            {
                                xaxis: { from: 84, to: 97 }, 
                                color: '#fee1bb'
                            }
                            ,
                            {
                                xaxis: { from: 97, to: 99 }, 
                                color: '#fef0db'
                            },
                            { // Línea punteada en X = 50
                                xaxis: { from: 50, to: 50 },
                                color: '#000', // color de la línea
                                lineWidth: 0.5
                            },
                            { // Línea horizontal en y = 6
                                yaxis: { from: 10.3, to: 10.3 },
                                color: 'white', // color rojo
                                lineWidth: 1
                            },
                            { // Línea horizontal en y = 6
                                yaxis: { from: 7.7, to: 7.7 },
                                color: 'white', // color rojo
                                lineWidth: 1
                            }
                            ,
                            { // Línea horizontal en y = 6
                                yaxis: { from: 1.1, to: 1.1 },
                                color: 'white', // color rojo
                                lineWidth: 1
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

                var colores = $.plot($('#colorss2'), [{
                    data: [],
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 3
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:1.5
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
                                xaxis: { from: 84, to: 94 }, 
                                color: 'rgba(13, 165, 140, 0.26)'
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
        setTimeout(function() {
            document.getElementById('colorss2').style.position = 'absolute';
        }, 1000);
        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });
        </script>
	</body>
</html>