<?php 
$numero = 1; ?>

<?= $this->include('comercial/administracionGeneral/header') ?>



<div class="info-card vertical">
<h4 class="title-wish"> <a href="<?php echo base_url('/home/nomina');?>">Nóminas > </a>  Nuevo historico <i class="fas fa-calendar-alt" style="color: #3498db;"></i></h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong><i class="fas fa-calendar-alt" style="color: #3498db;"></i> Nuevo pago de nómina</strong>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('/home/saveperiod') ?>" method="post">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="id_usuario" class="form-control" id="colaboradorSelect"
                                onchange="calcularFechaQuincena()">
                                <option value="">Selecciona el colaborador</option>
                                <?php foreach ($nomina as $lista): ?>
                                    <option value="<?php echo $lista->id_usuario; ?>"
                                        data-id-nomina="<?php echo $lista->id_nomina; ?>"
                                        data-fecha-inicio="<?php echo $lista->fecha_ingreso; ?>"
                                        data-pago-mensual="<?php echo $lista->pago_mensual_base; ?>">
                                        <?php echo $numero . ". " . $lista->nombre . " " . $lista->apellido_paterno . " " . $lista->apellido_materno; ?>
                                    </option>
                                    <?php $numero++; endforeach; ?>
                            </select>
                        </td>
                        <input type="hidden" name="id_nomina" class="form-control" value="" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Fecha inicio colaborador:</label>
                    <div class="col-sm-4">
                        <input type="date" id="fecha_inicio_colab" name="fecha_inicio_colab" class="form-control"
                            value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pago mensual:</label>
                    <div class="col-sm-4">
                        <input type="text" id="pago_mensual_base" name="pago_mensual_base" class="form-control" value=""
                            placeholder="Pago mensual del colaborador">
                    </div>
                    <label class="col-sm-2 col-form-label">Periodo:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="periodo" class="form-control" id="periodo">
                                <option value="">Selecciona un periodo colaborador</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </td>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mes del periodo:</label>
                    <div class="col-sm-10">
                        <td>
                            <select name="mes" class="form-control" id="mes">
                                <option value="">Selecciona un mes </option>
                                <option value="enero">Enero</option>
                                <option value="febrero">Febrero</option>
                                <option value="marzo">Marzo</option>
                                <option value="abril">Abril</option>
                                <option value="mayo">Mayo</option>
                                <option value="junio">Junio</option>
                                <option value="julio">Julio</option>
                                <option value="agosto">Agosto</option>
                                <option value="septiembre">Septiembre</option>
                                <option value="octubre">Octubre</option>
                                <option value="noviembre">Noviembre</option>
                                <option value="diciembre">Diciembre</option>
                            </select>
                        </td>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Inicio quincena: </label>
                    <div class="col-sm-4">
                        <input type="date" id="fecha_primer_quincena" name="fecha_inicio_quincena" class="form-control"
                            value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Fin quincena: </label>
                    <div class="col-sm-4">
                        <input type="date" id="fecha_fin_quincena" name="fecha_fin_quincena" class="form-control"
                            value="<?= date('Y-m-d'); ?>" required>
                    </div>

                </div>
                <div class="form-group row">
                

                    <label class="col-sm-2 col-form-label">Días trabajados</label>
                    <div class="col-sm-4">
                        <input type="text" name="dias_trabajados" id="dias_trabajados" class="form-control" value=""
                            required placeholder="Ingresa los días trabajados">
                    </div>
                    <label class="col-sm-2 col-form-label">Sueldo final </label>
                    <div class="col-sm-4">
                        <input type="text" name="sueldo_final" id="sueldo_final" class="form-control" value="" required
                            placeholder="Sueldo neto final">
                    </div>


                </div>
                <div class="form-group row">

                    <div class="col-sm-4">
                        <a href="<?php echo base_url("home/nomina"); ?>" class="ver-periodo-btn1">Retroceder</a>
                        <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function calcularFechaQuincena() {
        var select = document.getElementById("colaboradorSelect");
        var selectedOption = select.options[select.selectedIndex];

        var fechaInicioColab = selectedOption.getAttribute("data-fecha-inicio");
        var fechaQuincena = new Date(fechaInicioColab);

        // Validar si el 15 es sábado (día 6) o domingo (día 0)
        if (fechaQuincena.getDate() === 15) {
            if (fechaQuincena.getDay() === 6) { // Sábado
                fechaQuincena.setDate(fechaQuincena.getDate() - 1); // Restar un día
            } else if (fechaQuincena.getDay() === 0) { // Domingo
                fechaQuincena.setDate(fechaQuincena.getDate() - 2); // Restar dos días
            }
        }

        // Validar la regla de negocio: 13 días antes del 15
        var fechaLimite = new Date(fechaQuincena);
        fechaLimite.setDate(fechaQuincena.getDate() - 13);

        // Obtener el último día hábil del mes actual
        var ultimoDiaMes = new Date(fechaLimite.getFullYear(), fechaLimite.getMonth() + 1, 0);

        // Ajustar para casos donde el último día hábil sea sábado
        if (ultimoDiaMes.getDay() === 6) {
            ultimoDiaMes.setDate(ultimoDiaMes.getDate() - 1); // Restar un día
        }

        // Formatear la fecha al formato YYYY-MM-DD
        //var formattedUltimoDiaMes = formatDate(ultimoDiaMes);
       // document.getElementById("fecha_primer_quincena").value = formattedUltimoDiaMes;
       // var alcanzoQuincena = fechaQuincena.getDate() <= 13;
       // document.getElementById("si_no_quincena").value = alcanzoQuincena ? "SI" : "NO";
    }

    // Agregar evento onchange al campo de fecha
    document.getElementById("fecha_primer_quincena").onchange = function () {
        // Puedes agregar lógica adicional aquí si el usuario cambia la fecha manualmente
    };

    // Función para formatear la fecha como YYYY-MM-DD
    function formatDate(date) {
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();

        if (month < 10) {
            month = '0' + month;
        }

        if (day < 10) {
            day = '0' + day;
        }

        return year + '-' + month + '-' + day;
    }
</script>

<script>
    document.getElementById('colaboradorSelect').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        document.querySelector('[name="id_nomina"]').value = selectedOption.getAttribute('data-id-nomina');
        document.querySelector('[name="fecha_inicio_colab"]').value = selectedOption.getAttribute('data-fecha-inicio');
        document.querySelector('[name="pago_mensual_base"]').value = selectedOption.getAttribute('data-pago-mensual');
        document.querySelector('[name="sueldo_final"]').value = selectedOption.getAttribute('data-pago-mensual');
    });

    // Manejar el evento de cambio de la fecha de inicio del colaborador
    $('input[name="fecha_inicio_colab"]').on('input', function () {
        var fechaInicioColab = $(this).val();

        // Si la fecha de inicio está definida
        if (fechaInicioColab) {
            var fechaInicioQuincena = calcularFechaInicioQuincena(fechaInicioColab);
            var fechaFinQuincena = calcularFechaFinQuincena(fechaInicioQuincena);
            var diasTrabajados = calcularDiasTrabajados(fechaInicioQuincena, fechaFinQuincena);

            // Actualizar los campos correspondientes
            $('input[name="fecha_inicio_quincena"]').val(fechaInicioQuincena);
            $('input[name="fecha_fin_quincena"]').val(fechaFinQuincena);
            $('input[name="dias_trabajados"]').val(diasTrabajados);

            var primerDiaQuincena = new Date(fechaInicioQuincena.fecha);
            primerDiaQuincena.setDate(15);

            console.log(primerDiaQuincena);


        }
    });

    // Función para calcular la fecha de inicio de la quincena
    function calcularFechaInicioQuincena(fechaInicioColab) {
        var fecha = new Date(fechaInicioColab);

        // Si la fecha de inicio es viernes, sábado o domingo, mover al próximo lunes
        /* if (fecha.getDay() === 4
             || fecha.getDay() === 5
             || fecha.getDay() === 6) { // viernes, sábado o domingo
             fecha.setDate(fecha.getDate() + (7 - fecha.getDay())); // 7 - día actual
         } else {
             //fecha.setDate(fecha.getDate() + 1);
             fecha.setDate(fecha.getDate());
         }*/
        var mes = fecha.toLocaleString('es-ES', { month: 'long' });
        var anio = fecha.getFullYear();

        return {
            fecha: fecha.toISOString().split('T')[0],
            mes: mes.toLowerCase(),
            anio: anio
        };
    }


    // Función para calcular la fecha de fin de la quincena
    /*function calcularFechaFinQuincena(fechaInicioQuincena) {
        var fecha = new Date(fechaInicioQuincena);

        // Sumar 14 días (quincena)
        fecha.setDate(fecha.getDate() + 14);

        // Ajustar al último día hábil del mes
        while (fecha.getDay() === 0 || fecha.getDay() === 6) {
            // Si es sábado o domingo, retrocede un día
            fecha.setDate(fecha.getDate() - 1);
        }

        return fecha.toISOString().split('T')[0];
    }*/
    // Función para calcular los días trabajados
    function calcularDiasTrabajados(fechaInicioQuincena, fechaFinQuincena) {
        var inicio = new Date(fechaInicioQuincena);
        var fin = new Date(fechaFinQuincena);

        // Calcular la diferencia en días
        var diferencia = Math.floor((fin - inicio) / (1000 * 60 * 60 * 24));

        return diferencia + 1; // Se suma 1 porque ambos días se cuentan
    }
</script>

<script>
    function calcularFechas() {
        var fechaInicioColab = $('input[name="fecha_inicio_colab"]').val();

        // Si la fecha de inicio está definida
        if (fechaInicioColab) {
            var resultado = calcularFechaInicioQuincena(fechaInicioColab);
            var fechaInicioQuincena = resultado.fecha;
            var mes = resultado.mes;
            var anio = resultado.anio;

            // Actualizar los campos correspondientes
            $('input[name="fecha_inicio_quincena"]').val(fechaInicioQuincena);

            // Configurar el mes seleccionado
            $('select[name="mes"]').val(mes);

            // Configurar el año seleccionado
            $('select[name="periodo"]').val(anio);

            // Calcular la fecha de fin de quincena
            var fechaFinQuincena = calcularFechaFinQuincena(fechaInicioQuincena);
            $('input[name="fecha_fin_quincena"]').val(fechaFinQuincena);

            // Calcular los días trabajados
            var diasTrabajados = calcularDiasTrabajados(fechaInicioQuincena, fechaFinQuincena);
            $('input[name="dias_trabajados"]').val(diasTrabajados);
        }
    }

    // Manejar el evento de cambio de la fecha de inicio del colaborador
    $('input[name="fecha_inicio_colab"]').on('change', function () {
        calcularFechas();
        //console.log('Cambio de fecha de inicio del colaborador detectado.');
    });

    // Manejar el evento de cambio de selección del usuario
    $('#colaboradorSelect').on('change', function () {
        // Actualizar los campos al seleccionar un usuario
        var selectedOption = this.options[this.selectedIndex];
        $('input[name="id_nomina"]').val(selectedOption.getAttribute('data-id-nomina'));
        $('input[name="fecha_inicio_colab"]').val(selectedOption.getAttribute('data-fecha-inicio'));
        $('input[name="pago_mensual_base"]').val(selectedOption.getAttribute('data-pago-mensual'));
        $('input[name="sueldo_final"]').val(selectedOption.getAttribute('data-pago-mensual'));

        calcularFechas();
    });

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
    echo '    confirmButtonText: "Entendido.",';
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
    echo '    confirmButtonText: "Reintentar.",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
?>


<?= $this->include('comercial/administracionGeneral/footer') ?>