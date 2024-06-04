<?= $this->include('comercial/administracionGeneral/header') ?>
<?php 
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$in = strftime("%d/%B/%Y", strtotime($inicio));
$fn = strftime("%d/%B/%Y", strtotime($fin));
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">


<div class="info-card vertical">
    <h4 class="title-wish"><a href="<?php echo base_url("home/board/$año/$mes/$estado/$inicio/$fin"); ?>">
            <?= $nombreB; ?> >
        </a>
        <?= $in . " a " . $fn; ?> <i class="fas fa-university"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;' title="Acciones"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones">

            <a href='#' onclick='bono(event)' class='dropdown-item'>
                <i class='fas fa-hand-holding-usd' style=" color: #3498db;"></i> Bonos/Comisión extras
            </a>
            <?php
            foreach ($periodos as $periodo):
                $fecha_inic = $periodo->fecha_inicio_quincena;
                $fecha_fin = $periodo->fecha_fin_quincena;
                ?>

            <?php endforeach;
            ?>
            <a href='<?php echo base_url("home/aprov/$año/$mes/$nombreB/$estado/$fecha_inic/$fecha_fin"); ?>'
                    class='dropdown-item'>
                    <i class='fas fa-check' style=" color: #3498db;"></i> Aprobar periodo
            </a>
            <!-- <a href='#' class='dropdown-item'>
                <i class='fas fa-user-clock' style=" color: #3498db;"></i> Registrar ausencia
            </a>
            <a href='#' class='dropdown-item'>
                <i class='far fa-clock' style=" color: #3498db;"></i> Horas no trabajadas
            </a>

            <a href='#' class='dropdown-item'>
                <i class='fas fa-hospital' style=" color: #3498db;"></i> IMSS
            </a>
-->
        </div>

    </h4>
    <br>
    <div class="line"> </div>
    <div class="search-box">
        <input type="text" id="search1" oninput="filterTable1()" placeholder="Escriba para buscar por colaborador">
    </div>

    <table id="periodos-table1">
        <tbody>
            <tr style="font-weight:bold;">
                <td>Nombre</td>
                <td>Área</td>
                <td>Sueldo </td>
                <td>Quincena</td>
                <td>Sueldo por día</td>
                <td>Inicio quincena</td>
                <td>Fin quincena</td>
                <td>Días trabajados</td>
                <td>Total</td>
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
                        <?= $nomcp; ?>
                    </td>
                    <td>
                        <?= $periodo->descripcion; ?>
                    </td>
                    <td>$
                        <?= $periodo->pago_mensual_base; ?>.00
                    </td>
                    <td>$
                        <?= $periodo->sueldo_quincenal_total; ?>.00
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
                    <td>
                        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
                            title="Acciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-caret-down'></i>
                        </button>
                        <div class="dropdown-menu acciones">
                            <a href='' class='dropdown-item'
                                onclick='confirmAction(event, <?php echo $periodo->id_periodo; ?>)'>
                                <i class='fas fa-trash' style=" color: #3498db;"></i> Eliminar del periodo
                            </a>
                            <a href='' class='dropdown-item' onclick="editHistorico(event, 
                                '<?php echo $periodo->id_periodo; ?>',
                                '<?php echo $nomcp; ?>',
                                '<?php echo $periodo->pago_mensual_base; ?>',
                                '<?php echo $periodo->sueldo_quincenal_total; ?>',
                                '<?php echo $periodo->sueldo_diario; ?>',
                                '<?php echo $periodo->fecha_inicio_quincena; ?>',
                                '<?php echo $periodo->fecha_fin_quincena; ?>',
                                '<?php echo $periodo->dias_trabajados; ?>',
                                '<?php echo $periodo->home_office; ?>',//
                                '<?php echo $periodo->pago_dia_extra; ?>',//
                                '<?php echo $periodo->pago_bono_extra; ?>',//
                                '<?php echo $periodo->comision_extra; ?>',//
                                )">
                                <i class='fas fa-edit' style=" color: #3498db;"></i> Editar historico
                            </a>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <div class="alert alert-danger" id="mensaje-sin-periodo1" style="display: none;text-align: center;"> <i
            class="fa fa-exclamation-circle"></i> Sin colaborador en nómina disponible </div>
    <a href="<?php echo base_url("home/board/$año/$mes/$estado/$inicio/$fin"); ?>"
        class="ver-periodo-btn1">Retroceder</a>
</div>

<script>

    function bono(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '<i class="fas fa-hand-holding-usd" style=" color: #3498db;"></i> Bonos/Comisión extras',
            html:
                `<form id="formReq"  method="post" action="<?php echo base_url('/home/periods/saveExtras'); ?>">
                <td>
                    Colaborador:
                </td>
               
                    <td>
                    <input type="hidden" name="periodo" class="form-control" value ="<?= $año ?>" style="text-align: center;" required>
                    <input type="hidden" name="mes" class="form-control" value ="<?= $mes ?>" style="text-align: center;" required>
                    <input type="hidden" name="nombre_b" class="form-control" value ="<?= $nombreB ?>" style="text-align: center;" required>
                    <input type="hidden" name="estado" class="form-control" value ="<?= $estado ?>" style="text-align: center;" required>
                    <input type="hidden" name="inicio" class="form-control" value ="<?= $inicio ?>" style="text-align: center;" required>
                    <input type="hidden" name="fin" class="form-control" value ="<?= $fin ?>" style="text-align: center;" required>
                    <select name="id_nomina" class="form-control" id="id_nomina">
                    <?php foreach ($periodos as $data): ?>
                                            <option value="<?php echo $data->id_nomina; ?>">
                                                <?php echo $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno; ?>
                                            </option>
                    <?php endforeach; ?>
                     </select>
                    </td>
               
                <td>
                <i class='fas fa-building' style=" color: #3498db;"></i> Home Office
                </td>
                <td>
                    <input type="text" name="home_office" id = "home_office" class="form-control" value ="0" style="text-align: center;" required>
                </td>
                <td>
                <i class='fas fa-plus' style=" color: #3498db;"></i> Número de días extras:
                </td>
                <td>
                    <input type="number" name="dias_extras" id = "dias_extras" class="form-control"  value ="0"style="text-align: center;" required>
                </td>
                <td>
                <i class='fas fa-plus' style=" color: #3498db;"></i> Pago por día extra:
                </td>
                <td>
                    <input type="number" name="pago_dia_extra"  id = "pago_dia_extra" class="form-control"value ="0" style="text-align: center;" required>
                </td>
                <td>
                <i class='fas fa-plus' style=" color: #3498db;"></i> Concepto bono extra
                </td>
                <td>
                    <input type="text" name="bono_extra" id = "bono_extra" class="form-control" value ="---" style="text-align: center;" required>
                </td>
                <td>
                <i class='fas fa-plus' style=" color: #3498db;"></i> Pago bono extra
                </td>
                <td>
                    <input type="number" name="pago_bono_extra" id = "pago_bono_extra" class="form-control" value ="0" style="text-align: center;" required>
                </td>
                <td>
                <i class='fas fa-plus' style=" color: #3498db;"></i>   Comision extra
                </td>
                <td>
                    <input type="number" name="comision_extra" id = "comision_extra" class="form-control" value ="0" style="text-align: center;" required>
                </td>
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
    function editHistorico(event, id_periodo, nombre, sueldo, quincena, diario, in_quin, fin_quin, trabajados, home, dia_ext, bon_ex, com_ex) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '<img src="<?php echo base_url("login/img/log_turing.webp"); ?>" alt="logo_turing" width="110px" height="100px"><br> Usted está editando el histórico ',

            html:
                `<form id="formEditarHorario" method="post" action="<?php echo base_url('/home/periods/guardarCambios'); ?>" enctype="multipart/form-data">
                <td>
                    Nombre colaborador:
                </td>
                <td>
                    <input type="text" name="nombre_docente" value=" ${nombre} " class="form-control" readonly style="text-align: center;">
                    <input type="hidden" name="id_periodo" class="form-control" value="${id_periodo}">
                    <input type="hidden" name="año" class="form-control" value="<?= $año; ?>">
                    <input type="hidden" name="mes" class="form-control" value="<?= $mes; ?>">
                    <input type="hidden" name="n_banco" class="form-control" value="<?= $nombreB; ?>">
                    <input type="hidden" name="estado" class="form-control" value="<?= $estado; ?>">
                    <input type="hidden" name="inicio" class="form-control" value="<?= $inicio; ?>">
                    <input type="hidden" name="fin" class="form-control" value="<?= $fin; ?>">
                </td>

                <td>    
                    Sueldo:
                </td>
                <td>
                    <input type="text" name="sueldo_base" value ="${sueldo}" class="form-control">
                </td>

                <td>    
                    Monto quincena
                </td>
                <td>
                    <input type="text" name="monto_quincena" value ="${quincena}" class="form-control">
                </td>
                       
                <td>    
                    Fecha inicio quincena:
                </td>
                <td>
                    <input type="date" name="fecha_inicio" value ="${in_quin}" class="form-control">
                </td>

                <td>    
                    Fecha fin quincena:
                </td>
                <td>
                    <input type="date" name="fecha_fin" value ="${fin_quin}" class="form-control">
                </td>

                <td>    
                    Dias trabajados
                </td>
                <td>
                    <input type="text" name="trabajados" value ="${trabajados}" class="form-control">
                </td>
                
                <td>    
                   Home Office
                </td>
                <td>
                    <input type="text" name="home_office" value ="${home}" class="form-control">
                </td>

                <td>    
                   Pago dia extra
                </td>
                <td>
                    <input type="text" name="p_dia_extra" value ="${dia_ext}" class="form-control">
                </td>

                <td>    
                  Pago bono extra
                </td>
                <td>
                    <input type="text" name="bon_extra" value ="${bon_ex}" class="form-control">
                </td>

                <td>    
                  Pago comision extra
                </td>
                <td>
                    <input type="text" name="com_extra" value ="${com_ex}" class="form-control">
                </td>
                
            </form>`,
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                /*const url = ``;
                window.location.href = url;*/
                const form = document.getElementById('formEditarHorario');
                form.submit();
                /*const nombre = document.getElementById('nombre').value;
                const apellido = document.getElementById('apellido').value;*/
            }
        });
    }
</script>

<script>
    function confirmAction(event, id_periodo) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el colaborador y toda la información correspondiente asociada a este periodo. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/periods/delete/'); ?>${id_periodo}/`;
                window.location.href = url;
            }
        });
    }
</script>
<?= $this->include('comercial/administracionGeneral/footer') ?>


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