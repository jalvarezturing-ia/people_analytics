<?= $this->include('colaboradores/header') ?>
<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); 
$numero = 1;?>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> Días extras (Fines de
        semana)
        <?= strftime(date('M/Y')); ?> <i class="fas fa-clock"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-clock" style="color: #4070f4;"></i> Control de horas extras </strong>
            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="ms('nueva')" id="cero" data-toggle="tooltip"
                    data-placement="bottom" title="Registrar un nuevo permiso"> <i class="fas fa-plus"></i> Nuevo
                </a>|
                <a href="#" class="ver-periodo-btn" onclick="ms('pend')" id="uno" data-toggle="tooltip"
                    data-placement="bottom" title="Detalle de los permisos pendientes"> <i class="fas fa-clock"></i>
                    Proceso
                </a>

            </div>
            <hr>

            <small id="passwordHelpBlock" class="form-text text-muted">
                Para cualquier duda o aclaración favor de notificar al área de Capital Humano. Todo día extra se pagará
                a fin de mes según corresponda.
                <br>

                ¡Que tengan un excelente día!
            </small>

        </div>
        <div class="card-body" id="contenido-dinamico">

            <form id="formulario" action="<?php echo base_url("/home/savefinsemana"); ?>" method="post"
                enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                    <div class="col-sm-4">
                        <input type="hidden" name="user_id" class="form-control" value="<?= $id ?>">
                        <input type="text" name="nombre" class="form-control" value="<?= $name ?>" required readonly>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <input type="text" name="area" class="form-control" value="<?= $desc; ?>" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mes" class="col-sm-2 col-form-label">Año: <span style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="año" value="<?= date('Y') ?>" required readonly>
                    </div>
                    <label for="mes" class="col-sm-2 col-form-label">Mes: <span style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <select name="mes" id="mes" class="form-control">
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio">Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Septiembre">Septiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Diciembre">Diciembre</option>
                        </select>
                    </div>
                </div>
                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-sun" style="color: #FFC300;"></i> Días para laborar </strong>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        1. En caso de ser un único día, favor de llenar ambas casillas con el mismo día.
                        <br>
                        2. En caso de dudas o sugerencias, favor de contactarse al siguiente número: <a
                            href="https://api.whatsapp.com/send?phone=+525616631953&text=Hola, tengo una duda acerca de%20"
                            target='_blank'>5616631953</a>
                        - Mayte López. <br>

                        ¡Que tengan un excelente día!
                    </small>
                </div>
                <br>

                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Inicio: <span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="datetime-local" id="f_inicio" name="f_inicio" class="form-control" required>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fin: <span style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="datetime-local" id="f_fin" name="f_fin" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Horas a trabajar: <span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="text" id="horas_trabajar" name="horas_trabajar" class="form-control" />
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label">Jornada: <span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <select name="jornada" id="jornada" class="form-control">
                            <option value="Media">Media: 9am - 2pm</option>
                            <option value="Completa">Completa: 9am - 7pm</option>
                            <option value="Completa y media">Completa y media</option>
                            <option value="Dos completas">Dos completas</option>
                            <option value="Dos medias">Dos medias</option>
                        </select>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong><input type="checkbox" required> Notificó al encargado de área y a Capital Humano <span
                            style="color:red;">*</span></strong> <br>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar"
                        onclick="obtenerUbicacion()">
                </div>
            </form>
        </div>

        <div class="card-body" id="pendienteSection" style="display:none;">
            <?php if (empty($dias)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay diás extras tuyas reportadas, todo va
                    bien por aquí
                    <?= session('nombre'); ?> &#128561;
                </div>
            <?php else: ?>

                <table>
                    <tr style="text-align:center;">
                        <th>#</th>
                        <th>Año y mes</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Horas</th>
                        <th>Jornada</th>
                        <th>Opciones</th>
                    </tr>
                    <?php foreach ($dias as $dia): ?>
                        <tr style="text-align:center;">
                            <td><?= $numero; ?></td>
                            <td>
                                <?= $dia->mes . " de " . $dia->año ?>
                            </td>
                            <td>
                                <?= $dia->f_inicio ?>
                            </td>
                            <td>
                                <?= $dia->f_fin ?>
                            </td>
                            <td>
                                <?= $dia->h_trabajar ?> hrs
                            </td>
                            <td>
                                <?= $dia->jornada ?>
                            </td>
                            <td>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <?php if (($dia->evidencia_fin && $dia->evidencia_fin) == '' || ($dia->evidencia_fin && $dia->evidencia_fin) == NULL): ?>
                                        <a href="#!"
                                            onclick="gestion(event,'<?php echo $dia->id ?>','<?php echo $dia->f_inicio ?>','<?php echo $dia->f_fin ?>','<?php echo $dia->h_trabajar ?>',)">&nbsp;&nbsp;<i
                                                class="fas fa-edit" style="color: blue;"></i>Gestión</a>
                                    <?php else: ?>
                                        <a href="#!"
                                            onclick="vista(event,'<?php echo $dia->f_inicio ?>','<?php echo $dia->f_fin ?>','<?php echo $dia->evidencia_inic ?>','<?php echo $dia->evidencia_fin ?>', '<?php echo $dia->actividades ?>')">&nbsp;&nbsp;<i
                                                class="fas fa-check-circle" style="color: green;"></i>Gestión</a>
                                    <?php endif ?>
                                    <br>

                                    <a href="#!" onclick="eliminarDia(event,  '<?php echo $dia->id ?>')"
                                        title="Eliminar permiso">&nbsp;&nbsp;<i class="fas fa-trash"
                                            style="color: red;"></i>Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php $numero++; endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>



<script>
    function vista(event, inicio, fin, evidencia1, evidencia2, actividades) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Asistencia ></a>  Días extras (Fines de semana) </strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                1. En caso de tener algún problema en el envío de su captura, favor de reportarse inmediatamente
                                con Mayte López del área de Capital humano.<br>

                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body" id="contenido-dinamico">
                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">Inicio: </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="nombre" class="form-control" value="${inicio}" required readonly>
                                    </div>
                                    <label for="area" class="col-sm-2 col-form-label">Fin:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="area" class="form-control" value="${fin}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">Actividades: </label>
                                    <div class="col-sm-10">
                                    <textarea id="actividades" class="form-control" name="actividades" readonly rows="4" cols="50" placeholder="Describa con detalle las actividades realizadas">${actividades}</textarea>
                                    </div>
                                </div>
                                <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia de inicio de actividades (Con hora y fecha visible)</strong>
                                </div>
                                <br>
                                
                                <div class="form-group mb-2 text-center">
                                <img id="imagenPreview" src="<?php echo base_url("/dias/") ?>${evidencia1}" alt="Vista previa de la captura"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                                <br>
                                <div class="form-group mb-2 text-center">
                                <img id="imagenPreview" src="<?php echo base_url("/dias/") ?>${evidencia2}" alt="Vista previa de la captura"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                         </div>
                    </div>
                </div>`,
            showCancelButton: true,
            customClass: 'swal-wide',
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        });
    }
</script>

<script>
    function gestion(event, id, inicio, fin, horas) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Asistencia ></a>  Días extras (Fines de semana) </strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                1. En caso de tener algún problema en el envío de su captura, favor de reportarse inmediatamente
                                con Mayte López del área de Capital humano.<br>

                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body" id="contenido-dinamico">
                            <form id="formReq" action="<?php echo base_url("/home/saveExtras"); ?>" method="post"
                                enctype="multipart/form-data">
                               

                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">Inicio: </label>
                                    <div class="col-sm-4">
                                        <input type="hidden" name="user_id" class="form-control" value="<?= $id ?>">
                                        <input type="hidden" name="dato_id" class="form-control" value="${id}">
                                        <input type="text" name="nombre" class="form-control" value="${inicio}" required readonly>
                                    </div>
                                    <label for="area" class="col-sm-2 col-form-label">Fin:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="area" class="form-control" value="${fin}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">Actividades: </label>
                                    <div class="col-sm-10">
                                    <textarea id="actividades" class="form-control" name="actividades" rows="4" cols="50" placeholder="Describa con detalle las actividades realizadas"></textarea>
                                    </div>
                                </div>
                                <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia de inicio de actividades (Con hora y fecha visible)</strong>
                                </div>
                                <br>
                            
                                <div class="form-group mb-2 text-center">
                                    <img id="imagenPreview" src="#" alt="Vista previa de la captura"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                                <div class="form-group mb-2 text-center">
                                    <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                                        required="">
                                </div>

                                 <br>
                                 <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia de fin de actividades (Con hora y fecha visible)</strong>
                                </div>
                                <br>
                                
                                <div class="form-group mb-2 text-center">
                                    <input type="file" name="imagen1" id="imagenInput1" accept="image/*" onchange="previewImage1()"
                                        required="">
                                </div>
                                <div class="form-group mb-2 text-center">
                                    <img id="imagenPreview1" src="#" alt="Vista previa de la captura"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                                <br>
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
                var img = document.getElementById('imagenInput').value;
                var img2 = document.getElementById('imagenInput1').value;
                var actividades = document.getElementById('actividades').value;

                if ((img === '' || img === null) || (img2 === '' || img2 === null) || (actividades === '' || actividades === null)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, no dejes campos vacios.',
                        confirmButtonColor: '#3498db',
                        confirmButtonText: "Entendido",
                    });
                } else {
                    const form = document.getElementById('formReq');
                    form.submit();
                }
            }

        });
    }
</script>


<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('cero').classList.add('activo');
    });


    function ms(seccion) {


        document.getElementById('contenido-dinamico').style.display = 'none';
        document.getElementById('pendienteSection').style.display = 'none';

        document.getElementById('cero').classList.remove('activo');
        document.getElementById('uno').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'nueva') {
            document.getElementById('contenido-dinamico').style.display = 'block';
            document.getElementById('cero').classList.add('activo');

        } else if (seccion === 'pend') {

            document.getElementById('pendienteSection').style.display = 'block';
            document.getElementById('uno').classList.add('activo');
        }
    }
</script>

<script>

    // Obtener los elementos de entrada de fecha
    const fSalida = document.getElementById('f_inicio');
    const fRegreso = document.getElementById('f_fin');

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

        if (horas >= 6) {
            const resta = (horas - 1.5);
            // Mostrar las horas en el campo de entrada
            document.getElementById('horas_trabajar').value = resta.toFixed(1); // Redondear a 2 decimales
        } else {
            const resta = (horas - 1.5);
            // Mostrar las horas en el campo de entrada
            document.getElementById('horas_trabajar').value = horas.toFixed(0); // Redondear a 2 decimales
        }


    }

</script>


<?= $this->include('colaboradores/footer') ?>