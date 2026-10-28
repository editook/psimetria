<?php
include_once('../configs.php');
session_start();
require_once '../../vendor/autoload.php';
// SIMS
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
    ? 'indica que presenta un patrón de respuesta de sospecha de simulación o exageración de síntomas psicopatológicos o neurocognitivos. Ha respondido afirmativamente a un número elevado de ítems que describen síntomas atípicos, improbables o ilógicas de diversos trastornos. Esta elevación en la puntuación total supera al puntaje de corte (16). Lo que lo identifica como probable simulador. El patrón de respuestas observado refleja una tendencia sistemática a exagerar síntomas inconsistentes o improbables, lo que constituye un indicador significativo de posible falseamiento. Se recomienda una evaluación más extensa y exhaustiva con el fin de confirmar esta sospecha. Es muy importante señalar que el SIMS no es una prueba diagnóstica y, por lo tanto, no puede establecerse el diagnóstico de simulación aisladamente a partir de sus puntuaciones. Se requiere la convergencia de otras fuentes de información y evaluaciones para este propósito.'
    : 'indica que no presenta un patrón de respuesta con la simulación o exageración de síntomas psicopatológicos o neurocognitivos. Ha respondido de manera consistente a los ítems que evalúan síntomas atípicos, improbables o ilógicos de diversos trastornos. No se requiere una evaluación más exhaustiva de la posible simulación de síntomas, dado que la probabilidad de falseamiento es baja.';
$totalProfileInterpretation = 'La puntuación total del SIMS proporciona una estimación general de la probabilidad de que esté fingiendo síntomas psicopatológicos o alteraciones neurocognitivas. '
    . $register['id_client'] . ' obtuvo una puntuación de ' . (int) $simsResult['total'] . ', lo que ' . $totalElevatedText;
$profileInterpretations = [];
foreach ($simsResult['elevated_scales'] as $rank => $scale) {
    $descriptor = $scale['excel_label'];
    $score = (int) $scale['score'];
    if ($rank === 0) {
        $profileInterpretations[] = 'El perfil del SIMS refleja principalmente un patrón centrado en la presentación de síntomas '
            . $descriptor . '. Se obtuvo una puntuación de ' . $score . ', lo que ' . $scale['interpretation'];
    } elseif ($rank === 1) {
        $profileInterpretations[] = 'También se observa la presencia de síntomas ' . $descriptor
            . ', con una puntuación de ' . $score . ', lo que ' . $scale['interpretation'];
    } elseif ($rank === 2) {
        $profileInterpretations[] = 'Además, se observa la presencia de síntomas ' . $descriptor
            . ', con una puntuación de ' . $score . ', lo que ' . $scale['interpretation'];
    } elseif ($rank === 3) {
        $profileInterpretations[] = 'De igual manera, se observa la presencia de síntomas ' . $descriptor
            . ', con una puntuación de ' . $score . ', lo que ' . $scale['interpretation'];
    } else {
        $profileInterpretations[] = 'De igual manera, se observa la presencia de síntomas ' . $descriptor
            . '; con una puntuación de ' . $score . ', lo que ' . $scale['interpretation'];
    }
}
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
            color: black;
            font-family: "Ronnia Regular", Arial, sans-serif;
        }

        .sims-card {
            background: #fff;
            border-radius: 12px;
            margin-bottom: 18px;
            padding: 20px;
            text-align: justify;
        }

        .sims-card h2 {
            color: black;
            font-weight: 700;
            margin: 0 0 14px;
        }

        .sims-card h2 {
            font-size: 21px;
        }

        .sims-interpretation {
            line-height: 1.6;
            margin: 0;
        }

        .sims-flag-item {
            line-height: 1.45;
            margin: 6px 0;
        }

        #contenidoID {
            left: -10000px;
            position: absolute;
            top: 0;
            width: 900px;
            z-index: -1;
        }

        @media (max-width: 767px) {
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
            <br>
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
                                <div class="sims-logo">
                                    <img src="../../assets/img/test_image/sims.png?v=<?= VERSION_CODE ?>" class="img-logo">
                                </div>
                            </div>
                            <div class="container-body">
                                <div class="container-row">
                                    <span class="label">Id:</span>
                                    <input class="field form-control" value="<?= $escape($register['id_client']) ?>" readonly>
                                </div>
                                <div class="container-row">
                                    <span class="label">Edad:</span>
                                    <input class="field form-control max" value="<?= $escape($register['age']) ?> años" readonly>
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
                                <div class="sims-total-track">
                                    <div id="graphics_section1" aria-hidden="true"></div>
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

                                <div class="sims-profile-plot">
                                    <div id="graphics_section2" aria-hidden="true"></div>
                                </div>
                            </div>
                        </section>

                        <?php if ($baremoError !== ''): ?>
                            <div class="alert alert-danger mt-3" role="alert"><?= $escape($baremoError) ?></div>
                        <?php endif; ?>

                        <section id="contenido2" class="sims-content" aria-label="Perfil de resultados SIMS-III">



                            <div class="sims-card">

                                <p class="sims-interpretation"><?= $escape($totalProfileInterpretation) ?></p>
                                <?php foreach ($profileInterpretations as $interpretation): ?>
                                    <p class="sims-interpretation"><?= $escape($interpretation) ?></p>
                                    <br>
                                <?php endforeach; ?>
                            </div>

                            <div class="sims-card">
                                <h1 class="uppercase">Respuestas llamativas/omitidas</h1>


                                <?php if (count($simsResult['flags']) === 0): ?>
                                    <p class="mb-0">No se registran respuestas llamativas ni omisiones.</p>
                                <?php else: ?>
                                    <?php foreach ($simsResult['scales'] as $scale): ?>
                                        <?php if (!empty($flagsByScale[$scale['code']])): ?>
                                            <h2><?= $escape($scale['name']) ?> (<?= $escape($scale['code']) ?>) ( <?= count($flagsByScale[$scale['code']]) ?>/15)</h2>
                                            <?php foreach ($flagsByScale[$scale['code']] as $flag): ?>
                                                <p class="sims-flag-item"><?= $flag['item']  ?>.- <?= $escape($flag['question']) ?> (<?= $flag['omitted'] ? 'Omitido' : $escape($flag['response']) ?>)</p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                        </section>

                    </div>
                </div>
            </div>
        </main>

        <?php include('../include/footer.php'); ?>
    </div>
    <?php include("../include/print_content.php"); ?>
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/plugins/jquery.flot/jquery.flot.js"></script>
    <script src="../../assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar.js"></script>
    <script src="../../assets/js/custom.js?v=<?= $escape(VERSION_CODE) ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const name_user = <?= json_encode((string) $register['id_client'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
        const filenamepdf = (name_user + '_SIMS-III').replace(/\s+/g, '');
        const totalChartData = [
            [<?= (int) $simsResult['total'] ?>, 0.5]
        ];
        const totalCutoff = <?= (int) $simsResult['total_cutoff'] ?>;
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
            Array.from(card.children).forEach(function(element) {
                const text = element.innerText.trim();
                if (!text) return;

                if (element.matches('h1, h2')) {
                    jsonpdf.push({
                        type: 7,
                        text: text
                    });
                    jsonpdf.push({
                        type: 5,
                        text: ''
                    });
                    return;
                }

                if (element.matches('p')) {
                    jsonpdf.push({
                        type: 5,
                        text: text
                    });
                    if (element.classList.contains('sims-interpretation')) {
                        jsonpdf.push({
                            type: 5,
                            text: ''
                        });
                    }
                }
            });
            jsonpdf.push({
                type: 5,
                text: ''
            });
        });

        document.getElementById('baremo_id')?.addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });

        $(function() {
            'use strict';

            $.plot('#graphics_section1', [{
                data: totalChartData,
                lines: {
                    show: false
                },
                points: {
                    show: true,
                    radius: 5,
                    fill: true,
                    fillColor: '#000',
                    lineWidth: 2
                },
                color: '#000'
            }], {
                grid: {
                    margin: {
                        top: 6,
                        bottom: 6,
                        left: 12,
                        right: 12
                    },
                    minBorderMargin: 0,
                    hoverable: false,
                    clickable: false,
                    borderWidth: 0,
                    borderColor: 'white',
                    markings: [{
                        xaxis: {
                            from: 0,
                            to: totalCutoff
                        },
                        yaxis: {
                            from: 0,
                            to: 1
                        },
                        color: '#43b59b'
                    }, {
                        xaxis: {
                            from: totalCutoff,
                            to: 75
                        },
                        yaxis: {
                            from: 0,
                            to: 1
                        },
                        color: '#ffe2bf'
                    }]
                },
                xaxis: {
                    min: 0,
                    max: 75,
                    show: false
                },
                yaxis: {
                    min: 0,
                    max: 1,
                    show: false
                }
            });

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


            $.plot('#graphics_section2', series, {
                grid: {
                    margin: {
                        top: 12,
                        bottom: 12,
                        left: 12,
                        right: 12
                    },
                    minBorderMargin: 0,
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