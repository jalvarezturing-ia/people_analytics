<?= $this->include('colaboradores/header') ?>
<?php $numero = 1; ?>

<style>
    .ver-periodo-btn.activo {
        color: #FFFF;
        background-color: #1371C7;

    }
</style>


<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia |</a> <a
            href="<?php echo base_url("home/incidence/$id"); ?>">Incidencias |</a> Reposición de horas <i
            class="fas fa-clock"></i>
    </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-clock" style="color: #3498db;"></i> Formato de reposición de horas
            </strong>
        </div>

        <div class="card-body" id="nuevoSection">
            <form id="formulario" action="<?php echo base_url("/home/savegestion"); ?>" method="post"
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
                        2. En caso de dudas o sugerencias, favor de contactarse al con el Área de Capital Humano: <a
                            href="https://api.whatsapp.com/send?phone=+525616631953&text=Hola, tengo una duda acerca de%20"
                            target='_blank'>5616631953.</a>
                         <br>

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

                        <label for="nombre" class="col-sm-2 col-form-label">Inicio y hora de reposición:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="datetime-local" id="f_inicio" name="f_inicio" class="form-control" required>
                        </div>

                        <label for="area" class="col-sm-2 col-form-label">Fin y hora de reposición:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="datetime-local" id="f_termino" name="f_termino" class="form-control" required>
                        </div>
                    </div>
                    <?php if ($permiso->h_reponer == '' && $permiso->h_restantes == ''): ?>
                        <div class="form-group row">
                            <label for="area" class="col-sm-2 col-form-label">Horas totales de reponer:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" name="horas_totales" id="horas_totales" class="form-control"
                                    placeholder="Ejemplo: 1,2,3 o 4 " required value="<?= $permiso->horas_reponer ?>" readonly>
                            </div>
                            <label for="area" class="col-sm-2 col-form-label">Horas a reponer:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" name="horas_reponer" id="horas_reponer" class="form-control"
                                    placeholder="Ejemplo: 1,2,3 o 4 " readonly required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="area" class="col-sm-2 col-form-label">Horas restantes para reponer:<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" name="horas_restantes" id="horas_restantes" class="form-control"
                                    placeholder="Ejemplo: 1,2,3 o 4 " required readonly>

                            </div>
                            <label for="area" class="col-sm-2 col-form-label">¿De que forma las repondré?: <span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-4">
                                <textarea name="forma" class="form-control" autofocus
                                    placeholder="Escriba de manera como las repondras. Ejemplo: Actividades a realizar."
                                    rows="3" minlength="3" maxlength="5000" required></textarea>

                            </div>
                        <?php else: ?>
                            <div class="form-group row">
                                <label for="area" class="col-sm-2 col-form-label">Horas totales de reponer:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" name="horas_totales" class="form-control"
                                        placeholder="Ejemplo: 1,2,3 o 4 " required value="<?= $permiso->horas_reponer ?>"
                                        readonly>
                                </div>
                                <label for="area" class="col-sm-2 col-form-label">Horas a reponer:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" name="horas_reponer" class="form-control"
                                        value="<?= $permiso->h_restantes ?>" placeholder="Ejemplo: 1,2,3 o 4 " readonly
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="area" class="col-sm-2 col-form-label">Horas restantes para reponer:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number" name="horas_restantes" class="form-control"
                                        value="<?= $permiso->h_restantes - $permiso->h_restantes ?>"
                                        placeholder="Ejemplo: 1,2,3 o 4 " required readonly>

                                </div>
                                <label for="area" class="col-sm-2 col-form-label">¿De que forma las repondré?: <span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <textarea name="forma" class="form-control" autofocus
                                        placeholder="Escriba de manera como las repondras. Ejemplo: Actividades a realizar."
                                        rows="3" minlength="3" maxlength="5000" required
                                        readonly><?= $permiso->forma ?></textarea>

                                </div>

                            <?php endif; ?>
                        </div>

                    <?php endforeach; ?>

                    <div class="form-group mb-2 text-center">
                        <a href="<?php echo base_url("home/incidence/$id"); ?>"
                            class="ver-periodo-btn1 text-center ">Retroceder</a>
                        <input type="submit" class="ver-periodo-btn2 text-center " value="Enviar">
                    </div>

            </form>
        </div>

        <div class="card-body" id="pendienteSection" style="display: none;">
            <center>
                <h5><i class="fas fa-clock" style="color: #C7D000;"></i> Permisos solicitados
                </h5>
            </center>

        </div>

        <div class="card-body" id="autorizadosSection" style="display:none;">
            <center>
                <h5><i class="fas fa-check-circle" style="color: #00D05B;"></i> Permisos autorizados
                </h5>
            </center>
        </div>

    </div>
</div>


<script>
    const fSalida = document.getElementById('f_inicio');
    const fRegreso = document.getElementById('f_termino');

    var totales = document.getElementById('horas_totales').value;


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

        const resta = totales - horas;

        // Mostrar las horas en el campo de entrada
        document.getElementById('horas_reponer').value = horas.toFixed(0); // Redondear a 2 decimales
        document.getElementById('horas_restantes').value = resta.toFixed(0); // Redondear a 2 decimales



    }
</script>




<?= $this->include('colaboradores/footer') ?>