

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
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia | </a> Hora de entrada <i
            class="fas fa-clock"></i></h4>
            <div class="line"> </div>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-check-square" style="color: #4070f4;"></i> Marcar asistencia diaria</strong>
            <small id="passwordHelpBlock" class="form-text text-muted">
                1. En caso de tener algún problema en el envío de su hora de entrada, favor de reportarse inmediatamente
                con el área de Capital humano.<br>

                ¡Que tengan un excelente día!
            </small>
        </div>

        <?php if (empty($valida)): ?>

            <div class="card-body" id="contenido-dinamico">
                <form id="formulario" action="<?php echo base_url("/home/saveassistence"); ?>" method="post"
                    enctype="multipart/form-data">
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

                    <!--<div class="form-group row">
                    <label for="fecha" class="col-sm-2 col-form-label">Latitud:</label>
                    <div class="col-sm-4">
                        <input type="text" name="latitud" id="latitud" class="form-control"  required
                            readonly>
                    </div>
                    <label for="hora" class="col-sm-2 col-form-label">Longitud:</label>
                    <div class="col-sm-4">
                        <input type="text" name="longitud" id="longitud" class="form-control" required
                            readonly>
                    </div>
                </div>-->

                    <div class="card-header" style="text-align: center;">
                        <strong><i class="fas fa-image" style="color: #4070f4;"></i> Evidencia (Con hora, fecha y room ya
                            visibles sea por computador o
                            mediante celular) </strong>
                    </div>
                    <br>

                    <div class="form-group mb-2 text-center">
                        <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                            required="">
                    </div>
                    <br>

                    <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                        <img id="imagenPreview" src="#"  style="max-width: 100%; max-height: 300px;">
                    </div>
                    <br>

                    <div class="form-group mb-2 text-center">
                        <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar"
                            onclick="obtenerUbicacion()">
                    </div>


                </form>
            <?php else: ?>
                <br>
                <div class="alert alert-danger" style="text-align: center;">Ya se tomó la asistencia del día de hoy, que
                    tengas un buen día
                    <?= session('nombre'); ?> &#128516;
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->include('colaboradores/footer') ?>

