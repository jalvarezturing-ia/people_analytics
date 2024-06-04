<?php include("header.php"); ?>



<div class="info-card vertical">
    <h4 class="title-wish"><a href="<?php echo base_url('/home/account') ?>">Configuración de mi cuenta ></a> Foto de perfil <i class="fas fa-image"></i></h4>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong><i class="fas fa-image"></i> Avatar del usuario</strong>
        </div>

        <div class="container">
            <div class="row justify-content-center">

                <div class="col-12 col-md-5 mt-4 bg-light p-3">
                    <div class="form form-group">
                        <form action="<?php echo base_url('/home/account/savepicture') ?>" enctype="multipart/form-data"
                            method="post" class="form-inline">
                            <input type="hidden" name="user_id" value="<?= $user_id ?>">

                            <!-- elemento de vista previa de la imagen -->
                            <div class="form-group mb-2">
                                <input type="file" name="imagen" id="imagenInput" required="" accept="image/*"
                                    onchange="previewImage()">
                            </div>
                            <div class="text-center">
                                <img id="imagenPreview" src="#" alt="Vista previa de la imagen"
                                    style="max-width: 100%; max-height: 300px;" class='rounded-circle img-fluid'>
                            </div>

                            <div class="form-group mx-sm-3 mb-2">
                                 <a href="<?php echo base_url("home/account"); ?>" class="ver-periodo-btn1">Retroceder</a>
                                <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>







<?php include("footer.php"); ?>