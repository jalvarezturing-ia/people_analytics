<!DOCTYPE html>
<html lang="en">
<?php $numero = 1;
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y"); ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?= $vacante; ?></title>
    <link rel="icon" href="<?php echo base_url("login/img/log_turing.webp"); ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <link rel="stylesheet" href="<?php echo base_url("login/css/bootstrap-login-form.min.css"); ?>" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<style>
    body {
        /* font-family: 'Poppins', sans-serif; */
        font-family: 'Century Gothic';
        background-color: rgb(16, 53, 90);
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

    .imgCenter {
        text-align: center;
    }
</style>

<script type="text/javascript">
    function deshabilitaRetroceso() {
        window.location.hash = "no-back-button";
        window.location.hash = "Again-No-back-button" //chrome
        window.onhashchange = function () {
            window.location.hash = "no-back-button";
        }
    }
</script>




<body oncontextmenu="return false" onload="deshabilitaRetroceso()" onselectstart='return false'
    ondragstart="return false">
    <!-- Start your project here-->
    <section class="vh-100" style="">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card" style="border-radius: 1rem;">
                        <br>
                        <div class="imgCenter">
                            <img src="https://res.cloudinary.com/monday-platform/image/upload/v1681149433/board_views_images/logos/1681149425471_16edf394-3692-ca9a-dfb3-77ff66ccbf1f.png"
                                alt="" width="80px" height="80px">
                        </div>
                        <br>
                        <h3 style="font-weight: bold; text-align:center;">Turing Inteligencia Artificial</h3>
                        <div class="container">
                            <h6 class="fw-normal mb-3 pb-3" style="font-weight: bold; text-align:center;">Aplicante:
                                <?= $vacante; ?> <br><br>
                                <?= $fechaHoy . " " . '<span id="hora-actual" style="font-family:Century Gothic; border:none; background-color:white;" readonly
                                required></span>' ?>
                            </h6>
                            <form id="login-form" action="<?php echo base_url('/saveRespuestasAplicantes'); ?>"
                                method="POST" enctype="multipart/form-data">
                                <table class="table">
                                    <thead>
                                    <input type="hidden" name="fecha_hora" id="fecha_hora" value="" />
                                        <?php foreach ($data as $lista): ?>
                                            <tr>
                                                <th colspan="11">
                                                    <?= $numero; ?>.
                                                    <?= $lista->pregunta; ?><span style="color:red;">*</span>
                                                    <input type='hidden' name='id_encuesta'
                                                        value='<?php echo $lista->id_form; ?>'>
                                                    <input type='hidden' name='token' value='<?= $token ?>'>
                                                    <input type='hidden' name='pregunta[<?= $lista->id; ?>]'
                                                        value='<?php echo $lista->pregunta; ?>'>
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    // Verificar si hay respuestas predefinidas
                                                    $respuestas = array_filter([$lista->A, $lista->B, $lista->C, $lista->D, $lista->E, $lista->F]);

                                                    // Si hay respuestas predefinidas, mostrar un select
                                                    if (!empty($respuestas)): ?>
                                                        <select name='resp[<?= $lista->id; ?>][]' class="form-control">
                                                            <?php foreach ($respuestas as $respuesta): ?>
                                                                <option value="<?= $respuesta; ?>"><?= $respuesta; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php else: ?>
                                                        <!-- Si no hay respuestas predefinidas, mostrar un input text -->
                                                        <input type='text' name='resp[<?= $lista->id; ?>][]' required
                                                            class="form-control" placeholder="<?= $lista->pregunta; ?>">

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php $numero++; ?>

                                        <?php endforeach; ?>

                                        <tr>
                                            <th>Adjunta tu curriculum vitae <span style="color:red;">*</span></th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="documento" id="docInput" required=""
                                                    accept=".doc, .docx, .pdf" class="form-control-file">

                                            </td>
                                        </tr>
                                    </tbody>
                                    <!-- <p style="text-align:justify; color: rgb(16, 53, 90);">
                                    <span style="font-weight:bold;">AVISO DE PRIVACIDAD</span> <br>
                                    Estimada (o) candidata (o): Usted está participando en un proceso de reclutamiento y
                                    selección, por lo cual la información o datos que usted proporciona a Turing IA son
                                    para el uso exclusivo del proceso y serán tratados de conformidad con el presente
                                    Aviso de Privacidad y con lo establecido en la Ley Federal de Protección de Datos
                                    Personales en Posesión de los Particulares (LFPDPPP) En caso de que usted no sea
                                    seleccionado para avanzar en el proceso de selección, su información y datos serán
                                    (conservados/eliminados/resguardados) de forma segura. Otorgo mi consentimiento para
                                    el tratamiento de mis datos personales en términos del presente Aviso de Privacidad.
                                </p>
                                <tr>
                                    <td> <select name='' class="form-control">

                                            <option value="Acepto">ACEPTO</option>
                                            <option value="Declino">DECLINO</option>

                                        </select> </td>
                                </tr> -->

                                </table>
                                <div class="pt-1 mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg"
                                        style="display: block; margin: 0 auto; background-color: #1371C7; ">
                                        Guardar</button>
                                </div>
                            </form>
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
        <h4>Espera un momento, <strong>estamos guardando tus respuestas, ¡Gracias por tu colaboración!</strong></h4>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="<?php echo base_url("login/js/mdb.min.js"); ?>"></script>
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
</body>

</html>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script> -->


<script>
    document.addEventListener("DOMContentLoaded", function () {

        function actualizarHora() {
            var now = new Date();
            var year = now.getFullYear();
            var month = ("0" + (now.getMonth() + 1)).slice(-2); // Meses de 0 a 11
            var day = ("0" + now.getDate()).slice(-2);
            var hours = ("0" + now.getHours()).slice(-2);
            var minutes = ("0" + now.getMinutes()).slice(-2);
            var seconds = ("0" + now.getSeconds()).slice(-2);

            var formattedDateTime =
                year +
                "-" +
                month +
                "-" +
                day +
                " " +
                hours +
                ":" +
                minutes +
                ":" +
                seconds;
            document.getElementById("fecha_hora").value = formattedDateTime;
        }
        //actualizar la hora cada segundo
        setInterval(actualizarHora, 1000);
        //ejecutar la función para establecer la hora inicial
        actualizarHora();
    });
</script>


<!-- <script>
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#dropzone", {
        url: "<?php echo base_url('/upload'); ?>",
        paramName: "file",
        maxFilesize: 5,
        maxFiles: 3,
        acceptedFiles: ".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx"
    });
</script> -->

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
            }, 3000);
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
    echo '    title: "Éxito",';
    echo '    confirmButtonColor: "#092e50",';
    echo '    confirmButtonText: "Muchas gracias:)",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}

?>