<?= $this->include('colaboradores/header') ?>
<?php $numero = 1; ?>
<?php $numero1 = 1; ?>

<style>
    .ver-periodo-btn.activo {
        color: #FFFF;
        background-color: #1371C7;

    }
</style>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> Permisos de salida <i
            class="fas fa-sign-out-alt"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-sign-out-alt" style="color: #3498db;"></i> Registrar un permiso de salida
            </strong>

            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion1('nueva')" id="1" data-toggle="tooltip"
                    data-placement="bottom" title="Registrar un nuevo permiso"> <i class="fas fa-plus"></i> Nuevo
                </a>|
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion1('pend')" id="2" data-toggle="tooltip"
                    data-placement="bottom" title="Detalle de los permisos pendientes"> <i class="fas fa-clock"></i>
                    Pendientes
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion1('auto')" id="3" data-toggle="tooltip"
                    data-placement="bottom" title="Detalle de los permisos autorizados"> <i
                        class="fas fa-check-circle"></i> Autorizados </a>
            </div>
        </div>

        <div class="card-body" id="nuevoSection">
            <form id="formulario" action="<?php echo base_url("/home/savepermit"); ?>" method="post"
                enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                    <div class="col-sm-4">
                        <input type="hidden" name="user_id" class="form-control" value="<?= $id ?>">
                        <input type="text" name="nombre" class="form-control" value="<?= $name; ?>" required readonly>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <input type="text" name="descripcion" class="form-control" value="<?= $desc; ?>" required
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fecha" class="col-sm-2 col-form-label">Puesto:</label>
                    <div class="col-sm-4">
                        <input type="text" name="puesto" class="form-control" value="<?= $puesto; ?>" required readonly>
                    </div>
                    <label for="hora" class="col-sm-2 col-form-label">Correo:</label>
                    <div class="col-sm-4">
                        <input type="email" name="correo" class="form-control" value="<?= $mail; ?>" required readonly>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información de
                        salida</strong>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        1. En caso de no tener justificante autorizado por Capital Humano se tomará como falta
                        injustificada.
                        <br>
                        2. En caso de dudas o sugerencias, favor de contactarse con el Área de Capital Humano: <a
                            href="https://api.whatsapp.com/send?phone=+525616631953&text=Hola, tengo una duda acerca de%20"
                            target='_blank'>5616631953.</a>
                         <br>

                        ¡Que tengan un excelente día!
                    </small>
                </div>
                <br>

                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Motivo de salida:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">


                        <select name="motivo" class="form-control" id="cars" required>
                            <option value="none">Seleccione</option>
                            <option value="Medico">Médico</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <br>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fecha y hora de salida:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="datetime-local" id="f_salida" name="f_salida" class="form-control" required
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Fecha y hora de regreso:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">

                        <input type="datetime-local" id="f_regreso" name="f_regreso" class="form-control" required
                            readonly>

                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Horas a reponer:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="number" name="horas_reponer" id="horas" class="form-control"
                            placeholder="Ejemplo: 1,2,3 o 4 " required readonly>
                        <br>

                        <textarea name="motivo1" class="form-control" style="display:none;" id="motivoTextarea"
                            placeholder="Escriba el motivo de su salida con detalle, ejemplo: Tengo cita en el médico..."
                            rows="3" minlength="3" maxlength="5000" required></textarea>
                    </div>
                </div>


                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia y/o Justificante</strong>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                        required="">
                </div>
                <br>

                <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                    <img id="imagenPreview" src="#" style="max-width: 100%; max-height: 300px;">
                </div>
                <br>

                <div class="card-header" style="text-align: center;">
                    <strong><input type="checkbox" required> Al completar este formulario, me comprometo a compensar las
                        horas solicitadas, ya sea durante el fin de semana o después de mi jornada laboral. Reafirmo mi
                        compromiso de completar las tareas requeridas puntualmente para cumplir con mis objetivos
                        diarios.</strong> <br>
                    <strong><input type="checkbox" required> Notifique al área de Capital Humano y Directivos sobre mi
                        permiso de salida.</strong>
                </div>
                <br>
                <div class="form-group mb-2 text-center">
                    <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar">
                </div>
            </form>
        </div>

        <div class="card-body" id="pendienteSection" style="display: none;">
           
            <?php if (empty($pendientes)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay permisos solicitados.
                    <?= session('nombre'); ?> &#128516;
                </div>
            <?php else: ?>
                <table>
                    <tr style="font-weight:bold;">
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Fecha salida</th>
                        <th style="text-align: center;">Fecha regreso</th>
                        <th style="text-align: center;">Detalle</th>
                        <th style="text-align: center;">A reponer</th>
                        <th style="text-align: center;">Justificante</th>
                        <th style="text-align: center;">Opción</th>
                    </tr>
                    <?php foreach ($pendientes as $pendiente): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero; ?>
                            </td>
                            <td>
                                <?= $pendiente->f_salida ?>
                            </td>
                            <td>
                                <?= $pendiente->f_regreso ?>
                            </td>
                            <td>
                                <?php
                                $descripcion = strlen($pendiente->descripcion) > 30 ? substr($pendiente->descripcion, 0, 30) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($pendiente->descripcion) . '\')">...</a>' : $pendiente->descripcion;
                                echo $descripcion;
                                ?>
                            </td>
                            <td>
                                <span style="color:red;">
                                    <?= $pendiente->horas_reponer ?> hrs
                                </span>
                            </td>
                            <td>
                                <a href="#"
                                    onclick='mostrarImagen("<?php echo base_url("/permisos/$pendiente->evidencia"); ?>")'>
                                    <img src="<?php echo base_url("/permisos/$pendiente->evidencia"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;">
                                </a>
                            </td>

                            <td>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href="#!"
                                        onclick="eliminar(event, '<?php echo $pendiente->id ?>', '<?php echo $pendiente->evidencia ?>')"
                                        title="Eliminar permiso">&nbsp;&nbsp;<i class="fas fa-trash" style="color: red;"></i>
                                        Eliminar</a>

                                </div>
                            </td>
                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>

            <?php endif; ?>
        </div>

        <div class="card-body" id="autorizadosSection" style="display:none;">
           
            <?php if (empty($autorizados)): ?>
                <div class="alert alert-danger" style="text-align: center;">No hay permisos autorizados.
                    <?= session('nombre'); ?> &#128516;
                </div>
            <?php else: ?>
                <table>
                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">#</th>
                        <th style="text-align: center;">Fecha y hora salida</th>
                        <th style="text-align: center;">Fecha y hora regreso</th>
                        <th style="text-align: center;">Detalles </th>
                        <th style="text-align: center;">A reponer</th>
                        <th style="text-align: center;">Justificante</td>
                    </tr>
                    <?php foreach ($autorizados as $autorizado): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero1; ?>
                            </td>
                            <td>
                                <?= $autorizado->f_salida ?>
                            </td>
                            <td>
                                <?= $autorizado->f_regreso ?>
                            </td>
                            <td>
                                <?php
                                $descripcion = strlen($autorizado->descripcion) > 30 ? substr($autorizado->descripcion, 0, 30) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($autorizado->descripcion) . '\')">...</a>' : $autorizado->descripcion;
                                echo $descripcion;
                                ?>
                            </td>
                            <td style="color:red;">
                                <?= $autorizado->horas_reponer ?> hrs
                            </td>
                            <td>
                                <a href="#"
                                    onclick='mostrarImagen("<?php echo base_url("/permisos/$autorizado->evidencia"); ?>")'>
                                    <img src="<?php echo base_url("/permisos/$autorizado->evidencia"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;">
                                </a>
                            </td>


                        </tr>
                        <?php $numero1++; endforeach; ?>
                </table>

            <?php endif; ?>
        </div>

    </div>
</div>





<script>
    document.getElementById("cars").addEventListener("change", function () {

        var motivoTextarea = document.getElementById("motivoTextarea");
        var horas = document.getElementById("horas");
        var f_salida = document.getElementById("f_salida");
        var f_regreso = document.getElementById("f_regreso");

        if (this.value === "Medico") {

            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");
            horas.setAttribute("readonly", "readonly");
            motivoTextarea.style.display = "none";
            motivoTextarea.removeAttribute("required");
            horas.value = "0";

            //horas.style.display = "block";
            //horas1.style.display = "none";

        } else if (this.value === "Otro") {

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

        } else if (this.value === "none") {

            motivoTextarea.style.display = "none";
            motivoTextarea.removeAttribute("required");
            horas.setAttribute("readonly", "readonly");
            f_salida.setAttribute("readonly", "readonly");
            f_regreso.setAttribute("readonly", "readonly");

        }
    });
</script>




<?= $this->include('colaboradores/footer') ?>