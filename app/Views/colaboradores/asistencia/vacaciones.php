<?= $this->include('colaboradores/header') ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> Solicitudes de
        vacaciones <i class="fas fa-calendar"></i>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            onclick="detalle1(event, ' <?= 'Tienes ' . $ingreso . ' días correspondientes de vacaciones ' ?>')">Detalle
            <i class='fas fa-exclamation-circle'></i>
        </button>
        <!--<div class="dropdown-menu acciones">
           <span><i class="fas fa-calendar" style="color: #3498db"></i> </span>
        </div>-->
    </h4>
    <br>

    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-calendar" style="color: #3498db;"></i> Solicitudes de vacaciones
            </strong>

            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="showSection('nueva')" id="zero" data-toggle="tooltip"
                    data-placement="bottom" title="Registrar un nuevo permiso"> <i class="fas fa-plus"></i> Nuevo
                </a>|
                <a href="#" class="ver-periodo-btn" onclick="showSection('pend')" id="2" data-toggle="tooltip"
                    data-placement="bottom" title="Detalle de los permisos pendientes"> <i class="fas fa-clock"></i>
                    Pendientes
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="showSection('auto')" id="3" data-toggle="tooltip"
                    data-placement="bottom" title="Detalle de los permisos autorizados"> <i
                        class="fas fa-check-circle"></i> Autorizados </a>
            </div>
        </div>

        <div class="card-body" id="nuevoSection">
            <form id="formulario" action="<?php echo base_url("/home/savevacas"); ?>" method="post"
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
                    <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información solicitud de
                        vacaciones</strong>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        En caso de dudas o sugerencias, favor de contactarse al Área de capital Humano: <a
                            href="https://api.whatsapp.com/send?phone=+525616631953&text=Hola, tengo una duda acerca de%20"
                            target='_blank'>5616631953.</a>
                         <br>

                        ¡Que tengan un excelente día!
                    </small>
                </div>
                <br>

                <?php if ($años >= '1'): ?>

                    <div class="alert alert-success" style="text-align: center;">
                        <span style="font-size: 13px;">
                            <?= session('nombre'); ?>, recuerda que debes solicitar tu periodo en un lapso de <strong> seis
                                meses, todo dependerá de la
                                aprobación que te de RH y tu Jefe Directo </strong>
                            &#128521;
                        </span>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Días correspondientes:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="totales" name="totales" class="form-control" value="<?= $ingreso ?>"
                                required readonly>

                        </div>
                        <?php if (empty($vacaciones)): ?>
                            <label for="nombre" class="col-sm-2 col-form-label">Días restantes:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="restantes" name="restantes" class="form-control"
                                    placeholder="Días restantes" value="<?= $ingreso ?>" required readonly>
                            </div>
                        <?php else: ?>
                            <?php foreach ($vacaciones as $key): ?>
                                <label for="nombre" class="col-sm-2 col-form-label">Días restantes:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" id="restantes" name="restantes" class="form-control"
                                        placeholder="Días restantes" value="<?= $key->restantes ?>" required readonly>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                    <div class="form-group row">
                        <label for="area" class="col-sm-2 col-form-label">Fecha inicio:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="date" id="f_inicio" name="f_inicio" class="form-control" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Fecha fin:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="date" id="f_fin" name="f_fin" class="form-control" required>
                        </div>

                    </div>
                    <div class="form-group row">

                        <label for="area" class="col-sm-2 col-form-label">Días solicitados:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="d_solicitados" id="d_solicitados" class="form-control"
                                placeholder="Ejemplo: 1,2,3 o 4 " required readonly>
                            <br>
                        </div>
                        <label for="area" class="col-sm-2 col-form-label">Guardar solicitud:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="submit" class="ver-periodo-btn2 text-center" value="Guardar" id="btn-save">
                        </div>
                    </div>


                    <div class="card-header" style="text-align: center;">
                        <strong><i class="fas fa-file-alt" style="color: #3498db;"></i> Documento de solicitud (Con nombre y
                            firma del colaborador a mano) <br>
                        Nombre: SOLICITUD_nombre y apellido_colaborador</strong>
                    </div>
                    <br>



                    <div class="form-group mb-2 text-center">
                        <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                            onchange="previewDoc()">
                    </div>
                    <br>
                    <div class="form-group mb-2 text-center">
                        <p id="docMessage"></p>
                    </div>

                    <div class="card-header" style="text-align: center;" id="notif">
                        <strong><input type="checkbox" required> Notifique al área de Capital Humano, Encargado y/o
                            Directivos sobre mi
                            solicitud.</strong>
                    </div>
                    <br>

                <?php else: ?>

                    <div class="alert alert-danger" style="text-align: center;">No tienes derecho a vacaciones aún,
                        <?= session('nombre'); ?> &#128516;
                    </div>

                <?php endif; ?>

            </form>
        </div>

        <div class="card-body" id="pendienteSection" style="display: none;">

            <?php if (empty($vacacioness)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay solicitudes pendientes.
                    <?= session('nombre'); ?> &#128516;
                </div>

            <?php else: ?>

                <table>
                    <tr style="text-align:center; font-weight: bold;">

                        <th>
                            Días totales
                        </th>
                        <th>
                            Días restantes
                        </th>

                        <th>
                            Inicio
                        </th>
                        <th>
                            Fin
                        </th>
                        <th>
                            Días solicitados

                        </th>
                        <th>
                            Documento
                        </th>
                        <th>Opciones</th>
                    </tr>

                    <?php foreach ($vacacioness as $info):

                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");

                        $fecha_nac = strftime("%d/%B/%Y", strtotime($info->f_inicio));
                        $fecha_ing = strftime("%d/%B/%Y", strtotime($info->f_fin));
                        if ($info->estado == '0'):
                            ?>

                            <tr style="text-align:center;">
                                <td>
                                    <?= $info->d_totales ?>
                                </td>
                                <td>
                                    <?= $info->restantes ?>
                                </td>
                                <td>
                                    <?= $fecha_nac ?>
                                </td>
                                <td>
                                    <?= $fecha_ing ?>
                                </td>
                                <td>
                                    <?= $info->d_solicitados ?>
                                </td>

                                
                                <td style="color: #4070f4; text-decoration: underline; ">
                                    <a href="<?php echo base_url("/d_vacas/$info->documento"); ?>" target="_blank"><i class="fas fa-file-pdf"></i> </a>
                                </td>
                                <td>
                                    <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                        <i class='fas fa-caret-down'></i>
                                    </button>
                                    <div class="dropdown-menu acciones">
                                        <a href="#!" onclick="eliminarSing(event, '<?php echo $info->id ?>')"
                                            title="Eliminar permiso">&nbsp;&nbsp;<i class="fas fa-trash" style="color: red;"></i>
                                            Eliminar</a>
                                        <br>&nbsp;&nbsp;<a
                                            href="<?php echo base_url("home/edit/$id/$info->id/$info->d_totales/$info->f_inicio/$info->f_fin/$info->restantes/$info->d_solicitados") ?>"><i
                                                class="fas fa-edit" style="color: blue;"></i> Editar</a>

                                    </div>
                                </td>
                            </tr>

                        <?php endif; endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <div class="card-body" id="autorizadosSection" style="display:none;">

            <?php if (empty($vacacioness)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay solicitudes pendientes.
                    <?= session('nombre'); ?> &#128516;
                </div>

            <?php else: ?>

                <table>
                    <tr style="text-align:center; font-weight: bold;">

                        <th>
                            Días totales
                        </th>
                        <th>
                            Días restantes
                        </th>

                        <th>
                            Inicio
                        </th>
                        <th>
                            Fin
                        </th>
                        <th>
                            Días tomados

                        </th>
                        <th>
                            Estado
                        </th>

                        <th>
                            Documento
                        </th>

                    </tr>

                    <?php foreach ($vacacioness as $info):

                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");

                        $fecha_nac = strftime("%d/%B/%Y", strtotime($info->f_inicio));
                        $fecha_ing = strftime("%d/%B/%Y", strtotime($info->f_fin));
                        if ($info->estado > '0'):
                            ?>

                            <tr style="text-align:center;">
                                <td>
                                    <?= $info->d_totales ?>
                                </td>
                                <td>
                                    <?= $info->restantes ?>
                                </td>
                                <td>
                                    <?= $fecha_nac ?>
                                </td>
                                <td>
                                    <?= $fecha_ing ?>
                                </td>
                                <td>
                                    <?= $info->d_solicitados ?>
                                </td>


                                <?php if ($info->estado == '1'): ?>
                                    <td style="background: #3498db; color: white; font-weight:bold;"> Aprobado </td>
                                <?php elseif ($info->estado == '2'): ?>
                                    <td style="background: red; color: white; font-weight:bold;"> Rechazado</td>
                                <?php else: ?>
                                    <td style="background: green; color: white; font-weight:bold;">En cambio</td>
                                <?php endif; ?>

                                <td style="color: #4070f4; text-decoration: underline; ">
                                    <a href="<?php echo base_url("/d_vacas/$info->documento"); ?>" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                </td>

                            </tr>
                        <?php endif; endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

</div>
</div>



<script>
    function detalle1(event, descripcion) {
        event.preventDefault(); // Evita que el enlace realice su acción predeterminada
        Swal.fire({
            title: 'Detalles del motivo',
            html: `${descripcion} <br>
            <?php if (empty($archivo)): ?>
                <?php else: ?>
                            <a href="<?php echo base_url("d_vacas/$archivo"); ?>" target="_blank" > <span style="color: #1371C7"> <i class="fas fa-file-alt "></i> Descarga el formato aqui </span></a>
                    <?php endif; ?>
                    `,
            icon: 'warning',
            confirmButtonColor: '#1371C7',
            confirmButtonText: "Gracias",
        });
    }
</script>

<script>
    // Obtener los elementos de entrada de fecha
    const fSalida = document.getElementById('f_inicio');
    const fRegreso = document.getElementById('f_fin');

    const totales = document.getElementById('totales').value;
    const restantes = document.getElementById('restantes').value;

    //alert(restantes);

    // Escuchar los cambios en las fechas
    fSalida.addEventListener('change', calcularDias);
    fRegreso.addEventListener('change', calcularDias);

    function calcularDias() {

        console.log("se llamo la función");
        // Obtener las fechas seleccionadas
        const salida = new Date(fSalida.value);
        const regreso = new Date(fRegreso.value);


        let diasLaborables = 0;
        const fechaTemp = new Date(salida);
        //console.log("Seleccionado--> " +  fechaTemp.getDay());

        while (fechaTemp <= regreso) {
            const diaSemana = fechaTemp.getDay();
            if (diaSemana !== 0 && diaSemana !== 6) { // Excluir sábados y domingos
                //sabado            //domingo
                diasLaborables++;
            }
            fechaTemp.setDate(fechaTemp.getDate() + 1);
        }
        const resta = restantes - diasLaborables;
        //totales_12/14/etc   //d_solicitados


        if (resta == '0') {
            document.getElementById('d_solicitados').value = diasLaborables;
            document.getElementById('restantes').value = resta;
            document.getElementById('btn-save').style.display = "block";

        } else if (resta <= '0') {

            // Mostrar los días en el campo de entrada
            document.getElementById('d_solicitados').value = diasLaborables;
            document.getElementById('restantes').value = "Ya no tienes días pendientes.";
            document.getElementById('btn-save').style.display = "block";
        }
        else {

            document.getElementById('d_solicitados').value = diasLaborables;
            document.getElementById('restantes').value = resta;
            document.getElementById('btn-save').style.display = "block";
        }

        if (diasLaborables > restantes) {
            document.getElementById('d_solicitados').value = "Ya no puedes solicitar más dias.";
            document.getElementById('btn-save').style.display = "none";
            //console.log("Ya no puedes solicitar mas dias");

        }
    }

    if (restantes == 0) {

        document.getElementById('d_solicitados').value = "Ya obtuviste todas tus vacaciones.";
        document.getElementById('btn-save').setAttribute("readonly", "readonly");
        document.getElementById('notif').style.display = "none";
        document.getElementById('restantes').value = "Ya obtuviste todas tus vacaciones.";

        fSalida.setAttribute("readonly", "readonly");
        fRegreso.setAttribute("readonly", "readonly");

    }


</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('zero').classList.add('activo');
    });


    function showSection(seccion) {

        document.getElementById('nuevoSection').style.display = 'none';
        document.getElementById('pendienteSection').style.display = 'none';
        document.getElementById('autorizadosSection').style.display = 'none';

        document.getElementById('zero').classList.remove('activo');
        document.getElementById('2').classList.remove('activo');
        document.getElementById('3').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'nueva') {
            document.getElementById('nuevoSection').style.display = 'block';
            document.getElementById('zero').classList.add('activo');

        } else if (seccion === 'pend') {
            document.getElementById('pendienteSection').style.display = 'block';
            document.getElementById('2').classList.add('activo');

        } else if (seccion === 'auto') {
            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('3').classList.add('activo');

        }
    }
</script>


<script>

    function eliminarSing(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará su selección. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/eliminarV/'); ?>${id}/`;
                window.location.href = url;
            }
        });
    }
</script>


<script>
    function previewDoc() {
        var input = document.getElementById('docInput');
        var message = document.getElementById('docMessage');

        if (input.files && input.files[0]) {
            // Obtener el nombre del archivo seleccionado
            var fileName = input.files[0].name;
            message.innerText = 'Documento seleccionado: ' + fileName;
        } else {
            message.innerText = 'No se ha seleccionado un documento DOCX';
        }
    }
</script>


<?= $this->include('colaboradores/footer') ?>