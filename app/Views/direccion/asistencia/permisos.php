<?= $this->include('direccion/header') ?>
<?php $numero = 1; ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> Permisos de salida <i
            class="fas fa-sign-out-alt"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-sign-out-alt" style="color: #3498db;"></i> Administrar permisos de salida
            </strong>
            <hr>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion2('pend')" id="1"> <i
                        class="fas fa-clock"></i> Pendientes
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion2('auto')" id="2"> <i
                        class="fas fa-check-circle"></i> Autorizados </a>
            </div>
        </div>
        <div class="card-body" id="pendSection">
            <center>
                <h5><i class="fas fa-clock" style="color: blue;"></i> Permisos pendientes de autorizar
                </h5>
            </center>

            <?php if (empty($info)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay permisos solicitados.
                    <?= session('nombre'); ?> &#128516;
                </div>

            <?php else: ?>
                <table>
                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">#</td>
                        <td style="text-align: center;">Colaborador</td>
                        <td style="text-align: center;">Fecha salida </td>
                        <td style="text-align: center;">Fecha regreso </td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Justificante</td>
                    </tr>
                    <?php foreach ($info as $data): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero ?>
                            </td>
                            <td>
                                <!--<img src="<?php echo base_url("/fotos_colab/$data->foto_perfil"); ?>" alt="img"
                                    class='rounded-circle img-fluid' style='width: 45px; height: 45px; object-fit: cover;'> <br>-->
                                <?= $data->nombre . " " . $data->apellido_paterno; ?>
                            </td>
                            <td>
                                <?= $data->f_salida ?>
                            </td>
                            <td>
                                <?= $data->f_regreso ?>
                            </td>
                           
                            <td style="background: #E3FF72; color: #000000; font-weight: bold; ">
                               
                                    <?= $data->estado ?>
                              
                            </td>
                            <td>
                                <a href="#" onclick="mostrarImagen('<?php echo base_url("/permisos/$data->evidencia"); ?>')">
                                    <img src="<?php echo base_url("/permisos/$data->evidencia"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;">
                                </a>
                            </td>
                            
                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <div class="card-body" id="autoSection" style="display:none">

            <center>
                <h5><i class="fas fa-check-circle" style="color: blue;"></i> Lista de autorizados
                </h5>
            </center>

            <?php if (empty($aprobado)): ?>

                <div class="alert alert-danger" style="text-align: center;">No hay permisos autorizados &#128516;
                </div>

            <?php else: ?>
                <table>
                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">#</td>
                        <td style="text-align: center;">Colaborador</td>
                        <td style="text-align: center;">Fecha salida</td>
                        <td style="text-align: center;">Fecha regreso</td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Justificante</td>
                    </tr>
                    <?php foreach ($aprobado as $data1): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero ?>
                            </td>
                            <td>
                                <!--<img src="<?php echo base_url("/fotos_colab/$data1->foto_perfil"); ?>" alt="img"
                                    class='rounded-circle img-fluid' style='width: 45px; height: 45px; object-fit: cover;'> <br>-->
                                <?= $data1->nombre . " " . $data1->apellido_paterno; ?>
                            </td>
                            <td>
                                <?= $data1->f_salida ?>
                            </td>
                            <td>
                                <?= $data1->f_regreso ?>
                            </td>
                            
                            <td style="background: #8FFF69; color: #000000; font-weight: bold; ">
                                <?= $data1->estado ?>
                            </td>
                            <td>
                                <a href="#" onclick="mostrarImagen('<?php echo base_url("/permisos/$data1->evidencia"); ?>')">
                                    <img src="<?php echo base_url("/permisos/$data1->evidencia"); ?>" alt="img"
                                        class="rounded-thumbnail img-fluid"
                                        style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;">
                                </a>
                            </td>
                            
                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>






<?= $this->include('direccion/footer') ?>