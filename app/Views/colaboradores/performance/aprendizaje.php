<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('colaboradores/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance |</a> Centro de
        aprendizaje
        <i class="fas fa-info-circle"></i>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Detalle
            <i class='fas fa-exclamation-circle'></i>
        </button>
        <div class="dropdown-menu acciones">

            <a href="<?php echo base_url("home/aprendizaje/nuevaM/$id"); ?>"><i class="fas fa-plus"
                    style="color: green;"></i> Nueva meta
            </a><br>
            <a href="#!" onclick="newObjet(event)"><i class="fas fa-plus" style="color: green;"></i> Nuevo objetivo
            </a>
        </div>
    </h4>
    <hr>

    <div class="card-header" style="text-align: center;">
        <strong> <i class="fas fa-info-circle" style="color: #3498db;"></i> Vista de control de performance
        </strong>
        <hr>
        <a href="#" class="ver-periodo-btn" onclick="planes('cursos')" id="cursos" data-toggle="tooltip"
            data-placement="bottom" title="Reporte de metas"> <i class="fas fa-clock"></i>
            Metas y cursos
        </a>|

        <a href="#" class="ver-periodo-btn" onclick="planes('plan')" id="plan" data-toggle="tooltip"
            data-placement="bottom" title="Plan de carrera"> <i class="fas fa-check-circle"></i>
            Plan de carrera </a>
    </div>

    <div class="card-body" id="cursosSection">

        <?php if (empty ($cursos)): ?>

            <div class="alert alert-danger" style="text-align: center;">No hay cursos registrados tuyos reportadas, todo va
                bien por aquí
                <?= session('nombre'); ?> &#128561;
            </div>

        <?php else: ?>
            <table>
                <tr style="font-weight: bold; text-align:center;">
                    <th>Tipo</th>
                    <th>Tema</th>
                    <th>URL Curso</th>
                    <th>Tiempo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Observaciones</th>
                    <th>Estado</th>
                    <th>Menú</th>
                </tr>
                <?php foreach ($cursos as $curso):
                    date_default_timezone_set('America/Mexico_City');
                    setlocale(LC_TIME, "spanish");
                    $inicio = strftime("%d/%B/%Y", strtotime($curso->f_inicio));
                    $fin = strftime("%d/%B/%Y", strtotime($curso->f_fin));
                    ?>
                    <tr style="text-align:center;">
                        <td>
                            <?= $curso->tipo; ?>
                        </td>
                        <td>
                            <?php
                            $descripcion = strlen($curso->tema) > 15 ? substr($curso->tema, 0, 15) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($curso->tema) . '\')">...</a>' : $curso->tema;
                            echo $descripcion;
                            ?>
                        </td>
                        <td style="color:blue;">
                            <?php
                            $descripcion = strlen($curso->url_curso) > 15 ? substr($curso->url_curso, 0, 15) . '<a href="#!" style="color:blue;" target="_blank" onclick="detalle(event, \'' . htmlspecialchars($curso->url_curso) . '\')">...</a>' : $curso->url_curso;
                            echo $descripcion;
                            ?>
                        </td>
                        <td>
                            <!-- <input type="text" class="form-control" id="tiempo" value="<?= $curso->tiempo; ?>" oninput="updateEstado(this, '<?php echo $curso->id ?>')"> -->
                            <?= $curso->tiempo; ?>
                        </td>
                        <td>
                            <?= $inicio; ?>
                        </td>
                        <td>
                            <?= $fin; ?>
                        </td>
                        <td>
                            <?php
                            $descripcion = strlen($curso->observaciones) > 20 ? substr($curso->observaciones, 0, 20) . '<a href="#!" style="color:blue;" target="_blank" onclick="detalle(event, \'' . htmlspecialchars($curso->observaciones) . '\')">...</a>' : $curso->observaciones;
                            echo $descripcion;
                            ?>
                        </td>


                        <td>
                            <select name="estado" class="form-control" id="estado" required
                                onchange="updateEstado(this, '<?php echo $curso->id ?>')">
                                <option value="none">Seleccione</option>
                                <?php
                                $estados = ["Realizado" => "#008000", "Sin comenzar" => "#FF0000", "Trabajando" => "#40E0D0", "Detenido" => "#0071c5"];
                                foreach ($estados as $estado => $color) {
                                    $selected = ($estado === $curso->estado) ? 'selected' : ''; // Si el estado actual es igual al estado del curso, marcar como seleccionado
                                    echo '<option style="color: ' . $color . ';" value="' . $estado . '" ' . $selected . '>&#x1F7D4; ' . $estado . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td> <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;'
                                title="Menú de opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones">
                                &nbsp;<a href="#!" onclick="delCurso(event, '<?php echo $curso->id; ?>')"><i
                                        class="fas fa-trash" style="color: #3498db"></i>
                                    Eliminar curso</a><br>
                                <?php if ($curso->estado === 'Realizado'): ?>
                                    &nbsp;<a href="<?php echo base_url("home/aprendizaje/certificado/$id/$curso->id"); ?>"
                                        target="_blank"><i class="fas fa-file-pdf" style="color: red;"></i>
                                        Certificado curso</a><br>
                                <?php else: ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="card-body" id="planSection" style="display:none;">
        <?php if (empty ($objetivos)): ?>

            <div class="alert alert-danger" style="text-align: center;">No hay objetivos registrados tuyos reportados, todo
                va bien por aquí
                <?= session('nombre'); ?> &#128561;
            </div>
        <?php else: ?>

            <table>
                <tr style="font-weight: bold; text-align:center;">
                    <th>Objetivo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Progreso</th>
                    <th>Menú</th>

                </tr>

                <?php foreach ($objetivos as $objetivo):
                    date_default_timezone_set('America/Mexico_City');
                    setlocale(LC_TIME, "spanish");
                    $inicio = strftime("%d/%B/%Y", strtotime($objetivo->fecha_inicio));
                    $fin = strftime("%d/%B/%Y", strtotime($objetivo->fecha_fin));
                    ?>
                    <tr style="text-align:center;">
                        <td>
                            <?= $objetivo->titulo; ?><br>
                            <?= $inicio . " - " . $inicio ?>
                        </td>
                        <td>
                            <?php
                            $descripcion = strlen($objetivo->descripcion) > 20 ? substr($objetivo->descripcion, 0, 20) . '<a href="#!" style="color:blue;" target="_blank" onclick="detalle(event, \'' . htmlspecialchars($objetivo->descripcion) . '\')">...</a>' : $objetivo->descripcion;
                            echo $descripcion;
                            ?>
                        </td>
                        <style>
                            .progress-bar-container {
                                width: 100%;
                                height: 5px;
                                background-color: #f2f2f2;
                                border-radius: 4px;
                                margin-top: 5px;
                            }

                            .progress-bar {
                                height: 100%;
                                background-color: #34db6c;
                                border-radius: 4px;
                                transition: width 0.3s ease-in-out;
                                /* Establecer altura mínima para la barra de progreso */
                                min-width: 5px;
                                /* Ajusta este valor según tu diseño */
                            }

                            .animation-container {
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -50%);
                            }

                            @keyframes bounce {

                                0%,
                                20%,
                                50%,
                                80%,
                                100% {
                                    transform: translateY(0);
                                }

                                40% {
                                    transform: translateY(-30px);
                                }

                                60% {
                                    transform: translateY(-15px);
                                }
                            }

                            .balloon {
                                animation: bounce 50s ease-in-out;
                            }
                        </style>
                        <td>
                            <select name="estado" class="form-control" id="estado" required
                                onchange="updateEstadoCurso(this, '<?php echo $objetivo->id ?>')">
                                <option value="none">Seleccione</option>
                                <?php
                                $estados = ["Realizado" => "#008000", "Sin comenzar" => "#FF0000", "Trabajando" => "#40E0D0", "Detenido" => "#0071c5"];
                                foreach ($estados as $estado => $color) {
                                    $selected = ($estado === $objetivo->estado) ? 'selected' : ''; // Si el estado actual es igual al estado del curso, marcar como seleccionado
                                    echo '<option style="color: ' . $color . ';" value="' . $estado . '" ' . $selected . '>&#x1F7D4; ' . $estado . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="<?= $objetivo->porcentaje ?>" class="form-control" name="porcentaje"
                                id="porcentaje<?= $objetivo->id ?>" oninput="updateEstadoCurso(this, '<?= $objetivo->id ?>')">
                            <div class="progress-bar-container">
                                <div class="progress-bar" id="progress-bar<?= $objetivo->id ?>"></div>
                            </div>
                            <div class="animation-container" id="animation-container<?= $objetivo->id ?>"></div>
                        </td>
                        <td>
                            <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style='float: right;'
                                title="Menú de opciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-caret-down'></i>
                            </button>
                            <div class="dropdown-menu acciones">
                                &nbsp;<a href="#!" onclick="delObject(event, '<?php echo $objetivo->id; ?>')"><i
                                        class="fas fa-trash" style="color: #3498db"></i>
                                    Eliminar objetivo</a>

                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <!-- <?php if (empty ($plan)): ?>

            <div class="alert alert-danger" style="text-align: center;">No hay planes registrados tuyos reportadas, todo va
                bien por aquí
                <?= session('nombre'); ?> &#128561;
            </div>

        <?php else: ?> -->


            <!-- <?php endif; ?> -->

    </div>

</div>





<script>
    function newObjet(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Performance ></a>Crear objetivo</strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                1. En caso de tener algún problema en el envío de su captura, favor de reportarse inmediatamente
                                con Mayte López del área de Capital humano.<br>

                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <form id="formReq" action="<?php echo base_url("/home/saveObjetivo"); ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body" id="contenido-dinamico">
                        <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Titulo:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                    <input type="text" id="titulo" name="titulo" class="form-control" required
                            >
                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Fecha inicio:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">
                        <input type="date" id="f_inicio" name="f_inicio" class="form-control" required
                            >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Fecha fin:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">

                        <input type="date" id="f_fin" name="f_fin" class="form-control" required
                            >

                    </div>
                    <label for="area" class="col-sm-2 col-form-label">Descripción: <span
                            style="color:red;">*</span></label>
                    <div class="col-sm-4">

                        <textarea name="descripcion" class="form-control" id="descripcion"
                            
                            rows="3" minlength="3" maxlength="5000" required></textarea>
                    </div>

                    
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Estado:<span
                            style="color:red;">*</span></label>
                    <div class="col-sm-10">

                    <select name="estado" class="form-control" id="estado" required>
                        <option value="none">Seleccione</option>
                        <option style="color:#008000;" value="Realizado">&#9724; Realizado</option>
                        <option style="color:#FF0000;" value="Sin comenzar">&#9724; Sin comenzar</option>
                        <option style="color:#40E0D0;" value="Trabajando">&#9724; Trabajando</option>
                        <option style="color:#0071c5;" value="Detenido">&#9724; Detenido</option>
                    </select>

                    </div>
                </div>
                                <br>
                            </form>
                         </div>
                    </div>
                </div>`,
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            customClass: 'swal-wide',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const form = document.getElementById('formReq');
                form.submit();
                // var img = document.getElementById('imagenInput').value;

                // if (img === '' || img === null) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Error',
                //         text: 'Por favor, selecciona una imagen.',
                //         confirmButtonColor: '#3498db',
                //         confirmButtonText: "Entendido",
                //     });
                // } else {
                //     const form = document.getElementById('formReq');
                //     form.submit();
                // }
            }

        });
    }
</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('cursos').classList.add('activo');
    });


    function planes(seccion) {

        document.getElementById('cursosSection').style.display = 'none';
        document.getElementById('planSection').style.display = 'none';

        document.getElementById('cursos').classList.remove('activo');
        document.getElementById('plan').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'cursos') {
            document.getElementById('cursosSection').style.display = 'block';
            document.getElementById('cursos').classList.add('activo');

        } else if (seccion === 'plan') {

            document.getElementById('planSection').style.display = 'block';
            document.getElementById('plan').classList.add('activo');
            document.getElementById('cursosSection').style.display = 'none';

        }

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    // Función para actualizar la barra de progreso con el valor del porcentaje
    function updateProgressBar(id, valor) {
        // Obtener el elemento de la barra de progreso específica según el id del objetivo
        var progressBar = document.getElementById("progress-bar" + id);

        // Convertir el porcentaje a un número
        var porcentaje = parseFloat(valor);

        // Asegurarse de que el porcentaje esté en el rango de 0 a 100
        porcentaje = Math.max(0, Math.min(100, porcentaje));

        // Calcular la anchura de la barra de progreso en función del porcentaje
        var anchura = porcentaje + "%";

        // Actualizar la anchura de la barra de progreso
        progressBar.style.width = anchura;

        // Verificar si el porcentaje alcanzó el 100%
        // Verificar si el porcentaje alcanzó el 100%
        if (porcentaje === 100) {

            // Mostrar la animación de felicitaciones con globitos
            var animationContainer = document.getElementById("animation-container" + id);
            animationContainer.innerHTML = '<img class="balloon" src="<?php echo base_url("gifs/ballon.gif"); ?>" alt="Globito">';
            animationContainer.style.display = "block";

            // Ocultar la animación después de unos segundos
            setTimeout(function () {
                animationContainer.innerHTML = '';
                animationContainer.style.display = "none";
            }, 1000); // Cambia este valor (en milisegundos) según la duración deseada de la animación
        } else {
            // Ocultar la animación si el porcentaje no es 100
            var animationContainer = document.getElementById("animation-container" + id);
            animationContainer.innerHTML = '';
            animationContainer.style.display = "none";
        }
    }

    // Función para actualizar el estado del curso y la barra de progreso
    function updateEstadoCurso(inputElement, id) {
        var valor = inputElement.value;
        console.log(valor + " id " + id);

        // Actualizar la barra de progreso con el nuevo valor del porcentaje
        updateProgressBar(id, valor);




        $.ajax({
            url: '<?php echo base_url("/home/saveProgress"); ?>', // Especifica la URL de tu endpoint en el backend
            method: 'POST', // Método de la solicitud
            data: { id: id, valor: valor }, // Datos a enviar al servidor (ID y valor)
            success: function (response) {
                // Maneja la respuesta del servidor si es necesario
                console.log('Datos enviados al backend correctamente.');
            },
            error: function (xhr, status, error) {
                // Maneja errores si ocurrieron durante la solicitud AJAX
                console.error('Error al enviar datos al backend:', error);
            }
        });

    }

    // Llamar a la función updateProgressBar cuando la página se cargue completamente
    window.onload = function () {
        var inputElements = document.querySelectorAll("[id^='porcentaje']");

        inputElements.forEach(function (inputElement) {
            var id = inputElement.id.replace("porcentaje", "");
            var valor = inputElement.value;
            updateProgressBar(id, valor);
        });
    };


</script>

<script>
    function updateEstado(inputElement, id) {

        var valor = inputElement.value;
        console.log(valor + " id " + id);

        if (valor === 'none') {
            alert("¡No puede dejar vacio el estado!");
        }

        else {
            $.ajax({
                url: '<?php echo base_url("/home/savecCursoEdit"); ?>', // Especifica la URL de tu endpoint en el backend
                method: 'POST', // Método de la solicitud
                data: { id: id, valor: valor }, // Datos a enviar al servidor (ID y valor)
                success: function (response) {
                    // Maneja la respuesta del servidor si es necesario
                    console.log('Datos enviados al backend correctamente.');
                    //console.log(response);
                },
                error: function (xhr, status, error) {
                    // Maneja errores si ocurrieron durante la solicitud AJAX
                    console.error('Error al enviar datos al backend:', error);
                }
            });
        }
    }


    function delCurso(event, id_comen) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la información correspondiente y dejará de estar disponible. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/delCurso/'); ?>${id_comen}/`;
                window.location.href = url;
            }
        });
    }

    function delObject(event, id_comen) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la información correspondiente y dejará de estar disponible. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/delObject/'); ?>${id_comen}/`;
                window.location.href = url;
            }
        });
    }



</script>

<?= $this->include('colaboradores/footer') ?>