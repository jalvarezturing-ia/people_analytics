<?php date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "spanish"); ?>
<?= $this->include('colaboradores/header') ?>



<style>
    img {
        display: block;
        margin: auto;
    }

    #ptext {
        color: black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;

    }

    #centerTh {
        text-align: center;
    }

    th {
        background-color: #FF0000 !important;
    }

    @media (max-width: 600px) {

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        th {

            font-size: 10.5px;
            color: #FFFFFF !important;

        }

        tr {
            margin-bottom: 15px;

        }

        td {
            border: none;
            border-bottom: 1px solid #ddd;
            position: relative;
            padding-left: 50%;
        }

        td:before {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }
    }
</style>

<div id="miSeccion">
    <img src="<?php echo base_url("gifs/fondo.png"); ?>" alt="logo_turing" width="110px" height="100px">
    <h4 style="text-align:center;"><strong>TURING INTELIGENCIA ARTIFICIAL</strong></h4>

    <?php


    // Obtener la fecha actual en español
    $fechaHoy = strftime("%d de %B de %Y");
    $fecha_fin = strftime("%d/%B/%Y", strtotime($fin));
    // Imprimir la fecha en tu párrafo
    
    ?>
    <p style="text-align:center; color: #4785FF; " id="ptextCert"> <strong style="font-weight: bold;"> CERTIFICADO DE
            FINALIZACIÓN</strong></p>
    <div style="margin-left: 150px; margin-right: 150px; ">
        <p style="text-align:justify;" id="ptext">
            <br>
            Por medio de la presente se certifica que, a la fecha de firma del presente documento, se otorga a: <span
                style="font-weight:bold; text-decoration: underline;">
                <?= strtoupper($name); ?>
            </span>, en reconocimiento a su dedicación y excelencia demostrada, por haber completado con éxito el
            siguiente elemento de formación:
            <br><br>

        <h4 style="font-weight:bold; text-decoration: underline; text-align:center; color: #4785FF;" id="ptextCert">
            <?= strtoupper($cursos); ?>
        </h4>
       

        <p style="text-align:center; color: black;">Duración total:
            <?= $tiempo ?>
            <br>
            Finalizado el:
            <?= $fecha_fin ?>
        </p>

        </p>
        <br>
       

        <div class="firma-container" style=" text-align: center; ">
            <div class="firma-center" style=" float: center;  text-align: center;">
                <p><strong style="font-weight: bold; color: black;">ING. NOÉ ALEJANDRO CRUZ PONCE</p></strong>

                <!-- <?= strtoupper($name); ?> -->
                <img src="<?php echo base_url("gifs/firma-ing.png"); ?>" alt="logo_turing" width="100px" height="55px" style="text-align: right;">
                <p>--------------------------------------------</p>
                <p><strong style="font-weight: bold; color: black;">REPRESENTANTE LEGAL</strong></p>
            </div>
        </div>

        <br>
        <p style="text-align:center; font-weight:bold;" id="ptext">Ciudad de México a
            <?= $fechaHoy ?>
        </p>
        <br>
    </div>
</div>

<hr>

<input type="button" onclick="imprimirSeccion()" class="ver-periodo-btn2 text-center " value="Imprimir">


<?= $this->include('colaboradores/footer') ?>



<script>
    function imprimirSeccion() {


        var contenidoSeccion = document.getElementById('miSeccion').outerHTML;
        var nuevaVentana = window.open('', '_blank');
        var contenidoNuevoDocumento = '<html><head><title>Imprimir</title>';

        // Copiar estilos asociados al elemento y agregar estilos adicionales
        var estilos = document.getElementById('miSeccion').style.cssText;
        contenidoNuevoDocumento += '<style>' + estilos +' @media print { body { margin: 0; padding: 0; font-family: "Century Gothic"; font-size: 23px; } #ptextCert { font-size: 33px; } img {display: block;margin: auto;}</style>';

        contenidoNuevoDocumento += '</head><body>' + contenidoSeccion + '</body></html>';

        nuevaVentana.document.write(contenidoNuevoDocumento);
        nuevaVentana.document.close();
        nuevaVentana.print();
    }
</script>