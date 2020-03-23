<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Cuentas Corrientes con Sobregiro</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idMoraPrestamos = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(saldo as money),1) AS saldo2, convert(varchar,cast(acuerdo as money),1) AS acuerdo2,"
        . "convert(varchar,cast(exceso as money),1) AS exceso2, convert(varchar,cast(rechazo as money),1) AS rechazo2, "
        . "convert(varchar,cast(promedioMes as money),1) AS promedioMes2, convert(varchar,cast(promedio180 as money),1) AS promedio1802 FROM [4cuentasCorrientes] WHERE id = ". $idMoraPrestamos;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idMoraPrestamos || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombreCliente = utf8_encode($cuen['nombreCliente']);
				$primerVencimiento = isset($cuen['primerVencimiento']) ? $cuen['primerVencimiento']->format('d/m/Y') : "";
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuenta']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Digito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['digito']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $nombreCliente; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['producto'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['moneda']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Saldo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldo2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Acuerdo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['acuerdo2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Exceso:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['exceso2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Rechazo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['rechazo2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Dias de Sobregiro:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nroDiasSobregiro'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Dias Saldo Deudor:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['nroDiasSaldoDeudor']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Primer Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $primerVencimiento; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Promedio de Mes:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['promedioMes2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Promedio Semestral:</label>
                        <div class="col" >
			<input type="text" class="form-control mb-2" value="<?= $cuen['promedio1802'];} ?>" readonly>
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


