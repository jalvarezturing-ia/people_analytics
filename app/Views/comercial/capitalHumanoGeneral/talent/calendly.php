<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
    .cv-link {
        color: #4c49ea;
        text-decoration: underline;
        display: inline-block;
    }

    .cv-link:hover {
        color: #2e2bb3;
    }

    .cv-link i {
        margin-left: 5px;
    }

    /* Estilos para FontAwesome, asegúrate de incluir FontAwesome en tu proyecto */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>

<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/applicants"); ?>">Talent Management </a>| Automatización
        correos áreas
        <i class="fas fa-tasks"></i>
        <button type='button' class="btn ver-periodo-btn btn-xs btn-radius" style=' float: right;'
            title="Crear periodos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones
            <i class='fas fa-caret-down'></i>
        </button>
        <div class="dropdown-menu acciones" style="border-radius: 1rem;">
            <a href='#!' class='dropdown-item' data-toggle="tooltip" class="nav-link" data-placement="bottom"
                title="Registra un nuevo candidato" style="border-radius: 1rem;">
                <i class='fas fa-users'></i> Agregar candidato
            </a>
            <a href='<?php echo base_url("/home/forms") ?>' class='dropdown-item' data-toggle="tooltip" class="nav-link"
                data-placement="bottom" title="Formularios candidatos" style="border-radius: 1rem;">
                <i class='fas fa-tasks'></i> Formularios vacantes
            </a>
        </div>


    </h4>
    <small id="passwordHelpBlock" class="form-text text-center">
            En este espacio, el área de capital humano, determinara cual es el calendly? que le pertenecen a las áreas para los candidatos que son viables o no, y agendar una entrevista
    </small>
    <hr>


    <div class="card-body">

        <table>
            <tr style="text-align: center;">
                <th>Área</th>
                <th>Vacante</th>
                <th>Estado</th>
                <th>Calendly</th>
            </tr>

            <?php foreach ($calendlys as $calendly): ?>

                <tr style="font-size: 14px; text-align: center;">

                    <td>
                        <!-- <img src="https://portalanterior.ine.mx/archivos2/portal/Elecciones/2016/PELocales/tipo/unica/CdMex/CandidatasyCandidatos/img/CandidatoAvtr.png"
                            alt="img" class='rounded-circle img-fluid'
                            style='width: 45px; height: 45px; object-fit: cover;'> -->
                        <span
                            style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;">
                            <?= $calendly->area ?></span>
                    </td>
                    <td>
                        <span
                            style="padding: 7px; border-radius: 100px; background-color: rgb(229, 242, 254); border: 1px solid #ccc; border:none;"><?= $calendly->vacante ?></span>
                    </td>

                    <td><span
                            style="padding: 7px; border-radius: 100px; background-color: rgb(211, 243, 232); border: 1px solid #ccc; border:none;">Activos</span>
                    </td>

                    <td>
                        <input type="text" class="form-control" value="<?= $calendly->calendly ?>" name="calendly" oninput="saveCalendly(this,'<?= $calendly->id_cal ?>')" id="calendly" placeholder="Registra el Calendly">
                    </td>

                </tr>

            <?php endforeach; ?>
        </table>

    </div>

</div>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>