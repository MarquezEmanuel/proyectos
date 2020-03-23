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
                    <h4 class="text-center">RTE</h4>
                    <br>
                    <h5 class="text-center"><u>SELECCIONE LA OPCION DESEADA</u></h5>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formCrearRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear RTE</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar RTE</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formReporteMovDepRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Informe RTE</button></a>
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