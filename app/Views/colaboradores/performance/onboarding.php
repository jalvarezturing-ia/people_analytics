<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('colaboradores/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance </a>| Onboarding
        <i class="fas fa-info-circle"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='#!' onclick="nuevoOnboarding(event)" class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Busca un historial de horas de entrada" style="border-radius: 1rem;">
                <i class='fas fa-plus'></i> Añadir Onboarding
            </a>
        </div>
    </h4>
    <hr>
    <div class="col-md-3 ">
        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="estadoOnboarding(this)">
            <option value="proceso">Onboardings en proceso</option>
            <option value="finalizado">Onboardings finalizados</option>
        </select>


    </div>

    <div class="card-body">
        <?php if (empty($onboardings)): ?>
            <!-- <div class="alert alert-danger" style="text-align: center;">No hay
                onboardings actualmente</div>
                <br> -->
            <div class="info-card small">
                <h4 class="title-wish">Performance | Onboarding</h4>
                <div class="line"></div>
                <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/7df7c475521507.5c4f4a6978056.gif" alt=""
                    id="indeximg">
                <br><br>
                <div class="alert alert-danger" style="text-align: center;">No hay
                    onboardings actualmente</div>

            </div>
        <?php else: ?>

            <div id="proceso">
                <table>
                    <tr style="text-align:center;">

                        <th>Título</th>
                        <th>Fecha de inicio </th>
                        <th>Checklist </th>
                        <th>Completado</th>
                        <th>Menú</th>
                    </tr>
                    <?php foreach ($onboardings as $onboarding):

                        if ($onboarding->estado == 'Proceso') { ?>
                            <tr style="text-align:center;">
                                <td>
                                    <?= $onboarding->titulo ?>
                                </td>
                                <td>
                                    <?= strftime("%d/%B/%Y", strtotime($onboarding->fecha_inicio)) ?>
                                </td>
                                <td>

                                    <a href="<?php echo base_url("home/onboarding/checklist/$onboarding->id/$onboarding->titulo"); ?>"
                                        style="color: #34db6c;"><i class="fas fa-clipboard-list"></i>
                                        Crear checklist</a>

                                </td>
                                <td><input type="button" class="btn ver-periodo-btn2" value="Completar onboarding"
                                        onclick="completar(this, '<?php echo $onboarding->id ?>');"></td>
                                <td>
                                    <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                        <i class='fas fa-caret-down'></i>
                                    </button>
                                    <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                        <a href='#!'
                                            onclick="editOn(event, '<?= $onboarding->id ?>', '<?= $onboarding->titulo ?>', '<?= $onboarding->fecha_inicio ?>','<?= $onboarding->fecha_fin ?>')"
                                            class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                            title="Busca un historial de horas de entrada" style="border-radius: 1rem;">
                                            <i class='fas fa-edit'></i> Editar
                                        </a>
                                        <a href='#!' onclick="delOnboarding(event, '<?= $onboarding->id ?>')" class='dropdown-item'
                                            data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                            title="Busca un historial de horas de entrada" style="border-radius: 1rem; color:red;">
                                            <i class='fas fa-trash'></i> Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                </table>
            </div>
            <div id="completados" style="display:none;">
                <table>
                    <tr style="text-align:center;">
                        <th>#</th>
                        <th>Título</th>
                        <th>Fecha de inicio </th>
                        <th>Fecha de finalización </th>
                        <th>Checklist </th>
                        <th>Completado</th>
                        <th>Menú</th>
                    </tr>
                    <?php foreach ($onboardings as $onboarding):
                        if ($onboarding->estado == 'Finalizado') { ?>
                            <tr style="text-align:center;">
                                <td>1</td>
                                <td>
                                    <?= $onboarding->titulo ?>
                                </td>
                                <td>
                                    <?= strftime("%d/%B/%Y", strtotime($onboarding->fecha_inicio)) ?>
                                </td>
                                <td>
                                    <?= strftime("%d/%B/%Y", strtotime($onboarding->fecha_fin)) ?>
                                </td>
                                <td><a href="<?php echo base_url("home/onboarding/checklist/$onboarding->id/$onboarding->titulo"); ?>"
                                        onclick="verList(event, '<?php echo $onboarding->id ?>')" style="color: #007bff;"><i
                                            class="fas fa-clipboard-list"></i> Ver checklist</a>
                                </td>
                                <td><input type="button" class="btn ver-periodo-btn" value="Marcar como no completado"
                                        onclick="completar(this, '<?php echo $onboarding->id ?>');"></td>
                                <td>
                                    <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                        <i class='fas fa-caret-down'></i>
                                    </button>
                                    <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                        <a href='#!'
                                            onclick="editOn(event, '<?= $onboarding->id ?>', '<?= $onboarding->titulo ?>', '<?= $onboarding->fecha_inicio ?>','<?= $onboarding->fecha_fin ?>')"
                                            class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                            title="Busca un historial de horas de entrada" style="border-radius: 1rem;">
                                            <i class='fas fa-edit'></i> Editar
                                        </a>
                                        <a href='#!' onclick="delOnboarding(event, '<?= $onboarding->id ?>')" class='dropdown-item'
                                            data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                            title="Busca un historial de horas de entrada" style="border-radius: 1rem; color:red;">
                                            <i class='fas fa-trash'></i> Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function completar(estado, id) {
        var valor = estado.value;
        console.log(valor + " " + id);


        $.ajax({
            url: '<?php echo base_url("/home/saveOnboardingEdit"); ?>', // Especifica la URL de tu endpoint en el backend
            method: 'POST', // Método de la solicitud
            data: { id: id, valor: valor }, // Datos a enviar al servidor (ID y valor)
            success: function (response) {
                // Maneja la respuesta del servidor si es necesario
                console.log('Datos enviados al backend correctamente.');
                //console.log(response);
                location.reload(); // Recargar la página
            },
            error: function (xhr, status, error) {
                // Maneja errores si ocurrieron durante la solicitud AJAX
                console.error('Error al enviar datos al backend:', error);
            }
        });

    }
</script>
<script>
    function nuevoOnboarding(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="title-wish" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Performance | </a>Nuevo onboarding </strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                1. En caso de tener algún problema en el envío de su captura, favor de reportarse inmediatamente
                                con Mayte López del área de Capital humano.<br>

                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <form id="formReq" action="<?php echo base_url("/home/saveOnboarding"); ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body" id="contenido-dinamico">
                        <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Titulo:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                    <textarea id="titulo" name="titulo" class="form-control" placeholder="Ponle un título a tu onboarding..."></textarea>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fecha inicio:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="date" id="f_inicio" name="f_inicio" class="form-control" required  value="<?= date('Y-m-d'); ?>"
                            >
                    </div>
                </div>
               

                    
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Estado:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-10">

                    <select name="estado" class="form-control" id="estado" required>
                        <option style="color:#008000;" value="Proceso">&#9724; Proceso</option>
                    </select>

                    </div>
                </div>
                                <br>
                            </form>
                         </div>
                    </div>
                </div>`,
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            customClass: 'swal-wide',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const form = document.getElementById('formReq');
                form.submit();
                // var img = document.getElementById('imagenInput').value;

                // if (img === '' || img === null) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Error',
                //         text: 'Por favor, selecciona una imagen.',
                //         confirmButtonColor: '#3498db',
                //         confirmButtonText: "Entendido",
                //     });
                // } else {
                //     const form = document.getElementById('formReq');
                //     form.submit();
                // }
            }

        });
    }


    function editOn(event, id, title, f_inicio, f_fin) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="title-wish" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Performance | </a>Nuevo onboarding </strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                1. En caso de tener algún problema en el envío de su captura, favor de reportarse inmediatamente
                                con Mayte López del área de Capital humano.<br>

                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <form id="formReq" action="<?php echo base_url("/home/saveOnboardingEditData"); ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body" id="contenido-dinamico">
                        <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Titulo:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                    <input type="text" id="titulo" name="titulo" class="form-control" required value="${title}">
                    <input type="hidden" id="id" name="id" class="form-control" required value="${id}">
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fecha inicio:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="date" id="f_inicio" name="f_inicio" class="form-control" required  value="${f_inicio}"
                            >
                    </div>
                </div>
                        <div class="form-group row">
                    <label for="area" class="col-sm-2 col-form-label">Fecha fin:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" id="f_fin" name="f_fin" class="form-control" required  value="${f_fin}"
                            >
                    </div>
                </div>
            
                </div>
                            </form>
                         </div>
                    </div>
                </div>`,
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            customClass: 'swal-wide',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const form = document.getElementById('formReq');
                form.submit();
                // var img = document.getElementById('imagenInput').value;

                // if (img === '' || img === null) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Error',
                //         text: 'Por favor, selecciona una imagen.',
                //         confirmButtonColor: '#3498db',
                //         confirmButtonText: "Entendido",
                //     });
                // } else {
                //     const form = document.getElementById('formReq');
                //     form.submit();
                // }
            }

        });
    }


    function delOnboarding(event, id_comen) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la información correspondiente y dejará de estar disponible. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/delOnboarding/'); ?>${id_comen}/`;
                window.location.href = url;
            }
        });
    }
</script>

<?= $this->include('colaboradores/footer') ?>