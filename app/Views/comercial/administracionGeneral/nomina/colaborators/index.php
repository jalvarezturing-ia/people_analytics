<?= $this->include('comercial/administracionGeneral/header') ?>

<div class="info-card vertical">
    <h6 class="title-wish"><a href="<?php echo base_url('/home/nomina/people');?>">Colaboradores</a> > Agregar un empleado <i class="fas fa-user"></i></h6>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong><i class="fas fa-edit"></i> Información personal</strong>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('/home/newcolab/savecolab') ?>" method="post"
                enctype="multipart/form-data">
                <div class="mb-5" style="text-align:center;">
                    <!-- Sección para cambiar la foto de perfil -->
                   <img src='<?php echo base_url('/fotos_colab/perfil.png'); ?>'
                            class='rounded-circle img-fluid' style='width: 90px; height: 90px; object-fit: cover;'>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s):</label>
                    <div class="col-sm-4">
                        <input type="text" name="nombre" class="form-control" value="<?= session('nombre1') ?? '' ?>"
                            placeholder="Ingresa el nombre del colaborador (a)" required>
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label">Apellido paterno:</label>
                    <div class="col-sm-4">
                        <input type="text" name="apellido_paterno" class="form-control" value="<?= session('apellido_paterno') ?? '' ?>"
                            placeholder="Ingresa el Apellido Paterno" required>
                    </div>
                </div>
                <div class="form-group row">
                <label for="telefono" class="col-sm-2 col-form-label">Apellido materno:</label>
                    <div class="col-sm-4">
                        <input type="text" name="apellido_materno" class="form-control"
                            value="<?= session('apellido_materno') ?? '' ?>" 
                            required placeholder="Ingresa el Apellido Materno">
                    </div>
                <label for="telefono" class="col-sm-2 col-form-label">Teléfono:</label>
                    <div class="col-sm-4">
                        <input type="text" maxlength="10" name="telefono" class="form-control"
                            value="<?= session('telefono') ?? '' ?>" required placeholder="Ingresa el telefono del usuario">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="descripcion" class="col-sm-2 col-form-label">Fecha nacimiento:</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_nacimiento" class="form-control"
                            value="<?= session('fecha_nacimiento') ?? '' ?>" required>
                    </div>

                    <label for="sexo" class="col-sm-2 col-form-label">Sexo:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="sexo" class="form-control">
                            <option value="<?= session('sexo') ?? '' ?>">
                                    <?= session('sexo') ?? 'Selecciona el sexo:' ?>
                                </option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Indefinido">Indefinido</option>
                            </select>
                        </td>
                    </div>
                    
                </div>
                <div class="form-group row">

                    <label for="descripcion" class="col-sm-2 col-form-label">Dirección:</label>
                    <div class="col-sm-10">
                        <textarea name="direccion" class="form-control" placeholder="Escriba la dirección de vivienda del usuario, ejemplo: Mexicali, Baja California" rows="3"
                            minlength="3" maxlength="5000" required><?= session('direccion') ?? '' ?></textarea>

                    </div>
                </div>
                <div class="card-header" style="text-align: center;">
                <strong> <i class="fas fa-building"></i> Información empresarial  </strong>
                </div>
                <p></p>
                <div class="form-group row">
                    <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                    <div class="col-sm-4">
                        <input type="text" name="correo" class="form-control" value="<?= session('correo') ?? '' ?>"
                            required placeholder="Ingresa el correo empresarial del usuario">
                    </div>
                    <label for="nombre_area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="nombre_area" class="form-control">
                                <option value="<?= session('nombre_area') ?? '' ?>">
                                    <?= session('nombre_area') ?? 'Selecciona un Área:' ?>
                                </option>
                                <option value="Servicios">Servicios</option>
                                <option value="Comercial">Comercial</option>
                            </select>
                        </td>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="correo" class="col-sm-2 col-form-label">Descripción:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="descripcion" class="form-control">
                                <option value="<?= session('descripcion') ?? '' ?>">
                                    <?= session('descripcion') ?? 'Selecciona la descripción:' ?>
                                </option>
                                <option value="Administración">Administración</option>
                                <option value="Capital Humano">Capital Humano</option>
                                <option value="Comercial">Comercial</option>
                                <option value="Desarrollo de Software">Desarrollo de Software</option>
                                <option value="Infraestructura">Infraestructura</option>
                                <option value="Jurídico">Jurídico</option>
                                <option value="Project Management">Project Management</option>
                                <option value="Tableau">Tableau</option>
                                <!--<option value="Dirección Comercial">Dirección Comercial</option>
                                <option value="Dirección de Servicios">Dirección de Servicios</option>
                                <option value="Administración General">*Administrador de área Admin</option>
                                <option value="Capital Humano General">*Administrador de área RH</option>-->

                            </select>
                        </td>
                    </div>
                    <label for="correo" class="col-sm-2 col-form-label">Puesto:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="puesto" class="form-control">
                                <option value="<?= session('puesto') ?? '' ?>">
                                    <?= session('puesto') ?? 'Selecciona un puesto:' ?>
                                </option>

                                <option value="Becario">Becario</option>
                                <option value="Lider">Lider</option>
                                <option value="Practicante">Practicante</option>
                                <option value="Trainee">Trainee</option>
                            </select>
                        </td>
                    </div>
                </div>

                <div class="form-group row">
                
                <label for="correo" class="col-sm-2 col-form-label">Ingreso a <strong>TURING-IA:</strong></label>
                    <div class="col-sm-10">
                        <input type="date" name="fecha_ingreso" class="form-control"
                            value="<?= session('fecha_ingreso') ?? '' ?>" required>
                    </div>
            </div>

                <div class="card-header" style="text-align: center;">
                <strong><i class="fas fa-lock"></i> Guardar nueva contraseña </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="new_password" class="col-sm-2 col-form-label">Nueva Contraseña:</label>
                    <div class="col-sm-4">
                        <input type="text" name="new_password" value="<?= $passwordT ?>" class="form-control" placeholder="Contraseña"
                            pattern="[A-Za-z0-9]{4,10}" 
                            title="La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres.
                        </small>
                    </div>
                    <label for="v_password" class="col-sm-2 col-form-label">Válida Contraseña:</label>
                    <div class="col-sm-4">
                        <input type="text" name="v_password" class="form-control" placeholder="Contraseña"
                            pattern="[A-Za-z0-9]{4,10}"
                            title="La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres" required>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres.
                        </small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <a href="<?php echo base_url("home/nomina"); ?>" class="ver-periodo-btn1">Retroceder</a>
                        <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<?= $this->include('comercial/administracionGeneral/footer') ?>

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

<!-- Incluye jQuery desde un CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Función para eliminar acentos
        function removeAccents(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        // Aplica la función de eliminación de acentos mientras se escribe
        $("[name='nombre'], [name='apellido_paterno'], [name='apellido_materno'], [name='correo'], [name='direccion']").on('input', function () {
            $(this).val(removeAccents($(this).val()));
        });
    });
</script>
