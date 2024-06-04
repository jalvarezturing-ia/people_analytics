<?= $this->include('colaboradores/header') ?>
<?php $numero = 1; ?>
<?php $numero1 = 1; ?>
<?php $numero2 = 1; ?>

<style>
    .border-left-red {
        border-left: 4px solid #4c49ea;
        /* Puedes ajustar el grosor del borde y el color según tus necesidades */
    }

    .border-left-amarillo {
        border-left: 4px solid #952aff !important;
        /* Puedes ajustar el grosor del borde y el color según tus necesidades */
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

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> Reporte de
        incidencias
        <i class="fas fa-info-circle"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-info-circle" style="color: #3498db;"></i> Nuevo reporte de incidencias
            </strong>
            <hr>
            <div id="btns">

                <a href="#" class="ver-periodo-btn" onclick="mostrar('reporte')" id="5" data-toggle="tooltip"
                    data-placement="bottom" title="Reporte de incidencias"> <i class="fas fa-clock"></i>
                    Reporte
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="mostrar('total')" id="6" data-toggle="tooltip"
                    data-placement="bottom" title="Control de reposición de horas"> <i class="fas fa-check-circle"></i>
                    Horas </a>
            </div>
        </div>

        <div class="card-body" id="pendienteSection">

            <?php if (empty ($reporte)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay incidencias tuyas reportadas, todo va
                    bien por aquí
                    <?= session('nombre'); ?> &#128561;
                </div>
            <?php else: ?>
                <table>
                    <tr>
                        <th>#</th>
                        <th style="text-align: center;">Fecha y hora salida</th>
                        <th style="text-align: center;">Fecha y hora regreso</th>
                        <th style="text-align: center;">Motivo</th>
                        <th style="text-align: center;">Justificante</th>
                        <th style="text-align: center;">H. Reponer</th>
                        <th style="text-align: center;">Descripción</th>
                        <th style="text-align: center;">Menú</th>
                    </tr>
                    <?php foreach ($reporte as $pendiente): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero; ?>
                            </td>
                            <td>
                                <?= $pendiente->f_salida ?>
                            </td>
                            <?php if ($pendiente->f_regreso == ''): ?>
                                <td style="background:#64C4FF; color: white; font-weight:bold;">
                                    <?= $pendiente->resuelta ?>
                                </td>
                            <?php else: ?>

                                <td>
                                    <?= $pendiente->f_regreso ?>
                                </td>
                            <?php endif; ?>

                            <td style="background:#64C4FF; color: white; font-weight:bold;">
                                <?= $pendiente->motivo ?>
                            </td>

                            <?php if ($pendiente->evidencia == ''): ?>
                                <td style="background:#64C4FF; color: white; font-weight:bold;">
                                    <?= $pendiente->resuelta ?>
                                </td>
                            <?php else: ?>

                                <td> <a href="#"
                                        onclick='mostrarImagen("<?php echo base_url("/permisos/$pendiente->evidencia"); ?>")'>
                                        <video src="<?php echo base_url("/permisos/$pendiente->evidencia"); ?>" alt="img"
                                            class="rounded-thumbnail img-fluid"
                                            style="width: 40px; height: 20px; object-fit: cover;"></video>
                                    </a></td>
                            <?php endif; ?>

                            <td>
                                <?= $pendiente->horas_reponer ?> hrs
                            </td>
                            <td>
                                <?php
                                $descripcion = strlen($pendiente->descripcion) > 30 ? substr($pendiente->descripcion, 0, 30) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($pendiente->descripcion) . '\')">...</a>' : $pendiente->descripcion;
                                echo $descripcion;
                                ?>
                            </td>

                            <td>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <?php if ($pendiente->resuelta != 'Resuelta'): ?>

                                        <a href="#!" onclick="resolver(event,
                                        '<?php echo $pendiente->id; ?>', 
                                        '<?php echo $pendiente->descripcion; ?>', 
                                        '<?php echo $pendiente->f_salida; ?>', 
                                        '<?php echo $pendiente->horas_reponer; ?>'
                                        )"><i class="fas fa-edit" style="color: blue;"></i> Resolver reporte</a>

                                    <?php else: ?>

                                        <a href="#!"><i class="fas fa-check-circle" style="color: green;"></i>
                                            <?= $pendiente->resuelta ?>
                                        </a>

                                    <?php endif; ?>
                                    <br>
                                    <a href="#!"
                                        onclick="eliminarr(event, '<?php echo $pendiente->id ?>', '<?php echo $pendiente->evidencia ?>')"
                                        title="Eliminar permiso"><i class="fas fa-trash" style="color: red;"></i> Eliminar
                                        reporte </a>
                            </td>
                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>

            <?php endif; ?>
        </div>

        <div class="card-body" id="autorizadosSection" style="display:none;">
            <div class="row">
                <div class="ag-courses_item">
                    <a href="#!" onclick="mostrar('total')" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                            Horas para reponer
                        </div>
                        <div class="ag-courses-item_date-box">
                            Total de horas para reponer
                            <span class="ag-courses-item_date">
                            </span>
                        </div>
                    </a>
                </div>
                <div class="ag-courses_item" >
                    <a href="#!" onclick="mostrar('proceso')" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Horas en proceso

                        </div>
                        <div class="ag-courses-item_date-box">
                            Control de horas para reponer

                            <span class="ag-courses-item_date">

                            </span>
                        </div>
                    </a>
                </div>
                <div class="ag-courses_item" >
                    <a href="#!" onclick="mostrar('asistencia')" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            Horas recuperadas

                        </div>
                        <div class="ag-courses-item_date-box">
                            Total de horas recuperadas
                            <span class="ag-courses-item_date">

                            </span>
                        </div>
                    </a>
                </div>
                <!-- <div class="col-lg-4 col-sm-4">
                    <div class="card-box bg-red">
                        <div class="inner">
                            <h3> <a href="#!" onclick="mostrar('total')">Horas para reponer

                                </a> </h3>
                            <p> <a href="#!" onclick="mostrar('total')">Total de
                                    horas para reponer

                                </a>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                        </div>
                        <a href="#!" onclick="mostrar('total')" class="card-box-footer" id="pendientesBtn2"><i
                                class="fa fa-arrow-circle-down" onclick="mostrar('total')"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div class="card-box bg-orange">
                        <div class="inner">
                            <h3> <a href="#!" onclick="mostrar('proceso')">Horas en proceso

                                </a> </h3>
                            <p> <a href="#!" onclick="mostrar('proceso')">Control de
                                    horas para reponer
                                </a>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                        </div>
                        <a href="#!" onclick="mostrar('proceso')" class="card-box-footer" id="pendientesBtn2"><i
                                class="fa fa-arrow-circle-down" onclick="mostrar('proceso')"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div class="card-box bg-green">
                        <div class="inner">
                            <h3><a href="#!" onclick="mostrar('asistencia')">Horas repuestas

                                </a> </h3>
                            <p> <a href="#!" onclick="mostrar('asistencia')">Total de horas recuperadas</a>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                        </div>
                        <a href="#!" onclick="mostrar('asistencia')" class="card-box-footer" id="pendientesBtn1"><i
                                class="fa fa-arrow-circle-down" onclick="mostrar('asistencia')"></i></a>
                    </div>
                </div> -->
            </div>

        </div>


        <div class="card-body" id="sinreponer" style="display: none;">

        <?php if (empty ($reporte1)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay horas para reponer, todo va
                    bien por aquí &#128561;
                </div>
            <?php else: ?>
            <div class="card-columns" style="border-radius: 5rem;">
                <!-- Iterando sobre la variable $reporte -->
                <?php foreach ($reporte1 as $data): ?>
                    <div class="card border-left-red"
                        style=" box-shadow: rgb(38, 57, 77) 0px 10px 25px -10px; background: white;">
                        <div class="avatar mx-auto" style="border-radius: 4em; max-width: 55px; margin-top: 20px;">
                            <img src='<?php echo base_url("gifs/logo.svg"); ?>' class='rounded-circle img-fluid'>
                        </div>
                        <br>
                        <div class="card-body" style="background-color: white;">
                            <h5 class="card-title" style="text-align: center;">
                                <strong>Reposición</strong> <i class="fas fa-clock" style="color: blue;"></i>
                            </h5>
                            <div class="line"></div>
                            <strong class="strong-text">Motivo:</strong>
                            <?php
                            $descripcion = strlen($data->descripcion) > 30 ? substr($data->descripcion, 0, 30) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($data->descripcion) . '\')">...</a>' : $data->descripcion;
                            echo $descripcion;
                            ?>
                            <div class="line"></div>

                            <strong class="strong-text">Inicio:</strong>
                            <?= $data->f_salida; ?>
                            <div class="line"></div>

                            <strong class="strong-text">Fin:</strong>
                            <?= $data->f_regreso; ?>
                            <div class="line"> </div>

                            <strong>Reponer:</strong>
                            <?= $data->horas_reponer; ?> hrs
                            <div class="line"></div>

                            <strong>Restantes:</strong>
                            <?= $tot ? $tot : $data->horas_reponer ?> hrs
                            <div class="line"></div>

                            <?php if (($data->horas_reponer) == '0'): ?>
                            <?php else: ?>
                                <a href="<?php echo base_url("home/incidence/gestion/$id/$data->id_inc"); ?>" class="card-link"
                                    style="color: blue; text-decoration: underline;">Detalles</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>


        <div class="card-body" id="proceso" style="display:none">
            <?php if (empty ($proceso)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay horas en proceso, todo va
                    bien por aquí, verifica si tienes en <a href="#!" onclick="mostrar('proceso')">proceso</a>&#128561;
                </div>
            <?php else: ?>
                <div class="card-columns" style="border-radius: 5rem;">
                    <!-- Iterando sobre la variable $reporte -->
                    <?php foreach ($proceso as $proc): ?>
                        <div class="card border-left-amarillo"
                            style=" box-shadow: rgb(38, 57, 77) 0px 10px 25px -10px; background: white;">
                            <div class="avatar mx-auto" style="border-radius: 4em; max-width: 55px; margin-top: 20px;">
                                <img src='<?php echo base_url("gifs/logo.svg"); ?>' class='rounded-circle img-fluid'>
                            </div>
                            <br>
                            <div class="card-body" style="background-color: white;">
                                <h5 class="card-title" style="text-align: center;">
                                    <strong>
                                        <?= $proc->motivo; ?>
                                    </strong> <i class="fas fa-clock" style="color: blue;"></i>
                                </h5>
                                <div class="line"></div>
                                <strong class="strong-text">Salida:</strong>
                                <?= $proc->fecha_inicio; ?>
                                <div class="line"></div>

                                <strong class="strong-text">Regreso:</strong>
                                <?= $proc->fecha_fin; ?>
                                <div class="line"> </div>

                                <strong>Reponer inicial:</strong>
                                <?= $proc->h_reponer; ?> hrs
                                <div class="line"></div>

                                <strong>Total:</strong>
                                <?= $proc->h_reponer + $proc->h_restantes; ?> hrs
                                <div class="line"></div>

                                <?php if (($proc->h_reponer) == '0'): ?>
                                <?php else: ?>
                                    <a href="<?php echo base_url("home/incidence/reposicion/$id/$proc->id_repo"); ?>"
                                        class="card-link" style="color: blue; text-decoration: underline;">Detalles</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-body" id="repuestas" style="display: none;">
            <?php if (empty ($repuestas)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay horas repuestas en lista, todo va
                    bien por aquí, verifica si tienes en <a href="#!" onclick="mostrar('proceso')">proceso</a>&#128561;
                </div>
            <?php else: ?>

                <table>

                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">Índice</td>
                        <td style="text-align: center;">Inicio</td>
                        <td style="text-align: center;">Fin</td>
                        <td style="text-align: center;">Horas repuestas</td>
                        <td style="text-align: center;">Evidencia inicio</td>
                        <td style="text-align: center;">Evidencia fin</td>
                    </tr>

                    <?php foreach ($repuestas as $rep): ?>

                        <tr style="text-align: center;">
                            <td>
                                <?= $numero2; ?>
                            </td>
                            <td>
                                <?= $rep->fecha_inicio; ?>
                            </td>
                            <td>
                                <?= $rep->fecha_fin; ?>
                            </td>
                            <td>
                                <?= $rep->h_reponer; ?>hrs
                            </td>
                            <td style="text-align: center;">
                                <a href="#" data-toggle="tooltip" data-placement="bottom"
                                    title="Detalle de la captura de entrada"
                                    onclick='mostrarImagen("<?php echo base_url("/repo/$rep->evidencia_inic"); ?>")'>
                                    <img src="<?php echo base_url("/repo/$rep->evidencia_inic"); ?>" alt="img"
                                        class='rounded-Thumbnail img-fluid'
                                        style='width: 40px; height: 20px; object-fit: cover;'>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="#" data-toggle="tooltip" data-placement="bottom"
                                    title="Detalle de la captura de entrada"
                                    onclick='mostrarImagen("<?php echo base_url("/repo/$rep->evidencia_fin"); ?>")'>
                                    <img src="<?php echo base_url("/repo/$rep->evidencia_fin"); ?>" alt="img"
                                        class='rounded-Thumbnail img-fluid'
                                        style='width: 40px; height: 20px; object-fit: cover;'>
                                </a>
                            </td>
                        </tr>

                        <?php $numero2++; endforeach; ?>

                </table>
            </div>
        <?php endif; ?>
    </div>

</div>


<div id="loading-spinner" class="text-center">
    <div class="spinner-overlay"></div>
    <img src="<?php echo base_url("gifs/logo.svg"); ?>" class="spinner" alt="Spinner">
    <br>
    <br>
    <br>
    <br>
    <h4>Subiendo video: <strong>a People Analytics</strong></h4>
</div>





<script>
    function resolver(event, id, motivo, salida, horas) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada

        Swal.fire({
            title: '',
            html:
                `<div class="info-card vertical">
                        <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia ></a> Finalizar reporte de incidencias <i class="fas fa-info-circle"></i></h4>
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-info-circle" style="color: #3498db;"></i> Finalización reporte de incidencias </strong>
                        </div>

                        <div class="card-body" id="nuevoSection">
                            <form id="formRequest" action="<?php echo base_url("/home/closeincidencia"); ?>" method="post" enctype="multipart/form-data">
                            
                                <div class="form-group row">
                                    <label for="incidencia" class="col-sm-2 col-form-label">Id incidencia:</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="id_incidencia" class="form-control" value="${id}" required readonly>
                                            <input type="hidden" name="resuelta" class="form-control" value="Resuelta" required readonly>
                                        </div>
                                    <label for="motivo" class="col-sm-2 col-form-label">Motivo:</label>
                                        <div class="col-sm-4">
                        
                                            <textarea name="motivo" class="form-control" readonly
                                                placeholder="Escriba el motivo de la incidencia con detalle, ejemplo: Se fue el internet y/o luz en casa..."
                                                rows="3" minlength="3" maxlength="5000" required>${motivo}</textarea>
                                        </div>
                                </div>

                                <div class="form-group row">
                                    <label for="incidencia" class="col-sm-2 col-form-label">Fecha/Hora ocurruida:</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="salida" id="salida" class="form-control" value="${salida}" required readonly>
                                        </div>
                                    <label for="motivo" class="col-sm-2 col-form-label">Fecha/Hora regreso: <span style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="datetime-local" name="f_regreso" id="f_regreso" class="form-control" required >
                                        </div>
                                </div>

                                <div class="form-group row">
                                    <label for="incidencia" class="col-sm-2 col-form-label">Horas reponer:</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="h_reponer" id="h_reponer" class="form-control"  required>
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
                            </form>
                        </div>
                    </div>
                </div>`,
            showCancelButton: true,
            customClass: 'swal-wide',
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if (result.isConfirmed) {

                var video = document.getElementById('videoInput').value;
                var fecha = document.getElementById('f_regreso').value;
                var horas = document.getElementById('h_reponer').value;

                if (video === '' || video === null || fecha === '' || horas === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, no dejes campos vacios.',
                        confirmButtonColor: '#3498db',
                        confirmButtonText: "Entendido",
                    });
                } else {
                    const form = document.getElementById('formRequest');
                    form.submit();
                }

            }

        });;
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
            }, 3000);
        });
    });
</script>

<?= $this->include('colaboradores/footer') ?>