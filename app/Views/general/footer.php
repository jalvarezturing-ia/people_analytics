   
   
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

   
   <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

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



</body>

</html>