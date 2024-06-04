<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<?php $numero = 1; ?>
<?php $numero2 = 1; ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> Permisos de salida <i
            class="fas fa-sign-out-alt"></i>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones">
            <a href='#!' onclick="nuevo(event)" class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Crear nuevo permiso">
                <i class='fas fa-file-alt'></i> Crear nuevo permiso
            </a>

        </div>
        <hr>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-sign-out-alt" style="color: #3498db;"></i> Administrar permisos de salida
            </strong>
            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion2('pend')" id="1"> <i
                        class="fas fa-clock"></i> Pendientes
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion2('auto')" id="2"> <i
                        class="fas fa-check-circle"></i> Autorizados </a>
            </div>
        </div>
        <div class="card-body" id="pendSection">
            <center>
                <h5><i class="fas fa-clock" style="color: blue;"></i> Permisos pendientes de autorizar
                </h5>
            </center>

            <?php if (empty($info)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay permisos solicitados.
                    <?= session('nombre'); ?> &#128516;
                </div>

            <?php else: ?>
                <table>
                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">#</td>
                        <td style="text-align: center;">Colaborador</td>
                        <td style="text-align: center;">Fecha salida</td>
                        <td style="text-align: center;">Fecha regreso</td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Evidencia</td>
                        <td style="text-align: center;">Menú</td>
                    </tr>
                    <?php foreach ($info as $data): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero ?>
                            </td>
                            <td>
                                <!--<img src="<?php echo base_url("/fotos_colab/$data->foto_perfil"); ?>" alt="img"
                                    class='rounded-circle img-fluid' style='width: 45px; height: 45px; object-fit: cover;'> <br>-->
                                <?= $data->nombre . " " . $data->apellido_paterno; ?>
                            </td>

                            <td>
                                <?= $data->f_salida ?>
                            </td>
                            <td>
                                <?= $data->f_regreso ?>
                            </td>
                            <td style="background: #E3FF72; color: #000000; font-weight: bold; ">
                                <a href="#!" onclick="aprob(event, '<?php echo $data->id ?>')" title="Aprobar permiso">
                                    <?= $data->estado ?>
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick='mostrarImagen("<?php echo base_url("/permisos/$data->evidencia"); ?>")'>
                                    <img src="<?php echo base_url("/permisos/$data->evidencia"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;">
                                </a>
                            </td>

                            <td>

                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href="#!" onclick="aprobar(event,
                                '<?php echo $data->id ?>', 
                                                                '<?php echo $data->nombre ?>', 
                                                                '<?php echo $data->apellido_paterno ?>', 
                                                                '<?php echo $data->foto_perfil ?>', 
                                                                '<?php echo $data->descripcion ?>', 
                                                                '<?php echo $data->f_salida ?>', 
                                                                '<?php echo $data->f_regreso ?>', 
                                                                '<?php echo $data->horas_reponer ?>', 
                                                                '<?php echo $data->evidencia ?>', 
                                                                )"><i class="fas fa-edit" style="color:blue;"></i>
                                        Editar permiso</a> <br><a href="#!" onclick="elimin(event, '<?php echo $data->id ?>')"
                                        title="Eliminar permiso"><i class="fas fa-trash" style="color:red;"></i> Eliminar
                                        permiso </a>
                                </div>
                            </td>
                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <div class="card-body" id="autoSection" style="display:none">

            <center>
                <h5><i class="fas fa-check-circle" style="color: blue;"></i> Lista de autorizados
                </h5>
            </center>

            <?php if (empty($aprobado)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay permisos autorizados &#128516;
                </div>

            <?php else: ?>
                <table>
                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">#</td>
                        <td style="text-align: center;">Colaborador</td>
                        <td style="text-align: center;">Fecha salida</td>
                        <td style="text-align: center;">Fecha regreso</td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Evidencia</td>
                        <td style="text-align: center;">Menú</td>
                    </tr>
                    <?php foreach ($aprobado as $data1): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero2 ?>
                            </td>
                            <td>
                                <!--<img src="<?php echo base_url("/fotos_colab/$data1->foto_perfil"); ?>" alt="img"
                                    class='rounded-circle img-fluid' style='width: 45px; height: 45px; object-fit: cover;'> <br>-->
                                <?= $data1->nombre . " " . $data1->apellido_paterno; ?>
                            </td>
                            <td>
                                <?= $data1->f_salida ?>
                            </td>
                            <td>
                                <?= $data1->f_regreso ?>
                            </td>
                            <td style="background: #8FFF69; color: #000000; font-weight: bold; ">
                                <?= $data1->estado ?>
                            </td>
                            <td>
                                <a href="#" onclick='mostrarImagen("<?php echo base_url("/permisos/$data1->evidencia"); ?>")'>
                                    <img src="<?php echo base_url("/permisos/$data1->evidencia"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;">
                                </a>
                            </td>

                            <td>

                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href="#!" onclick="aprobar(event,
                                '<?php echo $data1->id ?>', 
                                '<?php echo $data1->nombre ?>', 
                                '<?php echo $data1->apellido_paterno ?>', 
                                '<?php echo $data1->foto_perfil ?>', 
                                '<?php echo $data1->descripcion ?>', 
                                '<?php echo $data1->f_salida ?>', 
                                '<?php echo $data1->f_regreso ?>', 
                                '<?php echo $data1->horas_reponer ?>', 
                                '<?php echo $data1->evidencia ?>', 
                                )"><i class="fas fa-edit" style="color:blue;"></i> Editar permiso</a> <br> <a href="#!"
                                        onclick="elimin(event, '<?php echo $data1->id ?>')" title="Eliminar permiso"><i
                                            class="fas fa-trash" style="color:red;"></i>Eliminar permiso</a>
                                </div>


                            </td>
                        </tr>
                        <?php $numero2++; endforeach; ?>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>


<script>
    function aprobar(event, id, nombre, apellido, foto, motivo, salida, regreso, horas, captura) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                ` <div class="card-body" id="nuevoSection">
            <form id="formReq" action="<?php echo base_url("/home/savepermitDF"); ?>" method="post"
                enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                    <div class="col-sm-10">
                        <input type="hidden" name="permiso_id" class="form-control" value="${id}">
                        <input type="text" name="nombre" class="form-control" value="${nombre} ${apellido}" required readonly>
                    </div>
                    
                </div>
                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-edit" style="color: #3498db;"></i> Edición de información de
                        salida</strong>
                </div>
                <br>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Motivo de salida:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                    <textarea name="motivo" class="form-control"" id="motivoTextarea"
                            placeholder="Escriba el motivo de su salida con detalle, ejemplo: Tengo cita en el médico..."
                            rows="3" minlength="3" maxlength="5000" required >${motivo}</textarea>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fecha y hora de salida:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="text" id="f_salida" name="f_salida" value="${salida}" class="form-control" required >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Fecha y hora de regreso:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">

                        <input type="text" id="f_regreso" name="f_regreso" value="${regreso}" class="form-control" required >

                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Horas a reponer:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="number" name="horas_reponer" id="horas" value="${horas}" class="form-control" placeholder="Ejemplo: 1,2,3 o 4 "
                            required >
                            <input type="hidden" name="captura" value="${captura}" required>
                    </div>
                </div>
                

                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia y/o Justificante</strong>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                        required="">
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <img id="imagenPreview" src="#" alt="Vista previa de la captura"
                        style="max-width: 100%; max-height: 300px;">
                </div>
                <br>
            </form>
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
    }
</script>



<script>

    function aprob(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción aprobara el permiso. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, continuar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/aprobP/'); ?>${id}/`;
                window.location.href = url;
            }
        });
    }


    function elimin(event, id) {
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
                const url = `<?php echo base_url('/home/deleteP/'); ?>${id}/`;
                window.location.href = url;
            }
        });
    }


</script>


<script>
    function nuevo(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
            `<div class="info-card vertical">
                <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia ></a> Permisos de salida <i
                        class="fas fa-sign-out-alt"></i>
                </h4>
                <div>
                    <div class="card-header" style="text-align: center;">
                        <strong> <i class="fas fa-sign-out-alt" style="color: #3498db;"></i> Registrar un permiso de salida
                        </strong>
                        <hr>
                    <div class="card-body" id="nuevoSection">
                        <form id="formulario" action="<?php echo base_url("/home/savepermitt"); ?>" method="post"
                            enctype="multipart/form-data">
                            
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Colaborador: </label>
                                <div class="col-sm-10">
                                    <select name="id_usuario" id="" class="form-control" onchange="rellenarDescripcion(this)"
                                        required>
                                        <option value="">Selecciona el colaborador</option>
                                        <?php foreach ($people as $lista): ?>
                                                        <option value="<?php echo $lista->id; ?>"
                                                            data-descripcion="<?php echo $lista->descripcion; ?>">
                                                            <?php echo $numero . ". " . $lista->nombre . " " . $lista->apellido_paterno . " " . $lista->apellido_materno; ?>
                                                        </option>
                                                        <?php $numero++; endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-header" style="text-align: center;">
                                <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información de
                                    salida</strong>
                            </div>
                            <br>

                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Motivo de salida:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">


                                    <select name="motivo" class="form-control" id="cars" required>
                                        <option value="none">Seleccione</option>
                                        <option value="Medico">Médico</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                    <br>
                                </div>
                                <label for="area" class="col-sm-2 col-form-label">Fecha y hora de salida:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="datetime-local" id="f_salida" name="f_salida" class="form-control" required
                                        >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Fecha y hora de regreso:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">

                                    <input type="datetime-local" id="f_regreso" name="f_regreso" class="form-control" required
                                        >

                                </div>
                                <label for="area" class="col-sm-2 col-form-label">Horas a reponer:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" name="horas_reponer" id="horas" class="form-control"
                                        placeholder="Ejemplo: 1,2,3 o 4 " required >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Motivo de salida:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-10">
                                    <textarea name="motivo1" class="form-control"  id="motivoTextarea"
                                        placeholder="Escriba el motivo de su salida con detalle, ejemplo: Tengo cita en el médico..."
                                        rows="3" minlength="3" maxlength="5000" required></textarea>
                                </div>
                            </div>


                            <div class="card-header" style="text-align: center;">
                                <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia y/o Justificante</strong>
                            </div>
                            <br>

                            <div class="form-group mb-2 text-center">
                                <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                                    required="">
                            </div>
                            <br>

                            <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                                <img id="imagenPreview" src="#" style="max-width: 100%; max-height: 300px;">
                            </div>
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

                const form = document.getElementById('formulario');
                form.submit();
                /*var img = document.getElementById('imagenInput').value;

                if (img === '' || img === null) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, selecciona una imagen.',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: "Entendido",
                });
                } else {
                    const form = document.getElementById('formReq');
                    form.submit();
                }*/
            }

        });
    }
</script>


<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>