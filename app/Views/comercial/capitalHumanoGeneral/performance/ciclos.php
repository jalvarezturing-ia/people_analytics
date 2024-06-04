<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/empeño"); ?>">Performance </a>| Ciclos
        <i class="fas fa-sync-alt"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='<?php echo base_url("/home/cicles/new_cicle") ?>' class='dropdown-item' data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Agrega un nuevo ciclo del colaborador"
                style="border-radius: 1rem;">
                <i class='fas fa-plus'></i> Agregar ciclo
            </a>
        </div>
    </h4>
    <hr>
    <div class="col-md-3 " style="">
        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="estadoEncuestas(this)">
            <option value="proceso">Periodos prueba pendientes</option>
            <option value="finalizado">Periodos prueba continuos</option>
        </select>
    </div>

    <div class="card-body" id="proceso">

        <div class="row">

            <?php $num = 1;
            foreach ($pendientes as $pendiente): ?>
                <div class="ag-courses_item">
                    <a href="<?= base_url("/home/cicle/edit/$pendiente->id"); ?>" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                            <span style="font-size:25px;">
                                <?= $pendiente->detalles; ?>
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

    </div>

    <div class="card-body" id="completados" style="display:none;">

        <div class="row">

            <?php $num = 1;
            foreach ($finalizados as $finalizado): ?>
                <div class="ag-courses_item">
                    <a href="<?= base_url("/home/cicle/edit/$finalizado->id"); ?>" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                            <span style="font-size:25px;">
                                <?= $finalizado->detalles; ?>
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