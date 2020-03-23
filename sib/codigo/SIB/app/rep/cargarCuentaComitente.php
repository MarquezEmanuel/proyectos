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
                    <h4 class="text-center">CUENTA COMITENTE </h4>
                    <br>
                    <h5 class="text-center"><u>SELECCIONE LA OPCION DESEADA</u></h5>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formAltaCliente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear Cuenta Comitente Alta Cliente</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBajaCliente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear Cuenta Comitente Baja Cliente</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarCuentaComitente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Cuenta Comitente</button></a>
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
        </div>
    </div>
</body>

</html>
