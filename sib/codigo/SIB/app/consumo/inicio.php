<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

//Correos invalidos

function correosInvalidos() {
    $sql = "SELECT COUNT(ID) cantidad FROM [correosElectronicosInvalidos] WHERE ID > 0";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas['cantidad'];
             $html = $html . '<tr style="background-color:#cfcffa;"><th><a href="correosInvalidos.php" class="text-dark"><font size=4>Correos Electronicos Invalidos</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Telefonos invalidad

function telefonosInvalidos() {
    $sql = "SELECT COUNT(NROCLIENTE) cantidad FROM [telefonosParticularesInvalidos] WHERE NROCLIENTE > 0";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas['cantidad'];
             $html = $html . '<tr style="background-color:#cfcffa;"><th><a href="telefonosInvalidos.php" class="text-dark"><font size=4>Telefonos Particulares Invalidos</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//correos electronicos

function correos() {
    $sql = "SELECT count(DISTINCT correo) cantidad FROM [correosElectronicos]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas['cantidad'];
             $html = $html . '<tr style="background-color:#cfcffa;"><th><a href="correos.php" class="text-dark"><font size=4>Correos Electronicos</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//telefonosInvalidos

function telefonos() {
    $sql = "SELECT count(NROCLIENTE) cantidad FROM [telefonosParticularesValidos]";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas['cantidad'];
             $html = $html . '<tr style="background-color:#cfcffa;"><th><a href="telefonos.php" class="text-dark"><font size=4>Telefonos Particulares</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <br>
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido1" class="col-lg-12 contenido1">
                        <div class="form-row align-items-center mx-auto">
                            <table class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 70%"/>
                                    <col style="width: 30%"/>
                                </colgroup>
                                <thead style='background-color:#363663;color:white;'>
                                    <tr>
                                        <th>Nombre de Reporte</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo correosInvalidos();
                                    echo telefonosInvalidos();
									echo correos();
									echo telefonos();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>