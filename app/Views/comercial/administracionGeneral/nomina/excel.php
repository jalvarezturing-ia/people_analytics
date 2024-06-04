<?= $this->include('comercial/administracionGeneral/header') ?>

<div class="info-card vertical">
    <h4 class="title-wish"><a href="<?php echo base_url("/home/nomina"); ?>"> Nóminas </a> Generar excel <i
            class="fas fa-file-alt"></i></h4>
    <div>
        <div class="card-header text-center">
            <strong><i class='fas fa-file-alt' style="color: #3498db;"></i> Cargar excel para insertar datos </strong>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Deberás cargar una plantilla vacia de excel en formado .xlsx, guardarla y este te exportara los datos que solicitaste.
            </small>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-6 bg-light p-3">
                <form action="<?php echo base_url('home/archive/process'); ?>" enctype="multipart/form-data"
                    method="post" class="form-inline">

                    <div class="form-group mb-2">
                        <input type="hidden" name="periodo" value="<?= $periodo; ?>">
                        <input type="hidden" name="mes" value="<?= $mes; ?>">
                        <input type="hidden" name="estado" value="<?= $estado; ?>">
                        <input type="hidden" name="inicio" value="<?= $inicio; ?>">
                        <input type="hidden" name="fin" value="<?= $fin; ?>">
                        <input type="file" name="documento" id="docInput" required="" accept=".xlsm, .XLS, .xlsx"
                            onchange="previewDoc()" class="form-control-file">
                    </div>

                    <div class="text-center">
                        <p id="docMessage"></p>
                    </div>


                    <div style="text-align:center;">

                        <button type="submit" class="ver-periodo-btn2">Guardar</button>
                        <a href="<?php echo base_url("home/board/$periodo/$mes/$estado/$inicio/$fin"); ?>" class="ver-periodo-btn1">Retroceder</a>
                        </a>

                    </div>

                </form>
            </div>
        </div>
    </div>





</div>

<?= $this->include('comercial/administracionGeneral/footer') ?>


<script>
    function previewDoc() {
        var input = document.getElementById('docInput');
        var message = document.getElementById('docMessage');

        if (input.files && input.files[0]) {
            // Obtener el nombre del archivo seleccionado
            var fileName = input.files[0].name;
            message.innerText = 'Documento seleccionado: ' + fileName;
        } else {
            message.innerText = 'No se ha seleccionado un documento DOCX';
        }
    }
</script