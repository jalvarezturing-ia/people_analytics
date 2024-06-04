<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$numero = 1; ?>
<?= $this->include('colaboradores/header') ?>




<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/encuestas') ?>">Performance| Encuestas | </a> Responder
        encuesta
        <i class="fas fa-envelope"></i>
        <!-- <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
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

    <div class="card-body">

        <form action="<?php echo base_url('home/guardarResultados') ?>" method="POST" id="test">

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
                <?php if (empty($preguntas)): ?>
                    <div class="alert alert-info" style="text-align: center;"> <i class="fa fa-exclamation-circle"></i> No
                        hay preguntas en la evaluación disponibles.
                    </div>
                    <style>
                        #guardar-btn {
                            display: none;
                        }
                    </style>
                <?php else: ?>
                    <?php foreach ($preguntas as $lista): ?>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                           
                        </small>
                        <tr>
                            <td colspan="11">
                                <?= $numero; ?>.
                                <?= $lista->pregunta; ?>
                                <input type='hidden' name='id_encuesta' value='<?php echo $lista->id_encuesta; ?>'>
                                <input type='hidden' name='id_usuario' value='<?= session('user_id'); ?>'>
                                <input type='hidden' name='pregunta[<?= $lista->id; ?>]'
                                    value='<?php echo $lista->pregunta; ?>'>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <?php
                                $array1 = array($lista->A, $lista->B, $lista->C, $lista->D);
                                shuffle($array1);
                                ?>
                                <?php foreach ($array1 as $key => $respuesta): ?>
                                    <div class='radio' style='margin-left:25px;'>
                                        <label>
                                            <input type='checkbox' name='resp[<?= $lista->id; ?>][]' value='<?= $respuesta; ?>'>
                                            <?= $respuesta; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <?php $numero++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>


            <div style="text-align: right;">
                <a href="<?php echo base_url('home/encuestas') ?>" class="btn ver-periodo-btn1">Cancelar</a>
                <button type="submit" class="btn ver-periodo-btn" id="guardar-btn">Guardar</button>
            </div>
        </form>
    </div>
</div>



<?= $this->include('colaboradores/footer') ?>