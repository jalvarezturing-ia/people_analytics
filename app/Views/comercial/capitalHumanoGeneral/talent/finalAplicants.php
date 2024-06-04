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
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/ats"); ?>">Talent Management </a> | <?= $vacante ?> |
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
        <?php if (empty($detalles)): ?>
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
                        <th style="text-align: center;">Fecha de postulación</th>
                        <th style="text-align: center;">Fin</th>
                        <th style="text-align: center;">Tipo</th>
                        <th style="text-align: center;">Prueba </th>
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
</div>




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
    const tabla = <?= json_encode($detalles); ?>; // Los datos de PHP

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
            let msjProgress = progress === 100 ? 'El colaborador ya finalizó su periodo' : 'El colaborador aun está en el periodo';
            let sss = lista.tipo;
            let ssss = lista.id_candidato;

            let values = sss === null ? 'Sin asignación' : sss;
            let tipos = sss === null ? 'rgb(243, 211, 211);' : 'rgb(211, 243, 232);';
            let validate = sss === null ? '' : `<a href='<?= base_url('/home/ats/candidat') ?>/${id_form}/${ssss}' class='dropdown-item' data-toggle='tooltip' class='nav-link' data-placement='bottom' title='Editar detalles candidato' style='border-radius: 1rem'><i class='fas fa-edit'></i> Detalles documentación</a>`;

            row.innerHTML = `
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${lista.nombre}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Fecha de postulación">${lista.fecha_hora}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${f_fn}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: ${tipos} border: 1px solid #ccc; border:none;">${values}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">${lista.t_prueba}</span>
                    </td>
                   
                    <td style="font-size: 13px; text-align: center;">
                        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-caret-down'></i>
                        </button>
                        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                            ${validate}
                            <a href='#!' onclick="tipoCandidato(event,'${lista.nombre}', '${lista.id_candidato}', '${id_form}')" class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Detalles candidato" style="border-radius: 1rem;">
                                <i class='fas fa-eye'></i> Detalle candidato
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
    function tipoCandidato(event, nombre, id, id_form) {

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

        <form id="formReq" action="<?php echo base_url('/home/ats/savetypecand') ?>" method="POST"
            enctype="multipart/form-data">

            <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="${nombre}" required>
                    <input type="hidden" name="id_form" class="form-control" value="<?= $id_form ?>">
                    <input type="hidden" name="id_user" class="form-control" value="${id}">
                </div>
                <label for="correo" class="col-sm-2 col-form-label">Tipo de candidato:</label>
                <div class="col-sm-4">
                    <select name="tipo" id="tipoPrueba" class="form-control">
                        <option value="other">Seleccione</option>
                        <option value="Trabajo">Para Trabajo (Becario)</option>
                        <option value="Practicante">Practicante</option>
                    </select>

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

                // const form = document.getElementById('formReq');
                // form.submit();

                var tipoPrueba = document.getElementById('tipoPrueba').value;

                if (tipoPrueba === 'other') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, selecciona un tipo de candidato',
                        confirmButtonColor: '#3498db',
                        confirmButtonText: "Entendido",
                    }).then((result) => {
                        if (result.isConfirmed) {

                            console.log("nepe");
                            tipoCandidato(event, nombre, id, id_form);
                        }

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

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>