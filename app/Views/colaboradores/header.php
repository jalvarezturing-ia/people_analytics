<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo base_url("login/img/log_turing.webp"); ?>" type="image/x-icon" />
    <title>People Analytics</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url("/index/css/style.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/index/css/cards.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/admin/css/style.css"); ?>">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>


</head>

<style>
    .modal1 {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal1-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px;
        width: 30%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<body>
    <!-- <body oncontextmenu="return false" > -->
    <div class="wrapper">
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li class="active">
                    <!-- <div class="sidebar-header text-center" >
                        <h3>
                            <img src="<?= base_url('gifs/logo.svg') ?>" alt="" style="
                    width: 35px;
                    height: 35px;
                    object-fit: cover;
                    border-radius: 50%;
                  " />
                            Turing-IA
                        </h3>
                        <strong><img src="<?= base_url('gifs/logo.svg') ?>" alt="" style="
                    width: 35px;
                    height: 35px;
                    object-fit: cover;
                    border-radius: 50%;
                  " /></strong>
                    </div> -->
                    <div class="card" style="border: none">
                        <div class="santa-hat-overlay">

                            <!--<img src="<?php echo base_url("gifs/imagen3.png"); ?>" alt="Gorro Navideño"
                                class="santa-hat-img" id="santa1">-->
                        </div>
                        <div class="avatar mx-auto" style="border-radius: 5em; max-width: 150px; margin-top: 20px;">
                            <?php
                            $session = session();
                            $foto = $session->get('foto');
                            if ($foto == 'perfil.png') {
                                echo "<img src='" . base_url('/fotos_colab/perfil.png') . "' class='rounded-circle img-fluid' style='border: 2px solid #4070f4'/>";
                            } else {
                                echo "<img src='" . base_url('/fotos_colab/' . $foto) . "' class='rounded-circle img-fluid' style='border: 2px solid #4070f4'/>";
                            }
                            ?>

                        </div>
                        <div class="sidebar-header text-center">
                            <h6 style="font-weight: bold;">Bienvenid@,
                                <?=
                                    $nombre = $session->get('nombre');
                                $nombre ?>
                            </h6>
                            <h6>Área de
                                <?=
                                    $descripcion = $session->get('descripcion');
                                $descripcion ?>
                            </h6>
                            <strong style="font-size: 7px;">TURING-IA</strong>
                        </div>
                    </div>
                    <hr>
                </li>
                <li id="module-list">
                    <a href="<?php echo base_url("/home/index"); ?>" data-toggle="tooltip" class="nav-link"
                        data-placement="bottom" title="Explorar nuevas noticias">
                        <i class="fas fa-newspaper"></i>
                        Noticias
                    </a>
                    <?php if (session('estado') == '1'): ?>
                        <div class="alert alert-danger" style="text-align: center; font-size: 10px;"> Modulos anulados.
                        </div>
                    <?php else: ?>

                        <a href="<?php echo base_url("home/index/overtimes"); ?>" data-toggle="tooltip" class="nav-link"
                            data-placement="bottom" title="Gestion de nómina del colaborador">
                            <i class="fas fa-hand-holding-usd"></i>
                            Nómina
                        </a>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-clock"></i>
                            Asistencia
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="<?php echo base_url("/home/assistence"); ?>" data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Marcar asistencia diaria">
                                    <i class="fas fa-check-square"></i> Marcar asistencia diaria</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/output"); ?>" data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Marcar salida diaria">
                                    <i class="fas fa-sign-out-alt"></i> Marcar salida diaria</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/analysis"); ?>" data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Análisis de asistencias">
                                    <i class="fas fa-chart-bar"></i> Análisis de asistencias</a>
                            </li>

                            <li>
                                <a href="<?php echo base_url("/home/permits/") . session('user_id'); ?>"
                                    data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Solicitar un permiso">
                                    <i class="fas fa-unlock"></i> Permisos </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/incidence/") . session('user_id'); ?>"
                                    data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Reportar incidencias ocurridas">
                                    <i class="fas fa-info-circle"></i> Incidencias </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/hours/") . session('user_id'); ?>" data-toggle="tooltip"
                                    class="nav-link" data-placement="bottom" title="Registro de horas y/o días extras">
                                    <i class="fas fa-clock"></i> Horas/dias extras </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/vacations/") . session('user_id'); ?>"
                                    data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                    title="Visualizar periodos de vacaciones">
                                    <i class="fas fa-calendar" aria-hidden="true"></i> Vacaciones </a>
                            </li>

                        </ul>
                        <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-chart-line"></i>
                            Eficacia
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu1">
                            <li>
                                <a href="<?php echo base_url("/home/performance"); ?>" data-toggle="tooltip"
                                    class="nav-link" data-placement="bottom" title="Desempeño y competencias">
                                    <i class="fas fa-check-circle"></i>Empeño</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/aprendizaje"); ?>" data-toggle="tooltip"
                                    class="nav-link" data-placement="bottom" title="Centro de aprendizaje">
                                    <i class="fas fa-chart-bar"></i> Estudio</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/onboarding"); ?>" data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Seguimiento de onboarding">
                                    <i class="fas fa-chart-line"></i> Inducción </a>
                            </li>

                            <li>
                                <a href="<?php echo base_url("/home/encuestas"); ?>" data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Encuestas y correos del colaborador">
                                    <i class="fas fa-envelope"></i> Encuestas </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("/home/ciclos"); ?>" data-toggle="tooltip" class="nav-link"
                                    data-placement="bottom" title="Ciclo de vida del colaborador">
                                    <i class="fas fa-sync-alt"></i> Ciclos </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>

            <!-- <ul class="list-unstyled CTAs">
                <li>
                    <a href="<?php echo base_url("/index/user_manual.pdf"); ?>" target="_blank" class="download"> <i
                            class="fas fa-file-pdf"></i> Manual de usuario </a>
                </li>
            </ul> -->
        </nav>
        <!-- <img src="<?php echo base_url("login/img/santa.gif"); ?>" alt="Santa Claus corriendo" id="santa">

       Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar- bg-">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light" title="Cerrar"
                        style="color: #707070; background: white">
                        <i class="fas fa-expand"></i>
                        <span> </span>
                    </button>
                   
                           <!-- start settings -->
                           <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle no-caret" href="#" title="Configuración"
                            style="color: #707070; background: white; border:none;" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-cog'></i>
                        </a>
                        <div class="dropdown-menu acciones" style='float: right; border-radius: 1rem;'>
                            <a href='<?php echo base_url("home/account"); ?>' class='dropdown-item'>
                                <i class='fas fa-cogs'></i> Configuración de perfil
                            </a>
                        </div>
                    </div>
                    <!-- end settings -->

                    <!-- start apps -->
                    <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle no-caret" href="#" title="Apps"
                            style="color: #707070; background: white; border:none;" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-box'></i>
                        </a>
                        <div class="dropdown-menu acciones" style='border-radius: 1rem;'>
                        <a href='https://mail.google.com/mail' target="_blank" class='dropdown-item'>
                                <img src='<?php echo base_url('assets/app/google.png'); ?>'
                                    class='rounded-circle img-fluid' width="30" alt="">
                                Gmail
                            </a>
                            <a href='https://calendar.google.com/calendar/' target="_blank" class='dropdown-item'>
                                <img src='<?php echo base_url('assets/app/google-calendar.png'); ?>'
                                    class='rounded-circle img-fluid' width="30" alt="">
                                Calendario
                            </a>
                            <a href='https://drive.google.com/drive/my-drive' target="_blank" class='dropdown-item'>
                                <img src='<?php echo base_url('assets/app/google-drive.png'); ?>'
                                    class='rounded-circle img-fluid' width="30" alt="">
                                Drive
                            </a>
                            <a href='https://open.spotify.com/intl-es' target="_blank" class='dropdown-item'>
                                <img src='<?php echo base_url('assets/app/spotify.png'); ?>'
                                    class='rounded-circle img-fluid' width="30" alt="">
                                Spotify
                            </a>
                        </div>
                    </div>
                    <!-- end apps -->


                    <div class="search-box" style="margin-top:10px;">
                        <input type="text" id="search-modules" style='float: right; border:none;' autofocus
                            placeholder="Escriba para buscar al modulo">
                        <!-- <div id="search-results" style="text-decoration: underline; border:none; border-radius: 1rem ">
                        </div> -->
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal1">
                        <div class="modal1-content">
                            <span class="close">&times;</span>
                            <div id="search-results-modal"></div>
                            <div id="no-results" style="display:none; color:red;">No se encontraron resultados</div>
                        </div>
                    </div>


                    <button class="btn btn-light d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        style="color: #707070; background: white" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-expand"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">

                            <!-- <?php $count = 1; ?>
                            <a class="btn btn-light" style="color: #707070; background: white" data-toggle="tooltip"
                                onclick="myNots()" class="nav-link" data-placement="bottom"
                                title="<?= $count; ?> nuevas notificaciones" href="#!"> <i class="fas fa-bell"></i>
                                <?php if ($count > 0) {
                                    echo $count;
                                } ?>
                            </a> -->
                            <a class="btn btn-light" style="color: #707070; background: white" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Cerrar sesión"
                                href="<?php echo base_url("/home/destroy"); ?>"> <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="color: #3498db; text-align:center;">
                            <h5 class="modal-title" id="filterModalLabel"> <i class="fas fa-filter"></i> Busqueda de
                                historial de entradas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo base_url('/home/analysis/history'); ?>" method="GET">
                            <div class="form-group row">
                                <label for="filterNombre" class="col-sm-2 col-form-label">Fecha inicio:</label>
                                <div class="col-sm-4">
                                    <input type="date" name="start" id="fecha_inicio" class="form-control" required>
                                </div>

                                <label for="filterArea" class="col-sm-2 col-form-label">Fecha fin:</label>
                                <div class="col-sm-4">
                                    <input type="date" name="end" id="fecha_fin" value="<?= date('Y-m-d'); ?>"
                                        class="form-control" required>
                                    <input type="hidden" name="tipe" id="fecha_inicio" class="form-control"
                                        value="Entrada" required>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <a href="#!" class="btn btn-outline-info btn-md" data-dismiss="modal"> <i
                                        class='fas fa-times'></i> Cerrar</a>
                                <button type='submit' class="btn btn-outline-success btn-md" title="Buscar"><i
                                        class='fa fa-search'></i>
                                    Buscar</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script>
                function removeAccents(str) {
                    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                }

                $(document).ready(function () {
                    $('#search-modules').on('input', function () {
                        var searchTerm = removeAccents($(this).val().toLowerCase());
                        var $searchResults = $('#search-results-modal');
                        var $noResults = $('#no-results');
                        $searchResults.empty();
                        $noResults.hide();

                        if (searchTerm.trim() !== '') {
                            var found = false;
                            $('#module-list li').each(function () {
                                var moduleText = removeAccents($(this).text().toLowerCase());
                                if (moduleText.includes(searchTerm)) {
                                    var $icon = $(this).find('i');
                                    var iconHtml = $icon.length > 0 ? $icon.prop('outerHTML') : '';
                                    var $resultLink = $('<a>').html(iconHtml + $(this).text()).attr('href', $(this).find('a').attr('href'));
                                    var $resultItem = $('<div>').append($resultLink);
                                    $searchResults.append($resultItem);
                                    found = true;
                                }
                            });

                            if (!found) {
                                $noResults.show();
                            }

                            // Mostrar el modal cuando se encuentren resultados
                            $('#myModal').css('display', 'block');
                        } else {
                            // Ocultar el modal si el campo de búsqueda está vacío
                            $('#myModal').css('display', 'none');
                        }
                    });

                    // Cerrar el modal al hacer clic en el botón de cierre
                    $('.close').on('click', function () {
                        $('#myModal').css('display', 'none');
                    });
                });




            </script>

            <script>
                function myNots() {

                    $(document).ready(function () {

                        $('#modalNotifs').modal('show');
                    });

                }
            </script>


            <!-- Modal para notificaciones -->
            <div class="modal fade" id="modalNotifs" tabindex="-1" role="dialog" aria-labelledby="modalNotifsLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modalNotifsLabel" >People Analytics</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí puedes añadir tus notificaciones -->
                            <ul class="list-group">
                                <li class="list-group-item" style="border:red;">Notificación 1</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <script>

                // Función para eliminar acentos de una cadena
                function removeAccents(str) {
                    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                }

                $(document).ready(function () {
                    $('#search-modules').on('input', function () {
                        var searchTerm = removeAccents($(this).val().toLowerCase()); // Obtener el término de búsqueda sin acentos
                        var $searchResults = $('#search-results'); // Elemento donde se mostrarán los resultados
                        $searchResults.empty(); // Limpiar resultados anteriores

                        if (searchTerm.trim() !== '') { // Verificar si el término de búsqueda no está vacío
                            $('#module-list li').each(function () {
                                var moduleText = removeAccents($(this).text().toLowerCase()); // Obtener el texto del módulo sin acentos
                                if (moduleText.includes(searchTerm)) { // Comprobar si el texto del módulo incluye el término de búsqueda
                                    // Obtener el icono del módulo si existe
                                    var $icon = $(this).find('i');
                                    var iconHtml = $icon.length > 0 ? $icon.prop('outerHTML') : ''; // Obtener el HTML del icono o establecerlo como vacío si no existe
                                    // Crear un elemento <a> para mostrar el módulo correspondiente
                                    var $resultLink = $('<a>').html(iconHtml + $(this).text()).attr('href', $(this).find('a').attr('href'));
                                    var $resultItem = $('<div>').append($resultLink); // Envolver el enlace en un elemento <div>
                                    $searchResults.append($resultItem); // Agregar el resultado al contenedor
                                }
                            });
                        }
                    });
                });


            </script> -->