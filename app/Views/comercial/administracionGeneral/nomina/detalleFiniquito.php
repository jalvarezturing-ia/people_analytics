<?= $this->include('comercial/administracionGeneral/header') ?>
<?php $numero = 1; ?>

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
            position: relative;
            padding-left: 50%;
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
<div style="background-color: #F7F7F7;">
    <img src="<?php echo base_url("login/img/log_turing.webp"); ?>" alt="logo_turing" width="110px" height="100px">
    <h4 style="text-align:center;"><strong>TURING INTELIGENCIA ARTIFICIAL S.A.S</strong></h4>
    <p style="text-align:center;" id="ptext"> <strong style="font-weight: bold;" > DOCUMENTO DE RECIBO DE PAGO</strong></p>
    <?php
    // Establecer el idioma a español
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_TIME, "spanish");

    // Obtener la fecha actual en español
    $fechaHoy = strftime("%d de %B de %Y");

    // Imprimir la fecha en tu párrafo
    echo '<p style="text-align:right;" id="ptext">Ciudad de México, ' . $fechaHoy . '</p>';
    ?>

    <?php foreach ($finiquito as $data):
        $fecha_ing = strftime("%d/%B/%Y", strtotime($data->fecha_ingreso));
        $fecha_eg = strftime("%d/%B/%Y", strtotime($data->fecha_egreso));

        $fecha_nueva_egreso = strftime("%d de %B de %Y", strtotime($data->fecha_egreso));

    endforeach;
    ?>


    <!--<p style="text-align:center;  font-weight:bold;" id="ptext">DECLARO ASI: <strong>"(CTRL + P PARA IMPRIMIR)"</strong></p>-->
    <div style="margin-left: 150px; margin-right: 150px; ">
        <p style="text-align:justify;" id="ptext">
            <br>
            Por medio de la presente le comunico que por así convenir a mis intereses a la fecha de firma del presente
            documento doy por terminado voluntariamente mi contrato y la relación de trabajo que me ligaba a usted,
            siendo el día <strong style="font-weight: bold;">
                <?= $fecha_nueva_egreso; ?>
            </strong> mi ultimo dia de trabajo con fundamento en la Fracción I del artículo 53
            de la Ley Federal del Trabajo.
            <br><br>

            Manifiesto expresamente que durante el tiempo que presente mis servicios, recibi el pago al que tuve
            derecho, que disfrute con goce de salario de los días de descanso obligatorios, así como al pago de todas y
            cada una de las prestaciones que conforme a la Ley Federal del Trabajo y mi contrato de trabajo tuve
            derecho.
            <br><br>

            Del mismo modo manifiesto que siempre labore en la jornada que venía especificada en mi contrato de trabajo,
            disfrutando siempre de al menos cuarenta y cinco minutos para reposar y tomar mis alimentos fuera del centro
            de trabajo, teniendo (dos) días de descanso (sabado y domingo), que jamas sufri a su servicio accidente ni
            enfermedad profesional alguno, por lo que no tengo nada que reclamar por ningún concepto.
        </p>
        <hr>

        <?php foreach ($finiquito as $data):
            $fecha_ing = strftime("%d/%B/%Y", strtotime($data->fecha_ingreso));
            $fecha_eg = strftime("%d/%B/%Y", strtotime($data->fecha_egreso));

            $fecha_nueva_egreso = strftime("%d de %B de %Y", strtotime($data->fecha_egreso));

            function numeroALetras($numero)
            {
                // Dividir la parte entera y la parte decimal
                $partes = explode('.', $numero);

                // Convertir la parte entera a letras
                $formato = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                $entero_en_letras = ucfirst(strtolower($formato->format($partes[0])));

                // Convertir la parte decimal a letras
                $decimal_en_letras = isset($partes[1]) ? ucfirst(strtolower($formato->format($partes[1]))) : '';

                // Construir la cadena resultante
                $monto_en_letras = $entero_en_letras . " PESOS";
                if (!empty($decimal_en_letras)) {
                    $monto_en_letras .= " CON $decimal_en_letras CENTAVOS";
                }

                return $monto_en_letras;
            }

            $monto_en_letras = numeroALetras($data->monto_finiquito);
            //echo strtoupper($monto_en_letras);
        

            ?>
            <table>
                <tr>
                    <th>FECHA INGRESO</th>
                    <td>
                        <?= $fecha_ing; ?>
                    </td>
                </tr>
                <tr>
                    <th>FECHA EGRESO</th>
                    <td>
                        <?= $fecha_eg; ?>
                    </td>
                </tr>
                <tr>
                    <th>DÍAS TRABAJADOS EN EL ÚLTIMO AÑO</th>
                    <td>
                        <?= $data->diferencia_dias; ?> DÍAS
                    </td>
                </tr>
                <th>SUELDO DIARIO</th>
                <td>
                    $
                    <?= $data->sueldo_diario; ?>
                </td>
                </tr>
                <tr>
                    <th>AGUINALDO</th>
                    <td> $
                        <?= $data->t_aguinaldo; ?>
                    </td>
                </tr>
                <tr>
                    <th>VACACIONES</th>
                    <td>
                        $
                        <?= $data->t_vacaciones; ?>
                    </td>
                </tr>
                <tr>
                    <th>PRIMA VACACIONAL</th>
                    <td>
                        $
                        <?= $data->total_pv; ?>

                    </td>
                </tr>
                <tr>
                    <th>SALARIOS PENDIENTES</th>
                    <td>
                        $
                        <?= $data->t_sp; ?>
                    </td>
                </tr>
                <!--<tr>
                    <th>PAGO MENSUAL</th>
                    <td>
                        $
                        <?= $data->pago_mensual_base; ?>.00
                    </td>
                </tr>-->
                <tr>

                <tr>
                    <th>MONTO TOTAL DEL FINIQUITO</th>
                    <td colspan="3">
                        $
                        <?= $data->monto_finiquito; ?>
                    </td>
                </tr>

            </table>

        <?php endforeach; ?>

        <p style="text-align:justify;" id="ptext">
            <br>
            Manifestado lo anterior confirmó que yo
            <?php echo strtoupper($data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno); ?>, he
            recibido al momento de firma del presente
            documento la cantidad de <strong style="font-weight: bold;">$
                <?= $data->monto_finiquito; ?> (
                <?php echo strtoupper($monto_en_letras); ?>)
            </strong> por concepto de finiquito por parte de <strong style="font-weight: bold;">TURING INTELIGENCIA
                ARTIFICIAL S.A.S. </strong>La cantidad
            anteriormente mencionada se constituye por los siguientes conceptos:
        </p>
        <hr>

        <table>
            <thead>
                <th colspan="7" style="text-align:center;">PROPORCIONAL DE VACACIONES</th>
                <tr>

                    <td style="text-align:center;"><strong>&nbsp;SALARIO DIARIO</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;DIAS ANUALES</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;FACTOR</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;1 AÑO</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;FACTOR</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;DIAS TRABAJADOS</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center;">$
                        <?= $data->sueldo_diario; ?>
                    </td>
                    <td style="text-align:center;">
                        <?= $data->dias_vacaciones; ?> DÍAS
                    </td>
                    <td style="text-align:center;">$
                        <?= $data->total_factor; ?>
                    </td>
                    <td style="text-align:center;">365</td>
                    <td style="text-align:center;">$
                        <?= $data->proporcional; ?>
                    </td>
                    <td style="text-align:center;">
                        <?= $data->diferencia_dias; ?> DÍAS
                    </td>
                </tr>
                <td colspan="7" style="text-align:center; font-weight: bold;">TOTAL $
                    <?= $data->t_vacaciones; ?>
                </td>
            </tbody>
        </table>
        <hr>

        <table>
            <thead>
                <th colspan="7" style="text-align:center;">PROPORCIONAL PRIMA VACACIONAL</th>
                <tr>

                    <td style="text-align:center;"><strong>&nbsp;PRIMA VACACIONAL</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;PROPORCIONAL DE VACACIONES</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center;">
                        <?= $data->legal; ?>%
                    </td>
                    <td style="text-align:center;">$
                        <?= $data->t_vacaciones; ?>
                    </td>
                </tr>
                <td colspan="7" style="text-align:center; font-weight: bold;">TOTAL $
                    <?= $data->total_pv; ?>
                </td>
            </tbody>
        </table>
        <hr>

        <table>
            <thead>
                <th colspan="7" style="text-align:center;">SALARIOS PENDIENTES</th>
                <tr>

                    <td style="text-align:center;"><strong>&nbsp;DIAS LABORADOS</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;SUELDO DIARIO </strong></td>
                    <td style="text-align:center;"><strong>&nbsp;SALARIOS PENDIENTES</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center;">
                        <?= $data->dias_laborados; ?> DÍAS
                    </td>
                    <td style="text-align:center;">$
                        <?= $data->sueldo_diario; ?>
                    </td>
                    <td style="text-align:center;">$
                        <?= $data->t_sp; ?>
                    </td>
                </tr>
                <td colspan="7" style="text-align:center; font-weight: bold;">TOTAL $
                    <?= $data->t_sp; ?>
                </td>
            </tbody>
        </table>
        <hr>

        <table>
            <thead>
                <th colspan="7" style="text-align:center;">PROPORCIONAL DE AGUINALDO</th>
                <tr>

                    <td style="text-align:center;"><strong>&nbsp;DÍAS LABORADOS</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;AGUINALDO</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;AÑO</strong></td>
                    <td style="text-align:center;"><strong>&nbsp;FACTOR DE AGUINALDO</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center;">
                        <?= $data->diferencia_dias; ?> DÍAS
                    </td>
                    <td style="text-align:center;">
                        <?= $data->dias_aguinaldo; ?> DÍAS
                    </td>
                    <td style="text-align:center;">365 DÍAS</td>
                    <td style="text-align:center;">
                        <?= $data->numero_factor; ?>
                    </td>
                </tr>
                <td colspan="7" style="text-align:center; font-weight: bold;">TOTAL $
                    <?= $data->t_aguinaldo; ?>
                </td>
            </tbody>
        </table>
        <hr>
        <table>
            <th colspan="7" style="text-align:center;">MONTO TOTAL DE FINIQUITO</th>
            <tr>
                <th>PROPORCIONAL DE VACACIONES</th>
                <td>
                    $
                    <?= $data->t_vacaciones; ?>
                </td>
            </tr>
            <tr>
                <th>PROPORCIONAL DE PRIMA VACACIONAL</th>
                <td>
                    $
                    <?= $data->total_pv; ?>
                </td>
            </tr>
            <tr>
                <th>PROPORCIONAL DE AGUINALDO</th>
                <td>
                    $
                    <?= $data->t_aguinaldo; ?>
                </td>
            </tr>
            <tr>
                <th>SALARIOS PENDIENTES</th>
                <td>
                    $
                    <?= $data->t_sp; ?>
                </td>
            </tr>
            <td colspan="7" style="text-align:center; font-weight: bold;">TOTAL $
                <?= $data->monto_finiquito; ?>
            </td>
        </table>

        <hr>
        <p style="text-align:justify;" id="ptext">
            Yo, <strong style="font-weight: bold;">
                <?php echo strtoupper($data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno); ?>,
            </strong> manifiesto
            que estoy de acuerdo con el pago de la cantidad desglosada anteriormente y he recibido el día 13 de octubre
            de 2023 al
            momento de firma del presente documento la cantidad de <strong style="font-weight: bold;">$
                <?= $data->monto_finiquito; ?> (
                <?php echo strtoupper($monto_en_letras); ?>)
            </strong> por concepto de finiquito.
        </p>

        <hr>
        <br>

        <style>
            .firma-container {
                overflow: hidden;
            }

            .firma-left {
                float: left;
                text-align: left;
            }

            .firma-right {
                float: right;
                text-align: right;
            }
        </style>

        <div class="firma-container">
            <div class="firma-left">
                <p><strong style="font-weight: bold;">EL TRABAJADOR</p></strong>
                <br>
                <p>--------------------------------------------</p>
                <p><strong style="font-weight: bold;">
                        <?php echo strtoupper($data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno); ?>
                    </strong></p>
            </div>

            <div class="firma-right">
                <p><strong style="font-weight: bold;">EL PATRÓN</p></strong>
                <br>
                <p>--------------------------------------------</p>
                <p><strong style="font-weight: bold; text-align:center;">NOE ALEJANDRO CRUZ PONCE <br>REPRESENTANTE
                        LEGAL</br></strong></p>
            </div>

            <hr style="clear: both;">
        </div>


    </div>

    <img src="<?php echo base_url("gifs/redes.png"); ?>" alt="logo_turing" width="320px" height="55px" style="text-align: right;">
</div>




<?= $this->include('comercial/administracionGeneral/footer') ?>