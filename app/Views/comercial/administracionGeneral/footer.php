   
   
     </div>
    </div>
   
   
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

<script>
    function baja(event, id_usuario) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción dará de baja al colaborador y toda la información correspondiente dejará de estar disponible. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, dar de baja",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/nomina/deletecolab/'); ?>${id_usuario}/`;
                window.location.href = url;
            }
        });
    }
    function alta(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción dará de alta al colaborador y toda la información correspondiente estará disponible. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, dar de alta",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/nomina/altacolab/'); ?>${id}/`;
                window.location.href = url;
            }
        });
    }


    function bajaSistema(event, id) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará por completo toda la información del colaborador en el sistema, ¡ESTA ACCIÓN ES IRREVERSIBLE!. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?php echo base_url('/home/nomina/deletesistema/'); ?>${id}/`;
                window.location.href = url;
            }
        });
    }

</script>


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    // Función para obtener el conteo almacenado en localStorage o 0 si no existe
    /*function getReactionCount(reactionType) {
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
*/
</script>

<script>
    function filterTable2() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search2");
        filter = input.value.toUpperCase();
        table = document.getElementById("periodos-table2");
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
        var mensajeSinPeriodo = document.getElementById("mensaje-sin-periodo2");
        if (!found) {
            mensajeSinPeriodo.style.display = "block";
        } else {
            mensajeSinPeriodo.style.display = "none";
        }
    }
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
    function mostrarSeccion(seccion) {
        // Oculta ambas secciones
        document.getElementById('pendientesSection').style.display = 'none';
        document.getElementById('pagadosSection').style.display = 'none';

        document.getElementById('pendientesBtn').classList.remove('activo');
        document.getElementById('pagadosBtn').classList.remove('activo');

        // Muestra la sección correspondiente
        if (seccion === 'pendientes') {
            document.getElementById('pendientesSection').style.display = 'block';
            document.getElementById('pendientesBtn').classList.add('activo');
        } else if (seccion === 'pagados') {
            document.getElementById('pagadosSection').style.display = 'block';
            document.getElementById('pagadosBtn').classList.add('activo');
        }
    }
</script>


</body>
</html>