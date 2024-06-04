<?= $this->include('colaboradores/header') ?>
<?php $numero = 1; ?>
<?php $numero2 = 1; ?>
<?php $numero3 = 1; ?>



<div class="info-card vertical">
<h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> Análisis de
        asistencias <i class="fas fa-chart-bar"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones">
            <a href='#!' onclick="openFilterModal()" class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Busca un historial de horas de entrada">
                <i class='fas fa-search'></i> Buscar historico
            </a>
        </div>
        <br><br>
        <div class="line"> </div>

    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-chart-bar" style="color: #3498db;"></i> Análisis de asistencias
                <?= session('nombre'); ?>
            </strong>
            <br><br>
            <div id="btns">
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('entrada')" id="entradaBtn"
                    data-toggle="tooltip" data-placement="bottom" title="Detalle de las horas de entrada"> <i
                        class="fas fa-check-circle"></i> Entradas
                </a>|
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('salida')" id="salidaBtn"
                    data-toggle="tooltip" data-placement="bottom" title="Detalle de las horas de salida"> <i
                        class="fas fa-sign-out-alt"></i> Salidas </a>
            </div>
        </div>

        <div class="card-body" id="entradaSection">
          
            <?php if (empty($entrada)): ?>

            <?php else: ?>
                <table>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Tipo</th>
                        <th style="text-align: center;">Hora</th>
                        <th style="text-align: center;">Fecha</th>
                        <th style="text-align: center;">Captura</th>
                        <th style="text-align: center;">Editar</th>
                    </tr>
                    <?php foreach ($entrada as $data):
                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");
                        $fecha = strftime("%d/%B/%Y", strtotime($data->fecha));
                        $foto = $data->captura;
                        ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $numero; ?>
                            </td>
                            <?php if ($data->retardo == "SI"): ?>
                                <td
                                    style="background-color: #FFE999; color: #000000; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <a href="#!" onclick="help(event, 
                                '<?php echo $data->id; ?>', 
                                '<?php echo $data->hora; ?>', 
                                '<?php echo $fecha; ?>', 
                                '<?php echo $data->tipo_asistencia; ?>', 
                                '<?php echo $data->retardo; ?>', 
                                '<?php echo $data->permiso; ?>', 
                                '<?php echo $data->captura; ?>', 
                                )" data-toggle="tooltip" data-placement="bottom"
                                        title="Detalle de las horas de entrada">
                                        <?= $data->tipo_asistencia; ?>
                                    </a>
                                </td>
                            <?php else: ?>
                                <td
                                    style="background-color: #00a65a; color: #f1f1f1; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <a href="#!" onclick="help(event, 
                                '<?php echo $data->id; ?>', 
                                '<?php echo $data->hora; ?>', 
                                '<?php echo $fecha; ?>', 
                                '<?php echo $data->tipo_asistencia; ?>', 
                                '<?php echo $data->retardo; ?>', 
                                '<?php echo $data->permiso; ?>', 
                                '<?php echo $data->captura; ?>', 
                                )" ' data-toggle="tooltip"  data-placement="bottom"
                                                    title="Detalle de las horas de entrada">
                                                    <?= $data->tipo_asistencia; ?>
                                                </a>
                                            </td>
                                    <?php endif; ?>

                                    <td>
                                        <?= $data->hora; ?>
                                    </td>
                                    <td>
                                        <?= $fecha; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="#" data-toggle="tooltip"  data-placement="bottom" 
                                                title="Detalle de la captura de entrada" onclick="mostrarImagen(' <?php echo base_url("/prueb_asist/$foto"); ?>')">
                                    <img src="<?php echo base_url("/prueb_asist/$foto"); ?>" alt="img"
                                        class='rounded-Thumbnail img-fluid'
                                        style='width: 40px; height: 20px; object-fit: cover;'>
                                </a>
                            </td>
                            <td> <a href="#!" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Editar captura de hora de entrada" onclick="editC(event, 
                                 '<?php echo $data->id; ?>', 

                                 )"><i class="fas fa-edit" style="color: blue;"></i></a> </td>
                        </tr>
                        <?php $numero++; endforeach; ?>
                </table>
            <?php endif; ?>



            <?php if (empty($hist) || $hist == NULL):
                ?>

            <?php else:
                date_default_timezone_set('America/Mexico_City');
                setlocale(LC_TIME, "spanish");
                $fecha1 = strftime("%d/%B/%Y", strtotime($inicio));
                $fecha2 = strftime("%d/%B/%Y", strtotime($fin));
                ?>

                <style>
                    #btns {
                        display: none;
                    }

                    #headT {
                        display: none;
                    }
                </style>
                <div id="impresion">
                    <center>
                        <h4> Historial de horas del <strong>
                                <?= $fecha1 . " al " . $fecha2 ?> de
                                <?= session('nombre'); ?>
                            </strong>
                            <br>
                        </h4>
                    </center>
                    <table>
                        <tr style="font-weight:bold;">
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Tipo</th>
                            <th style="text-align: center;">Hora</th>
                            <th style="text-align: center;">Fecha</th>
                            <th style="text-align: center;">Captura</td>

                        </tr>
                        <?php foreach ($hist as $historial):
                            date_default_timezone_set('America/Mexico_City');
                            setlocale(LC_TIME, "spanish");
                            $fecha = strftime("%d/%B/%Y", strtotime($historial->fecha));
                            $foto = $historial->captura;
                            ?>
                            <tr style="text-align: center;">
                                <td>
                                    <?= $numero3; ?>
                                </td>
                                <td
                                    style="background-color: #00a65a; color: #f1f1f1; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <?= $historial->tipo_asistencia; ?>
                                </td>
                                <td>
                                    <?= $historial->hora; ?>
                                </td>
                                <td>
                                    <?= $fecha; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="#" onclick="mostrarImagen('<?php echo base_url("/prueb_asist/$foto"); ?>')">
                                        <img src="<?php echo base_url("/prueb_asist/$foto"); ?>" alt="img"
                                            class='rounded-Thumbnail img-fluid'
                                            style='width: 40px; height: 20px; object-fit: cover;'>
                                    </a>
                                </td>

                            </tr>
                            <?php $numero3++; endforeach; ?>
                    </table>
                    <br>
                    <a href="<?php echo base_url('home/analysis/'); ?>" class="btn btn-outline-info btn-md">Retroceder</a>
                    <button onclick="imprimirSeccion()" class="btn btn-outline-success btn-md"
                        style="float: right;">Imprimir historial</button>
                    <br>
                </div>

            <?php endif; ?>

        </div><!--FIN PRIMER SECCION-->

        <?php if (empty($entrada)): ?> <!--IF PARA BUSQUEDA DE HISTORIAL-->

        <?php else: ?>

            <div class="card-body" id="salidaSection" style="display: none;">
            
                <?php if (empty($salida)): ?>
                    <div class="alert alert-danger" style="text-align: center;">No se han registrado salidas,
                        <?= session('nombre'); ?> &#128516;
                    </div>
                <?php else: ?>
                    <table>
                        <tr style="font-weight:bold;">
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Tipo</th>
                            <th style="text-align: center;">Hora</th>
                            <th style="text-align: center;">Fecha</th>
                            <th style="text-align: center;">Captura</th>
                            <th style="text-align: center;">Editar</th>
                        </tr>
                        <?php foreach ($salida as $data):
                            date_default_timezone_set('America/Mexico_City');
                            setlocale(LC_TIME, "spanish");
                            $fecha = strftime("%d/%B/%Y", strtotime($data->fecha));
                            $foto = $data->captura;
                            ?>
                            <tr style="text-align: center;">
                                <td>
                                    <?= $numero2; ?>
                                </td>
                                <td
                                    style="text-decoration: underline; text-align: center;">
                                    <?= $data->tipo_asistencia; ?>
                                </td>
                                <td>
                                    <?= $data->hora; ?>
                                </td>
                                <td>
                                    <?= $fecha; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="#" onclick="mostrarImagen('<?php echo base_url("/prueb_salid/$foto"); ?>')">
                                        <img src="<?php echo base_url("/prueb_salid/$foto"); ?>" alt="img"
                                            class='rounded-Thumbnail img-fluid'
                                            style='width: 40px; height: 20px; object-fit: cover;'>
                                    </a>
                                </td>

                                <td> <a href="#!" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                        title="Editar captura de hora de entrada" onclick="editC(event, 
                                 '<?php echo $data->id; ?>', 

                                 )"><i class="fas fa-edit" style="color: blue;"></i></a> </td>
                            </tr>
                            <?php $numero2++; endforeach; ?>
                    <?php endif; ?>
                </table>
            </div><!--FIN SEGUNDA SECCION-->

        <?php endif; ?>
        <!--
            <div class="card-body text-center">
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>-->
    </div>
</div>




<?= $this->include('colaboradores/footer') ?>