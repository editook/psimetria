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
    if($register['baremo_id'] == $baremo['id']){
        $baremo_name = htmlspecialchars($baremo['name']) ;
    }
}
$answers = $answerModel->getAll($register['codes']);

// Calculate MCMI-IV scores and interpretation
$results = $mcmiConfig->score($answers, $register['baremo_id']);

$raw_scores = $results['raw_scores'];
$initial_tbs = $results['initial_tbs'];
$adjustments = $results['adjustments'];
$final_tbs = $results['final_tbs'];
$percentiles = $results['percentiles'];
$report = $results['report'];
$invalidez = $results['invalidez'];
$inconsistencia = $results['inconsistencia'];

$scale_names = [
    'X' => 'Sinceridad', 'Y' => 'Deseabilidad social', 'Z' => 'Devaluación',
    '1' => 'Esquizoide', '2A' => 'Evitativo', '2B' => 'Melancólico', '3' => 'Dependiente',
    '4A' => 'Histriónico', '4B' => 'Tempestuoso', '5' => 'Narcisista', '6A' => 'Antisocial',
    '6B' => 'Sádico', '7' => 'Compulsivo', '8A' => 'Negativista', '8B' => 'Masoquista',
    'S' => 'Esquizotípico', 'C' => 'Límite', 'P' => 'Paranoide',
    'A' => 'Ansiedad generalizada', 'H' => 'Síntomas somáticos', 'N' => 'Espectro bipolar',
    'D' => 'Depresión persistente', 'B' => 'Consumo de alcohol', 'T' => 'Consumo de drogas', 'R' => 'Estrés postraumático',
    'SS' => 'Espectro esquizofrénico', 'CC' => 'Depresión mayor', 'PP' => 'Delirante'
];

$scale_categories = [
    'Índices Modificadores' => ['X', 'Y', 'Z'],
    'Patrones Clínicos de la Personalidad' => ['1', '2A', '2B', '3', '4A', '4B', '5', '6A', '6B', '7', '8A', '8B'],
    'Patología Grave de la Personalidad' => ['S', 'C', 'P'],
    'Síndromes Clínicos' => ['A', 'H', 'N', 'D', 'B', 'T', 'R'],
    'Síndromes Clínicos Graves' => ['SS', 'CC', 'PP']
];

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

$facet_names = [
    '1.1' => 'Interpers. Desvinculado', '1.2' => 'Cognitiv. Deficiente', '1.3' => 'Autoimagen de Apatía',
    '2A.1' => 'Interpers. Aversivo', '2A.2' => 'Cognitiv. Distraído', '2A.3' => 'Autoimagen de Alienación',
    '2B.1' => 'Cognitiv. Desesperanzado', '2B.2' => 'Autoimagen de Inutilidad', '2B.3' => 'Repres. Temp. de Desgracia',
    '3.1' => 'Interpers. Sumiso', '3.2' => 'Autoimagen de Ineptitud', '3.3' => 'Representac. Inmaduras',
    '4A.1' => 'Expresivam. Precipitado', '4A.2' => 'Interpers. Lisonjero', '4A.3' => 'Autoimagen de Sociabilidad',
    '4B.1' => 'Expresivam. Impetuoso', '4B.2' => 'Interpers. Fragmentado', '4B.3' => 'Autoimagen de Extrañeza',
    '5.1' => 'Interpers. Explotador', '5.2' => 'Cognitiv. Expansivo', '5.3' => 'Autoimagen de Elogiabilidad',
    '6A.1' => 'Interpers. Desleal', '6A.2' => 'Autoimagen de Autonomía', '6A.3' => 'Dinámica de Venganza',
    '6B.1' => 'Expresivam. Combativo', '6B.2' => 'Interpers. Desagradable', '6B.3' => 'Dinámica de Erupción',
    '7.1' => 'Expresivam. Disciplinado', '7.2' => 'Cognitiv. Constreñido', '7.3' => 'Autoimagen de Eficiencia',
    '8A.1' => 'Expresivam. Resentido', '8A.2' => 'Autoimagen de Descontento', '8A.3' => 'Dinámica de Vacilación',
    '8B.1' => 'Expresivam. Servil', '8B.2' => 'Autoimagen de Sufrimiento', '8B.3' => 'Dinámica de Dispersión',
    'S.1' => 'Cognitiv. Circunstancial', 'S.2' => 'Autoimagen de Vacío', 'S.3' => 'Dinámica de Desorganización',
    'C.1' => 'Autoimagen de Inestabilidad', 'C.2' => 'Estructura Incongruente', 'C.3' => 'Dinámica de Labilidad',
    'P.1' => 'Cognitiv. Suspicaz', 'P.2' => 'Autoimagen de Inviolabilidad', 'P.3' => 'Dinámica de Proyección'
];

function getGravedadBadge($tb, $code) {
    if (in_array($code, ['X', 'Y', 'Z'])) {
        return '<span class="badge bg-secondary">N/A</span>';
    }
    if ($tb >= 85) {
        return '<span class="badge bg-danger text-white">Trastorno / Signif.</span>';
    } elseif ($tb >= 75) {
        return '<span class="badge bg-warning text-dark">Tipo / Presencia</span>';
    } elseif ($tb >= 60) {
        return '<span class="badge bg-info text-white">Estilo / Sugerente</span>';
    } else {
        return '<span class="badge bg-success text-white">Normal</span>';
    }
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=WEB_TITLE?> - Resultados MCMI-IV</title>
    <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon"/>
    <link href="../../assets/css/icons.css?v=<?=VERSION_CODE?>" rel="stylesheet">
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">
    <link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>
    <link href="../../assets/css/style.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
    <link href="../../assets/css/style-dark.css" rel="stylesheet">
    <link href="../../assets/css/boxed.css" rel="stylesheet">
    <link href="../../assets/css/dark-boxed.css" rel="stylesheet">
    <link href="../../assets/css/skin-modes.css" rel="stylesheet" />
    <link href="../../assets/css/animate.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://db.onlinewebfonts.com/c/5f9ecd69838280dcd8a9f0072f92f6a6?family=Ronnia+W01+Regular" rel="stylesheet">
    <style>
        @font-face {
            font-family: "Ronnia W01 Regular";
            src: url("https://db.onlinewebfonts.com/t/5f9ecd69838280dcd8a9f0072f92f6a6.woff2") format("woff2"),
                url("https://db.onlinewebfonts.com/t/5f9ecd69838280dcd8a9f0072f92f6a6.woff") format("woff");
        }
    </style>
    <link href="../../assets/css/style_result7.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
</head>

<body class="main-body">
    <div id="global-loader">
        <img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>

    <div class="page <?=TESTING=='1'?'istesting':''?>">
        <?php include("../include/header_top.php"); ?>
        <?php include("../include/header_bottom.php"); ?>

        <div class="main-content horizontal-content">
            <div class="container">
                <div class="breadcrumb-header justify-content-between"></div>

                <!-- Baremos Selector -->
                <div class="card no-print mb-4 shadow-sm">
                    <div class="card-body flex items-center justify-between">
                        <h4 class="card-title m-0" style="color: #0B2B5E;"><i class="fas fa-filter"></i> Selección de Baremo</h4>
                        <form id="form_baremo" method="POST" action="result7.php" class="m-0 flex items-center gap-2">
                            <input type="hidden" name="id_register" value="<?=$register['id']?>">
                            <input type="hidden" name="id_user" value="<?=$idClient?>">
                            <select name="baremo_id" id="baremo_id" class="form-select form-control" style="width: 280px; height: 40px;">
                                <?php foreach ($baremos as $b) { ?>
                                    <option value="<?=$b['id']?>" <?=$register['baremo_id'] == $b['id'] ? 'selected' : ''?>>
                                        <?=$b['name']?>
                                    </option>
                                <?php } ?>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Patient Profile Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white flex justify-between items-center" style="background: #0B2B5E;">
                        <h3 class="card-title m-0 text-white"><i class="fas fa-user-circle"></i> Ficha del Evaluado</h3>
                        <button onclick="window.print()" class="btn btn-light btn-sm no-print"><i class="fas fa-print"></i> Imprimir Informe</button>
                    </div>
                    <div class="card-body">
                        <div class="row text-sm">
                            <div class="col-md-3"><b>ID/Nombre:</b> <?=$register['id_client']?></div>
                            <div class="col-md-2"><b>Edad:</b> <?=$register['age']?> años</div>
                            <div class="col-md-2"><b>Sexo:</b> <?=$register['sex']?></div>
                            <div class="col-md-5"><b>Baremo Aplicado:</b> <?=$baremo_name?></div>
                        </div>
                    </div>
                </div>

                <!-- Validity Warning Alert -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <?php if ($report['validity_status'] === 'INVALID') { ?>
                            <div class="alert alert-danger m-0" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-times-circle"></i> PROTOCOLO INVÁLIDO</h4>
                                <p class="text-sm"><?=$report['validity_text']?></p>
                            </div>
                        <?php } elseif ($report['validity_status'] === 'QUESTIONABLE') { ?>
                            <div class="alert alert-warning m-0 text-dark" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> PROTOCOLO CUESTIONABLE</h4>
                                <p class="text-sm"><?=$report['validity_text']?></p>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-success m-0" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-check-circle"></i> PROTOCOLO VÁLIDO E INTERPRETABLE</h4>
                                <p class="text-sm"><?=$report['validity_text']?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Profile Chart -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white" style="background: #0D47A1;">
                        <h3 class="card-title m-0 text-white"><i class="fas fa-chart-line"></i> Gráfico de Perfil (Tasas Base)</h3>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="mcmiChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Detailed Tables -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white" style="background: #1976D2;">
                        <h3 class="card-title m-0 text-white"><i class="fas fa-table"></i> Puntuaciones Detalladas</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped m-0 text-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Escala</th>
                                        <th class="text-center">Código</th>
                                        <th class="text-center">P. Directa (PD)</th>
                                        <th class="text-center">TB Inicial</th>
                                        <th class="text-center">Ajuste X</th>
                                        <th class="text-center">Ajuste A/CC</th>
                                        <th class="text-center">TB Final</th>
                                        <th class="text-center">Percentil (PC)</th>
                                        <th class="text-center">Gravedad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($scale_categories as $category => $codes) { ?>
                                        <tr class="table-secondary">
                                            <td colspan="9" class="font-bold text-[#0B2B5E]"><?=$category?></td>
                                        </tr>
                                        <?php foreach ($codes as $code) { 
                                            $name = $scale_names[$code];
                                            $pd = $raw_scores[$code];
                                            $init_tb = $initial_tbs[$code];
                                            $adj_x = $adjustments[$code]['x'];
                                            $adj_ad = $adjustments[$code]['ad'];
                                            $final_tb = $final_tbs[$code];
                                            $pc = $percentiles[$code];
                                            ?>
                                            <tr>
                                                <td><?=$name?></td>
                                                <td class="text-center font-bold"><?=$code?></td>
                                                <td class="text-center"><?=$pd?></td>
                                                <td class="text-center"><?=$init_tb?></td>
                                                <td class="text-center"><?=$adj_x != 0 ? ($adj_x > 0 ? "+$adj_x" : $adj_x) : '-'?></td>
                                                <td class="text-center"><?=$adj_ad != 0 ? ($adj_ad > 0 ? "+$adj_ad" : $adj_ad) : '-'?></td>
                                                <td class="text-center font-bold"><?=$final_tb?></td>
                                                <td class="text-center"><?=$pc?></td>
                                                <td class="text-center"><?=getGravedadBadge($final_tb, $code)?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Grossman Facets Details -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-white bg-secondary">
                        <h3 class="card-title m-0 text-white"><i class="fas fa-sitemap"></i> Detalle de Facetas de Grossman</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped m-0 text-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Faceta de Grossman</th>
                                        <th class="text-center">Código</th>
                                        <th class="text-center">P. Directa (PD)</th>
                                        <th class="text-center">Percentil (PC)</th>
                                        <th class="text-center">Nivel Clínico</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($facet_categories as $parent_code => $f_codes) { 
                                        $parent_name = $scale_names[$parent_code];
                                        ?>
                                        <tr class="table-secondary">
                                            <td colspan="5" class="font-bold">Escala <?=$parent_code?>: <?=$parent_name?></td>
                                        </tr>
                                        <?php foreach ($f_codes as $f_code) { 
                                            $name = $facet_names[$f_code];
                                            $pd = $raw_scores[$f_code];
                                            $pc = $percentiles[$f_code];
                                            $badge = ($pc >= 75) ? '<span class="badge bg-warning text-dark">Clínicamente Signif.</span>' : '<span class="badge bg-light text-dark">Normal</span>';
                                            ?>
                                            <tr>
                                                <td class="ps-4"><?=$name?></td>
                                                <td class="text-center font-bold"><?=$f_code?></td>
                                                <td class="text-center"><?=$pd?></td>
                                                <td class="text-center"><?=$pc?></td>
                                                <td class="text-center"><?=$badge?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Narrative Report -->
                <div class="card shadow-sm mb-5">
                    <div class="card-header text-white" style="background: #0B2B5E;">
                        <h3 class="card-title m-0 text-white"><i class="fas fa-file-alt"></i> Informe Interpretativo Narrativo</h3>
                    </div>
                    <div class="card-body">
                        <div class="report-section">
                            <h4 class="font-bold text-[#0B2B5E] mb-2"><i class="fas fa-shield-alt"></i> 1. Índices de Validez y Estilo de Respuesta</h4>
                            <p class="text-justify leading-relaxed text-sm"><?=$report['validity_text']?></p>
                            <p class="text-sm mt-3"><b>Detalle de Puntuaciones:</b> Invalidez (V) = <?=$invalidez?> | Inconsistencia (W) = <?=$inconsistencia?></p>
                        </div>

                        <div class="report-section">
                            <h4 class="font-bold text-[#0B2B5E] mb-2"><i class="fas fa-user-tag"></i> 2. Patrones de Personalidad</h4>
                            <p class="text-justify leading-relaxed text-sm"><?=nl2br(htmlspecialchars($report['personality']))?></p>
                        </div>

                        <div class="report-section">
                            <h4 class="font-bold text-[#0B2B5E] mb-2"><i class="fas fa-compress-arrows-alt"></i> 3. Facetas de Grossman</h4>
                            <p class="text-justify leading-relaxed text-sm"><?=nl2br(htmlspecialchars($report['facets']))?></p>
                        </div>

                        <div class="report-section">
                            <h4 class="font-bold text-[#0B2B5E] mb-2"><i class="fas fa-briefcase-medical"></i> 4. Síndromes Clínicos</h4>
                            <p class="text-justify leading-relaxed text-sm"><?=nl2br(htmlspecialchars($report['syndromes']))?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("../include/footer.php"); ?>
    </div>
    <?php include("../include/print_content.php"); ?>
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>

    <script src="../../assets/js/custom.js?v=<?= VERSION_CODE ?>"></script>

    <script src="../../assets/js/flot-circle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- Chart Configuration Script -->
    <script>
        const name_user = "<?php echo $register['id_client'] ?>";
        const testname = "<?php echo $register['type_question_name'] ?>";
        const filenamepdf = (name_user + "_" + testname).replace(/\s+/g, '');

        document.addEventListener("DOMContentLoaded", function() {
            // Chart.js Configuration
            const ctx = document.getElementById('mcmiChart').getContext('2d');
            
            const labels = <?=json_encode(array_keys($scale_names))?>;
            const values = <?=json_encode(array_values($final_tbs))?>;
            
            // Set dynamic colors based on scale categories
            const backgroundColors = labels.map(label => {
                if (['X', 'Y', 'Z'].includes(label)) return 'rgba(108, 117, 125, 0.7)'; // Grey for Modifiers
                if (['S', 'C', 'P'].includes(label)) return 'rgba(220, 53, 69, 0.7)';   // Red for Severe Personality
                if (['SS', 'CC', 'PP'].includes(label)) return 'rgba(253, 126, 20, 0.7)'; // Orange for Severe Clinical
                if (['A', 'H', 'N', 'D', 'B', 'T', 'R'].includes(label)) return 'rgba(40, 167, 69, 0.7)'; // Green for Clinical
                return 'rgba(0, 123, 255, 0.7)'; // Blue for Clinical Personality
            });
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Tasa Base (TB)',
                        data: values,
                        backgroundColor: backgroundColors,
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 0,
                            max: 120,
                            grid: {
                                color: function(context) {
                                    if ([60, 75, 85].includes(context.tick.value)) {
                                        return 'rgba(220, 53, 69, 0.5)'; // Highlight clinical lines
                                    }
                                    return 'rgba(0, 0, 0, 0.05)';
                                },
                                lineWidth: function(context) {
                                    if ([60, 75, 85].includes(context.tick.value)) {
                                        return 2;
                                    }
                                    return 1;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
            
            // Auto submit baremo form on change
            document.getElementById('baremo_id').addEventListener('change', function() {
                document.getElementById('form_baremo').submit();
            });
            
            // Hide global loader
            document.getElementById('global-loader').style.display = 'none';
        });
    </script>
</body>
</html>
