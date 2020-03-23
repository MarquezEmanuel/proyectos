<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
?>
<body id="body">
    <div class="container" style="margin: 60px;">
        <div class="card-header">
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-12 text-center">
                    <h2 class="text-center">Generaci&oacute;n de XML Altas </h2>
                    <br>
                    <h4 class="text-left"><u>SELECCIONE LA OPCI&Oacute;N DESEADA</u></h4>
					<br>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="procesarGenerarXMLAltas.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Generar XML Altas</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="inicioReportes.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button></a>
                </div>
            </div>
            <br>
        </div>
    </div>
</body>

</html>
