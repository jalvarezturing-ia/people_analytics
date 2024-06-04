<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<?php foreach($infos as $info):
    endforeach; ?>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/cicles') ?>">Performance | Ciclos </a>| Nuevo ciclo
        <i class="fas fa-sync-alt"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;' title="Crear periodos" onclick=""
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <!-- <div class="dropdown-menu acciones" style="border-radius: 1rem;"> 
            <a href='<?php echo base_url("/home/review/new_review") ?>' class='dropdown-item' data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Busca un historial de horas de entrada"
                style="border-radius: 1rem;">
                <i class='fas fa-plus'></i> Agregar encuesta
            </a>
        </div> -->
    </h4>
    <hr>
    <small id="passwordHelpBlock" class="form-text text-muted">
        Creado por <strong style="color: #4c49ea;"> Capital Humano </strong> el
        <?= date('d/m/Y'); ?>
        <br>

    </small>
    <br>
    <div class="card-body" id="proceso">

        <form action="<?php echo base_url('home/savecicleedit') ?>" method="POST">

            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Tipo:</label>
                <div class="col-sm-10">

                    <select name="detalles" id="detalles" class="form-control" style="border-radius: 1rem;" required>
                        <option value="<?= $info->detalles?>"><?= $info->detalles?></option>
                        <option value="prueba">Periodo de prueba</option>
                        <option value="contratacion">Contratatación</option>
                        <option value="desempeno">Desempeño</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Descripción:</label>
                <div class="col-sm-10">
                    <textarea name="descripcion" id="descripcion" class="form-control"
                        placeholder="En este periodo..."><?= $info->descripcion?></textarea>

                </div>
            </div>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Fecha inicio:</label>
                <div class="col-sm-4">

                    <input type="date" class="form-control" name="f_inicio" id="" value="<?= $info->f_inicio?>">
                    <input type="hidden" class="form-control" name="id_ciclo" id="" value="<?= $id?>">

                </div>
                <label for="titulo" class="col-sm-2 col-form-label">Fecha fin:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="f_fin" id="" value="<?= $info->f_fin?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Estado:</label>
                <div class="col-sm-10">

                    <select name="estado" id="estado" class="form-control" style="border-radius: 1rem;" required>
                        <option value="<?= $info->estado?>"><?= $info->estado?></option>
                        <option style="color:#008000;" value="Realizado">&#x1F7D4; Realizado</option>
                        <option style="color:#FF0000;" value="Sin comenzar">&#x1F7D4; Sin comenzar</option>
                        <option style="color:#40E0D0;" value="Trabajando">&#x1F7D4; Trabajando</option>
                        <option style="color:#0071c5;" value="Detenido">&#x1F7D4; Detenido</option>
                    </select>
                </div>
            </div>
            <br>

            <a href="<?php echo base_url('home/cicles') ?>" class="btn ver-periodo-btn1">Cancelar</a>
            <input type="submit" class="btn ver-periodo-btn" value="Guardar">
        </form>


    </div>

    
    <div class="noasignados">
        <h4 class="title-wish text-center">Asignar empleados <i class="fas fa-chart-line"></i></h4>
        <div class="search-box">
            <input type="text" id="search" oninput="filterTable()" placeholder="Escriba para buscar colaborador"
                style="border-radius: 1rem;"> |
            <button class="btn ver-periodo-btn" style=" float: right;" data-toggle="tooltip" class="nav-link"
                id="saveUsers" data-placement="bottom" title="Guardar usuarios">
                Guardar
            </button>
        </div>


            <table id="users-table"> 
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

        
        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
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
            form.action = '<?php echo base_url("home/saveidcicle") ?>';


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