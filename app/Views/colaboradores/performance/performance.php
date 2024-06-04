<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('colaboradores/header') ?>

<style>
    .section_left {
        float: left;
        background-color: whitesmoke;


    }

    .section_right {
        float: right;
        background-color: #3498db;
        color: white;

    }
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance |</a> Feedbacks
        <i class="fas fa-info-circle"></i>

        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Detalle
            <i class='fas fa-exclamation-circle'></i>
        </button>
        <div class="dropdown-menu acciones">
            <a href="#!" onclick="newFdb(event)"><i class="fas fa-paper-plane" style="color: #3498db"></i> Dar feedback
                -
                <?= $t ?>
            </a> <br>
            <a href="<?php echo base_url('home/verC'); ?>" target="_blank"><i class="fas fa-plus"
                    style="color: green;"></i> Nuevo evento
            </a>
        </div>
    </h4>
    

    <div class="card-header" style="text-align: center;">
        <strong> <i class="fas fa-info-circle" style="color: #3498db;"></i> Vista de control de performance
        </strong>
        <hr>
        <div id="btns">

            <a href="#" class="ver-periodo-btn" onclick="mostrarc('feedbacks')" id="b1" data-toggle="tooltip"
                data-placement="bottom" title="Reporte de feedbacks"> <i class="fas fa-clock"></i>
                Feedbacks
            </a>|

            <a href="#" class="ver-periodo-btn" onclick="mostrarc('desempeño')" id="b2" data-toggle="tooltip"
                data-placement="bottom" title="Control de desempeño"> <i class="fas fa-check-circle"></i>
                Desempeño </a> |

            <a href="#" class="ver-periodo-btn" onclick="mostrarc('competencias')" id="b3" data-toggle="tooltip"
                data-placement="bottom" title="Control de competencias y habilidades"> <i
                    class="fas fa-check-circle"></i>
                Competencias </a>
        </div>

    </div>
    <div class="card-body" id="feedbackSection">
        <div class="row">
            <!-- <div class="ag-courses_item">
                <a href="#!" onclick="mostrarc('mios')" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Mis feedbacks
                    </div>
                    <div class="ag-courses-item_date-box">
                        Feedbacks que se han dado
                        <span class="ag-courses-item_date">
                        </span>
                    </div>
                </a>
            </div>
            <div class="ag-courses_item">
                <a href="#!" onclick="mostrarc('todos')" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Todos los feedbacks

                    </div>
                    <div class="ag-courses-item_date-box">
                        Lista completa de feedbacks
                        <span class="ag-courses-item_date">

                        </span>
                    </div>
                </a>
            </div> -->

            <div class="col-lg-6 col-sm-6" onclick="mostrarc('mios')">
                <div class="card-box bg-green">
                    <div class="inner">
                        <h3><a href="#!" onclick="mostrarc('mios')">Mis feedbacks

                            </a> </h3>
                        <p> <a href="#!" onclick="mostrarc('mios')">Feedbacks que me han dado </a>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                    </div>
                    <a href="#!" onclick="mostrarc('mios')" class="card-box-footer" id="pendientesBtn1"><i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6" onclick="mostrarc('todos')">
                <div class="card-box bg-blue">
                    <div class="inner">
                        <h3> <a href="#!" onclick="mostrarc('todos')">Todos los feedbacks
                            </a> </h3>
                        <p> <a href="#!" onclick="mostrarc('todos')">Lista completa de feedbacks </a>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </div>
                    <a href="#!" onclick="mostrarc('todos')" class="card-box-footer" id="pendientesBtn2"><i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!----->
    <div class="card-body" id="mios" style="overflow-y: auto; max-height: auto;">
        <div class="row page-titles mx-0" style="font-weight:bold;">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Mis feedbacks</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">
                            <?= $tot ?> feedbacks
                        </a></li>
                </ol>
            </div>
        </div>


        <div class="search-box">
            <input type="text" id="search" oninput="filterTabless()" placeholder="Escriba para buscar feedback">
        </div>

        <?php if (empty($fedback)): ?>
        <div class="alert alert-danger" style="text-align: center;">No hay
            feedbacks actualmente</div>
        <?php else: ?>

        <?php
        foreach ($fedback as $index => $info):
            $fecha = strtotime($info->fecha_creacion);
            $fecha_formateada = strftime("%d de %B de %Y", $fecha);
            $hora_formateada = date("H:i A", $fecha);
            $editor_iddd = "editor_iddd" . ($index + 1);
            ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="card-container">
                            <div class="card1">
                                <div class="card-body" style="background: white; border-radius:1rem">
                                    <div class="email-right-box">
                                        <?php if ($info->id_autor == $id_usuario): ?>
                                        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius"
                                            style='float: right;' title="Crear periodos" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class='fas fa-caret-down'></i>
                                        </button>
                                        <div class="dropdown-menu acciones">
                                            <a href="<?php echo base_url("/home/performance/edit/$info->id"); ?>"><i
                                                    class="fas fa-heart" style="color: red;"></i>
                                                Editar feedback </a> <br>
                                            <a href="#!" onclick="delFed(event, '<?= $info->id ?>')"><i
                                                    class="fas fa-trash" style="color: #3498db"></i>
                                                Eliminar feedback</a>
                                        </div>
                                        <?php else: ?>
                                        <?php endif; ?>
                                        <div class="read-content">
                                            <div class="media pt-1">
                                                <div class="d-flex">
                                                    <img class="mr-3 rounded-circle" id="usrimg"
                                                        src="<?php echo base_url("fotos_colab/$info->foto_autor") ?>"
                                                        style="max-width: 58px; max-height:58px;">
                                                    <div class="media-body">
                                                        <h5 class="m-b-5">
                                                            <?= $info->n_autor . " " . $info->ap_autor; ?>
                                                        </h5>
                                                        <p class="m-b-2">
                                                            <?= $fecha_formateada; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div style="margin-top: 15px;">
                                                    <i class="fas fa-arrow-circle-right ml-3"> </i>
                                                </div>
                                                <div class="colab_que_le_hacen_feedback ml-3">
                                                    <div class="media pt-1">
                                                        <img class="mr-3 rounded-circle" id="usrimg"
                                                            src="<?php echo base_url("fotos_colab/$info->foto_usuario") ?>"
                                                            style="max-width: 55px;">
                                                        <div class="media-body">
                                                            <h5 class="m-b-5">
                                                                <?= $info->n_usuario . " " . $info->ap_usuario; ?>
                                                            </h5>
                                                            <p class="m-b-2">
                                                                <?= $fecha_formateada; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            </hr>
                                            <div class="media mb-4 mt-1">
                                                <div class="media-body"><span class="float-right"
                                                        style="font-weight:bold;">
                                                        <?= $hora_formateada; ?>
                                                    </span>
                                                    <h4 class="m-0 text-primary">
                                                        <?= $info->titulo; ?>
                                                    </h4><small class="text-muted">De:
                                                        <?= $info->correo_autor; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <p style="text-align: justify;"><strong>
                                                    <?= $info->contenido; ?>
                                                </strong>
                                            </p>
                                            <?php if (empty($coments)): ?>
                                            <strong>
                                                <hr>
                                            </strong>

                                            <div class="alert alert-danger" style="text-align: center;">No hay
                                                comentarios actualmente</div>
                                            <?php else: ?>
                                            <div class="comments" style="border:none;">
                                                <strong>
                                                    <hr>
                                                </strong>
                                                <?php foreach ($coments as $key):
                                                    $fecha = strtotime($key->fecha_creacion);
                                                    // Formatear la fecha solo para mostrar la fecha en español
                                                    $fecha_formateada1 = strftime("%d de %B de %Y", $fecha);
                                                    $hora_formateada1 = date("H:i A", $fecha);
                                                    // Verificar si el comentario pertenece al feedback actual
                                                    if ($key->fed_id == $info->id):
                                                        ?>
                                                <div class="comment">
                                                    <p class="author ">
                                                        <?= $key->n_autor . " " . $key->ap_autor . " en " . $fecha_formateada1 . " - " . $hora_formateada1 . '' ?>
                                                    </p>
                                                    <?php if ($key->id_autor == $id_usuario): ?>
                                                    <button type='button' class="btn ver-periodo-btn btn-xs btn-radius"
                                                        style='float: right;' title="Crear periodos"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class='fas fa-caret-down'></i>
                                                    </button>
                                                    <div class="dropdown-menu acciones">
                                                        <a href="#!"><i class="fas fa-heart" style="color: red;"></i>
                                                            Editar comentario </a> <br>
                                                        <a href="#!"
                                                            onclick="delComen(event, '<?php echo $key->id; ?>')"><i
                                                                class="fas fa-trash" style="color: #3498db"></i>
                                                            Eliminar comentario</a>
                                                    </div>
                                                    <?php else: ?>
                                                    <?php endif; ?>

                                                    <p>
                                                        <?= $key->contenido; ?>
                                                    </p>

                                                </div>
                                                <?php endif; // Fin de la verificación de pertenencia del comentario                                                          ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php endif; ?>
                                            <form method="POST"
                                                action="<?php echo base_url('/home/guardarComentario'); ?>">
                                                <td><textarea name="contenido" id="<?= $editor_iddd ?>"
                                                        placeholder="Comentar"></textarea></td>
                                                <input type="hidden" name="id_feedback" value="<?= $info->id ?>">
                                                <input type="hidden" name="id_autor" value="<?= $id_usuario ?>">
                                                <input type="hidden" name="fecha_creacion"
                                                    value="<?= date('Y-m-d\TH:i'); ?>">
                                                <br>
                                                <button type="submit" class="ver-periodo-btn2 text-center "><i
                                                        class="fa fa-paper-plane"></i> </button>
                                            </form>

                                            <script>
                                                // Inicializa CKEditor para el textarea con el ID único generado
                                                ClassicEditor.create(document.querySelector("#<?= $editor_iddd ?>"), {
                                                    ckfinder: {
                                                        // Especifica la URL de carga para CKFinder
                                                        uploadUrl: '<?php echo base_url('home/upload'); ?>', // Asegúrate de configurar esta ruta en tu controlador
                                                    }
                                                })
                                                    .catch(error => {
                                                        console.log(error);
                                                    });
                                            </script>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php endforeach; ?>

        <div class="alert alert-danger" id="mensaje-sin-user" style="display: none; text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> Sin usuario disponible </div>

        <?php endif; ?>
    </div>

    <!--TODOS LOS FEEDBACKS--->
    <div class="card-body" id="todos" style="display:none; overflow-y: auto; max-height: 800px;">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Todos los feedbacks</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">
                            <?= $tot2 ?> feedbacks
                        </a></li>
                </ol>
            </div>
        </div>

        <?php if (empty($all)): ?>
        <div class="alert alert-danger" style="text-align: center;">No hay
            feedbacks actualmente</div>
        <?php else: ?>

        <?php
        foreach ($all as $index => $info):
            $fecha = strtotime($info->fecha_creacion);
            // Formatear la fecha solo para mostrar la fecha en español
            $fecha_formateada = strftime("%d de %B de %Y", $fecha);
            $hora_formateada = date("H:i A", $fecha);
            $editor_id = "editor" . ($index + 1);
            ?>
        <?php if ($info->privacidad == '1'): //1 solo colab lo ve                                  ?>
        <?php else: //1 solo colab lo ve                                  ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="card-container">
                            <div class="card1">
                                <div class="card-body" style="background: white; border-radius:1rem">
                                    <div class="email-right-box">
                                        <?php if ($info->id_autor == $id_usuario): ?>
                                        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius"
                                            style='float: right;' title="Crear periodos" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class='fas fa-caret-down'></i>
                                        </button>
                                        <div class="dropdown-menu acciones">
                                            <a href="<?php echo base_url("/home/performance/edit/$info->id"); ?>"><i
                                                    class="fas fa-heart" style="color: red;"></i>
                                                Editar feedback </a> <br>
                                            <a href="#!" onclick="delFed(event, '<?= $info->id ?>')"><i
                                                    class="fas fa-trash" style="color: #3498db"></i>
                                                Eliminar feedback</a>
                                        </div>
                                        <?php else: ?>
                                        <?php endif; ?>
                                        <div class="read-content">
                                            <div class="media pt-1">
                                                <div class="d-flex">
                                                    <img class="mr-3 rounded-circle" id="usrimg"
                                                        src="<?php echo base_url("fotos_colab/$info->foto_autor") ?>"
                                                        style="max-width: 58px; max-height:58px;">
                                                    <div class="media-body">
                                                        <h5 class="m-b-5">
                                                            <?= $info->n_autor . " " . $info->ap_autor; ?>
                                                        </h5>
                                                        <p class="m-b-2">
                                                            <?= $fecha_formateada; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div style="margin-top: 15px;">
                                                    <i class="fas fa-arrow-circle-right ml-3"> </i>
                                                </div>
                                                <div class="colab_que_le_hacen_feedback ml-3">
                                                    <div class="media pt-1">
                                                        <img class="mr-3 rounded-circle" id="usrimg"
                                                            src="<?php echo base_url("fotos_colab/$info->foto_usuario") ?>"
                                                            style="max-width: 55px;">
                                                        <div class="media-body">
                                                            <h5 class="m-b-5">
                                                                <?= $info->n_usuario . " " . $info->ap_usuario; ?>
                                                            </h5>
                                                            <p class="m-b-2">
                                                                <?= $fecha_formateada; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="media mb-4 mt-1">
                                                <div class="media-body"><span class="float-right"
                                                        style="font-weight:bold;">
                                                        <?= $hora_formateada; ?>
                                                    </span>
                                                    <h4 class="m-0 text-primary">
                                                        <?= $info->titulo; ?>
                                                    </h4><small class="text-muted">De:
                                                        <?= $info->correo_autor; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <p style="text-align: justify;"><strong>
                                                    <?= $info->contenido; ?>
                                                </strong>
                                            </p>
                                            <?php if (empty($coments)): ?>
                                            <strong>
                                                <hr>
                                            </strong>
                                            <hr>
                                            <div class="alert alert-danger" style="text-align: center;">No hay
                                                comentarios actualmente</div>
                                            <?php else: ?>
                                            <div class="comments" style="border:none;">
                                                <strong>
                                                    <hr>
                                                </strong>
                                                <?php foreach ($coments as $key):
                                                    $fecha = strtotime($key->fecha_creacion);
                                                    // Formatear la fecha solo para mostrar la fecha en español
                                                    $fecha_formateada1 = strftime("%d de %B de %Y", $fecha);
                                                    $hora_formateada1 = date("H:i A", $fecha);
                                                    // Verificar si el comentario pertenece al feedback actual
                                                    if ($key->fed_id == $info->id):
                                                        ?>
                                                <div class="comment">
                                                    <p class="author ">
                                                        <?= $key->n_autor . " " . $key->ap_autor . " en " . $fecha_formateada1 . " - " . $hora_formateada1 . '' ?>
                                                    </p>
                                                    <?php if ($key->id_autor == $id_usuario): ?>
                                                    <button type='button' class="btn ver-periodo-btn btn-xs btn-radius"
                                                        style='float: right;' title="Crear periodos"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class='fas fa-caret-down'></i>
                                                    </button>
                                                    <div class="dropdown-menu acciones">
                                                        <a href="#!"><i class="fas fa-heart" style="color: red;"></i>
                                                            Editar comentario </a> <br>
                                                        <a href="#!"
                                                            onclick="delComen(event, '<?php echo $key->id; ?>')"><i
                                                                class="fas fa-trash" style="color: #3498db"></i>
                                                            Eliminar comentario</a>
                                                    </div>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?= $key->contenido; ?>
                                                    </p>
                                                </div>
                                                <?php endif; // Fin de la verificación de pertenencia del comentario                                                          ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php endif; ?>
                                            <form method="POST"
                                                action="<?php echo base_url('/home/guardarComentario'); ?>">
                                                <td><textarea name="contenido" id="<?= $editor_id ?>"
                                                        placeholder="Comentar"></textarea></td>
                                                <input type="hidden" name="id_feedback" value="<?= $info->id ?>">
                                                <input type="hidden" name="id_autor" value="<?= $id_usuario ?>">
                                                <input type="hidden" name="fecha_creacion"
                                                    value="<?= date('Y-m-d\TH:i'); ?>">
                                                <br>
                                                <button type="submit" class="ver-periodo-btn2 text-center "><i
                                                        class="fa fa-paper-plane"></i> </button>
                                            </form>
                                            <script>
                                                // Inicializa CKEditor para el textarea con el ID único generado
                                                ClassicEditor.create(document.querySelector("#<?= $editor_id ?>"));
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php endif; ?>
        <?php endforeach; ?>

        <div class="alert alert-danger" id="mensaje-sin-user" style="display: none; text-align: center;"> <i
                class="fa fa-exclamation-circle"></i> Sin usuario disponible </div>
        <?php endif; ?>

    </div>

    <div class="card-body" id="desempeñoSection" style="display:none;">
        <div class="card-header" style="text-align: center;">
            <strong>¿Qué es un 1:1?</strong>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Las reuniones one to one consisten en un encuentro breve entre un miembro de un equipo y de su
                supervisor directo, con el propósito de identificar desafíos, corregir errores o abordar
                necesidades, así como aumentar la eficiencia o infundir nuevas ideas en un proyecto.
                <br>
                ¡Que tengan un excelente día!
            </small>
        </div>

        <table>
            <tr style="text-align: center; font-weight:bold;">
                <th>
                    Título

                </th>
                <th>
                    Fecha y hora de inicio
                </th>
                <th>
                    Fecha y hora de fin
                </th>
                <th>
                    Ubicacion
                </th>
                <th>
                    Opciones
                </th>
            </tr>

            <?php foreach ($events as $event): ?>
            <tr style="text-align: center;">

                <td>
                    <?php
                    $descripcion = strlen($event->titulo) > 30 ? substr($event->titulo, 0, 30) . '<a href="#!" style="color:blue;" onclick="detalle(event, \'' . htmlspecialchars($event->titulo) . '\')">...</a>' : $event->titulo;
                    echo $descripcion;
                    ?>
                </td>
                <td>
                    <?= $event->f_inicio ?>
                </td>
                <td>
                    <?= $event->f_fin ?>
                </td>
                <td>
                    <?= $event->ubicacion ?>
                </td>
                <td>
                    <a href="<?php echo base_url('home/verC'); ?>" class="ver-periodo-btn2 text-center ">Calendario</a>
                </td>

            </tr>
            <?php endforeach; ?>
        </table>


    </div>

    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 25px;
            border: solid none;
            height: auto;
        }

        .section_left,
        .section_right {
            width: 100%;
            /* Ahora ocupará el 100% del ancho en dispositivos pequeños */
            margin-bottom: 20px;
            /* Espacio entre las secciones */
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
            border-radius: 1rem;
            border: solid black 0.5px;
        }

        .section_left {
            background-color: whitesmoke;
        }

        .section_right {
            background-color: #3498db;
            color: white;
        }

        #values,
        #values1 {
            text-align: center;
            border-radius: 1rem;
        }

        .border-left-red {
            border-left: 8px solid #3498db;
        }

        .border-left-color {
            border-left: 8px solid blue;
        }

        h3 {
            font-weight: bold;
        }

        span,
        img {
            text-align: left;
        }

        .profile-image img {
            width: 20px;
            height: 80px;
            border: 2px solid #007bff;
            border-radius: 50%;
        }

        @media screen and (min-width: 768px) {

            .section_left,
            .section_right {
                width: 48%;
                /* Vuelve a ocupar el 48% del ancho en dispositivos medianos y grandes */
            }
        }
    </style>

    <div class="card-body" id="competenciasSection" style="display:none;">
        <div class="container">
            <div class="section_left border-left-red">
                <h3>HABILIDADES BLANDAS</h3>
                <span>Habilidades relacionadas a cómo trabajas e interactuas con otros en el trabajo. </span>
                <hr>
                <?php foreach ($compe as $com): ?>
                <?php if ($com->tipo == 'Blandas'): ?>
                <div style="position: relative;">
                    <input type="text" name="values" id="values" value="<?= $com->habilidad; ?>" class="form-control"
                        style="padding-left: 25px;" ondblclick="delHabi(event, '<?php echo $com->id ?>')"
                        oninput="update(this, '<?php echo $com->id ?>' )">
                </div>
                <br>
                <?php endif; ?>
                <?php endforeach; ?>
                <!-- Resto del formulario para guardar habilidades blandas -->
                <form action="<?php echo base_url('home/saveHabi'); ?>" method="POST">
                    <div id="nuevoInput"> </div> <!-- Aquí se agregarán los nuevos inputs -->

                    <hr>
                    <input type="submit" class="btn ver-periodo-btn" value="Guardar" style="display: none;">
                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                    <input type="hidden" name="tipo" value="Blandas">
                </form>
                <br>
                <td><input type="button" class="btn ver-periodo-btn2" value=" + Agregar" onclick="agregarInput()"
                        id="agregarBtn"></td>
            </div>

            <div class="section_right border-left-color">
                <h3>HABILIDADES TÉCNICAS</h3>
                <span>Habilidades especificas del trabajo y conocimientos técnicos medibles. </span>
                <hr>
                <?php foreach ($compe as $com): ?>
                    <?php if ($com->tipo == 'Tecnicas'): ?>
                        <div style="position: relative;">
                            <input type="text" name="values" id="values1" value="<?= $com->habilidad; ?>" class="form-control"
                                style="padding-left: 25px;" ondblclick="delHabi(event, '<?php echo $com->id ?>')"
                                oninput="update(this, '<?php echo $com->id ?>' )">
                        </div>
                        <br>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- Resto del formulario para guardar habilidades técnicas -->
                <form action="<?php echo base_url('home/saveHabi'); ?>" method="POST">
                    <div id="nuevoInput1"> </div> <!-- Aquí se agregarán los nuevos inputs -->
                    <hr>
                    <input type="submit" id="tecnicaHab" class="btn ver-periodo-btn" value="Guardar"
                        style="display: none;">
                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                    <input type="hidden" name="tipo" value="Tecnicas">
                </form>
                <br>
                <td><input type="button" class="btn ver-periodo-btn2" value=" + Agregar" onclick="agregarInput1()"
                        id="agregarBtn"></td>
            </div>
        </div>
    </div>

</div>


<script>
    function agregarInput() {
        var nuevoInput = document.createElement('input');
        nuevoInput.type = 'text';
        nuevoInput.name = 'nuevoValues[]';
        nuevoInput.style = 'text-align: center;';
        nuevoInput.style = 'border-radius: 1rem;';
        nuevoInput.placeholder = 'Nueva habilidad blanda';
        nuevoInput.className = 'form-control';
        nuevoInput.required = 'required';

        var contenedor = document.getElementById('nuevoInput');
        contenedor.appendChild(nuevoInput);

        // Mostrar el botón de enviar cuando se agrega un nuevo input
        document.querySelector('input[type="submit"]').style.display = 'inline-block';
    }

</script>

<script>
    function agregarInput1() {
        var nuevoInput = document.createElement('input');
        nuevoInput.type = 'text';
        nuevoInput.name = 'nuevoValues[]';
        nuevoInput.style = 'text-align: center;';
        nuevoInput.style = 'border-radius: 1rem;';
        nuevoInput.placeholder = 'Nueva habilidad técnica';
        nuevoInput.className = 'form-control';
        nuevoInput.required = 'required';

        var contenedor = document.getElementById('nuevoInput1');
        contenedor.appendChild(nuevoInput);

        document.getElementById('tecnicaHab').style.display = 'inline-block';
        // Mostrar el botón de enviar cuando se agrega un nuevo input
        //document.querySelector('input[type="submit"]').style.display = 'inline-block';
    }
</script>

<?= $this->include('colaboradores/footer') ?>
<?php include ("scripts.php"); ?>