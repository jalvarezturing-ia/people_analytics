<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/cicles') ?>">Performance | Ciclos </a>| Nuevo ciclo
        <i class="fas fa-sync-alt"></i>
        <!-- <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;' title="Crear periodos"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
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

        <form action="<?php echo base_url('home/savecicle') ?>" method="POST">

            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Tipo:</label>
                <div class="col-sm-10">

                    <select name="detalles" id="detalles" class="form-control" style="border-radius: 1rem;" required>
                        <option value="none">Seleccione...</option>
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
                        placeholder="En este periodo..."></textarea>

                </div>
            </div>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Fecha inicio:</label>
                <div class="col-sm-4">

                    <input type="date" class="form-control" name="f_inicio" id="" value="<?= date('Y-m-d'); ?>">

                </div>
                <label for="titulo" class="col-sm-2 col-form-label">Fecha fin:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="f_fin" id="" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Estado:</label>
                <div class="col-sm-10">

                    <select name="estado" id="estado" class="form-control" style="border-radius: 1rem;" required>
                        <option value="none">Seleccione...</option>
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

    
    <!-- <div class="noasignados">
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

        <?php endif; ?>
        <div class="alert alert-danger" id="mensaje-sin-periodo" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> No hay usuarios disponibles </div>
    </div> -->

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