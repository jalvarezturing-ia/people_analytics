<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/applicants"); ?>">Talent Management | Candidatos | </a>
        Formularios vacantes
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

    <div class="col-md-3 " style="">
    </div>

    <div class="card-body" id="proceso">

        <div class="search-box">
            <a href="<?php echo base_url("/home/forms/nuevo/$token"); ?>" class="btn ver-periodo-btn"
                style="border: none;" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                title="Crear un formulario">
                <i class="fas fa-plus"></i> Nuevo
            </a>|
            <input type="text" id="search" oninput="filterForms()" placeholder="Escriba para buscar formulario">
        </div>
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)"> <i class="fas fa-tasks"></i>
                            <?= $total; ?>
                            <?php if ($total == 1):
                                echo "formulario creado";
                            else:
                                echo "formularios creados";
                            endif; ?>
                        </a></li>
                </ol>
            </div>
        </div>
        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> No hay formularios disponibles </div>

        <?php if (empty($forms)): ?>
            <br>
            <div class="alert alert-info" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay formularios disponibles.
            </div>
        <?php else: ?>
            <table id="forms-table">
                <tr>
                    <th> <input type="checkbox"> </th>
                    <th>Área</th>
                    <th>Vacante</th>
                    <th class="text-center">Link</th>
                    <th class="text-center">Origen <i class="fas fa-exclamation-circle"></i> </th>
                    <th class="text-center">Menú </th>
                </tr>
                <?php foreach ($forms as $form): ?>
                    <tr>
                        <td> <input type="checkbox"></td>
                        <td><?= $form->area ?></td>
                        <td><?= $form->vacante ?></td>
                        <td class="text-center">
                            <a style="color: #4c49ea; text-decoration: underline;"
                                href="<?= base_url('form_applicant/') . $form->token ?>" target="_blank">
                                <?= substr(base_url('form_applicant/') . $form->token, 0, 38) ?>
                            </a>
                        </td>

                        <td class="text-center">
                            <?php if ($form->clonado == '0'): ?>
                                <span
                                    style="padding: 7px; border-radius: 100px; background-color: rgb(246, 246, 246); border: 1px solid #ccc; border:none;">Origen</span>
                            <?php else: ?>

                                <span
                                    style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">Clonado</span>
                            <?php endif; ?>
                            <!-- <small id="passwordHelpBlock" class="form-text text-muted">
                                Creado por <strong style="color: #4c49ea;"> Capital Humano </strong>
                                <br></small> -->
                        </td>
                        <td class="text-center"><button type='button' class="btn ver-periodo-btn btn-xs btn-radius"
                                style=' float: right;' title="Crear periodos" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Acciones
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                <a href='<?php echo base_url("/home/forms/edit/$form->id/$form->token"); ?>'
                                    class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Edita el formulario" style="border-radius: 1rem;">
                                    <i class='fas fa-edit'></i> Editar
                                </a>
                                <a href='#!' onclick="clone(event, '<?= $form->token ?>')" class='dropdown-item'
                                    data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Clonar el formulario"
                                    style="border-radius: 1rem; color: #4c49ea;">
                                    <i class='fas fa-clone'></i> Clonar
                                </a>
                                <a href='#!' onclick="delEnc(event, '<?= $form->id ?>')" class='dropdown-item'
                                    data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Eliminar el formulario" style="color:red;" style="border-radius: 1rem;">
                                    <i class='fas fa-trash-alt'></i> Eliminar
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

    function delEnc(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará su selección. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2980b9',
            cancelButtonColor: '#df8686',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/eliminarForm/'); ?>${id}`;
                window.location.href = url;
            }
        });
    }

    function clone(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Clonar formulario?',
            text: 'El sistema clonará el formulario seleccionado',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#2980b9',
            cancelButtonColor: '#df8686',
            confirmButtonText: "Sí, continuar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/clonar/'); ?>${id}`;
                window.location.href = url;
            }
        });

    }

    function filterForms() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("forms-table");
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