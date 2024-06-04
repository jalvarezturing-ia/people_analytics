<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
    body.loading {
        overflow: hidden;
    }

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

<div class="info-card vertical" id="allTitle">
    <h4 class="title-wish"><a href="<?php echo base_url("/home/ats/final/$id_form"); ?>">Talent Management |
            <?= $vacante; ?> </a> | <?= $nombre; ?> <i class="fas fa-user"></i>


    </h4>
    <br>
    <div class="col-md-3 " style="">
        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="seccionesDocs(this)">
            <option value="info">Información</option>
            <!-- <option value="cv">Curriculum</option>
            <option value="contrato">Contrato</option>
            <option value="banco">Datos Bancarios</option>
            <option value="domicilio">C.Domicilio</option>
            <option value="estudios">C.Estudios</option>
            <option value="rfc">RFC</option>
            <option value="sbancarios">S.Datos Bancarios</option>
            <option value="beneficiario">Beneficiari@</option> -->
        </select>
    </div>
    <div>
        <!-- Sección de Información Personal -->
        <div class="card-body" id="infoSection">
            <form action="<?php echo base_url('/home/ats/save_new') ?>" method="post" id="formInfo"
                enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre (s):</label>
                    <div class="col-sm-4">
                        <input type="hidden" name="id_candidato" value="<?= $id_candidato; ?>">
                        <input type="hidden" name="id_form" value="<?= $id_form; ?>">
                        <input type="text" name="nombre" class="form-control" value="<?= $nombre; ?>"
                            placeholder="Ingresa el nombre" required>
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label">Apellido Paterno:</label>
                    <div class="col-sm-4">
                        <input type="text" name="apellido_paterno" class="form-control" value=""
                            placeholder="Ingresa el apellido paterno del usuario" required>
                    </div>

                </div>
                <div class="form-group row">

                    <label for="telefono" class="col-sm-2 col-form-label">Apellido Materno:</label>
                    <div class="col-sm-4">
                        <input type="text" name="apellido_materno" class="form-control" value="" required
                            placeholder="Ingresa el apellido materno del usuario">
                    </div>
                    <label for="telefono" class="col-sm-2 col-form-label">Teléfono:</label>
                    <div class="col-sm-4">
                        <input type="text" maxlength="10" name="telefono" class="form-control" value="" required
                            placeholder="Ingresa el telefono del usuario">
                    </div>
                </div>

                <div class="form-group row">

                    <label for="descripcion" class="col-sm-2 col-form-label">Fecha nacimiento:</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_nacimiento" class="form-control" value="" required>
                    </div>

                    <label for="sexo" class="col-sm-2 col-form-label">Sexo:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="sexo" class="form-control">
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Indefinido">Indefinido</option>
                            </select>
                        </td>
                    </div>

                </div>
                <div class="form-group row">

                    <label for="descripcion" class="col-sm-2 col-form-label">Dirección:</label>
                    <div class="col-sm-10">
                        <textarea name="direccion" class="form-control" placeholder="Escriba la dirección del usuario"
                            rows="3" minlength="3" maxlength="5000" required></textarea>

                    </div>
                </div>
                <!-- <div class="form-group row">

                    <label for="descripcion" class="col-sm-2 col-form-label">Url docs:</label>
                    <div class="col-sm-10">
                        <a href="<?= base_url("form_candidat/$id_candidato/$token"); ?>" target="_blank"><textarea
                                name="" class="form-control" placeholder="Escriba la dirección del usuario"
                                rows="3" minlength="3" maxlength="5000"
                                required><?= base_url("form_candidat/$id_candidato/$token"); ?></textarea></a>

                    </div>
                </div> -->

                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-building" style="color: #3498db;"></i> Información empresarial </strong>
                </div>
                <p></p>

                <div class="form-group row">
                    <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                    <div class="col-sm-4">
                        <input type="text" name="correo" class="form-control" value="" required
                            placeholder="Ingresa el correo empresarial del usuario">
                    </div>
                    <label for="nombre_area" class="col-sm-2 col-form-label">Área:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="nombre_area" class="form-control">
                                <option value="Servicios">Servicios</option>
                                <option value="Comercial">Comercial</option>
                            </select>
                        </td>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="correo" class="col-sm-2 col-form-label">Descripción:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="descripcion" class="form-control">
                                <option value="Infraestructura">Infraestructura</option>
                                <option value="Desarrollo de Software">Desarrollo de Software</option>
                                <option value="Administración">Administración</option>
                                <!-- <option value="Administración General">Administración General</option>
                                    <option value="Dirección Comercial">Dirección Comercial</option>
                                    <option value="Dirección de Servicios">Dirección de Servicios</option>
                                    <option value="Capital Humano General">Capital Humano General</option> -->
                                <option value="Capital Humano">Capital Humano</option>
                                <option value="Tableau">Tableau</option>
                                <option value="Project Management">Project Management</option>
                                <option value="Jurídico">Juridico</option>
                                <option value="Comercial">Comercial</option>
                                <option value="Marketing">Marketing</option>
                            </select>
                        </td>
                    </div>

                    <?php
                   
                    
                    $options = [
                        "Becario" => "Becario",
                        "Practicante" => "Practicante",
                        "Lider" => "Lider",
                        "Trainee" => "Trainee"
                    ];

                    ?>
                    <label for="correo" class="col-sm-2 col-form-label">Puesto:</label>
                    <div class="col-sm-4">
                        <td>
                            <select name="puesto" class="form-control">
                                <option value="<?= $tipo ?>"><?= $tipo ?></option>
                                <?php
                                foreach ($options as $value => $label) {
                                    if ($value !== $tipo && !($tipo === "Trabajo" && $value === "Becario")) {
                                        echo "<option value=\"$value\">$label</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="correo" class="col-sm-2 col-form-label">Ingreso a <strong>TURING-IA:</strong></label>
                    <div class="col-sm-10">
                        <input type="date" name="fecha_ingreso" class="form-control" value="<?= date('Y-m-d'); ?>"
                            required>
                    </div>
                </div>
                <div class="card-header" style="text-align: center;">
                    <strong> <i class="fas fa-dollar-sign" style="color: #3498db;"></i> Información bancaria </strong>
                </div>
                <p></p>


                <!-- ... Código de Datos Bancarios ... -->
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre Banco:</label>
                    <div class="col-sm-4">
                        <input type="text" name="nombre_banco" class="form-control" value="" required
                            placeholder="Escriba el nombre del banco">
                    </div>
                    <label for="telefono" class="col-sm-2 col-form-label">Numero de cuenta:</label>
                    <div class="col-sm-4">
                        <input type="text" name="numero_cuenta" class="form-control" value="" required
                            placeholder="Escriba el número de cuenta">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Clabe Interbancaria</label>
                    <div class="col-sm-4">
                        <input type="text" name="clabe_interbancaria" class="form-control" value="" required
                            placeholder="Escriba la clabe interbancaria">
                    </div>
                    <label for="correo" class="col-sm-2 col-form-label">Pago mensual:</label>
                    <div class="col-sm-4">
                        <input type="text" name="pago_mensual_base" class="form-control" value="" required
                            oninput="calcularSueldo1()" placeholder="Escriba el pago mensual">
                    </div>

                </div>
                <div class="form-group row">

                    <label for="nombre_area" class="col-sm-2 col-form-label">Pago quincenal:</label>
                    <div class="col-sm-4">
                        <input type="text" name="pago_quincenal" class="form-control" value="" required
                            placeholder="Escriba el pago quincenal">
                    </div>
                    <label for="correo" class="col-sm-2 col-form-label">Sueldo diario:</label>
                    <div class="col-sm-4">
                        <input type="text" name="sueldo_diario" class="form-control" value="" required
                            placeholder="Escriba el sueldo diario">
                    </div>
                </div>


                <p></p>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <a href="<?php echo base_url("home/ats/final/$id_form"); ?>"
                            class="btn ver-periodo-btn1">Retroceder</a>
                        <button type="submit" class="btn ver-periodo-btn2"> Guardar</button>
                    </div>
                </div>
            </form>


            <!-- <div class="card-header" style="text-align: center;" id="ineTitle">
                <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> INE </strong>
            </div>
            <div>
                <?php if (!empty($INE)): ?>
                    <div style="text-align: center; margin-top: 20px;">
                        <embed src="<?php echo base_url("/ine/$INE"); ?>" type="application/pdf" width="800" height="600">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <div class="row justify-content-center mt-4">
                                <div class="col-12 col-md-6 bg-light p-3">
                                    <form id="login-form" action="<?php echo base_url('/home/account/uploadine') ?>"
                                        enctype="multipart/form-data" method="post" class="form-inline">

                                        <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                        <div class="form-group mb-2">
                                            <input type="file" name="documento" id="docInput" required=""
                                                accept=".doc, .docx, .pdf" onchange="previewDoc()"
                                                class="form-control-file">
                                        </div>

                                        <div class="text-center">
                                            <p id="docMessage"></p>
                                        </div>
                                        <div style="text-align: center;">
                                            <button type="submit" class="ver-periodo-btn2">Guardarr</button>
                                            <a href="#!" onclick="scrollToallTitle()"
                                                class="ver-periodo-btn1">Retroceder</a>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row justify-content-center mt-4">
                        <div class="col-12 col-md-6 bg-light p-3">
                            <form id="login-form" action="<?php echo base_url('/home/account/uploadine') ?>"
                                enctype="multipart/form-data" method="post" class="form-inline">

                                <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                <div class="form-group mb-2">
                                    <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                        onchange="previewDoc()" class="form-control-file">
                                </div>

                                <div class="text-center">
                                    <p id="docMessage"></p>
                                </div>
                                <div style="text-align: center;">
                                    <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                    <a href="#!" onclick="scrollToallTitle()" class="ver-periodo-btn1">Retroceder</a>
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-header" style="text-align: center;" id="curpTitle">
              
                <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> CURP </strong>
            </div>
            <div>
                <?php if (!empty($CURP)): ?>
                    <div style="text-align: center; margin-top: 20px;">
                        <embed src="<?php echo base_url("/curp/$CURP"); ?>" type="application/pdf" width="800" height="600">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <div class="row justify-content-center mt-4">
                                <div class="col-12 col-md-6 bg-light p-3">
                                    <form id="login-form" action="<?php echo base_url('/home/account/uploadcurp') ?>"
                                        enctype="multipart/form-data" method="post" class="form-inline">

                                        <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                        <div class="form-group mb-2">
                                            <input type="file" name="documento" id="docInput" required=""
                                                accept=".doc, .docx, .pdf" onchange="previewDoc()"
                                                class="form-control-file">
                                        </div>

                                        <div class="text-center">
                                            <p id="docMessage"></p>
                                        </div>
                                        <div style="text-align: center;">
                                            <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                            <a href="#!" onclick="scrollToIneTitle()"
                                                class="ver-periodo-btn1">Retroceder</a>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row justify-content-center mt-4">
                        <div class="col-12 col-md-6 bg-light p-3">
                            <form id="login-form" action="<?php echo base_url('/home/account/uploadcurp') ?>"
                                enctype="multipart/form-data" method="post" class="form-inline">

                                <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                <div class="form-group mb-2">
                                    <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                        onchange="previewDoc()" class="form-control-file">
                                </div>

                                <div class="text-center">
                                    <p id="docMessage"></p>
                                </div>
                                <div style="text-align: center;">
                                    <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                    <a href="#!" onclick="scrollToIneTitle()" class="ver-periodo-btn1">Retroceder</a>
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-header" style="text-align: center;" id="actaTitle">

                <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> ACTA DE NACIMIENTO </strong>
            </div>

            <div>
                <?php if (!empty($nacimiento)): ?>
                    <div style="text-align: center; margin-top: 20px;">
                        <embed src="<?php echo base_url("/actasNacimiento/$nacimiento"); ?>" type="application/pdf"
                            width="800" height="600">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <div class="row justify-content-center mt-4">
                                <div class="col-12 col-md-6 bg-light p-3">
                                    <form id="login-form"
                                        action="<?php echo base_url('/home/account/uploadactaNacimiento') ?>"
                                        enctype="multipart/form-data" method="post" class="form-inline">

                                        <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                        <div class="form-group mb-2">
                                            <input type="file" name="documento" id="docInput" required=""
                                                accept=".doc, .docx, .pdf" onchange="previewDoc()"
                                                class="form-control-file">
                                        </div>

                                        <div class="text-center">
                                            <p id="docMessage"></p>
                                        </div>
                                        <div style="text-align: center;">
                                            <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                            <a href="#!" onclick="scrollTocurpTitle()"
                                                class="ver-periodo-btn1">Retroceder</a>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row justify-content-center mt-4">
                        <div class="col-12 col-md-6 bg-light p-3">
                            <form id="login-form" action="<?php echo base_url('/home/account/uploadactaNacimiento') ?>"
                                enctype="multipart/form-data" method="post" class="form-inline">

                                <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                <div class="form-group mb-2">
                                    <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                        onchange="previewDoc()" class="form-control-file">
                                </div>

                                <div class="text-center">
                                    <p id="docMessage"></p>
                                </div>
                                <div style="text-align: center;">
                                    <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                    <a href="#!" onclick="scrollTocurpTitle()" class="ver-periodo-btn1">Retroceder</a>
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div> -->

        </div> <!-- FIN DE LA SECCION DE INFO -->

        <!-- Sección de Curriculum -->
        <div class="card-body" id="cvSection" style="display: none;">
            <?php if (!empty($cv)): ?>
                <!-- ... Código de Curriculum ... -->
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/cvs/$cv"); ?>" type="application/pdf" width="800" height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form" action="<?php echo base_url('/home/account/uploadarchive') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">

                                    <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>
                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ... Código para subir nuevo curriculum ... -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form" action="<?php echo base_url('/home/account/uploadarchive') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">

                            <input type="hidden" name="id_usuario" value="" style="text-align: center;">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>

                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>

                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección de Contrato -->
        <div id="contratoSection" style="display: none;">
            <?php if (!empty($contrato)): ?>
                <!-- ... Código de Contrato ... -->
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/contratos/$contrato"); ?>" type="application/pdf" width="800"
                        height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form1" action="<?php echo base_url('/home/account/uploadcontract') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">
                                    <input type="hidden" name="id_usuario" value="">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>

                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ... Código para subir nuevo contrato ... -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form1" action="<?php echo base_url('/home/account/uploadcontract') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">
                            <input type="hidden" name="id_usuario" value="">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>
                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección de Datos Bancarios -->
        <div class="card-body" id="bancoSection" style="display: none;">

            <form id="bancariosForm" action="<?php echo base_url("home/nomina/savedatabank"); ?>" method="post"
                enctype="multipart/form-data">

                <!-- ... Código de Datos Bancarios ... -->
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre Banco:</label>
                    <div class="col-sm-4">
                        <input type="hidden" name="id_usuario" value="">
                        <input type="text" name="nombre_banco" class="form-control" value="" required>
                    </div>
                    <label for="telefono" class="col-sm-2 col-form-label">Numero de cuenta:</label>
                    <div class="col-sm-4">
                        <input type="text" name="numero_cuenta" class="form-control" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Clabe Interbancaria</label>
                    <div class="col-sm-4">
                        <input type="text" name="clabe_interbancaria" class="form-control" value="">
                    </div>
                    <label for="correo" class="col-sm-2 col-form-label">Pago mensual:</label>
                    <div class="col-sm-4">
                        <input type="text" name="pago_mensual_base" class="form-control" value=""
                            oninput="calcularSueldo1()">
                    </div>

                </div>
                <div class="form-group row">

                    <label for="nombre_area" class="col-sm-2 col-form-label">Pago quincenal:</label>
                    <div class="col-sm-4">
                        <input type="text" name="pago_quincenal" class="form-control" value="" required>
                    </div>
                    <label for="correo" class="col-sm-2 col-form-label">Sueldo diario:</label>
                    <div class="col-sm-4">
                        <input type="text" name="sueldo_diario" class="form-control" value="" required>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <a href="<?php echo base_url("home/nomina/people"); ?>" class="ver-periodo-btn1">Retroceder</a>
                    <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                </div>
            </form>
        </div>

        <!-- Sección de DOMICILIO -->
        <div id="comprobanteSection" style="display: none;">
            <?php if (!empty($domicilio)): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/cpdomicilio/$domicilio"); ?>" type="application/pdf" width="800"
                        height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form1" action="<?php echo base_url('/home/account/uploaddomicilio') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">
                                    <input type="hidden" name="id_usuario" value="">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>

                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form1" action="<?php echo base_url('/home/account/uploaddomicilio') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">
                            <input type="hidden" name="id_usuario" value="">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>
                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección de C.ESTUDIOS -->
        <div id="estudiosSection" style="display: none;">
            <?php if (!empty($estudios)): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/cpestudios/$estudios"); ?>" type="application/pdf" width="800"
                        height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form1" action="<?php echo base_url('/home/account/uploadestudios') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">
                                    <input type="hidden" name="id_usuario" value="">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>

                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ... Código para subir nuevo contrato ... -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form1" action="<?php echo base_url('/home/account/uploadestudios') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">
                            <input type="hidden" name="id_usuario" value="">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>
                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <!-- Sección de RFC -->
        <div id="rfcSection" style="display: none;">
            <?php if (!empty($rfc)): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/rfcs/$rfc"); ?>" type="application/pdf" width="800" height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form1" action="<?php echo base_url('/home/account/uploadrfc') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">
                                    <input type="hidden" name="id_usuario" value="">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>

                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ... Código para subir nuevo contrato ... -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form1" action="<?php echo base_url('/home/account/uploadrfc') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">
                            <input type="hidden" name="id_usuario" value="">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>
                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <!-- Sección de SOLICITUD_D_BANCARIOS -->
        <div id="d_bancariosSection" style="display: none;">
            <?php if (!empty($d_bancarios)): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/d_bancarios/$d_bancarios"); ?>" type="application/pdf" width="800"
                        height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form1" action="<?php echo base_url('/home/account/uploadbancarios') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">
                                    <input type="hidden" name="id_usuario" value="">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>

                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ... Código para subir nuevo contrato ... -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form1" action="<?php echo base_url('/home/account/uploadbancarios') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">
                            <input type="hidden" name="id_usuario" value="">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>
                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <!-- Sección de BENEFICIARIO -->
        <div id="beneficiarioSection" style="display: none;">
            <?php if (!empty($beneficiario)): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <embed src="<?php echo base_url("/beneficiario/$beneficiario"); ?>" type="application/pdf" width="800"
                        height="600">
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-6 bg-light p-3">
                                <form id="login-form1" action="<?php echo base_url('/home/account/uploadbeneficiario') ?>"
                                    enctype="multipart/form-data" method="post" class="form-inline">
                                    <input type="hidden" name="id_usuario" value="">
                                    <div class="form-group mb-2">
                                        <input type="file" name="documento" id="docInput" required=""
                                            accept=".doc, .docx, .pdf" onchange="previewDoc()" class="form-control-file">
                                    </div>

                                    <div class="text-center">
                                        <p id="docMessage"></p>
                                    </div>

                                    <div style="text-align: center;">
                                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                        <a href="<?php echo base_url("home/nomina/people"); ?>"
                                            class="ver-periodo-btn1">Retroceder</a>
                                        </a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ... Código para subir nuevo contrato ... -->
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-6 bg-light p-3">
                        <form id="login-form1" action="<?php echo base_url('/home/account/uploadbeneficiario') ?>"
                            enctype="multipart/form-data" method="post" class="form-inline">
                            <input type="hidden" name="id_usuario" value="">
                            <div class="form-group mb-2">
                                <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                                    onchange="previewDoc()" class="form-control-file">
                            </div>
                            <div class="text-center">
                                <p id="docMessage"></p>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="ver-periodo-btn2">Guardar</button>
                                <a href="<?php echo base_url("home/nomina/people"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>
    function seccionesDocs(estado) {
        var valor = estado.value;

        // Oculta ambas secciones
        document.getElementById('infoSection').style.display = 'none';
        document.getElementById('cvSection').style.display = 'none';
        document.getElementById('contratoSection').style.display = 'none';
        document.getElementById('bancoSection').style.display = 'none';
        document.getElementById('comprobanteSection').style.display = 'none';
        document.getElementById('estudiosSection').style.display = 'none';
        document.getElementById('rfcSection').style.display = 'none';
        document.getElementById('d_bancariosSection').style.display = 'none';
        document.getElementById('beneficiarioSection').style.display = 'none';

        //console.log(valor);

        // Muestra la sección correspondiente
        if (valor === 'cv') {
            document.getElementById('cvSection').style.display = 'block';

        } else if (valor === 'info') {
            document.getElementById('infoSection').style.display = 'block';

        } else if (valor === 'contrato') {
            document.getElementById('contratoSection').style.display = 'block';

        } else if (valor === 'banco') {
            document.getElementById('bancoSection').style.display = 'block';

        } else if (valor === 'domicilio') {
            document.getElementById('comprobanteSection').style.display = 'block';

        } else if (valor === 'estudios') {
            document.getElementById('estudiosSection').style.display = 'block';

        } else if (valor === 'rfc') {
            document.getElementById('rfcSection').style.display = 'block';

        } else if (valor === 'sbancarios') {
            document.getElementById('d_bancariosSection').style.display = 'block';

        } else if (valor === 'beneficiario') {
            document.getElementById('beneficiarioSection').style.display = 'block';

        }

    }

</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    jQuery(document).ready(function ($) {
        // Captura el evento de envío del formulario
        $('#formInfo').submit(function (event) {
            // Evita que el formulario se envíe de forma predeterminada
            event.preventDefault();

            var r = confirm("Es necesario que revises bien la información antes de guardarlo por favor, asegurate que esté bien por favor.");
            if (r == true) {

                $('#formInfo')[0].submit();
                alert("Se ha guardado el estado");
            }
            else {


                alert("No se envió.");
            }
            // // Agrega la clase 'loading' al body para aplicar el fondo blanco
            // $('body').addClass('loading');

            // // Muestra el spinner
            // $('#loading-spinner').show();

            // // Envía el formulario después de un breve retraso
            // setTimeout(function () {
            //   $('#login-form')[0].submit();
            // }, 2000);
        });

    });
</script>
<script>
    function calcularSueldo1() {
        // Obtener el valor del pago mensual base
        var pagoMensualBase = document.getElementById("formInfo").elements["pago_mensual_base"].value;

        // Realizar cálculos
        var pagoQuincenal = (pagoMensualBase / 2).toFixed(2);
        var sueldoDiario = (pagoQuincenal / 15).toFixed(2);

        // Actualizar los campos de resultado
        document.getElementById("formInfo").elements["pago_quincenal"].value = pagoQuincenal;
        document.getElementById("formInfo").elements["sueldo_diario"].value = sueldoDiario;
    }
</script>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>