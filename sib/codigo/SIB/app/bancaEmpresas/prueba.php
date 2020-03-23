<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado

$_SESSION['buscar'] = null;

$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-1+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-1+1,1,date("Y"))-1))));
$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-1+1,1,date("Y"))-1));

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
                        <a href="buscarCUIL.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Detalle por CUIL-CUIT</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="buscarExcel.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Exportar Excel</button></a>
                    </div>
                </div>
    </div>
</div>
</div>
</body>

</html>