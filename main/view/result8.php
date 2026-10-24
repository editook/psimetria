<?php
include_once('../configs.php');
// SIMS III Result View
session_start();
require '../../vendor/autoload.php';

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");
include("../models/mcmi/model_sims_configuration.php");

$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$mcmiConfig = new ModelSimsConfiguration();

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
// valor 1 verdadero, valor 0 falso
$answers = $answerModel->getAll($register['codes']);


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
    <link href="../../assets/css/style_result8.css?v=<?= VERSION_CODE ?>" rel="stylesheet">
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


        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });
    </script>
    <script src="../../assets/js/print.js?v=<?= VERSION_CODE ?>"></script>
</body>

</html>