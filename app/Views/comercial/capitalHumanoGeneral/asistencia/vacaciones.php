<?= $this->include('comercial/capitalHumanoGeneral/header') ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> Análisis de
        vacaciones <i class="fas fa-calendar"></i>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Detalle
            <i class='fas fa-exclamation-circle'></i>
        </button>
        <div class="dropdown-menu acciones">
            <a href="#" onclick="subirdocx(event)" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                title="Registro de nuevo documento de vacaciones"> <span><i class="fas fa-file-alt"
                        style="color: #3498db"></i> Subir documento vacaciones </span></a>
        </div>
    </h4>
    <br>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-calendar" style="color: #3498db;"></i> Análisis de
                vacaciones </strong>
            <br><br>
            <a href="#" class="ver-periodo-btn" onclick="mostrarSeccions('entrada')" id="pendientesBtn"> <i
                    class="fas fa-check-circle"></i> Pendientes
            </a>|
            <a href="#" class="ver-periodo-btn" onclick="mostrarSeccions('salida')" id="pagadosBtn"> <i
                    class="fas fa-sign-out-alt"></i> Lista aprobadas</a>
        </div>


        <div class="card-body" id="pendientesSection">

            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td>Nombre</td>
                    <td>Dias totales</td>
                    <td>Dias restantes</td>
                    <td>Inicio</td>
                    <td>Fin</td>
                    <td>Dias solicitados</td>
                    <td>Estado</td>
                    <td>Opciones</td>
                    <td>Menú</td>
                </tr>

                <?php foreach ($info as $inf):
                    if ($inf->estado === '0'): // Verifica si el estado es '0'
                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");

                        $fecha_nac = strftime("%d/%B/%Y", strtotime($inf->f_inicio));
                        $fecha_ing = strftime("%d/%B/%Y", strtotime($inf->f_fin));
                        ?>
                        <tr style="text-align:center;">

                            <td style="font-weight:bold;">
                                <?= $inf->nombre . " " . $inf->apellido_paterno ?>
                            </td>
                            <td>
                                <?= $inf->d_totales ?>
                            </td>
                            <td>
                                <?= $inf->restantes ?>
                            </td>
                            <td>
                                <?= $fecha_nac ?>
                            </td>
                            <td>
                                <?= $fecha_ing ?>
                            </td>
                            <td>
                                <?= $inf->d_solicitados ?>
                            </td>
                            <td style="background: #3498db; font-weight: bold; color: white; ">
                                Pendiente
                            </td>
                            <td>
                                <select name="estado" id="estado<?= $inf->id ?>" class="form-control">
                                    <!-- ID único generado dinámicamente -->
                                    <option value="none">Seleccione</option>
                                    <option value="Aprobar">Aprobar</option>
                                    <option value="Rechazar">Rechazar</option>
                                    <option value="Pendiente">Pendiente</option>
                                </select>
                            </td>
                            <td>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones"><a href="#!"
                                        onclick="elimVac(event, '<?php echo $inf->id ?>')" title="Eliminar permiso"><i
                                            class="fas fa-trash" style="color:red;"></i> Eliminar
                                        permiso </a>
                                    <br>
                                    <a href="<?php echo base_url("/home/editvaccap/$inf->id/$inf->d_totales/$inf->f_inicio/$inf->f_fin/$inf->restantes/$inf->d_solicitados"); ?>"
                                        title="Eliminar permiso"><i class="fas fa-edit" style="color:blue;"></i> Editar
                                        permiso </a>
                                </div>
                            </td>

                        </tr>
                    <?php endif; // Fin de la condición                  ?>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="card-body" id="pagadosSection" style="display:none;">

            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td>Nombre</td>
                    <td>Dias totales</td>
                    <td>Dias restantes</td>
                    <td>Inicio</td>
                    <td>Fin</td>
                    <td>Dias solicitados</td>
                    <td>Estado</td>

                </tr>

                <?php foreach ($info as $inf):
                    if ($inf->estado === '1'): // Verifica si el estado es '0'
                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");

                        $fecha_nac = strftime("%d/%B/%Y", strtotime($inf->f_inicio));
                        $fecha_ing = strftime("%d/%B/%Y", strtotime($inf->f_fin));
                        ?>

                        <tr style="text-align:center;">

                            <td style="font-weight:bold;">
                                <?= $inf->nombre . " " . $inf->apellido_paterno ?>
                            </td>
                            <td>
                                <?= $inf->d_totales ?>
                            </td>
                            <td>
                                <?= $inf->restantes ?>
                            </td>
                            <td>
                                <?= $fecha_nac ?>
                            </td>
                            <td>
                                <?= $fecha_ing ?>
                            </td>
                            <td>
                                <?= $inf->d_solicitados ?>
                            </td>
                            <td style="background: #3498db; font-weight: bold; color: white; ">
                                Aprobadas
                            </td>

                        </tr>
                    <?php endif; // Fin de la condición                  ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>


<!-- Formulario oculto -->
<form id="formulario" method="post" action="<?php echo base_url("home/savevacasadmin") ?>" style="display: none;">
    <input type="hidden" name="id_periodo" id="id_periodo">
    <input type="hidden" name="estado_seleccionado" id="estado_seleccionado">
</form>

<script>
    // Manejar el cambio en el menú desplegable
    <?php foreach ($info as $inf): ?>
        document.getElementById("estado<?= $inf->id ?>").addEventListener("change", function () {
            var id_periodo = <?= $inf->id ?>; // ID del período
            var estado_seleccionado = this.value; // Estado seleccionado
            console.log("ID del período: " + id_periodo);
            console.log("Estado seleccionado: " + estado_seleccionado);

            // Actualiza los campos ocultos del formulario con los valores obtenidos
            document.getElementById("id_periodo").value = id_periodo;
            document.getElementById("estado_seleccionado").value = estado_seleccionado;

            // Envía el formulario automáticamente



            if (this.value === "Aprobar") {

                var r = confirm("¿Desea aprobarla?");
                if (r == true) {
                    document.getElementById("formulario").submit();
                }
                else {
                    alert("No se envió.");
                }

            }
            if (this.value === "Rechazar") {

                var r = confirm("¿Desea rechazarla?");
                if (r == true) {
                    document.getElementById("formulario").submit();
                }
                else {
                    alert("No se envió.");
                }

            }
            if (this.value === "Pendiente") {

                var r = confirm("¿Desea dejarla como pendiente?");
                if (r == true) {
                    document.getElementById("formulario").submit();
                }
                else {
                    alert("No se envió.");
                }

            }

        });
    <?php endforeach; ?>
</script>


<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('pendientesBtn').classList.add('activo');
    });

    function mostrarSeccions(seccion) {
        // Oculta ambas secciones
        document.getElementById('pendientesSection').style.display = 'none';
        document.getElementById('pagadosSection').style.display = 'none';
        document.getElementById('pendientesBtn').classList.remove('activo');
        document.getElementById('pagadosBtn').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'entrada') {
            document.getElementById('pendientesSection').style.display = 'block';
            document.getElementById('pendientesBtn').classList.add('activo');
            document.getElementById('asistenciaSection').style.display = 'block';

        } else if (seccion === 'salida') {
            document.getElementById('pagadosSection').style.display = 'block';
            document.getElementById('pagadosBtn').classList.add('activo');
            document.getElementById('salidaSection').style.display = 'block';

        }
    }




    function elimVac(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el permiso. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, continuar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/deleteVacax/'); ?>${id}/`;
                window.location.href = url;
            }
        });
    }

</script>


<script>
    function subirdocx(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/attendance"); ?>"> Asistencia > Vacaciones > </a> Subir documento vacaciones</strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body">
                            <form id="formReq" action="<?php echo base_url("/home/document"); ?>" method="post" enctype="multipart/form-data">
                                <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-file-alt" style="color: #3498db;"></i> Evidencia </strong>
                                </div>
                                <br>
                                <div class="form-group mb-2 text-center">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf" onchange="previewDoc()">
                                </div>
                                 <br>
                                <div class="form-group mb-2 text-center">
                                <p id="docMessage"></p>
                                </div>

                                <?php if (!empty($archivo)) { ?>
                    <div class="col-lg-12 col-md-7">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 70%;"> <!-- Redujimos el ancho de esta celda -->
                                    <a href="#" 
                                    class="btn btn-outline-info btn-xs btn-radius" style="text-align: center;">
                                        <font class="lead"> Documento actual <strong><?= $archivo; ?></strong> </font>
                                    </a>
                                </td>
                       
                            </tr>
                        </table>
                    </div>
            <?php } else {
                                    echo '<h4><div class="btn btn-outline-danger btn-xs btn-radius" style="text-align: center;" > No hay ningún documento guardado </div></h4>';
                                } ?>
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

                var img = document.getElementById('docInput').value;

                if (img === '' || img === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, selecciona un documento.',
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
<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>