<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('colaboradores/header') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .container {
        display: flex;
        justify-content: center;
        /* Centra el contenido horizontalmente */
        align-items: stretch;
        /* Hace que los elementos del contenedor se estiren verticalmente */

        border: solid none;
        height: auto;
    }


    .card-header:first-child {
        border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
    }

    .card-header {
        display: flex;
        align-items: center;
        border-bottom-width: 1px;
        padding-top: 0;
        padding-bottom: 0;
        padding-right: 0.625rem;
        height: 3.5rem;
        background-color: #fff;
    }

    .widget-subheading {
        color: #858a8e;
        font-size: 10px;
        width: 500px;
    }

    .card-header.card-header-tab .card-header-title {
        display: flex;
        align-items: center;
        white-space: nowrap;
        text-align: center;
    }

    .card-header .header-icon {
        font-size: 1.65rem;
        margin-right: 0.625rem;
    }

    .btn-actions-pane-right {
        margin-left: auto;
        white-space: nowrap;
    }

    .text-capitalize {
        text-transform: capitalize !important;
    }

    .scroll-area-sm {
        height: 388px;
        overflow-x: hidden;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 0.75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .list-group {
        display: flex;
        flex-direction: column;
        padding-left: 0;
        margin-bottom: 0;
    }

    .todo-indicator {
        position: absolute;
        width: 4px;
        height: 60%;
        border-radius: 0.3rem;
        left: 0.625rem;
        top: 20%;
        opacity: .6;
        transition: opacity .2s;
    }

    .bg-warning {
        background-color: #f7b924 !important;
    }

    .widget-content {
        padding: 1rem;
        flex-direction: row;
        align-items: center;
    }

    .widget-content .widget-content-wrapper {
        display: flex;
        flex: 1;
        position: relative;
        align-items: center;
    }

    .widget-content .widget-content-right.widget-content-actions {
        visibility: hidden;
        opacity: 0;
        transition: opacity .2s;
    }

    .widget-content .widget-content-right {
        margin-left: auto;
    }

    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .btn {
        position: relative;
        transition: color 0.15s, background-color 0.15s, border-color 0.15s, box-shadow 0.15s;
    }

    .btn-outline-success {
        color: #3ac47d;
        border-color: #3ac47d;
    }

    .btn-outline-success:hover {
        color: #fff;
        background-color: #3ac47d;
        border-color: #3ac47d;
    }

    .btn-primary {
        color: #fff;
        background-color: #3f6ad8;
        border-color: #3f6ad8;
    }

    .btn {
        position: relative;
        transition: color 0.15s, background-color 0.15s, border-color 0.15s, box-shadow 0.15s;
        outline: none !important;
    }

    .card-footer {
        background-color: #fff;
    }
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/onboarding"); ?>">Performance | Onboarding | Nuevo
            checklist</a>
        <i class="fa fa-tasks"></i>
    </h4>
    <hr>
    <div class="card-body">
        <div class="row d-flex justify-content-center container">
            <div class="col-md-12">
                <div class="card-hover-shadow-2x mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize  font-weight-normal"><i
                                class="fa fa-tasks"></i>&nbsp;
                            <?= strtoupper($titulo) ?>
                        </div>
                    </div>
                    <div class="scroll-area-sm">
                        <perfect-scrollbar class="ps-show-limits">
                            <div style="position: static;" class="ps ps--active-y">
                                <div class="ps-content"> 
                                    <?php if (empty($activities)): ?>
                                        <br>
                                        <div class="alert alert-info" style="text-align: center;">No hay objetivos registrados tuyos, todo
                                            va bien por aquí
                                            <?= session('nombre'); ?> &#128561;
                                        </div>
                                    <?php else: ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($activities as $activiti): ?>
                                            <li class="list-group-item">
                                                <div class="todo-indicator bg-primary"></div>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-2">
                                                            <!-- <div class="custom-checkbox custom-control"><input
                                                                class="custom-control-input" id="exampleCustomCheckbox4"
                                                                type="checkbox"><label class="custom-control-label"
                                                                for="exampleCustomCheckbox4">&nbsp;</label></div> -->
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading"><input type="text" name="nombre"
                                                                    class="form-control" style="border:none;"
                                                                    value="<?= $activiti->actividad; ?>" required
                                                                    oninput="update1(this, '<?php echo $activiti->id ?>' )">
                                                            </div>
                                                            <hr>
                                                            <div class="widget-subheading"><input type="number" name="area"
                                                                    id="values" min="0" max="100" class="form-control"
                                                                    value="<?= $activiti->estado; ?>" required
                                                                    oninput="update1(this, '<?php echo $activiti->id ?>' )"
                                                                    style="border:none;"></div>
                                                        </div>

                                                        <div class="widget-content-right">
                                                            <!-- <button class="border-0 btn-transition btn btn-outline-success">
                                                                <i class="fa fa-check"></i>
                                                            </button> -->
                                                            <button class="border-0 btn-transition btn btn-outline-danger" onclick="todo1(this, '<?php echo $activiti->id ?>')">
                                                               
                                                                <i class="fa fa-trash"></i>

                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </perfect-scrollbar>
                    </div>
                    <form action="<?php echo base_url('home/savelistcheck'); ?>" method="POST">
                        <div id="nuevoInput"> </div>
                        <br>
                        <input type="submit" id="tecnicaHab" class="btn ver-periodo-btn" value="Guardar"
                            style="display: none;">
                        <input type="hidden" name="dato_id" value="<?= $id_dato ?>">
                        <input type="hidden" name="titulo" value="<?= $titulo ?>">
                    </form>
                    <div class="d-block text-right card-footer">
                        <button class="btn ver-periodo-btn2" onclick="agregarInput()" id="agregarBtn">+ Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function agregarInput() {
            var nuevoInput = document.createElement('input');
            nuevoInput.type = 'text';
            nuevoInput.name = 'nuevoValues[]';
            nuevoInput.style = 'text-align: center;';
            nuevoInput.style = 'border-radius: 1rem;';
            nuevoInput.placeholder = 'Nueva actividad';
            nuevoInput.className = 'form-control';
            nuevoInput.required = 'required';

            var contenedor = document.getElementById('nuevoInput');
            contenedor.appendChild(nuevoInput);

            // Mostrar el botón de enviar cuando se agrega un nuevo input
            document.querySelector('input[type="submit"]').style.display = 'inline-block';
        }



        function update1(inputElement, id) {

            var valor = inputElement.value;

            console.log(valor + " " + id);

            $.ajax({
                url: '<?php echo base_url("/home/savelistaEdit"); ?>', // Especifica la URL de tu endpoint en el backend
                method: 'POST', // Método de la solicitud
                data: { id: id, valor: valor }, // Datos a enviar al servidor (ID y valor)
                success: function (response) {
                    // Maneja la respuesta del servidor si es necesario
                    console.log('Datos enviados al backend correctamente.');
                    console.log(response);
                    //location.reload(); // Recargar la página
                },
                error: function (xhr, status, error) {
                    // Maneja errores si ocurrieron durante la solicitud AJAX
                    console.error('Error al enviar datos al backend:', error);
                }
            });

        }

        function todo1(inputElement, id) {

            var valor = inputElement.value;

            console.log(valor + " " + id);


            var r = confirm("¿Desea eliminar la actividad?");
                if (r == true) {
                    const url = `<?php echo base_url('/home/urlprueba/'); ?>${id}/`;
                    window.location.href = url;
                    alert("Se ha eliminado la actividad.");
                    location.reload(); // Recargar la página
                }
                else {

                    alert("No se envió.");
                }

        }

    </script>
    <?= $this->include('colaboradores/footer') ?>