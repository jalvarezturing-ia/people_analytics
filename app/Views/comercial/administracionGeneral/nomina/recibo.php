<?= $this->include('comercial/administracionGeneral/header') ?>
<?php 
$numero = 1;
?>
<style>
    img {
        display: block;
        margin: auto;
    }

    #ptext {
        color: black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;

    }

    #centerTh {
        text-align: center;
    }

    th {
        background-color: #FF0000 !important;
    }

    @media (max-width: 600px) {

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        th {

            font-size: 10.5px;
            color: #FFFFFF !important;

        }

        tr {
            margin-bottom: 15px;

        }

        td {
            border: none;
            border-bottom: 1px solid #ddd;
            font-size: 10.5px;

        }

        #ptext {
            font-size: 10.5px;
            text-align: center;
        }

        #firmaForm {

            font-size: 10.5px;
            text-align: center;

        }

        td:before {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }
    }
</style>


<div style="background-color: #F7F7F7;" id="miSeccion">
<!--<img src="<?php echo base_url("login/img/log_turing.webp"); ?>" alt="logo_turing" width="110px" height="100px">
    -->
    <h4 style="text-align:center;" id="ptext"> <strong>RECIBO DE PAGO DE NÓMINA #<?= $periodo ?></strong>
    </h4>

    <?php
    // Establecer el idioma a español
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_TIME, "spanish");

    // Obtener la fecha actual en español
    $fechaHoy = strftime("%d de %B de %Y");

    // Imprimir la fecha en tu párrafo
    /*echo '<p style="text-align:right;" id="ptext">27 de septiembre no. 127, San Jerónimo, C.P. 52170, Metepec, Estado de México, México., ' . $fechaHoy . '</p>';
    echo '<h5 style="text-align:center;">TURING INTELIGENCIA ARTIFICIAL S.A.S</h5>';
    echo '<p style="text-align:left;" id="ptext"><strong style="font-weight: bold;">R.F.C: </strong> TIA200629EA8 <br><strong style="font-weight: bold;">Rég: </strong> I.M.S.S. <br> <strong style="font-weight: bold;">Régimen:</strong> Sociedad por Acciones Simplificada</p>';*/

    ?>

<table>
        <thead>
            <th colspan="7" style="text-align:center;">DATOS DEL PATRÓN</th>
            <tr>
                <td> <img src="<?php echo base_url("login/img/log_turing.webp"); ?>" alt="logo_turing" width="110px" height="100px"></td>
                <td><strong style="text-align:center;">TURING INTELIGENCIA ARTIFICIAL S.A.S</strong> <br>
                <strong style="font-weight: bold;">R.F.C: </strong> TIA200629EA8 <br><strong style="font-weight: bold;">Rég: </strong> I.M.S.S. <br> <strong style="font-weight: bold;">Régimen:</strong> Sociedad por Acciones Simplificada <br>
                <strong style="font-weight: bold;">Dirección: </strong>27 de septiembre no. 127, San Jerónimo, C.P. 52170, Metepec, Estado de México, México., <?= $fechaHoy ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php foreach ($finiquito as $data):
        $fecha_in = strtoupper(strftime("%d/%B/%Y", strtotime($data->fecha_inicio_quincena)));
        $fecha_fin = strtoupper(strftime("%d/%B/%Y", strtotime($data->fecha_fin_quincena)));


    endforeach;
    ?>

    <div style="margin-left: 150px; margin-right: 150px; ">
        <p style="text-align:center;" id="ptext"><strong style="font-weight: bold;">PERIODO: QUINCENA DEL
                <?= $fecha_in . " AL " . $fecha_fin; ?>
            </strong></p>

        <hr>
    </div>

    <table>
        <thead>
            <th colspan="7" style="text-align:center;">DATOS DEL TRABAJADOR</th>
            <tr>
                <td style="text-align:center;"><strong>&nbsp;NOMBRE: </strong>
                    <?= strtoupper($data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;CURP: </strong> ??????? </td>
            </tr>
            <tr>
                <td style="text-align:center;"><strong>&nbsp;PUESTO: </strong>
                    <?= strtoupper($data->descripcion); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;RFC: </strong>???????</td>

            </tr>
            <tr>

                <td style="text-align:center;"><strong>&nbsp;BANCO: </strong>
                    <?= strtoupper($data->nombre_banco); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;IMSS: </strong>???????</td>

            </tr>
            <tr>
                <td style="text-align:center;"><strong>&nbsp;SUELDO BASE: </strong>$
                    <?= strtoupper($data->pago_mensual_base); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;SBC IMSS: </strong>???????</td>
            </tr>
        </thead>
    </table>

    <hr>
    <table>
        <thead>
            <th colspan="7" style="text-align:center;">INFORMACIÓN LABORAL</th>
            <tr>
                <td style="text-align:center;"><strong>&nbsp;SALARIO DIARIO: </strong> $
                    <?= strtoupper($data->sueldo_diario); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;DÍAS PAGADOS: </strong>
                    <?= strtoupper($data->dias_trabajados); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;SALARIO FINAL: </strong>$
                    <?= strtoupper($data->sueldo_final_total); ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;PERIODO: </strong>
                    <?= $fecha_in . " AL " . $fecha_fin; ?>
                </td>
            </tr>
        </thead>
    </table>
    <hr>
    <table>
        <thead>
            <th colspan="7" style="text-align:center;">INFORMACIÓN DE PAGO</th>
            <tr>
                <td style="text-align:center;"><strong>&nbsp;FECHA DE PAGO: </strong>
                    <?= $fecha_fin; ?>
                </td>
                <td style="text-align:center;"><strong>&nbsp;FORMA DE PAGO: </strong>TRANSFERENCIA ELÉCTRONICA</td>
                <td style="text-align:center;"><strong>&nbsp;EMISOR: </strong> ??????? </td>
            </tr>
        </thead>
    </table>
    <hr>


    <table>

        <tr>

            <th>CLAVE</th>
            <th>CONCEPTO</th>
            <th>IMPORTE</th>
            <th>CONCEPTO</th>
            <th>IMPORTE</th>
            <th style="text-align:center;">NETO PAGADO</th>

        </tr>
        <tr>
            <td>1</td>
            <td>SUELDO BASE</td>
            <td>$
                <?= strtoupper($data->pago_mensual_base); ?>.00
            </td>
            <td>SUELDO DEL COLABORADOR</td>
            <td>$
                <?= strtoupper($data->sueldo_final_total); ?>.00
            </td>
            <td style="text-align:center; font-weight:bold;">$
                <?= strtoupper($data->sueldo_final / 2); ?>.00
            </td>

        </tr>
        <tr>
            <td>2</td>
            <td>HOME OFFICE</td>
            <td>$
                <?= strtoupper($data->home_office); ?>.00
            </td>
            <td>AYUDA HOME OFFICE COLABORADOR</td>
            <td>$
                <?= strtoupper($data->home_office); ?>.00
            </td>
            <td style="text-align:center; font-weight:bold;">$
                <?= strtoupper($data->home_office / 2); ?>.00
            </td>

        </tr>
        <tr>
            <td>3</td>
            <td>DIAS EXTRA</td>
            <td>$
                <?= strtoupper($data->pago_dia_extra); ?>.00
            </td>
            <td>PAGO POR DIA EXTRA/FIN DE SEMANA</td>
            <td>$
                <?= strtoupper($data->pago_dia_extra); ?>.00
            </td>
            <td style="text-align:center; font-weight:bold;">$
                <?= strtoupper($data->pago_dia_extra); ?>.00
            </td>
        </tr>
        <tr>

            <td>4</td>
            <td>BONO EXTRA</td>
            <td>$
                <?= strtoupper($data->pago_bono_extra); ?>.00
            </td>
            <td>PAGO POR BONO EXTRA</td>
            <td>$
                <?= strtoupper($data->pago_bono_extra); ?>.00
            </td>
            <td style="text-align:center; font-weight:bold;">$
                <?= strtoupper($data->pago_bono_extra); ?>.00
            </td>

        </tr>
        <tr>
            <td>5</td>
            <td>COMISION EXTRA</td>
            <td>$
                <?= strtoupper($data->comision_extra); ?>.00
            </td>
            <td>PAGO POR COMISIÓN EXTRA</td>
            <td>$
                <?= strtoupper($data->comision_extra); ?>.00
            </td>
            <td style="text-align:center; font-weight:bold;">$
                <?= strtoupper($data->comision_extra); ?>.00
            </td>

        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th>TOTAL: $
                <?= strtoupper($data->sueldo_quincenal_total); ?>.00
            </th>
        </tr>

    </table>


    <style>
        input[type="checkbox"] {

            background-color: #fff;
            margin: 0;

            color: currentColor;
            width: 1.15em;
            height: 1.15em;
            border: 0.15em solid currentColor;
            border-radius: 0.15em;
            transform: translateY(-0.075em);
        }

        .firma-container {

            text-align: center;
        }

        .firma-center {
            float: center;
            text-align: center;
        }

        .ver-periodo-btn2 {
            color: #34db6c;
            /* Color del texto */
            background-color: #e1fedf;
            /* Color de fondo */
            padding: 8px 15px;
            /* Ajusta el espaciado interno */
            border-radius: 8px;
            /* Bordes redondeados */
            text-decoration: none;
            /* Sin subrayado */
            font-size: 14px;
            /* Tamaño del texto */
            transition: background-color 0.3s, color 0.3s;
            /* Transición suave del color de fondo y del texto */
            border: none;
            /* Quita el borde del botón */
            cursor: pointer;
            /* Cambia el cursor al pasar el mouse sobre el botón */
        }

        .ver-periodo-btn2:hover {
            background-color: #34db6c;
            /* Cambia el color de fondo al pasar el mouse */
            color: #e1fedf;
            /* Cambia el color del texto al pasar el mouse */
        }
    </style>

    <?php if (($data->firmado) == "NO"): ?>
        <form id="firmaForm" method="post" action="<?php echo base_url('/home/index/saveFirma'); ?>">


            <div class="card-header" style="text-align: center;">
                <strong> <i class="fas fa-edit" style="color: #3498db;"></i>FIRMAR DOCUMENTO</strong>
            </div>
            <hr>
            <div class="form-group row">

                <label for="total_uma" class="col-sm-3 col-form-label">NOMBRE COLABORADOR: <strong
                        style="color:red;">*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="nombre" value = "<?= strtoupper($data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno); ?>"  class="form-control"
                        placeholder="Introduce tu nombre completo por favor" style="text-align: center;" required>
                    <input type="hidden" name="id_periodo" id="id_periodo" class="form-control" value="<?= $periodo ?>"
                        style="text-align: center;">
                </div>
            </div>
            <div class="form-group row">
                <label for="total_uma" class="col-sm-4 col-form-label">ACEPTO PAGO RECIBO DE PAGO DE NÓMINA: <strong
                        style="color:red;">*</strong></label>
                <div class="col-sm-2">
                    <input type="checkbox" name="firma" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <a href="<?php echo base_url("home/index/overtimes"); ?>" class="ver-periodo-btn1">Retroceder</a>
                    <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                </div>
            </div>

        </form>

    <?php else: ?>
        <div class="firma-container">
            <div class="firma-center">
                <p><strong style="font-weight: bold;">EL TRABAJADOR</p></strong>

                <?php echo strtoupper($data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno); ?>
                <p>--------------------------------------------</p>
                <p><strong style="font-weight: bold;"> FIRMA DEL EMPLEADO</strong></p>
            </div>


            <hr style="clear: both;">
            <button onclick="imprimirSeccion()" class="ver-periodo-btn2">Imprimir Recibo</button>
        </div>
    <?php endif; ?>
</div>





<script>
    function imprimirSeccion() {
        var contenidoSeccion = document.getElementById('miSeccion').outerHTML;
        var nuevaVentana = window.open('', '_blank');
        var contenidoNuevoDocumento = '<html><head><title>Imprimir récibo</title>';

        // Copiar estilos asociados al elemento y agregar estilos adicionales
        var estilos = document.getElementById('miSeccion').style.cssText;
        contenidoNuevoDocumento += '<style>' + estilos + ' @media print { body { margin: 0; padding: 0; } }</style>';

        contenidoNuevoDocumento += '</head><body>' + contenidoSeccion + '</body></html>';

        nuevaVentana.document.write(contenidoNuevoDocumento);
        nuevaVentana.document.close();
        nuevaVentana.print();
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