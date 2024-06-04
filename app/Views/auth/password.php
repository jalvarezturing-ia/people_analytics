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
    /* font-family: "Century Gothic"; */
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
          <div class="col-lg-6 col-xl-8">
            <a href="https://www.turing-ia.com/" class="text-nowrap logo-img d-block px-4 py-9 w-100"
              target="_blank"></a>
            <div class="d-none d-xl-flex align-items-center justify-content-center h-n80">
              <img
                src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/backgrounds/login-security.svg"
                alt="modernize-img" class="img-fluid" width="700">
              <!-- <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/backgrounds/login-security.svg" alt="modernize-img" class="img-fluid" width="500"> -->
            </div>
          </div>
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
              <div class="auth-max-width mx-auto d-flex align-items-center w-100 h-100">
                <div class="card-body">
                  <div class="mb-5">
                    <h2 class="fw-bolder fs-7 mb-3  text-center">Olvidaste tu contraseña<a href="#"
                        onclick="help(event)">?</a></h2>
                    <p class="mb-0 text-center">
                      Introduce la dirección de correo electrónico y el número de teléfono asociada a tu cuenta y le
                      enviaremos un enlace para restablecer su contraseña.
                    </p>
                  </div>
                  <form id="login-form" action="<?php echo base_url('/forget/validmail'); ?>" method="POST">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                      <input type="email" id="email" name="email" class="form-control"
                        value="<?= session('email') ?? '' ?>" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-4">
                      <label for="exampleInputPassword1" class="form-label">Teléfono</label>
                      <input type="number" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 mb-3">Enviar</button>
                    <a href="<?php echo base_url("/"); ?>"
                      class="btn bg-primary-subtle text-primary w-100 py-8">Regresar al inicio</a>
                  </form>
                </div>
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
    <h4>Tu equipo, tus datos, tu portal: <strong>Bienvenido a People Analytics.</strong></h4>
  </div>

  <!-- Import Js Files -->
  <script src="<?php echo base_url("login/login2/bootstrap.bundle.min.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/simplebar.min.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/app.init.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/theme.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/app.min.js"); ?>"></script>
  <script src="<?php echo base_url("login/login2/sidebarmenu.js"); ?>"></script>


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
        }, 1000);
      });
    });
  </script>


  <script>
    function help(event) {
      event.preventDefault(); // Evita que el enlace realice su accion predeterminada
      Swal.fire({
        title: '¿Cómo recupero mi contraseña?',
        text: '1. Ingresa tu correo de @turing-ia.com/@turing-latam.com\n2. Ingresa tu número de teléfono sin espacios y te llegaran instrucciones a tu correo para poder restablecer la contraseña.',
        icon: 'warning',
        confirmButtonColor: '#1371C7',
        confirmButtonText: "¡Gracias por la información!",
      });
    }
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