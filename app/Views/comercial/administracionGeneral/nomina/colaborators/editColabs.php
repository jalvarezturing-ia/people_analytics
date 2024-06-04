<?php
$numero = 1;
$session = session();
if ($session->get('rol') == 'admin1') {
    echo $this->include('comercial/administracionGeneral/header');
} elseif ($session->get('rol') == 'admin2') {
    echo $this->include('comercial/capitalHumanoGeneral/header');
} else {

    $session->destroy();
    return redirect()->to(base_url('/'));
}
?>


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
    <h4 class="title-wish"><a href="<?php echo base_url('/home/nomina/people'); ?>">Colaboradores | </a> Información
        |<?= $puesto . ": " . $nombre . " " . $ap ?> <i class="fas fa-users"></i></h4>
    <br>
    <div class="col-md-3 " style="" id="controlButtons">
        <select name="onboardings" id="onboardings" class="form-control" style="border-radius: 1rem;"
            onchange="mostrarSeccion(this)">
            <option value="info">Información</option>
            <option value="cv">Curriculum</option>
            <option value="contrato">Contrato</option>
            <option value="banco">Datos Bancarios</option>
            <option value="domicilio">C.Domicilio</option>
            <option value="estudios">C.Estudios</option>
            <option value="rfc">RFC</option>
            <option value="sbancarios">S.Datos Bancarios</option>
            <option value="beneficiario">Beneficiari@</option>
        </select>
    </div>

    <div>
        <!-- <div class="card-header" style="text-align: center;">
            <strong>
                <i class="fas fa-edit" style="color: #3498db;"></i>
            </strong> <br><br>
            <div class="buttons-infos">
                <a href="#" class="ver-periodo-btn active" onclick="mostrarSeccion('info')" id="infoBtn">Información
                </a>|
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('cv')" id="cvBtn">Curriculum </a> |
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('contrato')" id="contratoBtn">Contrato</a>|
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('banco')" id="bancoBtn">Datos Bancarios</a>
                <hr>
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('domicilio')"
                    id="domicilioBtn">C.Domicilio</a> |
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('estudios')" id="estudiosBtn">C.Estudios</a>
                |
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('rfc')" id="rfcBtn">RFC</a> |
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('sbancarios')" id="bancariosBtn">S.Datos
                    Bancarios</a> |
                <a href="#" class="ver-periodo-btn" onclick="mostrarSeccion('beneficiario')"
                    id="beneficiarioBtn">Beneficiari@</a>
            </div>
        </div> -->
        <!-- Sección de Información Personal -->
        <div class="card-body" id="infoSection">
            <form action="<?php echo base_url('/home/nomina/updatecolab') ?>" method="post"
                enctype="multipart/form-data">
                <?php foreach ($colaborador as $data):
                    $cv = $data->curriculum_vitae;
                    $contrato = $data->contrato_vitae;
                    $domicilio = $data->c_domicilio;
                    $estudios = $data->c_estudios;
                    $rfc = $data->c_rfc;
                    $d_bancarios = $data->d_bancarios;
                    $beneficiario = $data->c_beneficiario;
                    $INE = $data->INE;
                    $CURP = $data->curp;
                    $nacimiento = $data->acta_nacimiento;
                    ?>
                    <!-- ... Código de Información Personal ... -->

                    <div class="card-header" style="text-align: center;" id="ineTitle">
                        <strong> <i class="fas fa-info" style="color: #3498db;"></i> Informacion personal </strong>
                    </div>
                    <br>
                    <div class="mb-5 text-center">
                        <!-- Sección para cambiar la foto de perfil -->
                        <?php
                        if ($data->foto_perfil == 'perfil.png' || $data->foto_perfil == NULL) {
                            echo "<img src='" . base_url('/fotos_colab/Captura.PNG') . "' class='rounded-circle img-fluid' style='width: 80px; height: 80px; object-fit: cover;'>";
                        } else {
                            echo "<a href='" . base_url('/fotos_colab/' . $data->foto_perfil) . "' target='_blank' ><img src='" . base_url('/fotos_colab/' . $data->foto_perfil) . "' class='rounded-circle img-fluid' style='width: 80px; height: 80px; object-fit: cover;'>";
                        }
                        ?>

                        <!--ELIMINAR UN COLABORADOR-->
                        <a href="#!" onclick="baja(event, <?php echo $data->id_usuario; ?>)" class="ver-periodo-btn1"
                            id="baja" style="float: right; margin-top: 20px"><i class="fas fa-times"></i>

                        </a>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre (s):</label>
                        <div class="col-sm-4">
                            <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
                            <input type="text" name="nombre" class="form-control" value="<?= $data->nombre; ?>"
                                placeholder="Ingresa el nombre del usuario" required>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Apellido Paterno:</label>
                        <div class="col-sm-4">
                            <input type="text" name="apellido_paterno" class="form-control"
                                value="<?= $data->apellido_paterno; ?>" placeholder="Ingresa el nombre del usuario"
                                required>
                        </div>

                    </div>
                    <div class="form-group row">

                        <label for="telefono" class="col-sm-2 col-form-label">Apellido Materno:</label>
                        <div class="col-sm-4">
                            <input type="text" name="apellido_materno" class="form-control"
                                value="<?= $data->apellido_materno; ?>" required>
                        </div>
                        <label for="telefono" class="col-sm-2 col-form-label">Teléfono:</label>
                        <div class="col-sm-4">
                            <input type="text" maxlength="10" name="telefono" class="form-control"
                                value="<?= $data->telefono; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label for="descripcion" class="col-sm-2 col-form-label">Fecha nacimiento:</label>
                        <div class="col-sm-4">
                            <input type="date" name="fecha_nacimiento" class="form-control"
                                value="<?= $data->fecha_nacimiento; ?>" required>
                        </div>

                        <label for="sexo" class="col-sm-2 col-form-label">Sexo:</label>
                        <div class="col-sm-4">
                            <td>
                                <select name="sexo" class="form-control">
                                    <option value="<?= $data->sexo; ?>">
                                        <?= "Actual: " . $data->sexo; ?>
                                    </option>
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
                                rows="3" minlength="3" maxlength="5000" required><?= $data->direccion; ?></textarea>

                        </div>
                    </div>

                    <div class="card-header" style="text-align: center;">
                        <strong> <i class="fas fa-building" style="color: #3498db;"></i> Información empresarial </strong>
                    </div>
                    <p></p>

                    <div class="form-group row">
                        <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                        <div class="col-sm-4">
                            <input type="text" name="correo" class="form-control" value="<?= $data->correo; ?>" required
                                placeholder="Ingresa el correo empresarial del usuario">
                        </div>
                        <label for="nombre_area" class="col-sm-2 col-form-label">Área:</label>
                        <div class="col-sm-4">
                            <td>
                                <select name="nombre_area" class="form-control">
                                    <option value="<?= $data->nombre_area; ?>">
                                        <?= "Actual: " . $data->nombre_area; ?>
                                    </option>
                                    <option value="Servicios">T.I-Servicios</option>
                                    <option value="Comercial">T.I-Comercial</option>
                                </select>
                            </td>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="correo" class="col-sm-2 col-form-label">Descripción:</label>
                        <div class="col-sm-4">
                            <td>
                                <select name="descripcion" class="form-control">
                                    <option value="<?= $data->descripcion; ?>">
                                        <?= "Actual: " . $data->descripcion; ?>
                                    </option>
                                    <option value="Infraestructura">Infraestructura</option>
                                    <option value="Desarrollo de Software">Desarrollo de Software</option>
                                    <option value="Administración">Administración</option>
                                    <option value="Administración General">Administración General</option>
                                    <option value="Dirección Comercial">Dirección Comercial</option>
                                    <option value="Dirección de Servicios">Dirección de Servicios</option>
                                    <option value="Capital Humano">Capital Humano</option>
                                    <option value="Capital Humano General">Capital Humano General</option>
                                    <option value="Tableau">Tableau</option>
                                    <option value="Project Management">Project Management</option>
                                    <option value="Jurídico">Juridico</option>
                                    <option value="Comercial">Comercial</option>
                                </select>
                            </td>
                        </div>
                        <label for="correo" class="col-sm-2 col-form-label">Puesto:</label>
                        <div class="col-sm-4">
                            <td>
                                <select name="puesto" class="form-control">
                                    <option value="<?= $data->puesto; ?>">
                                        <?= "Actual: " . $data->puesto; ?>
                                    </option>

                                    <option value="Becario">Becario</option>
                                    <option value="Practicante">Practicante</option>
                                    <option value="Lider">Lider</option>
                                    <option value="Director General">Director General</option>
                                    <option value="Dirección">Dirección</option>
                                    <option value="Trainee">Trainee</option>
                                </select>
                            </td>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="correo" class="col-sm-2 col-form-label">Ingreso a <strong>TURING-IA:</strong></label>
                        <div class="col-sm-10">
                            <input type="date" name="fecha_ingreso" class="form-control"
                                value="<?= $data->fecha_ingreso; ?>" required>
                        </div>
                    </div>



                    <p></p>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <a href="<?php echo base_url("home/nomina/people"); ?>" class="ver-periodo-btn1">Retroceder</a>
                            <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>

            <?php if ($puesto == 'Dirección' || $puesto == 'Director General'): ?>


                <script>
                    document.getElementById("controlButtons").style.display = "none";
                </script>

            <?php else: ?>


                <div class="card-header" style="text-align: center;" id="ineTitle">
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

                                            <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                                style="text-align: center;">
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

                                    <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                        style="text-align: center;">
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
                    <!-- <strong> <i class="fas fa-arrow-up" style="color: #3498db;"></i> Carga de archivos </strong>-->
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

                                            <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                                style="text-align: center;">
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

                                    <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                        style="text-align: center;">
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
                    <!-- <strong> <i class="fas fa-arrow-up" style="color: #3498db;"></i> Carga de archivos </strong>-->
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

                                            <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                                style="text-align: center;">
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

                                    <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                        style="text-align: center;">
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
                </div>

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

                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                            style="text-align: center;">
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

                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>"
                                    style="text-align: center;">
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
                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                <?php if (empty($nomina)): ?>
                    <div class="alert alert-danger" style="text-align: center;">AÚN NO EXISTEN DATOS BANCARIOS REGISTRADOS
                    </div>
                <?php else: ?>
                    <form id="bancariosForm" action="<?php echo base_url("home/nomina/savedatabank"); ?>" method="post"
                        enctype="multipart/form-data">
                        <?php foreach ($nomina as $nominas): ?>
                            <!-- ... Código de Datos Bancarios ... -->
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre Banco:</label>
                                <div class="col-sm-4">
                                    <input type="hidden" name="id_usuario" value="<?= $nominas->id_usuario; ?>">
                                    <input type="text" name="nombre_banco" class="form-control"
                                        value="<?= $nominas->nombre_banco; ?>" required>
                                </div>
                                <label for="telefono" class="col-sm-2 col-form-label">Numero de cuenta:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="numero_cuenta" class="form-control"
                                        value="<?= $nominas->numero_cuenta; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-2 col-form-label">Clabe Interbancaria</label>
                                <div class="col-sm-4">
                                    <input type="text" name="clabe_interbancaria" class="form-control"
                                        value="<?= $nominas->clabe_interbancaria; ?>">
                                </div>
                                <label for="correo" class="col-sm-2 col-form-label">Pago mensual:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="pago_mensual_base" class="form-control"
                                        value="<?= $nominas->pago_mensual_base; ?>" oninput="calcularSueldo1()">
                                </div>

                            </div>
                            <div class="form-group row">

                                <label for="nombre_area" class="col-sm-2 col-form-label">Pago quincenal:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="pago_quincenal" class="form-control"
                                        value="<?= $nominas->pago_quincenal; ?>" required>
                                </div>
                                <label for="correo" class="col-sm-2 col-form-label">Sueldo diario:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="sueldo_diario" class="form-control"
                                        value="<?= $nominas->sueldo_diario; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <a href="<?php echo base_url("home/nomina/people"); ?>" class="ver-periodo-btn1">Retroceder</a>
                                <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                            </div>
                        <?php endforeach; ?>
                    </form>

                <?php endif; ?>
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
                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                        <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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
                                <input type="hidden" name="id_usuario" value="<?= $data->id_usuario; ?>">
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

        <?php endif; ?>

    </div>
</div>


<div id="loading-spinner" class="text-center">
    <div class="spinner-overlay"></div>
    <img src="<?php echo base_url("gifs/logo.svg"); ?>" class="spinner" alt="Spinner">
    <br>
    <br>
    <br>
    <br>
    <h4>Subiendo el documento...</h4>
</div>
<?php
$session = session();
if ($session->get('rol') == 'admin1') {
    echo $this->include('comercial/administracionGeneral/footer');
} else {
    echo $this->include('comercial/capitalHumanoGeneral/footer');
}
?>

<?php include ("scripts.php"); ?>