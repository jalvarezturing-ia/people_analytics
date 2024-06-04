<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y"); ?>
<?= $this->include('colaboradores/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance </a>| Encuestas
        <i class="fas fa-envelope"></i>
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
                <?php $num = 5;
                foreach ($encuestas as $encuesta): ?>
                    <div class="ag-courses_item">
                        <a href="<?= base_url("home/encuestas/responder/$encuesta->id/$encuesta->titulo") ?>"
                            class="ag-courses-item_link">
                            <div class="ag-courses-item_bg"></div>
                            <div class="ag-courses-item_title">
                                <?= $encuesta->titulo ?>
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
                    class="fa fa-exclamation-circle"></i> No hay encuestas finalizadas disponibles.
            </div>
        <?php else: ?>

            <div class="row">
                <?php $num = 5;
                foreach ($respondidas as $respondida): ?>
                    <div class="ag-courses_item">
                        <a href="<?= base_url("home/encuestas/respuestas/$respondida->id/$respondida->titulo") ?>" class="ag-courses-item_link">
                            <div class="ag-courses-item_bg"></div>
                            <div class="ag-courses-item_title">
                            <span style="font-size:25px;">
                                <?= $respondida->titulo ?>
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

<?= $this->include('colaboradores/footer') ?>


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