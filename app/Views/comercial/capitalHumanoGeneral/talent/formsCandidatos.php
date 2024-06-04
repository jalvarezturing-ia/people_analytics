<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
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
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/applicants"); ?>">Talent Management | Candidatos por
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
            <option value="proceso">Candidatos viables</option>
            <option value="finalizado">Candidatos no viables</option>
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

                <a href="<?php echo base_url("home/applicants") ?>" class="btn ver-periodo-btn1">Atrás</a>

            </div>
        <?php else: ?>

            <table id="users-table">
                <thead>
                    <tr>
                        <!-- <th> <input type="checkbox"> </th> -->
                        <th style="text-align: center;" onclick="sortTable('name', 0)">Nombre</th>
                        <th style="text-align: center;">Correo</th>
                        <th style="text-align: center;">Origen</th>
                        <th style="text-align: center;">Estado <i class="fas fa-exclamation-circle"></i> </th>
                        <th style="text-align: center;">Curriculum Vitae </th>
                        <th style="text-align: center;" onclick="sortTable('postulation', 5)">Postulación</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                </thead>
                <tr style="font-size: 13px; text-align: center;">
                    <tbody id="table-body"></tbody>
                </tr>

            </table>
            <div style="text-align: left;">
                <br>
                <a href="<?php echo base_url("home/applicants") ?>" class="btn ver-periodo-btn1">Atrás</a>
            </div>

            <div id="pagination-container">
                <!-- Aquí se generará la paginación -->
            </div>

        <?php endif; ?>
    </div>
    <!-- no viables -->
    <div class="card-body" id="completados" style="display:none;">

        <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar al candidato">
        </div>

        <table id="users-table">
            <tr>
                <!-- <th> <input type="checkbox"> </th> -->
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Correo</th>
                <th style="text-align: center;">Origen</th>
                <th style="text-align: center;">Estado <i class="fas fa-exclamation-circle"></i> </th>
                <th style="text-align: center;">Curriculum Vitae </th>
                <th style="text-align: center;">Postulación </th>
                <th style="text-align: center;">Opciones</th>
            </tr>
            <?php
            $hayElementos = false;
            foreach ($candidatos as $candidato): ?>
                <?php if ($candidato->viable_no == 0 && $candidato->viable_no != null):
                    $hayElementos = true;
                    ?>
                    <!-- Filtrar candidatos no viables -->
                    <tr>
                        <td style="font-size: 13px; text-align: center;"><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;"><?= $candidato->nombre; ?></span>
                        </td>
                        <td style="font-size: 13px; text-align: center;"><?php echo $candidato->correo; ?></td>
                        <td style="font-size: 13px; text-align: center;"><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;"><?= $candidato->vacante; ?></span>
                        </td>
                        <td style="font-size: 13px; text-align: center;">
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(243, 211, 211); border: 1px solid #ccc; border:none;">No
                                Viable</span>
                        </td>
                        <td style="font-size: 13px; text-align: center;">
                            <a href="<?= base_url("assets/") . $candidato->cv; ?>" class="cv-link" target="_blank">
                                <?= $candidato->cv; ?>
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                        <td style="font-size: 13px; text-align: center;"><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;"><?= $candidato->fecha_hora; ?></span>
                        </td>
                        <td style="font-size: 13px; text-align: center;">
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                <a href='#!' onclick="delAplicant(event, '<?= $candidato->id; ?>', '<?= $id_formulario; ?>')"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Eliminar candidato" style="border-radius: 1rem; color:red;">
                                    <i class='fas fa-trash-alt'></i> Eliminar candidato
                                </a>
                                <a href="<?= base_url("home/applicants/details/$id_formulario/$candidato->id") ?>"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Ver detalles candidato" style="border-radius: 1rem;">
                                    <i class='fas fa-eye'></i>Ver detalles
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach;// Si no se encontraron elementos con viable_entre igual a 0 o 2, muestra un mensaje
            if (!$hayElementos):
                ?>
                <!-- Mostrar mensaje de que no hay elementos -->
                <tr>
                    <td colspan="7" style="text-align: center;" class="alert alert-info" style="text-align: center;">
                        No hay candidatos disponibles por aquí. &#128516;

                    </td>
                </tr>
            <?php endif; ?>
        </table>
        <div style="text-align: left;">
            <br>
            <a href="<?php echo base_url("home/applicants") ?>" class="btn ver-periodo-btn1">Atrás</a>

        </div>
    </div>
</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>



<script>
    function estadoEncuestas(estado) {
        var valor = estado.value;
        var proceso = document.getElementById("proceso");
        var completados = document.getElementById("completados");
        console.log(valor);

        if (valor === 'proceso') {

            proceso.style.display = 'block';
            completados.style.display = 'none';

        } else if (valor === 'finalizado') {

            completados.style.display = 'block';
            proceso.style.display = 'none';

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
    const tableBody = document.getElementById('table-body');
    const paginationContainer = document.getElementById('pagination-container');
    const itemsPerPage = 20; // Número de registros por página
    const tabla = <?= json_encode($candidatos); ?>; // Los datos de PHP

    function showPage(page) {
        tableBody.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const baseUrl = "<?= base_url(); ?>";
        const id_form = "<?= $id_formulario; ?>";

        for (let i = startIndex; i < endIndex && i < tabla.length; i++) {
            const lista = tabla[i];
            const row = document.createElement('tr');
            row.innerHTML = `
                    ${(lista.viable_no == 1 || lista.viable_no == null) ? `
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${lista.nombre}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <a href="mailto:${lista.correo}"><span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${lista.correo}</span></a>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">${lista.vacante}</span>
                    </td>
                    ${lista.viable_no == null ? '<td style="font-size: 13px; text-align: center;">Sin asignar</td>' : lista.viable_no == 1 ? '<td style="font-size: 13px; text-align: center;"><span style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Viable</span></td>' : '<td style="font-size: 13px; text-align: center;"><span style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">No Viable</span></td>'}
                    <td style="font-size: 13px; text-align: center;">
                        <a href="${baseUrl}assets/${lista.cv}" class="cv-link" target="_blank">${lista.cv}<i class="fas fa-download"></i></a>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <span style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">${lista.fecha_hora}</span>
                    </td>
                    <td style="font-size: 13px; text-align: center;">
                        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-caret-down'></i>
                        </button>
                        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                            <a href='#!' onclick="delAplicant(event, '${lista.id}', '${id_form}')" class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Eliminar candidato" style="border-radius: 1rem; color:red;">
                                <i class='fas fa-trash-alt'></i> Eliminar candidato
                            </a>
                            <a href='${baseUrl}home/applicants/details/${id_form}/${lista.id}' class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Ver detalles candidato" style="border-radius: 1rem;">
                                <i class='fas fa-eye'></i> Ver detalles
                            </a>
                        </div>
                    </td>
                    ` : ''
                }`;
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

    let sortDirection = {
        name: true,
        postulation: false
    };

    function sortTable(column, index) {
        const table = document.getElementById('users-table');
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);

        rows.sort((a, b) => {
            let aValue, bValue;
            if (column === 'name') {
                aValue = a.cells[index]?.innerText.toLowerCase() || '';
                bValue = b.cells[index]?.innerText.toLowerCase() || '';
                if (aValue < bValue) return sortDirection[column] ? -1 : 1;
                if (aValue > bValue) return sortDirection[column] ? 1 : -1;
                return 0;
            } else if (column === 'postulation') {
                aValue = new Date(a.cells[index]?.innerText || '');
                bValue = new Date(b.cells[index]?.innerText || '');
                return sortDirection[column] ? bValue - aValue : aValue - bValue;
            }
        });

        sortDirection[column] = !sortDirection[column];

        // Remove previous sorted class from all headers
        document.querySelectorAll('th').forEach(th => th.classList.remove('sorted-asc', 'sorted-desc'));

        // Add sorted class to the current header
        const currentHeader = document.querySelector(`th[onclick="sortTable('${column}', ${index})"]`);
        currentHeader.classList.add(sortDirection[column] ? 'sorted-asc' : 'sorted-desc');

        tbody.append(...rows);
    }
</script>


<script>

    function delAplicant(event, id, id_form) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará definitivamente al candidato del sistema. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2980b9',
            cancelButtonColor: '#df8686',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/delAplicant/'); ?>${id}/${id_form}`;
                window.location.href = url;
            }
        });
    }

</script>