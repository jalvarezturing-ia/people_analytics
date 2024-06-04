<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/review') ?>" data-toggle="tooltip"
            data-placement="bottom" title="Regresar al menú principal">Performance | Encuestas </a>| Editar
        encuesta
        <i class="fas fa-edit"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;' title="Crear periodos"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='<?php echo base_url("/home/review/new_review") ?>' class='dropdown-item' data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Busca un historial de horas de entrada"
                style="border-radius: 1rem;">
                <i class='fas fa-plus'></i> Agregar encuesta
            </a>
        </div>
    </h4>
    <hr>
    <small id="passwordHelpBlock" class="form-text text-muted">
        Creado por <strong style="color: #4c49ea;"> Capital Humano </strong> el
        <?= date('d/m/Y'); ?>
        <br>

    </small>
    <br>
    <div class="col-md-3 " style="">

        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="estadoEncuestas(this)">
            <option value="proceso">Preguntas </option>
            <option value="finalizado">Empleados </option>
        </select>
    </div>
    <div class="card-body" id="proceso">
        <?php foreach ($encuestas as $encuesta): ?>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Título de la encuesta:</label>
                <div class="col-sm-10">
                    <input type="text" name="titulo_encuesta" id="titulo_titulo_encuesta" size="3030"
                        placeholder="Encuesta sin título" value="<?= $encuesta->titulo; ?>" class="form-control " required
                        oninput="update1(this, 'titulo_encuesta', '<?php echo $encuesta->id ?>' )">
                    <input type="hidden" name="id_encuesta" id="id_encuesta" value="<?= $id; ?>" class="form-control "
                        required>
                </div>

            </div>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Descripción de la encuesta:</label>
                <div class="col-sm-10">
                    <input type="text" name="descripcion_encuesta" id="descripcion_encuesta" size="3030"
                        placeholder="Encuesta sin título" value="<?= $encuesta->subtitulo; ?>" class="form-control "
                        required oninput="update1(this, 'descripcion_encuesta', '<?php echo $encuesta->id ?>' )">
                </div>

            </div>
            <br>

        <?php endforeach; ?>

        <div class="d-block text-right">
            <button class="btn ver-periodo-btn" onclick="agregarPregunta()" id="agregarBtn" data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Agrega preguntas al cuestionario"> <i
                    class="fas fa-edit"></i></button>
            <button class="btn ver-periodo-btn1" onclick="delEnc(event, '<?= $id ?>')" id="agregarBtn"
                data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Elimina la encuesta del sistema">
                <i class="fas fa-trash-alt"></i> </button>
        </div>

        <?php
        // Obtener el número de pregunta más alto
        $ultimoNumero = 0;
        foreach ($preguntas as $pregunta) {
            $ultimoNumero = max($ultimoNumero, $pregunta->numero);
        }
        ?>
        <div id="preguntasSection">

            <?php if (empty($preguntas)): ?>
                <br>
                <div class="alert alert-info" style="text-align: center;">No hay preguntas registrados todo
                    va bien por aquí. &#128516;
                </div>
            <?php else: ?>

                <table class="table table-bordered table-hover">
                    <?php foreach ($preguntas as $pregunta): ?>
                        <tr>
                            <td>Pregunta
                                <?= $pregunta->numero; ?> <i class="fas fa-trash-alt" style="color:#4070F4;"
                                    onclick="delPreg(event, '<?= $pregunta->id; ?>', '<?= $id ?>')"> </i>
                            </td>
                            <td><input type="text" name="titulo_pregunta" id="titulo_pregunta" class="form-control"
                                    value="<?= $pregunta->pregunta; ?>" required style="border:none;"
                                    oninput="update1(this, 'titulo_pregunta', '<?php echo $pregunta->id ?>' )"> </td>

                            <td>
                                <input type="text" name="pregunta_a" id="pregunta_a" class="form-control"
                                    placeholder="Escriba la respuesta del inciso A" value="<?= $pregunta->A; ?>" required
                                    oninput="update1(this, 'pregunta_a', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                                <input type="text" name="pregunta_b" id="pregunta_b" class="form-control"
                                    placeholder="Escriba la respuesta del inciso B" value="<?= $pregunta->B; ?>" required
                                    oninput="update1(this, 'pregunta_b', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                                <input type="text" name="pregunta_c" id="pregunta_c" class="form-control"
                                    placeholder="Escriba la respuesta del inciso C" value="<?= $pregunta->C; ?>" required
                                    oninput="update1(this, 'pregunta_c', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                                <input type="text" name="pregunta_d" id="pregunta_d" class="form-control"
                                    placeholder="Escriba la respuesta del inciso D" value="<?= $pregunta->D; ?>" required
                                    oninput="update1(this, 'pregunta_d', '<?php echo $pregunta->id ?>' )" style="border:none;">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <form action="<?php echo base_url('home/saveencuestaEdit') ?>" method="POST">
                <table id="tablaPreguntas" class="table table-bordered table-hover">
                    <!-- Aquí van las filas de preguntas -->

                </table>

                <div class="botones">
                    <a href="<?php echo base_url('home/review') ?>" class="btn ver-periodo-btn1">Cancelar</a>
                    <input type="submit" class="btn ver-periodo-btn" class="fas fa-edit" data-toggle="tooltip"
                        class="nav-link" data-placement="bottom" title="Guarda el formulario">
                </div>
            </form>
        </div>
    </div>

    <div class="card-body" id="completados" style="display:none;">
        <div class="d-block text-right">

            <button class="btn ver-periodo-btn" onclick="toggleEmpleados()" id="agregarBtn" data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Agregar empleados"> <i class="fas fa-plus"></i></button>
        </div>

        <div class="asignados" id="asignados"> <!-- los que ya se asignaron -->

            <?php if (empty($usuarios)): ?>
                <br>
                <div class="alert alert-info" style="text-align: center;">No hay usuarios registrados todo
                    va bien por aquí. &#128516;
                </div>
            <?php else: ?>
                <table>
                    <h4 class="title-wish text-center">Empleados asignados <i class="fas fa-chart-line"></i></h4>
                    <tr>
                        <th>Empleado</th>
                        <th>Área</th>
                        <th>Cargo</th>
                        <th class="text-center">Respondida</th>
                        <th class="text-center">Opciones</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                    <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td>
                                <?= $user->nombre . " " . $user->apellido_paterno ?>
                            </td>
                            <td>
                                <?= $user->descripcion ?>
                            </td>
                            <td>
                                <?= $user->puesto ?>
                            </td>

                            <td class="text-center"
                                style="color: <?= $user->estado_respuesta === 'Contestado' ? 'green' : 'red' ?>">
                                <?= $user->estado_respuesta ?>
                            </td>


                            <td class="text-center"><a href='#!' onclick="delUser('<?= $user->id_asig ?>')" style=" color:red;"
                                    data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Eliminar usuario de la encuesta">
                                    <i class='fas fa-trash-alt'></i>
                                </a></td>
                            <td class="text-center">
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opciones <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones" style="border-radius: 1rem;">
                                    <a href='<?php echo base_url("/home/review/deleterespuestas/$user->id_colab/$id") ?>'
                                        class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                        style=" color:red;" title="Eliminar respuestas" style="border-radius: 1rem;">
                                        <i class='fas fa-trash-alt'></i> Eliminar respuestas
                                    </a>
                                    <a href='<?php echo base_url("/home/review/verespuestas/$user->id_colab/$id/$encuesta->titulo") ?>'
                                        class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                        title=" Ver respuestas" style="border-radius: 1rem;">
                                        <i class='fas fa-eye'></i> Ver respuestas
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <div class="noasignados" id="noasignados" style="display:none;">
            <h4 class="title-wish text-center">Asignar empleados <i class="fas fa-chart-line"></i></h4>
            <div class="search-box">
                <input type="text" id="search" oninput="filterTable()" placeholder="Escriba para buscar colaborador"
                    style="border-radius: 1rem;"> |
                <button class="btn ver-periodo-btn" style=" float: right;" data-toggle="tooltip" class="nav-link"
                    id="saveUsers" data-placement="bottom" title="Guardar usuarios">
                    Guardar
                </button>
            </div>

            <?php if (empty($people)): ?>
                <br>
                <div class="alert alert-info" style="text-align: center;">Todos los usuarios han sido asignados. &#128516;
                </div>
            <?php else: ?>

                <table id="users-table"> <!-- para agregar usuarios nuevos -->
                    <tr>
                        <th><input type="checkbox" id="allusers" required></th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Cargo</th>
                    </tr>
                    <?php foreach ($people as $user): ?>
                        <tr>
                            <td>

                                <input type="checkbox" id="one_user" required>
                            </td>
                            <td>
                                <?php echo $user->id_colab ?>
                            </td>
                            <td>
                                <?= $user->nombre . " " . $user->apellido_paterno ?>
                            </td>
                            <td>
                                <?= $user->descripcion ?>
                            </td>
                            <td>
                                <?= $user->puesto ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php endif; ?>
            <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
        </div>
    </div>
</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>



<script>
    function toggleEmpleados() {
        var asignados = document.getElementById("asignados");
        var noasignados = document.getElementById("noasignados");

        if (asignados.style.display === "block") {
            asignados.style.display = "none";
            noasignados.style.display = "block";
        } else {
            asignados.style.display = "block";
            noasignados.style.display = "none";
        }
    }

</script>

<script>

    function delEnc(event, id) {
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
                const url = `<?php echo base_url('/home/eliminarEncs/'); ?>${id}`;
                window.location.href = url;
            }
        });
    }
    function delPreg(event, id, id_encuesta) {
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
                const url = `<?php echo base_url('/home/eliminarPreg/'); ?>${id}/${id_encuesta}`;
                window.location.href = url;
            }
        });
    }
</script>

<script>
    // Variable para mantener el número de la próxima pregunta
    var proximoNumero = <?php echo $ultimoNumero + 1; ?>;

    function agregarPregunta() {
        var table = document.getElementById("tablaPreguntas");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        row.innerHTML = `
            <tr>
                <td>Pregunta ${proximoNumero}:</td>
                <td><textarea name="preg[]" class="form-control" placeholder="Escriba la pregunta ${proximoNumero}" rows="3">¿?</textarea></td>
                <td><br>Escriba la Respuesta:</td>
                <td>
                    <input type="text" name="A[]" class="form-control" placeholder="Escriba la respuesta del inciso A" required><br>
                    <input type="text" name="B[]" class="form-control" placeholder="Escriba la respuesta del inciso B" required><br>
                    <input type="text" name="C[]" class="form-control" placeholder="Escriba la respuesta del inciso C" required><br>
                    <input type="text" name="D[]" class="form-control" placeholder="Escriba la respuesta del inciso D" required>
                    <input type="hidden" name="id_encuesta[]" value="<?= $id; ?>">
                    <input type="hidden" name="numero[]" value="${proximoNumero}">
                </td>
            </tr>
        `;

        proximoNumero++; // Incrementar el número de la próxima pregunta
    }
</script>

<!-- <script>
    function agregarPregunta() {
        var table = document.getElementById("tablaPreguntas");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var preguntaNum = rowCount + 1; // Para mantener el índice de la pregunta actual

        row.innerHTML = `
        <tr>
            <td>Pregunta ${preguntaNum}: <i class="fas fa-trash-alt" style="color:#4070F4;"> </i> </td>
            <td><textarea name="preg[]" class="form-control" placeholder="Escriba la pregunta ${preguntaNum}" rows="3"></textarea></td>
            <td><br>Escriba la Respuesta:</td>
            <td>
                <input type="text" name="A[]" class="form-control" placeholder="Escriba la respuesta del inciso A" required><br>
                <input type="text" name="B[]" class="form-control" placeholder="Escriba la respuesta del inciso B" required><br>
                <input type="text" name="C[]" class="form-control" placeholder="Escriba la respuesta del inciso C" required><br>
                <input type="text" name="D[]" class="form-control" placeholder="Escriba la respuesta del inciso D" required>
                <input type="hidden" name="id_encuesta[]" value="<?= $id; ?>">
                <input type="hidden" name="numero[]" value="${preguntaNum}">
            </td>
        </tr>
    `;
    }
</script> -->

<script>

    document.addEventListener("DOMContentLoaded", function () {
        var allUsersCheckbox = document.getElementById('allusers');
        var individualCheckboxes = document.querySelectorAll('#users-table input[type="checkbox"]');
        var saveUsersButton = document.getElementById('saveUsers');

        // Evento de clic en el checkbox "Seleccionar todos"
        allUsersCheckbox.addEventListener('click', function () {
            individualCheckboxes.forEach(function (checkbox) {
                checkbox.checked = allUsersCheckbox.checked;

            });
        });

        // Evento de clic en el botón "Guardar usuarios"
        saveUsersButton.addEventListener('click', function () {
            var selectedUserIds = [];
            individualCheckboxes.forEach(function (checkbox) {
                if (checkbox.checked && checkbox.id !== 'allusers') {
                    // Obtener el ID del usuario desde la celda anterior
                    var userId = checkbox.parentNode.parentNode.cells[1].textContent.trim();
                    selectedUserIds.push(userId);
                    console.log(selectedUserIds);
                }
            });

            // Enviar los IDs de los usuarios seleccionados al formulario
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo base_url("home/saveidencuesta") ?>';


            selectedUserIds.forEach(function (userId) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selectedUsers[]';
                input.value = userId;

                var input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'id_cuestionario';
                input2.value = <?php echo $id ?>;

                form.appendChild(input);
                form.appendChild(input2); // Aquí se agrega el segundo input al formulario
            });

            document.body.appendChild(form);
            form.submit();
        });
    });


</script>

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("users-table");
        tr = table.getElementsByTagName("tr");

        var found = false;

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
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