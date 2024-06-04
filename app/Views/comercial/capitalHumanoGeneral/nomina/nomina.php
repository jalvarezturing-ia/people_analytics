<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<?php 
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$in = strftime("%d/%B/%Y", strtotime($inicio));
$fn = strftime("%d/%B/%Y", strtotime($fin)); ?>


<div class="info-card vertical">
    <h4 class="title-wish"><a href="<?php echo base_url("/home/index/capital"); ?>">Periodo por bancos > </a>
    <?=  $in . " a " . $fn; ?>
        
    </h4>
    <br>
    <div class="line"> </div>
    <div class="card-columns">
        <!-- Iterando sobre la variable $seleccionado -->
        <?php foreach ($periodo as $data): ?>
            <div class="card" style=" border-radius: 1rem; box-shadow: rgb(202, 206, 210) 0px 20px 30px -10px;">
                <div class="avatar mx-auto" style="border-radius: 5em; max-width: 80px; margin-top: 20px;">

                    <?php
                    if ($data->nombre_banco == 'BBVA') {
                        echo "<img src='https://play-lh.googleusercontent.com/gYR4jAAc1ijOk5naipxRcKAbQ94SSVgGAnSer_-7iDYLxbwnrMMLpbuBGDvsi5DkNw' class='rounded-circle img-fluid'>";
                    } else if ($data->nombre_banco == 'Santander') {
                        echo "<img src='https://i.pinimg.com/originals/bc/da/8a/bcda8a3eaa78befafba68b851b2cdfc0.png' class='rounded-circle img-fluid'>";
                    } else if ($data->nombre_banco == 'Banco Azteca') {
                        echo "<img src='https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.bancoazteca.com.mx%2Fayuda%2Fsucursales.html&psig=AOvVaw34cKokMtjSZErBWk_pAt8_&ust=1703191914952000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCOjmlrzynoMDFQAAAAAdAAAAABAD' class='rounded-circle img-fluid'>";
                    } else {
                        echo "<img src='" . base_url('/fotos_colab/turing-ia.png') . "' class='rounded-circle img-fluid'>";
                    }
                    ?>
                </div>
                <br>
                <div class=" card-body" style="background-color: #F1F1F1 ;">
                    <h5 class="card-title" style="text-align: center;">
                        <i class="fas fa-university"></i>
                        <?= $data->nombre_banco ?>
                    </h5>
                    <i class="fas fa-calendar"  style=" color: #3498db;"></i>
                    <strong class="strong-text">Periodo:</strong>
                    <?= $data->periodo; ?>
                    <div class="line" ></div>
                    <i class="fas fa-calendar" style=" color: #3498db;"></i>
                    <strong>Mes:</strong>
                    <?= $data->mes; ?>
                    <div class="line"> </div>
                    <strong><span class="status-circle"></span> Colaboradores activos:</strong>
                    <?= $data->cantidad_registros; ?>
                    <a href="<?php echo base_url("/home/data/$año/$mes/$data->nombre_banco/$estado/$inicio/$fin");?>" class="card-box-footer" style="text-align: center; float: right; color: #3498db;"> <i class="fa fa-arrow-circle-right"></i></a>
                    <div class="line" ></div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <br>
    <div class="alert alert-danger" id="mensaje-sin-periodo1" style="display: none;text-align: center;"> <i
            class="fa fa-exclamation-circle"></i> Sin colaborador en nómina disponible </div>
    <a href="<?php echo base_url("home/index/capital"); ?>" class="ver-periodo-btn1">Retroceder</a>
</div>



<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>


<script>
    function nomina(event, año, mes) {
        event.preventDefault(); // Evita que el enlace realice su accion predeterminada
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción generará el archivo correspondiente de pago de nomina. ¿Deseas continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, continuar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                const url = `<?php echo base_url('/home/archive/'); ?>${año}/${mes}`;
                window.location.href = url;
            }
        });
    }
</script>
