<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/forms') ?>" data-toggle="tooltip"
            data-placement="bottom" title="Regresar al menú principal">Talent Management | Candidatos | Formularios vacantes | </a> Editar formulario 
        <i class="fas fa-edit"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;' title="Crear periodos"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='<?php echo base_url("/home/forms/nuevo/$nuevoT"); ?>' class='dropdown-item' data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Busca un historial de horas de entrada"
                style="border-radius: 1rem;">
                <i class='fas fa-plus'></i> Agregar formulario
            </a>
        </div>
    </h4>
    <hr>
    <small id="passwordHelpBlock" class="form-text text-muted">
        Editado por <strong style="color: #4c49ea;"> Capital Humano </strong> el
        <?= date('d/m/Y'); ?>
        <br>

    </small>
    <br>

    <div class="card-body" id="proceso">
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label">Área:</label>
            <div class="col-sm-10">
                <select name="area" id="area" class="form-control"  onchange="updateFormulario(this, 'area', '<?php echo $id ?>' )">
                    <option value="<?= $area ?>"><?= $area ?></option>
                    <option value="Comercial">Comercial</option>
                    <option value="Tableau">Tableau</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Project Management">Project Management</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Administración">Administración</option>
                    <option value="Desarrollo de Software">Desarrollo de Software</option>
                    <option value="Administración de servidores">Administración de servidores</option>
                    <option value="Juridico">Jurídico</option>
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="titulo" class="col-sm-2 col-form-label">Vacante:</label>
            <div class="col-sm-10">
                <select name="vacante" id="vacante" class="form-control" onchange="updateFormulario(this, 'vacante', '<?php echo $id ?>' )">
                    <option value="<?= $vacante ?>"><?= $vacante ?></option>
                    <option value="Becario Comercial">Becario Comercial</option>
                    <option value="Becario Tableau">Becario Tableau</option>
                    <option value="Becario Recursos Humanos">Becario Recursos Humanos</option>
                    <option value="Becario Project Management">Becario Project Management</option>
                    <option value="Becario Marketing">Becario Marketing</option>
                    <option value="Becario Administración">Becario Administración</option>
                    <option value="Becario Desarrollo Software">Becario Desarrollo Software</option>
                    <option value="Becario Admon de servidores">Becario Admon de servidores</option>
                    <option value="Becario Jurídico">Becario Jurídico</option>
                </select>
            </div>

        </div>
        <br>



        <div class="d-block text-right">
            <button class="btn ver-periodo-btn" onclick="agregarPregunta()" id="agregarBtn" data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Agrega preguntas al cuestionario"> <i
                    class="fas fa-edit"></i></button>
            <button class="btn ver-periodo-btn1" onclick="delEnc(event, '<?= $id ?>')" id="agregarBtn"
                data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Elimina la encuesta del sistema">
                <i class="fas fa-trash-alt"></i> </button>
        </div>

        <?php
        // Obtener el número de pregunta más alto
        $ultimoNumero = 0;
        foreach ($forms as $pregunta) {
            $ultimoNumero = max($ultimoNumero, $pregunta->numero);
        }
        ?>
        <div id="preguntasSection">

            <?php if (empty($forms)): ?>
                <br>
                <div class="alert alert-info" style="text-align: center;">No hay preguntas registrados todo
                    va bien por aquí. &#128516;
                </div>
            <?php else: ?>

                <table class="table table-bordered table-hover">
                    <?php foreach ($forms as $pregunta): ?>
                        <tr>
                            <td>Pregunta
                                <?= $pregunta->numero; ?> <i class="fas fa-trash-alt" style="color:#4070F4;"
                                    onclick="delPreg(event, '<?= $pregunta->id; ?>', '<?= $id ?>', '<?= $token ?>')"> </i>
                            </td>
                            <td>
                                <textarea oninput="updateFormulario(this, 'titulo_pregunta', '<?php echo $pregunta->id ?>' )"
                                    name="titulo_pregunta" class="form-control" id="titulo_pregunta" placeholder="" rows="3"
                                    style="border:none;" required><?= $pregunta->pregunta; ?></textarea>
                            </td>

                            <td>
                                <input type="text" name="pregunta_a" id="pregunta_a" class="form-control"
                                    placeholder="Escriba la respuesta del inciso A" value="<?= $pregunta->A; ?>"
                                    oninput="updateFormulario(this, 'pregunta_a', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                                <input type="text" name="pregunta_b" id="pregunta_b" class="form-control"
                                    placeholder="Escriba la respuesta del inciso B" value="<?= $pregunta->B; ?>"
                                    oninput="updateFormulario(this, 'pregunta_b', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                            </td>
                            <td> <input type="text" name="pregunta_c" id="pregunta_c" class="form-control"
                                    placeholder="Escriba la respuesta del inciso C" value="<?= $pregunta->C; ?>"
                                    oninput="updateFormulario(this, 'pregunta_c', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                                <input type="text" name="pregunta_d" id="pregunta_d" class="form-control"
                                    placeholder="Escriba la respuesta del inciso D" value="<?= $pregunta->D; ?>"
                                    oninput="updateFormulario(this, 'pregunta_d', '<?php echo $pregunta->id ?>' )" style="border:none;">
                            </td>
                            </td>

                            <td> 
                                <input type="text" name="pregunta_d" id="pregunta_d" class="form-control"
                                    placeholder="Escriba la respuesta del inciso D" value="<?= $pregunta->D; ?>"
                                    oninput="updateFormulario(this, 'pregunta_d', '<?php echo $pregunta->id ?>' )"
                                    style="border:none;"><br>
                                <input type="text" name="pregunta_f" id="pregunta_f" class="form-control"
                                    placeholder="Escriba la respuesta del inciso D" value="<?= $pregunta->F; ?>"
                                    oninput="updateFormulario(this, 'pregunta_f', '<?php echo $pregunta->id ?>' )" style="border:none;">
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <form action="<?php echo base_url('/saveFormsAplicantEdit') ?>" method="POST">
                <table id="tablaPreguntas" class="table table-bordered table-hover">
                    <!-- Aquí van las filas de preguntas -->

                </table>

                <div class="botones" id="botones" style="display:none;">
                    <a href="<?php echo base_url('home/forms') ?>" class="btn ver-periodo-btn1">Cancelar</a>
                    <input type="submit" class="btn ver-periodo-btn" class="fas fa-edit" data-toggle="tooltip" class="nav-link"
                        data-placement="bottom" title="Guarda el formulario de las preguntas">
                </div>
            </form>
        </div>
    </div>


</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>





<script>

    function delEnc(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará su selección. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2980b9',
            cancelButtonColor: '#df8686',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/eliminarForm/'); ?>${id}`;
                window.location.href = url;
            }
        });
    }

    function delPreg(event, id,  id_form, token) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará su selección. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2980b9',
            cancelButtonColor: '#df8686',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/eliminarPregForm/'); ?>${id}/${id_form}/${token}`;
                window.location.href = url;
            }
        });
    }
</script>

<script>
    // Variable para mantener el número de la próxima pregunta
    var proximoNumero = <?php echo $ultimoNumero + 1; ?>;

    function agregarPregunta() {
        var table = document.getElementById("tablaPreguntas");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var botones = document.getElementById("botones");
        botones.style.display = 'block';
        row.innerHTML = `
            <tr>
                <td>Pregunta ${proximoNumero}:</td>
                <td><textarea name="preg[]" class="form-control" placeholder="Escriba la pregunta ${proximoNumero}" rows="3" style="border:none;" required></textarea></td>
                <td>
                    <input type="text" name="A[]" class="form-control" placeholder="Escriba la respuesta del inciso A" ><br>
                    <input type="text" name="B[]" class="form-control" placeholder="Escriba la respuesta del inciso B" ><br>
                    
                </td>
                <td>
                <input type="text" name="C[]" class="form-control" placeholder="Escriba la respuesta del inciso C" ><br>
                    <input type="text" name="D[]" class="form-control" placeholder="Escriba la respuesta del inciso D" >
                </td>
                <td>
                <input type="text" name="E[]" class="form-control" placeholder="Escriba la respuesta del inciso E" ><br>
                    <input type="text" name="F[]" class="form-control" placeholder="Escriba la respuesta del inciso F" >
                </td>
                <input type="hidden" name="id_encuesta" value="<?= $id; ?>">
                <input type="hidden" name="numero[]" value="${proximoNumero}">
            </tr>
        `;

        proximoNumero++; // Incrementar el número de la próxima pregunta
    }
   
</script>


<script>
    function estadoEncuestas(estado) {
        var valor = estado.value;
        var proceso = document.getElementById("proceso");
        var completados = document.getElementById("completados");
        console.log(valor);

        if (valor === 'proceso') {

            proceso.style.display = 'block';
            completados.style.display = 'none';

        } else if (valor === 'finalizado') {

            completados.style.display = 'block';
            proceso.style.display = 'none';

        }

    }

</script>