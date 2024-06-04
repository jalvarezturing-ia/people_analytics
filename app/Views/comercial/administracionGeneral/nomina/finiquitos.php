<?php 
$numero = 1;
$numero2 = 1;
?>
<?= $this->include('comercial/administracionGeneral/header') ?>
<style>
    @media only screen and (max-width: 600px) {
        td {
            display: block;
            width: 100%;
        }
    }
</style>

<script>
    function help(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Qué significa el *?',
            text: 'Todos los campos que son requeridos de llenar.',
            icon: 'question',
            confirmButtonColor: '#1371C7',
            confirmButtonText: "¡Gracias por la información!",
        });
    }
</script>

<div class="info-card vertical">
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Datos de finiquito</strong>
            <br><br>
            <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('pendientes')" id="pendientesBtn">Por pagar
            </a>|
            <a href="#!" class="ver-periodo-btn" onclick="mostrarSeccion('pagados')" id="pagadosBtn">Pagados </a>
        </div>
        <div class="card-body" id="pendientesSection">
            <form action="<?php echo base_url('/home/nomina/savefiniquito'); ?>" method="post"
                enctype="multipart/form-data">

                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-4">

                        <select name="id_usuario" class="form-control" onchange="rellenarDias(this)">
                            <option value="">Selecciona el colaborador</option>
                            <?php foreach ($datoFin as $lista): ?>
                                <option value="<?php echo $lista->id_usuario; ?>"
                                    data-dias="<?php echo $lista->diferencia_dias; ?>"
                                    data-ingreso="<?php echo $lista->fecha_ingreso; ?>"
                                    data-egreso="<?php echo $lista->fecha_egreso; ?>"
                                    data-pago="<?php echo $lista->sueldo_final_total; ?>"
                                    data-sueldo="<?php echo $lista->sueldo_diario; ?>"
                                    data-id_nomina="<?php echo $lista->id_nomina; ?>">
                                    <?php echo $numero . ". " . $lista->nombre . " " . $lista->apellido_paterno . " " . $lista->apellido_materno; ?>
                                </option>
                                <?php $numero++; endforeach; ?>
                        </select></td>
                        <input type="hidden" value="" name="id_nomina" id="id_nomina">
                    </div>
                    <label for="antiguedad" class="col-sm-2 col-form-label">Días de antiguedad: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-4">
                        <input type="text" name="antiguedad" id="antiguedad" class="form-control" value="" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="f_ingreso" class="col-sm-2 col-form-label">Fecha ingreso: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-4">
                        <input type="date" name="f_ingreso" id="f_ingreso" class="form-control" value="" required>
                    </div>
                    <label for="f_egreso" class="col-sm-2 col-form-label">Fecha egreso: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-4">
                        <input type="date" name="f_egreso" id="f_egreso" class="form-control" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pago_mensual" class="col-sm-2 col-form-label">Pago mensual: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-4">
                        <input type="text" name="pago_mensual" id="pago_mensual" class="form-control" value="" required>
                    </div>
                    <label for="sueldo_diario" class="col-sm-2 col-form-label">Sueldo diario de base: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-4">
                        <input type="text" name="sueldo_diario" id="sueldo_diario" class="form-control" value=""
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="aguinaldo" class="col-sm-2 col-form-label">Aguinaldo: <a href="#"
                            onclick="help(event)"><strong style="color:red;">*</strong></a></label>
                    <div class="col-sm-10">
                        <input type="text" name="aguinaldo" id="aguinaldo" class="form-control" value="15" required>
                    </div>
                </div>
                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Proporcional de vacaciones
                    </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="sueldo_diario" class="col-sm-2 col-form-label">Sueldo diario de base: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="sueldo_diario" id="sueldo_diario1" class="form-control" value=""
                            required>
                    </div>
                    <label for="vacaciones" class="col-sm-2 col-form-label">Días de vacaciones: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="vacaciones" id="vacaciones" class="form-control" value="12" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total" class="col-sm-2 col-form-label">Total proporcional vacaciones: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="total" id="total" class="form-control" value="" required>
                    </div>
                    <label for="dias" class="col-sm-2 col-form-label">Días del año: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="dias" id="dias" class="form-control" value="365" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="proporcional" class="col-sm-2 col-form-label">Año entre total proporcional: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="proporcional" id="proporcional" class="form-control" value="" required>
                    </div>
                    <label for="antiguedad1" class="col-sm-2 col-form-label">Días totales trabajados: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="antiguedad1" id="antiguedad1" class="form-control" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_vacaciones" class="col-sm-2 col-form-label">Total de vacaciones: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-10">
                        <input type="text" name="total_vacaciones" id="total_vacaciones" class="form-control" value=""
                            required>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Proporcional de prima vacacional
                    </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="legal" class="col-sm-2 col-form-label">LEGAL: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="legal" id="legal" class="form-control" value=".25" required>
                    </div>
                    <label for="pv" class="col-sm-2 col-form-label">P.V: <strong style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="pv" id="pv" class="form-control" value="" required>
                    </div>
                    <label for="total_pv" class="col-sm-2 col-form-label">Total P.V: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="total_pv" id="total_pv" class="form-control" value="" required>
                    </div>
                </div>
                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Salarios pendientes
                    </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="dias_laborados" class="col-sm-2 col-form-label">Días laborados: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="number" name="dias_laborados" id="dias_laborados" class="form-control" value="0"
                            required>
                    </div>
                    <label for="sueldo_diario" class="col-sm-2 col-form-label">Sueldo diario de base: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="sueldo_diario2" id="sueldo_diario2" class="form-control" value=""
                            required>
                    </div>
                    <label for="total_sp" class="col-sm-2 col-form-label">Total S.P: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="total_sp" id="total_sp" class="form-control" value="" required>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Factor de aguinaldo
                    </strong>
                </div>
                <div class="form-group row">
                    <table>
                        <thead>
                            <tr>
                                <td></td>
                                <td><strong>&nbsp;DÍAS </strong></td>
                                <td><strong>&nbsp;AGUINALDO</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Legales: <strong style="color:red;">*</strong></td>
                                <td><input type="text" name="dias" id="dias" class="form-control" value="365" required>
                                </td>
                                <td><input type="text" name="aguinaldo" id="aguinaldo" class="form-control" value="15"
                                        required> </td>
                            </tr>
                            <tr>
                                <td>Laborados: <strong style="color:red;">*</strong></td>
                                <td><input type="text" name="antiguedad2" id="antiguedad2" class="form-control" value=""
                                        required> </td>
                                <td><input type="text" name="factor" id="factor" class="form-control" value="" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Aguinaldo proporcional
                    </strong>
                </div>
                <p></p>
                <div class="form-group row">
                    <label for="factor1" class="col-sm-2 col-form-label">Factor: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="factor1" id="factor1" class="form-control" value="" required>
                    </div>
                    <label for="sd" class="col-sm-2 col-form-label">Sueldo diario: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="sd" id="sd" class="form-control" value="" required>
                    </div>
                    <label for="ap" class="col-sm-2 col-form-label">Total A.P: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="ap" id="ap" class="form-control" value="" required>
                    </div>
                </div>
                <!---->
                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Prima vacacional  (UMA)
                    </strong>
                </div>
                <p></p>

               <!-- <p style="text-align:justify;" id="ptext">
                    <br>
                    En cuanto a la prima vacacional, se considera una exención equivalente a 15 veces el valor de la UMA
                    <strong style="font-weight:bold;"> (De conformidad con la fracción XIV, artículo 93 de la
                        LISR).</strong>

                </p>-->

                <div class="form-group row">
                    <label for="valor_uma" class="col-sm-2 col-form-label">Valor de UMA: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="valor_uma" id="valor_uma" class="form-control" value="103.74" required>
                    </div>
                    <label for="mult_uma" class="col-sm-2 col-form-label">Exención equivalente: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="mult_uma" id="mult_uma" class="form-control" value="15" required>
                    </div>
                    <br>
                    <label for="ingreso_gravado" class="col-sm-2 col-form-label">Ingreso gravado: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="ingreso_gravado" id="ingreso_gravado" class="form-control" value="0" required>
                    </div>
                    <label for="ingreso_excento" class="col-sm-2 col-form-label">Ingreso excento: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="ingreso_excento" id="ingreso_excento" class="form-control" value="0" required>
                    </div>
                    <label for="total_uma" class="col-sm-2 col-form-label">TOPE GRAVADO: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-6">
                        <input type="text" name="total_uma" id="total_uma" class="form-control" value="" required>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Aguinaldo  (UMA)
                    </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="valor_uma" class="col-sm-2 col-form-label">Valor de UMA: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="valor_uma1" id="valor_uma1" class="form-control" value="103.74" required>
                    </div>
                    <label for="mult_uma" class="col-sm-2 col-form-label">Exención equivalente: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="mult_uma1" id="mult_uma1" class="form-control" value="30" required>
                    </div>

                    <label for="ingreso_gravado" class="col-sm-2 col-form-label">Ingreso gravado: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="ingreso_gravado1" id="ingreso_gravado1" class="form-control" value="0" required>
                    </div>
                    <label for="ingreso_excento" class="col-sm-2 col-form-label">Ingreso excento: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="ingreso_excento1" id="ingreso_excento1" class="form-control" value="0" required>
                    </div>
                    <label for="total_uma" class="col-sm-2 col-form-label">TOPE GRAVADO: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-6">
                        <input type="text" name="total_uma1" id="total_uma1" class="form-control" value="" required>
                    </div>
                </div>


                <!---->
                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Total a pagar
                    </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="factor1" class="col-sm-2 col-form-label"> POR AGUINALDO: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="t_aguinaldo" id="t_aguinaldo" class="form-control" value="" required
                            readonly>
                    </div>
                    <label for="sd" class="col-sm-2 col-form-label">POR VACACIONES: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="t_vacaciones" id="t_vacaciones" class="form-control" value="" required
                            readonly>
                    </div>
                    <label for="ap" class="col-sm-2 col-form-label">POR TOTAL P.V: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-2">
                        <input type="text" name="t_pv" id="t_pv" class="form-control" value="" required readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="proporcional" class="col-sm-2 col-form-label">POR TOTAL S.P: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" name="t_sp" id="t_sp" class="form-control" value="" required readonly>
                    </div>
                    <label for="antiguedad1" class="col-sm-2 col-form-label">TOTAL DE LIQUIDACIÓN: <strong
                            style="color:red;">*</strong></label>
                    <div class="col-sm-4">
                        <strong><input type="text" name="total_finiquito" id="total_finiquito" class="form-control"
                                value="" required readonly></strong>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <a href="<?php echo base_url("home/index"); ?>" class="ver-periodo-btn1">Retroceder</a>
                        <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                    </div>
                </div>
            </form>
        </div><!--FIN PRIMER SECCION-->

        <!-- Sección de pagados -->
        <div id="pagadosSection" style="display: none;">
            <div class="form-group row">
                <table>
                    <thead>
                        <tr>
                            <td>#</td>
                            <td><strong>&nbsp;Nombre y apellido </strong></td>
                            <td><strong>&nbsp;Ingreso</strong></td>
                            <td><strong>&nbsp;Egreso</strong></td>
                            <td><strong>&nbsp;Menú</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagados as $pagado):
                            date_default_timezone_set('America/Mexico_City');
                            setlocale(LC_TIME, "spanish");
                            $fecha_ing = strftime("%d/%B/%Y", strtotime($pagado->fecha_ingreso));
                            $fecha_salida = strftime("%d/%B/%Y", strtotime($pagado->fecha_egreso)); ?>
                            <tr>
                                <td>
                                    <?= $numero2; ?>
                                </td>
                                <td>
                                    <?= $pagado->nombre . " " . $pagado->apellido_paterno . " " . $pagado->apellido_materno; ?>
                                </td>
                                <td>
                                    <?= $fecha_ing; ?>
                                </td>
                                <td>
                                    <?= $fecha_salida; ?>
                                </td>
                                <td>
                                    <button type='button' class="btn ver-periodo-btn btn-xs btn-radius"
                                        style=' float: right;' title="Crear periodos" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Acciones
                                        <i class='fas fa-caret-down'></i>
                                    </button>
                                    <div class="dropdown-menu acciones">
                                        <a href="<?php echo base_url("home/nomina/severance/$pagado->id_usuario/$pagado->id_nomina"); ?> "
                                            class='dropdown-item' class="ver-periodo-btn"> <i class='fas fa-check'></i> Ver
                                            detalles</a>

                                        <a href='<?php echo base_url("home/nomina/deleteseverance/$pagado->id_nomina"); ?>'
                                            class='dropdown-item'> <i class='fas fa-trash'></i> Eliminar finiquito</a>
                                    </div>
                                <td>
                            </tr>
                            <?php $numero2++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<script>
    function rellenarDias(select) {
        var dia = parseInt(select.options[select.selectedIndex].getAttribute('data-dias'));
        var ingreso = select.options[select.selectedIndex].getAttribute('data-ingreso');
        var egreso = select.options[select.selectedIndex].getAttribute('data-egreso');
        var pago = select.options[select.selectedIndex].getAttribute('data-pago');
        var sueldo = parseFloat(select.options[select.selectedIndex].getAttribute('data-sueldo'));
        var id_nomina = select.options[select.selectedIndex].getAttribute('data-id_nomina');
        var vaca = parseFloat(document.getElementById('vacaciones').value);
        var año = parseFloat(document.getElementById('dias').value);
        var legal = parseFloat(document.getElementById('legal').value);
        var aguinaldo = parseFloat(document.getElementById('aguinaldo').value);


        var final = vaca * sueldo;
        var total = Math.ceil((final / año) * 100) / 100; // Redondea hacia arriba a dos decimales
        var total_vacaciones = Math.ceil((total * dia) * 100) / 100; // Redondea hacia arriba a dos decimales
        var total_pv = Math.ceil((total_vacaciones * legal) * 100) / 100; // Redondea hacia arriba a dos decimales
        var factor = Math.ceil((dia * aguinaldo / año) * 100) / 100;// Redondea hacia arriba a dos decimales
        var ap = Math.ceil((factor * sueldo) * 100) / 100;// Redondea hacia arriba a dos decimales



        document.getElementById('antiguedad').value = dia;
        document.getElementById('antiguedad1').value = dia;
        document.getElementById('antiguedad2').value = dia;
        document.getElementById('f_ingreso').value = ingreso;
        document.getElementById('f_egreso').value = egreso;
        document.getElementById('pago_mensual').value = pago;
        document.getElementById('sueldo_diario').value = sueldo;
        document.getElementById('sueldo_diario1').value = sueldo;
        document.getElementById('sueldo_diario2').value = sueldo;
        document.getElementById('sd').value = sueldo;
        document.getElementById('id_nomina').value = id_nomina;
        document.getElementById('total').value = final;
        document.getElementById('proporcional').value = total;
        document.getElementById('total_vacaciones').value = total_vacaciones;
        document.getElementById('pv').value = total_vacaciones;
        document.getElementById('total_pv').value = total_pv;
        document.getElementById('factor').value = factor;
        document.getElementById('factor1').value = factor;
        document.getElementById('ap').value = ap;
        document.getElementById('t_aguinaldo').value = ap;
        document.getElementById('t_vacaciones').value = total_vacaciones;
        document.getElementById('t_pv').value = total_pv;





        document.getElementById('dias_laborados').addEventListener('input', function () {
            var diasLaborados = parseFloat(document.getElementById('dias_laborados').value);
            var sueldoDiario = parseFloat(document.getElementById('sueldo_diario2').value);
            var totalSP = diasLaborados * sueldoDiario;
            var total_liquidacion = (ap + total_vacaciones + total_pv + totalSP);

            document.getElementById('total_sp').value = totalSP.toFixed(2);
            document.getElementById('total_finiquito').value = total_liquidacion.toFixed(2);
            document.getElementById('t_sp').value = totalSP;
        });

        document.getElementById('sueldo_diario2').addEventListener('input', function () {
            var diasLaborados = parseFloat(document.getElementById('dias_laborados').value);
            var sueldoDiario = parseFloat(document.getElementById('sueldo_diario2').value);
            var totalSP = diasLaborados * sueldoDiario;
            var total_liquidacion = (ap + total_vacaciones + total_pv + totalSP);

            document.getElementById('total_sp').value = totalSP.toFixed(2);
            document.getElementById('total_finiquito').value = total_liquidacion.toFixed(2);
            document.getElementById('t_sp').value = totalSP;
        });

      

        /*document.getElementById('valor_uma').addEventListener('input', function () {
            var huma = parseFloat(document.getElementById('valor_uma').value);
            var mult_uma = parseFloat(document.getElementById('mult_uma').value);

            // Verifica que los valores sean números
            console.log('Valor de UMA:', huma);
            console.log('Exención equivalente:', mult_uma);

            // Calcula el total y muestra en consola
            var total_huma = Math.ceil((huma * mult_uma) * 100) / 100;
            console.log('Total UMA:', total_huma);

            // Asigna el valor calculado al campo 'total_uma'
            document.getElementById('total_uma').value = total_huma;
        });*/


    }
</script>

<script>
    // Función para realizar la multiplicación
    function calcularTotalUMA() {
        var uma = parseFloat(document.getElementById('valor_uma').value);
        var uno = parseFloat(document.getElementById('mult_uma').value);
        var dos = uma * uno;
        
        document.getElementById('total_uma').value = dos.toFixed(2);
    }

    // Llama a la función al cargar la página
    window.addEventListener('load', calcularTotalUMA);

    // Llama a la función en el evento 'input' de 'valor_uma'
    document.getElementById('valor_uma').addEventListener('input', calcularTotalUMA);

    // Llama a la función en el evento 'input' de 'mult_uma'
    document.getElementById('mult_uma').addEventListener('input', calcularTotalUMA);
</script>
<script>
    // Función para realizar la multiplicación
    function calcularTotalUMA1() {
        var uma1 = parseFloat(document.getElementById('valor_uma1').value);
        var uno1= parseFloat(document.getElementById('mult_uma1').value);
        var dos1 = uma1 * uno1;
        
        document.getElementById('total_uma1').value = dos1.toFixed(2);
    }

    // Llama a la función al cargar la página
    window.addEventListener('load', calcularTotalUMA1);

    // Llama a la función en el evento 'input' de 'valor_uma'
    document.getElementById('valor_uma1').addEventListener('input', calcularTotalUMA1);

    // Llama a la función en el evento 'input' de 'mult_uma'
    document.getElementById('mult_uma1').addEventListener('input', calcularTotalUMA1);
</script>



<?php
$session = session();
$error_message = $session->getFlashdata('sucess_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "success",';
    echo '    title: "Éxito",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Siguiente",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
$error_message = $session->getFlashdata('error_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "error",';
    echo '    title: "Error",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Entendido",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}

?>
<?= $this->include('comercial/administracionGeneral/footer') ?>