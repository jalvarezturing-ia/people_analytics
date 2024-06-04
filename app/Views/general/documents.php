<?php include("header.php"); ?>


<div class="info-card vertical">
    <h4 class="title-wish"><a href="<?php echo base_url("/home/account"); ?>">Ajustes | Configuración del perfil </a>  | Curriculum Vitae </h4>
    <div>
        <div class="card-header text-center">
            <strong><i class='fas fa-file-alt' style="color: #3498db;"></i> Curriculum vitae</strong>
        </div>

        <?php if (!empty($name_doc)) { ?>

            <div style="text-align: center; margin-top: 20px;">

                <embed src="<?php echo base_url("/cvs/$name_doc"); ?>" type="application/pdf" width="800" height="600">
            </div>
        <div style="text-align:center;">
        <a href="<?php echo base_url("home/account"); ?>"
                                    class="ver-periodo-btn1">Retroceder</a>
                                </a>
        </div>
           

        <?php } ?>
        <?php if (empty($name_doc)) { ?>
            <div class="col-lg-12 col-md-6 mt-4">
                <div class="alert alert-danger" style="text-align: center;"><i class="fa fa-exclamation-circle"></i> Tu organización administra tu CV </div>
            </div>
            <div style="text-align:center;">
                <a href="<?php echo base_url("home/account"); ?>" class="ver-periodo-btn1">Retroceder</a>
                </a>
            </div>
        <?php } ?>


    </div>
</div>





</div>














<?php include("footer.php"); ?>