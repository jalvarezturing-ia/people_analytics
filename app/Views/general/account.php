<?php include("header.php"); ?>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #21f367;
}

input:focus + .slider {
  box-shadow: 0 0 1px #21f367;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<div class="info-card vertical">
    <h4 class="title-wish">Ajustes | Configuración del perfil <i class="fas fa-user"></i> </h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-user" style="color: #3498db;"></i> Información personal</strong>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('/home/account/upContra') ?>" method="post" enctype="multipart/form-data">
                <?php foreach ($cuenta as $data):
                  date_default_timezone_set('America/Mexico_City');
                  setlocale(LC_TIME, "spanish");
                    $foto = $data->foto_perfil; 
                    /*$fecha_nac = date("d/M/Y", strtotime($data->fecha_nacimiento));
                    $fecha_ing = date("d/M/Y", strtotime($data->fecha_ingreso));*/
                    $fecha_nac = strftime("%d/%B/%Y", strtotime($data->fecha_nacimiento));
                    $fecha_ing = strftime("%d/%B/%Y", strtotime($data->fecha_ingreso));
                    ?>
                    <div class="mb-4">
                        <!-- Sección para cambiar la foto de perfil -->
                        <?php
                        if ($foto == 'perfil.png') {
                            echo "<a href='" . base_url('/home/account/editpicture') . "'><img src='" . base_url('/fotos_colab/perfil.png') . "' class='rounded-circle img-fluid' style='width: 80px; height: 80px; object-fit: cover;'></a>";
                        } else {
                            echo "<a href='" . base_url('/home/account/editpicture') . "'><img src='" . base_url('/fotos_colab/' . $foto) . "' class='rounded-circle img-fluid' style='width: 80px; height: 80px; object-fit: cover;'></a>";
                        }
                        ?>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre (s) y apellidos:</label>
                        <div class="col-sm-4">
                            <input type="hidden" name="user_id" class="form-control" value="<?= $data->id_user; ?>">
                            <input type="text" name="nombre" class="form-control" value="<?= $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno; ?>" readonly>
                        </div>
                        <label for="telefono" class="col-sm-2 col-form-label">Teléfono:</label>
                        <div class="col-sm-4">
                            <input type="text" name="telefono" class="form-control" value="<?= $data->telefono; ?>" required
                                readonly>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        
                        <label for="descripcion" class="col-sm-2 col-form-label">Fecha nacimiento:</label>
                        <div class="col-sm-4">
                            <input type="text" name="fecha_nacimiento" class="form-control"
                                value="<?= $fecha_nac; ?>" required readonly>
                        </div>
                        <label for="correo" class="col-sm-2 col-form-label">Sexo:</label>
                        <div class="col-sm-4">
                            <input type="text" name="sexo" class="form-control"
                            value="<?= $data->sexo; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        
                        <label for="descripcion" class="col-sm-2 col-form-label">Dirección:</label>
                        <div class="col-sm-10">
                            <input type="text" name="direccion" class="form-control" value="<?= $data->direccion; ?>"
                                required readonly>
                        </div>
                    </div>

                    <div class="card-header" style="text-align: center;">
                <strong> <i class="fas fa-building"  style="color: #3498db;"></i> Información empresarial  </strong>
                </div>
                <p></p>

                <div class="form-group row">
                        <label for="correo" class="col-sm-2 col-form-label">Correo:</label>
                        <div class="col-sm-4">
                            <input type="text" name="correo" class="form-control" value="<?= $data->correo; ?>" readonly>
                        </div>
                        <label for="descripcion" class="col-sm-2 col-form-label">Área:</label>
                        <div class="col-sm-4">
                            <input type="text" name="descripcion" class="form-control" value="<?= $data->descripcion; ?>"
                                readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="correo" class="col-sm-2 col-form-label">Ingreso a <strong>TURING-IA:</strong></label>
                        <div class="col-sm-4">
                            <input type="text" name="fecha_ingreso" class="form-control"
                                value="<?= $fecha_ing; ?>" readonly>
                        </div>
                        <label for="correo" class="col-sm-2 col-form-label">Puesto:</label>
                        <div class="col-sm-4">
                            <input type="text" name="puesto" class="form-control" value="<?= $data->puesto; ?>" readonly>
                        </div>
                    </div>

                       <?php 
                       $rol = session('rol');
                       if($rol == 'directivo' || $rol == 'admin1' || $rol == 'admin2'): ?>
                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-2 col-form-label">Desactivar modulos:</label>
                            <div class="col-sm-10">
                                <label class="switch">
                                    <input type="checkbox" id="status" onclick='onOff()'>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- <script>

                        var inputs = document.querySelectorAll('input[type="text"]');
                            for (var i = 0; i < inputs.length; i++) {
                                inputs[i].readOnly = !inputs[i].readOnly;
                            }

                        </script> -->

                       <?php else: ?>
                    <div class="card-header" style="text-align: center;">
                         <!-- <strong> <i class="fas fa-arrow-up" style="color: #3498db;"></i> Carga de archivos </strong>-->
                        <strong> <i class="fas fa-file-alt" style="color: #3498db;"></i> Vista de archivos </strong>
                    </div>
                    <p></p>
                    <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <a href="<?php echo base_url("home/account/cv/$id_usuario"); ?>" class="ver-periodo-btn">
                                <i class='fas fa-file-alt'></i> CV</a>
                                <a href="<?php echo base_url("home/account/contract/$id_usuario"); ?>" class="ver-periodo-btn">
                                <i class='fas fa-file-alt'></i> Contrato</a>
                            </div>
                        </div>
                        <?php
                   endif;
                       ?>
                    <div class="card-header" style="text-align: center;">
                        <strong> <i class="fas fa-lock" style="color: #3498db;"></i> Cambio de contraseña </strong>
                    </div>
                    <p></p>

                    <div class="form-group row">
                        <label for="new_password" class="col-sm-2 col-form-label">Nueva Contraseña:</label>
                        <div class="col-sm-4">
                            <input type="password" name="new_password" class="form-control" placeholder="Contraseña"
                                
                                title="La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres" required>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres.
                            </small>
                        </div>
                        <label for="v_password" class="col-sm-2 col-form-label">Válida Contraseña:</label>
                        <div class="col-sm-4">
                            <input type="password" name="v_password" class="form-control" placeholder="Contraseña"
                                
                                title="La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres" required>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                La contraseña debe ser alfanumérica y tener entre 4 y 10 caracteres.
                            </small>
                        </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <a href="<?php echo base_url("home/index"); ?>" class="ver-periodo-btn1">Retroceder</a>
                                <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </form>
        </div>
    </div>
</div>



<!-- Formulario oculto -->
<form id="formulario" method="post" action="<?php echo base_url("home/savemodulos") ?>" style="display: none;">
    <input type="hidden" name="id_periodo" id="id_periodo">
</form>


<script>


let estado = '<?= session('estado'); ?>';

document.getElementById("status").checked=estado==1?true:false;




    var status2=document.getElementById("status");

    function onOff()
    {
        status=(status2.checked)?1:0
        
        
        if(status == 1)
        {

            var r = confirm("¿Desea desactivar los modulos?");
                if (r == true) {
                    
                    document.getElementById("id_periodo").value = status;
                    document.getElementById("formulario").submit();
                    alert("Se ha guardado el estado");
                }
                else {

                    document.getElementById("status").checked = false;
                    alert("No se envió.");
                }

        } else if (status == 0)
        {

            
            var r = confirm("¿Desea activar los modulos?");
                if (r == true) {
                    
                    document.getElementById("id_periodo").value = status;
                    document.getElementById("formulario").submit();
                    alert("Se ha guardado el estado");
                }
                else {

                    document.getElementById("status").checked = false;
                    alert("No se envió.");
                }

        }
        
    }

</script>



<?php include("footer.php"); ?>