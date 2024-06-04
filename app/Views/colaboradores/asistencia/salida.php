<?= $this->include('colaboradores/header') ?>

<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fecha_hoy = date("d/m/Y");
?>

<script>
    function actualizarHora() {
        var fecha = new Date();
        var hora = fecha.getHours();
        var minutos = fecha.getMinutes();
        var segundos = fecha.getSeconds();
        var ampm = (hora >= 12) ? 'pm' : 'am';

        //formatear la hora en formato de 12 horas
        hora = (hora % 12 === 0) ? 12 : hora % 12;
        //agregar ceros a la izquierda para minutos y segundos menores a 10
        minutos = minutos < 10 ? '0' + minutos : minutos;
        segundos = segundos < 10 ? '0' + segundos : segundos;
        var horaActual = hora + ':' + minutos + ':' + segundos + ' ' + ampm;
        //actualizar el contenido en el elemento con ID 'hora-actual'
        document.getElementById('hora-actual').innerText = horaActual;
        document.getElementById('hora-hidden').value = horaActual;
    }
    //actualizar la hora cada segundo
    setInterval(actualizarHora, 1000);
    //ejecutar la función para establecer la hora inicial
    actualizarHora();
</script>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> Hora de salida <i
            class="fas fa-sign-out-alt"></i></h4>
            <div class="line"> </div>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-check-square" style="color: #4070f4;"></i> Marcar Hora de salida </strong>
            <small id="passwordHelpBlock" class="form-text text-muted">
                1. En caso de tener algún problema en el envío de su hora de salida, favor de reportarse inmediatamente
                con el área de Capital humano.<br>

                ¡Que tengan un excelente día!
            </small>
        </div>

        <?php if(empty($valida)): ?>

        <div class="card-body">
            <form action="<?php echo base_url("/home/saveoutput"); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                    <div class="col-sm-4">
                        <input type="hidden" name="user_id" class="form-control" value="<?= session('user_id'); ?>">
                        <input type="text" name="nombre" class="form-control" value="<?= $completo; ?>" required
                            readonly>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <input type="text" name="area" class="form-control" value="<?= session('descripcion'); ?>"
                            required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fecha" class="col-sm-2 col-form-label">Fecha:</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d'); ?>" required
                            readonly>
                    </div>
                    <label for="hora" class="col-sm-2 col-form-label">Hora:</label>
                    <div class="col-sm-4">
                        <span id="hora-actual" style="font-family:Century Gothic;" class="form-control" readonly
                            required></span>
                        <input type="hidden" id="hora-hidden" name="hora" style="font-family:Century Gothic;" required>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-image" style="color: #4070f4;"></i> Evidencia (Con hora y fecha
                        visibles ya sea por computador o
                        mediante celular)</strong>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <input type="file" name="imagen" id="imagenInput"  accept="image/*"
                        onchange="previewImage()" required="">
                </div>
                <br>

                <div class="form-group mb-2 text-center " style="margin-left: 250px;">
                    <img id="imagenPreview" src="#"
                        style="max-width: 100%; max-height: 300px;">
                </div>
                <br>

                <!-- Agrega esto dentro de tu formulario -->
                <input type="hidden" id="imagenHiddenInput" name="captura_pantalla" value="">


                <div class="form-group mb-2 text-center">
                    <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar" onclick="captureAndSubmit()">
                </div>


            </form>
            <?php else: ?>
                <br>
                <div class="alert alert-danger" style="text-align: center;">Ya se tomó la salida del día de hoy, que tengas una bonita noche <?= session('nombre'); ?> &#128536;</div>

            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->include('colaboradores/footer') ?>

<script>
    function previewImage() {
        var input = document.getElementById('imagenInput');
        var preview = document.getElementById('imagenPreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>


<script>
    document.addEventListener('keydown', function (event) {
        // Verificar si se presionaron las teclas Alt + Impr Pant
        if (event.altKey && event.key === 'PrintScreen') {
            captureScreen();
            event.preventDefault();  // Prevenir la acción predeterminada de la captura de pantalla
        }
    });

    function captureScreen() {
        html2canvas(document.body).then(canvas => {
            var imageDataURL = canvas.toDataURL('image/png');
            displayCapturedImage(imageDataURL);
        });
    }

    function displayCapturedImage(imageDataURL) {
        var preview = document.getElementById('imagenPreview');
        preview.src = imageDataURL;
        preview.style.display = 'block';
        document.getElementById('imagenHiddenInput').value = imageDataURL;
    }
</script>
