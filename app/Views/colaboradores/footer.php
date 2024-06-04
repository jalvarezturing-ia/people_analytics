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
  
    <!-- PARA ENVIAR AL BACKEND -->


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
    function estadoOnboarding(estado) {
        var valor = estado.value;
        var proceso = document.getElementById("proceso");
        var completados = document.getElementById("completados");
        console.log(valor);

        if (valor === 'proceso') {

            proceso.style.display = 'block';
            completados.style.display = 'none';

        } else if (valor === 'finalizado') {

            completados.style.display = 'block';
            proceso.style.display = 'none';

        }

    }
</script>
<script>
    function delComen(event, id_comen) {
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

                const url = `<?php echo base_url('/home/deletecomen/'); ?>${id_comen}/`;
                window.location.href = url;
            }
        });
    }
    function delFed(event, id_comen) {
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

                const url = `<?php echo base_url('/home/deletefed/'); ?>${id_comen}/`;
                window.location.href = url;
            }
        });
    }
    function delHabi(event, id_comen) {
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

                const url = `<?php echo base_url('/home/delHabi/'); ?>${id_comen}/`;
                window.location.href = url;
            }
        });
    }
    function update(inputElement, id) {

        var valor = inputElement.value;
        
        console.log(valor + " " + id);

        $.ajax({
        url: '<?php echo base_url("/home/saveHabiEdit"); ?>', // Especifica la URL de tu endpoint en el backend
        method: 'POST', // Método de la solicitud
        data: { id: id, valor: valor }, // Datos a enviar al servidor (ID y valor)
        success: function(response) {
            // Maneja la respuesta del servidor si es necesario
            console.log('Datos enviados al backend correctamente.');
            //console.log(response);
        },
        error: function(xhr, status, error) {
            // Maneja errores si ocurrieron durante la solicitud AJAX
            console.error('Error al enviar datos al backend:', error);
        }
    });
        
    }

     
</script>
<script>
    function filterTable() {
        var input, filter, cardContainer, cards, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        cardContainer = document.getElementById("card-container");
        cards = cardContainer.getElementsByClassName("card1");

        var found = false;

        for (i = 0; i < cards.length; i++) {
            var card = cards[i];
            var name = card.querySelector(".m-b-5").textContent || card.querySelector(".m-b-5").innerText;
            if (name.toUpperCase().indexOf(filter) > -1) {
                card.style.display = "";
                found = true;
            } else {
                card.style.display = "none";
            }
        }

        // Mostrar el mensaje si no se encuentra ningún usuario
        var mensajeSinUsuario = document.getElementById("mensaje-sin-user");
        if (!found) {
            mensajeSinUsuario.style.display = "block";
        } else {
            mensajeSinUsuario.style.display = "none";
        }
    }


</script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('b1').classList.add('activo');
    });


    function mostrarc(seccion) {

        document.getElementById('feedbackSection').style.display = 'none';
        document.getElementById('desempeñoSection').style.display = 'none';
        document.getElementById('competenciasSection').style.display = 'none';


        document.getElementById('b1').classList.remove('activo');
        document.getElementById('b2').classList.remove('activo');
        document.getElementById('b3').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'feedbacks') {
            document.getElementById('feedbackSection').style.display = 'block';
            document.getElementById('b1').classList.add('activo');
            document.getElementById('mios').style.display = 'block';

        } else if (seccion === 'desempeño') {

            document.getElementById('desempeñoSection').style.display = 'block';
            document.getElementById('b2').classList.add('activo');
            document.getElementById('mios').style.display = 'none';
            document.getElementById('todos').style.display = 'none';

        }
        else if (seccion === 'competencias') {

            document.getElementById('competenciasSection').style.display = 'block';
            document.getElementById('b3').classList.add('activo');
            document.getElementById('mios').style.display = 'none';
            document.getElementById('todos').style.display = 'none';
        }
        else if (seccion === 'mios') {
            document.getElementById('feedbackSection').style.display = 'block';
            document.getElementById('mios').style.display = 'block';
            document.getElementById('b1').classList.add('activo');
            document.getElementById('todos').style.display = 'none';
        }
        else if (seccion === 'todos') {
            document.getElementById('feedbackSection').style.display = 'block';
            document.getElementById('todos').style.display = 'block';
            document.getElementById('b1').classList.add('activo');
            document.getElementById('mios').style.display = 'none';
        }

    }
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('5').classList.add('activo');
    });


    function mostrar(seccion) {

        document.getElementById('pendienteSection').style.display = 'none';
        document.getElementById('autorizadosSection').style.display = 'none';
        document.getElementById('proceso').style.display = 'none';
        document.getElementById('sinreponer').style.display = 'none';
        document.getElementById('repuestas').style.display = 'none';

        document.getElementById('5').classList.remove('activo');
        document.getElementById('6').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'reporte') {
            document.getElementById('pendienteSection').style.display = 'block';
            document.getElementById('5').classList.add('activo');

        } else if (seccion === 'total') {

            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('6').classList.add('activo');
            document.getElementById('sinreponer').style.display = 'block';
        }
        else if (seccion === 'asistencia') {

            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('6').classList.add('activo');
            document.getElementById('repuestas').style.display = 'block';
        }
        else if (seccion === 'proceso') {

            document.getElementById('proceso').style.display = 'block';
            document.getElementById('6').classList.add('activo');
            document.getElementById('autorizadosSection').style.display = 'block';
        }
    }
</script>
<script>
    document.getElementById("cars").addEventListener("change", function () {
        var internet = document.getElementById("Internet");
        var luz = document.getElementById("Luz");
        var ambas = document.getElementById("Ambas");

        var motivoTextarea = document.getElementById("motivoTextarea");
        var horas = document.getElementById("horas");
        var f_salida = document.getElementById("f_salida");
        var f_regreso = document.getElementById("f_regreso");

        if (this.value === "Internet" || this.value === "Luz" || this.value === "Ambas" || this.value === "Other") {

            motivoTextarea.style.display = "block";
            motivoTextarea.setAttribute("required", "required");
            horas.style.display = "block";
            horas.removeAttribute("readonly", "readonly");
            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");

            // Obtener los elementos de entrada de fecha
            const fSalida = document.getElementById('f_salida');
            const fRegreso = document.getElementById('f_regreso');

            // Escuchar los cambios en las fechas
            fSalida.addEventListener('change', calcularHoras);
            fRegreso.addEventListener('change', calcularHoras);

            function calcularHoras() {
                // Obtener las fechas seleccionadas
                const salida = new Date(fSalida.value);
                const regreso = new Date(fRegreso.value);

                // Calcular la diferencia en milisegundos
                const diferenciaMs = regreso - salida;

                // Convertir la diferencia a horas
                const horas = Math.abs(diferenciaMs / 3600000); // 3600000 milisegundos = 1 hora

                // Mostrar las horas en el campo de entrada
                document.getElementById('horas').value = horas.toFixed(0); // Redondear a 2 decimales
            }

        } else if (this.value === "Medico") {
            f_salida.removeAttribute("readonly");
            f_regreso.removeAttribute("readonly");
            horas.setAttribute("readonly", "readonly");
            motivoTextarea.style.display = "block";
            motivoTextarea.removeAttribute("required");
            horas.value = "0";
        } else if (this.value === "none") {
            motivoTextarea.style.display = "none";
            motivoTextarea.removeAttribute("required");
            horas.setAttribute("readonly", "readonly");
            f_salida.setAttribute("readonly", "readonly");
            f_regreso.setAttribute("readonly", "readonly");
        }
    });

</script>
<script>
    function previewVideo() {
        var input = document.getElementById('videoInput');
        var preview = document.getElementById('videoPreview');

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
    function openFilterModal() {
        $('#filterModal').modal('show');
    }
</script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('entradaBtn').classList.add('activo');
    });

    function mostrarSeccion(seccion) {
        // Oculta ambas secciones
        document.getElementById('entradaSection').style.display = 'none';
        document.getElementById('salidaSection').style.display = 'none';

        document.getElementById('entradaBtn').classList.remove('activo');
        document.getElementById('salidaBtn').classList.remove('activo');


        // Muestra la sección correspondiente
        if (seccion === 'entrada') {
            document.getElementById('entradaSection').style.display = 'block';
            document.getElementById('entradaBtn').classList.add('activo');

        } else if (seccion === 'salida') {
            document.getElementById('salidaSection').style.display = 'block';
            document.getElementById('salidaBtn').classList.add('activo');

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

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('1').classList.add('activo');
    });


    function mostrarSeccion1(seccion) {

        document.getElementById('nuevoSection').style.display = 'none';
        document.getElementById('pendienteSection').style.display = 'none';
        document.getElementById('autorizadosSection').style.display = 'none';

        document.getElementById('1').classList.remove('activo');
        document.getElementById('2').classList.remove('activo');
        document.getElementById('3').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'nueva') {
            document.getElementById('nuevoSection').style.display = 'block';
            document.getElementById('1').classList.add('activo');

        } else if (seccion === 'pend') {
            document.getElementById('pendienteSection').style.display = 'block';
            document.getElementById('2').classList.add('activo');

        } else if (seccion === 'auto') {
            document.getElementById('autorizadosSection').style.display = 'block';
            document.getElementById('3').classList.add('activo');

        }
    }
</script>
<script>
    function editC(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            html:
                `<div class="info-card vertical">
                    <div>
                        <div class="card-header" style="text-align: center;">
                            <strong> <i class="fas fa-edit" style="color: #3498db;"></i> <a href="<?php echo base_url("/home/analysis"); ?>"> Asistencia ></a> Edición de captura</strong>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                1. En caso de tener algún problema en el envío de su captura, favor de reportarse inmediatamente
                                con Mayte López del área de Capital humano.<br>

                                ¡Que tengan un excelente día!
                            </small>
                        </div>
                        <div class="card-body" id="contenido-dinamico">
                            <form id="formReq" action="<?php echo base_url("/home/savecapture"); ?>" method="post"
                                enctype="multipart/form-data">
                                <div class="card-header" style="text-align: center;">
                                    <strong><i class="fas fa-image" style="color: #3498db;"></i> Evidencia (Con hora, fecha y room ya
                                        visibles sea por computador o
                                        mediante celular)</strong>
                                </div>
                                <br>
                                <div class="form-group mb-2 text-center">
                                    <input type="hidden" name="id_hora" value="${id}" required>
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
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Guardar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
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

    function eliminarr(event, id) {
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
                const url = `<?php echo base_url('/home/eliminarPP/'); ?>${id}/`;
                window.location.href = url;
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
    function previewImage1() {
        var input = document.getElementById('imagenInput1');
        var preview = document.getElementById('imagenPreview1');

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
    function help(event, id_asistencia, hora, fecha, asistencia, retardo, permiso, captura) {

        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '',
            html:
                `<div class="card1" >
                    <img src="<?php echo base_url("gifs/logo.svg"); ?>" class="card-img-top" alt="logo_turing" width="110px" height="100px">
                        <div class="card-body">
                            <h5 class="card-title" style="font-weight: bold;"> Acerca de la hora de: ${asistencia} </h5>
                        </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Hora: ${hora} </li>
                                <li class="list-group-item">Fecha: ${fecha} </li>
                                <li class="list-group-item">Con retardo: ${retardo} </li>
                                <li class="list-group-item">Con permiso: ${permiso} </li>
                            </ul>
                            <div class="card-body">
                                Captura: 
                                    <a href="#" onclick="mostrarImagen('<?php echo base_url("/prueb_asist/"); ?>${captura}')">
                                        <img src="<?php echo base_url("/prueb_asist/"); ?>${captura}" alt="img" class='rounded-Thumbnail img-fluid' style='width: 40px; height: 20px; object-fit: cover;'>
                                    </a>
                            </div>
                </div>`,
            confirmButtonColor: '#00a65a',
            confirmButtonText: "¡Entendido!",
        });
    }
</script>
<script>
    function detalle(event, descripcion) {
        event.preventDefault(); // Evita que el enlace realice su acción predeterminada
        Swal.fire({
            title: 'Detalles del motivo',
            text: descripcion, // Aquí debes utilizar la variable descripcion
            icon: 'warning',
            confirmButtonColor: '#1371C7',
            confirmButtonText: "Entendido",
        });
    }
</script>
<script>

    function imprimirSeccion() {
        var contenidoSeccion = document.getElementById('impresion').outerHTML;
        var nuevaVentana = window.open('', '_blank');
        var contenidoNuevoDocumento = '<html><head><title>Imprimir historial</title>';

        // Copiar estilos asociados al elemento y agregar estilos adicionales
        var estilos = document.getElementById('impresion').style.cssText;
        contenidoNuevoDocumento += '<style>' + estilos + ' @media print { body { margin: 0; padding: 0; } }</style>';

        contenidoNuevoDocumento += '</head><body>' + contenidoSeccion + '</body></html>';

        nuevaVentana.document.write(contenidoNuevoDocumento);
        nuevaVentana.document.close();
        nuevaVentana.print();
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
    echo '    confirmButtonText: "Ok",';
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
    echo '    confirmButtonText: "Ok",';
    echo '    text: "' . esc($error_message) . '"';
    echo '});';
    echo '</script>';
}
?>

</body>

</html>