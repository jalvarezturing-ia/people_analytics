<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish");
$fechaHoy = strftime("%d de %B de %Y") ?>
<?= $this->include('comercial/capitalHumanoGeneral/header') ?>

<style>
    .container {
        display: flex;
        justify-content: space-between;
    }


    .card-body {
        border-radius: 1rem;
        padding: 15px;
    }

    .submenu {
        margin-bottom: 10px;
    }

    .submenu-item {
        border: none;
        background-color: transparent;
        padding: 5px 10px;
        cursor: pointer;
        outline: none;
        /* Eliminar el efecto de outline */
        color: #4070f4;
        font-weight: bold;
    }

    .submenu-item:hover {
        background-color: rgba(0, 0, 255, 0.1);
    }

    .submenu-item.selected {
        border-bottom: 2px solid blue;
        /* Color del borde del botón seleccionado */
    }

    .candidate-info {
        background-color: #F8FAFC;
        border-radius: 1rem;

        padding: 10px;
    }

    .hidden {
        display: none;
    }

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
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/applicants/proceso/$id_form"); ?>">Talent Management |
            Periodo de prueba </a> | <?= $vacante ?> | <?= $nombre ?>
        <i class="fas fa-users"></i>
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
    <hr>
    <small id="passwordHelpBlock" class="form-text text-center">
        En este espacio, el área de capital humano, determinara cual es tiempo de periodo de prueba de los candidatos
    </small>
    <div class="card-body" id="proceso">

        <form action="<?php echo base_url('/home/applicants/saveprueba') ?>" method="POST"
            enctype="multipart/form-data">

            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Fecha inicio:</label>
                <div class="col-sm-4">
                    <input type="date" name="f_inicio" id="f_inicio" class="form-control" value="" required>
                </div>
                <label for="correo" class="col-sm-2 col-form-label">Fecha fin:</label>
                <div class="col-sm-4">
                    <input type="hidden" name="id_user" class="form-control" value="<?= $id_user ?>">
                    <input type="date" name="f_fin" id="f_fin" class="form-control" value="">
                </div>
            </div>
            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Tiempo total de días:</label>
                <div class="col-sm-4">
                    <input type="text" name="t_dias" id="t_dias" class="form-control" value="" required>
                </div>
                <label for="correo" class="col-sm-2 col-form-label">Tipo de prueba:</label>
                <div class="col-sm-4">

                    <select name="tipoPrueba" id="tipoPrueba" class="form-control">
                        <option value="none">Seleccione...</option>
                        <option value="Prueba Técnica">Prueba Técnica</option>
                        <option value="Prueba Oral">Prueba Oral</option>
                        <option value="other">Otra</option>
                    </select>

                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <ul id="addedOptionsList" class="list-group"></ul>
                </div>
            </div>

            <div class="form-group row" id="otherTypeGroup" style="display:none;">
                <label for="otherType" class="col-sm-2 col-form-label">Especifique:</label>
                <div class="col-sm-4">
                    <input type="text" id="otherType" class="form-control" placeholder="Especifique el tipo de prueba">
                </div>
                <div class="col-sm-2">
                    <button type="button" id="addOtherType" class="btn ver-periodo-btn">Añadir</button>
                </div>
            </div>


            <div class="form-group row">

                <label for="descripcion" class="col-sm-2 col-form-label">Actividades:</label>
                <div class="col-sm-10">
                    <!-- <textarea name="actividades" id="editor"></textarea> -->
                    <!-- <input type="text" name="actividades" class="form-control" > -->
                    <textarea name="actividades" id="actividades" class="form-control"
                        placeholder="Escriba algún comentario"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <a href="<?php echo base_url("/home/applicants/proceso/$id_form"); ?>"
                        class="ver-periodo-btn1">Retroceder</a>
                    <button type="submit" class="ver-periodo-btn2"> Guardar</button>
                </div>
            </div>
        </form>
    </div>


</div>


<script>
    document.getElementById('tipoPrueba').addEventListener('change', function () {
        var otherTypeGroup = document.getElementById('otherTypeGroup');
        if (this.value === 'other') {
            otherTypeGroup.style.display = 'flex';
        } else {
            otherTypeGroup.style.display = 'none';
        }
    });

    document.getElementById('addOtherType').addEventListener('click', function () {
        var otherTypeInput = document.getElementById('otherType');
        var tipoPruebaSelect = document.getElementById('tipoPrueba');
        var newOptionValue = otherTypeInput.value.trim();

        if (newOptionValue !== "") {
            // Crear una nueva opción
            var newOption = document.createElement('option');
            newOption.value = newOptionValue;
            newOption.text = newOptionValue;

            // Añadir la nueva opción al select
            tipoPruebaSelect.add(newOption);

            // Seleccionar la nueva opción
            tipoPruebaSelect.value = newOptionValue;

            // Ocultar el campo de entrada y limpiar su valor
            document.getElementById('otherTypeGroup').style.display = 'none';
            otherTypeInput.value = "";
        }
    });
</script>

<script>
    // Obtener los elementos de entrada de fecha
    //  const fechaInicioInput = document.getElementById('f_inicio');
    //     const fechaFinInput = document.getElementById('f_fin');
    //     // Obtener el elemento de entrada de texto para el tiempo total de días
    //     const tiempoTotalDiasInput = document.getElementById('t_dias');

    //     // Función para calcular la diferencia de días entre dos fechas
    //     function calcularDiferenciaFechas() {
    //         // Obtener las fechas seleccionadas
    //         const fechaInicio = new Date(fechaInicioInput.value);
    //         const fechaFin = new Date(fechaFinInput.value);

    //         // Calcular la diferencia en milisegundos
    //         const diferencia = fechaFin.getTime() - fechaInicio.getTime();
    //         // Convertir la diferencia a días
    //         const dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

    //         // Actualizar el valor del campo de entrada de texto para el tiempo total de días
    //         tiempoTotalDiasInput.value = dias;
    //     }

    //     // Agregar eventos change a los campos de entrada de fecha
    //     fechaInicioInput.addEventListener('change', calcularDiferenciaFechas);
    //     fechaFinInput.addEventListener('change', calcularDiferenciaFechas);

    // Función para verificar si una fecha es fin de semana (sábado o domingo)
    function esFinDeSemana(fecha) {
        const dia = fecha.getDay();
        return (dia === 0 || dia === 6);
    }

    // Función para calcular la diferencia de días entre dos fechas, excluyendo los fines de semana
    function calcularDiferenciaFechas() {
        const fechaInicio = new Date(document.getElementById('f_inicio').value);
        const fechaFin = new Date(document.getElementById('f_fin').value);

        if (!fechaInicio || !fechaFin) {
            document.getElementById('t_dias').value = '';
            return;
        }

        // Ajuste de inicio y fin para incluir ambos días en el conteo
        let dias = 0;
        let currentDate = new Date(fechaInicio);

        while (currentDate <= fechaFin) {
            if (!esFinDeSemana(currentDate)) {
                dias++;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }

        document.getElementById('t_dias').value = dias;
    }

    // Agregar eventos change a los campos de entrada de fecha
    document.getElementById('f_inicio').addEventListener('change', calcularDiferenciaFechas);
    document.getElementById('f_fin').addEventListener('change', calcularDiferenciaFechas);
</script>

<!-- <script>
    ClassicEditor.create(document.querySelector('#editor'));
</script> -->


<?php include ("editor.php"); ?>

<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>