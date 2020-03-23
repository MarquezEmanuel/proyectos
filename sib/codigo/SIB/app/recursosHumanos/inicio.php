<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

require_once './header.php';
?>

<body id="body">
    <div class="container" style="margin: 60px;">
        <div class="card-header">
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-12 text-center">
                    <h5 class="h3 mb-3 font-weight-normal text-blue"><u>Seleccione la opcion deseada</u></h5>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="alta.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Alta de Personal</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="baja.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Baja/Modificacion de Personal</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="movimientos.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Movimientos de Personal</button></a>
                </div>
            </div>
            <br>
			<div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="cuentas.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Cuentas de Personal</button></a>
                </div>
            </div>
            <br>
			<!--<div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="edad.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Edad</button></a>
                </div>
            </div>
			-->
            <br>
        </div>
    </div>
</body>
</html>