<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
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
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/applicants"); ?>">Talent Management | Prosprección </a>| Candidatos por
        áreas
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
            <option value="proceso">Candidatos nuevos</option>
            <option value="finalizado">Candidatos en proceso</option>
        </select>
    </div>

    <div class="card-body" id="proceso">

        <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar por área">
            |
            <a href="<?php echo base_url("home/applicants/calendly"); ?>" class="btn ver-periodo-btn"
                style="border: none;" data-toggle="tooltip" class="nav-link" h data-placement="bottom"
                title="Asigna el Calendly de RH para las diferentes Áreas">
                <i class="fas fa-envelope"></i> Correos Áreas
            </a>
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
        <?php if (empty($candidatosForms)): ?>

            <div class="alert alert-danger" style="text-align: center;"> <i class="fa fa-exclamation-circle"></i> No hay
                candidatos disponibles </div>
        <?php else: ?>

            <table id="users-table">
                <tr style="text-align: center;">
                    <!-- <th> <input type="checkbox"> </th> -->
                    <!-- <th>Nombre</th>
                <th>País</th>
                <th>Origen</th>
                <th>Estado <i class="fas fa-exclamation-circle"></i> </th>
                <th>Curriculum Vitae </th>
                <th>Opciones</th> -->
                    <th>Área</th>
                    <th>Vacante</th>
                    <th>Estado <i class="fas fa-exclamation-circle"></i> </th>
                    <th>Total postulados </th>
                    <th>Calendly </th>
                    <th>Opciones</th>
                </tr>
                <?php foreach ($candidatosForms as $candidato): ?>
                    <tr style="font-size: 14px; text-align: center;">
                        <!-- <td><input type="checkbox"></td> -->
                        <td>
                            <!-- <img src="https://portalanterior.ine.mx/archivos2/portal/Elecciones/2016/PELocales/tipo/unica/CdMex/CandidatasyCandidatos/img/CandidatoAvtr.png"
                            alt="img" class='rounded-circle img-fluid'
                            style='width: 45px; height: 45px; object-fit: cover;'> -->
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">
                                <?= $candidato->area ?></span>
                        </td>
                        <td>
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;"><?= $candidato->vacante ?></span>
                        </td>

                        <td><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Activos</span>
                        </td>

                        <td>
                            <a href="<?php echo base_url("home/applicants/form/$candidato->id") ?>" class="cv-link"
                                data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Ver detalles candidatos">
                                <?= $candidato->cantidad_candidatos ?> candidatos <i class="fas fa-users"></i>

                            </a>
                        </td>
                        <td>
                            <?php if($candidato->calendly == "https://calendly.com/capitalhumanoturing/30min"): ?>
                                <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;"> Calendly de Cit</span>


                            <?php elseif($candidato->calendly == "https://calendly.com/recursoshumanos-turing-ia/30min"): ?>
                                <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Calendly de May</span>

                            <?php else: ?>

                                <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Otro Calendly</span>

                            <?php endif; ?>
                        </td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                <a href='#!' onclick="delAplicc(event, '<?= $candidato->id ?>','<?= $candidato->token ?>')"
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Eliminar todos los candidatos" style="border-radius: 1rem; color:red;">
                                    <i class='fas fa-trash-alt'></i> Eliminar candidatos
                                </a>
                                <a href='<?php echo base_url("home/forms/edit/$candidato->id/$candidato->token") ?>'
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Ver detalles del formulario" style="border-radius: 1rem;">
                                    <i class='fas fa-eye'></i>Ver formulario
                                </a>
                            </div>
                        </td>


                    </tr>

                <?php endforeach; ?>

            </table>
        <?php endif; ?>

    </div>

    <div class="card-body" id="completados" style="display:none;">
        <div class="search-box">
            <input type="text" id="search" oninput="filterCandidatos()" placeholder="Escriba para buscar al candidato">
            <!-- |
            <button onclick="modalAvanzado()" class="btn ver-periodo-btn" style="border: none;" data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Filtro avanzado en lista">
                <i class="fas fa-filter"></i> Filtrar
            </button> -->
        </div>
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> <i class="fas fa-users"></i>
                            <?= $totViables ?>

                            <?php if ($tot == 1):
                                echo "candidato en proceso postulado";
                            else:
                                echo "candidatos en proceso";
                            endif; ?></a></li>
                </ol>
            </div>
        </div>

        <?php if (empty($viables)): ?>

            <div class="alert alert-danger" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay candidatos en proceso </div>
        <?php else: ?>


            <table id="users-table">
                <tr style="text-align: center;">
                    <th> <input type="checkbox"> </th>
                    <th>Área</th>
                    <th>Vacante</th>
                    <th>Estado <i class="fas fa-exclamation-circle"></i> </th>
                    <th>Total en proceso </th>
                    <th>Opciones</th>
                </tr>
                <?php foreach ($viables as $viable): ?>
                    <tr style="font-size: 14px; text-align: center;">
                        <td><input type="checkbox"></td>
                        <td>
                            <!-- <img src="https://portalanterior.ine.mx/archivos2/portal/Elecciones/2016/PELocales/tipo/unica/CdMex/CandidatasyCandidatos/img/CandidatoAvtr.png"
                            alt="img" class='rounded-circle img-fluid'
                            style='width: 45px; height: 45px; object-fit: cover;'> -->
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">
                                <?= $viable->area ?></span>
                        </td>
                        <td>
                            <span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;"><?= $viable->vacante ?></span>
                        </td>

                        <td><span
                                style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">Activos</span>
                        </td>

                        <td>
                            <a href="<?php echo base_url("home/applicants/proceso/$viable->id") ?>" class="cv-link"
                                data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Ver detalles candidatos">
                                <?= $viable->cantidad_candidatos ?> candidatos <i class="fas fa-users"></i>

                            </a>

                            </a>
                        </td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                <a href='#!' class='dropdown-item' data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Eliminar todos los candidatos"
                                    style="border-radius: 1rem; color:red;">
                                    <i class='fas fa-trash-alt'></i> Eliminar candidatos
                                </a>
                                <a href='<?php echo base_url("home/forms/edit/$viable->id/$viable->token") ?>'
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Ver detalles del formulario" style="border-radius: 1rem;">
                                    <i class='fas fa-eye'></i>Ver formulario
                                </a>
                            </div>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>
        <?php endif; ?>

    </div>
</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>




<script>

    function delAplicc(event, id, token) {
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
                const url = `<?php echo base_url('/home/eliminarCands/'); ?>${id}/${token}`;
                window.location.href = url;
            }
        });
    }
</script>

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
            td = tr[i].getElementsByTagName("td")[1];
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