<?php $session = session(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo base_url("login/img/logo-turing.webp"); ?>" type="image/x-icon" />
    <title>People Analitycs</title>
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha384-eaR/o8R2/qOQVGaRlQsD5eRe3pN7m3dRAVwnQFz7JRMwRR65kHw9u5L5Jd9uHcqu" crossorigin="anonymous"> -->
    <!-- Incluye SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/super-build/ckeditor.js"></script>
</head>

<style>
    .notification-number {
        position: absolute;
        top: -5px;
        /* Ajusta según sea necesario */
        right: -1px;
        /* Ajusta según sea necesario */
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 4px 7px;
        /* Ajusta según sea necesario */
        font-size: 12px;
        /* Ajusta según sea necesario */
        font-weight: bold;
        line-height: 1;
    }

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

    #pagination-container {
        text-align: center;
        margin-top: 20px;
    }

    #pagination-container a {
        display: inline-block;
        padding: 8px 12px;
        margin: 2px;
        border: 1px solid #3498db;
        border-radius: 4px;
        text-decoration: none;
        color: #000000;
        transition: background-color 0.3s, color 0.3s;
        font-family: "Century Gothic";
    }

    #pagination-container a:hover {
        background-color: #3498db;
        color: #fff;
    }

    #pagination-container .current-page {
        background-color: #3498db;
        color: #fff;
    }

    .no-caret::after {
        display: none !important;
    }
</style>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li class="active">
                    <div class="card" style="border: none">
                        <div class="avatar mx-auto" style="border-radius: 5em; max-width: 150px; margin-top: 20px;">
                            <?php
                            $session = session();
                            $foto = $session->get('foto');
                            if ($foto == 'perfil.png') {
                                echo "<img src='" . base_url('/fotos_colab/perfil.png') . " 'class='rounded-circle img-fluid' style='border: 2px solid #4070f4'>";
                            } else {
                                echo "<img src='" . base_url('/fotos_colab/' . $foto) . " 'class='rounded-circle img-fluid' style='border: 2px solid #4070f4'>";
                            }
                            ?>

                        </div>
                        <div class="sidebar-header text-center">
                            <h6 style="font-weight: bold;">
                                Bienvenid@,
                                <?=
                                    $descripcion = $session->get('nombre');
                                $descripcion
                                    ?>

                            </h6>
                            <h6>Área de
                                <?=
                                    $descripcion = $session->get('descripcion');
                                $descripcion
                                    ?>
                            </h6>

                            <strong style="font-size: 8px;">TURING-IA</strong>
                        </div>
                    </div>

                </li>
                <li id="module-list">
                    <a href="<?php echo base_url("/home/index"); ?>" data-toggle="tooltip" class="nav-link"
                        data-placement="bottom" title="Explorar nuevas noticias">
                        <i class="fas fa-newspaper"></i>
                        Noticias
                    </a>

                    <a href="#pageSubmenu0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-dollar-sign"></i>
                        Nómina
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu0">
                        <li>
                            <a href="<?php echo base_url("home/index/capital"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Aprobar nómina">
                                <i class="fas fa-dollar-sign"></i> Aprobar</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/nomina/people"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Lista de usuarios">
                                <i class="fas fa-users"></i> People</a>
                        </li>

                    </ul>

                    <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-check-square"></i>
                        Asistencia
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">
                        <li>
                            <a href="<?php echo base_url("home/attendance"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Registro de hora de entrada y salida">
                                <i class="fas fa-check-circle"></i> Check</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/permit"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Visualizar permisos del colaborador">
                                <i class="fas fa-unlock"></i> Permisos </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/event"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Visualizar reportes de incidencias ocurridas">
                                <i class="fas fa-info-circle"></i> Incidencias </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/extras"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Registro de horas y/o días extras solicitados">
                                <i class="fas fa-clock"></i> Horas/dias extras </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/vacaciones"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Visualizar periodos de vacaciones por colaborador">
                                <i class="fas fa-calendar" aria-hidden="true"></i> Vacaciones </a>
                        </li>

                    </ul>

                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-chart-line"></i>
                        Eficacia
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Desempeño y competencias del colaborador">
                                <i class="fas fa-check-circle"></i> Empeño</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Centro de aprendizaje">
                                <i class="fas fa-chart-bar"></i> Estudio </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Onboarding">
                                <i class="fas fa-chart-line"></i> Inducción </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('home/review') ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Encuestas y correos automáticos">
                                <i class="fas fa-envelope"></i> Encuestas </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('home/cicles') ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Ciclo de vida del colaborador">
                                <i class="fas fa-sync-alt"></i> Ciclos </a>
                        </li>

                    </ul>

                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-tasks"></i>
                        Talent
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?php echo base_url('home/applicants') ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Tablero de postulaciones y candidatos">
                                <i class="fas fa-receipt"></i> Análisis</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url('home/ats') ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Seguimiento y contratación de candidatos">
                                <i class="fas fa-money-bill-wave"></i> ATS</a>
                        </li>


                    </ul>
                </li>
            </ul>
            <!--<ul class="list-unstyled CTAs">
                <li>
                    <a href="<?php echo base_url("/index/user_admin.pdf"); ?>" target="_blank" class="download">  <i  class="fas fa-file-pdf"></i> Manual de usuario </a>
                </li>
            </ul>-->
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar- bg-">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light" title="Cerrar"
                        style="color: #707070; background: white; border:none;">
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
                            placeholder="Escriba para buscar">
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal1">
                        <div class="modal1-content">
                            <span class="close">&times;</span>
                            <div id="search-results-modal"></div>
                            <div id="no-results" style="display:none; color:red;">No se encontraron resultados</div>
                        </div>
                    </div>
                    <!-- cuando se minimiza la pantalla a formatos más pequeños -->
                    <button class="btn btn-light d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        style="color: #707070; background: white" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-expand"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">



                            <?php
                            // $tot = '';
                            // $not = '';
                            if (!empty($tot) && !empty($not)):
                                // return [$tot, $not];
                            else:
                                $tot = '';
                                $not = '';
                            endif;

                            $count = $tot; ?>
                            <a class="btn btn-light"
                                style="color: #707070; background: white; border:none; position: relative;"
                                data-toggle="tooltip" onclick="myNots()" class="nav-link" data-placement="bottom"
                                title="Notificaciones" href="#!">
                                <i class="fas fa-bell"></i>
                                <?php if ($count > 0): ?>
                                    <span class="notification-number"><?= $count ?></span>
                                <?php endif; ?>
                            </a>

                            <a class="btn btn-light" title="Cerrar sesión"
                                onclick='localStorage.removeItem("token_people")'
                                style="color: #707070; background: white;border:none;" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Cerrar sesión"
                                href="<?php echo base_url("/home/destroy"); ?>"> <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </ul>
                    </div>
                </div>
            </nav>

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
                    <div class="modal-content" style='border-radius:1rem;'>
                        <div class="modal-header">
                            <h6 class="modal-title" id="modalNotifsLabel" style="color: #4070f4; font-weight:bold;">
                                Notificaciones <i class="fa fa-bell"></i></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí puedes añadir tus notificaciones -->
                            <ul class="list-group">
                                <?php
                                $number = 0;
                                // Dividir la cadena en mensajes individuales
                                $messages = explode("\n", $not);
                                // Iterar sobre cada mensaje y crear un elemento de lista
                                foreach ($messages as $message) {
                                    if (!empty(trim($message))) { // Verificar si el mensaje no está vacío
                                        echo "<li class='list-group-item' style='border-radius:2rem;'> <img src='https://c0.klipartz.com/pngpicture/970/916/gratis-png-hombre-sentado-enfrente-del-logotipo-del-ordenador-portatil-tiempo-y-asistencia-nomina-personal-de-gestion-de-recursos-humanos-recursos-humanos-nomina-de-pago-icono-de-servicios-thumbnail.png' class='rounded-circle img-fluid' style='border: 2px solid #4070f4'  width='35' > $message</li>";
                                    }
                                    //     echo "<li class='list-group-item' >Sin notificaciones</li>";
                                    // }
                                    $number++;
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>