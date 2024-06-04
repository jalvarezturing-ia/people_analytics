<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<?php $number = 1; ?>
<?php $number5 = 1; ?>
<?php $number6 = 1; ?>
<?php $number7 = 1; ?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
</head>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/attendance"); ?>">Asistencia ></a> Análisis de
        asistencias <i class="fas fa-chart-bar"></i></h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-check-circle" style="color: #3498db;"></i> Registro de hora de entrada y
                salida</strong>
            <br><br>
            <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('entrada')" id="pendientesBtn"> <i
                    class="fas fa-check-circle"></i> Check in
            </a>|
            <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('salida')" id="pagadosBtn"> <i
                    class="fas fa-sign-out-alt"></i> Check out </a>
        </div>

       <!----> 
        <div class="card-body" id="pendientesSection">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="card-box bg-green">
                            <div class="inner">
                                <h3><a href="#!" onclick="mostrarSeccion('asistencia')">Con asistencia - <?= $fecha; ?>
                                       
                                    </a> </h3>
                                <p> <a href="#!" onclick="mostrarSeccion('asistencia')"><?= $tentrada; ?> colaboradores marcaron asistencia</a> 
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle" aria-hidden="true"></i>
                            </div>
                            <a href="#!" class="card-box-footer" id="pendientesBtn1"><i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="card-box bg-red">
                            <div class="inner">
                                <h3> <a href="#!" onclick="mostrarSeccion('noasistencia')">Sin asistencia - <?= $fecha; ?>
                                        
                                    </a> </h3>
                                <p> <a href="#!" onclick="mostrarSeccion('noasistencia')"><?= $tnoentrada; ?> colaboradores no han marcado asistencia</a> 
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </div>
                            <a href="#!" class="card-box-footer" id="pendientesBtn2"><i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
        </div><!--FIN PRIMER SECCION-->
        <div class="card-body" id="asistenciaSection" style="overflow-y: auto; max-height: 300px;">
                <table class="green-border-table">
                    <tr>
                        <td colspan="6">
                            <center>
                                <h4><i class="fas fa-check-circle" style="color: green;"></i> Registro de hora de entrada
                                </h4>
                            </center>
                        </td>
                    </tr>
                    

                    <tr style="font-weight:bold;">
                        <td>#</td>
                        <td>Colaborador</td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Hora</td>
                        <td style="text-align: center;">Fecha</td>
                        <td style="text-align: center;">Captura</td>
                        <td style="text-align: center;">Editar</td>
                    </tr>
                   
                    <?php foreach ($lista as $dataa):
                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");
                        $fecha = strftime("%d/%B/%Y", strtotime($dataa->fecha_marcados));
                        $foto = $dataa->captura_marcados;
                        ?>
                        <?php if (!empty($dataa->nombre_marcados)): ?>
                            <tr>
                                <td>
                                    <?= $number5; ?>
                                </td>
                                <td>
                                    <?= $dataa->nombre_marcados . " " . $dataa->apellido_paterno_marcados; ?>
                                </td>
                                <td
                                    style="background-color: #00a65a; color: #f1f1f1; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <a href="#">Entrada</a>
                                </td>
                                <td style="text-align: center;">
                                    <?= $dataa->hora_marcados; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?= $fecha; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="#" onclick="mostrarImagen('<?php echo base_url("/prueb_asist/$foto"); ?>')">
                                        <img src="<?php echo base_url("/prueb_asist/$foto"); ?>" alt="img"
                                            class='rounded-Thumbnail img-fluid'
                                            style='width: 40px; height: 20px; object-fit: cover;'>
                                    </a>
                                </td>
                                <td style="text-align: center;"><a href="#!" onclick="editHora(event,
                                 '<?php echo $dataa->id_asis_marcados; ?>', 
                                 '<?php echo $dataa->nombre_marcados; ?>', 
                                 '<?php echo $dataa->apellido_paterno_marcados; ?>', 
                                 '<?php echo $dataa->hora_marcados; ?>', 
                                 '<?php echo $dataa->fecha_marcados; ?>', 
                                 '<?php echo $dataa->captura_marcados; ?>', 
                                 '<?php echo $salida = 'Entrada' ?>', 
                                 )"><i class="fas fa-edit" style="color:blue;"></i></a></td>

                            </tr>
                            <?php $number5++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
               
                </table>
        </div>
        <div class="card-body" id="NoasistenciaSection" style="display: none; overflow-y: auto; max-height: 300px;">
                <table class="red-border-table" >
                    <tr>
                        <td colspan="6">
                            <center>
                                <h4><i class="fas fa-times" style="color: red;"></i> Registro de hora sin asistencia
                                </h4>
                            </center>
                        </td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td>#</td>
                        <td>Colaborador</td>
                        <td style="text-align: center;">Estado</td>
                        
                    </tr>
                    <?php foreach ($lista as $data1):
                        ?>
                        <?php if (!empty($data1->nombre_no_marcados)): ?>
                            <tr>
                                <td>
                                    <?= $number; ?>
                                </td>
                                <td>
                                    <?= $data1->nombre_no_marcados . " " . $data1->apellido_paterno_no_marcados; ?>
                                </td>
                                <td
                                    style="background-color: #d9534f; color: #f1f1f1; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <a href="#!" onclick="crear(event,
                                     '<?php echo $data1->id_no_marcados; ?>', 
                                     '<?php echo $data1->nombre_no_marcados; ?>', 
                                     '<?php echo $data1->apellido_paterno_no_marcados; ?>', 
                                     )" >Crear</a>
                                </td>
                                
                            </tr>
                            <?php $number++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
        </div> <!--FIN CONTENIDO PRIMER SECCION-->
        <!----> 

         <!----> 
        <div class="card-body" id="pagadosSection" style="display: none; ">
            <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="card-box bg-green">
                            <div class="inner">
                                <h3><a href="#!" onclick="mostrarSeccion('salida')">Con salida - <?= $fecha1; ?>
                                    </a> </h3>
                                <p> <?= $tsalida; ?> colaboradores marcaron salida
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle" aria-hidden="true"></i>
                            </div>
                            <a href="#!" class="card-box-footer" id="pendientesBtn1"><i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="card-box bg-red">
                            <div class="inner">
                                <h3> <a href="#!" onclick="mostrarSeccion('nosalida')">Sin salida - <?= $fecha1; ?>
                                    </a> </h3>
                                <p> <?= $tnosalida; ?>
                                   colaboradores no han marcado salida
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </div>
                            <a href="#!" class="card-box-footer" id="pendientesBtn2"><i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
            </div>
        </div><!--FIN SEGUNDA SECCION-->

        <div class="card-body" id="salidaSection" style="display: none; overflow-y: auto; max-height: 300px;">
            <table class="green-border-table">
            <tr>
                <td colspan="6">
                     <center>
                         <h4><i class="fas fa-sign-out-alt" style="color: green;"></i> Registro de hora de salida
                            </h4>
                    </center>
                </td>
            </tr>
            <tr style="font-weight:bold;">
                        <td>#</td>
                        <td>Colaborador</td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Hora</td>
                        <td style="text-align: center;">Fecha</td>
                        <td style="text-align: center;">Captura</td>
                        <td style="text-align: center;">Editar</td>
            </tr>

            <?php foreach ($listasalidas as $dataaa):
                        date_default_timezone_set('America/Mexico_City');
                        setlocale(LC_TIME, "spanish");
                        $fecha = strftime("%d/%B/%Y", strtotime($dataaa->fecha_marcados));
                        $foto = $dataaa->captura_marcados;
                        ?>
                        <?php if (!empty($dataaa->nombre_marcados)): ?>
                            <tr>
                                <td>
                                    <?= $number6; ?>
                                </td>
                                <td>
                                    <?= $dataaa->nombre_marcados . " " . $dataaa->apellido_paterno_marcados; ?>
                                </td>
                                <td
                                    style="background-color: #d9534f; color: #f1f1f1; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <a href="#">Salida</a>
                                </td>
                                <td style="text-align: center;">
                                    <?= $dataaa->hora_marcados; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?= $fecha; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="#" onclick="mostrarImagen('<?php echo base_url("/prueb_salid/$foto"); ?>')">
                                        <img src="<?php echo base_url("/prueb_salid/$foto"); ?>" alt="img"
                                            class='rounded-Thumbnail img-fluid'
                                            style='width: 40px; height: 20px; object-fit: cover;'>
                                    </a>
                                </td>
                                <td style="text-align: center;"><a href="#!" onclick="editHora(event,
                                 '<?php echo $dataaa->id_asis_marcados; ?>', 
                                 '<?php echo $dataaa->nombre_marcados; ?>', 
                                 '<?php echo $dataaa->apellido_paterno_marcados; ?>', 
                                 '<?php echo $dataaa->hora_marcados; ?>', 
                                 '<?php echo $dataaa->fecha_marcados; ?>', 
                                 '<?php echo $dataaa->captura_marcados; ?>', 
                                 '<?php echo $salida = 'Salida' ?>', 
                                 )"><i class="fas fa-edit" style="color:blue;"></i></a></td>
                            </tr>
                            <?php $number6++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

            </table>
        </div>

        <div class="card-body" id="nosalidaSection" style="display: none; overflow-y: auto; max-height: 300px;">
        <table class="red-border-table" >
                    <tr>
                        <td colspan="6">
                            <center>
                                <h4><i class="fas fa-times" style="color: red;"></i> Registro de hora sin salida
                                </h4>
                            </center>
                        </td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td>#</td>
                        <td>Colaborador</td>
                        <td style="text-align: center;">Estado</td>
                        <td style="text-align: center;">Captura</td>
                    </tr>
                    <?php foreach ($listasalidas as $data1):
                        ?>
                        <?php if (!empty($data1->nombre_no_marcados)): ?>
                            <tr>
                                <td>
                                    <?= $number7; ?>
                                </td>
                                <td>
                                    <?= $data1->nombre_no_marcados . " " . $data1->apellido_paterno_no_marcados; ?>
                                </td>
                                <td
                                    style="background-color: #d9534f; color: #f1f1f1; font-weight:bold; text-decoration: underline; text-align: center;">
                                    <a href="#">Sin asistencia</a>
                                </td>
                                <td style="text-align: center;">----</td>
                            </tr>
                            <?php $number7++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
        </div> 
         <!----> 

    </div>
</div>



<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>





