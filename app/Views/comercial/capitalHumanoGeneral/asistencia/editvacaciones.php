<?= $this->include('comercial/capitalHumanoGeneral/header') ?>
<div class="info-card vertical">
    <h4 class="title-wish"> <a href="<?php echo base_url("/home/assistence"); ?>">Asistencia ></a> Solicitudes de
        vacaciones > Edición de periodo <i class="fas fa-calendar"></i>
    </h4>
    <div>
        <div class="card-body" id="nuevoSection">
            <form id="formulario" action="<?php echo base_url("/home/savevacaseditadmin"); ?>" method="post"
                enctype="multipart/form-data">
              

                <div class="card-header" style="text-align: center;">
                    <strong><i class="fas fa-edit" style="color: #3498db;"></i> Llenado de información solicitud de
                        vacaciones</strong>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        En caso de dudas o sugerencias, favor de contactarse al siguiente número: <a
                            href="https://api.whatsapp.com/send?phone=+525616631953&text=Hola, tengo una duda acerca de%20"
                            target='_blank'>5616631953</a>
                        - Mayte López. <br>

                        ¡Que tengan un excelente día!
                    </small>
                </div>
                <br>

                    <div class="alert alert-success" style="text-align: center;">
                        <span style="font-size: 13px;">
                            <?= session('nombre'); ?>, recuerda que debes solicitar tu periodo en un lapso de <strong> seis
                                meses, todo dependerá de la
                                aprobación que te de RH y tu Jefe Directo </strong>
                            &#128521;
                        </span>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Días correspondientes:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="totales" name="totales" class="form-control" value="<?=$dias ?>" required readonly>
                            <input type="hidden" name="id_dato" class="form-control" value="<?=$id_dato ?>" required readonly>
                            

                        </div>
     
                                <label for="nombre" class="col-sm-2 col-form-label">Días restantes:<span
                                        style="color:red;">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" id="restantes" name="restantes" class="form-control"
                                        placeholder="Días restantes" value="<?=$restantes ?>" required >
                                </div>
                    </div>
                    <div class="form-group row">
                        <label for="area" class="col-sm-2 col-form-label">Fecha inicio:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="date" id="f_inicio" name="f_inicio" class="form-control" required value="<?= $f_inicio?>">
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Fecha fin:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="date" id="f_fin" name="f_fin" class="form-control" required value="<?= $f_fin?>"> 
                        </div>

                    </div>
                    <div class="form-group row">

                        <label for="area" class="col-sm-2 col-form-label">Días solicitados:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="d_solicitados" id="d_solicitados" class="form-control"
                                placeholder="Ejemplo: 1,2,3 o 4 " required  value="<?= $d_solicitados?>" >
                            <br>
                        </div>
                        <label for="area" class="col-sm-2 col-form-label">Guardar solicitud:<span
                                style="color:red;">*</span></label>
                        <div class="col-sm-4">
                            <input type="submit" class="ver-periodo-btn2 text-center" value="Guardar" id="btn-save">
                        </div>
                    </div>


                    
                    <div class="card-header" style="text-align: center;">
                        <strong><i class="fas fa-file-alt" style="color: #3498db;"></i> Documento de autorización (Con nombre y
                            firma del DIRECTOR COMERCIAL y CAPITAL HUMANO) <br>
                      </strong>
                    </div>
                    <br>



                    <div class="form-group mb-2 text-center">
                        <input type="file" name="documento" id="docInput" required="" accept=".doc, .docx, .pdf"
                            onchange="previewDoc()">
                    </div>
                    <br>
                    <div class="form-group mb-2 text-center">
                        <p id="docMessage"></p>
                    </div>

            </form>
        </div>

    </div>

</div>
</div>




<script>
    // Obtener los elementos de entrada de fecha
    const fSalida = document.getElementById('f_inicio');
    const fRegreso = document.getElementById('f_fin');

    const totales = document.getElementById('totales').value;
    const restantes = document.getElementById('restantes').value;

    //alert(fSalida);

    // Escuchar los cambios en las fechas
    fSalida.addEventListener('change', calcularDias);
    fRegreso.addEventListener('change', calcularDias);

    function calcularDias() {

        console.log("se llamo la función");
        // Obtener las fechas seleccionadas
        const salida = new Date(fSalida.value);
        const regreso = new Date(fRegreso.value);


        let diasLaborables = 0;
        const fechaTemp = new Date(salida);
        //console.log("Seleccionado--> " +  fechaTemp.getDay());

        while (fechaTemp <= regreso) {
            const diaSemana = fechaTemp.getDay();
            if (diaSemana !== 0 && diaSemana !== 6) { // Excluir sábados y domingos
                //sabado            //domingo
                diasLaborables++;
            }
            fechaTemp.setDate(fechaTemp.getDate() + 1);
        }
        const resta = totales - diasLaborables;
        //const resta = restantes - diasLaborables;
        //totales_12/14/etc   //d_solicitados


        if (resta == '0') {
            document.getElementById('d_solicitados').value = diasLaborables;
            document.getElementById('restantes').value = resta;
            document.getElementById('btn-save').style.display = "block";

        } else if (resta <= '0') {

            // Mostrar los días en el campo de entrada
            document.getElementById('d_solicitados').value = diasLaborables;
            document.getElementById('restantes').value = "Ya no tienes días pendientes.";
            document.getElementById('btn-save').style.display = "block";
        }
        else {

            document.getElementById('d_solicitados').value = diasLaborables;
            document.getElementById('restantes').value = resta;
            document.getElementById('btn-save').style.display = "block";
        }

        if (diasLaborables > totales) {
            document.getElementById('d_solicitados').value = "Ya no puedes solicitar más dias.";
            document.getElementById('btn-save').style.display = "none";
            //console.log("Ya no puedes solicitar mas dias");

        }
    }

    /*if (restantes == 0) {

        document.getElementById('d_solicitados').value = "Ya obtuviste todas tus vacaciones.";
        document.getElementById('btn-save').setAttribute("readonly", "readonly");
        document.getElementById('notif').style.display = "none";
        document.getElementById('restantes').value = "Ya obtuviste todas tus vacaciones.";

        fSalida.setAttribute("readonly", "readonly");
        fRegreso.setAttribute("readonly", "readonly");

    }*/
</script>



<?= $this->include('comercial/capitalHumanoGeneral/footer') ?>