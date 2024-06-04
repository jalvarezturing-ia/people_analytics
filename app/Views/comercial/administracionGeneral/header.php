<?php $session = session(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo base_url("fotos_colab/turing-ia.png"); ?>" type="image/x-icon" />
    <title>Turing Nómina</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url("/index/css/style.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/admin/css/style.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("/index/css/cards.css"); ?>">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-eaR/o8R2/qOQVGaRlQsD5eRe3pN7m3dRAVwnQFz7JRMwRR65kHw9u5L5Jd9uHcqu" crossorigin="anonymous">
     Incluye SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

</head>

<style>
    #sidebar .sidebar-pageSubmenu a strong {
        display: none;
        font-size: 1.8em;
    }



    @media (max-width: 768px) {
        #infoBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #inactivosBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #activosBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #cvBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #contratoBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #bancoBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #baja {
            font-size: 10px;
            padding: 5px 10px;
        }

        #cvSection {
            border: chartreuse;
        }

        #contratoSection {
            display: none;
        }

        #beneficiarioBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #domicilioBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #estudiosBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #rfcBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #bancariosBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #pendientesBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

        #pagadosBtn {
            font-size: 10px;
            padding: 5px 10px;
        }

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

    /* Agrega estilos para la clase 'activo' */
    .ver-periodo-btn.activo {
        color: #FFFF;
        background-color: #1371C7;

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

    .avatar-wrapper {
        position: relative;
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
    <div class="wrapper">
        <nav id="sidebar">

            <ul class="list-unstyled components">
                <li class="active">
                    <div class="card" style=" border: none; ">
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
                            <h6 style="font-weight: bold;">
                                Bienvenido a
                                <?=
                                    $nombre = $session->get('nombre');
                                $nombre
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
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-hand-holding-usd"></i>
                        Nómina
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?php echo base_url("/home/newboard"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Crear una nueva nómina">
                                <i class="fas fa-hand-holding-usd"></i> Datos nómina</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('/home/nomina'); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Gestionar las nóminas">
                                <i class="fas fa-dollar-sign"></i> Gestión nómina</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("/home/nomina/terminations"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Consultar finiquitos">
                                <i class="fas fa-file-alt"></i> Finiquitos</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url("home/index/receipts"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Ver recibos de pago">
                                <i class="fas fa-file-pdf"></i> Recibos de pago</a>
                        </li>

                    </ul>

                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-users"></i>
                        Empleado
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="<?php echo base_url("/home/newcolab"); ?>" data-toggle="tooltip" class="nav-link"
                                data-placement="bottom" title="Agregar un nuevo colaborador">
                                <i class="fas fa-plus"></i> Agregar </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("/home/nomina/people"); ?>" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Explorar colaboradores">
                                <i class="fas fa-users"></i> Lista
                            </a>
                        </li>

                    </ul>

                    <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-chart-line"></i>
                        Eficacia
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu1">

                        <li>
                            <a href="#" data-toggle="tooltip" class="nav-link" data-placement="bottom"
                                title="Ciclo de vida del colaborador">
                                <i class="fas fa-sync-alt"></i> Ciclos </a>
                        </li>

                    </ul>

                    <!--<a href="#">
                        <i class="fas fa-file-pdf"></i> Docs</a>
                    </a>-->

                </li>
            </ul>
            <!-- <ul class="list-unstyled CTAs">
                <li>
                    <a href="<?php echo base_url("/index/user_admin.pdf"); ?>" target="_blank" class="download"> <i
                            class="fas fa-file-pdf"></i> Manual de usuario </a>
                </li>
            </ul> -->
        </nav>
        <!--<img src="<?php echo base_url("login/img/santa.gif"); ?>" alt="Santa Claus corriendo" id="santa">-->

        <!--   Page Content  -->
        <div id="content">
        <nav class="navbar navbar-expand-lg navbar- bg-">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light" title="Cerrar"
                        style="color: #707070; background: white; border:none;">
                        <i class="fas fa-expand"></i>
                        <span> </span>
                    </button>
                    <a class="btn btn-light" href="#" title="Configuración"
                        style="color: #707070; background: white; border:none;" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class='fas fa-cog'></i></a>

                    <div class="dropdown-menu acciones" style='float: right; border-radius: 1rem;'>
                        <a href='<?php echo base_url("home/account"); ?>' class='dropdown-item'>
                            <i class='fas fa-cogs'></i> Configuración de perfil
                        </a>
                    </div>

                    <div class="search-box" style="margin-top:10px;">
                        <input type="text" id="search-modules" style='float: right; border:none;' autofocus
                            placeholder="Escriba para buscar al modulo">
                        <!-- <div id="search-results" style="text-decoration: underline; border:none; border-radius: 1rem ">
                        </div> -->
                    </div>

                     <!-- Modal -->
                     <div id="myModal" class="modal1">
                        <div class="modal-content">
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
                            <a class="btn btn-light" title="Cerrar sesión"
                                style="color: #707070; background: white;border:none;" data-toggle="tooltip"
                                class="nav-link" data-placement="bottom" title="Cerrar sesión"
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

            <!-- Modal de filtrado -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="color: #3498db; text-align:center;">
                            <h5 class="modal-title" id="filterModalLabel"> <i class="fas fa-filter"></i> Filtrado
                                avanzado</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="form-group row">
                            <label for="filterNombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-4">
                                <input type="text" id="filterNombre" class="form-control">
                            </div>
                            <label for="filterTelefono" class="col-sm-2 col-form-label">Teléfono:</label>
                            <div class="col-sm-4">
                                <input type="text" id="filterTelefono" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="filterArea" class="col-sm-2 col-form-label">Area:</label>
                            <div class="col-sm-4">
                                <input type="text" id="filterArea" class="form-control">
                            </div>
                            <label for="filterCargo" class="col-sm-2 col-form-label">Cargo:</label>
                            <div class="col-sm-4">
                                <input type="text" id="filterCargo" class="form-control">
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="filterSueldo">Filtrar por sueldo:</label>
                                <input type="text" class="form-control" id="filterSueldo">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="ver-periodo-btn" style="border: none;"
                                data-dismiss="modal">Cerrar</button>
                            <button type="button" class="ver-periodo-btn2" onclick="applyFilters()">Aplicar
                                Filtros</button>
                        </div>
                    </div>
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