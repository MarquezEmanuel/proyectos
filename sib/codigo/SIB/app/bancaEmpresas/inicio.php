<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado

$_SESSION['buscar'] = null;


require_once './header.php';
?>
<div class="card-header">
<div class="container" id="contenido">
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
                        <a href="buscarCUIL.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Detalle por CUIL-CUIT o Nombre</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="buscarExcel.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Exportar Excel</button></a>
                    </div>
                </div>
				<br>
				<div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="moraComercial.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Mora Comercial</button></a>
                    </div>
                </div>
    </div>
</div>
</div>
</body>

</html>