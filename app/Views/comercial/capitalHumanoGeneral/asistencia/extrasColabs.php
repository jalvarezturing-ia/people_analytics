<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<?php $numero = 1; ?>
<?php $numero2 = 1; ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> <a
            href="<?php echo base_url("/home/extras"); ?>">Días extras -</a>
        <?= $mes . " del " . $año ?> <i class="fas fa-clock"></i>
        <hr>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-clock" style="color: #3498db;"></i> Administrar días extras
            </strong>


        </div>
        <div class="card-body" id="pendSection">





            <table>
                <tr style="font-weight: bold; text-align: center;">
                    <td>#</td>
                    <td>Nombre y apellido </td>
                    <td>Fecha inicio</td>
                    <td>Fecha fin</td>
                    <td>Horas trabajar</td>
                    <td>Jornada</td>
                    <td>Actividades</td>
                    <td>Evidencia</td>

                </tr>
                <?php foreach ($data as $info): ?>

                    <tr style="text-align: center;">
                        <td>
                            <?= $numero; ?>
                        </td>
                        <td>
                            <?= $info->nombre . " " . $info->apellido_paterno ?>
                        </td>
                        <td>
                            <?= $info->f_inicio ?>
                        </td>
                        <td>
                            <?= $info->f_fin ?>
                        </td>
                        <td>
                            <?= $info->h_trabajar ?>
                        </td>
                        <td>
                            <?= $info->jornada ?>
                        </td>
                        <?php if (empty($info->evidencia_inic && $info->evidencia_fin)): ?>
                            <td style="color:red;">
                                Sin evidencia
                            </td>
                        <?php else: ?>
                            <td>

                                <?php
                                $descripcion = strlen($info->actividades) > 30 ? substr($info->actividades, 0, 30) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($info->actividades) . '\')">...</a>' : $info->actividades;
                                echo $descripcion;
                                ?>
                            </td>
                        <?php endif; ?>
                        <?php if (empty($info->evidencia_inic && $info->evidencia_fin)): ?>
                            <td style="color:red;">
                                Sin evidencia
                            </td>
                        <?php else: ?>
                            <td>
                                <a href="#" onclick='mostrarImagen("<?php echo base_url("/dias/$info->evidencia_inic"); ?>")'>
                                    <img src="<?php echo base_url("/dias/$info->evidencia_inic"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;">
                                </a> -
                                <a href="#" onclick='mostrarImagen("<?php echo base_url("/dias/$info->evidencia_fin"); ?>")'>
                                    <img src="<?php echo base_url("/dias/$info->evidencia_fin"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;">
                                </a>
                            </td>
                        <?php endif; ?>

                    </tr>
                    <?php $numero++; endforeach; ?>
            </table>
            <hr>
            <a href="<?= base_url("/home/extras"); ?>" class="btn ver-periodo-btn1">Retroceder</a>
        </div>


    </div>
</div>





<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>