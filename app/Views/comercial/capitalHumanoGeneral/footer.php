</div>
</div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>


<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
    integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
    crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
    integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
    crossorigin="anonymous"></script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script type="text/javascript">
    // $(document).ready(function () {
    //     // Oculta el sidebar al cargar la página
    //     $('#sidebar').addClass('active');
    //     $('#santa').css('visibility', 'hidden');
    //     $('#santa1').css('visibility', 'hidden');

    //     $('#sidebarCollapse').on('click', function () {
    //         $('#sidebar').toggleClass('active');

    //         // Verifica si el sidebar tiene la clase 'active'
    //         if ($('#sidebar').hasClass('active')) {
    //             $('#santa').css('visibility', 'hidden');
    //             $('#santa1').css('visibility', 'hidden');
    //         } else {
    //             $('#santa').css('visibility', 'visible');
    //             $('#santa1').css('visibility', 'visible');
    //         }
    //     });
    // });

    $(document).ready(function () {
        // Verifica si el sidebar estaba oculto o mostrado antes de recargar la página y lo restaura
        var sidebarEstado = localStorage.getItem('sidebarEstado');
        if (sidebarEstado === 'oculto') {
            $('#sidebar').removeClass('active');
        } else {
            $('#sidebar').addClass('active');
        }

        // Asigna el evento click al botón para colapsar/expandir el sidebar
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');

            // Guarda el estado actual del sidebar en el almacenamiento local
            if ($('#sidebar').hasClass('active')) {
                localStorage.setItem('sidebarEstado', 'mostrado');
            } else {
                localStorage.setItem('sidebarEstado', 'oculto');
            }
        });
    });
</script>



<script>
    function saveCalendly(inputElement, id) {

        var valor = inputElement.value;

        console.log(valor + " " + id);

        $.ajax({
            url: '<?php echo base_url("/saveeditCalendly"); ?>',
            method: 'POST',
            data: { valor: valor, id: id },
            success: function (response) {
                console.log('Datos enviados al backend correctamente.');
                console.log(response);
                //location.reload(); // Recargar la página si es necesario
            },
            error: function (xhr, status, error) {
                console.error('Error al enviar datos al backend:', error);
            }
        });

    }
</script>

<script>
    function updateFormulario(inputElement, nombreInput, id) {

        var valor = inputElement.value;

        console.log(valor + " " + nombreInput + " " + id);

        $.ajax({
            url: '<?php echo base_url("/saveEditFormAplicant"); ?>',
            method: 'POST',
            data: { nombre: nombreInput, valor: valor, id: id },
            success: function (response) {
                console.log('Datos enviados al backend correctamente.');
                console.log(response);
                //location.reload(); // Recargar la página si es necesario
            },
            error: function (xhr, status, error) {
                console.error('Error al enviar datos al backend:', error);
            }
        });

    }
</script>

<script>


    function update1(inputElement, nombreInput, id) {

        var valor = inputElement.value;

        console.log(valor + " " + id);

        $.ajax({
            url: '<?php echo base_url("/home/saveEditEncuesta"); ?>',
            method: 'POST',
            data: { nombre: nombreInput, valor: valor, id: id },
            success: function (response) {
                console.log('Datos enviados al backend correctamente.');
                console.log(response);
                //location.reload(); // Recargar la página si es necesario
            },
            error: function (xhr, status, error) {
                console.error('Error al enviar datos al backend:', error);
            }
        });

    }


    function delUser(id) {
        console.log("Id-> " + id);


        $.ajax({
            url: '<?php echo base_url("/home/delUser"); ?>', // Especifica la URL de tu endpoint en el backend
            method: 'POST', // Método de la solicitud
            data: { id: id }, // Datos a enviar al servidor (ID y valor)
            success: function (response) {
                // Maneja la respuesta del servidor si es necesario
                console.log('Datos enviados al backend correctamente.');
                console.log(response);
                //location.reload(); // Recargar la página
                // Guardar la posición actual del scroll
                var scrollPosition = window.scrollY;

                // Mostrar el mensaje de éxito
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    confirmButtonColor: "#4CAF50",
                    confirmButtonText: "Ok",
                    text: "Usuario eliminado con éxito",
                }).then((result) => {
                    // Recargar la página después de que se cierre el mensaje de éxito
                    if (result.isConfirmed) {
                        // Restaurar la posición del scroll después de recargar la página
                        window.scrollTo(0, scrollPosition);
                        location.reload();
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error al enviar datos al backend:', error);
            }
        });
    }
</script>


<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('pendientesBtn').classList.add('activo');
    });

    function mostrarSeccion(seccion) {
        // Oculta ambas secciones
        document.getElementById('pendientesSection').style.display = 'none';
        document.getElementById('pagadosSection').style.display = 'none';

        document.getElementById('asistenciaSection').style.display = 'none';
        document.getElementById('NoasistenciaSection').style.display = 'none';

        document.getElementById('salidaSection').style.display = 'none';
        document.getElementById('nosalidaSection').style.display = 'none';

        document.getElementById('pendientesBtn1').classList.remove('activo');
        document.getElementById('pendientesBtn2').classList.remove('activo');
        document.getElementById('pendientesBtn').classList.remove('activo');
        document.getElementById('pagadosBtn').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'entrada') {
            document.getElementById('pendientesSection').style.display = 'block';
            document.getElementById('pendientesBtn').classList.add('activo');
            document.getElementById('asistenciaSection').style.display = 'block';

        } else if (seccion === 'salida') {
            document.getElementById('pagadosSection').style.display = 'block';
            document.getElementById('pagadosBtn').classList.add('activo');
            document.getElementById('salidaSection').style.display = 'block';

        } else if (seccion === 'nosalida') {
            document.getElementById('pagadosSection').style.display = 'block';
            document.getElementById('nosalidaSection').style.display = 'block';
            document.getElementById('pagadosBtn').classList.add('activo');

        } else if (seccion === 'asistencia') {
            document.getElementById('pendientesSection').style.display = 'block';
            document.getElementById('asistenciaSection').style.display = 'block';
            document.getElementById('pendientesBtn').classList.add('activo');
            document.getElementById('pendientesBtn1').classList.add('activo');

        } else if (seccion === 'noasistencia') {
            document.getElementById('pendientesSection').style.display = 'block';
            document.getElementById('NoasistenciaSection').style.display = 'block';
            document.getElementById('pendientesBtn').classList.add('activo');
            document.getElementById('pendientesBtn2').classList.add('activo');

        }
    }
</script>

<script>
    function mostrarImagen(url) {
        // Abre la imagen en una nueva ventana emergente o modal
        window.open(url, '_blank');
    }
</script>

<script>
    // Función para obtener el conteo almacenado en localStorage o 0 si no existe
    function getReactionCount(reactionType) {
        return parseInt(localStorage.getItem(`${reactionType}Count`)) || 0;
    }

    // Función para actualizar el conteo y almacenarlo en localStorage
    function updateReactionCount(reactionType, count) {
        localStorage.setItem(`${reactionType}Count`, count);
    }

    // Variables para contar las reacciones
    let likeCount = getReactionCount('like');
    let loveCount = getReactionCount('love');
    let surpriseCount = getReactionCount('surprise');

    // Función para manejar las reacciones
    function handleReaction(reactionType) {
        // Actualizar el contador según el tipo de reacción
        if (reactionType === 'like') {
            likeCount++;
        } else if (reactionType === 'love') {
            loveCount++;
        } else if (reactionType === 'surprise') {
            surpriseCount++;
        }

        // Actualizar el texto del contador en pantalla
        document.getElementById('likeCount').textContent = `${likeCount} Me gusta, ${loveCount} Me encanta, ${surpriseCount} No me gusta`;
        document.getElementById('likeCountSmall').textContent = `${likeCount} Me gusta, ${loveCount} Me encanta, ${surpriseCount} No me gusta`;

        // Almacenar el nuevo conteo en localStorage
        updateReactionCount('like', likeCount);
        updateReactionCount('love', loveCount);
        updateReactionCount('surprise', surpriseCount);
    }

    // Inicializar el texto del contador en pantalla
    document.getElementById('likeCount').textContent = `${likeCount} Me gusta, ${loveCount} Me encanta, ${surpriseCount} No me gusta`;
    document.getElementById('likeCountSmall').textContent = `${likeCount} Me gusta, ${loveCount} Me encanta, ${surpriseCount} No me gusta`;

</script>

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("periodos-table");
        tr = table.getElementsByTagName("tr");

        var found = false;

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    found = true;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Mostrar el mensaje si no se encuentra ningún periodo
        var mensajeSinPeriodo = document.getElementById("mensaje-sin-periodo");
        if (!found) {
            mensajeSinPeriodo.style.display = "block";
        } else {
            mensajeSinPeriodo.style.display = "none";
        }
    }
</script>

<script>
    function filterTable1() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search1");
        filter = input.value.toUpperCase();
        table = document.getElementById("periodos-table1");
        tr = table.getElementsByTagName("tr");

        var found = false;

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Cambiado a [0] para buscar en la columna del nombre
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    found = true;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Mostrar el mensaje si no se encuentra ningún colaborador
        var mensajeSinColaborador = document.getElementById("mensaje-sin-periodo1");
        if (!found) {
            mensajeSinColaborador.style.display = "block";
        } else {
            mensajeSinColaborador.style.display = "none";
        }
    }
</script>

<script>
    function calcularSueldo() {
        // Obtener el valor del pago mensual base
        var pagoMensualBase = document.getElementById("sueldoForm").elements["pago_mensual_base"].value;

        // Realizar cálculos
        var pagoQuincenal = (pagoMensualBase / 2).toFixed(2);
        var sueldoDiario = (pagoQuincenal / 15).toFixed(2);

        // Actualizar los campos de resultado
        document.getElementById("sueldoForm").elements["pago_quincenal"].value = pagoQuincenal;
        document.getElementById("sueldoForm").elements["sueldo_diario"].value = sueldoDiario;
    }
</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    function previewImage() {
        var input = document.getElementById('imagenInput');
        var preview = document.getElementById('imagenPreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>

<script>
    function editHora(event, id, nombre, apellido, hora, fecha, captura, tipo) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Asistencia ></a> Edición de fecha y/o hora</strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body" id="contenido-dinamico">
                            <form id="formReq" action="<?php echo base_url("/home/saveedit"); ?>" method="post"
                                enctype="multipart/form-data">
                                <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                        <div class="col-sm-4">
                        <input type="hidden" name="id_user" value="${id}" required>
                        <input type="hidden" name="tipo" value="${tipo}" required>
                        <input type="hidden" name="captura" value="${captura}" required>
                            <input type="text" name="nombre" class="form-control" value="${nombre} ${apellido}" required
                                readonly>
                        </div>
                        <label for="area" class="col-sm-2 col-form-label">Fecha:</label>
                        <div class="col-sm-4">
                        <input type="date" name="fecha_edit" class="form-control" value="${fecha}" required
                                >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fecha" class="col-sm-2 col-form-label">Hora:</label>
                        <div class="col-sm-10">
                        <input type="text" name="hora_actual" style="font-family:Century Gothic;"   placeholder = "0:00:00 pm" class="form-control" required value="${hora}" >
                        </div>
                    </div>

                                <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia (Con hora, fecha y room ya
                                        visibles sea por computador o
                                        mediante celular)</strong>
                                </div>
                                <br>
                                <div class="form-group mb-2 text-center">

                                    <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                                        required="">
                                </div>
                                 <br>
                                <div class="form-group mb-2 text-center">
                                    <img id="imagenPreview" src="#" alt="Vista previa de la captura"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                                <br>
                            </form>
                         </div>
                    </div>
                </div>`,
            showCancelButton: true,
            customClass: 'swal-wide',
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const form = document.getElementById('formReq');
                form.submit();
                /*var img = document.getElementById('imagenInput').value;

                if (img === '' || img === null) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, selecciona una imagen.',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: "Entendido",
                });
                } else {
                    const form = document.getElementById('formReq');
                    form.submit();
                }*/
            }

        });
    }
</script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('1').classList.add('activo');
    });

    function mostrarSeccion2(seccion) {

        document.getElementById('pendSection').style.display = 'none';
        document.getElementById('autoSection').style.display = 'none';

        document.getElementById('1').classList.remove('activo');
        document.getElementById('2').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'pend') {
            document.getElementById('pendSection').style.display = 'block';
            document.getElementById('1').classList.add('activo');

        } else if (seccion === 'auto') {
            document.getElementById('autoSection').style.display = 'block';
            document.getElementById('2').classList.add('activo');
        }
    }
</script>

<script>
    function crear(event, id, nombre, apellido) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Asistencia ></a> Nuevo registro</strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body" id="contenido-dinamico">
                            <form id="formReq" action="<?php echo base_url("/home/saveinputcolab"); ?>" method="post"
                                enctype="multipart/form-data">
                                <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre (s): </label>
                        <div class="col-sm-4">
                        <input type="hidden" name="id_usuario" class="form-control" value="${id}" required
                                readonly>
                            <input type="text" name="nombre" class="form-control" value="${nombre} ${apellido}" required
                                readonly>
                        </div>
                        <label for="area" class="col-sm-2 col-form-label">Fecha:</label>
                        <div class="col-sm-4">
                        <input type="date" name="fecha_edit" class="form-control" value="<?= date('Y-m-d'); ?>" required
                                >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fecha" class="col-sm-2 col-form-label">Hora:</label>
                        <div class="col-sm-10">
                        <input type="text" name="hora_actual" style="font-family:Century Gothic;"   placeholder = "0:00:00 am/pm" class="form-control" value="0:00:00 am/pm" required >
                        </div>
                    </div>

                                <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia (Con hora, fecha y room ya
                                        visibles sea por computador o
                                        mediante celular)</strong>
                                </div>
                                <br>
                                <div class="form-group mb-2 text-center">

                                    <input type="file" name="imagen" id="imagenInput" accept="image/*" onchange="previewImage()"
                                        required="">
                                </div>
                                 <br>
                                <div class="form-group mb-2 text-center">
                                    <img id="imagenPreview" src="#" alt="Vista previa de la captura"
                                        style="max-width: 100%; max-height: 300px;">
                                </div>
                                <br>
                            </form>
                         </div>
                    </div>
                </div>`,
            showCancelButton: true,
            customClass: 'swal-wide',
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                /* const form = document.getElementById('formReq');
                     form.submit();*/
                var img = document.getElementById('imagenInput').value;

                if (img === '' || img === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Por favor, selecciona una imagen.',
                        confirmButtonColor: '#3498db',
                        confirmButtonText: "Entendido",
                    });
                } else {
                    const form = document.getElementById('formReq');
                    form.submit();
                }
            }

        });
    }
</script>

<script>

    function eliminar(event, id, captura) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará su selección. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4CAF50',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/eliminarP/'); ?>${id}/${captura}`;
                window.location.href = url;
            }
        });
    }
</script>
<script>
    function detalle(event, descripcion) {
        event.preventDefault(); // Evita que el enlace realice su acción predeterminada
        Swal.fire({
            title: 'Detalles del motivo',
            text: descripcion, // Aquí debes utilizar la variable descripcion
            icon: 'info',
            confirmButtonColor: '#1371C7',
            confirmButtonText: "Entendido",
        });
    }
</script>

<?php
$session = session();
$error_message = $session->getFlashdata('error_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "error",';
    echo '    title: "Error",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Entendido",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
$error_message = $session->getFlashdata('success_message');
if (!empty($error_message)) {
    echo '<script>';
    echo 'Swal.fire({';
    echo '    icon: "success",';
    echo '    title: "Éxito",';
    echo '    confirmButtonColor: "#4CAF50",';
    echo '    confirmButtonText: "Entendido",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
?>

</body>

</html>