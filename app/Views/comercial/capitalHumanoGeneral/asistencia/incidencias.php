<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<?php $numero = 1; ?>
<?php $numero1 = 1; ?>
<?php $numero3 = 1; ?>


<style>
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

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> Reporte de
        incidencias
        <i class="fas fa-info-circle"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-sign-out-alt" style="color: #3498db;"></i> Nuevo reporte de incidencias
            </strong>

            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="mostrar('nuevo')" id="4"> <i class="fas fa-plus"></i> Nuevo
                </a>|
                <a href="#" class="ver-periodo-btn" onclick="mostrar('reporte')" id="5"> <i class="fas fa-clock"></i>
                    Reporte
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="mostrar('total')" id="6"> <i
                        class="fas fa-check-circle"></i> Horas </a>
            </div>
        </div>

        <div class="card-body" id="nuevoSection">
            <form id="formulario" action="<?php echo base_url("/home/saveincidencia"); ?>" method="post"
                enctype="multipart/form-data">

                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Colaborador: </label>
                    <div class="col-sm-4">
                        <select name="id_usuario" id="" class="form-control" onchange="rellenarDescripcion(this)"
                            required>
                            <option value="">Selecciona el colaborador</option>
                            <?php foreach ($info as $lista): ?>
                                <option value="<?php echo $lista->id; ?>"
                                    data-descripcion="<?php echo $lista->descripcion; ?>">
                                    <?php echo $numero . ". " . $lista->nombre . " " . $lista->apellido_paterno . " " . $lista->apellido_materno; ?>
                                </option>
                                <?php $numero++; endforeach; ?>
                        </select>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <input type="text" name="descripcion" class="form-control" id="descripcion" value="" required
                            readonly>
                    </div>
                </div>
                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información de
                        incidencia </strong>

                </div>
                <br>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Tipo de incidencia:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">


                        <select name="motivo" class="form-control" id="cars" required>
                            <option value="none">Seleccione</option>
                            <option value="Internet">Internet</option>
                            <option value="Luz">Luz eléctrica</option>
                            <option value="Internet y Luz">Internet y luz </option>
                            <option value="Medico">Médica</option>
                            <option value="Other">Otro</option>
                        </select>
                        <br>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fecha y hora inicio de incidencia:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="datetime-local" id="f_salida" name="f_salida" class="form-control" required
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Fecha y hora término de incidencia:</label>
                    <div class="col-sm-4">

                        <input type="datetime-local" id="f_regreso" name="f_regreso" class="form-control" readonly>

                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Horas a reponer:</label>
                    <div class="col-sm-4">
                        <input type="number" name="horas_reponer" id="horas" class="form-control"
                            placeholder="Ejemplo: 1,2,3 o 4" readonly>
                        <br>

                    </div>
                </div>
                <div class="form-group row" style="display:none;" id="motivoTextarea">
                    <label for="area" class="col-sm-2 col-form-label">Motivo de Incidencia:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-12">
                        <textarea name="motivo1" class="form-control"
                            placeholder="Escriba el motivo de la incidencia con detalle, ejemplo: Se fue el internet y/o luz en casa..."
                            rows="3" minlength="3" maxlength="5000" required></textarea>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia y/o video</strong>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        *El video debe ser menor a 100MB de tamaño de subida*
                        <br>
                    </small>
                </div>
                <br>
                <div class="form-group mb-2 text-center">
                    <input type="file" name="video" id="videoInput" accept="video/*" onchange="previewVideo()">
                </div>
                <br>

                <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                    <video id="videoPreview" controls style="max-width: 100%; max-height: 300px;">
                        <source src="#" type="video/mp4"> <!-- Para navegadores que no admiten el tipo de video -->
                        Tu navegador no soporta videos HTML5.
                    </video>
                </div>
                <br>
                <div class="form-group mb-2 text-center">
                    <input type="submit" class="ver-periodo-btn2 text-center " value="Guardar reporte">
                </div>
            </form>
        </div>

        <div class="card-body" id="pendienteSection" style="display: none;">
            <center>
                <h5><i class="fas fa-clock" style="color: #C7D000;"></i> Incidencias reportadas
                </h5>
            </center>

            <table>
                <tr style="font-weight:bold;">
                    <td style="text-align: center;">#</td>
                    <td style="text-align: center;">Colaborador</td>
                    <td style="text-align: center;">Fecha salida</td>
                    <td style="text-align: center;">Fecha regreso</td>
                    <td style="text-align: center;">Horas a reponer</td>
                    <td style="text-align: center;">Descripción</td>
                    <td style="text-align: center;">Evidencia</td>
                    <td style="text-align: center;">Menú</td>
                </tr>

                <?php foreach ($reporte as $report): ?>
                    <tr style="text-align: center;">
                        <td>
                            <?= $numero1; ?>
                        </td>
                        <td>
                            <?= $report->nombre . " " . $report->apellido_paterno; ?>
                        </td>
                        <td>
                            <?= $report->f_salida ?>
                        </td>
                        <td>
                            <?= $report->f_regreso ?>
                        </td>
                        <td>
                            <?= $report->horas_reponer ?> hrs
                        </td>
                        <td>


                            <?php
                            $descripcion = strlen($report->descripcion) > 15 ? substr($report->descripcion, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($report->descripcion) . '\')">...</a>' : $report->descripcion;
                            echo $descripcion;
                            ?>
                        </td>
                        <td>
                            <a href="#" onclick='mostrarImagen("<?php echo base_url("/permisos/$report->evidencia"); ?>")'>
                                <video src="<?php echo base_url("/permisos/$report->evidencia"); ?>" alt="img"
                                    class="rounded-thumbnail img-fluid"
                                    style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;"></video>
                            </a>
                        </td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones">
                                <a href="#!" title="Editar permiso" onclick="editInc(event, 
                                '<?php echo $report->id_inc ?>',
                                '<?php echo $report->nombre ?>',
                                '<?php echo $report->apellido_paterno ?>',
                                '<?php echo $report->f_salida ?>',
                                '<?php echo $report->f_regreso ?>',
                                '<?php echo $report->horas_reponer ?>',
                                '<?php echo $report->descripcion ?>',
                                '<?php echo $report->evidencia ?>',

                                )"><i class="fas fa-edit" style="color:blue;"></i> Editar incidencia </a> <br>
                                <a href="#!" title="Eliminar permiso"><i class="fas fa-trash" style="color:red;"></i>
                                    Eliminar incidencia </a>
                            </div>
                        </td>
                    </tr>
                    <?php $numero1++; endforeach; ?>
            </table>


        </div>

        <div class="card-body" id="autorizadosSection" style="display:none;">
            <center>
                <h5><i class="fas fa-check-circle" style="color: #00D05B;"></i> Reposición de horas
                </h5>
            </center>

            <table>
                <tr style="font-weight:bold;">
                    <td style="text-align: center;">#</td>
                    <td style="text-align: center;">Colaborador</td>
                    <td style="text-align: center;">Área</td>
                    <td style="text-align: center;">Fechas </td>
                    <td style="text-align: center;">Motivo</td>
                    <td style="text-align: center;">Forma de reponer</td>
                    <td style="text-align: center;">Horas reponer</td>
                    <td style="text-align: center;">Evidencia inicio</td>
                    <td style="text-align: center;">Evidencia fin</td>
                    <td style="text-align: center;">Menú</td>
                </tr>
                <?php foreach ($repo as $repos): ?>
                    <tr style="text-align: center;">
                        <td>
                            <?= $numero3; ?>
                        </td>
                        <td>
                            <?= $repos->nombre . " " . $repos->apellido_paterno; ?>
                        </td>
                        <td>
                            <?= $repos->area_desc; ?>
                        </td>
                        <td>
                            <?= $repos->f_salida . "//" . $repos->f_regreso; ?>
                        </td>
                        <td>
                            <?= $repos->motivo; ?>
                        </td>
                        <td>
                            <?php
                            $descripcion = strlen($repos->forma) > 10 ? substr($repos->forma, 0, 10) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($repos->forma) . '\')">...</a>' : $repos->forma;
                            echo $descripcion;
                            ?>
                        </td>
                        <td>
                            <?= $repos->h_reponer; ?> hrs
                        </td>
                        <td>
                        <a href="#" onclick='mostrarImagen("<?php echo base_url("/repo/$repos->evidencia_inic"); ?>")'>
                                <img src="<?php echo base_url("/repo/$repos->evidencia_inic"); ?>" alt="img"
                                    class="rounded-thumbnail img-fluid"
                                    style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;"></img>
                            </a>
                        </td>
                        <td>
                        <a href="#" onclick='mostrarImagen("<?php echo base_url("/repo/$repos->evidencia_fin"); ?>")'>
                                <img src="<?php echo base_url("/repo/$repos->evidencia_fin"); ?>" alt="img"
                                    class="rounded-thumbnail img-fluid"
                                    style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;"></img>
                            </a>
                        </td>
                    </tr>
                    <?php $numero3++; endforeach; ?>
            </table>

        </div>


        <div class="card-body" id="sinreponer" style="display: none;">

        </div>

        <div class="card-body" id="repuestas" style="display: none;">
            <p>Hola2</p>
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
    <h4>Registrando incidencia, espera un momento...</h4>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    function editInc(event, id, nombre, apellido, salida, entrada, horas, descripcion, evidencia) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/event"); ?>"> Asistencia ></a> Edición de incidencias </strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body" id="contenido-dinamico">
                        <form id="formReq" action="<?php echo base_url("/home/saveincidenciaa"); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Colaborador: </label>
                            <div class="col-sm-10">
                            <input type="hidden" name="captura" value="${evidencia}" required>
                            <input type="hidden" name="id_dato" value="${id}" required>
                            <input type="text" name="colab" class="form-control" id="descripcion" value="${nombre} ${apellido}" required readonly>
                            </div>
                        </div>
                        <div class="card-header" style="text-align: center;">
                            <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información de
                                incidencia </strong>

                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">motivo:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">

                            <textarea name="descripcion" class="form-control"" id="motivoTextarea"
                            placeholder="Escriba el motivo de su salida con detalle, ejemplo: Tengo cita en el médico..."
                            rows="3" minlength="3" maxlength="5000" required >${descripcion}</textarea>
                            </div>
                            <label for="area" class="col-sm-2 col-form-label">Fecha y hora inicio de incidencia:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="f_salida"  value="${salida}" name="f_salida" class="form-control" required
                                    >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Fecha y hora término de incidencia:</label>
                            <div class="col-sm-4">

                                <input type="text" id="f_regreso"  value="${entrada}" name="f_regreso" class="form-control" >

                            </div>
                            <label for="area" class="col-sm-2 col-form-label">Horas a reponer:</label>
                            <div class="col-sm-4">
                                <input type="number" name="horas_reponer"  value="${horas}" id="horas" class="form-control"
                                    placeholder="Ejemplo: 1,2,3 o 4" >
                                <br>

                            </div>
                        </div>
                        <div class="form-group row" style="display:none;" id="motivoTextarea">
                            <label for="area" class="col-sm-2 col-form-label">Motivo de Incidencia:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-12">
                                <textarea name="motivo1" class="form-control"
                                    placeholder="Escriba el motivo de la incidencia con detalle, ejemplo: Se fue el internet y/o luz en casa..."
                                    rows="3" minlength="3" maxlength="5000" required></textarea>
                            </div>
                        </div>

                        <div class="card-header" style="text-align: center;">
                            <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia y/o video</strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                *El video debe ser menor a 100MB de tamaño de subida*
                                <br>
                            </small>
                        </div>
                        <br>
                        <div class="form-group mb-2 text-center">
                            <input type="file" name="video" id="videoInput" accept="video/*" onchange="previewVideo()">
                        </div>
                        <br>

                        <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                            <video id="videoPreview" controls style="max-width: 100%; max-height: 300px;">
                                <source src="#" type="video/mp4"> <!-- Para navegadores que no admiten el tipo de video -->
                                Tu navegador no soporta videos HTML5.
                            </video>
                        </div>
                        
                    </form>
                                </div>
                            </div>
                        </div>`,
            showCancelButton: true,
            customClass: 'swal-wide',
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const form = document.getElementById('formReq');
                form.submit();
                /*var img = document.getElementById('imagenInput').value;

                if (img === '' || img === null) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, selecciona una imagen.',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: "Entendido",
                });
                } else {
                    const form = document.getElementById('formReq');
                    form.submit();
                }*/
            }

        });
    }
</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('4').classList.add('activo');
    });


    function mostrar(seccion) {

        document.getElementById('nuevoSection').style.display = 'none';
        document.getElementById('pendienteSection').style.display = 'none';
        document.getElementById('autorizadosSection').style.display = 'none';
        document.getElementById('sinreponer').style.display = 'none';
        document.getElementById('repuestas').style.display = 'none';

        document.getElementById('4').classList.remove('activo');
        document.getElementById('5').classList.remove('activo');
        document.getElementById('6').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'nuevo') {
            document.getElementById('nuevoSection').style.display = 'block';
            document.getElementById('4').classList.add('activo');

        } else if (seccion === 'reporte') {
            document.getElementById('pendienteSection').style.display = 'block';
            document.getElementById('5').classList.add('activo');

        } else if (seccion === 'total') {

            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('6').classList.add('activo');
            document.getElementById('sinreponer').style.display = 'block';
        }
        else if (seccion === 'asistencia') {

            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('6').classList.add('activo');
            document.getElementById('repuestas').style.display = 'block';
        }
    }
</script>


<script>
    function previewVideo() {
        var input = document.getElementById('videoInput');
        var preview = document.getElementById('videoPreview');

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
    jQuery(document).ready(function ($) {
        // Captura el evento de envío del formulario
        $('#formulario').submit(function (event) {
            // Evita que el formulario se envíe de forma predeterminada
            event.preventDefault();

            // Agrega la clase 'loading' al body para aplicar el fondo blanco
            $('body').addClass('loading');

            // Muestra el spinner
            $('#loading-spinner').show();

            // Envía el formulario después de un breve retraso
            setTimeout(function () {
                $('#formulario')[0].submit();
            }, 2000);
        });
    });
</script>


<script>
    function rellenarDescripcion(select) {
        // Obtiene la fecha del atributo data-fecha del option seleccionado
        var fechaSeleccionada = select.options[select.selectedIndex].getAttribute('data-descripcion');

        // Actualiza el valor del campo de fecha oculto
        document.getElementById('descripcion').value = fechaSeleccionada;
    }
</script>


<script>
    document.getElementById("cars").addEventListener("change", function () {
        var internet = document.getElementById("Internet");
        var luz = document.getElementById("Luz");
        var ambas = document.getElementById("Ambas");

        var motivoTextarea = document.getElementById("motivoTextarea");
        var horas = document.getElementById("horas");
        var f_salida = document.getElementById("f_salida");
        var f_regreso = document.getElementById("f_regreso");

        if (this.value === "Internet" || this.value === "Luz" || this.value === "Ambas" || this.value === "Other") {

            motivoTextarea.style.display = "block";
            motivoTextarea.setAttribute("required", "required");
            horas.style.display = "block";
            horas.removeAttribute("readonly", "readonly");
            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");

            // Obtener los elementos de entrada de fecha
            const fSalida = document.getElementById('f_salida');
            const fRegreso = document.getElementById('f_regreso');

            // Escuchar los cambios en las fechas
            fSalida.addEventListener('change', calcularHoras);
            fRegreso.addEventListener('change', calcularHoras);

            function calcularHoras() {
                // Obtener las fechas seleccionadas
                const salida = new Date(fSalida.value);
                const regreso = new Date(fRegreso.value);

                // Calcular la diferencia en milisegundos
                const diferenciaMs = regreso - salida;

                // Convertir la diferencia a horas
                const horas = Math.abs(diferenciaMs / 3600000); // 3600000 milisegundos = 1 hora

                // Mostrar las horas en el campo de entrada
                document.getElementById('horas').value = horas.toFixed(0); // Redondear a 2 decimales
            }

        } else if (this.value === "Medico") {
            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");
            horas.setAttribute("readonly", "readonly");
            motivoTextarea.style.display = "block";
            motivoTextarea.removeAttribute("required");
            horas.value = "0";
        } else if (this.value === "none") {
            motivoTextarea.style.display = "none";
            motivoTextarea.removeAttribute("required");
            horas.setAttribute("readonly", "readonly");
            f_salida.setAttribute("readonly", "readonly");
            f_regreso.setAttribute("readonly", "readonly");
        }
    });

</script>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>