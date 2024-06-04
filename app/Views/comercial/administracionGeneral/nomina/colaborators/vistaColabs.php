<?php
$numero = 1;
$session = session();
if ($session->get('rol') == 'admin1') {
    echo $this->include('comercial/administracionGeneral/header');
} else {
    echo $this->include('comercial/capitalHumanoGeneral/header');
}
?>

<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>



<div class="info-card vertical" id="activosSection">
    <h6 class="title-wish"><a href="<?php echo base_url('/home/nomina/people'); ?>">Colaboradores</a>  Activos <i
            class="fas fa-user"></i>
        <a href="#" class="ver-periodo-btn1" style="float: right;" onclick="mostrarSeccion('inactivos')"
            data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Seccion de colaboradores inactivos"
            id="inactivosBtn"><i class="fas fa-users"></i>
        </a>
        <br><br>
    </h6>
    <div class="line"> </div>
    <div class="search-box">
        <input type="text" id="search2" oninput="filterTable2()" placeholder="Escriba para buscar colaborador"> |
        <button onclick="openFilterModal()" class="ver-periodo-btn" style="border: none;" data-toggle="tooltip"
            class="nav-link" data-placement="bottom" title="Filtro avanzado en lista">
            <i class="fas fa-filter"></i> Filtrar
        </button>
    </div>
    <table id="periodos-table2" class="dataTable">
        <tbody>
            <tr style="font-weight:bold;">
                <th>#</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Área</th>
                <th>Cargo </th>
                <th>Sueldo base </th>
            </tr>
            <tr>
        <tbody id="table-body">
            </tr>
        </tbody>
    </table>
    <div id="pagination-container">
        <!-- Aquí se generará la paginación -->
    </div>
    <br>
    <div class="alert alert-danger" id="mensaje-sin-periodo2" style="display: none;text-align: center;"> <i
            class="fa fa-exclamation-circle"></i> Sin usuario disponible </div>
    <!---->

</div>
<div class="info-card vertical" id="inactivosSection" style="display: none;">
    <h6 class="title-wish"><a href="<?php echo base_url('/home/nomina/people'); ?>">Colaboradores</a> > Inactivos <i
            class="fas fa-user"></i>
        <a href="#" class="ver-periodo-btn2" style="float: right;" onclick="mostrarSeccion('activos')" id="activosBtn"
            data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Sección de colaboradores activos"><i
                class="fas fa-users"></i>
        </a>
        <br><br>
    </h6>
    <div class="line"> </div>
    <?php if (empty($baja)) { ?>

        <div class="alert alert-danger" style="text-align: center;">AÚN NO EXISTEN COLABORADORES DADOS DE BAJA </div>
    <?php } else { ?>
        <table id="periodos-table2" class="dataTable">
            <tbody>
                <tr style="font-weight:bold;">
                    <td>#</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Correo</td>
                    <td>Departamento</td>
                    <td>Cargo </td>
                    <td>Sueldo base </td>
                    <td> </td>
                </tr>
                <?php foreach ($baja as $baja1):
                    ?>
                    <tr>
                        <td>
                            <?= $numero; ?>
                        </td>

                        <td style="color: rgb(24, 147, 255);"><a href="#" onclick="alta(event, <?php echo $baja1->id; ?>)">
                                <?= $baja1->nombre . " " . $baja1->apellido_paterno . " " . $baja1->apellido_materno; ?></i>
                            </a></td>
                        <td><a href="https://api.whatsapp.com/send?phone=+52<?= $baja1->telefono; ?>&text=Hola, tengo una duda acerca de%20"
                                target='_blank'>
                                <?= $baja1->telefono; ?>
                            </a></td>
                        <td><a href="mailto:<?= $baja1->correo; ?>">
                                <?= $baja1->correo; ?>
                            </a></td>
                        <td>
                            <?= $baja1->descripcion; ?>
                        </td>
                        <td>
                            <?= $baja1->puesto; ?>
                        </td>
                        <td>$
                            <?= $baja1->pago_mensual_base; ?>.00
                        </td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
                                title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones">
                                <a href='#' onclick="bajaSistema(event, <?php echo $baja1->id; ?>)" class='dropdown-item'> <i
                                        class='fas fa-trash'></i> Eliminar del sistema</a>
                            </div>
                        </td>

                    </tr>
                    <?php $numero++; endforeach; ?>
            </tbody>
        </table>
    <?php } ?>
    <div id="pagination-container">
        <!-- Aquí se generará la paginación -->
    </div>
    <br>
    <div class="alert alert-danger" id="mensaje-sin-periodo2" style="display: none;text-align: center;"> <i
            class="fa fa-exclamation-circle"></i> Sin usuario disponible </div>
    <!---->

    <!---->

</div>


<?php
$session = session();
if ($session->get('rol') == 'admin1') {
    echo $this->include('comercial/administracionGeneral/footer');
} else {
    echo $this->include('comercial/capitalHumanoGeneral/footer');
}
?>





<script>

    /* SCRIPT PAGINACION*/

    const tableContainer = document.getElementById('table-container');
    const tableBody = document.getElementById('table-body');
    const paginationContainer = document.getElementById('pagination-container');
    const itemsPerPage = 10; // Número de registros por página
    const tabla = <?= json_encode($colabs); ?>; // Los datos de PHP

    function showPage(page) {
        tableBody.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const baseUrl = "<?php echo base_url(); ?>";

        for (let i = startIndex; i < endIndex && i < tabla.length; i++) {
            const lista = tabla[i];
            const row = document.createElement('tr');
            row.innerHTML = `
      <td>${i + 1}</td>
      <td id="filterNombre" style="color: rgb(24, 147, 255);"><a title="Información del colaborador" href="${baseUrl}home/nomina/collaborators/${lista.id}" >${lista.nombre} ${lista.apellido_paterno} ${lista.apellido_materno} </a></td>
      <td><a href="https://api.whatsapp.com/send?phone=+52${lista.telefono}&text=Hola, tengo una duda acerca de%20" target='_blank'>${lista.telefono}</a></td>
     
      <td> <a href="mailto:${lista.correo}">${lista.correo}</a></td>
      <td>${lista.descripcion}</td>
      <td>${lista.puesto}</td>
      ${lista.pago_mensual_base == null
                    ? '<td> --- </td>'
                    : `<td>$${lista.pago_mensual_base}.00</td>`
                }
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

</script>

<script>
    // Agrega funciones para abrir el modal y aplicar los filtros
    function openFilterModal() {
        $('#filterModal').modal('show');
    }

    function applyFilters() {
        // Obtiene los valores de los campos de filtro
        const filterNombre = document.getElementById('filterNombre').value;
        const filterTelefono = document.getElementById('filterTelefono').value;
        const filterArea = document.getElementById('filterArea').value;
        const filterCargo = document.getElementById('filterCargo').value;
        const filterSueldo = document.getElementById('filterSueldo').value;

        // Filtra los datos
        const filteredData = tabla.filter(item => {
            // Realiza las comparaciones necesarias
            return (
                (filterNombre === '' || item.nombre.toLowerCase().includes(filterNombre.toLowerCase())) &&
                (filterTelefono === '' || item.telefono.toLowerCase().includes(filterTelefono.toLowerCase())) &&
                (filterArea === '' || item.descripcion.toLowerCase().includes(filterArea.toLowerCase())) &&
                (filterCargo === '' || item.puesto.toLowerCase().includes(filterCargo.toLowerCase())) &&
                (filterSueldo === '' || item.pago_mensual_base.toLowerCase().includes(filterSueldo.toLowerCase()))

            );
        });

        // Muestra los datos filtrados
        showFilteredData(filteredData);
        // Cierra el modal
        $('#filterModal').modal('hide');
    }

    function showFilteredData(filteredData) {
        tableBody.innerHTML = '';
        const baseUrl = "<?php echo base_url(); ?>";
        // Mostrar los datos filtrados
        filteredData.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${index + 1}</td>
            <td style="color: rgb(24, 147, 255);"><a href="${baseUrl}home/nomina/collaborators/${item.id}">${item.nombre} ${item.apellido_paterno} ${item.apellido_materno}</a></td>
            <td><a href="https://api.whatsapp.com/send?phone=+52${item.telefono}&text=Hola, tengo una duda acerca de%20" target='_blank'>${item.telefono}</a></td>
            <td> <a href="mailto:${item.correo}">${item.correo}</a></td>
            <td>${item.descripcion}</td>
            <td>${item.puesto}</td>
            ${item.pago_mensual_base == null
                    ? '<td> --- </td>'
                    : `<td>$${item.pago_mensual_base}.00</td>`
                }
        `;
            tableBody.appendChild(row);
        });
    }

</script>

<script>
    function mostrarSeccion(seccion) {
        // Oculta ambas secciones
        document.getElementById('activosSection').style.display = 'none';
        document.getElementById('inactivosSection').style.display = 'none';

        document.getElementById('activosBtn').classList.remove('activo');
        document.getElementById('inactivosBtn').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'activos') {
            document.getElementById('activosSection').style.display = 'block';
            document.getElementById('activosBtn').classList.add('activo');
        } else if (seccion === 'inactivos') {
            document.getElementById('inactivosSection').style.display = 'block';
            document.getElementById('inactivosBtn').classList.add('activo');
        }
    }
</script>


<?php
$session = session();
$error_message = $session->getFlashdata('error_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "error",';
    echo '    title: "Error",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Ok",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
$error_message = $session->getFlashdata('success_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "success",';
    echo '    title: "Éxito",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Ok",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
?>