<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$numero = 1; ?>
<?= $this->include('colaboradores/header') ?>

<?php
foreach ($account as $acc):
endforeach;
?>


<style>
    /* Estilo para el círculo */
    .status-circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: rgb(50, 210, 150);
        border-radius: 50%;
        margin-left: 5px;
        /* Ajusta el margen según sea necesario */
    }

    #span2 {

        color: rgb(50, 210, 150);

    }

    /* Estilo para el símbolo de estado dentro del círculo */
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url('home/performance') ?>">Performance | Ciclos </a>
        <i class="fas fa-sync-alt"></i>
    </h4>
    <hr>
    <div class="card-header" style="text-align: center;">
    <h6 style="color:#4070f4;"><span class="status-circle"></span>
        <?= $acc->nombre . " " . $acc->apellido_paterno . " " . $acc->apellido_materno; ?>
        <br>
        <br>
        <a href="#!" class="btn ver-periodo-btn" data-toggle="tooltip" class="nav-link" data-placement="bottom"
            title="Correo electrónico"><span class="fas fa-envelope" id="span2"></span>
            <?= $acc->correo; ?>
        </a> |
        <a href="#!" class="btn ver-periodo-btn" data-toggle="tooltip" class="nav-link" data-placement="bottom"
            title="Fecha de nacimiento"><span class="fas fa-user" id="span2"></span>
            <?= strftime("%d/%B/%Y", strtotime($acc->fecha_nacimiento)); ?>
        </a>
        </a> |
        <a href="#!" class="btn ver-periodo-btn" data-toggle="tooltip" class="nav-link" data-placement="bottom"
            title="Fecha de ingreso a Turing Inteligencia Artificial"><span class="fas fa-sign-in-alt" id="span2"></span>
            <?= strftime("%d/%B/%Y", strtotime($acc->fecha_ingreso)); ?>
        </a>
        </a> |
        <a href="#!" class="btn ver-periodo-btn" data-toggle="tooltip" class="nav-link" data-placement="bottom"
            title="Área desempeñada"><span class="fas fa-building" id="span2"></span>
            <?= $acc->descripcion; ?>
        </a>
        </a> |
        <a href="#!" class="btn ver-periodo-btn" data-toggle="tooltip" class="nav-link" data-placement="bottom"
            title="Edad actual"><span class="fas fa-birthday-cake" id="span2"></span>
            <?= $edad; ?> años
        </a>
    </h6>
</div>
    <div class="card-body">


        <!-- Contenido principal -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" style="color:#4070f4; font-weight:bold;">Periodo de prueba: 23/enero/2001 - 23/enero/2001 </h6>
                        <p class="card-text text-center" > <small class="form-text text-muted">
                                1. Este espacio está diseñado especialmente para ti, donde podrás gestionar aspectos
                                importantes de tu trayectoria dentro de la empresa. Desde tu ingreso hasta tu desarrollo
                                profesional, este módulo te ofrece las herramientas necesarias para hacer de tu
                                experiencia laboral una experiencia excepcional. ¡Explora y gestiona tu camino en la
                                empresa de manera sencilla y eficiente! <br>
                                2. En caso de tener algún problema, favor de reportarse
                                inmediatamente con Mayte López del área de Capital humano.<br>
                                ¡Que tengan un excelente día! <br>

                            </small></p>
                        <a href="<?php echo base_url("home/ciclos/ver/$user_id") ?>" class="btn ver-periodo-btn">Validar periodo</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>



<?= $this->include('colaboradores/footer') ?>