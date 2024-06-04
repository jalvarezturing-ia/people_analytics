<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/empeño"); ?>">Performance </a>| Encuestas
        <i class="fas fa-envelope"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
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
    <div class="col-md-3 " style="">
        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="estadoEncuestas(this)">
            <option value="proceso">Encuestas pendientes</option>
            <option value="finalizado">Encuestas respondidas</option>
        </select>
    </div>

    <div class="card-body" id="proceso">


        <?php if (empty($encuestas)): ?>
            <br>
            <div class="alert alert-info" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay encuestas asignadas disponibles.
            </div>
        <?php else: ?>

            <div class="row">

                <?php $num = 1;
                foreach ($encuestas as $encuesta): ?>
                    <div class="ag-courses_item">
                        <a href="<?= base_url("/home/review/edit/$encuesta->id_encuesta"); ?>" class="ag-courses-item_link">
                            <div class="ag-courses-item_bg"></div>
                            <div class="ag-courses-item_title">
                                <span style="font-size:25px;">
                                    <?= $encuesta->titulo; ?>
                                </span>
                            </div>
                            <div class="ag-courses-item_date-box">
                                Ciudad de México a

                                <span class="ag-courses-item_date">
                                    <?= $fechaHoy ?>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>

    <div class="card-body" id="completados" style="display:none;">

        <?php if (empty($respondidas)): ?>
            <br>
            <div class="alert alert-info" id="mensaje-sin-periodo" style="text-align: center;"> <i
                    class="fa fa-exclamation-circle"></i> No hay encuestas respondidas disponibles.
            </div>
        <?php else: ?>
            
            <div class="row">

                <?php $num = 1;
                foreach ($respondidas as $respondida): ?>
                    <div class="ag-courses_item">
                        <a href="<?= base_url("/home/review/edit/$respondida->id_encuesta"); ?>" class="ag-courses-item_link">
                            <div class="ag-courses-item_bg"></div>
                            <div class="ag-courses-item_title">
                                <span style="font-size:25px;">
                                    <?= $respondida->titulo; ?>
                                </span>
                            </div>
                            <div class="ag-courses-item_date-box">
                                Ciudad de México a

                                <span class="ag-courses-item_date">
                                    <?= $fechaHoy ?>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
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