   
   
   <!-- jQuery CDN - Slim version (=without AJAX) -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
    $(document).ready(function () {
        // Oculta el sidebar al cargar la página
        $('#sidebar').addClass('active');
        $('#santa').css('visibility', 'hidden');
        $('#santa1').css('visibility', 'hidden');

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');

            // Verifica si el sidebar tiene la clase 'active'
            if ($('#sidebar').hasClass('active')) {
                $('#santa').css('visibility', 'hidden');
                $('#santa1').css('visibility', 'hidden');
            } else {
                $('#santa').css('visibility', 'visible');
                $('#santa1').css('visibility', 'visible');
            }
        });
    });
</script>


</body>

</html>
<script>
    function mostrarImagen(url) {
        // Abre la imagen en una nueva ventana emergente o modal
        window.open(url, '_blank');
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
        
        } else if(seccion === 'nosalida') {
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
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>