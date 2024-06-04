<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/forms') ?>">Talent Management | Candidatos | Formularios vacantes </a>| Nuevo formulario
        <i class="fas fa-envelope"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;' title="Crear periodos"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='<?php echo base_url("/home/forms") ?>' class='dropdown-item' data-toggle="tooltip"
                class="nav-link" data-placement="bottom" title="Crear una nueva encuesta"
                style="border-radius: 1rem;">
                <i class='fas fa-building'></i> Regresar al menú
            </a>
        </div>
    </h4>
    <hr>
    <small id="passwordHelpBlock" class="form-text text-muted">
        Creado por <strong style="color: #4c49ea;"> Capital Humano </strong> el
        <?= date('d/m/Y'); ?>
        <br>

    </small>
    <br>
    <div class="card-body" id="proceso">
        <form action="<?php echo base_url('home/saveform') ?>" method="POST">

            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Área:</label>
                <div class="col-sm-4">
                    <select name="area" id="area" class="form-control">
                        <option value="">ÁREA</option>
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
                    <input type="hidden" name="token" value="<?= $token ?>">
                </div>
                <label for="titulo" class="col-sm-2 col-form-label">Vacante:</label>
                <div class="col-sm-4">
                    <select name="vacante" id="vacante" class="form-control">
                        <option value="">VACANTE</option>
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

            <div class="d-block text-right">
                <a href="#!" class="btn ver-periodo-btn" onclick="agregarPregunta()" id="agregarBtn"
                    data-toggle="tooltip" class="nav-link" data-placement="bottom"
                    title="Agrega preguntas al formulario"> <i class="fas fa-edit"></i></a>
                <!-- <button class="btn ver-periodo-btn1" onclick="delEnc(event,)" id="agregarBtn"
                data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Elimina la encuesta del sistema">
                <i class="fas fa-trash-alt"></i> </button> -->
            </div>




            <table id="tablaPreguntas" class="table table-bordered table-hover">
            </table>






            <a href="<?php echo base_url('home/forms') ?>" class="btn ver-periodo-btn1">Cancelar</a>
            <input type="submit" class="btn ver-periodo-btn" value="Guardar">
        </form>


    </div>



    <div></div>
</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>




<script>
    // Variable para mantener el número de la próxima pregunta
    var contadorPreguntas = 1;

    function agregarPregunta() {
        var table = document.getElementById("tablaPreguntas");
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        row.innerHTML = `
            <tr>
                <td>Pregunta ${contadorPreguntas}:</td>
                <td><textarea name="preg[]" class="form-control" placeholder="Escriba la pregunta ${contadorPreguntas}" rows="3" style="border:none;" required></textarea></td>
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
                <input type="hidden" name="numero[]" value="${contadorPreguntas}">
            </tr>
        `;

        contadorPreguntas++; // Incrementar el número de la próxima pregunta
    }
</script>