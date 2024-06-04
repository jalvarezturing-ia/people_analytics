<link href="<?php echo base_url("fullCalendar/css/fullcalendar.css"); ?>" rel="stylesheet" />
<link href="<?php echo base_url("fullCalendar/css/bootstrap.min.css"); ?>" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<style>
    body{
        font-family: "Century Gothic";
    }
</style>
<title>Turing-IA</title>
<link rel="icon" href="<?php echo base_url("login/img/log_turing.webp"); ?>" type="image/x-icon" />

<style>
    body {
        padding-top: 70px;

    }

    #calendar {
        max-width: 800px;
    }

    .col-centered {
        float: none;
        margin: 0 auto;
    }

    .ver-periodo-btn2 {
        color: #34db6c;
        /* Color del texto */
        background-color: #e1fedf;
        /* Color de fondo */
        padding: 8px 15px;
        /* Ajusta el espaciado interno */
        border-radius: 8px;
        /* Bordes redondeados */
        text-decoration: none;
        /* Sin subrayado */
        font-size: 14px;
        /* Tamaño del texto */
        transition: background-color 0.3s, color 0.3s;
        /* Transición suave del color de fondo y del texto */
        border: none;
        /* Quita el borde del botón */
        cursor: pointer;
        /* Cambia el cursor al pasar el mouse sobre el botón */
    }

    .ver-periodo-btn2:hover {
        background-color: #34db6c;
        /* Cambia el color de fondo al pasar el mouse */
        color: #e1fedf;
        /* Cambia el color del texto al pasar el mouse */
    }
</style>

<body>


    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
            <a href="<?php echo base_url('home/performance'); ?>" class="ver-periodo-btn2 text-center">Regresar</a>
                <h1>Registra tus eventos Turing-IA</h1>
                <div id="calendar" class="col-centered">
                </div>
              
            </div>
         
        </div>
        <div class="content_calendar">

            <div id="calendar"></div>

            <!-- Modal -->
            <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="<?php echo base_url('home/saveEvents'); ?>">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Titulo</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="Titulo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Seleccionar</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro
                                            </option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                            <option style="color:#000;" value="#000">&#9724; Negro</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Ubicación</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ubicacion" class="form-control" id="ubicacion"
                                            placeholder="Escriba la ubicación del evento">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="start" class="form-control" id="start">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="end" class="form-control" id="end">
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="ver-periodo-btn2 text-center ">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="<?php echo base_url('home/editEvents'); ?>">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Modificar Evento</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Titulo</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="Titulo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Ubicacion</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ubicacion" class="form-control" id="ubicacion"
                                            placeholder="Ubicación">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Seleccionar</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro
                                            </option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                            <option style="color:#000;" value="#000">&#9724; Negro</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label class="text-danger"><input type="checkbox" name="delete">
                                                Eliminar
                                                Evento</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" class="form-control" id="id">


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="ver-periodo-btn2 text-center">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script src="<?php echo base_url("fullCalendar/js/jquery.js"); ?>"></script>
<script src="<?php echo base_url("fullCalendar/js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("fullCalendar/js/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("fullCalendar/js/fullcalendar/fullcalendar.min.js"); ?>"></script>
<script src="<?php echo base_url("fullCalendar/js/fullcalendar/fullcalendar.js"); ?>"></script>
<script src="<?php echo base_url("fullCalendar/js/fullcalendar/locale/es.js"); ?>"></script>

<script>

    $(document).ready(function () {

        var date = new Date();
        var yyyy = date.getFullYear().toString(); //año
        var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString(); //mes
        var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString(); //dia

        $('#calendar').fullCalendar({
            header: {
                language: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay',

            },
            defaultDate: yyyy + "-" + mm + "-" + dd,
            fixedWeekCount: false,
            showNonCurrentDates: false,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: true,
            select: function (start, end) {

                end = moment(end).subtract(1, 'seconds');

                // Obtener la hora actual del sistema
                var currentTime = moment().format('HH:mm:ss');

                // Combinar la fecha seleccionada con la hora actual
                start = start.format('YYYY-MM-DD') + ' ' + currentTime;

                //$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #start').val(start);
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');

                console.log(start);
            },

            eventRender: function (event, element) {
                element.bind('dblclick', function () {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #ubicacion').val(event.ubicacion);
                    $('#ModalEdit #color').val(event.color);
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function (event, delta, revertFunc) { // si changement de position

                edit(event);

            },
            eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                edit(event);

            },
            events: [
                <?php foreach ($events as $event):

                    $start = explode(" ", $event->f_inicio);
                    $end = explode(" ", $event->f_fin);
                    if ($start[1] == '00:00:00') {
                        $start = $start[0];
                    } else {
                        $start = $event->f_inicio;
                    }
                    if ($end[1] == '00:00:00') {
                        $end = $end[0];
                    } else {
                        $end = $event->f_fin;
                    }
                    ?>
                                                            {
                        id: '<?php echo $event->id; ?>',
                        title: '<?php echo $event->titulo; ?>',
                        ubicacion: '<?php echo $event->ubicacion; ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $event->color; ?>',
                    },
                <?php endforeach; ?>
            ]
        });

        function edit(event) {
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if (event.end) {
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            } else {
                end = start;
            }

            id = event.id;

            Event = [];
            Event[0] = id;
            Event[1] = start;
            Event[2] = end;

            //console.log(Event);

            $.ajax({
                url: '<?php echo base_url('home/editEventsLugar'); ?>',
                type: "POST",
                data: { Event: Event },
                success: function (rep) {
                    if (rep == 'OK') {
                        alert('El evento se ha guardado correctamente');
                    } else {
                        alert('No se pudo guardar el evento. Por favor, inténtalo de nuevo.');
                    }
                },
                error: function () {
                    alert('Hubo un error al intentar guardar el evento.');
                }
            });

        }

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