<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$numero = 1; ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>




<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/encuestas') ?>">Performance| Encuestas | </a> Resultados
        encuesta
        <i class="fas fa-envelope"></i>
    </h4>
    <hr>

    <?php if (empty($respuestas)): ?>
        <br>
        <div class="alert alert-info" style="text-align: center;">No hay respuestas registrados todo
            va bien por aquí. &#128516;
        </div>

        <div style="text-align: right;">
                <a href="<?php echo base_url("home/review/edit/$id") ?>" class="btn ver-periodo-btn1">Cancelar</a>

            </div>
    <?php else: ?>

        <div class="card-body">
            <table class="table table-hover table-bordered">
                <tr>
                    <td class="text-center" colspan="11">
                        <span style="font-weight:bold;">Evaluación:
                            <?= $titulo; ?>
                        </span>
                    </td>
                </tr>
                <?php foreach ($respuestas as $respuesta): ?>
                    <tr>
                        <td colspan="11">
                            <strong> De la pregunta.
                                <?= $respuesta->numero; ?>:
                            </strong>
                            <?= $respuesta->pregunta; ?>
                            <br>
                            <strong>R=</strong>
                            <?= $respuesta->respuesta; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div style="text-align: right;">
                <a href="<?php echo base_url("home/review/edit/$id") ?>" class="btn ver-periodo-btn1">Cancelar</a>

            </div>

        </div>
    <?php endif; ?>
</div>


<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>