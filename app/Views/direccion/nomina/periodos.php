<?php 
$ano_actual = date('Y');
$numero = 1; ?>
<?= $this->include('direccion/header') ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <i class="fas fa-calendar-alt" style="color: #3498db;"></i> Periodos por colaboradores </h4>
    <div class="line"> </div>

    <?php if (empty($periodos)) { ?>

        <div class="alert alert-danger" style="text-align: center;">AÚN NO HAY PERIODOS EN LISTA </div>
    <?php } else { ?>

        <table id="periodos-table">
            <tbody>
            <tr style="font-weight:bold;">
            <td>#</td>
                    <td>Periodo</td>
                    <td>Mes</td>
                    <td>Inicio</td>
                    <td>Fin</td>
                    <td>Colaboradores activos</td>
                    <td>Aprobado </td>
                    <td>Firmado por:</td>
                    <td>Menú</td>

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
        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> Sin periodo disponible </div>
    <?php } ?>
</div>




<?= $this->include('direccion/footer') ?>

<script>

    const tableContainer = document.getElementById('table-container');
    const tableBody = document.getElementById('table-body');
    const paginationContainer = document.getElementById('pagination-container');
    const itemsPerPage = 10; // Número de registros por página
    const tabla = <?= json_encode($periodos); ?>; // Los datos de PHP


    function showPage(page) {
        tableBody.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const baseUrl = "<?php echo base_url(); ?>";

      
        for (let i = startIndex; i < endIndex && i < tabla.length; i++) {
            const lista = tabla[i];
            const row = document.createElement('tr');
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
    const fechaInicio = new Date(lista.fecha_inicio_quincena.replace(/-/g, '/')).toLocaleDateString('es-ES', options);
    const fechaFin = new Date(lista.fecha_fin_quincena.replace(/-/g, '/')).toLocaleDateString('es-ES', options);
            row.innerHTML = `
      <td>${i + 1}</td>
      <td>${lista.periodo}</td>
      <td>${lista.mes}</td>
      <td>${fechaInicio}</td>
        <td>${fechaFin}</td>
      <td>${lista.colaboradores} colaboradores</td>
      <td>
  ${ (lista.nombre_f1 && lista.nombre_f2 && lista.nombre_f3 && lista.nombre_f4) ? '<span class="status-circle"></span> SI' : '<span class="status-circle1"></span> NO' }
</td>


      <td>
 ${lista.nombre_f1 ? '<img src="data:image/png;base64,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" alt="MDN"  width="14" height="14"/> <strong style="color:#3498db;">Jessica</strong>' : '<img src="https://w7.pngwing.com/pngs/380/139/png-transparent-x-red-mark-incorrect-thumbnail.png" alt="MDN"  width="14" height="14"/> <strong style="color:red;">Jessica</strong>'}<br>
  ${lista.nombre_f2 ? '<img src="data:image/png;base64,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" alt="MDN"  width="14" height="14"/> <strong style="color:#3498db;">Admin</strong>' : '<img src="https://w7.pngwing.com/pngs/380/139/png-transparent-x-red-mark-incorrect-thumbnail.png" alt="MDN"  width="14" height="14"/> <strong style="color:red;">Admin</strong>'}<br>
  ${lista.nombre_f3 ? '<img src="data:image/png;base64,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" alt="MDN"  width="14" height="14"/> <strong style="color:#3498db;">RH</strong>' : '<img src="https://w7.pngwing.com/pngs/380/139/png-transparent-x-red-mark-incorrect-thumbnail.png" alt="MDN"  width="14" height="14"/> <strong style="color:red;">RH</strong>'}<br>
  ${lista.nombre_f4 ? '<img src="data:image/png;base64,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" alt="MDN"  width="14" height="14"/> <strong style="color:#3498db;">Alejandro</strong>' : '<img src="https://w7.pngwing.com/pngs/380/139/png-transparent-x-red-mark-incorrect-thumbnail.png" alt="MDN"  width="14" height="14"/> <strong style="color:red;">Alejandro</strong>'}
</td>

      <td>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" 
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones 
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones">
        <a href="${baseUrl}home/signature/${lista.periodo}/${lista.mes}/${lista.pagada}/${lista.fecha_inicio_quincena}/${lista.fecha_fin_quincena}" >&nbsp; <i class="fa fa-arrow-circle-right"></i> Firmar periodo</a>
        <br>
       
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

</script>