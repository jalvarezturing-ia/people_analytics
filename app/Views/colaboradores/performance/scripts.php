

<script>
    function newFdb(event) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance ></a> Feedbacks
        <i class="fas fa-info-circle"></i>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Detalle
            <i class='fas fa-exclamation-circle'></i>
        </button>
        <div class="dropdown-menu acciones">
            <a href="#!" onclick="newFdb(event)"><i class="fa fa-paper-plane" style="color: #3498db"></i> Dar feedback -
                23 </a> <br>
        </div>
    </h4>
    <hr>
    <div>
        <div class="card-header" style="text-align: center;">
            <strong> <i class="fas fa-paper-plane" style="color: #3498db;"></i> Dar un feedback</strong>
            <small id="passwordHelpBlock" class="form-text text-muted">
                ¡Que tengan un excelente día!
            </small>
        </div>
        <div class="card-body" id="contenido-dinamico">
            <form id="formulario1" action="<?php echo base_url("/home/savefedback"); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">¿A quién está dirigido? </label>
                    <div class="col-sm-4">
                        <select name="id_usuario" id="" class="form-control" required>
                            <option value="" selected>Selecciona el colaborador</option>
                            <?php foreach ($people as $lista): ?>
                                    <option value="<?php echo $lista->id; ?>">
                                        <?php echo $lista->nombre . " " . $lista->apellido_paterno . " " . $lista->apellido_materno; ?>
                                    </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="fecha_creacion" value="<?= date('Y-m-d\TH:i'); ?>">
                    <input type="hidden" name="id_autor" class="form-control" value="<?= session('user_id'); ?>">
                    <label for="area" class="col-sm-2 col-form-label">¿Quién lo puede ver?</label>
                    <div class="col-sm-4">
                        <!-- The second value will be selected initially -->
                        <select name="privacidad" class="form-control" required>
                            <option value="" selected>Selecciona la privacidad</option>
                            <option value="0">Todos</option>
                            <option value="1">Colaborador</option>
                            <option value="2">Solo yo</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Titulo del feedback: </label>
                    <div class="col-sm-10">
                        <input type="text" name="titulo" id="titulo" class="form-control" required
                            placeholder="Escribe el título aquí">
                    </div>
                   
                    <label for="Contenido" class="col-sm-2 col-form-label">Contenido: </label>
                    <div class="col-sm-10">
                        <textarea name="contenido" id="contenidoData" placeholder="Entrega tu feedback"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
                `,
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            customClass: 'swal-wide',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar',
            didRender: () => {
                // Inicializa Quill cuando el modal se haya renderizado completamente
                ClassicEditor.create(document.querySelector('#contenidoData'));
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formulario1');
                form.submit();
            }
        });
    }
</script>


<script>
    ClassicEditor.create(document.querySelector('#contenidoData'));
</script>


