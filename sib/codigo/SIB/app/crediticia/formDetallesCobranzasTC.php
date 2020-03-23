<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cobranzas Tarjeta de Credito</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCobranzasTC = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(saldoPesos as money),1) AS saldoPesos2, convert(varchar,cast(minimoPesos as money),1) AS minimoPesos2,"
        . "convert(varchar,cast(saldoDolares as money),1) AS saldoDolares2, convert(varchar,cast(cobranzasSo as money),1) AS cobranzasSo2, "
        . "convert(varchar,cast(cobranzasTanqueSFB as money),1) AS cobranzasTanqueSFB2, convert(varchar,cast(cobranzasReafa as money),1) AS cobranzasReafa2, "
        . "convert(varchar,cast(saldoCuentaSFB as money),1) AS saldoCuentaSFB2, convert(varchar,cast(bloqueo as money),1) AS bloqueo2, cast ([fechaVencimiento] AS smalldatetime) fechaVencimiento2 FROM [4cobranzasTC] WHERE id = ". $idCobranzasTC;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$idCobranzasTC || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombre = utf8_encode($cuen['nombre']);
                $fechaVencimiento = isset($cuen['fechaVencimiento2']) ? $cuen['fechaVencimiento2']->format('d/m/Y') : "";
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['marca']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Cuenta de Tarjeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuentaTarjeta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombre; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Cuenta de Banco:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuentaBanco']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['sucursalCuentaBanco']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Tipo de Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipoCuenta'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Tipo de Debito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipoDebito']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Saldo en Pesos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoPesos2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Minimo en Pesos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['minimoPesos2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Saldo en Dolares:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoDolares2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Fecha de Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $fechaVencimiento; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cobranzas So:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cobranzasSo2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Cobranzas Tanques SFB:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cobranzasTanqueSFB2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Fecha de Pago Tanques SFB:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['fechaPagoTanqueSFB']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Cobranzas Reafa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cobranzasReafa2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Fecha Pago Reafa:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['fechaPagoReafa']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['cliente']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo Cuentas SFB:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoCuentaSFB2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Bloqueo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['bloqueo'];}?>" readonly>
                        </div>
                </div>                    
                <br>
                &nbsp;
                <a href="<?= $_SERVER["HTTP_REFERER"] ?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>


