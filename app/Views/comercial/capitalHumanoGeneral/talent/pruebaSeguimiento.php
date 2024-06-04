<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
    .progress {
        height: 20px;
    }

    .progress-bar {
        background-color: #28a745;
        color: #000000;
        font-weight: bold;
    }

    th {
        cursor: pointer;
    }

    th.sorted-asc::after {
        content: " \2191";
        /* Up arrow */
    }

    th.sorted-desc::after {
        content: " \2193";
        /* Down arrow */
    }

    #pagination-container {
        text-align: center;
        margin-top: 20px;
    }

    #pagination-container a {
        display: inline-block;
        padding: 8px 12px;
        margin: 2px;
        border: 1px solid #3498db;
        border-radius: 4px;
        text-decoration: none;
        color: #000000;
        transition: background-color 0.3s, color 0.3s;
        font-family: "Century Gothic";
    }

    #pagination-container a:hover {
        background-color: #3498db;
        color: #fff;
    }

    #pagination-container .current-page {
        background-color: #3498db;
        color: #fff;
    }

    .cv-link {
        color: #4c49ea;
        text-decoration: underline;
        display: inline-block;
    }

    .cv-link:hover {
        color: #2e2bb3;
    }

    .cv-link i {
        margin-left: 5px;
    }

    /* Estilos para FontAwesome, asegúrate de incluir FontAwesome en tu proyecto */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/ats"); ?>">Talent Management | Candidatos por
            áreas </a> | <?= $vacante ?>
        <i class="fas fa-tasks"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='#!' class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                title="Registra un nuevo candidato" style="border-radius: 1rem;">
                <i class='fas fa-users'></i> Agregar candidato
            </a>
            <a href='<?php echo base_url("/home/forms") ?>' class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Formularios candidatos" style="border-radius: 1rem;">
                <i class='fas fa-tasks'></i> Formularios vacantes
            </a>
        </div>
    </h4>
    <hr>

    <div class="col-md-3 " style="">
        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="estadoEncuestas(this)">
            <option value="proceso">Recientes</option>
            <option value="completados">Candidatos viables</option>
            <option value="no_viables">Candidatos no viables</option>
        </select>
    </div>
    <!-- todos  -->
    <div class="card-body" id="proceso">
        <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar al candidato">
        </div>

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> <i class="fas fa-users"></i> <?= $tot ?>

                            <?php if ($tot == 1):
                                echo "candidato nuevo postulado";
                            else:
                                echo "candidatos nuevos postulados";
                            endif; ?></a></li>
                </ol>
            </div>
        </div>

        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
        <?php if (empty($candidatos)): ?>
            <div class="alert alert-danger" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
            <div style="text-align: left;">

                <a href="<?php echo base_url("home/ats") ?>" class="btn ver-periodo-btn1">Atrás</a>

            </div>
        <?php else: ?>

            <table id="users-table">
                <thead>
                    <tr>
                        <!-- <th> <input type="checkbox"> </th> -->
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Postulación</th>
                        <th style="text-align: center;">Inicio - Fin</th>
                        <th style="text-align: center;">Días totales </th>
                        <th style="text-align: center;">Progreso </th>
                        <th style="text-align: center;">Prueba </th>
                        <th style="text-align: center;">Comentarios</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                </thead>
                <tr style="font-size: 13px; text-align: center;">
                    <tbody id="table-body"></tbody>
                </tr>

            </table>
            <div style="text-align: left;">
                <br>
                <a href="<?php echo base_url("home/ats") ?>" class="btn ver-periodo-btn1">Atrás</a>
            </div>

            <div id="pagination-container">
                <!-- Aquí se generará la paginación -->
            </div>

        <?php endif; ?>
    </div>

    <!-- viables -->
    <div class="card-body" id="completados" style="display:none;">

        <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar al candidato">
        </div>

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> <i class="fas fa-users"></i>
                            <?= $tot_viables ?>

                            <?php if ($tot_viables == 1):
                                echo "candidato nuevo postulado";
                            else:
                                echo "candidatos nuevos postulados";
                            endif; ?></a></li>
                </ol>
            </div>
        </div>

        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
        <?php if (empty($viables)): ?>
            <div class="alert alert-danger" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
            <div style="text-align: left;">

                <a href="<?php echo base_url("home/ats") ?>" class="btn ver-periodo-btn1">Atrás</a>

            </div>
        <?php else: ?>

            <table id="users-table">
                <thead>
                    <tr>
                        <!-- <th> <input type="checkbox"> </th> -->
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Postulación</th>
                        <th style="text-align: center;">Inicio - Fin</th>
                        <th style="text-align: center;">Días totales </th>
                        <th style="text-align: center;">Progreso </th>
                        <th style="text-align: center;">Prueba </th>
                        <th style="text-align: center;">Comentarios</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                </thead>
                <?php foreach ($viables as $viable):
                    // Convertir las fechas a objetos DateTime
                    $fechaInicio = new DateTime($viable->f_inicio);
                    $fechaFin = new DateTime($viable->f_fin);
                    $fechaHoy = new DateTime(); // Fecha actual
            
                    $fecha_nac = strftime("%d/%B/%Y", strtotime($viable->f_inicio));
                    $fecha_ing = strftime("%d/%B/%Y", strtotime($viable->f_fin));

                    $totalDias = $fechaInicio->diff($fechaFin)->days;
                    $diasTranscurridos = $fechaInicio->diff($fechaHoy)->days;
                    $progreso = min(max(($diasTranscurridos / $totalDias) * 100, 0), 100); // Asegurarse de que el progreso esté entre 0 y 100
            
                    $progressBarClass = $progreso === 100 ? 'bg-danger' : '';
                    $msjProgress = $progreso === 100 ? 'El colaborador ya finalizó su periodo' : ' El colaborador aun está en el periodo';

                    ?>

                    <tr style="font-size: 13px; text-align: center;">
                        <td><?= $viable->nombre ?></td>
                        <td><?= $viable->fecha_hora ?></td>
                        <td><?= $fecha_nac . " al " . $fecha_ing ?></td>
                        <td><?= $viable->t_dias ?> días</td>
                        <td><!-- progreso -->
                            <div class="progress">
                                <div class="progress-bar <?= $progressBarClass; ?>" role="progressbar"
                                    style="width: <?= $progreso ?>%;" aria-valuenow="<?= $progreso ?>" aria-valuemin="0"
                                    aria-valuemax="100" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="<?= $msjProgress; ?>">
                                    <?= round($progreso) ?>%
                                </div>
                            </div>
                        </td>
                        <td><?= $viable->t_prueba ?></td>
                        <td>
                        <?php
                            $descripcion = strlen($viable->comentarios) > 15 ? substr($viable->comentarios, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($viable->comentarios) . '\')">...</a>' : $viable->comentarios;
                            echo $descripcion;
                            ?></td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                <a href='#!'
                                    onclick="editarProg(event, '<?= $viable->id ?>', '<?= $viable->nombre ?>', '<?= $viable->fecha_hora ?>','<?= $viable->f_inicio ?>','<?= $viable->f_fin ?>', '<?= $viable->t_dias ?>','<?= $viable->t_prueba ?>','<?= $viable->comentarios ?>','<?= $progreso ?>', '<?= $progressBarClass ?>', '<?= $msjProgress ?>','<?= $viable->enlace_prueba ?>','<?= $viable->viable_prueba ?>')"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Editar detalles candidato" style="border-radius: 1rem;">
                                    <i class='fas fa-edit'></i> Editar prueba
                                </a>
                                <a href='#!' onclick="delAplicantPrueba(event, '${lista.id}', '${id_form}')"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Eliminar candidato" style="border-radius: 1rem; color:red;">
                                    <i class='fas fa-trash-alt'></i> Eliminar prueba candidato
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div style="text-align: left;">
                <br>
                <a href="<?php echo base_url("home/ats") ?>" class="btn ver-periodo-btn1">Atrás</a>
            </div>

        <?php endif; ?>


    </div>

    <!-- no viables -->
    <div class="card-body" id="no_viables" style="display:none;">
        
    <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar al candidato">
        </div>

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> <i class="fas fa-users"></i>
                            <?= $tot_no_viables ?>

                            <?php if ($tot_no_viables == 1):
                                echo "candidato nuevo postulado";
                            else:
                                echo "candidatos nuevos postulados";
                            endif; ?></a></li>
                </ol>
            </div>
        </div>

        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
        <?php if (empty($no_viables)): ?>
            <div class="alert alert-danger" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
            <div style="text-align: left;">

                <a href="<?php echo base_url("home/ats") ?>" class="btn ver-periodo-btn1">Atrás</a>

            </div>
        <?php else: ?>

            <table id="users-table">
                <thead>
                    <tr>
                        <!-- <th> <input type="checkbox"> </th> -->
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Postulación</th>
                        <th style="text-align: center;">Inicio - Fin</th>
                        <th style="text-align: center;">Días totales </th>
                        <th style="text-align: center;">Progreso </th>
                        <th style="text-align: center;">Prueba </th>
                        <th style="text-align: center;">Comentarios</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                </thead>
                <?php foreach ($no_viables as $viable):
                    // Convertir las fechas a objetos DateTime
                    $fechaInicio = new DateTime($viable->f_inicio);
                    $fechaFin = new DateTime($viable->f_fin);
                    $fechaHoy = new DateTime(); // Fecha actual
            
                    $fecha_nac = strftime("%d/%B/%Y", strtotime($viable->f_inicio));
                    $fecha_ing = strftime("%d/%B/%Y", strtotime($viable->f_fin));

                    $totalDias = $fechaInicio->diff($fechaFin)->days;
                    $diasTranscurridos = $fechaInicio->diff($fechaHoy)->days;
                    $progreso = min(max(($diasTranscurridos / $totalDias) * 100, 0), 100); // Asegurarse de que el progreso esté entre 0 y 100
            
                    $progressBarClass = $progreso === 100 ? 'bg-danger' : '';
                    $msjProgress = $progreso === 100 ? 'El colaborador ya finalizó su periodo' : ' El colaborador aun está en el periodo';

                    ?>

                    <tr style="font-size: 13px; text-align: center;">
                        <td><?= $viable->nombre ?></td>
                        <td><?= $viable->fecha_hora ?></td>
                        <td><?= $fecha_nac . " al " . $fecha_ing ?></td>
                        <td><?= $viable->t_dias ?> días</td>
                        <td><!-- progreso -->
                            <div class="progress">
                                <div class="progress-bar <?= $progressBarClass; ?>" role="progressbar"
                                    style="width: <?= $progreso ?>%;" aria-valuenow="<?= $progreso ?>" aria-valuemin="0"
                                    aria-valuemax="100" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="<?= $msjProgress; ?>">
                                    <?= round($progreso) ?>%
                                </div>
                            </div>
                        </td>
                        <td><?= $viable->t_prueba ?></td>
                        <td><?php
                            $descripcion = strlen($viable->comentarios) > 15 ? substr($viable->comentarios, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($viable->comentarios) . '\')">...</a>' : $viable->comentarios;
                            echo $descripcion;
                            ?></td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                <a href='#!'
                                    onclick="editarProg(event, '<?= $viable->id ?>', '<?= $viable->nombre ?>', '<?= $viable->fecha_hora ?>','<?= $viable->f_inicio ?>','<?= $viable->f_fin ?>', '<?= $viable->t_dias ?>','<?= $viable->t_prueba ?>','<?= $viable->comentarios ?>','<?= $progreso ?>', '<?= $progressBarClass ?>', '<?= $msjProgress ?>','<?= $viable->enlace_prueba ?>','<?= $viable->viable_prueba ?>')"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Editar detalles candidato" style="border-radius: 1rem;">
                                    <i class='fas fa-edit'></i> Editar prueba
                                </a>
                                <a href='#!' onclick="delAplicantPrueba(event, '${lista.id}', '${id_form}')"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Eliminar candidato" style="border-radius: 1rem; color:red;">
                                    <i class='fas fa-trash-alt'></i> Eliminar prueba candidato
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div style="text-align: left;">
                <br>
                <a href="<?php echo base_url("home/ats") ?>" class="btn ver-periodo-btn1">Atrás</a>
            </div>

        <?php endif; ?>

    </div>

</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>



<script>
    function estadoEncuestas(estado) {
        var valor = estado.value;
        var proceso = document.getElementById("proceso");
        var completados = document.getElementById("completados");
        var no_viables = document.getElementById("no_viables");

        //console.log(valor);

        if (valor === 'proceso') {

            proceso.style.display = 'block';
            completados.style.display = 'none';
            no_viables.style.display = 'none';

        } else if (valor === 'completados') {

            completados.style.display = 'block';
            proceso.style.display = 'none';
            no_viables.style.display = 'none';

        } else if (valor === 'no_viables') {

            no_viables.style.display = 'block';
            proceso.style.display = 'none';
            completados.style.display = 'none';

        }

    }

</script>
<script>
    function filterCandidatos() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("users-table");
        tr = table.getElementsByTagName("tr");

        var found = false;

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    found = true;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Mostrar el mensaje si no se encuentra ningún periodo
        var mensajeSinPeriodo = document.getElementById("mensaje-sin-periodo");
        if (!found) {
            mensajeSinPeriodo.style.display = "block";
            //table.style.display = "none";

        } else {
            mensajeSinPeriodo.style.display = "none";
            // table.style.display = "block";
        }
    }
</script>

<script>

    function formatDateToSpanish(dateString) {
        var date = new Date(dateString + 'T00:00:00');
        return date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }

    function calculateProgress(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const now = new Date();

        if (now < start) {
            return 0;
        } else if (now > end) {
            return 100;
        } else {
            const totalDays = (end - start) / (1000 * 60 * 60 * 24);
            const elapsedDays = (now - start) / (1000 * 60 * 60 * 24);
            return Math.round((elapsedDays / totalDays) * 100);
        }
    }

    const tableBody = document.getElementById('table-body');
    const paginationContainer = document.getElementById('pagination-container');
    const itemsPerPage = 20; // Número de registros por página
    const tabla = <?= json_encode($candidatos); ?>; // Los datos de PHP

    function showPage(page) {
        tableBody.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const baseUrl = "<?= base_url(); ?>";
        const id_form = "<?= $id_form; ?>";

        for (let i = startIndex; i < endIndex && i < tabla.length; i++) {
            const lista = tabla[i];
            const row = document.createElement('tr');

            // Crear una versión truncada de los comentarios si es necesario
            let comentarios = lista.comentarios;
            if (comentarios.length > 10) {
                comentarios = `${comentarios.substring(0, 15)}<a href="#!" style="color:blue;" onclick="detalle1(event, '${encodeURIComponent(lista.comentarios)}')">...</a>`;
            }

            var f_in = formatDateToSpanish(lista.f_inicio);
            var f_fn = formatDateToSpanish(lista.f_fin);
            var progress = calculateProgress(lista.f_inicio, lista.f_fin);

            let progressBarClass = progress === 100 ? 'bg-danger' : '';
            let msjProgress = progress === 100 ? 'El colaborador ya finalizó su periodo' : ' El colaborador aun está en el periodo';

            row.innerHTML = `
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${lista.nombre}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Fecha de postulación">${lista.fecha_hora}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${f_in} al ${f_fn}</span>
                    </td>

                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${lista.t_dias} días</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                       
                            <div class="progress">
                                <div class="progress-bar ${progressBarClass}" role="progressbar" style="width: ${progress}%;" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="${msjProgress}">${progress}%</div>
                            </div>
                        
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">${lista.t_prueba}</span>
                    </td>
                    <td style="font-size: 13px;">
                    ${comentarios}
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-caret-down'></i>
                        </button>
                        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                            <a href='#!' onclick="editarProg(event, '${lista.id}', '${lista.nombre}', '${lista.fecha_hora}','${lista.f_inicio}','${lista.f_fin}', '${lista.t_dias}','${lista.t_prueba}','${lista.comentarios}','${progress}', '${progressBarClass}', '${msjProgress}','${lista.enlace_prueba}','${lista.viable_prueba}')" class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Editar detalles candidato" style="border-radius: 1rem;">
                                <i class='fas fa-edit'></i> Editar prueba
                            </a>
                            <a href='#!' onclick="delAplicantPrueba(event, '${lista.id}', '${id_form}')" class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Eliminar candidato" style="border-radius: 1rem; color:red;">
                                <i class='fas fa-trash-alt'></i> Eliminar prueba candidato
                            </a>
                        </div>
                    </td>
                   
                `;
            tableBody.appendChild(row);
        }
    }

    function generatePagination() {
        paginationContainer.innerHTML = '';
        const totalPages = Math.ceil(tabla.length / itemsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const pageLink = document.createElement('a');
            pageLink.href = '#';
            pageLink.textContent = i;

            pageLink.addEventListener('click', (event) => {
                event.preventDefault();
                showPage(i);
            });
            paginationContainer.appendChild(pageLink);
        }
    }

    showPage(1);
    generatePagination();

    function detalle1(event, comentarios) {
        event.preventDefault();
        alert(decodeURIComponent(comentarios));
    }

</script>

<script>

    function delAplicantPrueba(event, id, id_form) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará definitivamente la prueba del candidato del sistema. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2980b9',
            cancelButtonColor: '#df8686',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/delAplicantPrueba/'); ?>${id}/${id_form}`;
                window.location.href = url;
            }
        });
    }

</script>

<script>
    function editarProg(event, id, nombre, postulacion, inicio, fin, dias, tipo, comentarios, progress, progressBarClass, msjProgress, enlace, prueba) {

        event.preventDefault();

        Swal.fire({
            html:
                `<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/ats/form/$id_form"); ?>">Talent Management |
            Periodo de prueba </a> | ${nombre}
        <i class="fas fa-users"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='#!' class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                title="Registra un nuevo candidato" style="border-radius: 1rem;">
                <i class='fas fa-users'></i> Agregar candidato
            </a>
            <a href='<?php echo base_url("/home/forms") ?>' class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Formularios candidatos" style="border-radius: 1rem;">
                <i class='fas fa-tasks'></i> Formularios vacantes
            </a>
        </div>
    </h4>
    <hr>
    <small id="passwordHelpBlock" class="form-text text-center">
        En este espacio, el área de capital humano, determinara cual es tiempo de periodo de prueba de los candidatos
    </small>
    <div class="card-body" id="proceso">

        <form id="formReq" action="<?php echo base_url('/home/ats/saveEditPrueba') ?>" method="POST"
            enctype="multipart/form-data">

            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Fecha inicio:</label>
                <div class="col-sm-4">
                    <input type="date" name="f_inicio" id="f_inicio" class="form-control" value="${inicio}" required>
                </div>
                <label for="correo" class="col-sm-2 col-form-label">Fecha fin:</label>
                <div class="col-sm-4">
                    <input type="hidden" name="id_form" class="form-control" value="<?= $id_form ?>">
                    <input type="hidden" name="id_prueba" class="form-control" value="${id}">
                    <input type="date" name="f_fin" id="f_fin" class="form-control" value="${fin}">
                </div>
            </div>
            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Tiempo total de días:</label>
                <div class="col-sm-4">
                    <input type="text" name="t_dias" id="t_dias" class="form-control" value="${dias}" required>
                </div>
                <label for="correo" class="col-sm-2 col-form-label">Tipo de prueba:</label>
                <div class="col-sm-4">

                    <select name="tipoPrueba" id="tipoPrueba" class="form-control">
                        <option value="${tipo}">${tipo}</option>
                        <option value="Prueba Técnica">Prueba Técnica</option>
                        <option value="Prueba Oral">Prueba Oral</option>
                        <option value="other">Otra</option>
                    </select>

                </div>
            </div>
            <div class="form-group row">
    <div class="col-sm-12">
        <ul id="addedOptionsList" class="list-group"></ul>
    </div>
</div>

            <div class="form-group row" id="otherTypeGroup" style="display:none;">
                <label for="otherType" class="col-sm-2 col-form-label">Especifique:</label>
                <div class="col-sm-4">
                    <input type="text" id="otherType" class="form-control"
                        placeholder="Especifique el tipo de prueba">
                </div>
                <div class="col-sm-2">
                    <button type="button" id="addOtherType" class="btn ver-periodo-btn">Añadir</button>
                </div>
            </div>


            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Actividades:</label>
                <div class="col-sm-10">
                    <!-- <textarea name="actividades" id="editor"></textarea> -->
                    <!-- <input type="text" name="actividades" class="form-control" > -->
                    <textarea name="actividades" id="actividades" class="form-control" placeholder="Escriba algún comentario">${comentarios}</textarea>
                </div>
            </div>
            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Progreso:</label>
                <div class="col-sm-10">
                <div class="progress">
                                <div class="progress-bar ${progressBarClass}" role="progressbar" style="width: ${progress}%;" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="${msjProgress}">${progress}%</div>
                            </div>
                </div>
            </div>
            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Enlace Drive:</label>
                <div class="col-sm-10">
                <textarea name="enlace" id="enlace" class="form-control" placeholder="Escriba algún enlace">${enlace}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Viable:</label>
                <div class="col-sm-4">
                     <input type="radio" id="contactChoice1" name="viable" value="1" class="form-control" style="border:none;" required ${prueba == '1' ? 'checked' : ''}/>
                </div>
                <label for="correo" class="col-sm-2 col-form-label">No viable:</label>
                <div class="col-sm-4">
                     <input type="radio" id="contactChoice1" name="viable" value="0" class="form-control"  style="border:none;" required required ${prueba == '0' ? 'checked' : ''}/>
                </div>
            </div>
        </form>
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

            }

        });


        // Inicializar eventos después de que el modal se ha mostrado
        document.getElementById('tipoPrueba').addEventListener('change', function () {
            var otherTypeGroup = document.getElementById('otherTypeGroup');
            if (this.value === 'other') {
                otherTypeGroup.style.display = 'flex';
            } else {
                otherTypeGroup.style.display = 'none';
            }
        });

        document.getElementById('addOtherType').addEventListener('click', function () {
            var otherTypeInput = document.getElementById('otherType');
            var tipoPruebaSelect = document.getElementById('tipoPrueba');
            var newOptionValue = otherTypeInput.value.trim();

            if (newOptionValue !== "") {
                // Crear una nueva opción
                var newOption = document.createElement('option');
                newOption.value = newOptionValue;
                newOption.text = newOptionValue;

                // Añadir la nueva opción al select
                tipoPruebaSelect.add(newOption);

                // Seleccionar la nueva opción
                tipoPruebaSelect.value = newOptionValue;

                // Ocultar el campo de entrada y limpiar su valor
                document.getElementById('otherTypeGroup').style.display = 'none';
                otherTypeInput.value = "";
            }
        });





    }
</script>

<script>
    document.getElementById('tipoPrueba').addEventListener('change', function () {
        var otherTypeGroup = document.getElementById('otherTypeGroup');
        if (this.value === 'other') {
            otherTypeGroup.style.display = 'flex';
        } else {
            otherTypeGroup.style.display = 'none';
        }
    });

    document.getElementById('addOtherType').addEventListener('click', function () {
        var otherTypeInput = document.getElementById('otherType');
        var tipoPruebaSelect = document.getElementById('tipoPrueba');
        var newOptionValue = otherTypeInput.value.trim();

        if (newOptionValue !== "") {
            // Crear una nueva opción
            var newOption = document.createElement('option');
            newOption.value = newOptionValue;
            newOption.text = newOptionValue;

            // Añadir la nueva opción al select
            tipoPruebaSelect.add(newOption);

            // Seleccionar la nueva opción
            tipoPruebaSelect.value = newOptionValue;

            // Ocultar el campo de entrada y limpiar su valor
            document.getElementById('otherTypeGroup').style.display = 'none';
            otherTypeInput.value = "";
        }
    });
</script>