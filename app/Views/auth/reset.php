<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Favicon icon-->
  <link rel="icon" href="<?php echo base_url("login/img/log_turing.webp"); ?>" type="image/x-icon" />
  <!-- Core Css -->
  <link rel="stylesheet" href="<?php echo base_url("login/login2/style.css"); ?>" />
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <!-- Title -->
  <title>People Analytics</title>
</head>

<style>


  #main-wrapper {
   /* background-color:  rgb(241, 242, 242); */
   /* background-color:  #FFFFFF; */
  }

  body.loading::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: #ffffff;
    /* Cambiado a blanco sólido */
    z-index: 999;
    /* Asegura que el fondo esté detrás del spinner */
  }

  #loading-spinner {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    z-index: 1000;
  }

  @keyframes pulse {

    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(0.8);
    }
  }

  .spinner {
    width: 350px;
    height: 350px;
    animation: pulse 1s ease-in-out infinite;
    z-index: 1001;
  }
</style>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="#!" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper" class="auth-customizer-none">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
      <div class="position-relative z-index-5">
        <div class="row">
          <div class="col-xl-7 col-xxl-8">
            <a href="https://www.turing-ia.com/" class="text-nowrap logo-img d-block px-4 py-9 w-100" target="_blank">
              <!-- <img src="<?php echo base_url("gifs/fondo.png"); ?>" class="dark-logo" alt="Logo-Dark" width="45px"/> -->
              <!-- <div class="alert alert-info alert-dismissable">
                <strong>People Analytics</strong> mejoró la página de inicio de sesión para un diseño más moderno. <br>
              </div> -->
            </a>
            <div class="d-none d-xl-flex align-items-center justify-content-center h-n80">
              
              <img src="https://cdn-icons-png.flaticon.com/512/6195/6195699.png" alt="modernize-img" class="img-fluid" width="500">
            </div>
          </div>
          <div class="col-xl-5 col-xxl-4">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
              <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
                <h2 class="mb-1 fs-6 fw-bolder text-center">Bienvenido a People Analytics</h2>
                <p class="mb-7 text-center">Guarda tu nueva contraseña </p>
                <div class="row">
                  <div class="col-12 mb-2 mb-sm-0">
                    <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                      href="javascript:void(0)" role="button">
                      <img src="<?php echo base_url("gifs/fondo.png"); ?>"
                        alt="modernize-img" class="img-fluid me-2" width="28" height="28">
                      <span class="flex-shrink-0"></span>
                    </a>
                  </div>
                  <!-- <div class="col-6">
                    <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                      <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/facebook-icon.svg" alt="modernize-img" class="img-fluid me-2" width="18" height="18">
                      <span class="flex-shrink-0">with FB</span>
                    </a>
                  </div> -->
                </div>
                <div class="position-relative text-center my-4">
                  <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">Para iniciar sesión</p>
                  <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div>
                <form id="login-form" action="<?php echo base_url('/validpass'); ?>" method="POST">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ingresa tu nueva contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" 
                      required autofocus>
                      <input type="hidden" name="id_usuario" class="form-control form-control-lg"
                        value="<?= $id_usuario ?>" />
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Valida tu contraseña</label>
                    <input type="password" id="password" name="vpassword"  class="form-control" required>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Recuperar</button>
                  <div class="d-flex align-items-center justify-content-center">
                  <a href="<?php echo base_url("/"); ?>" class="btn bg-primary-subtle text-primary w-100 py-8">Regresar al inicio</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div id="loading-spinner" class="text-center">
    <div class="spinner-overlay"></div>
    <img src="<?php echo base_url("gifs/logo.svg"); ?>" class="spinner" alt="Spinner">
    <br>
    <br>
    <br>
    <br>
    <h4>Recuperando información...</h4>
  </div>

  <!-- Import Js Files -->
  <script src="<?php echo base_url("login/login2/bootstrap.bundle.min.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/simplebar.min.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/app.init.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/theme.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/app.min.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/sidebarmenu.js"); ?>"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  jQuery(document).ready(function ($) {
    // Captura el evento de envío del formulario
    $('#login-form').submit(function (event) {
      // Evita que el formulario se envíe de forma predeterminada
      event.preventDefault();

      // Agrega la clase 'loading' al body para aplicar el fondo blanco
      $('body').addClass('loading');

      // Muestra el spinner
      $('#loading-spinner').show();

      // Envía el formulario después de un breve retraso
      setTimeout(function () {
        $('#login-form')[0].submit();
      }, 2000);
    });
  });
</script>



<?php
$session = session();
$error_message = $session->getFlashdata('success_message');
if (!empty($error_message)) {
  echo '<script>';
  echo 'Swal.fire({';
  echo '    icon: "success",';
  echo '    title: "¡Enhorabuena!",';
  echo '    confirmButtonColor: "#092e50",';
  echo '    confirmButtonText: "INTENTARLO DE NUEVO",';
  echo '    text: "' . esc($error_message) . '"';
  echo '});';
  echo '</script>';
}
$error_message = $session->getFlashdata('error_message');
if (!empty($error_message)) {
  echo '<script>';
  echo 'Swal.fire({';
  echo '    icon: "error",';
  echo '    title: "Algo salio mal!",';
  echo '    confirmButtonColor: "#092e50",';
  echo '    confirmButtonText: "INTENTARLO DE NUEVO",';
  echo '    text: "' . esc($error_message) . '"';
  echo '});';
  echo '</script>';
}
?>

</body>

</html>