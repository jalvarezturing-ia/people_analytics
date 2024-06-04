<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/review') ?>">Performance | Encuestas </a>| Nueva encuesta
        <i class="fas fa-envelope"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;' title="Crear periodos"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
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
    <!-- <div class="col-md-3 " style="">

        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="estadoEncuestas(this)">
            <option value="proceso">Encuestas </option>
            <option value="finalizado">Empleados </option>
        </select>
    </div> -->
    <div class="card-body" id="proceso">

        <form action="<?php echo base_url('home/saveencuesta') ?>" method="POST">

            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Título:</label>
                <div class="col-sm-10">
                    <input type="text" name="titulo" id="titulo" size="3030" placeholder="Encuesta sin título"
                        class="form-control " required autofocus>
                </div>

            </div>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Descripción:</label>
                <div class="col-sm-10">
                    <textarea name="subtitulo" id="subtitulo"  class="form-control"  placeholder="En esta encuesta evaluarás.."></textarea>
                    
                </div>

            </div>
            <br>
           
            <a href="<?php echo base_url('home/review') ?>" class="btn ver-periodo-btn1">Cancelar</a>
            <input type="submit" class="btn ver-periodo-btn" value="Guardar">
        </form>


    </div>

    <div class="card-body" id="completados" style="display:none;">

        <div class="search-box">
            <input type="text" id="search" oninput="filterTable()" placeholder="Escriba para buscar colaborador"
                style="border-radius: 1rem;"> |
            <button class="ver-periodo-btn2" style=" float: right;" data-toggle="tooltip" class="nav-link"
                id="saveUsers" data-placement="bottom" title="Guardar usuarios">
                <i class="fas fa-envelope"></i> Guardar
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
                        <?php echo $user->id ?>
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

    <div></div>
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