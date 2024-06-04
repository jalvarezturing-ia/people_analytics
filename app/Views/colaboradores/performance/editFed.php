<?= $this->include('colaboradores/header') ?>



<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/performance"); ?>">Performance ></a> Feedbacks > Editar
        Feedback
        <i class="fas fa-info-circle"></i>
    </h4>
    <hr>

    <div class="card-body" id="feedbackSection">
        <form action="<?php echo base_url("home/savechanges"); ?>" method="POST">
            <?php foreach ($info as $key):
                $fecha = strtotime($key->fecha_creacion);
                $hora_formateada = date("H:i A", $fecha);
                ?>
                <div class="content-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="card-container">
                                    <div class="card1">
                                        <div class="card-body" style="background: white; border-radius:1rem">
                                            <div class="email-right-box">
                                                <div class="read-content">
                                                    <div class="media pt-1">
                                                    </div>
                                                    </hr>
                                                    <div class="media mb-4 mt-1">
                                                        <div class="media-body"><span class="float-right"
                                                                style="font-weight:bold;">

                                                            </span>
                                                            <h4 class="m-0 text-primary">
                                                                Titulo:
                                                                <input type="text" value="<?= $key->titulo; ?>"
                                                                    class="form-control" name="titulo">
                                                                <input type="hidden" value="<?= $key->id_fed; ?>"
                                                                    class="form-control" name="id_fed">
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <p style="text-align: justify;"><strong>
                                                            <textarea name="contenido" id="contenido" cols="30"
                                                                rows="10"> <?= $key->contenido; ?></textarea>
                                                    </p>
                                                    <h4 class="m-0 text-primary">
                                                        Privacidad actual:
                                                        <?php if($key->privacidad === '0'): ?>
                                                            Todos
                                                        <?php elseif($key->privacidad === '1'): ?>
                                                            Solo Colaborador
                                                        <?php elseif($key->privacidad === '2'): ?>
                                                            Solo yo
                                                        <?php endif; ?>
                                                        <!-- The second value will be selected initially -->
                                                        <select name="privacidad" class="form-control" >
                                                            <option value="<?= $key->privacidad; ?>" selected>Selecciona la privacidad</option>
                                                            <option value="0">Todos</option>
                                                            <option value="1">Colaborador</option>
                                                            <option value="2">Solo yo</option>
                                                        </select>

                                                    </h4>

                                                    <div class="comments" style="border:none;">
                                                        <strong>
                                                            <hr>
                                                        </strong>

                                                        <div class="comment">
                                                            <p class="author ">

                                                            </p>

                                                            <p>

                                                            </p>
                                                        </div>

                                                    </div>


                                                    <button type="submit" class="ver-periodo-btn2 text-center "><i
                                                            class="fa fa-paper-plane"></i> </button>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>
</div>

<script>
    // Inicializa CKEditor para el textarea con el ID único generado
    ClassicEditor.create(document.querySelector("#contenido"));
</script>


<?= $this->include('colaboradores/footer') ?>