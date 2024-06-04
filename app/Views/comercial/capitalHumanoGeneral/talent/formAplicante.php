<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
    .table-container {
        display: flex;
    }

    table {
        width: 33.33%;
        margin-right: 10px;
        border-radius: 1rem;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;

        border-radius: 1rem;
    }

    th,
    td {
        padding: 10px;
    }

    th {
        /* background-color: #f2f2f2;
            background: #4070f4;
            color: white; */

    }

    /* th {
        text-align: center;
        background: #4070f4;
        border-radius: 1rem;
        color: white;
        border: none;
    }

    td {
        border: none;
        text-align: center;
    } */
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/applicants/proceso/$id_form"); ?>">Talent Management |
            Entrevista del candidato </a> | <?= $nombre; ?>
        <i class="fas fa-user"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='#!' class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                title="Registra un nuevo candidato" style="border-radius: 1rem;">
                <i class='fas fa-users'></i> Agregar candidato
            </a>
            <a href='<?php echo base_url("/home/forms") ?>' class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Formularios candidatos" style="border-radius: 1rem;">
                <i class='fas fa-tasks'></i> Formularios vacantes
            </a>
        </div>
    </h4>

    <div class="card-body" id="proceso" style="font-size: 14.5px;">
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-file-alt" style="color: #4070f4;"></i> Formato de entrevista del candidato
                <?= $nombre; ?></strong>
        </div>
        <div style="text-align: center; background-color: #4070f4; border-radius:1rem; color: white; font-weight:bold;">
            EVALUACIÓN DE ENTREVISTA INICIAL
        </div>

        <div style="text-align: center;">
            <strong>Objetivo:</strong> Ponderar las habilidades
            blandas y tecnicas que se observan en entrevista incial con el candidato. Para identificar si es
            viable a continuar a la siguiente etapa del proceso de selección.
        </div>

        <div style="text-align: center; background-color: #4070f4; border-radius:1rem; color: white; font-weight:bold;">
            DATOS GENERALES DEL CANDIDATO
        </div>
        <br>
        <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre: </label>
            <div class="col-sm-4">
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $nombre; ?>" required>
            </div>
            <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
            <div class="col-sm-4">
                <input type="email" name="correo" id="correo" class="form-control" value="<?= $correo; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="vacante" class="col-sm-2 col-form-label">Vacante: </label>
            <div class="col-sm-4">
                <input type="text" name="vacante" id="vacante" class="form-control" value="<?= $vacante_n; ?>" required>
            </div>
            <label for="correo" class="col-sm-2 col-form-label">Edad:</label>
            <div class="col-sm-4">
                <input type="email" name="correo" id="correo" class="form-control" value="0" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="vacante" class="col-sm-2 col-form-label">Posición: </label>
            <div class="col-sm-4">
                <input type="text" name="posicion" id="posicion" class="form-control" value="Becario" required>
            </div>
            <label for="telefono" class="col-sm-2 col-form-label">Teléfono:</label>
            <div class="col-sm-4">
                <input type="number" name="telefono" id="telefono" class="form-control" value="0" required>
            </div>
        </div>
        <div style="text-align: center; background-color: #4070f4; border-radius:1rem; color: white; font-weight:bold;">
            ESCALA
        </div>
        <br>
        <div class="form-group row">
            <label for="vacante" class="col-sm-2 col-form-label">Deficiente: </label>
            <div class="col-sm-4">
                <input type="text" name="posicion" id="posicion" class="form-control" value="1" required>
            </div>
            <label for="vacante" class="col-sm-2 col-form-label">Debe mejorar: </label>
            <div class="col-sm-4">
                <input type="text" name="posicion" id="posicion" class="form-control" value="2" required>
            </div>

        </div>
        <div class="form-group row">
            <label for="vacante" class="col-sm-2 col-form-label">Aceptable: </label>
            <div class="col-sm-4">
                <input type="text" name="posicion" id="posicion" class="form-control" value="3" required>
            </div>
            <label for="vacante" class="col-sm-2 col-form-label">Bien: </label>
            <div class="col-sm-4">
                <input type="text" name="posicion" id="posicion" class="form-control" value="4" required>
            </div>

        </div>
        <div class="form-group row">
            <label for="vacante" class="col-sm-2 col-form-label">Excelente: </label>
            <div class="col-sm-10">
                <input type="text" name="posicion" id="posicion" class="form-control" value="5" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="vacante" class="col-sm-2 col-form-label">Instrucciones: </label>
            <div class="col-sm-10">
                <textarea id="w3review" name="w3review" rows="4" cols="50" class="form-control">La evaluación de entrevista inicial tiene un valor del 30%, en el cuál se evaluan habilidades blandas con el 10%, habilidades técnicas con un 10% y la parte de Insights con el 10%, dando el total de 30%. Cada sección deberá evaluarse con una ponderación númerica del 1 al 5 (como se muestra en la tabla de escala) Así mismo cada sección tendrá un umbral, para determinar si el candidato ha aprobado cada una de las secciones evaluadas.  Cada sección se promediará con una regla de tres, posteriormente se promedia la calificación general de este formato. 
            </textarea>
            </div>
        </div>

        <div style="text-align: center; background-color: #4070f4; border-radius:1rem; color: white; font-weight:bold;">
            HUMBRALES
        </div>

        <div class="table-container" style="font-size: 12.5px;">
            <table>
                <th colspan="3">Umbral Habilidades blandas</th>
                <tr>
                    <th>Calificación</th>
                    <th>Porcentaje</th>
                    <th>Resultado</th>
                </tr>
                <tr>
                    <td>50</td>
                    <td>100</td>
                    <td>Excelente</td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>0.8</td>
                    <td>Aprobado</td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>0.6</td>
                    <td>No Aprobado</td>
                </tr>
            </table>

            <table>
                <th colspan="3">Umbral Habilidades técnicas</th>
                <tr>
                    <th>Calificación</th>
                    <th>Porcentaje</th>
                    <th>Resultado</th>
                </tr>
                <tr>
                    <td>50</td>
                    <td>100</td>
                    <td>Excelente</td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>0.8</td>
                    <td>Aprobado</td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>0.6</td>
                    <td>No Aprobado</td>
                </tr>
            </table>

            <table>
                <th colspan="3">Umbral Insights</th>
                <tr>
                    <th>Calificación</th>
                    <th>Porcentaje</th>
                    <th>Resultado</th>
                </tr>
                <tr>
                    <td>50</td>
                    <td>100</td>
                    <td>Excelente</td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>0.8</td>
                    <td>Aprobado</td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>0.6</td>
                    <td>No Aprobado</td>
                </tr>
            </table>
        </div>

        <br>
        <div style="text-align: center; background-color: #4070f4; border-radius:1rem; color: white; font-weight:bold;">
            CALIFICACIÓN DE HABILIDADES
        </div>


        <div class="table-container" style="font-size: 12.5px;">
            <table>
                <th colspan="3">Habilidades blandas</th>
                <tr>
                    <th>Habilidades</th>
                    <th colspan="2">Calificación</th>
                </tr>
                <?php foreach ($vacante[0] as $habilidad) { ?>
                    <tr>
                        <td><?php echo $habilidad; ?></td>
                        <td colspan="2"><input type="number" class="form-control" style="border:none; text-align:center;"
                                value="" name="valorBlandas[]" oninput="calcSuma(this, 'sumaBlandas', 'totalBlandas')"></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><strong>Suma</strong></td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value="0"
                            readonly name="sumaBlandas"></td>
                </tr>
                <tr>
                    <td colspan="2"> <strong>Total</strong> </td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value="0"
                            readonly name="totalBlandas"></td>

                </tr>
            </table>

            <table>
                <th colspan="3">Habilidades técnicas</th>
                <tr>
                    <th>Habilidades</th>
                    <th colspan="2">Calificación</th>
                </tr>
                <?php foreach ($vacante[1] as $habilidad) { ?>
                    <tr>
                        <td><?php echo $habilidad; ?> <br></td>
                        <td colspan="2"><input type="number" class="form-control" style="border:none; text-align:center;"
                                value="" name="valorTecnicas[]" oninput="calcSuma(this,'sumaTecnicas','totalTecnicas')">
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><strong>Suma</strong></td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value="0"
                            readonly name="sumaTecnicas"></td>
                </tr>

                <tr>
                    <td colspan="2"> <strong>Total</strong> </td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value="0"
                            readonly name="totalTecnicas"></td>

                </tr>

            </table>

            <table>
                <th colspan="3">Insights</th>
                <tr>
                    <th>Habilidades</th>
                    <th colspan="2">Calificación</th>
                </tr>
                <?php foreach ($vacante[2] as $habilidad) { ?>
                    <tr>
                        <td><?php echo $habilidad; ?></td>
                        <td colspan="2"><input type="number" class="form-control" style="border:none; text-align:center;"
                                value="" name="valorInsights[]" oninput="calcSuma(this,'sumaInsights','totalInsights')">
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="2"><strong>Suma</strong></td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value="0"
                            readonly name="sumaInsights"></td>
                </tr>
                <tr>
                    <td colspan="2"> <strong>Total</strong> </td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value="0"
                            readonly name="totalInsights"></td>

                </tr>
            </table>
        </div>
        <br>
        <div style="text-align: center; background-color: #4070f4; border-radius:1rem; color: white; font-weight:bold;">
            PROMEDIO GENERAL
        </div>

        <div class="table-container">
            <table>
                <th colspan="3" style="color: #4070f4;">Promedio general</th>
                <tr>
                    <th style="color: #4070f4;">Secciones</th>
                    <th style="color: #4070f4;">Calificación</th>
                </tr>
                <tr>
                    <td> <strong> Habilidades blandas</strong></td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value=""
                            id="totalBlandas1" oninput="onCal()"></td>
                </tr>
                <tr>
                    <td><strong>Habilidades técnicas</strong></td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value=""
                            id="totalTecnicas1" oninput="onCal()"></td>
                </tr>
                <tr>
                    <td><strong>Insights</strong></td>
                    <td><input type="number" class="form-control" style="border:none; text-align:center;" value=""
                            id="totalInsights1" oninput="onCal()"></td>
                </tr>
                <tr>
                    <td style="color: #4070f4;"><strong>Suma de las 3</strong></td>
                    <td style="color: #4070f4;"><strong><input type="number" class="form-control"
                                style="border:none; text-align:center;" value="" id="totalSuma" readonly></strong></td>
                </tr>
                <tr>
                    <td style="color: #4070f4;"><strong>RESULTADOS</strong></td>
                    <td style="color: #4070f4;"><strong><input type="number" class="form-control"
                                style="border:none; text-align:center;" value="" id="totalResultado" readonly></strong>
                    </td>
                </tr>
            </table>

            <table style="width: 66.33%;">
                <th style="color: #4070f4;">COMENTARIOS U OBSERVACIONES </th>
                <tr>
                    <td style="background-color:white;">
                        <textarea id="comentarios" name="comentarios" rows="11" class="form-control" oninput="onCal()"
                            required style="border:none;" placeholder="Escribe aquí tus comentarios...">Sin comentarios...</textarea>
                    </td>
                </tr>
            </table>
        </div>

        <br>
        <div class="alert alert-danger" id="mensaje-sin-periodo1" style="display: none;text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> El candidato no es viable</div>
        <div class="alert alert-success" id="mensaje-sin-periodo2" style="display: none;text-align: center;">
            <i class="fa fa-exclamation-circle"></i> El candidato puede ser viable
        </div>

        <form action="<?php echo base_url("/saveFormato") ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?= $id_user ?>" name="id_user">
            <input type="hidden" value="" name="calif_total" id="calif_total">
            <input type="hidden" value="" name="coment" id="coment">

            <input type="submit" class="btn ver-periodo-btn" style="text-align:center; display: none;"
                value="Guardar formulario" id="saveForm">
        </form>
    </div>
</div>

<script>
    function calcSuma(input, idSuma, idTotal) {

        var filaTabla = input.closest('table');
        var suma = 0;
        var inputs = filaTabla.querySelectorAll('input[name^="valor"]');
        inputs.forEach(function (input) {
            suma += parseFloat(input.value) || 0;
        });
        var campoSuma = filaTabla.querySelector('input[name="' + idSuma + '"]');
        var campoTotal = filaTabla.querySelector('input[name="' + idTotal + '"]');
        if (campoSuma) {
            campoSuma.value = suma;
            var nuevo = (100 / 50 * suma);
            campoTotal.value = nuevo;
            //prueb(nuevo, idTotal);
        } else {
            console.error('No se encontró el campo de suma con el nombre: ' + idSuma);
        }
    }

    function onCal() {

        var totalBlandas1 = parseInt(document.getElementById('totalBlandas1').value) || 0;
        var totalTecnicas1 = parseInt(document.getElementById('totalTecnicas1').value) || 0;
        var totalInsights1 = parseInt(document.getElementById('totalInsights1').value) || 0;
        var comentarios = document.getElementById('comentarios').value;
        var coment = document.getElementById('coment');

        coment.value = comentarios;

        var totalSuma = document.getElementById('totalSuma');
        var totalResultado = document.getElementById('totalResultado');

        var suma = totalBlandas1 + totalTecnicas1 + totalInsights1;

        totalSuma.value = suma;

        var promedio = (suma / 3);
        totalResultado.value = promedio;
        document.getElementById('calif_total').value = promedio;

        var mensajeSinPeriodo1 = document.getElementById("mensaje-sin-periodo1");
        var mensajeSinPeriodo2 = document.getElementById("mensaje-sin-periodo2");
        var saveForm = document.getElementById("saveForm");

        if (promedio >= 75) {

            mensajeSinPeriodo2.style.display = "block";
            saveForm.style.display = "block";
            mensajeSinPeriodo1.style.display = "none";


        } else if (promedio < 75) {
            mensajeSinPeriodo1.style.display = "block";
            saveForm.style.display = "block";
            mensajeSinPeriodo2.style.display = "none";
        }
        else {
            mensajeSinPeriodo1.style.display = "none";
            mensajeSinPeriodo2.style.display = "none";
            saveForm.style.display = "none";
        }

    }

</script>




<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>