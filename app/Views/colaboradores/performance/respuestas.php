<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$numero = 1; ?>
<?= $this->include('colaboradores/header') ?>




<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/encuestas') ?>">Performance| Encuestas | </a> Resultados
        encuesta
        <i class="fas fa-envelope"></i>
    </h4>
    <hr>

    <div class="card-body">



        <table class="table table-hover table-bordered">
            <tr>
                <td class="text-center" colspan="11">
                    <span style="font-weight:bold;">Evaluación:
                        <?= $titulo; ?>
                    </span>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        1. En caso de tener algún problema en el envío de su formulario, favor de reportarse
                        inmediatamente
                        con Mayte López del área de Capital humano.<br>

                        ¡Que tengan un excelente día!
                    </small>
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
            <a href="<?php echo base_url('home/encuestas') ?>" class="btn ver-periodo-btn1">Cancelar</a>

        </div>

    </div>
</div>



<?= $this->include('colaboradores/footer') ?>