<?php
/* INICIALIZA LA SESION */
session_start();

require_once './header.php';
?>
<body id="body">
    <div class="container" style="margin: 60px;">
        <div class="card-header">
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-12 text-center">
                    <h4 class="text-center">Control Regimen TC</h4>
                    <br>
                    <h5 class="text-center"><u>SELECCIONE LA OPCION DESEADA</u></h5>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="smvm.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Actualizar SMVM</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="controlConsumos.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Control Consumos</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formReporteMovDepRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit" disabled>Control Anticipos</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="inicio.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button></a>
                </div>
            </div>
            <br>
        </div>
    </div>
</body>

</html>