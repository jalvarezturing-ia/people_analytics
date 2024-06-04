<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<?php $numero = 1; ?>
<?php $numero2 = 1; ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> Administrar días
        extras <i class="fas fa-clock"></i>
        <hr>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-clock" style="color: #3498db;"></i> Administrar días extras
            </strong>
            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" id="1"> <i class="fas fa-clock"></i> Pendientes
                </a>
            </div>
        </div>
        <div class="card-body" id="pendSection">
        

            <?php if (empty($data)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay días solicitados.
                    <?= session('nombre'); ?> &#128516;
                </div>

            <?php else: ?>
                <table>
                    <tr style="font-weight: bold; text-align: center;">
                        <td>#</td>
                        <td>Año </td>
                        <td>Mes</td>
                        <td>Colaboradores en periodo</td>
                        <td>Menú</td>
                    </tr>
                    <?php foreach ($data as $datas): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero ?>
                            </td>
                            <td>
                                <?= $datas->año; ?>
                            </td>
                            <td>
                                <?= $datas->mes; ?>
                            </td>
                            <td>
                                <?= $datas->total_registros ?> con días extras
                            </td>


                            <td>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" title="Crear periodos"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href="<?php echo base_url("home/list/$datas->año/$datas->mes"); ?>"><i class="fas fa-arrow-right" style="color:blue;"></i> Visualizar periodo</a> 
                                </div>
                            </td>


                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>
            <?php endif; ?>
        </div>


    </div>
</div>





<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>