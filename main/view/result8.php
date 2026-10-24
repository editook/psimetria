<?php
include_once('../configs.php');
session_start();
require_once '../../vendor/autoload.php';

require_once '../connection.php';
require_once '../models/model_register.php';
require_once '../models/model_question.php';
require_once '../models/model_answer.php';
require_once '../models/model_baremo.php';
require_once '../models/sims/model_sims_configuration.php';

$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$simsConfig = new ModelSimsConfiguration();

if (empty($_SESSION['REST_type_user'])) {
    header('Location: ' . LOCALHOST . '/signin.php');
    exit;
}

$device = $registerModel->getDeviceType();
if ($device === 'mobile') {
    include('../include/no_permit.php');
    exit;
}

$idClient = 0;
$idPatient = 0;
if ($_SESSION['REST_type_user'] === 'Administrador' && isset($_GET['client'], $_GET['patient'])) {
    $idClient = (int) $_GET['client'];
    $idPatient = (int) $_GET['patient'];
} elseif ($_SESSION['REST_type_user'] === 'CLIENTE' && isset($_GET['patient'])) {
    $idClient = (int) $_SESSION['REST_id_user'];
    $idPatient = (int) $_GET['patient'];
}
$routeQuery = ['patient' => $idPatient];
if ($_SESSION['REST_type_user'] === 'Administrador') {
    $routeQuery['client'] = $idClient;
}
$resultUrl = 'result8.php?' . http_build_query($routeQuery);

$register = $registerModel->getById($idClient, $idPatient);
if ($register === null || (int) $register['id_type_question'] !== 8) {
    http_response_code(404);
    exit('No se encontró el registro SIMS solicitado.');
}

$baremos = $baremoModel->getAll($register['id_type_question']);
$baremoError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['baremo_id'])) {
    $selectedBaremoId = (int) $_POST['baremo_id'];
    $selectedBaremo = null;
    foreach ($baremos as $candidate) {
        if ((int) $candidate['id'] === $selectedBaremoId && (int) $candidate['active'] !== 0) {
            $selectedBaremo = $candidate;
            break;
        }
    }

    if ($selectedBaremo === null) {
        $baremoError = 'El baremo seleccionado no está disponible para este instrumento.';
    } else {
        $registerModel->updateClient(
            (int) $register['id'],
            $register['id_client'],
            $register['age'],
            $register['sex'],
            $register['id_type_question'],
            $selectedBaremoId
        );
        header('Location: ' . $resultUrl);
        exit;
    }
}

$answers = $answerModel->getAll($register['codes']);
$simsResult = $simsConfig->calculate($answers);
$baremoName = 'Adaptación española';
foreach ($baremos as $baremo) {
    if ((int) $register['baremo_id'] === (int) $baremo['id']) {
        $baremoName = $baremo['name'];
        break;
    }
}

$escape = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
$appliedDate = date('d/m/Y', strtotime($register['date_create']));
$flagsByScale = [];
foreach ($simsResult['flags'] as $flag) {
    $flagsByScale[$flag['scale_code']][] = $flag;
}
$profileChartPoints = [];
foreach ($simsResult['scales'] as $scaleIndex => $scale) {
    $profileChartPoints[] = [(int) $scale['score'], count($simsResult['scales']) - $scaleIndex - 1];
}
$totalElevatedText = $simsResult['total_elevated']
    ? 'La puntuación total alcanza el punto de corte del instrumento (17 o más). El perfil sugiere ampliar la evaluación de posible simulación o exageración de síntomas.'
    : 'La puntuación total se encuentra por debajo del punto de corte del instrumento (17). En esta aplicación no se alcanza el indicador global establecido en el perfil.';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $escape(WEB_TITLE) ?> - Resultados SIMS-III</title>
    <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon">
    <link href="../../assets/css/icons.css?v=<?= $escape(VERSION_CODE) ?>" rel="stylesheet">
    <link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">
    <link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="../../assets/css/style.css?v=<?= $escape(VERSION_CODE) ?>" rel="stylesheet">
    <link href="../../assets/css/style-dark.css" rel="stylesheet">
    <link href="../../assets/css/boxed.css" rel="stylesheet">
    <link href="../../assets/css/dark-boxed.css" rel="stylesheet">
    <link href="../../assets/css/skin-modes.css" rel="stylesheet">
    <link href="../../assets/css/animate.css" rel="stylesheet">
    <link href="../../assets/css/style_result8.css?v=<?= $escape(VERSION_CODE) ?>" rel="stylesheet">
    <style>
        .main-content {
            background: #fff;
        }

        .sims-report {
            color: #202020;
            font-family: "Ronnia Regular", Arial, sans-serif;
        }

        .sims-card {
            background: #fff;
            border: 1px solid #d9e1e7;
            border-radius: 12px;
            margin-bottom: 18px;
            padding: 20px;
        }

        .sims-card h2,
        .sims-card h3 {
            color: #163e56;
            font-weight: 700;
            margin: 0 0 14px;
        }

        .sims-card h2 {
            font-size: 21px;
        }

        .sims-card h3 {
            font-size: 17px;
        }

        .sims-total {
            align-items: center;
            display: flex;
            gap: 20px;
        }

        .sims-total-score {
            align-items: center;
            background: #eaf2f6;
            border: 2px solid #47788f;
            border-radius: 14px;
            display: flex;
            flex: 0 0 105px;
            flex-direction: column;
            justify-content: center;
            min-height: 95px;
        }

        .sims-total-score strong {
            color: #163e56;
            font-size: 34px;
            line-height: 1.1;
        }

        .sims-total-score span {
            font-size: 12px;
        }

        .sims-total-copy {
            line-height: 1.55;
        }

        .sims-scale {
            border-bottom: 1px solid #e3e8eb;
            padding: 14px 0;
        }

        .sims-scale:last-child {
            border-bottom: 0;
        }

        .sims-scale-head {
            align-items: center;
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .sims-scale-name {
            font-weight: 700;
        }

        .sims-scale-score {
            color: #163e56;
            font-size: 17px;
            font-weight: 700;
            white-space: nowrap;
        }

        .sims-track {
            background: #edf0f2;
            border-radius: 8px;
            height: 13px;
            margin: 10px 0 5px;
            overflow: visible;
            position: relative;
        }

        .sims-track-fill {
            background: #5292a8;
            border-radius: 8px;
            height: 100%;
        }

        .sims-track-fill.is-elevated {
            background: #c76b4a;
        }

        .sims-track-cutoff {
            border-left: 2px solid #263746;
            height: 19px;
            position: absolute;
            top: -3px;
        }

        .sims-track-legend {
            color: #626b70;
            display: flex;
            font-size: 12px;
            justify-content: space-between;
        }

        .sims-status {
            border-radius: 999px;
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
        }

        .sims-status.normal {
            background: #e7f2e9;
            color: #286239;
        }

        .sims-status.elevated {
            background: #f9e8e1;
            color: #913e25;
        }

        .sims-interpretation {
            line-height: 1.6;
            margin: 0;
        }

        .sims-flags {
            border-bottom: 1px solid #e3e8eb;
            padding: 12px 0;
        }

        .sims-flags:last-child {
            border-bottom: 0;
        }

        .sims-flags h3 {
            margin-bottom: 8px;
        }

        .sims-flag-item {
            line-height: 1.45;
            margin: 6px 0;
        }

        .sims-flag-item strong {
            color: #163e56;
        }

        .sims-note {
            background: #fff8e8;
            border-left: 4px solid #d4a23c;
            line-height: 1.5;
            padding: 12px 15px;
        }

        .sims-download {
            margin: 0;
        }

        #contenidoID {
            left: -10000px;
            position: absolute;
            top: 0;
            width: 900px;
            z-index: -1;
        }

        @media (max-width: 767px) {
            .sims-total {
                align-items: flex-start;
                flex-direction: column;
            }

            .sims-card {
                padding: 15px;
            }

            #contenido1 .container-left {
                margin-left: 45px;
            }

            #contenido1 .perfil-vertical {
                font-size: 29px;
            }
        }

        @media print {

            .sims-download,
            #global-loader {
                display: none !important;
            }

            .sims-card {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body class="main-body">
    <div id="global-loader">
        <img src="../../assets/img/loader.svg" class="loader-img" alt="Cargando">
    </div>

    <div class="page <?= TESTING === '1' ? 'istesting' : '' ?>">
        <?php include('../include/header_top.php'); ?>
        <?php include('../include/header_bottom.php'); ?>

        <main class="main-content horizontal-content">
            <div class="container sims-report">
                <div class="row row-sm container-short">
                    <div class="col-md-12">
                        <div id="contenidoID" aria-hidden="true" style="position: absolute; width: 90%; top: 30px; z-index: -1;">
                            <div class="container-header">
                                <div class="container-body">
                                    <div class="container-row-bg">
                                        <span class="label">Id:</span>
                                        <input class="field form-control" value="<?= $escape($register['id_client']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section id="contenido1" class="container-header" aria-label="Datos de aplicación SIMS">
                            <div class="container-left">
                                <div class="perfil-vertical">PERFIL</div>
                                <div class="divider"></div>
                                <div class="sims-logo" aria-label="SIMS-III">SIMS<br><small>III</small></div>
                            </div>
                            <div class="container-body">
                                <div class="container-row">
                                    <span class="label">Id:</span>
                                    <input class="field form-control" value="<?= $escape($register['id_client']) ?>" readonly>
                                </div>
                                <div class="container-row">
                                    <span class="label">Edad:</span>
                                    <input class="field form-control max" value="<?= $escape($register['age']) ?>" readonly>
                                    <span class="label">Sexo:</span>
                                    <input class="field form-control max" value="<?= $escape($register['sex']) ?>" readonly>
                                    <span class="label">Fecha:</span>
                                    <input class="field form-control max" value="<?= $escape($appliedDate) ?>" readonly>
                                </div>
                                <div class="container-row">
                                    <span class="label">Baremo:</span>
                                    <form action="<?= $escape($resultUrl) ?>" method="post" id="form_baremo" class="sims-baremo-form">
                                        <input type="hidden" name="id_user" value="<?= (int) $idClient ?>">
                                        <input type="hidden" name="id_register" value="<?= (int) $register['id'] ?>">
                                        <select class="field form-control max-left" id="baremo_id" name="baremo_id" aria-label="Baremo">
                                            <?php foreach ($baremos as $baremo): ?>
                                                <option value="<?= (int) $baremo['id'] ?>" <?= (int) $baremo['active'] === 0 ? 'disabled' : '' ?> <?= (int) $register['baremo_id'] === (int) $baremo['id'] ? 'selected' : '' ?>><?= $escape($baremo['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </div>
                                <div class="container-row row-m0">
                                    <span class="label">Responsable:</span>
                                    <input class="field form-control max-left" value="<?= $escape($register['evaluador']) ?>" readonly>
                                </div>
                            </div>
                        </section>

                        <section id="contenidoPerfilGrafico" class="sims-profile-chart" aria-label="Gráfico del perfil SIMS-III">
                            <div class="sims-profile-heading">
                                <span></span>
                                <span></span>
                                <span class="sims-profile-pd">PD</span>
                                <div class="sims-profile-legend">
                                    <span>Sin sospecha de simulación</span>
                                    <span>Sospecha de simulación</span>
                                </div>
                            </div>

                            <div class="sims-profile-total">
                                <strong>Total</strong>
                                <span></span>
                                <span class="sims-profile-value"><?= (int) $simsResult['total'] ?></span>
                                <div class="sims-total-track" role="img" aria-label="Puntuación total <?= (int) $simsResult['total'] ?> de 75, punto de corte 16">
                                    <span class="sims-total-safe" style="width: <?= round(($simsResult['total_cutoff'] / 75) * 100, 2) ?>%"></span>
                                    <span class="sims-total-marker" style="left: <?= round(($simsResult['total'] / 75) * 100, 2) ?>%"></span>
                                </div>
                            </div>

                            <div class="sims-profile-scales">
                                <div class="sims-profile-labels">
                                    <?php foreach ($simsResult['scales'] as $scale): ?>
                                        <div class="sims-profile-label-row">
                                            <span class="font-medium sims-profile-name"><?= $escape($scale['name']) ?></span>
                                            <strong class="sims-profile-code"><?= $escape($scale['code']) ?></strong>
                                            <span class="sims-profile-value"><?= (int) $scale['score'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="sims-profile-plot" role="img" aria-label="Puntuaciones por escala y sus puntos de corte">
                                    <div class="ht-100 ht-sm-300" style="margin-top: 8px;height:100% !important;position:absolute;width: 100%;" id="colorss"></div>
                                </div>
                            </div>
                        </section>

                        <?php if ($baremoError !== ''): ?>
                            <div class="alert alert-danger mt-3" role="alert"><?= $escape($baremoError) ?></div>
                        <?php endif; ?>

                        <section id="contenido2" class="sims-content" aria-label="Perfil de resultados SIMS-III">
                            <div class="sims-card sims-total">
                                <div class="sims-total-score">
                                    <strong><?= (int) $simsResult['total'] ?></strong>
                                    <span>Total / 75</span>
                                </div>
                                <div class="sims-total-copy">
                                    <h2>Resultado total SIMS-III</h2>
                                    <p class="sims-interpretation"><?= $escape($totalElevatedText) ?></p>
                                    <p class="mb-0 mt-2">Respuestas registradas: <?= (int) $simsResult['answered_count'] ?>/<?= (int) $simsResult['item_count'] ?>.</p>
                                </div>
                            </div>

                            <div class="sims-card">
                                <h2>Perfil por escalas</h2>
                                <p class="text-muted">Puntuación directa por dimensión y punto de corte indicado en la hoja Perfil del protocolo.</p>
                                <?php foreach ($simsResult['scales'] as $scale): ?>
                                    <?php
                                    $scoreWidth = min(100, ($scale['score'] / 15) * 100);
                                    $cutoffPosition = min(100, ($scale['cutoff'] / 15) * 100);
                                    ?>
                                    <div class="sims-scale">
                                        <div class="sims-scale-head">
                                            <span class="sims-scale-name"><?= $escape($scale['name']) ?> (<?= $escape($scale['code']) ?>)</span>
                                            <span class="sims-scale-score"><?= (int) $scale['score'] ?>/15 · corte <?= (int) $scale['cutoff'] ?></span>
                                            <span class="sims-status <?= $scale['elevated'] ? 'elevated' : 'normal' ?>"><?= $scale['elevated'] ? 'Alcanza el corte' : 'Bajo el corte' ?></span>
                                        </div>
                                        <div class="sims-track" role="img" aria-label="<?= $escape($scale['name']) ?>: <?= (int) $scale['score'] ?> puntos; corte <?= (int) $scale['cutoff'] ?>">
                                            <div class="sims-track-fill <?= $scale['elevated'] ? 'is-elevated' : '' ?>" style="width: <?= $scoreWidth ?>%"></div>
                                            <span class="sims-track-cutoff" style="left: <?= $cutoffPosition ?>%"></span>
                                        </div>
                                        <div class="sims-track-legend"><span>0</span><span>15 puntos posibles · línea = punto de corte</span></div>
                                        <p class="sims-scale-interpretation mb-0 mt-2"><?= $escape($scale['interpretation']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="sims-card">
                                <h2>Interpretación del perfil</h2>
                                <?php if (count($simsResult['elevated_scales']) === 0): ?>
                                    <p class="sims-interpretation">Ninguna de las cinco escalas alcanza su punto de corte según el protocolo. El perfil no muestra elevaciones en las dimensiones evaluadas.</p>
                                <?php else: ?>
                                    <p class="sims-interpretation mb-3">Las siguientes dimensiones alcanzan o superan el punto de corte y se ordenan de mayor a menor puntuación:</p>
                                    <?php foreach ($simsResult['elevated_scales'] as $scale): ?>
                                        <div class="sims-flags">
                                            <h3><?= $escape($scale['name']) ?> (<?= $escape($scale['code']) ?>): <?= (int) $scale['score'] ?> puntos</h3>
                                            <p class="sims-interpretation mb-0"><?= $escape($scale['interpretation']) ?> El patrón debe valorarse junto con otras fuentes de información; por sí solo no establece un diagnóstico de simulación.</p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="sims-card">
                                <h2>Respuestas llamativas u omitidas</h2>
                                <p class="text-muted">Se muestran las respuestas que coinciden con los indicadores atípicos del protocolo y los ítems sin respuesta.</p>
                                <?php if (count($simsResult['flags']) === 0): ?>
                                    <p class="mb-0">No se registran respuestas llamativas ni omisiones.</p>
                                <?php else: ?>
                                    <?php foreach ($simsResult['scales'] as $scale): ?>
                                        <?php if (!empty($flagsByScale[$scale['code']])): ?>
                                            <div class="sims-flags">
                                                <h3><?= $escape($scale['name']) ?> (<?= $escape($scale['code']) ?>) · <?= count($flagsByScale[$scale['code']]) ?>/15</h3>
                                                <?php foreach ($flagsByScale[$scale['code']] as $flag): ?>
                                                    <p class="sims-flag-item"><strong>Ítem <?= (int) $flag['item'] ?>.</strong> <?= $escape($flag['question']) ?> <span class="text-muted">— <?= $flag['omitted'] ? 'Omitido' : 'Respuesta: ' . $escape($flag['response']) ?></span></p>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <?php if ($simsResult['answered_count'] < $simsResult['item_count']): ?>
                                <div class="sims-note mb-4">El protocolo contiene respuestas omitidas o inválidas. La puntuación total y las escalas se calcularon con las respuestas válidas disponibles; interpreta el perfil con cautela.</div>
                            <?php endif; ?>
                            <div class="sims-note mb-4">El SIMS-III es un instrumento de cribado. Sus puntuaciones no constituyen por sí solas un diagnóstico y deben integrarse con una evaluación profesional y otras fuentes de información.</div>
                        </section>

                        <div class="sims-download text-right mb-5">
                            <button id="btnDownload" type="button" onclick="descargarPDF()" class="btn btn-primary">
                                <span id="btnText">DESCARGAR PDF</span>
                                <span id="btnLoader" style="display:none; margin-left:8px;">⏳</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include('../include/footer.php'); ?>
    </div>

    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/plugins/jquery.flot/jquery.flot.js"></script>
    <script src="../../assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>
    <script src="../../assets/js/custom.js?v=<?= $escape(VERSION_CODE) ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const name_user = <?= json_encode((string) $register['id_client'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
        const filenamepdf = (name_user + '_SIMS-III').replace(/\s+/g, '');
        const profileChartData = <?= json_encode($profileChartPoints, JSON_NUMERIC_CHECK) ?>;
        const profileScales = <?= json_encode(array_map(static function ($scale) {
                                    return ['cutoff' => (int) $scale['cutoff']];
                                }, $simsResult['scales']), JSON_NUMERIC_CHECK) ?>;
        const jsonpdf = [{
                type: 2,
                image: 'contenido1'
            },
            {
                type: 2,
                image: 'contenidoPerfilGrafico'
            }
        ];
        const reportCards = document.querySelectorAll('#contenido2 > .sims-card');

        reportCards.forEach(function(card) {
            const heading = card.querySelector('h2');
            if (heading) {
                jsonpdf.push({
                    type: 7,
                    text: heading.innerText.trim()
                });
            }

            if (card.classList.contains('sims-total')) {
                const score = card.querySelector('.sims-total-score')?.innerText.trim();
                if (score) jsonpdf.push({
                    type: 5,
                    text: score.replace(/\n+/g, ' ')
                });
                card.querySelectorAll('.sims-total-copy p').forEach(function(paragraph) {
                    jsonpdf.push({
                        type: 5,
                        text: paragraph.innerText.trim()
                    });
                });
                return;
            }

            card.querySelectorAll('.sims-scale').forEach(function(scale) {
                const name = scale.querySelector('.sims-scale-name')?.innerText.trim() || '';
                const score = scale.querySelector('.sims-scale-score')?.innerText.trim() || '';
                const status = scale.querySelector('.sims-status')?.innerText.trim() || '';
                jsonpdf.push({
                    type: 8,
                    text: `${name}: ${score} (${status}).`
                });
                const interpretation = scale.querySelector('.sims-scale-interpretation')?.innerText.trim();
                if (interpretation) jsonpdf.push({
                    type: 8,
                    text: interpretation
                });
            });

            card.querySelectorAll(':scope > p, .sims-flags').forEach(function(block) {
                if (block.classList.contains('sims-flags')) {
                    const subheading = block.querySelector('h3')?.innerText.trim();
                    if (subheading) jsonpdf.push({
                        type: 7,
                        text: subheading
                    });
                    block.querySelectorAll('p').forEach(function(paragraph) {
                        jsonpdf.push({
                            type: 8,
                            text: paragraph.innerText.trim()
                        });
                    });
                    return;
                }
                jsonpdf.push({
                    type: 5,
                    text: block.innerText.trim()
                });
            });
        });

        document.querySelectorAll('#contenido2 > .sims-note').forEach(function(note) {
            jsonpdf.push({
                type: 5,
                text: note.innerText.trim()
            });
        });

        document.getElementById('baremo_id')?.addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });

        $(function() {
            'use strict';

            const series = [{
                data: profileChartData,
                lines: {
                    show: true,
                    lineWidth: 2
                },
                points: {
                    show: true,
                    radius: 5,
                    fill: true,
                    fillColor: '#000',
                    lineWidth: 2
                },
                color: '#000'
            }];
            const markings = [];

            profileScales.forEach(function(scale, index) {
                const y = profileScales.length - index - 1;
                markings.push({
                    xaxis: {
                        from: 0,
                        to: scale.cutoff
                    },
                    yaxis: {
                        from: y - 0.5,
                        to: y + 0.5
                    },
                    color: '#43b59b'
                }, {
                    xaxis: {
                        from: scale.cutoff,
                        to: 15
                    },
                    yaxis: {
                        from: y - 0.5,
                        to: y + 0.5
                    },
                    color: '#ffe2bf'
                });
            });

            for (let y = 0.5; y < profileScales.length - 0.5; y += 1) {
                markings.push({
                    yaxis: {
                        from: y,
                        to: y
                    },
                    color: '#fff',
                    lineWidth: 2
                });
            }

            $.plot('#colorss', series, {
                grid: {
                    hoverable: false,
                    clickable: false,
                    borderWidth: 0,
                    borderColor: 'white',
                    markings: markings
                },
                xaxis: {
                    min: 0,
                    max: 15,
                    position: 'top',
                    show: false
                },
                yaxis: {
                    min: -0.5,
                    max: profileScales.length - 0.5,
                    show: false
                }
            });
        });
    </script>
    <script src="../../assets/js/print.js?v=<?= $escape(VERSION_CODE) ?>"></script>
</body>

</html>