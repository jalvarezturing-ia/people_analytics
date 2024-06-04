<?= $this->include('colaboradores/header') ?>

<?php $numero = 1;?>
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
<h4 class="title-wish"> <a href="<?php echo base_url('/home/index/overtimes');?>">Nóminas | </a>  Histórico de colaboradores  <i class="fas fa-calendar-alt" style="color: #4070f4;"></i></h4>
    <div class="line"> </div>
    <?php if (empty($periodos)) { ?>

        <div class="alert alert-danger" style="text-align: center;">AÚN NO TIENES PERIODOS EN LISTA </div>
    <?php } else { ?>
        <table id="periodos-table1">
            <tbody>
            <tr style="font-weight:bold;">
                    <th></th>
                    <th>Nombre</th>
                    <th>Banco</th>
                    <th>Sueldo quincena</th>
                    <th>Inicio quincena</th>
                    <th>Fin quincena</th>
                    <th>Días trabajados</th>
                    <th><a href="#" >Estado</a> <i class="fas fa-question"  onclick="help(event)"></i> </th>
                    <th>Menú</th>
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
                            <?= $periodo->sueldo_quincenal_total; ?>.00
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
                       
                        <td>
                            <?php if ($periodo->firmado == "NO"): ?>
                                <a href="#" onclick="firmar(event, 
                                '<?php echo $periodo->id_periodo; ?>', 
                                '<?php echo  $fecha_inic; ?>',
                                '<?php echo  $fecha_fin; ?>',
                                '<?php echo  $periodo->pago_mensual_base; ?>',
                                '<?php echo  $periodo->sueldo_diario; ?>',
                                '<?php echo  $periodo->sueldo_quincenal_total; ?>',
                                '<?php echo  $periodo->home_office; ?>',
                                '<?php echo  $periodo->pago_dia_extra; ?>',
                                '<?php echo  $periodo->pago_bono_extra; ?>',
                                '<?php echo  $periodo->comision_extra; ?>',
                                )">
                                <span class="status-circle1"></span> No firmado</a>
                            <?php else: ?>
                                <a href="#"><span class="status-circle"></span> Firmado</a>
                            <?php endif; ?>
                        </td>
                        <td>

                            <?php if ($periodo->firmado == "NO"): ?>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
                                    title="Acciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href='<?php echo base_url("home/index/receipt/$periodo->id_periodo");?>' class='dropdown-item'>
                                        <i class='fas fa-edit' style=" color: #3498db;"></i> Necesitas firmar
                                    </a>
                                </div>
                            <?php else: ?>
                                <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
                                    title="Acciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='fas fa-caret-down'></i>
                                </button>
                                <div class="dropdown-menu acciones">
                                    <a href='<?php echo base_url("home/index/receipt/$periodo->id_periodo");?>' class='dropdown-item'>
                                        <i class='fas fa-print' style=" color: #3498db;"></i> Imprimir Recibo
                                    </a>
                                </div>
                            <?php endif; ?>


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







<script>

    function firmar(event, id_periodo, inicio, fin, mensual, diario, quincenal, office, dia_extra, bono_extra, comision) {
        event.preventDefault();
        Swal.fire({
            title: '<img src="<?php echo base_url("login/img/log_turing.webp"); ?>" alt="logo_turing" width="110px" height="100px"><br> TURING INTELIGENCIA ARTIFICIAL S.A.S',
            html:
                `
                <p style="text-align:center;" id="ptext">DOCUMENTO DE RECIBO DE NÓMINA</p>
                <div style="margin-left: 15px; margin-right: 15px; ">
            <p style="text-align:justify;" id="ptext">
            <br>
            Por medio de la presente le comunico que por así convenir a mis intereses a la fecha de firma del presente
            documento doy por firmado voluntariamente mi recibo junto con la relación de trabajo que me liga a usted.
            <br>
             </p>
             </div>
                <form id="formReq"  method="post" action="<?php echo base_url('/home/index/saveFirma'); ?>">
                <!---->    
                <td>
                    <i class='fas fa-building' style=" color: #3498db;"></i> Sueldo mensual
                </td>
                <td>
                    <input type="hidden" name="id_periodo" id = "id_periodo" class="form-control" value="${id_periodo}"style="text-align: center;" >
                    <input type="text" name="home_office" id = "home_office" class="form-control" value="${mensual}"style="text-align: center;" readonly>
                </td>
                <!---->    
                <td>
                    <i class='fas fa-building' style=" color: #3498db;"></i> Sueldo diario
                </td>
                <td>
                    <input type="text" name="home_office" id = "home_office" class="form-control" value="${diario}" style="text-align: center;" readonly>
                </td>
                <!---->  
                <td>
                    <i class='fas fa-building' style=" color: #3498db;"></i> Fecha Inicio Quincena
                </td>
                <td>
                    <input type="text" name="home_office" id = "home_office" class="form-control" value="${inicio}" style="text-align: center;" readonly>
                </td>
                <!---->  

                <td>
                    <i class='fas fa-building' style=" color: #3498db;"></i> Fecha Fin Quincena
                </td>
                <td>
                    <input type="text" name="home_office" id = "home_office" class="form-control"  value="${fin}"style="text-align: center;" readonly>
                </td>
                <!---->  
                          
                <td>
                <i class='fas fa-building' style=" color: #3498db;"></i> Home Office
                </td>
                <td>
                    <input type="text" name="home_office" id = "home_office" class="form-control" value="${office}" style="text-align: center;" readonly>
                </td>
                <td>
                <i class="fas fa-hand-holding-usd" style=" color: #3498db;"></i> Pago por día extra:
                </td>
                <td>
                    <input type="number" name="pago_dia_extra"  id = "pago_dia_extra" value="${dia_extra}" class="form-control" style="text-align: center;" readonly>
                </td>
                <td>
                <i class="fas fa-hand-holding-usd" style=" color: #3498db;"></i> Pago bono extra
                </td>
                <td>
                    <input type="number" name="pago_bono_extra" id = "pago_bono_extra" value="${bono_extra}" class="form-control"  style="text-align: center;" readonly>
                </td>
                <td>
                <i class="fas fa-hand-holding-usd" style=" color: #3498db;"></i>   Comision extra
                </td>
                <td>
                    <input type="number" name="comision_extra" id = "comision_extra" class="form-control" value="${comision}" style="text-align: center;" readonly>
                </td>
                <td>
                <i class="fas fa-hand-holding-usd" style=" color: #3498db;"></i>  QUINCENA TOTAL:
                </td>
                <td>
                    <input type="number" name="comision_extra" id = "comision_extra" class="form-control" value="${quincenal}" style="text-align: center;" readonly>
                </td>
               <br><br> 
<!--FIRMA-->
                <td>
                <i class="fas fa-hand-holding-usd" style=" color: #3498db;"></i>  Firma del colaborador:
                </td>
                <td>
                    <input type="text" name="firma" id = "firma" class="form-control" placeholder="Introduce tu nombre completo por favor" style="text-align: center;" required >
                </td>
<!--FIRMA-->
                </form>`,
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const form = document.getElementById('formReq');
                form.submit();

            }
        });
    }

</script>


<script>
    function help(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Qué es el estado?',
            text: 'Los que son boton verde son los firmados, aceptados, y los de boton rojo, los que son pendientes de firmar.',
            icon: 'question',
            confirmButtonColor: '#1371C7',
            confirmButtonText: "¡Gracias por la información!",
        });
    }
</script>


<?= $this->include('colaboradores/footer') ?>



<?php
$session = session();
$error_message = $session->getFlashdata('error_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "error",';
    echo '    title: "Error",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Ok",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
$error_message = $session->getFlashdata('sucess_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "success",';
    echo '    title: "Éxito",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Ok",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
?>