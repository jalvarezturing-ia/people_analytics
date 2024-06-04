<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo base_url("login/img/log_turing.webp"); ?>" type="image/x-icon" />
    <title>Página principal</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha384-eaR/o8R2/qOQVGaRlQsD5eRe3pN7m3dRAVwnQFz7JRMwRR65kHw9u5L5Jd9uHcqu" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>

<!-- <style>
        .card-box {
        position: relative;
        color: #fff;
        padding: 20px 10px 40px;
        margin: 20px 0px;
        border-radius: 1em;
        box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
    }

    .card-box:hover {
        text-decoration: none;
        color: #f1f1f1;
    }

    .card-box:hover .icon i {
        font-size: 100px;
        transition: 1s;
        -webkit-transition: 1s;
    }

    .card-box .inner {
        padding: 5px 10px 0 10px;
    }

    .swal-wide {
        width: 1080px !important;
    }

    .card-box h3 {
        font-size: 27px;
        font-weight: bold;
        margin: 0 0 8px 0;
        white-space: nowrap;
        padding: 0;
        text-align: left;
    }

    .card-box p {
        font-size: 18px;
        color: #f1f1f1;
    }

    .card-box .icon {
        position: absolute;
        top: auto;
        bottom: 5px;
        right: 5px;
        z-index: 0;
        font-size: 72px;
        color: rgba(0, 0, 0, 0.15);
    }

    .card-box .card-box-footer {
        position: absolute;
        left: 0px;
        bottom: 0px;
        text-align: center;
        padding: 3px 0;
        color: rgba(255, 255, 255, 0.8);
        background: rgba(0, 0, 0, 0.1);
        width: 100%;
        text-decoration: none;
        border-radius: 4em;
    }

    .card-box:hover .card-box-footer {
        background: rgba(0, 0, 0, 0.3);
    }

    .bg-blue {
        background-color: #00c0ef !important;
    }

    .bg-green {
        background-color: #00a65a !important;
    }

    .bg-orange {
        background-color: #f39c12 !important;
    }

    .bg-red {
        background-color: #d9534f !important;
    }

    .green-border-table {
        border-left: 5px solid green;
        /* Ancho y color de la franja izquierda */
    }

    /* Opcional: Ajusta el espacio entre la franja y el contenido de la tabla */
    .green-border-table td {
        padding-left: 10px;
        /* Ajusta según sea necesario */
    }

    .red-border-table {
        border-left: 5px solid red;
        /* Ancho y color de la franja izquierda */
    }

    /* Opcional: Ajusta el espacio entre la franja y el contenido de la tabla */
    .red-border-table td {
        padding-left: 10px;
        /* Ajusta según sea necesario */
    }

    @keyframes santaRun {
        0% {
            transform: translateX(100%);
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateX(-100%);
            opacity: 0;
        }
    }

    #santa {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100px;
        animation: santaRun 10s linear infinite;
        visibility: visible;

    }

    @media (max-width: 768px) {
        #santa {
            visibility: hidden;
        }
    }

    .santa-hat-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
    }

    .santa-hat-img {
        width: 85%;
        height: auto;
        margin-top: -25px;
    }

    .status-circle1 {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        margin-left: 5px;
        /* Ajusta el margen según sea necesario */
    }

    .status-circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: green;
        border-radius: 50%;
        margin-left: 5px;
        /* Ajusta el margen según sea necesario */
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

    /* Agrega estilos para la clase 'activo' */
    .ver-periodo-btn.activo {
        color: #FFFF;
        background-color: #1371C7;

    }
</style> -->

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li class="active">
                    <!-- <div class="card"
                        style="background-color: #80865E;  border: none; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);"> -->
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
                                echo "<img src='" . base_url('/fotos_colab/perfil.png') . "' class='rounded-circle img-fluid' style='border: 2px solid #4070f4'>";
                            } else {
                                echo "<img src='" . base_url('/fotos_colab/' . $foto) . "' class='rounded-circle img-fluid' style='border: 2px solid #4070f4'>";
                            }
                            ?>

                        </div>
                        <div class="sidebar-header text-center">
                            <h6 style="font-weight: bold;">Bienvenid@,
                                <?=
                                    $nombre = $session->get('nombre');
                                $nombre ?>
                            </h6>
                            <h6>
                                <?=
                                    $descripcion = $session->get('descripcion');
                                $descripcion ?>
                            </h6>
                            <strong style="font-size: 8px;">TURING-IA</strong>
                        </div>
                    </div>
                    <hr>
                </li>
                <li>
                    <a href="<?php echo base_url("/home/index"); ?>" data-toggle="tooltip" class="nav-link"
                        data-placement="bottom" title="Explorar nuevas noticias">
                        <i class="fas fa-newspaper"></i>
                        Noticias
                    </a>

                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-hand-holding-usd"></i>
                        Nómina
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?php echo base_url("home/index/history"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Aprobar nóminas">
                                <i class="fas fa-dollar-sign"></i>
                                Aprobar nómina
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url("home/index/receiptss"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Ver recibos de pago">
                                <i class="fas fa-file-pdf"></i> Recibos de pago</a>
                        </li>

                    </ul>

                    <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-check-square"></i>
                        Asistencia
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">
                        <li>
                            <a href="<?php echo base_url("home/registro"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Registro de hora de entrada y salida">
                                <i class="fas fa-check-circle"></i> Check</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/permisos"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Visualizar permisos del colaborador">
                                <i class="fas fa-unlock"></i> Permisos </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/incidencias"); ?>" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Visualizar reportes de incidencias ocurridas">
                                <i class="fas fa-info-circle"></i> Incidencias </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/market"); ?>" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Registro de horas y/o días extras solicitados">
                                <i class="fas fa-clock"></i> Horas/dias extras </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("home/vacaciones"); ?>" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Visualizar periodos de vacaciones por colaborador">
                                <i class="fas fa-calendar" aria-hidden="true"></i> Vacaciones </a>
                        </li>

                    </ul>

                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-chart-line"></i>
                        Performance
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu2">
                    <li>
                            <a href="#" data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Desempeño y competencias del colaborador">
                                <i class="fas fa-check-circle"></i> Desempeño</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Centro de aprendizaje">
                                <i class="fas fa-chart-bar"></i> Aprendizaje </a>
                        </li>
                    </ul>

                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="<?php echo base_url("/index/user_admin.pdf"); ?>" target="_blank" class="download"> <i
                            class="fas fa-file-pdf"></i> Manual de usuario </a>
                </li>
            </ul>
        </nav>
        <img src="<?php echo base_url("login/img/santa.gif"); ?>" alt="Santa Claus corriendo" id="santa">

        <!-- Page Content  -->
        <div id="content">

        <nav class="navbar navbar-expand-lg navbar- bg-">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light"
                        title="Cerrar"  style="color: #707070; background: white">
                        <i class="fas fa-expand"></i>
                        <span> </span>
                    </button> 
                    <a class="btn btn-light" href="#" title="Configuración"  style="color: #707070; background: white"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='fas fa-cogs'></i></a>

                    <div class="dropdown-menu acciones" style='float: right;'>
                        <a href='<?php echo base_url("home/account"); ?>' class='dropdown-item'>
                            <i class='fas fa-cog'></i> Configuración de perfil
                        </a>
                    </div>
                    <button class="btn btn-info d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">


                                <?php
                                $session = session();
                                if (!empty($data)) {
                                    $data = $session->get('data');

                                    $title = $data['title'];
                                    $total = $data['total'];
                                    $body = $data['body'];

                                    ?>
                                    <!--<a class="btn btn-outline-info btn-xs btn-radius" href="#" data-toggle="tooltip"
                                        class="nav-link" data-placement="bottom" title="Notificaciones"
                                        onclick="notif(event, '<?php echo $total; ?>','<?php echo $title; ?>', '<?php echo $body; ?>')">
                                        <i class="fas fa-bell"></i> 
                                        <?php echo $total; ?>
                                    </a>-->
                                <?php } else { ?>

                                    <!--<a class="btn btn-outline-info btn-xs btn-radius" href="#" data-toggle="tooltip"
                                        class="nav-link" data-placement="bottom" title="Notificaciones"
                                        onclick="notif(event, '<?php echo $totall = 0; ?>','<?php echo $title = 'Notificación'; ?>', '<?php echo $body = 'Hola'; ?>')">
                                        <i class="fas fa-bell"></i>
                                        <?php echo $total = 0; ?>
                                    </a>|-->
                                <?php }

                                ?>
                            </li>
                            <a class="btn btn-light" title="Cerrar sesión" style="color: #707070; background: white"
                                data-toggle="tooltip" class="nav-link" data-placement="bottom" title="Cerrar sesión"
                                href="<?php echo base_url("/home/destroy"); ?>"> <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </ul>
                    </div>
                    <!--<div class="collapse" id="notificacionesPanel">
                        <div class="">
                        
                            <p>¡Tienes nuevas notificaciones!</p>
                            <p>Otra notificación importante.</p>
                        </div>
                    </div>-->
                </div>
            </nav>