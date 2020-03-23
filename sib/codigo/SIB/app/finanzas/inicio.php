<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();


require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center">
                        <img class="mb-4 img-login" src="../../lib/img/086-negro80_logo.fw.png" alt="">
                        <h1 class="h3 mb-3 font-weight-normal text-blue"> Le damos la bienvenida al Sistema Integral Bancario</h1>
                    </div>
                </div>
                <br>
				<div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="movimientos.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Movimientos de Cuentas en Dolares</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="resumen.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Resumen de Transacciones</button></a>
                    </div>
                </div>
    </div>
</div>
</body>
</html>