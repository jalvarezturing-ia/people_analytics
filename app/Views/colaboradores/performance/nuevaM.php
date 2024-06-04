<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('colaboradores/header') ?>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance |</a> <a
            href="<?php echo base_url("/home/aprendizaje"); ?>">Centro de
            aprendizaje |</a> Nueva entrada
        <i class="fas fa-info-circle"></i>

    </h4>
    <hr>

    <div class="card-body" id="cursosSection">


        <form id="formulario" action="<?php echo base_url("/home/savecurso"); ?>" method="post"
            enctype="multipart/form-data">

            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">Tipo de entrada:<span
                        style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <select name="tipo" class="form-control" id="tipo" required>
                        <option value="none">Seleccione</option>
                        <option value="Metas">Metas</option>
                        <option value="Cursos">Cursos</option>
                        <option value="Certificaciones">Certificaciones</option>
                    </select>
                    <br>
                </div>
                <label for="area" class="col-sm-2 col-form-label">Tema:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="text" id="tema" name="tema" class="form-control" required
                        placeholder="Nombre de su curso">
                </div>
            </div>
            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">URL Curso: <span style="color:red;">*</span></label>
                <div class="col-sm-4">

                    <textarea name="url" class="form-control" placeholder="Escriba el URL de su curso" rows="3"
                        required></textarea>

                </div>
                <label for="area" class="col-sm-2 col-form-label">Tiempo a apróximado:<span
                        style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="text" name="tiempo" id="horas" class="form-control" placeholder="Ejemplo: 1,2,3 o 4 "
                        required>

                </div>
            </div>
            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">Fecha inicio: <span
                        style="color:red;">*</span></label>
                <div class="col-sm-4">

                    <input type="date" name="inicio" id="inicio" class="form-control" required>

                </div>
                <label for="area" class="col-sm-2 col-form-label">Fecha fin:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="date" name="fin" id="fin" class="form-control" required>

                </div>
            </div>

            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">Observaciones: <span
                        style="color:red;">*</span></label>
                <div class="col-sm-4">

                    <textarea name="observaciones" class="form-control"
                        placeholder="Escriba el observaciones de su curso" rows="3" required></textarea>

                </div>
                <label for="area" class="col-sm-2 col-form-label">Estado:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <select name="estado" class="form-control" id="estado" required>
                        <option value="none">Seleccione</option>
                        <option style="color:#008000;" value="Realizado">&#9724; Realizado</option>
                        <option style="color:#FF0000;" value="Sin comenzar">&#9724; Sin comenzar</option>
                        <option style="color:#40E0D0;" value="Trabajando">&#9724; Trabajando</option>
                        <option style="color:#0071c5;" value="Detenido">&#9724; Detenido</option>
                    </select>

                </div>
            </div>

            <br>
            <div class="form-group mb-2 text-center">
                <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar">
            </div>
        </form>

    </div>



</div>



<?= $this->include('colaboradores/footer') ?>