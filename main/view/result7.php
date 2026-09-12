<?php
include_once('../configs.php');
// MCMI IV Result View
session_start();
require '../../vendor/autoload.php';

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");
include("../models/mcmi/model_mcmi_configuration.php");

$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$mcmiConfig = new ModelMcmiConfiguration();

$idClient = 0;
$idpatient = 0;

$device = $registerModel->getDeviceType();
if ($device === 'mobile') {
    include("../include/no_permit.php");
    exit;
}

if (!isset($_SESSION['REST_type_user'])) {
    header("Location: " . LOCALHOST . "/signin.php");
    exit;
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

if ($_SESSION['REST_type_user'] == 'Administrador' && isset($_GET['client']) && isset($_GET['patient'])) {
    $idClient = $_GET['client'];
    $idpatient = $_GET['patient'];
}

if ($_SESSION['REST_type_user'] == 'CLIENTE' && isset($_GET['patient'])) {
    $idClient = $_SESSION['REST_id_user'];
    $idpatient = $_GET['patient'];
}

$register = $registerModel->getById($idClient, $idpatient);
$inputRegister = $registerModel->getInputMcmmiById($idpatient);
//echo json_encode($register);
if ($register == null) {
    echo "<script>
			alert('FALLO DE ACCESO CODIGO #876 - " . $idpatient . " redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
    exit;
}

$baremos = $baremoModel->getAll($register['id_type_question']);
$baremo_name = "";
foreach ($baremos as $baremo) {
    if ($register['baremo_id'] == $baremo['id']) {
        $baremo_name = htmlspecialchars($baremo['name']);
    }
}
$answers = $answerModel->getAll($register['codes']);

// Calculate MCMI-IV scores and interpretation
$results = $mcmiConfig->score($answers, $register['baremo_id']);
//echo json_encode($results);
$raw_scores = $results['raw_scores'];
$initial_tbs = $results['initial_tbs'];
$adjustments = $results['adjustments'];
$final_tbs = $results['final_tbs'];
$percentiles = $results['percentiles'];
$facets_tb = $results['facets_tb'] ?? [];

$report = $results['report'];
$invalidez = $results['invalidez'];
$inconsistencia = $results['inconsistencia'];

$scale_names = [
    'X' => 'Sinceridad',
    'Y' => 'Deseabilidad social',
    'Z' => 'Devaluación',
    '1' => 'Esquizoide',
    '2A' => 'Evitativo',
    '2B' => 'Melancólico',
    '3' => 'Dependiente',
    '4A' => 'Histriónico',
    '4B' => 'Tempestuoso',
    '5' => 'Narcisista',
    '6A' => 'Antisocial',
    '6B' => 'Sádico',
    '7' => 'Compulsivo',
    '8A' => 'Negativista',
    '8B' => 'Masoquista',
    'S' => 'Esquizotípico',
    'C' => 'Límite',
    'P' => 'Paranoide',
    'A' => 'Ansiedad generalizada',
    'H' => 'Síntomas somáticos',
    'N' => 'Espectro bipolar',
    'D' => 'Depresión persistente',
    'B' => 'Consumo de alcohol',
    'T' => 'Consumo de drogas',
    'R' => 'Estrés postraumático',
    'SS' => 'Espectro esquizofrénico',
    'CC' => 'Depresión mayor',
    'PP' => 'Delirante'
];

$scale_categories = [
    'Índices modificadores' => ['X', 'Y', 'Z'],
    'Patrones clínicos de la personalidad' => ['1', '2A', '2B', '3', '4A', '4B', '5', '6A', '6B', '7', '8A', '8B'],
    'Patología grave de la personalidad' => ['S', 'C', 'P'],
    'Síndromes clínicos' => ['A', 'H', 'N', 'D', 'B', 'T', 'R'],
    'Síndromes clínicos graves' => ['SS', 'CC', 'PP']
];
$top_scales = [
    '1' => ['1.1', '1.2', '1.3'],
    '2A' => ['2A.1', '2A.2', '2A.3'],
    '2B' => ['2B.1', '2B.2', '2B.3'],
    '3' => ['3.1', '3.2', '3.3'],
    '4A' => ['4A.1', '4A.2', '4A.3'],
    '4B' => ['4B.1', '4B.2', '4B.3'],
    '5' => ['5.1', '5.2', '5.3'],
    '6A' => ['6A.1', '6A.2', '6A.3'],
    '6B' => ['6B.1', '6B.2', '6B.3'],
    '7' => ['7.1', '7.2', '7.3'],
    '8A' => ['8A.1', '8A.2', '8A.3'],
    '8B' => ['8B.1', '8B.2', '8B.3'],
    'S' => ['S.1', 'S.2', 'S.3'],
    'C' => ['C.1', 'C.2', 'C.3'],
    'P' => ['P.1', 'P.2', 'P.3']
];
$initial_tbs_result = [];

foreach ($top_scales as $key => $value) {
    if (isset($top_scales[$key])) {
        $initial_tbs_result[$key] = $initial_tbs[$key];
    }
}

arsort($initial_tbs_result);
$initial_tbs_result = array_slice($initial_tbs_result, 0, 3, true);

$facet_categories = [
    '1' => ['1.1', '1.2', '1.3'],
    '2A' => ['2A.1', '2A.2', '2A.3'],
    '2B' => ['2B.1', '2B.2', '2B.3'],
    '3' => ['3.1', '3.2', '3.3'],
    '4A' => ['4A.1', '4A.2', '4A.3'],
    '4B' => ['4B.1', '4B.2', '4B.3'],
    '5' => ['5.1', '5.2', '5.3'],
    '6A' => ['6A.1', '6A.2', '6A.3'],
    '6B' => ['6B.1', '6B.2', '6B.3'],
    '7' => ['7.1', '7.2', '7.3'],
    '8A' => ['8A.1', '8A.2', '8A.3'],
    '8B' => ['8B.1', '8B.2', '8B.3'],
    'S' => ['S.1', 'S.2', 'S.3'],
    'C' => ['C.1', 'C.2', 'C.3'],
    'P' => ['P.1', 'P.2', 'P.3']
];
$top_scales_t = [];

foreach ($initial_tbs_result as $key => $value) {
    if (isset($facet_categories[$key])) {
        $top_scales_t[$key] = $facet_categories[$key];
    }
}

$facet_names = [
    '1.1' => 'Interpers. Desvinculado',
    '1.2' => 'Contenido escaso',
    '1.3' => 'Temperamentalmente apático',
    '2A.1' => 'Interpers. Aversivo',
    '2A.2' => 'Autoimagen alienada',
    '2A.3' => 'Contenido vejatorio',
    '2B.1' => 'Cognitivamente fatalista',
    '2B.2' => 'Autoimagen inútil',
    '2B.3' => 'Temperamentalmente afligido',
    '3.1' => 'Expresivamente pueril',
    '3.2' => 'Interpers. Sumiso',
    '3.3' => 'Autoimagen inepta',
    '4A.1' => 'Expresivamente dramático',
    '4A.2' => 'Interpers. buscador de atención',
    '4A.3' => 'Temperamentalmente inconstante',
    '4B.1' => 'Expresivamente impetuoso',
    '4B.2' => 'Interpers. eufórico',
    '4B.3' => 'Autoimagen sobreestimada',
    '5.1' => 'Interpers. explotador',
    '5.2' => 'Cognitivamente expansivo',
    '5.3' => 'Autoimagen admirable',
    '6A.1' => 'Interpers. irresponsable',
    '6A.2' => 'Autoimagen autónoma',
    '6A.3' => 'Dinámicas de irreflexión (paso al acto)',
    '6B.1' => 'Expresivamente precipitado',
    '6B.2' => 'Interpers. desagradable',
    '6B.3' => 'Arquitectura eruptiva',
    '7.1' => 'Expresivamente disciplinado',
    '7.2' => 'Cognitivamente constreñido',
    '7.3' => 'Autoimagen responsable',
    '8A.1' => 'Expresivamente resentido',
    '8A.2' => 'Autoimagen descontenta',
    '8A.3' => 'Temperamentalmente irritable',
    '8B.1' => 'Autoimagen desmerecedora',
    '8B.2' => 'Arquitectura invertida',
    '8B.3' => 'Temperamentalmente disfórico',
    'S.1' => 'Cognitivamente circunstancial',
    'S.2' => 'Autoimagen disociada',
    'S.3' => 'Contenido caótico',
    'C.1' => 'Autoimagen inestable',
    'C.2' => 'Arquitectura disgregada',
    'C.3' => 'Temperamentalmente lábil',
    'P.1' => 'Expresivamente defensivo',
    'P.2' => 'Cognitivamente desconfiado',
    'P.3' => 'Dinámicas de proyección'
];

// 1. Calculate Código de Puntuaciones Máximas
$clinical_personality_codes = ['1', '2A', '2B', '3', '4A', '4B', '5', '6A', '6B', '7', '8A', '8B'];
$clinical_personality_tbs = [];
foreach ($clinical_personality_codes as $code) {
    $clinical_personality_tbs[$code] = $final_tbs[$code] ?? 0;
}
arsort($clinical_personality_tbs);
$vals = array_values($clinical_personality_tbs);
$large1 = $vals[0] ?? 0;
$large2 = $vals[1] ?? 0;
$large3 = $vals[2] ?? 0;

$code1 = "";
$code2 = "";
$code3 = "";
$excel_order = ['1', '2A', '2B', '3', '4A', '4B', '5', '6A', '6B', '7', '8A', '8B'];
foreach ($excel_order as $code) {
    if ($final_tbs[$code] == $large1 && $code1 === "") {
        $code1 = $code;
    }
}
foreach ($excel_order as $code) {
    if ($final_tbs[$code] == $large2 && $code2 === "") {
        $code2 = $code;
    }
}
foreach ($excel_order as $code) {
    if ($final_tbs[$code] == $large3 && $code3 === "") {
        $code3 = $code;
    }
}

$max_score_code = trim("$code1 $code2 $code3");

// 2. Calculate Ajustes de las Tasas Base
$has_x = false;
$has_ad = false;
foreach ($adjustments as $code => $adj) {
    if (isset($adj['x']) && $adj['x'] != 0) {
        $has_x = true;
    }
    if (isset($adj['ad']) && $adj['ad'] != 0) {
        $has_ad = true;
    }
}
$ajustes_text = "Ninguno";
if ($has_x && $has_ad) {
    $ajustes_text = "X, A/CC";
} elseif ($has_x) {
    $ajustes_text = "X";
} elseif ($has_ad) {
    $ajustes_text = "A/CC";
}

// 3. Process Noteworthy Responses (Respuestas Significativas)
$noteworthy_categories = [
    'Preocupación por su salud' => [7, 41, 57, 113, 120, 146],
    'Alienación interpersonal' => [4, 104, 182, 190],
    'Falta de control emocional' => [27, 36, 45, 56, 72, 80, 127, 177],
    'Potencial conducta autodestructiva' => [14, 32, 34, 39, 59, 78, 101, 107, 114, 126, 151, 164],
    'Maltrato Infantil' => [47, 157],
    'Trastorno de la conducta alimentaria' => [69, 86, 102, 186],
    'Tendencias vengativas' => [22, 37, 100, 103, 111, 136, 167, 178, 192],
    'Abuso de la medicación' => [124, 176],
    'Conductas/tendencias autolesivas' => [40, 181],
    'Explosiones de ira' => [11, 74, 115, 145, 168, 191],
    'TDAH' => [56, 77, 82, 92, 108, 63],
    'Espectro autista' => [92, 119, 138, 163, 165, 179, 190],
];


$noteworthy_by_category = [];
foreach ($noteworthy_categories as $category => $items) {
    $category_items = [];
    foreach ($items as $item_order) {
        foreach ($answers as $answer) {
            //|| solo para 63
            $selectedFind63 = ($answer['item_order'] == $item_order && $answer['response'] == 0 && $item_order == 63);
            $selectedFind = ($answer['item_order'] == $item_order && $answer['response'] == 1 && $item_order != 63 );
            if ($selectedFind) {
                $category_items[] = [
                    'item_order' => $item_order,
                    'question' => $answer['question']
                ];
                break;
            }
            else if($selectedFind63){
                    $category_items[] = [
                    'item_order' => $item_order,
                    'question' => $answer['question']
                ];
                break;
            }
        }
    }
    if (count($category_items) > 0) {
        $noteworthy_by_category[$category] = $category_items;
    }
}


// Helper to draw cell bar charts
function getBarChartCell($type, $tb)
{
    if ($tb === null || $tb === '' || $tb === '-') {
        return '<div class="w-full h-[15px]"></div>';
    }
    $tb_val = floatval($tb);
    if ($type === 'validez') {
        $pct = min(100, max(0, $tb_val));
        return '
        <div class="relative w-full h-[21px]" style="background: linear-gradient(to right, #eaeaea 0%, #eaeaea 35%, #ffff 35%, #ffff 75%, #797979 75%, #797979 100%);">
            <div class="absolute left-[35%] top-0 bottom-0 border-l border-black "></div>
            <div class="absolute left-[75%] top-0 bottom-0 border-l border-black "></div>
            
            <div class="absolute z-1 left-0 top-[6px] bottom-[6px] bg-black" style="width: ' . $pct . '%;"></div>
        </div>';
    } elseif ($type === 'personalidad') {
        $pct = min(100, max(0, ($tb_val / 115) * 100));
        return '
        <div class="relative w-full h-[21px]" style="background: linear-gradient(to right, #fff 0%, #fff 52.17%, #eaeaea 52.17%, #eaeaea 65.22%, #c0c0c0 65.22%, #c0c0c0 73.91%, #797979 73.91%, #797979 100%);">
            <div class="absolute left-[52.17%] top-0 bottom-0 border-l border-black"></div>
            <div class="absolute left-[65.22%] top-0 bottom-0 border-l border-black "></div>
            <div class="absolute left-[73.91%] top-0 bottom-0 border-l border-black "></div>
            <div class="absolute left-0 top-[6px] bottom-[6px] bg-black" style="width: ' . $pct . '%;"></div>
        </div>';
    } elseif ($type === 'psicopatologia') {
        $pct = min(100, max(0, ($tb_val / 115) * 100));
        return '
        <div class="relative w-full h-[21px]" style="background: linear-gradient(to right, #fff 0%, #fff 60%, #c0c0c0 60%, #c0c0c0 70%, #797979 70%, #797979 100%);">
            <div class="absolute left-[60%] top-0 bottom-0 border-l border-black"></div>
            <div class="absolute left-[70%] top-0 bottom-0 border-l border-black"></div>
            <div class="absolute left-0 top-[6px] bottom-[6px] bg-black" style="width: ' . ($pct - 5.5) . '%;"></div>
        </div>';
    } elseif ($type === 'facetas') {
        $pct = min(100, max(0, $tb_val));
        return '
        <div class="relative w-full h-[21px]" style="background: linear-gradient(to right, #fff 0%, #fff 75%, #797979 75%, #797979 100%);">
            <div class="absolute left-[75%] top-0 bottom-0 border-l"></div>
            <div class="absolute left-0 top-[6px] bottom-[6px] bg-black" style="width: ' . $pct . '%;">
            
            </div>
        </div>';
    }
}

function renderScaleRow($type, $code, $scale_names, $raw_scores, $percentiles, $final_tbs)
{
    $name = $scale_names[$code] ?? '';
    $pd = $raw_scores[$code] ?? 0;
    $pc = $percentiles[$code] ?? 0;
    $tb = (int)$final_tbs[$code] ?? 0;

    if ($pd === null || $pd === '' || $pd === '-') {
        $pd_str = '-';
        $pc_str = '-';
        $tb_str = '-';
        $bar_cell = getBarChartCell($type, '-');
    } else {
        $pd_str = $pd;
        $pc_str = $pc;
        $tb_str = $tb;
        $bar_cell = getBarChartCell($type, $tb);
    }

    if ($type === 'validez') {
        return "
        <tr class='border-b border-black text-xs h-[22px]'>
            <td class='border-r-0 border-l border-t border-b border-black px-[2.3rem] text-left text-black'><p class='h-full m-0 p-0 fix-margin'>$name</p></td>
            <td class='border-r border-black text-center text-black pr-2'><p class='h-full m-0 p-0 fix-margin'>$code</p></td>
            <td class='border-r border-black text-center text-black'><p class='h-full m-0 p-0 fix-margin'>$pd_str</p></td>
            <td class='border-r border-black text-center text-black'><p class='h-full m-0 p-0 fix-margin'>$tb_str</p></td>
            <td class='p-0 border-r border-black'>$bar_cell</td>
        </tr>";
    } else {
        return "
        <tr class='border-b border-black text-xs h-[22px]'>
            <td class='border-r-0 border-l border-t border-b border-black px-[2.3rem] text-left text-black'><p class='h-full m-0 p-0 fix-margin'>$name</p></td>
            <td class='border-r border-black text-center text-black  pr-2'><p class='h-full m-0 p-0 fix-margin'>$code</p></td>
            <td class='border-r border-black text-center text-black'><p class='h-full m-0 p-0 fix-margin'>$pd_str</p></td>
            <td class='border-r border-black text-center text-black'><p class='h-full m-0 p-0 fix-margin'>$pc_str</p></td>
            <td class='border-r border-black text-center text-black'><p class='h-full m-0 p-0 fix-margin'>$tb_str</p></td>
            <td class='p-0 border-r border-black'>$bar_cell</td>
        </tr>";
    }
}
$tipo = "una Mujer";
if ($register['sex'] == 'MASCULINO') {
    $tipo = "un Hombre";
}
$asp_interpretacion =  $register['id_client'] . " es " . $tipo . " de " . $register['age'] . "años de edad, con un nivel educativo de " . $inputRegister['estudios'];
$asp_interpretacion .= ". Actualmente se encuentra " . strtolower($inputRegister['estado_civil']);
$asp_interpretacion .= ". Refiere que su principal preocupacion es " . strtolower($inputRegister['one_problem']);
if ($inputRegister['two_problem']) {
    $asp_interpretacion .= ", mientras que su segunda preocupacion es " . strtolower($inputRegister['one_problem']);
}
$asp_interpretacion .= ".";

$p13 = $invalidez;
$p15 = $inconsistencia;
$resultado_1 = '';
if ($p13 < 0 || $p13 > 3 || $p15 < 0 || $p15 > 25) {
    $resultado_1 = "Los indicadores de respuestas aleatorias presentan valores fuera de los límites en que pueden interpretarse, por lo que es necesario revisar la corrección del protocolo antes de proseguir con su interpretación clínica.";
} elseif ($p13 >= 2 && $p15 >= 20) {
    $resultado_1 = "El protocolo debe considerarse inválido a partir de los indicadores de respuestas aleatorias, por lo que no debe llevarse a cabo su interpretación. Las escalas V (Invalidez) y W (Inconsistencia) configuran de manera conjunta un patrón de respuesta compatible con un proceder aleatorio, lo que puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación. En estos casos deben investigarse las posibles causas y, hasta que no se averigüe el motivo de la aleatoriedad, los resultados no deben interpretarse.";
} elseif ($p13 >= 2) {
    $resultado_1 = "El protocolo debe considerarse inválido a partir de los indicadores de respuestas aleatorias, por lo que no debe llevarse a cabo su interpretación. La escala V (Invalidez) presenta una puntuación compatible con un proceder aleatorio frente al contenido del inventario, lo que puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación. En estos casos deben investigarse las posibles causas y, hasta que no se averigüe el motivo de la aleatoriedad, los resultados no deben interpretarse.";
} elseif ($p15 >= 20) {
    $resultado_1 = "El protocolo debe considerarse inválido a partir de los indicadores de respuestas aleatorias, por lo que no debe llevarse a cabo su interpretación. La escala W (Inconsistencia) evidencia discrepancias entre pares de ítems compatibles con un patrón de respuestas contradictorias, lo que puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación. En estos casos deben investigarse las posibles causas y, hasta que no se averigüe el motivo de la aleatoriedad, los resultados no deben interpretarse.";
} elseif ($p15 >= 9 && $p15 <= 19) {
    $resultado_1 = "El protocolo se sitúa en el rango de los considerados cuestionables a partir del indicador de respuestas aleatorias W (Inconsistencia), que evidencia un número llamativo de respuestas contradictorias entre pares de ítems con contenido similar, lo cual sugiere una falta de receptividad al contenido de los ítems por parte del evaluado(a). Entre las causas habituales de tal patrón se incluyen problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, fatiga o una falta de cooperación deliberada; cabe investigar la posible incidencia de tales factores en las respuestas del evaluado(a) y, entretanto, los resultados deben interpretarse con cautela y contrastarse con la información obtenida más allá del inventario, es decir, entrevista clínica, historial psicosocial y otras fuentes, antes de extraer conclusiones definitivas.";
} elseif ($p13 == 1) {
    $resultado_1 = "El protocolo se sitúa en el rango de los considerados cuestionables a partir del indicador de respuestas aleatorias V (Invalidez), que presenta una puntuación que, sin alcanzar el umbral de invalidez, reduce la consistencia general del perfil. Tal patrón puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación; cabe investigar las posibles causas y, entretanto, las elevaciones del perfil deben contrastarse con la información obtenida más allá del inventario, es decir, entrevista clínica, historial psicosocial y otras fuentes, antes de extraer conclusiones definitivas.";
} else {
    $resultado_1 = "El perfil es interpretable: las escalas V (Invalidez) y W (Inconsistencia) no muestran un patrón compatible con respuestas aleatorias, de modo que el perfil puede analizarse a partir de las elevaciones que presenta.";
}

$v12 = $resultado_1; // Contenido de V12
$resultado_2 = '';
if (
    stripos($v12, 'fuera de los límites') !== false ||
    stripos($v12, 'debe considerarse inválido') !== false
) {
    $resultado_2 = '';
} elseif (stripos($v12, 'considerados cuestionables') !== false) {
    $resultado_2 = ' Por tal motivo, las puntuaciones obtenidas y el contenido interpretativo que se desarrolla a continuación deben analizarse con cautela.';
} else {
    $resultado_2 = '';
}
//.......................


$h20 = $raw_scores['X'] ?? null; //pd
$h21 = $raw_scores['Y'] ?? null;; //pd
$i21 = $final_tbs['Y'] ?? null; //tb
$i22 = $final_tbs['Z'] ?? null; //tb
$textoW17 = '';
if ($h20 < 7 || $h20 > 114) {

    $textoW17 = "el perfil debe considerarse inválido a partir de los índices modificadores, dado que la puntuación directa de la escala X (Sinceridad) se sitúa fuera de los límites en que el protocolo resulta clínicamente interpretable. El evaluado(a) ha minimizado o exagerado sus síntomas en una medida tal que los resultados no pueden interpretarse con fiabilidad, por lo que no debe llevarse a cabo la interpretación de las elevaciones del perfil.";
} elseif ($h20 < 21 && $i21 >= 75 && $i22 >= 75) {

    $textoW17 = "el evaluado(a) respondió afirmativamente a ítems que reflejan síntomas y características antitéticos, lo que da lugar a dudas sobre la validez del perfil. Esta configuración, en la que la escala X (Sinceridad) se sitúa en el rango compatible con una posible minimización de los síntomas y las escalas Y (Deseabilidad social) y Z (Devaluación) aparecen simultáneamente elevadas, debe interpretarse con cautela en el resto del perfil. Cabe señalar que tal configuración se observa, en ocasiones, en evaluados con trastornos depresivos graves habitualmente acompañados de agitación.";
} elseif ($h20 > 60 && $i22 >= 75) {

    // Equivale al IF anidado dentro del texto
    if ($h21 < 21) {
        $textoY = "la escala Y (Deseabilidad social) se mantiene baja";
    } elseif ($i21 >= 75) {
        $textoY = "a este patrón se añade una elevación de la escala Y (Deseabilidad social)";
    } else {
        $textoY = "la escala Y (Deseabilidad social) se mantiene en el rango medio";
    }

    $textoW17 =
        "la elevación conjunta de las escalas X (Sinceridad) y Z (Devaluación) configura un perfil de «petición de ayuda», en el que el estilo de respuesta de el evaluado(a) lo hace parecer más alterado psicológicamente de lo que realmente está. La escala X (Sinceridad) se sitúa en el rango de una posible exageración de los síntomas y la elevación de la escala Z (Devaluación) indica la tendencia a menospreciarse o subestimarse manifestando más problemas emocionales y personales de los que un análisis posterior pueda reflejar; "
        . $textoY .
        ". Debe analizarse con detalle las puntuaciones altas no solo para obtener una evaluación más precisa de lo que podría ser un nivel distorsionado de los problemas psicológicos, sino también para determinar si reflejan una petición de ayuda significativa por parte de el evaluado(a).";
}


$textoW18 = '';
if ($h20 < 21 && $h21 < 21 && $i22 >= 75) {

    $textoW18 = "las puntuaciones bajas en las escalas X (Sinceridad) e Y (Deseabilidad social), junto con la puntuación elevada en la escala Z (Devaluación), indican una exageración moderada de los problemas emocionales actuales, los cuales probablemente ya hayan sido solucionados en buena medida; tal configuración no afecta a la validez interpretativa del perfil.";
} elseif ($h20 < 21 && $i21 >= 75) {

    $textoW18 = "la configuración del perfil resulta compatible con un patrón de «falseado-bueno», propio de quienes intentan mostrar la mejor imagen de sí mismos. La puntuación de la escala X (Sinceridad) en el rango de una posible minimización de los síntomas, junto con la elevación de la escala Y (Deseabilidad social), reflejan la tendencia a parecer socialmente agradable, moralmente admirable o emocionalmente equilibrada, lo que indica que el evaluado(a) ha ocultado ciertos aspectos de sus dificultades psicológicas o interpersonales. Resulta pertinente analizar con detenimiento las elevaciones de las escalas Dependiente, Narcisista y Compulsivo, en la medida en que tales escalas tienden a aparecer asociadas a este estilo de respuesta según si el evaluado(a) quiere parecer cooperativo, seguro de sí mismo o responsable; en cambio, no es habitual observar elevaciones en las escalas de patología de la personalidad ni en las de los síndromes clínicos.";
} elseif ($h20 > 60) {

    $textoExtra = $i21 >= 75
        ? ". A tal patrón se añade una elevación de la escala Y (Deseabilidad social) que refleja la tendencia a mostrar una imagen de sí mismo positiva e interesante, mientras que la escala Z (Devaluación) se mantiene en un rango que no afecta a la validez interpretativa del perfil"
        : ". Las escalas Y (Deseabilidad social) y Z (Devaluación) se mantienen, por su parte, en rangos que no añaden distorsiones adicionales en la presentación de sí mismo";

    $textoW18 =
        "la escala X (Sinceridad) se sitúa en el rango de una posible exageración de los síntomas, lo que indica que el evaluado(a) se ha mostrado abierto y autorrevelador, hasta el punto de poder enfatizar o dramatizar sus dificultades personales. Tal estilo de respuesta puede reflejar una tendencia a magnificar el nivel de malestar experimentado, una inclinación caracterológica a quejarse o a la autocompasión, o bien sentimientos de vulnerabilidad extrema asociados a un episodio actual de agitación aguda; cualquiera que sea la causa, las puntuaciones de las escalas, especialmente las de los síndromes clínicos, pueden encontrarse algo exageradas y la interpretación del perfil debe realizarse teniendo en cuenta esta consideración"
        . $textoExtra .
        ". La identificación de este estilo de respuesta resulta clínicamente relevante en sí misma, pues permite al profesional formarse una opinión sobre cuán sincero o realista resulta el evaluado(a) respecto a sus problemas.";
} elseif ($h20 < 21) {

    $textoW18 = "la escala X (Sinceridad) se sitúa en el rango de una posible minimización de los síntomas, lo que indica una conducta reservada al responder, en la que el evaluado(a) tiende a minimizar sus síntomas y a manifestarse de forma poco autorreveladora. Las escalas Y (Deseabilidad social) y Z (Devaluación) se mantienen en rangos que no añaden distorsiones adicionales, si bien las elevaciones del perfil pueden encontrarse atenuadas. La identificación de este estilo de respuesta resulta clínicamente relevante en sí misma, pues permite al profesional formarse una opinión sobre cuán sincero o realista resulta el evaluado(a) respecto a sus problemas.";
} elseif ($i22 >= 75 && $i21 >= 75) {

    $textoW18 = "la elevación de la escala Z (Devaluación) indica la tendencia del evaluado(a) a menospreciarse o subestimarse manifestando más problemas emocionales y personales de los que un análisis posterior pueda reflejar; a tal patrón se añade una elevación de la escala Y (Deseabilidad social), que refleja la tendencia a mostrar una imagen de sí mismo positiva e interesante, mientras que la escala X (Sinceridad) se mantiene en un rango que no afecta a la validez interpretativa del perfil. Debe analizarse con detenimiento las puntuaciones altas para obtener una evaluación más precisa de lo que podría ser un nivel distorsionado de los problemas psicológicos.";
} elseif ($i22 >= 75) {

    $textoW18 = "la elevación de la escala Z (Devaluación) indica la tendencia del evaluado(a) a menospreciarse o subestimarse manifestando más problemas emocionales y personales de los que un análisis posterior pueda reflejar, mientras que las escalas X (Sinceridad) y Y (Deseabilidad social) se mantienen en rangos que no afectan a la validez interpretativa del perfil. Debe analizarse con detenimiento las puntuaciones altas no solo para obtener una evaluación más precisa de lo que podría ser un nivel distorsionado de los problemas psicológicos, sino también para determinar si reflejan una petición de ayuda significativa por parte de el evaluado(a).";
} elseif ($i21 >= 75) {

    $textoW18 = "la elevación de la escala Y (Deseabilidad social) refleja la tendencia del evaluado(a) a parecer socialmente agradable, moralmente admirable o emocionalmente equilibrada; cuanto más alta es la puntuación, más probable resulta que haya ocultado ciertos aspectos de sus dificultades psicológicas o interpersonales, por lo que resulta pertinente contrastar las elevaciones del resto del perfil con la información obtenida más allá del inventario.";
} else {

    $textoW18 = "el evaluado(a) ha respondido a los ítems con sinceridad y de forma abierta. Las escalas X (Sinceridad), Y (Deseabilidad social) y Z (Devaluación) se sitúan en rangos que no introducen sesgos en el estilo de respuesta, sin tendencia a minimizar ni a exagerar los síntomas, sin búsqueda de una imagen socialmente agradable, moralmente admirable o emocionalmente equilibrada, ni indicios de autodevaluación, de modo que el perfil puede analizarse a partir de las elevaciones que presenta.";
}
$w17 = $textoW17;
$w18 = $textoW18;

$textoW19 = strlen(trim($w17)) > 0
    ? trim($w17)
    : trim($w18);

$v12 = $resultado_1;
$w19 = $textoW19;
$resultado_3 = '';
if (
    stripos($v12, 'fuera de los límites') !== false ||
    stripos($v12, 'debe considerarse inválido') !== false
) {
    $resultado_3 = '';
} else {
    $resultado_3 = ' En cuanto al estilo de respuesta, ' . $w19;
}


$resultado_4 = '';
$v12 = $resultado_1;
$sumaAjustesF = 0;
$sumaAjustesG = 0;
foreach ($adjustments as $code => $adj) {
    if (isset($adj['x']) && $adj['x'] != 0) {
        $sumaAjustesF += $adj['x'];
    }
    if (isset($adj['ad']) && $adj['ad'] != 0) {
        $sumaAjustesG += $adj['ad'];
    }
}

// Equivalentes a SUM(Ajustes!F10:F37) y SUM(Ajustes!G10:G37)
$sumaF = $sumaAjustesF;
$sumaG = $sumaAjustesG;

// Equivalentes a Ajustes!G11, G12, G21, G23, G24

$g11 = $adjustments['2A']['ad'];

$g12 = $adjustments['2B']['ad'];
$g21 = $adjustments['8B']['ad'];
$g23 = $adjustments['S']['ad'];
$g24 = $adjustments['C']['ad'];

$resultado_4 = "";

// Equivale al IF principal
if (
    stripos($v12, "fuera de los límites") !== false ||
    stripos($v12, "debe considerarse inválido") !== false
) {

    $resultado_4 = "";
} else {

    if ($sumaF == 0 && $sumaG == 0) {

        $resultado_4 =
            " No se ha realizado ningún ajuste sobre las tasas base del perfil, dado que la puntuación directa de la escala X (Sinceridad) no se sitúa por debajo de 21 ni por encima de 60 y la suma de los puntos de las tasas base de las escalas A (Ansiedad generalizada) y CC (Depresión mayor) que exceden de 75 no alcanza el umbral que justifique su corrección.";
    } else {

        // ===== Ajustes por escala X =====

        if ($sumaF != 0 && $h20 < 21) {
            $resultado_4 .=
                " Sobre los resultados obtenidos, las tasas base de las escalas de los patrones de la personalidad y de los síndromes clínicos se han aumentado en función de la escala X (Sinceridad), a fin de compensar la probable minimización de los síntomas asociada a un estilo de respuesta reservado.";
        }

        if ($sumaF != 0 && $h20 > 60) {
            $resultado_4 .=
                " Sobre los resultados obtenidos, las tasas base de las escalas de los patrones de la personalidad y de los síndromes clínicos se han disminuido en función de la escala X (Sinceridad), a fin de compensar la probable exageración de los síntomas asociada a un estilo de respuesta abierto y autorrevelador.";
        }

        // ===== Ajustes por ansiedad/depresión =====

        if ($sumaG != 0) {

            $resultado_4 .= ($sumaF != 0)
                ? "Asimismo, las tasas base de "
                : " Sobre los resultados obtenidos, las tasas base de ";

            // Escalas afectadas

            if ($g12 != 0 && $g21 != 0 && $g24 != 0) {
                $escalas = "las escalas 2B (Melancólico), 8B (Masoquista) y C (Límite)";
            } elseif ($g12 != 0 && $g21 != 0) {
                $escalas = "las escalas 2B (Melancólico) y 8B (Masoquista)";
            } elseif ($g12 != 0 && $g24 != 0) {
                $escalas = "las escalas 2B (Melancólico) y C (Límite)";
            } elseif ($g21 != 0 && $g24 != 0) {
                $escalas = "las escalas 8B (Masoquista) y C (Límite)";
            } elseif ($g12 != 0) {
                $escalas = "la escala 2B (Melancólico)";
            } elseif ($g21 != 0) {
                $escalas = "la escala 8B (Masoquista)";
            } elseif ($g24 != 0) {
                $escalas = "la escala C (Límite)";
            } else {
                $escalas = "";
            }

            $resultado_4 .=
                $escalas .
                " se han disminuido en función de las escalas A (Ansiedad generalizada) y CC (Depresión mayor); este ajuste se basa en el principio de que las puntuaciones del evaluado(a) pueden estar distorsionadas si, al cumplementar el inventario, se encuentra en un estado emocional de ansiedad o depresión profunda";

            // Escalas adicionales

            if ($g11 != 0 || $g23 != 0) {

                if ($g11 != 0 && $g23 != 0) {
                    $extra = "las escalas 2A (Evitativo) y S (Esquizotípico)";
                } elseif ($g11 != 0) {
                    $extra = "la escala 2A (Evitativo)";
                } else {
                    $extra = "la escala S (Esquizotípico)";
                }

                $resultado_4 .= "; asimismo se aplica sobre " . $extra . ".";
            } else {
                $resultado_4 .= ".";
            }
        }
    }
}

$datosTbFiltrados = [ //i27_i38
    $final_tbs['1'],
    $final_tbs['2A'],
    $final_tbs['2B'],
    $final_tbs['3'],
    $final_tbs['4A'],
    $final_tbs['4B'],
    $final_tbs['5'],
    $final_tbs['6A'],
    $final_tbs['6B'],
    $final_tbs['7'],
    $final_tbs['8A'],
    $final_tbs['8B'],
];

$maximo = max($datosTbFiltrados);
$textoV16 = '';
//AQ185
if ($maximo < 85) {
    $textoV16 = "ninguna de las escalas de los patrones clínicos de la personalidad alcanza una tasa base igual o superior a 60, por lo que el perfil no refleja un patrón de personalidad claro que permita establecer un diagnóstico. Tales elevaciones pueden resultar ideográficamente útiles para formular hipótesis clínicas, si bien no se consideran fiables ni válidas con fines diagnósticos.";
} else {
    $textoV16 = "se observan elevaciones iguales o superiores a 85 en una o más escalas de los patrones clínicos de la personalidad, lo que refleja una patología suficientemente generalizada como para considerarla un trastorno clínico de la personalidad y, en su caso, el umbral propio de la patología grave de la personalidad. Las tres escalas con la puntuación más alta constituyen el código de puntuaciones máximas; al analizarse por separado y en su configuración conjunta, aportan información sustantiva sobre la estructura de polaridades (placer-dolor, pasivo-activo, uno mismo-otros) y sobre los dominios funcionales y estructurales que articulan la matriz personológica del evaluado(a), en la medida en que esta opera como mediador inmunológico entre el estrés psicosocial y la producción de síntomas.";
}
//$textoV16 = "se observan elevaciones con tasas base iguales o superiores a 60 en una o más escalas de los patrones clínicos de la personalidad, lo que indica que las respuestas del evaluado(a) son similares a las de los sujetos de la muestra de tipificación que presentan rasgos de un patrón determinado y posiblemente reflejan estilos adaptativos de la personalidad con problemas moderados u ocasionales en áreas específicas; las elevaciones iguales o superiores a 75 indican tipos de personalidad menos adaptativos con rasgos problemáticos propios del constructo correspondiente, en tanto que las elevaciones iguales o superiores a 85 reflejan una patología suficientemente generalizada como para considerarla un trastorno clínico de la personalidad.";

$v12 = $resultado_1;
$v16 = $textoV16;
$resultado_5 = '';
if (
    stripos($v12, 'fuera de los límites') !== false ||
    stripos($v12, 'debe considerarse inválido') !== false
) {
    $resultado_5 = '';
} else {
    $resultado_5 = ' Sobre esta base, ' . $v16;
}
$resultado_final_1 = $resultado_1;
$resultado_final_1 .= $resultado_2;
$resultado_final_1 .= $resultado_3;
$resultado_final_1 .= $resultado_4;
$resultado_final_1 .= $resultado_5;

$escalas = [
    'B47' => ['nombre' => 'Ansiedad generalizada', 'tb' => $final_tbs['A'] + ($percentiles['A'] / 1000) + ($raw_scores['A'] / 1000000)],
    'B48' => ['nombre' => 'Síntomas somáticos', 'tb' => $final_tbs['H'] + ($percentiles['H'] / 1000) + ($raw_scores['H'] / 1000000)],
    'B49' => ['nombre' => 'Espectro bipolar', 'tb' => $final_tbs['N'] + ($percentiles['N'] / 1000) + ($raw_scores['N'] / 1000000)],
    'B50' => ['nombre' => 'Depresión persistente', 'tb' => $final_tbs['D'] + ($percentiles['D'] / 1000) + ($raw_scores['D'] / 1000000)],
    'B51' => ['nombre' => 'Consumo de alcohol', 'tb' => $final_tbs['B'] + ($percentiles['B'] / 1000) + ($raw_scores['B'] / 1000000)],
    'B52' => ['nombre' => 'Consumo de drogas', 'tb' => $final_tbs['T'] + ($percentiles['T'] / 1000) + ($raw_scores['T'] / 1000000)],
    'B53' => ['nombre' => 'Estrés postraumático', 'tb' => $final_tbs['R'] + ($percentiles['R'] / 1000) + ($raw_scores['R'] / 1000000)],
    'B55' => ['nombre' => 'Espectro esquizofrénico', 'tb' => $final_tbs['SS'] + ($percentiles['SS'] / 1000) + ($raw_scores['SS'] / 1000000)],
    'B56' => ['nombre' => 'Depresión mayor', 'tb' => $final_tbs['CC'] + ($percentiles['CC'] / 1000) + ($raw_scores['CC'] / 1000000)],
    'B57' => ['nombre' => 'Delirante', 'tb' => $final_tbs['PP'] + ($percentiles['PP'] / 1000) + ($raw_scores['PP'] / 1000000)],
];
$escalas_texto = [
    'Ansiedad generalizada' => '300.02 (F41.1) Trastorno de ansiedad generalizada',
    'Síntomas somáticos' => '300.82 (F45.1) Trastorno de síntomas somáticos',
    'Espectro bipolar' => '296.43 (F31.13) Trastorno bipolar',
    'Depresión persistente' => '300.4 (F34.1) Trastorno depresivo persistente (Distimia)',
    'Consumo de alcohol' => '303.90 (F10.20) Trastorno por consumo de alcohol',
    'Consumo de drogas' => '304.30 (F12.20) Trastorno por consumo de sustancias',
    'Estrés postraumático' => '309.81 (F43.10) Trastorno de estrés postraumático',
    'Espectro esquizofrénico' => '295.90 (F20.9) Esquizofrenia',
    'Depresión mayor' => '296.23 (F32.2) Trastorno de depresión mayor',
    'Delirante' => '297.1 (F22) Trastorno delirante',
];

$mejor = null;

foreach ($escalas as $item) {
    if ($item['tb'] >= 85 && $item['tb'] <= 115.999) {

        if ($mejor === null || $item['tb'] >= $mejor['tb']) {
            $mejor = $item;
        }
    }
}

$sincromeClinico_nombre1 = $mejor ? $mejor['nombre'] : "";
$sincromeClinico_informe1 = $mejor ? $escalas_texto[$mejor['nombre']] . "'(Prominente)'" : "";

$filtradas = [];

// Filtrar valores entre 85 y 115.999
foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 85 && $item['tb'] <= 115.999) {
        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}
$segundomejor = "";
if (count($filtradas) < 2) {

    $segundomejor = "";
} else {
    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            return $a['orden'] <=> $b['orden'];
        }
        return $b['tb'] <=> $a['tb'];
    });

    // Segundo valor más alto
    $segundomejor = $filtradas[1]['nombre'];
}
$sincromeClinico_nombre2 = $segundomejor;
$sincromeClinico_informe2 = $segundomejor ? $escalas_texto[$segundomejor] . "'(Prominente)'" : "";

$filtradas = [];
foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 75 && $item['tb'] < 85) {

        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}
$terceromejor = '';
if (count($filtradas) === 0) {

    $terceromejor = "";
} else {

    // Ordenar de mayor a menor
    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            // mantiene el criterio de desempate de Excel
            return $a['orden'] <=> $b['orden'];
        }

        return $b['tb'] <=> $a['tb'];
    });


    // Primer elemento = valor más alto
    $terceromejor = $filtradas[0]['nombre'];
}
$sincromeClinico_nombre3 = $terceromejor;
$sincromeClinico_informe3 = $terceromejor ? $escalas_texto[$terceromejor] . "'(Presente)'" : "";


$valores = [
    $sincromeClinico_informe1,
    $sincromeClinico_informe2,
    $sincromeClinico_informe3,
    $sincromeClinico_nombre1,
    $sincromeClinico_nombre2,
    $sincromeClinico_nombre3,
];

$todasVacias = true;

foreach ($valores as $valor) {
    if (trim((string)$valor) !== '') {
        $todasVacias = false;
        break;
    }
}

$textoSincromeClinico = $todasVacias
    ? "Las tasas base obtenidas en las escalas correspondientes a síndromes clínicos se encuentran por debajo del umbral menores (TB ≥ 75 a 85), por lo que, no se identifica la presencia de un cuadro clínico específico."
    : "";

//--------------------------------
$escalas = [
    'B47' => ['nombre' => 'Esquizoide', 'tb' => $final_tbs['1'] + ($percentiles['1'] / 1000) + ($raw_scores['1'] / 1000000)],
    'B48' => ['nombre' => 'Evitativo', 'tb' => $final_tbs['2A'] + ($percentiles['2A'] / 1000) + ($raw_scores['2A'] / 1000000)],
    'B49' => ['nombre' => 'Melancólico', 'tb' => $final_tbs['2B'] + ($percentiles['2B'] / 1000) + ($raw_scores['2B'] / 1000000)],
    'B50' => ['nombre' => 'Dependiente', 'tb' => $final_tbs['3'] + ($percentiles['3'] / 1000) + ($raw_scores['3'] / 1000000)],
    'B51' => ['nombre' => 'Histriónico', 'tb' => $final_tbs['4A'] + ($percentiles['4A'] / 1000) + ($raw_scores['4A'] / 1000000)],
    'B52' => ['nombre' => 'Tempestuoso', 'tb' => $final_tbs['4B'] + ($percentiles['4B'] / 1000) + ($raw_scores['4B'] / 1000000)],
    'B53' => ['nombre' => 'Narcisista', 'tb' => $final_tbs['5'] + ($percentiles['5'] / 1000) + ($raw_scores['5'] / 1000000)],
    'B55' => ['nombre' => 'Antisocial', 'tb' => $final_tbs['6A'] + ($percentiles['6A'] / 1000) + ($raw_scores['6A'] / 1000000)],
    'B56' => ['nombre' => 'Sádico', 'tb' => $final_tbs['6B'] + ($percentiles['6B'] / 1000) + ($raw_scores['6B'] / 1000000)],
    'B57' => ['nombre' => 'Compulsivo', 'tb' => $final_tbs['7'] + ($percentiles['7'] / 1000) + ($raw_scores['7'] / 1000000)],
    'B58' => ['nombre' => 'Negativista', 'tb' => $final_tbs['8A'] + ($percentiles['8A'] / 1000) + ($raw_scores['8A'] / 1000000)],
    'B59' => ['nombre' => 'Masoquista', 'tb' => $final_tbs['8B'] + ($percentiles['8B'] / 1000) + ($raw_scores['8B'] / 1000000)],
    'B60' => ['nombre' => 'Esquizotípico', 'tb' => $final_tbs['S'] + ($percentiles['S'] / 1000) + ($raw_scores['S'] / 1000000)],
    'B61' => ['nombre' => 'Límite', 'tb' => $final_tbs['C'] + ($percentiles['C'] / 1000) + ($raw_scores['C'] / 1000000)],
    'B62' => ['nombre' => 'Paranoide', 'tb' => $final_tbs['P'] + ($percentiles['P'] / 1000) + ($raw_scores['P'] / 1000000)],
];
$escalas_personalidad = [
    'Esquizoide' => '  301.20 (F60.1) Trastorno de la personalidad esquizoide',
    'Evitativo' => '301.82 (F60.6) Trastorno de la personalidad evitativa',
    'Melancólico' => '301.89 (F60.89)  Otro trastorno de la personalidad especificado (Patrón Melancólico)',
    'Dependiente' => '301.6 (F60.7)	Trastorno de la personalidad dependiente',
    'Histriónico' => '301.50 (F60.4) Trastorno de la personalidad histriónica',
    'Tempestuoso' => '301.89 (F60.89)  Otro trastorno de la personalidad especificado (Patrón Tempestuoso)',
    'Narcisista' => '301.81 (F60.81) Trastorno de la personalidad narcisista',
    'Antisocial' => '301.7 (F60,2) Trastorno de la personalidad antisocial',
    'Sádico' => '301.89 (F60.89)  Otro trastorno de la personalidad especificado (Patrón Sádico)',
    'Compulsivo' => '301.4 (F60.5) Trastorno de la personalidad obsesivo-compulsiva',
    'Negativista' => '301.89 (F60.89)  Otro trastorno de la personalidad especificado (Patrón Negativista)',
    'Masoquista' => '301.89 (F60.89)  Otro trastorno de la personalidad especificado (Patrón Masoquista)',
    'Esquizotípico' => '301.22 (F21)  Trastorno de la personalidad esquizotípica',
    'Límite' => '301.83 (F60.3) Trastorno de la personalidad límite',
    'Paranoide' => '301.0 (F60.0) Trastorno de la personalidad paranoide',
];
$escalas_sintoma = [
    'Esquizoide' => 'Tipo de personalidad esquizoide',
    'Evitativo' => 'Tipo de personalidad evitativa',
    'Melancólico' => 'Tipo de personalidad especificado (Patrón Melancólico)',
    'Dependiente' => 'Tipo de personalidad dependiente',
    'Histriónico' => 'Tipo de personalidad histriónica',
    'Tempestuoso' => 'Tipo de personalidad especificado (Patrón Tempestuoso)',
    'Narcisista' => 'Tipo de personalidad narcisista',
    'Antisocial' => 'Tipo de personalidad antisocial',
    'Sádico' => 'Tipo de personalidad especificado (Patrón Sádico)',
    'Compulsivo' => 'Tipo de personalidad obsesivo-compulsiva',
    'Negativista' => 'Tipo de personalidad especificado (Patrón Negativista)',
    'Masoquista' => 'Tipo de personalidad especificado (Patrón Masoquista)',
    'Esquizotípico' => 'Tipo de personalidad Esquizotípico',
    'Límite' => 'Tipo de personalidad Límite',
    'Paranoide' => 'Tipo de personalidad Paranoide',
];

$filtradas = [];
foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 85 && $item['tb'] <= 115.999) {

        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}
if (count($filtradas) < 1) {

    $transtorno_personalidad_1 = "";
} else {

    // Orden descendente por TB
    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            // Respeta el desempate por posición de fila de Excel
            return $a['orden'] <=> $b['orden'];
        }

        return $b['tb'] <=> $a['tb'];
    });

    // AGGREGATE(...,1) = primer valor más alto
    $transtorno_personalidad_1 = $filtradas[0]['nombre'];
}
$transtorno_personalidad_informe_1 = $transtorno_personalidad_1 ? $escalas_personalidad[$transtorno_personalidad_1] : "";

$filtradas = [];

foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 85 && $item['tb'] <= 115.999) {

        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}


if (count($filtradas) < 2) {

    $transtorno_personalidad_2 = "";
} else {

    // Ordenar de mayor a menor
    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            // Simula el desempate ROW()/10000 de Excel
            return $a['orden'] <=> $b['orden'];
        }

        return $b['tb'] <=> $a['tb'];
    });


    // AGGREGATE(...,2) = segundo valor más alto
    $transtorno_personalidad_2 = $filtradas[1]['nombre'];
}
$transtorno_personalidad_informe_2 = $transtorno_personalidad_2 ? $escalas_personalidad[$transtorno_personalidad_2] : "";

$filtradas = [];

foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 85 && $item['tb'] <= 115.999) {

        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}


if (count($filtradas) < 3) {

    $transtorno_personalidad_3 = "";
} else {

    // Ordenar de mayor a menor
    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            // Simula ROW()/10000 de Excel
            return $a['orden'] <=> $b['orden'];
        }

        return $b['tb'] <=> $a['tb'];
    });


    // AGGREGATE(...,3)
    // Tercer valor más alto
    $transtorno_personalidad_3 = $filtradas[2]['nombre'];
}
$transtorno_personalidad_informe_3 = $transtorno_personalidad_3 ? $escalas_personalidad[$transtorno_personalidad_3] : "";

$filtradas = [];

foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 75 && $item['tb'] < 85) {

        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}


if (count($filtradas) < 1) {

    $transtorno_sintoma_1 = "";
} else {

    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            // Simula ROW()/10000 de Excel
            return $a['orden'] <=> $b['orden'];
        }

        return $b['tb'] <=> $a['tb'];
    });

    $transtorno_sintoma_1 = $filtradas[0]['nombre'];
}

$transtorno_sintoma_informe_1 = $transtorno_sintoma_1 ? $escalas_sintoma[$transtorno_sintoma_1] : "";

$filtradas = [];

foreach ($escalas as $index => $item) {

    if ($item['tb'] >= 60 && $item['tb'] < 75) {

        $filtradas[] = [
            'nombre' => $item['nombre'],
            'tb' => $item['tb'],
            'orden' => $index
        ];
    }
}

if (count($filtradas) < 1) {

    $transtorno_sintoma_2 = "";
} else {

    // Ordenar de mayor a menor TB
    usort($filtradas, function ($a, $b) {

        if ($a['tb'] == $b['tb']) {
            // Equivalente al ROW()/10000 usado en Excel
            return $a['orden'] <=> $b['orden'];
        }

        return $b['tb'] <=> $a['tb'];
    });

    $transtorno_sintoma_2 = $filtradas[0]['nombre'];
}
$transtorno_sintoma_informe_2 = $transtorno_sintoma_2 ? $escalas_sintoma[$transtorno_sintoma_2] : "";

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= WEB_TITLE ?> - Resultados MCMI-IV</title>
    <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.css?v=<?= VERSION_CODE ?>" rel="stylesheet">

    <!-- Bootstrap css -->

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
    <link href="../../assets/css/style_result7.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/tailwind.css">

    <style>
        @media (min-width: 1536px) {
            .container {
                max-width: 1200px !important;
            }
        }

        svg {
            display: inline !important;
        }

        .main-content {
            background: white;
        }
    </style>
</head>

<body class="main-body">
    <div id="global-loader">
        <img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>

    <div class="page <?= TESTING == '1' ? 'istesting' : '' ?>">
        <?php include("../include/header_top.php"); ?>
        <?php include("../include/header_bottom.php"); ?>

        <div class="main-content horizontal-content">
            <br>
            <div class="container">
                <div class="row row-sm container-short">
                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12 hidden">
                        <div id="contenidoPortada">
                            <div class="h-6 bg-[#0054a6] w-full mb-1"></div>
                            <div class="flex justify-between pt-4 pb-4">
                                <img width="400" src="../../assets/img/test_image/mcmmi.png?v=<?= VERSION_CODE ?>" class="img-logo">
                            </div>
                            <div class="border-b-2 border-[#0054a6] mt-1 mb-4"></div>
                        </div>
                        <div class="flex justify-between items-end text-[17px] text-black leading-tight">
                            <div class="text-[17px] text-black">
                                <div class="mb-2"><?= $register['type_question_name'] ?></div>
                                <div class="mb-2">Millon* Clinical Multiaxial Inventory-IV</div>
                                <div class="mb-2">Interpretive Report</div>
                                <div class="mb-4">Theodore Millon, PhD, DSc</div>
                                <div class="font-bold mb-2">Nombre: <span class="font-normal"><?= htmlspecialchars($register['id_client']) ?></span></div>
                                <div class="font-bold mb-2">Número de C.I: <span class="font-normal"><?= htmlspecialchars($inputRegister['ci']) ?></span></div>
                                <div class="font-bold mb-2">Edad: <span class="font-normal"><?= htmlspecialchars($register['id_client']) ?></span></div>
                                <div class="font-bold mb-2">Sexo: <span class="font-normal"><?= $register['sex'] ?></span></div>
                                <div class="font-bold mb-2">Ambito: <span class="font-normal"><?= htmlspecialchars($inputRegister['ambito']) ?></span></div>
                                <div class="font-bold mb-2">Estudios: <span class="font-normal"><?= htmlspecialchars($inputRegister['estudios']) ?></span></div>
                                <div class="font-bold mb-2">Región: <span class="font-normal"><?= htmlspecialchars($inputRegister['region']) ?></span></div>
                                <div class="font-bold mb-2">Estado civil: <span class="font-normal"><?= htmlspecialchars($inputRegister['estado_civil']) ?></span></div>
                                <div class="font-bold mb-2">Fecha de evaluación: <span class="font-normal"><?= date("d/m/Y", strtotime($register['date_create'])) ?></span></div>
                                <div class="font-bold mb-2 flex items-center gap-3">Baremo: <span class="font-normal whitespace-nowrap">
                                        <form action="result2.php" method="post" id="form_baremo" class="flex-1">
                                            <input type="hidden" name="id_user" id="id_user" value="<?= $idClient ?>">
                                            <input type="hidden" name="id_register" id="id_register" value="<?= $register['id'] ?>">
                                            <select class="field max-left" id="baremo_id" name="baremo_id">
                                                <?php
                                                foreach ($baremos as $baremo) {
                                                ?>
                                                    <option value="<?= $baremo['id'] ?>" <?= $baremo['active'] == '0' ? 'disabled' : '' ?> <?= $register['baremo_id'] == $baremo['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($baremo['name']) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </form>
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <img width="200" src="../../assets/img/test_image/mcmmi-folder.jpg?v=<?= VERSION_CODE ?>" class="img-logo">
                                </div>
                                <div class="mb-2">
                                    Copyright @ 2015 DICANDRIEN, Inc. All rights reserved.
                                </div>
                                <div class="mb-2">
                                    Pearson, the PSI logo, and PsychCorp are trademarks in the U.S. and/or other countries of Pearson Education, Inc., or its affiliate(s). MCMI
                                </div class="mb-2">
                                <div class="mb-2">
                                    and MIllon are registered trademarks of DICANDRIEN, Inc. DSM-5 is a registered trademark of the American Psychiatric Association.
                                </div>
                                <div class="mb-2">
                                    TRADE SECRET INFORMATION
                                </div class="mb-2">
                                <div class="mb-2">
                                    Not for release under HIPAA or other data disclosure laws that exempt trade secrets from disclosure.
                                </div>
                                <div class="mb-2">
                                    [1.0/RE1/QG1]
                                </div>
                                <div>

                                </div>
                                <div>
                                    <img src="../../assets/img/test_image/mcmmi-line.jpg?v=<?= VERSION_CODE ?>" class="img-logo">
                                    <br>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <div id="contenidoID">
                            <div class="h-6 bg-[#0054a6] w-full mb-1"></div>
                            <div class="flex justify-between items-end text-sm text-black leading-tight">
                                <div class="fix-margin">
                                    <div><?= $register['type_question_name'] ?> Informe</div>
                                    <div><?= date("d/m/Y", strtotime($register['date_create'])) ?></div>
                                </div>
                                <div class="text-right fix-margin">
                                    <div><?= $register['type_question_name'] ?></div>
                                    <?= htmlspecialchars($register['id_client']) ?>
                                </div>
                            </div>
                            <div class="border-b-2 border-[#0054a6] mt-1 mb-4"></div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12" style="padding-top:10px;padding-left: 0px;padding-right: 0px;">

                        <!-- PAGE 3: RESUMEN DE LAS PUNTUACIONES Y PERFIL -->
                        <div class="font-sans">
                            <!-- Top header banner -->
                            <div id="contenido2" class="pb-4">
                                <h1 class="text-center font-bold text-lg text-black uppercase tracking-wide leading-none mt-2">Inventario Clínico Multiaxial de Millon-IV</h1>
                                <h2 class="text-center font-bold text-[13px] text-black uppercase tracking-wide mt-1">Resumen de las Puntuaciones y Perfil</h2>

                                <div class="flex justify-between text-sm text-black font-sans mt-4 leading-tight">
                                    <div>
                                        <div>CÓDIGO DE PUNTUACIONES MÁXIMAS = <span><?= $max_score_code ?></span></div>
                                        <div>AJUSTES DE LAS TASAS BASE = <span><?= $ajustes_text ?></span></div>
                                    </div>
                                    <div class="text-right">
                                        <div>INVALIDEZ (V) = <span><?= $invalidez ?></span></div>
                                        <div>INCONSISTENCIA (W) = <span><?= $inconsistencia ?></span></div>
                                    </div>
                                </div>
                            </div>


                            <!-- VALIDEZ Table -->
                            <div id="contenido3">
                                <table class="w-full border-collapse border-1 border-black mb-4 font-sans">
                                    <thead>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black-100 text-left px-4 py-1 w-[36.5%] uppercase font-bold text-black align-middle">
                                                <p class="h-full m-0 p-0 fix-margin">Validez</p>
                                            </th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-1 w-20 font-bold"></th>
                                            <th class="border-1 border-black text-center py-1 w-60 font-bold" colspan="2">
                                                <div class="relative w-full h-[28px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="justify-items-center top-0 font-bold ">Puntuación</div>
                                                    <div class="absolute left-[18%] top-[14px] -translate-x-1/2 font-semibold">PD</div>
                                                    <div class="absolute left-[50%] top-[14px] -translate-x-1/2 font-semibold">PC</div>
                                                    <div class="absolute left-[86%] top-[14px] -translate-x-full font-semibold">TB</div>
                                                </div>
                                            </th>
                                            <th class="border-1 border-black text-center py-1 font-bold">
                                                <div class="h-full fix-margin">
                                                    Perfil de las tasas base
                                                    <div class="relative w-full h-[12px] font-sans text-xs text-black select-none">
                                                        <div class="absolute left-0 top-0 font-bold">0</div>
                                                        <div class="absolute left-[35%] top-0 -translate-x-1/2 font-bold">35</div>
                                                        <div class="absolute left-[75%] top-0 -translate-x-1/2 font-bold">75</div>
                                                        <div class="absolute left-[100%] top-0 -translate-x-full font-bold">100</div>
                                                    </div>
                                                </div>

                                            </th>
                                        </tr>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black text-left w-[36.5%] px-4 py-0.5 font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Índices modificadores</p>
                                            </th>
                                            <th class="border-l-0 border-r-0 border-t border-b border-black text-center py-1 w-20 font-bold"></th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-0.5 w-[12%]" colspan="2"></th>
                                            <th class="border-1 border-black p-1 w-full">
                                                <div class="relative w-full h-[18px] font-sans text-xs text-black select-none fix-margin">

                                                    <div class="absolute left-[17.5%] top-[1px] -translate-x-1/2 font-semibold">Bajo</div>
                                                    <div class="absolute left-[57.5%] top-[1px] -translate-x-1/2 font-semibold">Medio</div>
                                                    <div class="absolute left-[88.5%] top-[1px] -translate-x-full font-semibold">Alto</div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?= renderScaleRow('validez', 'X', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                        <?= renderScaleRow('validez', 'Y', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                        <?= renderScaleRow('validez', 'Z', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="contenido4">
                                <table class="w-full border-collapse border border-black mb-4 font-sans">
                                    <thead>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black border-black text-left px-4 py-1 w-[30%] uppercase font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Personalidad</p>
                                            </th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-1 w-20 font-bold"></th>
                                            <th class="border-1 border-black text-center py-1 w-60 font-bold" colspan="3">
                                                <div class="relative w-full h-[28px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="justify-items-center top-0 font-bold">Puntuación</div>
                                                    <div class="absolute left-[18%] top-[14px] -translate-x-1/2 font-semibold">PD</div>
                                                    <div class="absolute left-[50%] top-[14px] -translate-x-1/2 font-semibold">PC</div>
                                                    <div class="absolute left-[86%] top-[14px] -translate-x-full font-semibold">TB</div>
                                                </div>
                                            </th>
                                            <th class="border-1 border-black text-center py-1 w-full font-bold">
                                                <div class="h-full fix-margin">
                                                    Perfil de las tasas base
                                                    <div class="relative w-full h-[12px] font-sans text-xs text-black select-none">
                                                        <div class="absolute left-0 top-0 font-bold">0</div>
                                                        <div class="absolute left-[52.17%] top-0 -translate-x-1/2 font-bold">60</div>
                                                        <div class="absolute left-[65.22%] top-0 -translate-x-1/2 font-bold">75</div>
                                                        <div class="absolute left-[73.91%] top-0 -translate-x-1/2 font-bold">85</div>
                                                        <div class="absolute left-[100%] top-0 -translate-x-full font-bold">115</div>
                                                    </div>
                                                </div>

                                            </th>
                                        </tr>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black border-black text-left px-4 py-0.5 font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Patrones clínicos de la personalidad</p>
                                            </th>
                                            <th class="border-l-0 border-r-0 border-t border-b border-black text-center py-0.5"></th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-0.5 w-[18%]" colspan="3"></th>
                                            <th class="border-1 border-black p-1 w-full">
                                                <div class="relative w-full h-[18px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="absolute left-[58.7%] top-[1px] -translate-x-1/2 font-semibold">Estilo</div>
                                                    <div class="absolute left-[69.57%] top-[1px] -translate-x-1/2 font-semibold">Tipo</div>
                                                    <div class="absolute left-[91.95%] top-[1px] -translate-x-full font-semibold">Trastorno</div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $scales = ['1', '2A', '2B', '3', '4A', '4B', '5', '6A', '6B', '7', '8A', '8B'];
                                        foreach ($scales as $code) {
                                            echo renderScaleRow('personalidad', $code, $scale_names, $raw_scores, $percentiles, $final_tbs);
                                        }
                                        ?>
                                        <tr class="bg-white-100  text-xs">
                                            <td colspan="6" class="border-1 border-black px-4 py-0.5 font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Patología grave de la personalidad</p></td>
                                        </tr>
                                        <?= renderScaleRow('personalidad', 'S', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                        <?= renderScaleRow('personalidad', 'C', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                        <?= renderScaleRow('personalidad', 'P', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- PERSONALIDAD Table -->


                            <!-- PSICOPATOLOGÍA Table -->
                            <div id="contenido5">
                                <table class="w-full border-collapse border border-black mb-2 font-sans">
                                    <thead>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black text-left px-4 py-1 w-[30%] uppercase font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Psicopatología</p>
                                            </th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-1 w-20 font-bold"></th>
                                            <th class="border-1 border-black text-center py-1 w-[18%] font-bold" colspan="3">
                                                <div class="relative w-full h-[28px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="justify-items-center top-0 font-bold">Puntuación</div>
                                                    <div class="absolute left-[18%] top-[13px] -translate-x-1/2 font-semibold">PD</div>
                                                    <div class="absolute left-[50%] top-[13px] -translate-x-1/2 font-semibold">PC</div>
                                                    <div class="absolute left-[86%] top-[13px] -translate-x-full font-semibold">TB</div>
                                                </div>
                                            </th>
                                            <th class="border-1 border-black text-center py-1 w-full font-bold">
                                                <div class="h-full fix-margin">
                                                    Perfil de las tasas base
                                                    <div class="relative w-full h-[18px] font-sans text-xs text-black select-none">
                                                        <div class="absolute left-0 top-0 font-bold">0</div>
                                                        <div class="absolute left-[45%] top-0 -translate-x-1/2 font-bold">60</div>
                                                        <div class="absolute left-[60%] top-0 -translate-x-1/2 font-bold">75</div>
                                                        <div class="absolute left-[70%] top-0 -translate-x-1/2 font-bold">85</div>
                                                        <div class="absolute left-[100%] top-0 -translate-x-full font-bold">115</div>
                                                    </div>
                                                </div>

                                            </th>
                                        </tr>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black text-left px-4 py-0.5 font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Síndromes clínicos</p>
                                            </th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-0.5"></th>
                                            <th class="border-1 border-black text-center py-0.5 w-[18%]" colspan="3"></th>
                                            <th class="border-1 border-black p-1 w-full">
                                                <div class="relative w-full h-[14px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="absolute left-[65.57%] top-[0px] -translate-x-1/2 font-semibold">Presente</div>
                                                    <div class="absolute left-[91.95%] top-[0px] -translate-x-full font-semibold">Prominente</div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $syndromes = ['A', 'H', 'N', 'D', 'B', 'T', 'R'];
                                        foreach ($syndromes as $code) {
                                            echo renderScaleRow('psicopatologia', $code, $scale_names, $raw_scores, $percentiles, $final_tbs);
                                        }
                                        ?>
                                        <tr class="bg-white-100 text-xs">
                                            <td colspan="6" class="border-1 border-black px-4 py-0.5 font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Síndromes clínicos graves</p> </td>
                                        </tr>
                                        <?= renderScaleRow('psicopatologia', 'SS', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                        <?= renderScaleRow('psicopatologia', 'CC', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                        <?= renderScaleRow('psicopatologia', 'PP', $scale_names, $raw_scores, $percentiles, $final_tbs) ?>
                                    </tbody>
                                </table>

                                <div class="text-xs text-black pt-2 leading-tight fix-margin">Nota. Los guiones (-) indican puntuaciones no disponibles debido a la falta de información de demasiados ítems de una misma escala.</div>
                            </div>

                        </div>

                        <!-- PAGE 4: FACETAS DE GROSSMAN CON LA PUNTUACIÓN MÁS ALTA -->
                        <div class="font-sans pt-5">
                            <!-- Top header banner -->
                            <div id="contenido6">
                                <div>
                                <h1 class="text-center font-bold text-sm text-black uppercase tracking-wide leading-none mt-2">Inventario Clínico Multiaxial de Millon-IV</h1>
                                <h2 class="text-center font-bold text-sm text-black uppercase tracking-wide mt-1 mb-6">Facetas de Grossman con la Puntuación más Alta</h2>
                                </div>
                                

                                <!-- Top 3 scales elevated facets table -->
                                <table class="w-full border-collapse border-1 border-black font-sans" style="margin-top: 30px;">
                                    <thead>
                                        <tr class="bg-white-100 text-xs text-black">
                                            <th class="border-r-0 border-l border-t border-b border-black text-left px-4 py-1 w-[30%] uppercase font-bold text-black">
                                                <p class="h-full m-0 p-0 fix-margin">Facetas de Grossman</p>
                                            </th>
                                            <th class="border-l-0 border-r border-t border-b border-black text-center py-1 w-20 font-bold"></th>
                                            <th class="border-1 border-black text-center py-1 w-[18%] font-bold" colspan="3">
                                                <div class="relative w-full h-[28px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="justify-items-center top-0 font-bold">Puntuación</div>
                                                    <div class="absolute left-[18%] top-[13px] -translate-x-1/2 font-semibold">PD</div>
                                                    <div class="absolute left-[50%] top-[13px] -translate-x-1/2 font-semibold">PC</div>
                                                    <div class="absolute left-[86%] top-[13px] -translate-x-full font-semibold">TB</div>
                                                </div>
                                            </th>
                                            <th class="border-1 border-black text-center py-1 w-full font-bold">
                                                <div class="relative w-full h-[28px] font-sans text-xs text-black select-none fix-margin">
                                                    <div class="justify-items-center top-0 font-bold">Perfil de las tasas base</div>
                                                    <div class="absolute left-[1%] top-3.5 -translate-x-1/2 font-bold">0</div>
                                                    <div class="absolute left-[35%] top-3.5 -translate-x-1/2 font-bold">35</div>
                                                    <div class="absolute left-[75%] top-3.5 -translate-x-1/2 font-bold">75</div>
                                                    <div class="absolute left-[100%] top-3.5 -translate-x-full font-bold">100</div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $select = 0;
                                        foreach ($top_scales_t as $parent_code => $children) {

                                            $parent_name = $scale_names[$parent_code] ?? '';

                                            $parent_tb = $final_tbs[$parent_code] ?? 0;
                                            $interpretable_label = ($parent_tb >= 60) ? "Interpretable" : "";
                                            if ($parent_tb >= 60) {
                                                $select++;
                                            }
                                            if ($select > 1) {
                                                $interpretable_label = "";
                                            }
                                        ?>
                                            <tr class="border-1 border-black bg-white-100 text-xs h-[22px] font-bold text-black">
                                                <td class="border-r-0 border-l border-t border-b-2 px-4 border-black justify-between">
                                                    <p class="h-full m-0 p-0 fix-margin"><?= htmlspecialchars($parent_name) ?></p>
                                                    
                                                </td>
                                                <td class="border-l-0 border-b-2 border-t border-r-0 border-black px-[.3rem] text-left text-xs font-bold" colspan="4">
                                                    <p class="h-full m-0 p-0 fix-margin"><?= $parent_code ?></p></td>
                                                <td class="border-l border-b-2 border-t border-r border-black text-center text-black text-xs  font-bold" colspan="2">
                                                    <div class="relative w-full font-sans text-center text-xs text-black fix-margin">
                                                        <div class="relative ml-[72%] font-bold "><?= $interpretable_label ?></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            foreach ($facet_categories[$parent_code] as $f_code) {
                                                $f_name = $facet_names[$f_code] ?? '';
                                                $pd = $raw_scores[$f_code] ?? 0;
                                                $pc = $percentiles[$f_code] ?? 0;
                                                $tb = $facets_tb[$f_code] ?? 0;
                                            ?>
                                                <tr class="border-1 border-black text-xs h-[22px] text-black">
                                                    <td class="border-r-0 border-l border-t border-b border-black px-[2.3rem] text-left">
                                                        <p class="h-full m-0 p-0 fix-margin"><?= $f_name ?></p></td>
                                                    <td class="border-l-0 border-l border-t border-r-0 border-black text-center font-semibold">
                                                        <p class="h-full m-0 p-0 fix-margin"><?= $f_code ?></p></td>
                                                    <td class="border-1 w-[6%] border-black text-center">
                                                        <p class="h-full m-0 p-0 fix-margin"><?= $pd ?></p></td>
                                                    <td class="border-1 w-[6%] border-black text-center">
                                                        <p class="h-full m-0 p-0 fix-margin"><?= $pc ?></p></td>
                                                    <td class="border-1 w-[6%] border-black text-center font-bold">
                                                        <p class="h-full m-0 p-0 fix-margin"><?= $tb ?></p></td>
                                                    <td class="p-0" colspan="2"><?= getBarChartCell('facetas', $tb) ?></td>
                                                </tr>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="contenido7">
                                <!-- Full 45 Grossman facets score grid -->
                                <h2 class="text-left font-bold text-sm text-black text-center uppercase tracking-wide pb-1 mb-4" style="margin-top: 30px;">Puntuaciones de las Facetas de Grossman</h2>

                                <div class="grid grid-cols-2 gap-x-8 gap-y-4" style="margin-top: 30px;">
                                    <!-- Left Column: Scales 1 to 6A -->
                                    <div>
                                        <?php
                                        $left_scales = ['1', '2A', '2B', '3', '4A', '4B', '5', '6A'];
                                        foreach ($left_scales as $sc) {
                                            $sc_name = $scale_names[$sc] ?? '';
                                        ?>
                                            <div class="mb-3">
                                                <div class="font-bold text-[11px] text-black border-b border-white pb-0.5 mb-1 flex justify-between items-end">
                                                    <span><?= $sc ?> &nbsp; <?= $sc_name ?></span>
                                                    <span class="text-xs text-black tracking-wider">PD &nbsp; PC &nbsp; TB</span>
                                                </div>
                                                <table class="w-full text-xs font-sans">
                                                    <tbody>
                                                        <?php foreach ($facet_categories[$sc] as $f_code) {
                                                            $f_name = $facet_names[$f_code] ?? '';
                                                            $pd = $raw_scores[$f_code] ?? 0;
                                                            $pc = $percentiles[$f_code] ?? 0;
                                                            $tb = $facets_tb[$f_code] ?? 0;
                                                        ?>
                                                            <tr class="h-[16px] border-b border-white">
                                                                <td class="text-left text-black truncate max-w-[170px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $f_code ?> &nbsp; <?= $f_name ?></p></td>
                                                                <td class="text-right text-black pr-1 w-[20px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $pd ?></p></td>
                                                                <td class="text-right text-black pr-1 w-[25px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $pc ?></p></td>
                                                                <td class="text-right text-black w-[25px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $tb ?></p></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Right Column: Scales 6B to P -->
                                    <div>
                                        <?php
                                        $right_scales = ['6B', '7', '8A', '8B', 'S', 'C', 'P'];
                                        foreach ($right_scales as $sc) {
                                            $sc_name = $scale_names[$sc] ?? '';
                                        ?>
                                            <div class="mb-3">
                                                <div class="font-bold text-xs text-black pb-0.5 mb-1 flex justify-between items-end">
                                                    <span><?= $sc ?> &nbsp; <?= $sc_name ?></span>
                                                    <span class="text-xs text-black tracking-wider">PD &nbsp; PC &nbsp; TB</span>
                                                </div>
                                                <table class="w-full text-xs font-sans">
                                                    <tbody>
                                                        <?php foreach ($facet_categories[$sc] as $f_code) {
                                                            $f_name = $facet_names[$f_code] ?? '';
                                                            $pd = $raw_scores[$f_code] ?? 0;
                                                            $pc = $percentiles[$f_code] ?? 0;
                                                            $tb = $facets_tb[$f_code] ?? 0;
                                                        ?>
                                                            <tr class="h-[16px]">
                                                                <td class="text-left text-black truncate max-w-[170px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $f_code ?> &nbsp; <?= $f_name ?></p></td>
                                                                <td class="text-right text-black pr-1 w-[20px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $pd ?></p></td>
                                                                <td class="text-right text-black pr-1 w-[25px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $pc ?></p></td>
                                                                <td class="text-right text-black w-[25px]">
                                                                    <p class="h-full m-0 p-0 fix-margin"><?= $tb ?></p></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- ASPECTOS DE INTERPRETACIÓN -->
                        <div class="font-sans" style="text-align: justify;">
                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3" id="jsonvalue1">ASPECTOS DE INTERPRETACIÓN</h1>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue2">
                                El MCMI-IV se ha diseñado para evaluar a adultos que buscan atención o tratamiento psicológico. No es, por tanto, un instrumento de evaluación de la personalidad general para población no clínica. Por ello, solo debe utilizarse el MCMI-IV con poblaciones que no difieran notablemente de los sujetos de la muestra en la que se basan los baremos (p. ej., no es apropiado para adolescentes o poblaciones no clínicas). El informe del MCMI-IV no puede interpretarse de forma aislada y debe integrarse con otras fuentes de información. La interpretación del MCMI-IV la debe llevar a cabo un profesional de la salud mental con experiencia en evaluación psicológica.
                            </p>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue3">
                                <?= $asp_interpretacion ?>
                            </p>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue4">
                                <?= $resultado_final_1 ?>
                            </p>
                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3 " id="jsonvalue5">PATRONES DE PERSONALIDAD</h1>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue6">
                                Los siguientes apartados se refieren a los rasgos de personalidad persistentes y generalizados que subyacen a las dificultades emocionales, cognitivas e interpersonales de este evaluado(a). En lugar de centrarse en los síntomas mayormente transitorios que conforman los síndromes clínicos, esta sección se concentra en sus estilos más habituales y desadaptativos de relacionarse, comportarse, pensar y sentir.
                            </p>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue7">
                                <?= nl2br(htmlspecialchars($report['personality'])) ?>
                            </p>
                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3" id="jsonvalue8">ESCALAS DE FACETAS DE GROSSMAN</h1>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue9">
                                Al examinar las puntuaciones elevadas obtenidas en las escalas de patrones de personalidad clínicos y de patología grave de la personalidad de la Escala de Facetas de Grossman, es posible identificar los ámbitos funcionales y estructurales más problemáticos o clínicamente significativos (por ejemplo, la autoimagen o la conducta interpersonal). Un análisis minucioso de las puntuaciones de esta persona en las escalas de facetas sugiere que las siguientes características se encuentran entre sus rasgos de personalidad más destacados.
                            </p>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue10">
                                <?= nl2br(htmlspecialchars($report['facets'])) ?>
                            </p>
                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3" id="jsonvalue11">SÍNDROMES CLÍNICOS</h1>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue12">
                                Los síndromes clínicos que se presentan deben entenderse como trastornos integrados en el contexto de los patrones de personalidad del evaluado. Estos síndromes representan estados en los que se manifiesta un proceso patológico activo, a menudo acelerado por acontecimientos externos o situaciones estresantes. Clínicamente, estos síndromes se consideran ampliaciones o distorsiones del estilo básico de personalidad. Durante los periodos de malestar psicológico, los síndromes clínicos exageran, realzan y acentúan las características de la estructura de personalidad básica.
                            </p>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue13">
                                <?= nl2br(htmlspecialchars($report['syndromes'])) ?>
                            </p>
                        </div>
                        <!-- PAGE 5: RESPUESTAS SIGNIFICATIVAS -->
                        <div class="font-sans">

                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3" id="jsonvalue14">Respuestas Significativas</h1>

                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue15">
                                El paciente ha respondido a los siguientes ítems en el sentido indicado entre paréntesis. Estos ítems pertenecen a categorías específicas y sugieren problemas que el profesional puede analizar en mayor profundidad.
                            </p>
                            
                            <?php
                            $index_cat = 1;// index - max - 
                            foreach ($noteworthy_by_category as $category => $items) {
                            ?>
                                <div class="mb-6">
                                    <h3 class="font-bold text-sm text-black mb-2 pb-1" id="jsonvalue15_<?= $index_cat ?>_<?= count($noteworthy_by_category) ?>_<?= count($items)  ?>"><?= $category ?>(<?= count($items)  ?>/<?= count($noteworthy_categories[$category]) ?>)</h3>
                                    <ul class="text-sm text-black pl-4 space-y-1.5 list-none">
                                        <?php
                                        $index_sub_cat = 1;
                                        foreach ($items as $item) { ?>
                                            <li class="flex items-start gap-1">
                                                <span class="font-semibold w-[30px] flex-shrink-0 text-back" id="jsonvalue-sub-15_<?= $index_sub_cat ?>_<?= count($items) ?>"><?= $item['item_order'] ?>.</span>
                                                <span class="text-justify"><?= $item['question'] ?> <span class="font-semibold text-black" id="jsonvalue-sub-15-<?= $index_sub_cat ?>">(Verdadero)</span></span>
                                            </li>
                                        <?php $index_sub_cat++; } ?>
                                    </ul>
                                </div>
                            <?php
                            $index_cat++;
                            }
                            ?>
                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3" id="jsonvalue16">CONSIDERACIONES DIAGNÓSTICAS DSM-5®</h1>
                            <p class="text-sm text-black leading-relaxed" id="jsonvalue17">
                                Las siguientes asignaciones diagnósticas deben considerarse juicios de prototipos clínicos y de personalidad que corresponden conceptualmente a categorías diagnósticas formales. Los criterios diagnósticos y los ítems utilizados en el MCMI-IV difieren en cierta medida de los del DSM-5, pero existen suficientes paralelismos en los ítems del MCMI-IV para recomendar la consideración de las siguientes asignaciones. Es importante señalar que varios síndromes clínicos del DSM-5 no se evalúan en el MCMI-IV. Los diagnósticos definitivos deben fundamentarse en datos biográficos, de observación y de entrevista, además de los inventarios de autoinforme como el MCMI-IV.

                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue18">
                                Antes del nombre de cada trastorno, se presentan los códigos del CIE-9-MC, seguidos de los códigos del CIE-10-MC entre paréntesis
                            </p>
                            <h1 class="text-left font-bold text-lg text-black tracking-wide mb-3" id="jsonvalue19">Síndromes Clínicos</h1>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue20">
                                La sintomatología reportada y las conductas de la persona evaluada, son consistentes con los siguientes síndromes clínicos, enumerados según su relevancia.
                            </p>
                            <p class="text-sm text-black leading-relaxed" id="jsonvalue21">
                                <?= $textoSincromeClinico ?>
                            </p>
                            <?php
                            if ($sincromeClinico_informe1) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue22">
                                    <?= $sincromeClinico_informe1 ?>
                                </p>
                            <?php } ?>

                            <?php
                            if ($sincromeClinico_informe2) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue23">
                                    <?= $sincromeClinico_informe2 ?>
                                </p>
                            <?php } ?>

                            <?php
                            if ($sincromeClinico_informe3) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue24">
                                    <?= $sincromeClinico_informe3 ?>
                                </p>
                            <?php } ?>


                            <h1 class="text-left font-bold text-lg text-black uppercase tracking-wide mb-3" id="jsonvalue25">Trastornos de la personalidad</h1>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue26">
                                Los patrones duraderos y consistentes de funcionamiento psicológico desadaptativo explican la forma en que la persona percibe la realidad, se relaciona con los demás y regula sus emociones. Estos rasgos conforman la base estructural de su modo de ser y están en el origen de las manifestaciones clínicas observadas. En este caso, los siguientes prototipos de personalidad se relacionan con los diagnósticos más probables del DSM-5.
                            </p>
                            <?php
                            if ($transtorno_personalidad_informe_1) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue27">
                                    <?= $transtorno_personalidad_informe_1 ?>
                                </p>
                            <?php } ?>

                            <?php
                            if ($transtorno_personalidad_informe_2) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue28">
                                    <?= $transtorno_personalidad_informe_2 ?>
                                </p>
                            <?php } ?>

                            <?php
                            if ($transtorno_personalidad_informe_3) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue29">
                                    <?= $transtorno_personalidad_informe_3 ?>
                                </p>
                            <?php } ?>

                            <?php
                            if ($transtorno_sintoma_informe_1) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue30">
                                    <?= $transtorno_sintoma_informe_1 ?>
                                </p>
                            <?php } ?>

                            <?php
                            if ($transtorno_sintoma_informe_2) { ?>
                                <p class="text-sm text-black leading-relaxed text-center" id="jsonvalue31">
                                    <?= $transtorno_sintoma_informe_2 ?>
                                </p>
                            <?php } ?>


                            <h5 class="text-left font-bold text-lg text-black tracking-wide mb-3" id="jsonvalue32">
                                Fin del informe.
                            </h5>
                            <p class="text-sm text-black leading-relaxed mb-6" id="jsonvalue33">
                                Copyright @ 2020 DICANDRIEN, Inc. All rights reserved.
                            </p>

                        </div>


                    </div>
                </div>



            </div>
        </div>

        <?php include("../include/footer.php"); ?>
    </div>
    <?php include("../include/print_content-7.php"); ?>

    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/plugins/jquery.flot/jquery.flot.js"></script>
    <script src="../../assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
    <script src="../../assets/plugins/jquery.flot/jquery.flot.resize.js"></script>

    <script src="../../assets/plugins/ionicons/ionicons.js"></script>

    <script src="../../assets/plugins/moment/moment.js"></script>

    <script src="../../assets/plugins/select2/js/select2.min.js"></script>

    <script src="../../assets/js/eva-icons.min.js"></script>



    <script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
    <script src="../../assets/plugins/rating/jquery.barrating.js"></script>

    <script src="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

    <script src="../../assets/js/sticky.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>
    <script src="../../assets/js/custom.js?v=<?= VERSION_CODE ?>"></script>

    <script src="../../assets/js/flot-circle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const name_user = "<?php echo $register['id_client'] ?>";
        const testname = "<?php echo $register['type_question_name'] ?>";

        const noteworthy_by_category = <?php echo json_encode($noteworthy_by_category); ?>;
        const sincromeClinico_informe1 = `<?php echo $sincromeClinico_informe1 ?>`;
        const sincromeClinico_informe2 = `<?php echo $sincromeClinico_informe2 ?>`;
        const sincromeClinico_informe3 = `<?php echo $sincromeClinico_informe3 ?>`;
        
        const transtorno_personalidad_informe_1 = `<?php echo $transtorno_personalidad_informe_1 ?>`;
        const transtorno_personalidad_informe_2 = `<?php echo $transtorno_personalidad_informe_2 ?>`;
        const transtorno_personalidad_informe_3 = `<?php echo $transtorno_personalidad_informe_3 ?>`;

        const transtorno_sintoma_informe_1 = `<?php echo $transtorno_sintoma_informe_1 ?>`;
        const transtorno_sintoma_informe_2 = `<?php echo $transtorno_sintoma_informe_2 ?>`;
        console.log(noteworthy_by_category);
        const filenamepdf = (name_user + "_" + testname).replace(/\s+/g, '');
        var jsonpdf = [];

        jsonpdf.push({type: 2,image: "contenidoID"});

        jsonpdf.push({type: 2,image: "contenido2"});
        
        jsonpdf.push({
            type: 2,
            image: "contenido3"
        });
        
        jsonpdf.push({
            type: 2,
            image: "contenido4"
        });
        jsonpdf.push({
            type: 2,
            image: "contenido5"
        });
        jsonpdf.push({
            type: 3
        });
        jsonpdf.push({
            type: 2,
            image: "contenido6"
        });

        jsonpdf.push({
            type: 2,
            image: "contenido7",
            size: 100
        });

        jsonpdf.push({
            type: 7,
            text: getvalue('jsonvalue1')
        });
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue2')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue3')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue4')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue5')} );
        jsonpdf.push({type: 5,text: ''});


        jsonpdf.push({type:5,text:getvalue('jsonvalue6')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue7')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue8')} );
        jsonpdf.push({type: 5,text: ''});

        jsonpdf.push({type:5,text:getvalue('jsonvalue9')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue10')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue11')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue12')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue13')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue14')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue15')} );
        jsonpdf.push({type: 5,text: ''});

        Object.entries(noteworthy_by_category).forEach(([categoria, items]) => {
            jsonpdf.push({type:10,text:categoria} );
           
            items.forEach(item => {
                console.log(item.question);
                const value = item.item_order+". "+item.question +"(Verdadero)";
                jsonpdf.push({type:5,text:value});
                
            });
            jsonpdf.push({type: 5,text: ''});
        });

        jsonpdf.push({type:7,text:getvalue('jsonvalue16')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue17')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue18')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue19')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue20')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue21')} );
        if(sincromeClinico_informe1!=""){
            jsonpdf.push({type:11,text:sincromeClinico_informe1} );
            jsonpdf.push({type: 5,text: ''});
        }
        if(sincromeClinico_informe2!=""){
            jsonpdf.push({type:11,text:sincromeClinico_informe2} );
            jsonpdf.push({type: 5,text: ''});
        }
        if(sincromeClinico_informe3!=""){
            jsonpdf.push({type:11,text:sincromeClinico_informe3} );
            
        }
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue25')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue26')} );
        jsonpdf.push({type: 5,text: ''});
        if(transtorno_personalidad_informe_1!=""){
            jsonpdf.push({type:11,text:transtorno_personalidad_informe_1} );
            jsonpdf.push({type: 5,text: ''});
        }
        if(transtorno_personalidad_informe_2!=""){
            jsonpdf.push({type:11,text:transtorno_personalidad_informe_2} );
            jsonpdf.push({type: 5,text: ''});
        }
        if(transtorno_personalidad_informe_3!=""){
            jsonpdf.push({type:11,text:transtorno_personalidad_informe_3} );
            jsonpdf.push({type: 5,text: ''});
        }
       
        if(transtorno_sintoma_informe_1!=""){
            jsonpdf.push({type:11,text:transtorno_sintoma_informe_1} );
            jsonpdf.push({type: 5,text: ''});
        }
        if(transtorno_sintoma_informe_2!=""){
            jsonpdf.push({type:11,text:transtorno_sintoma_informe_2} );
        }
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:7,text:getvalue('jsonvalue32')} );
        jsonpdf.push({type: 5,text: ''});
        jsonpdf.push({type:5,text:getvalue('jsonvalue33')} );
        jsonpdf.push({type: 5,text: ''});
        function descargarDeforePDF() {

            document.querySelectorAll(".fix-margin").forEach(element => {
                element.style.setProperty("bottom", "5px", "important");
                element.style.setProperty("position", "relative", "important");
            });

            descargarPDF();
        }
    </script>
    <script src="../../assets/js/print.js?v=<?= VERSION_CODE ?>"></script>
</body>

</html>