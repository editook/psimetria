<?php
include_once('../configs.php');
require_once '../connection.php';
require_once '../models/model_user.php';
session_start();

if (empty($_SESSION['REST_id_user'])) {
    header('Location: ' . LOCALHOST . '/signin.php');
    exit;
}
if (empty($_SESSION['password_csrf'])) {
    $_SESSION['password_csrf'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['password_csrf'];


$userModel = new User_Model();
$success = isset($_GET['ok']) && $_GET['ok'] == '1';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postedToken = $_POST['csrf_token'] ?? '';


    if (!is_string($postedToken) ||
        !hash_equals($csrfToken, $postedToken)) {

        $error = 'La solicitud expiró. Vuelve a intentarlo.';

    } else {

        $id      = (int) $_SESSION['REST_id_user'];
        $current = (string) ($_POST['current_password'] ?? '');
        $new     = (string) ($_POST['new_password'] ?? '');
        $confirm = (string) ($_POST['confirm_password'] ?? '');



        if (!empty($faltan = $userModel->validarContrasena($new))) {

            $error = implode(' ', $faltan);

        } elseif ($new !== $confirm) {

            $error = 'La verificación no coincide con la nueva contraseña.';

        } elseif (!$userModel->verifyPassword($id, $current)) {

            $error = 'La contraseña actual es incorrecta.';

        } elseif ($userModel->updatePassword($id, $new)) {

            session_regenerate_id(true);

            header('Location: ' . LOCALHOST . '/view/password.php?ok=1');
            exit;

        } else {

            $error = 'No se pudo actualizar la contraseña.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
  <meta name="Author" content="Spruko Technologies Private Limited">
  <meta name="Keywords"
    content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

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
  #base2 {
    margin-top: 30px;
  }

  #base2 .card {
    padding: 20px;
    border-radius: 10px;
  }

  .btn-cambiar {
    width: 250px;
    display: block;
    margin: 20px auto 0;
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
        <div class="row row-sm justify-content-center">
          <div id="base2" class="col-lg-7  col-md-9 col-sm-12">
            <div class="card latest-tasks scroll-content">


              <?php if ($success): ?>
              <div class="alert alert-success">Contraseña cambiada correctamente.</div>
              <?php endif; ?>

              <?php if ($error !== ''): ?>
              <div class="alert alert-danger">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
              </div>
              <?php endif; ?>


              <form action="password.php" method="POST">

                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">


                <div class="form-group">
                  <label for="current_password"><strong>Ingresa tu contraseña actual</strong></label>
                  <input type="password" id="current_password" name="current_password" class="form-control campo"
                    placeholder="" required>
                </div>


                <div class="form-group">
                  <label for="new_password"><strong> Nueva contraseña</strong></label>
                  <input type="password" id="new_password" name="new_password" class="form-control campo" minlength="8"
                    placeholder="" required>
                </div>


                <div class="form-group">
                  <label for="confirm_password"><strong> Verifica la contraseña</strong></label>
                  <input type="password" id="confirm_password" name="confirm_password" class="form-control campo"
                    placeholder="" minlength="8" title="Repite exactamente la nueva contraseña" required>
                </div>

                <button type="submit" class="btn btn-main-primary btn-block btn-cambiar">
                  Cambiar Contraseña
                </button>

              </form>
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
  document.querySelectorAll('.action_check').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      var active = 0;
      if (this.checked) {
        active = 1;
      }
      const input = document.getElementById("active");
      input.value = active;
      const type = document.getElementById("id_baremo");
      type.value = this.dataset.id;
      const form = document.getElementById("form_baremo");
      form.submit();
    });
  });

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
