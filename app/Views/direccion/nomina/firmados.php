<?= $this->include('direccion/header') ?>
<?php $numero = 1; ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">


<style>
    .status-circle1 {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        margin-left: 5px;
        /* Ajusta el margen según sea necesario */
    }

    .status-circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: green;
        border-radius: 50%;
        margin-left: 5px;
        /* Ajusta el margen según sea necesario */
    }
</style>
<div class="info-card vertical">
<h4 class="title-wish"> <i class="fas fa-calendar-alt" style="color: #3498db;"></i> Recibos firmados por colaboradores </h4>
    <br>
    <div class="line"> </div>
    <?php if (empty($periodos)) { ?>

        <div class="alert alert-danger" style="text-align: center;">AÚN NO EXISTEN RECIBOS FIRMADOS EN LISTA </div>
    <?php } else { ?>
        <table id="periodos-table1">
            <tbody>
            <tr style="font-weight:bold;">
                    <td></td>
                    <td>Nombre</td>
                    <td>Banco</td>
                    <td>Sueldo mensual</th>
                    <td>Sueldo diario</th>
                    <td>Inicio quincena</th>
                    <td>Fin quincena</th>
                    <td>Días trabajados</th>
                    <td>Total beneficios</th>
                    <td>Sueldo del periodo </th>
                    <td>Estado </td>
                    <td>Menú</td>
                </tr>

                <?php foreach ($periodos as $periodo):
                    $nombre = $periodo->nombre;
                    $ap = $periodo->apellido_paterno;

                    date_default_timezone_set('America/Mexico_City');
                    setlocale(LC_TIME, "spanish");

                    $nomcp = $nombre . " " . $ap;
                    $fecha_inic = strftime("%d/%B/%Y", strtotime($periodo->fecha_inicio_quincena));
                    $fecha_fin = strftime("%d/%B/%Y", strtotime($periodo->fecha_fin_quincena));



                    ?>
                    <tr>
                        <td>
                            <?= $numero; ?>
                        </td>
                        <td>
                            <?= $nomcp; ?>
                        </td>
                        <td>
                            <?= $periodo->nombre_banco; ?>
                        </td>
                        <td>$
                            <?= $periodo->pago_mensual_base; ?>.00
                        </td>

                        <td>$
                            <?= $periodo->sueldo_diario; ?>
                        </td>
                        <td>
                            <?= $fecha_inic; ?>
                        </td>
                        <td>
                            <?= $fecha_fin; ?>
                        </td>
                        <td>
                            <?= $periodo->dias_trabajados; ?> días
                        </td>
                        <td>$
                            <?= $periodo->sueldo_final_total; ?>.00
                        </td>
                        <td>$
                            <?= $periodo->sueldo_quincenal_total; ?>.00
                        </td>
                        <td>
                                <a href="#"><span class="status-circle"></span> Firmado</a>
                           
                        </td>
                        <td>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
                                    title="Acciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href='<?php echo base_url("home/index/receiptt/$periodo->id_periodo");?>' class='dropdown-item'>
                                        <i class='fas fa-print' style=" color: #3498db;"></i> Ver Recibo
                                    </a>
                                </div>


                        </td>

                    </tr>
                    <?php $numero++; endforeach; ?>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <div class="alert alert-danger" id="mensaje-sin-periodo1" style="display: none;text-align: center;"> <i
            class="fa fa-exclamation-circle"></i> Sin colaborador en nómina disponible </div>

</div>






<?= $this->include('direccion/footer') ?>
