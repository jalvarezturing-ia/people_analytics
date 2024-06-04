<?= $this->include('direccion/header') ?>
<?php $numero1 =1; ?>
<?php $numero3 =1; ?>
<style>
    body.loading::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: #ffffff;
        /* Cambiado a blanco sólido */
        z-index: 999;
        /* Asegura que el fondo esté detrás del spinner */
    }

    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 1000;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(0.8);
        }
    }

    .spinner {
        width: 350px;
        height: 350px;
        animation: pulse 1s ease-in-out infinite;
        z-index: 1001;
    }
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/registro"); ?>">Asistencia ></a> Reporte de
        incidencias
        <i class="fas fa-info-circle"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-sign-out-alt" style="color: #3498db;"></i> Nuevo reporte de incidencias
            </strong>

            <hr>
            <div id="btns">
                
                <a href="#" class="ver-periodo-btn" onclick="mostrar('reporte')" id="5"> <i class="fas fa-clock"></i>
                    Reporte
                </a>|

                <a href="#" class="ver-periodo-btn" onclick="mostrar('total')" id="6"> <i
                        class="fas fa-check-circle"></i> Horas </a>
            </div>
        </div>

        <div class="card-body" id="pendienteSection" >
            <center>
                <h5><i class="fas fa-clock" style="color: #C7D000;"></i> Incidencias reportadas
                </h5>
            </center>

            <table>
                <tr style="font-weight:bold;">
                    <td style="text-align: center;">#</td>
                    <td style="text-align: center;">Colaborador</td>
                    <td style="text-align: center;">Fecha salida</td>
                    <td style="text-align: center;">Fecha regreso</td>
                    <td style="text-align: center;">Horas a reponer</td>
                    <td style="text-align: center;">Descripción</td>
                    <td style="text-align: center;">Evidencia</td>
                </tr>

                <?php foreach ($reporte as $report): ?>
                    <tr style="text-align: center;">
                        <td>
                            <?= $numero1; ?>
                        </td>
                        <td>
                            <?= $report->nombre . " " . $report->apellido_paterno; ?>
                        </td>
                        <td>
                            <?= $report->f_salida ?>
                        </td>
                        <td>
                            <?= $report->f_regreso ?>
                        </td>
                        <td>
                            <?= $report->horas_reponer ?> hrs
                        </td>
                        <td>


                            <?php
                            $descripcion = strlen($report->descripcion) > 15 ? substr($report->descripcion, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($report->descripcion) . '\')">...</a>' : $report->descripcion;
                            echo $descripcion;
                            ?>
                        </td>
                        <td>
                            <a href="#" onclick='mostrarImagen("<?php echo base_url("/permisos/$report->evidencia"); ?>")'>
                                <video src="<?php echo base_url("/permisos/$report->evidencia"); ?>" alt="img"
                                    class="rounded-thumbnail img-fluid"
                                    style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;"></video>
                            </a>
                        </td>
                        
                    </tr>
                    <?php $numero1++; endforeach; ?>
            </table>


        </div>

        <div class="card-body" id="autorizadosSection" style="display:none;">
            <center>
                <h5><i class="fas fa-check-circle" style="color: #00D05B;"></i> Reposición de horas
                </h5>
            </center>
            

            <table>
                <tr style="font-weight:bold;">
                    <td style="text-align: center;">#</td>
                    <td style="text-align: center;">Colaborador</td>
                    <td style="text-align: center;">Área</td>
                    <td style="text-align: center;">Fechas </td>
                    <td style="text-align: center;">Motivo</td>
                    <td style="text-align: center;">Forma de reponer</td>
                    <td style="text-align: center;">Horas reponer</td>
                    <td style="text-align: center;">Evidencia inicio</td>
                    <td style="text-align: center;">Evidencia fin</td>
                
                </tr>
                <?php foreach ($repo as $repos): ?>
                    <tr style="text-align: center;">
                        <td>
                            <?= $numero3; ?>
                        </td>
                        <td>
                            <?= $repos->nombre . " " . $repos->apellido_paterno; ?>
                        </td>
                        <td>
                            <?= $repos->area_desc; ?>
                        </td>
                        <td>
                            <?= $repos->f_salida . "//" . $repos->f_regreso; ?>
                        </td>
                        <td>
                            <?= $repos->motivo; ?>
                        </td>
                        <td>
                            <?php
                            $descripcion = strlen($repos->forma) > 10 ? substr($repos->forma, 0, 10) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($repos->forma) . '\')">...</a>' : $repos->forma;
                            echo $descripcion;
                            ?>
                        </td>
                        <td>
                            <?= $repos->h_reponer; ?> hrs
                        </td>
                        <td>
                        <a href="#" onclick='mostrarImagen("<?php echo base_url("/repo/$repos->evidencia_inic"); ?>")'>
                                <img src="<?php echo base_url("/repo/$repos->evidencia_inic"); ?>" alt="img"
                                    class="rounded-thumbnail img-fluid"
                                    style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;"></img>
                            </a>
                        </td>
                        <td>
                        <a href="#" onclick='mostrarImagen("<?php echo base_url("/repo/$repos->evidencia_fin"); ?>")'>
                                <img src="<?php echo base_url("/repo/$repos->evidencia_fin"); ?>" alt="img"
                                    class="rounded-thumbnail img-fluid"
                                    style="width: 40px; height: 20px; object-fit: cover;  margin: 5px;"></img>
                            </a>
                        </td>
                    </tr>
                    <?php $numero3++; endforeach; ?>
            </table>

        </div>


    </div>
</div>

<div id="loading-spinner" class="text-center">
    <div class="spinner-overlay"></div>
    <img src="<?php echo base_url("gifs/logo.svg"); ?>" class="spinner" alt="Spinner">
    <br>
    <br>
    <br>
    <br>
    <h4>Registrando incidencia, espera un momento...</h4>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('5').classList.add('activo');
    });


    function mostrar(seccion) {

        document.getElementById('pendienteSection').style.display = 'none';
        document.getElementById('autorizadosSection').style.display = 'none';
        document.getElementById('5').classList.remove('activo');
        document.getElementById('6').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'reporte') {
            document.getElementById('pendienteSection').style.display = 'block';
            document.getElementById('5').classList.add('activo');

        } else if (seccion === 'total') {

            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('6').classList.add('activo');
        }
        
    }
</script>




<script>
    document.getElementById("cars").addEventListener("change", function () {
        var internet = document.getElementById("Internet");
        var luz = document.getElementById("Luz");
        var ambas = document.getElementById("Ambas");

        var motivoTextarea = document.getElementById("motivoTextarea");
        var horas = document.getElementById("horas");
        var f_salida = document.getElementById("f_salida");
        var f_regreso = document.getElementById("f_regreso");

        if (this.value === "Internet" || this.value === "Luz" || this.value === "Ambas" || this.value === "Other") {

            motivoTextarea.style.display = "block";
            motivoTextarea.setAttribute("required", "required");
            horas.style.display = "block";
            horas.removeAttribute("readonly", "readonly");
            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");

            // Obtener los elementos de entrada de fecha
            const fSalida = document.getElementById('f_salida');
            const fRegreso = document.getElementById('f_regreso');

            // Escuchar los cambios en las fechas
            fSalida.addEventListener('change', calcularHoras);
            fRegreso.addEventListener('change', calcularHoras);

            function calcularHoras() {
                // Obtener las fechas seleccionadas
                const salida = new Date(fSalida.value);
                const regreso = new Date(fRegreso.value);

                // Calcular la diferencia en milisegundos
                const diferenciaMs = regreso - salida;

                // Convertir la diferencia a horas
                const horas = Math.abs(diferenciaMs / 3600000); // 3600000 milisegundos = 1 hora

                // Mostrar las horas en el campo de entrada
                document.getElementById('horas').value = horas.toFixed(0); // Redondear a 2 decimales
            }

        } else if (this.value === "Medico") {
            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");
            horas.setAttribute("readonly", "readonly");
            motivoTextarea.style.display = "block";
            motivoTextarea.removeAttribute("required");
            horas.value = "0";
        } else if (this.value === "none") {
            motivoTextarea.style.display = "none";
            motivoTextarea.removeAttribute("required");
            horas.setAttribute("readonly", "readonly");
            f_salida.setAttribute("readonly", "readonly");
            f_regreso.setAttribute("readonly", "readonly");
        }
    });

</script>



<?= $this->include('direccion/footer') ?>