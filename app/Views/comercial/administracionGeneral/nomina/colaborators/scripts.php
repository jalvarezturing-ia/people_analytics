

<script>
function scrollToIneTitle() {
    // Obtén el elemento con el ID "ineTitle"
    var ineTitleElement = document.getElementById("ineTitle");

    // Verifica si el elemento existe
    if (ineTitleElement) {
        // Calcula la posición del elemento en la página
        var offsetTop = ineTitleElement.offsetTop;

        // Realiza un desplazamiento suave hasta la posición del elemento
        window.scrollTo({
            top: offsetTop,
            behavior: "smooth"
        });
    }
}

function scrollTocurpTitle() {
    var ineTitleElement = document.getElementById("curpTitle");

    // Verifica si el elemento existe
    if (ineTitleElement) {
        // Calcula la posición del elemento en la página
        var offsetTop = ineTitleElement.offsetTop;

        // Realiza un desplazamiento suave hasta la posición del elemento
        window.scrollTo({
            top: offsetTop,
            behavior: "smooth"
        });
    }
}

function scrollToallTitle() {
    var ineTitleElement = document.getElementById("allTitle");

    // Verifica si el elemento existe
    if (ineTitleElement) {
        // Calcula la posición del elemento en la página
        var offsetTop = ineTitleElement.offsetTop;

        // Realiza un desplazamiento suave hasta la posición del elemento
        window.scrollTo({
            top: offsetTop,
            behavior: "smooth"
        });
    }
}


</script>


<script>
    function calcularSueldo1() {
        // Obtener el valor del pago mensual base
        var pagoMensualBase = document.getElementById("bancariosForm").elements["pago_mensual_base"].value;

        // Realizar cálculos
        var pagoQuincenal = (pagoMensualBase / 2).toFixed(2);
        var sueldoDiario = (pagoQuincenal / 15).toFixed(2);

        // Actualizar los campos de resultado
        document.getElementById("bancariosForm").elements["pago_quincenal"].value = pagoQuincenal;
        document.getElementById("bancariosForm").elements["sueldo_diario"].value = sueldoDiario;
    }
</script>
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
</script>
<script>
    function mostrarSeccion(estado) {
        var valor = estado.value;
        // Oculta secciones
        document.getElementById('infoSection').style.display = 'none';
        document.getElementById('cvSection').style.display = 'none';
        document.getElementById('contratoSection').style.display = 'none';
        document.getElementById('bancoSection').style.display = 'none';
        document.getElementById('comprobanteSection').style.display = 'none';
        document.getElementById('estudiosSection').style.display = 'none';
        document.getElementById('rfcSection').style.display = 'none';
        document.getElementById('d_bancariosSection').style.display = 'none';
        document.getElementById('beneficiarioSection').style.display = 'none';
        //document.getElementById('universidadSection').style.display = 'none';

        // document.getElementById('infoBtn').classList.remove('activo');
        // document.getElementById('cvBtn').classList.remove('activo');
        // document.getElementById('contratoBtn').classList.remove('activo');
        // document.getElementById('bancoBtn').classList.remove('activo');
        // document.getElementById('domicilioBtn').classList.remove('activo');
        // document.getElementById('estudiosBtn').classList.remove('activo');
        // document.getElementById('rfcBtn').classList.remove('activo');
        // document.getElementById('bancariosBtn').classList.remove('activo');
        // document.getElementById('beneficiarioBtn').classList.remove('activo');
       //document.getElementById('universidadBtn').classList.remove('activo');

        // Muestra la sección correspondiente
        if (valor === 'cv') {
            document.getElementById('cvSection').style.display = 'block';

        } else if (valor === 'info') {
            document.getElementById('infoSection').style.display = 'block';

        } else if (valor === 'contrato') {
            document.getElementById('contratoSection').style.display = 'block';

        } else if (valor === 'banco') {
            document.getElementById('bancoSection').style.display = 'block';

        } else if (valor === 'domicilio') {
            document.getElementById('comprobanteSection').style.display = 'block';

        } else if (valor === 'estudios') {
            document.getElementById('estudiosSection').style.display = 'block';

        } else if (valor === 'rfc') {
            document.getElementById('rfcSection').style.display = 'block';

        } else if (valor === 'sbancarios') {
            document.getElementById('d_bancariosSection').style.display = 'block';

        } else if (valor === 'beneficiario') {
            document.getElementById('beneficiarioSection').style.display = 'block';

        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery(document).ready(function ($) {
        // Captura el evento de envío del formulario
        $('#login-form').submit(function (event) {
            // Evita que el formulario se envíe de forma predeterminada
            event.preventDefault();

            // Agrega la clase 'loading' al body para aplicar el fondo blanco
            $('body').addClass('loading');

            // Muestra el spinner
            $('#loading-spinner').show();

            // Envía el formulario después de un breve retraso
            setTimeout(function () {
                $('#login-form')[0].submit();
            }, 2000);
        });
    });
</script>
<script>
    jQuery(document).ready(function ($) {
        // Captura el evento de envío del formulario
        $('#login-form1').submit(function (event) {
            // Evita que el formulario se envíe de forma predeterminada
            event.preventDefault();

            // Agrega la clase 'loading' al body para aplicar el fondo blanco
            $('body').addClass('loading');

            // Muestra el spinner
            $('#loading-spinner').show();

            // Envía el formulario después de un breve retraso
            setTimeout(function () {
                $('#login-form1')[0].submit();
            }, 2000);
        });
    });
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