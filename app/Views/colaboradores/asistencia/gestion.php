<?= $this->include('colaboradores/header') ?>
<?php $numero = 1; ?>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia ></a> <a
            href="<?php echo base_url("home/incidence/$id"); ?>">Incidencias ></a> Gestión de horas <i
            class="fas fa-clock"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-clock" style="color: #3498db;"></i> Evidencia de reposición de horas
            </strong>
        </div>
        <div class="card-body" id="nuevoSection">
            <form id="formulario" action="<?php echo base_url("/home/saveprimer"); ?>" method="post"
                enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                    <div class="col-sm-4">
                        <input type="hidden" name="user_id" class="form-control" value="<?= $id ?>">
                        <input type="hidden" name="id_dato" class="form-control" value="<?= $id_dato ?>">
                        <input type="text" name="nombre" class="form-control" value="<?= $name ?>" required readonly>
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <input type="text" name="descripcion" class="form-control" value="<?= $desc ?>" required
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fecha" class="col-sm-2 col-form-label">Puesto:</label>
                    <div class="col-sm-4">
                        <input type="text" name="puesto" class="form-control" value="<?= $puesto ?>" required readonly>
                    </div>
                    <label for="hora" class="col-sm-2 col-form-label">Correo:</label>
                    <div class="col-sm-4">
                        <input type="email" name="correo" class="form-control" value="<?= $mail ?>" required readonly>
                    </div>
                </div>

                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información de
                        reposición</strong>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        1. Favor de llenar el siguiente formulario con las horas a reponer por permiso y/o incidencia.
                        <br>
                        2. En caso de dudas o sugerencias, favor de contactarse al siguiente número: <a
                            href="https://api.whatsapp.com/send?phone=+525616631953&text=Hola, tengo una duda acerca de%20"
                            target='_blank'>5616631953</a>
                        - Mayte López. <br>

                        ¡Que tengan un excelente día!
                    </small>
                </div>
                <br>
                <?php foreach ($datos as $permiso): ?>

                    <div class="form-group row">
                        <label for="fecha" class="col-sm-2 col-form-label">Motivo de reposición de horas:</label>
                        <div class="col-sm-10">

                            <textarea name="motivo" class="form-control" placeholder="Motivo de su salida con detalle."
                                rows="3" minlength="3" maxlength="5000" required
                                readonly><?= $permiso->descripcion ?> </textarea>

                        </div>
                    </div>

                    <div class="form-group row">

                        <label for="nombre" class="col-sm-2 col-form-label">Inicio sucedido:</label>
                        <div class="col-sm-4">
                            <input type="text" id="" name="" value="<?= $permiso->f_salida ?> " class="form-control"
                                required readonly>
                        </div>

                        <label for="area" class="col-sm-2 col-form-label">Fin sucedido:</label>
                        <div class="col-sm-4">
                            <input type="text" id="" name="" value="<?= $permiso->f_regreso ?>" class="form-control"
                                required readonly>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="nombre" class="col-sm-2 col-form-label">Fecha inicio reposicion:</label>
                        <div class="col-sm-4">
                            <input type="text" id="" name="" value="<?= $permiso->fecha_inicio ?> " class="form-control"
                                required readonly>
                        </div>

                        <label for="area" class="col-sm-2 col-form-label">Fecha inicio reposicion:</label>
                        <div class="col-sm-4">
                            <input type="text" id="" name="" value="<?= $permiso->fecha_fin ?>" class="form-control"
                                required readonly>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="area" class="col-sm-2 col-form-label">Horas totales de reponer:</label>
                        <div class="col-sm-4">
                            <input type="number" name="horas_totales" id="horas_totales" class="form-control"
                                placeholder="Ejemplo: 1,2,3 o 4 " required value="<?= $permiso->horas_reponer ?>" readonly>
                        </div>
                        <label for="area" class="col-sm-2 col-form-label">Horas para reponer hoy:</label>
                        <div class="col-sm-4">
                            <input type="number" name="horas_reponer" id="horas_reponer" value="<?= $permiso->h_reponer ?>"
                                class="form-control" placeholder="Ejemplo: 1,2,3 o 4 " readonly required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="area" class="col-sm-2 col-form-label">Horas restantes para reponer:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" name="horas_restantes" id="horas_restantes" class="form-control"
                                placeholder="Ejemplo: 1,2,3 o 4 " value="<?= $permiso->h_restantes ?>" required readonly>

                        </div>
                    </div>

                <?php endforeach; ?>


                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia de inicio (hora y fecha
                        visibles)</strong>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <input type="file" name="imagen" id="imagenInput0" accept="image/*" onchange="previewImage0()"
                        required="">
                </div>
                <br>

                <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                    <img id="imagenPreview0" src="#" style="max-width: 100%; max-height: 300px;">
                </div>
                <br>



                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia de fin (hora y fecha
                        visibles)</strong>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <input type="file" name="imagen1" id="imagenInput1" accept="image/*" onchange="previewImage1()"
                        required="">
                </div>
                <br>

                <div class="form-group mb-2 text-center" style="margin-left: 250px;">
                    <img id="imagenPreview1" src="#" style="max-width: 100%; max-height: 300px;">
                </div>
                <br>

                
                <div class="card-header" style="text-align: center;">
                    <strong><input type="checkbox" required> Notifiqué al área de Capital Humano y al encargado de área sobre la reposición de mis horas correspondientes</strong>
                </div>
                <br>

                <div class="form-group mb-2 text-center">
                    <a href="<?php echo base_url("home/incidence/$id"); ?>"
                        class="ver-periodo-btn1 text-center ">Retroceder</a>
                    <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar">
                </div>

            </form>
        </div>
    </div>
</div>



<script>
    function previewImage0() {
        var input = document.getElementById('imagenInput0');
        var preview = document.getElementById('imagenPreview0');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
    function previewImage1() {
        var input = document.getElementById('imagenInput1');
        var preview = document.getElementById('imagenPreview1');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>

<?= $this->include('colaboradores/footer') ?>