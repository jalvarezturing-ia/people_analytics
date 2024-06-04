<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>People Analytics</title>
  <!-- MDB icon -->
  <link rel="icon" href="<?php echo base_url("login/img/log_turing.webp"); ?>" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="<?php echo base_url("login/css/bootstrap-login-form.min.css"); ?>" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>


<style>


@media (max-width: 768px) 
    {

      .vh-100 {
      /* Establece la imagen de fondo y ajusta las propiedades según sea necesario */
  
      background-image: url('<?php echo base_url("gifs/logo.svg"); ?>');
      background-size: cover; /* Cubre todo el fondo sin distorsionar la imagen */
      background-position: center; /* Centra la imagen en el fondo */
      background-repeat: no-repeat; /* Evita la repetición de la imagen */
      height: 100vh; /* Altura del 100% de la ventana visible */
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      background-color: rgba(255, 255, 255, 2)
    }


        
    }
  body {
    font-family: "Century Gothic";
  }

  body.loading::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: #ffffff; /* Cambiado a blanco sólido */
        z-index: 999; /* Asegura que el fondo esté detrás del spinner */
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
    0%, 100% {
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
  <!-- Start your project here-->
  <section class="vh-100" style="background-color: #FFFFF;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="<?php echo base_url("gifs/logo.svg"); ?>" alt="login form" class="img-fluid"
                  style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                  <form id="login-form" action="<?php echo base_url('/forget/validmail'); ?>" method="POST">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <span class="h1 fw-bold mb-0" style="color: #1371C7; ">Turing-IA People Analitycs</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="text-align:center;">Restablecimiento de contraseña <a href="#" onclick="help(event)"><i class="fas fa-question" ></i></a></h5>

                    <div class="form-outline mb-4">
                      <input type="email" id="email" name="email" class="form-control form-control-lg" required
                        value="<?= session('email') ?? '' ?>" />
                      <label class="form-label" for="form2Example17">Correo electrónico</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="number"id="telefono" name="telefono" class="form-control form-control-lg"
                        required />
                      <label class="form-label" for="form2Example27">Teléfono</label>
                    </div>

                    <div class="d-flex justify-content-around align-items-center mb-4">
                    <a href="<?php echo base_url("/"); ?>" style="color: #004aad; ">Ya tengo acceso</a>
                    </div>
                    <div class="pt-1 mb-4">
                      <button type="submit" class="btn btn-primary btn-lg"
                        style="display: block; margin: 0 auto; background-color: #1371C7; ">Enviar correo</button>
                    </div>


                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End your project here-->
  <div id="loading-spinner" class="text-center">
    <div class="spinner-overlay"></div>
    <img src="<?php echo base_url("gifs/logo.svg"); ?>" class="spinner" alt="Spinner">
    <br>
    <br>
    <br>
    <br>
    <h4>Tu equipo, tus datos, tu portal: <strong>Bienvenido a People Analytics.</strong></h4>
  </div>
  <!-- MDB -->
  <script type="text/javascript" src="<?php echo base_url("login/js/mdb.min.js"); ?>"></script>
  <!-- Custom scripts -->
  <script type="text/javascript"></script>
</body>

</html>




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