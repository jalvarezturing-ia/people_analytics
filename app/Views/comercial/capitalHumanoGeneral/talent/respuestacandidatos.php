<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$numero = 1; ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>




<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/applicants') ?>">Talent Management | Candidatos por áreas
            | </a> <?= $vacante ?> | Resultados
        formulario
        <i class="fas fa-envelope"></i>
    </h4>
    <hr>

    <?php if (empty($candidatos)): ?>
        <br>
        <div class="alert alert-info" style="text-align: center;">No hay respuestas registrados todo
            va bien por aquí. &#128516;
        </div>

        <div style="text-align: right;">
            <a href="<?php echo base_url("home/applicants/form/$id_form") ?>" class="btn ver-periodo-btn1">Cancelar</a>

        </div>
    <?php else: ?>

        <div class="card-body">
            <table class="table table-hover table-bordered">
                <tr>
                    <td class="text-center" colspan="11">
                        <span style="font-weight:bold;">Evaluación:
                            <?= $vacante; ?>
                        </span>
                    </td>
                </tr>
                <?php foreach ($candidatos as $respuesta): ?>
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
                <a href="<?php echo base_url("home/applicants/form/$id_form") ?>" class="btn ver-periodo-btn1"> Atrás <i
                        class="fas fa-arrow-left"></i> </a>
                <a href="<?php echo base_url("home/applicants/viable/0/$id_user") ?>" class="btn ver-periodo-btn"> No viable <i
                        class="fas fa-exclamation-circle"></i></a>
                <a href="<?php echo base_url("home/applicants/viable/1/$id_user") ?>" class="btn ver-periodo-btn"> Viable <i
                        class="fas fa-check-circle"></i></a>
            </div>

        </div>
    <?php endif; ?>
</div>


<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>