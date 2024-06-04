<?= $this->include('comercial/administracionGeneral/header') ?>
<?php
$numero = 1; ?>

<div class="info-card vertical">
    <h4 class="title-wish"><a href="<?php echo base_url('/home/nomina'); ?>">Nóminas > </a> Crear nómina <i
            class="fas fa-hand-holding-usd"></i> <strong></strong>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class='fas fa-cogs'></i>
        </button>
        <div class="dropdown-menu acciones">
            <a href='<?php echo base_url('/home/newperiod'); ?>' class='dropdown-item'>
                <i class='fas fa-calendar-alt'></i> Crear historico
            </a>
        </div>
    </h4>
    <br>
    <div class="line"> </div>
    <table>
        <form id="sueldoForm" action="<?php echo base_url('/home/newboard/saveNomina') ?>" method="post"
            enctype="multipart/form-data">
            <tbody>
                <tr>
                    <td>Colaborador: </td>
                    <td><select name="id_usuario" class="form-control" onchange="rellenarFecha(this)">
                            <option value="">Selecciona el colaborador</option>
                            <?php foreach ($colabs as $lista): ?>
                                <option value="<?php echo $lista->id; ?>" data-fecha="<?php echo $lista->fecha_ingreso; ?>">
                                    <?php echo $numero . ". " . $lista->nombre . " " . $lista->apellido_paterno . " " . $lista->apellido_materno; ?>
                                </option>
                                <?php $numero++; endforeach; ?>
                        </select></td>
                    <td>Nombre del banco:</td>
                    <td>
                        <select id="nombre_banco" name="nombre_banco" class="form-control">
                            <option value="Banamex">Banamex </option>
                            <option value="Banco Azteca">Banco Azteca</option>
                            <option value="BBVA">BBVA</option>
                            <option value="Bancoppel">Bancoppel</option>
                            <option value="Banorte">Banorte</option>
                            <option value="Santander">Santander</option>
                            <option value="Scotiabank">Scotiabank</option>
                            <option value="HSBC">HSBC</option>
                            <option value="Interbank">Interbank</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Número de cuenta: </td>
                    <td><input type="text" name="numero_cuenta" class="form-control"
                            placeholder="Numero de cuenta del banco" required> </td>
                    <td>Clabe interbancaria: </td>
                    <td><input type="text" name="clabe_interbancaria" class="form-control"
                            placeholder="Clabe proporcionada por el banco" required> </td>

                </tr>
                <tr>
                    <td>Inicio colaborador: </td>
                    <input type="hidden" id="fecha_ingreso_seleccionado" name="fecha_ingreso_seleccionado">
                    <td><input type="date" id="fecha_inicio_colab" value="" name="fecha_inicio_colab"
                            class="form-control" required> </td>
                    <td>Pago mensual:</td>
                    <td><input type="number" name="pago_mensual_base" class="form-control"
                            placeholder="Pago total mensual" required oninput="calcularSueldo()"></td>

                </tr>
                <tr>
                    <td>Pago Quincenal</td>
                    <td><input type="text" name="pago_quincenal" class="form-control" placeholder="Pago cada 15 días"
                            readonly>
                    </td>
                    <td>Sueldo Diario:</td>
                    <td><input type="number" name="sueldo_diario" class="form-control" placeholder="Sueldo por día"
                            readonly> </td>
                </tr>
                <tr>
                    <td align="center">
                        <a href="<?php echo base_url("home/nomina"); ?>" class="ver-periodo-btn1">Retroceder</a>
                        <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                    </td>
                </tr>
            </tbody>
        </form>
    </table>
</div>


<script>
    function rellenarFecha(select) {
        // Obtiene la fecha del atributo data-fecha del option seleccionado
        var fechaSeleccionada = select.options[select.selectedIndex].getAttribute('data-fecha');

        // Actualiza el valor del campo de fecha oculto
        document.getElementById('fecha_ingreso_seleccionado').value = fechaSeleccionada;

        // Actualiza el valor del campo de fecha visible
        document.getElementById('fecha_inicio_colab').value = fechaSeleccionada;
    }
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