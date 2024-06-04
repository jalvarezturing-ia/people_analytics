<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
    .container {
        display: flex;
        justify-content: space-between;
    }


    .card-body {
        border-radius: 1rem;
        padding: 15px;
    }

    .submenu {
        margin-bottom: 10px;
    }

    .submenu-item {
        border: none;
        background-color: transparent;
        padding: 5px 10px;
        cursor: pointer;
        outline: none;
        /* Eliminar el efecto de outline */
        color: #4070f4;
        font-weight: bold;
    }

    .submenu-item:hover {
        background-color: rgba(0, 0, 255, 0.1);
    }

    .submenu-item.selected {
        border-bottom: 2px solid blue;
        /* Color del borde del botón seleccionado */
    }

    .candidate-info {
        background-color: #F8FAFC;
        border-radius: 1rem;

        padding: 10px;
    }

    .hidden {
        display: none;
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
            áreas | Proceso </a> | <?= $vacante; ?>
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
            <option value="proceso">Candidatos proceso (<?= $t_sin; ?>)</option>
            <option value="finalizado">Candidatos finalistas (<?= $proces; ?>)</option>
        </select>
    </div>


    <!-- todos aplicantes  -->
    <div class="card-body" id="proceso">

        <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar al candidato">
        </div>

        <table id="users-table">
            <tr style="font-size: 14px; text-align: center;">
                <th>Nombre</th>
                <!-- <th>Correo</th> -->
                <th>Vacante</th>
                <th>Proceso</th>
                <th>Calificación</th>
                <th>Postulación</th>
                <th>Comentarios</th>
                <th>Opciones</th>
            </tr>
            <?php
            $hayElementos = false;
            foreach ($viables as $viable): ?>
                <?php if ($viable->viable_entre == 0 || $viable->viable_entre == 2):
                    $hayElementos = true;
                    ?>
                    <!-- Filtrar candidatos no viables -->
                    <tr style="font-size: 14px; text-align: center;">
                        <td><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;"><?= $viable->nombre; ?></span>
                        </td>
                        <!-- <td><?= $viable->correo; ?></td> -->
                        <td><?= $viable->vacante; ?></td>
                        <td>
                            <?php if ($viable->viable_entre == 0): ?>
                                <span
                                    style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Proceso</span>
                            <?php elseif ($viable->viable_entre == 2): ?>

                                <span
                                    style="padding: 7px; border-radius: 100px; background-color: rgb(243, 211, 211); border: 1px solid #ccc; border:none;">Descalificado</span>

                            <?php endif ?>

                        </td>
                        <td> <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(243, 211, 211); border: 1px solid #ccc; border:none;"><?= $viable->calificacion; ?></span>
                        </td>
                        <td> <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(243, 211, 211); border: 1px solid #ccc; border:none;"><?= $viable->fecha_hora; ?></span>
                        </td>
                        <td>

                            <?php
                            $descripcion = strlen($viable->comentarios) > 15 ? substr($viable->comentarios, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($viable->comentarios) . '\')">...</a>' : $viable->comentarios;
                            echo $descripcion;
                            ?>
                        </td>
                        <td> <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                id="hola" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">

                                <a href='<?php echo base_url("/home/applicants/formato/$id_form/$viable->id") ?>'
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Formularios candidatos" style="border-radius: 1rem;">
                                    <i class='fas fa-tasks'></i> Formato evaluación
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
    </div>

    <!-- no aplicantes -->
    <div class="card-body" id="completados" style="display:none;">

        <div class="search-box">
            <input type="text" id="search1" oninput="filterCandidatos1()"
                placeholder="Escriba para buscar al candidato">
        </div>

        <table id="users-table1">
            <tr style="font-size: 14px; text-align: center;">
                <th>Nombre</th>
                <!-- <th>Correo</th> -->
                <th>Vacante</th>
                <th>Proceso</th>
                <th>Calificación</th>
                <td>Postulación</td>
                <th>Comentarios</th>
                <th>Opciones</th>
            </tr>
            <?php 
            $hayElementos = false;
            foreach ($viables as $viable): ?>
                <?php if ($viable->viable_entre == 1): 
                     $hayElementos = true; ?>
                    <tr style="font-size: 14px; text-align: center;">

                        <td><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;"><?= $viable->nombre; ?></span>
                        </td>
                        <!-- <td><?= $viable->correo; ?></td> -->
                        <td><?= $viable->vacante; ?></td>
                        <td>
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Proceso</span>

                        </td>
                        <td> <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;"><?= $viable->calificacion; ?>
                            </span></td>
                            <td>
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;"><?= $viable->fecha_hora; ?>
                            </span>
                            </td>
                        <td> <?php
                        $descripcion = strlen($viable->comentarios) > 15 ? substr($viable->comentarios, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($viable->comentarios) . '\')">...</a>' : $viable->comentarios;
                        echo $descripcion;
                        ?></td>
                        <td> <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                id="hola" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">

                                <a href='<?php echo base_url("/home/applicants/formato/$id_form/$viable->id") ?>'
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Formularios candidatos" style="border-radius: 1rem;">
                                    <i class='fas fa-tasks'></i> Formato evaluación
                                </a>
                                <a href='<?php echo base_url("/home/applicants/prueba/$id_form/$viable->id") ?>'
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Periodos de prueba y feedback" style="border-radius: 1rem;">
                                    <i class='fas fa-comment'></i> Periodos de prueba y feedback
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
    </div>
</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>



<script>
    function selectStatus(type, status) {
        // Ocultar la información de todos los candidatos
        document.querySelectorAll('.candidate-info').forEach(info => {
            info.classList.add('hidden');
        });

        // Mostrar la información del candidato correspondiente
        const candidateInfo = document.getElementById(`${type}-${status}`);
        candidateInfo.classList.remove('hidden');

        // Cambiar el color del borde del botón presionado
        document.querySelectorAll('.submenu-item').forEach(button => {
            button.classList.remove('selected'); // Eliminar la clase seleccionada de todos los botones
        });
        event.target.classList.add('selected'); // Agregar la clase seleccionada al botón presionado
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
    function filterCandidatos1() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search1");
        filter = input.value.toUpperCase();
        table = document.getElementById("users-table1");
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