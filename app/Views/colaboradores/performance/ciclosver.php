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
  <h4 class="title-wish"> <a href="<?php echo base_url('home/ciclos') ?>">Performance | Ciclos </a> | Detalles periodo
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
        <?php foreach ($ciclos as $cic): ?>
          <div class="card">
            <div class="card-body">
              <h6 class="card-title text-center" style="color:#4070f4; font-weight:bold;">Detalles:
                <?= $cic->detalles ?>
              </h6>
              <span class="text-center">
                Fecha de inicio:
                <?= strftime("%d/%B/%Y", strtotime($cic->f_inicio)); ?>
              </span>
              <br>
              <span class="text-center">
                Fecha de finalización:
                <?= strftime("%d/%B/%Y", strtotime($cic->f_fin)); ?>
              </span>
              <br>
              <span class="text-center">
                <?php
                // Fecha actual
                date_default_timezone_set('America/Mexico_City');
                setlocale(LC_TIME, "spanish");
                $hoy = time(); // Marca de tiempo Unix de la fecha actual
              
                // Fecha de finalización (convertida a marca de tiempo Unix)
                $fecha_fin = strtotime($cic->f_fin);

                // Calcula la diferencia en segundos entre la fecha de finalización y la fecha actual
                $diferencia = $fecha_fin - $hoy;

                // Convierte la diferencia de segundos a días
                $dias_restantes = floor($diferencia / (60 * 60 * 24));

                // Imprime los días restantes
              
                ?>

                Días restantes:
                <?= $dias_restantes ?>
              </span>
              <br>
              <span class="text-center">
                Estado:
                <?= $cic->estado ?>
              </span>
              <div class="info-card small">

                <div class="line"></div>
                <img src="https://studiobehind90.com/wp-content/uploads/2019/12/Gamuda_Portal_Behind90_0001.gif" alt=""
                  id="indeximg">
                <br><br>
              </div>
              <a href="<?php echo base_url("home/ciclos") ?>" class="btn ver-periodo-btn1">Cancelar</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>




<?= $this->include('colaboradores/footer') ?>