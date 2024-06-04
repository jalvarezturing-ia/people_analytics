<?php include ("header.php"); ?>
<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y"); ?>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/locales/es@6.1.11/main.min.js'></script>
<div class="container">
    <div class="info-card vertical">
        <h4 class="title-wish"> Noticias | Página principal <i class="fas fa-home" ></i> </h4>
        <div class="line"> </div>
        <div class="ag-courses_item" id="ndnd">
            <a href="#!" class="ag-courses-item_link">
                <div class="ag-courses-item_bg" style=" background-color: #4c49ea;"></div>
                <div class="ag-courses-item_title">
                    Hola
                    <?php echo ($session->get('nombre')); ?>, ¡Bienvenid@!
                </div>
                <div class="ag-courses-item_date-box">
                    Ciudad de México a

                    <span class="ag-courses-item_date">
                        <?= $fechaHoy ?>
                    </span>
                </div>
            </a>
        </div>
        <br>
       <img src="<?php echo base_url('gifs/kik.png'); ?>" alt="Descripción de la imagen" id="clientimg">
    </div>

    <div class="info-card small">
        <h4 class="title-wish">Noticias | Calendario <i class="fas fa-calendar-alt" ></i> </h4>
        <div class="line"></div>
        <div id='calendar'></div>
    </div>

    <div class="info-card small">
        <h4 class="title-wish">Noticias |Últimos informes <i class="fas fa-newspaper" ></i> </h4>
        <div class="line"></div>
        <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/7df7c475521507.5c4f4a6978056.gif" alt=""
            id="indeximg">
           <br><br>
        <p>No hay vacaciones ni ausencias registrados en este momento. Tampoco hay permisos registrados o ausencias
            fichaje de entrada ni pausa.</p>
    </div>

</div>


<script src="<?php echo base_url("fullCalendar/js/fullcalendar/locale/es.js"); ?>"></script>
<script>

    document.addEventListener('DOMContentLoaded', function () {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es'
            ,
            buttonText: {
                today: 'Hoy'
            }
        });

        calendar.render();
    });

</script>

<body>

</body>


<?php include ("footer.php"); ?>