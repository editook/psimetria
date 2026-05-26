<?php
include_once('../configs.php');

session_start();
include('../connection.php');
include("../models/model_user.php");
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_baremo.php");
include("../models/model_answer.php");

$registerModel = new Register_Model();
$questionModel = new Question_Model();
$baremoModel = new Baremo_Model();
$answerModel = new Answer_Model();
$userModel = new User_Model();

if (!isset($_SESSION['REST_type_user'])) {
    header("Location: " . LOCALHOST . "/signin.php");
}

if (($_SESSION['REST_type_user'] == 'Administrador') && (isset($_POST['id_type']) && isset($_POST['type_show_result']))) {

    $idRegister = $registerModel->updateStatusShowResult($_POST['id_type'], $_POST['type_show_result']);

    header("Location: " . LOCALHOST . "/view/configuration.php");
}

$typeQuestions = $questionModel->getAllTypeQuestion();

foreach ($typeQuestions as &$value) {
    $value['name'] = htmlspecialchars($value['name']);
    $value['visible'] = $value['type_status']
        ? 'Visible'
        : 'No visible';
    $value['name_short'] = substr($value['name'], 0, 1);
    $value['mantenimiento'] = $value['type_show_result']
        ? 'Mostrando Graficas'
        : 'Actualizando/Mantenimiento';
}
unset($value);

$typeQuestionBaremos_response = $questionModel->getAllTypeQuestionBaremo();
$grouped = [];
$array_color = ['primary','pink','success','warning','teal','danger','primary','pink','success','warning','teal','danger','primary','pink','success','warning','teal','danger','primary','pink','success','warning','teal','danger'];
$count = count($array_color);
$index = 0;

foreach ($typeQuestionBaremos_response as $item) {

    $idType = $item['id_type_question_name'];

    if (!isset($grouped[$idType])) {

        $grouped[$idType] = [

            'id_type_question' => $item['id_type_question_name'],
            'type_question_name' => $item['type_question_name'],
            'value_data' => $item['value_data'],
            'baremos' => []
        ];
    }

    $grouped[$idType]['baremos'][] = [

        'id_baremo' => $item['id_baremo'],
        'baremo_name' => $item['baremo_name'],
        'active_baremo' => $item['active_baremo'],
        'color' => $array_color[$index]

    ];
    $index++;
    if($index==$count){
        $index = 0;
    }
}
$alto = 78 * count($grouped);
?>

<!DOCTYPE html>
<html lang="es">

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

    <style>
       #base,
        #base2{
            display: flex;
        }

        #base > div,
        #base2 > div{
            width: 100%;
            max-height: <?= $alto ?>px;
        }

        #base2 .scroll-content{
            overflow-y: auto;
            max-height: <?= $alto ?>px;
        }
    </style>

</head>

<body class="main-body">
    <div id="global-loader">
        <img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <div class="page <?= TESTING == '1' ? 'istesting' : '' ?>">
        <?php include("../include/header_top.php"); ?>
        <!-- /main-header -->
        <!--Horizontal-main -->
        <?php include("../include/header_bottom.php"); ?>
        <div class="main-content horizontal-content">
            <div class="container containermobile">
                <br>
                <div class="row row-sm align-items-stretch">
                    <div id="base" class="col-xl-5 col-md-12 col-lg-6">
                        <div class="card" >
                            <div class="card-header pb-1">
                                <h3 class="card-title mb-2">Instrumentos Psicométricos</h3>
                                <p class="tx-12 mb-0 text-muted">Configuración de estados</p>
                            </div>
                            <form action="configuration.php" method="post" id="form_type_show_result" style="margin:0;width: 100%;">
                                <input type="hidden" name="id_type" id="id_type" value="">
                                <input type="hidden" name="type_show_result" id="type_show_result" value="">
                            </form>
                            <div class="product-timeline card-body pt-2 mt-1">
                                <ul class="timeline-1 mb-0">
                                    <?php
                                    
                                    foreach ($typeQuestions as &$value) {
                                    ?>
                                        <li class="mt-0" id="mrg-8">
                                            <i class="si bg-success-gradient text-white product-icon">#<?= $value['id'] ?></i>
                                            <span class="fw-semibold tx-14 "><?= $value['name'] ?></span>
                                            <div class="float-end tx-12">
                                                <div class="mb-xl-0">
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn" style="background: #f7f7f7 !important;color: black !important;"><?= $value['mantenimiento'] ?></button>
                                                        <button type="button" class="btn  dropdown-toggle dropdown-toggle-split" style="background: #f7f7f7 !important;color: black !important;" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate" x-placement="bottom-end">
                                                            <button class="dropdown-item" onclick="changeShowResult(<?= $value['id'] ?>,1)">Mostrando Graficas</button>
                                                            <button class="dropdown-item" onclick="changeShowResult(<?= $value['id'] ?>,0)">Actualizando/Mantenimiento</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <p class="mb-0 text-muted tx-12"><?= $value['visible'] ?></p>

                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="base2" class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
                        <div class="card latest-tasks scroll-content">
                            <div class="">
                               
                                <div class="card-header pb-1">
                                    <h3 class="card-title mb-2">Baremos</h3>
                                    <p class="tx-12 mb-0 text-muted">Lista oficial de baremos activos/inactivos</p>
                                </div>
                                <div class="">
                                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-bold" role="tablist">
                                        <?php $firstTab = true; foreach ($grouped as $group): ?>

                                        <li class="nav-item">
                                            <a class="nav-link <?= $firstTab ? 'active show' : '' ?>" data-bs-toggle="tab" href="#tasktab-<?= $group['id_type_question'] ?>" role="tab" aria-selected="false">
                                                <?= $group['type_question_name'] ?>
                                            </a>
                                        </li>
                                        <?php $firstTab = false; endforeach; ?>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pt-3">
                                <div class="tab-content">
                                    <?php $firstPane = true; foreach ($grouped as $group): ?>
                                    <div class="tab-pane fade <?= $firstPane ? 'active show' : '' ?>" id="tasktab-<?= $group['id_type_question'] ?>" role="tabpanel">
                                        <div>
                                            <?php foreach ($group['baremos'] as $baremo): ?>
                                            <div class="tasks">
                                                <div class=" task-line <?= $baremo['color'] ?>">
                                                    <a href="#" class="span">
                                                        <?= $baremo['baremo_name'] ?>
                                                    </a>
                                                    <div class="time">
                                                        <?= $baremo['active_baremo']?'Activo':'Inactivo' ?>
                                                    </div>
                                                </div>
                                                <label class="checkbox">
                                                    <span class="check-box">
                                                        <span class="ckbox"><input checked type="checkbox"><span></span></span>
                                                    </span>
                                                </label>
                                            </div>
                                            <?php endforeach; ?>
                                            
                                        </div>
                                    </div>
                                    <?php $firstPane = false; endforeach; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include("../include/footer.php"); ?>
    </div>
    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    <!-- JQuery min js -->
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>

    <!--Internal  Datepicker js -->
    <script src="../../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

    <!-- Bootstrap Bundle js -->
    <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

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
    <script>
        function changeShowResult(id, changeShowResult) {
            const input = document.getElementById("type_show_result");
            input.value = changeShowResult;
            const type = document.getElementById("id_type");
            type.value = id;
            const form = document.getElementById("form_type_show_result");
            form.submit();
        }
    </script>
</body>

</html>